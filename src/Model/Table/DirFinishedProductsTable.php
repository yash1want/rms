<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;


class DirFinishedProductsTable extends Table
{
    
    // set default connection string
    public static function defaultConnectionName(): string {
        return Configure::read('conn');
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dir_finished_products');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }
    
    public function getFinishedProducts() {

        $query = $this->find()
                ->select(['f_products'])
                ->order(['f_products'=>'ASC'])
                ->toArray();
        
        $data = array();
        $i = 0;
        foreach ($query as $m) {
            $data[$m['f_products']] = $m['f_products'];
            $i++;
        }
        
        return $data;
        
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
            ->scalar('f_products')
            ->requirePresence('f_products', 'create')
            ->notEmptyString('f_products', __('Products cannot be empty'));

        return $validator;
    }

    public function postDataValidationMasters($forms_data)
    {
        $returnValue = 1;

        if (strlen($forms_data['f_products']) > 100) {
            $returnValue = null;
        }
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['f_products'])) {
            $returnValue = null;
        }
        return $returnValue;
    }

    public function checkIfALreadyExistFinishedProduct($f_product)
    {
        $query = $this->find()->select(['f_products'])->where(['f_products' => $f_product,'is_deleted' => 'no'])->first();
        
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

}
