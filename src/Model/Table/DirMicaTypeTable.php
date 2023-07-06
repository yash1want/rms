<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;


class DirMicaTypeTable extends Table
{
    
    // set default connection string
    public static function defaultConnectionName(): string {
        return Configure::read('conn');
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dir_mica_type');
        $this->setDisplayField('mica_sn');
        $this->setPrimaryKey('mica_sn');

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
            ->integer('mica_sn')
            ->allowEmptyString('mica_sn', null, 'create');

        $validator
            ->scalar('mica_def')
            ->requirePresence('mica_def', 'create')
            ->notEmptyString('mica_def', __('Mica def cannot be empty'));

        return $validator;
    }

    public function postDataValidationMasters($forms_data)
    {
        $returnValue = 1;

        $micaDef = $forms_data['mica_def'];

        if (strlen($forms_data['mica_def']) > 100) {
            $returnValue = null;
        }
        if (!preg_match('/^[a-zA-Z0-9().\s]+$/', $forms_data['mica_def'])) {
            $returnValue = null;
        }
        return $returnValue;
    }
}
