<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use \ZipArchive;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class InscriptionPassagesController extends AppController
{
    public $paginate = ['limit' => 20];

    public function initialize()
    {
        parent::initialize();        
    }
     
    public function beforeFilter(Event $event)
    {
        $this->Security->config('unlockedFields', ['licencies']);
        //$this->Auth->allow([ 'inscriptions']);
    }
    
    public function index($id) {
        
        $nomUserConnected = $this->Auth->User('nom');
        $prenomUserConnected = $this->Auth->User('prenom');
        
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
            
        // Envoie de l'image, dépend de si y en a une uploadée ou pas
        if(!empty($event['image'])) $headimg = 'headers/evenements/g-'.$event['image'];
        else $headimg =  'header_main.png';
        
        // Si l'utilisateur est connecté
        if($this->Auth->User('id') !== null){
            
            // On récupère son id et email
            $userId = $this->Auth->User('id');
            $userEmail = $this->Auth->User('email');
            // On cherche les inscriptions à l'événement qu'il a déjà faite
            $inscription = $this->InscriptionPassages->find()->contain(['Licencies' => ['Grades'],'Grades'])->where(['user_id' => $userId,'passage_id' => $idPassage])->first();
            //debug($inscription);die;
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
            ->where(['nom' => strtoupper($data['nom']), 'prenom' => strtoupper($data['prenom']), 'sexe' => $data['sexe'], 'grade_id' => $data['grade_id']])
            ->first();
            
            if($licencie) {
                $licencie->nationalite = $data['nationalite'];
                $licencie->adresse = $data['adresse'];
                $licencie->telephone = $data['telephone'];
                $licencie->fax = $data['fax'];
                $licencie->email = $data['email'];
                $licencie->date_naissance = Time::createFromFormat('d/m/Y', $data['date_naissance'])->format('Y-m-d');
                $licencie->lieu_naissance = $data['lieu_naissance'];
                $licencie->grade_actuel_lieu = $data['grade_actuel_lieu'];
                $licencie->grade_actuel_organisation = $data['grade_actuel_organisation'];
                $licencie->grade_actuel_date = Time::createFromFormat('d/m/Y', $data['grade_actuel_date'])->format('Y-m-d');
                $this->Licencies->save($licencie);
                $licencieId = $licencie->id;
            } else {
                
                $licencieTable = TableRegistry::get('Licencies');
                $newLicencie = $licencieTable->newEntity();
                
                
                $newLicencie = $this->Licencies->patchEntity($newLicencie, $data);                
                $newLicencie->nom = strtoupper($data['nom']);
                $newLicencie->prenom = strtoupper($data['prenom']);
                $newLicencie->sexe = strtoupper($data['sexe']);
                $newLicencie->ddn = Time::createFromFormat('d/m/Y', $data['date_naissance'])->format('Y');
                $newLicencie->date_naissance = Time::createFromFormat('d/m/Y', $data['date_naissance'])->format('Y-m-d');
                $newLicencie->grade_id = $data['grade_id'];
                $newLicencie->grade_actuel_date = Time::createFromFormat('d/m/Y', $data['grade_actuel_date'])->format('Y-m-d');
                $newLicencie->club_id = $data['club_id'];
                $newLicencie->discipline_id = $passage->discipline_id;
                $licencieTable->save($newLicencie);
                $licencieId = $newLicencie->id;
                
                //debug($newLicencie);die();
            }
            
            //On retrouve le licencié si existant
            $this->loadModel('InscriptionPassages');
            $inscription = $this->InscriptionPassages->find()->select(['id'])->where(['passage_id'=>$idPassage, 'licencie_id'=>$licencieId])->first();
            
            if($inscription) {
                $inscription->club_id = $data['club_id'];
                $inscription->passage_id = $idPassage;
                $inscription->user_id = $userId;
                $inscription->grade_presente_id = $data['grade_presente_id'];
                $inscription->commentaire = $data['commentaire'];
                $inscription->accord_rgpd = $data['consent'];
                $inscription->licencie_id = $licencieId;
                //debug($inscription);
                $this->InscriptionPassages->save($inscription);
                $inscriptionId = $inscription->id;
            } else {               
                $inscriptionTable = TableRegistry::get('InscriptionPassages');
                $inscription = $inscriptionTable->newEntity();
                $inscription->id = null;
                $inscription->club_id = $data['club_id'];
                $inscription->passage_id = $idPassage;
                $inscription->user_id = $userId;
                $inscription->grade_presente_id = $data['grade_presente_id'];
                $inscription->commentaire = $data['commentaire'];
                $inscription->accord_rgpd = $data['consent'];
                $inscription->licencie_id = $licencieId;
                //debug($inscription);
                $inscriptionTable->save($inscription);
                $inscriptionId = $inscription->id;
            }
            
            $recapPassage = $this->InscriptionPassages->find()
                                                      ->contain(['Passages' => ['Disciplines'], 'Grades', 'Licencies'=> ['Clubs','Grades']])
                                                      ->where(['InscriptionPassages.id' => $inscriptionId])->first();
            //Envoie du mail recap
            $CakeEmail = new Email('default');
            $CakeEmail->to($userEmail);
            $CakeEmail->bcc('admin@kendo-region-system.fr');
            $CakeEmail->subject('Récapitulatif de l\'inscriptions à : '.$event['name']);
            $CakeEmail->viewVars(['recapPassage' => $recapPassage,'event'=>$event ]);
            $CakeEmail->emailFormat('html');
            $CakeEmail->template('confirmpassage');
            $CakeEmail->send();
            
            $this->Flash->success('L\'inscription a bien été enregistrées. Vous devriez recevoir un mail récapitulatif dans les minutes à venir');
            return $this->redirect(['action'=>'retour',$id]);           
            
        }
        
        // On envoie les variables pour les listes déroulantes et les catégories pour le jQuery
        $clubs = $this->InscriptionPassages->Clubs->find('list')->order(['name'=>'ASC']);
        $this->loadModel("Regions");
        $regions = $this->Regions->find('list')->order(['name'=>'ASC']);
        $this->loadModel("Grades");
        $grades = $this->Grades->find('list', ['keyField' => 'id', 'valueField' => 'name'])->order(['id'=>'ASC']);
        $this->set(compact(['passage', 'title', 'description', 'headimg', 'event', 'article', 'inscription','clubs','regions','grades','prenomUserConnected','nomUserConnected']));
    }
    
    public function resume($id) {
        
        
        //Verification que user est admin
        if($this->Auth->User('profil_id') != 1) return $this->redirect(['controller' => 'Users', 'action' => 'permission']);
        
        // On prend les données de l'événement
        $this->loadModel('Evenements');
        $event = $this->Evenements->find()->contain(['Passages'])->first();
        $this->set('id',$id);
        $title = $event['name'];
        $description = $event['name'];
        //Envoie de l'image, dépend de si y en a une uploadée ou pas
        if(!empty($event['image'])) $headimg = 'headers/evenements/g-'.$event['image'];
        else $headimg =  'header_main.png';
        $idPassage = $event->passage->id;
        //on retrouve les infos du passage
        $this->loadModel('Passages');
        $passage = $this->Passages->find()->where(['id'=> $idPassage])->first();



        // On cherche les inscriptions au passages
        $inscriptions = $this->InscriptionPassages->find()
                                                  ->contain(['Passages' => ['Disciplines'],'Licencies' => ['Grades', 'Clubs'],'Grades'])
                                                  ->where(['passage_id' => $idPassage]);
                                        
 		$this->set(compact(['passage', 'title', 'description', 'headimg', 'event', 'passage', 'inscriptions']));
                                                      
                                                      
    }
    
    public function view($id) {
        
        //Verification que user est admin
        if($this->Auth->User('profil_id') != 1) return $this->redirect(['controller' => 'Users', 'action' => 'permission']);
        
        // On prend les données de l'événement
        $this->loadModel('Evenements');
        $event = $this->Evenements->find()->contain(['Passages'])->first();
        $this->set('id',$id);
        $title = $event['name'];
        $description = $event['name'];
        //Envoie de l'image, dépend de si y en a une uploadée ou pas
        if(!empty($event['image'])) $headimg = 'headers/evenements/g-'.$event['image'];
        else $headimg =  'header_main.png';
        $inscription = $this->InscriptionPassages->find()
                                                 ->contain(['Passages'=>['Disciplines'],'Licencies' => ['Grades', 'Clubs'],'Grades'])
                                                 ->where(['InscriptionPassages.id' => $id])->first();
        $this->set(compact(['passage', 'title', 'description', 'headimg', 'event', 'inscription']));
                                                         
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

    // Fonction csv à partir du plug in
    public function exportCsv($id) {
        
        //Verification que user est admin
        if($this->Auth->User('profil_id') != 1) return $this->redirect(['controller' => 'Users', 'action' => 'permission']);
        
        $user_id =  $this->Auth->User('id');        
        $this->response->download('export.csv');
            
        $name = date('Ymd')."_ExportInscriptionPassage";
        
        // On cherche les inscriptions à l'événement qu'il a déjà faite
        $inscriptions = $this->InscriptionPassages->find()
                                        ->contain(['Grades','Passages' =>['Disciplines'],'Licencies' => ['Grades', 'Clubs']])
                                        ->where(['passage_id' => $id]);
                
        foreach($inscriptions as $datas){
            //debug($datas->grade->name);die;
            $datas['discipline'] = $datas->passage->discipline->name;
            $datas['grade_presente'] =  $datas->grade->name;
            $datas['numero_licence'] = $datas->licency->numero_licence;
            $datas['nom'] = $datas->licency->nom;
            $datas['prenom'] = $datas->licency->prenom;
            $datas['sexe'] = $datas->licency->sexe;
            $datas['nationalite'] = $datas->licency->nationalite;
            $datas['adresse'] = $datas->licency->adresse;
            $datas['telephone'] =  $datas->licency->telephone;
            $datas['fax'] =  $datas->licency->fax;
            $datas['email'] =  $datas->licency->email;
            $datas['date_naissance'] =  $datas->licency->date_naissance;
            $datas['lieu_naissance'] =  $datas->licency->lieu_naissance;
            $datas['grade'] =  $datas->licency->grade->name;
            $datas['grade_actuel_date'] =  $datas->licency->grade_actuel_date;
            $datas['grade_actuel_lieu'] =  $datas->licency->grade_actuel_lieu;
            $datas['grade_actuel_organisation'] =  $datas->licency->grade_actuel_organisation;
            
        }
       
        // Données à envoyer au plugin
        $_serialize = 'inscriptions';        
        // Choix du délimitant du csv pour lecture correcte en excel
        $_delimiter = ';';        
        // colonnes sélectionnées
        $_extract = ['discipline','numero_licence','nom','prenom','sexe','nationalite','adresse','telephone','fax','email','date_naissance','lieu_naissance','grade','grade_actuel_date','grade_actuel_lieu','grade_actuel_organisation','grade_presente'];
        
        // Nom des colonnes
        $_header = ["Discipline","Numero de licence","Nom","Prénom","Sexe","Nationalité","Adresse","Téléphone","Fax","Email","Date de naissance","Lieu de naissance","Grade actuel","Obtenu le","Lieu d'obtention","Organisation","Grade présenté"];
        
        $this->set(compact('inscriptions', '_serialize', '_extract', '_delimiter','_header'));
        $this->viewBuilder()->className('CsvView.Csv');
        
        $this->response->download($name.'.csv');
    }

    public function exportPdf($id) {
        
        //Verification que user est admin
        if($this->Auth->User('profil_id') != 1) return $this->redirect(['controller' => 'Users', 'action' => 'permission']);
        
        $this->loadModel('Evenements');
            
        $event = $this->Evenements->find()->contain(['Competitions'])->first();            
        $title = $event['name'];
        $description = $event['name'];        
        
        if(!empty($event['image'])) { $headimg = 'headers/evenements/l-'.$event['image']; }else { $headimg =  'header_main.png';}

        $this->set(compact(['id','title','description','event','headimg']));
             
        // On cherche les inscriptions à l'événement qu'il a déjà faite
        $inscriptions = $this->InscriptionPassages->find()
                                                ->contain(['Licencies' => ['Grades', 'Clubs'],'Grades','Passages' =>['Disciplines']])
                                                ->where(['passage_id' => $id]);
        
        $name = date('Ymd')."_ExportInscriptionPassage";
        $this->set('inscriptions',$inscriptions);
        $this->set('filename',$name);
    }



    public function fiche($id, $vertical, $zip = null) {
      
        //Verification que user est admin
        if ($this->Auth->User('profil_id') != 1) return $this->redirect(['controller' => 'Users', 'action' => 'permission']);
        
        // On prend les données de l'événement
        $this->loadModel('Evenements');
        $event = $this->Evenements->find()->contain(['Passages'])->first();
        $this->set('id', $id);
        $title = $event['name'];
        $description = $event['name'];
       
       
       
        $inscription = $this->InscriptionPassages->find()
                                                 ->contain(['Passages'=>['Disciplines'],'Licencies' => ['Grades', 'Clubs'],'Grades'])
                                                 ->where(['InscriptionPassages.id' => $id])->first();
        
        $this->set(compact(['passage', 'title', 'description', 'headimg', 'event', 'inscription']));
                                                         
        $this->set('inscription',$inscription);
       
        $this->set('vertical',$vertical);
        $this->set('zip',$zip);
        
    
        
        
        if (isset($zip)) {
       
             $path = WWW_ROOT.'files/fiches-passages/'.$inscription['passage_id'];
             $folder = new Folder($path);

             if (is_null($folder->path)) {
   			     $folder = new Folder($path, true, 0755);
		}


       
        $name = 'files/fiches-passages/'.$inscription['passage']['id'].'/Fiche-'.$inscription['licency']['nom'].'-'.$inscription['licency']['prenom'];
     
        $this->set('filename',$name);
     
        echo '<script>window.location.replace("../../../createindivs/'.$inscription['passage']['id'].'");</script>';

     
        } else {
      
            $name = 'Fiche-'.$inscription['licency']['nom'].'-'.$inscription['licency']['prenom'];
            $this->set('filename',$name);
        }
    
      
      
        
        }




// Création automatique des fiches individuelles qui n'ont jamais été créées
	function createindivs($id) {
	
	  if($this->Auth->User('profil_id') != 1) return $this->redirect(['controller' => 'Users', 'action' => 'permission']);
        
        $this->loadModel('Evenements');
            
        $event = $this->Evenements->find()->contain(['Competitions'])->first();            
        $title = $event['name'];
        $description = $event['name'];        
        
       
        $this->set(compact(['id','title','description','event','headimg']));
             
        // On cherche les inscriptions à l'événement qu'il a déjà faite
        $inscriptions = $this->InscriptionPassages->find()
                                                ->contain(['Licencies' => ['Grades', 'Clubs'],'Grades','Passages' =>['Disciplines']])
                                                ->where(['passage_id' => $id]);
        

	
// S'il n'y en a pas, on le signale

if ($inscriptions->isEmpty()) { 

$this->Flash->error('Il n\'y a pas encore d\'inscriptions pour ce passage de grade');

return $this->redirect(['action'=>'resume',$id]);

} else {
		
		
		// On commencer par supprimer toutes les inscriptions pour n'avoir que des inscriptions à jour
		
		
		// On va aller chercher toutes les inscriptions individuelles
		
    foreach ($inscriptions as $inscription) {
		
	
			
			$filepath =  WWW_ROOT.'files/fiches-passages/'.$id.'/Fiche-'.$inscription['licency']['nom'].'-'.$inscription['licency']['prenom'].'.pdf';


			// Si on a un fichier
        if (file_exists($filepath)) {
			
			// on continue la boucle
			$restante = true;
			continue;
			
		} else {
		
			
			// Sinon on l'arrête pour créer l'inscription
   			    $restante = false;
			    break;
            }

		}
			
			// Si on a des inscriptions individuelles en pdf qui n'ont pas été créé, on recommence la boucle,
		if ($restante == false) {
			
			
			// On envoie pour ça le pdf en mode spécial pour qu'il créé l'export puis qu'il recommence en repassant par ici
	
            return $this->redirect(['action'=>'fiche',$inscription['id'],'vertical','zip', '_ext'=>'pdf']);
		
			
			// Si $restante est à true, donc toutes les fiches sont créées, on va zipper le tout 
        } else {

			    return $this->redirect(['action'=>'zip',$id]);

            }
        }
	}
	


    public function zip($id) {


            // On prend les données de l'événement        
             $this->loadModel('Evenements');        
             $event = $this->Evenements->find()->contain(['Passages'])->first();
        
             $this->set('id',$id);
             $title = $event['name'];
             $description = $event['name'];
             
        if (!empty($event['image'])) { $headimg = 'headers/evenements/g-'.$event['image']; }else { $headimg =  'header_main.png'; }
        
             $this->set(compact(['title','description','headimg','event']));


	
	           // On prend le dossier à zipper
             $rootPath = new Folder('files/fiches-passages/'.$id.'/');
	


                // On ouvre le fichier zip
             $zip = new \ZipArchive();
          // Qu'on enregistre dans le fichier adequat
             $zip->open('zip/fiches-passages/'.$id.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

          // On trouve tous les fichiers pdf.
             $files = $rootPath->findRecursive('.*\.pdf');

          // On les met dans le fichier zip
        foreach ($files as $name => $file)
        {
        // En configurant les chemins absolus et relatifs
            $filePath = $file;
      	    $rootPath = WWW_ROOT.'files/fiches-passages/'.$id.'/';
            $relativePath = substr($filePath, strlen($rootPath) );

        // Qu'on ajoute à l'archive
       
            $zip->addFile($filePath, $relativePath);
   	
   		
        }
        //    On ferme le zip
              $zip->close();

              $zipname = 'zip/fiches-passages/'.$id.'.zip';



        if ($this->request->is(['post','put'])){

          // Le response permet de forcer le download
             $filePathZip = WWW_ROOT . $zipname;
             $this->response->file($filePathZip ,
             ['download'=> true, 'name'=> $id.'.zip']);
	
             }	
	    }
    }
?>
