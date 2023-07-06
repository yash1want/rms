<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Controller\MonthlyController;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;

use function PHPUnit\Framework\returnValue;

class MachineryTable extends Table{

		var $name = "Machinery";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getAllData($mineCode, $returnType, $returnDate, $formType, $dynamicFormType = '') {

            $dynamicFormType = ($dynamicFormType == '') ? $formType : $dynamicFormType;

            $query = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['form_type'=>$formType])
                ->where(['dynamic_form_type'=>$dynamicFormType])
                ->toArray();

            // $i = 0;
            $aggregationCount = 0;
            // $yearlyCount = 0;
            $staticArray = Array();
            $aggregationArray = Array();
            // $yearlyArray = Array();
            foreach ($query as $data) {

                if ($data['dynamic_form_type'] == 1) {
                    //=======================STATIC FORM FIELDS=============================
                    $staticArray['FUTURE_PLAN'] = $data['future_plan'];
                    $staticArray['LAB_FACILITY'] = $data['lab_facility'];

                    $staticArray['FURNISH_SURFACE'] = $data['furnish_surface'];
                    $staticArray['SILENT_FEATURE'] = $data['silent_feature'];

                    //=======================AGGREGATION FIELDS=============================
                    $aggregationCount += 1;
                    $aggregationArray['aggregation_count'] = $aggregationCount;
                    $machineData = explode('-', $data['machinery_code']);
                    $machineCode = $machineData[0];
                    $machineUnit = ($data['machinery_code'] == 'NIL') ? '' : $machineData[1];
                    $aggregationArray['machine_select_' . $aggregationCount] = $data['machinery_code'];
                    $aggregationArray['unit_' . $aggregationCount] = $machineUnit;
                    $aggregationArray['capacity_box_' . $aggregationCount] = $data['capacity'];
                    $aggregationArray['unit_box_' . $aggregationCount] = $data['unit_no'];
                    
                    //In new form, One new extra fields are added. So add two new fields "NO_OF_MACHINERY"
                    //Done By Pravin Bhakare 17-08-2020
                    $aggregationArray['no_of_machinery_' . $aggregationCount] = $data['no_of_machinery']; 	
                    
                    $aggregationArray['electrical_select_' . $aggregationCount] = $data['electrical_machinery'];
                    $aggregationArray['opencast_select_' . $aggregationCount] = $data['oc_machinery'];
                }

            }

            if (count($query) == 0) {
                $staticArray['FUTURE_PLAN'] = '';
                $staticArray['LAB_FACILITY'] = '';
                $staticArray['FURNISH_SURFACE'] = '';
                $staticArray['SILENT_FEATURE'] = '';
                $aggregationArray['aggregation_count'] = 1;
                $aggregationArray['machine_select_1'] = '';
                $aggregationArray['unit_1'] = '';
                $aggregationArray['capacity_box_1'] = '';
                $aggregationArray['unit_box_1'] = '';
                $aggregationArray['no_of_machinery_1'] = '';
                $aggregationArray['electrical_select_1'] = '';
                $aggregationArray['opencast_select_1'] = '';
            }

            $resultSet = Array();
            $resultSet['static'] = $staticArray;
            $resultSet['aggregation'] = $aggregationArray;
            // $resultSet['yearly'] = $yearlyArray;

