<?php



namespace App\Controller;

use Cake\ORM\Table;
use App\Controller;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Http\Response;

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
    
    
     public function show($id)
    {
    
   $article = $this->loadModel('Competitions');
		$this->Competitions->find('all')
		->where(['id'=>$id])
		->first();
 
 		if(!empty($article['image'])) {
 
 		 $this->set('headimg', $article['image']);
 
 		}
 		
 		else {
 		
 		
        $this->set('headimg','header_main.png');
 
 		}
    }
    


    function inscriptions() {
	
	$article = $this->Inscriptions->newEntity();
	$this->set('article',$article);


    $this->set('clubs', $this->Inscriptions->Clubs->find('list')->order(['name'=>'ASC']));
	    
  

		// Quand on a une requête
		
	if($this->request->is(['patch','post','put'])){
	

	$data = $this->request->data;	


	// Si la case "Je ne vois pas mon club" a été cochée
	
	if($data['new_club'] == 1) {
	
	$club = $this->Inscriptions->Clubs->newEntity();
	$club->name = $data['club_name'];
	$result_club = $this->Inscriptions->Clubs->save($club);
	
		$data['club_id'] = $result_club['id'];
	
	}
		
	
		
		
		// Pour chaque inscrit
		
		foreach($data['inscrits'] as $key => $value) {
	
		// On retransforme les data "year de cakephp pour les placer au bon niveau
		$values = $value['age']['year'];
		$certifs = $value['certif_medical']['year'];
		
		$data['inscrits'][$key]['age'] = $values;
		$data['inscrits'][$key]['certif_medical'] = $certifs;	
		
		
		// Si ce n'est pas un nouveau club, on prend l'id de la liste de selection
		if($data['new_club'] == 0) {
		$data['inscrits'][$key]['club_id'] = $data['club_id'];
		} else {
		
		// Sinon on prend le result id du club plus haut
		$data['inscrits'][$key]['club_id'] = $result_club['id'];
		}
		
		// On attribue les catégories en fonction de l'année de naissance
		
		$this->loadModel('Categories');
		
		$categories = $this->Categories->find('all');
		
		foreach($categories as $category) {
		
		
			// Si la catégorie est mixte, cad pour les enfants
			if($category['sexe'] == 'X') {
		
				// On attribue la catégorie en fonction de l'age seulement en testant que la date de naissance
				// se trouve bien entre l'année de début et l'année de fin dans la catégorie
		
				if($data['inscrits'][$key]['age'] >= $category['annee_debut']  && $data['inscrits'][$key]['age'] <= $category['annee_fin']) {
		
					$data['inscrits'][$key]['category_id'] = $category['id'];
		
				}
		
		// Si on est dans une catégorie qui distingue homme et femmes (à partir de cadets / espoirs)
		
			} else {
		
		// S'il n'y a pas de distincition de grade pour ces catés (cadets/espoirs/juniors)
		
			if($category['grade_debut'] == 0) {
		
				
		// On ne prend en compte que la différence de sexe et l'année de naissance
		
				if($data['inscrits'][$key]['age'] >= $category['annee_debut']  
				   && $data['inscrits'][$key]['age'] <= $category['annee_fin']
				   && $data['inscrits'][$key]['sexe'] == $category['sexe']) {
		
					$data['inscrits'][$key]['category_id'] = $category['id'];
		
				}
		
			}
		
			
		// Pour les adultes, on va regarder le grade pour distinguer kyu/honneur/excellences
		
		else {

		
		if($data['inscrits'][$key]['age'] >= $category['annee_debut'] && $data['inscrits'][$key]['age'] <= $category['annee_fin'] && $data['inscrits'][$key]['sexe'] == $category['sexe'] && $data['inscrits'][$key]['grade'] >= $category['grade_debut'] && $data['inscrits'][$key]['grade'] <= $category['grade_fin'] ) {
		
		
		
		$data['inscrits'][$key]['category_id'] = $category['id'];
		
				
				}
			
		
			}
		
		
			}
		
		}
			
		}
	
	// On enregistre l'inscriptions (avec date et heure), plus toutes les données associées (inscrits) 
		
    $entity = $this->Inscriptions->patchEntity($article, $data, ['associated' => ['Clubs','Inscrits']]);
    

	
    
 
     $result =  $this->Inscriptions->save($entity,['associated'=>['Clubs','Inscrits']]);

    
    
         if ($result) {
	$this->Flash->success('Les inscriptions ont bien été envoyées');
		return $this->redirect(['action'=>'index']);
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
