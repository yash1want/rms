<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Network\Email\Email;
use Cake\ORM\Entity;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;

class UsersController extends AppController{
		
	var $name = 'Users';
	var $uses = array();
	
    public function initialize(): void
    {
        parent::initialize();
		
		$this->loadComponent('Createcaptcha');
		$this->loadComponent('Authentication');
		$this->loadComponent('Customfunctions');
		$this->loadComponent('Clscommon');
		$this->viewBuilder()->setHelpers(['Form','Html']);
		$this->Session = $this->getRequest()->getSession();
		$this->BrowserLogin = $this->getTableLocator()->get('BrowserLogin');
		$this->McUser = $this->getTableLocator()->get('McUser');
		$this->MmsUser = $this->getTableLocator()->get('MmsUser');
		$this->Mine = $this->getTableLocator()->get('Mine');
		$this->MineralWorkedEndUser = $this->getTableLocator()->get('MineralWorkedEndUser');
		$this->SecondaryUserRoles = $this->getTableLocator()->get('MmsSecondaryUserRoles');

		$this->connection = ConnectionManager::get('default');		
    }

	//To create captcha code, called from component
	public function createCaptcha(){ 
		$this->autoRender = false;
		$this->Createcaptcha->createCaptcha();
	}
		
	public function refreshCaptchaCode(){
			$this->autoRender = false;
			$this->Createcaptcha->refreshCaptchaCode();
	}

