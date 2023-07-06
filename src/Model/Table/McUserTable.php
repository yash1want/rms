<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class McUserTable extends Table{
		
		var $name = "McUser";			
		public $validate = array();

		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function getUserDatabyId($userId){			
			$data = $this->find('all',array('conditions'=>array('mcu_child_user_name'=>$userId)))->first();
			return $data;
		}

		public function getUserByEmail($user_name, $email){

			$row_count = $this->find('all',array('conditions'=>array('mcu_child_user_name'=>$user_name, 'mcu_email'=>$email)))->count();

			if ($row_count > 0) {
				$data = $this->find('all',array('conditions'=>array('mcu_child_user_name'=>$user_name, 'mcu_email'=>$email)))->first();
				$result = $data['mcu_user_id'];
			} else {
				$result = 0;
			}
			
			return $result;
		}

		public function findOneByMcuMineCode($mineCode){

			$result = $this->find('all')
					->where(['mcu_mine_code'=>$mineCode])
					->first();
			return $result;

		}

	    /**
	     * updates the time when user logs out
	     * @param type $mcu_user_id 
	     */
	    public function updateLastLogin($mcu_user_id) {

			$query = $this->query();
			$query->update()
				->set(array('mcu_last_login'=>time()))
				->where(array('mcu_child_user_name'=>$mcu_user_id))
				->execute();

	    }

	    /**
	     * update user logout time in logs when user logs out
		 * @param type $session_token
	     * added on 09-10-2020 by Aniket Ganvir
	     */
		public function updateUserLog($session_token) {

			$current_time = date('Y-m-d H:i:s');
			$mcUserLog = TableRegistry::getTableLocator()->get('McUserLog');
			$query = $mcUserLog->query();
			$query->update()
				->set(array('logout_time'=>$current_time, 'status'=>'FULL'))
				->where(array('session_token'=>$session_token))
				->execute();

		}

		public function getAppIdWithRegNo($applicant_name) {

			$conn = ConnectionManager::get(Configure::read('conn'));
			$q = $conn->execute("SELECT
							AD.mcappd_concession_code FROM MC_USER MC                        
							INNER JOIN MC_APPLICANT_DET AD ON MC.mcu_parent_app_id = AD.mcappd_app_id
							WHERE mcu_child_user_name = '".$applicant_name."' LIMIT 0,1");
	
			$records = $q->fetchAll();

			if ($records){
				// return $records[0]['mcappd_concession_code'];
				return $records[0][0];
			} else {
				return false;
			}
		}

		public function getActivityType($user_id){

			$conn = ConnectionManager::get(Configure::read('conn'));
			$query = $conn->execute("SELECT mcu_activity  FROM MC_USER 
							WHERE mcu_child_user_name = '".$user_id."' LIMIT 0,1");
			$records = $query->fetchAll();
			return $records[0][0];
		}

		public function getMCNameDesi($mine_code, $return_date = null, $return_type = null, $user_type = null, $user_name = null) {

			if ($user_type == 'authuser' && !empty($user_name)){

				$query = $this->find()
						->select(['mcu_first_name','mcu_middle_name','mcu_last_name','mcu_designation'])
						->where(['mcu_child_user_name'=>$user_name])
						->toArray();

			} else {

				if(!empty($return_date)){

					$TblFinalSubmit = TableRegistry::getTableLocator()->get('TblFinalSubmit');
					$submitData = $TblFinalSubmit->find()
							->select(['applicant_id'])
							->where(['return_date'=>$return_date, 'return_type'=>$return_type, 'mine_code'=>$mine_code, 'is_latest'=>1])
							->toArray();
	
					if (count($submitData) > 0){
	
						$user_name = $submitData[0]['applicant_id'];
						$query = $this->find()
								->select(['mcu_first_name','mcu_middle_name','mcu_last_name','mcu_designation'])
								->where(['mcu_child_user_name'=>$user_name])
								->toArray();
					} else {
	
						$query = $this->find()
						->select(['mcu_first_name','mcu_middle_name','mcu_last_name','mcu_designation'])
						->where(['mcu_mine_code'=>$mine_code])
						->toArray();
	
					}

				} else {
	
					$query = $this->find()
					->select(['mcu_first_name','mcu_middle_name','mcu_last_name','mcu_designation'])
					->where(['mcu_mine_code'=>$mine_code])
					->toArray();

				}

			}
				
			$msu_data['Name'] = $query[0]['mcu_first_name']." ".$query[0]['mcu_middle_name']." ".$query[0]['mcu_last_name'];
			$msu_data['desi'] = $query[0]['mcu_designation'];
	
			return $msu_data;
		}

		/**
		 * MAINTAIN USER PASSWORD HISTORY LOG
		 * THROUGH RESET PASSWORD LINK
		 */
		public function maintainPasswordLogWithResetlink($resetLink, $password, $userType) {
			
			$userName = $this->getUsernameByResetlink($resetLink);
			
			$this->maintainPasswordLog($userName, $password, $userType);
			
		}
		
		/**
		 * EXTRACT USERNAME FROM RESET LINK
		 */
		public function getUsernameByResetlink($resetLink) {
			
			$splitLink = explode("-", $resetLink);
			$splitLinkCount = count($splitLink);
			$passwordSent = $splitLink[$splitLinkCount - 1]; // MATCH THIS WITH DB PASSWORD
			// ALL THE DATA REQUIRED TO FIND RECORDS IN DB
			$encryptedUserName = str_replace("-" . $passwordSent, "", $resetLink);
			$userName = str_replace("-", "/", str_rot13(strrev($encryptedUserName))); // USER NAME TO FIND RECORD
			
			/**
			 * Added for solving J&K issue, catch the username and checking if % is there 
			 * as we are sending % in place of & and replacing it back to & for futher processing
			 * @author Naveen Jha <naveenj@ubicsindia.com>
			 * @version 19th July 2016
			 */
			if(strpos($userName, '%') != FALSE){
				$userName = str_replace('%', '&', $userName);
			}else{
				$userName = $userName;
			}
			
			return $userName;
		}

		/**
		 * MAINTAIN PASSWORD HISTORY LOGS
		 * for security audit
		 * 
		 * @version 29-03-2022
		 * @author Aniket Ganvir
		 */
		public function maintainPasswordLog($username, $password, $userType) {
			
			$PasswordHistory = TableRegistry::getTableLocator()->get('PasswordHistory');
			$created = date('Y-m-d H:i:s');
			
			$newEntity = $PasswordHistory->newEntity(array(
				'username'=>$username,
				'user_type'=>$userType,
				'password'=>$password,
				'created'=>$created
			));
			$PasswordHistory->save($newEntity);
			
		}

	} 
?>