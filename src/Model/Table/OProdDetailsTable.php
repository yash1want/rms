<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use App\Controller\MonthlyController;
	
	class OProdDetailsTable extends Table{

		var $name = "OProdDetails";
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getRecordId($formType, $retrunType, $returnDate, $end_user_id, $formFlag) {

            $query = $this->find()
                ->select(['id'])
                ->where(['form_type'=>$formType])
                ->where(['return_type'=>$retrunType])
                ->where(['return_date'=>$returnDate])
                ->where(['end_user_id'=>$end_user_id])
                ->where(['FORM_FLAG'=>$formFlag])
                // ->where(['mineral_name'=>$mineralName])
                ->toArray();

            $rowCount = count($query);
            if ($rowCount > 0) {
                return 1;
            } else {
                return 0;
            }

        }
        
        public function getMineralData($formType, $returnType, $returnDate, $end_user_id, $formFlagProd) {

            $query = $this->find('all')
                    ->where(['form_type'=>$formType])
                    ->where(['return_type'=>$returnType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['end_user_id'=>$end_user_id])
                    ->where(['form_flag'=>$formFlagProd])
                    // ->andWhere('mineral_name = ?', $mineralName)
                    // ->andWhere('user_type = ?', $userType)
                    ->toArray();

            $count = count($query);
            $resultSet = array();
            $resultSet['totalCount'] = $count;
            $count1 = 1;
            $count2 = 1;
            $count3 = 1;
            // for ($i = 0; $i <= $count; $i++) {
            for ($i = 0; $i < $count; $i++) {
                if ($query[$i]['prod_type'] == 1) {
                    $resultSet['prod_type1'] = $count1;
                    $resultSet['finished_Product_' . $count1] = $query[$i]['prod_name'];
                    $resultSet['finished_Capacity_' . $count1] = $query[$i]['prod_anual_capacity'];
                    $resultSet['finished_Previous_' . $count1] = $query[$i]['prev_year_prod'];
                    $resultSet['finished_Present_' . $count1] = $query[$i]['pres_year_prod'];
                    $resultSet['expansion_under'] = $query[0]['current_expansion_prog'];
                    $resultSet['expansion_program'] = $query[0]['future_expansion_prog'];
                    $resultSet['research_develop'] = $query[0]['reasearch_expansion_prog'];
                    $resultSet['finishedProductCount'] = $count1;
                    $count1++;
                } else if ($query[$i]['prod_type'] == 2) {

                    $resultSet['prod_type2'] = $count2;
                    $resultSet['intermediate_Product_' . $count2] = $query[$i]['prod_name'];
                    $resultSet['intermediate_Capacity_' . $count2] = $query[$i]['prod_anual_capacity'];
                    $resultSet['intermediate_Previous_' . $count2] = $query[$i]['prev_year_prod'];
                    $resultSet['intermediate_Present_' . $count2] = $query[$i]['pres_year_prod'];
                    $resultSet['expansion_under'] = $query[0]['current_expansion_prog'];
                    $resultSet['expansion_program'] = $query[0]['future_expansion_prog'];
                    $resultSet['research_develop'] = $query[0]['reasearch_expansion_prog'];
                    $resultSet['interProductCount'] = $count2;
                    $count2++;
                } else if ($query[$i]['prod_type'] == 3) {
                    $resultSet['prod_type3'] = $count3;
                    $resultSet['byProducts_Product_' . $count3] = $query[$i]['prod_name'];
                    $resultSet['byProducts_Capacity_' . $count3] = $query[$i]['prod_anual_capacity'];
                    $resultSet['byProducts_Previous_' . $count3] = $query[$i]['prev_year_prod'];
                    $resultSet['byProducts_Present_' . $count3] = $query[$i]['pres_year_prod'];
                    $resultSet['expansion_under'] = $query[0]['current_expansion_prog'];
                    $resultSet['expansion_program'] = $query[0]['future_expansion_prog'];
                    $resultSet['research_develop'] = $query[0]['reasearch_expansion_prog'];
                    $resultSet['byProductCount'] = $count3;
                    $count3++;
                }
            }

            /**
             * SET DEFAULT BLANK ARRAY IF THERE'S NO RECORDS IN DB
             * @version 10th Dec 2021
             * @author Aniket Ganvir
             */
            if ($count == 0) {
                $resultSet['prod_type1'] = 1;
                $resultSet['finished_Product_1'] = '';
                $resultSet['finished_Capacity_1'] = '';
                $resultSet['finished_Previous_1'] = '';
                $resultSet['finished_Present_1'] = '';
                $resultSet['expansion_under'] = '';
                $resultSet['expansion_program'] = '';
                $resultSet['research_develop'] = '';
                $resultSet['finishedProductCount'] = 1;

                $resultSet['prod_type2'] = 1;
                $resultSet['intermediate_Product_1'] = '';
                $resultSet['intermediate_Capacity_1'] = '';
                $resultSet['intermediate_Previous_1'] = '';
                $resultSet['intermediate_Present_1'] = '';
                $resultSet['expansion_under'] = '';
                $resultSet['expansion_program'] = '';
                $resultSet['research_develop'] = '';
                $resultSet['interProductCount'] = 1;

                $resultSet['prod_type3'] = 1;
                $resultSet['byProducts_Product_1'] = '';
                $resultSet['byProducts_Capacity_1'] = '';
                $resultSet['byProducts_Previous_1'] = '';
                $resultSet['byProducts_Present_1'] = '';
                $resultSet['expansion_under'] = '';
                $resultSet['expansion_program'] = '';
                $resultSet['research_develop'] = '';
                $resultSet['byProductCount'] = 1;
            }

            return $resultSet;
            
        }

        public function deleteRecordset($formType, $retrunType, $returnDate, $end_user_id, $formFlag) {

            $query = $this->query();
            $query->delete()
                ->where(['form_type'=>$formType])
                ->where(['return_type'=>$retrunType])
                ->where(['return_date'=>$returnDate])
                ->where(['end_user_id'=>$end_user_id])
                ->where(['form_flag'=>$formFlag])
                // ->where(['mineral_name'=>$mineralName])
                // ->where(['user_type'=>$userType])
                ->execute();

        }

        // public static function getAllData($formType, $retrunType, $returnDate, $end_user_id, $userType, $mineralName) {
        public function getAllData($formType, $retrunType, $returnDate, $end_user_id, $formFlag) {
            
            $query = $this->find('all')
                    ->where(['form_type'=>$formType])
                    ->where(['return_type'=>$retrunType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['end_user_id'=>$end_user_id])
                    ->where(['form_flag'=>$formFlag])
                    // ->andWhere('mineral_name = ?', $mineralName)
                    // ->andWhere('user_type = ?', $userType)
                    ->toArray();

            $count = count($query);
            $resultSet = array();
            $resultSet['totalCount'] = $count;

            // for ($i = 0; $i <= $count; $i++) {
            for ($i = 0; $i < $count; $i++) {
                if ($i == 15) {
                    $prod_name = str_replace('Refractories-bricks   ','',$query[$i]['prod_name']);
                } else if ($i == 16) {
                    $prod_name = str_replace('Fertilizers   ','',$query[$i]['prod_name']);
                } else if ($i == 17) {
                    $prod_name = str_replace('Any other product/by-product   ','',$query[$i]['prod_name']);
                } else {
                    $prod_name = $query[$i]['prod_name'];
                }
                $resultSet['prod_name_' . ($i + 1)] = $prod_name;
                $resultSet['prod_anual_capacity_' . ($i + 1)] = $query[$i]['prod_anual_capacity'];
                $resultSet['prev_year_prod_' . ($i + 1)] = $query[$i]['prev_year_prod'];
                $resultSet['pres_year_prod_' . ($i + 1)] = $query[$i]['pres_year_prod'];
                $resultSet['prod_remark_' . ($i + 1)] = $query[$i]['remark'];
                $resultSet['current_expansion_prog'] = $query[0]['current_expansion_prog'];
                $resultSet['future_expansion_prog'] = $query[0]['future_expansion_prog'];
                $resultSet['research_prog'] = $query[0]['reasearch_expansion_prog'];
            }

            if ($count == 0) {
                for ($n = 1; $n <= 19; $n++) {
                    $resultSet['prod_name_' . $n] = '';
                    $resultSet['prod_anual_capacity_' . $n] = '';
                    $resultSet['prev_year_prod_' . $n] = '';
                    $resultSet['pres_year_prod_' . $n] = '';
                    $resultSet['prod_remark_' . $n] = '';
                    $resultSet['current_expansion_prog'] = '';
                    $resultSet['future_expansion_prog'] = '';
                    $resultSet['research_prog'] = '';
                }
            }

            return $resultSet;
            
        }
        
	    public function saveFormDetails($params){

			$dataValidatation = $this->postDataValidation($params);

			if ($dataValidatation == 1){

                $formFlag = 1;

	        	$formType = $params['fType'];
	        	$returnType = $params['return_type'];
	        	$returnDate = $params['return_date'];
	        	$endUserId = $params['end_user_id'];
	        	$userType = $params['user_type'];

				$result = '1';
                
                // $exsistanceCheck = O_PROD_DETAILSTable::getRecordId($this->formType, $this->returnType, $this->returnDate, $this->endUserId, $this->userType, $this->mineralName);
                $exsistanceCheck = $this->getRecordId($formType, $returnType, $returnDate, $endUserId, $formFlag);

                if ($exsistanceCheck == 1) {
                    // O_PROD_DETAILSTable::deleteRecordset($this->formType, $this->returnType, $this->returnDate, $this->endUserId, $this->userType, $this->mineralName);
                    $this->deleteRecordset($formType, $returnType, $returnDate, $endUserId, $formFlag);
                }

                $finProdCount = count($params['finished_Product']);
                $srno = 20;
                for ($n = 0; $n < $finProdCount; $n++) {

                    $newEntity = $this->newEntity(array(
                        'form_type' => "O",
                        'return_type' => $returnType,
                        'return_date' => $returnDate,
                        'end_user_id' => $endUserId,
                        // 'mineral_name' => $mineralName,
                        'prod_name' => $params["finished_Product"][$n],
                        'prod_anual_capacity' => $params["finished_Capacity"][$n],
                        'prev_year_prod' => $params["finished_Previous"][$n],
                        'pres_year_prod' => $params["finished_Present"][$n],
                        'current_expansion_prog' => $params["expansion_under"],
                        'future_expansion_prog' => $params["expansion_program"],
                        'reasearch_expansion_prog' => $params["research_develop"],
                        // 'user_type' => $userType,
                        'prod_type' => 1,
                        'form_flag' => 1,
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
                
                $intProdCount = count($params['intermediate_Product']);
                for ($n = 0; $n < $intProdCount; $n++) {

                    $newEntity = $this->newEntity(array(
                        'form_type' => "O",
                        'return_type' => $returnType,
                        'return_date' => $returnDate,
                        'end_user_id' => $endUserId,
                        // 'mineral_name' => $mineralName,
                        'prod_name' => $params["intermediate_Product"][$n],
                        'prod_anual_capacity' => $params["intermediate_Capacity"][$n],
                        'prev_year_prod' => $params["intermediate_Previous"][$n],
                        'pres_year_prod' => $params["intermediate_Present"][$n],
                        'current_expansion_prog' => $params["expansion_under"],
                        'future_expansion_prog' => $params["expansion_program"],
                        'reasearch_expansion_prog' => $params["research_develop"],
                        // 'user_type' => $userType,
                        'prod_type' => 2,
                        'form_flag' => 1,
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
                
                $bypProdCount = count($params['byProducts_Product']);
                for ($n = 0; $n < $bypProdCount; $n++) {

                    $newEntity = $this->newEntity(array(
                        'form_type' => "O",
                        'return_type' => $returnType,
                        'return_date' => $returnDate,
                        'end_user_id' => $endUserId,
                        // 'mineral_name' => $mineralName,
                        'prod_name' => $params["byProducts_Product"][$n],
                        'prod_anual_capacity' => $params["byProducts_Capacity"][$n],
                        'prev_year_prod' => $params["byProducts_Previous"][$n],
                        'pres_year_prod' => $params["byProducts_Present"][$n],
                        'current_expansion_prog' => $params["expansion_under"],
                        'future_expansion_prog' => $params["expansion_program"],
                        'reasearch_expansion_prog' => $params["research_develop"],
                        // 'user_type' => $userType,
                        'prod_type' => 3,
                        'form_flag' => 1,
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

	    public function postDataValidation($params){
			
			$returnValue = 1;
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;

			if(empty($params['fType'])){ $returnValue = null; }
			if(empty($params['return_type'])){ $returnValue = null; }
			if(empty($params['return_date'])){ $returnValue = null; }
			if(empty($params['end_user_id'])){ $returnValue = null; }
            
            $expUnd = $params["expansion_under"];
            $expPrg = $params["expansion_program"];
            $resDev = $params["research_develop"];
            
            if (strlen($expUnd) > 500) { $returnValue = null; }
            if (strlen($expPrg) > 500) { $returnValue = null; }
            if (strlen($resDev) > 500) { $returnValue = null; }

            $products = array('finished', 'intermediate', 'byProducts');
            $i = 1;
            foreach ($products as $prd) {
                $prodCount = count($params[$prd.'_Product']);
                if (!is_numeric($prodCount)) { $returnValue = null; }
                else {
                    for ($n = 0; $n < $prodCount; $n++) {
    
                        $prod = $params[$prd."_Product"][$n];
                        $cap = $params[$prd."_Capacity"][$n];
                        $prev = $params[$prd."_Previous"][$n];
                        $pres = $params[$prd."_Present"][$n];
    
                        if (strlen($prod) > 50) { $returnValue = null; }
    
                        if ($cap != '') {
                            $returnValue = ($validate->chkFloatCharac($cap, 3, 16) == false) ? null : $returnValue;
                            $returnValue = ($validate->chkDecimalPlaces($cap, 3) == false) ? null : $returnValue;
                        }
                        if ($prev != '') {
                            $returnValue = ($validate->chkFloatCharac($prev, 3, 16) == false) ? null : $returnValue;
                            $returnValue = ($validate->chkDecimalPlaces($prev, 3) == false) ? null : $returnValue;
                        }
                        if ($pres != '') {
                            $returnValue = ($validate->chkFloatCharac($pres, 3, 16) == false) ? null : $returnValue;
                            $returnValue = ($validate->chkDecimalPlaces($pres, 3) == false) ? null : $returnValue;
                        }
                        $i++;
                        
                    }
                }
            }
			
			return $returnValue;
			
		}

	    public function saveFormIronSteel($params){

			$dataValidatation = $this->postDataValidateIronSteel($params);

			if ($dataValidatation == 1){

                $formFlag = 2;

	        	$formType = $params['fType'];
	        	$returnType = $params['return_type'];
	        	$returnDate = $params['return_date'];
	        	$endUserId = $params['end_user_id'];
	        	$userType = $params['user_type'];
                $params['prod_anual_capacity_19'] = '';
                $params['prod_remark_19'] = '';

				$result = '1';
                
                $exsistanceCheck = $this->getRecordId($formType, $returnType, $returnDate, $endUserId, $formFlag);

                if ($exsistanceCheck == 1) {
                    $this->deleteRecordset($formType, $returnType, $returnDate, $endUserId, $formFlag);
                }

                for ($i = 1; $i <= 19; $i++) {

                    if ($i == 16) {
                        $prod_name = 'Refractories-bricks   '.$params['prod_name_' . $i];
                    } else if ($i == 17) {
                        $prod_name = 'Fertilizers   '.$params['prod_name_' . $i];
                    } else if ($i == 18) {
                        $prod_name = 'Any other product/by-product   '.$params['prod_name_' . $i];
                    } else {
                        $prod_name = $params['prod_name_' . $i];
                    }

                    $newEntity = $this->newEntity(array(
                        'end_user_id' => $endUserId,
                        'form_type' => 'O',
                        'return_type' => $returnType,
                        'return_date' => $returnDate,
                        // 'mineral_name' => $mineral,
                        'prod_anual_capacity' => $params['prod_anual_capacity_' . $i],
                        'pres_year_prod' => $params['pres_year_prod_' . $i],
                        'prev_year_prod' => $params['prev_year_prod_' . $i],
                        'prod_name' => $prod_name,
                        'remark' => $params['prod_remark_' . $i],
                        'current_expansion_prog' => $params['current_expansion_prog'],
                        'future_expansion_prog' => $params['future_expansion_prog'],
                        'reasearch_expansion_prog' => $params['research_prog'],
                        // 'user_type' => $userType,
                        'prod_type' => '4',
                        'form_flag' => 2,
                        'srno' => $i,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s')
                    ));
                    if($this->save($newEntity)){
                        //
                    } else {
                        $result = false;
                    }
                    
                }

			} else {
				$result = false;
			}

			return $result;

	    }

	    public function postDataValidateIronSteel($params){
			
			$returnValue = 1;
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;

			if(empty($params['fType'])){ $returnValue = null; }
			if(empty($params['return_type'])){ $returnValue = null; }
			if(empty($params['return_date'])){ $returnValue = null; }
			if(empty($params['end_user_id'])){ $returnValue = null; }

            $params['prod_anual_capacity_19'] = '';
            $params['prod_remark_19'] = '';
            
            $cuExProg = $params["current_expansion_prog"];
            $fuExProg = $params["future_expansion_prog"];
            $resProg = $params["research_prog"];
            
            if (strlen($cuExProg) > 500) { $returnValue = null; }
            if (strlen($fuExProg) > 500) { $returnValue = null; }
            if (strlen($resProg) > 500) { $returnValue = null; }

            for ($i = 1; $i <= 19; $i++) {

                $prodAnCap = $params['prod_anual_capacity_' . $i];
                $presYearProd = $params['pres_year_prod_' . $i];
                $prevYearProd = $params['prev_year_prod_' . $i];
                $prodName = $params['prod_name_' . $i];
                $prodRem = $params['prod_remark_' . $i];

                if ($prodAnCap != '') {
                    $returnValue = ($validate->numeric($prodAnCap) == false) ? null : $returnValue;
                    $returnValue = ($validate->chkFloatCharac($prodAnCap, 3, 20) == false) ? null : $returnValue;
                    $returnValue = ($validate->chkDecimalPlaces($prodAnCap, 3) == false) ? null : $returnValue;
                }
                if ($presYearProd != '') {
                    $returnValue = ($validate->numeric($presYearProd) == false) ? null : $returnValue;
                    $returnValue = ($validate->chkFloatCharac($presYearProd, 3, 20) == false) ? null : $returnValue;
                    $returnValue = ($validate->chkDecimalPlaces($presYearProd, 3) == false) ? null : $returnValue;
                }
                if ($prevYearProd != '') {
                    $returnValue = ($validate->numeric($prevYearProd) == false) ? null : $returnValue;
                    $returnValue = ($validate->chkFloatCharac($prevYearProd, 3, 20) == false) ? null : $returnValue;
                    $returnValue = ($validate->chkDecimalPlaces($prevYearProd, 3) == false) ? null : $returnValue;
                }
                if ($prodRem != '') {
                    $returnValue = (strlen($prodRem) > 100) ? null : $returnValue;
                }
                if ($prodName != '') {
                    $returnValue = (strlen($prodName) > 50) ? null : $returnValue;
                }

            }
			
			return $returnValue;
			
		}
        
		/**
		* Used to check for the final submit
		* Returns 0 if the form is not filled
		* Returns 1 if the form is filled
        * @version 04th Dec 2021
        * @author Aniket Ganvir
		*/
        public function isFilled($formType, $returnType, $returnDate, $end_user_id, $formFlagProd) {

            $records = $this->find()
                    ->select(['id'])
                    ->where(['form_type'=>$formType])
                    ->where(['return_type'=>$returnType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['end_user_id'=>$end_user_id])
                    ->where(['form_flag'=>$formFlagProd])
                    ->count();

            if ($records > 0) {
                return 1;
            } else {
                return 0;
            }
            
        }

        public function checkRecordForFinalSubmit($formType, $retrunType, $returnDate, $end_user_id, $formFlag) {

            $query = $this->find()
                    // ->select('id')
                    ->where(['form_type'=>$formType])
                    ->where(['return_type'=>$retrunType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['end_user_id'=>$end_user_id])
                    ->where(['FORM_FLAG'=>$formFlag])
                    // ->where(['mineral_name'=>$mineralName])
                    ->toArray();

            $tableData = 0;
            foreach ($query as $data) {
                /**
                 * 
                 * @author Uday Shankar singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 15th Jan 2014
                 * 
                 * COMMENTED THE $data['PROD_NAME'] AS THIS IS SAVED HE LABEL IN DB
                 */
                // if ($data['PROD_NAME'] != '' || $data['PROD_ANUAL_CAPACITY'] != '' || $data['PREV_YEAR_PROD'] != '' || $data['PRES_YEAR_PROD'] != '') {
                if ($data['prod_anual_capacity'] != '' || $data['prev_year_prod'] != '' || $data['pres_year_prod'] != '') {
                    $tableData = 1;
                }
            }
            if ($tableData == 1) {
                return 1;
            } else {
                return 0;
            }

        }

	}
?>