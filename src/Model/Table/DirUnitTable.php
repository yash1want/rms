<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;


class DirUnitTable extends Table
{
    
    // set default connection string
    public static function defaultConnectionName(): string {
        return Configure::read('conn');
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dir_unit');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('unit_code')
            ->requirePresence('unit_code', 'create')
            ->notEmptyString('unit_code', __('unit code cannot be empty'));

        $validator
            ->scalar('unit_def')
            ->requirePresence('unit_def', 'create')
            ->notEmptyString('unit_def', __('Unit def cannot be empty'));

        return $validator;
    }

    public function postDataValidationMasters($forms_data)
    {
        $returnValue = 1;

        $unitCode = $forms_data['unit_code'];

        if ($forms_data['unit_code'] == '') {
            $returnValue = false;
        }
        if (strlen($forms_data['unit_code']) > 50) {
            $returnValue = false;
        }
        if (!preg_match('/^[a-zA-Z% ]+$/', $forms_data['unit_code'])) {
            $returnValue = false;
        }
		
        return $returnValue;
    }
}
