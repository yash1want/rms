<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Datasource\ConnectionManager;			  
use Cake\Controller\Controller;
use Cake\Routing\Router;
use Cake\Cache\Cache;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
ob_start();
class AppController extends Controller
{
    public $alert_message = ""; 
    public $alert_redirect_url = "";
    public $alert_theme = "";
    
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        
        ini_set('memory_limit', '10G');
        set_time_limit(600);
        $this->mpasconn = ConnectionManager::get('mpas');
		
        $this->Session = $this->getRequest()->getSession();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Beforepageload');
		
		
		if ($this->Session->read('loginusertype') == 'mmsuser') {
				 if(!defined('ForReportUserName')) define("ForReportUserName", "root");
				 if(!defined('ForReportPassword')) define("ForReportPassword", "mypassword123");
				 if(!defined('ForReportConnection')) define("ForReportConnection", "10.194.73.125");
				 if(!defined('ForReportDatabaseInterfade')) define("ForReportDatabaseInterfade", "mysql");
				 if(!defined('ForReportDB')) define("ForReportDB", "ibmphasetwo");
				 if(!defined('reporticoReport')) define("reporticoReport", $_SERVER['DOCUMENT_ROOT'] . "/vendor/reportico");
				/*define("ForReportUserName", "root");
				define("ForReportPassword", "");
				define("ForReportConnection", "localhost");
				define("ForReportDatabaseInterfade", "mysql");
				define('ForReportDB', 'ibmreturn');
				define('reporticoReport', $_SERVER['DOCUMENT_ROOT'] . "/IBMRETURN/IBMRETV8/vendor/reportico");*/
		}

        // SET cutoff date FOR PHASE-II
		$this->StartDates = $this->getTableLocator()->get('StartDates');
		$cutoff_date = $this->StartDates->getStartDate();
        Configure::write('cutoff_date', $cutoff_date); //cutoff date of returns for old MCDR as MCDR 2017 gets effective 

		$version = '1054'; // 28-06-2023
        $projectPath = 'https://ibmreturns.gov.in/';
		$this->set('version',$version);
		$this->set('projectPath',$projectPath);

        // UNSET 'oldreturns' SESSION VARIABLE IF URL CHANGED FROM OLD RETURN LISTING
        $currentActionUrl = $this->getRequest()->getParam('controller') . "/". $this->getRequest()->getParam('action');
        $exceptionOldReturnsUrl = array('Auth/returnsRecords', 'Mms/returnsRecords', 'Monthly/monthlyReturnsPdf', 'Returnspdf/minerPrintPdfOld', 'Mms/monthlyReturnsPdf', 'Returnspdf/enduserPrintPdfOld');
        if (!in_array($currentActionUrl, $exceptionOldReturnsUrl)) {
            if (null != $this->Session->read('oldreturns')) {
                $this->Session->delete('oldreturns');
            }
        }

        // SET DEFAULT CONNECTION STRING AS PER NEW & OLD RETURNS
        // THIS IS FOR HANDLING PDF VIEW OF OLD RETURNS (PHASE-I RETURNS)
        // AS THESE RETURNS DATA GETS FROM PHASE-I DB
        $defaultConnectionString = (null != $this->Session->read('oldreturns')) ? 'default' : 'default';
        Configure::write('conn', $defaultConnectionString);
        
        date_default_timezone_set('Asia/Kolkata');
        ini_set('upload_max_filesize', '100M');
	//	ini_set('max_input_vars', '5000');
        if(isset($_GET['test'])){
			echo ini_get('max_input_vars'); 
			echo phpinfo();exit;
		}
        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');

        Cache::disable();

        $this->loadModel('MmsUserRole');
        $userRoles = $this->MmsUserRole->find('list',['keyField'=>'id','valueField'=>'role'])->toArray();
        $this->set('mms_user_role_array',$userRoles);
        //fetch site menus
        if(null == $this->Session->read('username')){
			$this->Beforepageload->set_site_menus();
			$this->Beforepageload->fetch_visitor_count();
        }
		
		//$this->Beforepageload->checkMultiBrowserSession();
        $this->set('customer_id','');
		
		// $this->Beforepageload->ValidDomainRequest();
		
