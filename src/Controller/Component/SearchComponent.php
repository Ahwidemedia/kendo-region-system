<?php

namespace App\Controller\Component;
use Cake\Controller\Component;


class SearchComponent extends Component  {
	
	function advanced($articles,$data){
    
      $articles->hydrate(false);
$articles->toList();

$articlis = array();

foreach($articles as $article) {

foreach($data as $search_term) {

$search_term = mb_strtolower($search_term);
$name = mb_strtolower($article['name']);

$titre = 0;

if(strpos($name,$search_term) !== false) {

$titre = 50;

}

$controller = $this->request->params['controller'];

if($controller == 'Recettes') {
$description = mb_strtolower($article['description']);

if(strpos($description,$search_term) !== false) {

$titre += 50;

	}
}

preg_match_all('/<([^\s>]+)(.*?)>((.*?)<\/\1>)?|(?<=^|>)(.+?)(?=$|<)/i',$article['content'],$result);




$result = $result[0];

$h2 = 0;
$h3 = 0;
$p = 0;
$count = 0;

foreach($result as $resulti) {

$resulti = mb_strtolower($resulti);

$count = substr_count($resulti, $search_term);


if(strpos($resulti,'</h2>') !== false && strpos($resulti,$search_term) !== false) { $h2 += 1 * $count; }
	
if(strpos($resulti,'</h3>') !== false && strpos($resulti,$search_term)  !== false) { $h3 += 1 * $count; }

if((strpos($resulti,'</p>') !== false OR strpos($resulti,'</table>') !== false OR strpos($resulti,'</li>') !== false) && strpos($resulti,$search_term) !== false) { $p += 1 * $count; }

	}
}


$coeff =  $titre + ($h2 * 10) + ($h3 * 5) + ($p);

$article['coeff'] = $coeff;
 if($coeff > 1) {
$articlis[] = $article;
	}




}

if($articlis !== null) {

usort($articlis, function($a, $b) {
    return $b['coeff'] - $a['coeff'];
});


}

       
       
        return $articlis;
	}
}
?>