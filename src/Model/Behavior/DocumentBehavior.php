<?php

namespace App\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class DocumentBehavior extends Behavior

{

 public function afterSave($event, $entity, $options)
{
 


	if(!empty($entity['documentf']['tmp_name'])){
	
			debug($entity);
			$slug = $entity->slug;
			$alias = $event->subject()->alias();
			$alias = strtolower($alias);
		
			$f = explode('.',$entity['documentf']['name']);
			$ext = '.'.end($f);
			$directory ='files/'.$alias.'/';
          
          if(!file_exists($directory))
        	mkdir($directory, 0777);
            move_uploaded_file($entity['documentf']['tmp_name'], $directory . DS . $entity['id'].'-'.$alias.'-'.$slug .$ext);
             
           
           $document = $entity['id'].'-'.$alias.'-'.$slug .$ext;
           $id = $entity['id'];
           
         
            $entities = $this->_table->query();
			
			$entities->update()
   			 ->set(['document' => $document])
   		 	->where(['id' => $id])
    		->execute();      
            
		} 
	
	}

  
}

?>