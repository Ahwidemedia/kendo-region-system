<?php



namespace App\Controller;

use Cake\ORM\Table;
use App\Controller;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Http\Response;
use Cake\Mailer\Email;

class InscriptionAdministratifsController extends AppController
{


    public $paginate = [
        'limit' => 20
    ];

    public function initialize()
    {
        parent::initialize();
      
        
    }
     
     
     
     
     
    public function beforeFilter(Event $event)
    {
    
        $this->Security->config('unlockedFields', ['licencies','inscription_competitions']);
 
        $this->Auth->allow([
						    'organisateur',
						   'export',
						   'view']);

       
        
        
 
    }
    
 

	// la variable category détermine si on est sur une catégorie spécifique ou sur le général
	
    
    public function organisateur($id)
    {
		
        $this->loadModel('Evenements');
        
        $event = $this->Evenements->find()
	->contain(['Competitions'=> function(\Cake\ORM\Query $q) use ($id) {
        return $q->where(['Competitions.id' => $id])->contain(['Categories']);
    }])

	->matching('Competitions', function(\Cake\ORM\Query $q) use($id) {
        return $q->where(['Competitions.id' => $id])->contain(['Categories'=> function($q) {
        return $q->order(['annee_debut'=>'DESC','grade_debut'=>'DESC']);}]);
    })->first();
        
        $this->set('id',$id);
      
        $user_id =  $this->Auth->User('id');
        
         $title = $event['name'];
         $description = $event['name'];
        
     
        
        $this->set('title', $title);
        $this->set('description', $description);
        
          
         if(!empty($event['image'])) { $headimg = 'headers/evenements/g-'.$event['image']; }else { $headimg =  'header_main.png';}
         
         
          $this->set('headimg',$headimg);
          $this->set('event',$event);
        
        
		
	
            $articles = $this->InscriptionAdministratifs->find('all')
         ->where(['competition_id'=>$event['competition']['id']])
			->contain(['Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
    }]);
		
        
		
			$this->set('articles',$articles);   
	
 
        
    }
	
	
	
	// Fonction csv à partir du plug in
	public function export($id) {
		
         $user_id =  $this->Auth->User('id');
        
		$this->response->download('export.csv');
	
		
		
            $data = $this->InscriptionAdministratifs->find('all')
         ->where(['competition_id'=>$id])
			->contain(['Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
    }]);
		
            
            $name = 'Commissaire-arbitres';
            
		
      foreach($data as $datas){
            
         
           
            $datas['nom'] = $datas['licency']['nom'];
            $datas['prenom'] = $datas['licency']['prenom'];
            $datas['arbitre'] = $datas['licency']['arbitre'];
            $datas['commissaire'] = $datas['licency']['commissaire'];
          
           if (strpos($datas['presence'], '1') !== false) {$datas['samedi'] = 'X';} else {$datas['samedi'] = '';}
           if (strpos($datas['presence'], '2') !== false) {$datas['dimanche'] = 'X';} else {$datas['dimanche'] = '';}
          
            $datas['club'] = $datas['licency']['club']['name'];
           
           
        }
        
      	// Données à envoyer au plugin
		 $_serialize = 'data';
		 
		 // Choix du délimitant du csv pour lecture correcte en excel
    	 $_delimiter = ';'; 
    	 
    	 // colonnes sélectionnées
    	 $_extract = array( 'nom', 'prenom','arbitre','commissaire','samedi','dimanche','club');
		
		// Nom des colonnes
		 $_header = [ 'Nom', 'Prenom','Niveau arbitre','Niveau Commissaire','Samedi','Dimanche','Club'];
		
		$this->set(compact('data', '_serialize', '_extract', '_delimiter','_header'));		
		$this->viewBuilder()->className('CsvView.Csv');
		
		$this->response->download($name.'.csv');
	}

	
	
	
    
    
    
      public function view($id)
    {
		
        $this->loadModel('Evenements');
        
        $event = $this->Evenements->find()
	->contain(['Competitions'=> function(\Cake\ORM\Query $q) use ($id) {
        return $q->where(['Competitions.id' => $id])->contain(['Categories']);
    }])

	->matching('Competitions', function(\Cake\ORM\Query $q) use($id) {
        return $q->where(['Competitions.id' => $id])->contain(['Categories'=> function($q) {
        return $q->order(['annee_debut'=>'DESC','grade_debut'=>'DESC']);}]);
    })->first();
        
        $this->set('id',$id);
      
        $user_id =  $this->Auth->User('id');
        
         $title = $event['name'];
         $description = $event['name'];
        
     
        
        $this->set('title', $title);
        $this->set('description', $description);
        
          
         if(!empty($event['image'])) { $headimg = 'headers/evenements/g-'.$event['image']; }else { $headimg =  'header_main.png';}
         
         
          $this->set('headimg',$headimg);
          $this->set('event',$event);
        
        
		
	
            $articles = $this->InscriptionAdministratifs->find('all')
         ->where(['competition_id'=>$event['competition']['id']])
			->contain(['Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
    }]);
		
        
		
			$this->set('articles',$articles);   
	
        $this->set('filename','Commissaires-arbitres');
        
    }
    
}
?>
