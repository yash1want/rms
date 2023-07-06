<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\Datasource\ConnectionManager;
	
	class MiningPlanTable extends Table{

		var $name = "MiningPlan";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public static function getMineData($mineCode) {

			$conn = ConnectionManager::get(Configure::read('conn'));
			$q = $conn->execute("select registration_no,lessee_owner_name,mine_code,mine_name
								from mine 
								where mine_code = '$mineCode'");

			$query = $q->fetchAll('assoc');
			
			$data['registration_no'] = $query[0]['registration_no'];
			$data['owner_name'] = $query[0]['lessee_owner_name'];
			$data['mine_code'] = $query[0]['mine_code'];
			$data['mine_name'] = $query[0]['mine_name'];
	
			return $data;
		}

	    public function getEstimatedProd($mineCode, $mineralName, $subMin, $returnYear, $returnDate) {
	        $returnType = $_SESSION['returnType'];
	        /**
	         * ADDED THE BELOW RETURN TYPE AS ON MMS SIDE THE RETURN TYPE IS PASSED AS return_type
	         * ADDED THE if($mms_user_id) CONDITION FOR CHECKING THE MONTH ON THE MMS SIDE AS 
	         * THEY DON'T HAVE 'M' IN THEIR SESSION SO CHECKING FOR 'mms_user_id' TO CONFIRM THE 
	         * MMS USER AND THEN EXPLODING AND GETTING THE MONTH
	         * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
	         * @version 10th March 2014
	         *
	         * */
	        // if (!$returnType){
	        //     $returnType = sfContext::getInstance()->getUser()->getAttribute('return_type');
	        // }

	        if ($returnType == 'MONTHLY') {
	            $returnMonth = $_SESSION['mc_sel_month'];

	            // $mms_user_id = $_SESSION['mms_user_id'];

	            if (isset($_SESSION['mms_user_id'])) {

					$mms_user_id = $_SESSION['mms_user_id'];
	                $returnMonthTemp = $_SESSION['returnDate'];
	                $returnMonthTemp2 = explode('-', $returnMonthTemp);
	                $returnMonth = $returnMonthTemp2[1];
	            }

	            if (!$returnMonth) {
	                $tmp = explode("-", $returnDate);
	                $returnMonth = $tmp[1];
	            }


	            if ($returnMonth >= 1 && $returnMonth < 4) {
	                $returnYear = $returnYear - 1;
	            }
	        }

	//        print_r("********************");
	//        print_r($mineCode . "---");
	//        print_r($mineralName . "---");
	//        print_r($subMin . "---");
	//        print_r($returnYear);
	//        die;

	        if (is_string($subMin)) {
	            $subMin = strtolower(trim($subMin));
	            if ($subMin == 'hematite')
	                $subMin = 1;
	            if ($subMin == 'magnetite')
	                $subMin = 2;
	        }

	        $mineralName = strtoupper(str_replace('_', ' ', $mineralName));
	        if ($mineralName == "IRON ORE") {
	            if (is_numeric($subMin)) {
	                if ($subMin == 1)
	//          $subMin = "HEMATITE";
	                    $mineralName = 1;
	                else if ($subMin == 2)
	//          $subMin = "MAGNETITE";
	                    $mineralName = 2;
	//      }else {
	//        $subMin = strtoupper($subMin);
	            }
	//      $mineralName = $mineralName . "-" . $subMin;
	        }

			// Increment year by 1 as this causing condition mismatch in mining_plan table
			// For the financial year 2021-2022 it is storing 2022 as first_submit_date which is causing mis-match issue while
			// fetching records
			// Added on 25-05-2022 by Aniket G.
			$returnYear = $returnYear+1;
	        $query = $this->find('all')
	                ->select(['year_1', 'year_2', 'year_3', 'year_4', 'year_5', 'first_submit_date'])
	                ->where(['mine_code'=>$mineCode,'mineral_name'=>$mineralName,'status'=>'1','form_status' => '1','first_submit_date <=' => $returnYear])
	                ->order(['id'=>'DESC'])
	                ->limit(1)
	                ->toArray();

	        if (count($query) > 0) {
	            $first_submit_date = $query[0]['first_submit_date'];

	            $years[$first_submit_date] = $query[0]['year_1'];
	            $years[$first_submit_date + 1] = $query[0]['year_2'];
	            $years[$first_submit_date + 2] = $query[0]['year_3'];
	            $years[$first_submit_date + 3] = $query[0]['year_4'];
	            $years[$first_submit_date + 4] = $query[0]['year_5'];

	            $estimatedProd = (isset($years[$returnYear])) ? $years[$returnYear] : "";
	        }

	        $estimatedProd = (isset($estimatedProd) && $estimatedProd != "") ? $estimatedProd : 0;

	        return $estimatedProd;
	    }

	    public function getEstimatedProdForMms($mineCode, $mineralName, $subMin, $returnYear, $returnDate) {
	        $returnType = $_SESSION['returnType'];
	        /**
	         * ADDED THE BELOW RETURN TYPE AS ON MMS SIDE THE RETURN TYPE IS PASSED AS return_type
	         * ADDED THE if($mms_user_id) CONDITION FOR CHECKING THE MONTH ON THE MMS SIDE AS 
	         * THEY DON'T HAVE 'M' IN THEIR SESSION SO CHECKING FOR 'mms_user_id' TO CONFIRM THE 
	         * MMS USER AND THEN EXPLODING AND GETTING THE MONTH
	         * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
	         * @version 10th March 2014
	         *
	         * */
	        // if (!$returnType){
	        //     $returnType = sfContext::getInstance()->getUser()->getAttribute('return_type');
	        // }

	        if ($returnType == 'MONTHLY') {
	            $returnMonth = $_SESSION['mc_sel_month'];

	            $mms_user_id = $_SESSION['mms_user_id'];

	            if ($mms_user_id) {

	                $returnMonthTemp = $_SESSION['returnDate'];
	                $returnMonthTemp2 = explode('-', $returnMonthTemp);
	                $returnMonth = $returnMonthTemp2[1];
	            }

	            if (!$returnMonth) {
	                $tmp = explode("-", $returnDate);
	                $returnMonth = $tmp[1];
	            }


	            if ($returnMonth >= 1 && $returnMonth < 4) {
	                $returnYear = $returnYear - 1;
	            }
	        }

	        if (is_string($subMin)) {
	            $subMin = strtolower(trim($subMin));
	            if ($subMin == 'hematite')
	                $subMin = 1;
	            if ($subMin == 'magnetite')
	                $subMin = 2;
	        }

	        $mineralName = strtoupper(str_replace('_', ' ', $mineralName));
	        if ($mineralName == "IRON ORE") {
	            if (is_numeric($subMin)) {
	                if ($subMin == 1)
	//          $subMin = "HEMATITE";
	                    $mineralName = 1;
	                else if ($subMin == 2)
	//          $subMin = "MAGNETITE";
	                    $mineralName = 2;
	//      }else {
	//        $subMin = strtoupper($subMin);
	            }
	//      $mineralName = $mineralName . "-" . $subMin;
	        }

	        $query = $this->find('all')
	                ->select(['year_1', 'year_2', 'year_3', 'year_4', 'year_5', 'first_submit_date'])
	                ->where(['mine_code'=>$mineCode,'mineral_name'=>$mineralName,'status'=>'1','form_status' => '1','FIRST_SUBMIT_DATE <=' => $returnYear])
	                ->order(['created_at'=>'DESC'])
	                ->limit(1)
	                ->toArray();

	        if (count($query) > 0) {
	            $first_submit_date = $query[0]['first_submit_date'];

	            $years[$first_submit_date] = $query[0]['year_1'];
	            $years[$first_submit_date + 1] = $query[0]['year_2'];
	            $years[$first_submit_date + 2] = $query[0]['year_3'];
	            $years[$first_submit_date + 3] = $query[0]['year_4'];
	            $years[$first_submit_date + 4] = $query[0]['year_5'];

	            $estimatedProd = (isset($years[$returnYear])) ? $years[$returnYear] : 0;
	        }

	        $estimatedProd = (isset($estimatedProd) && $estimatedProd != "") ? $estimatedProd : 0;

	        return $estimatedProd;
	    }


        public function getCumProd($mineCode, $mineralName, $subMin, $returnYear, $returnMonth, $returnType = 'MONTHLY') {

			$returnMonth = (is_int($returnMonth)) ? $returnMonth : date('m',strtotime('2000-'.$returnMonth.'-01'));
			$returnMonth = ($returnType == 'MONTHLY') ? $returnMonth : 04;
	        $mineCode = ($mineCode != "") ? "'$mineCode'" : "''";

	        $mineralName = strtoupper(str_replace('_', ' ', $mineralName));
	        $mineralName = ($mineralName != "") ? "'$mineralName'" : "''";
	        $returnType = ($returnType != "") ? "'$returnType'" : "''";

	        if (is_numeric($subMin)) {
	            if ($subMin == 1)
	                $subMin = "hematite";
	            else if ($subMin == 2)
	                $subMin = "magnetite";
	        }
	        $subMin = ($subMin != "") ? "'$subMin'" : "''";

	        if ($returnMonth < 4) {
	            $tmp_prev_year = $returnYear - 1;
	            $tmp_cur_year = $returnYear;
	        } else {
	            $tmp_prev_year = $returnYear;
	            $tmp_cur_year = $returnYear + 1;
	        }

	        $prev_year = "'$tmp_prev_year-04-01'";
	        $cur_year = "'$returnYear-$returnMonth-01'";

	//    print_r($mineCode);
	//    print_r($mineralName);
	//    print_r($subMin);
	//    print_r($prev_year);
	//    print_r($cur_year);
	//    print_r($returnType);

	        $con = ConnectionManager::get(Configure::read('conn'));
	        $q = $con->execute("CALL SP_AnualProduction($mineCode, $mineralName, $subMin, $prev_year, $cur_year, $returnType);");
	        $cumProd = $q->fetchAll('assoc');
	//    print_r($cumProd);
	//    die;

	        // $cumProdTotal = (isset($cumProd[0]['grandtotalprod'])) ? $cumProd[0]['grandtotalprod'] : 0;
	        $cumProdTotal = $cumProd[0]['GrandTotalProd'];

	        return $cumProdTotal;
	    }

		public function getEstimationDetailsForPrintAll($mineCode, $mineralName, $subMin, $returnDate, $returnType) {
			$tmp = explode("-", $returnDate);
			$returnYear = $tmp[0];
			$returnMonth = $tmp[1];
	
			//    if ($isHematite == true)	
			//      $subMin = "HEMATITE";
			//    if ($isMagnetite == true)
			//      $subMin = "MAGNETITE";
	
			$estimatedProd = $this->getEstimatedProd($mineCode, $mineralName, $subMin, $returnYear, $returnDate);
	
			$cumProd = $this->getCumProd($mineCode, $mineralName, $subMin, $returnYear, $returnMonth, $returnType);
	
			$difference = $estimatedProd - $cumProd;
			$data['min'] = strtoupper(str_replace('_', ' ', $mineralName));
			$data['est'] = $estimatedProd;
			$data['cum'] = $cumProd;
			$data['diff'] = number_format($difference, 0, '', '');
	
			return $data;
		}
		public function getEstimationDetails($mineCode, $mineralName, $isHematite, $isMagnetite, $returnDate, $returnType) {
			$tmp = explode("-", $returnDate);
			$returnYear = $tmp[0];
			$returnMonth = $tmp[1];
			$subMin = '';
	
			if ($isHematite == true){
				$subMin = "HEMATITE";
			}
			if ($isMagnetite == true){
				$subMin = "MAGNETITE";
			}
	
			$estimatedProd = $this->getEstimatedProd($mineCode, $mineralName, $subMin, $returnYear, $returnDate);
	
			$cumProd = $this->getCumProd($mineCode, $mineralName, $subMin, $returnYear, $returnMonth, $returnType);
	
			$difference = $estimatedProd - $cumProd;
			$data['min'] = strtoupper(str_replace('_', ' ', $mineralName));
			$data['est'] = $estimatedProd;
			$data['cum'] = $cumProd;
			$data['diff'] = number_format($difference, 0, '', '');
	
			return $data;
		}
		// 27-01-2021 ,guided by pravin sir, execute by pranov , list of mine owners
		public static function getMiningPlanForMineOwner($ownerId) {
			$con = ConnectionManager::get('default');
			// GETTING DATA FOR RENDERING
			$q = $con->execute("SELECT *
							FROM MINING_PLAN P
							INNER JOIN MINE M ON M.mine_code = P.mine_code
							AND P.mine_code IN(
							SELECT MU.mcu_mine_code FROM MC_USER MU
							WHERE MU.mcu_parent_app_id = '$ownerId')
							AND P.STATUS = '1';
						  ");
			$records = $q->fetchAll('assoc');

			$q2 = $con->execute("SELECT count(*) as total_records
							FROM MINING_PLAN P
							INNER JOIN MINE M ON M.mine_code = P.mine_code
							AND P.mine_code IN(
							SELECT MU.mcu_mine_code FROM MC_USER MU
							WHERE MU.mcu_parent_app_id = '$ownerId')
							AND P.STATUS = '1'
						  ");

			$total_count = $q2->fetchAll('assoc');
			$totalRecords = $total_count[0]['total_records'];

			$userData = Array();
			$userData['totalRecords'] = $totalRecords;
			$userData['miningPlan'] = $records;
			return $userData;
		}

		// 27-01-2021 ,guided by pravin sir, execute by pranov , details of mine owner and 5 year data	
		public function getMiningPlanDetails($id, $mine_code) {
			$query = $this->find('all',array('conditions' => array('id IS' => $id,'mine_code IS' => $mine_code)))->toArray();
//			print_r($mine_code);die;

			$total_records = count($query);
			$data = array();
			if ($total_records > 0) {
				$static_data['id'] = $query[0]['id'];
				$static_data['registration_no'] = $query[0]['REGISTRATION_NO'];
				$static_data['owner_name'] = $query[0]['OWNER_NAME'];
				$static_data['mine_code'] = $query[0]['mine_code'];
				$static_data['mine_name'] = $query[0]['MINE_NAME'];
				$static_data['document_type'] = $query[0]['DOCUMENT_TYPE'];
				$static_data['reason'] = $query[0]['REFERRED_BACK_REASON'];
				$static_data['appr_date'] = date('d-m-Y',strtotime($query[0]['APPR_DATE']));
				$static_data['EFF_APPR_DATE'] = date('d-m-Y',strtotime($query[0]['EFF_APPR_DATE']));
				$static_data['COMMENCEMENT_DATE'] = date('d-m-Y',strtotime($query[0]['COMMENCEMENT_DATE']));

				for ($i = 0; $i < $total_records; $i++) {
					$year = $query[$i]['FIRST_SUBMIT_DATE'];

					$result['year1'] = $query[$i]['YEAR_1'];
					$result['year2'] = $query[$i]['YEAR_2'];
					$result['year3'] = $query[$i]['YEAR_3'];
					$result['year4'] = $query[$i]['YEAR_4'];
					$result['year5'] = $query[$i]['YEAR_5'];
					$result['first_submit_data'] = $query[$i]['FIRST_SUBMIT_DATE'];
					$result['mineral_name'] = $query[$i]['MINERAL_NAME'];
					$result['status'] = $query[$i]['STATUS'];
					$result['document_type'] = $query[$i]['DOCUMENT_TYPE'];
				}
			}
			$data['static_data'] = $static_data;
			$data['dynamic_data'] = $result;

			return $data;
		}

		//mining plan list ro user Date:07/02/2022 by Shalini D
		public function getAllApprovedMiningPlans($formData)
		{
			//print_r($formData);die;
			$mmsUserId = $_SESSION['mms_user_id'];
			$mmsUserRole = $_SESSION['mms_user_role'];

	        $users = $mmsUserId;
	        $userRole = $mmsUserRole;
	        
	        $mine_code = ($formData['mine_code'] != "") ? "'".$formData['mine_code']."'" :"''";
	        $year = ($formData['year'] != "") ? "'".$formData['year']."'" : "''";
	        $registrationNo = ($formData['reg_no'] != "") ? "'".$formData['reg_no']."'" : "''";
	      
	        $state =  "''";
	        $district =  "''";
	        if(isset($formData['district']) && !empty($formData['district']))
	        {
		        $dist = explode('-',$formData['district']);
		        $state = "'".$dist[0]."'";
		        $district = "'".$dist[1]."'";
	        }

	        $conn = ConnectionManager::get(Configure::read('conn'));

	        $q = $conn->execute("CALL SP_MiningPlan($mine_code, $registrationNo, $year, $users,  $state, $district,$userRole)");
	        $returns = $q->fetchAll('assoc');

	        $data = array();
	        if(!empty($returns))
	        { $i = 0;
	        	foreach ($returns as $r) {
	                $data[$i]['id'] = $r['ID'];
	                $data[$i]['reg_no'] = $r['REGISTRATION_NO'];
	                $data[$i]['owner_name'] = $r['OWNER_NAME'];
	                $data[$i]['mine_name'] = $r['MINE_NAME'];
	                $data[$i]['mine_code'] = $r['mine_code'];
	                $data[$i]['mineral_name'] = $r['MINERAL_NAME'];
	                $data[$i]['first_submit_year'] = $r['FIRST_SUBMIT_DATE'];
	                $data[$i]['status'] = $r['STATUS'];
	                $i++;
            	}
	        }
	        
	        return  $data;

		}


	} 
?>