<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;


class McpDepositTable extends Table
{
    
    // set default connection string
    public static function defaultConnectionName(): string {
        return Configure::read('conn');
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('mcp_deposit');
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
            ->scalar('mine_code')
            ->requirePresence('mine_code', 'create')
            ->notEmptyString('mine_code', __('Mine code cannot be empty'));

        $validator
            ->integer('deposit_sn')
            ->requirePresence('deposit_sn', 'create')
            ->notEmptyString('deposit_sn', __('Deposit Sn cannot be empty'));

        $validator
            ->scalar('ts_comtx_dataeposit_name')
            ->requirePresence('ts_comtx_dataeposit_name', 'create')
            ->notEmptyString('ts_comtx_dataeposit_name', __('ts_comtx_dataeposit_name cannot be empty'));

        $validator
            ->scalar('commodity_name')
            ->requirePresence('commodity_name', 'create')
            ->notEmptyString('commodity_name', __('Commodity name cannot be empty'));

        $validator
            ->integer('deposit_no')
            ->requirePresence('deposit_no', 'create')
            ->notEmptyString('deposit_no', __('Deposit no cannot be empty'));

        $validator
            ->integer('block_no')
            ->requirePresence('block_no', 'create')
            ->notEmptyString('block_no', __('Block no cannot be empty'));

        $validator
            ->integer('strike_length')
            ->requirePresence('strike_length', 'create')
            ->notEmptyString('strike_length', __('Strike length cannot be empty'));

        $validator
            ->integer('dip_amount')
            ->requirePresence('dip_amount', 'create')
            ->notEmptyString('dip_amount', __('Dip amount cannot be empty'));

        $validator
            ->integer('dip_direction')
            ->requirePresence('dip_direction', 'create')
            ->notEmptyString('dip_direction', __('Dip direction cannot be empty'));

        $validator
            ->integer('width')
            ->requirePresence('width', 'create')
            ->notEmptyString('width', __('Width cannot be empty'));

        $validator
            ->integer('depth')
            ->requirePresence('depth', 'create')
            ->notEmptyString('depth', __('Depth cannot be empty'));

        return $validator;
    }

    public function postDataValidationMasters($forms_data)
    {
        $returnValue = 1;

        $mineCode = $forms_data['mine_code'];
        $depositSn = $forms_data['deposit_sn'];
        $tsComTx = $forms_data['ts_comtx_dataeposit_name'];
        $commodityName = $forms_data['commodity_name'];
        $despositNo = $forms_data['deposit_no'];
        $blockNo = $forms_data['block_no'];
        $strike = $forms_data['strike_length'];
        $ampount = $forms_data['dip_amount'];
        $direction = $forms_data['dip_direction'];
        $width = $forms_data['width'];
        $depth = $forms_data['depth'];

        if ($forms_data['mine_code'] == '') {
            $returnValue = null;
        }
        if (strlen($forms_data['mine_code']) > 20) {
            $returnValue = null;
        }
        if (strlen($forms_data['deposit_sn']) > 2) {
            $returnValue = null;
        }
        if (strlen($forms_data['ts_comtx_dataeposit_name']) > 40) {
            $returnValue = null;
        }
        if (strlen($forms_data['commodity_name']) >20) {
            $returnValue = null;
        }
        if (strlen($forms_data['deposit_no']) > 11) {
            $returnValue = null;
        }
        if (strlen($forms_data['block_no']) > 6) {
            $returnValue = null;
        }
        if (strlen($forms_data['strike_length']) > 20) {
            $returnValue = null;
        }
        if (strlen($forms_data['dip_amount']) > 6) {
            $returnValue = null;
        }
        if (strlen($forms_data['dip_direction']) > 9) {
            $returnValue = null;
        }
        if (strlen($forms_data['width']) > 11) {
            $returnValue = null;
        }
        if (strlen($forms_data['depth']) > 11) {
            $returnValue = null;
        }


        if (!preg_match('/^[a-zA-Z0-9]+$/', $forms_data['mine_code'])) {
            $returnValue = null;
        }
        if (!preg_match("/^[0-9]+$/", $forms_data['deposit_sn'])) {
            $returnValue = null;
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $forms_data['ts_comtx_dataeposit_name'])) {
            $returnValue = null;
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $forms_data['commodity_name'])) {
            $returnValue = null;
        }
        if (!preg_match('/^[0-9]+$/', $forms_data['deposit_no'])) {
            $returnValue = null;
        }
        if (!preg_match('/^[0-9]+$/', $forms_data['block_no'])) {
            $returnValue = null;
        }
        if (!preg_match('/^[0-9]+$/', $forms_data['strike_length'])) {
            $returnValue = null;
        }
        if (!preg_match('/^[0-9]+$/', $forms_data['dip_amount'])) {
            $returnValue = null;
        }
        if (!preg_match('/^[0-9]+$/', $forms_data['dip_direction'])) {
            $returnValue = null;
        }
        if (!preg_match('/^[0-9]+$/', $forms_data['width'])) {
            $returnValue = null;
        }
        if (!preg_match('/^[0-9]+$/', $forms_data['depth'])) {
            $returnValue = null;
        }

        return $returnValue;
    }
}
