<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Mailer\Email;

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
        //$this->Auth->allow([ 'inscriptions']);
    }
    
    public function index($id) {
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
            
            // On récupère son id et email
            $userId = $this->Auth->User('id');
            $userEmail = $this->Auth->User('email');
            // On cherche les inscriptions à l'événement qu'il a déjà faite
            $inscriptions = $this->InscriptionPassages->find()
            ->contain(['Licencies' => ['Grades'],'Grades'])
            ->where(['user_id' => $userId,'passage_id' => $idPassage]);
        } else {
            // Sinon, on met un user_id par défaut pour pas faire bugger la sauvegarde ????? A REPRENDRE
            $userId = 1;
        }
        
        if($this->request->is(['patch','post','put'])) {
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
            
            //On retrouve le licencié si existant
            $this->loadModel('Licencies');
            $licencie = $this->Licencies->find()
            ->select(['id'])
            ->where(['nom' => strtoupper($data['nom']), 'prenom' => strtoupper($data['prenom']), 'sexe' => $data['sexe'][0], 'grade_actuel_id' => $data['grade_actuel_id']])
            ->first();
            if($licencie) {
                $licencieId = $licencie->id;
            } else {
                
                $licencieTable = TableRegistry::get('Licencies');
                $newLicencie = $licencieTable->newEntity();
                
                
                $newLicencie = $this->Licencies->patchEntity($newLicencie, $data);                
                $newLicencie->nom = strtoupper($data['nom']);
                $newLicencie->prenom = strtoupper($data['prenom']);
                $newLicencie->sexe = strtoupper($data['sexe'][0]);
                $newLicencie->ddn = Time::createFromFormat('d/m/Y', $data['date_naissance'])->format('Y');
                $newLicencie->date_naissance = Time::createFromFormat('d/m/Y', $data['date_naissance'])->format('Y-m-d');
                $newLicencie->grade_actuel_id = $data['grade_actuel_id'];
                $newLicencie->grade_actuel_date = Time::createFromFormat('d/m/Y', $data['obtenu_le'])->format('Y-m-d');
                $newLicencie->club_id = $data['club_id'];
                $newLicencie->discipline_id = $passage->discipline_id;
                $licencieTable->save($newLicencie);
                $licencieId = $newLicencie->id;
                
                //debug($newLicencie);die();
            }
            
            $inscriptionTable = TableRegistry::get('InscriptionPassages');
            $inscription = $inscriptionTable->newEntity();
            $inscription->id = null;
            $inscription->club_id = $data['club_id'];
            $inscription->passage_id = $idPassage;
            $inscription->user_id = $userId;
            $inscription->grade_presente_id = $data['grade_presente_id'];
            $inscription->commentaire = $data['commentaire'];
            $inscription->licencie_id = $licencieId;
            //debug($inscription);
            $inscriptionTable->save($inscription);
            
            
            $recapPassage = $this->InscriptionPassages->find()
                                                      ->contain(['Passages' => ['Disciplines'], 'Grades', 'Licencies'=> ['Clubs','Grades']])
                                                      ->where(['user_id'=>$userId, 'passage_id'=> $idPassage]);
            $CakeEmail = new Email('default');
            $CakeEmail->to($userEmail);
            $CakeEmail->subject('Récapitulatif de l\'inscriptions à : '.$event['name']);
            $CakeEmail->viewVars(['recapPassage' => $recapPassage,'event'=>$event ]);
            $CakeEmail->emailFormat('html');
            $CakeEmail->template('confirmpassage');
            $CakeEmail->send();
            
            $this->Flash->success('L\'inscriptions ont bien été enregistrées. Vous devriez recevoir un mail récapitulatif dans les minutes à venir');
            return $this->redirect(['action'=>'retour',$id]);           
            
        }
        
        // On envoie les variables pour les listes déroulantes et les catégories pour le jQuery
        $clubs = $this->InscriptionPassages->Clubs->find('list')->order(['name'=>'ASC']);
        $this->loadModel("Regions");
        $regions = $this->Regions->find('list')->order(['name'=>'ASC']);
        $this->loadModel("Grades");
        $grades = $this->Grades->find('list', ['keyField' => 'id', 'valueField' => 'name'])->order(['id'=>'ASC']);
        $this->set(compact(['passage', 'title', 'description', 'headimg', 'event', 'article', 'inscriptions','clubs','regions','grades']));
    }
    
