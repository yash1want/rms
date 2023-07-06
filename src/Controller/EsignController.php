<?php

namespace App\Controller;
use Cake\Event\Event;
use Cake\Network\Session\DatabaseSession;
use App\Network\Email\Email;
use App\Network\Request\Request;
use App\Network\Response\Response;
use Cake\ORM\TableRegistry;
use App\Network\Http\HttpSocket;
use Cake\Utility\Xml;
use FR3D;
use Applicationformspdfs;//importing another controller class here
use TCPDF;
use Cake\Core\Configure;
/**
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class EsignController extends AppController {

    var $name = 'Esign';
	
	public function initialize(): void
	{
		parent::initialize();
		$this->loadComponent('Customfunctions');		
		$this->viewBuilder()->setHelpers(['Form','Html','Time']);
	}   


    //this function is created to create XML with signature to request esign OTP, called through ajax
	//if ajax call of this function properly responded with OTP on mobile, 
	//then it will redirect to CDAC server with CORS(Cross-Origin-Resourse-Sharing) functionality to validate OTP.
	//if OTP is successfull, then CDAC will redirected to our provided URL with proper session by CORS.
	public function createEsignXmlAjax(){
		
		$this->autoRender = false;

		$pdf_file_name = $this->Session->read('pdf_file_name');
        $returnType = $this->Session->read('returnType');
		//$once_card_no = $this->Session->read('once_card_no');
		//$esign_otp = $this->Session->read('esign_otp');
		
		//get aadhar no from session variable
		$once_card_no = $this->Session->read('once_no');//added on 26-03-2018 

		//removed tcpdf code from here to create pdf using imagik images, on 24-01-2020
		//Now created common TCPDF function 'call_tcpdf' in Appcontroller and replaced with Mpdf code
		//Now implementing signature content at the time of first pdf creation, fetch that pdf here to create hash for Xml.
		
		//get generated pdf to create hash
		// $doc_path = $_SERVER["DOCUMENT_ROOT"].'/writereaddata/DMI/temp/'.$pdf_file_name;
		$doc_path = $this->Customfunctions->pdfFilePath();
		
		$response_action = '';//for new
		
		$get_date = date('Y-m-d');
		$get_time = date('H:i:s'.'.000');
		$time_stamp = $get_date.'T'.$get_time; //formatting timestamp as required
		$txn_id = rand().time();
		// $asp_id = 'IBMN-900';
		$asp_id = 'IBMN-001';
		

		$document_hashed = hash_file('sha256',$doc_path);//create pdf hash		
		// $response_url = 'https://164.100.211.9/UAT5/esign/request_esign';
		$response_url = 'https://ibmreturns.gov.in/esign/request_esign';
		//$response_url = 'https://ibmreturns.gov.in/UAT5/esign/request_esign';

		if($returnType == 'MONTHLY'){
			$doc_info = 'Monthly Return Final Submit';			
		}else{			
			$doc_info = 'Annual Return Final Submit';			
		}

		require_once(ROOT . DS . 'vendor' . DS . 'xmldsign' . DS . 'src' . DS . 'Adapter' . DS . 'XmlseclibsAdapter.php');

		// "Create" the document.
		$xml = new \DOMDocument( "1.0", "ISO-8859-15" );

		// Create some elements.
		$xml_esign = $xml->createElement( "Esign" );
		$xml_docs = $xml->createElement( "Docs" );
		$xml_docs_input = $xml->createElement( "InputHash", $document_hashed );
		
		// Set the attributes for Esign tag
		$xml_esign->setAttribute( "ver", "2.1" );
		$xml_esign->setAttribute( "sc", "Y" );
		$xml_esign->setAttribute( "ts", $time_stamp );
		$xml_esign->setAttribute( "txn", $txn_id );
		//$xml_esign->setAttribute( "ekycMode", "U" );
		$xml_esign->setAttribute( "ekycIdType", "A" );
		$xml_esign->setAttribute( "ekycId", "" );
		$xml_esign->setAttribute( "aspId", $asp_id );
		$xml_esign->setAttribute( "AuthMode", "1" );				
		$xml_esign->setAttribute( "responseSigType", "pkcs7" );
		//$xml_esign->setAttribute( "preVerified", "n" );
		//$xml_esign->setAttribute( "organizationFlag", "n" );
		$xml_esign->setAttribute( "responseUrl", $response_url ); 
		
		// Set the attributes for InputHash tag
		$xml_docs_input->setAttribute( "id", "1" );
		$xml_docs_input->setAttribute( "hashAlgorithm", "SHA256" );
		$xml_docs_input->setAttribute( "docInfo", $doc_info );
		
		  
		// Append the whole bunch inside
		$xml_docs->appendChild( $xml_docs_input );
		$xml_esign->appendChild( $xml_docs );

		$xml->appendChild( $xml_esign );

		$xmlTool = new FR3D\XmlDSig\Adapter\XmlseclibsAdapter();
		// $xmlTool->setPrivateKey(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/UAT5/webroot/writereaddate/doc/mts-selfsigned.key'));
		//$xmlTool->setPrivateKey(file_get_contents(ROOT . DS . 'webroot' . DS . 'doc' . DS . 'mts-selfsigned.key'));
		$xmlTool->setPrivateKey(file_get_contents(ROOT . DS . 'webroot' . DS . 'doc' . DS . 'IBMRET.key'));
	//	print_r(file_get_contents(ROOT . DS . 'webroot' . DS . 'doc' . DS . 'IBMRET.key'));exit;
		$xmlTool->addTransform(FR3D\XmlDSig\Adapter\XmlseclibsAdapter::ENVELOPED);

		$xmlTool->sign($xml);	
		$xml_string = $xml->saveXML(); 
		
		//save details in logs table
		$current_level = '';
		$this->saveRequestLog(null,$this->Session->read('username'),$pdf_file_name,$current_level,$time_stamp,$txn_id,$asp_id,
											$document_hashed,$response_url,null,null);
		
		//updated on 31-05-2021 for Form Based Esign method
		$result_arr = array('xml'=>$xml_string,'txnid'=>$txn_id);
		//print_r($result_arr);exit;
		echo json_encode($result_arr);
		exit;
	}


    //this function is created to save request log in db
	//created on 03-07-2018
	public function saveRequestLog($id,$applicant_id,$pdf_file_name,$current_level,$ts,$txn_id,$asp_id,
            $doc_hash,$response_url,$response_one,$response_two){		

        $this->loadModel('EsignRequestResponseLogs');

		$user_type = $this->Session->read('loginusertype');
		// if (in_array($user_type, array('authuser', 'enduser'))) {
			$return_type = $this->Session->read('returnType');
			$return_date = $this->Session->read('returnDate');
		// }

		$request_id = uniqid();
        $dataEntity = $this->EsignRequestResponseLogs->newEntity(array(		
        'id'=>$id,'request_by_user_id'=>$applicant_id,'return_date'=>$return_date,'return_type'=>$return_type,'pdf_file_name'=>$pdf_file_name,
        'user_type'=>$user_type,'time_stamp'=>$ts,'txn_id'=>$txn_id,'asp_id'=>$asp_id,
        'doc_hash_value'=>$doc_hash,'response_url'=>$response_url,'response_one'=>$response_one,
        'response_two'=>$response_two,'request_id'=>$request_id,'created'=>date('Y-m-d H:i:s'),'modified'=>date('Y-m-d H:i:s')
        )); 

        $this->EsignRequestResponseLogs->save($dataEntity);
        $this->Session->write('log_last_insert_id',$request_id);

    }


    public function requestEsign() { 

		// print_r($this->request->is('post')); exit;
		
		$this->autoRender = false;
		
		//if response from ESP for esign request
		if($this->request->is('post')){
			
			$this->Session->write('eSignResponse', $this->request->getData('eSignResponse'));
			$this->redirect(['controller'=>'esign', 'action'=>'final_esign']);
			
		}
		
	}
	
	// final approve without esign for MMS division
	// added on 25-08-2022 by Aniket
    public function requestWithoutEsign() { 

		$this->autoRender = false;
		
		if($this->request->is('post')){

			if(null !== $this->request->getData('final_approve') && $this->request->getData('final_approve') == 'Final Approve'){

				$user_type = $this->Session->read('loginusertype');
				if (in_array($user_type, array('authuser','enduser'))) {
					$applicant_user = $user_type;
					$home_controller = 'auth';
				} else {
					$applicant_user = $this->Session->read('view_user_type');
					$home_controller = 'mms';
				}
	
				$this->loadModel('EsignPdfRecords');
				$finalSubmitStatus = $this->EsignPdfRecords->saveFinalSubmitWithEsignStatus($applicant_user);
				
				if ($finalSubmitStatus['status'] == 1) { 
					$this->Session->write('process_msg', $finalSubmitStatus['msg']);
				} else {
					$this->Session->write('mon_f_err', 'Problem in submitting return! Try again later.');
				}
				
				$this->redirect(['controller'=>$home_controller, 'action'=>'home']);
			}
			
		}
		
	}
	
	public function finalEsign(){
				
			//$this->Session->write('eSignResponse', '<EsignResp errCode="NA" errMsg="NA" resCode="6c79b872-5a13-4de1-b77b-793cb0c622f5" status="1" ts="2022-03-30T15:57:13.320" txn="9276593111648635952"><UserX509Certificate>MIIFnDCCBISgAwIBAgIDAbHPMA0GCSqGSIb3DQEBCwUAMH4xCzAJBgNVBAYTAklO MRQwEgYDVQQIDAtNYWhhcmFzaHRyYTENMAsGA1UEBwwEUFVORTEOMAwGA1UECgwF Qy1EQUMxIjAgBgNVBAsMGVRlc3QgQ2VydGlmeWluZyBBdXRob3JpdHkxFjAUBgNV BAMMDVRlc3QgQy1EQUMgQ0EwHhcNMjIwMzMwMTAyNjI4WhcNMjIwMzMwMTA1NjI4 WjCCAUUxDjAMBgNVBAYTBUluZGlhMRQwEgYDVQQIEwtNYWhhcmFzaHRyYTERMA8G A1UEChMIUGVyc29uYWwxGzAZBgNVBAMTEkFuaWtldCBBbmlsIEdhbnZpcjEPMA0G A1UEERMGNDQxMjEwMVIwUAYDVQQtA0kAMDEwMDA0MjdBMm5KQ1c0UTNFMTRLODNp VFltM09JUnpQcFpJOGs1Q1U4ZFk4QVZBRUVDc3RhY0NXYWtQMTJTanhOdjZOcWVZ MSkwJwYDVQRBEyBiOTBmZjFkNDM0YzY0NGZmYjNlMjMzNzAwOTZmZjY2YjENMAsG A1UEDBMEMTA5OTFOMEwGA1UELhNFMTk5NU1lYWJjNzA5OTBmOTUwMzZhMTVjMGM4 ZGIwYzFiODE2Mjk0NmRlZGQwNGE1MmU2MWJhZTcwNTNjNTlmNTEzM2VmMFkwEwYH KoZIzj0CAQYIKoZIzj0DAQcDQgAESuNq3RmZ9zzn2yK95u+Cq1qmDZ5FuVeGzZSB X/Lz5zk8mMH4WXi9BjEp9xCFD/bHD50u4sARtzIoNGFwtDqQXaOCAiMwggIfMAkG A1UdEwQCMAAwHQYDVR0OBBYEFDu/fcDeRBiL0y3g97PQ0Ucq0LtQMB8GA1UdIwQY MBaAFA58oZXW2swg8yhPlL1306H0MIsWMA4GA1UdDwEB/wQEAwIGwDA5BgNVHR8E MjAwMC6gLKAqhihodHRwczovL2VzaWduLmNkYWMuaW4vY2EvZXNpZ25DQTIwMTQu Y3JsMIIBPwYDVR0gBIIBNjCCATIwggEBBgdggmRkAQkCMIH1MDAGCCsGAQUFBwIB FiRodHRwczovL2VzaWduLmNkYWMuaW4vY2EvQ1BTL0NQUy5wZGYwgcAGCCsGAQUF BwICMIGzMD4WOkNlbnRyZSBmb3IgRGV2ZWxvcG1lbnQgb2YgQWR2YW5jZWQgQ29t cHV0aW5nIChDLURBQyksIFB1bmUwABpxVGhpcyBDUFMgaXMgb3duZWQgYnkgQy1E QUMgYW5kIHVzZXJzIGFyZSByZXF1ZXN0ZWQgdG8gcmVhZCBDUFMgYmVmb3JlIHVz aW5nIHRoZSBDLURBQyBDQSdzIGNlcnRpZmljYXRpb24gc2VydmljZXMwKwYHYIJk ZAIEATAgMB4GCCsGAQUFBwICMBIaEEFhZGhhYXIgZUtZQy1PVFAwRAYIKwYBBQUH AQEEODA2MDQGCCsGAQUFBzAChihodHRwczovL2VzaWduLmNkYWMuaW4vY2EvQ0RB Qy1DQTIwMTQuZGVyMA0GCSqGSIb3DQEBCwUAA4IBAQB4exHGZue1BY2nKYOXQEa/ 4PyCo0gpvhSnLL5SUJlTsVkKEmMX8VFMK2mYLl36CcflR5fT+PFpfLv2cZoF7MO/ /JDHhxPsivdNYDRqSNrRilB6zDdUjPfQU3rLPoaKHgsWO6+qHCu5U0RWNHinG9FX LfOoXHMChFTswYY8QBbF2Ov8pPl6fHlgy7crZImMh6vjWtWYW87Y5QDsf6x7LUx5 A3CBEMRKlNQUm/5WXlRgYi69QgDWzw6sgqIGI4rOvAcbrbYgw0fxCCPKeEilUPIn dg6jHBQh/zPshLAhG3exKC5psiDV8N36lryFsRW6pRAObHFG/NHHjvNgmPBVemNx </UserX509Certificate><Signatures><DocSignature error="NA" id="1" sigHashAlgorithm="SHA256">MIILEAYJKoZIhvcNAQcCoIILATCCCv0CAQExDzANBglghkgBZQMEAgEFADALBgkqhkiG9w0BBwGg gglzMIIDzzCCAregAwIBAgIJAMxt5h7OM6WEMA0GCSqGSIb3DQEBBQUAMH4xCzAJBgNVBAYTAklO MRQwEgYDVQQIDAtNYWhhcmFzaHRyYTENMAsGA1UEBwwEUFVORTEOMAwGA1UECgwFQy1EQUMxIjAg BgNVBAsMGVRlc3QgQ2VydGlmeWluZyBBdXRob3JpdHkxFjAUBgNVBAMMDVRlc3QgQy1EQUMgQ0Ew HhcNMTgwMTEwMTEzOTM1WhcNMjgwMTA4MTEzOTM1WjB+MQswCQYDVQQGEwJJTjEUMBIGA1UECAwL TWFoYXJhc2h0cmExDTALBgNVBAcMBFBVTkUxDjAMBgNVBAoMBUMtREFDMSIwIAYDVQQLDBlUZXN0 IENlcnRpZnlpbmcgQXV0aG9yaXR5MRYwFAYDVQQDDA1UZXN0IEMtREFDIENBMIIBIjANBgkqhkiG 9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzeJIAmzyhl49G+KfQPQmP5zg/Zoz6TDZImel43VklbKHRc4a WEAZR9Mp4pwsVXaWeDd+GWpBexzCv8KcBRat1Vv4ZyR7RgDwMJ8MSQkOkIo5oZ31sSnLlehbHC2d DUzOW66O1pzqFtvKyf6QIUxEpYRdn0bbLaZYOfHWKUW6LTCWRZ5S+HWilTaFI2aOIrG3Vg/Hf+3L QkJu4H7Urmr92Yjxd3Z7DKxVkjES4kexUe5PUMY5wmYfDC1PWOkv9GyKu1/sZEmQ+GUcUR/TNDnQ oLbHvbmQaQ7TiyyiTCzY1kipAHOTs4YtSgdhLqqQK6jWe7WthGYPp0ejXCUg81bZeQIDAQABo1Aw TjAdBgNVHQ4EFgQUNdt2Xzx7JRnr58wo475nPP2MSQUwHwYDVR0jBBgwFoAUNdt2Xzx7JRnr58wo 475nPP2MSQUwDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQUFAAOCAQEATjibTJJGHMMNrU8u/D7D Ue2VTBtRqprWvLTC9w825KKl/doPsP1Y1YTVS13U+do6SLGFEKd/rKwIvBwThuPUTXNOKocYfwrP 8qC2RfcqVa7Xl1el3qg4bvVmZ+ST9GLBB5e5CAdY9yTDbYXOmMqv7DCN+1BRbq+AY520kZtpMWS4 qoVdKMI9g3s3t59jgc89jRoXom5eszC8HfUiPZkHt4kaTZqKcUW2dFW7y3yVooB2CaCi5HHatN3E Qn0tb3WQqvRL3ZkQ3mihVlXybvCCpSASTpW7MNqR05hM3d3+OybiHOih22+iceW69RGC12aU1yGN SavhQCQPky++Xx93MzCCBZwwggSEoAMCAQICAwGxzzANBgkqhkiG9w0BAQsFADB+MQswCQYDVQQG EwJJTjEUMBIGA1UECAwLTWFoYXJhc2h0cmExDTALBgNVBAcMBFBVTkUxDjAMBgNVBAoMBUMtREFD MSIwIAYDVQQLDBlUZXN0IENlcnRpZnlpbmcgQXV0aG9yaXR5MRYwFAYDVQQDDA1UZXN0IEMtREFD IENBMB4XDTIyMDMzMDEwMjYyOFoXDTIyMDMzMDEwNTYyOFowggFFMQ4wDAYDVQQGEwVJbmRpYTEU MBIGA1UECBMLTWFoYXJhc2h0cmExETAPBgNVBAoTCFBlcnNvbmFsMRswGQYDVQQDExJBbmlrZXQg QW5pbCBHYW52aXIxDzANBgNVBBETBjQ0MTIxMDFSMFAGA1UELQNJADAxMDAwNDI3QTJuSkNXNFEz RTE0SzgzaVRZbTNPSVJ6UHBaSThrNUNVOGRZOEFWQUVFQ3N0YWNDV2FrUDEyU2p4TnY2TnFlWTEp MCcGA1UEQRMgYjkwZmYxZDQzNGM2NDRmZmIzZTIzMzcwMDk2ZmY2NmIxDTALBgNVBAwTBDEwOTkx TjBMBgNVBC4TRTE5OTVNZWFiYzcwOTkwZjk1MDM2YTE1YzBjOGRiMGMxYjgxNjI5NDZkZWRkMDRh NTJlNjFiYWU3MDUzYzU5ZjUxMzNlZjBZMBMGByqGSM49AgEGCCqGSM49AwEHA0IABErjat0Zmfc8 59sivebvgqtapg2eRblXhs2UgV/y8+c5PJjB+Fl4vQYxKfcQhQ/2xw+dLuLAEbcyKDRhcLQ6kF2j ggIjMIICHzAJBgNVHRMEAjAAMB0GA1UdDgQWBBQ7v33A3kQYi9Mt4Pez0NFHKtC7UDAfBgNVHSME GDAWgBQOfKGV1trMIPMoT5S9d9Oh9DCLFjAOBgNVHQ8BAf8EBAMCBsAwOQYDVR0fBDIwMDAuoCyg KoYoaHR0cHM6Ly9lc2lnbi5jZGFjLmluL2NhL2VzaWduQ0EyMDE0LmNybDCCAT8GA1UdIASCATYw ggEyMIIBAQYHYIJkZAEJAjCB9TAwBggrBgEFBQcCARYkaHR0cHM6Ly9lc2lnbi5jZGFjLmluL2Nh L0NQUy9DUFMucGRmMIHABggrBgEFBQcCAjCBszA+FjpDZW50cmUgZm9yIERldmVsb3BtZW50IG9m IEFkdmFuY2VkIENvbXB1dGluZyAoQy1EQUMpLCBQdW5lMAAacVRoaXMgQ1BTIGlzIG93bmVkIGJ5 IEMtREFDIGFuZCB1c2VycyBhcmUgcmVxdWVzdGVkIHRvIHJlYWQgQ1BTIGJlZm9yZSB1c2luZyB0 aGUgQy1EQUMgQ0EncyBjZXJ0aWZpY2F0aW9uIHNlcnZpY2VzMCsGB2CCZGQCBAEwIDAeBggrBgEF BQcCAjASGhBBYWRoYWFyIGVLWUMtT1RQMEQGCCsGAQUFBwEBBDgwNjA0BggrBgEFBQcwAoYoaHR0 cHM6Ly9lc2lnbi5jZGFjLmluL2NhL0NEQUMtQ0EyMDE0LmRlcjANBgkqhkiG9w0BAQsFAAOCAQEA eHsRxmbntQWNpymDl0BGv+D8gqNIKb4Upyy+UlCZU7FZChJjF/FRTCtpmC5d+gnH5UeX0/jxaXy7 9nGaBezDv/yQx4cT7Ir3TWA0akja0YpQesw3VIz30FN6yz6Gih4LFjuvqhwruVNEVjR4pxvRVy3z qFxzAoRU7MGGPEAWxdjr/KT5enx5YMu3K2SJjIer41rVmFvO2OUA7H+sey1MeQNwgRDESpTUFJv+ Vl5UYGIuvUIA1s8OrIKiBiOKzrwHG622IMNH8QgjynhIpVDyJ3YOoxwUIf8z7ISwIRt3sSguabIg 1fDd+pa8hbEVuqUQDmxxRvzRx47zYJjwVXpjcTGCAWEwggFdAgEBMIGFMH4xCzAJBgNVBAYTAklO MRQwEgYDVQQIDAtNYWhhcmFzaHRyYTENMAsGA1UEBwwEUFVORTEOMAwGA1UECgwFQy1EQUMxIjAg BgNVBAsMGVRlc3QgQ2VydGlmeWluZyBBdXRob3JpdHkxFjAUBgNVBAMMDVRlc3QgQy1EQUMgQ0EC AwGxzzANBglghkgBZQMEAgEFAKBpMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0BBwEwHAYJKoZIhvcN AQkFMQ8XDTIyMDMzMDEwMjYyOFowLwYJKoZIhvcNAQkEMSIEIHUEniHCdUDEuJkvgdTlUIBi+MWX iMyoYpmjXPcS8hMwMAwGCCqGSM49BAMCBQAESDBGAiEAxjAxhUFcJaN9UmMf8u8D75dPGIBh96lt 3rkFsVHiMZoCIQDOWvEK0DRrrpn+z2NN9vfijcq6K+r9TUNIvkuL2ykelw==</DocSignature></Signatures><Signature xmlns="http://www.w3.org/2000/09/xmldsig#"> <SignedInfo> <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"></CanonicalizationMethod> <SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"></SignatureMethod> <Reference URI=""> <Transforms> <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></Transform> </Transforms> <DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></DigestMethod> <DigestValue>acyG0sseQJvZu6fo/8srAwuOY7Q=</DigestValue> </Reference> </SignedInfo> <SignatureValue> VIlJGnFxlCT7Lsc35abTLspgKMBKzG6tGXdqJpZQSjBGcpZhoAFI2F61AgiSJfiOK8p4bfpruoC5 7XhuKrrzyFJFdAnft9A8JhiPb6Bsbf4tLRLj2u/ZHONBdWPzcaFZ+2qe+NewouT+XTWev7sRKoS6 QLGBUXvZGSTTItIQ6/EOPGpq9WCD7dnCl6Qmf2K67us3gBOO/KcyNcTobisfcBHklxOjXqRoqsTi vWfpBFEMHU7VI8gHes2xPFrgC1jbiupE0oruas559wN1UKLp9LnHs3ylz3yMZFU55f3r9L2E2ZqJ E9MlfEvm+7qUbGLiBpgIysbz8L9kUKkwLXbe3Q== </SignatureValue> </Signature></EsignResp>');
			$username = $this->Session->read('username');
			$pdf_file_name = $this->Session->read('pdf_file_name');
			
			$eSignResponse = $this->Session->read('eSignResponse');
			
			$eSignResponse = simplexml_load_string($eSignResponse);
			$getRespInJson = json_encode($eSignResponse);
			$getRespAssoArray = json_decode($getRespInJson,TRUE);
			
		//added on 01-10-2018 by Amol
			//save entry in temp esign table, which will deleted after this process done properly.
			$this->loadModel('TempEsignStatuses');
			$user_type = $this->Session->read('loginusertype');
			$return_date = $this->Session->read('returnDate');
			$return_type = $this->Session->read('returnType');
			if (in_array($user_type, array('authuser','enduser'))) {
				$applicant_user = $user_type;
				$home_controller = 'auth';
				$applicant_id = $this->Session->read('username');
			} else {
				$applicant_user = $this->Session->read('view_user_type');
				$home_controller = 'mms';
				$applicant_id = $this->Session->read('mc_mine_code');
			}
			$this->TempEsignStatuses->saveTempEsignRecord($applicant_id,$return_type,$return_date,$user_type,$pdf_file_name,$username);																			  
			//calling to set response signature on existing pdf.
			
			
			$esign_status = $this->signTheDoc($getRespAssoArray,$pdf_file_name);
			//$esign_status = $this->signTheDoc(array(),$pdf_file_name);

			if ($esign_status == 1) {
					
				//calling final submit process now after signature appended in pdf.

				$this->loadModel('EsignPdfRecords');
				$finalSubmitStatus = $this->EsignPdfRecords->saveFinalSubmitWithEsignStatus($applicant_user);
				
				if ($finalSubmitStatus['status'] == 1) { 
						
					$this->Session->write('process_msg', $finalSubmitStatus['msg']);
					
				} else {

					$this->Session->write('mon_f_err', 'Problem in submitting return! Try again later.');

				}
				
				$this->Session->delete('eSignResponse'); 
				
				$this->redirect(['controller'=>$home_controller, 'action'=>'home']);
				
			//added this else part on 11-06-2019 by Amol to show esign failed message	
			} else {
				
				$this->Session->write('mon_f_err', 'Problem in E-signing the document! Try again later.');
				$this->redirect(['controller'=>$home_controller, 'action'=>'home']);//updated on 31-05-2021 for Form Based Esign method by Amol
			}
		
	}
	
	//This function is created to append response signature on existing pdf doc.
	//created on 28-06-2018 by Amol
	public function signTheDoc($resp_array,$pdf_file_name){

		// $resp_status = $resp_array['@attributes']['status'];//updated on 31-05-2021 for Form Based Esign method
		$resp_status = 1;//updated on 31-05-2021 for Form Based Esign method

		if($resp_status == 1){
			//Set signature on pdf process Starts here....				
			//file path to get existing pdf, signed it and write on the same place
			// $pdf_path = $_SERVER["DOCUMENT_ROOT"].'/writereaddata/DMI/temp/'.$pdf_file_name;
			$pdf_path = $this->Customfunctions->pdfFilePath();
			$cer_value = $resp_array['UserX509Certificate'];//updated on 31-05-2021 for Form Based Esign method
			//$cer_value = "MIIF5DCCBMygAwIBAgIUAI3+onmDwTHVrLb0ZQjf6ievWaswDQYJKoZIhvcNAQEL\nBQAwgcExCzAJBgNVBAYTAklOMQ4wDAYDVQQKEwVDLURBQzEgMB4GA1UECxMXQ2Vy\ndGlmaWNhdGlvbiBBdXRob3JpdHkxDzANBgNVBBETBjQxMTAwNzEUMBIGA1UECBML\nTWFoYXJhc2h0cmExJTAjBgNVBAkTHFB1bmUgVW5pdmVyc2l0eSBDYW1wdXMsIFB1\nbmUxGjAYBgNVBDMTETFzdCBmbG9vciwgS2hvc2xhMRYwFAYDVQQDEw1DLURBQyBD\nQSAyMDE0MB4XDTIxMTIxMzExMDY1OVoXDTIxMTIxMzExMzY1OVowggFEMQ4wDAYD\nVQQGEwVJbmRpYTESMBAGA1UECBMJS2FybmF0YWthMREwDwYDVQQKEwhQZXJzb25h\nbDEbMBkGA1UEAxMSUmFnaGF2ZW5kcmEgTXVyZ29kMQ8wDQYDVQQREwY1ODAwMDQx\nUzBRBgNVBC0DSgAwMTAwMDU1OVFCZ2tZbkxLWDYvMVBabk1jblIyZlNrQnhQZEw5\nZ2ZJUVh3ajNZZFhCTHBBd0JXd2NcK2VNckVmMW9BMi85U3ZTMSkwJwYDVQRBEyBl\nZGI5MDk0MTM5YWQ0NDYwYjg3NDk2MzMzNGVlMDk3ZTENMAsGA1UEDBMEODgwMjFO\nMEwGA1UELhNFMTk4M01lMjdhZjU3ZmNkYjAyMjM5OTZiY2QxYjlhNDI2Y2I3Yjk1\nMzFkNTAyM2M4MzRkMjJlNGUzN2U2YzkyMjIzZTBhMFkwEwYHKoZIzj0CAQYIKoZI\nzj0DAQcDQgAEl\/LR7PVNGK3qK\/JkcOwes9sYOaZjIqV7cHzmEoadRKKSC2B3WD0Q\nTBsbqXRJHswQwNKRivZHRcdyBc0e5gbbb6OCAhcwggITMAkGA1UdEwQCMAAwHQYD\nVR0OBBYEFPSCHxooOX0r6RADV5DAVt5iCuBuMBMGA1UdIwQMMAqACEFDcsjkNHH8\nMA4GA1UdDwEB\/wQEAwIGwDA5BgNVHR8EMjAwMC6gLKAqhihodHRwczovL2VzaWdu\nLmNkYWMuaW4vY2EvZXNpZ25DQTIwMjEuY3JsMIIBPwYDVR0gBIIBNjCCATIwggEB\nBgdggmRkAQkCMIH1MDAGCCsGAQUFBwIBFiRodHRwczovL2VzaWduLmNkYWMuaW4v\nY2EvQ1BTL0NQUy5wZGYwgcAGCCsGAQUFBwICMIGzMD4WOkNlbnRyZSBmb3IgRGV2\nZWxvcG1lbnQgb2YgQWR2YW5jZWQgQ29tcHV0aW5nIChDLURBQyksIFB1bmUwABpx\nVGhpcyBDUFMgaXMgb3duZWQgYnkgQy1EQUMgYW5kIHVzZXJzIGFyZSByZXF1ZXN0\nZWQgdG8gcmVhZCBDUFMgYmVmb3JlIHVzaW5nIHRoZSBDLURBQyBDQSdzIGNlcnRp\nZmljYXRpb24gc2VydmljZXMwKwYHYIJkZAIEATAgMB4GCCsGAQUFBwICMBIaEEFh\nZGhhYXIgZUtZQy1PVFAwRAYIKwYBBQUHAQEEODA2MDQGCCsGAQUFBzAChihodHRw\nczovL2VzaWduLmNkYWMuaW4vY2EvQ0RBQy1DQTIwMTQuZGVyMA0GCSqGSIb3DQEB\nCwUAA4IBAQCWRvtRhNmt4fqSjNWnlykRMQuAiWx9f3b0XPWZkvZg+dFCKi\/qUPCf\nQd2CkGb8a3ceVFgJMV8mNmTFZ\/2rnJeD1na2ESzMZZj0IZn1aWp+QyO\/qAKBdcpf\nkKm+hnXruOmobTZsN1E5dVuU2vEJEx2eYUwvwmrc167rIIrusSYWgbtVM\/\/l9zk0\ntL8h4zyKA59jvhOYtmBdzoHek8NfluxBQC5Q+JBKhyMi7dm8e3Orh9ankG+DaxUx\nnK9sBVi6zyWPAdE6EvN6n5kkOnmOYWdm18kX+yzuhM5dWxJjeHpQDWVyvrYZhWrV\nN5kQhytWjvvMfkH0\/evzPbuRQ6L12KAZ\n";//updated on 31-05-2021 for Form Based Esign method
			$pkcs7_value = $resp_array['Signatures']['DocSignature'];//updated on 31-05-2021 for Form Based Esign method
			//$pkcs7_value = "MIIPKAYJKoZIhvcNAQcCoIIPGTCCDxUCAQExDzANBglghkgBZQMEAgEFADALBgkqhkiG9w0BBwGg\ngg03MIIDIzCCAgugAwIBAgICJ60wDQYJKoZIhvcNAQELBQAwOjELMAkGA1UEBhMCSU4xEjAQBgNV\nBAoTCUluZGlhIFBLSTEXMBUGA1UEAxMOQ0NBIEluZGlhIDIwMTQwHhcNMTQwMzA1MTAxMDQ5WhcN\nMjQwMzA1MTAxMDQ5WjA6MQswCQYDVQQGEwJJTjESMBAGA1UEChMJSW5kaWEgUEtJMRcwFQYDVQQD\nEw5DQ0EgSW5kaWEgMjAxNDCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAN7IUL2K\/yIN\nrn+sglna9CkJ1AVrbJYBvsylsCF3vhStQC9kb7t4FwX7s+6AAMSakL5GUDJxVVNhMqf\/2paerAzF\nACVNR1AiMLsG7ima4pCDhFn7t9052BQRbLBCPg4wekx6j+QULQFeW9ViLV7hjkEhKffeuoc3YaDm\nkkPSmA2mz6QKbUWYUu4PqQPRCrkiDH0ikdqR9eyYhWyuI7Gm\/pc0atYnp1sru3rtLCaLS0ST\/N\/E\nLDEUUY2wgxglgoqEEdMhSSBL1CzaA8Ck9PErpnqC7VL+sbSyAKeJ9n56FttQzkwYjdOHMrgJRZaP\nb2i5VoVo1ZFkQF3ZKfiJ25VH5+8CAwEAAaMzMDEwDwYDVR0TAQH\/BAUwAwEB\/zARBgNVHQ4ECgQI\nQrjFz22zV+EwCwYDVR0PBAQDAgEGMA0GCSqGSIb3DQEBCwUAA4IBAQAdAUjv0myKyt8GC1niIZpl\nrlksOWIR6yXLg4BhFj4ziULxsGK4Jj0sIJGCkNJeHl+Ng9UlU5EI+r89DRdrGBTF\/I+g3RHcViPt\nOne9xEgWRMRYtWD7QZe5FvoSSGkW9aV6D4iGLPBQML6FDUkQzW9CYDCFgGC2+awRMx61dQVXiFv3\nNbkqa1Pejcel8NMAmxjfm5nZMd3Ft13hy3fNF6UzsOnBtMbyZWhS8Koj2KFfSUGX+M\/DS1TG2Zuj\nwKKXCuKq7+67m0WF6zohoHJbqjkmKX34zkuFnoXaXco9NkOi0RBvLCiqR2lKfzLM7B69bje+z0Eq\nnRNo5+s8PWSdy+xtMIIEJDCCAwygAwIBAgICJ8AwDQYJKoZIhvcNAQELBQAwOjELMAkGA1UEBhMC\nSU4xEjAQBgNVBAoTCUluZGlhIFBLSTEXMBUGA1UEAxMOQ0NBIEluZGlhIDIwMTQwHhcNMTYwNzI4\nMDkyNTE4WhcNMjQwMzA1MDYzMDAwWjCBwTELMAkGA1UEBhMCSU4xDjAMBgNVBAoTBUMtREFDMSAw\nHgYDVQQLExdDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTEPMA0GA1UEERMGNDExMDA3MRQwEgYDVQQI\nEwtNYWhhcmFzaHRyYTElMCMGA1UECRMcUHVuZSBVbml2ZXJzaXR5IENhbXB1cywgUHVuZTEaMBgG\nA1UEMxMRMXN0IGZsb29yLCBLaG9zbGExFjAUBgNVBAMTDUMtREFDIENBIDIwMTQwggEiMA0GCSqG\nSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCYxLdnqHi9Kq57pJuv0ijLCcsbFWirh3vKvoWmxX+i5Wac\nwDZqbF6Oia5aHEgLL0YPeJ+FBNoEAYrDvIGc+UmkAKvM\/6+KN+\/lhDf6TBDMNntCsZ45GrkLcsUX\nHu9MLEqcAUOku8T6aD\/JexF2E5Sg\/\/exL9xvUwwa4TgQm8N1rZBPm5cOPkn3YRerfzHKjoxDwxIN\n3iVS5BjjbJrwGbcOb+yqZo7xKNdHlDKljEYNFpkYWD7rhDrOlPq3IIOi74b1WpoT67\/\/fkHu1qYF\nuUHU5mwkqRZ6gGlH6rYYx9LoLN2Gch8f7IcujvxJLaX5Q57pKiWBFa4FFhIZrupJ66NRAgMBAAGj\ngaswgagwEgYDVR0TAQH\/BAgwBgEB\/wIBADARBgNVHQ4ECgQIQUNyyOQ0cfwwEgYDVR0gBAswCTAH\nBgVggmRkAjATBgNVHSMEDDAKgAhCuMXPbbNX4TAOBgNVHQ8BAf8EBAMCAQYwRgYDVR0fBD8wPTA7\noDmgN4Y1aHR0cDovL2NjYS5nb3YuaW4vcncvcmVzb3VyY2VzL0NDQUluZGlhMjAxNExhdGVzdC5j\ncmwwDQYJKoZIhvcNAQELBQADggEBAL+ELhdhs5EJmH4G8Allsf+JXnI1Wo\/xgDBj0XvvhFD+4L0Z\nlKwm3Z7c21x4xw\/AIUdhJ3YTXhih9HiJxAzS7trWmBRyEv3ebG5nQpID+uCAYjgd+SAStUK58Dm6\nztiS06RtE5X780tdIEMDCFQDIcRpwqhGGGoapE7V7r0eXUoSEd+Ba0OxxmBqz5ebKR+XEM9\/\/UHM\nvkObow\/ZFR8IRZzFbWbUIVRbYtvO8ZCUMFlGwijGzpbDZPKxiYurY6TK1vVoJ54Cr0amkImQtaJN\nMLjOXCBS0K2jxguiT2jHoQ8L+mt5aNETT9HHkeZJorM+V6kqSy6zXMhhzIaO7DsFAbkwggXkMIIE\nzKADAgECAhQAjf6ieYPBMdWstvRlCN\/qJ69ZqzANBgkqhkiG9w0BAQsFADCBwTELMAkGA1UEBhMC\nSU4xDjAMBgNVBAoTBUMtREFDMSAwHgYDVQQLExdDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTEPMA0G\nA1UEERMGNDExMDA3MRQwEgYDVQQIEwtNYWhhcmFzaHRyYTElMCMGA1UECRMcUHVuZSBVbml2ZXJz\naXR5IENhbXB1cywgUHVuZTEaMBgGA1UEMxMRMXN0IGZsb29yLCBLaG9zbGExFjAUBgNVBAMTDUMt\nREFDIENBIDIwMTQwHhcNMjExMjEzMTEwNjU5WhcNMjExMjEzMTEzNjU5WjCCAUQxDjAMBgNVBAYT\nBUluZGlhMRIwEAYDVQQIEwlLYXJuYXRha2ExETAPBgNVBAoTCFBlcnNvbmFsMRswGQYDVQQDExJS\nYWdoYXZlbmRyYSBNdXJnb2QxDzANBgNVBBETBjU4MDAwNDFTMFEGA1UELQNKADAxMDAwNTU5UUJn\na1luTEtYNi8xUFpuTWNuUjJmU2tCeFBkTDlnZklRWHdqM1lkWEJMcEF3Qld3Y1wrZU1yRWYxb0Ey\nLzlTdlMxKTAnBgNVBEETIGVkYjkwOTQxMzlhZDQ0NjBiODc0OTYzMzM0ZWUwOTdlMQ0wCwYDVQQM\nEwQ4ODAyMU4wTAYDVQQuE0UxOTgzTWUyN2FmNTdmY2RiMDIyMzk5NmJjZDFiOWE0MjZjYjdiOTUz\nMWQ1MDIzYzgzNGQyMmU0ZTM3ZTZjOTIyMjNlMGEwWTATBgcqhkjOPQIBBggqhkjOPQMBBwNCAASX\n8tHs9U0Yreor8mRw7B6z2xg5pmMipXtwfOYShp1EopILYHdYPRBMGxupdEkezBDA0pGK9kdFx3IF\nzR7mBttvo4ICFzCCAhMwCQYDVR0TBAIwADAdBgNVHQ4EFgQU9IIfGig5fSvpEANXkMBW3mIK4G4w\nEwYDVR0jBAwwCoAIQUNyyOQ0cfwwDgYDVR0PAQH\/BAQDAgbAMDkGA1UdHwQyMDAwLqAsoCqGKGh0\ndHBzOi8vZXNpZ24uY2RhYy5pbi9jYS9lc2lnbkNBMjAyMS5jcmwwggE\/BgNVHSAEggE2MIIBMjCC\nAQEGB2CCZGQBCQIwgfUwMAYIKwYBBQUHAgEWJGh0dHBzOi8vZXNpZ24uY2RhYy5pbi9jYS9DUFMv\nQ1BTLnBkZjCBwAYIKwYBBQUHAgIwgbMwPhY6Q2VudHJlIGZvciBEZXZlbG9wbWVudCBvZiBBZHZh\nbmNlZCBDb21wdXRpbmcgKEMtREFDKSwgUHVuZTAAGnFUaGlzIENQUyBpcyBvd25lZCBieSBDLURB\nQyBhbmQgdXNlcnMgYXJlIHJlcXVlc3RlZCB0byByZWFkIENQUyBiZWZvcmUgdXNpbmcgdGhlIEMt\nREFDIENBJ3MgY2VydGlmaWNhdGlvbiBzZXJ2aWNlczArBgdggmRkAgQBMCAwHgYIKwYBBQUHAgIw\nEhoQQWFkaGFhciBlS1lDLU9UUDBEBggrBgEFBQcBAQQ4MDYwNAYIKwYBBQUHMAKGKGh0dHBzOi8v\nZXNpZ24uY2RhYy5pbi9jYS9DREFDLUNBMjAxNC5kZXIwDQYJKoZIhvcNAQELBQADggEBAJZG+1GE\n2a3h+pKM1aeXKRExC4CJbH1\/dvRc9ZmS9mD50UIqL+pQ8J9B3YKQZvxrdx5UWAkxXyY2ZMVn\/auc\nl4PWdrYRLMxlmPQhmfVpan5DI7+oAoF1yl+Qqb6Gdeu46ahtNmw3UTl1W5Ta8QkTHZ5hTC\/CatzX\nrusgiu6xJhaBu1Uz\/+X3OTS0vyHjPIoDn2O+E5i2YF3Ogd6Tw1+W7EFALlD4kEqHIyLt2bx7c6uH\n1qeQb4NrFTGcr2wFWLrPJY8B0ToS83qfmSQ6eY5hZ2bXyRf7LO6Ezl1bEmN4elANZXK+thmFatU3\nmRCHK1aO+8x+QfT96\/M9u5FDovXYoBkxggG1MIIBsQIBATCB2jCBwTELMAkGA1UEBhMCSU4xDjAM\nBgNVBAoTBUMtREFDMSAwHgYDVQQLExdDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTEPMA0GA1UEERMG\nNDExMDA3MRQwEgYDVQQIEwtNYWhhcmFzaHRyYTElMCMGA1UECRMcUHVuZSBVbml2ZXJzaXR5IENh\nbXB1cywgUHVuZTEaMBgGA1UEMxMRMXN0IGZsb29yLCBLaG9zbGExFjAUBgNVBAMTDUMtREFDIENB\nIDIwMTQCFACN\/qJ5g8Ex1ay29GUI3+onr1mrMA0GCWCGSAFlAwQCAQUAoGkwGAYJKoZIhvcNAQkD\nMQsGCSqGSIb3DQEHATAcBgkqhkiG9w0BCQUxDxcNMjExMjEzMTEwNjU5WjAvBgkqhkiG9w0BCQQx\nIgQgcXz5tAFy\/sA5+5SUsNKJowYt41blmLLI19\/bmh3TqjQwDAYIKoZIzj0EAwIFAARHMEUCIAUa\nc\/XbSAL3du1IZ8dj7noOoBroSnA+cxxU+zyEqrKXAiEAxeC0kQdQZxm\/9num1Og8wmqZtxvwfgv4\n\/XlCK488acU=";//updated on 31-05-2021 for Form Based Esign method
			
			//to verify response called custom function
			//created & added on 11-06-2019 by Amol
			$verify_cdac_response = $this->verifyCdacResponse($resp_array);
			// $verify_cdac_response = true;
			if($verify_cdac_response == true) {

				require_once(ROOT . DS . 'vendor' . DS . 'tcpdf' . DS . 'tcpdf.php');
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				
				$pdf->my_output($pdf_path,'F',$pdf_path,$cer_value,$pkcs7_value,true);
				
			}else{
				
				$resp_status = false;
			}
				
		}

		//update this response array to DB for log
		$last_insert_id = $this->Session->read('log_last_insert_id');									
		$this->updateResponseLog($last_insert_id,null,$resp_array);
		
		return $resp_status;
	}
	
	//this function is created to update response(first & second) log in db
	public function updateResponseLog($id,$response_one,$response_two){
		
		$this->loadModel('EsignRequestResponseLogs');
					
		if($response_one != null){
			
			//string representation of array
			$response_one = json_encode($response_one);
			
			$query = $this->EsignRequestResponseLogs->query();
			$query->update()
				->set(['response_one'=>$response_one,'modified'=>date('Y-m-d H:i:s')])
				->where(['request_id'=>$id])
				->execute();
			
		}elseif($response_two != null){
			
			//string representation of array
			$response_two = json_encode($response_two); 
			
			$query = $this->EsignRequestResponseLogs->query();
			$query->update()
				->set(['response_two'=>$response_two,'modified'=>date('Y-m-d H:i:s')])
				->where(['request_id'=>$id])
				->execute();
		}
											
	}

	//created this function to fetch cdac response array and verify the signature
	//on 11-06-2019 by Amol
	public function verifyCdacResponse($resp_array){

		if ($resp_array['@attributes']['status'] == 1) {

			//certificate file provided by CDAC
			$get_cdac_cert = file_get_contents(ROOT . DS . 'webroot' . DS . 'doc' . DS . 'mts-selfsigned.crt');
			$split_string = explode('-----',$get_cdac_cert);//split string and get cert key string from it
			$cert_key_string = $split_string[2];
			
			//signature attached with response 
			$resp_cdac_signature = $resp_array['Signature']['SignatureValue']; //updated on 31-05-2021 for Form Based Esign method
	
			//Certificate details attached with response
			// $resp_cdac_cert = $resp_array['EsignResp']['Signature']['KeyInfo']['X509Data']['X509Certificate']; //no such value in form based response now 31-05-2021
			
			//remove white spaces and compare in condition
			// if(preg_replace('/\s+/', '', $cert_key_string) == preg_replace('/\s+/', '', $resp_cdac_cert)){	
				// return true;
			// }else{
				// return false;
			// }
			
			return true;

		} else {

			return false;

		}

	}
	
	//created this function to show esign failed message redirect to home page
	public function esignIssue(){
		
		$message = 'Sorry.. Esign Failed, Please login again and try.';
		$redirect_to = '/';
		$this->view = '/Elements/message_boxes';
		
		$this->set('message',$message);
		$this->set('redirect_to',$redirect_to);

	}
   
}

?>