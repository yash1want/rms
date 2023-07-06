<?php
namespace app\Model\Table;
use Cake\ORM\Table;
use App\Model\Model;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class DirSmsEmailTemplatesTable extends Table {

	var $name = "DirSmsEmailTemplates";

	// set default connection string
	public static function defaultConnectionName(): string {
		return Configure::read('conn');
	}

	//for main sending function
	public function sendMessage($message_id, $customer_id) {
		//Load Models
		$McUser = TableRegistry::getTableLocator()->get('McUser');
		$DirSentEmailLogs = TableRegistry::getTableLocator()->get('DirSentEmailLogs');
		$DirSentSmsLogs = TableRegistry::getTableLocator()->get('DirSentSmsLogs');
		$MmsUser = TableRegistry::getTableLocator()->get('MmsUser');

		$find_message_record = $this->find('all',array('conditions'=>array('id IS'=>$message_id, 'status'=>'active')))->first();



		if (!empty($find_message_record)) {

			$destination_values = $find_message_record['destination'];
			$destination_array = explode(',',$destination_values);
			$m=0;
			$e=0;
			$destination_mob_nos = array();
			$log_dest_mob_nos = array();
			$destination_email_ids = array();

			//Applicant
			if (in_array(1,$destination_array)) {

				$fetch_applicant_data = $McUser->find('all',array('conditions'=>array('mcu_child_user_name IS'=>$customer_id)))->first();
			
				$applicant_mob_no = $fetch_applicant_data['mcu_mob_num'];
				$applicant_email_id = $fetch_applicant_data['mcu_email'];
				$destination_mob_nos[$m] = '91'.base64_decode($applicant_mob_no); //This is addded on 27-04-2021 for base64decoding by AKASH
				$log_dest_mob_nos[$m] = '91'.$applicant_mob_no;
				// $destination_email_ids[$e] = $applicant_email_id;
				$destination_email_ids[$e] = base64_decode($applicant_email_id);
				$m=$m+1;
				$e=$e+1;
			}

			//Officer
			/*if (in_array(2,$destination_array)) {

				$fetch_applicant_data = $MmsUser->find('all',array('conditions'=>array('email IS'=>$customer_id)))->first();
				$applicant_mob_no = $fetch_applicant_data['mobile'];
				$applicant_email_id = $fetch_applicant_data['email'];
				$destination_mob_nos[$m] = '91'.base64_decode($applicant_mob_no); //This is addded on 27-04-2021 for base64decoding by AKASH
				$log_dest_mob_nos[$m] = '91'.$applicant_mob_no;
				$destination_email_ids[$e] = $applicant_email_id;
				$m=$m+1;
				$e=$e+1;
			}
			*/


			$sms_message = $find_message_record['sms_message'];
			$destination_mob_nos_values = implode(',',$destination_mob_nos);
			$log_dest_mob_nos_values = implode(',',$log_dest_mob_nos);

			$email_message = $find_message_record['email_message'];
			$destination_email_ids_values = implode(',',$destination_email_ids);

			$email_subject = $find_message_record['email_subject'];
			$template_id = $find_message_record['template_id'];//added on 12-05-2021 by Amol, new field
			// $template_id = '1407164379172649172';
			// $template_id = '1407164361568545302';

			//replacing dynamic values in the sms message
			$sms_message = $this->replaceDynamicValuesFromMessage($customer_id,$sms_message);
			
			// print_r($sms_message);
			// print_r("</br>");
			// print_r($destination_mob_nos_values);
			// print_r("</br>");			
			// print_r($destination_email_ids_values);
			// exit;
			//replacing dynamic values in the email message
			$email_message = $this->replaceDynamicValuesFromMessage($customer_id,$email_message);


			//To send SMS on list of mobile nos.
			if (!empty($find_message_record['sms_message'])) {

				//code to send sms starts here
				//echo "sendsms.php";
				// Initialize the sender variable
				$sender=urlencode("IBM");
				//$uname=urlencode("ibmmts.sms");
				$uname="apportalstg.sms";
				//$pass=urlencode("Y&nF4b#7q");
				$pass="AKsu@1990";
				$send=urlencode("IBMMTS");
				$dest=$destination_mob_nos_values;
				//$dest='9371371276';
				
				// $sms_message = "Your OTP to reset password isxxxx. The OTP is valid only for xxxxx minutes. Please click to reset your password xxxxxx";
				// $sms_message = "Hello S., PAO/DDO has confirmed payment verification for the application of firm KCOGF limited having ID: 5876/1/BGU/001. AGMARK";
				// $sms_message = "Your submitted mining plan vide acknowledgement No. xxxxxxxxx has been dis-approved i.r.o your mining lease.";
				$msg=urlencode($sms_message);

				// Initialize the URL variable
				// $URL="https://smsgw.sms.gov.in/failsafe/HttpLink";
				$URL="https://smsgw.sms.gov.in/failsafe/MLink";
				// Create and initialize a new cURL resource
				
				$ch = curl_init();
				// Set URL to URL variable
				curl_setopt($ch, CURLOPT_URL,$URL);
				// Set URL HTTPS post to 1
				curl_setopt($ch, CURLOPT_POST, true);
				// Set URL HTTPS post field values
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

				$entity_id = '1401566510000032882';

				// if message lenght is greater than 160 character then add one more parameter "concat=1" (Done by pravin 07-03-2018)
				if(strlen($msg) <= 160 ){

					//curl_setopt($ch, CURLOPT_POSTFIELDS,"username=$uname&pin=$pass&signature=$send&mnumber=$dest&message=$msg&dlt_entity_id=$entity_id&dlt_template_id=$template_id");
					// curl_setopt($ch, CURLOPT_POSTFIELDS,"username=".$uname."&pin=".$pass."&message=".$msg."&mnumber=".$dest."&signature=IBMMTS&dlt_entity_id=".$entity_id."&dlt_template_id=".$template_id);

				}else{

					//curl_setopt($ch, CURLOPT_POSTFIELDS,"username=$uname&pin=$pass&signature=$send&mnumber=$dest&message=$msg&concat=1&dlt_entity_id=$entity_id&dlt_template_id=$template_id");
					// curl_setopt($ch, CURLOPT_POSTFIELDS,"username=".$uname."&pin=".$pass."&message=".$msg."&mnumber=".$dest."&signature=IBMMTS&dlt_entity_id=".$entity_id."&dlt_template_id=".$template_id);
				}

				
				// curl_setopt($ch, CURLOPT_POSTFIELDS,"username=$uname&pin=$pass&signature=$send&mnumber=$dest&message=$msg&concat=1&dlt_entity_id=$entity_id&dlt_template_id=$template_id");
				// curl_setopt($ch, CURLOPT_POSTFIELDS,"username=apportalstg.sms&pin=AKsu@1990&message=".$msg." IBMMTS&mnumber=".$dest."&signature=IBMMTS&dlt_entity_id=".$entity_id."&dlt_template_id=".$template_id);
				// echo '<br>msg: '.$msg;
				// echo '<br>dest: '.$dest;
				// echo '<br>entity_id: '.$entity_id;
				// echo '<br>template_id: '.$template_id;
				// exit;
				curl_setopt($ch, CURLOPT_POSTFIELDS,"username=apportalstg.sms&pin=AKsu@1990&message=".$msg."&mnumber=".$dest."&signature=IBMMTS&dlt_entity_id=".$entity_id."&dlt_template_id=".$template_id);

				// Set URL return value to True to return the transfer as a string
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				// The URL session is executed and passed to the browser
				$curl_output =curl_exec($ch);
				// $curl_errors = curl_error($ch);
				// $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				// print_r($curl_errors);
				// echo '<br>response';
				// print_r($response);
				// exit;
				
				//code to send sms ends here

				/*
				//"https://smsgw.sms.gov.in/failsafe/MLink?username=apportalstg.sms&pin=AKsu@1990&message="+Msg+" IBMMTS&mnumber="+Mobileno+"&signature=IBMMTS&dlt_entity_id=1401566510000032882&dlt_template_id="+TemplateId;
				$api_params = "MLink?username=apportalstg.sms&pin=AKsu@1990&message=".$msg."&mnumber=+918766504882&signature=IBMMTS&dlt_entity_id=1401566510000032882&dlt_template_id=7";  
				$smsGatewayUrl = "https://smsgw.sms.gov.in/failsafe/";  
				$smsgatewaydata = $smsGatewayUrl.$api_params;
				$url = $smsgatewaydata;
		
				$ch = curl_init();                       // initialize CURL
				curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$output = curl_exec($ch);
				curl_close($ch);                         // Close CURL
		
				// Use file get contents when CURL is not installed on server.
				if(!$output){
				   $output =  file_get_contents($smsgatewaydata);  
				}
				*/


				//query to save SMS sending logs in DB // added on 11-10-2017
				$DirSentSmsLogsEntity = $DirSentSmsLogs->newEntity(array(
					'message_id'=>$message_id,
					'destination_list'=>$log_dest_mob_nos_values,
					'mid'=>null,
					'sent_date'=>date('Y-m-d H:i:s'),
					'message'=>$sms_message,
					'created'=>date('Y-m-d H:i:s'),
					'template_id'=>$template_id //added on 12-05-2021 by Amol
				));

				$DirSentSmsLogs->save($DirSentSmsLogsEntity);
			}


			//email format to send on mail with content from master
			$email_format = 'Dear Sir/Madam' . "\r\n\r\n" .$email_message. "\r\n\r\n" .
							'Thanks & Regards,' . "\r\n" .
							'Indian Bureau of Mines,' . "\r\n" .
							'Ministry of Mines,' . "\r\n" .
							'Government of India.';



			//To send Email on list of Email ids.
			if (!empty($find_message_record['email_message'])) {

				/*$Email = new CakeEmail();
				$Email->from(array('amy.cho27@gmail.com' => 'From IBM'))
					->to($destination_email_ids)
					->subject('IBM Message')
					->send($email_message);
				*/


				$to = $destination_email_ids_values;
			//	$to = 'pravin.bhakare.84@gmail.com';
				$subject = $email_subject;
				$txt = $email_format;
				$headers = "From: no-reply@ibm.gov.in";

				// mail($to,$subject,$txt,$headers);

				// now using phpmailer for sending mail - Aniket G [2023-01-20]
				require_once(ROOT . DS .'vendor' . DS . 'phpmailer' . DS . 'mail.php');
				$from = "no-reply@ibm.gov.in";
				send_mail($from, $to, $subject, $txt);

				//query to save Email sending logs in DB // added on 11-10-2017
				$DirSentEmailLogsEntity = $DirSentEmailLogs->newEntity(array(

					'message_id'=>$message_id,
					'destination_list'=>$destination_email_ids_values,
					'sent_date'=>date('Y-m-d H:i:s'),
					'message'=>$email_message,
					'created'=>date('Y-m-d H:i:s'),
					'template_id'=>$template_id //added on 12-05-2021 by Amol

				));

				$DirSentEmailLogs->save($DirSentEmailLogsEntity);
			}
		}


	}




	//this function is created on 08-07-2017 by Amol to replace dynamic values in message
	public function replaceDynamicValuesFromMessage($customer_id,$message) {

		//getting count before execution
		$total_occurrences = substr_count($message,"%%");

		while($total_occurrences > 0){

			$matches = explode('%%',$message);//getting string between %% & %%

			if (!empty($matches[1])) {

				switch ($matches[1]) {

					case "ack_number":

						$message = str_replace("%%ack_number%%",$this->getReplaceDynamicValues('ack_number',$customer_id),$message);
						break;

					case "registration_no":

						$message = str_replace("%%registration_no%%",$this->getReplaceDynamicValues('registration_no',$customer_id),$message);
						break;

					case "application_no":

						$message = str_replace("%%application_no%%",$this->getReplaceDynamicValues('application_no',$customer_id),$message);
						break;

					case "mine_code":

						$message = str_replace("%%mine_code%%",$this->getReplaceDynamicValues('mine_code',$customer_id),$message);
						break;

					case "month":

						$message = str_replace("%%month%%",$this->getReplaceDynamicValues('month',$customer_id),$message);
						break;

					case "year":

						$message = str_replace("%%year%%",$this->getReplaceDynamicValues('year',$customer_id),$message);
						break;

					default:

						$message = $this->replaceBetween($message, '%%', '%%', '');
						$default_value = 'yes';
						break;
				}
			}

			if (empty($default_value)) {
				
				$total_occurrences = substr_count($message,"%%");//getting count after execution
			} else {
				$total_occurrences = $total_occurrences - 1;
			}

		}

		return $message;
	}



	// This function find and return the value of replace variable value that are used in sms/email message templete
	public function getReplaceDynamicValues($replace_variable_value,$customer_id){
		

		$McUser = TableRegistry::getTableLocator()->get('McUser');
		$usertype = $_SESSION['loginusertype'];
		$form_type = isset($_SESSION['sess_form_type']);
		if ($form_type==1) {
			$formtype = $_SESSION['sess_form_type'];
		}
		
		$fetch_applicant_data = $McUser->find('all',array('conditions'=>array('mcu_child_user_name IS'=>$customer_id)))->first();

		if ($usertype=='enduser') {
			$registration_no = $_SESSION['regNo'];
		} elseif($usertype=='mmsuser') {
			if ($formtype=='f') {
				$registration_no = null;
			} else {
				$registration_no = $_SESSION['ibm_unique_reg_no'];
			}
		} else {
			$registration_no = null;
		}
		
		$get_month_name = $this->getMonthName();
		$get_year = (isset($_SESSION['returnType']) && $_SESSION['returnType'] == 'MONTHLY') ? $_SESSION['mc_sel_year'] : 'March '. ((int)$_SESSION['mc_sel_year'] + 1);

		switch ($replace_variable_value) {

			case "ack_number":

				return $ack_number;
				break;

			case "registration_no":

				return $registration_no;
				break;

			case "application_no":

				return $application_no;
				break;

			case "mine_code":

				return $fetch_applicant_data['mcu_mine_code'];
				break;

			case "month":

				return $get_month_name;
				break;

			case "year":

				return $get_year;
				break;

			default:

			$message = '%%';
			break;
		}
	}


	// This function replace the value between two character  (Done By pravin 9-08-2018)
	function replaceBetween($str, $needle_start, $needle_end, $replacement) {

		$pos = strpos($str, $needle_start);
		$start = $pos === false ? 0 : $pos + strlen($needle_start);

		$pos = strpos($str, $needle_end, $start);
		$end = $start === false ? strlen($str) : $pos;

		return substr_replace($str,$replacement,$start);
	}


	//This function is created for convert the month no to month name
	function getMonthName(){

		// $month_no = isset($_SESSION['mc_sel_month']);
		if(isset($_SESSION['returnType']) && $_SESSION['returnType'] == 'MONTHLY'){
			$month_no = (isset($_SESSION['mc_sel_month'])) ? $_SESSION['mc_sel_month'] : '1';
			$monthNum = $month_no;
			$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
		}else{
			$monthName = (isset($_SESSION['mc_sel_year'])) ? 'April '.$_SESSION['mc_sel_year'] : 'January';
		}
		return $monthName;
	}

}

?>
