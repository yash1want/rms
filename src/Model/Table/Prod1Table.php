<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use App\Controller\MonthlyController;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class Prod1Table extends Table{
		
		public function initialize(array $config): void
		{
			$this->setTable('prod_1');
		}
		
		// var $name = "Prod1";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		// fetch iron mineral name - HEMATITE MAGNETITE
		public function fetchIronTypeProduction($mineCode, $returnType, $returnDate, $mineralName, $subMinIronOre){
						
	        $row_count = $this->find('all',array('conditions'=>array('mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>$mineralName,$subMinIronOre=>'1')))->count();
	       // print_r($mineCode.'<br>'); print_r($returnType.'<br>'); print_r($returnDate.'<br>'); print_r($mineralName.'<br>');  exit;
			if($row_count > 0){
	        	return true;
	        } else {
	        	return false;
	        }

		}

		public function getMonSubOreType($mineCode, $returnType, $returnDate, $mineralName){

			$conn = ConnectionManager::get(Configure::read('conn'));  

			$starDate = (date('Y',strtotime($returnDate))).'-04-01';
            $endDate = (date('Y',strtotime($returnDate))+1).'-03-01';

			$sql = "SELECT sum(hematite) hematite,sum(magnetite) magnetite FROM `prod_1` 
			where mine_code='$mineCode' 
			and mineral_name = 'iron_ore'
			and return_type = 'MONTHLY'
			and return_date BETWEEN '$starDate' and '$endDate'";

			$queryResult = $conn->execute($sql)->fetchAll('assoc');
			
			return $queryResult[0];
			
		}

		//chk record is exists or not
	    public function chkProdDetails($mineCode, $returnType, $returnDate, $mineralName, $ironSubMin = '') {
	        if ($ironSubMin != '') {
	            $result = $this->find('all')
	                    ->select(['mine_code','return_type','return_date','mineral_name'])
	                    ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"mineral_name"=>$mineralName,$ironSubMin=>'1'])
	                    ->toArray();
	        } else {

	            $result = $this->find('all')
	                    ->select(['mine_code','return_type','return_date','mineral_name'])
	                    ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName])
	                    ->toArray();
	        }

	        if (count($result) > 0) {
	            return true;
	        } else {
	            return false;
	        }
    	}

	    //fetch prod array by mine code, return type, return date and mineral name 
	    public function fetchProduction($mineCode, $returnType, $returnDate, $mineralName, $ironSubMin = '', $section = '', $pdfStatus = 0) {

			$conn = ConnectionManager::get(Configure::read('conn'));
	    	$MonthlyController = new MonthlyController;

			$mineralName = str_replace(' ', '_', $mineralName);
			$result = array();

	        if ($ironSubMin != '') {

	            $result = $this->find('all')
	                    ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,$ironSubMin=>'1'])
	                    ->toArray();

				// For annual return prefetch monthly records logic	
				// Done By Pravin Bhakare, 30-09-2021	
				if( $returnType == "ANNUAL" )
				{
					$recordId = (isset($result[0]['id'])) ? $result[0]['id'] : '';

					if($section == 'deductiondet'){

						$isfill = $this->find('all')
							->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,$ironSubMin=>'1',"trans_cost IS NULL"])
							->toArray();

					}else{

						$isfill = $this->find('all')
							->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,$ironSubMin=>'1',"prod_oc_rom IS NULL"])
							->toArray();

					}
						

					$iron_type_con = "AND $ironSubMin = '1'";
				}		
				

	        } else {
	            $result = $this->find('all')
	                    ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName])
	                    ->toArray();

				if( $returnType == "ANNUAL" )
				{		
					if($section == 'deductiondet'){

						$isfill = $this->find('all')
							->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,"trans_cost IS NULL"])
							->toArray();

					}else{

						$isfill = $this->find('all')
							->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,"prod_oc_rom IS NULL"])
							->toArray();	
					}	
					$recordId = (isset($result[0]['id'])) ? $result[0]['id'] : '';
					$iron_type_con = "";
				}
			}

			// Prefetch the monthly records data for annula returns.
			// Done by Pravin bhakare 30-09-2021
			if(  $returnType == "ANNUAL"  && $isfill != null && $pdfStatus == 0){

				$starDate = (date('Y',strtotime($returnDate))).'-04-01';
            	$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';

				$str = "SELECT 
					g1.id,g1.mine_code, g1.return_type,g1.mineral_name,
					g1.trans_remark,g1.loading_remark,
					g1.railway_remark,g1.port_remark,g1.sampling_remark,
					g1.plot_remark,g1.other_remark,g1.created_at,g1.return_type,              
					CASE	
						WHEN g1.return_date = '$starDate' THEN g1.open_oc_rom    
					END as open_oc_rom,
					CASE	
						WHEN g1.return_date = '$starDate' THEN g1.open_ug_rom    
					END as open_ug_rom,
					CASE	
						WHEN g1.return_date = '$starDate' THEN g1.open_dw_rom    
					END as open_dw_rom,

					sum(prod_oc_rom) as prod_oc_rom,
					sum(prod_ug_rom) as prod_ug_rom,
					sum(prod_dw_rom) as prod_dw_rom,
					sum(g1.trans_cost) as trans_cost,
					sum(g1.loading_charges) as loading_charges,
					sum(g1.railway_freight) as railway_freight,
					sum(g1.port_handling) as port_handling,
					sum(g1.sampling_cost) as sampling_cost,
					sum(g1.plot_rent) as plot_rent,
					sum(g1.other_cost) as other_cost,
					sum(g1.total_prod) as total_prod,

					( 
						SELECT clos_oc_rom from prod_1
						where mine_code = '$mineCode'
						AND return_type = 'MONTHLY'
						AND return_date BETWEEN '$starDate' AND '$endDate' 
						AND mineral_name = '$mineralName'
						$iron_type_con       
						ORDER BY `return_date`  DESC
						LIMIT 1
					)  clos_oc_rom,

					( 
						SELECT clos_ug_rom from prod_1
						where mine_code = '$mineCode'
						AND return_type = 'MONTHLY'
						AND return_date BETWEEN '$starDate' AND '$endDate' 
						AND mineral_name = '$mineralName'
						$iron_type_con       
						ORDER BY `return_date`  DESC
						LIMIT 1
					)  clos_ug_rom,

					( 
						SELECT clos_dw_rom from prod_1
						where mine_code = '$mineCode'
						AND return_type = 'MONTHLY'
						AND return_date BETWEEN '$starDate' AND '$endDate' 
						AND mineral_name = '$mineralName'
						$iron_type_con
						ORDER BY `return_date`  DESC
						LIMIT 1
					)  clos_dw_rom

					FROM `prod_1` g1
					where mine_code = '$mineCode'
					AND return_type = 'MONTHLY'
					AND return_date BETWEEN '$starDate' AND '$endDate'
					AND mineral_name = '$mineralName'
					$iron_type_con					
					ORDER BY `id`  DESC";
					
					$result = $conn->execute($str)->fetchAll('assoc');
					$result[0]['id'] = $recordId;
			}
			
	        if (count($result) > 0){ 
	            $data = $result[0];
	        } else {
				$data = $MonthlyController->Customfunctions->getTableColumns('prod_1');
	        }
			
	        return $data;
	    }

		/**
		 * Cumulative monthly data for annual return
		 * @version 08th Nov 2021
		 * @author Aniket Ganvir
		 */
	    public function fetchProductionMonthly($mineCode, $returnType, $returnDate, $mineralName, $ironSubMin = '', $section = '') {

			$conn = ConnectionManager::get(Configure::read('conn'));
	    	$MonthlyController = new MonthlyController;

			$mineralName = str_replace(' ', '_', $mineralName);
			$result = array();

	        if ($ironSubMin != '') {
				$iron_type_con = "AND $ironSubMin = '1'";
	        } else {
				$iron_type_con = "";
			}

			$starDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';

			$str = "SELECT 
				CASE	
					WHEN g1.return_date = '$starDate' THEN g1.open_oc_rom    
				END as open_oc_rom,
				CASE	
					WHEN g1.return_date = '$starDate' THEN g1.open_ug_rom    
				END as open_ug_rom,
				CASE	
					WHEN g1.return_date = '$starDate' THEN g1.open_dw_rom    
				END as open_dw_rom,
				sum(prod_oc_rom) as prod_oc_rom,
				sum(prod_ug_rom) as prod_ug_rom,
				sum(prod_dw_rom) as prod_dw_rom,
				sum(g1.trans_cost) as trans_cost,
				sum(g1.loading_charges) as loading_charges,
				sum(g1.railway_freight) as railway_freight,
				sum(g1.port_handling) as port_handling,
				sum(g1.sampling_cost) as sampling_cost,
				sum(g1.plot_rent) as plot_rent,
				sum(g1.other_cost) as other_cost,
				sum(g1.total_prod) as total_prod,
				( 
					SELECT clos_oc_rom from prod_1
					where mine_code = '$mineCode'
					AND return_type = 'MONTHLY'
					AND return_date BETWEEN '$starDate' AND '$endDate' 
					AND mineral_name = '$mineralName'
					$iron_type_con       
					ORDER BY `return_date`  DESC
					LIMIT 1
				)  clos_oc_rom,

				( 
					SELECT clos_ug_rom from prod_1
					where mine_code = '$mineCode'
					AND return_type = 'MONTHLY'
					AND return_date BETWEEN '$starDate' AND '$endDate' 
					AND mineral_name = '$mineralName'
					$iron_type_con       
					ORDER BY `return_date`  DESC
					LIMIT 1
				)  clos_ug_rom,

				( 
					SELECT clos_dw_rom from prod_1
					where mine_code = '$mineCode'
					AND return_type = 'MONTHLY'
					AND return_date BETWEEN '$starDate' AND '$endDate' 
					AND mineral_name = '$mineralName'
					$iron_type_con
					ORDER BY `return_date`  DESC
					LIMIT 1
				)  clos_dw_rom

				FROM `prod_1` g1
				where mine_code = '$mineCode'
				AND return_type = 'MONTHLY'
				AND return_date BETWEEN '$starDate' AND '$endDate'
				AND mineral_name = '$mineralName'
				$iron_type_con					
				ORDER BY `id`  DESC";
				
			$result = $conn->execute($str)->fetchAll('assoc');
			
	        if (count($result) > 0){ 
	            $data = $result[0];
	        } else {
				$data = $MonthlyController->Customfunctions->getTableColumns('prod_1');
	        }
			
	        return $data;
	    }

	    //find prod array by parent id
	    public function findOneById($prodId){

            $result = $this->find('all')
                    ->where(["id IS"=>$prodId])
                    ->toArray();

	        if (count($result) > 0)
	            return $result[0];
	        else
	            return array();

	    }

        //fetch iron mineral name -HEMATITE MAGNETITE 
	    public function prodRecCount($mineCode, $returnType, $returnDate, $mineralName) {
	        $result = $this->find('all')
	                ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName])
	                ->toArray();
	        return count($result);
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
	        	$mineralName = $forms_data['mineral_name'];
	        	$ironSubMin = $forms_data['iron_sub_min'];

				$hematite = ($ironSubMin == 'hematite') ? 1 : '';
				$magnetite = ($ironSubMin == 'magnetite') ? 1 : '';

	        	$rowData = $this->fetchProduction($mineCode, $return_type, $return_date, $mineralName, $ironSubMin);
	        	if($rowData['id']!=""){
	        		$row_id = $rowData['id'];
	        		$created_at = $rowData['created_at'];
	        	} else {
	        		$row_id = '';
	        		$created_at = date('Y-m-d H:i:s');
	        	}

	        	$f_open_oc_rom = $forms_data['f_open_oc_rom'];
	        	$f_prod_oc_rom = $forms_data['f_prod_oc_rom'];
	        	$f_clos_oc_rom = $forms_data['f_clos_oc_rom'];
	        	$f_open_ug_rom = $forms_data['f_open_ug_rom'];
	        	$f_prod_ug_rom = $forms_data['f_prod_ug_rom'];
	        	$f_clos_ug_rom = $forms_data['f_clos_ug_rom'];
	        	$f_open_dw_rom = $forms_data['f_open_dw_rom'];
	        	$f_prod_dw_rom = $forms_data['f_prod_dw_rom'];
	        	$f_clos_dw_rom = $forms_data['f_clos_dw_rom'];

				$newEntity = $this->newEntity(array(
					'id'=>$row_id,
					'mine_code'=>$mineCode,
					'return_type'=>$return_type,
					'return_date'=>$return_date,
					'mineral_name'=>$mineralName,
					'hematite'=>$hematite,
					'magnetite'=>$magnetite,
					'open_oc_rom'=>$f_open_oc_rom,
					'prod_oc_rom'=>$f_prod_oc_rom,
					'clos_oc_rom'=>$f_clos_oc_rom,
					'open_ug_rom'=>$f_open_ug_rom,
					'prod_ug_rom'=>$f_prod_ug_rom,
					'clos_ug_rom'=>$f_clos_ug_rom,
					'open_dw_rom'=>$f_open_dw_rom,
					'prod_dw_rom'=>$f_prod_dw_rom,
					'clos_dw_rom'=>$f_clos_dw_rom,
					'created_at'=>$created_at,
					'updated_at'=>date('Y-m-d H:i:s')
				));
				if($this->save($newEntity)){
					$result = 1;
				} else {
					$result = false;
				}
			} else {
				$result = false;
			}

			return $result;

	    }

	    public function postDataValidation($forms_data){
			
			$returnValue = 1;
			
            $reply = $forms_data['reply'];
            $section = $forms_data['section_no'];
		
			if($forms_data['f_open_oc_rom'] == ''){ $returnValue = null ; }
			if($forms_data['f_prod_oc_rom'] == ''){ $returnValue = null ; }
			if($forms_data['f_clos_oc_rom'] == ''){ $returnValue = null ; }
			if($forms_data['f_open_ug_rom'] == ''){ $returnValue = null ; }
			if($forms_data['f_prod_ug_rom'] == ''){ $returnValue = null ; }
			if($forms_data['f_clos_ug_rom'] == ''){ $returnValue = null ; }
			if($forms_data['f_open_dw_rom'] == ''){ $returnValue = null ; }
			if($forms_data['f_prod_dw_rom'] == ''){ $returnValue = null ; }
			if($forms_data['f_clos_dw_rom'] == ''){ $returnValue = null ; }

			if(!is_numeric($forms_data['f_open_oc_rom']) && !is_float($forms_data['f_open_oc_rom'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_prod_oc_rom']) && !is_float($forms_data['f_prod_oc_rom'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_clos_oc_rom']) && !is_float($forms_data['f_clos_oc_rom'])){ $returnValue = null ; }

			if(!is_numeric($forms_data['f_open_ug_rom']) && !is_float($forms_data['f_open_ug_rom'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_prod_ug_rom']) && !is_float($forms_data['f_prod_ug_rom'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_clos_ug_rom']) && !is_float($forms_data['f_clos_ug_rom'])){ $returnValue = null ; }

			if(!is_numeric($forms_data['f_open_dw_rom']) && !is_float($forms_data['f_open_dw_rom'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_prod_dw_rom']) && !is_float($forms_data['f_prod_dw_rom'])){ $returnValue = null ; }
			if(!is_numeric($forms_data['f_clos_dw_rom']) && !is_float($forms_data['f_clos_dw_rom'])){ $returnValue = null ; }

			if(strlen($forms_data['f_open_oc_rom']) > '13'){ $returnValue = null ; }
			if(strlen($forms_data['f_prod_oc_rom']) > '13'){ $returnValue = null ; }
			if(strlen($forms_data['f_clos_oc_rom']) > '13'){ $returnValue = null ; }

			if(strlen($forms_data['f_open_ug_rom']) > '13'){ $returnValue = null ; }
			if(strlen($forms_data['f_prod_ug_rom']) > '13'){ $returnValue = null ; }
			if(strlen($forms_data['f_clos_ug_rom']) > '13'){ $returnValue = null ; }

			if(strlen($forms_data['f_open_dw_rom']) > '13'){ $returnValue = null ; }
			if(strlen($forms_data['f_prod_dw_rom']) > '13'){ $returnValue = null ; }
			if(strlen($forms_data['f_clos_dw_rom']) > '13'){ $returnValue = null ; }
			
			return $returnValue;
			
		}

		/**
	     * Returns true if the ore is selected already
	     * @param type $mineCode
	     * @param type $returnType
	     * @param type $returnDate
	     * @param type $mineral
	     * @return boolean 
	     */
	    public function isOreExists($mineCode, $returnType, $returnDate) {

	        $query = $this->find('all')
	                ->select(['hematite', 'magnetite'])
	                ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>"iron_ore"])
	                ->toArray();

	        if (count($query) > 0) {
	            foreach ($query as $m) {
	                if ($m['hematite'] || $m['magnetite'] != ""){
	                    return true;
					}
	            }
	        }
			
			return false;
			
	    }

	    // save or update form data
	    public function saveFormDetailsDeduction($forms_data){

			$dataValidatation = $this->postDataValidationDeduction($forms_data);
			$returnData = array();

			if($dataValidatation['err'] == 1 ){

	        	$returnVal = false;
	            $reply = $forms_data['reply'];
	            $section = $forms_data['section_no'];

	            $formId = $forms_data['form_no'];
	            $mineCode = $forms_data['mine_code'];
	        	$return_type = $forms_data['return_type'];
	        	$return_date = $forms_data['return_date'];
	        	$mineralName = str_replace(' ','_',$forms_data['mineral_name']);
	        	$ironSubMin = $forms_data['iron_sub_min'];

				$hematite = ($ironSubMin == 'hematite') ? 1 : '';
				$magnetite = ($ironSubMin == 'magnetite') ? 1 : '';

	        	$rowData = $this->fetchProduction($mineCode, $return_type, $return_date, $mineralName, $ironSubMin);
	        	if($rowData['id']!=""){
	        		$row_id = $rowData['id'];
	        		$created_at = $rowData['created_at'];
	        	} else {
	        		$row_id = '';
	        		$created_at = date('Y-m-d H:i:s');
	        	}

	        	$trans_cost = $forms_data['trans_cost'];
	        	$trans_remark = $forms_data['trans_remark'];
	        	$loading_charges = $forms_data['loading_charges'];
	        	$loading_remark = $forms_data['loading_remark'];
	        	$railway_freight = $forms_data['railway_freight'];
	        	$railway_remark = $forms_data['railway_remark'];
	        	$port_handling = $forms_data['port_handling'];
	        	$port_remark = $forms_data['port_remark'];
	        	$sampling_cost = $forms_data['sampling_cost'];
	        	$sampling_remark = $forms_data['sampling_remark'];
	        	$plot_rent = $forms_data['plot_rent'];
	        	$plot_remark = $forms_data['plot_remark'];
	        	$other_cost = $forms_data['other_cost'];
	        	$other_remark = $forms_data['other_remark'];
	        	$total_prod = $forms_data['total_prod'];

				$newEntity = $this->newEntity(array(
					'id'=>$row_id,
					'mine_code'=>$mineCode,
					'return_type'=>$return_type,
					'return_date'=>$return_date,
					'mineral_name'=>$mineralName,
					'trans_cost'=>$trans_cost,
					'trans_remark'=>$trans_remark,
					'loading_charges'=>$loading_charges,
					'loading_remark'=>$loading_remark,
					'railway_freight'=>$railway_freight,
					'railway_remark'=>$railway_remark,
					'port_handling'=>$port_handling,
					'port_remark'=>$port_remark,
					'sampling_cost'=>$sampling_cost,
					'sampling_remark'=>$sampling_remark,
					'plot_rent'=>$plot_rent,
					'plot_remark'=>$plot_remark,
					'other_cost'=>$other_cost,
					'other_remark'=>$other_remark,
					'total_prod'=>$total_prod,
					'created_at'=>$created_at,
					'updated_at'=>date('Y-m-d H:i:s')
				));
				if($this->save($newEntity)){
					$returnVal = 1;
				} else {
					$returnVal = false;
					$returnData['msg'][] = "Failed to update <b>Details of Deductions</b>! Please, try again later.";
				}

			} else {
				$returnVal = false;
				$returnData['msg'] = $dataValidatation['msg'];
				$result = false;
			}

			if($returnVal == 1){ $returnData['msg'][] = "<b>Details of Deductions</b> successfully saved !"; }

			$returnData['err'] = $returnVal;
			return $returnData;

	    }

	    public function postDataValidationDeduction($params){
			
			$returnValue = 1;
			$returnData = array();
			
			if(!is_numeric($params['trans_cost']) && !is_float($params['trans_cost'])){ $returnValue = null ; }
			if(!is_numeric($params['loading_charges']) && !is_float($params['loading_charges'])){ $returnValue = null ; }
			if(!is_numeric($params['railway_freight']) && !is_float($params['railway_freight'])){ $returnValue = null ; }
			if(!is_numeric($params['port_handling']) && !is_float($params['port_handling'])){ $returnValue = null ; }
			if(!is_numeric($params['sampling_cost']) && !is_float($params['sampling_cost'])){ $returnValue = null ; }
			if(!is_numeric($params['plot_rent']) && !is_float($params['plot_rent'])){ $returnValue = null ; }
			if(!is_numeric($params['other_cost']) && !is_float($params['other_cost'])){ $returnValue = null ; }
			if(!is_numeric($params['total_prod']) && !is_float($params['total_prod'])){ $returnValue = null ; }

			if($params['trans_cost'] == ''){ $returnValue = null ; }
			if($params['loading_charges'] == ''){ $returnValue = null ; }
			if($params['railway_freight'] == ''){ $returnValue = null ; }
			if($params['port_handling'] == ''){ $returnValue = null ; }
			if($params['sampling_cost'] == ''){ $returnValue = null ; }
			if($params['plot_rent'] == ''){ $returnValue = null ; }
			if($params['other_cost'] == ''){ $returnValue = null ; }

			if(strlen($params['trans_cost']) > '7'){ $returnValue = null ; }
			if(strlen($params['trans_remark']) > '250'){ $returnValue = null ; }
			if(strlen($params['loading_charges']) > '7'){ $returnValue = null ; }
			if(strlen($params['railway_freight']) > '8'){ $returnValue = null ; }
			if(strlen($params['railway_remark']) > '250'){ $returnValue = null ; }
			if(strlen($params['port_handling']) > '7'){ $returnValue = null ; }
			if(strlen($params['port_remark']) > '250'){ $returnValue = null ; }
			if(strlen($params['sampling_cost']) > '7'){ $returnValue = null ; }
			if(strlen($params['plot_rent']) > '7'){ $returnValue = null ; }
			if(strlen($params['other_cost']) > '7'){ $returnValue = null ; }
			if(strlen($params['other_remark']) > '250'){ $returnValue = null ; }
			if(strlen($params['total_prod']) > '9'){ $returnValue = null ; }
			
			if($params['trans_remark'] == '' && $params['trans_cost'] > 0) {
				$returnValue = null ;
				$returnData['msg'][] = 'Indicate Loading station and Distance from mine in remarks of <b>(a) Cost of transportation</b>!';
			}
			
			if($params['railway_remark'] == '' && $params['railway_freight'] > 0) {
				$returnValue = null ;
				$returnData['msg'][] = 'Indicate destination and distance in remarks of <b>(c) Railway freight</b>!';
			}
			
			if($params['port_remark'] == '' && $params['port_handling'] > 0) {
				$returnValue = null ;
				$returnData['msg'][] = 'Indicate name of port in remarks of <b>(d) Port Handling charges/export duty</b>!';
			}
			
			if($params['other_remark'] == '' && $params['other_cost'] > 0) {
				$returnValue = null ;
				$returnData['msg'][] = 'Specify remarks in <b>(g) Other charges</b>!';
			}
			
			$enteredTotal = $params['total_prod'];
			$prodTotal = $params['trans_cost'] + $params['loading_charges'] + $params['railway_freight'] + $params['port_handling'] + $params['sampling_cost'] + $params['plot_rent'] + $params['other_cost'];
			
			if ($enteredTotal != $prodTotal) {
				$returnValue = null ;
				$returnData['msg'][] = 'Entered value is not equal to the calculated total.';
			}
			
			if($returnValue == null & !isset($returnData['msg'])){ $returnData['msg'][] = "Failed to update <b>Details of Deductions</b>! Please, try again later."; }
			$returnData['err'] = $returnValue;
			return $returnData;
			
		}

	    /**
	     * Returns the previous month closing stocks for ROM 
	     * @param type $prevMonthDate
	     * @param type $mineCode
	     * @param type $returnType
	     * @param type $mineralName
	     * @param type $ironSubMin - have to change the db to fetch the respective sub-mineral(right now its filtered only till mineralname)
	     * @return type 
	     */
	    public function getRomPrevClosingStocks($prevMonthDate, $mineCode, $returnType, $mineralName, $ironSubMin) {
	//    $prevMonthDate = "2011-06-01";

	        $query = $this->find('all')
	                ->select(['clos_oc_rom', 'clos_ug_rom', 'clos_dw_rom'])
	                ->where(["mine_code"=>$mineCode, "return_type"=>$returnType, "return_date"=>$prevMonthDate, "mineral_name"=>$mineralName])
	                ->toArray();

	        $closing_stock = array();
	        if (count($query) > 0) {
	            $closing_stock['oc'] = $query[0]['clos_oc_rom'];
	            $closing_stock['ug'] = $query[0]['clos_ug_rom'];
	            $closing_stock['dw'] = $query[0]['clos_dw_rom'];
	        }

	        return $closing_stock;
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
	    public function isFilled($mineCode, $returnDate, $returnType, $minerals = array()) {

	        $min = array();
	        $dirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
	        $rom5 = TableRegistry::getTableLocator()->get('Rom5');
	        $romStone = TableRegistry::getTableLocator()->get('RomStone');

	        foreach ($minerals as $m) {

	            $formNo = $dirMcpMineral->getFormNumber($m);

	            if ($formNo == 5) {
	                $is_filled = $rom5->isFilledRom($mineCode, $returnDate, $returnType, $m);
	                if ($is_filled == true)
	                    $min[] = $m;
	            } else if ($formNo == 7) {
	                $is_filled = $romStone->isFilled($mineCode, $returnDate, $returnType);
	                if ($is_filled == true)
	                    $min[] = $m;
	            } else if ($formNo != 6) {
	                //since F-6 doesnt have ROM part do nothing
	                $rom = $this->find('all')
	                        ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate])
	                        ->toArray();

	                if (count($rom) == 0){
	                    $min[] = $m;
					}

	                foreach ($rom as $r) {
	                    $min_name = $r['mineral_name'];
	                    $formNo = $dirMcpMineral->getFormNumber($min_name);
	                    //since for deduction details we have to make an entry in PROD_1 table, we have to put this check
	                    if ($formNo == 1 || $formNo == 2 || $formNo == 3 || $formNo == 4 || $formNo == 8) {
	                        if ($min_name == 'iron_ore') {
	                            if ($r['open_oc_rom'] == "" || $r['open_dw_rom'] == "") {
	                                if ($r['hematite'] == 1)
	                                    $min[] = "hematite";
	                                else if ($r['magnetite'] == 1)
	                                    $min[] = "magnetite";
	                                else
	                                    $min[] = $min_name;
	                            }
	                        }else {
	                            if ($r['open_oc_rom'] == "" || $r['open_ug_rom'] = "" || $r['open_dw_rom'] = "") {
	                                $min[] = $min_name;
	                            }
	                        }
	                    }
	                }
	            }
	        }

	        if (count($min) > 0)
	            return $min;
	        else
	            return 0;
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
	    public function isDeductionFilled($mineCode, $returnDate, $returnType, $isHematite = '', $isMagnetite = '') {

        	$mineralWorked = TableRegistry::getTableLocator()->get('MineralWorked');

	        $minerals = $mineralWorked->find('all')
	                ->select(['mineral_name'])
	                ->where(["mine_code"=>$mineCode, 'mineral_name IS NOT'=>'MICA'])
	                ->toArray();

	        $min = array();
	        $iron_count = 0;

	        foreach ($minerals as $m) {
	            $query = $this->find('all')
	                    ->where(["mine_code"=>$mineCode,"return_date"=>$returnDate,"return_type"=>$returnType,"mineral_name"=>strtolower(str_replace(' ', '_', $m['mineral_name']))])
	                    ->toArray();

	            if (count($query) == 0)
	                $min[] = strtolower($m['mineral_name']);

	            foreach ($query as $s) {

	                if ($s['loading_charges'] == "" || $s['railway_freight'] == "" || $s['port_handling'] == "" ||
	                        $s['trans_cost'] == "" || $s['sampling_cost'] == "" || $s['plot_rent'] == "" || $s['other_cost'] == "") {

	                    if ($s['mineral_name'] == "iron_ore") {
	                        if ($s['hematite'] == "1") {
	                            $iron_count++;
	                        }

	                        if ($s['magnetite'] == "1") {
	                            $iron_count++;
	                        }
	                    } else {
	                        if (!in_array($s['mineral_name'], $min))
	                            $min[] = $s['mineral_name'];
	                    }
	                }
	            }
	        }

	        if ($iron_count == 2)
	            $min[] = 'iron_ore';

	        if (count($min) > 0)
	            return $min;
	        else
	            return 0;
	    }

		
	    /**
	     * Used to check for the final submit
	     * Returns 0 if the form is not filled
	     * Returns 1 if the form is filled
		 * @version 20th Nov 2021
		 * @author Aniket Ganvir
	     */
	    public function isDeductionFilledByMineral($mineCode, $returnDate, $returnType, $mineral, $ironSubMin = '') {

			$mineral = strtolower(str_replace(' ', '_', $mineral));
			
			if ($ironSubMin == '') {
				$query = $this->find('all')
					->where(["mine_code"=>$mineCode,"return_date"=>$returnDate,"return_type"=>$returnType,"mineral_name"=>$mineral])
					->limit(1)
					->toArray();
			} else {
				$query = $this->find('all')
					->where(["mine_code"=>$mineCode,"return_date"=>$returnDate,"return_type"=>$returnType,"mineral_name"=>$mineral,$ironSubMin=>1])
					->limit(1)
					->toArray();
			}

			if (count($query) > 0) {
				$data = $query[0];
				if ($data['loading_charges'] == "" || $data['railway_freight'] == "" || $data['port_handling'] == "" ||
						$data['trans_cost'] == "" || $data['sampling_cost'] == "" || $data['plot_rent'] == "" || $data['other_cost'] == "") {
					$result = 0;
				} else {
					$result = 1;
				}
			} else {
				$result = 0;
			}
			
			return $result;
			
	    }


	    /**
	     * returns the rom details for viewing of IBM Users
	     * @param type $mineCode
	     * @param type $returnType
	     * @param type $returnDate
	     * @param type $subMineral
	     * @return type 
	     */
	    public function getRomDetails($mineCode, $returnType, $returnDate, $mineral, $subMineral = '') {

			if ($subMineral == 1){
	        	$query = $this->find('all')
		                ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineral,"hematite"=>"1"])
		                ->toArray();
			} elseif ($subMineral == 2){
	        	$query = $this->find('all')
		                ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineral,"magnetite"=>"1"])
		                ->toArray();
			} else {
	        	$query = $this->find('all')
		                ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineral])
		                ->toArray();
			}

	        $data = array();
	        if (count($query) > 0) {
	            $data['oc']['open_oc_rom'] = $query[0]['open_oc_rom'];
	            $data['oc']['prod_oc_rom'] = $query[0]['prod_oc_rom'];
	            $data['oc']['clos_oc_rom'] = $query[0]['clos_oc_rom'];
	            $data['ug']['open_ug_rom'] = $query[0]['open_ug_rom'];
	            $data['ug']['prod_ug_rom'] = $query[0]['prod_ug_rom'];
	            $data['ug']['clos_ug_rom'] = $query[0]['clos_ug_rom'];
	            $data['dw']['open_dw_rom'] = $query[0]['open_dw_rom'];
	            $data['dw']['prod_dw_rom'] = $query[0]['prod_dw_rom'];
	            $data['dw']['clos_dw_rom'] = $query[0]['clos_dw_rom'];

	            $data['mineral_name'] = $query[0]['mineral_name'];
	        }

	        return $data;
	    }

		        /**
	     * returns the deduction details for viewing of IBM Users
	     * @param type $mineCode
	     * @param type $returnType
	     * @param type $returnDate
	     * @return type 
	     */
	    public function getDeductionDetails($mineCode, $returnType, $returnDate, $mineral, $subMineral = '') {

	        //print_r();die;

	        if ($subMineral == 1){
		        $query = $this->find('all')
		                ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineral,"hematite"=>"1"])
		                ->toArray();
	        } else if($subMineral == 2){
		        $query = $this->find('all')
		                ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineral,"magnetite"=>"1"])
		                ->toArray();
	        } else {
		        $query = $this->find('all')
		                ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineral])
		                ->toArray();
	        }


	        // if ($subMineral == 1)
	        //     $query->andWhere("hematite = ?", 1);
	        // elseif ($subMineral == 2)
	        //     $query->andWhere("magnetite = ?", 1);
	        // $query = $query->fetchArray();

	//    print_r($query);die;

	        $data = array();
	        if (count($query) > 0) {
	            $data['trans']['cost'] = $query[0]['trans_cost'];
	            $data['trans']['remark'] = $query[0]['trans_remark'];
	            $data['loading']['cost'] = $query[0]['loading_charges'];
	            $data['loading']['remark'] = $query[0]['loading_remark'];
	            $data['railway']['cost'] = $query[0]['railway_freight'];
	            $data['railway']['remark'] = $query[0]['railway_remark'];
	            $data['port']['cost'] = $query[0]['port_handling'];
	            $data['port']['remark'] = $query[0]['port_remark'];
	            $data['sampling']['cost'] = $query[0]['sampling_cost'];
	            $data['sampling']['remark'] = $query[0]['sampling_remark'];
	            $data['plot']['cost'] = $query[0]['plot_rent'];
	            $data['plot']['remark'] = $query[0]['plot_remark'];
	            $data['other']['cost'] = $query[0]['other_cost'];
	            $data['other']['remark'] = $query[0]['other_remark'];
	            $data['totalProd'] = $query[0]['total_prod'];
	        }
	        //print_r($data);die;
	        return $data;
	    }

		// save or update form data
	    public function updateOreType($forms_data){

			// $dataValidatation = $this->postDataValidationOreType($forms_data);
			$dataValidatation = 1;

			if($dataValidatation == 1 ){

	            $f_hematite = $forms_data['f_hematite'];
	            $f_magnetite = $forms_data['f_magnetite'];

	        	$mine_code = $forms_data['mine_code'];
	        	$return_type = $forms_data['return_type'];
	        	$return_date = $forms_data['return_date'];
	        	$mineralName = $forms_data['mineral_name'];
	        	$mineralName = str_replace(' ','_',$mineralName);
	        	$ironSubMin = $forms_data['iron_sub_min'];

	        	$date = date('Y-m-d H:i:s');

        		$ironSubMinStr = "&iron_sub_min=hematite";

	        	if($f_hematite == 0 && $f_magnetite == 0){

            		// Doctrine_Core::getTable('PROD_1')->deleteOtherOreType($this->mineCode, $this->returnType, $this->returnDate, $this->minaral, 'blank');

	        		$query = $this->query();
	        		$query->delete()
	        			->where(['mine_code'=>$mine_code, 'return_type'=>$return_type, 'return_date'=>$return_date, 'mineral_name'=>$mineralName])
	        			->execute();

	        	} else if($f_hematite == 1 && $f_magnetite == 1){

            		// Doctrine_Core::getTable('PROD_1')->updateBothOreTypes($this->mineCode, $this->returnType, $this->returnDate, $this->minaral);

			        $f_hematite_prev = $this->find('all')
			                ->where(['mine_code'=>$mine_code, 'return_type'=>$return_type, 'return_date'=>$return_date, 'mineral_name'=>$mineralName, 'hematite'=>'1'])
			                ->toArray();

					if(count($f_hematite_prev) > 0){

						$query = $this->query();
						$query->update()
							->set(['magnetite'=>NULL, 'updated_at'=>$date])
		                	->where(['mine_code'=>$mine_code, 'return_type'=>$return_type, 'return_date'=>$return_date, 'mineral_name'=>$mineralName, 'hematite'=>'1'])
		                	->execute();

					} else {

						$query = $this->query();
						$query->insert(['mine_code', 'return_type', 'return_date', 'mineral_name', 'hematite', 'created_at', 'updated_at'])
							->values([
								'mine_code'=>$mine_code,
								'return_type'=>$return_type,
								'return_date'=>$return_date,
								'mineral_name'=>$mineralName,
								'hematite'=>'1',
								'created_at'=>$date,
								'updated_at'=>$date
							])
							->execute();

					}

			        $f_magnetite_prev = $this->find('all')
			                ->where(['mine_code'=>$mine_code, 'return_type'=>$return_type, 'return_date'=>$return_date, 'mineral_name'=>$mineralName, 'magnetite'=>'1'])
			                ->toArray();

					if(count($f_magnetite_prev) > 0){

						$query = $this->query();
						$query->update()
							->set(['hematite'=>NULL, 'updated_at'=>$date])
		                	->where(['mine_code'=>$mine_code, 'return_type'=>$return_type, 'return_date'=>$return_date, 'mineral_name'=>$mineralName, 'magnetite'=>'1'])
		                	->execute();

					} else {

						$query = $this->query();
						$query->insert(['mine_code', 'return_type', 'return_date', 'mineral_name', 'magnetite', 'created_at', 'updated_at'])
							->values([
								'mine_code'=>$mine_code,
								'return_type'=>$return_type,
								'return_date'=>$return_date,
								'mineral_name'=>$mineralName,
								'magnetite'=>'1',
								'created_at'=>$date,
								'updated_at'=>$date
							])
							->execute();

					}
					

	        	} else if($f_hematite == 1 && $f_magnetite == 0){

	        		$query = $this->query();
	        		$query->delete()
	        			->where(['mine_code'=>$mine_code, 'return_type'=>$return_type, 'return_date'=>$return_date, 'mineral_name'=>$mineralName, 'hematite IS'=>null])
	        			->execute();

			        $f_hematite_prev = $this->find('all')
			                ->where(['mine_code'=>$mine_code, 'return_type'=>$return_type, 'return_date'=>$return_date, 'mineral_name'=>$mineralName, 'hematite'=>'1'])
			                ->toArray();

					if(count($f_hematite_prev) > 0){

						$query = $this->query();
						$query->update()
							->set(['magnetite'=>NULL, 'updated_at'=>$date])
		                	->where(['mine_code'=>$mine_code, 'return_type'=>$return_type, 'return_date'=>$return_date, 'mineral_name'=>$mineralName, 'hematite'=>'1'])
		                	->execute();

					} else {

						$query = $this->query();
						$query->insert(['mine_code', 'return_type', 'return_date', 'mineral_name', 'hematite', 'created_at', 'updated_at'])
							->values([
								'mine_code'=>$mine_code,
								'return_type'=>$return_type,
								'return_date'=>$return_date,
								'mineral_name'=>$mineralName,
								'hematite'=>'1',
								'created_at'=>$date,
								'updated_at'=>$date
							])
							->execute();

					}

	        	} else if($f_hematite == 0 && $f_magnetite == 1){

	        		$query = $this->query();
	        		$query->delete()
	        			->where(['mine_code'=>$mine_code, 'return_type'=>$return_type, 'return_date'=>$return_date, 'mineral_name'=>$mineralName, 'magnetite IS'=>null])
	        			->execute();
	        			
			        $f_magnetite_prev = $this->find('all')
			                ->where(['mine_code'=>$mine_code, 'return_type'=>$return_type, 'return_date'=>$return_date, 'mineral_name'=>$mineralName, 'magnetite'=>'1'])
			                ->toArray();

					if(count($f_magnetite_prev) > 0){

						$query = $this->query();
						$query->update()
							->set(['hematite'=>NULL, 'updated_at'=>$date])
		                	->where(['mine_code'=>$mine_code, 'return_type'=>$return_type, 'return_date'=>$return_date, 'mineral_name'=>$mineralName, 'magnetite'=>'1'])
		                	->execute();

					} else {

						$query = $this->query();
						$query->insert(['mine_code', 'return_type', 'return_date', 'mineral_name', 'magnetite', 'created_at', 'updated_at'])
							->values([
								'mine_code'=>$mine_code,
								'return_type'=>$return_type,
								'return_date'=>$return_date,
								'mineral_name'=>$mineralName,
								'magnetite'=>'1',
								'created_at'=>$date,
								'updated_at'=>$date
							])
							->execute();

					}

	        	}

				if($query){
					$result = 1;
				} else {
					$result = false;
				}
			} else {
				$result = false;
			}

			return $result;

	    }
		/**
		 * Returns the ore type for iron ore for viewing returns of IBM User
		 * @param type $mineCode
		 * @param type $returnType
		 * @param type $returnDate
		 * @return string 
		 */
		public function getOreType($mineCode, $returnType, $returnDate) {

			$query = $this->find()
					->select(['hematite', 'magnetite'])
					->where(["mine_code"=>$mineCode])
					->where(["return_type"=>$returnType])
					->where(["return_date"=>$returnDate])
					->toArray();

			$ore_type = array();
			if (count($query) > 0) {
				foreach ($query as $q) {
					if ($q['hematite'] == 1)
						$ore_type[] = "Hematite";

					if ($q['magnetite'] == 1)
						$ore_type[] = "Magnetite";
				}
			}

			$ores = implode(', ', $ore_type);

			return $ores;
		}
		
		//----function for PrintAll by Pranav Sanvatsarkar-------

		public function printRomDetails($mineCode, $returnType, $returnDate, $mineral, $subMineral = '') {

			$mineral_name = strtolower(str_replace(' ', '_', $mineral));

			$query = $this->find()
					->where(['mine_code'=>$mineCode])
					->where(['return_type'=>$returnType])
					->where(['return_date'=>$returnDate])
					->where(['mineral_name'=>$mineral_name]);

			if ($subMineral == 1)
				$query->where(['hematite'=>1]);
			elseif ($subMineral == 2)
				$query->where(['magnetite'=>1]);

			$query = $query->toArray();

			$data = array();
			if (count($query) > 0) {
				$data['OPEN_OC_ROM'] = $query[0]['open_oc_rom'];
				$data['PROD_OC_ROM'] = $query[0]['prod_oc_rom'];
				$data['CLOS_OC_ROM'] = $query[0]['clos_oc_rom'];
				$data['OPEN_UG_ROM'] = $query[0]['open_ug_rom'];
				$data['PROD_UG_ROM'] = $query[0]['prod_ug_rom'];
				$data['CLOS_UG_ROM'] = $query[0]['clos_ug_rom'];
				$data['OPEN_DW_ROM'] = $query[0]['open_dw_rom'];
				$data['PROD_DW_ROM'] = $query[0]['prod_dw_rom'];
				$data['CLOS_DW_ROM'] = $query[0]['clos_dw_rom'];
				$data['MINERAL_NAME'] = strtoupper(str_replace('_', ' ', $query[0]['mineral_name']));

				if ($query[0]['hematite'] == 1)
					$data['SUB_MIN'] = 'HEMATITE';
				if ($query[0]['magnetite'] == 1)
					$data['SUB_MIN'] = 'MAGNETITE';
			}

			return $data;
		}

		/**
		 * Check filled status of section
		 * @version 30th Oct 2021
		 * @author Aniket Ganvir
		 */
	    public function isFilledOreType($mineCode, $returnType, $returnDate, $mineralName, $ironSubMin = '') {

			$mineralName = str_replace(' ', '_', $mineralName);

	        if ($ironSubMin != '') {

	            $records = $this->find('all')
					->where(["mine_code"=>$mineCode])
					->where(["return_type"=>$returnType])
					->where(["return_date"=>$returnDate])
					->where(["mineral_name"=>$mineralName])
					->where([$ironSubMin=>'1'])
					->where(['open_oc_rom IS NOT NULL'])
					->where(['prod_oc_rom IS NOT NULL'])
					->where(['clos_oc_rom IS NOT NULL'])
					->where(['open_ug_rom IS NOT NULL'])
					->where(['prod_ug_rom IS NOT NULL'])
					->where(['clos_ug_rom IS NOT NULL'])
					->where(['open_dw_rom IS NOT NULL'])
					->where(['prod_dw_rom IS NOT NULL'])
					->where(['clos_dw_rom IS NOT NULL'])
					->count();

	        } else {
	            $records = $this->find('all')
					->where(["mine_code"=>$mineCode])
					->where(["return_type"=>$returnType])
					->where(["return_date"=>$returnDate])
					->where(["mineral_name"=>$mineralName])
					->where(['open_oc_rom IS NOT NULL'])
					->where(['prod_oc_rom IS NOT NULL'])
					->where(['clos_oc_rom IS NOT NULL'])
					->where(['open_ug_rom IS NOT NULL'])
					->where(['prod_ug_rom IS NOT NULL'])
					->where(['clos_ug_rom IS NOT NULL'])
					->where(['open_dw_rom IS NOT NULL'])
					->where(['prod_dw_rom IS NOT NULL'])
					->where(['clos_dw_rom IS NOT NULL'])
					->count();

			}

			if ($records > 0) {
				return true;
			} else {
				return false;
			}

		}

		public function getRomProductionTotal($mineCode, $returnType, $returnDate, $mineralName) {

			$query = $this->find()
				->select(['prod_oc_rom', 'prod_ug_rom', 'prod_dw_rom'])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>$returnType])
				->where(['return_date'=>$returnDate])
				->where(['mineral_name'=>$mineralName])
				->toArray();
			$total = 0;
			foreach ($query as $data) {
				$total = $total + $data['prod_oc_rom'];
				$total = $total + $data['prod_ug_rom'];
				$total = $total + $data['prod_dw_rom'];
			}
			return $total;

		}

		/**
		 * CREATED THE FUNCTION FOR GETTING THE IRON ORE TYPE SELECTED BY THE USER
		 * THIS IS THE ONLY FEASIBLE WAY RIGHT NOW
		 * CALLED FROM GRADE_PRODTable function removeTableExtraRowsForIronOre()
		 * 
		 * @author Uday Shankar Singh
		 * @version 10th June 2014
		 * 
		 * @param String $mineCode
		 * @param String $returnType
		 * @param String $returnDate
		 * @return ARRAY OF IRON ORE MINERAL 
		 */
		public function getIronOreSelected($mineCode, $returnType, $returnDate) {

			$query1 = $this->find()
				->select(['hematite', 'magnetite'])
				->where(['mine_code'=>$mineCode])
				->where(["return_type"=>$returnType])
				->where(['return_date'=>$returnDate])
				->where(["mineral_name"=>'iron_ore'])
				->toArray();

			$checkResult = Array();
			if (count($query1) > 0) {
				foreach ($query1 as $data) {
					if ($data['hematite'] == 1)
						$checkResult[0] = 'HEMATITE';
					if ($data['magnetite'] == 1)
						$checkResult[1] = 'MAGNETITE';
				}
			}

			return $checkResult;

		}

	} 
?>