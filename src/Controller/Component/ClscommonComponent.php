<?php	

	//To access the properties of main controller used initialize function.

	namespace app\Controller\Component;
	use Cake\Controller\Controller;
	use Cake\Controller\Component;
	
	use Cake\Controller\ComponentRegistry;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\EntityInterface;
	use Cake\Core\Configure;
	use Cake\Utility\Security;
	use SimpleXMLElement;
	
	class ClscommonComponent extends Component {
	
		
		public $components= array('Session','Sitemails');
		public $controller = null;
		public $session = null;

		public function initialize(array $config): void {
			parent::initialize($config);
			$this->Controller = $this->_registry->getController();
			$this->Session = $this->getController()->getRequest()->getSession();
		}
		
		public function loginuser($username,$password){
			
			$loginusertype = $this->Session->read('loginusertype');
			$randSalt = $this->Session->read('tkn1');
			$result = null;
			
			if($loginusertype == 'primaryuser')
			{
				$userLogTable = TableRegistry::get('McUserLog');
				
				$loadUrl = MineOwnerProfileUrl . $username . '/' . $password . '/' . $randSalt;
					
				try{
					
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $loadUrl);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$output = curl_exec($ch);	
					curl_close($ch);
					$xmlTree = new SimpleXMLElement($output);
					$xml = (array) $xmlTree;
					
				}catch (Exception $e) { 
					unset($xml);
				}
								
				if (isset($xml['complexUserDetails'])) {								
					$result = 'success';					
				}
				
			}elseif($loginusertype == 'authuser' || $loginusertype == 'enduser'){	
				
				$userTable = TableRegistry::get('McUser');
				$userLogTable = TableRegistry::get('McUserLog');
				
				$userData = $userTable->find('all', array('conditions'=> array('mcu_child_user_name' => $username)))->first();
					
				if(!empty($userData)){
					$dbPassword = $userData['mcu_sha_password'];
				}
				
			
			}elseif($loginusertype == 'mmsuser'){
				
				$userTable = TableRegistry::get('MmsUser');
				$userLogTable = TableRegistry::get('MmsUserLog');
				
				$userData = $userTable->find('all', array('conditions'=> array('user_name' => $username,'is_delete'=>0)))->first();
				if(!empty($userData)){
					$dbPassword = $userData['sha_password'];
				}
				
			}
			if($loginusertype != 'primaryuser'){
				
				if(!empty($dbPassword)){
					
					$sha256 = hash('sha512',$dbPassword.$randSalt);				
					if ($password == $sha256)
					{	
						$result = 'success';
					}
				}else{
					$result = 'resetpass';
				}	
			}	
				
			$last_24_hour = date('Y-m-d H:i:s', strtotime('-1 day'));
			$records = $userLogTable->find('all', array('conditions'=> array('uname' => trim($username),'login_time'=>$last_24_hour,
														 'status !='=>'LOCKED'),'order'=>array('id desc'),'limit'=>3))->toArray();														 
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
			}
			
			if($not_found_status == 0 && count($records) >= 3){			
				$result = null;
			}	

			return 	$result;		
		}


		/**
	     * FOR CREATING THE LINK AND UPDATING THE CORRESPONDING COLUMNS IN DATABASE
	     * FOR CHECKING THE VERIFICATION LINK LATER
	     * 
	     * @author: Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com> 
	     * @version: 5th Sep 2014
	     */
	    public function forgotPassword($user_id, $userName, $email, $tableName) {
	       
	        /**
	         * Added for solving the J&K issue, now replacing & with % and then sending the reset link
	         * @author Uday Shankar Singh <udayshankar1306@gmail.com, usingh@ubicsindia.com>
	         * @version 12th Feb 2016
	         */
			$user_name_for_email_message = $userName;
	        if(strpos($userName, '&') != FALSE){
	            $userName = str_replace('&', 'strrepp', $userName);
	        }else{
	            $userName = $userName;
	        }
			//print_r($userName); exit;
	        $userNameEncrypt = strrev(str_rot13(str_replace("/", "-", $userName)));

	        $newPwd = $this->createRandomPassword();
	        //$newPwdEncrypt = md5($newPwd);
			// Changed MD5 hashing to sha512 hashing, Done By Pravin Bhakare, 26/05/2020
			$newPwdEncrypt = hash('sha512',$newPwd);								  

	        $encodedString = $userNameEncrypt . "-" . $newPwdEncrypt;

	        $dateTime = strtotime(date("Y-m-d G:i:s")); // CONVERTING THE DATE TO STR AND TIME SO THAT COMPARISION WILL BE EASY

	        $dataToSave = $dateTime . "-" . $newPwdEncrypt;

	        /**
	         * SETTING THE CONDITION FOR CHECKING IF WE REALLY NEED TO UPDATE THE 
	         * TABLE FOR FORGOT PASSWORD 
	         */
	        $update = false;
	        if ($tableName == 'McUser') {
	            $passwordField = 'mcu_sha_password';
	            $flagField = 'mcu_pass_change_status';
	            $id = 'mcu_user_id';
	            $update = true;
	            $linkToSend = "/auth/" . $encodedString; // ENCODED STRING MUST BE LESS THEN 50 WORDS, AS DB LENTH IS 50
	            $userType = "auth";
	        } else if ($tableName == 'MmsUser') {
	            $passwordField = 'sha_password';
	            $flagField = 'is_pwd_changed';
	            $id = 'id IS';
	            $update = true;
	            $linkToSend = "/mms/" . $encodedString; // ENCODED STRING MUST BE LESS THEN 50 WORDS, AS DB LENTH IS 50
	            $userType = "mms";
	        }
	        else
	            return false;
			
	        if ($update == true) {

	        	$user_table = TableRegistry::getTableLocator()->get($tableName);

				$user_table->updateAll(
					array(
						$passwordField=>$dataToSave,
    					$flagField=>'1'),
					array(
						$id=>$user_id
						)
				);

	            $arrParams = array();
				$arrParams['user_name'] = $user_name_for_email_message;
	            $arrParams['toEmailAddress'] = $email;
	            $arrParams['link'] = $linkToSend;
	            $arrParams['new_pwd'] = $newPwd;

                $status = $this->Sitemails->forgotPwdEmail($arrParams, $userType);
				
				// send sms
				// $customer_id = $userName;
				// $DirSmsEmailTemplates = TableRegistry::getTableLocator()->get('DirSmsEmailTemplates');
				// $DirSmsEmailTemplates->sendMessage(7,$customer_id);
				
	        }
	    }

	    //create randam password for user
	    public function createRandomPassword() {
	        $chars = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
	        srand((double) microtime() * 1000000);
	        $i = 0;
	        $pass = '';
	        while ($i <= 7) {
	            $num = rand() % 33;
	            $tmp = substr($chars, $num, 1);
	            $pass = $pass . $tmp;
	            $i++;
	        }
	        return $pass;
	    }


	    //fetch email containt by key
	    public function getSiteEmails($emailKey) {
	        if (!$emailKey){
	            return false;
	        }

			$SiteEmail = TableRegistry::getTableLocator()->get('SiteEmails');

	        $objSiteEmails = $SiteEmail->find('all', array('conditions'=> array('email_key'=>$emailKey)))->first();

	        return $objSiteEmails;
	    }

	    /**
	     * FOR CREATING THE LINK AND UPDATING THE CORRESPONDING COLUMNS IN DATABASE
	     * FOR CHECKING THE VERIFICATION LINK LATER
	     * 
	     * @author: Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com> 
	     * @version: 5th Sep 2014
	     */
	    public function updatePassword($resetLink, $tableName, $newPassword) {

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
	        if ($tableName == 'McUser') {
	            $passwordField = 'mcu_password';
				$shaPasswordField = 'mcu_sha_password';							  
	            $flagField = 'mcu_pass_change_status';
	            $userNameField = 'mcu_child_user_name';
				$userNameValue = $userName;
	            $id = 'mcu_user_id';
	            $update = true;
	        } else if ($tableName == 'MmsUser') {
				$userName = str_replace("/", "-", str_rot13(strrev($encryptedUserName))); // USER NAME TO FIND RECORD
	            $passwordField = 'password';
				$shaPasswordField = 'sha_password';						  
	            $flagField = 'is_pwd_changed';
	            // $userNameField = 'user_name';
	            $userNameField = 'email';
				$userNameValue = base64_encode($userName);
	            $id = 'id';
	            $update = true;
	        }
	        else
	            return false;

	        if ($update == true) {

	        	$user_table = TableRegistry::getTableLocator()->get($tableName);

				// $newEntity = $user_table->newEntity(array(
				// 					$userNameField=>$userName,
				// 					$flagField=>'0',
				// 					$passwordField=>$newPassword,
				// 					$shaPasswordField=>$newPassword
				// 				));		
				// if($user_table->save($newEntity)){
				// 	return '1';
				// } else {
				// 	return '0';
				// }
				
				// CHECK LAST THREE PASSWORD WITH NEW PASSWORD
				$PasswordLogs = TableRegistry::getTableLocator()->get('PasswordHistory');
				$userType = ($tableName == 'McUser') ? 'auth' : 'mms';
				$checkPastThreePassword = $PasswordLogs->checkPastThreePassword($userName,$newPassword,$userType);

				if ($checkPastThreePassword == 'found') {
					return 4;
					exit;
				}

				$reset = $user_table->find('all', array('conditions'=>array($userNameField=>$userNameValue)))->first();
	        	$dbPassword = $reset[$shaPasswordField];

	            $explodePassword = explode("-", $dbPassword);

	            $dateTimeToCheck = $explodePassword[0];
	            $passwordToCheck = $explodePassword[1];

	            // NOW COMPARING THE PASSWORD WITH DATABASE PASSSWORD AND THEN REDIRECTING BACK TO RESET PAGE FOR FURTHER ACTION
				
            	$twentyFourHrIncTime = $dateTimeToCheck + 24*60*60;
				//print_r($dateTimeToCheck . '--'.$passwordToCheck);exit;
            	if ($dateTimeToCheck <= $twentyFourHrIncTime) { // 1st CONDITION VERIFIED
            		if ($passwordSent == $passwordToCheck) { // 2nd CONDITION VERFIED

            			if($user_table->updateAll(
							array(
								$flagField=>'0',
								$passwordField=>$newPassword,
								$shaPasswordField=>$newPassword),
							array(
								$userNameField=>$userNameValue
								)
						)){
            				$result = '1';
						} else {
            				$result = '0';
						}

            		}
            	} else {
            		$result = '0';
            	}

            	return $result;

				
	        }
	    }

		/**
		 * PARTIALLY HIDE EMAIL ADDRESS FOR SECURITY PURPOSE
		 * By Aniket Ganvir dated 07th DEC 2020
		 */
		public function partialHideEmail($email) {
			
			$parts = explode("@", $email);
			$username = strlen($parts[0]);
			if($username >= 5){
				$emailUsernameCount = strlen($parts[0]) - 2;
				$starCount = 2;
			}else{
				$emailUsernameCount = strlen($parts[0]) - 1;
				$starCount = 1;
			}
			$crossString = "";
			for($i = 1; $i <= $emailUsernameCount; $i++) {
				$crossString = $crossString . "*";
			}

			$partialEmail = substr($email, 0, $starCount) . $crossString . substr($email, strpos($email, "@"));
			return $partialEmail;
			
		}

	    public function changeDateFormat($timestamp) {
	        $date = explode(' ', $timestamp);
	        $temp = explode('-', $date[0]);
	        $formatted_date = $temp[2] . "-" . $temp[1] . "-" . $temp[0];

	        return $formatted_date;
	    }
		
	    public function globalDateFormat($timestamp) {
	        $date = explode(' ', $timestamp);
	        $temp = explode('-', $date[0]);

			if(count($temp) >= 3){
				$formatted_date = $temp[2] . "-" . $temp[1] . "-" . $temp[0];
			} else {
				$formatted_date = date('d-m-Y', strtotime($date[0]));
			}

	        return $formatted_date;
	    }

		//get grade
		public function getGradeArr($mineral, $returnDate = null) {
			if ($mineral == ''){
				$mineral = 'IRON ORE';
			}

			$cutoffDate = Configure::read('cutoff_date');
        	$dirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
			$formType = $dirMcpMineral->getFormNumber($mineral);

			if ($formType == 5){
				if($returnDate >= $cutoffDate){
					$dirMineralGrade = TableRegistry::getTableLocator()->get('DirMineralGrade');
					$gradeArr = $dirMineralGrade->getGradsbyNameForF2($mineral, $returnDate);
				}else{
					$dirMetal = TableRegistry::getTableLocator()->get('DirMetal');
					$gradeArr = $dirMetal->getDropDownMetalList($mineral);
				}
			} else if ($formType == 7){
				if($returnDate >= $cutoffDate){
					$dirMineralGrade = TableRegistry::getTableLocator()->get('DirMineralGrade');
					$gradeArr = $dirMineralGrade->getGradsbyNameForF2($mineral, $returnDate);
				}else{
					$dirStoneType = TableRegistry::getTableLocator()->get('DirStoneType');
					$gradeArr = $dirStoneType->fetchStoneGrades();
				}
			} else {
        		$dirMineralGrade = TableRegistry::getTableLocator()->get('DirMineralGrade');
				$gradeArr = $dirMineralGrade->getGradsbyName($mineral, $returnDate);
			}
			return $gradeArr;
		}

	    /**
	     * FUNCTION RETURNS THE FORM NUMBER BASED ON:
	     * 1. formName from the url
	     * 2. formNo from Session 
	     */
	    public function getFormNoFAndH($defaultValue = 'FALSE') {

	        // In this function add the some code for fetch the form no by using the mineral and pass the form no and comment the f8 form case.
	        // added by ganesh satav and uday singh dated by 17 july 2014
	        if ($defaultValue == 'FALSE') {
	            $userFormNo = 'F' . $this->Session->read('mc_form_type');
	        } else if ($defaultValue == 'TRUE') {
	            $userMineral = $this->Session->read('mc_mineral');
	        	$dirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
	            $userFormNo = $dirMcpMineral->getFormNumber($userMineral);
	            $userFormNo = 'F' . $userFormNo;
	        }

	        // ALL OF THE ABOVE AS COMMON FORM NO, SO NO NEED TO CHANGE THEM
	        switch ($userFormNo) {
	            case 'F1':
	            case 'F2':
	            case 'F3':
	            case 'F4':
	            case 'F7':
	            case 'F8':
	                $leftNavArr = Array(
	                    'deductions_details' => 3,
	                    'sales_despatches' => 4
	                );
	                break;
	            case 'F5':
	                $leftNavArr = Array(
	                    'deductions_details' => 6,
	                    'sales_despatches' => 7
	                );
	                break;
	            case 'F6':
	                $leftNavArr = Array(
	                    'deductions_details' => 2,
	                    'sales_despatches' => 3
	                );
	                break;
	//            case 'F8':
	//                $leftNavArr = Array(
	//                    'deductions_details' => 4,
	//                    'sales_despatches' => 5
	//                );
	//                break;
	        }

	        return $leftNavArr;
	    }

        public function getFormRuleNumber($formNumber) {

	        switch ($formNumber) {
	            case 1:
	                return "(i)";
	                break;
	            case 2:
	                return "(ii)";
	                break;
	            case 3:
	                return "(iii)";
	                break;
	            case 4:
	                return "(iv)";
	                break;
	            case 5:
	                return "(v)";
	                break;
	            case 6:
	                return "(vi)";
	                break;
	            case 7:
	                return "(vii)";
	                break;
	            case 8:
	                return "(viii)";
	        }
	    }

	    //get Reasons array
	    public function getReasonsArr() {
        	$dirWorkStoppage = TableRegistry::getTableLocator()->get('DirWorkStoppage');
	        $reasonsArr = $dirWorkStoppage->fetchReasonsArr();
	        return $reasonsArr;
	    }


	    public function getChemRep($mineral_name) {

	        $mineral = strtolower(str_replace(' ', '_', $mineral_name));

	        switch ($mineral) {
	            case ("iron_ore"):
	                $chem_rep = "Fe";
	                break;

	            case ("manganese_ore"):
	                $chem_rep = "Mn";
	                break;

	            case ("bauxite"):
	            case ("laterite"):
	                $chem_rep = "Al<sub>2</sub>O<sub>3</sub>";
	                break;

	            case ("chromite"):
	                $chem_rep = "Cr<sub>2</sub>O<sub>3</sub>";
	                break;

	            default:
	            	$chem_rep = '';
	        }
	        return $chem_rep;
	    }


	    public function sendRejectionMail($return_id, $mineCode, $returnDate) {

	    	$tblFinalSubmit = TableRegistry::get('TblFinalSubmit');
	    	$mcUser = TableRegistry::get('McUser');
	        $return = $tblFinalSubmit->findReturnById($return_id);
	        /**
	         *  ADDED
	         * $verifiedBy = $return->getVerifiedFlag();
	         * $status = $return->getStatus();
	         * if ($verifiedBy == 2 && $status == 4) {
	         * AND IT'S ELSE CONDITION 
	         * CONDITION IS ADDED TO CHECK IF THE THE STATUS IS REJECTED AND THEN ONLY SEND THE MAIL
	         * SO THAT THE MAIL WILL GO ONLY ONCE PER RETURN
	         * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
	         * @version 9th July 2014
	         *
	         * */
	        $verifiedBy = $return['verified_flag'];
	        $status = $return['status'];

	        if ($verifiedBy == 2 && $status == 4) {
	            $submitted_by = $return['submitted_by'];
	            $mail_id = "";
	            $mine_user = $mcUser->findOneByMcuChildUserName($submitted_by);
	            if ($mine_user) {
	                $mail_id = $mine_user->getMcuEmail();
	                $user = $mine_user->getMcuFirstName();
	                $user_name = ($user != "") ? $user : $submitted_by;
	            }

	            if ($mail_id == "") {
	                $mine = Doctrine_Core::getTable('MINE')->findOneByMineCode($mineCode);
	                if ($mine) {
	                    $mail_id = $mine->getEmail();
	                    $owner = $mine->getLesseeOwnerName();
	                    $user_name = ($owner != "") ? $owner : "Sir/Madam";
	                }
	            }

	            $temp = explode('-', $returnDate);
	            $year = $temp[0];
	            $monthName = date("F", mktime(0, 0, 0, $temp[1], 1, 2011));

	            $mailParams['toEmailAddress'] = $mail_id;
	            $mailParams['user_name'] = $user_name;
	            $mailParams['month'] = $monthName . "/" . $year;
	            $mailParams['mineCode'] = $mineCode;
	            $mail = new siteMails();
	            try {
	                $sent = $mail->mmsReturnRejectionEmail($mailParams);
	            } catch (Exception $e) {
	                
	            }

	            if ($sent)
	                return true;
	            else
	                return false;
	        }
	        else
	            return true;
	    }

	    
	    /**
	     * This function create for the set form label with Serial no as per the FM 
	     * Guideliance
	     * 
	     * @param type $form id
	     * @param type $params
	     * @author Ganesh satav
	     */
	    public function getFormLabelNameWithFormNo($form, $returnType) {

			$elementLabel = '';
			$elementLabel1 = '';
			if ($returnType == 'ANNUAL'){
				$elementLabel = 'year';
			}
			else if ($returnType == 'MONTHLY'){
				$elementLabel = 'month';
			}
	
			if ($form == '5') {
				$elementLabel1 = 'of Ore and Concentrates';
			}
			// below changes do ganesh satav as per discuss with ajay sir change like space other
			// added by ganesh satav dated 12 sep 2014
			$labelNameArr = Array(
				'1' => "Type of Ore Produced",
				'2' => 'Production and Stocks of ROM ore at Mine-head',
				'3' => 'Grade-wise production, Despatches, Stocks and Ex-mine prices of Processed ore',
				'4' => 'Details of Deductions used for computation of Ex-mine price',
				'5' => 'Sales/Dispatches effected for Domestic Consumption and for exports',
				'6' => 'Give Reason for increase/decrease in production',
				'7' => "Give Reason for increase/decrease in grade wise ex-mine price",
				'8' => 'Production and Stocks of ROM ore',
				'9' => 'Ex-mine price of the ore produced',
				'10' => "Recoveries at Concentrator/Mill/Plant",
				'11' => "Sales during the $elementLabel",
				'12' => 'Details of Deduction used for computation of Ex-mine price of ore',
				'13' => "Sales/Despatches $elementLabel1 effected for Domestic Consumption and for Exports",
				'14' => 'Give Reason for increase/decrease in production',
				'15' => 'Give Reason for increase/decrease in grade wise ex-mine price',
				'16' => 'Production, despatches and stocks of crude and dressed mica',
				'17' => 'ROM Production',
				'18' => 'Production, stocks and dispatches',
				'19' => 'In case the mineral is being pulverised in own factory, please give the following particulars',
				'20' => 'Recovery at the Smelter/Mill/Plant',
				'21' => '(i) In case the mineral is being pulverised in own factory, please give the following particulars',
			);
	
			$labelArr = Array();
			$labelArr1 = Array();
			// $form = 5;
			$count = 1;
			switch ($form) {
				case 1:
					$numberArr = Array('', '1', '2', '3', '4', '5', '6', '7');
					break;
				case 2:
					$numberArr = Array('', '', '2', '3', '4', '5', '6', '7');
					break;
				case 3:
					$numberArr = Array('', '', '2', '3', '4', '5', '6', '7');
					break;
				case 4:
					$numberArr = Array('', '', '2', '3', '4', '5', '6', '7');
					break;
				case 5:
					$numberArr = Array('', '', '', '', '', '', '', '', '8', '9', '10', '20', '11', '12', '13', '14', '15', '16');
					break;
				case 6:
					$numberArr = Array('', '', '', '16', '4', '5', '6', '7');
					break;
				case 7:
					$numberArr = Array('', '', '17', '18', '4', '5', '6', '7');
					break;
				case 8:
					$numberArr = Array('', '', '2', '3', '4', '5', '6', '7', '21');
					break;
			}
	
			for ($i = 1; $i <= 19; $i++) {
				if ($form == '8') {
					if (isset($numberArr[$i]) && $numberArr[$i]) {
						if ($numberArr[$i] != '21') {
							if ($count < '3') {
								$labelArr[$i] = $count . ". " . $labelNameArr[$numberArr[$i]];
								$count++;
							} else {
								$labelArr[$i] = $count + 1 . ". " . $labelNameArr[$numberArr[$i]];
								$count++;
							}
						} else {
							$labelArr[$i] = "3. " . $labelNameArr[$numberArr[$i]];
						}
					}
					else
						$labelArr[$i] = "";
				}
				else {
					if (isset($numberArr[$i]) && $numberArr[$i]) {
	
						$labelArr[$i] = $count . ". " . $labelNameArr[$numberArr[$i]];
						$count++;
					}
					else
						$labelArr[$i] = "";
				}
			}
			//echo "<pre>"; print_r($labelArr); exit;
	
			return $labelArr;

	    }

		/**
		 * GET CLIENT IP ADDRESS
		 */
		public function getIpAddresses() {

			if (array_key_exists("HTTP_CLIENT_IP", $_SERVER) && !empty($_SERVER["HTTP_CLIENT_IP"])) {
				return $_SERVER["HTTP_CLIENT_IP"];
			} else if (array_key_exists("X_FORWARDED_FOR", $_SERVER) && !empty($_SERVER["X_FORWARDED_FOR"])) {
				return $_SERVER["X_FORWARDED_FOR"];
			} else {
				return $_SERVER["REMOTE_ADDR"];
			}
		}

		public function getDatePeriod($date = false, $returnType = false, $separator = false) {

			$monthArr = array(
				'01' => 'Jan',
				'02' => 'Feb',
				'03' => 'March',
				'04' => 'April',
				'05' => 'May',
				'06' => 'June',
				'07' => 'July',
				'08' => 'Aug',
				'09' => 'Sept',
				'10' => 'Oct',
				'11' => 'Nov',
				'12' => 'Dec'
			);
			if ($returnType == 'MONTHLY') {
				$getDate = explode("-", $date);
				return $monthArr[$getDate[1]] . $separator . $getDate[0];
			}
			else
				return '[' . $date . ']';

		}

		public function userTypeFullForm($activityType) {

			if ($activityType == 'T')
				$currActivity = 'Trading Activity';
			else if ($activityType == 'E')
				$currActivity = 'Export Activity';
			else if ($activityType == 'C')
				$currActivity = 'End-User Mineral Based Activity';
			else if ($activityType == 'S')
				$currActivity = 'Storage Activity';
			else if ($activityType == 'W')
				$currActivity = 'Trader Without Storage';
	
			return $currActivity;
			
		}

		/**
		 * @author Uday Shnakar Singh <usingh@ubicsindia.com>
		 * GETS ALL THE APPROVED AND REJECTED SECTIONS FOR RETURN FILLER
		 * 
		 * @param type $section
		 * @param type $partNo
		 * @param type $userType
		 * @return int
		 */
		public function getNOrOFinalSubmitData($section, $partNo, $userType) {

			//=======================GETTING SESSION VARIABLES==========================
			//===="regCode" OF SESSION IS SAME AS THE "registration_code"
			$regCode = $this->Session->read('registration_code');
			$returnType = $this->Session->read('returnType');
			$returnDate = $this->Session->read('returnDate');
			$formType = $this->Session->read('formType');
			$ibmUniqueRegNo = $this->Session->read('regNo');
			//=====================GETTING SESSION VARIABLES ENDS=======================

			if ($formType == 'N') {
				$getDate = $returnDate;
			} elseif ($formType == 'O') {
				$getDate = $returnDate;
			} else {
				print_r("OOPSsss....Something is wrong. Either you have opened multiple 
					browser tabs which is not allowed or something went seriously wrong.
					Kindly press back button of the browser then logout and try Again to login... 
					If the problem still persist kindly contact IBM regarding the same.");
				die;
			}

			//===========TO TBL_END_USER_FINAL_SUBMIT
			// $finalSubmitData = TBL_END_USER_FINAL_SUBMITTable::getDetailsForNOForAccepted($regCode, $returnType, $returnDate, $ibmUniqueRegNo, $formType);
			
			$tblEndUserFinalSubmit = TableRegistry::get('TblEndUserFinalSubmit');
			$finalSubmitData = $tblEndUserFinalSubmit->getDetailsForNO($regCode, $returnType, $returnDate, $ibmUniqueRegNo, $formType);

			if ($finalSubmitData > 0) {
				$resonData = Array();
				$resonData['count'] = COUNT($finalSubmitData) - 1;
				$resonData['countFlag'] = TRUE;
				for ($i = 0; $i < $finalSubmitData['count']; $i++) {
					$resonData['communication'][$i]['status_date'] = $this->globalDateFormat($finalSubmitData[$i]['status_date']);
					$resonData['communication'][$i]['rejectedSection'] = (isset($finalSubmitData[$i]['approved_sections'][$partNo][$section])) ? $finalSubmitData[$i]['approved_sections'][$partNo][$section] : '';
					$resonData['communication'][$i]['rejectedSectionReason'] = (isset($finalSubmitData[$i]['rejected_section_remarks'][$partNo][$section])) ? $finalSubmitData[$i]['rejected_section_remarks'][$partNo][$section] : '';
					$resonData['communication'][$i]['reply'] = (isset($finalSubmitData[$i]['reply'][$partNo][$section])) ? $finalSubmitData[$i]['reply'][$partNo][$section] : '';
					$resonData['communication'][$i]['previousReason'] = (isset($finalSubmitData[$i]['replied_section_remarks'][$partNo][$section])) ? $finalSubmitData[$i]['replied_section_remarks'][$partNo][$section] : '';
				}
				
				return $resonData;
			} else {
				return 0;
			}
			
		}

		/**
		 * @author Uday Shankar Singh <usingh@ubicsindia.com>
		 * 
		 * @param String $formType
		 * @param String $returnType
		 * @param String $returnDate
		 * @param String $endUserId
		 * @param String $userType
		 * @return Array
		 * 
		 * RETURNS THE DATA BASED ON THE DATE PASSED ....
		 */
		public function NSeriesPrevMonthVsCurrentData($formType, $returnType, $returnDate, $endUserId, $userType, $pdfStatus = 0) {

			//============GETS ALL UNIT IN ONE SHOT SHOW THAT NO NEED TO HIT DB AGAIN AND AGIN.. THIS WILL INCREASE THE PERFORMANCE
			$dirMcpMineral = TableRegistry::get('DirMcpMineral');
			$mineralUnit = $dirMcpMineral->getAllUnit();
			$mineralData = array();
			
			//CHECKING FOR CURRENT MONTH DATA ... AS IF THERE IS DATA NO NEED TO CHECK FOR PREV MONTH DATA
			$nSeriesProdActivity = TableRegistry::get('NSeriesProdActivity');
			$currentMonthCheck = $nSeriesProdActivity->checkForValue($formType, $returnType, $returnDate, $endUserId, $userType);
			//====IF COUNT OF CURRENT MONTH DATA IS 0 THEN STARTS===============
			if ($currentMonthCheck == 0) {
				//============CREATING PRECIOUS MONTH DATE======================
				if ($returnType == 'MONTHLY') {
					$prevMonthString = strtotime("$returnDate -1 month");
				} else if ($returnType == 'ANNUAL') {
					$prevMonthString = strtotime("$returnDate -1 year");
				}
				$prevMonthDate = date('Y-m-d', $prevMonthString);
				$prevReturnDate = $prevMonthDate;

				if ($returnType == 'ANNUAL') {
					/**
					 * Added following logic to prefetch cumulative monthly details in annual return
					 * Effective from Phase-II
					 * @version 01st Dec 2021
					 * @author Aniket Ganvir
					 */
					$mineralData = $nSeriesProdActivity->getSeriesActivityDetails($formType, $returnType, $returnDate, $endUserId, $userType, $pdfStatus);
					if (!isset($mineralData[0]['local_mineral_code'])) {
						$pervMonthMineralData = $nSeriesProdActivity->getSeriesActivityDetails($formType, $returnType, $prevReturnDate, $endUserId, $userType, $pdfStatus);
						if (isset($pervMonthMineralData[0]['local_mineral_code']) && $pervMonthMineralData[0]['local_mineral_code'] != 'NIL') { // THIS CHECK HADLES THE NIL CONDITION
							$inc = 0;
							foreach ($pervMonthMineralData as $data) {
								$mineralData[$inc]['opening_stock'] = $data['closing_stock'];
								$mineralData[$inc]['closing_stock'] = '';
								$mineralData[$inc]['remark'] = $data['remark'];
								$mineralData[$inc]['local_mineral_code'] = $data['local_mineral_code'];
								$mineralData[$inc]['local_grade_code'] = $data['local_grade_code'];
								$mineralData[$inc]['mineral_unit'] = $mineralUnit[$data['local_mineral_code']];
								$inc++;
							}
						}
					} else {
						$inc = 0;
						foreach ($mineralData as $data) {
							$mineralData[$inc]['opening_stock'] = $data['opening_stock'];
							$mineralData[$inc]['closing_stock'] = $data['closing_stock'];
							$mineralData[$inc]['remark'] = $data['remark'];
							$mineralData[$inc]['local_mineral_code'] = $data['local_mineral_code'];
							$mineralData[$inc]['local_grade_code'] = $data['local_grade_code'];
							$mineralData[$inc]['mineral_unit'] = (isset($data['local_mineral_code']) && $data['local_mineral_code'] == 'NIL') ? 'NIL' : (isset($mineralUnit[$data['local_mineral_code']]) ? $mineralUnit[$data['local_mineral_code']] : '');
							$inc++;
						}
					}
				} else {
					$pervMonthMineralData = $nSeriesProdActivity->getSeriesActivityDetails($formType, $returnType, $prevReturnDate, $endUserId, $userType, $pdfStatus);
					if (isset($pervMonthMineralData[0]['local_mineral_code']) && $pervMonthMineralData[0]['local_mineral_code'] != 'NIL') { // THIS CHECK HADLES THE NIL CONDITION
						$inc = 0;
						foreach ($pervMonthMineralData as $data) {
							$mineralData[$inc]['opening_stock'] = $data['closing_stock'];
							$mineralData[$inc]['closing_stock'] = '';
							$mineralData[$inc]['remark'] = $data['remark'];
							$mineralData[$inc]['local_mineral_code'] = $data['local_mineral_code'];
							$mineralData[$inc]['local_grade_code'] = $data['local_grade_code'];
							$mineralData[$inc]['mineral_unit'] = $mineralUnit[$data['local_mineral_code']];
							$inc++;
						}
					}
				}
				//====IF COUNT OF CURRENT MONTH DATA IS 0 THEN ENDS=============
			} else {
				$mineralData = $nSeriesProdActivity->getSeriesActivityDetails($formType, $returnType, $returnDate, $endUserId, $userType, $pdfStatus);
				$inc = 0;
				foreach ($mineralData as $data) {
					$mineralData[$inc]['opening_stock'] = $data['opening_stock'];
					$mineralData[$inc]['closing_stock'] = $data['closing_stock'];
					$mineralData[$inc]['remark'] = $data['remark'];
					$mineralData[$inc]['local_mineral_code'] = $data['local_mineral_code'];
					$mineralData[$inc]['local_grade_code'] = $data['local_grade_code'];
					$mineralData[$inc]['mineral_unit'] = ($data['local_mineral_code'] == 'NIL') ? 'NIL' : $mineralUnit[$data['local_mineral_code']];
					$inc++;
				}
			}

			$gradeforMineral = array();
			//==========GETTING THE DATA FROM EXTRA_N_SERIES TABLE==================
			foreach ($mineralData as $n) {
				$extraNSeriesProdActivity = TableRegistry::get('ExtraNSeriesProdActivity');
				$gradeforMineral[] = $extraNSeriesProdActivity->getSeriesExtraActivityDetails($returnType, $returnDate, $endUserId, $n['local_mineral_code'], $n['local_grade_code'], $userType);
			}

			$resultSet['mineralsData'] = $mineralData;
			$resultSet['gradeforMineral'] = $gradeforMineral;

			return $resultSet;

		}

		/**
		 * Added following logic to prefetch cumulative monthly details in annual return
		 * Effective from Phase-II
		 * @version 13th Dec 2021
		 * @author Aniket Ganvir
		 */
		public function NSeriesPrevMonthVsCurrentDataMonthAll($formType, $returnType, $returnDate, $endUserId, $userType) {

			//============GETS ALL UNIT IN ONE SHOT SHOW THAT NO NEED TO HIT DB AGAIN AND AGIN.. THIS WILL INCREASE THE PERFORMANCE
			$dirMcpMineral = TableRegistry::get('DirMcpMineral');
			$mineralUnit = $dirMcpMineral->getAllUnit();
			$mineralData = array();
			
			//CHECKING FOR CURRENT MONTH DATA ... AS IF THERE IS DATA NO NEED TO CHECK FOR PREV MONTH DATA
			$nSeriesProdActivity = TableRegistry::get('NSeriesProdActivity');

			//============CREATING PRECIOUS MONTH DATE======================
			$prevMonthString = strtotime("$returnDate -1 year");
			$prevMonthDate = date('Y-m-d', $prevMonthString);
			$prevReturnDate = $prevMonthDate;
			
			$mineralData = $nSeriesProdActivity->getSeriesActivityDetailsMonthAll($formType, $returnType, $returnDate, $endUserId, $userType);
			if (!isset($mineralData[0]['local_mineral_code'])) {
				$pervMonthMineralData = $nSeriesProdActivity->getSeriesActivityDetailsMonthAll($formType, $returnType, $prevReturnDate, $endUserId, $userType);
				if (isset($pervMonthMineralData[0]['local_mineral_code']) && $pervMonthMineralData[0]['local_mineral_code'] != 'NIL') { // THIS CHECK HADLES THE NIL CONDITION
					$inc = 0;
					foreach ($pervMonthMineralData as $data) {
						$mineralData[$inc]['opening_stock'] = $data['closing_stock'];
						$mineralData[$inc]['closing_stock'] = '';
						$mineralData[$inc]['remark'] = $data['remark'];
						$mineralData[$inc]['local_mineral_code'] = $data['local_mineral_code'];
						$mineralData[$inc]['local_grade_code'] = $data['local_grade_code'];
						$mineralData[$inc]['mineral_unit'] = $mineralUnit[$data['local_mineral_code']];
						$inc++;
					}
				}
			} else {
				$inc = 0;
				foreach ($mineralData as $data) {
					$mineralData[$inc]['opening_stock'] = $data['opening_stock'];
					$mineralData[$inc]['closing_stock'] = $data['closing_stock'];
					$mineralData[$inc]['remark'] = $data['remark'];
					$mineralData[$inc]['local_mineral_code'] = $data['local_mineral_code'];
					$mineralData[$inc]['local_grade_code'] = $data['local_grade_code'];
					$mineralData[$inc]['mineral_unit'] = ($data['local_mineral_code'] == 'NIL') ? 'NIL' : $mineralUnit[$data['local_mineral_code']];
					$inc++;
				}
			}

			$gradeforMineral = array();
			//==========GETTING THE DATA FROM EXTRA_N_SERIES TABLE==================
			foreach ($mineralData as $n) {
				$extraNSeriesProdActivity = TableRegistry::get('ExtraNSeriesProdActivity');
				$gradeforMineral[] = $extraNSeriesProdActivity->getSeriesExtraActivityDetailsMonthAll($returnType, $returnDate, $endUserId, $n['local_mineral_code'], $n['local_grade_code'], $userType);
			}

			$resultSet['mineralsData'] = $mineralData;
			$resultSet['gradeforMineral'] = $gradeforMineral;

			return $resultSet;

		}

		/**
		 * @author Uday Shankar Singh <usingh@ubicsindia.com>
		 * COMMON FUNCTION FOR WHOLE N SERIES
		 * 
		 * @param Integer $section
		 * @param String $partNo
		 * @param Integer $userType
		 * @return Array. 
		 * 
		 * RETURNS THE ARRAY OF ALL THE ELEMENTS NEEDED BY THE FORM N AT THE MMS SIDE.
		 * THIS ARRAY IS VERY SOFISTICATED AS MAKING ONE CHANGE WILL EFFECT WHOLE OF THE N SERIES DISPLAY..
		 * SO BE CAREFUL BEFORE CHANGING THE CODE HERE.
		 */
		public function mmsPreExecute($section, $partNo, $userType) {

			//=======================GETTING SESSION VARIABLES==========================
			//===="regCode" OF SESSION IS SAME AS THE "registration_code"
			$userName = $this->Session->read('mc_mine_code');
			$mcUser = TableRegistry::get('McUser');
			$regNo = $mcUser->getAppIdWithRegNo($userName);
			$this->Session->write('ibm_unique_reg_no', $regNo);

			$returnType = $this->Session->read('returnType');
			$returnDate = $this->Session->read('returnDate');

			$tblEndUserFinalSubmit = TableRegistry::get('TblEndUserFinalSubmit');
			$formType = $tblEndUserFinalSubmit->getFormType($userName, $userName, $returnDate, $returnType);
			$this->Session->write('formType', $formType);
			$ibmUniqueNo = $regNo;
			// $dbAppliStatus = $this->Session->read('dbAppliStatus');
			// $dbVerifiedFlag = $this->Session->read('dbVerifiedFlag');
			$this->Session->write('dbAppliStatus', 0);
			$this->Session->write('dbVerifiedFlag', 0);
			$dbAppliStatus = 0;
			$dbVerifiedFlag = 0;
			//=====================GETTING SESSION VARIABLES ENDS=======================

			$search = "_";
			$replace = "/";
			$endUserId = str_replace($search, $replace, $userName);
			$ibmUniqueRegNo = str_replace($search, $replace, $ibmUniqueNo);

			$returnTypeTemp = stripslashes($returnType);
			if ($returnTypeTemp == 'MONTHLY') {
				$getDate = $returnDate;
			} elseif ($returnTypeTemp == 'ANNUAL') {
				$getDate = $returnDate;
				// NEED TO MODIFY AT THE TIME ON ANNUAL FORM
				// $getDate = $this->getRequestParameter('date'); NEED TO MODIFY
			} else {
				print_r("OOPS....Something is wrong. Either you have opened multiple 
					browser tabs which is not allowed or something went seriously wrong.
					Kindly press back button of the browser then logout and try Again to login... 
					If the problem still persist kindly contact IBM regarding the same.");
				die;
			}

			if ($returnType == 'MONTHLY')
				$returnDatePeriod = $this->getDatePeriod($getDate, $returnTypeTemp, " "); // Parameter date , return type , separator
			if ($returnType == 'ANNUAL') {
				$temp = explode('-', $returnDate);
				$returnYearTemp = $temp[0];
				// $this->returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
				$returnDatePeriod = $returnYearTemp . " - " . ($temp[0] + 1);
			}
			//===========for hiding the action buttons for master admin alone===========
			$master_admin = false;
			$role = $this->Session->read('mms_user_role');
			if ($role == 1)
				$master_admin = true;
			//==================CHECKING FOR PENDING FROM PRIMARY USER================== NOT IN USE CURRENTLY AND NEED TO VERIFY BERFORE DELETE AS I CAN USE THIS IF NEEDED AS A FLAG
			// $is_pri_pending = $this->Session->read('is_pri_pending');
			$is_pri_pending = 0;
			//================CHECKING FOR PENDING FROM PRIMARY USER ENDS===============
			// $viewOnly = ($role == 2 || $role == 3) ? false : true;

			// if ($formType == 'N') {
			// 	if ($role == 2 || $role == 3) {
			// 		$viewOnly = false;
			// 	}
			// 	else {
			// 		$viewOnly = true;
			// 	}
			// }
			// if ($formType == 'O') {
			// Commented above condition as in Phase-II,
			// Supervisor & primary now gets both listing of "L" and "M"
			// By Aniket Ganvir on date 11th Jan 2022
				if ($role == 8 || $role == 9) {
					$viewOnly = false;
				}
				else {
					$viewOnly = true;
				}
			// }
			// THE QUERY IS ASSIGNED TO THE "$this->" VARIABLE AS WE ARE MAKING THE SAME 
			// QUERY TO THE DB 2 TIMES 1 HERE AND 1 IN THE POST FUNCTION.. SO I MADE
			// THIS GLOBAL TO STORE THE RESULT AT THE FIRST TIME ONLY.
			$returnDataArray = $tblEndUserFinalSubmit->getReturnId($endUserId, $returnDate, $returnTypeTemp, $ibmUniqueRegNo);
			$return_ids = ($returnDataArray == '') ? array() : $returnDataArray;

			// NEED TO CHECK THIS LOOP... WHETHER ONLY ONE RECORD(latest only) DATA WILL COME 
			// OR ALL OF IT i.e, ALL REJECTED + LATEST
			$reasons = array();
			foreach ($return_ids as $r) {
				$reasons[] = $tblEndUserFinalSubmit->getReason($r['id'], $partNo, $section);
			}

			//=============================================================
			$nSeriesProdActivity = TableRegistry::get('NSeriesProdActivity');
			$mineralData = $nSeriesProdActivity->getMmsSeriesActivityDetails($formType, $returnTypeTemp, $returnDate, $endUserId, $userType);

			$gradeforMineral = array();
			foreach ($mineralData as $n) {
				$extraNSeriesProdActivity = TableRegistry::get('ExtraNSeriesProdActivity');
				$dirMineralGrade = TableRegistry::get('DirMineralGrade');
				$gradeforMineral[] = $extraNSeriesProdActivity->getSeriesExtraActivityDetails($returnType, $returnDate, $endUserId, $n['local_mineral_code'], $n['local_grade_code'], $userType);
				$LOCAL_GRADE_CODE =	$dirMineralGrade->getGradeName($n['local_grade_code'], 1);
				
				if(!empty($LOCAL_GRADE_CODE)){
					$gradeData[] = $LOCAL_GRADE_CODE;
				}else{
					$gradeData[] =''; 
				}
				
			}

			//=============================================================

			$mmsPreExeArr = Array();
			$mmsPreExeArr['formType'] = $formType;
			$mmsPreExeArr['returnDate'] = $returnDate;
			$mmsPreExeArr['endUserId'] = $endUserId;
			$mmsPreExeArr['ibmUniqueRegNo'] = $ibmUniqueRegNo;
			$mmsPreExeArr['returnType'] = $returnTypeTemp;
			$mmsPreExeArr['getDate'] = $getDate;
			$mmsPreExeArr['returnDatePeriod'] = $returnDatePeriod;
			$mmsPreExeArr['master_admin'] = $master_admin;
			$mmsPreExeArr['is_pri_pending'] = $is_pri_pending;
			$mmsPreExeArr['viewOnly'] = $viewOnly;
			$mmsPreExeArr['returnDataArray'] = $returnDataArray;
			$mmsPreExeArr['reasons'] = $reasons;
			$mmsPreExeArr['mineralData'] = $mineralData;
			$mmsPreExeArr['gradesData'] = (!isset($gradeData)) ? '' : $gradeData;
			$mmsPreExeArr['gradeForMineral'] = $gradeforMineral;
			$mmsPreExeArr['dbAppliStatus'] = $dbAppliStatus;
			$mmsPreExeArr['dbVerifiedFlag'] = $dbVerifiedFlag;

			return $mmsPreExeArr;
		}

		public function getMineralNames($mine_code) {

			$mineralWorked = TableRegistry::get('MineralWorked');
			$mins = $mineralWorked->fetchMineralInfo($mine_code);
	
			$minerals = array();
			foreach ($mins as $m) {
				$minerals[] = strtolower(str_replace(' ', '_', $m['mineral_name']));
			}
	
			return $minerals;

		}
		
		public function changeDateFormatFromDashToSlash($timestamp) {

			$date = explode(' ', $timestamp);
			$temp = explode('-', $date[0]);
			$formatted_date = $temp[2] . "/" . $temp[1] . "/" . $temp[0];
	
			return $formatted_date;
			
		}

		public function leaseAreaAgencyOptions($lang = null) {

			if($lang == null) { $lang = 'english'; }
			$optArr = array();
			$optArr['english'] = ['-Select-', 'Public Sector', 'Private Sector', 'Joint Sector'];
			$optArr['hindi'] = ['-चुनिए-', 'पब्लिक सेक्टर', 'प्राइवेट सेक्टर', 'संयुक्त सेक्टर'];

			$options = array(
				'' => $optArr[$lang][0],
				'1' => $optArr[$lang][1],
				'2' => $optArr[$lang][2],
				'3' => $optArr[$lang][3],
			);
	
			return $options;
			
		}
		
		public function getCapitalStructureKeys() {

			//===================ROW WISE KEYS ARE CREATED IN ARRAY=====================
			$capStrucKeys = Array();
			$capStrucKeys = array(
				array(
					'at_year_beg' => 'land_beg',
					'add_during_year' => 'land_addition',
					'sold_during_year' => 'land_sold',
					'dep_during_year' => 'land_depreciated',
					'closing_bal' => 'land_close_bal',
					'estimated_value' => 'land_estimated'
				),
				array(
					'at_year_beg' => 'indus_beg',
					'add_during_year' => 'indus_addition',
					'sold_during_year' => 'indus_sold',
					'dep_during_year' => 'indus_depreciated',
					'closing_bal' => 'indus_close_bal',
					'estimated_value' => 'indus_estimated'
				),
				array(
					'at_year_beg' => 'resi_beg',
					'add_during_year' => 'resi_addition',
					'sold_during_year' => 'resi_sold',
					'dep_during_year' => 'resi_depreciated',
					'closing_bal' => 'resi_close_bal',
					'estimated_value' => 'resi_estimated'
				),
				array(
					'at_year_beg' => 'plant_beg',
					'add_during_year' => 'plant_addition',
					'sold_during_year' => 'plant_sold',
					'dep_during_year' => 'plant_depreciated',
					'closing_bal' => 'plant_close_bal',
					'estimated_value' => 'plant_estimated'
				),
				array(
					'at_year_beg' => 'capital_beg',
					'add_during_year' => 'capital_addition',
					'sold_during_year' => 'capital_sold',
					'dep_during_year' => 'capital_depreciated',
					'closing_bal' => 'capital_close_bal',
					'estimated_value' => 'capital_estimated'
				),
				array(
					'at_year_beg' => 'total_beg',
					'add_during_year' => 'total_addition',
					'sold_during_year' => 'total_sold',
					'dep_during_year' => 'total_depreciated',
					'closing_bal' => 'total_close_bal',
					'estimated_value' => 'total_estimated'
				)
			);
	
			return $capStrucKeys;
		}

		public function changeDateFormatFromSlashToDash($timestamp) {

			$date = explode(' ', $timestamp);
			$temp = explode('/', $date[0]);
			$formatted_date = $temp[2] . "-" . $temp[1] . "-" . $temp[0];
	
			return $formatted_date;
			
		}
		
		public function getExplosiveConsumption() {

			$expConKeys = Array();
			$expConKeys = array(
	       		// 0 ---  Gun Powder
				array(
					'large_con' => 'LARGE_CON_QTY',
					'large_req' => 'LARGE_REQ_QTY'
				),
	       		// 1 --- Loose ammonium nitrate
				array(
					'small_con' => 'SMALL_CON_QTY_1',
					'large_con' => 'LARGE_CON_QTY_1',
					'small_req' => 'SMALL_REQ_QTY_1',
					'large_req' => 'LARGE_REQ_QTY_1'
				),
	       		// 2 --- Ammonium nitrate in cartridged - form
				array(
					'small_con' => 'SMALL_CON_QTY_2',
					'large_con' => 'LARGE_CON_QTY_2',
					'small_req' => 'SMALL_REQ_QTY_2',
					'large_req' => 'LARGE_REQ_QTY_2'
				),
	       		// 3 --- Nitro compound
				array(
					'small_con' => 'SMALL_CON_QTY_3',
					'large_con' => 'LARGE_CON_QTY_3',
					'small_req' => 'SMALL_REQ_QTY_3',
					'large_req' => 'LARGE_REQ_QTY_3'
				),
	       		// 4 --- Liquid Oxygen soaked cartridges
				array(
					'small_con' => 'SMALL_CON_QTY_4',
					'large_con' => 'LARGE_CON_QTY_4',
					'small_req' => 'SMALL_REQ_QTY_4',
					'large_req' => 'LARGE_REQ_QTY_4'
				),
	       		// 5 --- Slurry explosives
				array(
					'slurry_tn' => 'SLURRY_TN',
					'small_con' => 'SMALL_CON_QTY_5',
					'large_con' => 'LARGE_CON_QTY_5',
					'small_req' => 'SMALL_REQ_QTY_5',
					'large_req' => 'LARGE_REQ_QTY_5'
				),
	       		// 6 --- Ordinary Detonators
				array(
					'large_con' => 'LARGE_CON_QTY_6',
					'large_req' => 'LARGE_REQ_QTY_6'
				),
	       		// 7 --- Ordinary Electrical
				array(
					'large_con' => 'LARGE_CON_QTY_8',
					'large_req' => 'LARGE_REQ_QTY_8'
				),
	       		// 8 --- Delay Ordinary Electrical
				array(
					'large_con' => 'LARGE_CON_QTY_9',
					'large_req' => 'LARGE_REQ_QTY_9'
				),
	       		// 9 --- Safety Fuse
				array(
					'large_con' => 'LARGE_CON_QTY_11',
					'large_req' => 'LARGE_REQ_QTY_11'
				),
	       		// 10 --- Detonating Fuse
				array(
					'large_con' => 'LARGE_CON_QTY_12',
					'large_req' => 'LARGE_REQ_QTY_12'
				),
	       		// 11 --- Plastic ignition cord
				array(
					'large_con' => 'LARGE_CON_QTY_13',
					'large_req' => 'LARGE_REQ_QTY_13'
				),
	       		// 12 --- Others (specify)
				array(
					'other_explosives' => 'OTHER_EXPLOSIVES',
					'other_unit' => 'OTHER_UNIT',
					'large_con' => 'LARGE_CON_QTY_14',
					'large_req' => 'LARGE_REQ_QTY_14'
				),
			);
			return $expConKeys;
			
		}
		
		public function getExplosiveSn($loop_no) {
			
			switch ($loop_no) {
				// Gun Powder
				case 0:
					$explosive_sn = 1;
					break;
				// Loose ammonium nitrate
				case 1:
					$explosive_sn = 3;
					break;
				// Ammonium nitrate in cartridged - form
				case 2:
					$explosive_sn = 4;
					break;
				// Nitro compound
				case 3:
					$explosive_sn = 5;
					break;
				// Liquid Oxygen soaked cartridges
				case 4:
					$explosive_sn = 6;
					break;
				// Slurry explosives
				case 5:
					$explosive_sn = 7;
					break;
				// Ordinary Detonators
				case 6:
					$explosive_sn = 9;
					break;
				// Ordinary Electrical
				case 7:
					$explosive_sn = 10;
					break;
				// Delay Ordinary Electrical
				case 8:
					$explosive_sn = 11;
					break;
				// Safety Fuse
				case 9:
					$explosive_sn = 12;
					break;
				// Detonating Fuse
				case 10:
					$explosive_sn = 13;
					break;
				// Plastic ignition cord
				case 11:
					$explosive_sn = 14;
					break;
				// Others (specify)
				case 12:
					$explosive_sn = 99;
					break;
			}
	
			return $explosive_sn;
			
		}

		public function getEmploymentWagesKeys() {

			$keys = array(
				array(
					'direct' => 'BELOW_FOREMAN_DIRECT',
					'contract' => 'BELOW_FOREMAN_CONTRACT',
					'worked_days' => 'BELOW_FOREMAN_DAYS',
					'male' => 'BELOW_FOREMAN_MALE',
					'female' => 'BELOW_FOREMAN_FEMALE',
					'total_wage' => 'BELOW_FOREMAN_TOTAL_WAGES',
					'man_tot' => 'BELOW_FOREMAN_MAN_TOT',
					'per_tot' => 'BELOW_FOREMAN_PER_TOTAL',
				),
				array(
					'direct' => 'BELOW_FACE_DIRECT',
					'contract' => 'BELOW_FACE_CONTRACT',
					'worked_days' => 'BELOW_FACE_DAYS',
					'male' => 'BELOW_FACE_MALE',
					'female' => 'BELOW_FACE_FEMALE',
					'total_wage' => 'BELOW_FACE_TOTAL_WAGES',
					'man_tot' => 'BELOW_FACE_MAN_TOT',
					'per_tot' => 'BELOW_FACE_PER_TOTAL',
				),
				array(
					'direct' => 'BELOW_OTHER_DIRECT',
					'contract' => 'BELOW_OTHER_CONTRACT',
					'worked_days' => 'BELOW_OTHER_DAYS',
					'male' => 'BELOW_OTHER_MALE',
					'female' => 'BELOW_OTHER_FEMALE',
					'total_wage' => 'BELOW_OTHER_TOTAL_WAGES',
					'man_tot' => 'BELOW_OTHER_MAN_TOT',
					'per_tot' => 'BELOW_OTHER_PER_TOTAL',
				),
				array(
					'direct' => 'OC_FOREMAN_DIRECT',
					'contract' => 'OC_FOREMAN_CONTRACT',
					'worked_days' => 'OC_FOREMAN_DAYS',
					'male' => 'OC_FOREMAN_MALE',
					'female' => 'OC_FOREMAN_FEMALE',
					'total_wage' => 'OC_FOREMAN_TOTAL_WAGES',
					'man_tot' => 'OC_FOREMAN_MAN_TOT',
					'per_tot' => 'OC_FOREMAN_PER_TOTAL',
				),
				array(
					'direct' => 'OC_FACE_DIRECT',
					'contract' => 'OC_FACE_CONTRACT',
					'worked_days' => 'OC_FACE_DAYS',
					'male' => 'OC_FACE_MALE',
					'female' => 'OC_FACE_FEMALE',
					'total_wage' => 'OC_FACE_TOTAL_WAGES',
					'man_tot' => 'OC_FACE_MAN_TOT',
					'per_tot' => 'OC_FACE_PER_TOTAL',
				),
				array(
					'direct' => 'OC_OTHER_DIRECT',
					'contract' => 'OC_OTHER_CONTRACT',
					'worked_days' => 'OC_OTHER_DAYS',
					'male' => 'OC_OTHER_MALE',
					'female' => 'OC_OTHER_FEMALE',
					'total_wage' => 'OC_OTHER_TOTAL_WAGES',
					'man_tot' => 'OC_OTHER_MAN_TOT',
					'per_tot' => 'OC_OTHER_PER_TOTAL',
				),
				array(
					'direct' => 'ABOVE_CLERICAL_DIRECT',
					'contract' => 'ABOVE_CLERICAL_CONTRACT',
					'worked_days' => 'ABOVE_CLERICAL_DAYS',
					'male' => 'ABOVE_CLERICAL_MALE',
					'female' => 'ABOVE_CLERICAL_FEMALE',
					'total_wage' => 'ABOVE_CLERICAL_TOTAL_WAGES',
					'man_tot' => 'ABOVE_CLERICAL_MAN_TOT',
					'per_tot' => 'ABOVE_CLERICAL_PER_TOTAL',
				),
				array(
					'direct' => 'ABOVE_ATTACHED_DIRECT',
					'contract' => 'ABOVE_ATTACHED_CONTRACT',
					'worked_days' => 'ABOVE_ATTACHED_DAYS',
					'male' => 'ABOVE_ATTACHED_MALE',
					'female' => 'ABOVE_ATTACHED_FEMALE',
					'total_wage' => 'ABOVE_ATTACHED_TOTAL_WAGES',
					'man_tot' => 'ABOVE_ATTACHED_MAN_TOT',
					'per_tot' => 'ABOVE_ATTACHED_PER_TOTAL',
				),
				array(
					'direct' => 'ABOVE_OTHER_DIRECT',
					'contract' => 'ABOVE_OTHER_CONTRACT',
					'worked_days' => 'ABOVE_OTHER_DAYS',
					'male' => 'ABOVE_OTHER_MALE',
					'female' => 'ABOVE_OTHER_FEMALE',
					'total_wage' => 'ABOVE_OTHER_TOTAL_WAGES',
					'man_tot' => 'ABOVE_OTHER_MAN_TOT',
					'per_tot' => 'ABOVE_OTHER_PER_TOTAL',
				),
			);
	
			return $keys;
			
		}

		public function getMaterialConQtyKeys() {

			$keys = array(
				array(
					'qty' => 'COAL_QUANTITY',
					'value' => 'COAL_VALUE'
				),
				array(
					'qty' => 'DIESEL_QUANTITY',
					'value' => 'DIESEL_VALUE'
				),
				array(
					'qty' => 'PETROL_QUANTITY',
					'value' => 'PETROL_VALUE'
				),
				array(
					'qty' => 'KEROSENE_QUANTITY',
					'value' => 'KEROSENE_VALUE'
				),
				array(
					'qty' => 'GAS_QUANTITY',
					'value' => 'GAS_VALUE'
				),
				array(
					'qty' => 'LUBRICANT_QUANTITY',
					'value' => 'LUBRICANT_VALUE'
				),
				array(
					'qty' => 'GREASE_QUANTITY',
					'value' => 'GREASE_VALUE'
				),
				array(
					'qty' => 'CONSUMED_QUANTITY',
					'value' => 'CONSUMED_VALUE'
				),
				array(
					'qty' => 'GENERATED_QUANTITY',
					'value' => 'GENERATED_VALUE'
				),
				array(
					'qty' => 'SOLD_QUANTITY',
					'value' => 'SOLD_VALUE'
				),
				array(
					'value' => 'EXPLOSIVES_VALUE'
				),
				array(
					'qty' => 'TYRES_QUANTITY',
					'value' => 'TYRES_VALUE'
				),
				array(
					'value' => 'TIMBER_VALUE'
				),
				array(
					'qty' => 'DRILL_QUANTITY',
					'value' => 'DRILL_VALUE'
				),
				array(
					'value' => 'OTHER_VALUE'
				),
			);
	
			return $keys;
		}

		/**
		 * Change date format dynamically
		 * @param string $date
		 * @param string $format
		 * @return string $formattedDate
		 * @version 28th Oct 2021
		 * @author Aniket Ganvir
		 */
		public function dateFormat($date, $format) {

			if (!empty($date)) {
				$formattedDate = date($format, strtotime($date));
			} else {
				$formattedDate = $format;
				$formattedDate = str_replace('d', '00', $formattedDate);
				$formattedDate = str_replace('m', '00', $formattedDate);
				$formattedDate = str_replace('Y', '0000', $formattedDate);
			}
			return $formattedDate;

		}
		
	}
	
?>
