<?php	

	//To access the properties of main controller used initialize function.

	namespace app\Controller\Component;
	use Cake\Controller\Controller;
	use Cake\Controller\Component;
	
	use Cake\Controller\ComponentRegistry;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\View\Helper;
	use Cake\Datasource\EntityInterface;
	use Cake\Utility\Security;
	use Cake\View\Helper\UrlHelper;
	use SimpleXMLElement;
	
	class SitemailsComponent extends Component {
	
		
		public $components= array('Session','Clscommon');
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

	    //send forget password mail
	    public function forgotPwdEmail($arrParams = array(), $userType) {
	        if (!$arrParams['toEmailAddress']){
	            return false;
	        }

	        $objSiteEmails = $this->Clscommon->getSiteEmails('forgotpassMail');

	        $address = $arrParams['toEmailAddress'];
	        $subject = $objSiteEmails['email_subject'];
	        $body = $objSiteEmails['email_body'];
			$host_path = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
			$controller = $userType;
	        $miner_reset_url = $host_path .'/'. $controller.'/resetPassword';

	        $body = str_replace('##username##', '"' . $arrParams['user_name'] . '"', $body);
	        $body = str_replace('##loginUrl##', $miner_reset_url . $arrParams['link'], $body);

	        $this->sendMailCommon($address,$subject,$body);
	        $this->saveSentMailLogs($arrParams['user_name'],$userType,'Reset Password (Automated link sent for setting new password)',$address,$subject,$body);

	    }

	    /**
	     * save sent mail logs
	     * @addedon 06th MAR 2021 (by Aniket Ganvir)
	     */
	    public function saveSentMailLogs($userid,$usertype,$mail_remark,$to_address,$subject,$mail_body){

        	$mailSentLogs = TableRegistry::getTableLocator()->get('MailSentLogs');

        	$sent_on = date('Y-m-d H:i:s');
			$newEntity = $mailSentLogs->newEntity(array(
								'userid'=>$userid,
								'usertype'=>$usertype,
								'mail_remark'=>$mail_remark,
								'to_address'=>$to_address,
								'subject'=>$subject,
								'mail_body'=>$mail_body,
								'sent_on'=>$sent_on
							));		
			$mailSentLogs->save($newEntity);

	    }

	    /**
	     * common function to send mails
	     * @addedon	06th MAR 2021 (by Aniket Ganvir)
	     */
	    public function sendMailCommon($to, $subject, $body){

			$host_path = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	        $headerStrip = $host_path.'/img/admin/mail-header.jpg';

	        $body = str_replace('##headerImg##', "'".$headerStrip."'", $body);
	        $body = str_replace('%3D', '=', $body);

			$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: no-reply@ibm.gov.in';
	    	mail($to,$subject,$body,$headers);

	    }

	    // public function replaceDynamicValuesFromMessage($matchstring, $dynamicValue, $body){

	    // 	$body = str_replace('##'.$matchstring.'##', $dynamicValue . $arrParams['link'], $body);

	    // }

		
	}
	
?>
