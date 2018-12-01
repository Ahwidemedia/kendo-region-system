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
class DisciplinesTable extends Table
{




 public function initialize(array $config)
    {
           $this->belongsTo('Licencies');
           $this->hasMany('Competitions');
           
       	 
    }



}
?>
