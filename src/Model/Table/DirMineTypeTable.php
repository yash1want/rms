<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;


class DirMineTypeTable extends Table
{

    // set default connection string
    public static function defaultConnectionName(): string {
        return Configure::read('conn');
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dir_mine_type');
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
            ->integer('form_type')
            ->requirePresence('form_type', 'create')
            ->notEmptyString('form_type', __('form type cannot be empty'));

        $validator
            ->scalar('form_def')
            ->requirePresence('form_def', 'create')
            ->notEmptyString('form_def', __('form def cannot be empty'));

        return $validator;
    }

    public function postDataValidationMasters($forms_data)
    {
        $returnValue = 1;

        $formType = $forms_data['form_type'];
        $formDef = $forms_data['form_def'];

        if ($forms_data['form_type'] == '') {
            $returnValue = null;
        }
        if (strlen($forms_data['form_type']) > 4) {
            $returnValue = null;
        }
        if (strlen($forms_data['form_def']) > 50) {
            $returnValue = null;
        }
        if (!is_numeric($forms_data['form_type'])) {
			$returnValue = null;
		}
        if (!preg_match('/^[0-9]+$/', $forms_data['form_type'])) {
            $returnValue = null;
        }
        if (!preg_match("/^[a-zA-Z0-9\s]+$/", $forms_data['form_def'])) {
            $returnValue = null;
        }
        return $returnValue;
    }

}
