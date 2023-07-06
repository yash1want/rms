<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;


class DirCommodityTable extends Table
{
    
    // set default connection string
    public static function defaultConnectionName(): string {
        return Configure::read('conn');
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dir_commodity');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'updated' => 'always'
                ]
            ]
        ]);
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
            ->scalar('commodity_name')
            ->requirePresence('commodity_name', 'create')
            ->notEmptyString('commodity_name', __('Commodity name cannot be empty'));

        $validator
            ->scalar('unit_code')
            ->requirePresence('unit_code', 'create')
            ->notEmptyString('unit_code', __('Unit code cannot be empty'));

        return $validator;
    }

    public function postDataValidationMasters($forms_data)
    {
        $returnValue = 1;

        $commodityName = $forms_data['commodity_name'];
        $unitCode = $forms_data['unit_code'];

        if ($forms_data['commodity_name'] == '') {
            $returnValue = null;
        }
        if ($forms_data['unit_code'] == '') {
            $returnValue = null;
        }

        if (strlen($forms_data['commodity_name']) > 20) {
            $returnValue = null;
        }
        if (strlen($forms_data['unit_code']) > 10) {
            $returnValue = null;
        }

        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['commodity_name'])) {
            $returnValue = null;
        }

        if (!preg_match("/^[a-zA-Z]+$/", $forms_data['unit_code'])) {
            $returnValue = null;
        }
        return $returnValue;
    }
}
