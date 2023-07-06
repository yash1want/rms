<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class ExtraNSeriesProdActivityTable extends Table{
		
		var $name = "ExtraNSeriesProdActivity";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getSeriesExtraActivityDetails($returnType, $returnDate, $endUserId, $mine_name, $grade_code, $user_type) {
            
            $query = $this->find()
                    ->where(['return_type'=>$returnType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['end_user_id'=>$endUserId])
                    ->where(['local_mineral_code'=>$mine_name])
                    ->where(['local_grade_code IS'=>$grade_code])
                    ->where(['user_type'=>$user_type])
                    ->toArray();

            if (count($query) == 0 && $returnType == 'ANNUAL') {

				/**
				 * Prefetch the monthly records data for annual return
				 * Effective from Phase - II
				 * @version 01st Dec 2021
				 * @author Aniket Ganvir
				 */
				$conn = ConnectionManager::get(Configure::read('conn'));
				$startDate = (date('Y',strtotime($returnDate))).'-04-01';
				$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
				$str = "SELECT
                    country_name,
                    registration_no,
                    ROUND(SUM(quantity), 3) as quantity,
                    ROUND(AVG(`value`), 2) as `value`,
                    activity_status,
                    local_mineral_code,
                    local_grade_code
                    FROM `extra_n_series_prod_activity`
                    WHERE return_type = 'MONTHLY'
                    AND return_date BETWEEN '$startDate' AND '$endDate'
                    AND end_user_id = '$endUserId'
                    AND local_mineral_code = '$mine_name'
                    AND local_grade_code = '$grade_code'
                    AND user_type = '$user_type'
                    GROUP BY country_name, registration_no, activity_status";
					
				$query = $conn->execute($str)->fetchAll('assoc');

            }
    
            // CREATING EMPTY ARRAY OF FORM TYPES IF ARRAY ID EMPTY---- THIS IS BASICALLY FOR PREVIOUS YEAR DATA DISPLAY AS ALL OTHER FIELDS WILL BE EMPTY AT THAT TIME
            if (count($query) == 0) {
                if ($user_type == 'C') { // AS CONSUMER HAS ONE EXTRA SECTION 
                    $query = array(
                        '0' => array(
                            'activity_status' => 1,
                            'local_mineral_code' => null,
                            'registration_no' => null,
                            'quantity' => null,
                            'value' => null
                        ),
                        '1' => array(
                            'activity_status' => 2,
                            'local_mineral_code' => null,
                            'country_name' => null,
                            'quantity' => null,
                            'value' => null
                        ),
                        '2' => array(
                            'activity_status' => 3,
                            'local_mineral_code' => null,
                            'registration_no' => null,
                            'country_name' => null,
                            'quantity' => null,
                            'value' => null
                        ),
                        '3' => array(
                            'activity_status' => 4,
                            'quantity' => null,
                            'value' => null
                    ));
                } else {
                    $query = array(
                        '0' => array(
                            'activity_status' => 1,
                            'local_mineral_code' => null,
                            'registration_no' => null,
                            'quantity' => null,
                            'value' => null
                        ),
                        '1' => array(
                            'activity_status' => 2,
                            'local_mineral_code' => null,
                            'country_name' => null,
                            'quantity' => null,
                            'value' => null
                        ),
                        '2' => array(
                            'activity_status' => 3,
                            'local_mineral_code' => null,
                            'registration_no' => null,
                            'country_name' => null,
                            'quantity' => null,
                            'value' => null
                    ));
                }
            }
    
            $i = 0;
            $supplierCount = 1;
            $importCount = 1;
            $despatchCount = 1;
            $consumeCount = 1;
            $supplier = Array();
            $import = Array();
            $despatch = Array();
            $consume = Array();
            foreach ($query as $m) {
                if ($m['activity_status'] == 1) {
                    $supplier['local_mineral_code_' . $supplierCount] = $m['local_mineral_code'];
                    $supplier['activity_status_' . $supplierCount] = $m['activity_status'];
                    $supplier['registration_no_' . $supplierCount] = $m['registration_no'];
                    $supplier['quantity_' . $supplierCount] = $m['quantity'];
                    $supplier['value_' . $supplierCount] = $m['value'];
                    $supplier['suppliercount'] = $supplierCount;
                    $supplierCount++;
                } else if ($m['activity_status'] == 2) {
                    $import['local_mineral_code_' . $importCount] = $m['local_mineral_code'];
                    $import['activity_status_' . $importCount] = $m['activity_status'];
                    $import['country_name_' . $importCount] = $m['country_name'];
                    $import['quantity_' . $importCount] = $m['quantity'];
                    $import['value_' . $importCount] = $m['value'];
                    $import['importcount'] = $importCount;
                    $importCount++;
                } else if ($m['activity_status'] == 3) {
                    $despatch['local_mineral_code_' . $despatchCount] = $m['local_mineral_code'];
                    $despatch['activity_status_' . $despatchCount] = $m['activity_status'];
                    $despatch['registration_no_' . $despatchCount] = $m['registration_no'];
                    $despatch['country_name_' . $despatchCount] = $m['country_name'];
                    $despatch['quantity_' . $despatchCount] = $m['quantity'];
                    $despatch['value_' . $despatchCount] = $m['value'];
                    $despatch['despatchcount'] = $despatchCount;
                    $despatchCount++;
                } else if ($m['activity_status'] == 4) {
                    $consume['quantity'] = $m['quantity'];
                    $consume['value'] = $m['value'];
                    $consumeCount++;
                }
            }

            $returnSet = Array();
            $returnSet['supplier'] = $supplier;
            $returnSet['importData'] = $import;
            $returnSet['despatch'] = $despatch;
            $returnSet['consumeData'] = $consume;
            return $returnSet;

        }

        /**
         * Prefetch the monthly records data for annual return
         * Effective from Phase - II
         * @version 13th Dec 2021
         * @author Aniket Ganvir
         */
        public function getSeriesExtraActivityDetailsMonthAll($returnType, $returnDate, $endUserId, $mine_name, $grade_code, $user_type) {

            $conn = ConnectionManager::get(Configure::read('conn'));
            $startDate = (date('Y',strtotime($returnDate))).'-04-01';
            $endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
            $str = "SELECT
                country_name,
                registration_no,
                ROUND(SUM(quantity), 3) as quantity,
                ROUND(AVG(`value`), 2) as `value`,
                activity_status,
                local_mineral_code,
                local_grade_code
                FROM `extra_n_series_prod_activity`
                WHERE return_type = 'MONTHLY'
                AND return_date BETWEEN '$startDate' AND '$endDate'
                AND end_user_id = '$endUserId'
                AND local_mineral_code = '$mine_name'
                AND local_grade_code = '$grade_code'
                AND user_type = '$user_type'
                GROUP BY country_name, registration_no, activity_status";
                
            $query = $conn->execute($str)->fetchAll('assoc');
    
            // CREATING EMPTY ARRAY OF FORM TYPES IF ARRAY ID EMPTY---- THIS IS BASICALLY FOR PREVIOUS YEAR DATA DISPLAY AS ALL OTHER FIELDS WILL BE EMPTY AT THAT TIME
            if (count($query) == 0) {
                if ($user_type == 'C') { // AS CONSUMER HAS ONE EXTRA SECTION 
                    $query = array(
                        '0' => array(
                            'activity_status' => 1,
                            'local_mineral_code' => null,
                            'registration_no' => null,
                            'quantity' => null,
                            'value' => null
                        ),
                        '1' => array(
                            'activity_status' => 2,
                            'local_mineral_code' => null,
                            'country_name' => null,
                            'quantity' => null,
                            'value' => null
                        ),
                        '2' => array(
                            'activity_status' => 3,
                            'local_mineral_code' => null,
                            'registration_no' => null,
                            'country_name' => null,
                            'quantity' => null,
                            'value' => null
                        ),
                        '3' => array(
                            'activity_status' => 4,
                            'quantity' => null,
                            'value' => null
                    ));
                } else {
                    $query = array(
                        '0' => array(
                            'activity_status' => 1,
                            'local_mineral_code' => null,
                            'registration_no' => null,
                            'quantity' => null,
                            'value' => null
                        ),
                        '1' => array(
                            'activity_status' => 2,
                            'local_mineral_code' => null,
                            'country_name' => null,
                            'quantity' => null,
                            'value' => null
                        ),
                        '2' => array(
                            'activity_status' => 3,
                            'local_mineral_code' => null,
                            'registration_no' => null,
                            'country_name' => null,
                            'quantity' => null,
                            'value' => null
                    ));
                }
            }
    
            $i = 0;
            $supplierCount = 1;
            $importCount = 1;
            $despatchCount = 1;
            $consumeCount = 1;
            $supplier = Array();
            $import = Array();
            $despatch = Array();
            $consume = Array();
            foreach ($query as $m) {
                if ($m['activity_status'] == 1) {
                    $supplier['local_mineral_code_' . $supplierCount] = $m['local_mineral_code'];
                    $supplier['activity_status_' . $supplierCount] = $m['activity_status'];
                    $supplier['registration_no_' . $supplierCount] = $m['registration_no'];
                    $supplier['quantity_' . $supplierCount] = $m['quantity'];
                    $supplier['value_' . $supplierCount] = $m['value'];
                    $supplier['suppliercount'] = $supplierCount;
                    $supplierCount++;
                } else if ($m['activity_status'] == 2) {
                    $import['local_mineral_code_' . $importCount] = $m['local_mineral_code'];
                    $import['activity_status_' . $importCount] = $m['activity_status'];
                    $import['country_name_' . $importCount] = $m['country_name'];
                    $import['quantity_' . $importCount] = $m['quantity'];
                    $import['value_' . $importCount] = $m['value'];
                    $import['importcount'] = $importCount;
                    $importCount++;
                } else if ($m['activity_status'] == 3) {
                    $despatch['local_mineral_code_' . $despatchCount] = $m['local_mineral_code'];
                    $despatch['activity_status_' . $despatchCount] = $m['activity_status'];
                    $despatch['registration_no_' . $despatchCount] = $m['registration_no'];
                    $despatch['country_name_' . $despatchCount] = $m['country_name'];
                    $despatch['quantity_' . $despatchCount] = $m['quantity'];
                    $despatch['value_' . $despatchCount] = $m['value'];
                    $despatch['despatchcount'] = $despatchCount;
                    $despatchCount++;
                } else if ($m['activity_status'] == 4) {
                    $consume['quantity'] = $m['quantity'];
                    $consume['value'] = $m['value'];
                    $consumeCount++;
                }
            }

            $returnSet = Array();
            $returnSet['supplier'] = $supplier;
            $returnSet['importData'] = $import;
            $returnSet['despatch'] = $despatch;
            $returnSet['consumeData'] = $consume;
            return $returnSet;

        }


	}

?>