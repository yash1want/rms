<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class NSeriesProdActivityTable extends Table{
		
		var $name = "NSeriesProdActivity";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function checkForValue($formType, $returnType, $returnDate, $endUserId, $userType) {

            $count = $this->find('all')
                    ->where(['form_type IS'=>$formType])
                    ->where(['return_type IS'=>$returnType])
                    ->where(['return_date IS'=>$returnDate])
                    ->where(['end_user_id IS'=>$endUserId])
                    ->where(['user_type IS'=>$userType])
                    ->count();
                    
            if ($count > 0) {
                return 1;
            } else {
                return 0;
            }

        }

        public function getSeriesActivityDetails($formType, $returnType, $returnDate, $endUserId, $user_type, $pdfStatus = 0) {

            $query = $this->find()
                    ->where(['form_type'=>$formType])
                    ->where(['return_type'=>$returnType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['end_user_id'=>$endUserId])
                    ->where(['user_type'=>$user_type])
                    ->toArray();

            if (count($query) == 0 && $returnType == 'ANNUAL' && $pdfStatus == 0) {
                
				/**
				 * Prefetch the monthly records data for annual returns
				 * Effective from Phase - II
				 * @version 01st Dec 2021
				 * @author Aniket Ganvir
				 */
				$conn = ConnectionManager::get(Configure::read('conn'));
				$startDate = (date('Y',strtotime($returnDate))).'-04-01';
				$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
				$str = "SELECT
                n.local_mineral_code,
                n.local_grade_code,
                n.remark,
                (
                    SELECT m.opening_stock
                    FROM `n_series_prod_activity` m
                    WHERE m.form_type = 'N'
                    AND m.return_type = 'MONTHLY'
                    AND m.return_date BETWEEN '$startDate' AND '$endDate'
                    AND m.end_user_id = '$endUserId'
                    AND m.user_type = '$user_type'
                    AND m.local_mineral_code = n.local_mineral_code
                    AND m.local_grade_code = n.local_grade_code
                    ORDER BY m.return_date ASC
                    LIMIT 1
                ) opening_stock,
                (
                    SELECT o.closing_stock
                    FROM `n_series_prod_activity` o
                    WHERE o.form_type = 'N'
                    AND o.return_type = 'MONTHLY'
                    AND o.return_date BETWEEN '$startDate' AND '$endDate'
                    AND o.end_user_id = '$endUserId'
                    AND o.user_type = '$user_type'
                    AND o.local_mineral_code = n.local_mineral_code
                    AND o.local_grade_code = n.local_grade_code
                    ORDER BY o.return_date DESC
                    LIMIT 1
                ) closing_stock
                FROM `n_series_prod_activity` n
                WHERE n.form_type = 'N'
                AND n.return_type = 'MONTHLY'
                AND n.return_date BETWEEN '$startDate' AND '$endDate'
                AND n.end_user_id = '$endUserId'
                AND n.user_type = '$user_type'
                GROUP BY n.local_mineral_code, n.local_grade_code";
					
				$query = $conn->execute($str)->fetchAll('assoc');

            }
        
            return $query;

        }

        /**
         * Prefetch the monthly records data for annual returns
         * Effective from Phase - II
         * @version 01st Dec 2021
         * @author Aniket Ganvir
         */
        public function getSeriesActivityDetailsMonthAll($formType, $returnType, $returnDate, $endUserId, $user_type) {

            $conn = ConnectionManager::get(Configure::read('conn'));
            $startDate = (date('Y',strtotime($returnDate))).'-04-01';
            $endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
            $str = "SELECT
            n.local_mineral_code,
            n.local_grade_code,
            n.remark,
            (
                SELECT m.opening_stock
                FROM `n_series_prod_activity` m
                WHERE m.form_type = 'N'
                AND m.return_type = 'MONTHLY'
                AND m.return_date BETWEEN '$startDate' AND '$endDate'
                AND m.end_user_id = '$endUserId'
                AND m.user_type = '$user_type'
                AND m.local_mineral_code = n.local_mineral_code
                AND m.local_grade_code = n.local_grade_code
                ORDER BY m.return_date ASC
                LIMIT 1
            ) opening_stock,
            (
                SELECT o.closing_stock
                FROM `n_series_prod_activity` o
                WHERE o.form_type = 'N'
                AND o.return_type = 'MONTHLY'
                AND o.return_date BETWEEN '$startDate' AND '$endDate'
                AND o.end_user_id = '$endUserId'
                AND o.user_type = '$user_type'
                AND o.local_mineral_code = n.local_mineral_code
                AND o.local_grade_code = n.local_grade_code
                ORDER BY o.return_date DESC
                LIMIT 1
            ) closing_stock
            FROM `n_series_prod_activity` n
            WHERE n.form_type = 'N'
            AND n.return_type = 'MONTHLY'
            AND n.return_date BETWEEN '$startDate' AND '$endDate'
            AND n.end_user_id = '$endUserId'
            AND n.user_type = '$user_type'
            GROUP BY n.local_mineral_code, n.local_grade_code";
                
            $query = $conn->execute($str)->fetchAll('assoc');
        
            return $query;

        }
        
        public function saveFormDetails($params){
            
			$dataValidatation = $this->postDataValidation($params);

			if($dataValidatation == 1 ){

	            $formType = $params['fType'];
	        	$returnType = $params['return_type'];
	        	$returnDate = $params['return_date'];
	        	$endUserId = $params['end_user_id'];
	        	$userType = $params['user_type'];
                $sectionNo = $params['section_no'];
                
                $checkDBForData = $this->checkDBForForSave($formType, $returnType, $returnDate, $endUserId);
                if ($checkDBForData > 0) {
                
                    $this->query()
                    ->delete()
                    ->where(['form_type'=>$formType])
                    ->where(['return_type'=>$returnType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['end_user_id'=>$endUserId])
                    ->where(['user_type'=>$userType])
                    ->execute();

                    $extraNSeriesProdActivity = TableRegistry::getTableLocator()->get('ExtraNSeriesProdActivity');
                    $extraNSeriesProdActivity->query()
                            ->delete()
                            // ->andWhere('FORM_TYPE = ?', $formType)
                            ->where(['return_type'=>$returnType])
                            ->where(['return_date'=>$returnDate])
                            ->where(['end_user_id'=>$endUserId])
                            ->where(['user_type'=>$userType])
                            ->execute();

                }

				$result = '1';
                $saveStatus = false;
                $mineral_cnt = $params['mineral_cnt'];
                $date = date('Y-m-d H:i:s');
                for ($y = 1; $y <= $mineral_cnt; $y++) {
    
                    $grade_count = $params['grade_cnt_' . $y];
                    $mineralName = $params['mineral_' . $y];
                    $gradeIncreament = 1;    
                    for ($i = 0; $i < $grade_count; $i++) {
                        $gradeIncreament = $i + 1;

                        $gradeName = $params['grade_' . $y . '_' . $gradeIncreament]; // grade name
                        $openingStock = $params['opening_stock_quantity_' . $y . '_' . $gradeIncreament]; // opening stock
                        $closingStock = $params['closing_stock_' . $y . '_' . $gradeIncreament]; // opening stock
                        // $remark = $params['remark_' . $y . '_' . $gradeIncreament]; // remark
                        
						$newEntity = $this->newEntity(array(
                            'form_type'=>$formType,
                            'return_type'=>$returnType,
                            'return_date'=>$returnDate,
                            'end_user_id'=>$endUserId,
                            'user_type'=>$userType, // MAY BE HARD CODED AS THIS FORM ALWAYS BELONG TO TRADING AND SO ARE OTHERS
                            'local_mineral_code'=>$mineralName,
                            'local_grade_code'=>$gradeName,
                            'opening_stock'=>$openingStock,
                            'closing_stock'=>$closingStock,
                            // 'remark'=>$remark,
                            'created_at'=>$date,
                            'updated_at'=>$date
						));
						if($this->save($newEntity)){
                            $saveStatus = true;
						} else {
							$result = false;
						}

                        $purchase_cnt = $params['purchase_cnt_' . $y . '_' . $gradeIncreament];
                        for ($k = 0; $k < $purchase_cnt; $k++) { //for purchase 
                            $sup_cnt = $k + 1;
                            
                            $purchaseRegNo = $params['reg_no_' . $y . '_' . $gradeIncreament . '_' . $sup_cnt];
                            $purchaseQuantity = $params['supplier_quantity_' . $y . '_' . $gradeIncreament . '_' . $sup_cnt];
                            $purchaseValue = $params['supplier_value_' . $y . '_' . $gradeIncreament . '_' . $sup_cnt];

                            $extraNSeriesProdActivity = TableRegistry::getTableLocator()->get('ExtraNSeriesProdActivity');

                            $newEntityPurchase = $extraNSeriesProdActivity->newEntity(array(
                                'return_type'=>$returnType,
                                'return_date'=>$returnDate,
                                'end_user_id'=>$endUserId,
                                'local_mineral_code'=>$mineralName,
                                'local_grade_code'=>$gradeName,
                                'registration_no'=>$purchaseRegNo,
                                'quantity'=>$purchaseQuantity,
                                'value'=>$purchaseValue,
                                'activity_status'=>'1',
                                'user_type'=>$userType,
                                'created_at'=>$date,
                                'updated_at'=>$date
                            ));
                            if($extraNSeriesProdActivity->save($newEntityPurchase)){
                                $saveStatus = true;
                            } else {
                                $result = false;
                            }
                            
                        }

                        $import_cnt = $params['import_cnt_' . $y . '_' . $gradeIncreament];
                        for ($m = 0; $m < $import_cnt; $m++) { // for import
                            $impt_cnt = $m + 1;
                            
                            $importCounty = $params['import_country_' . $y . '_' . $gradeIncreament . '_' . $impt_cnt];
                            $importQuantity = $params['import_quantity_' . $y . '_' . $gradeIncreament . '_' . $impt_cnt];
                            $importValue = $params['import_value_' . $y . '_' . $gradeIncreament . '_' . $impt_cnt];
                            $importValue = ($importValue == '') ? 0 : $importValue;

                            $extraNSeriesProdActivity = TableRegistry::getTableLocator()->get('ExtraNSeriesProdActivity');

                            $newEntityImport = $extraNSeriesProdActivity->newEntity(array(
                                'return_type'=>$returnType,
                                'return_date'=>$returnDate,
                                'end_user_id'=>$endUserId,
                                'local_mineral_code'=>$mineralName,
                                'local_grade_code'=>$gradeName,
                                'country_name'=>$importCounty,
                                'quantity'=>$importQuantity,
                                'value'=>$importValue,
                                'activity_status'=>'2',
                                'user_type'=>$userType,
                                'created_at'=>$date,
                                'updated_at'=>$date
                            ));
                            if($extraNSeriesProdActivity->save($newEntityImport)){
                                $saveStatus = true;
                            } else {
                                $result = false;
                            }

                        }

                        //ore dispatch
                        if($sectionNo == 3){
                            
                            $consumeQuantity = $params['consumeQuantity_' . $y . '_' . $gradeIncreament];
                            $consumeValue = $params['consumeValue_' . $y . '_' . $gradeIncreament];
                            $consumeValue = ($consumeValue == '') ? 0 : $consumeValue;

                            $extraNSeriesProdActivity = TableRegistry::getTableLocator()->get('ExtraNSeriesProdActivity');

                            $newEntityCons = $extraNSeriesProdActivity->newEntity(array(
                                'return_type'=>$returnType,
                                'return_date'=>$returnDate,
                                'end_user_id'=>$endUserId,
                                'local_mineral_code'=>$mineralName,
                                'local_grade_code'=>$gradeName,
                                'quantity'=>$consumeQuantity,
                                'value'=>$consumeValue,
                                'activity_status'=>4,
                                'user_type'=>$userType,
                                'created_at'=>$date,
                                'updated_at'=>$date
                            ));
                            if($extraNSeriesProdActivity->save($newEntityCons)){
                                $saveStatus = true;
                            } else {
                                $result = false;
                            }

                        }
    
                        $buyer_cnt = $params['despatch_cnt_' . $y . '_' . $gradeIncreament];
                        for ($n = 0; $n < $buyer_cnt; $n++) {  //for despatch
                            $buy_cnt = $n + 1;
                            
                            $despatchRegNo = $params['buyer_regNo_' . $y . '_' . $gradeIncreament . '_' . $buy_cnt];
                            $despatchQuantity = $params['buyer_quantity_' . $y . '_' . $gradeIncreament . '_' . $buy_cnt];
                            $despatchValue = $params['buyer_value_' . $y . '_' . $gradeIncreament . '_' . $buy_cnt];
                            
                            $extraNSeriesProdActivity = TableRegistry::getTableLocator()->get('ExtraNSeriesProdActivity');

                            $newEntityBuyer = $extraNSeriesProdActivity->newEntity(array(
                                'return_type'=>$returnType,
                                'return_date'=>$returnDate,
                                'end_user_id'=>$endUserId,
                                'local_mineral_code'=>$mineralName,
                                'local_grade_code'=>$gradeName,
                                'registration_no'=>$despatchRegNo,
                                'quantity'=>$despatchQuantity,
                                'value'=>$despatchValue,
                                'activity_status'=>'3',
                                'user_type'=>$userType,
                                'created_at'=>$date,
                                'updated_at'=>$date
                            ));
                            if($extraNSeriesProdActivity->save($newEntityBuyer)){
                                $saveStatus = true;
                            } else {
                                $result = false;
                            }

                        }
                    }
                }

                //insert other activities with NIL values
                /*
                if($saveStatus == true){

                    $formType = $params['fType'];
                    $returnType = $params['return_type'];
                    $returnDate = $params['return_date'];
                    $endUserId = $params['end_user_id'];
                    $userType = $params['user_type'];
                    $sectionNo = $params['section_no'];

                    $userTypeArr = array('T','E','C','S');
                    for($i=0; $i<4; $i++){

                        $otherUserType = $userTypeArr[$i];
                        if($otherUserType != $userType){

                            //mineral
                            $otherMineral = $this->newEntity(array(
                                'form_type'=>$formType,
                                'return_type'=>$returnType,
                                'return_date'=>$returnDate,
                                'end_user_id'=>$endUserId,
                                'user_type'=>$otherUserType,
                                'local_mineral_code'=>'NIL',
                                'local_grade_code'=>'0',
                                'opening_stock'=>'0.000',
                                'closing_stock'=>'0.000',
                                'created_at'=>$date,
                                'updated_at'=>$date
                            ));
                            if($this->save($otherMineral)){
                                //
                            } else {
                                $result = false;
                            }

                            //purchase
                            $extraNSeriesProdActivity = TableRegistry::getTableLocator()->get('ExtraNSeriesProdActivity');

                            $otherPurchase = $extraNSeriesProdActivity->newEntity(array(
                                'return_type'=>$returnType,
                                'return_date'=>$returnDate,
                                'end_user_id'=>$endUserId,
                                'local_mineral_code'=>'NIL',
                                'local_grade_code'=>'0',
                                'registration_no'=>'0',
                                'quantity'=>'0.000',
                                'value'=>'0.00',
                                'activity_status'=>'1',
                                'user_type'=>$otherUserType,
                                'created_at'=>$date,
                                'updated_at'=>$date
                            ));
                            if($extraNSeriesProdActivity->save($otherPurchase)){
                                //
                            } else {
                                $result = false;
                            }

                            //import
                            $otherImport = $extraNSeriesProdActivity->newEntity(array(
                                'return_type'=>$returnType,
                                'return_date'=>$returnDate,
                                'end_user_id'=>$endUserId,
                                'local_mineral_code'=>'NIL',
                                'local_grade_code'=>'0',
                                'country_name'=>'NIL',
                                'quantity'=>'0.000',
                                'value'=>'0.00',
                                'activity_status'=>'2',
                                'user_type'=>$otherUserType,
                                'created_at'=>$date,
                                'updated_at'=>$date
                            ));
                            if($extraNSeriesProdActivity->save($otherImport)){
                                //
                            } else {
                                $result = false;
                            }

                            
                            //ore dispatch
                            if($otherUserType == 'C'){
                                
                                $consumeQuantity = $params['consumeQuantity_' . $y . '_' . $gradeIncreament];
                                $consumeValue = $params['consumeValue_' . $y . '_' . $gradeIncreament];

                                $extraNSeriesProdActivity = TableRegistry::getTableLocator()->get('ExtraNSeriesProdActivity');

                                $otherConsum = $extraNSeriesProdActivity->newEntity(array(
                                    'return_type'=>$returnType,
                                    'return_date'=>$returnDate,
                                    'end_user_id'=>$endUserId,
                                    'local_mineral_code'=>'NIL',
                                    'local_grade_code'=>'0',
                                    'quantity'=>'0.000',
                                    'value'=>'0.00',
                                    'activity_status'=>4,
                                    'user_type'=>$otherUserType,
                                    'created_at'=>$date,
                                    'updated_at'=>$date
                                ));
                                if($extraNSeriesProdActivity->save($otherConsum)){
                                    //
                                } else {
                                    $result = false;
                                }

                            }

                            //despatch
                            $otherBuyer = $extraNSeriesProdActivity->newEntity(array(
                                'return_type'=>$returnType,
                                'return_date'=>$returnDate,
                                'end_user_id'=>$endUserId,
                                'local_mineral_code'=>'NIL',
                                'local_grade_code'=>'0',
                                'registration_no'=>'0',
                                'quantity'=>'0.000',
                                'value'=>'0.00',
                                'activity_status'=>'3',
                                'user_type'=>$otherUserType,
                                'created_at'=>$date,
                                'updated_at'=>$date
                            ));
                            if($extraNSeriesProdActivity->save($otherBuyer)){
                                //
                            } else {
                                $result = false;
                            }


                        }

                    }


                }
                */

			} else {
				$result = false;
			}

			return $result;

        }
        
	    public function postDataValidation($params){
			
			$returnValue = 1;
            
			if(empty($params['fType'])){ $returnValue = null ; }
			if(empty($params['return_type'])){ $returnValue = null ; }
			if(empty($params['return_date'])){ $returnValue = null ; }
			if(empty($params['end_user_id'])){ $returnValue = null ; }
			if(empty($params['user_type'])){ $returnValue = null ; }
			if(empty($params['section_no'])){ $returnValue = null ; }
			if(empty($params['mineral_cnt'])){ $returnValue = null ; }
            
            if($returnValue != null){

                $formType = $params['fType'];
                $returnType = $params['return_type'];
                $returnDate = $params['return_date'];
                $endUserId = $params['end_user_id'];
                $userType = $params['user_type'];
                $sectionNo = $params['section_no'];
                $mineral_cnt = $params['mineral_cnt'];

                for ($y = 1; $y <= $mineral_cnt; $y++) {

                    $grade_count = $params['grade_cnt_' . $y];
                    $mineralName = $params['mineral_' . $y];

                    if(empty($grade_count)){ $returnValue = null ; }
                    if(empty($mineralName)){ $returnValue = null ; }

                    $gradeIncreament = 1;
                    if($returnValue != null){
                        for ($i = 0; $i < $grade_count; $i++) {
                            $gradeIncreament = $i + 1;

                            $gradeName = $params['grade_' . $y . '_' . $gradeIncreament]; // grade name
                            $openingStock = $params['opening_stock_quantity_' . $y . '_' . $gradeIncreament]; // opening stock
                            $closingStock = $params['closing_stock_' . $y . '_' . $gradeIncreament]; // opening stock

                            if(strlen($gradeName) == 0){ $returnValue = null ; }
                            if(strlen($openingStock) == 0){ $returnValue = null ; }
                            if(strlen($closingStock) == 0){ $returnValue = null ; }
                            if(!is_numeric($gradeName)){ $returnValue = null ; }
                            if(!is_numeric($openingStock) && !is_float($openingStock)){ $returnValue = null ; }
                            if(!is_numeric($closingStock) && !is_float($closingStock)){ $returnValue = null ; }
                            
                            $purchase_cnt = $params['purchase_cnt_' . $y . '_' . $gradeIncreament];
                            if(!is_numeric($purchase_cnt)){ $returnValue = null ; }

                            if($returnValue != null){
                                for ($k = 0; $k < $purchase_cnt; $k++) { //for purchase 
                                    $sup_cnt = $k + 1;
                                    
                                    $purchaseRegNo = $params['reg_no_' . $y . '_' . $gradeIncreament . '_' . $sup_cnt];
                                    $purchaseQuantity = $params['supplier_quantity_' . $y . '_' . $gradeIncreament . '_' . $sup_cnt];
                                    $purchaseValue = $params['supplier_value_' . $y . '_' . $gradeIncreament . '_' . $sup_cnt];
                                    
                                    if(strlen($purchaseRegNo) == 0){ $returnValue = null ; }
                                    if(strlen($purchaseQuantity) == 0){ $returnValue = null ; }
                                    if(strlen($purchaseValue) == 0){ $returnValue = null ; }

                                    if(!is_numeric($purchaseQuantity) && !is_float($purchaseQuantity)){ $returnValue = null ; }
                                    if(!is_numeric($purchaseValue) && !is_float($purchaseValue)){ $returnValue = null ; }
                                    
                                }
                            }

                            $import_cnt = $params['import_cnt_' . $y . '_' . $gradeIncreament];
                            if(!is_numeric($import_cnt)){ $returnValue = null ; }

                            if($returnValue != null){
                                for ($m = 0; $m < $import_cnt; $m++) { // for import
                                    $impt_cnt = $m + 1;
                                    
                                    $importCounty = $params['import_country_' . $y . '_' . $gradeIncreament . '_' . $impt_cnt];
                                    $importQuantity = $params['import_quantity_' . $y . '_' . $gradeIncreament . '_' . $impt_cnt];
                                    $importValue = $params['import_value_' . $y . '_' . $gradeIncreament . '_' . $impt_cnt];
                                    
                                    // if(strlen($importCounty) == 0){ $returnValue = null ; }
                                    if(strlen($importQuantity) == 0){ $returnValue = null ; }
                                    // if(strlen($importValue) == 0){ $returnValue = null ; }

                                    if(!is_numeric($importQuantity) && !is_float($importQuantity)){ $returnValue = null ; }
                                    if(!is_numeric($importValue) && !is_float($importValue) && strlen($importValue) != 0){ $returnValue = null ; }

                                }
                            }

                            //ore dispatch
                            if($sectionNo == 3){
                                
                                $consumeQuantity = $params['consumeQuantity_' . $y . '_' . $gradeIncreament];
                                $consumeValue = $params['consumeValue_' . $y . '_' . $gradeIncreament];

                                if(strlen($consumeQuantity) == 0){ $returnValue = null ; }
                                // if(strlen($consumeValue) == 0){ $returnValue = null ; }

                                if(!is_numeric($consumeQuantity) && !is_float($consumeQuantity)){ $returnValue = null ; }
                                if(!is_numeric($consumeValue) && !is_float($consumeValue) && strlen($consumeValue) != 0){ $returnValue = null ; }

                            }

                            $buyer_cnt = $params['despatch_cnt_' . $y . '_' . $gradeIncreament];
                            for ($n = 0; $n < $buyer_cnt; $n++) {  //for despatch
                                $buy_cnt = $n + 1;
                                
                                $despatchRegNo = $params['buyer_regNo_' . $y . '_' . $gradeIncreament . '_' . $buy_cnt];
                                $despatchQuantity = $params['buyer_quantity_' . $y . '_' . $gradeIncreament . '_' . $buy_cnt];
                                $despatchValue = $params['buyer_value_' . $y . '_' . $gradeIncreament . '_' . $buy_cnt];
                                
                                if($sectionNo != 2){
                                    if(strlen($despatchRegNo) == 0){ $returnValue = null ; }
                                }
                                if(strlen($despatchQuantity) == 0){ $returnValue = null ; }
                                if(strlen($despatchValue) == 0){ $returnValue = null ; }

                                if(!is_numeric($despatchQuantity) && !is_float($despatchQuantity)){ $returnValue = null ; }
                                if(!is_numeric($despatchValue) && !is_float($despatchValue)){ $returnValue = null ; }

                            }
                        }
                    }
                }

            }
			
			return $returnValue;
			
		}

        public function checkDBForForSave($formType, $returnType, $returnDate, $endUserId) {

            $result = $this->find('all')
                    ->where(['form_type'=>$formType])
                    ->where(['return_type'=>$returnType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['end_user_id'=>$endUserId])
                    ->count();
        
            return $result;

        }
        
        // check section fill status
        // @addedon 14th JUL 2021 (by Aniket Ganvir)
        public function checkFillStatus($formType, $returnType, $returnDate, $endUserId, $user_type) {

            $result = $this->find()
                    ->where(['form_type'=>$formType])
                    ->where(['return_type'=>$returnType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['end_user_id'=>$endUserId])
                    ->where(['user_type'=>$user_type])
                    ->count();
        
            return $result;

        }
        
        public function getMmsSeriesActivityDetails($formType, $returnType, $returnDate, $endUserId, $userType) {

            $query = $this->find()
                    ->where(['FORM_TYPE'=>$formType])
                    ->where(['RETURN_TYPE'=>$returnType])
                    ->where(['RETURN_DATE'=>$returnDate])
                    ->where(['END_USER_ID'=>$endUserId])
                    ->where(['USER_TYPE'=>$userType])
                    ->toArray();

            return $query;

        }


	} 
?>