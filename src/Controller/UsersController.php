<?php

namespace App\Controller;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Mailer\Email;

class UsersController extends AppController {


  // public $components = ['RBruteForce.RBruteForce'];
  
  
  	public function beforeFilter(Event $event) {
      $this->set('headimg','header_main.png');
      $bodyclass = 'image-default';
    $this->set('bodyclass', $bodyclass);
    
 $this->Auth->allow(['home', 
        					'login',
        					'logout', 
        					'forgot',
        					'password',
        					'activate', 
        					'resend',
        					'instructions',
        					'active',
        					'forgotsuccess',
                    ]);

    }
  
  
	public function initialize() {
    
         parent::initialize();
   		    
        }

	public function login() {
	
      $user = $this->Users->newEntity();
     
        $this->set('user', $user);

$this->set('title', 'Interface de connexion');
$this->set('description', 'Connectez vous à votre interface pour écrire de nouveaux articles, etc.');
	
	if($this->request->is('post')){
	
        
 			 $data = $this->request->data;
		
        
		if(isset($data['register'])){
            
            
	$entity = $this->Users->patchEntity($user, $data);
            
	
	$username = $data['username'];
	$email = $data['email'];
	$entity->active = 1;
         
		if($result = $this->Users->save($entity))
	{

	$user = $this->Users->find('all')
	->where(['email' => $email]);
	$row = $user->first();
	
	$id = $row->id;
	$token = $row->token;
	
	$CakeEmail = new Email('default');
	$CakeEmail->to($email);
	$CakeEmail->subject('Inscription sur le site des Inscriptions aux compétitions');
	$CakeEmail->viewVars([	'username' => $username]);
	$CakeEmail->emailFormat('html');
	$CakeEmail->template('inscription');
	$CakeEmail->send();
	
	$this->Flash->success('L\'email pour l\'activation du compte a été envoyé avec succès.');
	return $this->redirect(['action' => 'instructions']);
				
            
        }
            
            
        }	
        else {
            
         
			// Anti bruteforce - partie 1
			     $existence_ft = '';
			     
    if(file_exists('antibrute/'.$data['username'].'.tmp'))
    {
        $fichier_tentatives = fopen('antibrute/'.$data['username'].'.tmp', 'r+');

        $contenu_tentatives = fgets($fichier_tentatives);
        $infos_tentatives = explode(';', $contenu_tentatives);
        if($infos_tentatives[0] == date('d/m/Y'))
        {    $tentatives = $infos_tentatives[1]; }
            else
        { $existence_ft = 2;  $tentatives = 0;  } }
    
    else
    { $existence_ft = 1; $tentatives = 0;}

    if($tentatives < 15)
    {  
    
    //tentative d'authenfication
    
     		$user = $this->Auth->identify();
			  
	   //Verification du statut actif de l'utilisateur		  
			  if ($user['active'] == '0') { 		
			  $this->redirect(['action' =>'resend']);
			  $this->Flash->error(__("Vous devez activer votre compte pour pouvoir accéder à votre espace personnel."));  
			  }
			  
			  else {
		
		//Si Authentification réussie
			 if($user) {
			 
			 //Ouverture sessions et redirection
            $this->Auth->setUser($user);
          return $this->redirect($this->Auth->redirectUrl());
    
			
			}
			
			//Si mdp faux
   			else { 
   	 
   	 // Bruteforce partie 2
   	    if($existence_ft == 1)
               {
                   $creation_fichier = fopen('antibrute/'.$data['username'].'.tmp', 'a+'); 
                   fputs($creation_fichier, date('d/m/Y').';1'); 
                   fclose($creation_fichier);
               }
              
               elseif($existence_ft == 2)
               {
                   fseek($fichier_tentatives, 0); 
                   fputs($fichier_tentatives, date('d/m/Y').';1'); 
               }
               else
               {
                   fseek($fichier_tentatives, 11); 
                   fputs($fichier_tentatives, $tentatives + 1);
               }
   	 // Message d'erreur
   	 //	$this->RBruteForce->check();
   	 	$this->Flash->error(__("Nom d'utilisateur ou mot de passe incorrect, essayez à nouveau.")); }
   	 	}
   	 	}
            else
           	  {
           	  $this->Flash->error(__("Trop de tentatives d'authentification aujourd'hui (plus de 15). Reessayez demain ou 
           	  contactez un administrateur"));
        }
        
    if($existence_ft != 1)
    {
    fclose($fichier_tentatives);
			   
        }
		} 
    }
    
}
	
	public function logout() {
	$id = $this->request->session()->read('Auth.User.id');
	
	$user = $this->Users->find('all')
	->select(['id'])
	->where(['id' => $id]);
	$row = $user->first();
	
	if(!empty($row['token'])) {
	
	$row->token = ' ';
	
	$usersTable = TableRegistry::get('Users');
	$usersTable->save($row);
	
	}
	
	$this->Auth->logout();
	$this->Flash->success('Vous êtes maintenant déconnecté');
	$this->redirect('/');
	
	} 
	
	public function forgot() {
	
		$this->set('title', 'Regénérer mon mot de passe');
		$this->set('description', 'Retrouvez votre mot de passe par mail');

	$user = $this->Users->newEntity();	
	 $this->set('user', $user);
		
		if($this->request->is(['post','put'])){
	
	
	$mail = $this->request->data['email'];
	
	$user = $this->Users->find('all')
	->where(['email' => $mail]);
	$row = $user->first();
	
	if(empty($row)) {
	
	$this->Flash->error('Cet email n\'est associé à aucun compte');
	
	}else {
	
	$id = $row->id;
	$token = md5(time('-' .uniqid()));
	
	$usersTable = TableRegistry::get('Users');
	$user = $usersTable->get($id);

	$user->token = $token;
	$username = $user->username;


if ($usersTable->save($user)) {


	
	$CakeEmail = new Email('default');
	$CakeEmail->to($mail);
	$CakeEmail->subject('Demande de nouveau mot de passe');
	$CakeEmail->viewVars(['token' => $token,'id' => $id, 'username'=> $username]);
	$CakeEmail->emailFormat('html');
	$CakeEmail->template('password');
	$CakeEmail->send();
	
	$this->Flash->success('Un mail a été envoyé avec les instructions');

	return $this->redirect(['action' => 'forgotsuccess']);
				}
	
			}
		}
	}
	
	
		public function forgotsuccess() {
		
		$this->set('title', 'Les instructions ont bien été envoyées');
$this->set('description', 'Vérifier votre boîte mail pour les instructions d\'un nouveau mot de passe');

		
		}
	
	public function password($user_id, $token) {
	
	$this->set('title', 'Confirmation du mot de passe');
$this->set('description', 'Confirmez votre mot de passe');

	
	$user = $this->Users->find('all')
	->where(['id' => $user_id,
	'token' => $token]);
	$row = $user->first();
	 
	
	if(empty($user)) {
	$this->Flash->error('Ce lien est erroné');
	return $this->redirect(['action' => 'forgot']);
	}
	
	if($this->request->is(['patch','post','put'])){
	
	$poste = $this->request->data();
	
	if($poste['password'] != $poste['passwordconfirm']) {
	
	$this->Flash->error('Les mots de passe ne correspondent pas');
	}
	
	else{
	

	$usersTable = TableRegistry::get('Users');
	$user = $usersTable->get($user_id);

	$user->token = '';
	$user->password = $poste['password'];
	
	
	$usersTable->save($user);
	
	

	
	$this->Flash->success("Votre mot de passe a bien été réinitialisé");
	
	return $this->redirect(['action' => 'login']);
	
				}
			}
		}
			


	public function instructions() {
	$this->set('title', 'Les instructions ont été envoyées');

	$this->set('description', 'Les instructions pour l\'activation de votre compte ont été envoyées');
}

	public function activate($user_id, $token) {
	
	$this->set('title', 'Inscriptions Kendo - Activation du compte');
$this->set('description', 'Activez votre compte Inscriptions Kendo dès maintenant');

	
	$user = $this->Users->find('all')
	->where(['id' => $user_id,
	'token' => $token])->first();
	 
	
	if(empty($user)) {
	$this->Flash->error('Ce lien est erroné, merci de recommencer votre inscription ou contactez l\'administrateur.');
	return $this->redirect(['action' => 'register']);
		}
	
	else {
	
	
	$data = $this->request->data();
	

	$usersTable = TableRegistry::get('Users');
	$user = $usersTable->get($user_id);

	$user->token = '';
	$user->active = '1';
	

	
	if ($usersTable->save($user)) {

	$this->Flash->success("Votre compte a bien été activé");
	return $this->redirect(['action' => 'active']);
	
	
						}
					}
				}
				
	public function active() {$this->set('title', 'Activation du compte');
$this->set('description', 'Votre compte est maintenant activé');
}	
	
	public function resend() {
	
	$this->set('title', 'Renvoi du mail');
$this->set('description', 'Renvoi du mail pour votre activation de compte');

if($this->request->is(['post'])) {

$email = $this->request->data['email'];
 
 $user = $this->Users->find('all')
	->where(['mail' => $email])
	->first();
	

	if(!empty($user)){
	
	$id = $user->id;
	$token = $user->token;
	$username = $user->username;
	
	$CakeEmail = new Email('default');
	$CakeEmail->to($email);
	$CakeEmail->subject('Inscription sur Inscriptions Kendo');
	$CakeEmail->viewVars(['token' => $token,
	'id' => $id,
	'username' => $username]);
	$CakeEmail->emailFormat('html');
	$CakeEmail->template('inscription');
	
	if($CakeEmail->send()) {
	
	$this->Flash->success('Un mail a été envoyé avec les instructions pour l\'activation du compte');

				}
			}
		
	else {
				$this->Flash->error('Ce mail n\'est pas dans notre base de données');
			}
		}
	}
		
	function change() {
	
	 $this->set('title', 'Changer mon mot de passe');
$this->set('description', 'Changer votre mot de passe');

$id = $this->request->session()->read('Auth.User.id');
	


	 	$user = $this->Users->find('all')
	->where(['id' => $id])
	->first();
	$this->set('user', $user);
	
	if($user->id != $this->Auth->user('id')) {
	
		$this->Flash->error('Il y a eu un problème lors de votre identification. Contactez un administrateur.');
		return $this->redirect(['action' => 'accueil']);
		
	}
	
	
	else {
	
	if($this->request->is(['post','put'])){
	
	$data = $this->request->data();
	
	$this->Users->patchEntity($user, $data);
	
	
	 if ($user->errors()) {
	 
             $this->Flash->error(__('Une erreur est survenue.'));


         } else {
         
         if($this->Users->save($user)) {
         
         $this->Flash->success('Les modifications ont bien été prises en compte');
              return $this->redirect(['action' => 'accueil']);
        		}
        	}
        }
	}
 }	
 
	
}
?>