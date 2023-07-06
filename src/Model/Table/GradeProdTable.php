<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use App\Controller\MonthlyController;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
    use Cake\Datasource\ConnectionManager;
	
	class GradeProdTable extends Table{

		var $name = "GradeProd";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		//chk record is exists or not
		public function chkGradeWiseProd($mineCode, $returnType, $returnDate, $mineralName, $gradeCode, $ironSubMin) {
			$query = $this->find('all')
			        ->select(['mine_code','return_type','return_date','mineral_name', 'grade_code'])
			        ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,"grade_code"=>$gradeCode,"iron_type IS"=>$ironSubMin])
			        ->toArray();

			if ($query) {
			  return true;
			} else {
			  return false;
			}
		}

		//fetch array by mine code, return type, return date and mineral name 
		public function fetchGradeWiseProd($mineCode, $returnType, $returnDate, $mineralName, $gradeCode, $ironSubMin=null, $type=null) {
			$MonthlyController = new MonthlyController;
			$mineralName = str_replace(' ','_', $mineralName);

			if($gradeCode != ''){
				if($ironSubMin == null){
			    	$result = $this->find('all')
							->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,"grade_code"=>$gradeCode,"type IS">$type])
							->toArray();
				} else {
			    	$result = $this->find('all')
							->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,"grade_code"=>$gradeCode,"iron_type"=>$ironSubMin,"type IS">$type])
							->toArray();
				}
			} else {
				if($ironSubMin == null){
					$result = $this->find('all')
							->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,"type IS">$type])
							->toArray();
				} else {
					$result = $this->find('all')
							->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,"iron_type"=>$ironSubMin,"type IS">$type])
							->toArray();
				}
			}

		    if (count($result) > 0){
				foreach($result as $key => $value){
					$data = $result[$key];
				}
		    } else {
				$data = $MonthlyController->Customfunctions->getTableColumns('grade_prod');
		    }

		    return $data;
		}


		//fetch array by parent id 
		public function findOneById($openGradeId) {
		    $result = $this->find('all')
		            ->where(["id"=>$openGradeId])
		            ->toArray();

		    if (count($result) > 0)
		        return $result[0];
		    else
		        return array();
		}


		// save or update form data
	    public function saveFormDetails($forms_data){

			$dataValidatation = $this->postDataValidation($forms_data);
			$returnData = array();
			
			if($dataValidatation['err'] == 1 ){

	            $formId = $forms_data['form_no'];
	            $formNo = $forms_data['form_no'];
	            $mineCode = $forms_data['mine_code'];
	        	$return_type = $forms_data['return_type'];
	        	$return_date = $forms_data['return_date'];
	        	$mineral_name = $forms_data['mineral_name'];
	        	$iron_sub_min = $forms_data['iron_sub_min'];
				$iron_type = ($iron_sub_min != '') ? $iron_sub_min : '-';
				$min_und_low = strtolower(str_replace(' ','_',$mineral_name));

				if (in_array($min_und_low, array('iron_ore', 'chromite'))) {
					
					$grade_code_rom = $forms_data['grade_code_rom'];

					$average_grade = array();
					$despatches_rom = $forms_data['despatches_rom'];	        	
					$pmv_rom = $forms_data['pmv_rom'];
	
					$gcode_count_rom = count($grade_code_rom);
	
					$returnVal = false;
					for($i=0; $i<$gcode_count_rom; $i++){
						
						$rowData = $this->fetchGradeWiseProd($mineCode, $return_type, $return_date, $mineral_name, $grade_code_rom[$i], $iron_type, 'ROM');
						
						if($rowData['id']!=""){
							$row_id = $rowData['id'];
							$created_at = $rowData['created_at'];
						} else {
							$row_id = '';
							$created_at = date('Y-m-d H:i:s');
						}
	
						if($formId != '3'){
							$average_grade[$i] = null;
						}
						
						$opening_stock_rom[$i] = null;
						$production_rom[$i] = null;
						$closing_stock_rom[$i] = null;
	
						$newEntity = $this->newEntity(array(
							'id'=>$row_id,
							'mine_code'=>$mineCode,
							'return_type'=>$return_type,
							'return_date'=>$return_date,
							'mineral_name'=>str_replace(' ','_',$mineral_name),
							'grade_code'=>$grade_code_rom[$i],
							'iron_type'=>$iron_type,
							'type'=>'ROM',
							'opening_stock'=>$opening_stock_rom[$i],
							'production'=>$production_rom[$i],
							'despatches'=>$despatches_rom[$i],
							'closing_stock'=>$closing_stock_rom[$i],
							'pmv'=>$pmv_rom[$i],
							'average_grade'=>$average_grade[$i],
							'created_at'=>$created_at,
							'updated_at'=>date('Y-m-d H:i:s')
						));
	
						if($this->save($newEntity)){
							$returnVal = 1;
						} else {
							$returnVal = false;
							$returnData['msg'][] = "Failed to update <b>Grade-Wise Production</b>! Please, try again later.";
						}
	
					}

				}

	        	$grade_code = $forms_data['grade_code'];

	        	if($formId == '3'){
	        		$average_grade = $forms_data['average_grade'];
	        	} else {
	        		$average_grade = array();
	        	}

				//if(!in_array($formNo,array(1,4))){
						
					$opening_stock = $forms_data['opening_stock'];
					$production = $forms_data['production'];
					$closing_stock = $forms_data['closing_stock'];		
				//}
	        		        	
	        	$despatches = $forms_data['despatches'];	        	
	        	$pmv = $forms_data['pmv'];

	        	$gcode_count = count($grade_code);

	        	$returnVal = false;
	        	for($i=0; $i<$gcode_count; $i++){
					
					if($iron_sub_min != ''){
						$rowData = $this->fetchGradeWiseProd($mineCode, $return_type, $return_date, $mineral_name, $grade_code[$i], $iron_type);
					} else {
						$rowData = $this->fetchGradeWiseProd($mineCode, $return_type, $return_date, $mineral_name, $grade_code[$i]);
					}
		        	
		        	if($rowData['id']!=""){
		        		$row_id = $rowData['id'];
		        		$created_at = $rowData['created_at'];
		        	} else {
		        		$row_id = '';
		        		$created_at = date('Y-m-d H:i:s');
		        	}

		        	if($formId != '3'){
		        		$average_grade[$i] = null;
		        	}
					
					/*if(in_array($formNo,array(1,4))){
						
						$opening_stock[$i] = null;
						$production[$i] = null;
						$closing_stock[$i] = null;						
					}*/

					$newEntity = $this->newEntity(array(
						'id'=>$row_id,
						'mine_code'=>$mineCode,
						'return_type'=>$return_type,
						'return_date'=>$return_date,
						'mineral_name'=>str_replace(' ','_',$mineral_name),
						'grade_code'=>$grade_code[$i],
						'iron_type'=>$iron_type,
						'opening_stock'=>$opening_stock[$i],
						'production'=>$production[$i],
						'despatches'=>$despatches[$i],
						'closing_stock'=>$closing_stock[$i],
						'pmv'=>$pmv[$i],
						'average_grade'=>$average_grade[$i],
						'created_at'=>$created_at,
						'updated_at'=>date('Y-m-d H:i:s')
					));

					if($this->save($newEntity)){
						$returnVal = 1;
					} else {
						$returnVal = false;
						$returnData['msg'][] = "Failed to update <b>Grade-Wise Production</b>! Please, try again later.";
					}

	        	}

        	} else {
				$returnVal = false;
				$returnData['msg'] = $dataValidatation['msg'];
			}

			if($returnVal == 1){ $returnData['msg'][] = "<b>Grade-Wise Production</b> successfully saved !"; }

			$returnData['err'] = $returnVal;
			return $returnData;

	    }

	    public function postDataValidation($forms_data){
						
			$returnValue = 1;
			$returnData = array();
			
			$form_no = $forms_data['form_no'];			
        	$grade_code = $forms_data['grade_code'];
			
			// if(!in_array($form_no,array(1,4))){
			if(!in_array($form_no,array(4))){ // removed form no 1 because now Iron Ore have non-Rom grade-wise section, added on 31-08-2022
				$opening_stock = $forms_data['opening_stock'];
				$production = $forms_data['production'];
				$closing_stock = $forms_data['closing_stock'];
			}
        	
        	$despatches = $forms_data['despatches'];        	
        	$pmv = $forms_data['pmv'];

        	$gcode_count = count($grade_code);

        	for($i=0; $i<$gcode_count; $i++){
				
				// if(!in_array($form_no,array(1,4))){
				if(!in_array($form_no,array(4))){ // removed form no 1 because now Iron Ore have non-Rom grade-wise section, added on 31-08-2022
					
					if($opening_stock[$i] == ''){ $returnValue = null ; }
					if($production[$i] == ''){ $returnValue = null ; }
					if($closing_stock[$i] == ''){ $returnValue = null ; }
					
					if(!is_numeric($opening_stock[$i]) && !is_float($opening_stock[$i])){ $returnValue = null ; }
					if(!is_numeric($production[$i]) && !is_float($production[$i])){ $returnValue = null ; }
					if(!is_numeric($closing_stock[$i]) && !is_float($closing_stock[$i])){ $returnValue = null ; }
				
					$totalOpnStock = round(($opening_stock[$i] + $production[$i]) - $despatches[$i], 3); 
					if($totalOpnStock != $closing_stock[$i]){
						$returnValue = null ;
						$returnData['msg'][] = 'Closing stock must be same as <br><b>(Opening Stock + Production) - Despatches</b> !';
					}

				}
        		
        		if($despatches[$i] == ''){ $returnValue = null ; }				
				if($pmv[$i] == ''){ $returnValue = null ; }
				
        		if(!is_numeric($despatches[$i]) && !is_float($despatches[$i])){ $returnValue = null ; }        		
        		if(!is_numeric($pmv[$i]) && !is_float($pmv[$i])){ $returnValue = null ; }
        	}
			
			if($returnValue == null && !isset($returnData['msg'])){ $returnData['msg'][] = "Failed to update <b>Grade-Wise Production</b>! Please, try again later."; }
			$returnData['err'] = $returnValue;

			return $returnData;
			
		}


		/**
		 * Gradewise production for all the forms are checked here
		 * Used to check for the final submit
		 * Returns 1 if the form is not filled
		 * Returns 0 if the form is filled
		 * @param type $mineCode
		 * @param type $returnDate
		 * @param type $returnType
		 * @return int 
		 */
		public function isFilled($mineCode, $returnDate, $returnType, $isHematite = '', $isMagnetite = '') {

			$mineralWorked = TableRegistry::getTableLocator()->get('MineralWorked');
			$dirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
			$prodMica = TableRegistry::getTableLocator()->get('ProdMica');
			$prodStone = TableRegistry::getTableLocator()->get('ProdStone');
			$prod1 = TableRegistry::getTableLocator()->get('Prod1');

			$minerals = $mineralWorked->find('all')
					->select(['mineral_name'])
					->where(["mine_code"=>$mineCode,'mineral_name IS NOT'=>'MICA'])
					->toArray();

			$min = array();
			$hem = false;
			$mag = false;

			foreach ($minerals as $m) {

				$mineral_name = strtoupper(str_replace('_', ' ', $m['mineral_name']));
				$formNo = $dirMcpMineral->getFormNumber($mineral_name);

				if ($formNo == 5) {
					//do nothing
				} elseif ($formNo == 6) {
					$is_filled = $prodMica->isFilled($mineCode, $returnDate, $returnType);
					if ($is_filled == true)
					$min[] = "mica";
				} else if ($formNo == 7) {
					$is_filled = $prodStone->isFilled($mineCode, $returnDate, $returnType);
					if ($is_filled == true)
					$min[] = strtolower($m['mineral_name']);
				} else {

					/* changed by saranya on 14/6/2016 ********************* */
					/* checking the entry for the mineral in the prod_1 table ---- if the selection is 1 or 0 * */
					if ($mineral_name == 'IRON ORE') {
						$querycheck = $prod1->find('all')
								->select(['hematite','magnetite'])
								->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate])
								->toArray();
						
						$hematiteval = '';
						$magnetiteval = '';
						foreach ($querycheck as $value) {
							if ($value['hematite'] == 1)
								$hematiteval = 1;
							if ($value['magnetite'] == 1)
								$magnetiteval = 1;
						}
					}

					$query = $this->find('all')
							->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>strtolower(str_replace(' ', '_', $m['mineral_name']))])
							// ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>strtolower(str_replace('_', ' ', $m['mineral_name']))])
							->toArray();

					if (count($query) == 0){
						$min[] = strtolower($m['mineral_name']);
					}
					//on hold
					return $min;

					foreach ($query as $s) {

						if ($s['iron_type'] == 'hematite')
							$hem = true;

						if ($s['iron_type'] == 'magnetite')
							$mag = true;

						if ($s['opening_stock'] == "" || $s['production'] == "" || $s['despatches'] == "" || $s['closing_stock'] == "" || $s['pmv'] == "") {

							if ($s['mineral_name'] == "iron_ore") {

								if ($s['iron_type'] == 'hematite' && $hematiteval == 1)
									if (!in_array('hematite', $min))
										$min[] = 'hematite';

								if ($s['iron_type'] == 'magnetite' && $magnetiteval == 1)
									if (!in_array('magnetite', $min))
										$min[] = 'magnetite';
							} else {
								$mineral_name = strtolower(str_replace('_', ' ', $m['mineral_name']));
								if (!in_array($mineral_name, $min))
									$min[] = $mineral_name;
							}
						}
					}
				}
			}

			//if the record for either one of the sub mineral for iron ore is not created
			//in the gradewise table, we have to show that mineral is also not filled
			if ($isHematite == 1 && $hem == false){
				if (!in_array('hematite', $min)){
					$min[] = 'hematite';
				}
			}

			if ($isMagnetite == 1 && $mag == false){
				if (!in_array('magnetite', $min)){
					$min[] = 'magnetite';
				}
			}


			if (count($min) > 0){
				return $min;
			} else {
				return 0;
			}
	 	 
		}


		public function getProductionDetails($mineCode, $returnType, $returnDate, $mineral, $sub_mineral=null, $pdfStatus = 0) {

            $conn = ConnectionManager::get(Configure::read('conn'));            

            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $sub_mineral = strtolower(str_replace(' ', '_', $sub_mineral));
            $query = array();
        
            if ($sub_mineral != "") {
				
                $query = $this->find('all')
                        ->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>$mineral,'iron_type'=>$sub_mineral,'type IS NULL'])
                        ->toArray();
           
                $iron_type_con = "AND iron_type = '".$sub_mineral."'"; 

            } else {
                $query = $this->find('all')
                        ->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>$mineral,'type IS NULL'])
                        ->toArray();

                $iron_type_con = "";                  
            }

			// Prefetch the monthly records data for annula returns.
			// Done by Pravin bhakare 01-10-2021
            if (  $returnType == "ANNUAL"  && $query == null && $pdfStatus == 0) {
                
				$starDate = (date('Y',strtotime($returnDate))).'-04-01';
            	$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';

                $str = "SELECT 
                g1.id,g1.mine_code, g1.return_type,g1.mineral_name,
                g1.grade_code,g1.iron_type,g1.reason_1,g1.reason_2,g1.average_grade,
                CASE	
                    WHEN g1.return_date = '$starDate' THEN g1.opening_stock    
                END as opening_stock,
                sum(production) as production,
                sum(despatches) as despatches,
                avg(pmv) as pmv,
                ( 
                    SELECT closing_stock from grade_prod
                    where mine_code = '$mineCode'
                    AND return_type = 'MONTHLY'
                    AND return_date BETWEEN '$starDate' AND '$endDate' 
                    AND mineral_name = '$mineral'
                    $iron_type_con                  
					AND type IS NULL
                    AND grade_code = g1.grade_code
                    ORDER BY `return_date`  DESC
                    LIMIT 1
                )  closing_stock
                
                FROM `grade_prod` g1
                where mine_code = '$mineCode'
                AND return_type = 'MONTHLY'
                AND return_date BETWEEN '$starDate' AND '$endDate'
                AND mineral_name = '$mineral'
                $iron_type_con
				AND type IS NULL
                GROUP by grade_code 
                ORDER BY `id`  DESC ";

                // print_r($str);   exit;
                $query = $conn->execute($str)->fetchAll('assoc');

            }
		  

			//   
			//     $returns = $con->execute("SELECT status FROM (SELECT * FROM TBL_FINAL_SUBMIT 
			//   	WHERE applicant_id = ? AND return_type = ? " . $where_clause . " ORDER BY created_at DESC) m 
			//     GROUP BY return_date, mine_code", array($app_id, $return_type))->fetchAll('assoc');

			$data = array();
			$i = 0;
			foreach ($query as $g) {
				$data[$g['grade_code']] = $query[$i];

				if ($query[$i]['reason_1'] != '')
				$data['reason_1'] = $query[$i]['reason_1'];
				if ($query[$i]['reason_2'] != '')
				$data['reason_2'] = $query[$i]['reason_2'];

				$i++;
			}

			if (count($query) > 0)
				return $data;
			else
				return array();
			
		}
		
		public function getProductionDetailsRom($mineCode, $returnType, $returnDate, $mineral, $sub_mineral=null, $pdfStatus = 0) {

            $conn = ConnectionManager::get(Configure::read('conn'));            

            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $sub_mineral = strtolower(str_replace(' ', '_', $sub_mineral));
            $query = array();
			
            if ($sub_mineral != "") {
				
                $query = $this->find('all')
                        ->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>$mineral,'iron_type'=>$sub_mineral,'type'=>'ROM'])
                        ->toArray();
           
                $iron_type_con = "AND iron_type = '".$sub_mineral."'"; 

            } else {
                $query = $this->find('all')
                        ->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>$mineral,'type'=>'ROM'])
                        ->toArray();

                $iron_type_con = "";                  
            }

			// Prefetch the monthly records data for annula returns.
			// Done by Pravin bhakare 01-10-2021
            if(  $returnType == "ANNUAL"  && $query == null && $pdfStatus == 0){
                
                
				$starDate = (date('Y',strtotime($returnDate))).'-04-01';
            	$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';

                $str = "SELECT 
                g1.id,g1.mine_code, g1.return_type,g1.mineral_name,
                g1.grade_code,g1.iron_type,g1.reason_1,g1.reason_2,g1.average_grade,
                CASE	
                    WHEN g1.return_date = '$starDate' THEN g1.opening_stock    
                END as opening_stock,
                sum(production) as production,
                sum(despatches) as despatches,
                avg(pmv) as pmv,
                ( 
                    SELECT closing_stock from grade_prod
                    where mine_code = '$mineCode'
                    AND return_type = 'MONTHLY'
                    AND return_date BETWEEN '$starDate' AND '$endDate' 
                    AND mineral_name = '$mineral'
                    $iron_type_con                  
					AND type = 'ROM'
                    AND grade_code = g1.grade_code
                    ORDER BY `return_date`  DESC
                    LIMIT 1
                )  closing_stock
                
                FROM `grade_prod` g1
                where mine_code = '$mineCode'
                AND return_type = 'MONTHLY'
                AND return_date BETWEEN '$starDate' AND '$endDate'
                AND mineral_name = '$mineral'
                $iron_type_con
				AND type = 'ROM'
                GROUP by grade_code 
                ORDER BY `id`  DESC ";

                // print_r($str);   exit;
                $query = $conn->execute($str)->fetchAll('assoc');

            }
		  

			//   
			//     $returns = $con->execute("SELECT status FROM (SELECT * FROM TBL_FINAL_SUBMIT 
			//   	WHERE applicant_id = ? AND return_type = ? " . $where_clause . " ORDER BY created_at DESC) m 
			//     GROUP BY return_date, mine_code", array($app_id, $return_type))->fetchAll('assoc');

			$data = array();
			$i = 0;
			foreach ($query as $g) {
				$data[$g['grade_code']] = $query[$i];

				if ($query[$i]['reason_1'] != '')
				$data['reason_1'] = $query[$i]['reason_1'];
				if ($query[$i]['reason_2'] != '')
				$data['reason_2'] = $query[$i]['reason_2'];

				$i++;
			}

			if (count($query) > 0)
				return $data;
			else
				return array();
			
		
		}

		/**
		 * Cumulative monthly data for annual return
		 * @version 08th Nov 2021
		 * @author Aniket Ganvir
		 */
		public function getProductionDataMonthly($mineCode, $returnType, $returnDate, $mineral, $sub_mineral=null) {

            $conn = ConnectionManager::get(Configure::read('conn'));            

            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $sub_mineral = strtolower(str_replace(' ', '_', $sub_mineral));
            $query = array();
			
            if ($sub_mineral != "") {
                $iron_type_con = "AND iron_type = '".$sub_mineral."'";
            } else {
                $iron_type_con = "";
            }
			
			$starDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';

			$str = "SELECT 
			g1.grade_code,g1.iron_type,g1.average_grade,
			CASE	
				WHEN g1.return_date = '$starDate' THEN g1.opening_stock    
			END as opening_stock,
			sum(production) as production,
			sum(despatches) as despatches,
			avg(pmv) as pmv,
			( 
				SELECT closing_stock from grade_prod
				where mine_code = '$mineCode'
				AND return_type = 'MONTHLY'
				AND return_date BETWEEN '$starDate' AND '$endDate' 
				AND mineral_name = '$mineral'
				$iron_type_con                  
				AND type IS NULL
				AND grade_code = g1.grade_code
				ORDER BY `return_date`  DESC
				LIMIT 1
			)  closing_stock
			
			FROM `grade_prod` g1
			where mine_code = '$mineCode'
			AND return_type = 'MONTHLY'
			AND return_date BETWEEN '$starDate' AND '$endDate'
			AND mineral_name = '$mineral'
			$iron_type_con
			AND type IS NULL
			GROUP by grade_code 
			ORDER BY `id`  DESC ";

			$query = $conn->execute($str)->fetchAll('assoc');

			$data = array();
			$i = 0;
			foreach ($query as $g) {
				$data[$g['grade_code']] = $query[$i];
				$i++;
			}

			if (count($query) > 0) {
				return $data;
			}
			else {
				return array();
			}

		}
		


		/**
		 * Cumulative monthly data for annual return
		 * @version 27th Dec 2021
		 * @author Aniket Ganvir
		 */
		public function getProductionDataRomMonthly($mineCode, $returnType, $returnDate, $mineral, $sub_mineral=null) {

            $conn = ConnectionManager::get(Configure::read('conn'));            

            $mineral = strtolower(str_replace(' ', '_', $mineral));
            $sub_mineral = strtolower(str_replace(' ', '_', $sub_mineral));
            $query = array();
				
            if ($sub_mineral != "") {
                $iron_type_con = "AND iron_type = '".$sub_mineral."'";
            } else {
                $iron_type_con = "";
            }
			
			$starDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';

			$str = "SELECT 
			g1.grade_code,g1.iron_type,g1.average_grade,
			CASE	
				WHEN g1.return_date = '$starDate' THEN g1.opening_stock    
			END as opening_stock,
			sum(production) as production,
			sum(despatches) as despatches,
			avg(pmv) as pmv,
			( 
				SELECT closing_stock from grade_prod
				where mine_code = '$mineCode'
				AND return_type = 'MONTHLY'
				AND return_date BETWEEN '$starDate' AND '$endDate' 
				AND mineral_name = '$mineral'
				$iron_type_con                  
				AND type = 'ROM'
				AND grade_code = g1.grade_code
				ORDER BY `return_date`  DESC
				LIMIT 1
			)  closing_stock
			
			FROM `grade_prod` g1
			where mine_code = '$mineCode'
			AND return_type = 'MONTHLY'
			AND return_date BETWEEN '$starDate' AND '$endDate'
			AND mineral_name = '$mineral'
			$iron_type_con
			AND type = 'ROM'
			GROUP by grade_code 
			ORDER BY `id`  DESC ";

			$query = $conn->execute($str)->fetchAll('assoc');

			$data = array();
			$i = 0;
			foreach ($query as $g) {
				$data[$g['grade_code']] = $query[$i];
				$i++;
			}

			if (count($query) > 0) {
				return $data;
			}
			else {
				return array();
			}

		}

		/**
		 * GET PREVIOUS MONTH GRADEWISE CLOSING STOCKS
		 * @addedon: 26th JUN 2021 (by Aniket Ganvir)
		*/
		public function getPrevClosingStocks($mineCode, $returnType, $returnDate, $mineral, $sub_mineral=null) {

			$returnDate = date('Y-m-d', strtotime('-1 month', strtotime($returnDate)));

			if ($sub_mineral != "") {
				$query = $this->find('all')
					->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>$mineral,'iron_type'=>$sub_mineral])
					->toArray();
			} else {
				$query = $this->find('all')
					->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>$mineral])
					->toArray();
			}
			if ($query == null) {
				if ($sub_mineral != "") {
					$query = $this->find('all')
						->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>strtolower(str_replace(' ', '_', $mineral)),'iron_type'=>strtolower(str_replace(' ', '_', $sub_mineral))])
						->toArray();
				} else {
					$query = $this->find('all')
						->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>strtolower(str_replace(' ', '_', $mineral))])
						->toArray();
				}
			}

			$data = array();
			$i = 0;
			foreach ($query as $g) {
				$data[$g['grade_code']] = $query[$i];

				if ($query[$i]['reason_1'] != '')
					$data['reason_1'] = $query[$i]['reason_1'];
				if ($query[$i]['reason_2'] != '')
					$data['reason_2'] = $query[$i]['reason_2'];

				$i++;
			}

			if (count($query) > 0)
				return $data;
			else
				return array();

		}

		/**
		 * Check filled status of section
		 * @version 29th Oct 2021
		 * @author Aniket Ganvir
		 */
		public function isFilledGradeProd($mineCode, $returnType, $returnDate, $mineralName, $gradeCode, $ironSubMin=null) {

			if($gradeCode != ''){
				if($ironSubMin == null){
			    	$records = $this->find('all')
							->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,"grade_code"=>$gradeCode])
							->count();
				} else {
			    	$records = $this->find('all')
							->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,"grade_code"=>$gradeCode,"iron_type"=>$ironSubMin])
							->count();
				}
			} else {
				if($ironSubMin == null){
					$records = $this->find('all')
							->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName])
							->count();
				} else {
					$records = $this->find('all')
							->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,"iron_type"=>$ironSubMin])
							->count();
				}
			}

			if ($records > 0) {
				return true;
			} else {
				return false;
			}
			
		}

		public function getProductionTotal($mineCode, $returnType, $returnDate, $mineralName){

			$query = $this->find()
				->select(['production'])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>$returnType])
				->where(['return_date'=>$returnDate])
				->where(['mineral_name'=>$mineralName])
				->toArray();
			$total = 0;
			foreach($query as $data){
			  $total = $total + $data['production'];
			}
			return $total;

		}

		/**
		 * CREATED THE FUNCTION FOR GETTING THE TYPE OF IRON ORE SELECTED BY THE USER
		 * AND THEN REMOVE THE ROWS THAT ARE USELESS
		 * 
		 * 
		 * @author Uday Shankar Singh
		 * @version 10th June 2014
		 * 
		 * @param String $mineCode
		 * @param String $returnType
		 * @param String $returnDate
		 * @param String $mineralName
		 * @return TRUE AS THIS WILL EXECUTE EVERY TIME OF FINALL SUBMIT  
		 */
		public function removeTableExtraRowsForIronOre($mineCode, $returnDate, $returnType){
			
			$prod1 = TableRegistry::getTableLocator()->get('Prod1');
			$query1  = $prod1->getIronOreSelected($mineCode, $returnType, $returnDate);
			if(count($query1) == 2)
				return true;
			else if(count($query1) == 1){
				if(isset($query1[0]) && $query1[0] == 'HEMATITE')
					$this->removeTableRow($mineCode, $returnDate, $returnType, 'magnetite');
				if(isset($query1[1]) && $query1[1] == 'MAGNETITE')
					$this->removeTableRow($mineCode, $returnDate, $returnType, 'hematite');
			}
			
			return true;

		}

		/**
		 * FUNCTION CALLED FROM removeTableExtraRowsForIronOre() OF THE SAME FILE.
		 * FUNTION ACTUALLY REMOVE THE RECORDS FROM THE DATABASE
		 * 
		 * @author Uday Shankar Singh
		 * @version 10th June 2014
		 * 
		 * @param String $mineCode
		 * @param String $returnDate
		 * @param String $returnType
		 * @param String $ironSubMineralName
		 * @return TRUE AS THE FUNCTION IS CALLED EVERY TIME OF FINAL SUBMIT AND GETS 
		 * EXECUTED AND REMOVE THE EXTRA RECORDS IF FOUND 
		 */
		public function removeTableRow($mineCode, $returnDate, $returnType, $ironSubMineralName){

			$query = $this->query();
			$query->delete()
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>$returnType])
				->where(['return_date'=>$returnDate])
				->where(['iron_type'=>$ironSubMineralName])
				->where(["mineral_name"=>'iron_ore'])
				->execute();
			
			return true;

		}

	} 
?>