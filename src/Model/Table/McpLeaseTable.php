<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\Datasource\ConnectionManager;
    use App\Controller\MonthlyController;
	
	class McpLeaseTable extends Table{

		var $name = "McpLease";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getParticularsDetails($mineCode, $year = "") {

            $query = $this->find()
                    ->enableAutoFields(false)
                    ->where(['mine_code'=>$mineCode]);
            if ($year != "") {
                $query = $query->where(['lease_year'=>$year]);
            } else if ($year == "") {
                $currentYear = date("Y");
                $query = $query->where(['lease_year'=>$currentYear]);
            }
        
            $query = $query->toArray();
            $MonthlyController = new MonthlyController;
    
            $data = array();
            if (count($query) > 0) {
        
                $i = 0;
                foreach ($query as $q) {
        
                    $data[$i]['lease_no'] = $q['lease_no'];
            
                    $data[$i]['under_forest'] = $q['under_forest_area'];
                    $data[$i]['outside_forest'] = $q['outside_forest_area'];
                    $data[$i]['total'] = number_format(round($q['under_forest_area'] + $q['outside_forest_area'], 3), 3);
                    // $data[$i]['execution_date'] = clsCommon::changeDateFormat($q['date_execution']);
                    // $data[$i]['execution_date'] = $MonthlyController->Clscommon->changeDateFormatFromDashToSlash($q['date_execution']);
                    $data[$i]['execution_date'] = (!empty($q['date_execution'])) ? $q['date_execution']->format('Y-m-d') : $q['date_execution'];
                    $data[$i]['lease_period'] = $q['period_lease'];
                    $data[$i]['surface_under_forest'] = $q['surface_under_forest_area'];
                    $data[$i]['surface_outside_forest'] = $q['surface_outside_forest_area'];
                    $data[$i]['surface_rights'] = $q['surface_right_area'];
                    // $data[$i]['renewal_date'] = clsCommon::changeDateFormat($q['date_renewal']);
                    // $data[$i]['renewal_date'] = $MonthlyController->Clscommon->changeDateFormatFromDashToSlash($q['date_renewal']);
                    $data[$i]['renewal_date'] = (!empty($q['date_renewal'])) ? $q['date_renewal']->format('Y-m-d') : $q['date_renewal'];
                    $data[$i]['renewal_period'] = $q['period_renewal'];
                    $data[$i]['lease_info'] = json_decode($q['add_info_lease']);
            
                    $i++;
                }
            } else {

                $data[0]['lease_no'] = null;
                $data[0]['under_forest'] = null;
                $data[0]['outside_forest'] = null;
                $data[0]['total'] = null;
                $data[0]['execution_date'] = null;
                $data[0]['lease_period'] = null;
                $data[0]['surface_under_forest'] = null;
                $data[0]['surface_outside_forest'] = null;
                $data[0]['surface_rights'] = null;
                $data[0]['renewal_date'] = null;
                $data[0]['renewal_period'] = null;
                $data[0]['lease_info'] = json_decode('');

            }

            return $data;
            
        }

        public function getApplicantMinesDetails($mineOwner, $mineCode) {

	        $conn = ConnectionManager::get('default');
			$record = $conn->execute("CALL SP_Proc_GetApplicantMinesDetails('".$mineOwner."', '".$mineCode."')")->fetchAll('assoc');
            return $record;

        }
        
        public function getApplicantAllMinesDetails($mineOwner) {

	        $conn = ConnectionManager::get('default');
			$record = $conn->execute("CALL SP_Proc_GetApplicantAllMinesDetails('".$mineOwner."')")->fetchAll('assoc');
            return $record;

        }

	    public function saveFormDetails($forms_data){

			$dataValidatation = $this->postDataValidation($forms_data);

			if($dataValidatation == 1 ){

	            $mineCode = $forms_data['mine_code'];
                $total_leases = $forms_data['table_count'];
                $currentYear = $forms_data['return_year'];
                
                $this->deleteLeaseRecords($mineCode, $currentYear);
                $result = false;
                
                for ($i = 1; $i <= $total_leases; $i++) {

                    $date = date('Y-m-d H:i:s');
                    
                    $newEntity = $this->newEntity(array(
                        'mine_code'=>$mineCode,
                        'lease_sn'=>$i,
                        'lease_no'=>$forms_data['lease_no_' . $i],
                        'under_forest_area'=>$forms_data['under_forest_' . $i],
                        'outside_forest_area'=>$forms_data['outside_forest_' . $i],
                        // $lease->DATE_EXECUTION = clsCommon::changeDateFormatFromSlashToDash(htmlentities($params['execution_date_' . $i], ENT_QUOTES));
                        'date_execution'=>$forms_data['execution_date_' . $i],
                        'period_lease'=>$forms_data['lease_period_' . $i],
                        'surface_under_forest_area'=>$forms_data['surface_under_forest_' . $i],
                        'surface_outside_forest_area'=>$forms_data['surface_outside_forest_' . $i],
                        'surface_right_area'=>$forms_data['surface_total_' . $i],
                        // $lease->DATE_RENEWAL = clsCommon::changeDateFormatFromSlashToDash(htmlentities($params['renewal_date_' . $i], ENT_QUOTES));
                        'date_renewal'=>$forms_data['renewal_date_' . $i],
                        'period_renewal'=>$forms_data['renewal_period_' . $i],
                        'add_info_lease'=>json_encode($forms_data['add_info_lease']),
                        'lease_year'=>$currentYear,
                        'created_at'=>$date,
                        'updated_at'=>$date
                    ));
                
                    if($this->save($newEntity)){
                        $result = 1;
                    } else {
                        $result = false;
                    }
                    
                }

                return $result;

			} else {
				return false;
			}

	    }

	    public function postDataValidation($forms_data){
			
			$returnValue = 1;
			
			if(empty($forms_data['mine_code'])){ $returnValue = null ; }
			if(empty($forms_data['table_count'])){ $returnValue = null ; }
			if(empty($forms_data['return_year'])){ $returnValue = null ; }

			if(!is_numeric($forms_data['table_count'])){ $returnValue = null ; }
            
            $total_leases = $forms_data['table_count'];
            
            for ($i = 1; $i <= $total_leases; $i++) {
                
			    if($forms_data['lease_no_' . $i] == ''){ $returnValue = null ; }
			    if($forms_data['under_forest_' . $i] == ''){ $returnValue = null ; }
			    if($forms_data['outside_forest_' . $i] == ''){ $returnValue = null ; }
			    if($forms_data['total_' . $i] == ''){ $returnValue = null ; }
			    if($forms_data['surface_under_forest_' . $i] == ''){ $returnValue = null ; }
			    if($forms_data['surface_outside_forest_' . $i] == ''){ $returnValue = null ; }
			    if($forms_data['surface_total_' . $i] == ''){ $returnValue = null ; }
			    if($forms_data['renewal_period_' . $i] == ''){ $returnValue = null ; }

			    if(!is_numeric($forms_data['under_forest_' . $i])){ $returnValue = null ; }
			    if(!is_numeric($forms_data['outside_forest_' . $i])){ $returnValue = null ; }
			    if(!is_numeric($forms_data['total_' . $i])){ $returnValue = null ; }
			    if(!is_numeric($forms_data['surface_under_forest_' . $i])){ $returnValue = null ; }
			    if(!is_numeric($forms_data['surface_outside_forest_' . $i])){ $returnValue = null ; }
			    if(!is_numeric($forms_data['surface_total_' . $i])){ $returnValue = null ; }

			    if($forms_data['lease_period_' . $i] != ''){
                    if(!is_numeric($forms_data['lease_period_' . $i])){ $returnValue = null ; }
                    if($forms_data['lease_period_' . $i] > 99){ $returnValue = null ; }
                }

			    if(strlen(round($forms_data['under_forest_' . $i], 3)) > '9'){ $returnValue = null ; }
			    if(strlen(round($forms_data['outside_forest_' . $i], 3)) > '9'){ $returnValue = null ; }
			    if(strlen(round($forms_data['surface_under_forest_' . $i], 3)) > '9'){ $returnValue = null ; }
			    if(strlen(round($forms_data['surface_total_' . $i], 3)) > '9'){ $returnValue = null ; }
                
			    if($forms_data['execution_date_' . $i] != ''){
                    $execution_date = $forms_data['execution_date_' . $i];
                    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $execution_date)) {
                        //validate date range
                        // $returnValue = null ;
                    } else {
                        $returnValue = null ;
                    }
                }
                
			    if($forms_data['renewal_date_' . $i] != ''){
                    $renewal_date = $forms_data['renewal_date_' . $i];
                    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $renewal_date)) {
                        //validate date range
                        // $returnValue = null ;
                    } else {
                        $returnValue = null ;
                    }
                }

                //check total of area under lease
                $total_forest_area = round($forms_data['under_forest_' . $i] + $forms_data['outside_forest_' . $i], 3);
                $total_forest_area_entered = round($forms_data['total_' . $i], 3);
                if($total_forest_area != $total_forest_area_entered) {
                    $returnValue = null ;
                }
                
                //check total of area for surface rights
                $total_surface_forest_area = round($forms_data['surface_under_forest_' . $i] + $forms_data['surface_outside_forest_' . $i], 3);
                $total_surface_forest_area_entered = round($forms_data['surface_total_' . $i], 3);
                if($total_surface_forest_area != $total_surface_forest_area_entered) {
                    $returnValue = null ;
                }
                
            }
			
			return $returnValue;
			
		}

        public function deleteLeaseRecords($mineCode, $leaseYear) {

            $query = $this->query();
            $query->delete()
                ->where(['mine_code'=>$mineCode])
                ->where(['lease_year'=>$leaseYear])
                ->execute();
        
            if ($query) {
                return true;
            } else {
                return false;
            }

        }

		/*
		 * Added one more parameter returnDate for validation with Lease_Year. Earlier it was being compared with 'CurrentYear' resulting in issue.
		 * Author : Naveen Jha naveenj@ubicsindia.com
		 * Date : 17th Jan 2015
		 */
        public function particularAnnualCheck($mineCode, $returnDate) {

            // $currentYear = date("Y");
            $temp = explode('-', $returnDate);
            $currentYear = $temp[0];
        
            $dataCount = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['lease_year'=>$currentYear])
                ->count();
            
            if ($dataCount > 0) {
                return 0;
            } else {
                return 1;
            }

        }

	} 
?>