//     public function inscriptions($id) {
        
//         // On prend les données de l'événement        
//         $this->loadModel('Evenements');        
//         $event = $this->Evenements->find()->contain(['Passages'])->first();        
//         $this->set('id',$id);
//         $title = $event['name'];
//         $description = $event['name'];
        
//         $idPassage = $event->passage->id;
//         //on retrouve les infos du passage
//         $this->loadModel('Passages');
//         $passage = $this->Passages->find()->where(['id'=> $idPassage])->first();
//         // On envoie article pour que le Form soit lié à la table InscriptionPassages    
//         //$passage = $this->InscriptionPassages->newEntity();        
        
//         // Envoie de l'image, dépend de si y en a une uploadée ou pas        
//         if(!empty($event['image'])) $headimg = 'headers/evenements/g-'.$event['image']; 
//         else $headimg =  'header_main.png';
        
//         // Si l'utilisateur est connecté
//         if($this->Auth->User('id') !== null){
        
//             // On récupère son id et email
//             $userId = $this->Auth->User('id');            
//             $userEmail = $this->Auth->User('email');
//             // On cherche les inscriptions à l'événement qu'il a déjà faite            
//             $inscriptions = $this->InscriptionPassages->find()
//                                                       ->contain(['Licencies' => ['Grades'],'Grades'])
//                                                       ->where(['user_id' => $userId,'passage_id' => $idPassage]);
//         } else {        
//             // Sinon, on met un user_id par défaut pour pas faire bugger la sauvegarde ????? A REPRENDRE
//             $userId = 1;
//         }
       
//         if($this->request->is(['patch','post','put'])){
//             $data = $this->request->data;	     
//             //debug($data['nom']);die;
//             if(count($data['nom']) < 2  ) return $this->redirect(['action'=>'inscriptions',$id]);
            
//             //debug($data);die();
//             // Si c'est un nouveau club, on le rentre dans la base
//             if($data['new_club'] == 1) {
//                 $clubTable = TableRegistry::get('Clubs');
//                 $club = $clubTable->newEntity();
//                 $club->id = null;
//             	$club->name = strtoupper($data['club_name']);
//                 $club->region_id = $data['region_id'];
//                 $clubTable->save($club);
//                 $data['club_id'] = $club->id;
//             }    
            
//             $nbInscription = count($data['licence']);
        
//             for ($i = 0; $i < $nbInscription; $i++) {
//                 //On retrouve le licencié si existant
//                 $this->loadModel('Licencies');
//                 $licencie = $this->Licencies->find()
//                                             ->select(['id'])
//                                             ->where(['numero_licence' => $data['licence'][$i], 'nom' => strtoupper($data['nom'][$i]), 'prenom' => strtoupper($data['prenom'][$i]), 'sexe' => $data['sexe'][$i], 'grade_id' => $data['grade'][$i]])
//                                             ->first();
//                 //debug($licencie);die();
//                 if($licencie) {
//                     $licencieId = $licencie->id;
//                 } else {

//                     $licencieTable = TableRegistry::get('Licencies');
//                     $newLicencie = $licencieTable->newEntity();
//                     $newLicencie->id = null;
//                     $newLicencie->numero_licence = $data['licence'][$i];
//                     $newLicencie->nom = strtoupper($data['nom'][$i]);
//                     $newLicencie->prenom = strtoupper($data['prenom'][$i]);
//                     $newLicencie->ddn = Time::createFromFormat('d/m/Y', $data['ddn'][$i])->format('Y');
//                     $newLicencie->sexe = $data['sexe'][$i];
//                     $newLicencie->grade_id = $data['grade'][$i];
//                     $newLicencie->club_id = $data['club_id'];
//                     $newLicencie->discipline_id = $passage->discipline_id;                    
//                     $licencieTable->save($newLicencie);
//                     $licencieId = $newLicencie->id;;
//                 }
             
