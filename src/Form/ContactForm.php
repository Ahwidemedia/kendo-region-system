<?php namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class ContactForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('name', 'string')
            ->addField('email', ['type' => 'string'])
            ->addField('body', ['type' => 'text']);
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator->add('username', 'length', [
                'rule' => ['minLength', 10],
                'message' => 'Un nom est requis'
            ])->add('email', 'format', [
                'rule' => 'email',
                'message' => 'Une adresse email valide est requise',
            ])
            ->notEmpty('message', ['message'=>'Vous devez remplir ce champ'])
                ->allowEmpty('test')
    ->add('test', 'custom', ['rule' => ['inList', ['4','four','quatre'],false], 'Vous n\'avez pas rempli le captcha correctement'])
	;
    }

    protected function _execute(array $data)
    {
        // Envoie un email.
        return true;
    }
}

;?>