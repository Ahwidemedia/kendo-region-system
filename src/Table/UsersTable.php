<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\ORM\Rule\IsUnique;
use Cake\Auth\DefaultPasswordHasher;


$validator = new Validator();
class UsersTable extends Table
{


 public function initialize(array $config)
    {
        
        $this->addBehavior('Timestamp');
          
    }


public function validationDefault(Validator $validator)
    {
    
    
    $validator
	->notEmpty('username', 'Entrer un nom d\'utilisateur')
	->add('username', 'length', ['rule' => ['lengthBetween', 4, 30],  'message' => 'Le nom d\'utilisateur doit être compris entre 4 et 30 caractères.'])
	->add('password', 'length', ['rule' => ['lengthBetween', 8, 30],  'message' => 'Le mot de passe doit être compris entre 8 et 30 caractères.'])
	->notEmpty('password', 'Merci d\'indiquer votre mot de passe')
	->allowEmpty('lastname', 'Merci d\'indiquer votre nom')
	->allowEmpty('firstname', 'Merci d\'indiquer votre prénom')
	->notEmpty('email', 'Merci d\'indiquer votre adresse e-mail')
	->notEmpty('mail', 'Merci d\'indiquer votre adresse e-mail')
	
	->add('passwordconfirm',[
                'match'=>[
                    'rule'=> ['compareWith','password'],
                    'message'=>'Les mots de passe ne correspondent pas.',
                ]
            ])    
            
    ->add('passwordconfirme',[
                'match'=>[
                    'rule'=> ['compareWith','finalpassword'],
                    'message'=>'Les mots de passe ne correspondent pas.',
                ]
            ]) 
    ->allowEmpty('test')
    ->add('test', 'custom', ['rule' => ['inList', ['4','four','quatre'],false], 'Vous n\'avez pas rempli le captcha correctement'])
	 ->add('username', 'validFormat',[
                'rule' => array('custom', '/^[a-z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ .\-]+$/i'),
                'message' => 'Votre nom d\'utilisateur ne peut pas contenir de caractères spéciaux'
        ])
    ->add('email', 'validFormat', [
        'rule' => 'email',
        'message' => 'Le format de l\'email que vous avez rentré n\'est pas valide'
    ])
     ->add('mail', 'validFormat', [
        'rule' => 'email',
        'message' => 'Le format de l\'email que vous avez rentré n\'est pas valide'
    ])
     ->allowEmpty('avatarf')
    ->add('avatarf',  'mimeType', [
   'rule' => ['mimeType', ['image/jpg', 'image/png', 'image/jpeg', 'image/gif']],
  'message' => 'Le format du fichier n\'est pas valide.'
    ])
    ->add('avatarf', [
                        'fileSize' => [
                                'rule' => [
                                    'fileSize', '<', '0.4MB'
                                ],
                                'message' => 'La taille de votre avatar ne doit pas dépasser les 400kos'
                            ]])
                            
     ->add('ancienpassword', 'custom', [
                    'rule' => 

                    function($value, $context) {
                        $query = $this->find()
                                ->where(['id' => $context['data']['id']])
                                ->first();

                        $data = $query->toArray();

                        return (new DefaultPasswordHasher)->check($value, $data['password']);
                    },
                    'message' => 'Le mot de passe actuel est incorrect'
                ])
                
             ->add('finalpassword', 'custom', [
                    'rule' => 

                    function($value, $context) {
                        $query = $this->find()
                                ->where(['id' => $context['data']['id']])
                                ->first();

                        $data = $query->toArray();

                        return (new DefaultPasswordHasher)->check($value, $data['password']);
                    },
                    'message' => 'Le mot de passe est invalide'
                ]);
                
     
   return $validator;
        
        }
        
        
                 public function buildRules(RulesChecker $rules)
    {
    $rules->add($rules->isUnique(['mail'], 'Il existe déjà un utilisateur avec cet email.'));
     $rules->add($rules->isUnique(['username'], 'Ce nom d\'utilisateur est déjà attribué.'));
         
        return $rules;
    }

  

}
?>
