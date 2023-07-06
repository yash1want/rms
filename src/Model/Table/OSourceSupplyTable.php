<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
    use App\Controller\MonthlyController;
	use Cake\Datasource\ConnectionManager;
	class OSourceSupplyTable extends Table{

		var $name = "OSourceSupply";
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getAllData($formType, $retrunType, $returnDate, $end_user_id, $userType) {

            $query = $this->find('all')
                    ->where(['form_type'=>$formType])
                    ->where(['return_type'=>$retrunType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['end_user_id'=>$end_user_id])
                    ->where(['user_type'=>$userType])
                    ->toArray();

            /**
             * Commented below code to handle issue of undefined array for "TALC"
             * And add logic for fetching unit from "DirMeMineral" table which is used in form itself
             * @version 10th Dec 2021
             * @author Aniket Ganvir
             */
            // $dirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
            // $mineralUnit = $dirMcpMineral->getAllUnit();
            $dirMeMineral = TableRegistry::getTableLocator()->get('DirMeMineral');

            $count = count($query);
            $resultSet = array();
            $resultSet['totalCount'] = $count;
            for ($i = 0; $i < $count; $i++) {
                $resultSet['sour_indus_' . ($i + 1)] = $query[$i]['industry'];
                $resultSet['sour_name_add_' . ($i + 1)] = $query[$i]['ind_sup_name'];
                $resultSet['sour_mine_area_dist_' . ($i + 1)] = $query[$i]['ind_source_search'];
                $resultSet['sour_mine_area_' . ($i + 1)] = $query[$i]['ind_source_dd'];
                $resultSet['sour_ind_dis_' . ($i + 1)] = $query[$i]['ind_distance'];
                $resultSet['sour_qty_' . ($i + 1)] = $query[$i]['ind_quantity'];
                $resultSet['sour_price_' . ($i + 1)] = $query[$i]['ind_price'];
                $resultSet['sour_tran_mode_' . ($i + 1)] = $query[$i]['ind_trans_mode'];
                $resultSet['sour_tran_cost_' . ($i + 1)] = $query[$i]['ind_trans_cost'];
                $resultSet['sour_supplier_add_' . ($i + 1)] = $query[$i]['import_addr'];
                $resultSet['sour_cost_metric_' . ($i + 1)] = $query[$i]['import_cost'];
                $resultSet['sour_supplier_country_' . ($i + 1)] = $query[$i]['import_country'];
                $resultSet['sour_qty_purch_' . ($i + 1)] = $query[$i]['import_pur_quantity'];
                $resultSet['sour_mineral_' . ($i + 1)] = $query[$i]['ferroalloy'];
                // $resultSet['mineral_unit_' . ($i + 1)] = $mineralUnit[$query[$i]['ferroalloy']];
                $resultSet['mineral_unit_' . ($i + 1)] = $dirMeMineral->getMineralUnit($query[$i]['ferroalloy']);
            }

            /**
             * SET DEFAULT BLANK ARRAY IF THERE'S NO RECORDS IN DB
             * @version 10th Dec 2021
             * @author Aniket Ganvir
             */
            if ($count == 0) {
                $resultSet['totalCount'] = '1';
                $resultSet['sour_indus_1'] = '';
                $resultSet['sour_name_add_1'] = '';
                $resultSet['sour_mine_area_dist_1'] = '';
                $resultSet['sour_mine_area_1'] = '';
                $resultSet['sour_ind_dis_1'] = '';
                $resultSet['sour_qty_1'] = '';
                $resultSet['sour_price_1'] = '';
                $resultSet['sour_tran_mode_1'] = '';
                $resultSet['sour_tran_cost_1'] = '';
                $resultSet['sour_supplier_add_1'] = '';
                $resultSet['sour_cost_metric_1'] = '';
                $resultSet['sour_supplier_country_1'] = '';
                $resultSet['sour_qty_purch_1'] = '';
                $resultSet['sour_mineral_1'] = '';
                $resultSet['mineral_unit_1'] = '';
            }
            
            return $resultSet;

        }
        
        public function getRecordId($formType, $retrunType, $returnDate, $end_user_id, $userType) {

            $query = $this->find()
                    ->select(['id'])
                    ->where(['form_type'=>$formType])
                    ->where(['return_type'=>$retrunType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['end_user_id'=>$end_user_id])
                    ->toArray();

            $resultSet = Array();
            $rowCount = count($query);
            $resultSet['count'] = $rowCount;
            if ($rowCount > 0) {
                $resultSet['status'] = 1;
            } else {
                $resultSet['status'] = 0;
            }
            return $resultSet;

        }
            
        public function deleteRecordset($formType, $retrunType, $returnDate, $end_user_id, $userType) {

            $query = $this->query();
            $query->delete('O_SOURCE_SUPPLY')
                ->where(['form_type'=>$formType])
                ->where(['return_type'=>$retrunType])
                ->where(['return_date'=>$returnDate])
                ->where(['end_user_id'=>$end_user_id])
                ->where(['user_type'=>$userType])
                ->execute();

        }
        
	    public function saveFormDetails($params){

			$data = $this->postDataValidate($params);

			if ($data['dataStatus'] == 1) {

	        	$formType = $data['fType'];
	        	$returnType = $data['return_type'];
	        	$returnDate = $data['return_date'];
	        	$endUserId = $data['end_user_id'];
	        	$userType = $data['user_type'];

				$result = '1';
                
                $exsistanceCheck = $this->getRecordId($formType, $returnType, $returnDate, $endUserId, $userType);

                if ($exsistanceCheck['status'] == 1) {
                    $this->deleteRecordset($formType, $returnType, $returnDate, $endUserId, $userType);
                }

                $totalRecords = $data['source_of_supply_count'];
                for ($i = 1; $i <= $totalRecords; $i++) {

                    $newEntity = $this->newEntity(array(
                        'end_user_id' => $endUserId,
                        'form_type' => 'O',
                        'return_type' => $returnType,
                        'return_date' => $returnDate,
                        // 'mineral_name' => $mineral,
                        'industry' => $data['sour_indus_' . $i],
                        'ind_sup_name' => $data['sour_name_add_' . $i],
                        'ind_source_search' => $data['sour_mine_area_dist_' . $i],
                        'ind_source_dd' => $data['sour_mine_area_' . $i],
                        'ind_distance' => $data['sour_ind_dis_' . $i],
                        'ind_quantity' => $data['sour_qty_' . $i],
                        'ind_price' => $data['sour_price_' . $i],
                        'ind_trans_mode' => $data['sour_tran_mode_' . $i],
                        'ind_trans_cost' => $data['sour_tran_cost_' . $i],
                        'import_addr' => $data['sour_supplier_add_' . $i],
                        'import_cost' => $data['sour_cost_metric_' . $i],
                        'import_country' => $data['sour_supplier_country_' . $i],
                        'import_pur_quantity' => $data['sour_qty_purch_' . $i],
                        'ferroalloy' => $data['sour_mineral_' . $i],
                        'user_type' => $userType,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s')
                    ));
                    if($this->save($newEntity)){
                        //
                    } else {
                        $result = false;
                    }
                    
                }

			} else {
				$result = false;
			}

			return $result;

	    }

	    public function postDataValidate($params){
			
			$returnValue = 1;
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;

			if(empty($params['fType'])){ $returnValue = null; }
			if(empty($params['return_type'])){ $returnValue = null; }
			if(empty($params['return_date'])){ $returnValue = null; }
			if(empty($params['end_user_id'])){ $returnValue = null; }
			if(empty($params['user_type'])){ $returnValue = null; }
            
            $totalRecords = $params['source_of_supply_count'];
            if (is_numeric($totalRecords) && $totalRecords > 0) {
                for ($i = 1; $i <= $totalRecords; $i++) {
                    
                    $industry = $params['sour_indus_' . $i];
                    if (in_array($industry, array('imported', 'indigenous'))) {

                        if ($industry == 'indigenous') {
                            
                            $ferroalloy = $params['sour_mineral_' . $i];
                            if ($ferroalloy == '') { $returnValue = null; }

                            $ind_sup_name = $params['sour_name_add_' . $i];
                            if ($ind_sup_name != '') {
                                if (strlen($ind_sup_name) > 100) { $returnValue = null; }
                            } else { $returnValue = null; }
                            
                            $ind_source_search = $params['sour_mine_area_dist_' . $i];
                            if ($ind_source_search == '') { $returnValue = null; }
                            
                            $ind_source_dd = $params['sour_mine_area_' . $i];
                            if ($ind_source_dd != '') {
                                if (strlen($ind_source_dd) > 100) { $returnValue = null; }
                            } else { $returnValue = null; }
                            
                            $ind_distance = $params['sour_ind_dis_' . $i];
                            if ($ind_distance != '') {
                                $returnValue = ($validate->numeric($ind_distance) == false) ? null : $returnValue;
                                $returnValue = ($validate->chkFloatCharac($ind_distance, 3, 8) == false) ? null : $returnValue;
                                $returnValue = ($validate->chkDecimalPlaces($ind_distance, 3) == false) ? null : $returnValue;
                            } else { $returnValue = null; }
                            
                            $ind_quantity = $params['sour_qty_' . $i];
                            if ($ind_quantity != '') {
                                $returnValue = ($validate->numeric($ind_quantity) == false) ? null : $returnValue;
                                $returnValue = ($validate->chkFloatCharac($ind_quantity, 3, 19) == false) ? null : $returnValue;
                                $returnValue = ($validate->chkDecimalPlaces($ind_quantity, 3) == false) ? null : $returnValue;
                            } else { $returnValue = null; }
                            
                            $ind_price = $params['sour_price_' . $i];
                            if ($ind_price != '') {
                                $returnValue = ($validate->numeric($ind_price) == false) ? null : $returnValue;
                                $returnValue = ($validate->chkFloatCharac($ind_price, 2, 12) == false) ? null : $returnValue;
                                $returnValue = ($validate->chkDecimalPlaces($ind_price, 2) == false) ? null : $returnValue;
                            } else { $returnValue = null; }
                            
                            $ind_trans_mode = $params['sour_tran_mode_' . $i];
                            if ($ind_trans_mode == '') { $returnValue = null; }
                            
                            $ind_trans_cost = $params['sour_tran_cost_' . $i];
                            if ($ind_trans_cost != '') {
                                $returnValue = ($validate->numeric($ind_trans_cost) == false) ? null : $returnValue;
                                $returnValue = ($validate->chkFloatCharac($ind_trans_cost, 2, 8) == false) ? null : $returnValue;
                                $returnValue = ($validate->chkDecimalPlaces($ind_trans_cost, 2) == false) ? null : $returnValue;
                            } else { $returnValue = null; }

                            $params['sour_supplier_add_' . $i] = '';
                            $params['sour_cost_metric_' . $i] = '';
                            $params['sour_supplier_country_' . $i] = '';
                            $params['sour_qty_purch_' . $i] = '';

                        } else if ($industry == 'imported') {
                            
                            $ferroalloy = $params['sour_mineral_' . $i];
                            if ($ferroalloy == '') { $returnValue = null; }
                            
                            $import_addr = $params['sour_supplier_add_' . $i];
                            if ($import_addr != '') {
                                if (strlen($import_addr) > 100) { $returnValue = null; }
                            } else { $returnValue = null; }
                            
                            $import_cost = $params['sour_cost_metric_' . $i];
                            if ($import_cost != '') {
                                $returnValue = ($validate->numeric($import_cost) == false) ? null : $returnValue;
                                $returnValue = ($validate->chkFloatCharac($import_cost, 2, 12) == false) ? null : $returnValue;
                                $returnValue = ($validate->chkDecimalPlaces($import_cost, 2) == false) ? null : $returnValue;
                            } else { $returnValue = null; }
                            
                            $import_country = $params['sour_supplier_country_' . $i];
                            if ($import_country == '') { $returnValue = null; }
                            
                            $import_pur_quantity = $params['sour_qty_purch_' . $i];
                            if ($import_pur_quantity != '') {
                                $returnValue = ($validate->numeric($import_pur_quantity) == false) ? null : $returnValue;
                                $returnValue = ($validate->chkFloatCharac($import_pur_quantity, 3, 19) == false) ? null : $returnValue;
                                $returnValue = ($validate->chkDecimalPlaces($import_pur_quantity, 3) == false) ? null : $returnValue;
                            } else { $returnValue = null; }

                            $params['sour_name_add_' . $i] = '';
                            $params['sour_mine_area_dist_' . $i] = '';
                            $params['sour_mine_area_' . $i] = '';
                            $params['sour_ind_dis_' . $i] = '';
                            $params['sour_qty_' . $i] = '';
                            $params['sour_price_' . $i] = '';
                            $params['sour_tran_mode_' . $i] = '';
                            $params['sour_tran_cost_' . $i] = '';

                        }

                    } else {
                        $returnValue = null;
                    }

                }
            } else { $returnValue = null; }
            
            $params['dataStatus'] = $returnValue;
			
			return $params;
			
		}

		/**
		* Used to check for the final submit
		* Returns 1 if the form is filled
		* Returns 0 if the form is not filled
        * @version 10th Dec 2021
        * @author Aniket Ganvir
		*/
		public function isFilled($formType, $retrunType, $returnDate, $end_user_id, $userType) {

            $records = $this->find()
                ->select(['id'])
                ->where(['form_type'=>$formType])
                ->where(['return_type'=>$retrunType])
                ->where(['return_date'=>$returnDate])
                ->where(['end_user_id'=>$end_user_id])
                ->where(['user_type'=>$userType])
                ->count();

			if ($records > 0){
				return 1;
			} else {
                return 0;
            }

		}
		
		//Made by Shweta Apale
    public function getSupplierMineral($mineral)
    {
        $mineral = implode(',', $mineral);
        $conn = ConnectionManager::get(Configure::read('conn'));
        $q = $conn->execute("SELECT ind_sup_name FROM o_source_supply WHERE FIND_IN_SET(ferroalloy ,'$mineral')  AND ind_sup_name != ' ' ORDER BY ind_sup_name ASC");
        $records = $q->fetchAll('assoc');

        $data = array();
        $i = 0;
        foreach ($records as $result) {
            $code = $result['ind_sup_name'];
            $data[$code] = $result['ind_sup_name'];
            $i++;
        }
        return $data;
    }

    //Made by Shweta Apale
    public function getSupplierPlant($plant)
    {
        $plant = implode(',', $plant);
        $plant = trim($plant);
        $conn = ConnectionManager::get(Configure::read('conn'));
        $q = $conn->execute(
            "
        SELECT oss.ind_sup_name, o.plant_name1, o.plant_name2 
        FROM o_source_supply oss 
        INNER JOIN o_mineral_industry_info o ON o.end_user_id = oss.end_user_id
        WHERE FIND_IN_SET(o.plant_name1 ,'$plant') OR FIND_IN_SET(o.plant_name2,'$plant')  AND oss.ind_sup_name != ' ' ORDER BY oss.ind_sup_name ASC"
        );
        $records = $q->fetchAll('assoc');

        $data = array();
        $i = 0;
        foreach ($records as $result) {
            $code = $result['ind_sup_name'];
            $data[$code] = $result['ind_sup_name'];
            $i++;
        }
        return $data;
    }

    //Made by Shweta Apale
    public function getTransportModeSupplier($mineral, $suppiler)
    {
        $suppiler = implode(',', $suppiler);
        $mineral = implode(',', $mineral);
        $conn = ConnectionManager::get(Configure::read('conn'));
        $q = $conn->execute("SELECT ind_trans_mode FROM o_source_supply WHERE FIND_IN_SET(ind_sup_name ,'$suppiler') AND FIND_IN_SET(ferroalloy,'$mineral') ORDER BY ind_trans_mode ASC");
        $records = $q->fetchAll('assoc');

        $data = array();
        $i = 0;
        foreach ($records as $result) {
            $code = $result['ind_trans_mode'];
            $data[$code] = $result['ind_trans_mode'];
            $i++;
        }
        return $data;
    }


	}
?>