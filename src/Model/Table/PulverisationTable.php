<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use App\Controller\MonthlyController;
	use Cake\ORM\Locator\LocatorAwareTrait;
    use Cake\Datasource\ConnectionManager;
	use Cake\Core\Configure;
	
	class PulverisationTable extends Table{

		var $name = "Pulverisation";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function chkPulRecord($mineCode, $returnType, $returnDate, $mineralname) {
			$query = $this->find('all')
			        ->select(['mine_code', 'return_type', 'return_date', 'mineral_name'])
			        ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralname])
			        ->toArray();

			if (count($query) > 0)
			  return true;
			else
			  return false;
		}


		public function fetchPulRcd($mineCode, $returnType, $returnDate, $mineralName) {
			$query = $this->find('all')
			        ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"mineral_name"=>$mineralName])
			        ->order(['id'=>'ASC'])
			        ->toArray();

			if (count($query) > 0)
			  return $query;
			else
			  return array();
		}

		public function isPulverised($mineCode, $returnType, $returnDate, $mineralName) {
			$query = $this->find('all')
			        ->select(['is_pulverised'])
			        ->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>$mineralName])
			        ->toArray();

			if (count($query) > 0) {
			  if ($query[0]['is_pulverised'] == 1)
			    return true;
			  else
			    return false;
			}
			else
			  return false;

		}

		//fetch pulverisation data by mine code, return type, return date and mineral
		public function getPulverData($mineCode, $returnType, $returnDate, $mineralname, $pdfStatus = 0) {

			$MonthlyController = new MonthlyController;
            $conn = ConnectionManager::get(Configure::read('conn'));

			$query = $this->find('all')
				->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralname])
				->order(['id'=>'ASC'])
				->toArray();

			if (count($query) > 0){
				$data = $query;
			}
			else {

				if ($returnType == 'ANNUAL' && $pdfStatus == 0) {
					
					/**
					 * Prefetch the monthly records data for annual returns
					 * Effective from Phase - II
					 * @version 29th Oct 2021
					 * @author Aniket Ganvir
					 */
					$startDate = (date('Y',strtotime($returnDate))).'-04-01';
					$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
					$str = "SELECT
						id,
						return_type,
						grade_code,
						SUM(mineral_tot_qty) as mineral_tot_qty,
						produced_mesh_size,
						SUM(produced_quantity) as produced_quantity,
						sold_mesh_size,
						SUM(sold_quantity) as sold_quantity,
						SUM(sale_value) as sale_value,
						(
							SELECT avg(avg_cost) as avg_cost
							FROM `pulverisation`
							WHERE mine_code = '$mineCode'
							AND return_type = 'MONTHLY'
							AND return_date BETWEEN '$startDate' AND '$endDate'
							AND is_pulverised = 1
						) avg_cost,
						is_pulverised
						FROM `pulverisation`
						WHERE mine_code = '$mineCode'
						AND return_type = 'MONTHLY'
						AND return_date BETWEEN '$startDate' AND '$endDate'
						AND is_pulverised = 1
						GROUP BY grade_code, produced_mesh_size";
						
					$query = $conn->execute($str)->fetchAll('assoc');
					if ($query == null) {
						$data[0] = $MonthlyController->Customfunctions->getTableColumns('pulverisation');
					} else {
						$data = $query;
					}

				} else {
					$data[0] = $MonthlyController->Customfunctions->getTableColumns('pulverisation');
				}
			}

			return $data;

		}
		
		/**
		 * Cumulative monthly data for annual return
		 * @version 09th Nov 2021
		 * @author Aniket Ganvir
		 */
		public function getPulverDataMonthAll($mineCode, $returnType, $returnDate, $mineralname) {

			$MonthlyController = new MonthlyController;
            $conn = ConnectionManager::get(Configure::read('conn'));
			
			$startDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
			$str = "SELECT
				grade_code,
				SUM(mineral_tot_qty) as mineral_tot_qty,
				produced_mesh_size,
				SUM(produced_quantity) as produced_quantity,
				sold_mesh_size,
				SUM(sold_quantity) as sold_quantity,
				SUM(sale_value) as sale_value,
				(
					SELECT avg(avg_cost) as avg_cost
					FROM `pulverisation`
					WHERE mine_code = '$mineCode'
					AND return_type = 'MONTHLY'
					AND return_date BETWEEN '$startDate' AND '$endDate'
					AND is_pulverised = 1
				) avg_cost,
				is_pulverised
				FROM `pulverisation`
				WHERE mine_code = '$mineCode'
				AND return_type = 'MONTHLY'
				AND return_date BETWEEN '$startDate' AND '$endDate'
				AND is_pulverised = 1
				GROUP BY grade_code, produced_mesh_size";
				
			$query = $conn->execute($str)->fetchAll('assoc');
			if ($query == null) {
				$data[0] = $MonthlyController->Customfunctions->getTableColumns('pulverisation');
			} else {
				$data = $query;
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
	        	$mineral_name = $forms_data['mineral_name'];
	        	$f_grade_code = $forms_data['f_grade_code'];
	        	$f_mineral_tot_qty = $forms_data['f_mineral_tot_qty'];
	        	$f_produced_mesh_size = $forms_data['f_produced_mesh_size'];
	        	$f_produced_quantity = $forms_data['f_produced_quantity'];
	        	$f_sold_mesh_size = $forms_data['f_sold_mesh_size'];
	        	$f_sold_quantity = $forms_data['f_sold_quantity'];
	        	$f_sale_value = $forms_data['f_sale_value'];
	        	$avg_cost = $forms_data['avg_cost'];
	        	$is_pulverised = $forms_data['is_pulverised'];

	        	$rowDetail = $this->getPulverData($mineCode, $return_type, $return_date, $mineral_name);

	        	$this->deleteAll(array('mine_code'=>$mineCode,'return_type'=>$return_type,'return_date'=>$return_date,'mineral_name'=>$mineral_name));

	        	$created_at = date('Y-m-d H:i:s');

	        	$loopC = "0"; $result = true;
	        	foreach($f_grade_code as $g_code){

	        		$g_code = ($g_code == '') ? '0' : $g_code;
	        		$f_mineral_tot_qty[$loopC] = ($f_mineral_tot_qty[$loopC] == '') ? '0' : $f_mineral_tot_qty[$loopC];
	        		$f_produced_quantity[$loopC] = ($f_produced_quantity[$loopC] == '') ? '0' : $f_produced_quantity[$loopC];
	        		$f_sold_quantity[$loopC] = ($f_sold_quantity[$loopC] == '') ? '0' : $f_sold_quantity[$loopC];
	        		$f_sale_value[$loopC] = ($f_sale_value[$loopC] == '') ? '0' : $f_sale_value[$loopC];
	        		$avg_cost[$loopC] = ($avg_cost[$loopC] == '') ? '0' : $avg_cost[$loopC];

					$newEntity = $this->newEntity(array(
						'mine_code'=>$mineCode,
						'return_type'=>$return_type,
						'return_date'=>$return_date,
						'mineral_name'=>$mineral_name,
						'grade_code'=>$g_code,
						'mineral_tot_qty'=>$f_mineral_tot_qty[$loopC],
						'produced_mesh_size'=>$f_produced_mesh_size[$loopC],
						'produced_quantity'=>$f_produced_quantity[$loopC],
						'sold_mesh_size'=>$f_sold_mesh_size[$loopC],
						'sold_quantity'=>$f_sold_quantity[$loopC],
						'sale_value'=>$f_sale_value[$loopC],
						'avg_cost'=>$avg_cost,
						'is_pulverised'=>$is_pulverised,
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

	        	return $result;
        	} else {
				return false;
			}


	    }

	    public function postDataValidation($params){
			
			$returnValue = 1;
			
            $reply = $params['reply'];
            $section = $params['section_no'];

        	$f_grade_code = $params['f_grade_code'];
        	$f_mineral_tot_qty = $params['f_mineral_tot_qty'];
        	$f_produced_mesh_size = $params['f_produced_mesh_size'];
        	$f_produced_quantity = $params['f_produced_quantity'];
        	$f_sold_mesh_size = $params['f_sold_mesh_size'];
        	$f_sold_quantity = $params['f_sold_quantity'];
        	$f_sale_value = $params['f_sale_value'];
        	$avg_cost = $params['avg_cost'];
        	$is_pulverised = $params['is_pulverised'];

        	$loopC = "0";
        	foreach($f_grade_code as $g_code){

        		if(!empty($g_code)){ 
        			if(!is_numeric($g_code)){ $returnValue = null ; } 
        		}
        		if(!empty($f_mineral_tot_qty[$loopC])){ 
        			if(!is_numeric($f_mineral_tot_qty[$loopC]) && !is_float($f_mineral_tot_qty[$loopC])){ $returnValue = null ; } 
        			if(strlen($f_mineral_tot_qty[$loopC]) > '13'){ $returnValue = null ; }
        			if($f_mineral_tot_qty[$loopC] > 999999999.999){ $returnValue = null ; }
        		}
        		if(!empty($f_produced_mesh_size[$loopC])){ 
        			if(strlen($f_produced_mesh_size[$loopC]) > '15'){ $returnValue = null ; }
        		}
        		if(!empty($f_produced_quantity[$loopC])){ 
        			if(!is_numeric($f_produced_quantity[$loopC]) && !is_float($f_produced_quantity[$loopC])){ $returnValue = null ; } 
        			if(strlen($f_produced_quantity[$loopC]) > '13'){ $returnValue = null ; }
        			if($f_produced_quantity[$loopC] > 999999999.999){ $returnValue = null ; }
        		}
        		if(!empty($f_sold_mesh_size[$loopC])){ 
        			if(strlen($f_sold_mesh_size[$loopC]) > '15'){ $returnValue = null ; }
        		}
        		if(!empty($f_sold_quantity[$loopC])){ 
        			if(!is_numeric($f_sold_quantity[$loopC]) && !is_float($f_sold_quantity[$loopC])){ $returnValue = null ; } 
        			if(strlen($f_sold_quantity[$loopC]) > '13'){ $returnValue = null ; }
        			if($f_sold_quantity[$loopC] > 999999999.999){ $returnValue = null ; }
        		}
        		if(!empty($f_sale_value[$loopC])){ 
        			if(!is_numeric($f_sale_value[$loopC]) && !is_float($f_sale_value[$loopC])){ $returnValue = null ; } 
        			if(strlen($f_sale_value[$loopC]) > '14'){ $returnValue = null ; }
        			if($f_sale_value[$loopC] > 99999999999.99){ $returnValue = null ; }
        		}
        		if(!empty($avg_cost)){ 
        			if(!is_numeric($avg_cost) && !is_float($avg_cost)){ $returnValue = null ; } 
        		}

	        	$loopC++;
	        }
			
			return $returnValue;
			
		}
		
		public function getPulvRecords($mineCode, $returnType, $returnDate, $mineralName) {

			$query = $this->find()
					->select(['grade_code', 'mineral_tot_qty', 'produced_mesh_size', 'produced_quantity', 
					  'sold_mesh_size', 'sold_quantity', 'sale_value', 'avg_cost'])
					->where(['mine_code'=>$mineCode])
					->where(['return_type'=>$returnType])
					->where(['return_date'=>$returnDate])
					->where(['mineral_name'=>$mineralName])
					->order(['id'=>'ASC'])
					->toArray();
		
			$data = array();
			$dirMineralGrade = TableRegistry::getTableLocator()->get('DirMineralGrade');
		
			if (count($query) > 0) {
			  $i = 0;
			  foreach ($query as $p) {
				$data[$i]['GRADE_CODE'] = $dirMineralGrade->getGradeName($p['grade_code']);
				$data[$i]['MINERAL_TOT_QTY'] = $p['mineral_tot_qty'];
				$data[$i]['PRODUCED_MESH_SIZE'] = $p['produced_mesh_size'];
				$data[$i]['PRODUCED_QUANTITY'] = $p['produced_quantity'];
				$data[$i]['SOLD_MESH_SIZE'] = $p['sold_mesh_size'];
				$data[$i]['SOLD_QUANTITY'] = $p['sold_quantity'];
				$data[$i]['SALE_VALUE'] = $p['sale_value'];
				$data[$i]['AVG_COST'] = $p['avg_cost'];
		
				$i++;
			  }
			}
			return $data;

		}

		/**
		 * Check filled status of section
		 * @version 30th Oct 2021
		 * @author Aniket Ganvir
		 */
		public function isFilled($mineCode, $returnType, $returnDate, $mineralname) {

			$records = $this->find('all')
				->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralname])
				->count();

			if ($records > 0) {
				return true;
			} else {
				return false;
			}

		}


	} 
?>