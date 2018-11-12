<?php

namespace App\Controller;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Mailer\Email;

class UsersController extends AppController {


  public $components = ['RBruteForce.RBruteForce'];
  
  
  	public function beforeFilter(Event $event) {
    
      $bodyclass = 'image-default';
    $this->set('bodyclass', $bodyclass);
    
 $this->Auth->allow(['home', 
        					'login',
        					'logout', 
        					'display',
        					'register',
        					'forgot',
        					'password',
        					'activate', 
        					'resend',
        					'instructions',
        					'active',
        					'profile',
        					'forgotsuccess']);

    }
  
  
	public function initialize() {
    
         parent::initialize();
   		    
        }

	public function login() {
	
$this->set('title', 'Interface de connexion');
$this->set('description', 'Connectez vous à votre interface pour écrire de nouveaux articles, etc.');
	
	if($this->request->is('post')){
	
 			 $data = $this->request->data;
			
			
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
   	 	$this->RBruteForce->check();
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
	->where(['mail' => $mail]);
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
			
	public function register() {

	$this->set('title', 'Planete cuisine - Inscription');
	$this->set('description', 'S\'inscrire sur planète cuisine, l\'encyclopédie en ligne');

	 $user = $this->Users->newEntity();	
	 $this->set('user', $user);
	
	if($this->request->is(['patch','post', 'put'])) {
	
	$data = $this->request->data();


	
	$user = $this->Users->patchEntity($user, $data);
	$user->role = 'Membre';
	$token = md5(time('-' .uniqid()));
	$user->token = $token;
	
	
	$username = $this->request->data['username'];
	$mail = $this->request->data['mail'];
	
		if($this->Users->save($user))
	{

	$user = $this->Users->find('all')
	->where(['mail' => $mail]);
	$row = $user->first();
	
	$id = $row->id;
	$token = $row->token;
	
	$CakeEmail = new Email('default');
	$CakeEmail->to($mail);
	$CakeEmail->subject('Inscription sur Planète Cuisine');
	$CakeEmail->viewVars(['token' => $token,
	'id' => $id,
	'username' => $username]);
	$CakeEmail->emailFormat('html');
	$CakeEmail->template('inscription');
	$CakeEmail->send();
	
	$this->Flash->success('L\'email pour l\'activation du compte a été envoyé avec succès.');
	return $this->redirect(['action' => 'instructions']);
				
			
		}
	}
}

	public function instructions() {
	$this->set('title', 'Les instructions ont été envoyées');

	$this->set('description', 'Les instructions pour l\'activation de votre compte ont été envoyées');
}

	public function activate($user_id, $token) {
	
	$this->set('title', 'Planète cuisine - Activation du compte');
$this->set('description', 'Activez votre compte planète cuisine dès maintenant');

	
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
	$CakeEmail->subject('Inscription sur Planète Cuisine');
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
 
 	function account() {
	
$this->set('title', 'Mon compte');
$this->set('description', 'Gestion de votre compte et de votre profil');

	
	$id = $this->request->session()->read('Auth.User.id');
	
	
	$user = $this->Users->find('all')
	->select(['id','password','avatar','username','lastname','mail','firstname'])
	->where(['id' => $id])->first();
	$this->set('user', $user);
	  
	  if($user->id != $this->Auth->user('id')) {
	
		$this->Flash->error('Il y a eu un problème lors de votre identification. Contactez un administrateur.');
		return $this->redirect(['action' => 'accueil']);
		
	}
	
	
	else {
	
	if($this->request->is(['patch','post','put'])){

	
	$data = $this->request->data();
	
	$this->Users->patchEntity($user, $data);
	
	
	if($user->errors()){ 
	
	$this->Flash->error('Les modifications n\'ont pas pu être enregistrées.');}
	
	else {
	
	

	if(!empty($data['avatarf']['tmp_name'])){
	
					$f = explode('.',$data['avatarf']['name']);
					$ext = '.'.end($f);
					$directory ='img/avatars' . DS . ceil($user['id'] / 1000);
					
                    
                    if(!file_exists($directory))
                        mkdir($directory, 0777);
                    move_uploaded_file($data['avatarf']['tmp_name'], $directory . DS . $user['id'] .$ext);
                    
                    $rows = $user->avatar = 'avatars/'.ceil($user['id'] / 1000) . '/'. $user['id'] .$ext;
                    
                    
                  $avatarf = $this->Users->find('all')
				  ->where(['id' => $id])
				  ->select(['avatar'])->first();
				  
    				
                    $this->Users->save($avatarf);
                    
                    
             
            
						}
						
						   if($this->Users->save($user)) {      
                    $this->Flash->success('Les modifications ont bien été prises en compte');
                    
                    return $this->redirect(['action' => 'accueil']);
		
						}
						
					}
		
				}

			}

		}
		

		
	function accueil() {
	
	 $this->viewBuilder()->layout('menu');
$this->set('title', 'Mon interface utilisateur');
$this->set('description', 'Votre interface utilisateur pour éditer vos articles, etc.');

	
	$id = $this->request->session()->read('Auth.User.id');
	$session = $this->request->session();
	$id = $session->read('Auth.User.id');
	
	  
	  
	        
    
$articles = $this->Users->find('all')
 ->contain(['Produits' => function($q) {return $q
     ->select(['name','id','user_id','illustration','statut']) ->limit(5)->order(['statut'=>'DESC'])->where(['Produits.statut  >='=>'0']);}])

 ->contain(['Encyclopedies' => function($q) {return $q
     ->select(['name','encyclopediecategory_id','id','user_id','illustration','statut']) ->limit(5)->order(['statut'=>'DESC'])->where(['Encyclopedies.statut  >='=>'0']);}])

 ->contain(['Explorations' => function($q) {return $q
     ->select(['name','id','explorationcategory_id','user_id','illustration','statut']) ->limit(5)->order(['statut'=>'DESC'])->where(['Explorations.statut  >='=>'0']);}])

 ->contain(['Recettes' => function($q) {return $q
     ->select(['name','id','user_id','illustration','statut']) ->limit(5)->order(['statut'=>'DESC'])->where(['Recettes.statut >='=>'0']);}])

 ->contain(['SujetMondes' => function($q) {return $q
     ->select(['id','user_id','monde_id','SujetMondes.statut'])->where(['archivemembre'=>'0']) ->limit(5)->order(['SujetMondes.statut'=>'DESC'])
     ->contain(['Mondes'=>['fields'=>['Mondes.id','Mondes.statut','name','drapeau']]]);}])
->contain(['Favories' => function($q) {return $q
     ->select(['id','user_id','recette_id'])
     ->contain(['Recettes'=>['fields'=>['statut','id','cout','cuisson','preparation','difficulte','name','illustration','description','user_id']]]);}])
->contain(['Badges'])
    
    ->where(['Users.id'=>$this->Auth->User('id')])
   	->select(['username','id','avatar']);
 


foreach ($articles as $row) {
 
if(!empty($row['badges'])) {    
    
  $statut_badge =  $row['badges'][0]['badge_Produits'] + $row['badges'][0]['badge_Recettes']+ $row['badges'][0]['badge_Explorations']+ $row['badges'][0]['badge_Mondes']+ $row['badges'][0]['badge_Encyclopedies']+ $row['badges'][0]['badge_premium'];
  $num_articles =  $row['badges'][0]['num_Produits'] + $row['badges'][0]['num_Recettes']+ $row['badges'][0]['num_Explorations']+ $row['badges'][0]['num_Encyclopedies'];
  $num_premium =  $row['badges'][0]['premium_Produits'] + $row['badges'][0]['premium_Recettes']+ $row['badges'][0]['premium_Explorations']+ $row['badges'][0]['premium_Mondes']+ $row['badges'][0]['premium_Encyclopedies'];
  }
 
 else {
 
 $row['badges'][0]['badge_Produits'] = '0';
 $row['badges'][0]['badge_Recettes'] = '0';
 $row['badges'][0]['badge_Encyclopedies'] = '0';
 $row['badges'][0]['badge_Explorations'] = '0';
 $row['badges'][0]['badge_Mondes'] = '0';
 $row['badges'][0]['badge_premium'] = '0';
 
 
 $row['badges'][0]['num_Produits'] = '0';
 $row['badges'][0]['num_Recettes'] = '0';
 $row['badges'][0]['num_Encyclopedies'] = '0';
 $row['badges'][0]['num_Explorations'] = '0';
 $row['badges'][0]['num_Mondes'] = '0';
 
  $statut_badge =  '0';
  $num_articles =  '0';
  $num_premium =  '0';
  

 
 
 }
 
 
    $this->set('articles',$articles);
    $this->set('row',$row);
     $this->set('statut_badge',$statut_badge);
       $this->set('num_articles',$num_articles);
          $this->set('num_premium',$num_premium);
    
    }
        
		  
	  }
	  
	  
	  		
	function supprimer() {
	$this->set('title', 'Mon interface utilisateur');
$this->set('description', 'Votre interface pour gérer votre profil');

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
	
	$nvnom = $user->username;
	
	$data = $this->request->data();
	$data['role'] = 'Supprime';
	$data['username'] = 'Ancien membre - '.$nvnom;
	

	$this->Users->patchEntity($user, $data);
	
	
	 if ($user->errors()) {
	 
             $this->Flash->error(__('Votre compte n\'a pu être supprimé.'));
		

         } else {
         
         if($this->Users->save($user)) {
         
         $this->Flash->success('Votre compte a bien été supprimé.');
             return $this->redirect(['action' => 'logout']);
        		}
        	}
        }
	}

	
	}

	function profile($id) {
	

$this->set('title', 'Mon interface utilisateur');
$this->set('description', 'Votre interface utilisateur pour éditer vos articles, etc.');

	
	$user = $this->Users->find('all')
	->where(['id' => $id])->first();
	$this->set('user', $user);
	  
	  
	        
    
$articles = $this->Users->find('all', ['fields'=>['username','id','avatar']])
 ->contain(['Produits' => function($q) {return $q
     ->select(['name','id','user_id','illustration','statut'])->where(['Produits.statut >='=>'3']) ->limit(5)->order(['statut'=>'DESC', 'modified'=>'ASC'])
     ->contain(['Produitcategories'=>['fields'=>['name']]]);}])

 ->contain(['Encyclopedies' => function($q) {return $q
     ->select(['name','id','user_id','illustration','statut'])->where(['Encyclopedies.statut >='=>'3']) ->limit(5)->order(['statut'=>'DESC','modified'=>'ASC'])
      ->contain(['Encyclopediesouscategories'=>['fields'=>['name']]]);}])

 ->contain(['Explorations' => function($q) {return $q
     ->select(['name','id','user_id','illustration','statut'])->where(['Explorations.statut >='=>'3']) ->limit(5)->order(['statut'=>'DESC','modified'=>'ASC'])
     ->contain(['Explorationsouscategories'=>['fields'=>['name']]]);}])

->contain(['Recettes' => function($q) {return $q
     ->select(['id','cout','cuisson','preparation','difficulte','name','recettecategory_id','illustration','description','user_id',])
     ->where(['Recettes.statut >='=>'3'])
     ->order(['Recettes.id'=>'DESC'])
    ->limit('5')
    ->contain(['Recettecategories'=>['fields'=>['name','id']]]);}])
    
    ->contain(['Badges'])
    
    ->where(['Users.id'=>$id]);


    
   
foreach ($articles as $row) {
 

if(!empty($row['badges'])) {    

  $statut_badge =  $row['badges'][0]['badge_Produits'] + $row['badges'][0]['badge_Recettes']+ $row['badges'][0]['badge_Explorations']+ $row['badges'][0]['badge_Mondes']+ $row['badges'][0]['badge_Encyclopedies']+ $row['badges'][0]['badge_premium'];
  $num_articles =  $row['badges'][0]['num_Produits'] + $row['badges'][0]['num_Recettes']+ $row['badges'][0]['num_Explorations']+ $row['badges'][0]['num_Encyclopedies'];
  $num_premium =  $row['badges'][0]['premium_Produits'] + $row['badges'][0]['premium_Recettes']+ $row['badges'][0]['premium_Explorations']+ $row['badges'][0]['premium_Mondes']+ $row['badges'][0]['premium_Encyclopedies'];
 }
 
 else {
 
 $row['badges'][0]['badge_Produits'] = '0';
 $row['badges'][0]['badge_Recettes'] = '0';
 $row['badges'][0]['badge_Encyclopedies'] = '0';
 $row['badges'][0]['badge_Explorations'] = '0';
 $row['badges'][0]['badge_Mondes'] = '0';
 $row['badges'][0]['badge_premium'] = '0';
 
 
 $row['badges'][0]['num_Produits'] = '0';
 $row['badges'][0]['num_Recettes'] = '0';
 $row['badges'][0]['num_Encyclopedies'] = '0';
 $row['badges'][0]['num_Explorations'] = '0';
 $row['badges'][0]['num_Mondes'] = '0';
 
  $statut_badge =  '0';
  $num_articles =  '0';
  $num_premium =  '0';
  

 
 
 }
   
    $this->set('row',$row);
     $this->set('statut_badge',$statut_badge);
       $this->set('num_articles',$num_articles);
          $this->set('num_premium',$num_premium);
    
    }

		  
	  }
	

	
}
?>