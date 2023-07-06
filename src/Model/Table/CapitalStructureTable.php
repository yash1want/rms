<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use App\Controller\MonthlyController;
	use Cake\Datasource\ConnectionManager;
	
	class CapitalStructureTable extends Table{

		var $name = "CapitalStructure";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        /**
         * GETS ALL THE DATA FOR THE CAPITAL STRUCTURE PAGE
         * @param string $mineCode
         * @return array containing all the field values of the capital structure
         */
        public function getAllData($mineCode, $returnDate) {

            $query = $this->find()
                ->where(['user_mine_code'=>$mineCode])
                ->where(['return_date'=>$returnDate])
                ->toArray();

            $capitalCount = count($query);
            $dynamicRowCount = ($capitalCount / 6);

            $result_set = Array();
            $common_data_set = Array();
            $dynamic_result_set = Array();

            $MonthlyController = new MonthlyController;
            $capitalStrucKeys = $MonthlyController->Clscommon->getCapitalStructureKeys();

            //===========================FIXED PART OF THE PAGE=========================
            $result_set['assests_value'] = (isset($query[0]['assests_value'])) ? $query[0]['assests_value'] : '';
            $result_set['selected_mine_code'] = json_decode(isset($query[0]['selected_mine_code']) ? $query[0]['selected_mine_code'] : '');
            $result_set['paid_share'] = (isset($query[0]['paid_share'])) ? $query[0]['paid_share'] : '';
            $result_set['own_Capital'] = (isset($query[0]['own_capital'])) ? $query[0]['own_capital'] : '';
            $result_set['reserve'] = (isset($query[0]['reserve'])) ? $query[0]['reserve'] : '';
            $result_set['loan_outstanding'] = (isset($query[0]['loan_outstanding'])) ? $query[0]['loan_outstanding'] : '';
            $result_set['interest_paid'] = (isset($query[0]['interest_paid'])) ? $query[0]['interest_paid'] : '';
            $result_set['rent_paid'] = (isset($query[0]['rent_paid'])) ? $query[0]['rent_paid'] : '';
            //========================FIXED PART OF THE PAGE ENDS=======================

            $j = 0;
            for ($i = 0; $i < $capitalCount; $i++) {

            //====NEED TO SEND AS PER THE COMMON_KEY THAT ARE BEING CREATED===========
            if ($i < 6) {
                $common_data_set[$capitalStrucKeys[$i]['at_year_beg']] = $query[$i]['at_year_beg'];
                $common_data_set[$capitalStrucKeys[$i]['add_during_year']] = $query[$i]['add_during_year'];
                $common_data_set[$capitalStrucKeys[$i]['sold_during_year']] = $query[$i]['sold_during_year'];
                $common_data_set[$capitalStrucKeys[$i]['dep_during_year']] = $query[$i]['dep_during_year'];
                $common_data_set[$capitalStrucKeys[$i]['closing_bal']] = $query[$i]['closing_bal'];
                $common_data_set[$capitalStrucKeys[$i]['estimated_value']] = $query[$i]['estimated_value'];
            }
            //========================================================================
            // ============================DYNAMIC PART===============================
            if ($i % 6 == 0) {
                $j += 1;
                $dynamic_result_set['institute_name_' . $j] = $query[$i]['institution_name'];
                $dynamic_result_set['loan_amount_' . $j] = $query[$i]['loan_amount'];
                $dynamic_result_set['interest_rate_' . $j] = $query[$i]['interest_rate'];
            }
            // =======================================================================
            }

            // define blank variables by default if there's no records in db
            if ($capitalCount == 0) {
                for ($n = 0; $n < 6; $n++) {
                    $common_data_set[$capitalStrucKeys[$n]['at_year_beg']] = '';
                    $common_data_set[$capitalStrucKeys[$n]['add_during_year']] = '';
                    $common_data_set[$capitalStrucKeys[$n]['sold_during_year']] = '';
                    $common_data_set[$capitalStrucKeys[$n]['dep_during_year']] = '';
                    $common_data_set[$capitalStrucKeys[$n]['closing_bal']] = '';
                    $common_data_set[$capitalStrucKeys[$n]['estimated_value']] = '';
                }
                
                $dynamic_result_set['institute_name_1'] = '';
                $dynamic_result_set['loan_amount_1'] = '';
                $dynamic_result_set['interest_rate_1'] = '';

                $dynamicRowCount = 1;
            }

            $capital_result_set = Array();
            $capital_result_set['fixed_result'] = $result_set;
            $capital_result_set['common_result'] = $common_data_set;
            $capital_result_set['dynamic_result'] = $dynamic_result_set;
            $capital_result_set['dynamic_result']['rowCount'] = $dynamicRowCount;
            
            return $capital_result_set;
        }

        public function getFiledMines($mineOwnerId, $returnDate) {

            $query = $this->find()
                ->select(['selected_mine_code'])
                ->where(['mine_owner_id'=>$mineOwnerId])
                ->where(['return_date'=>$returnDate])
                ->toArray();
            
            $filedMineCodes = array();
            if(count($query) > 0){
                // two loops
                $filedMineCodes = json_decode($query[0]['selected_mine_code']);
            }
            
            return $filedMineCodes;
            
        }

        public function getFiledMinesByCurrentUser($mineCode, $returnDate) {

            $query = $this->find()
                ->select(['selected_mine_code'])
                ->where(['user_mine_code'=>$mineCode])
                ->where(['return_date'=>$returnDate])
                ->toArray();
            
            $filedMineCodes = array();
            if(count($query) > 0){
                // two loops
                $filedMineCodes = json_decode($query[0]['selected_mine_code']);
            }
            
            return $filedMineCodes;
            
        }

        public function getRecordId($mineCode, $returnDate) {

            $query = $this->find()
                ->select(['id'])
                ->where(['user_mine_code'=>$mineCode])
                ->where(['return_date'=>$returnDate])
                ->toArray();
        
            $rowCount = count($query);
            if ($rowCount > 0) {
              return 1;
            }
            else {
                return 0;
            }

        }

        public function deleteRecordset($mineCode, $returnDate) {

            $query = $this->query();
            $query->delete()
                ->where(['user_mine_code'=>$mineCode])
                ->where(['return_date'=>$returnDate])
                ->execute();

        }
        
	    public function savePostData($params){

			$postData = $this->postDataValidate($params);

			if ($postData['data_status'] == 1) {

	            $mineCode = $postData['mine_code'];
                $returnDate = $postData['return_date'];
                $returnType = $postData['return_type'];
                $institution_count = $postData['institutionCount'];
                $mineOwner = $postData['mine_owner'];
				
                $result = 1;
				$date = date('Y-m-d H:i:s');
                
	            $MonthlyCntrl = new MonthlyController;
				$getCommonIds = $MonthlyCntrl->Clscommon->getCapitalStructureKeys();
				
                $exsistanceCheck = $this->getRecordId($mineCode, $returnDate);
                if ($exsistanceCheck == 1) {
                    $this->deleteRecordset($mineCode, $returnDate);
                }
                
                for ($j = 1; $j <= $institution_count; $j++) {
                    for ($i = 0; $i < 6; $i++) {

                        $newEntity = $this->newEntity(array(
                            'mine_owner_id' => $mineOwner,
                            'user_mine_code' => $mineCode,
                            'assests_value' => $postData['assests_value'],
                            'selected_mine_code' => json_encode($postData['selected_mine_code']),
                            'return_date' => $returnDate,
                            'at_year_beg' => $postData[$getCommonIds[$i]['at_year_beg']],
                            'add_during_year' => $postData[$getCommonIds[$i]['add_during_year']],
                            'sold_during_year' => $postData[$getCommonIds[$i]['sold_during_year']],
                            'dep_during_year' => $postData[$getCommonIds[$i]['dep_during_year']],
                            'closing_bal' => $postData[$getCommonIds[$i]['closing_bal']],
                            'estimated_value' => $postData[$getCommonIds[$i]['estimated_value']],
                            // $capStrucClassObj->total = $params[$getCommonIds[$i]['total']];
                            'paid_share' => $postData['paid_share'],
                            'own_capital' => $postData['own_Capital'],
                            'reserve' => $postData['reserve'],
                            'loan_outstanding' => $postData['loan_outstanding'],
                  
                            // DYNAMIC PART... A SEPERATE ROW WILL BE CREATED IN THE DB FOR EVERY 
                            // ENTRY OF INSTITUTION NAME
                            /* =============================================================== */
                            'institution_name' => $postData['institute_name_' . $j],
                            'loan_amount' => $postData['loan_amount_' . $j],
                            'interest_rate' => $postData['interest_rate_' . $j],
                            /* =============================================================== */
                  
                            'interest_paid' => $postData['interest_paid'],
                            'rent_paid' => $postData['rent_paid'],
                            'created_at' => $date,
                            'updated_at' => $date
                        ));
                    
                        if ($this->save($newEntity)) {
                            //
                        } else {
                            $result = false;
                        }
                
                    }
                }

                return $result;

			} else {
				return false;
			}

	    }

	    public function postDataValidate($params){
			
			$dataStatus = 1;
			
			if(empty($params['mine_code'])){ $dataStatus = null ; }
			if(empty($params['return_date'])){ $dataStatus = null ; }
			if(empty($params['return_type'])){ $dataStatus = null ; }
			if(empty($params['institutionCount'])){ $dataStatus = null ; }
			if(empty($params['mine_owner'])){ $dataStatus = null ; }
			
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;
            $getCommonIds = $MonthlyCntrl->Clscommon->getCapitalStructureKeys();
            $institution_count = $params['institutionCount'];

            // common fields
            $paid_share = $params['paid_share'];
            if ($paid_share != '') {
                $dataStatus = ($validate->numeric($paid_share) == false) ? null : $dataStatus;
                $dataStatus = ($validate->maxLen($paid_share, 15) == false) ? null : $dataStatus;
            } else { $params['paid_share'] = 0; }
            
            $own_capital = $params['own_Capital'];
            if ($own_capital != '') {
                $dataStatus = ($validate->numeric($own_capital) == false) ? null : $dataStatus;
                $dataStatus = ($validate->maxLen($own_capital, 15) == false) ? null : $dataStatus;
            } else { $params['own_Capital'] = 0; }
            
            $reserve = $params['reserve'];
            if ($reserve != '') {
                $dataStatus = ($validate->numeric($reserve) == false) ? null : $dataStatus;
                $dataStatus = ($validate->maxLen($reserve, 15) == false) ? null : $dataStatus;
            } else { $params['reserve'] = 0; }
            
            $loan_outstanding = $params['loan_outstanding'];
            if ($loan_outstanding != '') {
                $dataStatus = ($validate->numeric($loan_outstanding) == false) ? null : $dataStatus;
                $dataStatus = ($validate->maxLen($loan_outstanding, 15) == false) ? null : $dataStatus;
            } else { $params['loan_outstanding'] = 0; }
            
            $interest_paid = $params['interest_paid'];
            if ($interest_paid != '') {
                $dataStatus = ($validate->numeric($interest_paid) == false) ? null : $dataStatus;
                $dataStatus = ($validate->maxLen($interest_paid, 12) == false) ? null : $dataStatus;
            } else { $dataStatus = null ; }
            
            $rent_paid = $params['rent_paid'];
            if ($rent_paid != '') {
                $dataStatus = ($validate->numeric($rent_paid) == false) ? null : $dataStatus;
                $dataStatus = ($validate->maxLen($rent_paid, 12) == false) ? null : $dataStatus;
            } else { $dataStatus = null ; }

            
            for ($j = 1; $j <= $institution_count; $j++) {
                for ($i = 0; $i < 6; $i++) {

                    $params['assests_value'] = ($params['total_close_bal'] != '') ? $params['total_close_bal'] : 0;
                    
                    $at_year_beg = $params[$getCommonIds[$i]['at_year_beg']];
                    if ($at_year_beg != '') {
                        $dataStatus = ($validate->numeric($at_year_beg) == false) ? null : $dataStatus;
                        $dataStatus = ($validate->maxLen($at_year_beg, 15) == false) ? null : $dataStatus;
                    } else { $params[$getCommonIds[$i]['at_year_beg']] = 0; }
                    
                    $add_during_year = $params[$getCommonIds[$i]['add_during_year']];
                    if ($add_during_year != '') {
                        $dataStatus = ($validate->numeric($add_during_year) == false) ? null : $dataStatus;
                        $dataStatus = ($validate->maxLen($add_during_year, 15) == false) ? null : $dataStatus;
                    } else { $params[$getCommonIds[$i]['add_during_year']] = 0; }
                    
                    $sold_during_year = $params[$getCommonIds[$i]['sold_during_year']];
                    if ($sold_during_year != '') {
                        $dataStatus = ($validate->numeric($sold_during_year) == false) ? null : $dataStatus;
                        $dataStatus = ($validate->maxLen($sold_during_year, 15) == false) ? null : $dataStatus;
                    } else { $params[$getCommonIds[$i]['sold_during_year']] = 0; }
                    
                    $dep_during_year = $params[$getCommonIds[$i]['dep_during_year']];
                    if ($dep_during_year != '') {
                        $dataStatus = ($validate->numeric($dep_during_year) == false) ? null : $dataStatus;
                        $dataStatus = ($validate->maxLen($dep_during_year, 15) == false) ? null : $dataStatus;
                    } else { $params[$getCommonIds[$i]['dep_during_year']] = 0; }
                    
                    $closing_bal = $params[$getCommonIds[$i]['closing_bal']];
                    if ($closing_bal != '') {
                        // Fields (2+3)-(4+5) value must be equal to field 6 value
                        $net_closing_bal_calc = ($at_year_beg + $add_during_year) - ($sold_during_year + $dep_during_year);
                        if ($closing_bal != $net_closing_bal_calc) {
                            $dataStatus = null ;
                        }
                        $dataStatus = ($validate->numeric($closing_bal) == false) ? null : $dataStatus;
                        $dataStatus = ($validate->maxLen($closing_bal, 15) == false) ? null : $dataStatus;

                    }
                    
                    $estimated_value = $params[$getCommonIds[$i]['estimated_value']];
                    if ($estimated_value != '') {
                        $dataStatus = ($validate->numeric($estimated_value) == false) ? null : $dataStatus;
                        $dataStatus = ($validate->maxLen($estimated_value, 15) == false) ? null : $dataStatus;
                    } else { $params[$getCommonIds[$i]['estimated_value']] = 0; }
                    
                    // DYNAMIC PART
                    $loan_amount = $params['loan_amount_' . $j];
                    if ($loan_amount != '') {
                        $dataStatus = ($validate->numeric($loan_amount) == false) ? null : $dataStatus;
                        $dataStatus = ($validate->maxLen($loan_amount, 15) == false) ? null : $dataStatus;
                    } else { $params['loan_amount_' . $j] = 0; }
                    
                    $interest_rate = $params['interest_rate_' . $j];
                    if ($interest_rate != '') {
                        $dataStatus = ($validate->chkFloatCharac($interest_rate, 2, 5) == false) ? null : $dataStatus;
                    } else { $params['interest_rate_' . $j] = 0; }
            
                }

            }

            $params['data_status'] = $dataStatus;
            return $params;
			
		}

		/**
		 * Check filled status of section
		 * @version 29th Oct 2021
		 * @author Aniket Ganvir
		 */
		public function isFilled($mineCode, $returnDate) {
            
			$records = $this->find()
                ->where(['user_mine_code'=>$mineCode])
                ->where(['return_date'=>$returnDate])
				->count();

            if ($records > 0) {
                return true;
            } else {
                return false;
            }

		}


	} 
?>