<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;


class DirExtraMineralTable extends Table
{
    
    // set default connection string
    public static function defaultConnectionName(): string {
        return Configure::read('conn');
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dir_extra_mineral');
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
            ->scalar('mineral_name')
            ->requirePresence('mineral_name', 'create')
            ->notEmptyString('mineral_name', __('mineral name cannot be empty'));

        $validator
            ->scalar('unit_code')
            ->requirePresence('unit_code', 'create')
            ->notEmptyString('unit_code', __('Unit code cannot be empty'));

        return $validator;
    }

    public function postDataValidationMasters($forms_data)
    {
        $returnValue = 1;

        $mineralName = $forms_data['mineral_name'];
        $unitCode = $forms_data['unit_code'];

        if ($forms_data['mineral_name'] == '') {
            $returnValue = null;
        }
        if ($forms_data['unit_code'] == '') {
            $returnValue = null;
        }

        if (strlen($forms_data['mineral_name']) > 20) {
            $returnValue = null;
        }
        if (strlen($forms_data['unit_code']) > 10) {
            $returnValue = null;
        }

        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['mineral_name'])) {
            $returnValue = null;
        }

        if (!preg_match("/^[a-zA-Z]+$/", $forms_data['unit_code'])) {
            $returnValue = null;
        }
        return $returnValue;
    }
}
