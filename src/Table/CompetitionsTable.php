<?php
namespace App\Model\Table;
use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;





$validator = new Validator();
class CompetitionsTable extends Table
{




 public function initialize(array $config)
    {
           $this->belongsToMany('Categories');
            $this->belongsTo('Disciplines');
      
         
           $this->addBehavior('Timestamp');
           $this->addBehavior('Image');
           $this->addBehavior('Document');
            $this->addBehavior('Sluggable');
      
      
    
      	 
    }


public function validationDefault(Validator $validator)
    {
    $validator
	->notEmpty('name', 'Entrer le nom de votre événement');
	 
   return $validator;
        
        }
        
        
  


}
?>
