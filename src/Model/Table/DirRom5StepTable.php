<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;


class DirRom5StepTable extends Table
{
    
    // set default connection string
    public static function defaultConnectionName(): string {
        return Configure::read('conn');
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dir_rom_5_step');
        $this->setDisplayField('rom_5_step_sn');
        $this->setPrimaryKey('rom_5_step_sn');

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
            ->integer('rom_5_step_sn')
            ->allowEmptyString('rom_5_step_sn', null, 'create');

        $validator
            ->scalar('rom_5_step_def')
            ->requirePresence('rom_5_step_def', 'create')
            ->notEmptyString('rom_5_step_def', __('Rom 5 step cannot be empty'));

        return $validator;
    }

    public function postDataValidationMasters($forms_data)
    {
        $returnValue = 1;

        $romStepDef = $forms_data['rom_5_step_def'];

        if ($forms_data['rom_5_step_def'] == '') {
            $returnValue = null;
        }
        if (strlen($forms_data['rom_5_step_def']) > 20) {
            $returnValue = null;
        }
        if (!preg_match('/^[a-zA-Z0-9-\s]+$/', $forms_data['rom_5_step_def'])) {
            $returnValue = null;
        }
        return $returnValue;
    }
}
