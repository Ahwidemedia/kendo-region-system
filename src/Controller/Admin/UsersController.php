<?php



namespace App\Controller\Admin;
use Cake\ORM\Table;
use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class UsersController extends AppController {


public function initialize()
    {
    parent::initialize();
    $this->set('title', 'Interface administrateur');
    $this->set('description', 'Gerer les utilisateurs et articles...');

    $this->viewBuilder()->layout('menu');
        
     }
     
     
      public function beforeFilter(Event $event)
    {
       $bodyclass = 'image-default';
    $this->set('bodyclass', $bodyclass);  
 }
     
     
     	function menu() {
	

	$users = $this->Users->find('all', 
	[ 'fields' => ['username', 'id','role']]);
        $this->set(compact('users'));
        
   }

	function utilisateurs() {
	

	$users = $this->Users->find('all', 
	[ 'fields' => ['username', 'id','role','created','lastname','firstname']])
	->where(['role !=' => 'supprime']);
        $this->set(compact('users'));
        
        
        }
        
   
   
   
        	function index() {
 	 $this->viewBuilder()->layout('menu');
$this->set('title', 'Mon interface utilisateur');
$this->set('description', 'Votre interface utilisateur pour éditer vos articles, etc.');
	  
	  // Sauvegarde bdd
	  
	  $conn = ConnectionManager::get('default');
       
      // On prend le nom de la base de données actuelle
       $database = $conn->config()['database'];
       

    
    $filename = date("d-m-Y"). "-".$database.".sql";
    	$dir = new Folder('spe'.DS);
	$files = $dir->find($filename);
	
	
	if(empty($files)) {
	 return $this->redirect(['controller'=>'Settings','action' => 'db']);
	
	}
	  
	  
	 
	
	// Sélectionner les articles
	
   $articles= TableRegistry::get('Users');
$query = $articles->find('all', 
	[ 'fields' => ['username', 'id','role']])
	 ->contain(['Produits' => function($q) {return $q
     ->select(['user_id','name','statut','id','illustration'])->limit(5)->order(['id'=>'DESC'])->where(['Produits.statut >'=>'0']);}])

 ->contain(['Encyclopedies' => function($q) {return $q
   ->select(['user_id','name','statut','id','illustration'])->limit(5)->order(['id'=>'DESC'])->where(['Encyclopedies.statut >'=>'0']);}])

 ->contain(['Explorations' => function($q) {return $q
       ->select(['user_id','name','statut','id','illustration'])->limit(5)->order(['id'=>'DESC'])->where(['Explorations.statut >'=>'0']);}])

 ->contain(['Recettes' => function($q) {return $q
       ->select(['user_id','name','statut','id','illustration'])->limit(5)->order(['id'=>'DESC'])->where(['Recettes.statut >'=>'0']);}])

 ->contain(['Mondes' => function($q) {return $q
       ->select(['user_id','name','statut','drapeau','id'])->limit(5)->order(['id'=>'DESC'])->where(['Mondes.statut >'=>'0']);}])
 ->contain(['News' => function($q) {return $q
       ->select(['user_id','name','statut','illustration','id'])->limit(5)->order(['id'=>'DESC']);}]);

$this->set(compact('query'));

  
  // Compter les articles
        
 $num_articles = $this->Users->find('all')
 ->contain(['Produits' => function($q) {return $q
     ->select(['user_id','statut','total' => $q->func()->count('Produits.user_id')]) ->where(['Produits.statut >='=>'3']);}])

 ->contain(['Encyclopedies' => function($q) {return $q
      ->select(['user_id','statut','total' => $q->func()->count('Encyclopedies.user_id')]) ->where(['Encyclopedies.statut >='=>'3']);}])

 ->contain(['Explorations' => function($q) {return $q
      ->select(['user_id','statut','total' => $q->func()->count('Explorations.user_id')]) ->where(['Explorations.statut >='=>'3']);}])

 ->contain(['Recettes' => function($q) {return $q
       ->select(['user_id','statut','total' => $q->func()->count('Recettes.user_id')]) ->where(['Recettes.statut >='=>'3']);}])

 ->contain(['Mondes' => function($q) {return $q
       ->select(['user_id','id','total' => $q->func()->count('Mondes.user_id')]) ->where(['Mondes.statut >='=>'3']);}]);
    	
    $this->set(compact('num_articles'));  
        
   
   $this->loadModel('AidesCulinaires');
   $aides = $this->AidesCulinaires->find('all')
   ->select(['id','name','illustration','statut'])
   ->limit(5);
   
   $this->set('aides',$aides);
   
    $this->loadModel('Remplacements');
   $remplacements = $this->Remplacements->Produits->find('all')
   ->select(['id','name','statut','illustration'])
   ->matching('Remplacements')
   ->group(['Produits.id'])
   ->limit(5);
   
   $this->set('remplacements',$remplacements);
   
       $this->loadModel('Glossaires');
   $glossaires = $this->Glossaires->find('all')
   ->select(['id','name','statut'])
   ->limit(5);
   
   $this->set('glossaires',$glossaires);
        

	}
	
	public function add() {
	
	
		$data = $this->request->data();
		
		$user = $this->Users->newEntity();
		$user->active = '1';
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Un nouvel utilisateur a été ajouté.'));
                return $this->redirect(['action' => 'index']);
            }
            else {
            $this->Flash->error(__('Impossible d\'ajouter cet utilisateur.'));
           
            }
        
        }
        $this->set('user', $user);
        
        $data['roles'] = [
		'Admin'=> 'Admin',
		'Membre' => 'Membre',
		'Premium' => 'Premium'];
		
		$this->set($data);
		
	
	
	}
	
	public function edit($id=null){

	
		$data['roles'] = [
		'Admin'=> 'Admin',
		'Membre' => 'Membre',
		'Premium' => 'Premium'];
		
		$this->set($data);
		
	
	$user = $this->Users->find('all')
	->where(['id' => $id])
	->first();
	$this->set('user', $user);
	
	  
	
	if($this->request->is(['post','put'])){

	
	$data = $this->request->data();
	
	$this->Users->patchEntity($user, $data);

	if(!empty($data['avatarf']['tmp_name'])){

		if (!$user->errors())  {
			$f = explode('.',$data['avatarf']['name']);
			$ext = '.'.end($f);
			$directory ='img/avatars' . DS . ceil($user['id'] / 1000);
					
                    
          if(!file_exists($directory))
        	mkdir($directory, 0777);
            move_uploaded_file($data['avatarf']['tmp_name'], $directory . DS . $user['id'] .$ext);
                    
             $user->avatar = 'avatars/'.ceil($user['id'] / 1000) . '/'. $user['id'] .$ext;
                    }
                  
	}

	
	if($this->Users->save($user)) {
	
		$this->Flash->success('Les modifications ont bien été prises en compte');
		return $this->redirect(['action' => 'index']);
		}
		
			else {
	
	$this->Flash->error('Les modifications n\'ont pas pu être enregistrées.');
	
	}

			}
			
		}
		
		 function change($id) {
	 
	 	$user = $this->Users->find('all')
	->where(['id' => $id])
	->first();
	$this->set('user', $user);
	
	if($this->request->is(['post','put'])){
	
	$data = $this->request->data();
	
	$this->Users->patchEntity($user, $data);
	
	
	 if ($user->errors()) {
             $this->Flash->error(__('Une erreur est survenu.'));


         } else {
         
         if($this->Users->save($user)) {
         
         $this->Flash->success('Les modifications ont bien été prises en compte');
        	 }
        }
	}
 }
		
	
	
	
	
		public function delete($id,$token){

	if(!isset($token)) {
	     throw new \NotFoundException(__('Action impossible'));
  $this->Flash->error('L\'article n\'a pu être supprimé.');


	}else {
	
	

	$this->request->allowMethod(['get', 'delete']);

  $article = $this->Users->get($id);
  
  if($token != md5($article->username)){

   throw new \NotFoundException(__('Action impossible'));
  $this->Flash->error('L\'article n\'a pu être supprimé.');
} else {
  
  
  		$articles = TableRegistry::get('Users');
			$name = $articles ->find()
  		->select(['username'])
   	 	->where(['id' => $id])
   	 	->first();
  		
			$query = $articles->query();
					
		$result =	$query->update()
   			 ->set(['role' => "supprime", 'username'=>'Ancien Membre -'.$article->username])
   		 	->where(['id' => $id])
    		->execute();      

    if ($result) {
	$this->Flash->success('Les modifications ont bien été prises en compte');
		return $this->redirect(['action' => 'index']);
	}
				else {
	
	$this->Flash->error('L\'article n\'a pu être supprimé.');
		return $this->redirect(['action' => 'index']);
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
	
	$user = $this->Users->find('all')
	->where(['id' => $id])->first();
	$this->set('user', $user);
	  
	  
	        
    
    
$articles = $this->Users->find('all')
 ->contain(['Produits' => function($q) {return $q
     ->select(['name','id','user_id','illustration','statut']) ->limit(5)->order(['statut'=>'DESC'])->where(['Produits.statut >='=>'0']);}])

 ->contain(['Encyclopedies' => function($q) {return $q
     ->select(['name','encyclopediecategory_id','id','user_id','illustration','statut']) ->limit(5)->order(['statut'=>'DESC'])->where(['Encyclopedies.statut >='=>'0']);}])

 ->contain(['Explorations' => function($q) {return $q
     ->select(['name','id','explorationcategory_id','user_id','illustration','statut']) ->limit(5)->order(['statut'=>'DESC'])->where(['Explorations.statut >='=>'0']);}])

 ->contain(['Recettes' => function($q) {return $q
     ->select(['name','id','user_id','illustration','statut']) ->limit(5)->order(['statut'=>'DESC'])->where(['Recettes.statut >='=>'0']);}])

 ->contain(['SujetMondes' => function($q) {return $q
     ->select(['id','user_id','monde_id','SujetMondes.statut'])->where(['archivemembre'=>'0']) ->limit(5)->order(['SujetMondes.statut'=>'DESC'])
     ->contain(['Mondes'=>['fields'=>['Mondes.id','Mondes.statut','name','drapeau']]]);}])
->contain(['Favories' => function($q) {return $q
     ->select(['id','user_id','recette_id'])
     ->contain(['Recettes'=>['fields'=>['id','cout','cuisson','preparation','difficulte','name','illustration','description','user_id']]]);}])
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
 
 
   
    $this->set('row',$row);
     $this->set('statut_badge',$statut_badge);
       $this->set('num_articles',$num_articles);
          $this->set('num_premium',$num_premium);
    
    }
        
		  
	  }
	
}




?>