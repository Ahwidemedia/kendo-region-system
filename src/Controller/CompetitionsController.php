<?php



namespace App\Controller;

use Cake\ORM\Table;
use App\Controller;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Http\Response;

class CompetitionsController extends AppController
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

$this->Auth->allow(['creation']);


$title = 'Création de compétition';
$description = 'Création de compétitions';

$this->set('title', $title);
$this->set('description', $description);

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
