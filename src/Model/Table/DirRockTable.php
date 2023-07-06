<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;


class DirRockTable extends Table
{
    
    // set default connection string
    public static function defaultConnectionName(): string {
        return Configure::read('conn');
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dir_rock');
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
            ->scalar('rock_code')
            ->requirePresence('rock_code', 'create')
            ->notEmptyString('rock_code', __('Rock code cannot be empty'));

        $validator
            ->scalar('rock_name')
            ->requirePresence('rock_name', 'create')
            ->notEmptyString('rock_name', __('Rock name cannot be empty'));

        return $validator;
    }

    public function postDataValidationMasters($forms_data)
    {
        $returnValue = 1;

        $rockCode = $forms_data['rock_code'];
        $rockName = $forms_data['rock_name'];

        if ($forms_data['rock_code'] == '') {
            $returnValue = null;
        }
        if ($forms_data['rock_name'] == '') {
            $returnValue = null;
        }

        if (strlen($forms_data['rock_code']) > 4) {
            $returnValue = null;
        }
        if (strlen($forms_data['rock_name']) > 50) {
            $returnValue = null;
        }

        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['rock_code'])) {
            $returnValue = null;
        }

        if (!preg_match("/^[a-zA-Z0-9\s]+$/", $forms_data['rock_name'])) {
            $returnValue = null;
        }
        return $returnValue;
    }
}
