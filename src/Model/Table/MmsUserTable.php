<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use App\Controller\AdminController;
	use Cake\Core\Configure;
	use App\Controller\UsersController;

	
	class MmsUserTable extends Table{
		
		var $name = "MmsUser";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function getUserDatabyId($userId){			
			$data = $this->find('all',array('conditions'=>array('user_name'=>$userId)))->first();
			return $data;
		}

		public function getUserByEmail($user_name, $email){			

			// removed 'user_name' from condition as email addresses are now treated as username
			// $row_count = $this->find('all',array('conditions'=>array('user_name'=>$user_name, 'email'=>$email)))->count();
			$row_count = $this->find('all',array('conditions'=>array('email'=>$email)))->count();

			if ($row_count > 0) {
				// $data = $this->find('all',array('conditions'=>array('user_name'=>$user_name, 'email'=>$email)))->first();
				$data = $this->find('all',array('conditions'=>array('email'=>$email)))->first();
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


		public function saveUserDetails($formsData){	

			$zoneid = null;
			$regionid = null;
			$parent_id = 0;		
			$mcr_role = null;
			$role_id = null;
			
			// For user details update
			if( isset($_SESSION['editUserId']) && $_SESSION['editUserId'] != '' ){

				$user_id = $_SESSION['editUserId'];

				$usernameData = $this->find('all',array('fields'=>array('user_name','user_image'),'conditions'=>array('id IS'=>$user_id)))->first();
				
				$username = $usernameData['user_name'];
					
			}else{

				//create user name for new added user
				$usernameData = $this->find('all',array('fields'=>array('id','user_image'),'order'=>array('id desc')))->first();

				if(empty($usernameData)){

					$usernameData['id'] = 1;
				}

				$username = 'usribm'.$usernameData['id']+1;

				$user_id = '';

			}

			$validateError = $this->postDataValidation($formsData);

			if($validateError[0] == 'false'){

				$formsData = $validateError[1];
				
				$first_name = htmlentities($formsData['first_name'], ENT_QUOTES);
				$mid_name = htmlentities($formsData['mid_name'], ENT_QUOTES);
				$last_name = htmlentities($formsData['last_name'], ENT_QUOTES);
				$email = htmlentities($formsData['email'], ENT_QUOTES);
				$mobile = htmlentities($formsData['mobile'], ENT_QUOTES);
				$phone = htmlentities($formsData['phone'], ENT_QUOTES);
				$designation = htmlentities($formsData['designation'], ENT_QUOTES);
				$state_code = null;

				if(array_key_exists('role_id',$formsData)){
					
					$role_id = htmlentities($formsData['role_id'], ENT_QUOTES);
				}				

				
				if(array_key_exists('parentuser',$formsData)){
					
					$parent_id = htmlentities($formsData['parentuser'], ENT_QUOTES);

					if($role_id == 10){
						$state_code = $parent_id;
						$parent_id = 0;
					}
				}

				if(array_key_exists('zoneregion',$formsData)){

					if($role_id == 5){

						$zoneid = htmlentities($formsData['zoneregion'], ENT_QUOTES);

					}elseif($role_id == 6){

						$regionid = htmlentities($formsData['zoneregion'], ENT_QUOTES);
					}
				}



				// Add role for registration module user
				if($role_id == 1){

					$mcr_role = 'A';

				}elseif($role_id == 5){

					$mcr_role = 'Z';

				}elseif($role_id == 6){

					$mcr_role = 'R';

				}elseif($role_id == 11){

					$mcr_role = 'M';
					
				}elseif($role_id == 18){

					$mcr_role = 'H';

				}elseif($role_id == 19){

					$mcr_role = 'C';
					
				}elseif($role_id == 20){

					$mcr_role = 'D';
					
					$dealing_reg_id = $this->find('all',array('fields'=>array('region_id'),'conditions'=>array('id IS'=>$parent_id)))->first();
					$regionid = $dealing_reg_id['region_id'];
				}	


				if($_SESSION['userAction'] == 'profile'){

					

					if($formsData['userimg'] == ''){
						$formsData['userimg'] = $usernameData['user_image'];
					}


					$newEntity = $this->newEntity(array(

						'id'=>$user_id,
						'first_name'=>$first_name,
						'mid_name'=>$mid_name,
						'last_name'=>$last_name,
						'email'=>base64_encode($email),						
						'mobile'=>base64_encode($mobile),
						'phone'=>$phone,
						'designation'=>$designation,
						'user_image'=>$formsData['userimg'],	
						'created_at'=>$formsData['created_at'],
						'updated_at'=>date('Y-m-d H:i:s')
					));
					
				
				}else{

					if($user_id != '' && $formsData['userimg'] == ''){
						$formsData['userimg'] = $usernameData['user_image'];
					}
					
        			$saveData = array(
						'id'=>$user_id,
						'parent_id'=>$parent_id,
						'user_name'=>$username,
						'role_id'=>$role_id,
						'mcr_role'=>$mcr_role,
						'zone_id'=>$zoneid,
						'region_id'=>$regionid,						
						'first_name'=>$first_name,
						'mid_name'=>$mid_name,
						'last_name'=>$last_name,
						'email'=>base64_encode($email),						
						'mobile'=>base64_encode($mobile),
						'phone'=>base64_encode($phone),
						'designation'=>$designation,
						'user_image'=>$formsData['userimg'],
						'state_code'=>$state_code,						
						'created_at'=>$formsData['created_at'],
						'updated_at'=>date('Y-m-d H:i:s')
					);	
					if($user_id == '')
					{
						$newPwdEncrypt = hash('sha512',"Admin@123");
						$saveData['sha_password'] = $newPwdEncrypt;	
					}
					//print_r($saveData);die;
					$newEntity = $this->newEntity($saveData);
				}
				//print_r($newEntity); exit;
				$result = $this->save($newEntity);
				$id = $result->id;

				if($id){
					// send email when add new user
					if($user_id == '')
					{
						$emailID = $email;
						$userID = $id;
						$user_table = "MmsUser";
						$userName = $username;
						$usersController = new UsersController;

						// maintain user creation log (by Aniket G. on dated 15-05-2022) 
						$mmsUserId = $_SESSION['mms_user_id'];
						$mmsUserStatusLog = TableRegistry::getTableLocator()->get('MmsUserStatusLog');
						$mmsUserStatusLog->saveUserStatusLog($id, $mmsUserId, 2);

						//$usersController->Clscommon->forgotPassword($userID, $userName, $emailID, $user_table);
					} //end

					if($_SESSION['userAction'] == 'profile')
					{

						$_SESSION['mms_user_first_name'] = $first_name; 
						$_SESSION['mms_user_last_name'] = $last_name;
						$_SESSION['mms_user_email'] = base64_encode($email);
						$_SESSION['mms_designation'] = $designation;
						$_SESSION['user_image'] = $formsData['userimg'];
						$_SESSION['mms_profile'] = $formsData['userimg'];
					}

					return 1;
				} else {
					return 0;
				}

			}else{

				return 0;

			}

				
			
			
			
		}

		public function postDataValidation($formsData){

			
			$errors = 'false';

			$formsData['userimg'] = '';

			$AdminController = new AdminController;

			$mandatoryFields = array('first_name','last_name','email','mobile','role_id','parentuser','zoneregion'); 
			
			// Check duplicate email address
			// For user details update
			if( isset($_SESSION['editUserId']) && $_SESSION['editUserId'] != '' ){

				$user_id = $_SESSION['editUserId'];

				$emailFound = $this->find('all')
							->where(['id IS NOT'=>$user_id])
							->where(['email'=>base64_encode($formsData['email'])])
							->count();

				if($emailFound > 0){
					$errors = 'true9';
				}
					
			}else{

				//create user name for new added user
				$emailFound = $this->find('all', array('conditions' => array('email IS' => base64_encode($formsData['email']))))->count();
				if($emailFound > 0){
					$errors = 'true10';
				}

			}

			foreach($formsData as $key => $each){


				if(empty($each) && in_array($key,$mandatoryFields)){

					$errors = 'true1';
				
				}else{

					if($key == 'email' && !filter_var($each, FILTER_VALIDATE_EMAIL)){

						$errors = 'true2';

					}

					if($key == 'mobile' && !preg_match("/^[0-9]{10}$/", $each)){

						$errors = 'true3';

					}

					if($key == 'role_id' && !preg_match("/^[0-9]$/", $each)){

						$MmsUserRole = TableRegistry::getTableLocator()->get('MmsUserRole');

						$roleIdResult = $MmsUserRole->find('all',array('conditions'=>array('id IS'=>$each)))->toArray();

						if(empty($roleIdResult)){

							$errors = 'true4';
						}


					}

					if($key == 'parentuser' && !preg_match("/^[0-9]$/", $each)){

						if($formsData['role_id'] != 10){

							$parentuserResult = $this->find('all',array('conditions'=>array('id IS'=>$each)))->toArray();
	
							if(empty($parentuserResult)){
	
								$errors = 'true5';
							}

						}

					}

					if($key == 'zoneregion' && !preg_match("/^[0-9]$/", $each)){


						if($formsData['role_id'] == 5){

							$DirZone = TableRegistry::getTableLocator()->get('DirZone');

							$zoneResult = $DirZone->find('all',array('conditions'=>array('id IS'=>$each)))->toArray();

							if(empty($zoneResult)){

								$errors = 'true6';
							}
						}

						if($formsData['role_id'] == 6){

							$DirRegion = TableRegistry::getTableLocator()->get('DirRegion');

							$regionResult = $DirRegion->find('all',array('conditions'=>array('id IS'=>$each)))->toArray();

							if(empty($regionResult)){

								$errors = 'true7';
							}
						}


					}

					if($key == 'user_image' && !empty($formsData['user_image']->getClientFilename())){				
				
						$file_name = $formsData['user_image']->getClientFilename();
						$file_size = $formsData['user_image']->getSize();
						$file_type = $formsData['user_image']->getClientMediaType();
						$file_local_path = $formsData['user_image']->getStream()->getMetadata('uri');
						
						$upload_result = $AdminController->Customfunctions->fileUploadLib($file_name,$file_size,$file_type,$file_local_path); // calling file uploading function
						if($upload_result[0] == 'success'){
							$formsData['userimg'] = $upload_result[1];
						}else{
							$errors = 'true8';
						}						
					}

				}

			}
			//print_r($errors);
			return array($errors,$formsData);
		}

	} 
?>