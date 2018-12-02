<?php



namespace App\Controller;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Http\Response;

class InscriptionPassagesController extends AppController
{
    public $paginate = ['limit' => 20];

    public function initialize()
    {
        parent::initialize();        
    }
     
    public function beforeFilter(Event $event)
    {
        $this->Security->config('unlockedFields', ['licencies','inscription_competitions']);
        $this->Auth->allow(['index',
                            'inscriptions',
						    'organisateur',
						    'export',
						    'gestion',
						    'view']);
    }
    
    function inscriptions($id) {
	
        // On prend les données de l'événement        
        $this->loadModel('Evenements');
        
        $event = $this->Evenements->find()->contain(['Passages'])->first();        
        $this->set('id',$id);
        $title = $event['name'];
        $description = $event['name'];
        
        // On envoie article pour que le Form soit lié à la table InscriptionPassages    
        $passage = $this->InscriptionPassages->newEntity();        
        
        // Envoie de l'image, dépend de si y en a une uploadée ou pas        
        if(!empty($event['image'])) $headimg = 'headers/evenements/g-'.$event['image']; 
        else $headimg =  'header_main.png';
         
        
        
        // Si l'utilisateur est connecté
        if($this->Auth->User('id') !== null){
        
            // On récupère son id          
            $user_id = $this->Auth->User('id');
            
            // On cherche les inscriptions à l'événement qu'il a déjà faite            
            $inscriptions = $this->InscriptionPassages->find()
                                                      ->contain(['Licencies'])
                                                      ->where(['user_id' => $user_id,'passage_id' => $event->passage->id]);
            
        } else {
        
            // Sinon, on met un user_id par défaut pour pas faire bugger la sauvegarde ????? A REPRENDRE
            $user_id = 1;
       }
       if($this->request->is(['patch','post','put'])){
        	
           $data = $this->request->data;	     
    
        // Si c'est un nouveau club, on le rentre dans la base
        if($data['new_club'] == 1) {
	
        	$club = $this->InscriptionPassages->Clubs->newEntity();
        	$club->name = strtoupper($data['club_name']);
            $club->region_id = $data['region_id'];
            $result_club = $this->InscriptionPassages->Clubs->save($club);
        	
            $data['licencie']['club_id'] = $result_club['id'];
        	$data['club_id'] = $result_club['id'];
	       }        
		}   
		
		// On envoie les variables pour les listes déroulantes et les catégories pour le jQuery
		$this->set('clubs', $this->InscriptionPassages->Clubs->find('list')->order(['name'=>'ASC']));
		$this->set('regions', $this->InscriptionPassages->Regions->find('list')->order(['name'=>'ASC']));
		$this->set('grades', $this->InscriptionPassages->Grades->find('list')->order(['id'=>'ASC']));
		$this->set(compact(['passage', 'title', 'description', 'headimg', 'event', 'article', 'inscriptions']));
		
    }	
	
}
?>