            return $resultSet;

        }

        public function getAllPart6Data($mineCode, $returnType, $returnDate, $mineralName, $formType) {

            $query = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['mineral_name'=>$mineralName])
                ->where(['form_type'=>$formType])
                ->toArray();

            $staticArray = Array();
            $staticArray['static']['MIN_TREATMENT_PLANT'] = (isset($query[0]['min_treatment_plant'])) ? $query[0]['min_treatment_plant'] : '';
            $staticArray['static']['FEED_TONNAGE'] = (isset($query[0]['feed_tonnage'])) ? $query[0]['feed_tonnage'] : '';
            $staticArray['static']['FEED_AVG_GRADE'] = (isset($query[0]['feed_avg_grade'])) ? $query[0]['feed_avg_grade'] : '';
            $staticArray['static']['CONCEN_TONNAGE'] = (isset($query[0]['concen_tonnage'])) ? $query[0]['concen_tonnage'] : '';
            $staticArray['static']['CONCEN_AVG_GRADE'] = (isset($query[0]['concen_avg_grade'])) ? $query[0]['concen_avg_grade'] : '';
            $staticArray['static']['BY_PRO_TONNAGE'] = (isset($query[0]['by_pro_tonnage'])) ? $query[0]['by_pro_tonnage'] : '';
            $staticArray['static']['BY_PRO_AVG_GRADE'] = (isset($query[0]['by_pro_avg_grade'])) ? $query[0]['by_pro_avg_grade'] : '';
            $staticArray['static']['TAIL_TONNAGE'] = (isset($query[0]['tail_tonnage'])) ? $query[0]['tail_tonnage'] : '';
            $staticArray['static']['TAIL_AVG_GRADE'] = (isset($query[0]['tail_avg_grade'])) ? $query[0]['tail_avg_grade'] : '';

            return $staticArray;

        }
        
        public function getFormDataForSec6($mineCode, $returnType, $returnDate, $formType, $mineralName) {

            $query = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['form_type'=>$formType])
                ->where(['mineral_name'=>$mineralName])
                ->toArray();
            
            $staticArray = Array();
            $staticArray['MIN_TREATMENT_PLANT'] = (isset($query[0]['min_treatment_plant'])) ? $query[0]['min_treatment_plant'] : '';
            $staticArray['FEED_TONNAGE'] = (isset($query[0]['feed_tonnage'])) ? $query[0]['feed_tonnage'] : '';
            $staticArray['FEED_AVG_GRADE'] = (isset($query[0]['feed_avg_grade'])) ? $query[0]['feed_avg_grade'] : '';
            $staticArray['CONCEN_TONNAGE'] = (isset($query[0]['concen_tonnage'])) ? $query[0]['concen_tonnage'] : '';
            $staticArray['CONCEN_AVG_GRADE'] = (isset($query[0]['concen_avg_grade'])) ? $query[0]['concen_avg_grade'] : '';
            $staticArray['TAIL_TONNAGE'] = (isset($query[0]['tail_tonnage'])) ? $query[0]['tail_tonnage'] : '';
            $staticArray['TAIL_AVG_GRADE'] = (isset($query[0]['tail_avg_grade'])) ? $query[0]['tail_avg_grade'] : '';
            $staticArray['BY_PRO_TONNAGE'] = (isset($query[0]['by_pro_tonnage'])) ? $query[0]['by_pro_tonnage'] : '';
            $staticArray['BY_PRO_AVG_GRADE'] = (isset($query[0]['by_pro_avg_grade'])) ? $query[0]['by_pro_avg_grade'] : '';
            $resultSet = Array();
            $resultSet['static'] = $staticArray;
            return $resultSet;
            
        }
        
        public function checkDB($mineCode, $returnType, $returnDate, $formType) {

            $dbRow = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['form_type'=>$formType])
                ->count();

            if ($dbRow > 0) {
                return 1;
            } else {
                return 0;
            }
            
        }

        public function deletePart3Data($mineCode, $returnType, $returnDate, $formType) {

            $query = $this->query();
            $query->delete()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['form_type'=>$formType])
                ->execute();

        }

        
        public function checkDBForPart6($mineCode, $returnType, $returnDate, $formType, $mineralName) {

            $query = $this->find()
                    ->where(['mine_code'=>$mineCode])
                    ->where(['return_type'=>$returnType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['form_type'=>$formType])
                    ->where(['mineral_name'=>$mineralName])
                    ->toArray();

            if ($query) {
                return 1;
            } else {
                return 0;
            }

        }

        public function deletePart6Data($mineCode, $returnType, $returnDate, $formType, $mineralName) {

            $query = $this->query();
            $query->delete()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['form_type'=>$formType])
                ->where(['mineral_name'=>$mineralName])
                ->execute();

        }
        
	    public function saveFormDetails($params){

			$postData = $this->postDataValidation($params);

			if($postData['data_status'] == 1 ){

	            $mineCode = $postData['mine_code'];
                $returnDate = $postData['return_date'];
                $returnType = $postData['return_type'];
                $formType = $postData['form_type'];
				
                $result = 1;
				$date = date('Y-m-d H:i:s');

                $dbCheck = $this->checkDB($mineCode, $returnType, $returnDate, $formType);
                if ($dbCheck == 1) {
                    $this->deletePart3Data($mineCode, $returnType, $returnDate, $formType);
                }

                $aggCount = count($postData['machine_select']);
                if ($postData['machine_select'][0] == 'NIL') {
                    $aggCount = 1;
                }
                
                for ($i = 0; $i < $aggCount; $i++) {

                    $newEntity = $this->newEntity(array(
                        
                        'machinery_code' => $postData['machine_select'][$i],
                        'capacity' => $postData['capacity_box'][$i],
                        'unit_no' => $postData['unit_box'][$i],
                        
                        // In new form, One new extra fields are added. So add two new fields "NO_OF_MACHINERY"
                        // Done By Pravin Bhakare 17-08-2020
                        'no_of_machinery' => $postData['no_of_machinery'][$i],
                        
                        'electrical_machinery' => $postData['electrical_select'][$i],
                        'oc_machinery' => $postData['opencast_select'][$i],

                        //========================FORM STATIC FIELDS==============================
                        'mine_code' => $mineCode,
                        'return_type' => $returnType,
                        'return_date' => $returnDate,
                        // 'future_plan' => $postData["FUTURE_PLAN"],
                        // 'lab_facility' => $postData["LAB_FACILITY"],
                        // 'furnish_surface' => $postData["FURNISH_SURFACE"],
                        // 'silent_feature' => $postData["SILENT_FEATURE"],
                        'form_type' => $formType,
                        'machinery_sn' => 0,
                        
                        //========================1 -> AGGREGATION FIELDS=========================
                        'dynamic_form_type' => '1',

                        'created_at' => $date,
                        'updated_at' => $date
                    ));
                
                    if ($this->save($newEntity)) {
                        //
                    } else {
                        $result = false;
                    }

                }
                
                return $result;

			} else {
				return false;
			}

	    }

	    public function postDataValidation($params){
			
			$dataStatus = 1;
			
			if(empty($params['mine_code'])){ $dataStatus = null ; }
			if(empty($params['return_date'])){ $dataStatus = null ; }
			if(empty($params['return_type'])){ $dataStatus = null ; }
			if(empty($params['form_type'])){ $dataStatus = null ; }
			
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;

            $rws = count($params['machine_select']);
            
            if ($params['machine_select'][0] == 'NIL') {
                $rws = 1;
                $params['capacity_box'][0] = 0.000;
                $params['unit_box'][0] = 0;
                $params['no_of_machinery'][0] = 0;
                $params['electrical_select'][0] = 0;
                $params['opencast_select'][0] = 0;
            }

            for ($i=0; $i<$rws; $i++) {

                if ($params['machine_select'][$i] != 'NIL') {
                    
                    if ($params['machine_select'][$i] == '') { $dataStatus = null ; }

                    $dataStatus = ($validate->chkFloatCharac($params['capacity_box'][$i], 3, 10) == false) ? null : $dataStatus;
                    if ($params['capacity_box'][$i] < 0 || $params['capacity_box'][$i] > 999999.999) { $dataStatus = null ; }
                    
                    // NO NEED TO VALIDATE 'unit_box' FIELD, THIS IS NOW IN 'disabled/readonly' MODE
                    // $dataStatus = ($validate->maxLen($params['unit_box'][$i], 10) == false) ? null : $dataStatus;
                    // $dataStatus = ($validate->numeric($params['unit_box'][$i]) == false) ? null : $dataStatus;
                    // if ($params['unit_box'][$i] < 0 || $params['unit_box'][$i] > 9999) { $dataStatus = null ; }
                    
                    $dataStatus = ($validate->maxLen($params['no_of_machinery'][$i], 10) == false) ? null : $dataStatus;
                    $dataStatus = ($validate->numeric($params['no_of_machinery'][$i]) == false) ? null : $dataStatus;
                    if ($params['no_of_machinery'][$i] < 0 || $params['no_of_machinery'][$i] > 9999) { $dataStatus = null ; }

                    if (empty($params['electrical_select'][$i])) { $dataStatus = null ; }
                    if (empty($params['opencast_select'][$i])) { $dataStatus = null ; }

                }

            }

            $params['data_status'] = $dataStatus;

            return $params;
			
		}

	    public function postFormDataPartSix($params){

			$postData = $this->postPartSixDataValidation($params);

			if ($postData['data_status'] == 1) {

	            $mineCode = $postData['mine_code'];
                $returnDate = $postData['return_date'];
                $returnType = $postData['return_type'];
                $formType = 2;
                $mineralName = $postData['mineral_name'];
				
                $result = 1;
				$date = date('Y-m-d H:i:s');

                $dbCheck = $this->checkDBForPart6($mineCode, $returnType, $returnDate, $formType, $mineralName);
                if ($dbCheck == 1) {
                    $this->deletePart6Data($mineCode, $returnType, $returnDate, $formType, $mineralName);
                }
                
                $newEntity = $this->newEntity(array(
                    
                    'mine_code' => $mineCode,
                    'return_type' => $returnType,
                    'return_date' => $returnDate,
                    'mineral_name' => $mineralName,
                    'machinery_sn' => 0,
                    'min_treatment_plant' => $postData["MIN_TREATMENT_PLANT"],
                    'feed_tonnage' => $postData['FEED_TONNAGE'],
                    'feed_avg_grade' => $postData['FEED_AVG_GRADE'],
                    'concen_tonnage' => $postData['CONCEN_TONNAGE'],
                    'concen_avg_grade' => $postData['CONCEN_AVG_GRADE'],
                    'by_pro_tonnage' => $postData['BY_PRO_TONNAGE'],
                    'by_pro_avg_grade' => $postData['BY_PRO_AVG_GRADE'],
                    'tail_tonnage' => $postData['TAIL_TONNAGE'],
                    'tail_avg_grade' => $postData['TAIL_AVG_GRADE'],
                    'dynamic_form_type' => 2,
                    'form_type' => $formType,

                    'created_at' => $date,
                    'updated_at' => $date
                ));
            
                if ($this->save($newEntity)) {
                    //
                } else {
                    $result = false;
                }
                
                return $result;

			} else {
				return false;
			}

	    }

        
	    public function postPartSixDataValidation($params){
			
			$dataStatus = 1;
			
			if(empty($params['mine_code'])){ $dataStatus = null ; }
			if(empty($params['return_date'])){ $dataStatus = null ; }
			if(empty($params['return_type'])){ $dataStatus = null ; }
			if(empty($params['mineral_name'])){ $dataStatus = null ; }
			
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;

            if ($params['FEED_TONNAGE'] != '') {
                $dataStatus = ($validate->maxLen($params['FEED_TONNAGE'], 10) == false) ? null : $dataStatus;
                $dataStatus = ($validate->numeric($params['FEED_TONNAGE']) == false) ? null : $dataStatus;
            } else {
                $params['FEED_TONNAGE'] = 0;
            }

            if ($params['FEED_AVG_GRADE'] != '' && is_numeric($params['FEED_AVG_GRADE'])) {
                $params['FEED_AVG_GRADE'] = round($params['FEED_AVG_GRADE']);
            } else {
                $params['FEED_AVG_GRADE'] = 0;
            }

            if ($params['CONCEN_TONNAGE'] != '') {
                $dataStatus = ($validate->maxLen($params['CONCEN_TONNAGE'], 10) == false) ? null : $dataStatus;
                $dataStatus = ($validate->numeric($params['CONCEN_TONNAGE']) == false) ? null : $dataStatus;
            } else {
                $params['CONCEN_TONNAGE'] = 0;
            }
            
            if ($params['CONCEN_AVG_GRADE'] != '' && is_numeric($params['CONCEN_AVG_GRADE'])) {
                $params['CONCEN_AVG_GRADE'] = round($params['CONCEN_AVG_GRADE']);
            } else {
                $params['CONCEN_AVG_GRADE'] = 0;
            }
             
            if ($params['BY_PRO_TONNAGE'] != '') {
                $dataStatus = ($validate->maxLen($params['BY_PRO_TONNAGE'], 10) == false) ? null : $dataStatus;
                $dataStatus = ($validate->numeric($params['BY_PRO_TONNAGE']) == false) ? null : $dataStatus;
            } else {
                $params['BY_PRO_TONNAGE'] = 0;
            }

            if ($params['BY_PRO_AVG_GRADE'] != '') {
                $dataStatus = ($validate->maxLen($params['BY_PRO_AVG_GRADE'], 10) == false) ? null : $dataStatus;
                $dataStatus = ($validate->numeric($params['BY_PRO_AVG_GRADE']) == false) ? null : $dataStatus;
            } else {
                $params['BY_PRO_AVG_GRADE'] = 0;
            }

            if ($params['TAIL_TONNAGE'] != '') {
                $dataStatus = ($validate->maxLen($params['TAIL_TONNAGE'], 10) == false) ? null : $dataStatus;
                $dataStatus = ($validate->numeric($params['TAIL_TONNAGE']) == false) ? null : $dataStatus;
            } else {
                $params['TAIL_TONNAGE'] = 0;
            }
            
            if ($params['TAIL_AVG_GRADE'] != '' && is_numeric($params['TAIL_AVG_GRADE'])) {
                $params['TAIL_AVG_GRADE'] = round($params['TAIL_AVG_GRADE']);
            } else {
                $params['TAIL_AVG_GRADE'] = 0;
            }

            $params['data_status'] = $dataStatus;

            return $params;
			
		}
        
		/**
		 * Check filled status of section "6. Type of Machinery"
		 * @version 30th Oct 2021
		 * @author Aniket Ganvir
		 */
		public function isFilled($mineCode, $returnType, $returnDate, $formType, $dynamicFormType = '') {

            $dynamicFormType = ($dynamicFormType == '') ? $formType : $dynamicFormType;

			$records = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['form_type'=>$formType])
                ->where(['dynamic_form_type'=>$dynamicFormType])
				->count();
			if ($records > 0) {
				return true;
			} else {
				return false;
			}

		}
        
		/**
		 * Check filled status of section "7. Mineral Treatment Plant"
		 * @version 30th Oct 2021
		 * @author Aniket Ganvir
		 */
        public function isFilledPartSix($mineCode, $returnType, $returnDate, $mineralName, $formType, $dynamicFormType = '') {

            $dynamicFormType = ($dynamicFormType == '') ? $formType : $dynamicFormType;
            $mineral = str_replace(' ','_',$mineralName);
			$records = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['mineral_name'=>$mineral])
                ->where(['form_type'=>$formType])
                ->where(['dynamic_form_type'=>$dynamicFormType])
				->count();
			if ($records > 0) {
				return true;
			} else {
				return false;
			}

        }
        
	} 
?>