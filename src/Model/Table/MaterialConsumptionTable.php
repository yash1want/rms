<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use App\Controller\MonthlyController;
	
	class MaterialConsumptionTable extends Table{

		var $name = "MaterialConsumption";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}
        
        public function getMatConsDetails($mineCode, $returnDate) {

            $mc = $this->find()
                    ->where(['mine_code'=>$mineCode])
                    ->where(['return_date'=>$returnDate])
                    ->where(['return_type'=>"ANNUAL"])
                    ->toArray();

            $data = array();
            $MonthlyController = new MonthlyController;
            $keys = $MonthlyController->Clscommon->getMaterialConQtyKeys();
            if (count($mc) > 0) {
                for ($i = 0; $i < 15; $i++) {
                    if (isset($keys[$i]['qty'])) {
                        $data[$keys[$i]['qty']] = $mc[$i]['material_quantity'];
                    }
                    $data[$keys[$i]['value']] = $mc[$i]['material_value'];
                }
            } else {
                for ($i = 0; $i < 15; $i++) {
                    if (isset($keys[$i]['qty'])) {
                        $data[$keys[$i]['qty']] = '';
                    }
                    $data[$keys[$i]['value']] = '';
                }
            }

            return $data;

        }
        
        public function explosiveCheckForPart4($mineCode, $returnType, $returnDate) {

            $query = $this->find()
                ->where(['material_sn'=>14])
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->toArray();

            /**
             * 0 -> DATA IS IN DB AND VALUE IS GREATER THEN 0 AND NOT NULL
             * 1 -> DATA NOT IN DB
             */
            if (count($query) > 0) {
                $explMaterialValue = $query[0]['material_value'];
                if ($explMaterialValue > 0) {
                    return 0;
                }
                else {
                    return 1;
                }
            }
            else {
                return 1;
            }

        }

        public function deleteAnnualRecords($mineCode, $returnDate) {

            $query = $this->query();
            $query->delete()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_date'=>$returnDate])
                ->where(['return_type'=>"ANNUAL"])
                ->execute();

        }
        
	    public function saveFormData($params){

			$postData = $this->postDataValidate($params);

			if ($postData['data_status'] == 1) {

	            $mineCode = $postData['mine_code'];
                $returnDate = $postData['return_date'];
                $returnType = $postData['return_type'];
				
                $result = 1;
				$date = date('Y-m-d H:i:s');
                
	            $MonthlyCntrl = new MonthlyController;
                
                $this->deleteAnnualRecords($mineCode, $returnDate);
                $material_sn = array(2, 3, 4, 5, 6, 8, 9, 11, 12, 13, 14, 15, 16, 17, 18);
                $keys = $MonthlyCntrl->Clscommon->getMaterialConQtyKeys();
				
                for ($i = 0; $i < 15; $i++) {

                    $newEntity = $this->newEntity(array(
                        'mine_code' => $mineCode,
                        'return_type' => 'ANNUAL',
                        'return_date' => $returnDate,
                        'material_sn' => $material_sn[$i],
                        'material_quantity' => $postData[$keys[$i]['qty']],
                        'material_value' => $postData[$keys[$i]['value']],
                        'created_at' => $date,
                        'updated_at' => $date
                    ));
                
                    if ($this->save($newEntity)) {
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

	    public function postDataValidate($params){
			
			$dataStatus = 1;
			
			if(empty($params['mine_code'])){ $dataStatus = null ; }
			if(empty($params['return_date'])){ $dataStatus = null ; }
			if(empty($params['return_type'])){ $dataStatus = null ; }
			
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;
            $keys = $MonthlyCntrl->Clscommon->getMaterialConQtyKeys();

            for ($i = 0; $i < 15; $i++) {
                
                if (isset($keys[$i]['qty'])) {

                    $material_quantity = $params[$keys[$i]['qty']];
                    if ($material_quantity != '') {
                        $dataStatus = ($validate->numeric($material_quantity) == false) ? null : $dataStatus;
                        $dataStatus = ($validate->maxLen($material_quantity, 10) == false) ? null : $dataStatus;
                    } else { $dataStatus = null ; }

                }
                
                $material_value = $params[$keys[$i]['value']];
                if ($material_value != '') {
                    $dataStatus = ($validate->numeric($material_value) == false) ? null : $dataStatus;
                    $dataStatus = ($validate->maxLen($material_value, 12) == false) ? null : $dataStatus;
                } else {
                    if (in_array($keys[$i]['value'], array('TIMBER_VALUE', 'OTHER_VALUE'))) {
                        $params[$keys[$i]['value']] = 0;
                    } else {
                        $dataStatus = null ;
                    }
                }
            
            }

            $params['data_status'] = $dataStatus;
            return $params;
			
		}

		/**
		 * Check filled status of section
		 * @version 29th Oct 2021
		 * @author Aniket Ganvir
		 */
		public function isFilled($mineCode, $returnDate) {
            
            $records = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_date'=>$returnDate])
                ->where(['return_type'=>"ANNUAL"])
                ->count();

            if ($records > 0) {
                return true;
            } else {
                return false;
            }

		}

        public function materialQuantityAnnualCheck($mineCode, $returnDate, $returnType) {

            $query = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_date'=>$returnDate])
                ->where(['return_type'=>$returnType])
                ->count();
        
            if ($query > 0)
              return 0;
            else
              return 1;
              
        }


	} 
?>