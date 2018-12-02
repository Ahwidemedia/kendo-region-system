<?php



namespace App\Controller;

use Cake\ORM\Table;
use App\Controller;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Http\Response;

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
 debug("ok");die;
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
    
 


    function inscriptions($id) {
	
        
        // On prend les données de l'événement
        
        
        $this->loadModel('Evenements');
        
        $event = $this->Evenements->find('all')
            ->contain('Competitions')
            ->matching('Competitions')
            ->first();
        
            debug($event);die();
            
        // On envoie article pour que le Form soit lié à la table InscriptionCompetition
    
        $article = $this->InscriptionCompetitions->newEntity();
        
        
        // Envoie de l'image, dépend de si y en a une uploadée ou pas
        
         if(!empty($event['image'])) { $headimg = 'headers/evenements/g-'.$event['image']; }else { $headimg =  'header_main.png';}
         
         
          $this->set('headimg',$headimg);
          $this->set('event',$event);
          $this->set('article',$article);
        
        
       
        // Si l'utilisateur est connecté
        
        if($this->Auth->User('id') !== null){
            
        
            // On récupère son id
            
        $user_id = $this->Auth->User('id');
         
            
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
        
       
              
       // Je vais mettre toutes les variables communes
                
    $data['new_club'] = $datai['new_club'];
    $data['licencie']['club_id'] = $datai['club_id'];
    $data['commentaire'] = $datai['commentaire'];    
    $data['competition_id'] = $event['competition']['id'];  
    $data['user_id'] = $user_id;
        
	
	// Je remets les années de cakephp au carré
		$data['certificat'] = $data['certificat']['year'];
		$data['licencie']['ddn'] = $data['licencie']['ddn']['year'];
		$data['licencie']['discipline_id'] = $event['discipline_id'];
     
		
		
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
		
					$data['licencie']['category_id'] = $category['id'];
		
				}
		
		// Si on est dans une catégorie qui distingue homme et femmes (à partir de cadets / espoirs)
		
			} else {
		
		// S'il n'y a pas de distincition de grade pour ces catés (cadets/espoirs/juniors)
		
			if($category['grade_debut'] == 0) {
		
				
		// On ne prend en compte que la différence de sexe et l'année de naissance
		
				if($data['licencie']['ddn'] >= $category['annee_debut']  
				   && $data['licencie']['ddn'] <= $category['annee_fin']
				   && $data['licencie']['sexe'] == $category['sexe']) {
		
					$data['licencie']['category_id'] = $category['id'];
		
				}
		
			}
		
			
		// Pour les adultes, on va regarder le grade pour distinguer kyu/honneur/excellences
		
		else {

		
		if($data['licencie']['ddn'] >= $category['annee_debut'] && $data['licencie']['ddn'] <= $category['annee_fin'] && $data['licencie']['sexe'] == $category['sexe'] && $data['licencie']['grade_id'] >= $category['grade_debut'] && $data['licencie']['grade_id'] <= $category['grade_fin'] ) {
		
		
		
		$data['licencie']['category_id'] = $category['id'];
		
				
				        }
			 
		          } 
			
            }
		
		
         }
		
    
        // Si ce n'est pas un nouveau licencié      
        
        if($data['licencie']['id'] !== '') {
        
            // Je cherche le licencié concerné dans la base
           
        $licencie = $this->InscriptionCompetitions->Licencies->find('all')
           ->Where(['id'=>$data['licencie']['id']])
           ->first();
            
            // Je prépare pour la mise à jour
             $newlicencie = $licencie;
        }
        
      
        else {
            
            // Sinon, j'en créé un nouveau
          
            $newlicencie = $this->InscriptionCompetitions->Licencies->newEntity();
           
           
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
                $entity_equipe->competition_id = 3;
                $result_equipe = $this->InscriptionCompetitions->Equipes->save($entity_equipe);
              
                   
                    
                    // Pour chaque inscrit en equipe
                    foreach($datae['licencie'] as $datao) {
                        
                    if($datao['nom'] !== '') {
                      
                        // Je vérifie si c'est une mise à jour ou une nouvelle
                       
                         if($datao['id'] !== '') {
                        
                        $licencio = $this->InscriptionCompetitions->Licencies->find('all')
                        ->Where(['id'=>$datao['id']])
                        ->first();
                        
                        $inscri = $licencio;
                             
                        
                         } else {
                        
                          // S'il n'existe pas, je le créé
                      
                        
                        $inscri = $this->InscriptionCompetitions->Licencies->newEntity();   
                      
                         
                             
                       }
                             
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
                            
                           
                       
                        // Sinon, je créé l'inscription en mettant à 1 la participation
                        } else {
                            
                            // Sinon je cree l'inscription
                            
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
               
              
                 // Je vérifie s'il existe ou pas
                        $licencio = $this->InscriptionCompetitions->Licencies->find('all')
                        ->where(['numero_licence'=>$dataa['licencie']['numero_licence']])
                        ->first();
                        
                        $result_inscro = $licencio;
                        
                     
                        
                          // S'il n'existe pas, je le créé
                        if(empty($licencio)) {
                            
                     
                            
                        $inscri = $this->InscriptionCompetitions->Licencies->newEntity();
                        
                            $entity_inscro = $this->InscriptionCompetitions->Licencies->patchEntity($inscri,$dataa['licencie']);
                        
                            $entity_inscro->discipline_id = $event['competition']['discipline_id'];
                            $entity_inscro->club_id = $datai['club_id'];
                            
                            $result_inscro = $this->InscriptionCompetitions->Licencies->save($entity_inscro);
                
                               
                        }          
                        
                       // Je créé ensuite l'inscription administrative
                        
                        $this->loadModel('InscriptionAdministratifs');
                        
                        if(!empty($dataa['id'])) {
                
                       $inscru = $this->InscriptionAdministratifs->find('all')
                           ->where(['id'=>$dataa['id']])
                           ->first();
                            
                        } else {
                            
                            
                            $inscru = $this->InscriptionAdministratifs->newEntity();
                            
                        }
                
                        
                        
                        $entity_inscru = $this->InscriptionAdministratifs->patchEntity($inscru,$dataa);
                            
                        $entity_inscru->licencie_id = $result_inscro['id'];
                        $entity_inscru->competition_id = $id;
                        $entity_inscru->user_id = $user_id;
                       
                        
                        
                        if(isset($dataa['Commissaires'])) {
                            
                         $entity_inscru->commissaire = 1;
                            
                        }
                
                        if(isset($dataa['Arbitres'])) {
                        
                            $entity_inscru->arbitre = 1;
                        }
                
                
                        // 1 va représenter la présence le 1er jour
                        // 2 va représenter la présence le 2ème jour
                        // 12 la présence les 2 jours
                
                        if($dataa['samedi'] == 1 && $dataa['dimanche'] == 0 ) {
                        
                            $entity_inscru->presence = 1;
                       
                        }elseif ($dataa['samedi'] == 0 && $dataa['dimanche'] == 1 ) {
                            
                            $entity_inscru->presence = 2;
                        } elseif ($dataa['samedi'] == 1 && $dataa['dimanche'] == 1 ){
                           
                            $entity_inscru->presence = 12;
                            
                        }
                
                        
                        
                        
                       
                    
                        $result_inscru = $this->InscriptionAdministratifs->save($entity_inscru);
                     
                            
                        }
                            
                
                
                
                
                
            }
            
        
        
    
         if (isset($result) OR isset($result_inscru)) {
             
	$this->Flash->success('Les inscriptions ont bien été envoyées');
		return $this->redirect($this->referer());
	}
				else {
	
	$this->Flash->error('Il y a eu une erreur et les inscriptions n\'ont pu être envoyées.');

                    
                }
		}

       	
	

}

    
    
    
    
    
    
    
    
	// la variable category détermine si on est sur une catégorie spé ou sur le général
	public function organisateur($category=null)
    {
		
		$this->set('category',$category);
		
		
		
		// Junior + Junior & Honneurs + Junior & Excellence
		if($category == 6) {
			
			$category = array('11','6','12');
		}
		
		
		// Junior + Junior & Honneurs 
		if($category == 7) {
			
			$category = array('11','7');
		}
		
		
		// Excellence + Junior & Excellence 
		if($category == 8) {
			
			$category = array('12','8');
		}
		
		
		// Espoir + Espoir & Femme 
		if($category == 5) {
			
			$category = array('14','5');
		}
		
		
		// Femmes + Espoir & Femme 
		if($category == 10) {
			
			$category = array('14','10');
		}
		
		
 	// Si on n'a pas de catégorie spécifiée, on prend tout
		if($category == null) {
		$articles = $this->Inscriptions->find('all')
			->contain(['Inscrits'=> function($q) {
        return $q->contain(['Categories','Clubs']);
    }]);
		}
		
		
		// Si on a plus d'une catégorie (gamin surclassé), on prend les 2 catégories dans lesquelles il apparait
		elseif(isset($category[1])) {
			
			$articles = $this->Inscriptions->find('all')
			->contain(['Inscrits'=> function(\Cake\ORM\Query $q) use ($category)  {
        return $q->contain('Clubs','Categories')
			->where(['Inscrits.category_id IN'=>$category]);		
		}]);
			
		}
		else {
			
			// Sinon, on prend la catégorie correspondante
		$articles = $this->Inscriptions->find('all')
			->contain(['Inscrits'=> function(\Cake\ORM\Query $q) use ($category)  {
        return $q->contain('Clubs','Categories')->where(['Inscrits.category_id'=>$category]);
    }]);	
			
			
		}
		
			
		$this->set('articles',$articles);
 
    }
	
	
	
	// Fonction csv à partir du plug in
	public function export($category=null) {
		
		$this->response->download('export.csv');
	
	
	// Former le le nom de la catégorie
		 if($category !== null) {
	
	if($category == 13) {$name = 'Catégorie -Poussins';}
	if($category == 1) {$name = 'Catégorie -Samourais';}
	if($category == 2) {$name = 'Catégorie -Benjamins';}
	if($category == 3) {$name = 'Catégorie -Minimes';}
	if($category == 4) {$name = 'Catégorie -Cadets';}
	if($category == 5) {$name = 'Catégorie -Juniors';}
	if($category == 6) {$name = 'Catégorie -Espoirs';}
	if($category == 7) {$name = 'Catégorie -Honneurs';}
	if($category == 8) {$name = 'Catégorie -Excellences';}
	if($category == 9) {$name = 'Catégorie -Kyusha';}
	if($category == 10) {$name = 'Catégorie -Femmes';}
		} else {
		
		$name = 'Toutes les catégories';
		
		}
		
		// Junior + Junior & Honneurs + Junior & Excellence
		if($category == 6) {
			
			$category = array('11','6','12');
		}
		
		
		// Junior + Junior & Honneurs 
		if($category == 7) {
			
			$category = array('11','7');
		}
		
		
		// Excellence + Junior & Excellence 
		if($category == 8) {
			
			$category = array('12','8');
		}
		
		
		// Espoir + Espoir & Femme 
		if($category == 5) {
			
			$category = array('14','5');
		}
		
		
		// Femmes + Espoir & Femme 
		if($category == 10) {
			
			$category = array('14','10');
		}
		
		
		
		// Si on a pas de catégories, on prend tout
		if($category == null) {
		
			$data = $this->Inscriptions->Inscrits->find('all')
			->contain('Categories','Clubs')
    		->toArray();
		
			 
		}
		
		// Si on a 2 catégories (surclassement, combat dans les deux catés)
		
			elseif(isset($category[1])) {
			
			$data = $this->Inscriptions->Inscrits->find('all')
			->contain('Categories','Clubs')
			->where(['Inscrits.category_id IN'=>$category])
			->toArray();	
	
			
		}
		else {
			
			
			// Si cela ne correspond qu'à une seule catégorie
			$data = $this->Inscriptions->Inscrits->find('all')
			->contain('Categories')
			->contain('Clubs')	
			->where(['Inscrits.category_id'=>$category])
			->toArray();
	}
			
		
		
		
		foreach($data as $datas) {
			
			$datas['category_id'] = $datas['category']['name'];
			$datas['club_id'] = $datas['club']['name'];
			
			// On retranscrit les grades en nom pour le tableau
	if($datas['grade'] == -10) {$datas['grade'] = '10ème Kyu';}
			elseif($datas['grade'] == -10) {$datas['grade'] = '10eme Kyu';}
			elseif($datas['grade'] == -9) {$datas['grade'] = '9eme Kyu';}
			elseif($datas['grade'] == -8) {$datas['grade'] = '8eme Kyu';}
			elseif($datas['grade'] == -7) {$datas['grade'] = '7eme Kyu';}
			elseif($datas['grade'] == -6) {$datas['grade'] = '6eme Kyu';}
			elseif($datas['grade'] == -5) {$datas['grade'] = '5eme Kyu';}
			elseif($datas['grade'] == -4) {$datas['grade'] = '4eme Kyu';}
			elseif($datas['grade'] == -3) {$datas['grade'] = '3eme Kyu';}
			elseif($datas['grade'] == -2) {$datas['grade'] = '2eme Kyu';}
			elseif($datas['grade'] == -1) {$datas['grade'] = '1er Kyu';}
			elseif($datas['grade'] == 1) {$datas['grade'] = '1er Dan';}
			elseif($datas['grade'] == 2) {$datas['grade'] = '2eme Dan';}
			elseif($datas['grade'] == 3) {$datas['grade'] = '3eme Dan';}
			elseif($datas['grade'] == 4) {$datas['grade'] = '4eme Dan';}
			elseif($datas['grade'] == 5) {$datas['grade'] = '5eme Dan';}
			elseif($datas['grade'] == 6) {$datas['grade'] = '6eme Dan';}
			elseif($datas['grade'] == 7) {$datas['grade'] = '7eme Dan';}
	
			
	// On retransmet le nom des catégories à partir de l'id
	if($datas['category_id'] == 13) {$datas['category_id'] = 'Poussins';}
	if($datas['category_id'] == 1) {$datas['category_id'] = 'Samourais';}
	if($datas['category_id'] == 2) {$datas['category_id'] = 'Benjamins';}
	if($datas['category_id'] == 3) {$datas['category_id'] = 'Minimes';}
	if($datas['category_id'] == 4) {$datas['category_id'] = 'Cadets';}
	if($datas['category_id'] == 5) {$datas['category_id'] = 'Juniors';}
	if($datas['category_id'] == 6) {$datas['category_id'] = 'Espoirs';}
	if($datas['category_id'] == 7) {$datas['category_id'] = 'Honneurs';}
	if($datas['category_id'] == 8) {$datas['category_id'] = 'Excellences';}
	if($datas['category_id'] == 9) {$datas['category_id'] = 'Kyusha';}
	if($datas['category_id'] == 10) {$datas['category_id'] = 'Femmes';}
			
			
			// On va écrire s'il y a surclassement
			if($datas['surclassement_age'] == 1 OR $datas['surclassement_grade']== 1) {
				
				$datas['surclasse'] = 'Oui';
			}else {
				
				$datas['surclasse'] = 'Non';
				
			}
		
		
		}
		
		
		
		// Données à envoyer au plugin
		 $_serialize = 'data';
		 
		 // Choix du délimitant du csv pour lecture correcte en excel
    	 $_delimiter = ';'; 
    	 
    	 // colonnes sélectionnées
    	 $_extract = array( 'nom', 'prenom','sexe','grade','age','category_id','surclasse','club_id');
		
		// Nom des colonnes
		 $_header = [ 'Nom', 'Prenom','Sexe','Grade','Annee de naissance','Categorie','Surclasse','club'];
		
		$this->set(compact('data', '_serialize', '_extract', '_delimiter','_header'));		
		$this->viewBuilder()->className('CsvView.Csv');
		
		$this->response->download($name.'.csv');
	}

	
	
	
	// Fonction pour contrôler les inscriptions
	public function gestion() {
	
	$articles =	$this->Inscriptions->find('all')
	->contain(['Clubs', 'Inscrits' => function($q) {
    $q->select([
         'Inscrits.id',
		 'Inscrits.inscription_id',
         'count' => $q->func()->count('*')])
		 ->group(['inscription_id']);


    return $q;
}]);
	
	$this->set('articles',$articles);
	
	}
	
	
	// Fonction pdf, marche comme la csv
	
	public function view($category=null){
	
	
		$category_id = $category;
		
		$this->set('category',$category);
		
		
		// Junior + Junior & Honneurs + Junior & Excellence
		if($category == 6) {	$category = array('11','6','12');}
		
		
		// Junior + Junior & Honneurs 
		if($category == 7) {	$category = array('11','7');}
		
		
		// Excellence + Junior & Excellence 
		if($category == 8) {			$category = array('12','8');	}
		
		
		// Espoir + Espoir & Femme 
		if($category == 5) {		$category = array('14','5');}
		
		
		// Femmes + Espoir & Femme 
		if($category == 10) {	$category = array('14','10');	}
		
		
 	
		if($category == null) {
		$articles = $this->Inscriptions->find('all')
			->contain(['Inscrits'=> function($q) {
        return $q->contain(['Categories','Clubs']);
    }]);
		}
		
		elseif(isset($category[1])) {
			
			$articles = $this->Inscriptions->find('all')
			->contain(['Inscrits'=> function(\Cake\ORM\Query $q) use ($category)  {
        return $q->contain('Clubs','Categories')
			->where(['Inscrits.category_id IN'=>$category]);		
		}]);
			
		}
		else {
			
		$articles = $this->Inscriptions->find('all')
			->contain(['Inscrits'=> function(\Cake\ORM\Query $q) use ($category)  {
        return $q->contain('Clubs','Categories')->where(['Inscrits.category_id'=>$category]);
    }]);	
			
			
		}
		
			
		$this->set('articles',$articles);
	
		
		
		 if($category !== null) {
	
	if($category_id == 13) {$name = 'Catégorie - Poussins';}
	if($category_id == 1) {$name = 'Catégorie - Samourais';}
	if($category_id == 2) {$name = 'Catégorie - Benjamins';}
	if($category_id == 3) {$name = 'Catégorie - Minimes';}
	if($category_id == 4) {$name = 'Catégorie - Cadets';}
	if($category_id == 5) {$name = 'Catégorie - Juniors';}
	if($category_id == 6) {$name = 'Catégorie - Espoirs';}
	if($category_id == 7) {$name = 'Catégorie - Honneurs';}
	if($category_id == 8) {$name = 'Catégorie - Excellences';}
	if($category_id == 9) {$name = 'Catégorie - Kyusha';}
	if($category_id == 10) {$name = 'Catégorie - Femmes';}
		
		} else {
		
		$name = 'Toutes les catégories';
		
		}
		
	
	$this->set('filename',$name);
		

	
	
}
}
?>