//                 $inscriptionTable = TableRegistry::get('InscriptionPassages');
//                 $inscription = $inscriptionTable->newEntity();
//                 $inscription->id = null;
//                 $inscription->club_id = $data['club_id'];
//                 $inscription->passage_id = $idPassage;
//                 $inscription->user_id = $userId;
//                 $inscription->grade_presente_id = $data['grade_presente'][$i];
//                 $inscription->commentaire = $data['commentaire'];
//                 $inscription->licencie_id = $licencieId;
//                 //debug($inscription);
//                 $inscriptionTable->save($inscription);
//             }
            
            
            
                
//             $recapPassage = $this->InscriptionPassages->find()
//                                                       ->contain(['Passages' => ['Disciplines'], 'Grades', 'Licencies'=> ['Clubs','Grades']])
//                                                       ->where(['user_id'=>$userId, 'passage_id'=> $idPassage]);
//             $CakeEmail = new Email('default');
//             $CakeEmail->to($userEmail);
//             $CakeEmail->subject('Récapitulatif de vos inscriptions à : '.$event['name']);
//             $CakeEmail->viewVars(['recapPassage' => $recapPassage,'event'=>$event ]);
//             $CakeEmail->emailFormat('html');
//             $CakeEmail->template('confirmpassage');
//             $CakeEmail->send();
                    
//             $this->Flash->success('Les inscriptions ont bien été enregistrées. Vous devriez recevoir un mail récapitulatif dans les minutes à venir');
//             return $this->redirect(['action'=>'retour',$id]);
                        
// 		}   
		
// 		// On envoie les variables pour les listes déroulantes et les catégories pour le jQuery
// 		$clubs = $this->InscriptionPassages->Clubs->find('list')->order(['name'=>'ASC']);
// 		$this->loadModel("Regions");
// 		$regions = $this->Regions->find('list')->order(['name'=>'ASC']);
// 		$this->loadModel("Grades");
// 		$grades = $this->Grades->find('list', ['keyField' => 'id', 'valueField' => 'name'])->order(['id'=>'ASC']);
// 		$this->set(compact(['passage', 'title', 'description', 'headimg', 'event', 'article', 'inscriptions','clubs','regions','grades']));
		
//     }	
    
    public function retour($id) {
        
        
        // On prend les données de l'événement        
        $this->loadModel('Evenements');        
        $event = $this->Evenements->find()->contain(['Passages'])->first();
        
        $this->set('id',$id);
        $title = $event['name'];
        $description = $event['name'];
        if(!empty($event['image'])) { $headimg = 'headers/evenements/g-'.$event['image']; }else { $headimg =  'header_main.png';}
        
        $this->set(compact(['title','description','headimg','event']));
        
    }
    
    public function edit($id) {
        
        $inscription = $this->InscriptionPassages->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            debug($this->request->data);die();
            $inscription = $this->InscriptionPassages->patchEntity($inscription, $this->request->data);
            if ($this->InscriptionPassages->save($inscription)) {
                
                $this->Flash->success(__('Le club a été sauvegardé.'));
            } else {
                $this->Flash->error(__('Le club n\'a pas été sauvegardé.'));
            }
        }     
        
        return $this->redirect(['action'=>'inscriptions',$id]);
        
    }
    
    public function delete($id, $event) {
    
        $this->request->allowMethod(['post', 'delete']);
        $element = $this->InscriptionPassages->get($id);
        if ($this->InscriptionPassages->delete($element)) {
            $this->Flash->success(__('L\'isnscription a bien été supprimé.'));
        } else {
            $this->Flash->error(__('Erreur dans la suppression de l\'isnscription.'));
        }
        return $this->redirect(['action' => 'inscriptions', $event]);
    }
}
?>
