<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class MmsUserTestTable extends Table{
		
		var $name = "MmsUserTest";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		//get user details by user name
		public function getUserDatabyId($userId){			
			$data = $this->find('all',array('conditions'=>array('user_name'=>$userId)))->first();
			return $data;
		}

		// get user details by email	
		public function getUserByEmail($user_name, $email){			

			$row_count = $this->find('all',array('conditions'=>array('user_name'=>$user_name, 'email'=>$email)))->count();

			if ($row_count > 0) {
				$data = $this->find('all',array('conditions'=>array('user_name'=>$user_name, 'email'=>$email)))->first();
				$result = $data['id'];
			} else {
				$result = 0;
			}
			
			return $result;
		}

		// get mms user data by user id
		public function findOneById($userId){			
			$data = $this->find('all',array('conditions'=>array('id'=>$userId)))->first();
			return $data;
		}

		//get list of user by role id
		public function getUserListByRole($roleid){

			$data = $this->find('all',array('fields'=>array('id','first_name','last_name','user_name'),
												'conditions'=>array('is_delete IS'=>0,'role_id IS'=>'2')))
											->order('first_name')
											->toArray();

			foreach($data as $eachUser){ 
				$name = $eachUser['first_name'].' '.$eachUser['last_name'].'('.$eachUser['user_name'].')';
				$userList[$eachUser['id']] = $name;               
			}
			
			return $userList;
		}

		// Add and update the user details
		public function saveUserDetails($formsData){			

			$zoneid = null;
			$regionid = null;
			$parentuser = 0;

			$first_name = htmlentities($formsData['first_name'], ENT_QUOTES);
			$mid_name = htmlentities($formsData['mid_name'], ENT_QUOTES);
			$last_name = htmlentities($formsData['last_name'], ENT_QUOTES);
			$email = htmlentities($formsData['email'], ENT_QUOTES);
			$alt_email = htmlentities($formsData['email_alts'], ENT_QUOTES);
			$mobile = htmlentities($formsData['mobile'], ENT_QUOTES);
			$phone = htmlentities($formsData['phone'], ENT_QUOTES);
			$designation = htmlentities($formsData['designation'], ENT_QUOTES);
			//$user_image = htmlentities($formsData['user_image'], ENT_QUOTES);
			$state_code = htmlentities($formsData['state_code'], ENT_QUOTES);
			$district_id = htmlentities($formsData['district_id'], ENT_QUOTES);
			$user_name = htmlentities($formsData['user_name'], ENT_QUOTES);
			$role_id = htmlentities($formsData['role_id'], ENT_QUOTES);
			
			$userRoles = ['2','3','5','6','8','9'];
			
			if(in_array($role_id,$userRoles)){

				$parentuser = htmlentities($formsData['parentuser'], ENT_QUOTES);

				if($role_id == 5){
					$zoneid = htmlentities($formsData['zoneregion'], ENT_QUOTES);
				}elseif($role_id == 5){
					$regionid = htmlentities($formsData['zoneregion'], ENT_QUOTES);
				}				
			}

			$newEntity = $this->newEntity(array(
				'id'=>$formsData['id'],
				'first_name'=>$first_name,
				'mid_name'=>$mid_name,
				'last_name'=>$last_name,
				'email'=>$email,
				'thxe'=>'roa',
				'mobile'=>$mobile,
				'phone'=>$phone,
				'designation'=>$designation,
				'user_image'=>$user_image,
				'state_code'=>$state_code,
				'district_id'=>$district_id,
				'user_name'=>$user_name,
				'role_id'=>$role_id,
				'parent_id'=>$parentuser,				
				'zone_id'=>$zoneid,
				'region_id'=>$regionid,
				'created_at'=>$formsData['created_at'],
				'updated_at'=>date('Y-m-d H:i:s')
			));
			//exit;
			//print_r($newEntity); exit;
			if($this->save($newEntity)){
				return 1;
			} else {
				return false;
			}
			
		}

	} 
?>