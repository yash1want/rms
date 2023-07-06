<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use App\Controller\MonthlyController;
	
	class LeaseReturnTable extends Table{

		var $name = "LeaseReturn";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getLeaseDetails($mineCode, $returnDate) {

            $query = $this->find()
                    ->where(['mine_code'=>$mineCode])
                    ->where(['return_date'=>$returnDate])
                    ->where(['return_type'=>'ANNUAL'])
                    ->toArray();

            $data = array();
            if (count($query) > 0) {
                $data['FOREST_ABANDONED_AREA'] = $query[0]['forest_abandoned_area'];
                $data['NON_FOREST_ABANDONED_AREA'] = $query[0]['non_forest_abandoned_area'];
                $data['TOTAL_ABANDONED_AREA'] = $query[0]['total_abandoned_area'];
                $data['FOREST_WORKING_AREA'] = $query[0]['forest_working_area'];
                $data['NON_FOREST_WORKING_AREA'] = $query[0]['non_forest_working_area'];
                $data['TOTAL_WORKING_AREA'] = $query[0]['total_working_area'];
                $data['FOREST_RECLAIMED_AREA'] = $query[0]['forest_reclaimed_area'];
                $data['NON_FOREST_RECLAIMED_AREA'] = $query[0]['non_forest_reclaimed_area'];
                $data['TOTAL_RECLAIMED_AREA'] = $query[0]['total_reclaimed_area'];
                $data['FOREST_WASTE_AREA'] = $query[0]['forest_waste_area'];
                $data['NON_FOREST_WASTE_AREA'] = $query[0]['non_forest_waste_area'];
                $data['TOTAL_WASTE_AREA'] = $query[0]['total_waste_area'];
                $data['FOREST_BUILDING_AREA'] = $query[0]['forest_building_area'];
                $data['NON_FOREST_BUILDING_AREA'] = $query[0]['non_forest_building_area'];
                $data['TOTAL_BUILDING_AREA'] = $query[0]['total_building_area'];
                $data['OTHER_PURPOSE'] = $query[0]['other_purpose'];
                $data['FOREST_OTHER_AREA'] = $query[0]['forest_other_area'];
                $data['NON_FOREST_OTHER_AREA'] = $query[0]['non_forest_other_area'];
                $data['TOTAL_OTHER_AREA'] = $query[0]['total_other_area'];
                $data['FOREST_PROGRESSIVE_AREA'] = $query[0]['forest_progressive_area'];
                $data['NON_FOREST_PROGRESSIVE_AREA'] = $query[0]['non_forest_progressive_area'];
                $data['TOTAL_PROGRESSIVE_AREA'] = $query[0]['total_progressive_area'];
                
	            $MonthlyController = new MonthlyController;
                $agencyChoices = $MonthlyController->Clscommon->leaseAreaAgencyOptions();
                $data['AGENCY'] = $agencyChoices[$query[0]['agency']];
            }

            return $data;

        }

        public function getLeaseObj($mineCode, $returnDate) {

            $obj = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_date'=>$returnDate])
                ->where(['return_type'=>'ANNUAL'])
                ->first();
        
            return $obj;

        }
        
	    public function saveFormDetails($params){

			$dataValidatation = $this->postDataValidation($params);

			if($dataValidatation == 1 ){

	            $mineCode = $params['mine_code'];
                $returnDate = $params['return_date'];

                $date = date('Y-m-d H:i:s');

                $leaseData = $this->getLeaseId($mineCode, $returnDate);
                if ($leaseData['id'] != '') {
                    $id = $leaseData['id'];
                    // $lease_mine_code = $leaseData['lease_mine_code'];
                    $created_at = $leaseData['created_at'];
                } else {
                    $id = '';
                    // $lease_mine_code = null;
                    $created_at = $date;
                }
                
                $result = false;
                
                
                $newEntity = $this->newEntity(array(
                    'id' => $id,
                    'mine_code' => $mineCode,
                    'return_date' => $returnDate,
                    'return_type' => 'ANNUAL',
                    'lease_sn' => 0,
                    // 'lease_mine_code' => $lease_mine_code,
                    'forest_abandoned_area' => $params['FOREST_ABANDONED_AREA'],
                    'non_forest_abandoned_area' => $params['NON_FOREST_ABANDONED_AREA'],
                    'total_abandoned_area' => $params['TOTAL_ABANDONED_AREA'],
                    'forest_working_area' => $params['FOREST_WORKING_AREA'],
                    'non_forest_working_area' => $params['NON_FOREST_WORKING_AREA'],
                    'total_working_area' => $params['TOTAL_WORKING_AREA'],
                    'forest_reclaimed_area' => $params['FOREST_RECLAIMED_AREA'],
                    'non_forest_reclaimed_area' => $params['NON_FOREST_RECLAIMED_AREA'],
                    'total_reclaimed_area' => $params['TOTAL_RECLAIMED_AREA'],
                    'forest_waste_area' => $params['FOREST_WASTE_AREA'],
                    'non_forest_waste_area' => $params['NON_FOREST_WASTE_AREA'],
                    'total_waste_area' => $params['TOTAL_WASTE_AREA'],
                    'forest_building_area' => $params['FOREST_BUILDING_AREA'],
                    'non_forest_building_area' => $params['NON_FOREST_BUILDING_AREA'],
                    'total_building_area' => $params['TOTAL_BUILDING_AREA'],
                    'other_purpose' => $params['OTHER_PURPOSE'],
                    'forest_other_area' => $params['FOREST_OTHER_AREA'],
                    'non_forest_other_area' => $params['NON_FOREST_OTHER_AREA'],
                    'total_other_area' => $params['TOTAL_OTHER_AREA'],
                    'forest_progressive_area' => $params['FOREST_PROGRESSIVE_AREA'],
                    'non_forest_progressive_area' => $params['NON_FOREST_PROGRESSIVE_AREA'],
                    'total_progressive_area' => $params['TOTAL_PROGRESSIVE_AREA'],
                    'agency' => $params['AGENCY'],
                    'created_at' => $created_at,
                    'updated_at' => $date
                ));
            
                if($this->save($newEntity)){
                    $result = 1;
                } else {
                    $result = false;
                }

                return $result;

			} else {
				return false;
			}

	    }

	    public function postDataValidation($params){
			
			$returnValue = 1;
            $MonthlyCntrl = new MonthlyController;
            $validate = $MonthlyCntrl->Validate;
			
			if(empty($params['mine_code'])){ $returnValue = null ; }
			if(empty($params['return_year'])){ $returnValue = null ; }
			if(empty($params['return_date'])){ $returnValue = null ; }
            
            if ($validate->chkFloatCharac($params['FOREST_ABANDONED_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['NON_FOREST_ABANDONED_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['TOTAL_ABANDONED_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['FOREST_WORKING_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['NON_FOREST_WORKING_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['TOTAL_WORKING_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['FOREST_RECLAIMED_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['NON_FOREST_RECLAIMED_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['TOTAL_RECLAIMED_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['FOREST_WASTE_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['NON_FOREST_WASTE_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['TOTAL_WASTE_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['FOREST_BUILDING_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['NON_FOREST_BUILDING_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['TOTAL_BUILDING_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['FOREST_OTHER_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['NON_FOREST_OTHER_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['TOTAL_OTHER_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['FOREST_PROGRESSIVE_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['NON_FOREST_PROGRESSIVE_AREA'], 3, 9) == false) { $returnValue = null ; }
            if ($validate->chkFloatCharac($params['TOTAL_PROGRESSIVE_AREA'], 3, 9) == false) { $returnValue = null ; }
            
            if($params['AGENCY'] == ''){ $returnValue = null ; }

            //validate other purpose
            $forestArea1 = $params['FOREST_OTHER_AREA'];
            $forestArea2 = $params['NON_FOREST_OTHER_AREA'];
            $forestArea3 = $params['TOTAL_OTHER_AREA'];
            //need to review with phase 1 project 
            /*if (($forestArea1 != '' && $forestArea1 != '0.000') || ($forestArea2 != '' && $forestArea2 != '0.000') || ($forestArea3 != '' && $forestArea3 != '0.000')) {
                $returnValue = null ;
            }*/
			
			return $returnValue;
			
		}

        
        public function getLeaseId($mineCode, $returnDate) {

            $data = $this->find()
                ->select(['id', 'created_at', 'lease_mine_code'])
                ->where(['mine_code'=>$mineCode])
                ->where(['return_date'=>$returnDate])
                ->where(['return_type'=>'ANNUAL'])
                ->toArray();

            if (count($data) > 0) {
                return $data[0];
            } else {
                $data = array();
                $data[0]['id'] = '';
                return $data;
            }

        }
        
        /**
         * RETURN LEASE DATA ARRAY (RETURN BLANK ARRAY IN CASE OF NO RECORD FOUND)
         * 
         * @param type $mineCode
         * @param type $returnDate
         * @version 04th OCT 2021
         * @author Aniket Ganvir
         */
        public function getLeaseData($mineCode, $returnDate) {

            $lease = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_date'=>$returnDate])
                ->where(['return_type'=>'ANNUAL'])
                ->toArray();

            if (count($lease) > 0) {
                $data = $lease[0];
            } else {
                $data = array();
                $data['forest_abandoned_area'] = '';
                $data['non_forest_abandoned_area'] = '';
                $data['total_abandoned_area'] = '';
                $data['forest_working_area'] = '';
                $data['non_forest_working_area'] = '';
                $data['total_working_area'] = '';
                $data['forest_reclaimed_area'] = '';
                $data['non_forest_reclaimed_area'] = '';
                $data['total_reclaimed_area'] = '';
                $data['forest_waste_area'] = '';
                $data['non_forest_waste_area'] = '';
                $data['total_waste_area'] = '';
                $data['forest_building_area'] = '';
                $data['non_forest_building_area'] = '';
                $data['total_building_area'] = '';
                $data['other_purpose'] = '';
                $data['forest_other_area'] = '';
                $data['non_forest_other_area'] = '';
                $data['total_other_area'] = '';
                $data['forest_progressive_area'] = '';
                $data['non_forest_progressive_area'] = '';
                $data['total_progressive_area'] = '';
                $data['agency'] = '';
            }

            return $data;

        }
        
        public function lesseeCheck($mineCode, $returnDate) {

            $dataCount = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_date'=>$returnDate])
                ->where(['return_type'=>'ANNUAL'])
                ->count();

            if ($dataCount > 0){
                return 0;
            } else {
                return 1;
            }

        }


	} 
?>