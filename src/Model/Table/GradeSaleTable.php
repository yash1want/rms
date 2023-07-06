<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use App\Controller\MonthlyController;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
    use Cake\Datasource\ConnectionManager;
	
	class GradeSaleTable extends Table{

		var $name = "GradeSale";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		//chk record is exists or not
		public function chkSalesRecord($mineCode, $returnType, $returnDate, $mineralname) {
			$result = $this->find('all')
			        ->select(['mine_code','return_type','return_date','mineral_name'])
			        ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralname])
			        ->toArray();

			if (count($result) > 0) {
			  return true;
			} else {
			  return false;
			}
		}

		//fetch sales array by mine code, return type, return date and mineral name 
		public function fetchSalesRcd($mineCode, $returnType, $returnDate, $mineralName) {
			$result = $this->find('all')
			        ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName])
			        ->order(['id'=>'ASC'])
			        ->toArray();

			if (count($result) > 0)
			  return $result[0];
			else
			  return array();
		}

		public function findOneById($salesId) {
			$result = $this->find('all')
			        ->where(["id"=>$salesId])
			        ->toArray();
			        
			if (count($result) > 0)
			  return $result[0];
			else
			  return array();
		}

		//fetch sales array by mine code, return type, return date and mineral name 
		public function fetchSalesData($mineCode, $returnType, $returnDate, $mineralName, $pdfStatus = 0) {

			$MonthlyController = new MonthlyController;
            $conn = ConnectionManager::get(Configure::read('conn'));

			$result = $this->find('all')
				->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName])
				->order(['id'=>'ASC'])
				->toArray();

			if (count($result) > 0){
				$data = $result;
			} else {
				if ($returnType == 'ANNUAL' && $pdfStatus == 0) {
					/**
					 * Prefetch the monthly records data for annual returns
					 * Effective from Phase - II
					 * @version 29th Oct 2021
					 * @author Aniket Ganvir
					 */
					$starDate = (date('Y',strtotime($returnDate))).'-04-01';
					$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
					$str = "SELECT 
						id,
						return_type,
						grade_code,
						client_type,
						client_name,
						client_reg_no,
						sum(quantity) as quantity,
						sum(sale_value) as sale_value,
						expo_country,
						sum(expo_quantity) as expo_quantity,
						sum(expo_fob) as expo_fob
						FROM `grade_sale`
						WHERE mine_code = '$mineCode'
						AND return_type = 'MONTHLY'
						AND return_date BETWEEN '$starDate' AND '$endDate'
						AND mineral_name = '$mineralName'
						GROUP BY grade_code, client_type, client_reg_no, expo_country";
						
					$query = $conn->execute($str)->fetchAll('assoc');
					if ($query == null) {
						$data[0] = $MonthlyController->Customfunctions->getTableColumns('grade_sale');
					} else {
						$data = $query;
					}

				} else {
					$data[0] = $MonthlyController->Customfunctions->getTableColumns('grade_sale');
				}
			}

            $mcApplicantDet = TableRegistry::getTableLocator()->get('McApplicantDet');
			foreach($data as $l=>$d) {
				$data[$l]['client_name_status'] = $mcApplicantDet->checkConsigneeName($d['client_reg_no'], $d['client_name']);
			}

			return $data;
			
		}
		
		public function fetchSalesDataMonthly($mineCode, $returnDate, $mineralName) {

			$MonthlyController = new MonthlyController;
            $conn = ConnectionManager::get(Configure::read('conn'));

			/**
			 * Prefetch the monthly records data for annual returns
			 * Effective from Phase - II
			 * @version 05th Nov 2021
			 * @author Aniket Ganvir
			 */
			$starDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
			$str = "SELECT 
				id,
				return_type,
				grade_code,
				client_type,
				client_name,
				client_reg_no,
				sum(quantity) as quantity,
				sum(sale_value) as sale_value,
				expo_country,
				sum(expo_quantity) as expo_quantity,
				sum(expo_fob) as expo_fob
				FROM `grade_sale`
				WHERE mine_code = '$mineCode'
				AND return_type = 'MONTHLY'
				AND return_date BETWEEN '$starDate' AND '$endDate'
				AND mineral_name = '$mineralName'
				GROUP BY grade_code, client_type, client_reg_no, expo_country";
				
			$query = $conn->execute($str)->fetchAll('assoc');
			if ($query == null) {
				$data[0] = $MonthlyController->Customfunctions->getTableColumns('grade_sale');
			} else {
				$data = $query;
			}

			return $data;
			
		}

		// save or update form data
	    public function saveFormDetails($forms_data){

			$dataValidatation = $this->postDataValidation($forms_data);

			if($dataValidatation == 1 ){

	            $formId = $forms_data['form_no'];
	            $mineCode = $forms_data['mine_code'];
	        	$return_type = $forms_data['return_type'];
	        	$return_date = $forms_data['return_date'];
	        	$mineral_name = $forms_data['mineral_name'];
				$iron_sub_min = $forms_data['iron_sub_min'];
				$min_iron_type = (in_array($iron_sub_min, array('hematite', 'magnetite'))) ? $iron_sub_min : '-';
	        	$grade_code = $forms_data['grade_code'];
	        	$client_type = $forms_data['client_type'];
	        	$client_reg_no = $forms_data['client_reg_no'];
	        	$client_name = $forms_data['client_name'];
	        	$quantity = $forms_data['quantity'];
	        	$sale_value = $forms_data['sale_value'];
	        	
	        	$expo_country = $forms_data['expo_country'];
	        	$expo_quantity = $forms_data['expo_quantity'];
	        	$expo_fob = $forms_data['expo_fob'];

	            $this->deleteAll(array("mine_code"=>$mineCode,"return_type"=>$return_type,"return_date"=>$return_date,"mineral_name"=>$mineral_name));

	        	$created_at = date('Y-m-d H:i:s');

	        	$result = false;

	        	$loopC = "0";
	        	$export = "0";
	        	$nonexport = "0";
				
				if(in_array('NIL', $grade_code)){
					
					$newEntity = $this->newEntity(array(
						'mine_code'=>$mineCode,
						'return_type'=>$return_type,
						'return_date'=>$return_date,
						'mineral_name'=>$mineral_name,
						'min_iron_type'=>$min_iron_type,
						'grade_code'=>'0',
						'new_grade_code'=>'0',
						'client_type'=>'NIL',
						'client_name'=>'NIL',
						'client_reg_no'=>'0',
						'quantity'=>'0.000',
						'sale_value'=>'0.00',
						'expo_country'=>'NIL',
						'expo_quantity'=>'0.000',
						'expo_fob'=>'0.00',
						'created_at'=>$created_at,
						'updated_at'=>date('Y-m-d H:i:s')
					));

					if($this->save($newEntity)){
						$result = 1;
					} else {
						$result = false;
					}

				} else {
					foreach($grade_code as $g_code){

						if($client_type[$loopC] == 'EXPORT'){

							$expo_country_val = $expo_country[$export];
							$expo_quantity_val = $expo_quantity[$export];
							$expo_fob_val = $expo_fob[$export];

							$client_reg_no_val = "";
							$client_name_val = "";
							$quantity_val = "";
							$sale_value_val = "";
							$export++;

						} else {

							$expo_country_val = "";
							$expo_quantity_val = "";
							$expo_fob_val = "";
							$client_reg_no_val = $client_reg_no[$nonexport];
							$client_name_val = $client_name[$nonexport];
							$quantity_val = $quantity[$nonexport];
							$sale_value_val = $sale_value[$nonexport];
							$nonexport++;

						}

						$newEntity = $this->newEntity(array(
							'mine_code'=>$mineCode,
							'return_type'=>$return_type,
							'return_date'=>$return_date,
							'mineral_name'=>$mineral_name,
							'min_iron_type'=>$min_iron_type,
							'grade_code'=>$g_code,
							'new_grade_code'=>$g_code,
							'client_type'=>$client_type[$loopC],
							'client_reg_no'=>$client_reg_no_val,
							'client_name'=>$client_name_val,
							'quantity'=>$quantity_val,
							'sale_value'=>$sale_value_val,
							'expo_country'=>$expo_country_val,
							'expo_quantity'=>$expo_quantity_val,
							'expo_fob'=>$expo_fob_val,
							'created_at'=>$created_at,
							'updated_at'=>date('Y-m-d H:i:s')
						));

						if($this->save($newEntity)){
							$result = 1;
						} else {
							$result = false;
						}

						$loopC++;

					}

				}

	        	$reason_1 = trim($forms_data['reason_1']);
	        	$reason_2 = trim($forms_data['reason_2']);

				$incrDecrReasons = TableRegistry::getTableLocator()->get('IncrDecrReasons');
				$reasonsData = $incrDecrReasons->getAllData($mineCode, $return_type, $return_date, $mineral_name);

				if($reasonsData['id']!=''){
					if($reason_1 != '' || $reason_2 != ''){
						$row_id = $reasonsData['id'];
	        			$created_at = $reasonsData['created_at'];

						$newEntity = $incrDecrReasons->newEntity(array(
							'id'=>$row_id,
							'mine_code'=>$mineCode,
							'return_type'=>$return_type,
							'return_date'=>$return_date,
							'mineral_name'=>$mineral_name,
							'reason_1'=>$reason_1,
							'reason_2'=>$reason_2,
							'created_at'=>$created_at,
							'updated_at'=>date('Y-m-d H:i:s')
						));

						if($incrDecrReasons->save($newEntity)){
							$result = 1;
						} else {
							$result = false;
						}

					} else {

	            		$incrDecrReasons->deleteAll(array("mine_code"=>$mineCode,"return_type"=>$return_type,"return_date"=>$return_date,"mineral_name"=>$mineral_name));

					}
				} else {

					if($reason_1 != '' || $reason_2 != ''){
						$row_id = '';

						$newEntity = $incrDecrReasons->newEntity(array(
							'id'=>$row_id,
							'mine_code'=>$mineCode,
							'return_type'=>$return_type,
							'return_date'=>$return_date,
							'mineral_name'=>$mineral_name,
							'reason_1'=>$reason_1,
							'reason_2'=>$reason_2,
							'created_at'=>date('Y-m-d H:i:s'),
							'updated_at'=>date('Y-m-d H:i:s')
						));

						if($incrDecrReasons->save($newEntity)){
							$result = 1;
						} else {
							$result = false;
						}
						
					}

				}
				
	            //save the reply alone here
	            // $reply = $this->getRequestParameter('reply');
	            // $section = $this->getRequestParameter('section_no');
	            // if ($reply != "")
	            //     $this->saveReply($reply, $section);

	            return $result;
        	}  else {
				return false;
			}

		}

	    public function postDataValidation($forms_data){
			
			$returnValue = 1;
			
        	$grade_code = $forms_data['grade_code'];
        	$client_type = $forms_data['client_type'];
        	$client_reg_no = $forms_data['client_reg_no'];
        	$client_name = $forms_data['client_name'];
        	$quantity = $forms_data['quantity'];
        	$sale_value = $forms_data['sale_value'];

        	$expo_country = $forms_data['expo_country'];
        	$expo_quantity = $forms_data['expo_quantity'];
        	$expo_fob = $forms_data['expo_fob'];

        	$loopC = "0";
        	$nonexport = "0";
        	$export = "0";
        	foreach($grade_code as $g_code){
				if($g_code != 'NIL'){
					if(!empty($client_type[$loopC])){

						if(empty($g_code)){ $returnValue = null ; }

						if(!is_numeric($g_code)){ $returnValue = null ; }

						if($client_type[$loopC] == 'EXPORT'){

							if($expo_country[$export] == ''){ $returnValue = null ; }
							if($expo_quantity[$export] == ''){ $returnValue = null ; }
							if($expo_fob[$export] == ''){ $returnValue = null ; }

							if(!is_numeric($expo_quantity[$export])){ $returnValue = null ; }
							if(!is_numeric($expo_fob[$export]) && !is_float($expo_fob[$export])){ $returnValue = null ; }

							$export++;

						} else {

							if($quantity[$nonexport] == ''){ $returnValue = null ; }
							if($sale_value[$nonexport] == ''){ $returnValue = null ; }

							if(!is_numeric($quantity[$nonexport])){ $returnValue = null ; }
							if(!is_numeric($sale_value[$nonexport]) && !is_float($sale_value[$nonexport])){ $returnValue = null ; }

							$nonexport++;

						}

					} else {
						$returnValue = null ; 
					}
				}

				$loopC++;
        	}
	
			if(empty($forms_data['reason_1'])){ $returnValue = null ; }
			if(empty($forms_data['reason_2'])){ $returnValue = null ; }

			if(strlen($forms_data['reason_1']) > '500'){ $returnValue = null ; }
			if(strlen($forms_data['reason_2']) > '500'){ $returnValue = null ; }
			
			return $returnValue;
			
		}


		/**
		 * Returns the sales and dispatches for viewing of IBM Users
		 * @param type $mineCode
		 * @param type $returnType
		 * @param type $returnDate
		 * @param type $mineralName
		 * @return type 
		 */
		public function getSalesDispatches($mineCode, $returnType, $returnDate, $mineralName) {

			//print_r($mineCode,$returnType,$returnDate,$mineralName);die;
			$query = $this->find('all')
					->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName])
					->order(['id'=>'ASC'])
					->toArray();
			// print_r(count($query));die;
			if (count($query) < 1){
				return array();
			}

			$dirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
			$dirMetal = TableRegistry::getTableLocator()->get('DirMetal');
			$dirStoneType = TableRegistry::getTableLocator()->get('DirStoneType');
			$dirMineralGrade = TableRegistry::getTableLocator()->get('DirMineralGrade');
			$dirCountry = TableRegistry::getTableLocator()->get('DirCountry');

			$formType = $dirMcpMineral->getFormNumber($mineralName);

			$data = array();
			$stoneArr = array();
		  	$i = 0;
		 	foreach ($query as $g) {
				$grade_code = ($g['grade_code'] != "") ? $g['grade_code'] : 0;
				$grade_name = "--";
				if ($formType == 5) {
					if ($grade_code != 0){
						$grade_name = $dirMetal->getGradeName($g['grade_code'], $mineralName);
					}
				} 
				// Added else if condition for form type = 7
				// 14th oct 2014
				//author : Uday Singh
				else if ($formType == 7) { 
					if ($grade_code != 0){
						$stoneArr = $dirStoneType->fetchStoneGrades();
						$grade_name =$stoneArr[$grade_code];
						//  print_r($grade_name); 
					}
				
				}
				else {
					//get respective grade code
					if ($grade_code != 0){
						$grade_name = $dirMineralGrade->getGradeName($g['grade_code']);
					}
				}
		    
				$data[$i]['grade'] = $grade_name;

				$data[$i]['client_type'] = ($g['client_type'] != "") ? $g['client_type'] : "--";
				$data[$i]['client_name'] = ($g['client_name'] != "") ? $g['client_name'] : "--";
				$data[$i]['client_reg_no'] = ($g['client_reg_no'] != "") ? $g['client_reg_no'] : "--";
				$data[$i]['quantity'] = ($g['quantity'] != "") ? $g['quantity'] : "--";
				$data[$i]['sale_value'] = ($g['sale_value'] != "") ? $g['sale_value'] : "--";

				//get respective country name
				$country = $g['expo_country'];
				if ($country != ""){
					$data[$i]['country'] = $dirCountry->getCountry($country);
				}
				else {
					$data[$i]['country'] = "--";
				}

				$data[$i]['expo_quantity'] = ($g['expo_quantity'] != 0.000) ? $g['expo_quantity'] : "--";
				$data[$i]['expo_fob'] = ($g['expo_fob'] != 0) ? $g['expo_fob'] : "--";

				$i++;
		  	}

			// print_r($data);die;
			return $data;

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
			$mineralWorked = TableRegistry::getTableLocator()->get('MineralWorked');
			$minerals = $mineralWorked->find('all')
				->select(['mineral_name'])
				->where(["mine_code"=>$mineCode])
				->toArray();

			$min = array();

			foreach ($minerals as $m) {
				$query = $this->find('all')
						->where(["mine_code"=>$mineCode])
						->where(["return_date"=>$returnDate])
						->where(["return_type"=>$returnType])
						->where(["mineral_name"=>strtolower(str_replace(' ', '_', $m['mineral_name']))])
						->toArray();

				foreach ($query as $s) {
					if ($s['grade_code'] == "" || $s['client_type'] == "") {

						$mineral_name = str_replace('_', ' ', $s['mineral_name']);
						if (!in_array($mineral_name, $min))
						$min[] = $mineral_name;
					}
				}
			}

			if (count($min) > 0)
				return $min;
			else
				return 0;
		}

	} 
?>