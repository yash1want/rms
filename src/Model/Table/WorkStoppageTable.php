<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use App\Controller\MonthlyController;
	use Cake\Core\Configure;
	use Cake\Datasource\ConnectionManager;
	
	class WorkStoppageTable extends Table{

		var $name = "WorkStoppage";
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		//chk working details is exists or not
		public function chkWorkingDetails($mineCode, $returnType, $returnDate) {
			$query = $this->find('all')
			        ->select(['mine_code','return_type','return_date'])
			        ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate])
			        ->toArray();
			if (count($query) > 0) {
				return true;
			} else {
				return false;
			}
		}

		//fetch working by mine code, return type and return date
		public function fetchWorkingDetails($mineCode, $returnType, $returnDate, $pdfStatus = 0) {

			$conn = ConnectionManager::get(Configure::read('conn'));
			$MonthlyController = new MonthlyController;

			if ($returnType == 'ANNUAL') {

				$annualResult = $this->find('all')
					->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate])
					->toArray();
				
				if (count($annualResult) == 0 && $pdfStatus == 0) {
					
					/**
					 * Prefetch the monthly records data for annual returns.
					 * Effective from Phase II
					 * @version 22nd Oct 2021
					 * @author Aniket Ganvir
					 * @author Pravin Bhakare
					 */
					$starDate = (date('Y',strtotime($returnDate))).'-04-01';
					$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
					
					$str = "SELECT tt.reason AS reason, sum(tt.no_days) AS days FROM 
					(
					SELECT `stoppage_sn_1` AS reason, sum(`no_days_1`) AS no_days FROM `work_stoppage` WHERE return_date BETWEEN '$starDate' AND '$endDate'
					AND return_type = 'MONTHLY' AND mine_code = '$mineCode' AND stoppage_sn_1 IS NOT NULL
					GROUP BY stoppage_sn_1
					UNION
					SELECT `stoppage_sn_2` AS reason, sum(`no_days_2`) AS no_days FROM `work_stoppage` WHERE return_date BETWEEN '$starDate' AND '$endDate'
					AND return_type = 'MONTHLY' AND mine_code = '$mineCode' AND stoppage_sn_2 IS NOT NULL
					GROUP BY stoppage_sn_2
					UNION
					SELECT `stoppage_sn_3` AS reason, sum(`no_days_3`) AS no_days FROM `work_stoppage` WHERE return_date BETWEEN '$starDate' AND '$endDate'
					AND return_type = 'MONTHLY' AND mine_code = '$mineCode' AND stoppage_sn_3 IS NOT NULL
					GROUP BY stoppage_sn_3 
					UNION
					SELECT `stoppage_sn_4` AS reason, sum(`no_days_4`) AS no_days FROM `work_stoppage` WHERE return_date BETWEEN '$starDate' AND '$endDate'
					AND return_type = 'MONTHLY' AND mine_code = '$mineCode' AND stoppage_sn_4 IS NOT NULL
					GROUP BY stoppage_sn_4
					UNION
					SELECT `stoppage_sn_5` AS reason, sum(`no_days_5`) AS no_days FROM `work_stoppage` WHERE return_date BETWEEN '$starDate' AND '$endDate'
					AND return_type = 'MONTHLY' AND mine_code = '$mineCode' AND stoppage_sn_5 IS NOT NULL
					GROUP BY stoppage_sn_5
					) as tt
					
					GROUP BY reason
					ORDER BY reason";
					
					$monthlyData = $conn->execute($str)->fetchAll('assoc');
					
					$dirWorkStoppage = TableRegistry::getTableLocator()->get('DirWorkStoppage');
					$reasonsArr = $dirWorkStoppage->getReasonsArr();
					$reasonsLen = count($reasonsArr);

					$monthlyDataArr = array();
					$rid = 1;
					foreach ($monthlyData as $key=>$val) {
						$monthlyDataArr[0]['stoppage_sn_'.$rid] = $val['reason'];
						$monthlyDataArr[0]['no_days_'.$rid] = $val['days'];
						$rid++;
					}

					$filledR = $rid - 1;
					for ($n = $filledR; $n < $reasonsLen; $n++) {
						$monthlyDataArr[0]['stoppage_sn_'.$rid] = '';
						$monthlyDataArr[0]['no_days_'.$rid] = '';
						$rid++;
					}

					$monthlyDataArr[0]['id'] = '';
					$result = $monthlyDataArr;

				} else {

					$result = $this->find('all')
						->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate])
						->toArray('assoc');
				}

			} else {

				$result = $this->find('all')
					->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate])
					->toArray();

			}

		    if (count($result) > 0) {
				$data = $result[0];
		    } else {
				$data = $MonthlyController->Customfunctions->getTableColumns('work_stoppage');
		    }

		    return $data;
		}

		
		public function fetchWorkingDetailsMonthly($mineCode, $returnDate) {

			$conn = ConnectionManager::get(Configure::read('conn'));
			$MonthlyController = new MonthlyController;
					
			/**
			 * Prefetch the monthly records data for annual returns.
			 * Effective from Phase II
			 * @version 22nd Oct 2021
			 * @author Aniket Ganvir
			 * @author Pravin Bhakare
			 */
			$starDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
			
			$str = "SELECT tt.reason AS reason, sum(tt.no_days) AS days FROM 
			(
			SELECT `stoppage_sn_1` AS reason, sum(`no_days_1`) AS no_days FROM `work_stoppage` WHERE return_date BETWEEN '$starDate' AND '$endDate'
			AND return_type = 'MONTHLY' AND mine_code = '$mineCode' AND stoppage_sn_1 IS NOT NULL
			GROUP BY stoppage_sn_1
			UNION
			SELECT `stoppage_sn_2` AS reason, sum(`no_days_2`) AS no_days FROM `work_stoppage` WHERE return_date BETWEEN '$starDate' AND '$endDate'
			AND return_type = 'MONTHLY' AND mine_code = '$mineCode' AND stoppage_sn_2 IS NOT NULL
			GROUP BY stoppage_sn_2
			UNION
			SELECT `stoppage_sn_3` AS reason, sum(`no_days_3`) AS no_days FROM `work_stoppage` WHERE return_date BETWEEN '$starDate' AND '$endDate'
			AND return_type = 'MONTHLY' AND mine_code = '$mineCode' AND stoppage_sn_3 IS NOT NULL
			GROUP BY stoppage_sn_3 
			UNION
			SELECT `stoppage_sn_4` AS reason, sum(`no_days_4`) AS no_days FROM `work_stoppage` WHERE return_date BETWEEN '$starDate' AND '$endDate'
			AND return_type = 'MONTHLY' AND mine_code = '$mineCode' AND stoppage_sn_4 IS NOT NULL
			GROUP BY stoppage_sn_4
			UNION
			SELECT `stoppage_sn_5` AS reason, sum(`no_days_5`) AS no_days FROM `work_stoppage` WHERE return_date BETWEEN '$starDate' AND '$endDate'
			AND return_type = 'MONTHLY' AND mine_code = '$mineCode' AND stoppage_sn_5 IS NOT NULL
			GROUP BY stoppage_sn_5
			) as tt
			
			GROUP BY reason
			ORDER BY reason";
			
			$monthlyData = $conn->execute($str)->fetchAll('assoc');
			
			$dirWorkStoppage = TableRegistry::getTableLocator()->get('DirWorkStoppage');
			$reasonsArr = $dirWorkStoppage->getReasonsArr();
			$reasonsLen = count($reasonsArr);

			$monthlyDataArr = array();
			foreach ($monthlyData as $key=>$val) {
				$monthlyDataArr['reason'][] = $val['reason'];
				$monthlyDataArr['days'][] = $val['days'];
			}
			$result = $monthlyDataArr;

		    if (count($result) == 0) {
				$monthlyDataArr['reason'][] = '';
				$monthlyDataArr['days'][] = '';
		    }

		    return $monthlyDataArr;
		}

		public function findOneById($workingId){

		    $result = $this->find('all')
		            ->where(["id"=>$workingId])
		            ->toArray();
		    if (count($result) > 0)
		      return $result[0];
		    else
		      return array();

		}


		// save or update the form data
	    public function saveFormDetails($forms_data){

			$dataValidatation = $this->postDataValidation($forms_data);
			$returnData = array();
			if($dataValidatation['err'] == 1 ){

				$params = $dataValidatation['data'];
				
	            $formId = $params['form_no'];
	            $mineCode = $params['mine_code'];
	        	$return_type = $params['return_type'];
	        	$return_date = $params['return_date'];

	        	$rowDetail = $this->fetchWorkingDetails($mineCode, $return_type, $return_date);
	        	if($rowDetail['id']!=""){
	        		$row_id = $rowDetail['id'];
	        		$created_at = $rowDetail['created_at'];
	        		$reporting = $rowDetail['reporting'];
	        	} else {
	        		$row_id = '';
	        		$created_at = date('Y-m-d H:i:s');
	        		$reporting = null;
	        	}

	        	$total_no_days = $params['f_total_no_days'];

				$newEntity = $this->newEntity(array(
					'id'=>$row_id,
					'mine_code'=>$mineCode,
					'return_type'=>$return_type,
					'return_date'=>$return_date,
					'stoppage_sn_1'=>$params['stoppage_reason_1'],
					'stoppage_sn_2'=>$params['stoppage_reason_2'],
					'stoppage_sn_3'=>$params['stoppage_reason_3'],
					'stoppage_sn_4'=>$params['stoppage_reason_4'],
					'stoppage_sn_5'=>$params['stoppage_reason_5'],
					'no_days_1'=>$params['no_days_1'],
					'no_days_2'=>$params['no_days_2'],
					'no_days_3'=>$params['no_days_3'],
					'no_days_4'=>$params['no_days_4'],
					'no_days_5'=>$params['no_days_5'],
					'total_no_days'=>$total_no_days,
					'created_at'=>$created_at,
					'updated_at'=>date('Y-m-d H:i:s')
				));
				if($this->save($newEntity)){
					$returnVal = 1;
					$returnData['msg'][] = "<b>Details on Working</b> successfully saved!";
				} else {
					$returnVal = false;
					$returnData['msg'][] = "Failed to update <b>Details on Working</b>! Please, try again later.";
				}
			} else {
				$returnVal = false;
				$returnData['msg'] = $dataValidatation['msg'];
			}

			$returnData['err'] = $returnVal;
			return $returnData;

	    }

	    public function postDataValidation($params){
			
			$returnValue = 1;
			$returnData = array();
			
			if(!is_numeric($params['f_total_no_days'])){ $returnValue = null ; }
			if(strlen($params['f_total_no_days']) > '2' || strlen($params['f_total_no_days']) == '0'){ $returnValue = null ; }

			// $stoppage_reason = $params['stoppage_reason'];

			// $duplicate_status = $this->hasDuplicateValues($stoppage_reason);
			// if($duplicate_status == 1){ $returnValue = null ; }

			$loopC = 0;
			$total_no_days = $params['f_total_no_days'];
			for($i='0';$i<'5';$i++){
				
				$newI = $i+'1';
				$stoppage_reason = 'stoppage_reason_'.$newI;
				$no_days = 'no_days_'.$newI;

				if(isset($params[$stoppage_reason])) {

					if ($params[$no_days] != ''){
						$total_no_days = $total_no_days + $params[$no_days];
						if ($params[$stoppage_reason] == ''){ $returnValue = null ; }
						if(!is_numeric($params[$no_days])){ $returnValue = null ; }
						if(strlen($params[$no_days]) > '2'){ $returnValue = null ; }
					} else {
						$params[$stoppage_reason] = '';
					}

				} else {
					$params[$stoppage_reason] = '';
					$params[$no_days] = '';
				}

			}

			$month_days = $params['month_days'];
			if($month_days != $total_no_days){
				$returnValue = null ;
				$returnData['msg'][] = 'Total no. of days in month not matching with total no. of entered days';
			}
			
			$returnData['data'] = $params;
			$returnData['err'] = $returnValue;
			return $returnData;
			
		}

		/**
		 * CHECK IF ARRAYS HAS DUPLICATE VALUES
		 */
		public function hasDuplicateValues($array) {

		    $dupe_array = array();
		    $result = 0;
		    foreach ($array as $val) {
		        if (++$dupe_array[$val] > 1) {
		            $result = 1;
		        }
		    }

		    return $result;
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
			        ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate])
			        ->toArray();

			if (count($query) == 0)
			  return 1;

			if ($returnType == 'ANNUAL') {
			  if(count($query) > 0)
			  return 0;
			  else return 1;
			}

			foreach ($query as $w) {
			  if (($w['total_no_days'] == "") && ($w['no_of_days_1'] == ""))
			    return 1;
			}
		}

		/**
		 * Returns the working details necessary for viewing of IBM user
		 * @param type $mineCode
		 * @param type $returnType
		 * @param type $returnDate
		 * @return type 
		 */
		public function getWorkingDetails($mineCode, $returnType, $returnDate) {

		  $MonthlyController = new MonthlyController;

		  $query = $this->find('all')
		          ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate])
		          ->toArray();

		  if (count($query) <= 0)
		    return array();

		  $data['total_days'] = $query[0]['total_no_days'];

		  $reasonsArr = $MonthlyController->Clscommon->getReasonsArr();

		  $count = 1;
		  for ($i = 0; $i < 5; $i++) {
		    if ($query[0]['stoppage_sn_' . $count] == ""){
				$data['reason'][$i] = "";
			}
		    else {
				$data['reason'][$i] = $reasonsArr[($query[0]['stoppage_sn_' . $count] == 1) ? '' : $query[0]['stoppage_sn_' . $count]];
			}
		    $data['no_of_days'][$i] = $query[0]['no_days_' . $count];
		    $count++;
		  }

		  return $data;
		}

		public function deleteAnnualRecords($mineCode, $returnDate) {

			$query = $this->query();
			$query->delete()
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>"ANNUAL"])
				->execute();

		}

	} 
?>