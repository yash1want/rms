<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Network\Email\Email;
use Cake\ORM\Entity;

class HomeController extends AppController{
		
	var $name = 'Home';
	var $uses = array();
	
    public function initialize(): void
    {
        parent::initialize();
		
		$this->loadComponent('Createcaptcha');
		$this->loadComponent('Authentication');
		$this->loadComponent('Customfunctions');
		$this->viewBuilder()->setHelpers(['Form','Html']);
		$this->Session = $this->getRequest()->getSession();
    }


    public function disclaimer() {

        $this->viewBuilder()->setLayout('home_page');

    }

    public function webpolicy() {

        $this->viewBuilder()->setLayout('home_page');

    }

    public function help() {

        $this->viewBuilder()->setLayout('home_page');

    }

    public function contact() {

        $this->viewBuilder()->setLayout('home_page');

    }

    public function regionalOfficeDetails() {

        $this->viewBuilder()->setLayout('home_page');

    }
	
	
	public function testsms(){
		
		$this->autoRender = false;
		
		$sender=urlencode("IBM");
		//$uname=urlencode("ibmmts.sms");
		$uname="apportalstg.sms";
		//$pass=urlencode("Y&nF4b#7q");
		$pass="AKsu@1990";
		$send=urlencode("IBMMTS");
		$dest="8766504882";
		//$dest='9371371276';
		
		// $sms_message = "Your OTP to reset password isxxxx. The OTP is valid only for xxxxx minutes. Please click to reset your password xxxxxx";
		// $sms_message = "Hello S., PAO/DDO has confirmed payment verification for the application of firm KCOGF limited having ID: 5876/1/BGU/001. AGMARK";
		// $sms_message = "Your return for the mine code 30APR02003, for the month of APRIL 2022 has been submitted. IBMMTS1";
		$sms_message = "Your return for the mine code 30APR02003, for the month of APRIL -  2022 has been submitted. IBMMTS1";
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
		curl_setopt($ch, CURLOPT_POSTFIELDS,"username=apportalstg.sms&pin=AKsu@1990&message=".$msg."&mnumber=".$dest."&signature=IBMMTS&dlt_entity_id=".$entity_id."&dlt_template_id=1407165458588264520");

		// Set URL return value to True to return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// The URL session is executed and passed to the browser
		$curl_output =curl_exec($ch);
        curl_close($ch);
		
        if(!$curl_output){
			$curl_output =  file_get_contents("https://smsgw.sms.gov.in/failsafe/MLink?username=apportalstg.sms&pin=AKsu@1990&message=".$msg."&mnumber=".$dest."&signature=IBMMTS&dlt_entity_id=".$entity_id."&dlt_template_id=1407165458588264520");  
		}
		
		print_r($curl_output); exit;

	}

		
}
?>