<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;


class DirConcentrateTable extends Table
{

    // set default connection string
    public static function defaultConnectionName(): string {
        return Configure::read('conn');
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dir_concentrate');
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
            ->scalar('type_concentrate')
            ->requirePresence('type_concentrate', 'create')
            ->notEmptyString('type_concentrate', __('Type Concenrate cannot be empty'));

        return $validator;
    }

    public function postDataValidationMasters($forms_data)
    {
        $returnValue = 1;

        $typeConcenrate = $forms_data['type_concentrate'];

        if ($forms_data['type_concentrate'] == '') {
            $returnValue = null;
        }
        if (strlen($forms_data['type_concentrate']) > 20) {
            $returnValue = null;
        }
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['type_concentrate'])) {
            $returnValue = null;
        }
        return $returnValue;
    }
}
