<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;


class DirExplosiveTable extends Table
{
    
    // set default connection string
    public static function defaultConnectionName(): string {
        return Configure::read('conn');
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dir_explosive');
        $this->setDisplayField('explosive_sn');
        $this->setPrimaryKey('explosive_sn');

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
            ->integer('explosive_sn')
            ->allowEmptyString('explosive_sn', null, 'create');

        $validator
            ->scalar('explosive_name')
            ->requirePresence('explosive_name', 'create')
            ->notEmptyString('explosive_name', __('explosive_name name cannot be empty'));

        $validator
            ->scalar('explosive_unit')
            ->requirePresence('explosive_unit', 'create')
            ->notEmptyString('explosive_unit', __('explosive_unit cannot be empty'));

        return $validator;
    }

    public function postDataValidationMasters($forms_data)
    {
        $returnValue = 1;

        $explosiveName = $forms_data['explosive_name'];
        $explosiveUnit = $forms_data['explosive_unit'];

        if ($forms_data['explosive_name'] == '') {
            $returnValue = null;
        }
        if ($forms_data['explosive_unit'] == '') {
            $returnValue = null;
        }

        if (strlen($forms_data['explosive_name']) > 50) {
            $returnValue = null;
        }
        if (strlen($forms_data['explosive_unit']) > 10) {
            $returnValue = null;
        }

        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['explosive_name'])) {
            $returnValue = null;
        }

        if (!preg_match("/^[a-zA-Z]+$/", $forms_data['explosive_unit'])) {
            $returnValue = null;
        }
        return $returnValue;
    }
}
