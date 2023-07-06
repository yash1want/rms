<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\Datasource\ConnectionManager;
	use Cake\ORM\Locator\LocatorAwareTrait;
	
	class McApplicantDetTable extends Table{

		var $name = "McApplicantDet";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}


		// public function getMineralName($mine_code){
			
		// 	$row_count = $this->find('all',array('conditions'=>array('mine_code'=>$mine_code)))->count();
		// 	if ($row_count > 0) {
		// 		$data = $this->find('all',array('conditions'=>array('mine_code'=>$mine_code)))->first();
		// 		$mineral_name = $data['mineral_name'];
		// 	} else {
		// 		$mineral_name = "--";
		// 	}
			
		// 	return $mineral_name;
			
		// }

		public function findOneByMcuMineCode($parent_id){

			//$result = $this->find('all', array('conditions'=>array('id',$parent_id)))->first();
			$result = $this->find('all', array('conditions'=>array('mcappd_app_id',$parent_id)))->first();
			return $result;

		}

		public function getConsigneeByRegNo($reg_no){

		    $result = $this->find('all')
		            ->where(["mcappd_app_id LIKE"=>"3"])
		            ->toArray();
		    if (count($result) > 0){
		      $data = $result;
		    }
		    else {
		      $data[0] = array();;
		    }

		    return $data;

		}

		public function getConsigneeName($forms_data){

			$reg_no = $forms_data['reg_no'];
			$codeArr = explode('/',$reg_no);
			//print_r($codeArr);die;
			$regNo = (count($codeArr) == 3) ? $codeArr[1] : $reg_no;
			

			$result = $this->find('all')
					->select(["mcappd_fname"])
					->where(["mcappd_app_id"=>$regNo])
					->toArray();

			if(count($result) > 0){
				$consignee_name = $result[0]['mcappd_fname'];
			} else {
				$consignee_name = '';
			}

			return $consignee_name;

		}

		public function getRegNo($forms_data){

			$app_id = $forms_data['app_id'];
			$connection = ConnectionManager::get(Configure::read('conn'));
			$result = $connection->execute("SELECT `mcappd_concession_code` FROM mc_applicant_det WHERE mcappd_app_id LIKE '%".$app_id."%' ORDER BY CASE WHEN mcappd_app_id LIKE '".$app_id."' THEN 1 ELSE 2 END ")->fetchAll('assoc');

			$count = 0;

		    if (count($result) > 0){
				
				$output = '<ul class="list-unstyled">';
			
				foreach($result as $row){
					if(!empty($row['mcappd_concession_code'])){
						$output .= '<li>'.ucwords($row['mcappd_concession_code']).'</li>';
						$count++;
					}
				}

				$output .= '</ul>';

		    }
			
			if($count == 0){
				// $output .= '<li> Registration number not found!</li>';
				$output = '';
			}

		    return $output;

		}


		public function checkConsigneeName($regNo, $consigneeName){

			$records = $this->find('all')
					->where(["mcappd_concession_code IS"=>$regNo])
					->where(["mcappd_fname IS"=>$consigneeName])
					->count();

			if($records > 0){
				return true;
			} else {
				return false;
			}

		}

		public function getFullName($regNo) {

			$reg_no_arr = explode('/', $regNo);
			$reg_no = $reg_no_arr[0];
			$query = $this->find()
					->select(['mcappd_fname', 'mcappd_mname', 'mcappd_lastname'])
					->where(['mcappd_app_id'=>$reg_no])
					->toArray();
	
			$fullName = $query[0]['mcappd_fname'] . " " . $query[0]['mcappd_mname'] . " " . $query[0]["mcappd_lastname"];
			return $fullName;

		}

		public function fetchAllDetailsByAppId($appid) {

			$result = $this->find()
					->select(['mcappd_state', 'mcappd_district', 'mcappd_address1', 'mcappd_address2', 'mcappd_address3', 'mcappd_pincode'])
					->where(['mcappd_app_id'=>$appid])
					->toArray();
				
			if ($result) {
				return $result;
			} else {
				return null;
			}

		}

		
		public function getapplicantDetails() {

			$parent_id = 2;
	
			$query = $this->find()
					->select(['mcappd_pincode', 'mcappd_state', 'mcappd_district'])
					->where(['mcappd_app_id'=>$parent_id])
					->toArray();
					
			if (count($query) < 1){
				return array();
			}
	
			$data['mcappd_pincode'] = $query[0]['mcappd_pincode'];
			$state_code = $query[0]['mcappd_state'];
			$dist_code = $query[0]['mcappd_district'];
	        $dirDistrict = TableRegistry::getTableLocator()->get('DirDistrict');
			$data['region_name'] = $dirDistrict->getRegionNameByDistrictcode($state_code, $dist_code);
			return $data;

		}

		//get applicant details by dql
		public function findByDql($endUserIdBreak){

		    $result = $this->find()
					->select(['mcappd_state', 'mcappd_district', 'mcappd_concession_code', 'mcappd_officer_desig', 'mcappd_pincode'])
		            ->where(["mcappd_app_id"=>$endUserIdBreak])
		            ->toArray();

		    if (count($result) > 0){
		      $data = $result;
		    }
		    else {
		      $data[0] = array();;
		    }

		    return $data;

		}

	} 
?>