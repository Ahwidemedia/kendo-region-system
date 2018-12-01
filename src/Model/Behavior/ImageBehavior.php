<?php

namespace App\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class ImageBehavior extends Behavior

{

 public function afterSave($event, $entity, $options)
{
 


	if(!empty($entity['imagef']['tmp_name'])){
	
	 function crop($img,$dest,$largeur=0,$hauteur=0){
    
  $dimension=getimagesize($img);
       
        $ratio = $dimension[0] / $dimension[1];
        // Création des miniatures
        if($largeur==0 && $hauteur==0){ $largeur = $dimension[0]; $hauteur = $dimension[1]; }
          else if($hauteur==0){ $hauteur = round($largeur / $ratio); }
        else if($largeur==0){ $largeur = round($hauteur * $ratio); }

		if($dimension[0]>($largeur/$hauteur)*$dimension[1] ){ $dimY=$hauteur; $dimX=round($hauteur*$dimension[0]/$dimension[1]);}
		if($dimension[0]<($largeur/$hauteur)*$dimension[1]){ $dimX=$largeur; $dimY=round($largeur*$dimension[1]/$dimension[0]);}
		if($dimension[0]==($largeur/$hauteur)*$dimension[1]){ $dimX=$largeur; $dimY=$hauteur;}

        if($dimension[0]>($largeur/$hauteur)*$dimension[1] ){ $dimY=$hauteur; $dimX=round($hauteur*$dimension[0]/$dimension[1]); $decalX=($dimX-$largeur)/2; $decalY=0;}
        if($dimension[0]<($largeur/$hauteur)*$dimension[1]){ $dimX=$largeur; $dimY=round($largeur*$dimension[1]/$dimension[0]); $decalY=($dimY-$hauteur)/2; $decalX=0;}
        if($dimension[0]==($largeur/$hauteur)*$dimension[1]){ $dimX=$largeur; $dimY=$hauteur; $decalX=0; $decalY=0;}
        $miniature =imagecreatetruecolor ($largeur,$hauteur);
        if(substr($img,-4)==".jpg" || substr($img,-4)==".JPG"){$image = imagecreatefromjpeg($img); }
        if(substr($img,-4)==".png" || substr($img,-4)==".PNG"){$image = imagecreatefrompng($img); }
        if(substr($img,-4)==".gif" || substr($img,-4)==".GIF"){$image = imagecreatefromgif($img); }
		if(substr($img,-5)==".jpeg" || substr($img,-5)==".JPEG"){$image = imagecreatefromjpeg($img); }

        imagecopyresampled($miniature,$image,-$decalX,-$decalY,0,0,$dimX,$dimY,$dimension[0],$dimension[1]);
        imagejpeg($miniature,$dest,90);
        
        return true;
	} 

	
			
			$slug = $entity->slug;
			$alias = $event->subject()->alias();
			$alias = strtolower($alias);
		
			$f = explode('.',$entity['imagef']['name']);
			$ext = '.'.end($f);
			$directory ='img/headers/'.$alias.'/';
          
          if(!file_exists($directory))
        	mkdir($directory, 0777);
            move_uploaded_file($entity['imagef']['tmp_name'], $directory . DS . $entity['id'].'-'.$slug .$ext);
             
			foreach(Configure::read('Media.formats') as $k=>$v){
					$prefix = $k;
					$size = explode('x',$v);
					crop( $directory . DS . $entity['id'].'-'.$slug .$ext, $directory . DS . $prefix.'-'.$entity['id'].'-'.$slug.$ext,$size[0],$size[1]); 
			}
           
           $illustration = $entity['id'].'-'.$slug .$ext;
           $id = $entity['id'];
           
         
            $entities = $this->_table->query();
			
			$entities->update()
   			 ->set(['image' => $illustration])
   		 	->where(['id' => $id])
    		->execute();      
            
		} 
	
	}

  
}

?>