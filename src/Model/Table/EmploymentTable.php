<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use App\Controller\MonthlyController;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class EmploymentTable extends Table{

		var $name = "Employment";
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

	  //chk employee wages rcd is exists or not
	  public function chkOpenEmpDetails($mineCode, $returnType, $returnDate, $emp_sn) {
	    $query = $this->find('all')
	            ->select(['mine_code','return_type','return_date'])
	            ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"employee_classif_sn"=>$emp_sn])
	            ->toArray();

	    if (count($query) > 0) {
	      return true;
	    } else {
	      return false;
	    }
	  }

		//fetch employee wages by mine code, return type and return date and emp. classification no
		public function fetchEmpWageDetails($mineCode, $returnType, $returnDate, $emp_sn) {

			$MonthlyController = new MonthlyController;

		    $result = $this->find('all')
		            ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"employee_classif_sn"=>$emp_sn])
		            ->toArray();
		    if (count($result) > 0){
				$data = $result[0];
		    } else {
				$data = $MonthlyController->Customfunctions->getTableColumns('employment');
		    }

		    return $data;
		}

		public function findOneById($openEmpId){

		    $result = $this->find('all')
		            ->where(["id"=>$openEmpId])
		            ->toArray();
		    if (count($result) > 0)
		      return $result[0];
		    else
		      return array();

		}

		public function deleteAnnualRecords($mineCode, $returnDate) {

			$query = $this->query();
			$query->delete()
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>"ANNUAL"])
				->execute();

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

	        	$open_cast_id = $forms_data['open_cast_id'];
	        	$below_id = $forms_data['below_id'];
	        	$above_id = $forms_data['above_id'];

	        	$openCast = $this->fetchEmpWageDetails($mineCode, $return_type, $return_date, $open_cast_id);
	        	if($openCast['id']!=""){
	        		$open_row_id = $openCast['id'];
	        		$created_at = $openCast['created_at'];
	        	} else {
	        		$open_row_id = '';
	        		$created_at = date('Y-m-d H:i:s');
	        	}

	        	$f_open_male_avg_direct = $forms_data['f_open_male_avg_direct'];
	        	$f_open_female_avg_direct = $forms_data['f_open_female_avg_direct'];
	        	$f_open_male_avg_contract = $forms_data['f_open_male_avg_contract'];
	        	$f_open_female_avg_contract = $forms_data['f_open_female_avg_contract'];
	        	$f_open_wage_direct = $forms_data['f_open_wage_direct'];
	        	$f_open_wage_contract = $forms_data['f_open_wage_contract'];
	        	$f_open_total_male_direct = $forms_data['f_open_total_male_direct'];
	        	$f_open_total_female_direct = $forms_data['f_open_total_female_direct'];
	        	$f_open_total_male_contract = $forms_data['f_open_total_male_contract'];
	        	$f_open_total_female_contract = $forms_data['f_open_total_female_contract'];
	        	$f_open_total_direct = $forms_data['f_open_total_direct'];
	        	$f_open_total_contract = $forms_data['f_open_total_contract'];

				$openNewEntity = $this->newEntity(array(
					'id'=>$open_row_id,
					'mine_code'=>$mineCode,
					'return_type'=>$return_type,
					'return_date'=>$return_date,
					'employee_classif_sn'=>$open_cast_id,
					'male_avg_direct'=>$f_open_male_avg_direct,
					'female_avg_direct'=>$f_open_female_avg_direct,
					'male_avg_contract'=>$f_open_male_avg_contract,
					'female_avg_contract'=>$f_open_female_avg_contract,
					'wage_direct'=>$f_open_wage_direct,
					'wage_contract'=>$f_open_wage_contract,
					'total_male_direct'=>$f_open_total_male_direct,
					'total_female_direct'=>$f_open_total_female_direct,
					'total_male_contract'=>$f_open_total_male_contract,
					'total_female_contract'=>$f_open_total_female_contract,
					'total_direct'=>$f_open_total_direct,
					'total_contract'=>$f_open_total_contract,
					'created_at'=>$created_at,
					'updated_at'=>date('Y-m-d H:i:s')
				));

	        	$below_ground = $this->fetchEmpWageDetails($mineCode, $return_type, $return_date, $below_id);
	        	if($below_ground['id']!=""){
	        		$below_row_id = $below_ground['id'];
	        		$created_at = $below_ground['created_at'];
	        	} else {
	        		$below_row_id = '';
	        		$created_at = date('Y-m-d H:i:s');
	        	}

	        	$f_below_male_avg_direct = $forms_data['f_below_male_avg_direct'];
	        	$f_below_female_avg_direct = $forms_data['f_below_female_avg_direct'];
	        	$f_below_male_avg_contract = $forms_data['f_below_male_avg_contract'];
	        	$f_below_female_avg_contract = $forms_data['f_below_female_avg_contract'];
	        	$f_below_wage_direct = $forms_data['f_below_wage_direct'];
	        	$f_below_wage_contract = $forms_data['f_below_wage_contract'];

				$belowNewEntity = $this->newEntity(array(
					'id'=>$below_row_id,
					'mine_code'=>$mineCode,
					'return_type'=>$return_type,
					'return_date'=>$return_date,
					'employee_classif_sn'=>$below_id,
					'male_avg_direct'=>$f_below_male_avg_direct,
					'female_avg_direct'=>$f_below_female_avg_direct,
					'male_avg_contract'=>$f_below_male_avg_contract,
					'female_avg_contract'=>$f_below_female_avg_contract,
					'wage_direct'=>$f_below_wage_direct,
					'wage_contract'=>$f_below_wage_contract,
					'created_at'=>$created_at,
					'updated_at'=>date('Y-m-d H:i:s')
				));

	        	$above_ground = $this->fetchEmpWageDetails($mineCode, $return_type, $return_date, $above_id);
	        	if($above_ground['id']!=""){
	        		$below_row_id = $above_ground['id'];
	        		$created_at = $above_ground['created_at'];
	        	} else {
	        		$below_row_id = '';
	        		$created_at = date('Y-m-d H:i:s');
	        	}

	        	$f_above_male_avg_direct = $forms_data['f_above_male_avg_direct'];
	        	$f_above_female_avg_direct = $forms_data['f_above_female_avg_direct'];
	        	$f_above_male_avg_contract = $forms_data['f_above_male_avg_contract'];
	        	$f_above_female_avg_contract = $forms_data['f_above_female_avg_contract'];
	        	$f_above_wage_direct = $forms_data['f_above_wage_direct'];
	        	$f_above_wage_contract = $forms_data['f_above_wage_contract'];

				$aboveNewEntity = $this->newEntity(array(
					'id'=>$below_row_id,
					'mine_code'=>$mineCode,
					'return_type'=>$return_type,
					'return_date'=>$return_date,
					'employee_classif_sn'=>$above_id,
					'male_avg_direct'=>$f_above_male_avg_direct,
					'female_avg_direct'=>$f_above_female_avg_direct,
					'male_avg_contract'=>$f_above_male_avg_contract,
					'female_avg_contract'=>$f_above_female_avg_contract,
					'wage_direct'=>$f_above_wage_direct,
					'wage_contract'=>$f_above_wage_contract,
					'created_at'=>$created_at,
					'updated_at'=>date('Y-m-d H:i:s')
				));

				$result = false;
				if($this->save($openNewEntity)){
					if($this->save($belowNewEntity)){
						if($this->save($aboveNewEntity)){
							$result = 1;
						}
					}
				}

				return $result;
			} else {
				return false;
			}

	    }

	    public function postDataValidation($forms_data){
			
			$returnValue = 1;
			
            $reply = $forms_data['reply'];
            $section = $forms_data['section_no'];
		
			if(!is_numeric($forms_data['f_open_male_avg_direct'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_open_female_avg_direct'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_open_male_avg_contract'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_open_female_avg_contract'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_open_wage_direct'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_open_wage_contract'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_below_male_avg_direct'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_below_female_avg_direct'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_below_male_avg_contract'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_below_female_avg_contract'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_below_wage_direct'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_below_wage_contract'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_above_male_avg_direct'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_above_female_avg_direct'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_above_male_avg_contract'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_above_female_avg_contract'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_above_wage_direct'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_above_wage_contract'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_open_total_male_direct'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_open_total_female_direct'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_open_total_male_contract'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_open_total_female_contract'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_open_total_direct'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_open_total_contract'])){ $returnValue = null ; }

			if(empty($forms_data['mine_code'])){ $returnValue = null ; }

			if($forms_data['f_open_male_avg_direct'] == ''){ $returnValue = null ; }
			if($forms_data['f_open_female_avg_direct'] == ''){ $returnValue = null ; }
			if($forms_data['f_open_male_avg_contract'] == ''){ $returnValue = null ; }
			if($forms_data['f_open_female_avg_contract'] == ''){ $returnValue = null ; }
			if($forms_data['f_open_wage_direct'] == ''){ $returnValue = null ; }
			if($forms_data['f_open_wage_contract'] == ''){ $returnValue = null ; }
			if($forms_data['f_below_male_avg_direct'] == ''){ $returnValue = null ; }
			if($forms_data['f_below_female_avg_direct'] == ''){ $returnValue = null ; }
			if($forms_data['f_below_male_avg_contract'] == ''){ $returnValue = null ; }
			if($forms_data['f_below_female_avg_contract'] == ''){ $returnValue = null ; }
			if($forms_data['f_below_wage_direct'] == ''){ $returnValue = null ; }
			if($forms_data['f_below_wage_contract'] == ''){ $returnValue = null ; }
			if($forms_data['f_above_male_avg_direct'] == ''){ $returnValue = null ; }
			if($forms_data['f_above_female_avg_direct'] == ''){ $returnValue = null ; }
			if($forms_data['f_above_male_avg_contract'] == ''){ $returnValue = null ; }
			if($forms_data['f_above_female_avg_contract'] == ''){ $returnValue = null ; }
			if($forms_data['f_above_wage_direct'] == ''){ $returnValue = null ; }
			if($forms_data['f_above_wage_contract'] == ''){ $returnValue = null ; }
			if($forms_data['f_open_total_male_direct'] == ''){ $returnValue = null ; }
			if($forms_data['f_open_total_female_direct'] == ''){ $returnValue = null ; }
			if($forms_data['f_open_total_male_contract'] == ''){ $returnValue = null ; }
			if($forms_data['f_open_total_female_contract'] == ''){ $returnValue = null ; }
			if($forms_data['f_open_total_direct'] == ''){ $returnValue = null ; }
			if($forms_data['f_open_total_contract'] == ''){ $returnValue = null ; }

			if($forms_data['f_open_male_avg_direct'] > 9999.9){ $returnValue = null ; }
			if($forms_data['f_open_female_avg_direct'] > 9999.9){ $returnValue = null ; }
			if($forms_data['f_open_male_avg_contract'] > 9999.9){ $returnValue = null ; }
			if($forms_data['f_open_female_avg_contract'] > 9999.9){ $returnValue = null ; }
			if($forms_data['f_open_wage_direct'] > 999999999.9){ $returnValue = null ; }
			if($forms_data['f_open_wage_contract'] > 999999999.9){ $returnValue = null ; }
			if($forms_data['f_below_male_avg_direct'] > 9999.9){ $returnValue = null ; }
			if($forms_data['f_below_female_avg_direct'] > 9999.9){ $returnValue = null ; }
			if($forms_data['f_below_male_avg_contract'] > 9999.9){ $returnValue = null ; }
			if($forms_data['f_below_female_avg_contract'] > 9999.9){ $returnValue = null ; }
			if($forms_data['f_below_wage_direct'] > 999999999.9){ $returnValue = null ; }
			if($forms_data['f_below_wage_contract'] > 999999999.9){ $returnValue = null ; }
			if($forms_data['f_above_male_avg_direct'] > 9999.9){ $returnValue = null ; }
			if($forms_data['f_above_female_avg_direct'] > 9999.9){ $returnValue = null ; }
			if($forms_data['f_above_male_avg_contract'] > 9999.9){ $returnValue = null ; }
			if($forms_data['f_above_female_avg_contract'] > 9999.9){ $returnValue = null ; }
			if($forms_data['f_above_wage_direct'] > 999999999.9){ $returnValue = null ; }
			if($forms_data['f_above_wage_contract'] > 999999999.9){ $returnValue = null ; }

			if(strlen($forms_data['f_open_total_direct']) > '13'){ $returnValue = null ; }
			if(strlen($forms_data['f_open_total_contract']) > '13'){ $returnValue = null ; }
			
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

		$dirEmployeeClassif = TableRegistry::getTableLocator()->get('DirEmployeeClassif');
	    $emp_class = $dirEmployeeClassif->find('all')
	            ->select(['employee_classif_sn'])
	            ->where(["return_type"=>$returnType])
	            ->toArray();

	    $classifications = array();
	    foreach ($emp_class as $c) {
	      $classifications[] = $c['employee_classif_sn'];
	    }

	    foreach ($classifications as $classif_id) {
	      $query = $this->find('all')
	              ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"employee_classif_sn"=>$classif_id])
	              ->toArray();

	      if (count($query) == 0)
	        return 1;

	      foreach ($query as $e) {
	        if ($e['male_avg_direct'] == "")
	          return 1;
	      }
	    }

	    return 0;
	  }


	  public function getDailyAverage($mineCode, $returnType, $returnDate) {

		$dirEmployeeClassif = TableRegistry::getTableLocator()->get('DirEmployeeClassif');

	    $classification = $dirEmployeeClassif->find('all')
	            ->select(['employee_classif_sn'])
	            ->where(['return_type'=>$returnType])
	            ->toArray();

	    $data = array();
	    for ($i = 0; $i < count($classification); $i++) {
	      $query = $this->find('all')
	              ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"employee_classif_sn"=>$classification[$i]['employee_classif_sn']])
	              ->toArray();

	      if (count($query) < 1)
	        return array();

	      if ($classification[$i]['employee_classif_sn'] == 5) {
	        $data['opencast'] = $query[0];
	      } else if ($classification[$i]['employee_classif_sn'] == 1) {
	        $data['below'] = $query[0];
	      } else if ($classification[$i]['employee_classif_sn'] == 9) {
	        $data['above'] = $query[0];
	      }

	      if ($query[0]['total_male_direct'] != "")
	        $data['total']['total_male_direct'] = $query[0]['total_male_direct'];
	      if ($query[0]['total_female_direct'] != "")
	        $data['total']['total_female_direct'] = $query[0]['total_female_direct'];
	      if ($query[0]['total_male_contract'] != "")
	        $data['total']['total_male_contract'] = $query[0]['total_male_contract'];
	      if ($query[0]['total_female_contract'] != "")
	        $data['total']['total_female_contract'] = $query[0]['total_female_contract'];
	      if ($query[0]['total_direct'] != "")
	        $data['total']['total_direct'] = $query[0]['total_direct'];
	      if ($query[0]['total_contract'] != "")
	        $data['total']['total_contract'] = $query[0]['total_contract'];
	      if ($query[0]['total_tech_emp'] != "")
	        $data['total']['total_tech_emp'] = $query[0]['total_tech_emp'];
	      if ($query[0]['total_salaries'] != "")
	        $data['total']['total_salaries'] = $query[0]['total_salaries'];
	    }

	    return $data;
	  }

		public function getEmploymentWagesDetails($mineCode, $returnDate, $formType) {

			/**
			 * formType == 1 -> ANNUAL EMPLOYMENT WAGES 
			 */
			$returns = TableRegistry::getTableLocator()->get('RentReturns');
			$ret = $returns->find()
					->select(['wholly_employed_gme', 'partly_employed_gme', 'wholly_employed_dme',
					'partly_employed_dme', 'wholly_employed_geologist', 'partly_employed_geologist', 
					'wholly_employed_surveyor', 'partly_employed_surveyor', 'wholly_employed_other',
					'partly_employed_other', 'no_work_days', 'no_shifts', 'no_below_employees', 
					'date_below_employees', 'no_all_employees', 'date_all_employees'])
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>"ANNUAL"])
					->where(['h_form_type'=>$formType])
					->toArray();

			$workStoppage = TableRegistry::getTableLocator()->get('WorkStoppage');
			$ws = $workStoppage->find()
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>"ANNUAL"])
					->toArray();
			
			/*$emp = Doctrine_Query::create()
					->select('EMPLOYEE_CLASSIF_SN, DIRECT_MANDAYS, CONTRACT_MANDAYS,
					NO_WORK_DAYS, MALE_AVG_NO, FEMALE_AVG_NO, TOTAL_SALARIES, TOTAL_TECH_EMP')
					->from('EMPLOYMENT')
					->where('mine_code = ?', $mineCode)
					->andWhere('return_date = ?', $returnDate)
					->andWhere('return_type = ?', "ANNUAL")
					->fetchArray();*/

			$data = array();
			$returnDetails = array();
			if (count($ret) > 0) {
				$returnDetails['GRAD_MINING_WHOLLY'] = $ret[0]['wholly_employed_gme'];
				$returnDetails['GRAD_MINING_PARTLY'] = $ret[0]['partly_employed_gme'];
				$returnDetails['DIP_MINING_WHOLLY'] = $ret[0]['wholly_employed_dme'];
				$returnDetails['DIP_MINING_PARTLY'] = $ret[0]['partly_employed_dme'];
				$returnDetails['GEO_WHOLLY'] = $ret[0]['wholly_employed_geologist'];
				$returnDetails['GEO_PARTLY'] = $ret[0]['partly_employed_geologist'];
				$returnDetails['SURV_WHOLLY'] = $ret[0]['wholly_employed_surveyor'];
				$returnDetails['SURV_PARTLY'] = $ret[0]['partly_employed_surveyor'];
				$returnDetails['OTHER_WHOLLY'] = $ret[0]['wholly_employed_other'];
				$returnDetails['OTHER_PARTLY'] = $ret[0]['partly_employed_other'];
				$returnDetails['DAYS_MINE_WORKED'] = $ret[0]['no_work_days'];
				$returnDetails['NO_OF_SHIFTS'] = $ret[0]['no_shifts'];
				/*$returnDetails['WORKING_BELOW_DATE'] = clsCommon::changeDateFormat($ret[0]['DATE_BELOW_EMPLOYEES']);
				$returnDetails['WORKING_BELOW_PER'] = $ret[0]['NO_BELOW_EMPLOYEES'];
				$returnDetails['WORKING_ALL_DATE'] = clsCommon::changeDateFormat($ret[0]['DATE_ALL_EMPLOYEES']);
				$returnDetails['WORKING_ALL_PER'] = $ret[0]['NO_ALL_EMPLOYEES'];*/

				//totals
				$returnDetails['TOTAL_WHOLLY'] = ($returnDetails['GRAD_MINING_WHOLLY'] + $returnDetails['DIP_MINING_WHOLLY'] +
				$returnDetails['GEO_WHOLLY'] + $returnDetails['SURV_WHOLLY'] + $returnDetails['OTHER_WHOLLY']);

				$returnDetails['TOTAL_PARTLY'] = ($returnDetails['GRAD_MINING_PARTLY'] + $returnDetails['DIP_MINING_PARTLY'] +
				$returnDetails['GEO_PARTLY'] + $returnDetails['SURV_PARTLY'] + $returnDetails['OTHER_PARTLY']);
			}

			$data['returnDetails'] = $returnDetails;


			//WORK STOPPAGE DETAILS
			$workStoppage = array();
			if (count($ws) > 0) {
				$workStoppage = $ws[0];
			}
			$data['workStoppageDetails'] = $workStoppage;

			//EMPLOYMENT DETAILS
			/*$empDetails = array();
			$keys = clsCommon::getEmploymentWagesKeys();
			if (count($emp) > 0) {
			for ($i = 0; $i < 9; $i++) {
				$empDetails[$keys[$i]['direct']] = $emp[$i]['DIRECT_MANDAYS'];
				$empDetails[$keys[$i]['contract']] = $emp[$i]['CONTRACT_MANDAYS'];
				$empDetails[$keys[$i]['man_tot']] = ($emp[$i]['DIRECT_MANDAYS'] + $emp[$i]['CONTRACT_MANDAYS']);
				$empDetails[$keys[$i]['worked_days']] = $emp[$i]['NO_WORK_DAYS'];
				$empDetails[$keys[$i]['male']] = $emp[$i]['MALE_AVG_NO'];
				$empDetails[$keys[$i]['female']] = $emp[$i]['FEMALE_AVG_NO'];
				$empDetails[$keys[$i]['per_tot']] = ($emp[$i]['MALE_AVG_NO'] + $emp[$i]['FEMALE_AVG_NO']);
				$empDetails[$keys[$i]['total_wage']] = $emp[$i]['TOTAL_SALARIES'];

				$empDetails['TOTAL_DIRECT'] += $emp[$i]['DIRECT_MANDAYS'];
				$empDetails['TOTAL_CONTRACT'] += $emp[$i]['CONTRACT_MANDAYS'];
				$empDetails['TOTAL_DAYS'] += $emp[$i]['NO_WORK_DAYS'];
				$empDetails['TOTAL_MALE'] += $emp[$i]['MALE_AVG_NO'];
				$empDetails['TOTAL_FEMALE'] += $emp[$i]['FEMALE_AVG_NO'];
				$empDetails['TOTAL_WAGES'] += $emp[$i]['TOTAL_SALARIES'];

				if ($i == 8) {
				$empDetails['TOTAL_MAN'] = ($empDetails['TOTAL_DIRECT'] + $empDetails['TOTAL_CONTRACT']);
				$empDetails['TOTAL_PERSONS'] = ($empDetails['TOTAL_MALE'] + $empDetails['TOTAL_FEMALE']);
				}

				$empDetails['TOTAL_SALARY'] = $emp[$i]['TOTAL_TECH_EMP'];
			}
			}

			$data['empDetails'] = $empDetails;*/

			return $data;
		}
		
		public function getEmploymentWagesPart2Details($mineCode, $returnDate, $formType, $pdfStatus = 0) {
			
			/**
			 * formType == 1 -> ANNUAL EMPLOYMENT WAGES 
			 */
			$conn = ConnectionManager::get(Configure::read('conn'));
			$monthlyCntrl = new MonthlyController;
			$returns = TableRegistry::getTableLocator()->get('RentReturns');
			$ret = $returns->find()
					->select(['no_below_employees', 
					  'date_below_employees', 'no_all_employees', 'date_all_employees'])
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>"ANNUAL"])
					->where(['h_form_type'=>5])
					->toArray();
		
			$emp = $this->find()
					->select(['employee_classif_sn', 'direct_mandays', 'contract_mandays',
					  'no_work_days', 'male_avg_no', 'female_avg_no', 'total_salaries', 'total_tech_emp'])
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>"ANNUAL"])
					->toArray();
		
			$data = array();
			$returnDetails = array();
			if (count($ret) > 0) {
				// $returnDetails['WORKING_BELOW_DATE'] = $monthlyCntrl->Clscommon->changeDateFormat($ret[0]['date_below_employees']);
				$returnDetails['WORKING_BELOW_DATE'] = $monthlyCntrl->Clscommon->dateFormat($ret[0]['date_below_employees'], 'd-m-Y');
				// $returnDetails['WORKING_BELOW_DATE'] = $ret[0]['date_below_employees'];
				$returnDetails['WORKING_BELOW_PER'] = $ret[0]['no_below_employees'];
				// $returnDetails['WORKING_ALL_DATE'] = $monthlyCntrl->Clscommon->changeDateFormat($ret[0]['date_all_employees']);
				$returnDetails['WORKING_ALL_DATE'] = $monthlyCntrl->Clscommon->dateFormat($ret[0]['date_all_employees'], 'd-m-Y');
				// $returnDetails['WORKING_ALL_DATE'] = $ret[0]['date_all_employees'];
				$returnDetails['WORKING_ALL_PER'] = $ret[0]['no_all_employees'];
			} else {
				$returnDetails['WORKING_BELOW_DATE'] = '';
				$returnDetails['WORKING_BELOW_PER'] = '';
				$returnDetails['WORKING_ALL_DATE'] = '';
				$returnDetails['WORKING_ALL_PER'] = '';
			}
		
			$data['returnDetails'] = $returnDetails;
			
			//EMPLOYMENT DETAILS
			$empDetails = array();
			$empDetails['TOTAL_DIRECT'] = 0;
			$empDetails['TOTAL_CONTRACT'] = 0;
			$empDetails['TOTAL_MALE'] = 0;
			$empDetails['TOTAL_FEMALE'] = 0;
			$empDetails['TOTAL_WAGES'] = 0;
			$totalCalculatedDays = 0;
			$keys = $monthlyCntrl->Clscommon->getEmploymentWagesKeys();
			if (count($emp) > 0) {
				for ($i = 0; $i < 9; $i++) {
					$totalCalculatedDays = $totalCalculatedDays+(($emp[$i]['no_work_days'])*($emp[$i]['direct_mandays'] + $emp[$i]['contract_mandays']));
						
					$empDetails[$keys[$i]['direct']] = $emp[$i]['direct_mandays'];
					$empDetails[$keys[$i]['contract']] = $emp[$i]['contract_mandays'];
					$empDetails[$keys[$i]['man_tot']] = ($emp[$i]['direct_mandays'] + $emp[$i]['contract_mandays']);
					$empDetails[$keys[$i]['worked_days']] = $emp[$i]['no_work_days'];
					$empDetails[$keys[$i]['male']] = $emp[$i]['male_avg_no'];
					$empDetails[$keys[$i]['female']] = $emp[$i]['female_avg_no'];
					$empDetails[$keys[$i]['per_tot']] = ($emp[$i]['male_avg_no'] + $emp[$i]['female_avg_no']);
					$empDetails[$keys[$i]['total_wage']] = $emp[$i]['total_salaries'];
			
					$empDetails['TOTAL_DIRECT'] += $emp[$i]['direct_mandays'];
					$empDetails['TOTAL_CONTRACT'] += $emp[$i]['contract_mandays'];
					//$empDetails['TOTAL_DAYS'] += $emp[$i]['no_work_days'];
					$empDetails['TOTAL_MALE'] += $emp[$i]['male_avg_no'];
					$empDetails['TOTAL_FEMALE'] += $emp[$i]['female_avg_no'];
					$empDetails['TOTAL_WAGES'] += $emp[$i]['total_salaries'];
			
					if ($i == 8) {
						$empDetails['TOTAL_MAN'] = ($empDetails['TOTAL_DIRECT'] + $empDetails['TOTAL_CONTRACT']);
						$empDetails['TOTAL_PERSONS'] = ($empDetails['TOTAL_MALE'] + $empDetails['TOTAL_FEMALE']);
					}
					$empDetails['TOTAL_SALARY']  = $emp[$i]['total_tech_emp'];
				}
			  	$empDetails['TOTAL_DAYS']    = ($empDetails['TOTAL_MAN'] != 0) ? round($totalCalculatedDays/$empDetails['TOTAL_MAN'],0) : round($totalCalculatedDays/1,0);
				// $empDetails['TOTAL_PERSONS'] = $empDetails['TOTAL_MAN']/$empDetails['TOTAL_DAYS'];
			} elseif ($pdfStatus == 0) {
				
				/**
				 * Prefetch the monthly records data for annual returns.
				 * Effective from Phase - II
				 * @version 25th Oct 2021
				 * @author Aniket Ganvir
				 */
				$starDate = (date('Y',strtotime($returnDate))).'-04-01';
            	$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';

				$belowQuery = "SELECT 
					SUM(male_avg_direct + male_avg_contract) AS male_avg,
					SUM(female_avg_direct + female_avg_contract) AS female_avg,
					SUM(male_avg_direct + male_avg_contract + female_avg_direct + female_avg_contract) AS avg_tot,
					SUM(wage_direct + wage_contract) AS wage_tot
					FROM `employment`
					WHERE mine_code = '$mineCode' 
					AND return_date BETWEEN '$starDate' AND '$endDate' 
					AND return_type = 'MONTHLY' 
					AND employee_classif_sn = '1'";
					
				$below = $conn->execute($belowQuery)->fetchAll('assoc');
				
				$opencastQuery = "SELECT 
					SUM(male_avg_direct + male_avg_contract) AS male_avg,
					SUM(female_avg_direct + female_avg_contract) AS female_avg,
					SUM(male_avg_direct + male_avg_contract + female_avg_direct + female_avg_contract) AS avg_tot,
					SUM(wage_direct + wage_contract) AS wage_tot
					FROM `employment`
					WHERE mine_code = '$mineCode' 
					AND return_date BETWEEN '$starDate' AND '$endDate' 
					AND return_type = 'MONTHLY' 
					AND employee_classif_sn = '5'";
					
				$oc = $conn->execute($opencastQuery)->fetchAll('assoc');
				
				$aboveQuery = "SELECT 
					SUM(male_avg_direct + male_avg_contract) AS male_avg,
					SUM(female_avg_direct + female_avg_contract) AS female_avg,
					SUM(male_avg_direct + male_avg_contract + female_avg_direct + female_avg_contract) AS avg_tot,
					SUM(wage_direct + wage_contract) AS wage_tot
					FROM `employment`
					WHERE mine_code = '$mineCode' 
					AND return_date BETWEEN '$starDate' AND '$endDate' 
					AND return_type = 'MONTHLY' 
					AND employee_classif_sn = '9'";
					
				$above = $conn->execute($aboveQuery)->fetchAll('assoc');

				$empDetails['BELOW_FOREMAN_DIRECT'] = '';
				$empDetails['BELOW_FOREMAN_CONTRACT'] = '';
				$empDetails['BELOW_FOREMAN_MAN_TOT'] = '';
				$empDetails['BELOW_FOREMAN_DAYS'] = '';
				$empDetails['BELOW_FOREMAN_MALE'] = $below[0]['male_avg'];
				$empDetails['BELOW_FOREMAN_FEMALE'] = $below[0]['female_avg'];
				$empDetails['BELOW_FOREMAN_PER_TOTAL'] = $below[0]['avg_tot'];
				$empDetails['BELOW_FOREMAN_TOTAL_WAGES'] = $below[0]['wage_tot'];
				$empDetails['OC_FOREMAN_DIRECT'] = '';
				$empDetails['OC_FOREMAN_CONTRACT'] = '';
				$empDetails['OC_FOREMAN_MAN_TOT'] = '';
				$empDetails['OC_FOREMAN_DAYS'] = '';
				$empDetails['OC_FOREMAN_MALE'] = $oc[0]['male_avg'];
				$empDetails['OC_FOREMAN_FEMALE'] = $oc[0]['female_avg'];
				$empDetails['OC_FOREMAN_PER_TOTAL'] = $oc[0]['avg_tot'];
				$empDetails['OC_FOREMAN_TOTAL_WAGES'] = $oc[0]['wage_tot'];
				$empDetails['ABOVE_CLERICAL_DIRECT'] = '';
				$empDetails['ABOVE_CLERICAL_CONTRACT'] = '';
				$empDetails['ABOVE_CLERICAL_MAN_TOT'] = '';
				$empDetails['ABOVE_CLERICAL_DAYS'] = '';
				$empDetails['ABOVE_CLERICAL_MALE'] = $above[0]['male_avg'];
				$empDetails['ABOVE_CLERICAL_FEMALE'] = $above[0]['female_avg'];
				$empDetails['ABOVE_CLERICAL_PER_TOTAL'] = $above[0]['avg_tot'];
				$empDetails['ABOVE_CLERICAL_TOTAL_WAGES'] = $above[0]['wage_tot'];
				$empDetails['ABOVE_ATTACHED_DIRECT'] = '';
				$empDetails['ABOVE_ATTACHED_CONTRACT'] = '';
				$empDetails['ABOVE_ATTACHED_MAN_TOT'] = '';
				$empDetails['ABOVE_ATTACHED_DAYS'] = '';
				$empDetails['ABOVE_ATTACHED_MALE'] = '';
				$empDetails['ABOVE_ATTACHED_FEMALE'] = '';
				$empDetails['ABOVE_ATTACHED_PER_TOTAL'] = '';
				$empDetails['ABOVE_ATTACHED_TOTAL_WAGES'] = '';

			} else {

				$empDetails['BELOW_FOREMAN_DIRECT'] = '';
				$empDetails['BELOW_FOREMAN_CONTRACT'] = '';
				$empDetails['BELOW_FOREMAN_MAN_TOT'] = '';
				$empDetails['BELOW_FOREMAN_DAYS'] = '';
				$empDetails['BELOW_FOREMAN_MALE'] = '';
				$empDetails['BELOW_FOREMAN_FEMALE'] = '';
				$empDetails['BELOW_FOREMAN_PER_TOTAL'] = '';
				$empDetails['BELOW_FOREMAN_TOTAL_WAGES'] = '';
				$empDetails['OC_FOREMAN_DIRECT'] = '';
				$empDetails['OC_FOREMAN_CONTRACT'] = '';
				$empDetails['OC_FOREMAN_MAN_TOT'] = '';
				$empDetails['OC_FOREMAN_DAYS'] = '';
				$empDetails['OC_FOREMAN_MALE'] = '';
				$empDetails['OC_FOREMAN_FEMALE'] = '';
				$empDetails['OC_FOREMAN_PER_TOTAL'] = '';
				$empDetails['OC_FOREMAN_TOTAL_WAGES'] = '';
				$empDetails['ABOVE_CLERICAL_DIRECT'] = '';
				$empDetails['ABOVE_CLERICAL_CONTRACT'] = '';
				$empDetails['ABOVE_CLERICAL_MAN_TOT'] = '';
				$empDetails['ABOVE_CLERICAL_DAYS'] = '';
				$empDetails['ABOVE_CLERICAL_MALE'] = '';
				$empDetails['ABOVE_CLERICAL_FEMALE'] = '';
				$empDetails['ABOVE_CLERICAL_PER_TOTAL'] = '';
				$empDetails['ABOVE_CLERICAL_TOTAL_WAGES'] = '';
				$empDetails['ABOVE_ATTACHED_DIRECT'] = '';
				$empDetails['ABOVE_ATTACHED_CONTRACT'] = '';
				$empDetails['ABOVE_ATTACHED_MAN_TOT'] = '';
				$empDetails['ABOVE_ATTACHED_DAYS'] = '';
				$empDetails['ABOVE_ATTACHED_MALE'] = '';
				$empDetails['ABOVE_ATTACHED_FEMALE'] = '';
				$empDetails['ABOVE_ATTACHED_PER_TOTAL'] = '';
				$empDetails['ABOVE_ATTACHED_TOTAL_WAGES'] = '';

			}

			$data['empDetails'] = $empDetails;
		
			return $data;
			
		}
		
		/**
		 * Cumulative monthly data for annual return
		 * @version 08th Nov 2021
		 * @author Aniket Ganvir
		 */
		public function getEmploymentWagesPart2DataMonthly($mineCode, $returnDate, $formType) {
			
			$conn = ConnectionManager::get(Configure::read('conn'));
			$starDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';

			$belowQuery = "SELECT 
				SUM(male_avg_direct + male_avg_contract) AS male_avg,
				SUM(female_avg_direct + female_avg_contract) AS female_avg,
				SUM(male_avg_direct + male_avg_contract + female_avg_direct + female_avg_contract) AS avg_tot,
				SUM(wage_direct + wage_contract) AS wage_tot
				FROM `employment`
				WHERE mine_code = '$mineCode' 
				AND return_date BETWEEN '$starDate' AND '$endDate' 
				AND return_type = 'MONTHLY' 
				AND employee_classif_sn = '1'";
				
			$below = $conn->execute($belowQuery)->fetchAll('assoc');
			
			$opencastQuery = "SELECT 
				SUM(male_avg_direct + male_avg_contract) AS male_avg,
				SUM(female_avg_direct + female_avg_contract) AS female_avg,
				SUM(male_avg_direct + male_avg_contract + female_avg_direct + female_avg_contract) AS avg_tot,
				SUM(wage_direct + wage_contract) AS wage_tot
				FROM `employment`
				WHERE mine_code = '$mineCode' 
				AND return_date BETWEEN '$starDate' AND '$endDate' 
				AND return_type = 'MONTHLY' 
				AND employee_classif_sn = '5'";
				
			$oc = $conn->execute($opencastQuery)->fetchAll('assoc');
			
			$aboveQuery = "SELECT 
				SUM(male_avg_direct + male_avg_contract) AS male_avg,
				SUM(female_avg_direct + female_avg_contract) AS female_avg,
				SUM(male_avg_direct + male_avg_contract + female_avg_direct + female_avg_contract) AS avg_tot,
				SUM(wage_direct + wage_contract) AS wage_tot
				FROM `employment`
				WHERE mine_code = '$mineCode' 
				AND return_date BETWEEN '$starDate' AND '$endDate' 
				AND return_type = 'MONTHLY' 
				AND employee_classif_sn = '9'";
				
			$above = $conn->execute($aboveQuery)->fetchAll('assoc');

			$empDetails['BELOW_FOREMAN_MALE'] = $below[0]['male_avg'];
			$empDetails['BELOW_FOREMAN_FEMALE'] = $below[0]['female_avg'];
			$empDetails['BELOW_FOREMAN_PER_TOTAL'] = $below[0]['avg_tot'];
			$empDetails['BELOW_FOREMAN_TOTAL_WAGES'] = $below[0]['wage_tot'];
			$empDetails['OC_FOREMAN_MALE'] = $oc[0]['male_avg'];
			$empDetails['OC_FOREMAN_FEMALE'] = $oc[0]['female_avg'];
			$empDetails['OC_FOREMAN_PER_TOTAL'] = $oc[0]['avg_tot'];
			$empDetails['OC_FOREMAN_TOTAL_WAGES'] = $oc[0]['wage_tot'];
			$empDetails['ABOVE_CLERICAL_MALE'] = $above[0]['male_avg'];
			$empDetails['ABOVE_CLERICAL_FEMALE'] = $above[0]['female_avg'];
			$empDetails['ABOVE_CLERICAL_PER_TOTAL'] = $above[0]['avg_tot'];
			$empDetails['ABOVE_CLERICAL_TOTAL_WAGES'] = $above[0]['wage_tot'];
			$empDetails['ABOVE_ATTACHED_MALE'] = '';
			$empDetails['ABOVE_ATTACHED_FEMALE'] = '';
			$empDetails['ABOVE_ATTACHED_PER_TOTAL'] = '';
			$empDetails['ABOVE_ATTACHED_TOTAL_WAGES'] = '';

			$data['empDetails'] = $empDetails;
		
			return $data;
			
		}

		/**
		 * Check filled status of section
		 * @version 29th Oct 2021
		 * @author Aniket Ganvir
		 */
		public function isFilledEmpWagePart($mineCode, $returnDate) {

			$returns = TableRegistry::getTableLocator()->get('RentReturns');
			$ret = $returns->find()
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>"ANNUAL"])
				->where(['h_form_type'=>5])
				->count();
		
			$emp = $this->find()
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>"ANNUAL"])
				->count();

			if ($ret > 0 && $emp > 0) {
				return true;
			} else {
				return false;
			}

		}

		public function employmentAnnualCheck($mineCode, $returnDate, $returnType) {

			$query = $this->find()
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>$returnType])
				->toArray();
		
			if (count($query) > 0)
			  return 0;
			else
			  return 1;

		}


	} 
?>