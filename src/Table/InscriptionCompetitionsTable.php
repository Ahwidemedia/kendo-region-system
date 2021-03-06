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
class InscriptionCompetitionsTable extends Table
{




 public function initialize(array $config)
    {
           $this->belongsTo('Licencies',['foreignKey' => 'licencie_id']);
           $this->belongsTo('Clubs',['foreignKey' => 'club_id']);
           $this->belongsTo('Grades',['foreignKey' => 'grade_id']);
           $this->belongsTo('Equipes',['foreignKey' => 'equipe_id']);
           $this->belongsTo('Categories',['foreignKey' => 'category_id']);
        
       	   $this->belongsTo('Users');
         
           $this->addBehavior('Timestamp');
        
      
    
      	 
    }




}
?>
