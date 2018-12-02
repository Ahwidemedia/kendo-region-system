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
class InscriptionAdministratifsTable extends Table
{




 public function initialize(array $config)
    {
           $this->belongsTo('Licencies',['foreignKey' => 'licencie_id']);
           $this->belongsTo('Competitions');
		   $this->belongsTo('Users');
         
           $this->addBehavior('Timestamp');
        
      
    
      	 
    }




}
?>
