<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

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
        $this->Auth->allow([ 'inscriptions']);
    }
    
    function inscriptions($id) {
        
        // On prend les données de l'événement        
        $this->loadModel('Evenements');        
        $event = $this->Evenements->find()->contain(['Passages'])->first();        
        $this->set('id',$id);
        $title = $event['name'];
        $description = $event['name'];
        
        $idPassage = $event->passage->id;
        //on retrouve les infos du passage
        $this->loadModel('Passages');
        $passage = $this->Passages->find()->where(['id'=> $idPassage])->first();
        // On envoie article pour que le Form soit lié à la table InscriptionPassages    
        //$passage = $this->InscriptionPassages->newEntity();        
        
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
                                                      ->where(['user_id' => $user_id,'passage_id' => $idPassage]);
        } else {        
            // Sinon, on met un user_id par défaut pour pas faire bugger la sauvegarde ????? A REPRENDRE
            $user_id = 1;
        }
       
        if($this->request->is(['patch','post','put'])){
            $data = $this->request->data;	     
            //debug($data);die();
            // Si c'est un nouveau club, on le rentre dans la base
            if($data['new_club'] == 1) {
                $clubTable = TableRegistry::get('Clubs');
                $club = $clubTable->newEntity();
                $club->id = null;
            	$club->name = strtoupper($data['club_name']);
                $club->region_id = $data['region_id'];
                $clubTable->save($club);
                $data['club_id'] = $club->id;
            }    
            
            $nbInscription = count($data['licence']);
        
            for ($i = 0; $i < $nbInscription; $i++) {
                //On retrouve le licencié si existant
                $this->loadModel('Licencies');
                $licencie = $this->Licencies->find()
                                            ->select(['id'])
                                            ->where(['numero_licence' => $data['licence'][$i], 'nom' => $data['nom'][$i], 'prenom' => $data['prenom'][$i], 'sexe' => $data['sexe'][$i], 'grade_id' => $data['grade'][$i]])
                                            ->first();
                //debug($licencie);die();
                if($licencie) {
                    $licencie_id = $licencie->id;
                } else {

                    $licencieTable = TableRegistry::get('Licencies');
                    $newLicencie = $licencieTable->newEntity();
                    $newLicencie->id = null;
                    $newLicencie->numero_licence = strtoupper($data['licence'][$i]);
                    $newLicencie->nom = strtoupper($data['nom'][$i]);
                    $newLicencie->prenom = $data['prenom'][$i];
                    $newLicencie->ddn = Time::createFromFormat('d/m/Y', $data['ddn'][$i])->format('Y');
                    $newLicencie->sexe = $data['sexe'][$i];
                    $newLicencie->grade_id = $data['grade'][$i];
                    $newLicencie->club_id = $data['club_id'];
                    $newLicencie->discipline_id = $passage->discipline_id;                    
                    $licencieTable->save($newLicencie);
                    $licencie_id = $newLicencie->id;;
                }
             
                $inscriptionTable = TableRegistry::get('InscriptionPassages');
                $inscription = $inscriptionTable->newEntity();
                $inscription->id = null;
                $inscription->club_id = $data['club_id'];
                $inscription->passage_id = $idPassage;
                $inscription->user_id = $user_id;
                $inscription->grade_presente_id = $data['grade_presente'][$i];
                $inscription->commentaire = $data['commentaire'];
                $inscription->licencie_id = $licencie_id;
                //debug($inscription);
                $inscriptionTable->save($inscription);
            }	       
		}   
		
		// On envoie les variables pour les listes déroulantes et les catégories pour le jQuery
		$clubs = $this->InscriptionPassages->Clubs->find('list')->order(['name'=>'ASC']);
		$this->loadModel("Regions");
		$regions = $this->Regions->find('list')->order(['name'=>'ASC']);
		$this->loadModel("Grades");
		$grades = $this->Grades->find('list', ['keyField' => 'id', 'valueField' => 'name'])->order(['id'=>'ASC']);
		$this->set(compact(['passage', 'title', 'description', 'headimg', 'event', 'article', 'inscriptions','clubs','regions','grades']));
		
    }	
	
}
?>
