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

class InscriptionCompetitionsController extends AppController
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
 
        $this->Auth->allow(['index',
						    'organisateur',
						   'export',
						   'gestion',
						   'view']);

       
        
        
 
    }
    
 


    function inscriptions($id) {
	
        
        // On prend les données de l'événement
        
        $this->loadModel('Evenements');
        
        $event = $this->Evenements->find()
	->contain(['Competitions'=> function(\Cake\ORM\Query $q) use ($id) {
        return $q->where(['Competitions.id' => $id]);
    }])

	->matching('Competitions', function(\Cake\ORM\Query $q) use($id) {
        return $q->where(['Competitions.id' => $id]);
    })->first();
        
        $this->set('id',$id);
      
         
         $title = $event['name'];
         $description = $event['name'];
        
     
        
        $this->set('title', $title);
        $this->set('description', $description);
        
        
        
        // On envoie article pour que le Form soit lié à la table InscriptionCompetition
    
        $article = $this->InscriptionCompetitions->newEntity();
        
        
        // Envoie de l'image, dépend de si y en a une uploadée ou pas
        
         if(!empty($event['image'])) { $headimg = 'headers/evenements/l-'.$event['image']; }else { $headimg =  'header_main.png';}
         
         
          $this->set('headimg',$headimg);
          $this->set('event',$event);
          $this->set('article',$article);
        
        
       
        // Si l'utilisateur est connecté
        
        if($this->Auth->User('id') !== null){
            
        
            // On récupère son id
            
        $user_id = $this->Auth->User('id');
        $user_email = $this->Auth->User('email');
        $user_club = $this->Auth->User('club_id');    
         
            
            // On cherche les inscriptions à l'événement qu'il a déjà faite
            
        $articles = $this->InscriptionCompetitions->find('all')
         ->where(['user_id'=>$user_id,'InscriptionCompetitions.competition_id'=>$event['competition']['id']])
            ->contain(['Licencies','Categories','Equipes']);
            
            $this->set('articles',$articles);
              
             // Pour les administratifs aussi
            
            $this->loadModel('InscriptionAdministratifs');
            
            $admins = $this->InscriptionAdministratifs->find('all')
            ->where(['user_id'=>$user_id,'InscriptionAdministratifs.competition_id'=>$event['competition']['id']])
            ->contain(['Licencies']);
           
              $this->set('admins',$admins);
            
        
            
        } else {
        
        // Sinon, on met un user_id par défaut pour pas faire bugger la sauvegarde ????? A REPRENDRE
        
             $user_id = 1;
        }
        
    
    
        
      
        // On envoie les variables pour les listes déroulantes et les catégories pour le jQuery
         
    $this->set('clubs', $this->InscriptionCompetitions->Clubs->find('list')->order(['name'=>'ASC']));
    $this->set('grades', $this->InscriptionCompetitions->Grades->find('list')->order(['id'=>'ASC']));
    $this->set('regions', $this->InscriptionCompetitions->Clubs->Regions->find('list')->order(['name'=>'ASC']));
    $this->set('categories', $this->Evenements->Competitions->Categories->find('all')->order(['id'=>'ASC']));
        
        
	    
  

		// Quand on a une requête
		
	if($this->request->is(['patch','post','put'])){
	
    
        
      
	$datai = $this->request->data;	
       
    
        // Si c'est un nouveau club, on le rentre dans la base
        if($datai['new_club'] == 1) {
	
	$club = $this->InscriptionCompetitions->Clubs->newEntity();
	$club->name = strtoupper($datai['club_name']);
    $club->region_id = $datai['region_id'];
	$result_club = $this->InscriptionCompetitions->Clubs->save($club);
	
    $data['licencie']['club_id'] = $result_club['id'];
	$datai['club_id'] = $result_club['id'];
	} 
        
        
        
        /*------- TRAITEMENT DES INSCRIPTIONS INDIVIDUELLES-------------*/
        
        
        
        // Si on a une inscription individuelle
        if(!empty($datai['inscription_competitions'])) {
    
            
            // Pour chacune d'entre elle
            
            foreach($datai['inscription_competitions'] as $data) {
        
       
                
              if(isset($data['id'])) {
       // Je vais définir toutes les variables communes à tous les licenciés
                
    $data['new_club'] = $datai['new_club'];
    $data['licencie']['club_id'] = $datai['club_id'];
    $data['commentaire'] = $datai['commentaire'];    
    $data['competition_id'] = $event['competition']['id'];  
    $data['user_id'] = $user_id;
        
	
              
                
	// Je remets les années de cakephp au carré
		$data['certificat'] = $data['certificat']['year'];
		$data['licencie']['ddn'] = $data['licencie']['ddn']['year'];
		$data['licencie']['discipline_id'] = $event['discipline_id'];
        
        // Je mets nom et prénom en majuscules
                  
             $data['licencie']['nom'] =  strtoupper($data['licencie']['nom']);
             $data['licencie']['prenom'] =  strtoupper($data['licencie']['prenom']);      
		
		
		// Si ce n'est pas un nouveau club, on prend l'id de la liste de selection
		if($data['new_club'] == 0) {
		$data['licencie']['club_id'] = $datai['club_id'];
		} else {
		
		// Sinon on prend le result id du club plus haut
		$data['licencie']['club_id'] = $result_club['id'];
		}
		
		// On attribue les catégories en fonction de l'année de naissance
		
		$this->loadModel('Categories');
		
		$categories = $this->Categories->find('all');
		
		foreach($categories as $category) {
		
		
			// Si la catégorie est mixte, cad pour les enfants
			if($category['sexe'] == 'X') {
		
				// On attribue la catégorie en fonction de l'age seulement en testant que la date de naissance
				// se trouve bien entre l'année de début et l'année de fin dans la catégorie
		
				if($data['licencie']['ddn'] >= $category['annee_debut']  && $data['licencie']['ddn'] <= $category['annee_fin']) {
		
					$data['category_id'] = $category['id'];
		
				}
		
		// Si on est dans une catégorie qui distingue homme et femmes (à partir de cadets / espoirs)
		
			} else {
		
		// S'il n'y a pas de distincition de grade pour ces catés (cadets/espoirs/juniors)
		
			if($category['grade_debut'] == 0) {
		
				
		// On ne prend en compte que la différence de sexe et l'année de naissance
		
				if($data['licencie']['ddn'] >= $category['annee_debut']  
				   && $data['licencie']['ddn'] <= $category['annee_fin']
				   && $data['licencie']['sexe'] == $category['sexe']) {
		
					$data['category_id'] = $category['id'];
		
				}
		
			}
		
			
		// Pour les adultes, on va regarder le grade pour distinguer kyu/honneur/excellences
		
		else {

		
		if($data['licencie']['ddn'] >= $category['annee_debut'] && $data['licencie']['ddn'] <= $category['annee_fin'] && $data['licencie']['sexe'] == $category['sexe'] && $data['licencie']['grade_id'] >= $category['grade_debut'] && $data['licencie']['grade_id'] <= $category['grade_fin'] ) {
		
		
		
		$data['category_id'] = $category['id'];
		
				
				        }
			 
		          } 
			
            }
		
		
         }
		
    
        // Si ce n'est pas un nouveau licencié (on reprend l'id à partir de l'inscription)    
        
        if($data['licencie']['id'] !== '') {
        
            // Je cherche le licencié concerné dans la base
           
        $licencie = $this->InscriptionCompetitions->Licencies->find('all')
           ->Where(['id'=>$data['licencie']['id']])
           ->first();
            
            // Je prépare pour la mise à jour
             $newlicencie = $licencie;
        }
        
      
        else {
            
            // Sinon, je vérifie qu'il existe pas dans la base à partir du numéro de licence ou du nom /prenom
            
             $licencie = $this->InscriptionCompetitions->Licencies->find('all')
           ->Where(['numero_licence'=>$data['licencie']['numero_licence']])
           ->orWhere(['nom'=>$data['licencie']['nom'], 'prenom'=>$data['licencie']['prenom']])
           ->first();
            
            if($licencie !== null) {
                
            $newlicencie = $licencie;
        
                $data['licencie']['id'] = $newlicencie['id'];
            
            } else {
            
            // Sinon, j'en créé un nouveau
          
            $newlicencie = $this->InscriptionCompetitions->Licencies->newEntity();
           }
           
        }
            
                // Sauvegarde des données
                
          $entity_licencie = $this->InscriptionCompetitions->Licencies->patchEntity($newlicencie, $data['licencie']);
            
          $entity_licencie->discipline_id = $event['competition']['discipline_id'];
       
          $result_licencie = $this->InscriptionCompetitions->Licencies->save($entity_licencie);
        
            
                // Si ce n'est pas une nouveau inscription
                
		 if($data['id'] !== '') {
             
             // Je vais mettre à jour l'inscription
             
              $articli = $this->InscriptionCompetitions->find('all')
           ->Where(['id'=>$data['id']])
           ->first();
             
         }else {
             
             // Sinon j'en créé une nouvelle
             
        $articli = $this->InscriptionCompetitions->newEntity();
            
         }
	
	// On enregistre l'inscription en rajoutant 1 à la participation individuelle
		
    $entity = $this->InscriptionCompetitions->patchEntity($articli, $data, ['associated' => 'Licencies']);


        $entity->licencie_id = $result_licencie['id'];
        $entity->competition_id = $id;
	    $entity->participation_indiv = 1;
        
        
    
 
     $result =  $this->InscriptionCompetitions->save($entity,['associated'=>'Licencies']);

    }
        
      }      
        }
        
        
        /*------- TRAITEMENT DES INSCRIPTIONS PAR EQUIPE-------------*/
            
        
        
            foreach($datai['equipes'] as $datae) {
    
                // Si on a une inscription par équipe (en testant sur le nom d'équipe)
                
                if(!empty($datae['equipe']['name'])) {
                
                          
                    // Si ce n'est pas une nouvelle equipe (j'ai un id)
                   
                    if($datae['equipe']['id'] !== '') {
                    
                        // Je cherche l'equipe de référence pour la mettre à jour
                    
                        $equipe = $this->InscriptionCompetitions->Equipes->find('all')
                        ->where(['id'=>$datae['equipe']['id'],'Equipes.competition_id'=>$id])
                        ->first();
                    
                      
                    
                } else {
                   
                        // Sinon, je créé l'équipe
                    
                        $equipe = $this->InscriptionCompetitions->Equipes->newEntity();
                        
                       
               
                }
                
                $entity_equipe = $this->InscriptionCompetitions->Equipes->patchEntity($equipe, $datae['equipe']);
                $entity_equipe->competition_id = $id;
                $result_equipe = $this->InscriptionCompetitions->Equipes->save($entity_equipe);
              
                   
                    
                    // Pour chaque inscrit en equipe
                    foreach($datae['licencie'] as $datao) {
                        
                    if($datao['nom'] !== '') {
                      
                        // Dans tous les cas, on remet la date de naissance au carré
                        $datao['ddn'] = $datao['ddn']['year'];
                        
                        // Si c'est une mise à jour (on a déjà un id)
                       
                         if($datao['id'] !== '') {
                        
                        $licencio = $this->InscriptionCompetitions->Licencies->find('all')
                        ->Where(['id'=>$datao['id']])
                        ->first();
                        
                        $inscri = $licencio;
                             
                        
                         } else {
                        
                            
                          // Sinon je vérifie s'il n'existe pas à partir de la licence ou du nom / prenom
                             
                               // Je mets nom et prénom en majuscules
                  
             $datao['nom'] =  strtoupper($datao['nom']);
             $datao['prenom'] =  strtoupper($datao['prenom']);      
		
                             
                             
                      $licencio = $this->InscriptionCompetitions->Licencies->find('all')
                        ->Where(['numero_licence'=>$datao['numero_licence']])
                        ->orWhere(['nom'=>$datao['nom'], 'prenom'=>$datao['prenom']])  
                        ->first();
                             
                          
                        
                        if($licencio !== null) {     
                             
                        $inscri = $licencio;
                                
                            // Si on a un licencié, on va lui indiqué l'id à mettre à jour dans le data
                            $datao['id'] = $licencio['id'];
                             
                        }
                             else {
                             
                        // Sinon, je le créé
                        $inscri = $this->InscriptionCompetitions->Licencies->newEntity();   
                            
                             }
                         
                             
                       }
                        
                       
                       $datae['certificat'] = $datao['certificat']['year'];
                       $datae['surclassement_age'] = $datao['surclassement'];
                        $datae['certificat_qs'] = $datao['certificat_qs'];
                
                        $entity_inscro = $this->InscriptionCompetitions->Licencies->patchEntity($inscri,$datao);
                        
                      
                        
                        $entity_inscro->discipline_id = $event['competition']['discipline_id'];
                        $entity_inscro->club_id = $datai['club_id'];
                        
                       
                        
                        $result_inscro = $this->InscriptionCompetitions->Licencies->save($entity_inscro);
                        
                       
                        
                        // Je vérifie ensuite s'il est déjà inscrit à la compète ou pas
                        
                         $inscro = $this->InscriptionCompetitions->find('all')
                        ->where(['licencie_id'=>$result_inscro['id'], 'competition_id'=>$id])
                        ->first();
                            
                        
                        
                        // Si c'est le cas, je vais le prendre pour le mettre à jour
                      
                        if($inscro !== null) {
                            
                            $inscru = $inscro;     
                     
                       
                        } else {
                            
                            // Sinon je cree l'inscription à la compete
                            
                        $inscru = $this->InscriptionCompetitions->newEntity();
                     
                            
                        }
                        
                        // Je passe participation_equipe à 1 pour signaler qu'il fait partie d'une équipe
                        
                        $entity_inscru = $this->InscriptionCompetitions->patchEntity($inscru,$datae);
                            
                        $entity_inscru->licencie_id = $result_inscro['id'];
                        $entity_inscru->competition_id = $id;
                        $entity_inscru->equipe_id = $result_equipe['id'];
                        $entity_inscru->user_id = $user_id;
                        $entity_inscru->participation_equipe = 1;
                        
                        if(!empty($datai['commentaire'])) {
                            $entity_inscru->commentaire = $datai['commentaire'];
                         }
                    
                     
                        
                        $result_inscru = $this->InscriptionCompetitions->save($entity_inscru, ['associated' => false]);
                            
                         
                        } 
                        
                    
                    
                    }
                
            
        
                    }   
            
            
        }
    
        
        /*------- TRAITEMENT DES INSCRIPTIONS COMMISSAIRES ET ARBRITRES -------------*/
        
        // Pour chaque inscrit administratif
        
       
        
        foreach($datai['administratif'] as $dataa) {
         
            
            // Si on a le nom de rempli
            
            if(!empty($dataa['licencie']['nom'])){
               
           
                // Je mets nom et prénom en majuscules
                  
             $dataa['licencie']['nom'] =  strtoupper($dataa['licencie']['nom']);
             $dataa['licencie']['prenom'] =  strtoupper($dataa['licencie']['prenom']);      
		
                
                 // Je vérifie s'il existe ou pas
                        $licencio = $this->InscriptionCompetitions->Licencies->find('all')
                        ->where(['numero_licence'=>$dataa['licencie']['numero_licence']])
                        ->orWhere(['nom'=>$dataa['licencie']['nom'], 'prenom'=>$dataa['licencie']['prenom']])    
                        ->first();
                        
                        $result_inscro = $licencio;
                        
                    
                        
                          // S'il n'existe pas, je le créé
                        if(empty($licencio)) {
                            
                     
                            
                        $inscri = $this->InscriptionCompetitions->Licencies->newEntity();
                        
                
                               
                        }   else {
                            
                             $inscri = $licencio;
                            
                            
                        }       
                        
                         $entity_inscro = $this->InscriptionCompetitions->Licencies->patchEntity($inscri,$dataa['licencie']);
                        
                            $entity_inscro->discipline_id = $event['competition']['discipline_id'];
                            $entity_inscro->club_id = $datai['club_id'];
                            
                            $result_inscro = $this->InscriptionCompetitions->Licencies->save($entity_inscro);
                
                       // Je créé ensuite l'inscription administrative
                        
                        $this->loadModel('InscriptionAdministratifs');
                        
                        if(!empty($dataa['id'])) {
                
                       $inscru = $this->InscriptionAdministratifs->find('all')
                           ->where(['id'=>$dataa['id']])
                           ->first();
                            
                           
                        } else {
                            
                            
                            $inscru = $this->InscriptionAdministratifs->newEntity();
                            
                        }
                
                                        
                        // 1 va représenter la présence le 1er jour
                        // 2 va représenter la présence le 2ème jour
                        // 12 la présence les 2 jours
                
                        if($dataa['samedi'] == 1 && $dataa['dimanche'] == 0 ) {
                        
                            $dataa['presence'] = 1;
                       
                        }elseif ($dataa['samedi'] == 0 && $dataa['dimanche'] == 1 ) {
                            
                            $dataa['presence'] = 2;
                        } elseif ($dataa['samedi'] == 1 && $dataa['dimanche'] == 1 ){
                           
                            $dataa['presence'] = 12;
                            
                        } else 
                            
                        { $dataa['presence'] = 0;}
                
                                
                
                
                        
                        $entity_inscru = $this->InscriptionAdministratifs->patchEntity($inscru,$dataa);
                            
                        $entity_inscru->licencie_id = $result_inscro['id'];
                        $entity_inscru->competition_id = $id;
                        $entity_inscru->user_id = $user_id;
                       
               
                      
                    
                        $result_inscru = $this->InscriptionAdministratifs->save($entity_inscru);
                     
                            
                        }
                            
                
                
                
                
                
            }
            
        
        
    
         if (isset($result) OR isset($result_inscru)) {
             
             $recap_compete = $this->InscriptionCompetitions->find('all')
                 ->where(['user_id'=>$user_id, 'InscriptionCompetitions.competition_id'=>$id])
                 ->order(['equipe_id'=>'ASC'])
                 ->contain(['Categories','Equipes','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades'])
                 ;}]);
             
             
             $recap_admin= $this->InscriptionAdministratifs->find('all')
                 ->where(['user_id'=>$user_id, 'InscriptionAdministratifs.competition_id'=>$id])
                 ->contain('Licencies');
             
             $club = $this->InscriptionCompetitions->Clubs->find('all')
                 ->where(['id'=>$user_club])
                 ->first();
            
             
    $CakeEmail = new Email('default');
	$CakeEmail->to($user_email);
	$CakeEmail->addTo('admin@kendo-region-system.fr');
	$CakeEmail->subject('Récapitulatif de vos inscriptions à : '.$event['name']);
	$CakeEmail->viewVars(['recap_compete' => $recap_compete,
	'recap_admin' => $recap_admin,
    'event'=>$event,
    'club'=>$club                      
	]);
	
	$CakeEmail->emailFormat('html');
	$CakeEmail->template('confirmcompete');
	 $CakeEmail->send();	
             
             
             
	$this->Flash->success('Les inscriptions ont bien été envoyées. Vous devriez recevoir un mail récapitulatif dans les minutes à venir');
		return $this->redirect(['action'=>'retour',$id]);
	}
				else {
	
	$this->Flash->error('Il y a eu une erreur et les inscriptions n\'ont pu être envoyées.');

                    
                }
		}

       	
	

}
    
     function retour($id) {
	
        
        // On prend les données de l'événement
        
        $this->loadModel('Evenements');
        
        $event = $this->Evenements->find()
	->contain(['Competitions'=> function(\Cake\ORM\Query $q) use ($id) {
        return $q->where(['Competitions.id' => $id]);
    }])

	->matching('Competitions', function(\Cake\ORM\Query $q) use($id) {
        return $q->where(['Competitions.id' => $id]);
    })->first();
        
        $this->set('id',$id);
      
         
         $title = $event['name'];
         $description = $event['name'];
        
     
        
        $this->set('title', $title);
        $this->set('description', $description);
         
         
          if(!empty($event['image'])) { $headimg = 'headers/evenements/l-'.$event['image']; }else { $headimg =  'header_main.png';}
         
         
          $this->set('headimg',$headimg);
          $this->set('event',$event);
      
         
     }
    

    
    function deleteindiv($id,$compete){

	$this->request->allowMethod(['post', 'deleteindiv']);
	
    
        // On prend l'inscription
    $inscription = $this->InscriptionCompetitions->get($id);
        
        // Si le competiteur est inscrit en individuel ET en équipe
        if($inscription['participation_indiv'] == 1 && $inscription['participation_equipe'] == 1) {
            
            // on enlève juste sa participation en individuel
            
	$upd_inscro = TableRegistry::get('InscriptionCompetitions');
			$query = $upd_inscro->query();
			$query->update()
   			 ->set(['participation_indiv' => 0])
   		 	->where(['id' => $id])
    		->execute();      
            
              $this->Flash->success('L\'inscription a été supprimée');
              return $this->redirect(['action'=>'inscriptions',$compete]);
        }
        
        // Sinon, on supprime totalement l'inscription
        
        elseif($inscription['participation_indiv'] == 1 && $inscription['participation_equipe'] == 0) {
        
        
    if ($supprime = $this->InscriptionCompetitions->delete($inscription)) {
    
	$this->Flash->success('L\'inscription a été supprimée');
		
        return $this->redirect(['action'=>'inscriptions',$compete]);
	}
				else {

		$this->Flash->error('L\'inscription n\'a pu être supprimée');
		return $this->redirect(['action'=>'inscriptions',$compete]);
		  }
	   }
	
    }
    
    
     function deleteequipe($id,$compete){

	$this->request->allowMethod(['post', 'deleteequipe']);
	
    
        // On prend l'inscription
    $inscription = $this->InscriptionCompetitions->get($id);
        
        // Si le competiteur est inscrit en individuel ET en équipe
        if($inscription['participation_indiv'] == 1 && $inscription['participation_equipe'] == 1) {
            
            // on enlève juste sa participation en individuel
            
	$upd_inscro = TableRegistry::get('InscriptionCompetitions');
			$query = $upd_inscro->query();
			$query->update()
   			 ->set(['participation_equipe' => 0])
   		 	->where(['id' => $id])
    		->execute();     
            $this->Flash->success('L\'inscription a été supprimée');
              return $this->redirect(['action'=>'inscriptions',$compete]);
        }
        
        // Sinon, on supprime totalement l'inscription
        
        elseif($inscription['participation_indiv'] == 0 && $inscription['participation_equipe'] == 1) {
        
        
    if ($supprime = $this->InscriptionCompetitions->delete($inscription)) {
    
	$this->Flash->success('L\'inscription a été supprimée');
		
        return $this->redirect(['action'=>'inscriptions',$compete]);
	}
				else {

		$this->Flash->error('L\'inscription n\'a pu être supprimée');
		return $this->redirect(['action'=>'inscriptions',$compete]);
		  }
	   }
	
    }
    
    
    
      function deleteadmin($id,$compete){

	$this->request->allowMethod(['post', 'deleteadmin']);
	
    $this->loadModel('InscriptionAdministratifs');
        // On prend l'inscription
    $inscription = $this->InscriptionAdministratifs->get($id);
        
        // On la supprime
        
    if ($supprime = $this->InscriptionAdministratifs->delete($inscription)) {
    
	$this->Flash->success('L\'inscription a été supprimée');
		
        return $this->redirect(['action'=>'inscriptions',$compete]);
	}
				else {

		$this->Flash->error('L\'inscription n\'a pu être supprimée');
		return $this->redirect(['action'=>'inscriptions',$compete]);
		  }
	   }
	
    
    
    
    
    
	// la variable category détermine si on est sur une catégorie spécifique ou sur le général
	
    
    public function organisateur($id,$category=null)
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
        
        
        // anti-hack, seul le créateur de l'événement peut voir les inscriptions
        if($user_id !== $event['user_id'])
            
        {
            
            $this->Flash->error('Vous n\'êtes pas autorisé à accéder à cette section.');

            $this->redirect($this->referer());
            
        }
        
        
         $title = $event['name'];
         $description = $event['name'];
        
     
        
        $this->set('title', $title);
        $this->set('description', $description);
        
          
         if(!empty($event['image'])) { $headimg = 'headers/evenements/l-'.$event['image']; }else { $headimg =  'header_main.png';}
         
         
          $this->set('headimg',$headimg);
          $this->set('event',$event);
        
        
       
		$this->set('category',$category);
		
        
		
		
 	// Si on n'a pas de catégorie spécifiée, on prend tout
		if($category == null) {
		
            $articles = $this->InscriptionCompetitions->find('all')
         ->where(['competition_id'=>$event['competition']['id'],'participation_indiv'=>'1'])
			->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
    }]);
		
            
            

            
		
       // Sinon, on prend que les inscros de la caté qui nous intéresse
        
        }
        
       else {
           
           
              
                //Si on est dans les excellences femmes
		if($category == 7) {
			
            // On prend les espoirs (id = 3) en plus des femmes excellence(id =7)
             
              $articles = $this->InscriptionCompetitions->find('all')
        ->where(['category_id'=>$category, 'competition_id'=>$event['competition']['id'],'participation_indiv'=>'1'])
        ->orWhere(['competition_id'=>$event['competition']['id'],'category_id'=>'3','surclassement_age'=>'1','participation_indiv'=>'1'])
        ->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
			 }]);
            
      
			
        }
		

           
           //Si on est dans les honneurs hommes
		elseif($category == 10) {
			
            // On prend les juniors non surclassés en grade (id=5) et les honneurs hommes (id = 10)
            
			  
              $articles = $this->InscriptionCompetitions->find('all')
         ->where(['category_id'=>$category,'surclassement_grade'=>'0', 'competition_id'=>$event['competition']['id'],'participation_indiv'=>'1'])
        ->orWhere(['category_id'=>'5','surclassement_age'=>'1','surclassement_grade'=>'0','participation_indiv'=>1])
        ->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
			 }]);
            
           
            
		}
           
        
		
		// Si on est dans les excellences hommes
		elseif($category == 11) {
			
             
            // On prend les juniors surclassés en grade et age (id=5), les honneurs hommes surclassés (id=10) et les excellences hommes (id=11)
    
            	  
              $articles = $this->InscriptionCompetitions->find('all')
         ->where(['category_id'=>$category, 'competition_id'=>$event['competition']['id'],'participation_indiv'=>'1'])
        ->orWhere([ 'competition_id'=>$event['competition']['id'],'surclassement_grade'=>'1','participation_indiv'=>'1'])
        
        ->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
			 }]);
          
            
		}
           
           // Si c'est une caté sans surclassement possible

           else {
           
           
		    $articles = $this->InscriptionCompetitions->find('all')
         ->where(['category_id'=>$category, 'competition_id'=>$event['competition']['id'],'participation_indiv'=>'1'])
			->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
			 }]);
				$this->set('articles',$articles);
               }
               
               
           // On prend également les données de la catégorie présente
           
          $category_info = $this->InscriptionCompetitions->Categories->find('all')
               ->where(['id'=>$category])
               ->first();
		
           $this->set('category_info',$category_info);
                       
           
        	
                      
       }
		
			$this->set('articles',$articles);   
	
 
        
    }
	
	
	
	// Fonction csv à partir du plug in
	public function export($id,$category=null) {
		
         $user_id =  $this->Auth->User('id');
        
		$this->response->download('export.csv');
	
		
 	// Si on n'a pas de catégorie spécifiée, on prend tout
		if($category == null) {
		
            $data = $this->InscriptionCompetitions->find('all')
         ->where(['competition_id'=>$id,'participation_indiv'=>'1'])
			->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
    }]);
		
            
            
            $name = 'Tous';
            
		
       // Sinon, on prend que les inscros de la caté qui nous intéresse
        
        }
        
       else {
           
           // Pour avoir le nom de la catégorie
           
          $cate = $this->InscriptionCompetitions->Categories->find('all')
               ->where(['id'=>$category])
               ->first();
           
           $name = $cate['name'];
           
           
                //Si on est dans les excellences femmes
		if($category == 7) {
			
            // On prend les espoirs (id = 3) en plus des femmes excellence(id =7)
             
              $data = $this->InscriptionCompetitions->find('all')
        ->where(['category_id'=>$category, 'competition_id'=>$id,'participation_indiv'=>'1'])
        ->orWhere(['competition_id'=>$id,'category_id'=>'3','surclassement_age'=>'1','participation_indiv'=>'1'])
        ->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
			 }]);
            
      
			
        }
		

           
           //Si on est dans les honneurs hommes
		elseif($category == 10) {
			
            // On prend les juniors non surclassés en grade (id=5) et les honneurs hommes (id = 10)
            
			  
              $data = $this->InscriptionCompetitions->find('all')
         ->where(['category_id'=>$category, 'surclassement_grade'=>'0','competition_id'=>$id,'participation_indiv'=>'1'])
        ->orWhere(['category_id'=>'5','surclassement_age'=>'1','surclassement_grade'=>'0','participation_indiv'=>1])
        ->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
			 }]);
            
           
            
		}
           
        
		
		// Si on est dans les excellences hommes
		elseif($category == 11) {
			
             
            // On prend les juniors surclassés en grade et age (id=5), les honneurs hommes surclassés (id=10) et les excellences hommes (id=11)
    
            	  
              $data = $this->InscriptionCompetitions->find('all')
         ->where(['category_id'=>$category, 'competition_id'=>$id,'participation_indiv'=>'1'])
        ->orWhere([ 'competition_id'=>$id,'surclassement_grade'=>'1','participation_indiv'=>'1'])
        ->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
			 }]);
          
            
		}
           
           // Si c'est une caté sans surclassement possible

           else {
           
           
		    $data = $this->InscriptionCompetitions->find('all')
         ->where(['category_id'=>$category, 'competition_id'=>$id,'participation_indiv'=>'1'])
			->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
			 }]);
				
               }
                     
       }
		
        
		foreach($data as $datas){
            
         
           
            $datas['nom'] = $datas['licency']['nom'];
            $datas['prenom'] = $datas['licency']['prenom'];
            $datas['sexe'] = $datas['licency']['sexe'];
            $datas['ddn'] = $datas['licency']['ddn'];
            $datas['category'] = $datas['category']['name'];
            $datas['grade'] = str_replace('è','e',$datas['licency']['grade']['name']);
            $datas['club'] = $datas['licency']['club']['name'];
            
            if($datas['surclassement_grade']== 1 OR $datas['surclassement_age'] == 1) {
                
                $datas['surclasse'] = 'X';
                
            }else {$datas['surclasse'] = '';}
            
           
        }
        
       
        
       
        
		
		// Données à envoyer au plugin
		 $_serialize = 'data';
		 
		 // Choix du délimitant du csv pour lecture correcte en excel
    	 $_delimiter = ';'; 
    	 
    	 // colonnes sélectionnées
    	 $_extract = array( 'nom', 'prenom','sexe','grade','ddn','category_id','surclasse','club');
		
		// Nom des colonnes
		 $_header = [ 'Nom', 'Prenom','Sexe','Grade','Annee de naissance','Categorie','Surclasse','club'];
		
		$this->set(compact('data', '_serialize', '_extract', '_delimiter','_header'));		
		$this->viewBuilder()->className('CsvView.Csv');
		
		$this->response->download($name.'.csv');
	}

	
	
	
    
    
	// Fonction pour contrôler les inscriptions
	public function equipes($id) {
        
        
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
        
          
         if(!empty($event['image'])) { $headimg = 'headers/evenements/l-'.$event['image']; }else { $headimg =  'header_main.png';}
         
         
          $this->set('headimg',$headimg);
          $this->set('event',$event);
        
        
       

		
            $articles = $this->InscriptionCompetitions->find('all')
         ->where(['InscriptionCompetitions.competition_id'=>$id,'participation_equipe'=>'1'])
                ->order(['equipe_id'=>'ASC'])
			->contain(['Equipes','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
    }]);
		
            
            
	$this->set('articles',$articles);
	
	}
    
    
    
    
    
    
    	// Fonction csv à partir du plug in
	public function exportequipe($id) {
		
         $user_id =  $this->Auth->User('id');
        
		$this->response->download('export.csv');
	
        $name = 'Equipes';
		
 	  $data = $this->InscriptionCompetitions->find('all')
         ->where(['InscriptionCompetitions.competition_id'=>$id,'participation_equipe'=>'1'])
                ->order(['equipe_id'=>'ASC'])
			->contain(['Equipes','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
    }]);
		
		
        
		foreach($data as $datas){
            
         
           
            $datas['nom'] = $datas['licency']['nom'];
            $datas['prenom'] = $datas['licency']['prenom'];
            $datas['sexe'] = $datas['licency']['sexe'];
            $datas['ddn'] = $datas['licency']['ddn'];
            $datas['grade'] = str_replace('è','e',$datas['licency']['grade']['name']);
            $datas['club'] = $datas['licency']['club']['name'];
            $datas['equipe'] = strtoupper($datas['equipe']['name']);
            
            if($datas['surclassement_grade']== 1 OR $datas['surclassement_age'] == 1) {
                
                $datas['surclasse'] = 'X';
                
            }else {$datas['surclasse'] = '';}
            
           
        }
        
       
        
       
        
		
		// Données à envoyer au plugin
		 $_serialize = 'data';
		 
		 // Choix du délimitant du csv pour lecture correcte en excel
    	 $_delimiter = ';'; 
    	 
    	 // colonnes sélectionnées
    	 $_extract = array( 'equipe','nom', 'prenom','sexe','grade','ddn','surclasse','club');
		
		// Nom des colonnes
		 $_header = [ 'Equipe','Nom', 'Prenom','Sexe','Grade','Annee de naissance','Surclasse','club'];
		
		$this->set(compact('data', '_serialize', '_extract', '_delimiter','_header'));		
		$this->viewBuilder()->className('CsvView.Csv');
		
		$this->response->download($name.'.csv');
	}

	
	
	
    
	
    
    
	
	// Fonction pdf, marche comme la csv
	
	public function view($id,$category=null){
	
	
			
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
        
          
         if(!empty($event['image'])) { $headimg = 'headers/evenements/l-'.$event['image']; }else { $headimg =  'header_main.png';}
         
         
          $this->set('headimg',$headimg);
          $this->set('event',$event);
        
        
       
		$this->set('category',$category);
		
        
		
		
 	// Si on n'a pas de catégorie spécifiée, on prend tout
		if($category == null) {
		
            $articles = $this->InscriptionCompetitions->find('all')
         ->where(['competition_id'=>$event['competition']['id'],'participation_indiv'=>'1'])
			->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
    }]);
		
            
            
            $name = 'Tous';
            
		
       // Sinon, on prend que les inscros de la caté qui nous intéresse
        
        }
        
       else {
           
           
         
              
                //Si on est dans les excellences femmes
		if($category == 7) {
			
            // On prend les espoirs (id = 3) en plus des femmes excellence(id =7)
             
              $articles = $this->InscriptionCompetitions->find('all')
        ->where(['category_id'=>$category, 'competition_id'=>$event['competition']['id'],'participation_indiv'=>'1'])
        ->orWhere(['competition_id'=>$event['competition']['id'],'category_id'=>'3','surclassement_age'=>'1','participation_indiv'=>'1'])
        ->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
			 }]);
            
      
			
        }
		

           
           //Si on est dans les honneurs hommes
		elseif($category == 10) {
			
            // On prend les juniors non surclassés en grade (id=5) et les honneurs hommes (id = 10)
            
			  
              $articles = $this->InscriptionCompetitions->find('all')
         ->where(['category_id'=>$category,'surclassement_grade'=>'0', 'competition_id'=>$event['competition']['id'],'participation_indiv'=>'1'])
        ->orWhere(['category_id'=>'5','surclassement_age'=>'1','surclassement_grade'=>'0','participation_indiv'=>1])
        ->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
			 }]);
            
           
            
		}
           
        
		
		// Si on est dans les excellences hommes
		elseif($category == 11) {
			
             
            // On prend les juniors surclassés en grade et age (id=5), les honneurs hommes surclassés (id=10) et les excellences hommes (id=11)
    
            	  
              $articles = $this->InscriptionCompetitions->find('all')
         ->where(['category_id'=>$category, 'competition_id'=>$event['competition']['id'],'participation_indiv'=>'1'])
        ->orWhere([ 'competition_id'=>$event['competition']['id'],'surclassement_grade'=>'1','participation_indiv'=>'1'])
        
        ->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
			 }]);
          
            
		}
           
           // Si c'est une caté sans surclassement possible

           else {
           
           
		    $articles = $this->InscriptionCompetitions->find('all')
         ->where(['category_id'=>$category, 'competition_id'=>$event['competition']['id'],'participation_indiv'=>'1'])
			->contain(['Categories','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
			 }]);
				$this->set('articles',$articles);
               }
               
               
           // On prend également les données de la catégorie présente
           
          $category_info = $this->InscriptionCompetitions->Categories->find('all')
               ->where(['id'=>$category])
               ->first();
		
           $this->set('category_info',$category_info);
                       
           
             $name = $category_info['name'];
        	
                      
       }
		
			$this->set('articles',$articles);   
	
    
		
	
	$this->set('filename',$name);
		

	
	
}
    
    
    
    	public function viewequipes($id){
            
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
        
          
         if(!empty($event['image'])) { $headimg = 'headers/evenements/l-'.$event['image']; }else { $headimg =  'header_main.png';}
         
         
          $this->set('headimg',$headimg);
          $this->set('event',$event);
        
        
       

		
            $articles = $this->InscriptionCompetitions->find('all')
         ->where(['InscriptionCompetitions.competition_id'=>$id,'participation_equipe'=>'1'])
                ->order(['equipe_id'=>'ASC'])
			->contain(['Equipes','Licencies'=> function($q) {
        return $q->contain(['Clubs','Grades']);
    }]);
		
            
            
	$this->set('articles',$articles);
            
              $name = 'Equipes';
    
    $this->set('filename',$name);
    
        }
    
  
}
?>
