<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
    use App\Controller\MonthlyController;
	
	class ORawMatConsumeTable extends Table{

		var $name = "ORawMatConsume";
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getRecordIdNew($formType, $retrunType, $returnDate, $end_user_id, $userType) {

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
        
        public function getAllData($formType, $retrunType, $returnDate, $end_user_id, $userType) {

            $query = $this->find('all')
                    ->where(['form_type'=>$formType])
                    ->where(['return_type'=>$retrunType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['end_user_id'=>$end_user_id])
                    ->where(['user_type'=>$userType])
                    ->toArray();
        
            /**
             * COMMENTED THE BELOW FIRST LINE AND ADDED THE NEXT LINE
             * ADDED FOR GETTING THE MINERAL NAME AND THERE RESPECTIVE UNITS AT ONCE
             * EARLIER POINTING TO MMS MINERAL UNIT TABLE 
             * @author Uday Shankar Singh
             * @version 27th June 2014
            */
            // $mineralUnit = DIR_MCP_MINERALTable::getAllUnit();
            $dirMeMineral = TableRegistry::getTableLocator()->get('DirMeMineral');
            $mineralUnit = $dirMeMineral->getAllMineralWithUnit();
            
            $count = count($query);
            $resultSet = array();
            $resultSet['totalCount'] = $count;
            for ($i = 0; $i < $count; $i++) {
                // $resultSet['rawmat_indus_' . ($i + 1)] = $query[$i]['INDUSTRY_NAME'];
                $resultSet['raw_mineral_' . ($i + 1)] = $query[$i]['mineral_name'];
                $resultSet['rawmat_ser_' . ($i + 1)] = $query[$i]['raw_material_search'];
                $resultSet['rawmat_physpe_' . ($i + 1)] = $query[$i]['raw_material_phy'];
                $resultSet['rawmat_chespe_' . ($i + 1)] = $query[$i]['raw_material_chem'];
                $resultSet['rawmat_prv_ind_' . ($i + 1)] = $query[$i]['prev_ind_year'];
                $resultSet['rawmat_prv_imp_' . ($i + 1)] = $query[$i]['prev_imp_year'];
                $resultSet['rawmat_pre_ind_' . ($i + 1)] = $query[$i]['pres_ind_year'];
                $resultSet['rawmat_pre_imp_' . ($i + 1)] = $query[$i]['pres_inm_year'];
                $resultSet['rawmat_nex_fin_yr_' . ($i + 1)] = $query[$i]['next_year_est'];
                $resultSet['rawmat_nextonex_fin_yr_' . ($i + 1)] = $query[$i]['future_est'];
                $resultSet['mineral_unit_' . ($i + 1)] = ($query[$i]['mineral_name'] == 'NIL') ? '' : $mineralUnit[$query[$i]['mineral_name']];
            }

            /**
             * SET BLANK RECORD ARRAY IF NO RECORD FOUNDS IN DATABASE
             * @version 07th Dec 2021
             * @author Aniket Ganvir
             */
            if ($count == 0) {
                $resultSet['totalCount'] = 1;
                $resultSet['raw_mineral_1'] = '';
                $resultSet['rawmat_ser_1'] = '';
                $resultSet['rawmat_physpe_1'] = '';
                $resultSet['rawmat_chespe_1'] = '';
                $resultSet['rawmat_prv_ind_1'] = '';
                $resultSet['rawmat_prv_imp_1'] = '';
                $resultSet['rawmat_pre_ind_1'] = '';
                $resultSet['rawmat_pre_imp_1'] = '';
                $resultSet['rawmat_nex_fin_yr_1'] = '';
                $resultSet['rawmat_nextonex_fin_yr_1'] = '';
                $resultSet['mineral_unit_1'] = '';
            }
            
            return $resultSet;

        }

        public function deleteRecordsetNew($formType, $retrunType, $returnDate, $end_user_id, $userType) {

            $query = $this->query();
            $query->delete()
                ->where(['form_type'=>$formType])
                ->where(['return_type'=>$retrunType])
                ->where(['return_date'=>$returnDate])
                ->where(['end_user_id'=>$end_user_id])
                ->where(['user_type'=>$userType])
                ->execute();

        }

	    public function saveFormDetails($params){

			$dataValidatation = $this->postDataValidate($params);

			if ($dataValidatation == 1){

	        	$formType = $params['fType'];
	        	$returnType = $params['return_type'];
	        	$returnDate = $params['return_date'];
	        	$endUserId = $params['end_user_id'];
	        	$userType = $params['user_type'];

				$result = '1';
                
                $exsistanceCheck = $this->getRecordIdNew($formType, $returnType, $returnDate, $endUserId, $userType);

                if ($exsistanceCheck['status'] == 1) {
                    $this->deleteRecordsetNew($formType, $returnType, $returnDate, $endUserId, $userType);
                }

                $records = count($params['raw_mineral']);
                $srno = 1;
                for ($i = 0; $i < $records; $i++) {

                    $newEntity = $this->newEntity(array(
                        'form_type' => "O",
                        'return_type' => $returnType,
                        'return_date' => $returnDate,
                        'end_user_id' => $endUserId,
                        // 'industry_name' => $params['rawmat_indus_' . $i],
                        // 'mineral_name' => $mineral, 
                        'mineral_name' => $params['raw_mineral'][$i], // ADDED BY UDAY .. EARLIER IT  WAS LIKE ABOVE... 
                        // 'raw_material_search' => $params['rawmat_ser'][$i]; // COMMNETD BY UDAY .. AS PER THE REQUIREMENT SENT ON 11th JUNE 2013
                        'raw_material_phy' => $params['rawmat_physpe'][$i],
                        'raw_material_chem' => $params['rawmat_chespe'][$i],
                        'prev_ind_year' => $params['rawmat_prv_ind'][$i],
                        'prev_imp_year' => $params['rawmat_prv_imp'][$i],
                        'pres_ind_year' => $params['rawmat_pre_ind'][$i],
                        'pres_inm_year' => $params['rawmat_pre_imp'][$i],
                        'next_year_est' => $params['rawmat_nex_fin_yr'][$i],
                        'future_est' => $params['rawmat_nextonex_fin_yr'][$i],
                        'user_type' => $userType,
                        'srno' => $srno,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s')
                    ));
                    if($this->save($newEntity)){
                        //
                    } else {
                        $result = false;
                    }
                    $srno++;
                    
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

            $count = count($params['raw_mineral']);
            if (is_numeric($count) && $count > 0) {

                for ($i = 0; $i < $count; $i++) {

                    $mineral_name = $params['raw_mineral'][$i];
                    $raw_material_phy = $params['rawmat_physpe'][$i];
                    $raw_material_chem = $params['rawmat_chespe'][$i];
                    $prev_ind_year = $params['rawmat_prv_ind'][$i];
                    $prev_imp_year = $params['rawmat_prv_imp'][$i];
                    $pres_ind_year = $params['rawmat_pre_ind'][$i];
                    $pres_inm_year = $params['rawmat_pre_imp'][$i];
                    $next_year_est = $params['rawmat_nex_fin_yr'][$i];
                    $future_est = $params['rawmat_nextonex_fin_yr'][$i];

                    if ($mineral_name == '') { $returnValue = null; }

                    if ($raw_material_phy != '') {
                        $returnValue = (strlen($raw_material_phy) > 100) ? null : $returnValue;
                    }
                    else { $returnValue = null; }
                    
                    if ($raw_material_chem != '') {
                        $returnValue = (strlen($raw_material_chem) > 100) ? null : $returnValue;
                    }
                    else { $returnValue = null; }
                    
                    // $years = array('prev_ind_year', 'prev_imp_year', 'pres_ind_year', 'pres_inm_year', 'next_year_est', 'future_est');
                    // foreach ($years as $year) {
                    //     if (${$year} != '') {
                    //         $returnValue = ($validate->numeric(${$year}) == false) ? null : $returnValue;
                    //         $returnValue = ($validate->chkFloatCharac(${$year}, 3, 19) == false) ? null : $returnValue;
                    //         $returnValue = ($validate->chkDecimalPlaces(${$year}, 3) == false) ? null : $returnValue;
                    //     }
                    //     else { $returnValue = null; }
                    // }
                    if ($prev_ind_year != '') {
                        $returnValue = ($validate->numeric($prev_ind_year) == false) ? null : $returnValue;
                        $returnValue = ($validate->chkFloatCharac($prev_ind_year, 3, 20) == false) ? null : $returnValue;
                        $returnValue = ($validate->chkDecimalPlaces($prev_ind_year, 3) == false) ? null : $returnValue;
                    }
                    if ($prev_imp_year != '') {
                        $returnValue = ($validate->numeric($prev_imp_year) == false) ? null : $returnValue;
                        $returnValue = ($validate->chkFloatCharac($prev_imp_year, 3, 20) == false) ? null : $returnValue;
                        $returnValue = ($validate->chkDecimalPlaces($prev_imp_year, 3) == false) ? null : $returnValue;
                    }
                    if ($pres_ind_year != '') {
                        $returnValue = ($validate->numeric($pres_ind_year) == false) ? null : $returnValue;
                        $returnValue = ($validate->chkFloatCharac($pres_ind_year, 3, 20) == false) ? null : $returnValue;
                        $returnValue = ($validate->chkDecimalPlaces($pres_ind_year, 3) == false) ? null : $returnValue;
                    }
                    if ($pres_inm_year != '') {
                        $returnValue = ($validate->numeric($pres_inm_year) == false) ? null : $returnValue;
                        $returnValue = ($validate->chkFloatCharac($pres_inm_year, 3, 20) == false) ? null : $returnValue;
                        $returnValue = ($validate->chkDecimalPlaces($pres_inm_year, 3) == false) ? null : $returnValue;
                    }
                    if ($next_year_est != '') {
                        $returnValue = ($validate->numeric($next_year_est) == false) ? null : $returnValue;
                        $returnValue = ($validate->chkFloatCharac($next_year_est, 3, 20) == false) ? null : $returnValue;
                        $returnValue = ($validate->chkDecimalPlaces($next_year_est, 3) == false) ? null : $returnValue;
                    }
                    if ($future_est != '') {
                        $returnValue = ($validate->numeric($future_est) == false) ? null : $returnValue;
                        $returnValue = ($validate->chkFloatCharac($future_est, 3, 20) == false) ? null : $returnValue;
                        $returnValue = ($validate->chkDecimalPlaces($future_est, 3) == false) ? null : $returnValue;
                    }

                }

            } else { $returnValue = null; }
			
			return $returnValue;
			
		}
        
        public function getMineralSelectedInRawMaterialForm($formType, $returnType, $returnDate, $endUserId) {

            $query = $this->find()
                    ->select(["mineral_name"])
                    ->where(['form_type'=>$formType])
                    ->where(['return_type'=>$returnType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['end_user_id'=>$endUserId])
                    ->toArray();

            $resultSet = Array();
            foreach ($query as $data) {
                $resultSet[] = $data['mineral_name'];
            }

            return $resultSet;

        }
        
		/**
		* Used to check for the final submit
		* Returns 1 if the form is filled
		* Returns 0 if the form is not filled
        * @version 07th Dec 2021
        * @author Aniket Ganvir
		*/
		public function isFilled($formType, $returnType, $returnDate, $end_user_id, $userType) {

            $records = $this->find()
                    ->select(['id'])
                    ->where(['form_type'=>$formType])
                    ->where(['return_type'=>$returnType])
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


	}
?>