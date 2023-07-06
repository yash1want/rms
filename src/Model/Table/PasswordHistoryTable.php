<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\Datasource\ConnectionManager;
	
	class PasswordHistoryTable extends Table{

		var $name = "PasswordHistory";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function savePasswordLogs($username,$password,$userType){

			date_default_timezone_set('Asia/Kolkata');

			if($userType == 'authuser'){
				$userType = 'auth';
			} elseif ($userType == 'enduser') {
				$userType = 'end';
			} elseif ($userType == 'mmsuser') {
				$userType = 'mms';
			}

			$newEntity = $this->newEntity(array(
				'username'=>$username,
				'user_type'=>$userType,
				'password'=>$password,
				'created'=>date('Y-m-d H:i:s')
			));
			if ($this->save($newEntity)){ return true;  }

			
			//$this->Authentication->userActionPerformLog("Password Changed","Success");
		}


		public function checkPastThreePassword($username, $password,$userType) {

			$result = "empty";
		
			if($userType == 'authuser'){
				$userType = 'auth';
			} elseif ($userType == 'enduser') {
				$userType = 'end';
			} elseif ($userType == 'mmsuser') {
				$userType = 'mms';
			}
			
			$lastThreePassword = $this->find('all', array('conditions' => array('username'=>$username, 'user_type IS'=>$userType), 'order' => 'id DESC', 'limit' => '3'))->toArray();

			foreach ($lastThreePassword as $passwordLog) {
				$passwordInDb = $passwordLog['password'];
					
				if ($password == $passwordInDb) {
					
					$result = 'found';
				}
			}
				
			return $result;
			exit;
		}
	} 
?>