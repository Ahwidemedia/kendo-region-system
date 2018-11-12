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
class InscritsTable extends Table
{




 public function initialize(array $config)
    {
           $this->belongsTo('Clubs');
           $this->belongsTo('Inscriptions');
           $this->belongsTo('Categories');
           
        
       	  $this->belongsTo('Users');
         
         $this->addBehavior('Timestamp');
         
      
    
      	 
    }


public function validationDefault(Validator $validator)
    {
    $validator
	->notEmpty('name', 'Entrer un titre d\'article');
	
   return $validator;
        
        }
        
        
  





}
?>
