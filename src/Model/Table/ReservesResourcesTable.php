<?php 
	namespace app\Model\Table;
	use App\Controller\MonthlyController;
	use App\Model\Model;
	use Cake\Core\Configure;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	
	class ReservesResourcesTable extends Table{

		var $name = "ReservesResources";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getAllData($mineCode, $returnType, $returnDate, $mineralName){
		
            $query = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['mineral_name'=>$mineralName])	
                ->toArray();
                
            if (count($query) > 0) {
                return $query[0];
            } else {
                $MonthlyCntrl = new MonthlyController();
				return $MonthlyCntrl->Customfunctions->getTableColumns('reserves_resources');
            }	
        }
        
        /**
        * @param string $mineCode
        * @param string $returnType
        * @param date $returnDate
        * @param int $formType
        * @return if data then record id else null
        */
        public function getReturnsId($mineCode, $returnType, $returnDate, $mineralName) {
            
            $query = $this->find()
                ->select(['id'])
                ->where(["mine_code"=>$mineCode])
                ->where(["return_type"=>$returnType])
                ->where(["return_date"=>$returnDate])
                ->where(['mineral_name'=>$mineralName])	
                ->toArray();
                    
            if (count($query) > 0) {
                return $query[0];
            } else {
                return null;
            }

        }
        
	    public function saveFormDetails($params){

			$dataValidatation = $this->postDataValidation($params);

			if($dataValidatation == 1 ){

	            $mineCode = $params['mine_code'];
	            $mineralName = strtolower(str_replace(' ', '_', $params['mineral_name']));
                $returnDate = $params['return_date'];
                $returnType = $params['return_type'];
				
                $result = 1;
				$date = date('Y-m-d H:i:s');

				$reservesParams = $params['RS'];
                $reservesData = $this->getReturnsId($mineCode, $returnType, $returnDate, $mineralName);
				if (isset($reservesData['id']) && $reservesData['id'] != '') {
					$rowId = $reservesData['id'];
					$created_at = $reservesData['created_at'];
				} else {
					$rowId = '';
					$created_at = $date;
				}
                
				$newEntity = $this->newEntity(array(
                    'id' => $rowId,
                    
                    // Basic details
                    'mine_code' => $mineCode,
                    'return_type' => $returnType,
                    'return_date' => $returnDate,
                    'mineral_name' => $mineralName,
                    
                    //Proved Mineral Reserve Details
                    'proved_begin' => $reservesParams['PROVED_BEGIN'],
                    'proved_assessed_during' => $reservesParams['PROVED_ASSESSED_DURING'],
                    'proved_depletion' => $reservesParams['PROVED_DEPLETION'],
                    'proved_balance' => $reservesParams['PROVED_BALANCE'],
                    
                    //Probable mineral Reserve Details
                    'probable_first_begin' => $reservesParams['PROBABLE_FIRST_BEGIN'],
                    'probable_first_assessed_during' => $reservesParams['PROBABLE_FIRST_ASSESSED_DURING'],
                    'probable_first_depletion' => $reservesParams['PROBABLE_FIRST_DEPLETION'],
                    'probable_first_balance' => $reservesParams['PROBABLE_FIRST_BALANCE'],
                    'probable_sec_begin' => $reservesParams['PROBABLE_SEC_BEGIN'],
                    'probable_sec_assessed_during' => $reservesParams['PROBABLE_SEC_ASSESSED_DURING'],
                    'probable_sec_depletion' => $reservesParams['PROBABLE_SEC_DEPLETION'],
                    'probable_sec_balance' => $reservesParams['PROBABLE_SEC_BALANCE'],
                    
                    //Feasibility mineral Resource Details
                    'feasibility_begin' => $reservesParams['FEASIBILITY_BEGIN'],
                    'feasibility_assessed_during' => $reservesParams['FEASIBILITY_ASSESSED_DURING'],
                    'feasibility_depletion' => $reservesParams['FEASIBILITY_DEPLETION'],
                    'feasibility_balance' => $reservesParams['FEASIBILITY_BALANCE'],
                    
                    //Prefeasibility mineral resource Details
                    'prefeasibility_first_begin' => $reservesParams['PREFEASIBILITY_FIRST_BEGIN'],
                    'prefeasibility_first_assessed_during' => $reservesParams['PREFEASIBILITY_FIRST_ASSESSED_DURING'],
                    'prefeasibility_first_depletion' => $reservesParams['PREFEASIBILITY_FIRST_DEPLETION'],
                    'prefeasibility_first_balance' => $reservesParams['PREFEASIBILITY_FIRST_BALANCE'],
                    'prefeasibility_sec_begin' => $reservesParams['PREFEASIBILITY_SEC_BEGIN'],
                    'prefeasibility_sec_assessed_during' => $reservesParams['PREFEASIBILITY_SEC_ASSESSED_DURING'],
                    'prefeasibility_sec_depletion' => $reservesParams['PREFEASIBILITY_SEC_DEPLETION'],
                    'prefeasibility_sec_balance' => $reservesParams['PREFEASIBILITY_SEC_BALANCE'],
                    
                    //Measured mineral resource Details
                    'measured_begin' => $reservesParams['MEASURED_BEGIN'],
                    'measured_assessed_during' => $reservesParams['MEASURED_ASSESSED_DURING'],
                    'measured_sec_depletion' => $reservesParams['MEASURED_SEC_DEPLETION'],
                    'measured_sec_balance' => $reservesParams['MEASURED_SEC_BALANCE'],
                    
                    //Indicated mineral resource Details
                    'indicated_begin' => $reservesParams['INDICATED_BEGIN'],
                    'indicated_assessed_during' => $reservesParams['INDICATED_ASSESSED_DURING'],
                    'indicated_sec_depletion' => $reservesParams['INDICATED_SEC_DEPLETION'],
                    'indicated_sec_balance' => $reservesParams['INDICATED_SEC_BALANCE'],
                    
                    //Inferred mineral resource Details
                    'inferred_begin' => $reservesParams['INFERRED_BEGIN'],
                    'inferred_assessed_during' => $reservesParams['INFERRED_ASSESSED_DURING'],
                    'inferred_sec_depletion' => $reservesParams['INFERRED_SEC_DEPLETION'],
                    'inferred_sec_balance' => $reservesParams['INFERRED_SEC_BALANCE'],
                    
                    //Reconnaissance mineral resource
                    'reconnaissance_begin' => $reservesParams['RECONNAISSANCE_BEGIN'],
                    'reconnaissance_assessed_during' => $reservesParams['RECONNAISSANCE_ASSESSED_DURING'],
                    'reconnaissance_sec_depletion' => $reservesParams['RECONNAISSANCE_SEC_DEPLETION'],
                    'reconnaissance_sec_balance' => $reservesParams['RECONNAISSANCE_SEC_BALANCE'],
					'created_at' => $created_at,
					'updated_at' => $date
				));
			
				if ($this->save($newEntity)) {
					//
				} else {
					$result = false;
				}

				$subgradeParams = $params['SMR'];

                $subgradeMineralReject = TableRegistry::getTableLocator()->get('SubgradeMineralReject');
				$subgradeData = $subgradeMineralReject->getReturnsId($mineCode, $returnType, $returnDate, $mineralName);
				if (isset($subgradeData['id']) && $subgradeData['id'] != '') {
					$subgradeRowId = $subgradeData['id'];
					$subgrade_created_at = $subgradeData['created_at'];
				} else {
					$subgradeRowId = '';
					$subgrade_created_at = $date;
				}
                
				$subgradeNewEntity = $this->newEntity(array(
                    'id' => $subgradeRowId,
                    
                    // Basic details
                    'mine_code' => $mineCode,
                    'return_type' => $returnType,
                    'return_date' => $returnDate,
                    'mineral_name' => $mineralName,
                    
                    //unprocessed ore deatils
                    'unprocessed_begin' => $subgradeParams['UNPROCESSED_BEGIN'],
                    'unprocessed_generated' => $subgradeParams['UNPROCESSED_GENERATED'],
                    'unprocessed_disposed' => $subgradeParams['UNPROCESSED_DISPOSED'],
                    'unprocessed_total' => $subgradeParams['UNPROCESSED_TOTAL'],
                    'unprocessed_average' => $subgradeParams['UNPROCESSED_AVERAGE'],
                    
                    //processed ore deatils
                    'processed_begin' => $subgradeParams['PROCESSED_BEGIN'],
                    'processed_generated' => $subgradeParams['PROCESSED_GENERATED'],
                    'processed_disposed' => $subgradeParams['PROCESSED_DISPOSED'],
                    'processed_total' => $subgradeParams['PROCESSED_TOTAL'],
                    'processed_average' => $subgradeParams['PROCESSED_AVERAGE'],
					'created_at' => $subgrade_created_at,
					'updated_at' => $date
				));
			
				if ($subgradeMineralReject->save($subgradeNewEntity)) {
					//
				} else {
					$result = false;
				}

                return $result;

			} else {
				return false;
			}

	    }

	    public function postDataValidation($params){
			
			$returnValue = 1;
			
			if(empty($params['mine_code'])){ $returnValue = null ; }
			if(empty($params['return_date'])){ $returnValue = null ; }
			if(empty($params['return_type'])){ $returnValue = null ; }
			if(empty($params['mineral_name'])){ $returnValue = null ; }
			
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;

			foreach ($params['RS'] as $key=>$val) {

				if ($val != '') {
					$returnValue = ($validate->maxLen($val, 12) == false) ? null : $returnValue;
					$returnValue = ($validate->numeric($val) == false) ? null : $returnValue;
				} else {
					$returnValue = null ;
				}

			}
            
			foreach ($params['SMR'] as $key=>$val) {

				if ($val != '') {
					$returnValue = ($validate->chkFloatCharac($val, 2, 12) == false) ? null : $returnValue;
				} else {
					$returnValue = null ;
				}

			}
			
			return $returnValue;
			
		}

		/**
		 * Check filled status of section
		 * @version 29th Oct 2021
		 * @author Aniket Ganvir
		 */
		public function isFilled($mineCode, $returnType, $returnDate, $mineralName) {

            $mineral = str_replace(' ', '_', $mineralName);
			$reserves = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['mineral_name'=>$mineral])	
				->count();
                
            $subgradeMineralReject = TableRegistry::getTableLocator()->get('SubgradeMineralReject');
            $subgrade = $subgradeMineralReject->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['mineral_name'=>$mineral])	
                ->count();

			if ($reserves > 0 && $subgrade > 0) {
				return true;
			} else {
				return false;
			}

		}

	} 
?>