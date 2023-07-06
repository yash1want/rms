<?php 
	namespace app\Model\Table;
	use App\Controller\MonthlyController;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\Datasource\ConnectionManager;
	
	class RentReturnsTable extends Table{

		var $name = "RentReturns";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

	  //chk record is exists or not
	  public function chkMineReturns($mineCode, $returnType, $returnDate) {
	    $query = $this->find('all')
	            ->select(['mine_code', 'return_type', 'return_date'])
	            ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate])
	            ->toArray();

	    if ($query) {
	      return true;
	    } else {
	      return false;
	    }
	  }


	  //fetch returns by mine code, return type and return date
	  public function fetchMineReturns($mineCode, $returnType, $returnDate) {
	    $query = $this->find('all')
	            ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate])
	            ->toArray();

	    if (count($query) > 0)
	      return $query[0];
	    else
	      return array();
	  }


		/**
		 * fetch returns by return id
		 * @addedon 10th MAR 2021 (by Aniket Ganvir)
		 */
		public function findOneById($returnId){

			$query = $this->find('all')
	            ->where(["id"=>$returnId])
	            ->toArray();

		    if (count($query) > 0)
		      return $query[0];
		    else
		      return array();

		}

		// get rent details by mine code
		// @addedon 10th MAR 2021 (by Aniket Ganvir)
	    public function getRentReturnsDetails($mineCode, $returnType, $returnDate) {
	        
		    $mc = $this->find('all')
		            ->where(['mine_code'=>$mineCode,'return_date'=>$returnDate,'return_type'=>$returnType])
		            ->toArray();

		    if (count($mc) > 0) {
		    	$data = $mc[0];
		    } else {
		    	$data = Array("id"=>"", "mine_code"=>"", "return_type"=>$returnType, "return_date"=>$returnDate, "status_receipt"=>"", "mineral_name"=>"", "reporting"=>"", "wholly_employed_gme"=>"", "partly_employed_gme"=>"", "wholly_employed_dme"=>"", "partly_employed_dme"=>"", "wholly_employed_geologist"=>"", "partly_employed_geologist"=>"", "wholly_employed_surveyor"=>"", "partly_employed_surveyor"=>"", "wholly_employed_other"=>"", "partly_employed_other"=>"", "no_work_days"=>"", "no_shifts"=>"", "no_below_employees"=>"", "date_below_employees"=>"", "no_all_employees"=>"", "date_all_employees"=>"", "total_staff_salaries"=>"", "month_staff_salaries"=>"", "current_royalty"=>"", "past_royalty"=>"0", "current_dead_rent"=>"", "past_dead_rent"=>"0", "past_pay_dmf"=>"0", "past_pay_nmet"=>"0", "current_surface_rent"=>"", "past_surface_rent"=>"0", "current_pay_dmf"=>"", "current_pay_nmet"=>"", "total_rent"=>"", "total_rent_royalty"=>"", "tree_compensation"=>"", "depreciation"=>"", "central_sales_tax"=>"", "state_sales_tax"=>"", "central_welfare_cess"=>"", "state_welfare_cess"=>"", "central_mineral_cess"=>"", "state_mineral_cess"=>"", "central_cdr"=>"", "state_cdr"=>"", "central_other_taxes"=>"", "state_other_taxes"=>"", "other_taxes_spec"=>"", "overheads"=>"", "maintenance"=>"", "benefits_workmen"=>"", "payment_agencies"=>"", "drilling_no"=>"", "drilling_meterage"=>"", "drilling_grid"=>"", "trenching_no"=>"", "trenching_meterage"=>"", "trenching_grid"=>"", "pitting_no"=>"", "pitting_meterage"=>"", "pitting_grid"=>"", "bench_ore_mec"=>"", "bench_ore_man"=>"", "bench_ob_mec"=>"", "bench_ob_man"=>"", "height_ore_mec"=>"", "height_ore_man"=>"", "height_ob_mec"=>"", "height_ob_man"=>"", "depth_mec"=>"", "depth_man"=>"", "total_rom"=>"", "oc_mineral_rejects"=>"", "oc_grade_mineral_rejects"=>"", "tot_over_qty"=>"", "tot_over_qty_cumu"=>"", "year_back_filled"=>"", "cum_back_filled"=>"", "year_disposed_off"=>"", "cum_disposed_off"=>"", "ore_driving"=>"", "barren_drives"=>"", "winzing"=>"", "raising"=>"", "shaft_sinking"=>"", "stope_prep"=>"", "ore_stoping"=>"", "ug_waste"=>"", "ug_mineral_rejects"=>"", "ug_grade_mineral_rejects"=>"", "trees_inside"=>"", "trees_outside"=>"", "survival_rate"=>"", "plant_capacity"=>"", "feed_tonnage"=>"", "feed_avg_grade"=>"", "concentrates_tonnage"=>"", "concentrates_avg_grade"=>"", "tailings_tonnage"=>"", "tailings_avg_grade"=>"", "surface_plans_prepared"=>"", "ug_plans_prepared"=>"", "surface_plans_updated"=>"", "ug_plans_updated"=>"", "salient_factors"=>"", "depth_ore_mec"=>"", "depth_ore_man"=>"", "depth_ob_mec"=>"", "depth_ob_man"=>"", "total_rejects"=>"", "date_of_entry"=>"", "created_at"=>"", "updated_at"=>"", "oc_quantity"=>"", "oc_grade"=>"", "ug_quantity"=>"", "ug_grade"=>"", "species"=>"", "h_form_type"=>"");
		    }

		    return $data;
	    }
		
		/**
		 * @param string $mineCode
		 * @param string $returnType
		 * @param date $returnDate
		 * @param int $formType
		 * @return if data then record id else null
		 */
		public function getReturnsId($mineCode, $returnType, $returnDate, $formType) {

			$query = $this->find()
				->select(['id', 'created_at'])
				->where(["mine_code"=>$mineCode])
				->where(["return_type"=>$returnType])
				->where(["return_date"=>$returnDate])
				->where(["h_form_type"=>$formType])
				->toArray();

			if (count($query) > 0) {
				return $query[0];
			} else {
				return null;
			}

		}

		function getAllData($mineCode, $returnType, $returnDate, $formType) {

			$query = $this->find()
				->where(["mine_code"=>$mineCode])
				->where(["return_type"=>$returnType])
				->where(["return_date"=>$returnDate])
				->where(["h_form_type"=>$formType])
				->toArray();

			if (count($query) > 0) {
				$data = $query[0];
			} else {
				$data = array();
				$data['wholly_employed_gme'] = '';
				$data['partly_employed_gme'] = '';
				$data['wholly_employed_dme'] = '';
				$data['partly_employed_dme'] = '';
				$data['wholly_employed_geologist'] = '';
				$data['partly_employed_geologist'] = '';
				$data['wholly_employed_surveyor'] = '';
				$data['partly_employed_surveyor'] = '';
				$data['wholly_employed_other'] = '';
				$data['partly_employed_other'] = '';
				$data['no_work_days'] = '';
				$data['no_shifts'] = '';
			}
			return $data;

		}

		// save or update form data
	    public function saveFormDetails($forms_data){

			$dataValidatation = $this->postDataValidation($forms_data);

			if($dataValidatation == 1 ){

	            $reply = $forms_data['reply'];
	            $section = $forms_data['section_no'];

	            $formId = $forms_data['form_no'];
	            $mineCode = $forms_data['mine_code'];
	        	$return_type = $forms_data['return_type'];
	        	$return_date = $forms_data['return_date'];

	        	$rentData = $this->getRentReturnsDetails($mineCode, $return_type, $return_date);
	        	if($rentData['id']!=""){
	        		$row_id = $rentData['id'];
	        		$status_receipt = $rentData['status_receipt'];
	        		$created_at = $rentData['created_at'];
	        		$reporting = $rentData['reporting'];
	        	} else {
	        		$row_id = '';
	        		$status_receipt = "RECEIVED";
	        		$created_at = date('Y-m-d H:i:s');
	        		$reporting = null;
	        	}

	        	$past_surface_rent = $forms_data['f_past_surface_rent'];
	        	$past_royalty = $forms_data['f_past_royalty'];
	        	$past_dead_rent = $forms_data['f_past_dead_rent'];
	        	$past_pay_dmf = $forms_data['f_past_pay_dmf'];
	        	$past_pay_nmet = $forms_data['f_past_pay_nmet'];

	        	$currentDateTime = date('Y-m-d H:i:s');

	        	// $return_date = date('Y-m-d',strtotime($return_date));

				$newEntity = $this->newEntity(array(
					'id'=>$row_id,
					'mine_code'=>$mineCode,
					'return_type'=>$return_type,
					'return_date'=>$return_date,
					'status_receipt'=>$status_receipt,
					'reporting'=>$reporting,
					'past_surface_rent'=>$past_surface_rent,
					'past_royalty'=>$past_royalty,
					'past_dead_rent'=>$past_dead_rent,
					'past_pay_dmf'=>$past_pay_dmf,
					'past_pay_nmet'=>$past_pay_nmet,
					'created_at'=>$created_at,
					'updated_at'=>$currentDateTime
				));
				if($this->save($newEntity)){
					return 1;
				} else {
					return false;
				}
			} else {
				return false;
			}

	    }

    	public function postDataValidation($forms_data){
			
			$returnValue = 1;
			
			if(!is_numeric($forms_data['f_past_surface_rent'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_past_royalty'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_past_dead_rent'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_past_pay_dmf'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_past_pay_nmet'])){ $returnValue = null ; }

			if(empty($forms_data['mine_code'])){ $returnValue = null ; }

			if(strlen($forms_data['f_past_surface_rent']) > '12' || strlen($forms_data['f_past_surface_rent']) == 0){ $returnValue = null ; }
			if(strlen($forms_data['f_past_royalty']) > '12' || strlen($forms_data['f_past_royalty']) == 0){ $returnValue = null ; }
			if(strlen($forms_data['f_past_dead_rent']) > '12' || strlen($forms_data['f_past_dead_rent']) == 0){ $returnValue = null ; }
			if(strlen($forms_data['f_past_pay_dmf']) > '12' || strlen($forms_data['f_past_pay_dmf']) == 0){ $returnValue = null ; }
			if(strlen($forms_data['f_past_pay_nmet']) > '12' || strlen($forms_data['f_past_pay_nmet']) == 0){ $returnValue = null ; }
			
			return $returnValue;
			
		}

		
		/**
		* Used to check for the final submit
		* Returns 1 if the form is not filled
		* Returns 0 if the form is filled
		* @param type $mineCode
		* @param type $returnDate
		* @param type $returnType
		* @return int 
		*/
		public function isFilled($mineCode, $returnDate, $returnType) {

			$query = $this->find('all')
			        ->select(['past_surface_rent', 'past_royalty', 'past_dead_rent', 'past_pay_dmf', 'past_pay_nmet'])
			        ->where(["mine_code"=>$mineCode, "return_type"=>$returnType, "return_date"=>$returnDate])
			        ->toArray();

			if (count($query) == 0)
			  return 1;

			foreach ($query as $r) {
			  if ($r['past_surface_rent'] == "" || $r['past_royalty'] == "" || $r['past_dead_rent'] == "" || $r['past_pay_dmf'] == "" || $r['past_pay_nmet'] == "")
			    return 1;
			}

			return 0;
		}
				
		//==============================TAXES QUERY ==================================
		public function checkOverHead($mineCode, $returnType, $returnDate, $formType) {

			$query = $this->find()
				->select(['overheads'])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>$returnType])
				->where(['return_date'=>$returnDate])
				->where(['h_form_type'=>$formType])
				->toArray();

			if (count($query) > 0) {
				return $query[0]['overheads'];
			} else {
				return null;
			}

		}

		//========GETTING SUM OF MONTHLY RETURN ROYALTY TOTAL FOR ANNUAL CHECK========
		public function getRoyaltyMonthlyTotal($mineCode, $returnType, $startDate, $endDate) {

	        $con = ConnectionManager::get(Configure::read('conn'));
			$q = $con->execute("CALL SP_Royality('$mineCode', '$returnType', '$startDate', '$endDate');");
			$totalCal = $q->fetchAll('assoc');
			return ($totalCal[0]['royaltyTotal']);

		}

		public function getMatConsRoyaltyDetails($mineCode, $returnDate, $formType, $pdfStatus = 0) {

			$mc = $this->find()
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>"ANNUAL"])
				->where(['h_form_type'=>$formType])
				->toArray();
		
			$data = array();
			if (count($mc) > 0) {
				$data['ROYALTY_CURRENT'] = $mc[0]['current_royalty'];
				$data['ROYALTY_PAST'] = $mc[0]['past_royalty'];
				$data['DEAD_RENT_CURRENT'] = $mc[0]['current_dead_rent'];
				$data['DEAD_RENT_PAST'] = $mc[0]['past_dead_rent'];
				$data['SURFACE_RENT_CURRENT'] = $mc[0]['current_surface_rent'];
				$data['SURFACE_RENT_PAST'] = $mc[0]['past_surface_rent'];
				
				/*
				In new form, four new extra fields are added. So add four new fields 
				"CURRENT_PAY_DMF", "PAST_PAY_DMF", "CURRENT_PAY_NMET", "PAST_PAY_NMET"
				Done by Pravin Bhakare, 18/8/2020
				*/
				$data['CURRENT_PAY_DMF'] = $mc[0]['current_pay_dmf'];
				$data['PAST_PAY_DMF'] = $mc[0]['past_pay_dmf'];
				$data['CURRENT_PAY_NMET'] = $mc[0]['current_pay_nmet'];
				$data['PAST_PAY_NMET'] = $mc[0]['past_pay_nmet'];
				
				$data['TREE_COMPENSATION'] = $mc[0]['tree_compensation'];
				$data['DEPRECIATION'] = $mc[0]['depreciation'];
			} elseif ($pdfStatus == 0) {
				
				/**
				 * Prefetch the monthly records data for annual returns.
				 * Effective from Phase - II
				 * @version 25th Oct 2021
				 * @author Aniket Ganvir
				 */
				$con = ConnectionManager::get(Configure::read('conn'));
				$starDate = (date('Y',strtotime($returnDate))).'-04-01';
            	$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';

				$str = "SELECT 
					SUM(past_surface_rent) AS past_surface_rent,
					SUM(past_royalty) AS past_royalty,
					SUM(past_dead_rent) AS past_dead_rent,
					SUM(past_pay_dmf) AS past_pay_dmf,
					SUM(past_pay_nmet) AS past_pay_nmet
					FROM `rent_returns`
					WHERE mine_code = '$mineCode' 
					AND return_date BETWEEN '$starDate' AND '$endDate' 
					AND return_type = 'MONTHLY'";
					
				$mcMonthly = $con->execute($str)->fetchAll('assoc');

				$data['ROYALTY_CURRENT'] = $mcMonthly[0]['past_surface_rent'];
				$data['ROYALTY_PAST'] = '';
				$data['DEAD_RENT_CURRENT'] = $mcMonthly[0]['past_royalty'];
				$data['DEAD_RENT_PAST'] = '';
				$data['SURFACE_RENT_CURRENT'] = $mcMonthly[0]['past_dead_rent'];
				$data['SURFACE_RENT_PAST'] = '';
				$data['CURRENT_PAY_DMF'] = $mcMonthly[0]['past_pay_dmf'];
				$data['PAST_PAY_DMF'] = '';
				$data['CURRENT_PAY_NMET'] = $mcMonthly[0]['past_pay_nmet'];
				$data['PAST_PAY_NMET'] = '';
				$data['TREE_COMPENSATION'] = '';
				
				//========GETTING DEPRICIATION TOTAL VALUE FROM CAPITAL STRUCTURE===========
	            $capitalStructure = TableRegistry::getTableLocator()->get('CapitalStructure');
				$depriciationAllData = $capitalStructure->getAllData($mineCode, $returnDate);
				$depriciationTotal = $depriciationAllData['common_result']['total_depreciated'];

				$data['DEPRECIATION'] = $depriciationTotal;
			} else {
				$data['ROYALTY_CURRENT'] = '';
				$data['ROYALTY_PAST'] = '';
				$data['DEAD_RENT_CURRENT'] = '';
				$data['DEAD_RENT_PAST'] = '';
				$data['SURFACE_RENT_CURRENT'] = '';
				$data['SURFACE_RENT_PAST'] = '';
				$data['CURRENT_PAY_DMF'] = '';
				$data['PAST_PAY_DMF'] = '';
				$data['CURRENT_PAY_NMET'] = '';
				$data['PAST_PAY_NMET'] = '';
				$data['TREE_COMPENSATION'] = '';
				//========GETTING DEPRICIATION TOTAL VALUE FROM CAPITAL STRUCTURE===========
	            $capitalStructure = TableRegistry::getTableLocator()->get('CapitalStructure');
				$depriciationAllData = $capitalStructure->getAllData($mineCode, $returnDate);
				$depriciationTotal = $depriciationAllData['common_result']['total_depreciated'];

				$data['DEPRECIATION'] = $depriciationTotal;
			}
		
			return $data;

		}
		
		/**
		 * Cumulative monthly data for annual return
		 * @version 08th Nov 2021
		 * @author Aniket Ganvir
		 */
		public function getMatConsRoyaltyDataMonthly($mineCode, $returnDate, $formType) {

			$con = ConnectionManager::get(Configure::read('conn'));
			$starDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';

			$str = "SELECT 
				SUM(past_surface_rent) AS past_surface_rent,
				SUM(past_royalty) AS past_royalty,
				SUM(past_dead_rent) AS past_dead_rent,
				SUM(past_pay_dmf) AS past_pay_dmf,
				SUM(past_pay_nmet) AS past_pay_nmet
				FROM `rent_returns`
				WHERE mine_code = '$mineCode' 
				AND return_date BETWEEN '$starDate' AND '$endDate' 
				AND return_type = 'MONTHLY'";
				
			$mcMonthly = $con->execute($str)->fetchAll('assoc');

			$data['ROYALTY_CURRENT'] = $mcMonthly[0]['past_surface_rent'];
			$data['DEAD_RENT_CURRENT'] = $mcMonthly[0]['past_royalty'];
			$data['SURFACE_RENT_CURRENT'] = $mcMonthly[0]['past_dead_rent'];
			$data['CURRENT_PAY_DMF'] = $mcMonthly[0]['past_pay_dmf'];
			$data['CURRENT_PAY_NMET'] = $mcMonthly[0]['past_pay_nmet'];
		
			return $data;

		}

		public function getMatConsTaxDetails($mineCode, $returnDate, $formType) {

			$mc = $this->find()
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>"ANNUAL"])
				->where(['h_form_type'=>$formType])
				->toArray();

			$data = array();
			if (count($mc) > 0) {
				$data['SALES_TAX_CENTRAL'] = $mc[0]['central_sales_tax'];
				$data['SALES_TAX_STATE'] = $mc[0]['state_sales_tax'];
				$data['WELFARE_TAX_CENTRAL'] = $mc[0]['central_welfare_cess'];
				$data['WELFARE_TAX_STATE'] = $mc[0]['state_welfare_cess'];
				$data['MIN_CESS_TAX_CENTRAL'] = $mc[0]['central_mineral_cess'];
				$data['MIN_CESS_TAX_STATE'] = $mc[0]['state_mineral_cess'];
				$data['DEAD_CESS_TAX_CENTRAL'] = $mc[0]['central_cdr'];
				$data['DEAD_CESS_TAX_STATE'] = $mc[0]['state_cdr'];
				$data['OTHER_TAX'] = $mc[0]['other_taxes_spec'];
				$data['OTHER_TAX_CENTRAL'] = $mc[0]['central_other_taxes'];
				$data['OTHER_TAX_STATE'] = $mc[0]['state_other_taxes'];
				$data['OVERHEADS'] = $mc[0]['overheads'];
				$data['MAINTENANCE'] = $mc[0]['maintenance'];
				$data['WORKMEN_BENEFITS'] = $mc[0]['benefits_workmen'];
				$data['PAYMENT_AGENCIES'] = $mc[0]['payment_agencies'];
			} else {
				$data['SALES_TAX_CENTRAL'] = '';
				$data['SALES_TAX_STATE'] = '';
				$data['WELFARE_TAX_CENTRAL'] = '';
				$data['WELFARE_TAX_STATE'] = '';
				$data['MIN_CESS_TAX_CENTRAL'] = '';
				$data['MIN_CESS_TAX_STATE'] = '';
				$data['DEAD_CESS_TAX_CENTRAL'] = '';
				$data['DEAD_CESS_TAX_STATE'] = '';
				$data['OTHER_TAX'] = '';
				$data['OTHER_TAX_CENTRAL'] = '';
				$data['OTHER_TAX_STATE'] = '';
				$data['OVERHEADS'] = '';
				$data['MAINTENANCE'] = '';
				$data['WORKMEN_BENEFITS'] = '';
				$data['PAYMENT_AGENCIES'] = '';
			}

			return $data;

		}

		/**
		 * Check filled status of section
		 * @version 29th Oct 2021
		 * @author Aniket Ganvir
		 */
		public function isFilledByFormType($mineCode, $returnType, $returnDate, $formType) {

			$records = $this->find()
				->where(["mine_code"=>$mineCode])
				->where(["return_type"=>$returnType])
				->where(["return_date"=>$returnDate])
				->where(["h_form_type"=>$formType])
				->count();
			if ($records > 0) {
				return true;
			} else {
				return false;
			}

		}
		
	    public function saveEmpWagesForm($params){

			$postData = $this->postDataEmpWagesValidate($params);

			if ($postData['data_status'] == 1) {

	            $mineCode = $postData['mine_code'];
                $returnDate = $postData['return_date'];
                $returnType = $postData['return_type'];
				
                $result = 1;
				$date = date('Y-m-d H:i:s');
				
				//form type for employment wages => 1
				$formType = '1';
				//====GIVES THE ID OF THE DATABASE RECORD.. AS ONLY ONE FIELD IS SAVED FOR THIS FORM====
				$empWageData = $this->getReturnsId($mineCode, 'ANNUAL', $returnDate, $formType);
				if (isset($empWageData['id']) && $empWageData['id'] != '') {
					$rowId = $empWageData['id'];
					$created_at = $empWageData['created_at'];
				} else {
					$rowId = '';
					$created_at = $date;
				}
                
				$newEntity = $this->newEntity(array(
                    'id' => $rowId,
					'mine_code' => $mineCode,
					'return_type' => 'ANNUAL',
					'return_date' => $returnDate,
					'status_receipt' => 'RECEIVED',
					'wholly_employed_gme' => $postData['GRAD_MINING_WHOLLY'],
					'partly_employed_gme' => $postData['GRAD_MINING_PARTLY'],
					'wholly_employed_dme' => $postData['DIP_MINING_WHOLLY'],
					'partly_employed_dme' => $postData['DIP_MINING_PARTLY'],
					'wholly_employed_geologist' => $postData['GEO_WHOLLY'],
					'partly_employed_geologist' => $postData['GEO_PARTLY'],
					'wholly_employed_surveyor' => $postData['SURV_WHOLLY'],
					'partly_employed_surveyor' => $postData['SURV_PARTLY'],
					'wholly_employed_other' => $postData['OTHER_WHOLLY'],
					'partly_employed_other' => $postData['OTHER_PARTLY'],
					'no_work_days' => $postData['DAYS_MINE_WORKED'],
					'no_shifts' => $postData['NO_OF_SHIFTS'],
					/*'no_below_employees' => $postData['WORKING_BELOW_PER'],
					'date_below_employees' => clsCommon::changeDateFormat($postData['WORKING_BELOW_DATE']),
					'no_all_employees' => $postData['WORKING_ALL_PER'],
					'date_all_employees' => clsCommon::changeDateFormat($postData['WORKING_ALL_DATE']),*/
					'h_form_type' => '1',

					'created_at' => $created_at,
					'updated_at' => $date
				));
			
				if ($this->save($newEntity)) {
					//
				} else {
					$result = false;
				}


				//WORK STOPPAGE TABLE DATA
				$workStoppage = TableRegistry::getTableLocator()->get('WorkStoppage');
				$workStoppage->deleteAnnualRecords($mineCode, $returnDate);

				$workStoppageEntity = $workStoppage->newEntity(array(
					'mine_code' => $mineCode,
					'return_type' => 'ANNUAL',
					'return_date' => $returnDate,
					'stoppage_sn_1' => $postData['reason_1'],
					'stoppage_sn_2' => $postData['reason_2'],
					'stoppage_sn_3' => $postData['reason_3'],
					'stoppage_sn_4' => $postData['reason_4'],
					'stoppage_sn_5' => $postData['reason_5'],
					'stoppage_sn_6' => $postData['reason_6'],
					'stoppage_sn_7' => $postData['reason_7'],
					'stoppage_sn_8' => $postData['reason_8'],
					'stoppage_sn_9' => $postData['reason_9'],
					'stoppage_sn_10' => $postData['reason_10'],
					'stoppage_sn_11' => $postData['reason_11'],
					'stoppage_sn_12' => $postData['reason_12'],
					'stoppage_sn_13' => $postData['reason_13'],
					'stoppage_sn_14' => $postData['reason_14'],
					'stoppage_sn_15' => $postData['reason_15'],
					'no_days_1' => $postData['no_of_days_1'] == 0?"":$postData['no_of_days_1'],
					/**
					 * CHANGED THE  no_of_days_ to no_of_days_ MEANS
					 * EARLIER EVERYWHERE no_of_days_1 IS PASSING CHANGED IT TO SERIAL 
					 * 
					 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
					 * @version 21st Jan 2014
					 */      
					'no_days_2' => $postData['no_of_days_2'] == 0?"":$postData['no_of_days_2'],
					'no_days_3' => $postData['no_of_days_3'] == 0?"":$postData['no_of_days_3'],
					'no_days_4' => $postData['no_of_days_4'] == 0?"":$postData['no_of_days_4'],
					'no_days_5' => $postData['no_of_days_5'] == 0?"":$postData['no_of_days_5'],
					'no_days_6' => $postData['no_of_days_6'] == 0?"":$postData['no_of_days_6'],
					'no_days_7' => $postData['no_of_days_7'] == 0?"":$postData['no_of_days_7'],
					'no_days_8' => $postData['no_of_days_8'] == 0?"":$postData['no_of_days_8'],
					'no_days_9' => $postData['no_of_days_9'] == 0?"":$postData['no_of_days_9'],
					'no_days_10' => $postData['no_of_days_10'] == 0?"":$postData['no_of_days_10'],
					'no_days_11' => $postData['no_of_days_11'] == 0?"":$postData['no_of_days_11'],
					'no_days_12' => $postData['no_of_days_12'] == 0?"":$postData['no_of_days_12'],
					'no_days_13' => $postData['no_of_days_13'] == 0?"":$postData['no_of_days_13'],
					'no_days_14' => $postData['no_of_days_14'] == 0?"":$postData['no_of_days_14'],
					'no_days_15' => $postData['no_of_days_15'] == 0?"":$postData['no_of_days_15'],

					'created_at' => $date,
					'updated_at' => $date
				));
			
				if ($workStoppage->save($workStoppageEntity)) {
					//
				} else {
					$result = false;
				}

                return $result;

			} else {
				return false;
			}

	    }

	    public function postDataEmpWagesValidate($params){
			
			$dataStatus = 1;
			
			if(empty($params['mine_code'])){ $dataStatus = null ; }
			if(empty($params['return_date'])){ $dataStatus = null ; }
			if(empty($params['return_type'])){ $dataStatus = null ; }
			if(empty($params['reasons_len'])){ $dataStatus = null ; }
			
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;
			$reasonsLen = $params['reasons_len'];
			
			if ($params['GRAD_MINING_WHOLLY'] == '') {
				$params['GRAD_MINING_WHOLLY'] = 0;
			} else {
				$dataStatus = ($validate->numeric($params['GRAD_MINING_WHOLLY']) == false) ? null : $dataStatus;
				$dataStatus = ($params['GRAD_MINING_WHOLLY'] > 9999) ? null : $dataStatus;
			}
			
			if ($params['GRAD_MINING_PARTLY'] == '') {
				$params['GRAD_MINING_PARTLY'] = 0;
			} else {
				$dataStatus = ($validate->numeric($params['GRAD_MINING_PARTLY']) == false) ? null : $dataStatus;
				$dataStatus = ($params['GRAD_MINING_PARTLY'] > 9999) ? null : $dataStatus;
			}
			
			if ($params['DIP_MINING_WHOLLY'] == '') {
				$params['DIP_MINING_WHOLLY'] = 0;
			} else {
				$dataStatus = ($validate->numeric($params['DIP_MINING_WHOLLY']) == false) ? null : $dataStatus;
				$dataStatus = ($params['DIP_MINING_WHOLLY'] > 9999) ? null : $dataStatus;
			}
			
			if ($params['DIP_MINING_PARTLY'] == '') {
				$params['DIP_MINING_PARTLY'] = 0;
			} else {
				$dataStatus = ($validate->numeric($params['DIP_MINING_PARTLY']) == false) ? null : $dataStatus;
				$dataStatus = ($params['DIP_MINING_PARTLY'] > 9999) ? null : $dataStatus;
			}
			
			if ($params['GEO_WHOLLY'] == '') {
				$params['GEO_WHOLLY'] = 0;
			} else {
				$dataStatus = ($validate->numeric($params['GEO_WHOLLY']) == false) ? null : $dataStatus;
				$dataStatus = ($params['GEO_WHOLLY'] > 9999) ? null : $dataStatus;
			}
			
			if ($params['GEO_PARTLY'] == '') {
				$params['GEO_PARTLY'] = 0;
			} else {
				$dataStatus = ($validate->numeric($params['GEO_PARTLY']) == false) ? null : $dataStatus;
				$dataStatus = ($params['GEO_PARTLY'] > 9999) ? null : $dataStatus;
			}
			
			if ($params['SURV_WHOLLY'] == '') {
				$params['SURV_WHOLLY'] = 0;
			} else {
				$dataStatus = ($validate->numeric($params['SURV_WHOLLY']) == false) ? null : $dataStatus;
				$dataStatus = ($params['SURV_WHOLLY'] > 9999) ? null : $dataStatus;
			}
			
			if ($params['SURV_PARTLY'] == '') {
				$params['SURV_PARTLY'] = 0;
			} else {
				$dataStatus = ($validate->numeric($params['SURV_PARTLY']) == false) ? null : $dataStatus;
				$dataStatus = ($params['SURV_PARTLY'] > 9999) ? null : $dataStatus;
			}
			
			if ($params['OTHER_WHOLLY'] == '') {
				$params['OTHER_WHOLLY'] = 0;
			} else {
				$dataStatus = ($validate->numeric($params['OTHER_WHOLLY']) == false) ? null : $dataStatus;
				$dataStatus = ($params['OTHER_WHOLLY'] > 9999) ? null : $dataStatus;
			}
			
			if ($params['OTHER_PARTLY'] == '') {
				$params['OTHER_PARTLY'] = 0;
			} else {
				$dataStatus = ($validate->numeric($params['OTHER_PARTLY']) == false) ? null : $dataStatus;
				$dataStatus = ($params['OTHER_PARTLY'] > 9999) ? null : $dataStatus;
			}

			$errorFlag1 = false;
            $errorFlag2 = false;
			$errorFlag = false;
			for ($i=1; $i <= $reasonsLen; $i++) {

				if (isset($params['no_of_days_'.$i])) {

					if ($params['no_of_days_'.$i] != '') {
						$dataStatus = ($validate->maxLen($params['no_of_days_'.$i], 3) == false) ? null : $dataStatus;
						$dataStatus = ($validate->numeric($params['no_of_days_'.$i]) == false) ? null : $dataStatus;
						$dataStatus = ($params['no_of_days_'.$i] > 366) ? null : $dataStatus;
					}
					//NEED TO CHECK IN PHASE 1
					/*if ($params['no_of_days_'.$i] == '' || $params['no_of_days_'.$i] == 0){
						$errorFlag2 = true;
					}*/
					//NEED TO CHECK IN PHASE 1
					// CHECKING FOR ANY SELECTION OF REASONS
					// var allSelect1 = $(".select_reason");
					/*if ($params['reason_'.$i] != '') {
						$errorFlag1 = true;
					}*/

				}

			}
			
			if ($errorFlag2 == true && $errorFlag1 == true){
				$errorFlag = true;
			}

			if ($params['no_of_days_1'] == '') {
				$params['no_of_days_1'] = 0;
			}

			if ($params['DAYS_MINE_WORKED'] != 365 && $params['DAYS_MINE_WORKED'] != 366) {
				if ($errorFlag == true) {
					// alert("Number of days of work stoppage is not entered for one or more reasons or it is entered 0. Kindly provide correct details before proceeding.");
					$dataStatus = null ;
				}
			}

			if ($params['DAYS_MINE_WORKED'] != $params['no_days']) {
				//NEED TO CHECK IN PHASE 1
				/*if ($params['reason_1'] == '' || $params['no_of_days_1'] == '' || $params['no_of_days_1'] == 0) {
					$dataStatus = null ;
				}*/
			} else if ($params['DAYS_MINE_WORKED'] > $params['no_days']) {
				$dataStatus = null ;
			}
			
			if($params['DAYS_MINE_WORKED'] > 0){
				if ($params['NO_OF_SHIFTS'] == '' || $params['NO_OF_SHIFTS'] == 0){
					// alert(" No.of shifts per day can't be empty or 0. Kindly provide correct details before proceeding.");
					$dataStatus = null ;
				}
			}else{
				if ($params['NO_OF_SHIFTS'] == ''){
					// alert(" No.of shifts per day can't be empty. Kindly provide correct details before proceeding.");
					$dataStatus = null ;
				}
			}


            $params['data_status'] = $dataStatus;
            return $params;
			
		}

		
	    public function saveEmpWagesPartForm($params){

			$postData = $this->postDataEmpWagesPartValidate($params);

			if ($postData['data_status'] == 1) {

	            $mineCode = $postData['mine_code'];
                $returnDate = $postData['return_date'];
                $returnType = $postData['return_type'];
				
                $result = 1;
				$date = date('Y-m-d H:i:s');
	            $MonthlyCntrl = new MonthlyController;
				
				//form type for employment wages => 1
				$formType = '5';
				//====GIVES THE ID OF THE DATABASE RECORD.. AS ONLY ONE FIELD IS SAVED FOR THIS FORM====
				$empWagePartData = $this->getReturnsId($mineCode, 'ANNUAL', $returnDate, $formType);
				if (isset($empWagePartData['id']) && $empWagePartData['id'] != '') {
					$rowId = $empWagePartData['id'];
					$created_at = $empWagePartData['created_at'];
				} else {
					$rowId = '';
					$created_at = $date;
				}
                
				$newEntity = $this->newEntity(array(
                    'id' => $rowId,
					'mine_code' => $mineCode,
					'return_type' => 'ANNUAL',
					'return_date' => $returnDate,
					'status_receipt' => 'RECEIVED',
					'no_below_employees' => $postData['WORKING_BELOW_PER'],
					// 'date_below_employees' => clsCommon::changeDateFormat($params['WORKING_BELOW_DATE']),
					'date_below_employees' => $postData['WORKING_BELOW_DATE'],
					'no_all_employees' => $postData['WORKING_ALL_PER'],
					// 'date_all_employees' => clsCommon::changeDateFormat($params['WORKING_ALL_DATE']),
					'date_all_employees' => $postData['WORKING_ALL_DATE'],
					'h_form_type' => '5',
					'created_at' => $created_at,
					'updated_at' => $date
				));
			
				if ($this->save($newEntity)) {
					//
				} else {
					$result = false;
				}

				//EMPLOYMENT TABLE DATA
				$employment = TableRegistry::getTableLocator()->get('Employment');
				$employment->deleteAnnualRecords($mineCode, $returnDate);
				$classif_sn = array(2, 3, 4, 6, 7, 8, 10, 11, 12);
				$keys = $MonthlyCntrl->Clscommon->getEmploymentWagesKeys();

				for ($i = 0; $i < 9; $i++) {
					$employmentEntity = $employment->newEntity(array(
						'mine_code' => $mineCode,
						'return_type' => 'ANNUAL',
						'return_date' => $returnDate,
						'employee_classif_sn' => $classif_sn[$i],
						'direct_mandays' => $postData[$keys[$i]['direct']],
						'contract_mandays' => $postData[$keys[$i]['contract']],
						'no_work_days' => $postData[$keys[$i]['worked_days']],
						'male_avg_no' => $postData[$keys[$i]['male']],
						'female_avg_no' => $postData[$keys[$i]['female']],
						'total_salaries' => $postData[$keys[$i]['total_wage']],
						'total_tech_emp' => $postData['TOTAL_SALARY'],
						'created_at' => $date,
						'updated_at' => $date
					));
					
					if ($employment->save($employmentEntity)) {
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

	    public function postDataEmpWagesPartValidate($params){
			
			$dataStatus = 1;
			
			if(empty($params['mine_code'])){ $dataStatus = null ; }
			if(empty($params['return_date'])){ $dataStatus = null ; }
			if(empty($params['return_type'])){ $dataStatus = null ; }
			
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;
			
			$returnDate = $params['return_date'];
			$startDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
			$endDate = date('Y-m-t', strtotime($endDate));

			if ($params['WORKING_BELOW_DATE'] != '') {
				$dataStatus = ($validate->validateDate($params['WORKING_BELOW_DATE']) == false) ? null : $dataStatus;
				$params['WORKING_BELOW_DATE'] = $MonthlyCntrl->Clscommon->changeDateFormat($params['WORKING_BELOW_DATE']);
				if ($params['WORKING_BELOW_DATE'] < $startDate || $params['WORKING_BELOW_DATE'] > $endDate) {
					$dataStatus = null ;
				}
			}
			// else { $params['WORKING_BELOW_DATE'] = '0000-00-00'; }
			else { $params['WORKING_BELOW_DATE'] = null; }
			
			if ($params['WORKING_ALL_DATE'] != '') {
				$dataStatus = ($validate->validateDate($params['WORKING_ALL_DATE']) == false) ? null : $dataStatus;
				$params['WORKING_ALL_DATE'] = $MonthlyCntrl->Clscommon->changeDateFormat($params['WORKING_ALL_DATE']);
				if ($params['WORKING_ALL_DATE'] < $startDate || $params['WORKING_ALL_DATE'] > $endDate) {
					$dataStatus = null ;
				}
			}
			// else { $params['WORKING_ALL_DATE'] = '0000-00-00'; }
			else { $params['WORKING_ALL_DATE'] = null; }

			if ($params['WORKING_BELOW_PER'] != '') {
				$dataStatus = ($params['WORKING_BELOW_PER'] > 9999) ? null : $dataStatus;
				$dataStatus = ($validate->numeric($params['WORKING_BELOW_PER']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['WORKING_BELOW_PER'], 4) == false) ? null : $dataStatus;
			}
			else { $params['WORKING_BELOW_PER'] = '0'; }
			
			if ($params['WORKING_ALL_PER'] != '') {
				$dataStatus = ($params['WORKING_ALL_PER'] > 9999) ? null : $dataStatus;
				$dataStatus = ($validate->numeric($params['WORKING_ALL_PER']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['WORKING_ALL_PER'], 4) == false) ? null : $dataStatus;
			}
			else { $params['WORKING_ALL_PER'] = '0'; }


			// days validation
			if ($params['BELOW_FOREMAN_DAYS'] != '') {
				$dataStatus = ($params['BELOW_FOREMAN_DAYS'] > 366) ? null : $dataStatus;
				$dataStatus = ($validate->numeric($params['BELOW_FOREMAN_DAYS']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['BELOW_FOREMAN_DAYS'], 3) == false) ? null : $dataStatus;
			}
			else { $params['BELOW_FOREMAN_DAYS'] = '0'; }
			
			if ($params['OC_FOREMAN_DAYS'] != '') {
				$dataStatus = ($params['OC_FOREMAN_DAYS'] > 366) ? null : $dataStatus;
				$dataStatus = ($validate->numeric($params['OC_FOREMAN_DAYS']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['OC_FOREMAN_DAYS'], 3) == false) ? null : $dataStatus;
			}
			else { $params['OC_FOREMAN_DAYS'] = '0'; }
			
			if ($params['ABOVE_CLERICAL_DAYS'] != '') {
				$dataStatus = ($params['ABOVE_CLERICAL_DAYS'] > 366) ? null : $dataStatus;
				$dataStatus = ($validate->numeric($params['ABOVE_CLERICAL_DAYS']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['ABOVE_CLERICAL_DAYS'], 3) == false) ? null : $dataStatus;
			}
			else { $params['ABOVE_CLERICAL_DAYS'] = '0'; }


			// wages validation
			if ($params['BELOW_FOREMAN_TOTAL_WAGES'] != '') {
				$dataStatus = ($validate->chkFloatCharac($params['BELOW_FOREMAN_TOTAL_WAGES'], 2, 15) == false) ? null : $dataStatus;
			}
			else { $params['BELOW_FOREMAN_TOTAL_WAGES'] = '0'; }
			
			if ($params['OC_FOREMAN_TOTAL_WAGES'] != '') {
				$dataStatus = ($validate->chkFloatCharac($params['OC_FOREMAN_TOTAL_WAGES'], 2, 15) == false) ? null : $dataStatus;
			}
			else { $params['OC_FOREMAN_TOTAL_WAGES'] = '0'; }
			
			if ($params['ABOVE_CLERICAL_TOTAL_WAGES'] != '') {
				$dataStatus = ($validate->chkFloatCharac($params['ABOVE_CLERICAL_TOTAL_WAGES'], 2, 15) == false) ? null : $dataStatus;
			}
			else { $params['ABOVE_CLERICAL_TOTAL_WAGES'] = '0'; }


			// direct
			if ($params['BELOW_FOREMAN_DIRECT'] != '') {
				$dataStatus = ($validate->numeric($params['BELOW_FOREMAN_DIRECT']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['BELOW_FOREMAN_DIRECT'], 8) == false) ? null : $dataStatus;
			}
			else { $params['BELOW_FOREMAN_DIRECT'] = '0'; }
			
			if ($params['OC_FOREMAN_DIRECT'] != '') {
				$dataStatus = ($validate->numeric($params['OC_FOREMAN_DIRECT']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['OC_FOREMAN_DIRECT'], 8) == false) ? null : $dataStatus;
			}
			else { $params['OC_FOREMAN_DIRECT'] = '0'; }
			
			if ($params['ABOVE_CLERICAL_DIRECT'] != '') {
				$dataStatus = ($validate->numeric($params['ABOVE_CLERICAL_DIRECT']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['ABOVE_CLERICAL_DIRECT'], 8) == false) ? null : $dataStatus;
			}
			else { $params['ABOVE_CLERICAL_DIRECT'] = '0'; }
			

			// contract
			if ($params['BELOW_FOREMAN_CONTRACT'] != '') {
				$dataStatus = ($validate->numeric($params['BELOW_FOREMAN_CONTRACT']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['BELOW_FOREMAN_CONTRACT'], 8) == false) ? null : $dataStatus;
			}
			else { $params['BELOW_FOREMAN_CONTRACT'] = '0'; }
			
			if ($params['OC_FOREMAN_CONTRACT'] != '') {
				$dataStatus = ($validate->numeric($params['OC_FOREMAN_CONTRACT']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['OC_FOREMAN_CONTRACT'], 8) == false) ? null : $dataStatus;
			}
			else { $params['OC_FOREMAN_CONTRACT'] = '0'; }
			
			if ($params['ABOVE_CLERICAL_CONTRACT'] != '') {
				$dataStatus = ($validate->numeric($params['ABOVE_CLERICAL_CONTRACT']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['ABOVE_CLERICAL_CONTRACT'], 8) == false) ? null : $dataStatus;
			}
			else { $params['ABOVE_CLERICAL_CONTRACT'] = '0'; }
			

			// male
			if ($params['BELOW_FOREMAN_MALE'] != '') {
				$dataStatus = ($validate->chkFloatCharac($params['BELOW_FOREMAN_MALE'], 1, 6) == false) ? null : $dataStatus;
			}
			else { $params['BELOW_FOREMAN_MALE'] = '0'; }
			
			if ($params['OC_FOREMAN_MALE'] != '') {
				$dataStatus = ($validate->chkFloatCharac($params['OC_FOREMAN_MALE'], 1, 6) == false) ? null : $dataStatus;
			}
			else { $params['OC_FOREMAN_MALE'] = '0'; }
			
			if ($params['ABOVE_CLERICAL_MALE'] != '') {
				$dataStatus = ($validate->chkFloatCharac($params['ABOVE_CLERICAL_MALE'], 1, 6) == false) ? null : $dataStatus;
			}
			else { $params['ABOVE_CLERICAL_MALE'] = '0'; }

			
			// female
			if ($params['BELOW_FOREMAN_FEMALE'] != '') {
				$dataStatus = ($validate->chkFloatCharac($params['BELOW_FOREMAN_FEMALE'], 1, 6) == false) ? null : $dataStatus;
			}
			else { $params['BELOW_FOREMAN_FEMALE'] = '0'; }
			
			if ($params['OC_FOREMAN_FEMALE'] != '') {
				$dataStatus = ($validate->chkFloatCharac($params['OC_FOREMAN_FEMALE'], 1, 6) == false) ? null : $dataStatus;
			}
			else { $params['OC_FOREMAN_FEMALE'] = '0'; }
			
			if ($params['ABOVE_CLERICAL_FEMALE'] != '') {
				$dataStatus = ($validate->chkFloatCharac($params['ABOVE_CLERICAL_FEMALE'], 1, 6) == false) ? null : $dataStatus;
			}
			else { $params['ABOVE_CLERICAL_FEMALE'] = '0'; }

            $params['data_status'] = $dataStatus;
            return $params;
			
		}

		
	    public function saveMatConsRoyaltyForm($params){

			$postData = $this->postMatConsRoyaltyValidate($params);

			if ($postData['data_status'] == 1) {

	            $mineCode = $postData['mine_code'];
                $returnDate = $postData['return_date'];
                $returnType = $postData['return_type'];
				
                $result = 1;
				$date = date('Y-m-d H:i:s');
				
				/**
				 * form type for royality = 2 in RENT_RETURNS TABLE 
				 */
				$formType = 2;
				$matConsRoyData = $this->getReturnsId($mineCode, 'ANNUAL', $returnDate, $formType);
				if (isset($matConsRoyData['id']) && $matConsRoyData['id'] != '') {
					$rowId = $matConsRoyData['id'];
					$created_at = $matConsRoyData['created_at'];
				} else {
					$rowId = '';
					$created_at = $date;
				}

				$postData['ROYALTY_CURRENT'] = ($postData['ROYALTY_CURRENT']=='')?'0':$postData['ROYALTY_CURRENT'];

				$postData['ROYALTY_PAST'] = ($postData['ROYALTY_PAST']=='')?'0':$postData['ROYALTY_PAST'];

				$postData['DEAD_RENT_CURRENT'] = ($postData['DEAD_RENT_CURRENT']=='')?'0':$postData['DEAD_RENT_CURRENT'];

				$postData['DEAD_RENT_PAST'] = ($postData['DEAD_RENT_PAST']=='')?'0':$postData['DEAD_RENT_PAST'];

				$postData['SURFACE_RENT_CURRENT'] = ($postData['SURFACE_RENT_CURRENT']=='')?'0':$postData['SURFACE_RENT_CURRENT'];

				$postData['SURFACE_RENT_PAST'] = ($postData['SURFACE_RENT_PAST']=='')?'0':$postData['SURFACE_RENT_PAST'];

				$postData['CURRENT_PAY_DMF'] = ($postData['CURRENT_PAY_DMF']=='')?'0':$postData['CURRENT_PAY_DMF'];

				$postData['PAST_PAY_DMF'] = ($postData['PAST_PAY_DMF']=='')?'0':$postData['PAST_PAY_DMF'];

				$postData['CURRENT_PAY_NMET'] = ($postData['CURRENT_PAY_NMET']=='')?'0':$postData['CURRENT_PAY_NMET'];

				$postData['PAST_PAY_NMET'] = ($postData['PAST_PAY_NMET']=='')?'0':$postData['PAST_PAY_NMET'];

				$postData['TREE_COMPENSATION'] = ($postData['TREE_COMPENSATION']=='')?'0':$postData['TREE_COMPENSATION'];

				$postData['DEPRECIATION'] = ($postData['DEPRECIATION']=='')?'0':$postData['DEPRECIATION'];

                
				$newEntity = $this->newEntity(array(
                    'id' => $rowId,
					'mine_code' => $mineCode,
					'return_type' => 'ANNUAL',
					'return_date' => $returnDate,
					'status_receipt' => 'RECEIVED',
					'current_royalty' => $postData['ROYALTY_CURRENT'],
					'past_royalty' => $postData['ROYALTY_PAST'],
					'current_dead_rent' => $postData['DEAD_RENT_CURRENT'],
					'past_dead_rent' => $postData['DEAD_RENT_PAST'],
					'current_surface_rent' => $postData['SURFACE_RENT_CURRENT'],
					'past_surface_rent' => $postData['SURFACE_RENT_PAST'],
					
					/*
					  In new form, four new extra fields are added. So add four new fields 
					  "CURRENT_PAY_DMF", "PAST_PAY_DMF", "CURRENT_PAY_NMET", "PAST_PAY_NMET"
					  Done by Pravin Bhakare, 18/8/2020
				   */
					'current_pay_dmf' => $postData['CURRENT_PAY_DMF'],
					'past_pay_dmf' => $postData['PAST_PAY_DMF'],
					'current_pay_nmet' => $postData['CURRENT_PAY_NMET'],
					'past_pay_nmet' => $postData['PAST_PAY_NMET'],
					
					'tree_compensation' => $postData['TREE_COMPENSATION'],
					'depreciation' => $postData['DEPRECIATION'],
					'h_form_type' => $formType,
					'created_at' => $created_at,
					'updated_at' => $date
				));
				//print_r($newEntity);die;
			
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

	    public function postMatConsRoyaltyValidate($params){
			
			$dataStatus = 1;
			
			if(empty($params['mine_code'])){ $dataStatus = null ; }
			if(empty($params['return_date'])){ $dataStatus = null ; }
			if(empty($params['return_type'])){ $dataStatus = null ; }
			
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;

			if ($params['ROYALTY_CURRENT'] != '') {
				$dataStatus = ($validate->numeric($params['ROYALTY_CURRENT']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['ROYALTY_CURRENT'], 12) == false) ? null : $dataStatus;
			}
			//else { $dataStatus = null ; }
			
			if ($params['ROYALTY_PAST'] != '') {
				$dataStatus = ($validate->numeric($params['ROYALTY_PAST']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['ROYALTY_PAST'], 12) == false) ? null : $dataStatus;
			}
			//else { $dataStatus = null ; }
			
			if ($params['DEAD_RENT_CURRENT'] != '') {
				$dataStatus = ($validate->numeric($params['DEAD_RENT_CURRENT']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['DEAD_RENT_CURRENT'], 12) == false) ? null : $dataStatus;
			}
			//else { $dataStatus = null ; }
			
			if ($params['DEAD_RENT_PAST'] != '') {
				$dataStatus = ($validate->numeric($params['DEAD_RENT_PAST']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['DEAD_RENT_PAST'], 12) == false) ? null : $dataStatus;
			}
			//else { $dataStatus = null ; }
			
			if ($params['SURFACE_RENT_CURRENT'] != '') {
				$dataStatus = ($validate->numeric($params['SURFACE_RENT_CURRENT']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['SURFACE_RENT_CURRENT'], 12) == false) ? null : $dataStatus;
			}
			//else { $dataStatus = null ; }
			
			if ($params['SURFACE_RENT_PAST'] != '') {
				$dataStatus = ($validate->numeric($params['SURFACE_RENT_PAST']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['SURFACE_RENT_PAST'], 12) == false) ? null : $dataStatus;
			}
			//else { $dataStatus = null ; }
			
			if ($params['CURRENT_PAY_DMF'] != '') {
				$dataStatus = ($validate->numeric($params['CURRENT_PAY_DMF']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['CURRENT_PAY_DMF'], 12) == false) ? null : $dataStatus;
			}
			//else { $dataStatus = null ; }
			
			if ($params['PAST_PAY_DMF'] != '') {
				$dataStatus = ($validate->numeric($params['PAST_PAY_DMF']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['PAST_PAY_DMF'], 12) == false) ? null : $dataStatus;
			}
			//else { $dataStatus = null ; }
			
			if ($params['CURRENT_PAY_NMET'] != '') {
				$dataStatus = ($validate->numeric($params['CURRENT_PAY_NMET']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['CURRENT_PAY_NMET'], 12) == false) ? null : $dataStatus;
			}
			//else { $dataStatus = null ; }
			
			if ($params['PAST_PAY_NMET'] != '') {
				$dataStatus = ($validate->numeric($params['PAST_PAY_NMET']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['PAST_PAY_NMET'], 12) == false) ? null : $dataStatus;
			}
			//else { $dataStatus = null ; }
			
			if ($params['TREE_COMPENSATION'] != '') {
				$dataStatus = ($validate->numeric($params['TREE_COMPENSATION']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['TREE_COMPENSATION'], 12) == false) ? null : $dataStatus;
			}
			//else { $dataStatus = null ; }
			
			if ($params['DEPRECIATION'] != '') {
				$dataStatus = ($validate->numeric($params['DEPRECIATION']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['DEPRECIATION'], 12) == false) ? null : $dataStatus;
			}
			//else { $params['DEPRECIATION'] = 0; }

            $params['data_status'] = $dataStatus;
            return $params;
			
		}

	    public function saveMatConsTaxForm($params){

			$postData = $this->postMatConsTaxValidate($params);

			if ($postData['data_status'] == 1) {

	            $mineCode = $postData['mine_code'];
                $returnDate = $postData['return_date'];
                $returnType = $postData['return_type'];
				
                $result = 1;
				$date = date('Y-m-d H:i:s');
				
				/**
				 * form type for consumption tax  fields = 3 in RETURNS table
				 */
				$formType = 3;
				$matConsTaxData = $this->getReturnsId($mineCode, 'ANNUAL', $returnDate, $formType);
				if (isset($matConsTaxData['id']) && $matConsTaxData['id'] != '') {
					$rowId = $matConsTaxData['id'];
					$created_at = $matConsTaxData['created_at'];
				} else {
					$rowId = '';
					$created_at = $date;
				}
                
				$newEntity = $this->newEntity(array(
                    'id' => $rowId,
					'mine_code' => $mineCode,
					'return_type' => 'ANNUAL',
					'return_date' => $returnDate,
					'status_receipt' => 'RECEIVED',
					'central_sales_tax' => $postData['SALES_TAX_CENTRAL'],
					'state_sales_tax' => $postData['SALES_TAX_STATE'],
					'central_welfare_cess' => $postData['WELFARE_TAX_CENTRAL'],
					'state_welfare_cess' => $postData['WELFARE_TAX_STATE'],
					'central_mineral_cess' => $postData['MIN_CESS_TAX_CENTRAL'],
					'state_mineral_cess' => $postData['MIN_CESS_TAX_STATE'],
					'central_cdr' => $postData['DEAD_CESS_TAX_CENTRAL'],
					'state_cdr' => $postData['DEAD_CESS_TAX_STATE'],
					'other_taxes_spec' => $postData['OTHER_TAX'],
					'central_other_taxes' => $postData['OTHER_TAX_CENTRAL'],
					'state_other_taxes' => $postData['OTHER_TAX_STATE'],
					'overheads' => $postData['OVERHEADS'],
					'maintenance' => $postData['MAINTENANCE'],
					'benefits_workmen' => $postData['WORKMEN_BENEFITS'],
					'payment_agencies' => $postData['PAYMENT_AGENCIES'],
					'h_form_type' => $formType,
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

	    public function postMatConsTaxValidate($params){
			
			$dataStatus = 1;
			
			if(empty($params['mine_code'])){ $dataStatus = null ; }
			if(empty($params['return_date'])){ $dataStatus = null ; }
			if(empty($params['return_type'])){ $dataStatus = null ; }
			
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;

			if ($params['SALES_TAX_CENTRAL'] != '') {
				$dataStatus = ($validate->numeric($params['SALES_TAX_CENTRAL']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['SALES_TAX_CENTRAL'], 12) == false) ? null : $dataStatus;
			}
			else { $params['SALES_TAX_CENTRAL'] = 0; }
			
			if ($params['SALES_TAX_STATE'] != '') {
				$dataStatus = ($validate->numeric($params['SALES_TAX_STATE']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['SALES_TAX_STATE'], 12) == false) ? null : $dataStatus;
			}
			else { $params['SALES_TAX_STATE'] = 0; }
			
			if ($params['WELFARE_TAX_CENTRAL'] != '') {
				$dataStatus = ($validate->numeric($params['WELFARE_TAX_CENTRAL']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['WELFARE_TAX_CENTRAL'], 12) == false) ? null : $dataStatus;
			}
			else { $params['WELFARE_TAX_CENTRAL'] = 0; }
			
			if ($params['WELFARE_TAX_STATE'] != '') {
				$dataStatus = ($validate->numeric($params['WELFARE_TAX_STATE']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['WELFARE_TAX_STATE'], 12) == false) ? null : $dataStatus;
			}
			else { $params['WELFARE_TAX_STATE'] = 0; }
			
			if ($params['MIN_CESS_TAX_CENTRAL'] != '') {
				$dataStatus = ($validate->numeric($params['MIN_CESS_TAX_CENTRAL']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['MIN_CESS_TAX_CENTRAL'], 12) == false) ? null : $dataStatus;
			}
			else { $params['MIN_CESS_TAX_CENTRAL'] = 0; }
			
			if ($params['MIN_CESS_TAX_STATE'] != '') {
				$dataStatus = ($validate->numeric($params['MIN_CESS_TAX_STATE']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['MIN_CESS_TAX_STATE'], 12) == false) ? null : $dataStatus;
			}
			else { $params['MIN_CESS_TAX_STATE'] = 0; }
			
			if ($params['DEAD_CESS_TAX_CENTRAL'] != '') {
				$dataStatus = ($validate->numeric($params['DEAD_CESS_TAX_CENTRAL']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['DEAD_CESS_TAX_CENTRAL'], 12) == false) ? null : $dataStatus;
			}
			else { $params['DEAD_CESS_TAX_CENTRAL'] = 0; }

			if ($params['DEAD_CESS_TAX_STATE'] == '') {
				$params['DEAD_CESS_TAX_STATE'] = 0;
			}
			
			if ($params['OTHER_TAX'] != '') {
				$dataStatus = ($validate->maxLen($params['OTHER_TAX'], 100) == false) ? null : $dataStatus;
			}
			
			if ($params['OTHER_TAX'] != '' && $params['OTHER_TAX'] != 0) {
				$dataStatus = ($params['OTHER_TAX_STATE'] == '') ? null : $dataStatus;
			}
			
			if ($params['OTHER_TAX_STATE'] != '') {
				$dataStatus = ($validate->numeric($params['OTHER_TAX_STATE']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['OTHER_TAX_STATE'], 12) == false) ? null : $dataStatus;
			}
			else { $params['OTHER_TAX_STATE'] = 0; }
			
			if ($params['OTHER_TAX'] != '' && $params['OTHER_TAX'] > 0) {
				$dataStatus = ($params['OTHER_TAX_CENTRAL'] == '') ? null : $dataStatus;
			}
			
			if ($params['OTHER_TAX_CENTRAL'] != '') {
				$dataStatus = ($validate->numeric($params['OTHER_TAX_CENTRAL']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['OTHER_TAX_CENTRAL'], 12) == false) ? null : $dataStatus;
			}
			else { $params['OTHER_TAX_CENTRAL'] = 0; }
			
			if ($params['OVERHEADS'] != '') {
				$dataStatus = ($validate->numeric($params['OVERHEADS']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['OVERHEADS'], 12) == false) ? null : $dataStatus;
			}
			else { $params['OVERHEADS'] = 0; }
			
			if ($params['MAINTENANCE'] != '') {
				$dataStatus = ($validate->numeric($params['MAINTENANCE']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['MAINTENANCE'], 12) == false) ? null : $dataStatus;
			}
			else { $params['MAINTENANCE'] = 0; }
			
			if ($params['WORKMEN_BENEFITS'] != '') {
				$dataStatus = ($validate->numeric($params['WORKMEN_BENEFITS']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['WORKMEN_BENEFITS'], 12) == false) ? null : $dataStatus;
			}
			else { $params['WORKMEN_BENEFITS'] = 0; }
			
			if ($params['PAYMENT_AGENCIES'] != '') {
				$dataStatus = ($validate->numeric($params['PAYMENT_AGENCIES']) == false) ? null : $dataStatus;
				$dataStatus = ($validate->maxLen($params['PAYMENT_AGENCIES'], 12) == false) ? null : $dataStatus;
			}
			else { $params['PAYMENT_AGENCIES'] = 0; }
			
            $params['data_status'] = $dataStatus;
            return $params;
			
		}

		public function checkGeologyPart2Id($mineCode, $returnType, $returnDate, $formType, $mineralName) {

			$query = $this->find()
				->select(['id'])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>$returnType])
				->where(['return_date'=>$returnDate])
				->where(['mineral_name'=>$mineralName])
				->where(['h_form_type'=>$formType])
				->toArray();
		
			$i = 0;
			$result = Array();
			$resultSet = Array();
			foreach ($query as $data) {
				$result[$i] = $data['id'];
				$i++;
			}
		
			if ($query) {
				$resultSet['db_ids'] = $result;
				$resultSet['db_check'] = 1;
			} else {
				$resultSet['db_check'] = 0;
			}

			return $resultSet;

		}

		public function checkMineralDB($mineCode, $returnType, $returnDate,$mineralName) {

			$query = $this->find()
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>$returnType])
				->where(['return_date'=>$returnDate])
				->where(['mineral_name'=>$mineralName])
				->where(['h_form_type'=>6])
				->toArray();
	
			if ($query) {
			  return 1;
			}
			else
			  return 0;

		}
		
		//==========================GEOLOGY PART - 2 FUNCTIONS========================
		public function getAllGeology2Details($mineCode, $returnType, $returnDate, $mineralName) {

			$query = $this->find()
					->select(['id', 'mine_code', 'return_type', 'return_date', 'drilling_no', 
					'drilling_meterage', 'drilling_grid', 'trenching_no', 'trenching_meterage', 
					'trenching_grid', 'pitting_no', 'pitting_meterage', 'pitting_grid', 
					'total_rom', 'oc_mineral_rejects', 'oc_grade_mineral_rejects', 
					'oc_quantity', 'oc_grade', 'tot_over_qty', 'year_back_filled', 
					'cum_back_filled', 'year_disposed_off', 'cum_disposed_off', 'ore_driving',
					'barren_drives', 'winzing', 'raising', 'shaft_sinking', 'stope_prep', 
					'ore_stoping', 'ug_waste', 'ug_mineral_rejects', 'ug_grade_mineral_rejects', 
					'ug_quantity', 'ug_grade', 'trees_inside', 'trees_outside', 'species',
					'survival_rate', 'bench_ore_man', 'bench_ob_man', 'bench_ore_mec',
					'bench_ob_mec', 'height_ore_man', 'height_ob_man', 'height_ore_mec',
					'height_ob_mec', 'depth_ore_man', 'depth_ob_man', 'depth_ore_mec',
					'depth_ob_mec', 'depth_ore_man', 'depth_ob_man', 'depth_ore_mec'])
					->where(['mine_code'=>$mineCode])
					->where(['return_type'=>$returnType])
					->where(['return_date'=>$returnDate])
					->where(['h_form_type'=>4])
					->toArray();

			$i = 0;
			$benchCount = 0;
			$heightCount = 0;
			$depthCount = 0;
			$expDrillCount = 0;
			$expTrenchCount = 0;
			$exppitCount = 0;
			$benchResult = Array();
			$heightResult = Array();
			$depthResult = Array();
			$staticResult = Array();
			$explorationDrill = Array();
			$explorationTrench = Array();
			$explorationPit = Array();
			foreach ($query as $data) {
			//=========================DYNAMIC FIELDS STARTS==========================
			//====================CHECKING FOR BENCH NUMBER DATA======================
			if ($data['bench_ore_man'] != '' || $data['bench_ob_man'] != '' || $data['bench_ore_mec'] != '' || $data['bench_ob_mec'] != '') {
				$benchCount++;
				$benchResult['bench_count'] = $benchCount;
				if ($data['bench_ore_man'] != '' || $data['bench_ob_man'] != '') {
				$benchResult['bench_no_ore_select_' . $benchCount] = 1;
				$benchResult['bench_no_ore_input_' . $benchCount] = $data['bench_ore_man'];
				$benchResult['bench_no_waste_input_' . $benchCount] = $data['bench_ob_man'];
				} else if ($data['bench_ore_mec'] != '' || $data['bench_ob_mec'] != '') {
				$benchResult['bench_no_ore_select_' . $benchCount] = 2;
				$benchResult['bench_no_ore_input_' . $benchCount] = $data['bench_ore_mec'];
				$benchResult['bench_no_waste_input_' . $benchCount] = $data['bench_ob_mec'];
				}
			}
			//========================CHECKING FOR HEIGHT DATA========================
			if ($data['height_ore_man'] != '' || $data['height_ob_man'] != '' || $data['height_ore_mec'] != '' || $data['height_ob_mec'] != '') {
				$heightCount++;
				$heightResult['height_count'] = $heightCount;
				if ($data['height_ore_man'] != '' || $data['height_ob_man'] != '') {
				$heightResult['avg_height_ore_select_' . $heightCount] = 1;
				$heightResult['avg_height_ore_input_' . $heightCount] = $data['height_ore_man'];
				$heightResult['avg_height_waste_input_' . $heightCount] = $data['height_ob_man'];
				} else if ($data['height_ore_mec'] != '' || $data['height_ob_mec'] != '') {
				$heightResult['avg_height_ore_select_' . $heightCount] = 2;
				$heightResult['avg_height_ore_input_' . $heightCount] = $data['height_ore_mec'];
				$heightResult['avg_height_waste_input_' . $heightCount] = $data['height_ob_mec'];
				}
			}
			//========================CHECKING FOR DEPTH DATA=========================
			if ($data['depth_ore_man'] != '' || $data['depth_ob_man'] != '' || $data['depth_ore_mec'] != '' || $data['depth_ob_mec'] != '') {
				$depthCount++;
				$depthResult['depth_count'] = $depthCount;
				if ($data['depth_ore_man'] != '' || $data['depth_ob_man'] != '') {
				$depthResult['deepest_working_ore_select_' . $depthCount] = 1;
				$depthResult['deepest_working_ore_input_' . $depthCount] = $data['depth_ore_man'];
				$depthResult['deepest_working_waste_input_' . $depthCount] = $data['depth_ob_man'];
				} else if ($data['depth_ore_mec'] != '' || $data['depth_ob_mec'] != '') {
				$depthResult['deepest_working_ore_select_' . $depthCount] = 2;
				$depthResult['deepest_working_ore_input_' . $depthCount] = $data['depth_ore_mec'];
				$depthResult['deepest_working_waste_input_' . $depthCount] = $data['depth_ob_mec'];
				}
			}
			//========================Exploration Drill=========================

			if ($data['drilling_grid'] != '' || $data['drilling_meterage'] != '' || $data['drilling_no'] != '') {
				$expDrillCount++;
				$explorationDrill['drill_count'] = $expDrillCount;

				$explorationDrill['drill_grid_' . $expDrillCount] = $data['drilling_grid'];
				$explorationDrill['drill_meter_' . $expDrillCount] = $data['drilling_meterage'];
				$explorationDrill['drill_number_' . $expDrillCount] = $data['drilling_no'];
			}

			//========================Exploration Trenching=========================
			if ($data['trenching_grid'] != '' || $data['trenching_meterage'] != '' || $data['trenching_no'] != '') {
				$expTrenchCount++;
				$explorationTrench['trench_count'] = $expTrenchCount;

				$explorationTrench['trench_grid_' . $expTrenchCount] = $data['trenching_grid'];
				$explorationTrench['trench_meter_' . $expTrenchCount] = $data['trenching_meterage'];
				$explorationTrench['trench_number_' . $expTrenchCount] = $data['trenching_no'];
			}
			//========================Exploration Pitting=========================
			if ($data['pitting_grid'] != '' || $data['pitting_meterage'] != '' || $data['pitting_no'] != '') {
				$exppitCount++;
				$explorationPit['pit_count'] = $exppitCount;

				$explorationPit['pit_grid_' . $exppitCount] = $data['pitting_grid'];
				$explorationPit['pit_meter_' . $exppitCount] = $data['pitting_meterage'];
				$explorationPit['pit_number_' . $exppitCount] = $data['pitting_no'];
			}

			$i++;
			//=========================DYNAMIC FIELDS ENDS============================
			//=========================STATIC FIELDS STARTS===========================
			$staticResult['id'] = $data['id'];
			$staticResult['mine_code'] = $data['mine_code'];
			$staticResult['return_type'] = $data['return_type'];
			$staticResult['return_date'] = $data['return_date'];
			/* $staticResult['drill_number'] = $data['drilling_no'];
				$staticResult['drill_meter'] = $data['drilling_meterage'];
				$staticResult['drill_grid'] = $data['drilling_grid'];
				$staticResult['trench_number'] = $data['trenching_no'];
				$staticResult['trench_meter'] = $data['trenching_meterage'];
				$staticResult['trench_grid'] = $data['trenching_grid'];
				$staticResult['pit_number'] = $data['pitting_no'];
				$staticResult['pit_meter'] = $data['pitting_meterage'];
				$staticResult['pit_grid'] = $data['pitting_grid']; */
			$staticResult['TOTAL_ROM'] = $data['total_rom'];
			$staticResult['OC_MINERAL_REJECTS'] = $data['oc_mineral_rejects'];

			//=====================FOR THE OC MINERAL SELECT==========================
			$staticResult['OC_GRADE_MINERAL_REJECTS'] = $data['oc_grade_mineral_rejects'];
			//========================================================================

			$staticResult['OC_QUANTITY'] = $data['oc_quantity'];
			$staticResult['OC_GRADE'] = $data['oc_grade'];
			$staticResult['TOT_QTY_OVERBURDEN'] = $data['tot_over_qty'];
			$staticResult['YEAR_BACK_FILLED'] = $data['year_back_filled'];
			$staticResult['CUM_BACK_FILLED'] = $data['cum_back_filled'];
			$staticResult['YEAR_DISPOSED_OFF'] = $data['year_disposed_off'];
			$staticResult['CUM_DISPOSED_OFF'] = $data['cum_disposed_off'];
			$staticResult['ORE_DRIVING'] = $data['ore_driving'];
			$staticResult['BARREN_DRIVES'] = $data['barren_drives'];
			$staticResult['WINZING'] = $data['winzing'];
			$staticResult['RAISING'] = $data['raising'];
			$staticResult['SHAFT_SINKING'] = $data['shaft_sinking'];
			$staticResult['STOPE_PREP'] = $data['stope_prep'];
			$staticResult['ORE_STOPING'] = $data['ore_stoping'];
			$staticResult['UG_WASTE'] = $data['ug_waste'];
			$staticResult['UG_MINERAL_REJECTS'] = $data['ug_mineral_rejects'];

			//=====================FOR THE UG MINERAL SELECT==========================
			$staticResult['UG_GRADE_MINERAL_REJECTS'] = $data['ug_grade_mineral_rejects'];
			//=====================FOR THE UG MINERAL SELECT==========================

			$staticResult['UG_QUANTITY'] = $data['ug_quantity'];
			$staticResult['UG_GRADE'] = $data['ug_grade'];
			$staticResult['TREES_INSIDE'] = $data['trees_inside'];
			$staticResult['TREES_OUTSIDE'] = $data['trees_outside'];
			$staticResult['SPECIES'] = $data['species'];
			$staticResult['SURVIVAL_RATE'] = $data['survival_rate'];
			//==========================STATIC FIELDS ENDS============================
			}

			$resultSet = Array();
			$resultSet['bench'] = $benchResult;
			$resultSet['height'] = $heightResult;
			$resultSet['depth'] = $depthResult;
			$resultSet['static'] = $staticResult;

			$resultSet['drill'] = $explorationDrill;
			$resultSet['trench'] = $explorationTrench;
			$resultSet['pit'] = $explorationPit;

			return $resultSet;
			
		}
		
		public function getMineralRejectsDetails($mineCode, $returnType, $returnDate, $mineralName) {

			$query = $this->find()
					->select(['id', 'mine_code', 'return_type', 'return_date', 'oc_mineral_rejects', 'oc_grade_mineral_rejects', 
					  'oc_quantity', 'oc_grade', 'ug_mineral_rejects', 'ug_grade_mineral_rejects', 
					  'ug_quantity', 'ug_grade'])
					->where(['mine_code'=>$mineCode])
					->where(['return_type'=>$returnType])
					->where(['return_date'=>$returnDate])
					->where(['mineral_name'=>$mineralName])
					->where(['h_form_type'=>6])
					->toArray();
			
			$staticResult = Array();
			foreach ($query as $data) {
			  //=========================DYNAMIC FIELDS ENDS============================
			  //=========================STATIC FIELDS STARTS===========================
			  $staticResult['id'] = $data['id'];
			  $staticResult['mine_code'] = $data['mine_code'];
			  $staticResult['return_type'] = $data['return_type'];
			  $staticResult['return_date'] = $data['return_date'];
		
			  $staticResult['OC_MINERAL_REJECTS'] = $data['oc_mineral_rejects'];
		
			  //=====================FOR THE OC MINERAL SELECT==========================
			  $staticResult['OC_GRADE_MINERAL_REJECTS'] = $data['oc_grade_mineral_rejects'];
			  //========================================================================
		
			  $staticResult['OC_QUANTITY'] = $data['oc_quantity'];
			  $staticResult['OC_GRADE'] = unserialize($data['oc_grade']);
		
			  $staticResult['UG_WASTE'] = $data['ug_waste'];
			  $staticResult['UG_MINERAL_REJECTS'] = $data['ug_mineral_rejects'];
		
			  //=====================FOR THE UG MINERAL SELECT==========================
			  $staticResult['UG_GRADE_MINERAL_REJECTS'] = $data['ug_grade_mineral_rejects'];
			  //=====================FOR THE UG MINERAL SELECT==========================
		
			  $staticResult['UG_QUANTITY'] = $data['ug_quantity'];
			  $staticResult['UG_GRADE'] = unserialize($data['ug_grade']);
			  //==========================STATIC FIELDS ENDS============================
			}
			$resultSet = Array();
			$resultSet['static'] = $staticResult;
			return $resultSet;
			
		}

	} 
?>