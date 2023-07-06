<?php 
	namespace app\Model\Table;
	use App\Controller\MonthlyController;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class CostProductionTable extends Table{

		var $name = "CostProduction";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}
        
        public function getCostId($mineCode, $returnType, $returnDate) {

            $query = $this->find()
                ->select(['id', 'created_at'])
                ->where(["mine_code"=>$mineCode])
                ->where(["return_type"=>$returnType])
                ->where(["return_date"=>$returnDate])
                ->toArray();

            if (count($query) > 0) {
                return $query[0];
            } else {
                return array();
            }

        }
        
        public function getAllData($dataId) {

            $dataId = (isset($dataId['id'])) ? $dataId['id'] : '';
            $query = $this->find()
                ->where(['id'=>$dataId])
                ->toArray();

            if (count($query) > 0) {
                return $query[0];
            } else {
                return array();
            }

        }

        public function getData($mineCode, $returnType, $returnDate) {

            $query = $this->find()
                ->where(["mine_code"=>$mineCode])
                ->where(["return_type"=>$returnType])
                ->where(["return_date"=>$returnDate])
                ->toArray();

            if (count($query) == 0) {
                $data = array();
                $data['total_direct_cost'] = '';
                $data['exploration_cost'] = '';
                $data['mining_cost'] = '';
                $data['beneficiation_cost'] = '';
                $data['overhead_cost'] = '';
                $data['depreciation_cost'] = '';
                $data['interest_cost'] = '';
                $data['royalty_cost'] = '';
                $data['past_pay_dmf'] = '';
                $data['past_pay_nmet'] = '';
                $data['taxes_cost'] = '';
                $data['dead_rent_cost'] = '';
                $data['others_spec'] = '';
                $data['others_cost'] = '';
                $data['total_cost'] = '';
            } else {
                $data = $query[0];
            }

            return $data;

        }
        
	    public function saveFormDetails($params){

			$postData = $this->postDataValidation($params);

			if($postData['data_status'] == 1 ){

	            $mineCode = $postData['mine_code'];
                $returnDate = $postData['return_date'];
                $returnType = $postData['return_type'];
				
                $result = 1;
				$date = date('Y-m-d H:i:s');

                $costData = $this->getCostId($mineCode, 'ANNUAL', $returnDate);
				if (isset($costData['id']) && $costData['id'] != '') {
					$rowId = $costData['id'];
					$created_at = $costData['created_at'];
				} else {
					$rowId = '';
					$created_at = $date;
				}
                
				$newEntity = $this->newEntity(array(
                    'id' => $rowId,
                    'mine_code' => $mineCode,
                    'return_date' => $returnDate,
                    'return_type' => 'ANNUAL',
                    'total_direct_cost' => $postData['TOTAL_DIRECT_COST'],
                    'exploration_cost' => $postData['EXPLORATION_COST'],
                    'mining_cost' => $postData['MINING_COST'],
                    'beneficiation_cost' => $postData['BENEFICIATION_COST'],
                    'overhead_cost' => $postData['OVERHEAD_COST'],
                    'depreciation_cost' => $postData['DEPRECIATION_COST'],
                    'interest_cost' => $postData['INTEREST_COST'],
                    'royalty_cost' => $postData['ROYALTY_COST'],
                    
                    // In new form, Two new extra fields are required in "COST OF PRODUCTION" details section.
                    // So added two new fields "PAST_PAY_DMF" and "PAST_PAY_NMET". 
                    // Done By Pravin Bhakare 18-08-2020
                    'past_pay_dmf' => $postData['PAST_PAY_DMF'],
                    'past_pay_nmet' => $postData['PAST_PAY_NMET'],
                    
                    'taxes_cost' => $postData['TAXES_COST'],
                    'dead_rent_cost' => $postData['DEAD_RENT_COST'],
                    'others_cost' => $postData['OTHERS_COST'],
                    'others_spec' => $postData['OTHERS_SPEC'],
                    'total_cost' => $postData['TOTAL_COST'],

					'created_at' => $created_at,
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

	    public function postDataValidation($params){
			
			$dataStatus = 1;
			
			if(empty($params['mine_code'])){ $dataStatus = null ; }
			if(empty($params['return_date'])){ $dataStatus = null ; }
			if(empty($params['return_type'])){ $dataStatus = null ; }
			
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;

            $dataStatus = ($validate->minLen($params['TOTAL_DIRECT_COST'], 1) == false) ? null : $dataStatus;
            $dataStatus = ($validate->chkFloatCharac($params['TOTAL_DIRECT_COST'], 2, 8) == false) ? null : $dataStatus;
            
            $dataStatus = ($validate->minLen($params['EXPLORATION_COST'], 1) == false) ? null : $dataStatus;
            $dataStatus = ($validate->chkFloatCharac($params['EXPLORATION_COST'], 2, 8) == false) ? null : $dataStatus;
            
            $dataStatus = ($validate->minLen($params['MINING_COST'], 1) == false) ? null : $dataStatus;
            $dataStatus = ($validate->chkFloatCharac($params['MINING_COST'], 2, 8) == false) ? null : $dataStatus;
            
            $dataStatus = ($validate->minLen($params['BENEFICIATION_COST'], 1) == false) ? null : $dataStatus;
            $dataStatus = ($validate->chkFloatCharac($params['BENEFICIATION_COST'], 2, 8) == false) ? null : $dataStatus;
            
            $dataStatus = ($validate->minLen($params['OVERHEAD_COST'], 1) == false) ? null : $dataStatus;
            $dataStatus = ($validate->chkFloatCharac($params['OVERHEAD_COST'], 2, 8) == false) ? null : $dataStatus;
            
            $dataStatus = ($validate->minLen($params['DEPRECIATION_COST'], 1) == false) ? null : $dataStatus;
            $dataStatus = ($validate->chkFloatCharac($params['DEPRECIATION_COST'], 2, 8) == false) ? null : $dataStatus;
            
            $dataStatus = ($validate->minLen($params['INTEREST_COST'], 1) == false) ? null : $dataStatus;
            $dataStatus = ($validate->chkFloatCharac($params['INTEREST_COST'], 2, 8) == false) ? null : $dataStatus;
            
            $dataStatus = ($validate->minLen($params['ROYALTY_COST'], 1) == false) ? null : $dataStatus;
            $dataStatus = ($validate->chkFloatCharac($params['ROYALTY_COST'], 2, 8) == false) ? null : $dataStatus;
            
            $dataStatus = ($validate->minLen($params['PAST_PAY_DMF'], 1) == false) ? null : $dataStatus;
            $dataStatus = ($validate->chkFloatCharac($params['PAST_PAY_DMF'], 2, 8) == false) ? null : $dataStatus;
            
            $dataStatus = ($validate->minLen($params['PAST_PAY_NMET'], 1) == false) ? null : $dataStatus;
            $dataStatus = ($validate->chkFloatCharac($params['PAST_PAY_NMET'], 2, 8) == false) ? null : $dataStatus;
            
            $dataStatus = ($validate->minLen($params['TAXES_COST'], 1) == false) ? null : $dataStatus;
            $dataStatus = ($validate->chkFloatCharac($params['TAXES_COST'], 2, 8) == false) ? null : $dataStatus;
            
            $dataStatus = ($validate->minLen($params['DEAD_RENT_COST'], 1) == false) ? null : $dataStatus;
            $dataStatus = ($validate->chkFloatCharac($params['DEAD_RENT_COST'], 2, 8) == false) ? null : $dataStatus;
            
            $dataStatus = ($validate->minLen($params['DEAD_RENT_COST'], 1) == false) ? null : $dataStatus;
            $dataStatus = ($validate->chkFloatCharac($params['DEAD_RENT_COST'], 2, 8) == false) ? null : $dataStatus;

            if ($params['OTHERS_SPEC'] != '' && $params['OTHERS_SPEC'] != 0) {
                $dataStatus = ($validate->chkFloatCharac($params['OTHERS_COST'], 2, 8) == false) ? null : $dataStatus;
            }
            
            if ($params['OTHERS_COST'] != '' && $params['OTHERS_COST'] > 0) {
                $dataStatus = ($validate->maxLen($params['OTHERS_SPEC'], 18) == false) ? null : $dataStatus;
                if ($params['OTHERS_SPEC'] == '') { $dataStatus = null ; }
            }
            
            if ($params['OTHERS_SPEC'] == '' && $params['OTHERS_COST'] == '') {
                $params['OTHERS_COST'] = 0;
            }

            // check all form fields for total required
            $fieldList = ['TOTAL_DIRECT_COST', 'OVERHEAD_COST', 'DEPRECIATION_COST', 'INTEREST_COST', 'ROYALTY_COST', 'PAST_PAY_DMF', 'PAST_PAY_NMET', 'TAXES_COST', 'DEAD_RENT_COST', 'OTHERS_COST'];
            $fieldCount = count($fieldList);
            
            $check = 0;
            $fieldCost = 0;
            for ($i = 0; $i < $fieldCount; $i++) {
                $fieldValue = $params[$fieldList[$i]];
                if ($fieldValue > 0) {
                    $check = 1;
                }

                $fieldCost = $fieldCost + $params[$fieldList[$i]];

            }
            if ($check != 0) {

                if ($params['TOTAL_COST'] == '') { $dataStatus = null ; }
                $dataStatus = ($validate->chkFloatCharac($params['TOTAL_COST'], 2, 9) == false) ? null : $dataStatus;

                $enteredCost = $params['TOTAL_COST'];
                // if ($fieldCost != $enteredCost) {
                //     // $msg = "Entered total is not equal to the calculated total";
                //     $dataStatus = null ;
                // }

            }

            // check total direct cost
            $directCost = $params['TOTAL_DIRECT_COST'];
            $total = $params['EXPLORATION_COST'] + $params['MINING_COST'] + $params['BENEFICIATION_COST'];
            $total = round($total, 2);
            if ($directCost != $total) {
                // $msg = "Direct cost is not equal to the sum of Exploration,Mining and Beneficiation cost";
                $dataStatus = null ;
            }

            $params['data_status'] = $dataStatus;
            return $params;
			
		}

		/**
		 * Check filled status of section
		 * @version 01st Nov 2021
		 * @author Aniket Ganvir
		 */
        public function isFilled($mineCode, $returnType, $returnDate) {

			$records = $this->find()
                ->where(["mine_code"=>$mineCode])
                ->where(["return_type"=>$returnType])
                ->where(["return_date"=>$returnDate])
				->count();
			if ($records > 0) {
				return true;
			} else {
				return false;
			}

        }

	} 
?>