		//$cronjob = new CronjobController();
		//$cronjob->mmsDashboardCount();
    }

	
	public function userSessionExits(){
		
		if(null == $this->Session->read('username')){
			
			$msg = 'Your session is expired due to inactivity';
			$this->invalidActivities($msg);
		}
	}
	
	public function invalidActivities($msg = null){
				
		$this->Session->destroy();
        $homeUrl = "https://ibmreturns.gov.in"; //added on 04-07-2022 by Aniket.
        $msg_txt = ($msg == null) ? "Sorry something wrong happened !! " : $msg;
        $msg_icon = ($msg_txt == 'Your session is expired due to inactivity') ? 'clock' : 'exclamation-circle';
        $msg_title = ($msg_txt == 'Your session is expired due to inactivity') ? 'Session Expired' : 'Alert';

        $msg_content = '<html lang="en"><head>
                        <meta charset="utf-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta http-equiv="Content-Language" content="en">
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>Session expired</title>
                        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
                        <meta name="description" content="This is an example dashboard created using build-in elements and components.">
                        <meta name="msapplication-tap-highlight" content="no">
                        <link href="'.$homeUrl.'/favicon.ico" type="image/x-icon" rel="icon"><link href="'.$homeUrl.'/favicon.ico" type="image/x-icon" rel="shortcut icon"><meta charset="utf-8"><link rel="stylesheet" href="'.$homeUrl.'/css/main.css"><script src="'.$homeUrl.'/js/main.js"></script><style type="text/css">/* Chart.js */
                        @-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}</style></head>
                        <body>
                            <link rel="stylesheet" href="'.$homeUrl.'/css/error/session_expired.css"><div class="container-fluid error_div">
                            <div class="card col-md-4 mx-auto p-0">
                                <div class="card-header">
                                    '.$msg_title.'
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless font-weight-bold font_gainsboro">
                                        <tbody><tr>
                                            <td rowspan="2" class="align-top"><i class="fa fa-'.$msg_icon.'" id="error_icon"></i></td>
                                            <td>'.$msg_txt.'</td>
                                        </tr>
                                        <tr>
                                            <td>Click "Continue" to redirect to the login page.</td>
                                        </tr>
                                    </tbody></table>
                                    <a href="'.$homeUrl.'" class="btn btn_continue float-right text-white font-weight-bold">CONTINUE</a></div>
                                </div>
                            </div>
                        </body>
                        </html>';

		echo $msg_content;
        exit;

	}
    
    /**
     * HTML ENCODE ALL POST DATA REQUEST FOR SECURITY PURPOSE
     * COMMON FUNCTION FOR ALL POST DATA ENCODING
     * @authorOne   Pravin Bhakare
     * @authorTwo   Aniket Ganvir
     * @createdOn   15th JAN 2021
     */
    public function htmlEncodePostData() {
        
        if($this->request->is('post')){
            
            // CHECK JSON ENCODE ARRAY, IF FOUND EXCEPT IT FROM VALIDATION
            if(!array_key_exists("m_sample_obs_code", $this->request->data)){
            
                foreach($this->request->data as $key => $value){
                    
                    $exceptEncodes = array("&amp;","&ndash;");
                    $retainEncodes = array("&","–");
                    
                    if(is_array($value))
                    {
                        foreach($value as $keyTwo => $valueTwo){
                            if(is_array($valueTwo))
                            {
                                foreach($valueTwo as $keyThree => $valueThree){
                                    $this->request->data[$key][$keyTwo][$keyThree] = str_replace($exceptEncodes,$retainEncodes,htmlentities($valueThree, ENT_QUOTES));
                                    $_POST[$key][$keyTwo][$keyThree] = str_replace($exceptEncodes,$retainEncodes,htmlentities($valueThree, ENT_QUOTES));
                                }
                            }
                            else
                            {
                                $this->request->data[$key][$keyTwo] = str_replace($exceptEncodes,$retainEncodes,htmlentities($valueTwo, ENT_QUOTES));
                                $_POST[$key][$keyTwo] = str_replace($exceptEncodes,$retainEncodes,htmlentities($valueTwo, ENT_QUOTES));
                            }
                        }
                    }
                    else
                    {
                        $this->request->data[$key] = str_replace($exceptEncodes,$retainEncodes,htmlentities($value, ENT_QUOTES));
                        $_POST[$key] = str_replace($exceptEncodes,$retainEncodes,htmlentities($value, ENT_QUOTES));
                    }
                    
                }
                
            }
            
        }
        
    }


     public function proceedEvenMultipleLogin(){

        $loginusertype =  $this->Session->read('loginusertype'); 

        $action = $this->Session->read('alreadyLogin');
        $userName = $this->Session->read('username');  
        
        $UsersController = new UsersController();           
        $UsersController->loginProceed($userName,$action);        

        if(in_array($loginusertype,array('mmsuser'))){

            $this->redirect(array('controller'=>'mms', 'action'=>'home'));

        }elseif(in_array($loginusertype,array('primaryuser','authuser','enduser'))){

            $this->redirect(array('controller'=>'auth', 'action'=>'home'));
        }    
    }
    
	// Logout on session expired, Added on 11-10-2022 by Aniket
	public function sessionExpiredLogout(){	
	
		$this->autoRender = false;
		
		if ($this->request->is('post')) {
			if($_POST['action'] == 'session_logout'){

				$usertype = htmlentities($_POST['session_usertype'], ENT_QUOTES);
				$session_token = htmlentities($_POST['session_token'], ENT_QUOTES);
				$username = $_POST['session_username'];
				$support_team_login = $_POST['session_support_team_login'];
				
				$date = date('Y/m/d H:i:s');
                $this->loadModel('McUserLog');
                $this->loadModel('MmsUserLog');
                $this->loadModel('BrowserLogin');

				if($support_team_login == false){ // restrict support team logs
					if($usertype == 'authuser' || $usertype == 'enduser' || $usertype == 'primaryuser'){

						$this->McUserLog->updateAll(
							array(
								'logout_time'=>$date,
								'status'=>'FULL',
								'session_expired'=>1,
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
								'session_expired'=>1,
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
	
				echo '1';
				exit;

			}
		}
		
	}

}
