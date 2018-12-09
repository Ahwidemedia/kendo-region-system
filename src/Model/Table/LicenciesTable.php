<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Licencies Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clubs
 * @property \Cake\ORM\Association\BelongsTo $GradeActuels
 * @property \Cake\ORM\Association\BelongsTo $Disciplines
 *
 * @method \App\Model\Entity\Licency get($primaryKey, $options = [])
 * @method \App\Model\Entity\Licency newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Licency[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Licency|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Licency patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Licency[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Licency findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LicenciesTable extends Table
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

        $this->table('licencies');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clubs', [
            'foreignKey' => 'club_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Grades', [
            'foreignKey' => 'grade_id'
        ]);
        $this->belongsTo('Disciplines', [
            'foreignKey' => 'discipline_id',
            'joinType' => 'INNER'
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
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        $validator
            ->requirePresence('prenom', 'create')
            ->notEmpty('prenom');

        $validator
            ->requirePresence('ddn', 'create')
            ->notEmpty('ddn');

        $validator
            ->date('date_naissance')
            ->allowEmpty('date_naissance');

        $validator
            ->allowEmpty('lieu_naissance');

        $validator
            ->allowEmpty('adresse');

        $validator
            ->requirePresence('sexe', 'create')
            ->notEmpty('sexe');

        $validator
            ->allowEmpty('numero_licence');

        $validator
            ->allowEmpty('nationalite');

        $validator
            ->allowEmpty('telephone');

        $validator
            ->allowEmpty('fax');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->allowEmpty('grade_actuel_lieux');

        $validator
            ->allowEmpty('grade_actuel_organisation');

        $validator
            ->date('grade_actuel_date')
            ->allowEmpty('grade_actuel_date');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['club_id'], 'Clubs'));
        $rules->add($rules->existsIn(['grade_actuel_id'], 'Grades'));
        $rules->add($rules->existsIn(['discipline_id'], 'Disciplines'));

        return $rules;
    }
}
