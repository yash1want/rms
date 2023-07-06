<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Network\Email\Email;
use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

class AuthController extends AppController{
		
	var $name = 'Auth';
	var $uses = array();
	
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);
	}
	
    public function initialize(): void
    {
        parent::initialize();
		$this->userSessionExits();
		
		$this->loadComponent('Createcaptcha');
		$this->loadComponent('Authentication');
		$this->loadComponent('Customfunctions');
		$this->loadComponent('Returnslist');
		$this->loadComponent('Clscommon');
		
		$this->loadModel('Mine');
		$this->loadModel('McUser');
		
		$this->viewBuilder()->setHelpers(['Form','Html']);
		$this->Session = $this->getRequest()->getSession();
		$this->TblFinalSubmit = $this->getTableLocator()->get('TblFinalSubmit');
		$this->TblEndUserFinalSubmit = $this->getTableLocator()->get('TblEndUserFinalSubmit');

		$this->connection = ConnectionManager::get('default');
		
		
    }
	
	public function home(){
	
		$userId = $this->Session->read('username');
		
		$result = explode('/', $userId);
		
		if(count($result) == 1){

			$this->redirect('/auth/primary-home');
			
		}else{
			
			$enduser = strpos($userId,"block");
			
			if($enduser != null){

				$this->redirect('/auth/enduser-home');
				
			}else{
				
				$this->redirect('/auth/auth-home');
			}
			
			
		}
	
	}
	
	
	public function authHome() {
		 
        $alert_message = '';
		$alert_message_status = '';  
		$alert_redirect_url = '';

        $this->loadModel('McMineDir');
        $this->loadModel('McmineSheldDet');
		$this->viewBuilder()->setLayout('mc_panel');
        
		$table = 'TBL_FINAL_SUBMIT';
		$userId = $this->Session->read('username');
		$mine_code = $this->Session->read('mc_mine_code');
		$this->Session->write('color_code', 'hidden');
        
        // added by shankhpal on 12/05/2022
		$result1 = $this->McmineSheldDet->find('all',array('fields'=>array('mcmd_mine_code'),'conditions'=>array('mcmd_mine_code IS'=>$mine_code)))->first();
       
		$result2 = $this->McMineDir->find('all',array('fields'=>array('mcm_mine_code'),'conditions'=>array('mcm_mine_code IS'=>$mine_code)))->first();

       if(empty($result1) || empty($result2))
       {
			  $alert_message = "Kindly update your mine / lease data through Registration form K (ibmreg.nic.in). After your updation request is approved by respective RO, you will be able to file your returns against this mine code.";
			   $alert_message_status = "error";
			   $alert_redirect_url = "/users/logout/authuser";
		} 
        $this->set('alert_redirect_url',$alert_redirect_url);
        $this->set('alert_message',$alert_message);
		$this->set('alert_message_status',$alert_message_status);
        //end code

        $temp = explode('/', $userId);
        $app_id = $temp[0] . "/" . $temp[1];

        if (count($temp) == 3){
            $submitted_by = $temp[2];
        } else {
            $submitted_by = $app_id;
        }
		
		$mineCreated = $this->Mine->find('all',array('fields'=>array('created_at'),'conditions'=>array('mine_code IS'=>$mine_code)))->first();
		$mineCreatedDate =  $mineCreated['created_at'];
		
		
		$totalMonthsYears = $this->getTotalReturnsMonthsYear($mineCreatedDate);
		$totalMonths = $totalMonthsYears[0];		
		$totalYears = $totalMonthsYears[1];
		//print_r($mineCreatedDate); exit;
		$conn = ConnectionManager::get('default');
		
		$mTSubmittedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','',$table,'MONTHLY','','1');
		$mSubmittedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','0|1|2',$table,'MONTHLY','submitted','1');
		$mRepliedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','0|1|2',$table,'MONTHLY','replied','1');
		$mReferredBackCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','4',$table,'MONTHLY','','1');
		$mApprovedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','3',$table,'MONTHLY','','1');
		$mTPendingCountRes = $totalMonths - array_sum(array_column($mTSubmittedCount, 'count'));
				
		$mTPendingCount = ($mTPendingCountRes < 0) ? 0 : $mTPendingCountRes;
				
		$this->Session->write('mTSubmittedCount',array_sum(array_column($mTSubmittedCount, 'count')));
		$this->Session->write('mSubmittedCount',array_sum(array_column($mSubmittedCount, 'count')));
		$this->Session->write('mRepliedCount',array_sum(array_column($mRepliedCount, 'count')));
		$this->Session->write('mReferredBackCount',array_sum(array_column($mReferredBackCount, 'count')));
		$this->Session->write('mApprovedCount',array_sum(array_column($mApprovedCount, 'count')));
		$this->Session->write('mTPendingCount',$mTPendingCount);	
				
				
		$aTSubmittedCount =  $this->Returnslist->getFilteredUserReturnsList($app_id,'','','',$table,'ANNUAL','','1');
		$aSubmittedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','0|1|2',$table,'ANNUAL','submitted','1');
		$aRepliedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','0|1|2',$table,'ANNUAL','replied','1');
		$aReferredBackCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','4',$table,'ANNUAL','','1');
		$aApprovedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','3',$table,'ANNUAL','','1');
		$aTPendingCountRes = $totalYears - array_sum(array_column($aTSubmittedCount, 'count'));

		$aTPendingCount = ($aTPendingCountRes < 0) ? 0 : $aTPendingCountRes;	

		$this->Session->write('aTSubmittedCount',array_sum(array_column($aTSubmittedCount, 'count')));
		$this->Session->write('aSubmittedCount',array_sum(array_column($aSubmittedCount, 'count')));
		$this->Session->write('aRepliedCount',array_sum(array_column($aRepliedCount, 'count')));
		$this->Session->write('aReferredBackCount',array_sum(array_column($aReferredBackCount, 'count')));
		$this->Session->write('aApprovedCount',array_sum(array_column($aApprovedCount, 'count')));
		$this->Session->write('aTPendingCount',$aTPendingCount);		
		
	}
	
	
	public function primaryHome() {
		
		$this->viewBuilder()->setLayout('mc_panel');		
		$userId = $this->Session->read('username');
		$this->Session->write('color_code', 'hidden');
		
		$authtable = 'TBL_FINAL_SUBMIT';
		$endTable = 'TBL_END_USER_FINAL_SUBMIT';
		
		
		//================== For Miner Returns Count =================//
		
		$getMineList = $this->McUser->find('list',array('valueField'=>'mcu_mine_code','conditions'=>array('mcu_mine_code IS NOT'=>NULL,'mcu_mine_code NOT LIKE'=>'%block%', 'mcu_parent_app_id'=>$userId)))->toList();
		
		$totalMonths[] = '';		
		$totalYears[] = '';	
		if (!empty($getMineList)) {
			
			$mineCreated = $this->Mine->find('all',array('fields'=>array('created_at'),'conditions'=>array('mine_code IN'=>array_unique(array_values($getMineList)))))->toArray();		
				
			foreach($mineCreated as $each){			
				$mineCreatedDate =  $each['created_at'];
				$totalMonthsYears = $this->getTotalReturnsMonthsYear($mineCreatedDate);
				$totalMonths[] = $totalMonthsYears[0];		
				$totalYears[] = $totalMonthsYears[1];			
			}

		}	
				
		$conn = ConnectionManager::get('default');		
		
		/**For Monthly Total Submitted, Referred Back and Approved Count**/	
		
		$mTSubmittedCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','',$authtable,'MONTHLY');
		$mSubmittedCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','0|1|2',$authtable,'MONTHLY');
		$mReferredBackCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','4',$authtable,'MONTHLY');
		$mApprovedCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','3',$authtable,'MONTHLY');
		$mTPendingCountRes = array_sum($totalMonths) - count(array_column($mTSubmittedCount, 'MineCode'));

		$mTPendingCount = ($mTPendingCountRes < 0) ? 0 : $mTPendingCountRes;		

		$this->Session->write('mTSubmittedCount',count(array_column($mTSubmittedCount, 'MineCode')));
		$this->Session->write('mSubmittedCount',count(array_column($mSubmittedCount, 'MineCode')));
		$this->Session->write('mReferredBackCount',count(array_column($mReferredBackCount, 'MineCode')));
		$this->Session->write('mApprovedCount',count(array_column($mApprovedCount, 'MineCode')));
		$this->Session->write('mTPendingCount',$mTPendingCount);
		
		/**For Annual Total Submitted, Referred Back and Approved Count**/		
		
		$aTSubmittedCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','',$authtable,'ANNUAL');
		$aSubmittedCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','0|1|2',$authtable,'ANNUAL');
		$aReferredBackCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','4',$authtable,'ANNUAL');
		$aApprovedCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','3',$authtable,'ANNUAL');
		$aTPendingCountRes = array_sum($totalYears) - count(array_column($aTSubmittedCount, 'MineCode'));

		$aTPendingCount = ($aTPendingCountRes < 0) ? 0 : $aTPendingCountRes;		

		$this->Session->write('aTSubmittedCount',count(array_column($aTSubmittedCount, 'MineCode')));
		$this->Session->write('aSubmittedCount',count(array_column($aSubmittedCount, 'MineCode')));
		$this->Session->write('aReferredBackCount',count(array_column($aReferredBackCount, 'MineCode')));
		$this->Session->write('aApprovedCount',count(array_column($aApprovedCount, 'MineCode'))); 	 
		$this->Session->write('aTPendingCount',$aTPendingCount); 	
		
		/**For Monthly Total Pending Count**/			

		//================== End Miner Returns Count  =================//





		//================== Trader/End User Returns Count  =================//
		
		$getBlockUsrList = $this->McUser->find('list',array('valueField'=>'mcu_child_user_name','conditions'=>array('mcu_parent_app_id IS'=>$userId,'mcu_child_user_name LIKE'=>'%/block%/%')))->toList();
		
		$eTotalMonths[] = '';		
		$eTotalYears[] = '';	

		if (!empty($getBlockUsrList)) {
			$BlockUsrList = array();
			foreach($getBlockUsrList as $eachUsr){
				
				$temp = explode('/', $eachUsr);
				if (count($temp) == 4){
					$BlockUsrList[] = $temp[0].'/'.$temp[1].'/'.$temp[2];
				} else {
					$BlockUsrList[] = $eachUsr;
				}
			}
			
			$blockUsrCreated = $this->McUser->find('all',array('fields'=>array('created_at'),'conditions'=>array('mcu_child_user_name IN'=>array_unique($BlockUsrList))))->toArray();	
			
			foreach($blockUsrCreated as $each){			
				$blockUsrCDate =  $each['created_at'];
				$eTotalMonthsYears = $this->getTotalReturnsMonthsYear($blockUsrCDate);
				$eTotalMonths[] = $eTotalMonthsYears[0];		
				$eTotalYears[] = $eTotalMonthsYears[1];			
			}
		}
		
		

		$emTSubmittedCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','',$endTable,'MONTHLY');
		$emSubmittedCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','0|1|2',$endTable,'MONTHLY');
		$emReferredBackCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','4',$endTable,'MONTHLY');
		$emApprovedCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','3',$endTable,'MONTHLY');
		$emTPendingCountRes = array_sum($eTotalMonths) - count(array_column($emTSubmittedCount, 'ApplicantId'));
		
		$emTPendingCount = ($emTPendingCountRes < 0) ? 0 : $emTPendingCountRes;

		$this->Session->write('emTSubmittedCount',count(array_column($emTSubmittedCount, 'ApplicantId')));
		$this->Session->write('emSubmittedCount',count(array_column($emSubmittedCount, 'ApplicantId')));
		$this->Session->write('emReferredBackCount',count(array_column($emReferredBackCount, 'ApplicantId')));
		$this->Session->write('emApprovedCount',count(array_column($emApprovedCount, 'ApplicantId')));
		$this->Session->write('emTPendingCount',$emTPendingCount);
		
		$eaTSubmittedCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','',$endTable,'ANNUAL');
		$eaSubmittedCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','0|1|2',$endTable,'ANNUAL');
		$eaReferredBackCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','4',$endTable,'ANNUAL');
		$eaApprovedCount = $this->Returnslist->getFilteredPrimaryUserReturnsList($userId,'','','','','3',$endTable,'ANNUAL');		
		$eaTPendingCountRes = array_sum($eTotalYears) - count(array_column($eaTSubmittedCount, 'ApplicantId'));

		$eaTPendingCount = ($eaTPendingCountRes < 0) ? 0 : $eaTPendingCountRes;
		
		$this->Session->write('eaTSubmittedCount',count(array_column($eaTSubmittedCount, 'ApplicantId')));
		$this->Session->write('eaSubmittedCount',count(array_column($eaSubmittedCount, 'ApplicantId')));
		$this->Session->write('eaReferredBackCount',count(array_column($eaReferredBackCount, 'ApplicantId')));
		$this->Session->write('eaApprovedCount',count(array_column($eaApprovedCount, 'ApplicantId'))); 	 
		$this->Session->write('eaTPendingCount',$eaTPendingCount); 	
		
		//================== End Trader/End User Returns Count  =================//
	
	}
	
	public function enduserHome() {
		
		$this->viewBuilder()->setLayout('mc_panel');
		$this->Session->write('color_code', 'hidden');
        
		$table = 'TBL_END_USER_FINAL_SUBMIT';

		$userId = $this->Session->read('username');
		$applicantId = $this->Session->read('applicantid');
		
        $temp = explode('/', $userId);
		if (count($temp) == 4){
			$app_id = $temp[0].'/'.$temp[1].'/'.$temp[2];
		} else {
			$app_id = $userId;
		}

		
		$blockUsrCreated = $this->McUser->find('all',array('fields'=>array('created_at'),'conditions'=>array('mcu_child_user_name IS'=>$app_id)))->first();
		$blockUsrCreatedDate =  $blockUsrCreated['created_at'];
		
		$totalMonthsYears = $this->getTotalReturnsMonthsYear($blockUsrCreatedDate);
		$totalMonths = $totalMonthsYears[0];		
		$totalYears = $totalMonthsYears[1];

		$conn = ConnectionManager::get('default');
					
		$mTSubmittedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','',$table,'MONTHLY','','1');
		$mSubmittedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','0|1|2',$table,'MONTHLY','submitted','1');
		$mRepliedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','0|1|2',$table,'MONTHLY','replied','1');
		$mReferredBackCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','4',$table,'MONTHLY','','1');
		$mApprovedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','3',$table,'MONTHLY','','1');
		$mTPendingCountRes = $totalMonths - array_sum(array_column($mTSubmittedCount, 'count'));
			
		$mTPendingCount = ($mTPendingCountRes < 0) ? 0 : $mTPendingCountRes;
				
		$this->Session->write('emTSubmittedCount',array_sum(array_column($mTSubmittedCount, 'count')));
		$this->Session->write('emSubmittedCount',array_sum(array_column($mSubmittedCount, 'count')));
		$this->Session->write('emRepliedCount',array_sum(array_column($mRepliedCount, 'count')));
		$this->Session->write('emReferredBackCount',array_sum(array_column($mReferredBackCount, 'count')));
		$this->Session->write('emApprovedCount',array_sum(array_column($mApprovedCount, 'count')));
		$this->Session->write('emTPendingCount',$mTPendingCount);	
				
		$aTSubmittedCount =  $this->Returnslist->getFilteredUserReturnsList($app_id,'','','',$table,'ANNUAL','','1');
		$aSubmittedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','0|1|2',$table,'ANNUAL','submitted','1');
		$aRepliedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','0|1|2',$table,'ANNUAL','replied','1');
		$aReferredBackCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','4',$table,'ANNUAL','','1');
		$aApprovedCount = $this->Returnslist->getFilteredUserReturnsList($app_id,'','','3',$table,'ANNUAL','','1');
		$aTPendingCountRes = $totalYears - array_sum(array_column($aTSubmittedCount, 'count'));
		
		$aTPendingCount = ($aTPendingCountRes < 0) ? 0 : $aTPendingCountRes;

		$this->Session->write('eaTSubmittedCount',array_sum(array_column($aTSubmittedCount, 'count')));
		$this->Session->write('eaSubmittedCount',array_sum(array_column($aSubmittedCount, 'count')));
		$this->Session->write('eaRepliedCount',array_sum(array_column($aRepliedCount, 'count')));
		$this->Session->write('eaReferredBackCount',array_sum(array_column($aReferredBackCount, 'count')));
		$this->Session->write('eaApprovedCount',array_sum(array_column($aApprovedCount, 'count')));
		$this->Session->write('eaTPendingCount',$aTPendingCount);
		
		$mmsRemark = $this->TblEndUserFinalSubmit->getSupervisorComments($applicantId);
		$this->set('mmsRemark', $mmsRemark);
		
	}

	public function returns($return_type,$form_type,$status,$oldreturns=null){
				
		$this->Session->write('sess_return_type', $return_type);
		$this->Session->write('sess_form_type', $form_type);
		$this->Session->write('sess_status', $status);
		if (!empty($oldreturns)) {
			$this->Session->write('oldreturns',$oldreturns);
		}else{
			if (!empty($this->Session->read('oldreturns'))){
					$this->Session->delete('oldreturns');
				}
		}
		$this->redirect(array('controller'=>'auth','action'=>'returns-records'));
	}


	public function returnsRecords(){

		$this->viewBuilder()->setLayout('mc_panel');
		
		$username = $this->Session->read('username');
		$temp = explode('/', $username);

		$returnType = strtoupper($this->Session->read('sess_return_type'));
		$sess_status = $this->Session->read('sess_status');
		$sess_form_type = $this->Session->read('sess_form_type');
		$returnPeriodArr = $this->Customfunctions->getReturnPeriodArr('auth');
		$this->set('returnPeriodArr',$returnPeriodArr);

		$fromDate = null;
		$toDate = null;
		$applicantId = null;
		$mineCode = null;

		if (null !== $this->request->getData('f_search')){

			$rb_period = $this->request->getData('rb_period');
				
			if($rb_period == 'period'){
				
				$r_period = $this->Customfunctions->getReturnDateByReturnPeriod($this->request->getData('r_period'));
				
				$fromDate = $r_period[0];
				$toDate = $r_period[1];
				
			}elseif($rb_period == 'range'){	
			
				$fromDate = $this->Customfunctions->getReturnsDateByReturnRange($this->request->getData('from_date'));
				$toDate = $this->Customfunctions->getReturnsDateByReturnRange($this->request->getData('to_date'));
			}
		}

		switch($sess_status){
			case 'total' :
				$status = '';
				break;
			case  'submitted' :
				$status = '0|1|2';
				break;
			case 'replied' :
				$status = '0|1|2';
				break;
			case 'referredback' :
				$status = '4';
				break;	
			case 'accepted' :
				$status = '3';
				break;
			default :
				$status = '';
				break;		
		}


		if(in_array($sess_form_type,array('f','g'))){

			$table = 'TBL_FINAL_SUBMIT';

		}elseif(in_array($sess_form_type,array('m','l'))){

			$table = 'TBL_END_USER_FINAL_SUBMIT';
		}

		if(strpos($username,'block') > 0 ){

			if (count($temp) == 4){
				$app_id = $temp[0].'/'.$temp[1].'/'.$temp[2];
			} else {
				$app_id = $username;
			}

			$returnsData = $this->Returnslist->getFilteredUserReturnsList($app_id,$fromDate,$toDate,$status,$table,$returnType,$sess_status,'');

		}else{

			if(count($temp) > 1){

				$app_id = $temp[0] . "/" . $temp[1];

				$returnsData = $this->Returnslist->getFilteredUserReturnsList($app_id,$fromDate,$toDate,$status,$table,$returnType,$sess_status,'');

			}else{

				$app_id = $username;

				$returnsData = $this->Returnslist->getFilteredPrimaryUserReturnsList($app_id,$applicantId,$mineCode,$fromDate,$toDate,$status,$table,$returnType);
			}  
		}

		$cutoffDate = Configure::read('cutoff_date');
		
		$this->set('returnsData',$returnsData);
		$this->set('dashboard','authuser');
		$this->set('cutoffDate',$cutoffDate);

	}

	
	
	public function getTotalReturnsMonthsYear($startDate){
		
		$this->loadModel('StartDates');
		
		/*if($startDate == NULL || $startDate == ''){		
			
		}*/
		$mineStartDate = $this->StartDates->find('all')->first();
		$startDate = $mineStartDate['startdate'];
		
		$currDateOfDay = date("d"); // Today Date of day
		$currDateOfmonth = date("m"); // Today Date of month	
		$d1 = strtotime($startDate); // Start date of mine
		
		$d2 = date("Y-m-d h:m:s");  
		$d3 = strtotime($d2); // Today date

		$totalSecondsDiff = abs($d1-$d3); // Difference of start and today day
		$totalDaysDiff    = intval($totalSecondsDiff/60/60/24); // Total difference in days
		$totalMonthsDiff  = intval($totalSecondsDiff/60/60/24/30); // Total difference in months
		$totalYearsDiff   = intval($totalSecondsDiff/60/60/24/365);  // Total difference in years
				
		if($currDateOfDay < 10){
			$totalMonths = $totalMonthsDiff -1;
		}else{
			$totalMonths = $totalMonthsDiff;
		}
		
		if($currDateOfmonth < 4){
			$totalYears = $totalYearsDiff -1;
		}else{
			$totalYears = $totalYearsDiff;
		}
				
		return array($totalMonths,$totalYears);		
	}

	public function level3Users(){

		$this->Session->delete('level3userid');

		$this->viewBuilder()->setLayout('mc_panel');		
		$userId = $this->Session->read('username');
		$mcMineCode = $this->Session->read('mc_mine_code');
		
		$level3users = $this->McUser->find('all',array(
						'fields'=>array('mcu_user_id','mcu_email','mcu_first_name','mcu_last_name','mcu_child_user_name','is_deleted'),
						'conditions'=>array('mcu_child_user_name like'=>'%'.$userId.'%','mcu_level_flag'=>'3'),
						 'order'=>array('is_deleted','mcu_user_id desc')))
						->toArray();

		$this->set('level3users',$level3users);
	}

	public function level3UserActivited($userid){
		
		$this->loadModel('Mcuser');

		$this->Mcuser->updateAll(
			array('is_deleted'=>'no'),
			array('mcu_user_id'=>$userid)
		);

		$this->redirect('/auth/level3-users');
	}

	public function level3UserDeactivited($userid){

		$this->loadModel('Mcuser');
			
		$this->Mcuser->updateAll(
			array('is_deleted'=>'yes'),
			array('mcu_user_id'=>$userid)
		);

		$this->redirect('/auth/level3-users');
	}
	

	public function updateLevel3User($userid){

		$this->Session->write('level3userid',$userid);
		$this->redirect('/auth/level3-user');
	}

	public function level3User(){

		$this->viewBuilder()->setLayout('mc_panel');		
		$this->loadModel('Mcuser');

		
		$level3userid = $this->Session->read('level3userid');
		$mcMineCode = $this->Session->read('mc_mine_code');
		$parentid = $this->Session->read('parentid');
		$username = $this->Session->read('username');

		$email = null;
		$firstname = null;
		$lastname = null;
		$heading =  'create User';
		$buttonlabel = 'Create';

		$userlist = $this->Mcuser->find('all',array('conditions'=>array('mcu_child_user_name like'=>'%'.$username.'%')))->toArray();
		$mcu_role = count($userlist);
		
		$mcu_child_user_name = $username.'/'.$mcu_role;

		if( null !== $level3userid){
			$heading =  'update user';
			$level3UserDetails = $this->Mcuser->find('all',array('conditions'=>array('mcu_user_id'=>$level3userid)))->first();
			$firstname = $level3UserDetails['mcu_first_name'];
			$lastname = $level3UserDetails['mcu_last_name'];
			$email = $level3UserDetails['mcu_email'];
			$mcu_child_user_name = $level3UserDetails['mcu_child_user_name'];

			$buttonlabel = 'Update';
		}

		if($this->request->is('post')){
			
			$firstname = $this->request->getData('first_name');
			$lastname = $this->request->getData('last_name');
			$email = $this->request->getData('email');
			


			$newEntity = $this->Mcuser->newEntity(array(

				'mcu_user_id'=>$level3userid,
				'mcu_first_name'=>$firstname,
				'mcu_last_name'=>$lastname,
				'mcu_email'=>$email,
				'mcu_activity'=>1,
				'mcu_mine_code'=>$mcMineCode,
				'mcu_ip_address'=>$_SERVER['REMOTE_ADDR'],
				'mcu_level_flag'=>3,
				'mcu_parent_app_id'=>$parentid,
				'mcu_child_user_name'=>$mcu_child_user_name,
				'mcu_role'=>$mcu_role
			));
			
			$result = $this->Mcuser->save($newEntity);
		
			if( null == $level3userid){				
				$record_id=$result->mcu_user_id;
				$this->Clscommon->forgotPassword($record_id, $username, $email, 'McUser');

				$this->alert_message = "User Created Successfully !!";
				$this->alert_redirect_url = 'level-3-users';
			
			}else{

				$this->alert_message = "User Details Updated !!";
				$this->alert_redirect_url = 'level-3-users';
			}

		}
	
		$this->set('firstname',$firstname);
		$this->set('lastname',$lastname);
		$this->set('email',$email);
		$this->set('heading',$heading);
		$this->set('buttonlabel',$buttonlabel);
		$this->set('level3userid',$level3userid);
		$this->set('alert_message',$this->alert_message);
		$this->set('alert_redirect_url',$this->alert_redirect_url);

	}


	public function level2Users ()
	{
		$this->viewBuilder()->setLayout('mc_panel');	
		$this->loadModel('Mcuser');

		$username = $this->Session->read('username');
//echo $username; die;
		$conn = ConnectionManager::get('default');
		$level2usertype = ['E'=>'Exporter','T'=>'Trader','S'=>'Storage',
					 'W'=>'Trader without Storage','C'=>'End User/Consume',
					 'Mining'=>'Mining'];


		$result = $conn->execute("select mcmd_mine_code, LOWER(mcbd_mine_name) as mcbd_mine_name, mcbd_desc   
		from mc_minesheld_det M  
		INNER JOIN mc_businessActivity_det MB ON M.mcmd_app_id = MB.mcbad_app_id 
		INNER JOIN mc_businessActivity_directory MD On MB.mcbad_business_activity_code = MD.mcbd_code    
		Where M.mcmd_app_id = '$username' and MB.mcbad_business_activity_code ='M' and M.mcmd_status = '1'
		
		 UNION ALL    
		
		 select mcmd_slno as mcmd_mine_code,LOWER(CONCAT_WS(' ', mcmd_ba,mcmd_village,mcmd_tehsil,mdr.DISTRICT_NAME,msd.STATE_NAME)) as mcbd_mine_name,
				mcmd_ba as mcbd_desc 
		from mc_mineralTradingStorageExport_det mce
		INNER JOIN mc_mineralTradingStorageExportdistrict_det mced ON  mce.mcmd_app_id=mced.mcmtdd_app_id and mce.mcmd_slno=mced.mcmtdd_slno  
		INNER JOIN mc_district_dir mdr ON mced.mcmtdd_district_code=mdr.LG_DistrictCode and mdr.LG_StateCode=mce.mcmd_state  
		INNER JOIN mc_state_dir msd ON mce.mcmd_state=msd.LG_State_Code
		where mcmd_app_id = '$username' and mce.mcmd_status = '1'
		
		UNION ALL
		
		select mcmd_slno mcmd_mine_code,    
		LOWER(mcmcd_nameofplant) mcbd_mine_name,
		'C' AS mcbd_desc
		from mc_mineralConsumption_det where mcmd_app_id = '$username' and mcmcd_status = '1' ")->fetchAll('assoc');

		
		$i = 0;
		foreach($result as $each){

			$userCreated = '';

			$usrMineCode = $each['mcmd_mine_code'];
			$userLabel = null;
			$userCreatedLabel = 'Generate';
			$useremail = $this->Session->read('user_email');
			
			if (in_array($each['mcbd_desc'], array('T', 'S', 'W'))) // W IS ADDED FOR TRADER WITHOUT STORAGE USER
				$userLabel = 'block7';
			if (in_array($each['mcbd_desc'], array('E')))
				$userLabel = 'block9';
			if (in_array($each['mcbd_desc'], array('C')))
				$userLabel = 'block8';

			if ($userLabel != null)	
			$Usrname = $username . '/' .  $userLabel . '/' . $usrMineCode;
			else
			$Usrname = $username . '/' .  $usrMineCode;

			$userlist = $this->Mcuser->find('all',array('conditions'=>array('mcu_child_user_name IS'=>$Usrname)))->toArray();
			
			if (count($userlist)>0){
				$userCreated = $userlist[0]['mcu_user_id'];
				$userCreatedLabel = 'Regenerate';
				$useremail = base64_decode($userlist[0]['mcu_email']);
			}

			$result[$i]['userid'] = $Usrname;
			$result[$i]['level2usrid'] = $userCreated;
			$result[$i]['actionlabel'] = $userCreatedLabel;
			$result[$i]['useremail'] = $useremail;
			
			$i++;
		}

		$this->set('level2users',$result);
		$this->set('level2usertype',$level2usertype);

		//print_r($result); exit;


	}


	public function profile(){

		$this->viewBuilder()->setLayout('mc_panel');
		$errors = 'false';

		$this->loadModel('McUser');
		$userName = $this->Session->read('username');

		if($this->Session->read('loginusertype') == 'primaryuser'){

			$pri_user_data = $this->connection->newQuery()
							->select('*')
							->from('mc_applicant_det')
							->where(['mcappd_app_id'=>$userName])
							->execute()
							->fetch('assoc');

			$user_data['mcu_first_name']	= 	$pri_user_data['mcappd_fname'];	
			$user_data['mcu_middle_name']	= 	$pri_user_data['mcappd_mname'];
			$user_data['mcu_last_name']	= 	$pri_user_data['mcappd_lastname'];
			$user_data['mcu_email']	= 	base64_decode($pri_user_data['mcappd_email']);
			$user_data['mcu_mob_num']	= 	base64_decode($pri_user_data['mcappd_office_phoneno']);
			$user_data['mcu_designation']	= 	$pri_user_data['mcappd_officer_desig'];	

		}else{
			$user_data = $this->McUser->getUserDatabyId($userName);
			$user_id = $user_data['mcu_user_id'];
		}

		

		
		$this->set('user_details',$user_data);
	
		if (null !== $this->request->getData('save')){
			$formsData = $this->request->getData();
			
			$first_name = htmlentities($formsData['first_name'], ENT_QUOTES);
			$middle_name = htmlentities($formsData['mid_name'], ENT_QUOTES);
			$last_name = htmlentities($formsData['last_name'], ENT_QUOTES);
			$email = htmlentities($formsData['email'], ENT_QUOTES);
			$mob_num = htmlentities($formsData['mobile'], ENT_QUOTES);
			$designation = htmlentities($formsData['designation'], ENT_QUOTES);

			if($first_name == '' || $email == '' || $mob_num == '' ){
				$errors = 'true';
			}

			if( $email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors = 'true';
			}

			if($mob_num != '' && !preg_match("/^[0-9]{10}$/", $mob_num)){
				$errors = 'true';
			}
			
			if(!empty($formsData['user_image']->getClientFilename())){				
				
				$file_name = $formsData['user_image']->getClientFilename();
				$file_size = $formsData['user_image']->getSize();
				$file_type = $formsData['user_image']->getClientMediaType();
				$file_local_path = $formsData['user_image']->getStream()->getMetadata('uri');
				
				$upload_result = $this->Customfunctions->fileUploadLib($file_name,$file_size,$file_type,$file_local_path); // calling file uploading function
				if($upload_result[0] == 'success'){
					$profile_pics = $upload_result[1];
				}else{
					$errors = 'true';
				}
				
			}else{ $profile_pics = $user_data['mcu_user_image']; }

			//print_r($user_id); exit;

			if($errors == 'false'){

				$newEntity = $this->McUser->newEntity(array(
					'mcu_user_id'=>$user_id,
					'mcu_first_name'=>$first_name,
					'mcu_middle_name'=>$middle_name,
					'mcu_last_name'=>$last_name,
					'mcu_email'=>base64_encode($email),
					'mcu_mob_num'=>base64_encode($mob_num),
					'mcu_designation'=>$designation,
					'mcu_user_image'=>$profile_pics
				));

				if($this->McUser->save($newEntity)){

					$this->Session->write('user_first_name', $first_name);
					$this->Session->write('user_last_name', $last_name);
					$this->Session->write('user_image', $profile_pics);

					$this->alert_message = "Profile successfully updated";
					if($this->Session->read('loginusertype') == 'enduser'){
						$this->alert_redirect_url = "enduser-home";
					}else{
						$this->alert_redirect_url = "auth-home";						
					}
                    $this->alert_theme = 'success';
				}else{

					$this->alert_message = "Something went wrong ty. Try again";
					$this->alert_redirect_url = 'profile';
					$this->alert_theme = 'error';
				}

			}else{

				$this->alert_message = "Something went wrong. Try again";
				$this->alert_redirect_url = 'profile';
				$this->alert_theme = 'error';
			}

		}

		$this->set('alert_message',$this->alert_message);
        $this->set('alert_redirect_url',$this->alert_redirect_url);
		$this->set('alert_theme',$this->alert_theme);

	}
	
	// User trailing logs, added on 21-07-2022 by Aniket
	public function logs()
	{
		$userId = $this->Session->read('username');
		$this->viewBuilder()->setLayout('mc_panel');

		$from_date = date('Y-m-d',strtotime('-5 days',strtotime(date('Y-m-d'))));
		$to_date = date('Y-m-d');
		$log_filtered_txt = "Last 5 days"; 
		
		if ($this->request->is('post')) {
			if (null !== $this->request->getData('log_search')) {
				$from_date = $this->request->getData('from_date');
				$to_date = $this->request->getData('to_date');
				$log_filtered_txt = "Between ".date('d-m-Y',strtotime($from_date))." - ".date('d-m-Y',strtotime($to_date)); 
			}
		}
		
		$this->loadModel('McUserLog');
		$logdata = $this->McUserLog->find('all')->where(['uname'=>$userId])->where(['DATE(login_time) BETWEEN :start AND :end'])->bind(':start',$from_date,'date')->bind(':end',$to_date,'date')->order(['id DESC'])->toArray();

		$this->set('from_date',$from_date);
		$this->set('to_date',$to_date);
		$this->set('log_filtered_txt',$log_filtered_txt);
		$this->set('logdata',$logdata);
	}
	

}
