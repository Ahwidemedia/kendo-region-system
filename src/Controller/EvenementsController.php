<?php



namespace App\Controller;

use Cake\ORM\Table;
use App\Controller;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Http\Response;

class EvenementsController extends AppController
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
    
        $this->Security->config('unlockedFields', ['inscrits']);
 
        $this->Auth->allow(['creation','show']);
        
        
        $title = 'Création d\'événements';
        $description = 'Création d\'évenements';
 
        $this->set('title', $title);
        $this->set('description', $description);

          
    
    }
    
 


    function creation($id=null) {
    
        $this->set('headimg','header_main.png');
        
    if(isset($id)) {
    
    $article = $this->Evenements->find('all')
    ->where(['Evenements.id'=>$id])
    ->contain(['Competitions'=> function($q) {return $q
                            ->contain(['Disciplines','Categories']);}])
    ->first();
  
    } else {
	
	$article = $this->Evenements->newEntity(['associated'=>'Competitions','Competitions.Categories']);
	
	}
	$this->set('article',$article);


    $this->set('categories', $this->Evenements->Competitions->Categories->find('list'));
    $this->set('disciplines', $this->Evenements->Competitions->Disciplines->find('list'));     
        
	    
  

		// Quand on a une requête
		
	if($this->request->is(['patch','post','put'])){
	

	$data = $this->request->data;	
     
        
if($data['cfcompetitions'] == 0) {

$data['competition'] = array();
}
        $data['competition']['name'] = $data['name'];
      	
    $entity = $this->Evenements->patchEntity($article, $data,['associated'=>['Competitions','Competitions.Categories']]);
    
     $result =  $this->Evenements->save($entity,['associated'=>['Competitions','Competitions.Categories']]);

    
    
         if ($result) {
	$this->Flash->success('La compétition a bien été créée');
		return $this->redirect($this->referer());
	}
				else {
	
	$this->Flash->error('Il y a eu une erreur et les inscriptions n\'ont pu être envoyées.');

		}

        
                }
            }

    
    
     function show($id) {
    
         $article = $this->Evenements->find()
             ->contain(['Competitions' => ['Disciplines'], 'Passages' => ['Disciplines']])
             ->where(['Evenements.id'=>$id])
             ->first();
         
         $this->set('article',$article);
         
         if(!empty($article['image'])) {
             $headimg = 'headers/evenements/l-'.$article['image'];
             
         }else {
             
           $headimg =  'header_main.png';
         }
         
         
          $this->set('headimg',$headimg);
         
     }

}
?>
