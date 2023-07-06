<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;


class DirMaterialTable extends Table
{
    
    // set default connection string
    public static function defaultConnectionName(): string {
        return Configure::read('conn');
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dir_material');
        $this->setDisplayField('material_sn');
        $this->setPrimaryKey('material_sn');

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
            ->integer('material_sn')
            ->allowEmptyString('material_sn', null, 'create');

        $validator
            ->scalar('material_def')
            ->requirePresence('material_def', 'create')
            ->notEmptyString('material_def', __('Material def cannot be empty'));

        return $validator;
    }

    public function postDataValidationMasters($forms_data)
    {
        $returnValue = 1;

        $materialDef = $forms_data['material_def'];
        $materialUnit = $forms_data['material_unit'];
        
        if (strlen($forms_data['material_def']) > 50) {
            $returnValue = null;
        }
        if (strlen($forms_data['material_unit']) > 10) {
            $returnValue = null;
        }

        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['material_def'])) {
            $returnValue = null;
        }

        if (!preg_match("/^[a-zA-Z]+$/", $forms_data['material_unit'])) {
            $returnValue = null;
        }
        return $returnValue;
    }
}
