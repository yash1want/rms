<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Network\Email\Email;
use Cake\ORM\Entity;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\EntityInterface;


class SupportModController extends AppController{
		
	var $name = 'SupportMod';
	var $uses = array();
	
    public function initialize(): void
    {
        parent::initialize();
        //$this->userSessionExits();
		
		$this->loadComponent('Createcaptcha');
		$this->loadComponent('Authentication');
		$this->loadComponent('Customfunctions');
		$this->loadComponent('TicketReturnslist');
		$this->loadComponent('Clscommon');

		$this->viewBuilder()->setHelpers(['Form', 'Html']);
        $this->connection = ConnectionManager::get('default');
        $this->Session = $this->getRequest()->getSession();

		$this->BrowserLogin = $this->getTableLocator()->get('BrowserLogin');
		$this->Support = $this->getTableLocator()->get('Support');
		$this->TicketTakenStatus = $this->getTableLocator()->get('TicketTakenStatus');
		$this->SupportLog = $this->getTableLocator()->get('SupportLog');
		$this->SupportingAttachments = $this->getTableLocator()->get('SupportingAttachments');
		$this->Mine = $this->getTableLocator()->get('Mine');
		$this->MineralWorkedEndUser = $this->getTableLocator()->get('MineralWorkedEndUser');
		$this->SecondaryUserRoles = $this->getTableLocator()->get('MmsSecondaryUserRoles');
		$this->MmsRaisingTickets = $this->getTableLocator()->get('MmsRaisingTickets');
				
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
	
	
	public function supportuser(){
		// $_SESSION['loginusertype'] = 'authuser';
		$this->getRequest()->getSession()->write('loginusertype','supportuser');
		$this->redirect('/support/login');
	}

	public function validUserName($username){
		
		$str1 = explode('/',$username);
		$str2 = strpos($username,'block');
		$return = false ;

		if (filter_var($username, FILTER_VALIDATE_EMAIL))
		{

			if(in_array($_SESSION['loginusertype'],array('supportuser'))){
				$return = true ;
			}

		}
		elseif(filter_var($username, FILTER_VALIDATE_INT) && $_SESSION['loginusertype'] == 'supportuser')
		{ 
				$return = true ;
		}
		/*elseif(count($str1) > 1 && empty($str2) && $_SESSION['loginusertype']=='supportuser')
		{ 
			$return = true ; 
		}*/
		/*elseif(count($str1) > 1 && !empty($str2) && $_SESSION['loginusertype']=='supportuser'){ 
			$return = true ; 
		}*/
		return $return;
	}
	
	
	public function login()
	{
		
		$this->viewBuilder()->setLayout('home_page');

		//$logititle = 'Support Team Login';

		/*if(filter_var($username, FILTER_VALIDATE_INT) && $_SESSION['loginusertype'] == 'supportuser')
		{ 
				$return = true ;
		}*/

		/*if($_SESSION['loginusertype'] == 'supportuser')
		{ */
			$current_ctrl = 'supportuser';
			$this->Session->write('loginusertype',$current_ctrl);
			$this->set('current_ctrl',$current_ctrl);
		/*}*/

			$logititle = 'Support Team Login'; 
			$this->set('logititle',$logititle);
			//$this->render('/support/login');
		

		$loginRequestId = md5(rand(1000, 10000) . date('syimHd') . rand(100, 1000) . date('mHdsyi') . "012012 210210" . rand(1000000, 100000000));
		$this->Session->write('loginrequestid',$loginRequestId);
		$this->set('loginRequestId',$loginRequestId);

		//echo"<pre>";print_r($_SESSION);exit;

		$loginusertype = $this->getRequest()->getSession()->read('loginusertype');

		$already_loggedin_msg = 'no';

		$userLoginTxt['placeholder'] = 'Enter User Name Like 000/00XYZ0000';

		if($loginusertype == 'supportuser'){ $logititle = 'Support Team Login'; $current_ctrl = 'supportuser'; }
		
		
		if ($this->request->is('post'))
		{

			$userName = htmlentities($this->request->getData('username'), ENT_QUOTES);
			$password = htmlentities($this->request->getData('password'), ENT_QUOTES);
			$captcha = htmlentities($this->request->getData('captcha'), ENT_QUOTES);

			//echo"<pre>";print_r($password);
			//$userType = htmlentities($this->request->getData('current_ctrl'), ENT_QUOTES);
			
			$userType= $this->Session->read('loginusertype');

			//echo"<pre>";print_r($_POST);exit;

			if(!preg_match("/^[A-Za-z0-9]{6}$/", $captcha))
			{

				$this->alert_message = 'Invalid Captcha Input';
				$this->alert_redirect_url = 'login';

			}
			else
			{
				//print_r($this->Session->read('code')); print_r($captcha); exit;
				if($captcha == $this->Session->read('code'))
				{

					$validUserName = $this->validUserName(base64_decode($userName));
					//echo"<pre>";print_r($validUserName);exit;

					if($validUserName == true && strlen($password) == '128')
					{

						
						$login_result =	$this->Authentication->loginsupport($userName,$password,$userType);
						//echo"<pre>";print_r($login_result);exit;
					
						
						$loginStatus =  $login_result[0];
						

						if($loginStatus == 'SUCCESS')
						{
							
							$userName = $login_result[1];
		          			$userID =   $login_result[2];
							$primaryUserId = explode('/',$userName)[0];
							//print_r($userID);exit;
		          			
		          			$alreadyLogin = $this->checkMultipleBrowserLogin($userName);
		          			//print_r($alreadyLogin);exit;

		          			if($alreadyLogin == 'no' || $alreadyLogin == 'norecord')
		          			{

		          				if($loginusertype=='supportuser')
		          				{	
		          					//print_r($userName);exit;
									$this->loginProceed($userName,$alreadyLogin,$userID);   
						            $this->redirect(array('controller'=>'SupportMod', 'action'=>'home'));
						           // $this->redirect(home());
						           
						        }	
						        else
								{
									
									$this->Session->write('alreadyLogin', $alreadyLogin);
									$this->Session->write('username', $userName);
									$this->Session->write('userID', $userID);
									$already_loggedin_msg = 'yes';
								}
								$this->set('already_loggedin_msg',$already_loggedin_msg);

		          			}

		          			else
							{	          		
				          		$this->alert_message = "You are trying to login from incorrect login window";
								$this->alert_redirect_url = 'login';

				          	}
				          	$this->set('already_loggedin_msg',$already_loggedin_msg);
							
						}
						else
						{
								/*print_r($loginusertype);
								print_r($loginStatus);
								print_r(base64_decode($userName));exit;
								*/
								$this->saveSupportLog(base64_decode($userName),$loginStatus,'', $loginusertype); 

								if($loginStatus=='LOCKED')
								{
									$this->alert_message = 'Sorry... Your account is disabled for 10 minutes, on account of 3 login failure';							
								}

								if($loginStatus=='FAILED')
								{
									$attemptleft = 2 - $login_result[3];
									$this->alert_message = 'Username or password do not match.<br> Please note: You have '. $attemptleft .' more attempt to login';							
								}

								if($loginStatus=='DENIED')
								{

									$this->alert_message = 'Username or password do not match';	
								}
								
								$this->alert_redirect_url = 'login';
						}
						$this->set('already_loggedin_msg',$already_loggedin_msg);
					}
					else
					{	          		
			          		$this->alert_message = "Invalid Captcha Input";
							$this->alert_redirect_url = 'login';

			        }
				}
			
			} 	
		
		}	
			// set variables to show popup messages from view file
			$this->set('alert_message',$this->alert_message);
			$this->set('already_loggedin_msg',$already_loggedin_msg);
			$this->set('alert_redirect_url',$this->alert_redirect_url);
			$this->render('/support/login');
	}


	public function home()
	{	
		 //print_r('welcome');exit;
		 $this->viewBuilder()->setLayout('support_panel');

			$this->loadModel('MmsRaisingTickets');
		 	$d_count['all'] = $this->MmsRaisingTickets->find()->select(['id'])->count();
		 	$d_count['pending'] = $this->MmsRaisingTickets->find()->select(['id'])->where(['status'=>'Pending'])->count();
		 	$d_count['inprocess'] = $this->MmsRaisingTickets->find()->select(['id'])->where(['status'=>'Inprocess'])->count();
		 	$d_count['resolve'] = $this->MmsRaisingTickets->find()->select(['id'])->where(['status'=>'Closed'])->count();
			//print_r($d_count);exit;

		$this->set('d_count',$d_count);
		$this->render('/support/home');

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
	
	
	/*public function saveUserLog($user, $status, $login_session=null, $userType) {
		
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
	}*/

	//Save Support Log==================================
	public function saveSupportLog($user, $status, $login_session=null, $userType) {

		/*echo "<pre>";print_r($user);
		echo "<pre>";print_r($status);
		echo "<pre>";print_r($userType);exit;*/
		
		if($userType == 'supportuser')
		{
			
			$this->loadModel('SupportLog');
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
				$newEntity = $this->SupportLog->newEntity(array(
									'uname'=>$uname,
									'ip_address'=>$ip_address,
									'login_time'=>$login_time,
									'status'=>$status,
									'session_token'=>$session_token
								));		
				$this->SupportLog->save($newEntity);
			}

		}
		else 
		{

			$this->loadModel('SupportLog');
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
				$newEntity = $this->SupportLog->newEntity(array(
									'uname'=>$uname,
									'ip_address'=>$ip_address,
									'login_time'=>$login_time,
									'status'=>$status,
									'session_token'=>$session_token
								));		
				$this->SupportLog->save($newEntity);
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

    
    public function logout($usertype){

    	$date = date('Y/m/d H:i:s');

    	$this->loadModel('Support');
    	$this->loadModel('SupportLog');
		$this->loadModel('BrowserLogin');


    	if(null !== $this->Session->read('login_session'))
    	{
    			
    			$session_token = $this->Session->read('login_session');
    			$username = $this->Session->read('user_name');

    			if($usertype == 'supportuser' )
    			{
    		

		    			$this->SupportLog->updateAll(
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
		    	/*else 
		    	{
		    		
		    			$this->SupportLog->updateAll(
							array(
								'logout_time'=>$date,
								'status'=>'FULL',
								),
							array(
								'uname'=>$username,
								'session_token'=>$session_token
								)
						);

		    	}	*/


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
    	$this->redirect('/support/login');

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

	/*public function loginProceed($userName,$action){

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
*/

	public function loginProceed($userName,$action,$userID)
	{
		$loginusertype =  $this->Session->read('loginusertype');
		$support_team_login =  $this->Session->read('support_team_login');
		

		$this->Session->destroy();
				
		$parentid = explode('/',$userName);
		//echo"<pre>";print_r($parentid);exit;
		$this->Session->write('username',$userName);
		$this->Session->write('applicantid',$userID);
		$this->Session->write('loginusertype',$loginusertype);
		$this->Session->write('support_team_login',$support_team_login);
		$this->Session->write('parentid',$parentid[0]);	
		
		$login_session = uniqid();

		if($loginusertype=='supportuser')
		{

			//$support_data = $this->getSupportData($userName);
			//echo"<pre>";print_r($support_data);exit;
			
			$this->Session->write('user_name', $userName);
			$this->Session->write('support_log_id', $support_data['id']);
			//$this->Session->write('parentid',$support_data['parent_id']);	
			$first_name = ($support_data['first_name']) ? $support_data['first_name'] : "";
			$last_name = ($support_data['last_name']) ? $support_data['last_name'] : "";
			
			//$profileimage = ($user_data['user_image']) ? $user_data['user_image'] : "user-icon.png";

			$this->Session->write('first_name', $first_name);
			$this->Session->write('last_name', $last_name);
			$this->Session->write('email', $support_data['email']);

			$this->updateBrowserLogin($userName, $action, $login_session);
		
		}

		$this->saveSupportLog($userName,'SUCCESS',$login_session, $loginusertype); // saving user logs

	}


		/*public function getSupportData($userId){			
			//print_r($userId);exit;
			$Username = $userId;
			$support_data = $this->find('all', array('conditions'=> array('user_name IS' => $Username)))->first();
			print_r($support_data);exit;
			return $support_data;
		}*/

		public function getUserDatabyId($userId){			
			$data = $this->find('all',array('conditions'=>array('user_name'=>$userId)))->first();
			return $data;
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

	//==========================

	/*public function authuser(){
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
	}*/
	
	/*public function primaryuser(){
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
		
	}*/

	
	/*PENDING TICKET LIST*/

	/*public function pendingList()
	{
		$this->viewBuilder()->setLayout('support_panel');
		$this->render('/support/pending_list');

	}*/

	/*public function listTicket()
    {
        $userId = $this->Session->read('username');
        $this->viewBuilder()->setLayout('mms_panel');
       
       $listTicket = $this->MmsRaisingTickets->find('all')
                    ->order('-id')
                    ->toArray();

                   // echo '<pre>'; print_r($listTicket);die;
        $this->set('listTicket',$listTicket);
    }*/
	

	public function supportApp($list_type) {

		//print_r($list_type);exit;

		//$this->autoRender = false;
		$this->Session->write('ticket_type', $list_type);
		//$this->redirect(array('controller'=>'support-mod', 'action'=>'applicationList'));
		$this->redirect(array('controller'=>'SupportMod', 'action'=>'ticketList'));
	}


	
	public function ticketList() 
	{
		//print_r($_SESSION);exit;
		//echo"<pre>";print_r($_POST);exit;
		//$post_request = htmlentities($_POST['f_search'], ENT_QUOTES);
    	
    	$this->viewBuilder()->setLayout('support_panel');
    	//echo'<pre>';print_r($_SESSION);exit;
    	$this->loadModel('Support');

		$alert_message = '';
		$alert_message_status = '';
		$applicant_id = "";
		
		
		$status = $this->Session->read('ticket_type');

		$returnPeriodArr = $this->Customfunctions->getTicketPeriodArr($status);
		$yearsArr = $this->Customfunctions->getYearArr();


		$returnTickType = array('RMS'=>'RMS','MPAS'=>'MPAS');

		$this->set('returnPeriodArr', $returnPeriodArr);
		$this->set('yearsArr', $yearsArr);
		$this->set('returnTickType', $returnTickType);
		$main_status='';
		$ticket_type='';
		$from_date = '';
        $to_date = '';
		//echo'<pre>';print_r($this->request->getData());exit;

		/*$this->request->getData('f_search')*/

		if (null !== $this->request->getData('f_search')) 
		{

            $rb_period = $this->request->getData('rb_period');

            if ($rb_period == 'period') 
            {

                $r_period = $this->Customfunctions->getReturnTicketDateByTicketPeriod($this->request->getData('r_period'));
                $from_date = $r_period[0];
                $to_date = $r_period[1];
                
            } elseif ($rb_period == 'range') 
            {

                $from_date = $this->Customfunctions->getTicketDateByReturnRange($this->request->getData('from_date'));
                $to_date = $this->Customfunctions->getTicketDateByReturnRange($this->request->getData('to_date'));
               
            }

            $ticket_type = $this->request->getData('f_ticket_type');

            

            /*if($status=='pending')
            {
            	$main_status='Pending';
            }
            elseif($status=='inprocess')
            {
            	$main_status='Inprocess';
            }
            elseif($status=='resolve')
            {
            	$main_status='Closed';
            }
            else
            {
            	$main_status='all';
            }*/
        }
       
    	$returnsData='';
     	
 		$returnsData = $this->TicketReturnslist->getFilteredTicketList($ticket_type,$from_date,$to_date,$status);
 		$this->set('returnsData', $returnsData);
     	
        
         //echo'<pre>';print_r($returnsData);exit;




		//$ticket_status = $this->Session->read('ticket_type');
		$inprocessTicketstatusList = '';
        $resolveTicketstatusList = '';
        $pendingTicketstatusList='';
        

		if($status=='pending')
		{
			$page_title = "Pending Ticket List";
			$title = "Pending";
			$btn_tooltip = "Edit";
			$btn_icon = "fa fa-edit";
			$displaymode = 'edit';
		}
		elseif($status=='inprocess')
		{
			$page_title = "Inprocess Ticket List";
			$title = "Inprocess";
			$btn_tooltip = "View";
			$btn_icon = "fa fa-edit";
			$displaymode = 'view';
		}
		elseif($status=='resolve')
		{
			$page_title = "Resolved Ticket List";
			$title = "Resolve";
			$btn_tooltip = "View";
			$btn_icon = "fa fa-edit";
			$displaymode = 'view';
		}
		else
		{
			$page_title = "All Ticket List";
			$btn_tooltip = "View";
			$title = "All";
			$btn_icon = "fa fa-edit";
			$displaymode = 'view';
		}
		$this->set('page_title',$page_title);
		$this->set('title',$title);
		$this->set('btn_tooltip',$btn_tooltip);
		$this->set('btn_icon',$btn_icon);
		$this->set('displaymode',$displaymode);

		/*if (null !== $this->request->getData('f_search')) 
		{
			 $rb_period = $this->request->getData('r_period');
			 print_r($rb_period);exit;
			 if ($rb_period == 'period') 
			 {

				 //$recordsResults = $this->Returnslist->getFilteredReturnsList($applicant_id);
				 $recordsResults= $this->getFilteredReturnsList($applicant_id);
			}	
			else
			{
				$recordsResults = array();
			}

		}*/

        $pendinglistTicket = $this->MmsRaisingTickets->find('all')
        			->where(['status'=>'Pending']) 	
                    ->order('id')
                    ->toArray();

        // echo '<pre>'; print_r($listTicket);die;
        $this->set('pendinglistTicket',$pendinglistTicket);

        $inprocesslistTicket = $this->MmsRaisingTickets->find('all')
        			->where(['status'=>'Inprocess']) 	
                    ->order(['updated_at' => 'DESC'])
                    ->toArray();
        $this->set('inprocesslistTicket',$inprocesslistTicket);

        $resolvelistTicket = $this->MmsRaisingTickets->find('all')
        			->where(['status'=>'Closed']) 	
                    ->order(['updated_at' => 'DESC'])
                    ->toArray();
        $this->set('resolvelistTicket',$resolvelistTicket);

        $AllTicketList = $this->MmsRaisingTickets->find('all')	
                    ->order('id')
                    ->toArray();
        $this->set('AllTicketList',$AllTicketList);

        // echo '<pre>'; print_r($listTicket);die;	
        
        

        //echo '<pre>'; print_r($resolvelistTicket);die;
        
        /*$pending_result =  $this->connection->newQuery() 	
							   ->select('*')
							  ->from('mms_raising_tickets')
							  ->where(['status'=>'pending']) 	
							  ->execute()
							  ->fetchAll('assoc');	
		echo"<pre>";print_r($pending_result);exit;*/
			
		/*switch($status)
		{
			
			case 'pending':

			$page_title = "Pending Ticket List";
			$btn_tooltip = "Edit";
			$btn_icon = "fa fa-edit";
			$displaymode = 'edit';
			$penListQuery = $this->connection->execute("
                            SELECT * FROM mms_raising_tickets
							WHERE status = 'pending'
							ORDER BY id ASC");
            $pendingListArr = $penListQuery->fetchAll('assoc');
            $pendingTicketstatusList = array();
            foreach($pendingListArr as $key=>$val){
                $pendingTicketstatusList[$key] = $val;
            }
                //echo"<pre>";print_r($pendingTicketstatusList);exit;
            
			break;

			case 'inprocess':

				$page_title = "Inprocess Ticket List";
				$btn_tooltip = "View";
				$btn_icon = "fa fa-eye";
				$displaymode = 'view';
				$processListQuery = $this->connection->execute("
		                        SELECT * FROM mms_raising_tickets
								WHERE status = 'inprocess'
								ORDER BY id ASC");
		            //$stateListArr = $stateListQuery->fetchAll('assoc');
		            $inprocessListArr = $processListQuery->fetchAll('assoc');
		            $inprocessTicketstatusList = array();
		            foreach($inprocessListArr as $key=>$val){
		                $inprocessTicketstatusList[$key] = $val;
		            }
				break;

			case 'resolve':
			$page_title = "Resolved Ticket List";
			$btn_tooltip = "View";
			$btn_icon = "fa fa-eye";
			$displaymode = 'view';
            $resolveListQuery = $this->connection->execute("
                        SELECT * FROM mms_raising_tickets
						WHERE status = 'resolve'
						ORDER BY id ASC");
            //$stateListArr = $stateListQuery->fetchAll('assoc');
            $resolveListArr = $resolveListQuery->fetchAll('assoc');
            $resolveTicketstatusList = array();
            foreach($resolveListArr as $key=>$val){
                $resolveTicketstatusList[$key] = $val;
            }
		    break;
			
			default:
			$page_title = "Ticket List";
			$btn_tooltip = "View";
			$btn_icon = "fa fa-eye";
			$displaymode = 'view';
			$penListQuery = $this->connection->execute("
                            SELECT * FROM mms_raising_tickets
							WHERE status = 'pending'
							ORDER BY id ASC");
                //$stateListArr = $stateListQuery->fetchAll('assoc');
                $pendingListArr = $penListQuery->fetchAll('assoc');
                $pendingTicketstatusList = array();
                foreach($pendingListArr as $key=>$val){
                    $pendingTicketstatusList[$key] = $val;
                }
		}*/
		$this->render('/support/ticket_list');
		/*$this->set('pendinglistTicket', $pendinglistTicket);		
        $this->set('inprocesslistTicket', $inprocesslistTicket);		
        $this->set('resolvelistTicket', $resolvelistTicket);	*/	
     
    }
    /*==========All Ticket List Shown============================= */
    /*public function allTicketList()
    {
    	$this->viewBuilder()->setLayout('support_panel');

    		$page_title = "All Ticket List";
			$btn_tooltip = "Edit";
			$btn_icon = "fa fa-edit";
			$displaymode = 'edit';

		$this->set('page_title',$page_title);
		$this->set('btn_tooltip',$btn_tooltip);
		$this->set('btn_icon',$btn_icon);
		$this->set('displaymode',$displaymode);

		$AllTicketList = $this->MmsRaisingTickets->find('all')	
                    ->order('id')
                    ->toArray();
        $this->set('AllTicketList',$AllTicketList);
        $this->render('/support/all_ticket_list');


    }*/

    /*public function getFilteredReturnsList($applicantid){

			$listData = null;
			$filter = $this->Customfunctions->validateServerSide($applicantid,$fromDate,$toDate,$status,$tablename,$returntype,$statusType,$isCount);
			
			$applicantid = ($applicantid != "") ? "'$applicantid'" : "''";
			
			if($filter == 'tampared'){
				
				return 'filterDataTampared';
				
			}
			else
			{
				$conn = ConnectionManager::get(Configure::read('conn'));
				$listData = $conn->execute("CALL SP_GetUserReturns($applicantid)")->fetchAll('assoc');
				print_r($listData);exit;
				
				return $listData; 
			}
		}*/

	/*public function search()
	{
		$this->autoRender = false;
		$this->loadModel('MmsRaisingTickets');
		//print_r($this->request->getData('query'));exit;
	    $query = $this->request->getData('query');
	    //print_r($query);exit;
	    $results = $this->MmsRaisingTickets->find()->where(['token IN' =>$query])->toArray();

	    print_r($results);exit;
	    $this->set(compact('results'));
	    $this->viewBuilder()->setLayout(false);
	}*/

    public function fetchFileId($token,$id) {

    	//echo"<pre>";print_r($token);
    	//echo"<pre>";print_r($id);exit;
		$this->Session->write('token_id',$token);
		$this->Session->write('id',$id);
		$this->redirect(array('controller'=>'SupportMod','action'=>'ticket_view'));

	}

	public function ticketView()
	{
		//echo"<pre>";print_r($_SESSION);exit;
		$this->viewBuilder()->setLayout('support_panel');
		$token_id = $this->Session->read('token_id');
		$ticket_record_id = $this->Session->read('id');
		$support_team_id = $this->Session->read('applicantid');
		$username = $this->Session->read('username');
		


		$getTicketDetails = $this->MmsRaisingTickets->find('all',array('conditions'=>array('id IS'=>$ticket_record_id)))->first();
		//echo"<pre>";print_r($getTicketDetails);exit;
		//[attachment] => /writereaddata/IBM/files/ticket/1682599752644a6f48cb209logoE-police.jpg

		$token_number = $getTicketDetails['token'];
		$reference_no = $getTicketDetails['reference_no'];
		$Ticketstatus = $getTicketDetails['status'];
		$ticket_type = $getTicketDetails['ticket_type'];
		$issued_raise_at = $getTicketDetails['issued_raise_at'];
		$issued_type = $getTicketDetails['issued_type'];
		$description = $getTicketDetails['description'];
		$form_submission = $getTicketDetails['form_submission'];
		$form_type_monthly = $getTicketDetails['form_type_monthly'];
		$form_type_annual = $getTicketDetails['form_type_annual'];
		$other_issue_type = $getTicketDetails['other_issue_type'];
		$attachment = $getTicketDetails['add_more_attachment'];
		$attachDescription = $getTicketDetails['add_more_description'];
		$created_at = $getTicketDetails['created_at'];

		//$explodeAttach = explode('/',$attachment);
		$explodeAttach = explode(',',$attachment);
		//$splitLinkCount = count($explodeAttach);
		//$getSent = $explodeAttach[$splitLinkCount - 1];

		$getAttach =array();

		/*if(!empty($explodeAttach[0])){
			$getAttach =$explodeAttach;
		}*/
		//print_r($getAttach);exit;

		if(count($explodeAttach)!=0){

		$getAttach =$explodeAttach;
		}
		 //print_r($getAttach);exit;



		$explAttchDescript = explode(',',$attachDescription);
		$getAttachDescript =array();

		$getAttachDescript=$explAttchDescript;
		
		/*foreach($getAttachDescript as $descRow)
		{
			$eachrow=$descRow;
		}*/
		//echo"<pre>";print_r($getAttachDescript);exit;

		$this->set('token_number',$token_number);
		$this->set('reference_no',$reference_no);
		$this->set('ticket_type',$ticket_type);
		$this->set('issued_raise_at',$issued_raise_at);
		$this->set('issued_type',$issued_type);
		$this->set('description',$description);
		$this->set('form_submission',$form_submission);
		$this->set('form_type_monthly',$form_type_monthly);
		$this->set('form_type_annual',$form_type_annual);
		$this->set('other_issue_type',$other_issue_type);
		$this->set('attachment',$attachment);
		$this->set('explodeAttach',$explodeAttach);
		//$this->set('getSent',$getSent);
		$this->set('getAttach',$getAttach);
		$this->set('getAttachDescript',$getAttachDescript);
		$this->set('created_at',$created_at);
		$this->set('support_team_id',$support_team_id);
		$this->set('Ticketstatus',$Ticketstatus);
		$this->set('ticket_record_id',$ticket_record_id);
		$this->set('username',$username);
		$this->render('/support/ticket_view');
		
	}

	/*
	//to preview uploaded file
	public function fileView() {

		$this->authenticateUserForCms();
		$this->loadModel('mpFileUploads');

		$file_id = $this->Session->read('file_id');
		$get_file_path = $this->mpFileUploads->find('all',array('fields'=>'file','conditions'=>array('id IS'=>$file_id)))->first();

		$view_file = $get_file_path['file'];

		$this->set('view_file',$view_file);

	}
	*/
	public function saveTakenStatus()
	{	
		
		
		$ticket_record_id = htmlentities($_REQUEST['ticket_record_id'], ENT_QUOTES);
		//echo"<pre>";print_r($ticket_record_id);exit;
		$token_number = htmlentities($_REQUEST['token_number'], ENT_QUOTES);
		$support_team_id = htmlentities($_REQUEST['support_team_id'], ENT_QUOTES);
        $username = htmlentities($_REQUEST['username'], ENT_QUOTES);
        $edit = htmlentities($_REQUEST['edit'], ENT_QUOTES);


        $this->loadModel('Support');
        $this->loadModel('TicketTakenStatus');
        $this->loadModel('MmsRaisingTickets');
			
		
		$date= date('Y-m-d H:i:s');

		/*$condition="id='".$ticket_record_id."' AND token_number='".$token_number."'";
		$data = array(
								'status'=>'inprocess',							
								'updated_at'=>$date,							
							);
		$this->Support->updateData('mms_raising_tickets',$data,$condition);
			*/
            

         	/*$ticketstatus_data = $this->connection->newQuery()
							->select('*')
							->from('mc_applicant_det')
							->where(['mcappd_app_id'=>$userName])
							->execute()
							->fetch('assoc');*/

			//$this->MmsRaisingTickets->UpdateDatabyId($ticket_record_id,$token_number);
			//echo"<pre>";print_r($upd_data);exit;
           /* //$result = false;
			$save = $this->Support->query();

			$save->update()
				->set(['status'=>'inprocess', 'updated_at'=>$date])
				->where(['id'=>$ticket_record_id])
				->execute();
			$this->last_query($save);exit;*/
			
	
			/*if($save) 
			{
	            $result = 1;
			}
	        return $result;*/

	        /*Update TicketRaising Table*/

		    $Entity = $this->MmsRaisingTickets->newEntity(array(
	                'id'=>$ticket_record_id,
	                'token_number'=>$token_number,
	                'status'=>'Inprocess',							
	                'support_team_id'=>$support_team_id,							
	                'support_firstname'=>$username,							
					'updated_at'=>$date,	
	                
	            ));
            $this->MmsRaisingTickets->save($Entity);

            /*Insert TicketTaken Status Inprocess */

			$newEntity = $this->TicketTakenStatus->newEntity(array(
									'ticket_record_id'=>$ticket_record_id,
									'token_number'=>$token_number,
									'support_team_id'=>$support_team_id,
									'status'=>'inprocess',
									'created_on'=>$date									
								));
			if($this->TicketTakenStatus->save($newEntity))
			{
				$this->Session->write('mon_f_suc', '<b>Allocate Record Updated Successfully!');

			}
			else
			{
				$this->Session->write('mon_f_err', '<b>Problem In Ticket Allocte,Please Try Again Later.</b>');
			}

			echo 1;exit;
			
			/*if($query)
			{	
				echo 'success';
			}
			else
			{
				echo 'error';
			}*/
		
	}

	/*=========================For Inprocess to Resolved Status=============================*/

	public function fetchResolveId($token,$id) {

    	//echo"<pre>";print_r($token);
    	//echo"<pre>";print_r($id);exit;
		$this->Session->write('token_id',$token);
		$this->Session->write('id',$id);
		$this->redirect(array('controller'=>'SupportMod','action'=>'view_inprocess_ticket'));

	}
	public function viewInprocessTicket()
	{
		//echo"<pre>";print_r($_SESSION);exit;
		$this->viewBuilder()->setLayout('support_panel');
		$token_id = $this->Session->read('token_id');
		$ticket_record_id = $this->Session->read('id');
		$support_team_id = $this->Session->read('applicantid');

		$session_support_team_id = $this->Session->read('applicantid');
		$username = $this->Session->read('username');
		


		$getTicketDetails = $this->MmsRaisingTickets->find('all',array('conditions'=>array('id IS'=>$ticket_record_id)))->first();
		//echo"<pre>";print_r($getTicketDetails);exit;
		//[attachment] => /writereaddata/IBM/files/ticket/1682599752644a6f48cb209logoE-police.jpg

		$token_number = $getTicketDetails['token'];
		$reference_no = $getTicketDetails['reference_no'];
		$ticket_type = $getTicketDetails['ticket_type'];
		$issued_raise_at = $getTicketDetails['issued_raise_at'];
		$issued_type = $getTicketDetails['issued_type'];
		$description = $getTicketDetails['description'];
		$form_submission = $getTicketDetails['form_submission'];
		$form_type_monthly = $getTicketDetails['form_type_monthly'];
		$form_type_annual = $getTicketDetails['form_type_annual'];
		$other_issue_type = $getTicketDetails['other_issue_type'];
		$attachment = $getTicketDetails['add_more_attachment'];
		$attachDescription = $getTicketDetails['add_more_description'];
		$created_at = $getTicketDetails['created_at'];
		$suppTeam_id = $getTicketDetails['support_team_id'];
		$Ticketstatus = $getTicketDetails['status'];
		$support_firstname = $getTicketDetails['support_firstname'];

		/*$explodeAttach = explode('/',$attachment);*/
		$explodeAttach = explode(',',$attachment);
		//$splitLinkCount = count($explodeAttach);
		//$getSent = $explodeAttach[$splitLinkCount - 1];


		$getAttach =array();
		/*if(!empty($explodeAttach[0])){
			$getAttach =$explodeAttach;
		}*/
		if(count($explodeAttach)!=0){

		$getAttach =$explodeAttach;
		//print_r($getAttach);exit;
		}


		$explAttchDescript = explode(',',$attachDescription);
		$getAttachDescript =array();

		$getAttachDescript=$explAttchDescript;



		$inproIssueTypes = array('Operational'=>'Operational','DB_Related'=>'Database Related','API_Related'=>'API Related','External'=>'External','Training'=>'Training','Other_Module_Related'=>'Other Module Related');

            
        $this->set('inproIssueTypes',$inproIssueTypes);



		$this->set('token_number',$token_number);
		$this->set('reference_no',$reference_no);
		$this->set('ticket_type',$ticket_type);
		$this->set('issued_raise_at',$issued_raise_at);
		$this->set('issued_type',$issued_type);
		$this->set('description',$description);
		$this->set('form_submission',$form_submission);
		$this->set('form_type_monthly',$form_type_monthly);
		$this->set('form_type_annual',$form_type_annual);
		$this->set('other_issue_type',$other_issue_type);
		$this->set('attachment',$attachment);
		$this->set('explodeAttach',$explodeAttach);
		
		$this->set('getAttach',$getAttach);
		$this->set('getAttachDescript',$getAttachDescript);
		$this->set('created_at',$created_at);
		$this->set('support_team_id',$support_team_id);
		$this->set('session_support_team_id',$session_support_team_id);
		$this->set('suppTeam_id',$suppTeam_id);
		$this->set('ticket_record_id',$ticket_record_id);
		$this->set('username',$username);
		$this->set('Ticketstatus',$Ticketstatus);
		$this->set('support_firstname',$support_firstname);
		$this->render('/support/view_inprocess_ticket');
	}
	
	public function saveResolveStatus()
	{	
		/*echo"<pre>";print_r($_POST);
		echo"<pre>";print_r($_FILES);
		*/
		/*$ticket_record_id = htmlentities($_POST['ticket_record_id'], ENT_QUOTES);
		//echo"<pre>";print_r($ticket_record_id);exit;
		$token_number = htmlentities($_POST['token_number'], ENT_QUOTES);
		$support_team_id = htmlentities($_POST['support_team_id'], ENT_QUOTES);
        $username = htmlentities($_POST['username'], ENT_QUOTES);
        $description = htmlentities($_POST['description'], ENT_QUOTES);
        $add_more_description = htmlentities($_POST['add_more_description'], ENT_QUOTES);*/
        //$add_more_attachment = $_FILES['add_more_attachment']['name'];
        //echo"<pre>";print_r($add_more_attachment);exit;
      
        //print_r($mon_f_suc);exit;


         $formData = $this->request->getData();

         $formData['ticket_record_id']= $this->request->getData('ticket_record_id');
         //echo"<pre>";print_r($formData['ticket_record_id']);exit;
         $formData['token_number']= $this->request->getData('token_number');
         $formData['support_team_id']= $this->request->getData('support_team_id');
         $formData['username']= $this->request->getData('username');
         $formData['description']= $this->request->getData('description');
         $formData['inpro_issue_type']= $this->request->getData('inpro_issue_type');
         $formData['add_more_description']= $this->request->getData('add_more_description');
         $formData['add_more_attachment']= $this->request->getData('add_more_attachment');

        $mon_f_suc = $this->getRequest()->getSession()->read('mon_f_suc');
        //$mon_f_suc = $this->getRequest()->getSession()->read('mon_f_suc');
        
        //print_r($mon_f_suc);exit;

        $this->loadModel('Support');
        $this->loadModel('TicketTakenStatus');
        $this->loadModel('MmsRaisingTickets');
        $this->loadModel('SupportingAttachments');
			
		/*if (isset($formsData['add_more_description']) && !empty($formsData['add_more_description']))
         {
             $add_more_description_string = implode(',', $formsData['add_more_description']);

	         $add_more_description=$add_more_description_string;    

	           // echo '<pre>'; print_r($add_more_description);die;
         } */

         if (isset($_FILES['add_more_attachment']) && !empty($_FILES['add_more_attachment']['name'][0])) 
	     {

			$files = $formData['add_more_attachment'];

			$supportModCntrl = new SupportModController;
			$upload_result = array();

			foreach ($files as $file) 
			{

				$file_name = $file->getClientFilename();
				$file_size = $file->getSize();
				$file_type = $file->getClientMediaType();
				$file_local_path = $file->getStream()->getMetadata('uri');

				$ticket_attachment = true;



           		$upload_result[] = $supportModCntrl->Customfunctions->supportFileUploadLib($file_name,$file_size,$file_type,$file_local_path,$ticket_attachment); // calling file uploading function
         	}

                          
	         $attachment = array(); 
	         foreach ($upload_result as $result) 
	         {
		             // Verify that the current element is an array with two elements

	         	if (is_array($result) && count($result) == 2) {
		               $status = $result[0]; // Get the success/failure status of the file upload
		               $file_path = $result[1]; // Get the path or URL of the uploaded file
		               
		               if ($status == 'success') {
		               	$attachment[] = $result[1];
		                   // print_r($attachment);die;
		               } elseif($status == 'error') {
		               	session_destroy();
		               	echo $result[1];
		               	exit;
		               }else{
		               	$errors = true;
		               }
		             } 

		     }

           $attachments_string = implode(',', $attachment);
           // echo '<pre>'; print_r($attachments_string);die;
           $add_more_filename=$attachments_string;
                        
		}
	    /*else 
	    { 
	     	$add_more_filename = $formsData['add_more_old_other_attachment']; 
	 	}*/
                     
      	if (isset($formData['add_more_description']) && !empty($formData['add_more_description']))

         {
             $add_more_description_string = implode(',', $formData['add_more_description']);
	          $add_more_description=$add_more_description_string;    

	           // echo '<pre>'; print_r($add_more_description);die;
         }

         $newSupportDocEntity = $this->SupportingAttachments->newEntity(array(
         	'token_number_id'=>$formData['token_number'],
         	'ticket_record_id'=>$formData['ticket_record_id'],
         	'add_more_attachment'=>$add_more_filename,
         	'add_more_description'=>$add_more_description,						
         	'created_on'=>date('Y-m-d H:i:s'),
         	/*'updated_at'=>date('Y-m-d H:i:s')*/

         ));

         //echo '<pre>'; print_r($newSupportDocEntity);die;
	     $this->SupportingAttachments->save($newSupportDocEntity);
                  

        /*Update TicketRaising Table status field Resolved*/
		$date= date('Y-m-d H:i:s');

	    $ResolveEntity = $this->MmsRaisingTickets->newEntity(array(
                'id'=>$formData['ticket_record_id'],
                'token_number'=>$formData['token_number'],
                'status'=>'Closed',
                'support_team_id'=>$formData['support_team_id'],
                'support_firstname'=>$formData['username'],										
                'issue_category'=>$formData['inpro_issue_type'],							
                'reply'=>$formData['description'],							
				'updated_at'=>$date,	
				'reply_date'=>$date,	
                
            ));
        $this->MmsRaisingTickets->save($ResolveEntity);

        /*Insert TicketTaken Status Inprocess */

		$SavenewResolveEntity = $this->TicketTakenStatus->newEntity(array(
								'ticket_record_id'=>$formData['ticket_record_id'],
								'token_number'=>$formData['token_number'],
								'support_team_id'=>$formData['support_team_id'],
								'status'=>'closed',
								'created_on'=>$date									
							));
		$query=$this->TicketTakenStatus->save($SavenewResolveEntity);
		
		//echo $query;exit;
		//return true;
		$this->Session->write('mon_f_suc', '<b>Ticket Closed</b> successfully!');
		$this->redirect(array('controller'=>'SupportMod','action'=>'support_app','resolve'));
			
	}


	//======For Resolved List View Function 04-05-2023==================

	public function fetchClosedTicketId($token,$id)
	{
		$this->Session->write('token_id',$token);
		$this->Session->write('id',$id);
		$this->redirect(array('controller'=>'SupportMod','action'=>'view_resolved_ticket'));
	}
	public function viewResolvedTicket()
	{
		//echo"<pre>";print_r($_SESSION);exit;
		$this->viewBuilder()->setLayout('support_panel');
		$token_id = $this->Session->read('token_id');
		$ticket_record_id = $this->Session->read('id');
		$support_team_id = $this->Session->read('applicantid');

		$session_support_team_id = $this->Session->read('applicantid');
		$username = $this->Session->read('username');
		
		$getTicketDetails = $this->MmsRaisingTickets->find('all',array('conditions'=>array('id IS'=>$ticket_record_id)))->first();
		//echo"<pre>";print_r($getTicketDetails);exit;

		$token_number = $getTicketDetails['token'];

		$reference_no = $getTicketDetails['reference_no'];
		
		/*if(!empty($reference_no))
		{
			$reference_no = $getTicketDetails['reference_no'];
		}
		else
		{
			$reference_no = 'N/A';
		}*/
		$ticket_type = $getTicketDetails['ticket_type'];
		$issued_raise_at = $getTicketDetails['issued_raise_at'];
		$issued_type = $getTicketDetails['issued_type'];
		$description = $getTicketDetails['description'];
		$form_submission = $getTicketDetails['form_submission'];
		$form_type_monthly = $getTicketDetails['form_type_monthly'];
		$form_type_annual = $getTicketDetails['form_type_annual'];
		$other_issue_type = $getTicketDetails['other_issue_type'];
		$attachment = $getTicketDetails['add_more_attachment'];
		$attachDescription = $getTicketDetails['add_more_description'];
		$created_at = $getTicketDetails['created_at'];
		$suppTeam_id = $getTicketDetails['support_team_id'];
		$Ticketstatus = $getTicketDetails['status'];
		$support_firstname = $getTicketDetails['support_firstname'];

		/*$explodeAttach = explode('/',$attachment);*/
		$explodeAttach = explode(',',$attachment);
		//$splitLinkCount = count($explodeAttach);
		//$getSent = $explodeAttach[$splitLinkCount - 1];

		$getAttach =array();
		/*if(count($explodeAttach)!=0)
		{

			$getAttach =$explodeAttach;
			//print_r($getAttach);exit;
		}*/

		/*if(!empty($explodeAttach[0])){
			$getAttach =$explodeAttach;
		}*/

		if(count($explodeAttach)!=0){

		$getAttach =$explodeAttach;
		//print_r($getAttach);exit;
		}


		$explAttchDescript = explode(',',$attachDescription);
		$getAttachDescript =array();

		$getAttachDescript=$explAttchDescript;

		
		$this->set('token_number',$token_number);
		$this->set('reference_no',$reference_no);
		$this->set('ticket_type',$ticket_type);
		$this->set('issued_raise_at',$issued_raise_at);
		$this->set('issued_type',$issued_type);
		$this->set('description',$description);
		$this->set('form_submission',$form_submission);
		$this->set('form_type_monthly',$form_type_monthly);
		$this->set('form_type_annual',$form_type_annual);
		$this->set('other_issue_type',$other_issue_type);
		$this->set('attachment',$attachment);
		$this->set('explodeAttach',$explodeAttach);
		
		$this->set('getAttach',$getAttach);
		$this->set('getAttachDescript',$getAttachDescript);
		$this->set('created_at',$created_at);
		$this->set('support_team_id',$support_team_id);
		$this->set('session_support_team_id',$session_support_team_id);
		$this->set('suppTeam_id',$suppTeam_id);
		$this->set('ticket_record_id',$ticket_record_id);
		$this->set('Ticketstatus',$Ticketstatus);
		$this->set('support_firstname',$support_firstname);
		$this->set('username',$username);
		$this->render('/support/view_resolved_ticket');
	}

	//======For Perform Inprocess-Released-revert-to-Pending  04-05-2023 ==================
	public function saveReleaseStatus()
	{
		//echo"<pre>";print_r($_REQUEST);exit;
		$ticket_record_id = htmlentities($_REQUEST['ticket_record_id'], ENT_QUOTES);
		$token_number = htmlentities($_REQUEST['token_number'], ENT_QUOTES);
		$support_team_id = htmlentities($_REQUEST['support_team_id'], ENT_QUOTES);
        $username = htmlentities($_REQUEST['username'], ENT_QUOTES);

        //$this->loadModel('Support');
        $this->loadModel('MmsRaisingTickets');
        $this->loadModel('TicketTakenStatus');

        $date= date('Y-m-d H:i:s');

        /*Update TicketRaising Table status field Pending*/

	    $ReleaseEntity = $this->MmsRaisingTickets->newEntity(array(
                'id'=>$ticket_record_id,
                'token_number'=>$token_number,
                'status'=>'Pending',
                'support_team_id'=>'',
                'support_firstname'=>'',																	
				'updated_at'=>$date,
            ));
        $this->MmsRaisingTickets->save($ReleaseEntity);
        //echo"<pre>";print_r($test);exit;
        /*Insert TicketTaken Status Release */

		$SavenewReleaseEntity = $this->TicketTakenStatus->newEntity(array(
								'ticket_record_id'=>$ticket_record_id,
								'token_number'=>$token_number,
								'support_team_id'=>$support_team_id,
								'status'=>'released',
								'created_on'=>$date									
							));
		/*$query=$this->TicketTakenStatus->save($SavenewReleaseEntity);
		
		echo $query;exit;*/	
		if($this->TicketTakenStatus->save($SavenewReleaseEntity))
		{
			$this->Session->write('mon_f_suc', '<b>Ticket Record Released Successfully!');

		}
		else
		{
			$this->Session->write('mon_f_err', '<b>Problem In Ticket Released,Please Try Again Later.</b>');
		}

		echo 1;exit;
	}

	/*Reference View===============================*/

	public function viewReferenceFun($reference_no,$id)
	{
		$this->Session->write('reference_no',$reference_no);
		$this->Session->write('id',$id);
		$this->redirect(array('controller'=>'SupportMod','action'=>'view_reference'));
	}
	public function viewReference()
	{
		$this->viewBuilder()->setLayout('support_panel');
		$reference_no = $this->Session->read('reference_no');
		
		
		//echo"<pre>";print_r($_SESSION);exit;
		$token_id = $this->Session->read('token_id');
		//echo"<pre>";print_r($token_id);exit;

		$ticket_record_id = $this->Session->read('id');
		$support_team_id = $this->Session->read('applicantid');

		$session_support_team_id = $this->Session->read('applicantid');
		$username = $this->Session->read('username');
		
		$getTicketDetails = $this->MmsRaisingTickets->find('all',array('conditions'=>array('token IS'=>$reference_no)))->first();
		//echo"<pre>";print_r($getTicketDetails);exit;

		$token_number = $getTicketDetails['token'];
		$reference_no = $getTicketDetails['reference_no'];
		$ticket_type = $getTicketDetails['ticket_type'];
		$issued_raise_at = $getTicketDetails['issued_raise_at'];
		$issued_type = $getTicketDetails['issued_type'];
		$description = $getTicketDetails['description'];
		$form_submission = $getTicketDetails['form_submission'];
		$form_type_monthly = $getTicketDetails['form_type_monthly'];
		$form_type_annual = $getTicketDetails['form_type_annual'];
		$other_issue_type = $getTicketDetails['other_issue_type'];
		$attachment = $getTicketDetails['add_more_attachment'];
		$attachDescription = $getTicketDetails['add_more_description'];
		$created_at = $getTicketDetails['created_at'];
		$suppTeam_id = $getTicketDetails['support_team_id'];
		$Ticketstatus = $getTicketDetails['status'];
		$support_firstname = $getTicketDetails['support_firstname'];

		/*$explodeAttach = explode('/',$attachment);*/
		$explodeAttach = explode(',',$attachment);
		//$splitLinkCount = count($explodeAttach);
		//$getSent = $explodeAttach[$splitLinkCount - 1];

		$getAttach =array();
		/*if(count($explodeAttach)!=0)
		{

			$getAttach =$explodeAttach;
			//print_r($getAttach);exit;
		}*/

		/*if(!empty($explodeAttach[0])){
			$getAttach =$explodeAttach;
		}*/

		if(count($explodeAttach)!=0){

		$getAttach =$explodeAttach;
		//print_r($getAttach);exit;
		}


		$explAttchDescript = explode(',',$attachDescription);
		$getAttachDescript =array();

		$getAttachDescript=$explAttchDescript;

		
		$this->set('token_number',$token_number);
		$this->set('reference_no',$reference_no);
		$this->set('ticket_type',$ticket_type);
		$this->set('issued_raise_at',$issued_raise_at);
		$this->set('issued_type',$issued_type);
		$this->set('description',$description);
		$this->set('form_submission',$form_submission);
		$this->set('form_type_monthly',$form_type_monthly);
		$this->set('form_type_annual',$form_type_annual);
		$this->set('other_issue_type',$other_issue_type);
		$this->set('attachment',$attachment);
		$this->set('explodeAttach',$explodeAttach);
		
		$this->set('getAttach',$getAttach);
		$this->set('getAttachDescript',$getAttachDescript);
		$this->set('created_at',$created_at);
		$this->set('support_team_id',$support_team_id);
		$this->set('session_support_team_id',$session_support_team_id);
		$this->set('suppTeam_id',$suppTeam_id);
		$this->set('ticket_record_id',$ticket_record_id);
		$this->set('Ticketstatus',$Ticketstatus);
		$this->set('support_firstname',$support_firstname);
		$this->set('username',$username);
		$this->render('/support/view_reference');
	}


	/*Added By Yashwant 02-06-2023*/

	public function ticketReportList()
	{
		$this->autoRender = false;
		$this->viewBuilder()->setLayout('ticket_report_layout');
		$this->render('/support/ticket_report_list');
	}

	/*public function monthlyFilter()
	{
		$title = $this->request->getQuery('title');
		$subtype = null;

		if ($title == "report-M01a") 
		{
			$title = "report-M01";
			$subtype = "1";
		}
		if ($title == "report-M01b") 
		{
			$title = "report-M01";
			$subtype = "2";
		}

		$this->set('subtype', $subtype);
		$this->set('title', $title);

		$this->viewBuilder()->setLayout('report_layout');

		$queryMineral = $this->DirMcpMineral->find('list', [
			'keyField' => 'mineral_name',
			'valueField' => 'mineral_name',
		])
			->select(['mineral_name'])->order(['mineral_name' => 'ASC']);
		$minerals = $queryMineral->toArray();
		$this->set('minerals', $minerals);

		$queryState = $this->DirState->find('list', [
			'keyField' => 'state_code',
			'valueField' => 'state_name',
		])
			->select(['state_name']);
		$states = $queryState->toArray();
		$this->set('states', $states);
	}*/

	public function allStatusFilter()
	{
		//print_r($title = $this->request->getQuery('title'));exit;
		$this->viewBuilder()->setLayout('ticket_report_layout');
		
		$title = $this->request->getQuery('title');
		$subtype = null;

		if ($title == "report-filter") 
		{
			$title = "report-statusS1";
			$subtype = "1";
		}
		$this->set('subtype', $subtype);
		$this->set('title', $title);

		//Query For Ticket Form Type

		$queryTickFormType = $this->MmsRaisingTickets->find('list', [
			'keyField' => 'ticket_type',
			'valueField' => 'ticket_type',
		])
		->select(['ticket_type'])->group(['ticket_type'])->order(['ticket_type' => 'ASC']);
		$tFormType = $queryTickFormType->toArray();
		$this->set('tFormType', $tFormType);

		//Query For Ticket Status

		$queryTickStatus = $this->MmsRaisingTickets->find('list', [
			'keyField' => 'status',
			'valueField' => 'status',
		])
		->select(['status'])->group(['status'])->order(['status' => 'ASC']);
		$tStatus = $queryTickStatus->toArray();
		$this->set('tStatus', $tStatus);

		//Query For Ticket Token Number 

		$queryTickToken = $this->MmsRaisingTickets->find('list', [
			'keyField' => 'token',
			'valueField' => 'token',
		])
		->select(['token'])->group(['token'])->order(['token' => 'ASC']);
		$tToken = $queryTickToken->toArray();
		$this->set('tToken', $tToken);
		

		$queryTickReferenceNo = $this->MmsRaisingTickets->find('list', [
			'keyField' => 'reference_no',
			'valueField' => 'reference_no',
		])
		->select(['reference_no'])->group(['reference_no'])->order(['reference_no' => 'ASC']);
		$tReference = $queryTickReferenceNo->toArray();
		$this->set('tReference', $tReference);

		$this->render('/support/all_status_filter');
	}

	public function reportStatusS1()
	{
		$this->viewBuilder()->setLayout('ticket_report_layout');
		//print_r($this->request->getData());exit;
		//Array ( [returnType] => MONTHLY [from_date] => June 2023 [to_date] => June 2023 [ticket_type] => MPAS [status] => [token] => [reference_no] => [subtype] => 1 )
		if ($this->request->is('post')) 
		{
			$returnType = $this->request->getData('returnType');
			$fromDate = $this->request->getData('from_date');

			$year1='';
			$year2='';

			$fromDate = explode(' ', $fromDate);
			$month1 = $fromDate[0];
			$month1 = $year1 . $month1 . '-01';
			$month01 = explode('-', $month1);
			$monthno = date('m', strtotime($month1));
			$year1 = $fromDate[1];
			$from_date = $year1 . '-' . $monthno . '-01';


			$toDate = $this->request->getData('to_date');
			$toDate = explode(' ', $toDate);
			$month2 = $toDate[0];
			$month2 = $year2 . $month2 . '-01';
			$month02 = explode('-', $month2);
			$monthno = date('m', strtotime($month2));
			$year2 = $toDate[1];
			$to_date = $year2 . '-' . $monthno . '-01';



			$from = $month1 . ' ' . $year1;
			$to =  $month2 . ' ' . $year2;

			$showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

			//print_r($showDate);exit;

			$ticket_type = $this->request->getData('ticket_type');
			//$ticket_type = strtolower($ticket_type);


			$status = $this->request->getData('status');

			$token = $this->request->getData('token');
			$reference_no = $this->request->getData('reference_no');

			/*if ($minecode != '') {
				$minecode = implode('\', \'', $minecode);
			}*/

			$con = ConnectionManager::get('default');

			//  Changes query on 06-04-2022 by Shweta Apale
			$sql = "SELECT * FROM mms_raising_tickets mrt";

			if ($status == 'Pending') 
			{
				$sql .= " WHERE mrt.status = 'Pending'";
			}
			elseif($status == 'Inprocess')
			{
				$sql .= " WHERE mrt.status = 'Inprocess'";
			}
			elseif($status == 'Closed')
			{ 
				$sql .= " WHERE mrt.status = 'Closed'";
			}else
			{
				$sql .= " WHERE mrt.status != '' ";
			}

			if ($ticket_type != '') 
			{
				$sql .= " AND mrt.ticket_type = '$ticket_type'";
			}

			if ($token != '') {
				$sql .= " AND mrt.token = '$token'";
			}

			if ($reference_no != '') 
			{
				$sql .= " AND mrt.reference_no = '$reference_no'";
			}
			if($from_date !='' && $to_date !='')
			{
				$sql .= " AND mrt.created_at BETWEEN '$from_date' AND '$to_date'";
			}
			

			/*$sql .= " UNION SELECT m.MINE_NAME, m.lessee_owner_name, m.registration_no, s.state_name, d.district_name, EXTRACT(MONTH FROM rs.return_date)  AS showMonth, EXTRACT(YEAR FROM rs.return_date)  AS showYear,
            ml.mcmdt_ML_Area AS lease_area, rs.mine_code, rs.mineral_name, rs.qty, rs.grade, rs.type_concentrate AS metal_content,
            rs.smelter_step_sn AS rom_step_sn_5, rs.value, rs.return_date
            FROM
            tbl_final_submit tfs
			   INNER JOIN recov_smelter rs on rs.mine_code = tfs.mine_code
			   AND tfs.return_type = 'MONTHLY'
                INNER JOIN
            mine m ON m.mine_code = rs.mine_code
                INNER JOIN
            dir_state s ON m.state_code = s.state_code
                INNER JOIN
            dir_district d ON m.district_code = d.district_code
                AND d.state_code = s.state_code
                LEFT JOIN
            mc_minesleasearea_dt ml ON m.mine_code = ml.mcmdt_mineCode AND ml.mcmdt_status = 1 
            WHERE
             (rs.return_date BETWEEN '$from_date' AND '$to_date')
                AND rs.return_type = '$returnType' AND  tfs.is_latest = 1 AND tfs.return_type = 'MONTHLY'";*/

			$sql .= " order by token LIMIT 100"; // Added LIMIT condition on 08-03-2023 by Shweta Apale

			//print_r($sql);exit;
			$query = $con->execute($sql);

			// To count number of records
			$rowCount = $query->rowCount();
			//print_r($rowCount);exit;
			$records = $query->fetchAll('assoc');
			if (!empty($records)) {
				$lprint = $this->generateTicketS1($records, $showDate, $rowCount);
				$lfilenm = "ticket_reportS1_" . strftime("%d-%m-%Y"); //.$_SESSION['mms_user_email'];
				//$lfile = $this->createfileM04($lprint, $lfilenm);
				$this->set('lprint', $lprint);
				$this->set('lfilenm', $lfilenm);
				$this->set('records', $records);
				$this->set('showDate', $showDate);
				$this->set('rowCount', $rowCount);
			} else {
				$this->set('records', array());
				$alert_message = "<strong> Records Not Found!!! </strong>";
				$alert_redirect_url = "ticket-report-list";
				$alert_theme = "success";

				$this->set('alert_message', $alert_message);
				$this->set('alert_redirect_url', $alert_redirect_url);
				$this->set('alert_theme', $alert_theme);
			}
		}

		$this->render('/support/report_statusS1');
	}
	//-------------------------------------------------------------------------------
	public function generateTicketS1($records, $showDate, $rowCount)
	{
		$datarry = array();
		$lcnt = -1;
		$cnt = 0;
		$lcounter = 0;

		$lmineral_name = "";

		$lticket_type = "";
		$lstatus = "";
		$lreference_no = "";
		$ltoken = "";
		

		$ldistrict_name = "";
		$lmonthnm = "";
		$lyearnm = "";
		$lmincode = "";
		$lserialno = "";
		$lflg = "";
		$print = "";

		$oreopstk = array();		//Opening Stock of the Ore at concentrator/plant
			

		//if ($rowCount <= 15000) {
		// Changed table id by Shweta Apale on 08-03-2023
		// Added Export button and heading for excel on 09-03-2023 by Shweta Apale
		$print = '<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<h4 class="tHeadFont" id="heading1">Ticket Report - Pending,Inprocess & Closed ( With Filter Records )</h4>
						<div class="form-horizontal">
							<div class="card-body" id="avb">
								<h6 class="tHeadDate"  id="heading2">Date : From ' . $showDate . '</h6>
								<input type="button" id="downloadExcel" value="Export to Excel"> 
								<br /><br />
								<div class="table-responsive">
									<table class="table table-striped table-hover table-bordered compact" id="noDatatable">
										<thead class="tableHead">
											<tr>
												<th colspan="58" class="noDisplay" align="left">Ticket Report - Pending,Inprocess & Closed ( With Filter Records )  Date : From ' . $showDate . '</th>												
											</tr>
											<tr>
												<th rowspan="2">#</th>
												<th rowspan="2">Token Number</th>
                                                <th rowspan="2">Applicant ID</th>
                                                <th rowspan="2">Form Module</th>
                                                <th rowspan="2">Issue Raise By</th>
                                                <th rowspan="2">Issue Type</th>
                                                <th rowspan="2">Ticket Status</th>
                                                <th rowspan="2">Created Date</th>
											</tr>
										</thead>
										<tbody class="tableBody">';

		
		if ($rowCount > 75000) {
			array_pop($records);
		}
		foreach ($records as $record) 
		{

			if ($lticket_type != $record['ticket_type']) {
				$lticket_type = $record['ticket_type'];
				$lflg = "Y";
			}
			if ($lstatus != $record['status']) {
				$lstatus = $record['status'];
				$lflg = "Y";
			}
			if ($lreference_no != $record['reference_no']) {
				$lreference_no = $record['reference_no'];
				$lflg = "Y";
			}
			/*if ($lmonthnm != $record['showMonth']) {
				$lmonthnm  = $record['showMonth'];
				$lflg = "Y";
			}
			if ($lyearnm != $record['showYear']) {
				$lyearnm  = $record['showYear'];
				$lflg = "Y";
			}*/
			if ($ltoken != $record['token']) {
				$ltoken = $record['token'];
				$lflg = "Y";
			}

			if ($lflg == "Y" || $lcnt  >= 0) 
			{ 
				if ($lcnt >= 0) 
				{
					$larcount = count($oreopstk);


					$lrowspan = "";

					if ($larcount > 1)
						$lrowspan = " rowspan=" . $larcount . "";
						$lcounter += 1;
						$print .= '<tr>
						<td ' . $lrowspan . '>' . $lcounter . '</td>
						<td ' . $lrowspan . '>' . $token . '</td>	
						<td ' . $lrowspan . '>' . $applicant_id . '</td>
						<td ' . $lrowspan . '>' . $ticket_type . '</td>
						<td ' . $lrowspan . '>' . $issued_raise_at . '</td>												
						<td ' . $lrowspan . '>' . $issued_type . '</td>
						<td ' . $lrowspan . '>' . $status . '</td>
						<td ' . $lrowspan . '>' . $created_at . '</td>';
					
					if ($cnt > 0) $print .= '</tr>';
				}
				$lcnt++;

				$token = $record['token'];
				$applicant_id = $record['applicant_id'];
				$ticket_type = $record['ticket_type'];
				$issued_raise_at = $record['issued_raise_at'];
				$issued_type = $record['issued_type'];
				$status = $record['status'];
				$created_at = $record['created_at'];
				
				
			}
			
		}


		if ($lcnt >= 0) 
		{
			$larcount = count($oreopstk);
			

			$lrowspan = "";
			if ($larcount > 1)
				$lrowspan = " rowspan=" . $larcount . "";
			$lcounter += 1;
			$print .= '<tr>
			<td ' . $lrowspan . '>' . $lcounter . '</td>
			<td ' . $lrowspan . '>' . $token . '</td>	
			<td ' . $lrowspan . '>' . $applicant_id . '</td>
			<td ' . $lrowspan . '>' . $ticket_type . '</td>
			<td ' . $lrowspan . '>' . $issued_raise_at . '</td>												
			<td ' . $lrowspan . '>' . $issued_type . '</td>
			<td ' . $lrowspan . '>' . $status . '</td>
			<td ' . $lrowspan . '>' . $created_at . '</td>';

			for ($cnt = 0; $cnt < $larcount; $cnt++) 
			{
				if ($cnt > 0) $print .= '</tr><tr>';
			}
			$print .= '<tr> <th colspan="58" align="left"> Report Generated on : ' . date("Y-m-d h:i:sa") . '</th> </tr>';
			if ($cnt > 0) $print .= '</tr>';
		}
		$print .= '</tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
		</div>';

		return $print;
	}














}
?>
