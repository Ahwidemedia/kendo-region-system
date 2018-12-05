<?php



namespace App\Controller;

use Cake\ORM\Table;
use App\Controller;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Http\Response;
use App\Form\ContactForm;
use Cake\Mailer\Email;


class PagesController extends AppController
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
 
        $this->Auth->allow(['index',
                            'inscriptions',
						    'organisateur',
						   'export',
						   'gestion',
						   'view']);

                            $title = 'Inscriptions Interregions 2019';
        $description = 'Inscriptions Interregions 2019';
 
        $this->set('title', $title);
        $this->set('description', $description);

    }
    
 
 
    public function index()
    {
 
        $this->set('headimg','header_main.png');
 
        $this->loadModel('Evenements');
        $articles = $this->Evenements->find('all')
            ->contain(['Passages','Competitions'=> function($q) {
        return $q->contain(['Disciplines']);
    }]);
        
        $this->set('articles',$articles);
        
        
        // Si l'utilisateur est connecté
        if($this->Auth->User('id') !== null){
            
            $user_id = $this->Auth->User('id');
            
            $this->loadModel('InscriptionCompetitions');
            
            $inscriptions = $this->InscriptionCompetitions->find('all')
                ->where(['user_id'=>$user_id]);
    
             $number_compete = $inscriptions->count();
            
            $this->set('number_compete', $number_compete);
          
        }
     
        
        
    }
    

    
    	public function contact(){

            
             $this->set('headimg','header_main.png');
 $contact = new ContactForm();
if($this->request->is(['post'])) {

$data = $this->request->data;



	$CakeEmail = new Email('default');
	$CakeEmail->to('amandine.hilt@hotmail.fr');
    $CakeEmail->addTo('anthony.coue@gmail.com');
	$CakeEmail->from($data['email']);
	$CakeEmail->sender($data['email']);
	$CakeEmail->subject($data['sujet']);
	$CakeEmail->viewVars(['message' => nl2br($data['message']),
	'username' => $data['username']]);
	$CakeEmail->emailFormat('html');
	$CakeEmail->template('message');
	
	if($CakeEmail->send()) {
	
	$this->Flash->center('Votre email a bien été envoyé, nous revenons vers vous au plus vite. Merci !');
	return $this->redirect($this->referer);
				}else {
				
	$this->Flash->error('L\'email n\'a pu être envoyé');

				
				}

}
 $this->set('contact', $contact);
$this->set('title', 'Formulaire de contact');
$this->set('description', 'Contacte pour erreur technique');



}	

     
}

?>
