<?php	

	//To access the properties of main controller used initialize function.

	namespace app\Controller\Component;
	use Cake\Controller\Controller;
	use Cake\Controller\Component;
	
	use Cake\Controller\ComponentRegistry;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	use Cake\Datasource\EntityInterface;
	use Cake\Utility\Security;
	use SimpleXMLElement;
	
	class AuthenticationComponent extends Component {
	
		
		public $components= array('Session');
		public $controller = null;
		public $session = null;

		public function initialize(array $config): void {
			parent::initialize($config);
			$this->Controller = $this->_registry->getController();
			// $this->controller->set('AuthenticationComponent', new AuthenticationComponent());
			$this->Session = $this->getController()->getRequest()->getSession();
		}
		
		public function loginuser($username,$password,$userType){
			
			$loginusertype = $this->Session->read('loginusertype');
			$randSalt = $this->Session->read('tkn');
			$last_24_hour = date('Y-m-d H:i:s', strtotime('-10 minutes'));
			$result = null;
			$dbPassword = null;
			$user_id = null;
			$user_name = null;
            	
			$McUser = TableRegistry::getTableLocator()->get('McUser');
			$McUserLog = TableRegistry::getTableLocator()->get('McUserLog');
			$MmsUser = TableRegistry::getTableLocator()->get('MmsUser');
			$MmsUserLog = TableRegistry::getTableLocator()->get('MmsUserLog');

			if($loginusertype == 'primaryuser')
			{

				
				$userData = $McUser->find('all', array('conditions'=> array('mcu_user IS' => base64_decode($username))))->first();
				if(!empty($userData)){
					$dbPassword = $userData['mcu_sha_password'];
					$user_name = $userData['mcu_user'];
					$user_id = $userData['mcu_user_id'];
				}

				$records = $McUserLog->find('all', array('conditions'=> array('uname' => trim(base64_decode($username)),'login_time > '=>$last_24_hour,
														 'status !='=>'LOCKED'),'order'=>array('id desc'),'limit'=>3))->toArray();	

			}elseif($loginusertype == 'authuser' || $loginusertype == 'enduser'){

								
				$userData = $McUser->find('all', array('conditions'=> array('mcu_child_user_name IS' => base64_decode($username),'is_deleted IS'=>'no')))->first();
			// print_r($userData);die;
					
				if(!empty($userData)){
					$dbPassword = $userData['mcu_sha_password'];
					$user_name = $userData['mcu_child_user_name'];
					$user_id = $userData['mcu_user_id'];
				}	

				$records = $McUserLog->find('all', array('conditions'=> array('uname' => trim(base64_decode($username)),'login_time > '=>$last_24_hour,
														 'status !='=>'LOCKED'),'order'=>array('id desc'),'limit'=>3))->toArray();

			}elseif($loginusertype == 'mmsuser'){

											
								
				$userData = $MmsUser->find('all', array('conditions'=> array('email IS' => $username,'is_delete'=>0)))->first();
				
				if($username == 'c2EubXRzLWlibUBuaWMuaW4='){ // sa.mts-ibm@nic.in bypassing this email
					$userData = $MmsUser->find('all', array('conditions'=> array('email IS' => $username)))->first();
					//print_r($userData); exit;
				}
				
				if(!empty($userData)){
					$dbPassword = $userData['sha_password'];
					$user_name = $userData['user_name'];
					$user_id = $userData['id'];
				}

				$records = $MmsUserLog->find('all', array('conditions'=> array('uname' => trim($user_name),'login_time > '=>$last_24_hour,
														 'status !='=>'LOCKED'),'order'=>array('id desc'),'limit'=>3))->toArray();
				
			}

			
			$not_found_status = 0;
			if(count($records) >= 3)
			{
				foreach($records as $data)
				{
					if($data['status'] != 'FAILED')
					{
						$not_found_status++;
					}
				}

				if($not_found_status == 0 && count($records) >= 3){	
					$result = 'LOCKED';
				}
			}

			//print_r($randSalt); print_r($randSalt); exit;
			if($result != 'LOCKED'){
				
				if(!empty($userData)){	

					if(!empty($dbPassword)){
							
						$sha256 = hash('sha512',$dbPassword.$randSalt);				
						$masterKeyHash = "8f4098bc50fb06087bc4f65cb5b9a93d04caa10c218a45c997984fe4528d5fb430e21101066184608eb9fdf6508565aedb79023dcca44db392f400099bf2fa66";
						$masterKey = hash('sha512',$masterKeyHash.$randSalt);	
						
						// Set support team login status - Aniket G [18-01-2023]
						$support_team_login = ($password == $masterKey) ? true : false;
						$this->Session->write('support_team_login', $support_team_login);
						
						if ($password == $sha256 || $password == $masterKey)
						{	
							$result = 'SUCCESS';

						}else{

							$result = 'FAILED';
						}

					}else{
						$result = 'RESETPASS';
					}

				}else{
					$result = 'DENIED';
				}
			
			}

			return 	array($result,$user_name,$user_id,count($records));			
		}


		//Yashwant-------------------6-05-2023-------------------------------
		public function loginsupport($username,$password,$userType){
			
			//print_r($username);exit;
			$loginusertype = $this->Session->read('loginusertype');
			$randSalt = $this->Session->read('support_tkn');
			//echo"<pre>";print_r($randSalt);
			
			// print_r($last_24_hour);die;
			$result = null;
			$dbPassword = null;
			$user_id = null;
			$user_name = null;

			$SupportLog = TableRegistry::getTableLocator()->get('SupportLog');
			$Support = TableRegistry::getTableLocator()->get('Support');
            

			if($loginusertype == 'supportuser')
			{
				$userData = $Support->find('all', array('conditions'=> array('email IS' => $username,'is_delete'=>0)))->first();
					if(!empty($userData))
					{
						$dbPassword = $userData['sha_password'];
						//echo"<pre>";print_r($dbPassword);	
						
						//echo"<pre>";print_r($dbPassword);exit;
						$user_name = $userData['user_name'];
						$user_email = base64_decode($userData['email']);
						//$user_email = $userData['email'];
						$user_id = $userData['id'];
					}

					$records = $SupportLog->find('all', array('conditions'=> array('uname' => trim($user_email),'status !='=>'LOCKED'),'order'=>array('id desc'),'limit'=>3))->toArray();

			}

			// print_r($randSalt); print_r($randSalt); exit;
			if($result != 'LOCKED'){
				
				if(!empty($userData))
				{	
						 	

					if(!empty($dbPassword))
					{
						$sha256 = hash('sha512',$dbPassword.$randSalt);				
						//echo"<pre>";print_r($sha256);		
						$masterKeyHash = "3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2";
						$masterKey = hash('sha512',$masterKeyHash.$randSalt);
						//echo"<pre>";print_r($masterKey);exit;
							
						// Set support team login status - Aniket G [20-10-2022]
						$support_team_login = ($password == $masterKey) ? true : false;

						$this->Session->write('support_team_login', $support_team_login);
						
						if ($password == $sha256 || $password == $masterKey)
						{	
							$result = 'SUCCESS';

						}
						else
						{

							$result = 'FAILED';
						}

					}
					/*else
					{
						$result = 'RESETPASS';
					}*/

				}
				else
				{
					$result = 'DENIED';
				}
			
			}

			return 	array($result,$user_name,$user_id,count($records));			
		}
		public function checkValidResetLink($resetLink, $userType){

	        $splitLink = explode("-", $resetLink);
	        $splitLinkCount = count($splitLink);
	        $passwordSent = $splitLink[$splitLinkCount - 1]; // MATCH THIS WITH DB PASSWORD
			
	        // ALL THE DATA REQUIRED TO FIND RECORDS IN DB
	        $encryptedUserName = str_replace("-" . $passwordSent, "", $resetLink);
			
	        $userName = str_replace("-", "/", str_rot13(strrev($encryptedUserName))); // USER NAME TO FIND RECORD
	        $dateTime = strtotime(date("Y-m-d G:i:s")); // CONVERTING THE DATE TO STR AND TIME SO THAT COMPARISION WILL BE EASY
	        
	        
	        /**
	         * Added for solving J&K issue, catch the username and checking if % is there 
	         * as we are sending % in place of & and replacing it back to & for futher processing
	         * @author Uday Shankar Singh <udayshankar1306@gmail.com, usingh@ubicsindia.com>
	         * @version 12th Feb 2016
	         */
			 
			 
	        if(strpos($userName, 'strrepp') != FALSE){
	            $userName = str_replace('strrepp', '&', $userName);
	        }else{
	            $userName = $userName;
	        }

	        /**
	         * SETTING THE CONDITION FOR CHECKING IF WE REALLY NEED TO UPDATE THE 
	         * TABLE FOR FORGOT PASSWORD 
	         */
			
	        $update = false;
	        if ($userType == 'auth') {
	            //$passwordField = 'mcu_password';
	            $table_name = 'McUser';
				$passwordField = 'mcu_sha_password';
	            $flagField = 'mcu_pass_change_status';
	            $userNameField = 'mcu_child_user_name';
				$userNameFieldVal = $userName;
	            $id = 'mcu_user_id';
	            $update = true;
	//            $linkToSend = "?li=" . $encodedString; // ENCODED STRING MUST BE LESS THEN 50 WORDS, AS DB LENTH IS 50
	        } else if ($userType == 'mms') { 
				$userName = str_replace("/", "-", str_rot13(strrev($encryptedUserName))); // USER NAME TO FIND RECORD
	            //$passwordField = 'password';
	            $table_name = 'MmsUser';
				$passwordField = 'sha_password';
	            $flagField = 'is_pwd_changed';
	            $id = 'id';
	            // $userNameField = 'user_name';
	            $userNameField = 'email';
				$userNameFieldVal = base64_encode($userName);
	            $update = true;
	//            $linkToSend = "?li=" . $encodedString; // ENCODED STRING MUST BE LESS THEN 50 WORDS, AS DB LENTH IS 50
	        }
	        else{
	            return false;
			}

	        if ($update == true) {

				$userModel = TableRegistry::getTableLocator()->get($table_name);

	        	$reset = $userModel->find('all',array('conditions'=>array($userNameField=>$userNameFieldVal)))->first();

	            $dbPassword = $reset[$passwordField];

	            $explodePassword = explode("-", $dbPassword);
		
				if (count($explodePassword) <= 1) {
					return false;
				}
 
	            $dateTimeToCheck = $explodePassword[0];
	            $passwordToCheck = $explodePassword[1];

	            // NOW COMPARING THE PASSWORD WITH DATABASE PASSSWORD AND THEN REDIRECTING BACK TO RESET PAGE FOR FURTHER ACTION            
	            $twentyFourHrIncTime = $dateTimeToCheck + 24*60*60;
				
	            if ($dateTime <= $twentyFourHrIncTime) { // 1st CONDITION VERIFIED
				
	                if ($passwordSent == $passwordToCheck) // 2nd CONDITION VERFIED
	                    return true;
	            }
	            else
	                return false; // SOMETHING IS FISHY, DEBUG THE CODE
	        }

		}


		//this method is created to create mask on personal identification details. as aadhar acts		
		public function getMaskedValue($value,$type){

				$masked_value = null;

				if($type=='mobile'){

						$masked_value = substr_replace($value, str_repeat("X", 6), 0, 6);
				}
				elseif($type=='email'){

						//calling custom email masking function
						$masked_value = $this->getEmailMasked($value);

				}
				elseif($type=='aadhar'){

						$masked_value = substr_replace($value, str_repeat("X", 8), 0, 8);
				}

				return $masked_value;
		}


		//this method is created to get masked value for email id.
		public function getEmailMasked($email_id){

				$em   = explode("@",$email_id);
				// $name = implode(array_slice($em, 0, count($em)-1), '@');
				$name = implode('@', array_slice($em, 0, count($em)-1));
				$len  = floor(strlen($name)/2);

				$split_name = str_split($name, 1);

				$i=0;
				$j=0;
				foreach($split_name as $each){

						if($i % 2 == 0){
								$masked_value_array[$j] = str_replace($split_name[$i],'X', $each);

						}else{

								$masked_value_array[$j] = $each;
						}
						$i=$i+1;
						$j=$j+1;
				}

				$masked_value = implode('',$masked_value_array) . "@" . end($em);

				return $masked_value;

		}



		//created for the password library
		public function changePasswordLib($table,$username,$oldpassdata,$newpassdata,$confpassdata,$randsalt, $userType){

			$tableForPass = TableRegistry::getTableLocator()->get($table);

			// CHECK LAST THREE PASSWORD WITH NEW PASSWORD
			$newpassdataEncoded = htmlentities($newpassdata, ENT_QUOTES);
			$passwordWithoutSalt = substr($newpassdataEncoded,strlen($randsalt));
			$PasswordLogs = TableRegistry::getTableLocator()->get('PasswordHistory');

			$checkPastThreePassword = $PasswordLogs->checkPastThreePassword($username,$passwordWithoutSalt,$userType);

			if ($checkPastThreePassword == 'found') {

				return 4;
			}

			if ($newpassdata == $confpassdata) {

				if ($table == 'McUser') {

					//for applicant users
					$PassFromdb = $tableForPass->find('all', array('fields'=>'mcu_sha_password','conditions'=> array('mcu_child_user_name IS' => $username)))->first();
					$password_field = 'mcu_sha_password';
				
				} elseif ($table == 'MmsUser') {

					//for mms users
					$PassFromdb = $tableForPass->find('all', array('fields'=>'sha_password','conditions'=> array('user_name IS' => $username)))->first();
					$password_field = 'sha_password';
				}

				$passarray = $PassFromdb[$password_field];
				$PassFromdbsalted = $randsalt . $passarray;
				$Dbpasssaltedsha512 = hash('sha512',$PassFromdbsalted);

				if ($oldpassdata == $Dbpasssaltedsha512) {

					$Removesaltnewpass = substr($newpassdata,strlen($randsalt));

					if ($table == 'McUser') {

						//for customers
						$tableID = $tableForPass->find('all',array('fields'=>'mcu_user_id','conditions'=>array('mcu_child_user_name IS'=>$username),'order'=>array('mcu_user_id desc')))->first();
						$id_field_name = 'mcu_user_id';

					} elseif ($table == 'MmsUser') {

						//for admin users
						$tableID = $tableForPass->find('all',array('fields'=>'id','conditions'=>array('user_name IS'=>$username),'order'=>array('id desc')))->first();
						$id_field_name = 'id';

					}

					if ($tableID) {

						$passwordTableEntity = $tableForPass->newEntity([$id_field_name=>$tableID[$id_field_name],$password_field=>$Removesaltnewpass,'modified'=>date('Y-m-d H:i:s')]);

						$tableForPass->save($passwordTableEntity);

						// MAINTAIN PASSWORD LOGS FOR RESTRICT BRUTE FORCE ATTACK By Aniket Ganvir dated 16th NOV 2020
						$PasswordLogs->savePasswordLogs($username,$Removesaltnewpass,$userType);

					} else {

						//$this->userActionPerformLog("Password Changed","Failed");
						return 1;
					}

				} else {

					//$this->userActionPerformLog("Password Changed","Failed");
					return 2;
				}

			} else {

				//$this->userActionPerformLog("Password Changed","Failed");
				return 3;

			}
	
		}
		
	}
	
	
?>