<?php
namespace App\Model\Table;
use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\Core\Configure;



class ClubsTable extends Table
{



 public function initialize(array $config)
    {
    
     parent::initialize($config);
     
        
        $this->hasMany('Inscrits');
        $this->hasMany('Inscriptions');
          
        
    }


}
?>
