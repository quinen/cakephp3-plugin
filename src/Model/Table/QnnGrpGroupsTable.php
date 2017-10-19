<?php
namespace Quinen\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QnnGrpGroups Model
 *
 *
 * @method \Quinen\Model\Entity\QnnGrpGroup get($primaryKey, $options = [])
 * @method \Quinen\Model\Entity\QnnGrpGroup newEntity($data = null, array $options = [])
 * @method \Quinen\Model\Entity\QnnGrpGroup[] newEntities(array $data, array $options = [])
 * @method \Quinen\Model\Entity\QnnGrpGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Quinen\Model\Entity\QnnGrpGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Quinen\Model\Entity\QnnGrpGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \Quinen\Model\Entity\QnnGrpGroup findOrCreate($search, callable $callback = null, $options = [])
 */
class QnnGrpGroupsTable extends Table
{
    use QnnTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('qnn_grp_groups');
        $this->setDisplayField('grp_name');
        $this->setPrimaryKey('grp_id');

        $this->hasMany('Users', [
            'foreignKey' => 'usr_grp_id',
            'joinType' => 'INNER',
            'className' => 'Quinen.QnnUsrUsers'
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
            ->scalar('grp_code')
            ->requirePresence('grp_code', 'create')
            ->notEmpty('grp_code')
            ->add('grp_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('grp_name')
            ->requirePresence('grp_name', 'create')
            ->notEmpty('grp_name');

        $validator
            ->dateTime('grp_dt_created')
            ->requirePresence('grp_dt_created', 'create')
            ->notEmpty('grp_dt_created');

        $validator
            ->dateTime('grp_dt_updated')
            ->requirePresence('grp_dt_updated', 'create')
            ->notEmpty('grp_dt_updated');

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
        $rules->add($rules->isUnique(['grp_code']));

        return $rules;
    }
}
