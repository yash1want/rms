<?php 
	namespace app\Model\Table;
	use App\Controller\MonthlyController;
	use App\Model\Model;
	use Cake\Core\Configure;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	
	class OverburdenWasteTable extends Table{

		var $name = "OverburdenWaste";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}
        
        public function getAllData($mineCode, $returnType, $returnDate){
            
            $query = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->toArray();
                
            if (count($query) > 0) {
                return $query[0];
            } else {
                $MonthlyCntrl = new MonthlyController();
				return $MonthlyCntrl->Customfunctions->getTableColumns('overburden_waste');
            }

        }

        
        /**
        * @param string $mineCode
        * @param string $returnType
        * @param date $returnDate
        * @param int $formType
        * @return if data then record id else null
        */
        public function getReturnsId($mineCode, $returnType, $returnDate) {
            
            $query = $this->find()
                ->select(['id', 'created_at'])
                ->where(["mine_code"=>$mineCode])
                ->where(["return_type"=>$returnType])
                ->where(["return_date"=>$returnDate])
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
                $returnDate = $params['return_date'];
                $returnType = $params['return_type'];
				
                $result = 1;
				$date = date('Y-m-d H:i:s');

				$overburdenParams = $params['O'];
                $overburdenData = $this->getReturnsId($mineCode, $returnType, $returnDate);
				if (isset($overburdenData['id']) && $overburdenData['id'] != '') {
					$rowId = $overburdenData['id'];
					$created_at = $overburdenData['created_at'];
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
                    
                    //Overburden and Waste Details
                    'at_begining_yr' => $overburdenParams['AT_BEGINING_YR'],
                    'generated_dy' => $overburdenParams['GENERATED_DY'],
                    'disposed_dy' => $overburdenParams['DISPOSED_DY'],
                    'backfilled_dy' => $overburdenParams['BACKFILLED_DY'],
                    'total_at_eoy' => $overburdenParams['TOTAL_AT_EOY'],
					'created_at' => $created_at,
					'updated_at' => $date
				));
			
				if ($this->save($newEntity)) {
					//
				} else {
					$result = false;
				}

				$treesParams = $params['T'];

                $treesPlantSurvival = TableRegistry::getTableLocator()->get('TreesPlantSurvival');
				$treesPlantDaa = $treesPlantSurvival->getReturnsId($mineCode, $returnType, $returnDate);
				if (isset($treesPlantDaa['id']) && $treesPlantDaa['id'] != '') {
					$treesPlantId = $treesPlantDaa['id'];
					$treesPlantCreatedAt = $treesPlantDaa['created_at'];
				} else {
					$treesPlantId = '';
					$treesPlantCreatedAt = $date;
				}
                
				$treesPlantNewEntity = $this->newEntity(array(
                    'id' => $treesPlantId,
                    
                    // Basic details
                    'mine_code' => $mineCode,
                    'return_type' => $returnType,
                    'return_date' => $returnDate,
                    
                    //unprocessed ore deatils
                    'trees_wi_lease' => $treesParams['TREES_WI_LEASE'],
                    'trees_os_lease' => $treesParams['TREES_OS_LEASE'],
                    'surv_wi_lease' => $treesParams['SURV_WI_LEASE'],
                    'surv_os_lease' => $treesParams['SURV_OS_LEASE'],
                    'ttl_eoy_wi_lease' => $treesParams['TTL_EOY_WI_LEASE'],
                    'ttl_eoy_os_lease' => $treesParams['TTL_EOY_OS_LEASE'],
					'created_at' => $treesPlantCreatedAt,
					'updated_at' => $date
				));
			
				if ($treesPlantSurvival->save($treesPlantNewEntity)) {
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
			
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;

			foreach ($params['O'] as $key=>$val) {
				if ($val != '') {
					$returnValue = ($validate->chkFloatCharac($val, 2, 15) == false) ? null : $returnValue;
				} else {
					$returnValue = null ;
				}
			}
            
			foreach ($params['T'] as $key=>$val) {
				if ($val != '') {
                    if (in_array($key, array('SURV_WI_LEASE', 'SURV_OS_LEASE'))){
                        $returnValue = ($validate->chkFloatCharac($val, 2, 6) == false) ? null : $returnValue;
                        if ($val < 0 || $val > 100) { $returnValue = null ; }
                    } else {
                        $returnValue = ($validate->maxLen($val, 15) == false) ? null : $returnValue;
                        $returnValue = ($validate->numeric($val) == false) ? null : $returnValue;
                    }
				} else {
					$returnValue = null ;
				}
			}

            return $returnValue;
			
		}

	} 
?>