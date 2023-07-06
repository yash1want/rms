<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;


class DirSmelterStepTable extends Table
{
    
    // set default connection string
    public static function defaultConnectionName(): string {
        return Configure::read('conn');
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dir_smelter_step');
        $this->setDisplayField('smelter_step_sn');
        $this->setPrimaryKey('smelter_step_sn');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('smelter_step_sn')
            ->allowEmptyString('smelter_step_sn', null, 'create');

        $validator
            ->scalar('smelter_step_def')
            ->requirePresence('smelter_step_def', 'create')
            ->notEmptyString('smelter_step_def', __('Smelter Def cannot be empty'));

        return $validator;
    }

    public function postDataValidationMasters($forms_data)
    {
        $returnValue = 1;

        $commodityName = $forms_data['smelter_step_def'];

        if ($forms_data['smelter_step_def'] == '') {
            $returnValue = null;
        }
        if (strlen($forms_data['smelter_step_def']) > 100) {
            $returnValue = null;
        }
        if (!preg_match('/^[a-zA-Z0-9()\s]+$/', $forms_data['smelter_step_def'])) {
            $returnValue = null;
        }
        return $returnValue;
    }

}