	public function refreshCaptcha(){
			$this->autoRender = false;
			$this->Createcaptcha->refreshCaptcha();
	}
				
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);
	}
	
	public function authuser(){
		// $_SESSION['loginusertype'] = 'authuser';
		$this->getRequest()->getSession()->write('loginusertype','authuser');
		$this->redirect('/auth/login');
	}
	
	public function mmsuser(){
		// $_SESSION['loginusertype'] = 'mmsuser';
		$this->getRequest()->getSession()->write('loginusertype','mmsuser');
		$this->redirect('/mms/login');
	}
	
	public function enduser(){
		// $_SESSION['loginusertype'] = 'enduser';
		$this->getRequest()->getSession()->write('loginusertype','enduser');
		$this->redirect('/auth/login');
	}
	
	public function primaryuser(){
		// $_SESSION['loginusertype'] = 'primaryuser';
		$this->getRequest()->getSession()->write('loginusertype','primaryuser');
		$this->redirect('/auth/login');
	}

	public function authForgotPassword(){
		$this->getRequest()->getSession()->write('forgotusertype','auth');
		$this->redirect('/auth/forgotPassword');
	}

	public function mmsForgotPassword(){
		$this->getRequest()->getSession()->write('forgotusertype','mms');
		$this->redirect('/mms/forgotPassword');
	}
	
	public function validLoginWindow($username){
		
		$str1 = explode('/',$username);
		$str2 = strpos($username,'block');
		$return = false ;
		
		if(count($str1) > 1 && empty($str2) && $_SESSION['loginusertype']=='authuser'){ $return = true ; }
		if(count($str1) == 1 && !is_int($username) && $_SESSION['loginusertype']=='mmsuser'){ $return = true ; }
		if(count($str1) > 1 && !empty($str2) && $_SESSION['loginusertype']=='enduser'){ $return = true ; }
		if(count($str1) == 1 && is_int(57) && $_SESSION['loginusertype']=='primaryuser'){ $return = true ; }
		return $return;
		
	}

	public function validUserName($username){
		
		$str1 = explode('/',$username);
		$str2 = strpos($username,'block');
		$return = false ;

		if (filter_var($username, FILTER_VALIDATE_EMAIL)){

			if(in_array($_SESSION['loginusertype'],array('mmsuser'))){
				$return = true ;
			}

		}elseif(filter_var($username, FILTER_VALIDATE_INT) && $_SESSION['loginusertype'] == 'primaryuser'){ 
				$return = true ;
		}elseif(count($str1) > 1 && empty($str2) && $_SESSION['loginusertype']=='authuser'){ 
			$return = true ; 
		}elseif(count($str1) > 1 && !empty($str2) && $_SESSION['loginusertype']=='enduser'){ 
			$return = true ; 
		}	

		return $return;
	}


	// auth user login function			
	public function login(){
		
		$this->viewBuilder()->setLayout('home_page');

		//$codeCaptcha = $this->Createcaptcha->getCaptchaRandomCode();

		// SET SESSION ID VARIABLE FOR VALIDATING ALONG WITH CAPTCHA FIELD
		// to address "Captcha implementation not proper" security audit issue
		// @addedon: 05th MAR 2021 (by Aniket Ganvir)
		$loginRequestId = md5(rand(1000, 10000) . date('syimHd') . rand(100, 1000) . date('mHdsyi') . "012012 210210" . rand(1000000, 100000000));
		$this->Session->write('loginrequestid',$loginRequestId);
		$this->set('loginRequestId',$loginRequestId);


		$loginusertype = $this->getRequest()->getSession()->read('loginusertype');
		$already_loggedin_msg = 'no';

		if(null == $loginusertype){
			return $this->redirect(array('controller'=>'Pages','action'=>'home'));
		}

		if($loginusertype == 'primaryuser'){ $logititle = 'Mine Owner Login'; $current_ctrl = 'auth'; }
		if($loginusertype == 'authuser'){ $logititle = 'Miners Login'; $current_ctrl = 'auth'; }
		if($loginusertype == 'enduser'){ $logititle = 'End Users Login'; $current_ctrl = 'auth'; }
		if($loginusertype == 'mmsuser'){ $logititle = 'IBM Login'; $current_ctrl = 'mms'; }

		$userLoginTxt = array();
		switch ($loginusertype) {
			case 'authuser':
				$userLoginTxt['placeholder'] = 'Enter User Name Like 000/00XYZ0000';
				$userLoginTxt['note'] = 'Mine Owner should use the credentials generated by form K for the first time login and other user should use the credential generated by the system.';
				break;
			case 'enduser':
				$userLoginTxt['placeholder'] = 'Enter User Name Like 000/blockX/0';
				$userLoginTxt['note'] = '';
				break;
			case 'mmsuser':
				$userLoginTxt['placeholder'] = 'Enter User Name Like xxxx@ibm.gov.in';
				$userLoginTxt['note'] = '';
				break;
			case 'primaryuser':
				$userLoginTxt['placeholder'] = 'Enter User Name Like 000';
				$userLoginTxt['note'] = 'Mine Owner should use the credentials generated by form K for the first time login and other user should use the credential generated by the system.';
				break;
			default:
				$userLoginTxt['placeholder'] = 'Enter User Name Like 000/00XYZ0000';
				$userLoginTxt['note'] = 'Mine Owner should use the credentials generated by form K for the first time login and other user should use the credential generated by the system.';
		}

		$this->set('userlogintxt',$userLoginTxt);
		$this->set('logititle',$logititle);
		$this->set('current_ctrl',$current_ctrl);
		
		if ($this->request->is('post')){	
			
			$userName = htmlentities($this->request->getData('username'), ENT_QUOTES);
			$password = htmlentities($this->request->getData('password'), ENT_QUOTES);
			$captcha = htmlentities($this->request->getData('captcha'), ENT_QUOTES);
			$userType = htmlentities($this->request->getData('current_ctrl'), ENT_QUOTES);
			//$multilogin = htmlentities($this->request->getData('multilogin'), ENT_QUOTES);

			
			if(!preg_match("/^[A-Za-z0-9]{6}$/", $captcha)){

				$this->alert_message = 'Invalid Captcha Input';
				$this->alert_redirect_url = 'login';

			}else{
				//print_r($this->Session->read('code')); print_r($captcha); exit;
				if($captcha == $this->Session->read('code')){

					$validUserName = $this->validUserName(base64_decode($userName));

					if($validUserName == true && strlen($password) == '128'){

						$login_result =	$this->Authentication->loginuser($userName,$password,$userType);
						
						$loginStatus =  $login_result[0];

						if($loginStatus == 'SUCCESS'){
							
							$userName =  $login_result[1];
		          			$userID =  $login_result[2];
							$primaryUserId = explode('/',$userName)[0];
							
							// Checked primary user is suspended or not in registration module, Done By Pravin Bhakare 09-11-2022
							$user_data = $this->connection->newQuery()
										->select('mcappd_suspend')
										->from('mc_applicant_det')
										->where(['mcappd_app_id'=>$primaryUserId])
										->execute()
										->fetch('assoc');	

		          			
		          			$alreadyLogin = $this->checkMultipleBrowserLogin($userName);

		          			if($alreadyLogin == 'no' || $alreadyLogin == 'norecord'){

		          				if(in_array($loginusertype,array('mmsuser'))){

									$this->loginProceed($userName,$alreadyLogin);  
						            $this->redirect(array('controller'=>'mms', 'action'=>'home'));

						        }elseif(in_array($loginusertype,array('primaryuser','authuser','enduser'))){
                                       
										if(!empty($user_data) ){
											
											// if($user_data['mcappd_suspend'] == 1){
									
												// $this->alert_message = 'The id '.$primaryUserId.' is currently deactivated/suspended in Registration Module (ibmreg.nic.in). ';
												// $this->alert_redirect_url = 'login';
												
											// }else{
												
													$suspend_status = $this->checkSuspendedEnduser($userName, $loginusertype);
													
													if($suspend_status == false){
														$this->alert_message = 'The id '.$userName.' is currently deactivated in Registration Module (ibmreg.nic.in). ';
														$this->alert_redirect_url = 'login';
													} else {
														$this->loginProceed($userName, $alreadyLogin);
														$this->redirect(array('controller' => 'auth', 'action' => 'home'));
													}
													
											//}
											
										}else{	
											$this->alert_message = 'The Id '.$primaryUserId.' is not available in registration module(ibmreg.nic.in)';
											$this->alert_redirect_url = 'login';	
										}		
						        }


		          			}else{

								if (in_array($loginusertype, array('primaryuser', 'authuser', 'enduser'))) {
									
										if(!empty($user_data) ){
											
											// if($user_data['mcappd_suspend'] == 1){
									
												// $this->alert_message = 'The id '.$primaryUserId.' is currently deactivated/suspended in Registration Module (ibmreg.nic.in). ';
												// $this->alert_redirect_url = 'login';
												
											// }else{

													$suspend_status = $this->checkSuspendedEnduser($userName, $loginusertype);
													
													if($suspend_status == false){
														$this->alert_message = 'The id '.$userName.' is currently deactivated in Registration Module (ibmreg.nic.in). ';
														$this->alert_redirect_url = 'login';
													} else {
														$this->Session->write('alreadyLogin', $alreadyLogin);
														$this->Session->write('username', $userName);
														$already_loggedin_msg = 'yes';
													}
											//}
											
										}else{	
											$this->alert_message = 'The Id '.$primaryUserId.' is not available in registration module(ibmreg.nic.in)';
											$this->alert_redirect_url = 'login';	
										}		
								}else{
									
									$this->Session->write('alreadyLogin', $alreadyLogin);
									$this->Session->write('username', $userName);
									$already_loggedin_msg = 'yes';
								}
		          			}


						}elseif($loginStatus == 'RESETPASS'){

							/* Send resetpassword link to user to update the password with sha512 hashing
										   Done by Pravin Bhakare 26/05/2020
							*/				

							if($userType == 'miner' || $userType == 'enduser' || $userType == 'primary'){

								$user_table = "McUser";
								$user_email = "mcu_email";
								$user_id = "mcu_user_id";

							} else {

								$user_table = "MmsUser";
								$user_email = "email";
								$user_id = "id";
							}

							$this->loadModel($user_table);
							$user_data = $this->$user_table->getUserDatabyId($userName);
							$emailID = $user_data[$user_email];
							$userID = $user_data[$user_id];

							$this->Clscommon->forgotPassword($userID, $userName, $emailID, $user_table);
							
							$this->alert_message = 'Validity of your password has expired. A link to reset the password has been sent to your registered email account. Click on link to set new password. The link has a validity period of 24 hours';
							$this->alert_redirect_url = 'login';


						}else{

							$this->saveUserLog(base64_decode($userName),$loginStatus,'', $loginusertype); 

							if($loginStatus=='LOCKED'){
								$this->alert_message = 'Sorry... Your account is disabled for 10 minutes, on account of 3 login failure';							
							}

							if($loginStatus=='FAILED'){
								$attemptleft = 2 - $login_result[3];
								$this->alert_message = 'Username or password do not match.<br> Please note: You have '. $attemptleft .' more attempt to login';							
							}

							if($loginStatus=='DENIED'){

								$this->alert_message = 'Username or password do not match';	
							}
							
							$this->alert_redirect_url = 'login';
						}


					}else{	          		
		          		$this->alert_message = "You are trying to login from incorrect login window";
						$this->alert_redirect_url = 'login';

		          	}

				}else{	          		
		          		$this->alert_message = "Invalid Captcha Input";
						$this->alert_redirect_url = 'login';

		        }

			}
			
		} 	
		
		
		// set variables to show popup messages from view file
		$this->set('alert_message',$this->alert_message);
		$this->set('already_loggedin_msg',$already_loggedin_msg);
		$this->set('alert_redirect_url',$this->alert_redirect_url);
			
	}



	public function checkMultipleBrowserLogin($username){	

    		$this->loadModel('BrowserLogin');

    		$userType = $this->Session->read('loginusertype');			
			
			// WHITELISTED "&" CHARACTER FROM HTMLENCODING ESPECIALLY FOR THE J&K USERSID			
			$exceptEncodes = array("&amp;","&ndash;");
			$retainEncodes = array("&","–");
			$userId = str_replace($exceptEncodes,$retainEncodes,htmlentities($username, ENT_QUOTES));
				
			$userDetailsResult = $this->BrowserLogin->find('all',array('conditions'=>array('user_id IS'=>$userId, 'user_type'=>$userType)))->count();

			if($userDetailsResult != 0){
				
				$alreadyLoginResult = $this->BrowserLogin->find('all',array('conditions'=>array('user_id IS'=>$userId, 'user_type'=>$userType, 'current_logged_in'=>'yes')))->count();
				
				if($alreadyLoginResult != 0){
					return 'yes';
				}else{
					return 'no';
				}
			}else{
				return 'norecord';
			}
    
    }
	
	
	public function saveUserLog($user, $status, $login_session=null, $userType) {
		
		if($userType == 'authuser' || $userType == 'enduser' || $userType == 'primaryuser'){
			
			$this->loadModel('McUserLog');
			$uname = $user;
			$ip_address = $_SERVER['REMOTE_ADDR'];
			$login_time = date('Y-m-d H:i:s');
			
			$session_token = null;
			if($status=='SUCCESS')
			{
				$session_token = $login_session;
				$this->Session->write('login_session',$session_token);
				$this->Session->write('last_activity_time',strtotime(date('Y-m-d H:i:s')));				
			}
			if($this->Session->read('support_team_login') == false){ // restrict support team logs
				$newEntity = $this->McUserLog->newEntity(array(
									'uname'=>$uname,
									'ip_address'=>$ip_address,
									'login_time'=>$login_time,
									'status'=>$status,
									'session_token'=>$session_token
								));		
				$this->McUserLog->save($newEntity);
			}

		}else {

			$this->loadModel('MmsUserLog');
			$uname = $user;
			$ip_address = $_SERVER['REMOTE_ADDR'];
			$login_time = date('Y-m-d H:i:s');
			
			$session_token = null;
			if($status=='SUCCESS')
			{
				$session_token = $login_session;
				$this->Session->write('login_session',$session_token);
				$this->Session->write('last_activity_time',strtotime(date('Y-m-d H:i:s')));				
			}
			if($this->Session->read('support_team_login') == false){ // restrict support team logs
				$newEntity = $this->MmsUserLog->newEntity(array(
									'uname'=>$uname,
									'ip_address'=>$ip_address,
									'login_time'=>$login_time,
									'status'=>$status,
									'session_token'=>$session_token
								));		
				$this->MmsUserLog->save($newEntity);
			}

		}
	}

		
	public function updateBrowserLogin($user, $action, $session_id){
		
		$this->loadModel('BrowserLogin');
		$date = date('Y/m/d H:i:s');
		
		$loginusertype = $this->Session->read('loginusertype');
		
		if($this->Session->read('support_team_login') == false){ // restrict support team logs
			if($action == 'norecord')
			{
				$newEntity = $this->BrowserLogin->newEntity(array(
								'user_id'=>$user,
								'user_type'=>$loginusertype,
								'session_id'=>$session_id,
								'current_logged_in'=>'yes'							
							));
				$this->BrowserLogin->save($newEntity);
			}else
			{
				$this->BrowserLogin->updateAll(
					array(
						'current_logged_in'=>'yes',
						'session_id'=>$session_id,
						'modified'=>$date),
					array(
						'user_id IS'=>$user,
						'user_type IS'=>$loginusertype
						)
				);
			}
		}		
	}

	/**
	 * for getting updated returns statistics count
	 * @addedon: 04th MAR 2021 (by Aniket Ganvir)
	 */
    public function statistics(){

        $this->viewBuilder()->setLayout('home_page');

        $submittedTotal = $this->Customfunctions->getFilteredReturnsCount('', '', '', '', '', '', '', '', '', '', '');
        $submitted1 = $this->Customfunctions->getFilteredReturnsCount('', '', '', '', '', '', '', '', '1', '', '');
        $submitted2 = $this->Customfunctions->getFilteredReturnsCount('', '', '', '', '', '', '', '', '2', '', '');
        $submitted3 = $this->Customfunctions->getFilteredReturnsCount('', '', '', '', '', '', '', '', '3', '', '');
        $submitted4 = $this->Customfunctions->getFilteredReturnsCount('', '', '', '', '', '', '', '', '4', '', '');
        $submitted5 = $this->Customfunctions->getFilteredReturnsCount('', '', '', '', '', '', '', '', '5', '', '');
        $submitted7 = $this->Customfunctions->getFilteredReturnsCount('', '', '', '', '', '', '', '', '7', '', '');
        $submitted8 = $this->Customfunctions->getFilteredReturnsCount('', '', '', '', '', '', '', '', '8', '', '');

        $this->set('submitted1', $submitted1);
        
        $submittedAnnualTotal = $this->Customfunctions->getAnnualReturnsCount('', '', '', '', '', '', '', '', '', '');
        $submittedAnnual1 = $this->Customfunctions->getAnnualReturnsCount('', '', '', '', '', '', '', '1', '', '');
        $submittedAnnual2 = $this->Customfunctions->getAnnualReturnsCount('', '', '', '', '', '', '', '2', '', '');
        $submittedAnnual3 = $this->Customfunctions->getAnnualReturnsCount('', '', '', '', '', '', '', '3', '', '');
        $submittedAnnual4 = $this->Customfunctions->getAnnualReturnsCount('', '', '', '', '', '', '', '4', '', '');
        $submittedAnnual5 = $this->Customfunctions->getAnnualReturnsCount('', '', '', '', '', '', '', '5', '', '');
        $submittedAnnual6 = $this->Customfunctions->getAnnualReturnsCount('', '', '', '', '', '', '', '6', '', '');
        $submittedAnnual7 = $this->Customfunctions->getAnnualReturnsCount('', '', '', '', '', '', '', '7', '', '');
        $submittedAnnual8 = $this->Customfunctions->getAnnualReturnsCount('', '', '', '', '', '', '', '8', '', '');

    }

    /**
     * destroy current user session and redirect to the login page
     * @addedon: 05th MAR 2021 (by Aniket Ganvir)
     */
    public function logout($usertype){

    	$date = date('Y/m/d H:i:s');
    	$this->loadModel('McUserLog');
		$this->loadModel('MmsUserLog');
		$this->loadModel('BrowserLogin');


    	if(null !== $this->Session->read('login_session')){
    			
    			$session_token = $this->Session->read('login_session');
    			$username = $this->Session->read('username');

    			if($usertype == 'authuser' || $usertype == 'enduser' || $usertype == 'primaryuser'){
    		

		    			$this->McUserLog->updateAll(
							array(
								'logout_time'=>$date,
								'status'=>'FULL',
								),
							array(
								'uname'=>$username,
								'session_token'=>$session_token
								)
						);
		    		

		    	}else {
		    		

		    			$this->MmsUserLog->updateAll(
							array(
								'logout_time'=>$date,
								'status'=>'FULL',
								),
							array(
								'uname'=>$username,
								'session_token'=>$session_token
								)
						);

		    	}	


		    	$this->BrowserLogin->updateAll(
					array(
						'current_logged_in'=>'',				
						'modified'=>$date),
					array(
						'user_id'=>$username,
						'user_type'=>$usertype
						)
				);
    	}	    	

    	$this->Session->destroy();
    	$this->redirect('/users/'.$usertype);

    }


	// user resetPassword		
	public function resetPassword($userType, $resetLink){

		$this->set('resetParam',$resetLink);
		$this->set('userType',$userType);
		
		// set variables to show popup messages from view file
		$message = '';
		$redirect_to = '';
		$message_theme = '';

		if(empty($userType) || empty($resetLink)){

			echo "Sorry You are not authorized to view this page..'<a href='../'>'Please login'</a>'";
			exit();

		} else if(!in_array($userType, ['auth', 'mms'])){

			echo "Sorry You are not authorized to view this page..'<a href='../'>'Please login'</a>'";
			exit();

		} else {

			$resetLinkStatus = $this->Authentication->checkValidResetLink($resetLink, $userType);
			if($resetLinkStatus == 0){

				echo "Link expired or not valid!";
				exit();

			} else {

				if ($this->request->is('post')){	

					// validate captcha input, added on 07th JAN 2021
					$patternSpecialChar = '/[\'~`\!@#\$%\^\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
					$captchaText = htmlentities($this->request->getData('captcha'), ENT_QUOTES);
					if(preg_match($patternSpecialChar, $captchaText) || $captchaText == "" || strlen($captchaText) != "6"){
						$message = 'Sorry...Wrong Captcha Code Entered';
						$redirect_to = '../'.$userType.'/'.$resetLink;
					} else {

						$resetPass = htmlentities($this->request->getData('resetPass'), ENT_QUOTES); // getting the link
			            //======GETTING THE USER NAME AND PASSWORD AND DECODING THEM TO GET=======
			            //============THE ACTUAL USER NAME PASSWORD AND SALT VALUE================
			            $password = str_replace($this->Session->read('tkn'),"",$this->request->getData('new_pass'));
					    $password = str_replace($this->Session->read('tkn2'),"",$password);
				                   
						$passwordConf = str_replace($this->Session->read('tkn'),"",$this->request->getData('conf_pass'));
					    $passwordConf = str_replace($this->Session->read('tkn1'),"",$passwordConf);

					    $post_NewPwd = $password;
					    $post_ConfirmPwd = $passwordConf;
			           
			            if ($post_NewPwd == $post_ConfirmPwd) {

			              //  $checkPassForComplexity = clsCommon::validatePassword($userPass);

			                if (!isset($checkPassForComplexity)) {
			                    //$this->getUser()->setFlash('errMsg', 'Required Password Parameters are not satisfied. Kindly make sure password satisfy the criteria given on the page', false);
								//$this->getUser()->setFlash('errMsg', 'Required Password Parameters are not satisfied. Kindly make sure password satisfy the criteria given on the page');
								//$this->redirect("auth/resetPassword?li=$resetPass");
			                }

			                //new password
			                //$new_genpassword = trim(md5($post_NewPwd));
							$new_genpassword = $post_NewPwd; //REMOVED MD5 FUNCTION AS PASSWORD IS NOW ALREADY IN MD5

							if($userType == 'auth'){
								$user_table = 'McUser';
							} else {
								$user_table = 'MmsUser';
							}

			                $updateQuery = $this->Clscommon->updatePassword($resetPass, $user_table, $new_genpassword);

			                if ($updateQuery == '1') {

								// MAINTAINING PASSWORD HISTORY LOG IN DB
								$this->McUser->maintainPasswordLogWithResetlink($resetPass, $new_genpassword, $userType);
								
								$splitLink = explode("-", $resetPass);
								$splitLinkCount = count($splitLink);
								$passwordSent = $splitLink[$splitLinkCount - 1];
								$encryptedUserName = str_replace("-" . $passwordSent, "", $resetPass);
								$userName = str_replace("-", "/", str_rot13(strrev($encryptedUserName)));
								
								$userTypee = 'authuser';
								
								if($user_table == 'MmsUser'){
								  $mms_user_name = $this->MmsUser->find('all',array('fields'=>'user_name','conditions'=>array('email'=>base64_encode($userName))))->first();			
								  $userName = $mms_user_name['user_name'];
								  $userTypee = 'mmsuser';
								}	
								
								$this->saveUserLog($userName,'SUCCESS','', $userTypee);

								$message = 'Password successfully changed';
								$message_theme = 'success';
								$redirect_to = '../../../';

			                } else if ($updateQuery == '4') {

								$message = 'This password matched with your last three passwords, Please enter different password !!!';
								$redirect_to = '../'.$userType.'/'.$resetLink;

							} else {

								$message = 'Password not set. Kindly try again or generate a new link to reset password';
								$redirect_to = '../'.$userType.'/'.$resetLink;

			                }
			            } else {
							$message = 'New password and confirm password does not match.';
							$redirect_to = '../'.$userType.'/'.$resetLink;
			            }
			            
			        }

		        } else {

					// $codeCaptcha = $this->Createcaptcha->getCaptchaRandomCode();

		            $hashValue = rand(1000, 10000) . date('syimHd') . rand(100, 1000) . date('mHdsyi') . "012012 210210" . rand(1000000, 100000000);
					$hashValue1 = rand(1000, 10000);
					$hashValue1 = md5($hashValue1);
					$hashValue2 = md5($hashValue);
			 
					$hashValue1 = substr($hashValue1,0,rand(5,25));
					$hashValue2 = substr($hashValue2,0,rand(9,25));
					
					$this->Session->write('tkn',$hashValue);
					$this->Session->write('tkn1',$hashValue1);
					$this->Session->write('tkn2',$hashValue2);

					$this->set('tkn',$hashValue);
					$this->set('tkn1',$hashValue1);
					$this->set('tkn2',$hashValue2);

					// SET SESSION ID VARIABLE FOR VALIDATING ALONG WITH CAPTCHA FIELD
					// to address "Captcha implementation not proper" security audit issue
					// @addedon: 05th MAR 2021 (by Aniket Ganvir)
					$loginRequestId = md5(rand(1000, 10000) . date('syimHd') . rand(100, 1000) . date('mHdsyi') . "012012 210210" . rand(1000000, 100000000));
					$this->Session->write('loginrequestid',$loginRequestId);
					$this->set('loginRequestId',$loginRequestId);

				}

			}

		}
		
		$this->viewBuilder()->setLayout('home_page');
		// $this->render('/users/login');
		
		// set variables to show popup messages from view file
		$this->set('message',$message);
		$this->set('redirect_to',$redirect_to);
		$this->set('alert_message',$message);
		$this->set('alert_theme',$message_theme);
		$this->set('alert_redirect_url',$redirect_to);
		
		// render login alert modal component if message is set
		// added on 22nd FEB 2021 by Aniket Ganvir
		if($message != null) {
			$this->render('/element/message_box');
		}
			
	}

	public function forgotPassword(){

		$userType = $this->Session->read('forgotusertype');
		if(null == $userType){
			return $this->redirect(array('controller'=>'Pages','action'=>'home'));
		}

		$this->set('userType',$userType);
		
		// set variables to show popup messages from view file
		$message = '';
		$redirect_to = '';		
		
		if ($this->request->is('post')){
			
			// validate captcha input, added on 07th JAN 2021
			$patternSpecialChar = '/[\'~`\!@#\$%\^\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
			$captchaText = htmlentities($this->request->getData('captcha'), ENT_QUOTES);
			if(preg_match($patternSpecialChar, $captchaText) || $captchaText == "" || strlen($captchaText) != "6"){
				$message = 'Sorry...Wrong Captcha Code Entered';
				$redirect_to = 'forgotPassword';
			} else {
				
				$user_name = $this->request->getData('username');
				$email = htmlentities(base64_decode($this->request->getData('email')), ENT_QUOTES);

				// validate username and allow only aplhanumeric username with exception of '/' and '&' characters
				// added on 06th JAN 2021 by Aniket Ganvir
				//print_r($this->request->getData('username')); exit;
				$pattern = '/^[a-zA-Z0-9-&_.@\/ ]*$/';
				if($userType == 'auth' && !preg_match('/^[a-zA-Z0-9-&_.@\/]+$/', $this->request->getData('username'))){ // auth username

					$message = 'Invalid request';
					$redirect_to = 'forgotPassword';

				} else if($userType == 'mms' && !filter_var($this->request->getData('username'), FILTER_VALIDATE_EMAIL)) { // mms username 

					$message = 'Invalid request';
					$redirect_to = 'forgotPassword';

				} else if(empty($user_name) || empty($email) || empty($captchaText)){

					$message = 'Blank field not accepted';
					$redirect_to = 'forgotPassword';

				} else if(!filter_var(base64_decode($this->request->getData('email')), FILTER_VALIDATE_EMAIL)) {

					// validate email addresses, added on 06th JAN 2021 by Aniket Ganvir
					$message = 'Invalid email address';
					$redirect_to = 'forgotPassword';

				} else if($captchaText != $this->Session->read('code')){

					$message = 'Invalid captcha code';
					$redirect_to = 'forgotPassword';

				} else {
					
					$userType = htmlentities($this->request->getData('userType'), ENT_QUOTES);

					if($userType == 'auth'){

						$table_name = 'McUser';

					} else {

						$table_name = 'MmsUser';

					}
				
					// GET PARTIALLY HIDED EMAIL ADDRESS, By Aniket Ganvir dated 07th DEC 2020
					$partialEmailId = $this->Clscommon->partialHideEmail($email);
					
					$this->loadModel($table_name);					
					$user = $this->$table_name->getUserByEmail($user_name, base64_encode($email));
					
					if ($user != 0) {

				        $user_id = $user;

						$reset_pwd = $this->Clscommon->forgotPassword($user_id, $user_name, $email, $table_name);
						
						$message = "If the given username & email match, you'll soon receive a link in email id '".$partialEmailId."' to reset the password !";
						$redirect_to = '../';
						
					} else {
				       
						$message = "If the given username & email match, you'll soon receive a link in email id '".$partialEmailId."' to reset the password !";
						$redirect_to = '../';

					}

				}

			}

        } else {
			
			//$codeCaptcha = $this->Createcaptcha->getCaptchaRandomCode();
			//print_r(''); exit;
			// SET SESSION ID VARIABLE FOR VALIDATING ALONG WITH CAPTCHA FIELD
			// to address "Captcha implementation not proper" security audit issue
			// @addedon: 05th MAR 2021 (by Aniket Ganvir)
			$loginRequestId = md5(rand(1000, 10000) . date('syimHd') . rand(100, 1000) . date('mHdsyi') . "012012 210210" . rand(1000000, 100000000));
			$this->Session->write('loginrequestid',$loginRequestId);
			$this->set('loginRequestId',$loginRequestId);

		}
		//print_r($message); exit;
		$this->viewBuilder()->setLayout('home_page');
		// $this->render('/users/login');
		
		// set variables to show popup messages from view file
		$this->set('alert_message',$message);
		$this->set('alert_redirect_url',$redirect_to);
		
		// render login alert modal component if message is set
		// added on 22nd FEB 2021 by Aniket Ganvir
		if($message != null) {			
			$this->render('/element/msg_box');
		}

	}

	public function loginProceed($userName,$action){

		$loginusertype =  $this->Session->read('loginusertype');
		$support_team_login =  $this->Session->read('support_team_login');
		
		$this->Session->destroy();
				
		$parentid = explode('/',$userName);
		$this->Session->write('username',$userName);
		$this->Session->write('applicantid',$userName);
		$this->Session->write('loginusertype',$loginusertype);
		$this->Session->write('support_team_login',$support_team_login);
		$this->Session->write('parentid',$parentid[0]);	
		$login_session = uniqid();

		if(in_array($loginusertype,array('mmsuser'))){

			$user_data = $this->MmsUser->getUserDatabyId($userName);
			$roles = $this->SecondaryUserRoles->getUserRoles($user_data['id']);
			
			$this->Session->write('mms_user_name', $userName);
			$this->Session->write('mms_user_id', $user_data['id']);
			$this->Session->write('parentid',$user_data['parent_id']);	
			$first_name = ($user_data['first_name']) ? $user_data['first_name'] : "Guest";
			$designation = ($user_data['designation']) ? $user_data['designation'] : "";
			$profileimage = ($user_data['user_image']) ? $user_data['user_image'] : "user-icon.png";

			$this->Session->write('mms_user_first_name', $first_name);
			$this->Session->write('mms_user_last_name', $user_data['last_name']);
			$this->Session->write('mms_user_role', $user_data['role_id']);
			$this->Session->write('mms_designation', $designation);
			$this->Session->write('mms_profile', $profileimage);
			$this->Session->write('mms_user_email', $user_data['email']);
			$this->Session->write('user_image', $user_data['user_image']);
			$this->Session->write('user_roles', $roles);
			$this->Session->write('mining_close_status', '');

			//$user_data['id']

			$this->updateBrowserLogin($userName, $action, $login_session);
		
		}elseif(in_array($loginusertype,array('primaryuser'))){			

			$user_data = $this->connection->newQuery()
							->select('*')
							->from('mc_applicant_det')
							->where(['mcappd_app_id'=>$userName])
							->execute()
							->fetch('assoc');			
							
			$first_name = ($user_data['mcappd_fname']) ? $user_data['mcappd_fname'] : "Guest";
			$last_name = ($user_data['mcappd_lastname']) ? $user_data['mcappd_lastname'] : "";			
			$profileimage = "user-icon.png";

			$this->Session->write('is_mine_owner', true);
			$this->Session->write('endUserFlag', false);
			$this->Session->write('user_first_name', $first_name);
			$this->Session->write('user_last_name', $last_name);	
			$this->Session->write('user_profile', $profileimage);
			$this->Session->write('user_email', base64_decode($user_data['mcappd_email']));	
			$this->Session->write('mc_form_main', '');		
			$this->Session->write('mining_close_status', '');

			$this->updateBrowserLogin($userName, $action, $login_session);

		}elseif(in_array($loginusertype,array('authuser'))){

			$user_data = $this->McUser->getUserDatabyId($userName);

			$mine_code = $user_data['mcu_mine_code'];
			$this->loadModel('MineralWorked');
			$mineral_name = $this->MineralWorked->getMineralName($mine_code);
			$this->loadModel('DirMcpMineral');
			$form_type = $this->DirMcpMineral->getFormNumber($mineral_name);
			$form_one = array('1','2','3','4','8');
			if(in_array($form_type, $form_one)){
				$form_main = '1';
			} else if($form_type == '5') {
				$form_main = '2';
			} else if($form_type == '7') {
				$form_main = '3';
			} else {
				$form_main = '0';
			}

			$first_name = ($user_data['mcu_first_name']) ? $user_data['mcu_first_name'] : "Guest";
			$last_name = ($user_data['mcu_last_name']) ? $user_data['mcu_last_name'] : "";	

			$miningCloseStatus = $this->Mine->getMineCloserStatus($mine_code);
			
			$this->Session->write('mining_close_status', $miningCloseStatus);

			$this->Session->write('mc_mine_code', $mine_code);
			$this->Session->write('mc_mineral', $mineral_name);
			$this->Session->write('mc_form_type', $form_type);
			$this->Session->write('mc_form_main', $form_main);
			$this->Session->write('user_first_name', $first_name);
			$this->Session->write('user_last_name', $last_name);
			$this->Session->write('user_image', $user_data['mcu_user_image']);
			
			$this->Session->write('is_mine_owner', false);
			$this->Session->write('endUserFlag', false);
			
			$this->insertMineCodeDetails($mine_code);
			
			$this->Mine->updateMineDetails($parentid[0],$mine_code);
			$this->Mine->updateMineOwnerDetails($parentid[0],$mine_code);

			$this->updateBrowserLogin($userName, $action, $login_session);

		}elseif(in_array($loginusertype,array('enduser'))){

			$user_data = $this->McUser->getUserDatabyId($userName);

			$regNO = $this->McUser->getAppIdWithRegNo($userName);
			$activityType = $this->McUser->getActivityType($userName);
			$mc_mineral = $this->MineralWorkedEndUser->getMineralName($userName);

			$first_name = ($user_data['mcu_first_name']) ? $user_data['mcu_first_name'] : "Guest";
			$last_name = ($user_data['mcu_last_name']) ? $user_data['mcu_last_name'] : "";	

			$this->Session->write('is_mine_owner', false);
			$this->Session->write('endUserFlag', true);
			$this->Session->write('regNo',$regNO);
			$this->Session->write('registration_code',$userName);
			$this->Session->write('activityType',$activityType);
			$this->Session->write('mc_mineral',$mc_mineral);
			$this->Session->write('mcu_user_id',$userName);
			$this->Session->write('user_first_name', $first_name);
			$this->Session->write('user_last_name', $last_name);
			$this->Session->write('user_image', $user_data['mcu_user_image']);	
			$this->Session->write('mc_form_main', '');
			$this->Session->write('mining_close_status', '');

			$this->updateBrowserLogin($userName, $action, $login_session);
		}


		$this->saveUserLog($userName,'SUCCESS',$login_session, $loginusertype); // saving user logs

	}

	

	//created the password method for changing the password on 15-01-2022 by akash
	 // change password for admin user method start
    public function changePassword() {

        // set variables to show popup messages from view file
        $message = '';
        $message_theme = '';
        $redirect_to = '';
		$alert_message = '';
		$alert_theme = '';
		$alert_redirect_url = '';

        $username = $this->Session->read('username');
		$loginusertype = $this->Session->read('loginusertype');
			
		$McUser = $this->loadModel('McUser');
		$MmsUser = $this->loadModel('MmsUser');
		$PasswordHistory = $this->loadModel('PasswordHistory');

		if($loginusertype == 'primaryuser')
		{
			$userData = $McUser->find('all', array('conditions'=> array('mcu_user IS' => base64_decode($username))))->first();
			$table = 'McUser';
			$layout = 'mc_panel';

			if(!empty($userData)){
				$dbPassword = $userData['mcu_sha_password'];
				$user_name = $userData['mcu_user'];
				$user_id = $userData['mcu_user_id'];
			}

		}elseif($loginusertype == 'authuser' || $loginusertype == 'enduser'){	

			$userData = $McUser->find('all', array('conditions'=> array('mcu_child_user_name IS' => $username)))->first();

			$table = 'McUser';
			$layout = 'mc_panel';

			if(!empty($userData)){
				$dbPassword = $userData['mcu_sha_password'];
				$user_name = $userData['mcu_child_user_name'];
				$user_id = $userData['mcu_user_id'];
			}	

		}elseif($loginusertype == 'mmsuser'){

			$layout = 'mms_panel';		
			$userData = $MmsUser->find('all', array('conditions'=> array('email IS' => $this->Session->read('mms_user_email'),'is_delete'=>0)))->first();
			$table = 'MmsUser';

			if(!empty($userData)){

				$dbPassword = $userData['sha_password'];
				$user_name = $userData['user_name'];
				$user_id = $userData['id'];
			}

		}


        //set the layout
        $this->viewBuilder()->setLayout($layout);
       

        if (!empty($userData)) {

            if ($this->request->is('post')) {

                $randsalt = $this->Session->read('randSalt');
                $changepassdata = $this->request->getData();

                $oldpassdata = $this->request->getData('old_password');
                $newpassdata = $this->request->getData('new_password');
                $confpassdata = $this->request->getData('confirm_password');

                // calling change password library function
                $change_pass_result = $this->Authentication->changePasswordLib($table, $user_name, $oldpassdata, $newpassdata, $confpassdata, $randsalt,$loginusertype);


                if ($change_pass_result == 1) {

                	//for mms user
                	if($layout == 'mms_panel'){

            		 	$this->Session->write('master_error_alert','Sorry...username not matched to save new password !!!');
						$this->redirect(array('controller'=>'users','action'=>'change-password'));

					//for mc user
                	} else {

                		$alert_message = "Sorry...username not matched to save new password !!!";
                		//$this->message_theme = "danger";
                    	$alert_redirect_url = "change-password";
                	}
                   


                } elseif ($change_pass_result == 2) {

                	//for mms user
                	if ($layout == 'mms_panel') {
                    	$this->Session->write('master_error_alert','Sorry...Please Check old password again !!!');
                    	$this->redirect(array('controller'=>'users','action'=>'change-password'));

                    //for mc user	
                	} else {

						$alert_message = "Sorry...Please Check old password again !!!";
						//$this->message_theme = "danger";
                    	$alert_redirect_url = "change-password";
                	}

                } elseif ($change_pass_result == 3) {

                	//for mms user
                	if ($layout == 'mms_panel') {

                		$this->Session->write('master_error_alert','Sorry...please Check. Confirm password not matched !!!');
						$this->redirect(array('controller'=>'users','action'=>'change-password'));

					//for mc user
                	} else {

                		$alert_message = "Sorry...please Check. Confirm password not matched !!!";
                		//$this->message_theme = "danger";
                    	$alert_redirect_url = "change-password";
                	}
                   

                } elseif ($change_pass_result == 4) {

                	//for mms user
                	if ($layout == 'mms_panel') {
                		
                		$this->Session->write('master_error_alert','This password matched with your last three passwords, Please enter different password !!!');
						$this->redirect(array('controller'=>'users','action'=>'change-password'));

					//for mc user
                	} else {

                		$alert_message = "This password matched with your last three passwords, Please enter different password !!!";
                		//$this->message_theme = "danger";
                    	$alert_redirect_url = "change-password";
                	}
    

                } else {

                	if ($layout == 'mms_panel') {

                		$this->Session->write('master_success_alert','Password Changed Successfully !!!');
						$this->redirect(array('controller'=>'users','action'=>'change-password'));

                	} else {

                		$alert_message = "Password Changed Successfully !!!";
                		$alert_theme = "success";
                    	$alert_redirect_url = "change-password";
                	}
                }

            }

        } else {
            echo "Sorry You are not authorized to view this page..'<a href='login_user'>'Please login'</a>'";
            exit();
        }

    	$this->set('alert_message',$alert_message);
    	$this->set('alert_theme',$alert_theme);
    	$this->set('message_theme',$message_theme);
        $this->set('alert_redirect_url',$alert_redirect_url);



    }
	
	
	
	// Done By Pravin Bhakare 02-11-2022
	public function insertMineCodeDetails($mineCode){
		
		//if($mineCode == '22RAJ06437'){
			
			$formType = '';
			
			$conn = ConnectionManager::get('default');
			
			$mineData = $conn->execute(" select * from mine where mine_code = '".$mineCode."'")->fetchAll('assoc');
			
			if(count($mineData) == 0){
				
				$mcMineData = $conn->execute(" select * from mc_mine_dir where mcm_mine_code = '".$mineCode."'")->fetchAll('assoc');
				
				if(count($mcMineData) > 0){
					
					$primaryMineral = $conn->execute(" select * from mc_miniesheldmineral_det where mcmhmd_mineral_type = 'P' and mcmhmd_mine_code = '".$mineCode."'")->fetchAll('assoc');
					$secondaryMineral = $conn->execute(" select * from mc_miniesheldmineral_det where mcmhmd_mineral_type = 'A' and mcmhmd_mine_code = '".$mineCode."'")->fetchAll('assoc');
					
					if(count($primaryMineral) > 0){
						$dir_mcp_mineral_det =  $conn->execute(" select * from dir_mcp_mineral where mineral_code = '".$primaryMineral[0]['mcmhmd_mineral_id']."'")->fetchAll('assoc');
						
						if(count($dir_mcp_mineral_det) > 0){
							
							$formType = $dir_mcp_mineral_det[0]['form_type'];
							$mineralName = $dir_mcp_mineral_det[0]['mineral_name'];
							$stateCode = $mcMineData[0]['mcm_state_code'];
							$districtCode = $mcMineData[0]['mcm_district_code'];
							$mineName = $mcMineData[0]['mcm_mine_desc'];
							$mineCategory = $mcMineData[0]['mine_category'];
							$typeWorking = $mcMineData[0]['type_working'];
							$natureUse = $mcMineData[0]['nature_use'];
							$mechanisation = $mcMineData[0]['mechanisation'];
							$mineOwnership = $mcMineData[0]['mine_ownership'];
							$villageName = $mcMineData[0]['mcm_mine_VillageName'];	
							$created = date('Y-m-d H:i:s');
							
							$conn->execute("insert into mine (mine_code,form_type,state_code,district_code,MINE_NAME,mine_category,type_working,nature_use,mechanisation,mine_ownership,village_name,delete_status,created_at)
											values('$mineCode','$formType','$stateCode','$districtCode','$mineName','$mineCategory','$typeWorking','$natureUse','$mechanisation','$mineOwnership','$villageName','no','$created')");
						
							$conn->execute("insert into minecodegenwithoutmasterlog (mine_code) values('$mineCode')");		
												
							$mineral_worked_data =  $conn->execute(" select * from mineral_worked where mine_code = '".$mineCode."' and mineral_name = '".$mineralName."'")->fetchAll('assoc');
							if(count($mineral_worked_data) == 0){
								
								$conn->execute("insert into mineral_worked (mine_code,mineral_name,mineral_sn,created_at)
												values('$mineCode','$mineralName',1,'$created')");
								$conn->execute("insert into mineralworkedaddwithoutmasterlog (mine_code,mineral_name)
												values('$mineCode','$mineralName')");				
							}						
							
						}
						
					}
					
					$secMineralId = '';
					$secMineralname = '';
					if(count($secondaryMineral) > 0){
						
						foreach($secondaryMineral as $each){
							$secMineralId .= "'".$each['mcmhmd_mineral_id']."',";
						}
						
						$sec_mcp_mineral_det =  $conn->execute("select * from dir_mcp_mineral where mineral_code IN (".rtrim($secMineralId,',').")")->fetchAll('assoc');
						
						foreach($sec_mcp_mineral_det as $each){
							$secMineralname .= "'".$each['mineral_name']."',";
						}
						
						$mineral_worked_sec =  $conn->execute("select * from mineral_worked where mine_code = '".$mineCode."' and mineral_name IN (".rtrim($secMineralname,',').")")->fetchAll('assoc');
					
						$existMineral = array();
						foreach($mineral_worked_sec as $each){						
							$existMineral[] = $each['mineral_name'];
						}
						
						foreach($sec_mcp_mineral_det as $each){
							
							if(!in_array($each['mineral_name'],$existMineral)){
								$mineralNameSec = $each['mineral_name'];
								$conn->execute("insert into mineral_worked (mine_code,mineral_name,mineral_sn,created_at)
												values('$mineCode','$mineralNameSec',2,'$created')");	
								$conn->execute("insert into mineralworkedaddwithoutmasterlog (mine_code,mineral_name)
												values('$mineCode','$mineralNameSec')");					
							}
						}
					
					}
					
				}
			}
		//}	
	}
	
	// check suspended user status
	public function checkSuspendedEnduser($username, $loginusertype){
		
		return true;
		
		if($loginusertype == 'enduser'){
			
			$username_explode = explode('/', $username);
			$endusername = $username_explode[0].'/'.$username_explode[1].'/'.$username_explode[2];
			
			$secondary_user_data = $this->connection->newQuery()
					->select('mcu_activity')
					->from('mc_user')
					->where(['mcu_child_user_name'=>$endusername])
					->execute()
					->fetch('assoc');	

			if($secondary_user_data != ''){
				
				$activity_type = $secondary_user_data['mcu_activity'];
				$status = '';
				if (in_array($activity_type, array('T','S','E','W'))){
					
					$status = $this->connection->newQuery()
							->select('mcmd_status')
							->from('mc_mineraltradingstorageexport_det')
							->where(['mcmd_app_id'=>$username_explode[0],'mcmd_slno'=>$username_explode[2],'mcmd_status'=>1])
							->execute()
							->fetch('assoc');	
				} else if (in_array($activity_type, array('C'))){
					
					$status = $this->connection->newQuery()
							->select('mcmcd_status')
							->from('mc_mineralconsumption_det')
							->where(['mcmd_app_id'=>$username_explode[0],'mcmd_slno'=>$username_explode[2],'mcmcd_status'=>1])
							->execute()
							->fetch('assoc');

					if($status == ''){
						$status = $this->connection->newQuery()
							->select('mcmd_status')
							->from('mc_mineraltradingstorageexport_det')
							->where(['mcmd_app_id'=>$username_explode[0],'mcmd_slno'=>$username_explode[2],'mcmd_status'=>1])
							->execute()
							->fetch('assoc');
					}
				}
				
				if($status != ''){
					return true;
				} else {
					return false;
				}
				
			}
		} else if($loginusertype == 'authuser'){
			
			$username_explode = explode('/', $username);
			
			$status = $this->connection->newQuery()
				->select('mcmd_status')
				->from('mc_minesheld_det')
				->where(['mcmd_app_id'=>$username_explode[0],'mcmd_mine_code'=>$username_explode[1],'mcmd_status'=>1])
				->execute()
				->fetch('assoc');
				
			if($status != ''){
				return true;
			} else {
				return false;
			}
			
		} else {
			return true;
		}
		
		
	}
	// Test mail delivery - Aniket G [16-01-2023]
	public function testMailDelivery($email) {
		
		$this->autoRender = false; 
		 
		$to = (is_null($email)) ? 'aniketaganvir@gmail.com' : $email;
		$subject = "Testing mail delivery for ibmreturns.gov.in through mail()";
		$txt = "Hello there, this is just a test mail for testing ibmreturns.gov.in portal. Kindly ignore this mail as this was intentionally sent for testing purpose only.";
		$headers = "From: no-reply@ibm.gov.in";
		$resp = mail($to,$subject,$txt,$headers);
		print_r($resp); exit;

	}

	// Test mail delivery - Aniket G [16-01-2023]
	public function testMailPhpmailer() {
		
		$this->autoRender = false; 
		 
		require_once(ROOT . DS .'vendor' . DS . 'phpmailer' . DS . 'mail.php');
		
		$from = "support.mts-ibm@nic.in";

		// $to = "sa.mts-ibm@nic.in";
		$to = 'aniketaganvir@gmail.com';

		$subject = " Text from PHP code through HostName";

		$msg = " Sample Message Body  ";

		send_mail($from, $to, $subject, $msg);

		// if($res){
		// echo " send mail result is ".$res;
		// }
		// else
		// {
		// echo "Something went wrong. please try again.";
		// }
		// exit;



	}

	
	// Test mail delivery - Aniket G [16-01-2023]
	public function testMailPhpmailerDelivery($email = null) {
		
		$this->autoRender = false; 
		 
		require_once(ROOT . DS .'vendor' . DS . 'phpmailer' . DS . 'mail.php');
		
		$from = "support.mts-ibm@nic.in";

		$to = (is_null($email)) ? 'aniketaganvir@gmail.com' : $email;

		$msg = "Hello there, this is just a test mail for testing ibmreturns.gov.in portal. Kindly ignore this mail as this was intentionally sent for testing purpose only.";

		$subject = "Testing mail delivery for ibmreturns.gov.in throught send_mail()";

		print_r(send_mail($from, $to, $subject, $msg));

		// if($res){
		// echo " send mail result is ".$res;
		// }
		// else
		// {
		// echo "Something went wrong. please try again.";
		// }
		// exit;



	}

	public function testphpmail(){
		$this->autoRender = false; 
		$this->testMailPhpmailer();
	}

	public function saleDespatchDemo(){
		$this->autoRender = false;
		$this->viewBuilder()->setLayout('demo');
		$this->render('/Users/sale_despatch_demo');
	}
	
	public function detailsDeductionDemo(){
		$this->autoRender = false;
		$this->viewBuilder()->setLayout('demo');
		$this->render('/Users/details_deduction_demo');
	}
		
}
?>
