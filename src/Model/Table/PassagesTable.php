<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Passages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Disciplines
 * @property \Cake\ORM\Association\BelongsTo $Evenements
 * @property \Cake\ORM\Association\HasMany $InscriptionPassages
 *
 * @method \App\Model\Entity\Passage get($primaryKey, $options = [])
 * @method \App\Model\Entity\Passage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Passage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Passage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Passage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Passage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Passage findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PassagesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('passages');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Disciplines', [
            'foreignKey' => 'discipline_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Evenements', [
            'foreignKey' => 'evenement_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('InscriptionPassages', [
            'foreignKey' => 'passage_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->date('date_passage')
            ->requirePresence('date_passage', 'create')
            ->notEmpty('date_passage');

        $validator
            ->allowEmpty('lieux');

        $validator
            ->allowEmpty('description');

        $validator
            ->integer('archive')
            ->requirePresence('archive', 'create')
            ->notEmpty('archive');

        $validator
            ->date('date_desactivation')
            ->allowEmpty('date_desactivation');

        $validator
            ->allowEmpty('document');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['discipline_id'], 'Disciplines'));
        $rules->add($rules->existsIn(['evenement_id'], 'Evenements'));

        return $rules;
    }
}
