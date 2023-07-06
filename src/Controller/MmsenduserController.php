<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Network\Email\Email;
use Cake\ORM\Entity;
use Cake\Datasource\ConnectionManager;

class MmsenduserController extends AppController{

	var $name = 'Mmsenduser';
	var $uses = array();

	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);

		$this->userSessionExits();
	}

    public function initialize(): void
    {
        parent::initialize();

		$this->loadComponent('Createcaptcha');
		$this->loadComponent('Authentication');
		$this->loadComponent('Customfunctions');
		$this->loadComponent('Language');
		$this->loadComponent('Counts');
		$this->loadComponent('Returnslist');
		$this->loadComponent('Clscommon');
		$this->loadComponent('Formcreation');
		$this->viewBuilder()->setHelpers(['Form','Html']);
		$this->Session = $this->getRequest()->getSession();
		$this->DirCountry = $this->getTableLocator()->get('DirCountry');
		$this->DirDistrict = $this->getTableLocator()->get('DirDistrict');
		$this->DirMcpMineral = $this->getTableLocator()->get('DirMcpMineral');
		$this->DirMeMineral = $this->getTableLocator()->get('DirMeMineral');
		$this->DirMetal = $this->getTableLocator()->get('DirMetal');
		$this->DirMineralGrade = $this->getTableLocator()->get('DirMineralGrade');
		$this->DirProduct = $this->getTableLocator()->get('DirProduct');
		$this->DirRomGrade = $this->getTableLocator()->get('DirRomGrade');
		$this->DirWorkStoppage = $this->getTableLocator()->get('DirWorkStoppage');
		$this->DirRegion = $this->getTableLocator()->get('DirRegion');
		$this->DirZone = $this->getTableLocator()->get('DirZone');
		$this->DirState = $this->getTableLocator()->get('DirState');
		$this->Employment = $this->getTableLocator()->get('Employment');
		$this->ExplosiveReturn = $this->getTableLocator()->get('ExplosiveReturn');
		$this->DirFinishedProducts = $this->getTableLocator()->get('DirFinishedProducts');
		$this->GradeProd = $this->getTableLocator()->get('GradeProd');
		$this->GradeRom = $this->getTableLocator()->get('GradeRom');
		$this->GradeSale = $this->getTableLocator()->get('GradeSale');
		$this->IncrDecrReasons = $this->getTableLocator()->get('IncrDecrReasons');
		$this->KwClientType = $this->getTableLocator()->get('KwClientType');
		$this->McApplicantDet = $this->getTableLocator()->get('McApplicantDet');
		$this->McMclatlongDet = $this->getTableLocator()->get('McMclatlongDet');
		$this->McMineralconsumptionDet = $this->getTableLocator()->get('McMineralconsumptionDet');
		$this->McMineralconsumptiondistrictDet = $this->getTableLocator()->get('McMineralconsumptiondistrictDet');
		$this->McMineraltradingstorageexportDet = $this->getTableLocator()->get('McMineraltradingstorageexportDet');
		$this->McMineraltradingstorageexportdistrictDet = $this->getTableLocator()->get('McMineraltradingstorageexportdistrictDet');
		$this->McSflatlongDet = $this->getTableLocator()->get('McSflatlongDet');
		$this->McUser = $this->getTableLocator()->get('McUser');
		$this->Mine = $this->getTableLocator()->get('Mine');
		$this->MineralWorked = $this->getTableLocator()->get('MineralWorked');
		$this->MiningPlan = $this->getTableLocator()->get('MiningPlan');
		$this->MmsUser = $this->getTableLocator()->get('MmsUser');
		$this->MmsDashboardCounts = $this->getTableLocator()->get('MmsDashboardCounts');
		$this->OIndustry = $this->getTableLocator()->get('OIndustry');
		$this->OMineralIndustryInfo = $this->getTableLocator()->get('OMineralIndustryInfo');
		$this->OProdDetails = $this->getTableLocator()->get('OProdDetails');
		$this->ORawMatConsume = $this->getTableLocator()->get('ORawMatConsume');
		$this->OSourceSupply = $this->getTableLocator()->get('OSourceSupply');
		$this->OSupplyMode = $this->getTableLocator()->get('OSupplyMode');
		$this->Prod1 = $this->getTableLocator()->get('Prod1');
		$this->Prod5 = $this->getTableLocator()->get('Prod5');
		$this->ProdStone = $this->getTableLocator()->get('ProdStone');
		$this->Pulverisation = $this->getTableLocator()->get('Pulverisation');
		$this->RecovSmelter = $this->getTableLocator()->get('RecovSmelter');
		$this->RentReturns = $this->getTableLocator()->get('RentReturns');
		$this->Rom5 = $this->getTableLocator()->get('Rom5');
		$this->RomMetal5 = $this->getTableLocator()->get('RomMetal5');
		$this->RomStone = $this->getTableLocator()->get('RomStone');
		$this->Sale5 = $this->getTableLocator()->get('Sale5');
		$this->TblEndUserFinalSubmit = $this->getTableLocator()->get('TblEndUserFinalSubmit');
		$this->TblFinalSubmit = $this->getTableLocator()->get('TblFinalSubmit');
		$this->WorkStoppage = $this->getTableLocator()->get('WorkStoppage');

		$this->Customfunctions->formReturnTitle();

    }

	public function returns($return_type,$form_type,$status){

		$this->Session->write('sess_return_type', $return_type);
		$this->Session->write('sess_form_type', $form_type);
		$this->Session->write('sess_status', $status);

		$this->redirect(array('controller'=>'mms','action'=>'returns-records'));
	}

	public function returnsRecords(){

		$this->viewBuilder()->setLayout('mms_panel');

		$mms_user_id = $this->Session->read('mms_user_id');
		$userrole = $this->Session->read('mms_user_role');
		$return_type = strtoupper($this->Session->read('sess_return_type'));
		$form_type = $this->Session->read('sess_form_type');
		$status = $this->Customfunctions->returnStatus($userrole,$this->Session->read('sess_status'));

		$zoneArr = $this->DirZone->find('list',array('keyField'=>'zone_name','valueField'=>'zone_name'))->toArray();
		//$monthsArr = $this->Customfunctions->getMonthArr();
		$yearsArr = $this->Customfunctions->getYearArr();
		$formsArr = $this->Customfunctions->getFormArr($form_type);
		$returnPeriodArr = $this->Customfunctions->getReturnPeriodArr($form_type);
		$this->set('zoneArr',$zoneArr);
		//$this->set('monthsArr',$monthsArr);
		$this->set('yearsArr',$yearsArr);
		$this->set('formsArr',$formsArr);
		$this->set('returnPeriodArr',$returnPeriodArr);

		$mine_code = '';
		$zoneName = '';
		$regionName = '';
		$stateCode = '';
		$district = '';
		$year = date('Y');
		$month = '';
		$form = '';
		$r_period = '';
		$from_date = '';
		$to_date = '';

		if (null !== $this->request->getData('f_search')){

			$rb_period = $this->request->getData('rb_period');

			if($rb_period == 'period'){

				$r_period = $this->Customfunctions->getReturnDateByReturnPeriod($this->request->getData('r_period'));

				$from_date = $r_period[0];
				$to_date = $r_period[1];

			}elseif($rb_period == 'range'){

				$from_date = $this->Customfunctions->getReturnsDateByReturnRange($this->request->getData('from_date'));
				$to_date = $this->Customfunctions->getReturnsDateByReturnRange($this->request->getData('to_date'));
			}

			$zoneName = $this->request->getData('f_zone');
			$regionName = $this->request->getData('f_region');
			$stateCode = $this->request->getData('f_state');
			$district = $this->request->getData('f_district');
			$form = $this->request->getData('f_form');
			$mine_code = $this->request->getData('f_mine_code');
		}

		$regionsList = null;
		$statesList = null;
		$districtsList = null;

		switch($userrole){

			case 5 :
					$zoneid = $this->MmsUser->find('all',array('fields'=>'zone_id','conditions'=>array('id IS'=>$mms_user_id)))->first();
					$zone = $this->DirZone->find('all',array('fields'=>'zone_name','conditions'=>array('id IS'=>$zoneid['zone_id'])))->first();
					$zoneName = $zone['zone_name'];
					$regionsList = $this->DirRegion->find('list',array('keyField'=>'region_name','valueField'=>'region_name','conditions'=>array('zone_name IS'=>$zoneName)))->toArray();
				break;
			case 6 :
					$regionid = $this->MmsUser->find('all',array('fields'=>'region_id','conditions'=>array('id IS'=>$mms_user_id)))->first();
					$region = $this->DirRegion->find('all',array('fields'=>'region_name','conditions'=>array('id IS'=>$regionid['region_id'])))->first();
					$regionName = $region['region_name'];
					$statesList = $this->DirDistrict->getstateByregion($regionName);
				break;
			case 10 :
					$region = $this->MmsUser->find('all',array('fields'=>'region_id','conditions'=>array('id IS'=>$mms_user_id)))->first();
					$stateResult = $this->DirState->find('all',array('fields'=>'state_code','conditions'=>array('id IS'=>$region['region_id'])))->first();
					$stateCode = $stateResult['state_code'];
					$districtsList = $this->DirDistrict->getDistrictCodesByStateCode($stateCode);
				break;
		}

		$this->set('regionsList',$regionsList);
		$this->set('statesList',$statesList);
		$this->set('districtsList',$districtsList);
		$this->set('userrole',$userrole);

	  $returnsData = $this->Returnslist->getFilteredReturnsList($mine_code, $mms_user_id, $zoneName, $regionName, $stateCode, $district, $from_date, $to_date, $form, $status, $userrole,$return_type);
	  $this->set('returnsData',$returnsData);
	  $this->set('dashboard','mmsuser');
	//exit;
	}


	public function monthlyReturns($mine_code, $return_month, $return_year, $return_type, $action = ''){

        if(str_contains($mine_code, 'SPRblock')){ // for end user

            $mine_code = str_replace('SPR','/',$mine_code);
            $form_name = 'another';
			$user_type = 'enduser';

        } else { // for mine user

            $form_name = 'mine';
			$user_type = 'authuser';
        }

        $date = trim($return_month).' 01 '.trim($return_year);
        $return_month = date('m',strtotime($date));
        $return_year = trim($return_year);
        $return_date = $return_year."-".$return_month."-01";

		//fetch applicant id
		$applicantid = $this->TblFinalSubmit->getReturnApplicantId($mine_code, $return_date, $return_type);

		$mineral_name = $this->MineralWorked->getMineralName($mine_code);
		$form_type = $this->DirMcpMineral->getFormNumber($mineral_name);
		$form_one = array('1','2','3','4','8');
		if(in_array($form_type, $form_one)){
			$form_main = '1';
		} else if($form_type == '5') {
			$form_main = '2';
		} else if($form_type == '7') {
			$form_main = '3';
		} else {
			if($user_type != 'enduser'){
				$this->set('message','Invalid form type');
				$this->set('redirect_to','login');
				$this->render('/element/message_box');
				return false;
			}
		}

		$this->Session->write('mc_form_main', $form_main);

		$this->Session->write('applicantid',$applicantid['applicant_id']);
		$this->Session->write('mc_mine_code', $mine_code);
		$this->Session->write('returnDate', $return_date);
		$this->Session->write('returnType', $return_type);
		$this->Session->write('mc_sel_year', $return_year);
		$this->Session->write('mc_sel_month', $return_month);
		$this->Session->write('lang', 'english');
		$this->Session->write('form_status', $action);
		$this->Session->write('report_home_page', 'monthyreturn/allreturns');
		$this->redirect(array('controller'=>'mms','action'=>$form_name));

	}

	//PART I: General Particulars
	public function generalParticular(){

		$this->viewBuilder()->setLayout('mms/form_layout');

        /**
         * @author: Uday Shankar Singh
         * TRADING ACTIVITY -> SECTION IS 1  AND IT'S FIXED... NEVER CHANGE IT
         * TRADING ACTIVITY -> USER TYPE IS 1  AND IT'S FIXED... NEVER CHANGE IT
         */
        $section = 1; // THIS IS FIXED FOR EVERY FORM AND USED FOR APPROVAL REJECTION LOGIC... DON'T EVER CHANGE IT.. OTHER WISE NO DATA WILL COME RIGHT
        $userType = 1; // NEED TO CHECK THE USE
        $partNo = 'partI'; // NOT IN USE  CURRENTLY
        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');

        $mmsPreExeArr = $this->Clscommon->mmsPreExecute($section, $partNo, $userType);

        $formType = $mmsPreExeArr['formType'];
        $returnDate = $mmsPreExeArr['returnDate'];
        $endUserId = $mmsPreExeArr['endUserId'];
        $ibmUniqueRegNo = $mmsPreExeArr['ibmUniqueRegNo'];
        $returnType = $mmsPreExeArr['returnType'];
        $getDate = $mmsPreExeArr['getDate'];
        $returnDatePeriod = $mmsPreExeArr['returnDatePeriod'];
        $master_admin = $mmsPreExeArr['master_admin'];
        $is_pri_pending = $mmsPreExeArr['is_pri_pending'];
        $viewOnly = $mmsPreExeArr['viewOnly'];
        $returnDataArray = $mmsPreExeArr['returnDataArray'];
		$returnDataArr = end($returnDataArray);
		$return_id = $returnDataArr['id'];
        $reasons = $mmsPreExeArr['reasons'];
        $mineralsData = $mmsPreExeArr['mineralData'];
        $dbAppliStatus = $mmsPreExeArr['dbAppliStatus']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN
        $dbVerifiedFlag = $mmsPreExeArr['dbVerifiedFlag']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN

		$userdata = $this->McUser->getUserDatabyId($endUserId);
		$email = $userdata['mcu_email'];
		$phoneno = $userdata['mcu_mob_num'];

		/* create a new session variable to get applicant id on userprofile section, Done by pravin bhakare 22-12-2020 */
        $this->Session->write('report_home_page', $endUserId);

		$regNoTemp = $this->Session->read('ibm_unique_reg_no');
		$checkUnderScore = strpos($regNoTemp, '_');
		if ($checkUnderScore > 0) {
			$regNo = str_replace('_', '/', $regNoTemp);
		} else {
			$regNo = $ibmUniqueRegNo;
		}

        $activityType = $activityType = $this->McUser->getActivityType($endUserId);
        $currActivity = $this->Clscommon->userTypeFullForm($activityType);

        $fullName = $this->McApplicantDet->getFullName($endUserId);
        $registrationCodeNumericPart = explode("/",$endUserId);

        /**
         * @author Uday Shankar Singh<using@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 15th Jan 2015
         *
         * ADDED THIS CODE AS THE PER THE CHANGES MADE FROM BANGALORE WITH
         * AMOD SIR in Nov 2013 before coming to Nagpur for final demo
         *
         * ADDED THE CALL TO NEW FUNCTION fetchAllDetailsByAppId($registrationCodeNumericPart)
         */
        //===============GETTING AND MANAGING THE APPLICANT ADDRESS=============
        $appAdd = $this->McApplicantDet->fetchAllDetailsByAppId($registrationCodeNumericPart['0']);
		$districtData = ($appAdd[0]["mcappd_state"] && $appAdd[0]["mcappd_district"]) ? $this->DirDistrict->getDistrictName($appAdd[0]["mcappd_district"], $appAdd[0]["mcappd_state"]) : array('name'=>'');
		$districtName = $districtData['name'];
		$appAdd[0]["mcappd_district"] = (!empty($districtName)) ? $districtName . ",<br/>" : "";
		$appAdd[0]["mcappd_state"] = $appAdd[0]["mcappd_state"] ? $this->DirState->getStateNameAsArray($appAdd[0]["mcappd_state"]) . ",<br/>" : "";
		$latiLongiDetails['latitude'] = 'NA';
		$latiLongiDetails['longitude'] = '';
        if ($activityType == 'C') {

            $addressDetails = $this->McMineralconsumptionDet->getConsumptionDetailsBasedOnAppId($endUserId);
			$stateCode = $addressDetails[0]['mcmd_state'];
			if(empty ($stateCode)) {
				$addressDetails[0]['mcmd_state'] = "";
			} else {
                $stateNameTemp = $this->DirState->getStateName($stateCode);
                $addressDetails[0]['mcmd_state'] = $stateNameTemp[0]['state_name'];
			}
            $regionAndDistrictName = $this->McMineralconsumptionDet->getRegionAndDistrictName($registrationCodeNumericPart['0'], $stateCode, $endUserId);
            $slNo = $addressDetails[0]['mcmd_slno'];
            $latiLongiDetails = $this->McMclatlongDet->getLatitudeLongitude($registrationCodeNumericPart['0'], $slNo);

        } else {

            $addressDetails = $this->McMineraltradingstorageexportDet->getTSEDetailsBasedOnAppId($endUserId);
            $stateCode = $addressDetails[0]['mcmd_state'];
            $stateNameTemp = $this->DirState->getStateName($stateCode);
            $addressDetails[0]['mcmd_state'] = $stateNameTemp[0]['state_name'];
            $regionAndDistrictName = $this->McMineraltradingstorageexportdistrictDet->getRegionAndDistrictName($registrationCodeNumericPart['0'], $stateCode, $endUserId);
            if ($activityType == 'S') {
                $slNo = $addressDetails[0]['mcmd_slno'];
                $latiLongiDetails = $this->McSflatlongDet->getLatitudeLongitude($registrationCodeNumericPart['0'], $slNo);
            }

        }


		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('general_particular', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId, $return_id);

		// APPROVED / REJECTION SECTION ON HOLD
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

		// set next section
		switch($activityType){
			case "T":
				$nextSection = "tradingActivity";
				break;
			case "E":
				$nextSection = "exportOfOre";
				break;
			case "C":
				$nextSection = "mineralBaseActivity";
				break;
			case "S":
				$nextSection = "storageActivity";
				break;
			default:
				$nextSection = "generalParticular";
		}

		//communication
        //fetch the particular rejected reason
        // $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        // $commented_status = '0';
        $reasons = array();
        // foreach ($return_id as $r){
        //     $reasons[] = $this->TblFinalSubmit->getReason($r['id'], '', '', 1);
        //     $reason_data = $this->TblFinalSubmit->getReason($r['id'], '', '', 1, $this->Session->read('mms_user_role'));
        //     if($reason_data['commented'] == '1'){
        //     	$commented_status = '1';
        //     }
        // }

        // $mmsUserId = $this->Session->read('mms_user_id');
        // $mmsUserRole = $this->Session->read('mms_user_role');
        // $this->set('mmsUserRole',$mmsUserRole);
        // $this->set('commented_status', $commented_status);
        // $this->set('mmsUserId',$mmsUserId);
        // $this->set('sectionId','1');

		$commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));

		$this->set('reasons', $reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('email', $email);
		$this->set('phoneno', $phoneno);

		$this->set('regNo', $regNo);
		$this->set('fullName', $fullName);
		$this->set('appAdd', $appAdd);
		$this->set('addressDetails', $addressDetails);
		$this->set('regionAndDistrictName', $regionAndDistrictName);
		$this->set('activityType', $activityType);
		$this->set('latiLongiDetails', $latiLongiDetails);
		$this->set('currActivity', $currActivity);
		$this->set('nextSection', $nextSection);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formType', $formType);
		$this->set('return_id', $return_id);
		$this->set('part_no', $partNo);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/general_particular');

		if($this->request->is('post')){

			$result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

			if($result == 1){
				$this->Session->write('mon_f_suc','Comment added in <b>Details of the Mine</b> successfully!');
				$this->redirect(array('controller'=>'mms','action'=>'mine'));
			} else {
				$this->Session->write('mon_f_err','Failed to add comment in <b>Details of the Mine</b>! Please, try again later.');
				$this->redirect(array('controller'=>'mms','action'=>'mine'));
			}

		}

	}


	//PART II: Trading Activity
	public function tradingActivity(){

		$this->viewBuilder()->setLayout('mms/form_layout');

        /**
         * @author: Uday Shankar Singh
         * TRADING ACTIVITY -> SECTION IS 1  AND IT'S FIXED... NEVER CHANGE IT
         * TRADING ACTIVITY -> USER TYPE IS 1  AND IT'S FIXED... NEVER CHANGE IT
         */
        $section = 1; // THIS IS FIXED FOR EVERY FORM AND USED FOR APPROVAL REJECTION LOGIC... DON'T EVER CHANGE IT.. OTHER WISE NO DATA WILL COME RIGHT
        $userType = 'T'; // NEED TO CHECK THE USE
        $partNo = 'partII'; // NOT IN USE  CURRENTLY
        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');

        $mmsPreExeArr = $this->Clscommon->mmsPreExecute($section, $partNo, $userType);

        $formType = $mmsPreExeArr['formType'];
        $returnDate = $mmsPreExeArr['returnDate'];
        $endUserId = $mmsPreExeArr['endUserId'];
        $ibmUniqueRegNo = $mmsPreExeArr['ibmUniqueRegNo'];
        $returnType = $mmsPreExeArr['returnType'];
        $getDate = $mmsPreExeArr['getDate'];
        $returnDatePeriod = $mmsPreExeArr['returnDatePeriod'];
        $master_admin = $mmsPreExeArr['master_admin'];
        $is_pri_pending = $mmsPreExeArr['is_pri_pending'];
        $viewOnly = $mmsPreExeArr['viewOnly'];
        $returnDataArray = $mmsPreExeArr['returnDataArray'];
		$returnDataArr = end($returnDataArray);
		$return_id = $returnDataArr['id'];
        $reasons = $mmsPreExeArr['reasons'];
        $mineralsData = $mmsPreExeArr['mineralData'];
        $dbAppliStatus = $mmsPreExeArr['dbAppliStatus']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN
        $dbVerifiedFlag = $mmsPreExeArr['dbVerifiedFlag']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN

        /**
         * @author Uday Shaknar Singh <usingh@ubicsindia.com>
         * HANDLIN NIL CONDITION
         * WE CAN ALSO CHECK MINERAL NAME IN $this->mineral BUT IF THERE IS A MINERAL AND FOR THAT THERE IS NO GRADE THEN WE ARE BACK TO THE SAME PROBLEM.
         * SO I AM HANDLING THIS IN THE BELOW WAY
         */
        $gradesData = $mmsPreExeArr['gradesData'];
        if (count($gradesData) == 0) {
            $gradesData[0][] = "NIL";
            $gradesData = $gradesData[0];
        } else {
            $gradesData = $gradesData;
		}

        $gradeforMineral = $mmsPreExeArr['gradeForMineral'];

        // $approvedSections = $this->getUser()->getAttribute('approved_sections');
        // $rejectedReasons = $this->getUser()->getAttribute('rejected_reasons');
        $approvedSections = array();
        $rejectedReasons = array();
		$countries = $this->DirCountry->getCountryNameLMSeries();

        //====GETTING THE DATA FROM N SERIES BASED ON IF CURRENT MONTH IS FILLED THEN GET CURRENT MONTH DATA ELSE GET LAST MONTH DATA
        $resultSet = $this->Clscommon->NSeriesPrevMonthVsCurrentData($formType, $returnType, $returnDate, $endUserId, $userType);

		if($resultSet['mineralsData']==null){
			$resultSet['mineralsData'][0] = ['local_mineral_code'=>'', 'local_grade_code'=>'', 'opening_stock'=>'', 'closing_stock'=>'', 'remark'=>'', 'mineral_unit'=>''];
		}

		if($resultSet['gradeforMineral']==null){

			$resultSet['gradeforMineral'][0]['supplier'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'suppliercount'=>1];
			$resultSet['gradeforMineral'][0]['importData'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'country_name_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'importcount'=>1];
			$resultSet['gradeforMineral'][0]['despatch'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'despatchcount'=>1];
			$resultSet['gradeforMineral'][0]['consumeData'] = '';
		}

		$min_row_span = array();
		$min_val = "";
		$min_grade_arr = array();
		$min_code_row = array();
		foreach($resultSet['mineralsData'] as $key=>$val){

			//set mineral rowspan structure
			if($val['local_mineral_code'] == ''){
				$min_count = 1;
			} else if($min_val == $val['local_mineral_code']){
				$min_count = 0;
				// $min_row_span[$key-1] = $min_row_span[$key-1] + 1;
				$min_code_key = $min_code_row[$val['local_mineral_code']];
				$min_row_span[$min_code_key] = $min_row_span[$min_code_key] + 1;
			} else {
				$min_count = 1;
				$min_code_row[$val['local_mineral_code']] = $key;
			}
			$min_row_span[$key] = $min_count;
			$min_val = $val['local_mineral_code'];

			//grades data
			$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $returnDate);
			$min_grade_arr[$key] = $min_grade['gradeData'];

		}

		if ($returnType == 'ANNUAL') {
			$resultSetMonthAll = $this->Clscommon->NSeriesPrevMonthVsCurrentDataMonthAll($formType, $returnType, $returnDate, $endUserId, $userType);
			$min_row_span_month_all = array();
			$min_val_month_all = "";
			$min_grade_arr_month_all = array();
			$min_code_row_month_all = array();
			foreach($resultSetMonthAll['mineralsData'] as $key=>$val){

				//set mineral rowspan structure
				if($val['local_mineral_code'] == ''){
					$min_count = 1;
				} else if($min_val_month_all == $val['local_mineral_code']){
					$min_count = 0;
					// $min_row_span_month_all[$key-1] = $min_row_span_month_all[$key-1] + 1;
					$min_code_key = $min_code_row_month_all[$val['local_mineral_code']];
					$min_row_span_month_all[$min_code_key] = $min_row_span_month_all[$min_code_key] + 1;
				} else {
					$min_count = 1;
					$min_code_row_month_all[$val['local_mineral_code']] = $key;
				}
				$min_row_span_month_all[$key] = $min_count;
				$min_val_month_all = $val['local_mineral_code'];

				//grades data
				$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $returnDate);
				$min_grade_arr_month_all[$key] = $min_grade['gradeData'];

			}
		} else {
			$resultSetMonthAll = null;
			$min_row_span_month_all = null;
			$min_grade_arr_month_all = null;
		}

		// get minerals
	    $minerals = $this->DirMeMineral->getMineralList();
	    $mineralsArr = [];
	    foreach($minerals as $key=>$val){
	    	$mineralsArr[$val] = $val;
	    }
		$mineralsArr['NIL'] = 'NIL';

        $mineralWithUnitArr = $this->DirMeMineral->getAllMineralWithUnit();

		/* create a new session variable to get applicant id on userprofile section, Done by pravin bhakare 22-12-2020 */
        $this->Session->write('report_home_page', $endUserId);

		$regNoTemp = $this->Session->read('ibm_unique_reg_no');
		$checkUnderScore = strpos($regNoTemp, '_');
		if ($checkUnderScore > 0) {
			$regNo = str_replace('_', '/', $regNoTemp);
		} else {
			$regNo = $ibmUniqueRegNo;
		}

        $activityType = $activityType = $this->McUser->getActivityType($endUserId);
        $currActivity = $this->Clscommon->userTypeFullForm($activityType);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('trading_activity', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId, $return_id);
        $this->commentMode($return_id, 'partII', '1');

		// APPROVED / REJECTION SECTION ON HOLD
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

		//communication
        //fetch the particular rejected reason
		$return_id_arr = $this->TblEndUserFinalSubmit->getReturnId($endUserId, $returnDate, $returnType, $ibmUniqueRegNo);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id_arr as $r){
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partII', 1);
            $reason_data = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partII', 1, $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');

		$commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));

		$this->set('reasons', $reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('commented_status',$commented_status);

		$form_status = $this->Session->read('form_status');

		$this->set('regNo', $regNo);
	    $this->set('minerals',$mineralsArr);
		$this->set('countries', $countries);
	    $this->set('userType',$userType);
		$this->set('activityType', $activityType);
		$this->set('currActivity', $currActivity);
		$this->set('section_no',$section);
		$this->set('tradingAc',$resultSet);
		$this->set('tradingAcMonthAll',$resultSetMonthAll);
		$this->set('min_row_span',$min_row_span);
		$this->set('min_row_span_month_all',$min_row_span_month_all);
		$this->set('min_grade_arr',$min_grade_arr);
		$this->set('min_grade_arr_month_all',$min_grade_arr_month_all);
		$this->set('returnDataArray',$returnDataArray);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('sectionId', $section);
		$this->set('return_id', $return_id);
		$this->set('part_no', $partNo);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('view', $form_status);
		$this->set('viewOnly', $viewOnly);
		$this->set('is_pri_pending', $is_pri_pending);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/trading_activity');

		if($this->request->is('post')){

			$result = $this->TblEndUserFinalSubmit->saveApproveReject($this->request->getData());

			if ($result == 1) {
				$this->Session->write('mon_f_suc', 'Comment added in <b>Trading Activity</b> successfully!');
				$this->nextSection('tradingActivity', 'mmsenduser');
			} else if($result == 3) {
				$this->Session->write('mon_f_suc', '<b>Trading Activity</b> section succesfully <b><u>approved</u></b>!');
				$this->nextSection('tradingActivity', 'mmsenduser');
			} else if($result == 4) {
				$this->Session->write('process_msg', $returnType.' return successfully approved!');
				$this->redirect(array('controller'=>'mms','action'=>'home'));
			} else {
				$this->Session->write('mon_f_err', 'Something went wrong for <b>Trading Activity</b>! Please, try again later.');
				$this->redirect(array('controller'=>'mmsenduser','action'=>'tradingActivity'));
			}

		}

	}


	//PART II: Export Activity
	public function exportOfOre(){

		$this->viewBuilder()->setLayout('mms/form_layout');

        /**
         * @author: Uday Shankar Singh
         * TRADING ACTIVITY -> SECTION IS 1  AND IT'S FIXED... NEVER CHANGE IT
         * TRADING ACTIVITY -> USER TYPE IS 1  AND IT'S FIXED... NEVER CHANGE IT
         */
        $section = 2; // THIS IS FIXED FOR EVERY FORM AND USED FOR APPROVAL REJECTION LOGIC... DON'T EVER CHANGE IT.. OTHER WISE NO DATA WILL COME RIGHT
        $userType = 'E'; // NEED TO CHECK THE USE
        $partNo = 'partII'; // NOT IN USE  CURRENTLY
        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');

        $mmsPreExeArr = $this->Clscommon->mmsPreExecute($section, $partNo, $userType);

        $formType = $mmsPreExeArr['formType'];
        $returnDate = $mmsPreExeArr['returnDate'];
        $endUserId = $mmsPreExeArr['endUserId'];
        $ibmUniqueRegNo = $mmsPreExeArr['ibmUniqueRegNo'];
        $returnType = $mmsPreExeArr['returnType'];
        $getDate = $mmsPreExeArr['getDate'];
        $returnDatePeriod = $mmsPreExeArr['returnDatePeriod'];
        $master_admin = $mmsPreExeArr['master_admin'];
        $is_pri_pending = $mmsPreExeArr['is_pri_pending'];
        $viewOnly = $mmsPreExeArr['viewOnly'];
        $returnDataArray = $mmsPreExeArr['returnDataArray'];
		$returnDataArr = end($returnDataArray);
		$return_id = $returnDataArr['id'];
        $reasons = $mmsPreExeArr['reasons'];
        $mineralsData = $mmsPreExeArr['mineralData'];
        $dbAppliStatus = $mmsPreExeArr['dbAppliStatus']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN
        $dbVerifiedFlag = $mmsPreExeArr['dbVerifiedFlag']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN

        /**
         * @author Uday Shaknar Singh <usingh@ubicsindia.com>
         * HANDLIN NIL CONDITION
         * WE CAN ALSO CHECK MINERAL NAME IN $this->mineral BUT IF THERE IS A MINERAL AND FOR THAT THERE IS NO GRADE THEN WE ARE BACK TO THE SAME PROBLEM.
         * SO I AM HANDLING THIS IN THE BELOW WAY
         */
        $gradesData = $mmsPreExeArr['gradesData'];
        if (count($gradesData) == 0) {
            $gradesData[0][] = "NIL";
            $gradesData = $gradesData[0];
        } else {
            $gradesData = $gradesData;
		}

        $gradeforMineral = $mmsPreExeArr['gradeForMineral'];

        // $approvedSections = $this->getUser()->getAttribute('approved_sections');
        // $rejectedReasons = $this->getUser()->getAttribute('rejected_reasons');
        $approvedSections = array();
        $rejectedReasons = array();
		$countries = $this->DirCountry->getCountryNameLMSeries();

        //====GETTING THE DATA FROM N SERIES BASED ON IF CURRENT MONTH IS FILLED THEN GET CURRENT MONTH DATA ELSE GET LAST MONTH DATA
        $resultSet = $this->Clscommon->NSeriesPrevMonthVsCurrentData($formType, $returnType, $returnDate, $endUserId, $userType);

		if($resultSet['mineralsData']==null){
			$resultSet['mineralsData'][0] = ['local_mineral_code'=>'', 'local_grade_code'=>'', 'opening_stock'=>'', 'closing_stock'=>'', 'remark'=>'', 'mineral_unit'=>''];
		}

		if($resultSet['gradeforMineral']==null){

			$resultSet['gradeforMineral'][0]['supplier'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'suppliercount'=>1];
			$resultSet['gradeforMineral'][0]['importData'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'country_name_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'importcount'=>1];
			$resultSet['gradeforMineral'][0]['despatch'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'despatchcount'=>1];
			$resultSet['gradeforMineral'][0]['consumeData'] = '';
		}

		$min_row_span = array();
		$min_val = "";
		$min_grade_arr = array();
		$min_code_row = array();
		$vall = 1;
		foreach($resultSet['mineralsData'] as $key=>$val){

			//set mineral rowspan structure
			if($val['local_mineral_code'] == ''){
				$min_count = 1;
			} else if($min_val == $val['local_mineral_code']){
				$min_count = 0;
				// $min_row_span[$key-1] = $min_row_span[$key-1] + 1;
				$min_code_key = $min_code_row[$val['local_mineral_code']];
				$min_row_span[$min_code_key] = $min_row_span[$min_code_key] + 1;
			} else {
				$min_count = 1;
				$min_code_row[$val['local_mineral_code']] = $key;
			}
			$min_row_span[$key] = $min_count;
			$min_val = $val['local_mineral_code'];

			//grades data
			$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $returnDate);
			$min_grade_arr[$key] = $min_grade['gradeData'];

		}

		if ($returnType == 'ANNUAL') {
			$resultSetMonthAll = $this->Clscommon->NSeriesPrevMonthVsCurrentDataMonthAll($formType, $returnType, $returnDate, $endUserId, $userType);
			$min_row_span_month_all = array();
			$min_val_month_all = "";
			$min_grade_arr_month_all = array();
			$min_code_row_month_all = array();
			foreach($resultSetMonthAll['mineralsData'] as $key=>$val){

				//set mineral rowspan structure
				if($val['local_mineral_code'] == ''){
					$min_count = 1;
				} else if($min_val_month_all == $val['local_mineral_code']){
					$min_count = 0;
					// $min_row_span_month_all[$key-1] = $min_row_span_month_all[$key-1] + 1;
					$min_code_key = $min_code_row_month_all[$val['local_mineral_code']];
					$min_row_span_month_all[$min_code_key] = $min_row_span_month_all[$min_code_key] + 1;
				} else {
					$min_count = 1;
					$min_code_row_month_all[$val['local_mineral_code']] = $key;
				}
				$min_row_span_month_all[$key] = $min_count;
				$min_val_month_all = $val['local_mineral_code'];

				//grades data
				$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $returnDate);
				$min_grade_arr_month_all[$key] = $min_grade['gradeData'];

			}
		} else {
			$resultSetMonthAll = null;
			$min_row_span_month_all = null;
			$min_grade_arr_month_all = null;
		}

		// get minerals
	    $minerals = $this->DirMeMineral->getMineralList();
	    $mineralsArr = [];
	    foreach($minerals as $key=>$val){
	    	$mineralsArr[$val] = $val;
	    }
		$mineralsArr['NIL'] = 'NIL';

        $mineralWithUnitArr = $this->DirMeMineral->getAllMineralWithUnit();

		/* create a new session variable to get applicant id on userprofile section, Done by pravin bhakare 22-12-2020 */
        $this->Session->write('report_home_page', $endUserId);

		$regNoTemp = $this->Session->read('ibm_unique_reg_no');
		$checkUnderScore = strpos($regNoTemp, '_');
		if ($checkUnderScore > 0) {
			$regNo = str_replace('_', '/', $regNoTemp);
		} else {
			$regNo = $ibmUniqueRegNo;
		}

        $activityType = $activityType = $this->McUser->getActivityType($endUserId);
        $currActivity = $this->Clscommon->userTypeFullForm($activityType);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('export_of_ore', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId, $return_id);
        $this->commentMode($return_id, 'partII', '2');

		// APPROVED / REJECTION SECTION ON HOLD
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

		//communication
        //fetch the particular rejected reason
		$return_id_arr = $this->TblEndUserFinalSubmit->getReturnId($endUserId, $returnDate, $returnType, $ibmUniqueRegNo);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id_arr as $r){
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partII', 2);
            $reason_data = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partII', 2, $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');

		$commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));

		$this->set('reasons', $reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('commented_status',$commented_status);

		$form_status = $this->Session->read('form_status');

		$this->set('regNo', $regNo);
	    $this->set('minerals',$mineralsArr);
		$this->set('countries', $countries);
	    $this->set('userType',$userType);
		$this->set('activityType', $activityType);
		$this->set('currActivity', $currActivity);
		$this->set('section_no',$section);
		$this->set('tradingAc',$resultSet);
		$this->set('tradingAcMonthAll',$resultSetMonthAll);
		$this->set('min_row_span',$min_row_span);
		$this->set('min_row_span_month_all',$min_row_span_month_all);
		$this->set('min_grade_arr',$min_grade_arr);
		$this->set('min_grade_arr_month_all',$min_grade_arr_month_all);
		$this->set('returnDataArray',$returnDataArray);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('sectionId', $section);
		$this->set('return_id', $return_id);
		$this->set('part_no', $partNo);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('view', $form_status);
		$this->set('viewOnly', $viewOnly);
		$this->set('is_pri_pending', $is_pri_pending);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/trading_activity');

		if($this->request->is('post')){

			$result = $this->TblEndUserFinalSubmit->saveApproveReject($this->request->getData());

			if ($result == 1) {
				$this->Session->write('mon_f_suc', 'Comment added in <b>Export Activity</b> successfully!');
				$this->nextSection('exportOfOre', 'mmsenduser');
			} else if($result == 3) {
				$this->Session->write('mon_f_suc', '<b>Export Activity</b> section succesfully <b><u>approved</u></b>!');
				$this->nextSection('exportOfOre', 'mmsenduser');
			} else if($result == 4) {
				$this->Session->write('process_msg', $returnType.' return successfully approved!');
				$this->redirect(array('controller'=>'mms','action'=>'home'));
			} else {
				$this->Session->write('mon_f_err', 'Something went wrong for <b>Export Activity</b>! Please, try again later.');
				$this->redirect(array('controller'=>'mmsenduser','action'=>'exportOfOre'));
			}

		}

	}


	//PART II: Mineral Based Activity
	public function mineralBaseActivity(){

		$this->viewBuilder()->setLayout('mms/form_layout');

        /**
         * @author: Uday Shankar Singh
         * TRADING ACTIVITY -> SECTION IS 1  AND IT'S FIXED... NEVER CHANGE IT
         * TRADING ACTIVITY -> USER TYPE IS 1  AND IT'S FIXED... NEVER CHANGE IT
         */
        $section = 3; // THIS IS FIXED FOR EVERY FORM AND USED FOR APPROVAL REJECTION LOGIC... DON'T EVER CHANGE IT.. OTHER WISE NO DATA WILL COME RIGHT
        $userType = 'C'; // NEED TO CHECK THE USE
        $partNo = 'partII'; // NOT IN USE  CURRENTLY
        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');

        $mmsPreExeArr = $this->Clscommon->mmsPreExecute($section, $partNo, $userType);

        $formType = $mmsPreExeArr['formType'];
        $returnDate = $mmsPreExeArr['returnDate'];
        $endUserId = $mmsPreExeArr['endUserId'];
        $ibmUniqueRegNo = $mmsPreExeArr['ibmUniqueRegNo'];
        $returnType = $mmsPreExeArr['returnType'];
        $getDate = $mmsPreExeArr['getDate'];
        $returnDatePeriod = $mmsPreExeArr['returnDatePeriod'];
        $master_admin = $mmsPreExeArr['master_admin'];
        $is_pri_pending = $mmsPreExeArr['is_pri_pending'];
        $viewOnly = $mmsPreExeArr['viewOnly'];
        $returnDataArray = $mmsPreExeArr['returnDataArray'];
		$returnDataArr = end($returnDataArray);
		$return_id = $returnDataArr['id'];
        $reasons = $mmsPreExeArr['reasons'];
        $mineralsData = $mmsPreExeArr['mineralData'];
        $dbAppliStatus = $mmsPreExeArr['dbAppliStatus']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN
        $dbVerifiedFlag = $mmsPreExeArr['dbVerifiedFlag']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN

        /**
         * @author Uday Shaknar Singh <usingh@ubicsindia.com>
         * HANDLIN NIL CONDITION
         * WE CAN ALSO CHECK MINERAL NAME IN $this->mineral BUT IF THERE IS A MINERAL AND FOR THAT THERE IS NO GRADE THEN WE ARE BACK TO THE SAME PROBLEM.
         * SO I AM HANDLING THIS IN THE BELOW WAY
         */
        $gradesData = $mmsPreExeArr['gradesData'];
        if (count($gradesData) == 0) {
            $gradesData[0][] = "NIL";
            $gradesData = $gradesData[0];
        } else {
            $gradesData = $gradesData;
		}

        $gradeforMineral = $mmsPreExeArr['gradeForMineral'];

        // $approvedSections = $this->getUser()->getAttribute('approved_sections');
        // $rejectedReasons = $this->getUser()->getAttribute('rejected_reasons');
        $approvedSections = array();
        $rejectedReasons = array();

        // if ($approvedSections[$mineral][2] == "Rejected") {
        if (isset($approvedSections['mineral'][2]) && $approvedSections['mineral'][2] == "Rejected") {
            $is_rejected_section = 1;
            $rejected_reason = $rejectedReasons[$mineral][2];
        // } else if ($approvedSections[$mineral][2] == "Approved") {
        } else if (isset($approvedSections['mineral'][2]) && $approvedSections['mineral'][2] == "Approved") {
            $is_rejected_section = 2;
        }

		$countries = $this->DirCountry->getCountryNameLMSeries();

        //====GETTING THE DATA FROM N SERIES BASED ON IF CURRENT MONTH IS FILLED THEN GET CURRENT MONTH DATA ELSE GET LAST MONTH DATA
        $resultSet = $this->Clscommon->NSeriesPrevMonthVsCurrentData($formType, $returnType, $returnDate, $endUserId, $userType);

		if($resultSet['mineralsData']==null){
			$resultSet['mineralsData'][0] = ['local_mineral_code'=>'', 'local_grade_code'=>'', 'opening_stock'=>'', 'closing_stock'=>'', 'remark'=>'', 'mineral_unit'=>''];
		}

		if($resultSet['gradeforMineral']==null){

			$resultSet['gradeforMineral'][0]['supplier'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'suppliercount'=>1];
			$resultSet['gradeforMineral'][0]['importData'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'country_name_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'importcount'=>1];
			$resultSet['gradeforMineral'][0]['despatch'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'despatchcount'=>1];
			$resultSet['gradeforMineral'][0]['consumeData'] = ['quantity'=>'', 'value'=>''];
		}

		$min_row_span = array();
		$min_val = "";
		$min_grade_arr = array();
		$min_code_row = array();
		$vall = 1;
		foreach($resultSet['mineralsData'] as $key=>$val){

			//set mineral rowspan structure
			if($val['local_mineral_code'] == ''){
				$min_count = 1;
			} else if($min_val == $val['local_mineral_code']){
				$min_count = 0;
				// $min_row_span[$key-1] = $min_row_span[$key-1] + 1;
				$min_code_key = $min_code_row[$val['local_mineral_code']];
				$min_row_span[$min_code_key] = $min_row_span[$min_code_key] + 1;
			} else {
				$min_count = 1;
				$min_code_row[$val['local_mineral_code']] = $key;
			}
			$min_row_span[$key] = $min_count;
			$min_val = $val['local_mineral_code'];

			//grades data
			$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $returnDate);
			$min_grade_arr[$key] = $min_grade['gradeData'];

		}

		if ($returnType == 'ANNUAL') {
			$resultSetMonthAll = $this->Clscommon->NSeriesPrevMonthVsCurrentDataMonthAll($formType, $returnType, $returnDate, $endUserId, $userType);
			$min_row_span_month_all = array();
			$min_val_month_all = "";
			$min_grade_arr_month_all = array();
			$min_code_row_month_all = array();
			$vall = 1;
			foreach($resultSetMonthAll['mineralsData'] as $key=>$val){

				//set mineral rowspan structure
				if($val['local_mineral_code'] == ''){
					$min_count = 1;
				} else if($min_val_month_all == $val['local_mineral_code']){
					$min_count = 0;
					// $min_row_span_month_all[$key-1] = $min_row_span_month_all[$key-1] + 1;
					$min_code_key = $min_code_row_month_all[$val['local_mineral_code']];
					$min_row_span_month_all[$min_code_key] = $min_row_span_month_all[$min_code_key] + 1;
				} else {
					$min_count = 1;
					$min_code_row_month_all[$val['local_mineral_code']] = $key;
				}
				$min_row_span_month_all[$key] = $min_count;
				$min_val_month_all = $val['local_mineral_code'];

				//grades data
				$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $returnDate);
				$min_grade_arr_month_all[$key] = $min_grade['gradeData'];

			}
		} else {
			$resultSetMonthAll = null;
			$min_row_span_month_all = null;
			$min_grade_arr_month_all = null;
		}

		// get minerals
	    $minerals = $this->DirMeMineral->getMineralList();
	    $mineralsArr = [];
	    foreach($minerals as $key=>$val){
	    	$mineralsArr[$val] = $val;
	    }
		$mineralsArr['NIL'] = 'NIL';

        $mineralWithUnitArr = $this->DirMeMineral->getAllMineralWithUnit();

		/* create a new session variable to get applicant id on userprofile section, Done by pravin bhakare 22-12-2020 */
        $this->Session->write('report_home_page', $endUserId);

		$regNoTemp = $this->Session->read('ibm_unique_reg_no');
		$checkUnderScore = strpos($regNoTemp, '_');
		if ($checkUnderScore > 0) {
			$regNo = str_replace('_', '/', $regNoTemp);
		} else {
			$regNo = $ibmUniqueRegNo;
		}

        $activityType = $activityType = $this->McUser->getActivityType($endUserId);
        $currActivity = $this->Clscommon->userTypeFullForm($activityType);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('mineral_base_activity', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId, $return_id);
        $this->commentMode($return_id, 'partII', '3');

		// APPROVED / REJECTION SECTION ON HOLD
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

		//communication
        //fetch the particular rejected reason
		$return_id_arr = $this->TblEndUserFinalSubmit->getReturnId($endUserId, $returnDate, $returnType, $ibmUniqueRegNo);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id_arr as $r){
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partII', 3);
            $reason_data = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partII', 3, $this->Session->read('mms_user_role'));

            if((isset($reason_data['commented'])) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');

		$commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));

		$this->set('reasons', $reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('commented_status',$commented_status);

		$form_status = $this->Session->read('form_status');

		$this->set('regNo', $regNo);
	    $this->set('minerals',$mineralsArr);
		$this->set('countries', $countries);
	    $this->set('userType',$userType);
		$this->set('activityType', $activityType);
		$this->set('currActivity', $currActivity);
		$this->set('section_no',$section);
		$this->set('tradingAc',$resultSet);
		$this->set('tradingAcMonthAll',$resultSetMonthAll);
		$this->set('min_row_span',$min_row_span);
		$this->set('min_row_span_month_all',$min_row_span_month_all);
		$this->set('min_grade_arr',$min_grade_arr);
		$this->set('min_grade_arr_month_all',$min_grade_arr_month_all);
		$this->set('returnDataArray',$returnDataArray);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('sectionId', $section);
		$this->set('return_id', $return_id);
		$this->set('part_no', $partNo);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('view', $form_status);
		$this->set('viewOnly', $viewOnly);
		$this->set('is_pri_pending', $is_pri_pending);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('diff_color_code', 1); // to display color code for difference between cumulative monthly data & annual return

		$this->render('/element/enduser/forms/trading_activity');

		if($this->request->is('post')){

			$result = $this->TblEndUserFinalSubmit->saveApproveReject($this->request->getData());

			if ($result == 1) {
				$this->Session->write('mon_f_suc', 'Comment added in <b>Mineral Based Activity</b> successfully!');
				$this->nextSection('mineralBaseActivity', 'mmsenduser');
			} else if($result == 3) {
				$this->Session->write('mon_f_suc', '<b>Mineral Based Activity</b> section succesfully <b><u>approved</u></b>!');
				$this->nextSection('mineralBaseActivity', 'mmsenduser');
			} else if($result == 4) {
				$this->Session->write('process_msg', $returnType.' return successfully approved!');
				$this->redirect(array('controller'=>'mms','action'=>'home'));
			} else {
				$this->Session->write('mon_f_err', 'Something went wrong for <b>Mineral Based Activity</b>! Please, try again later.');
				$this->redirect(array('controller'=>'mmsenduser','action'=>'mineralBaseActivity'));
			}

		}

	}


	//PART II: Storage Activity
	public function storageActivity(){

		$this->viewBuilder()->setLayout('mms/form_layout');

        /**
         * @author: Uday Shankar Singh
         * TRADING ACTIVITY -> SECTION IS 1  AND IT'S FIXED... NEVER CHANGE IT
         * TRADING ACTIVITY -> USER TYPE IS 1  AND IT'S FIXED... NEVER CHANGE IT
         */
        $section = 4; // THIS IS FIXED FOR EVERY FORM AND USED FOR APPROVAL REJECTION LOGIC... DON'T EVER CHANGE IT.. OTHER WISE NO DATA WILL COME RIGHT
        $userType = 'S'; // NEED TO CHECK THE USE
        $partNo = 'partII'; // NOT IN USE  CURRENTLY
        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');

        $mmsPreExeArr = $this->Clscommon->mmsPreExecute($section, $partNo, $userType);

        $formType = $mmsPreExeArr['formType'];
        $returnDate = $mmsPreExeArr['returnDate'];
        $endUserId = $mmsPreExeArr['endUserId'];
        $ibmUniqueRegNo = $mmsPreExeArr['ibmUniqueRegNo'];
        $returnType = $mmsPreExeArr['returnType'];
        $getDate = $mmsPreExeArr['getDate'];
        $returnDatePeriod = $mmsPreExeArr['returnDatePeriod'];
        $master_admin = $mmsPreExeArr['master_admin'];
        $is_pri_pending = $mmsPreExeArr['is_pri_pending'];
        $viewOnly = $mmsPreExeArr['viewOnly'];
        $returnDataArray = $mmsPreExeArr['returnDataArray'];
		$returnDataArr = end($returnDataArray);
		$return_id = $returnDataArr['id'];
        $reasons = $mmsPreExeArr['reasons'];
        $mineralsData = $mmsPreExeArr['mineralData'];
        $dbAppliStatus = $mmsPreExeArr['dbAppliStatus']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN
        $dbVerifiedFlag = $mmsPreExeArr['dbVerifiedFlag']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN

        /**
         * @author Uday Shaknar Singh <usingh@ubicsindia.com>
         * HANDLIN NIL CONDITION
         * WE CAN ALSO CHECK MINERAL NAME IN $this->mineral BUT IF THERE IS A MINERAL AND FOR THAT THERE IS NO GRADE THEN WE ARE BACK TO THE SAME PROBLEM.
         * SO I AM HANDLING THIS IN THE BELOW WAY
         */
        $gradesData = $mmsPreExeArr['gradesData'];
        if (count($gradesData) == 0) {
            $gradesData[0][] = "NIL";
            $gradesData = $gradesData[0];
        } else {
            $gradesData = $gradesData;
		}

        $gradeforMineral = $mmsPreExeArr['gradeForMineral'];

        // $approvedSections = $this->getUser()->getAttribute('approved_sections');
        // $rejectedReasons = $this->getUser()->getAttribute('rejected_reasons');
        $approvedSections = array();
        $rejectedReasons = array();

		$countries = $this->DirCountry->getCountryNameLMSeries();

        //====GETTING THE DATA FROM N SERIES BASED ON IF CURRENT MONTH IS FILLED THEN GET CURRENT MONTH DATA ELSE GET LAST MONTH DATA
        $resultSet = $this->Clscommon->NSeriesPrevMonthVsCurrentData($formType, $returnType, $returnDate, $endUserId, $userType);

		if($resultSet['mineralsData']==null){
			$resultSet['mineralsData'][0] = ['local_mineral_code'=>'', 'local_grade_code'=>'', 'opening_stock'=>'', 'closing_stock'=>'', 'remark'=>'', 'mineral_unit'=>''];
		}

		if($resultSet['gradeforMineral']==null){

			$resultSet['gradeforMineral'][0]['supplier'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'suppliercount'=>1];
			$resultSet['gradeforMineral'][0]['importData'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'country_name_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'importcount'=>1];
			$resultSet['gradeforMineral'][0]['despatch'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'despatchcount'=>1];
			$resultSet['gradeforMineral'][0]['consumeData'] = '';
		}

		$min_row_span = array();
		$min_val = "";
		$min_grade_arr = array();
		$min_code_row = array();
		$vall = 1;
		foreach($resultSet['mineralsData'] as $key=>$val){

			//set mineral rowspan structure
			if($val['local_mineral_code'] == ''){
				$min_count = 1;
			} else if($min_val == $val['local_mineral_code']){
				$min_count = 0;
				// $min_row_span[$key-1] = $min_row_span[$key-1] + 1;
				$min_code_key = $min_code_row[$val['local_mineral_code']];
				$min_row_span[$min_code_key] = $min_row_span[$min_code_key] + 1;
			} else {
				$min_count = 1;
				$min_code_row[$val['local_mineral_code']] = $key;
			}
			$min_row_span[$key] = $min_count;
			$min_val = $val['local_mineral_code'];

			//grades data
			$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $returnDate);
			$min_grade_arr[$key] = $min_grade['gradeData'];

		}

		if ($returnType == 'ANNUAL') {
			$resultSetMonthAll = $this->Clscommon->NSeriesPrevMonthVsCurrentDataMonthAll($formType, $returnType, $returnDate, $endUserId, $userType);
			$min_row_span_month_all = array();
			$min_val_month_all = "";
			$min_grade_arr_month_all = array();
			$min_code_row_month_all = array();
			foreach($resultSetMonthAll['mineralsData'] as $key=>$val){

				//set mineral rowspan structure
				if($val['local_mineral_code'] == ''){
					$min_count = 1;
				} else if($min_val_month_all == $val['local_mineral_code']){
					$min_count = 0;
					// $min_row_span_month_all[$key-1] = $min_row_span_month_all[$key-1] + 1;
					$min_code_key = $min_code_row_month_all[$val['local_mineral_code']];
					$min_row_span_month_all[$min_code_key] = $min_row_span_month_all[$min_code_key] + 1;
				} else {
					$min_count = 1;
					$min_code_row_month_all[$val['local_mineral_code']] = $key;
				}
				$min_row_span_month_all[$key] = $min_count;
				$min_val_month_all = $val['local_mineral_code'];

				//grades data
				$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $returnDate);
				$min_grade_arr_month_all[$key] = $min_grade['gradeData'];

			}
		} else {
			$resultSetMonthAll = null;
			$min_row_span_month_all = null;
			$min_grade_arr_month_all = null;
		}

		// get minerals
	    $minerals = $this->DirMeMineral->getMineralList();
	    $mineralsArr = [];
	    foreach($minerals as $key=>$val){
	    	$mineralsArr[$val] = $val;
	    }
		$mineralsArr['NIL'] = 'NIL';

        $mineralWithUnitArr = $this->DirMeMineral->getAllMineralWithUnit();

		/* create a new session variable to get applicant id on userprofile section, Done by pravin bhakare 22-12-2020 */
        $this->Session->write('report_home_page', $endUserId);

		$regNoTemp = $this->Session->read('ibm_unique_reg_no');
		$checkUnderScore = strpos($regNoTemp, '_');
		if ($checkUnderScore > 0) {
			$regNo = str_replace('_', '/', $regNoTemp);
		} else {
			$regNo = $ibmUniqueRegNo;
		}

        $activityType = $activityType = $this->McUser->getActivityType($endUserId);
        $currActivity = $this->Clscommon->userTypeFullForm($activityType);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('storage_activity', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId, $return_id);
        $this->commentMode($return_id, 'partII', '4');

		// APPROVED / REJECTION SECTION ON HOLD
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

		//communication
        //fetch the particular rejected reason
		$return_id_arr = $this->TblEndUserFinalSubmit->getReturnId($endUserId, $returnDate, $returnType, $ibmUniqueRegNo);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id_arr as $r){
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partII', 4);
            $reason_data = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partII', 4, $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');

		$commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));

		$this->set('reasons', $reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('commented_status',$commented_status);

		$form_status = $this->Session->read('form_status');

		$this->set('regNo', $regNo);
	    $this->set('minerals',$mineralsArr);
		$this->set('countries', $countries);
	    $this->set('userType',$userType);
		$this->set('activityType', $activityType);
		$this->set('currActivity', $currActivity);
		$this->set('section_no',$section);
		$this->set('tradingAc',$resultSet);
		$this->set('tradingAcMonthAll',$resultSetMonthAll);
		$this->set('min_row_span',$min_row_span);
		$this->set('min_row_span_month_all',$min_row_span_month_all);
		$this->set('min_grade_arr',$min_grade_arr);
		$this->set('min_grade_arr_month_all',$min_grade_arr_month_all);
		$this->set('returnDataArray',$returnDataArray);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('sectionId', $section);
		$this->set('return_id', $return_id);
		$this->set('part_no', $partNo);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('view', $form_status);
		$this->set('viewOnly', $viewOnly);
		$this->set('is_pri_pending', $is_pri_pending);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/trading_activity');

		if($this->request->is('post')){

			$result = $this->TblEndUserFinalSubmit->saveApproveReject($this->request->getData());

			if ($result == 1) {
				$this->Session->write('mon_f_suc', 'Comment added in <b>Storage Activity</b> successfully!');
				$this->nextSection('storageActivity', 'mmsenduser');
			} else if($result == 3) {
				$this->Session->write('mon_f_suc', '<b>Storage Activity</b> section succesfully <b><u>approved</u></b>!');
				$this->nextSection('storageActivity', 'mmsenduser');
			} else if($result == 4) {
				$this->Session->write('process_msg', $returnType.' return successfully approved!');
				$this->redirect(array('controller'=>'mms','action'=>'home'));
			} else {
				$this->Session->write('mon_f_err', 'Something went wrong for <b>Storage Activity</b>! Please, try again later.');
				$this->redirect(array('controller'=>'mmsenduser','action'=>'storageActivity'));
			}

		}

	}


	//PART II: End-Use Mineral Based Industries - I
	public function mineralBasedIndustries(){

		$this->viewBuilder()->setLayout('mms/form_layout');

        //==============================FIXED VARIABLES=========================
        $section = 1;
        $userType = 'C';
        $partNo = 'partIII';

        $mmsPreExeArr = $this->Clscommon->mmsPreExecute($section, $partNo, $userType);

        $formType = $mmsPreExeArr['formType'];
        $returnDate = $mmsPreExeArr['returnDate'];
        $endUserId = $mmsPreExeArr['endUserId'];
        $ibmUniqueRegNo = $mmsPreExeArr['ibmUniqueRegNo'];
        $returnType = $mmsPreExeArr['returnType'];
        $getDate = $mmsPreExeArr['getDate'];
        $returnDatePeriod = $mmsPreExeArr['returnDatePeriod'];
        $master_admin = $mmsPreExeArr['master_admin'];
        $is_pri_pending = $mmsPreExeArr['is_pri_pending'];
        $viewOnly = $mmsPreExeArr['viewOnly'];
        $returnDataArray = $mmsPreExeArr['returnDataArray'];
		$returnDataArr = end($returnDataArray);
		$return_id = $returnDataArr['id'];
        $reasons = $mmsPreExeArr['reasons'];
        $mineralsData = $mmsPreExeArr['mineralData'];
        $dbAppliStatus = $mmsPreExeArr['dbAppliStatus']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN
        $dbVerifiedFlag = $mmsPreExeArr['dbVerifiedFlag']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN

        //=============================FOR FORM DATA============================
        $return_home_page = $this->Session->read('report_home_page');

		// section data
        $mineralIndustriesInfo = $this->OMineralIndustryInfo->getAllRecord('O', 'ANNUAL', $returnDate, $endUserId, $userType);
        $stateCode = $mineralIndustriesInfo['state'];
        $districtCode = $mineralIndustriesInfo['district'];
        $stateName = $this->DirState->getStateNameAsArray($mineralIndustriesInfo['state']);
        $districtName = $this->DirDistrict->getDistrictNameArrayResult($districtCode, $stateCode);

		// Added by Naveen Jha on 03/07/18 to get the registration number irrespective of the length of number. "/" used for splitting
		$regid = explode("/", $endUserId);
		$registrationCodeNumericPart = $regid[0];
		$activityType = $this->Session->read('activityType');
        if ($activityType == 'C') {
            $addressDetails = $this->McMineralconsumptionDet->getConsumptionDetailsBasedOnAppId($endUserId);
            $stateCode = $addressDetails[0]['mcmd_state'];
            $regionAndDistrictName = $this->McMineralconsumptiondistrictDet->getRegionAndDistrictName($registrationCodeNumericPart, $stateCode, $endUserId);
			$stateFullName = $this->DirState->getState($addressDetails[0]['mcmd_state']);
			$addressDetails[0]['mcmd_state'] = ($stateFullName == '--') ? $addressDetails[0]['mcmd_state'] : $stateFullName;
            $slNo = $addressDetails[0]['mcmd_slno'];
            $latiLongiDetails = $this->McMclatlongDet->getLatitudeLongitude($registrationCodeNumericPart, $slNo);
        } else {
            $addressDetails = $this->McMineraltradingstorageexportDet->getTSEDetailsBasedOnAppId($endUserId);
            $stateCode = $addressDetails[0]['mcmd_state'];
            $regionAndDistrictName = $this->McMineraltradingstorageexportdistrictDet->getRegionAndDistrictName($registrationCodeNumericPart, $stateCode, $endUserId);
            $slNo = $addressDetails[0]['mcmd_slno'];
            $latiLongiDetails = $this->McSflatlongDet->getLatitudeLongitude($registrationCodeNumericPart, $slNo);
        }

        $fetchData = $this->OMineralIndustryInfo->getAllRecord($formType, $returnType, $returnDate, $endUserId, $userType);

        $industries = $this->OIndustry->getIndustries();
		$industries_op = array();
		foreach ($industries as $ind) {
			$industries_op[$ind] = $ind;
		}
		$industries_op['other'] = 'Other';

		$this->set('fetchData', $fetchData);
		$this->set('industries_op', $industries_op);
		$this->set('addressDetails', $addressDetails);
		$this->set('regionAndDistrictName', $regionAndDistrictName);
		$this->set('latiLongiDetails', $latiLongiDetails);


        // $approvedSections = $this->getUser()->getAttribute('approved_sections');
        // $rejectedReasons = $this->getUser()->getAttribute('rejected_reasons');
        $approvedSections = array();
        $rejectedReasons = array();

        // if ($approvedSections[$mineral][2] == "Rejected") {
        if (isset($approvedSections['mineral'][2]) && $approvedSections['mineral'][2] == "Rejected") {
            $is_rejected_section = 1;
            $rejected_reason = $rejectedReasons[$mineral][2];
        // } else if ($approvedSections[$mineral][2] == "Approved") {
        } else if (isset($approvedSections['mineral'][2]) && $approvedSections['mineral'][2] == "Approved") {
            $is_rejected_section = 2;
        }


		/* create a new session variable to get applicant id on userprofile section, Done by pravin bhakare 22-12-2020 */
        $this->Session->write('report_home_page', $endUserId);

		$regNoTemp = $this->Session->read('ibm_unique_reg_no');
		$checkUnderScore = strpos($regNoTemp, '_');
		if ($checkUnderScore > 0) {
			$regNo = str_replace('_', '/', $regNoTemp);
		} else {
			$regNo = $ibmUniqueRegNo;
		}

        $activityType = $activityType = $this->McUser->getActivityType($endUserId);
        $currActivity = $this->Clscommon->userTypeFullForm($activityType);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('mineral_based_industries', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId, $return_id);
        $this->commentMode($return_id, 'partIII', '1');

		// APPROVED / REJECTION SECTION ON HOLD
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

		//communication
        //fetch the particular rejected reason
		$return_id_arr = $this->TblEndUserFinalSubmit->getReturnId($endUserId, $returnDate, $returnType, $ibmUniqueRegNo);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id_arr as $r){
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partIII', 1);
            $reason_data = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partIII', 1, $this->Session->read('mms_user_role'));

            if((isset($reason_data['commented'])) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');

		$commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));

		$this->set('reasons', $reasons);
		$this->set('commentLabel', $commentLabel);
		$this->set('commented_status', $commented_status);

		$form_status = $this->Session->read('form_status');

		$this->set('regNo', $regNo);
	    $this->set('userType',$userType);
		$this->set('activityType', $activityType);
		$this->set('currActivity', $currActivity);
		$this->set('section_no',$section);
		$this->set('returnDataArray',$returnDataArray);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('sectionId', $section);
		$this->set('return_id', $return_id);
		$this->set('part_no', $partNo);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('view', $form_status);
		$this->set('viewOnly', $viewOnly);
		$this->set('is_pri_pending', $is_pri_pending);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/mineral_based_industries');

		if($this->request->is('post')){

			$result = $this->TblEndUserFinalSubmit->saveApproveReject($this->request->getData());

			if ($result == 1) {
				$this->Session->write('mon_f_suc', 'Comment added in <b>End-use Mineral Based Industries - I</b> successfully!');
				$this->nextSection('mineralBasedIndustries', 'mmsenduser');
			} else if($result == 3) {
				$this->Session->write('mon_f_suc', '<b>End-use Mineral Based Industries - I</b> section succesfully <b><u>approved</u></b>!');
				$this->nextSection('mineralBasedIndustries', 'mmsenduser');
			} else if($result == 4) {
				$this->Session->write('process_msg', $returnType.' return successfully approved!');
				$this->redirect(array('controller'=>'mms','action'=>'home'));
			} else {
				$this->Session->write('mon_f_err', 'Something went wrong for <b>End-use Mineral Based Industries - I</b>! Please, try again later.');
				$this->redirect(array('controller'=>'mmsenduser','action'=>'mineralBasedIndustries'));
			}

		}

	}

	//PART II: End-Use Mineral Based Industries - II
	public function productManufactureDetails(){

		$this->viewBuilder()->setLayout('mms/form_layout');

        //==============================FIXED VARIABLES=========================
        $section = 2;
        $userType = 'C';
        $partNo = 'partIII';

        $mmsPreExeArr = $this->Clscommon->mmsPreExecute($section, $partNo, $userType);

        $formType = $mmsPreExeArr['formType'];
        $returnDate = $mmsPreExeArr['returnDate'];
        $endUserId = $mmsPreExeArr['endUserId'];
        $ibmUniqueRegNo = $mmsPreExeArr['ibmUniqueRegNo'];
        $returnType = $mmsPreExeArr['returnType'];
        $getDate = $mmsPreExeArr['getDate'];
        $returnDatePeriod = $mmsPreExeArr['returnDatePeriod'];
        $master_admin = $mmsPreExeArr['master_admin'];
        $is_pri_pending = $mmsPreExeArr['is_pri_pending'];
        $viewOnly = $mmsPreExeArr['viewOnly'];
        $returnDataArray = $mmsPreExeArr['returnDataArray'];
		$returnDataArr = end($returnDataArray);
		$return_id = $returnDataArr['id'];
        $reasons = $mmsPreExeArr['reasons'];
        $mineralsData = $mmsPreExeArr['mineralData'];
        $dbAppliStatus = $mmsPreExeArr['dbAppliStatus']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN
        $dbVerifiedFlag = $mmsPreExeArr['dbVerifiedFlag']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN

        //=============================FOR FORM DATA============================
        $return_home_page = $this->Session->read('report_home_page');

        // $approvedSections = $this->getUser()->getAttribute('approved_sections');
        // $rejectedReasons = $this->getUser()->getAttribute('rejected_reasons');
        $approvedSections = array();
        $rejectedReasons = array();

        // if ($approvedSections[$mineral][2] == "Rejected") {
        if (isset($approvedSections['mineral'][2]) && $approvedSections['mineral'][2] == "Rejected") {
            $is_rejected_section = 1;
            $rejected_reason = $rejectedReasons[$mineral][2];
        // } else if ($approvedSections[$mineral][2] == "Approved") {
        } else if (isset($approvedSections['mineral'][2]) && $approvedSections['mineral'][2] == "Approved") {
            $is_rejected_section = 2;
        }


		/* create a new session variable to get applicant id on userprofile section, Done by pravin bhakare 22-12-2020 */
        $this->Session->write('report_home_page', $endUserId);

		$regNoTemp = $this->Session->read('ibm_unique_reg_no');
		$checkUnderScore = strpos($regNoTemp, '_');
		if ($checkUnderScore > 0) {
			$regNo = str_replace('_', '/', $regNoTemp);
		} else {
			$regNo = $ibmUniqueRegNo;
		}

        $activityType = $activityType = $this->McUser->getActivityType($endUserId);
        $currActivity = $this->Clscommon->userTypeFullForm($activityType);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('product_manufacture_details', $lang);
		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId, $return_id);
        $this->commentMode($return_id, 'partIII', '2');

		// APPROVED / REJECTION SECTION ON HOLD
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

		// section data
		$formFlagProd = 1;
		$mineralData = $this->OProdDetails->getMineralData($formType, $returnType, $returnDate, $endUserId, $formFlagProd);
		$finishedProducts = $this->DirFinishedProducts->getFinishedProducts();

		/**
		 * CREATE HTML FORM STRUCTURE BY PASSING ARRAYS DATA
		 * @version 02nd Dec 2021
		 * @author Aniket Ganvir
		 */
		$rowArrOne = array();
		$rowArrOne[0] = 1;
		$rowArrOne[1] = $mineralData;
		$rowArrOne[2] = $finishedProducts;
		$tableForm = array();
		$tableForm[] = $this->Formcreation->formTableArr('product_manufacture_details', $lang, $rowArrOne);
		$rowArrTwo = array();
		$rowArrTwo[0] = 2;
		$rowArrTwo[1] = $mineralData;
		$rowArrTwo[2] = $finishedProducts;
		$tableForm[] = $this->Formcreation->formTableArr('product_manufacture_details', $lang, $rowArrTwo);
		$rowArrThree = array();
		$rowArrThree[0] = 3;
		$rowArrThree[1] = $mineralData;
		$rowArrThree[2] = $finishedProducts;
		$tableForm[] = $this->Formcreation->formTableArr('product_manufacture_details', $lang, $rowArrThree);
		$jsonTableForm = json_encode($tableForm);

		$this->set('tableForm', $jsonTableForm);
		$this->set('mineralData', $mineralData);

		//communication
        //fetch the particular rejected reason
		$return_id_arr = $this->TblEndUserFinalSubmit->getReturnId($endUserId, $returnDate, $returnType, $ibmUniqueRegNo);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id_arr as $r){
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partIII', 2);
            $reason_data = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partIII', 2, $this->Session->read('mms_user_role'));

            if((isset($reason_data['commented'])) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');

		$commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));

		$this->set('reasons', $reasons);
		$this->set('commentLabel', $commentLabel);
		$this->set('commented_status', $commented_status);

		$form_status = $this->Session->read('form_status');

		$this->set('regNo', $regNo);
	    $this->set('userType',$userType);
		$this->set('activityType', $activityType);
		$this->set('currActivity', $currActivity);
		$this->set('section_no',$section);
		$this->set('returnDataArray',$returnDataArray);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('sectionId', $section);
		$this->set('return_id', $return_id);
		$this->set('part_no', $partNo);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('view', $form_status);
		$this->set('viewOnly', $viewOnly);
		$this->set('is_pri_pending', $is_pri_pending);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/product_manufacture_details');

		if($this->request->is('post')){

			$result = $this->TblEndUserFinalSubmit->saveApproveReject($this->request->getData());

			if ($result == 1) {
				$this->Session->write('mon_f_suc', 'Comment added in <b>End-use Mineral Based Industries - II</b> successfully!');
				$this->nextSection('productManufactureDetails', 'mmsenduser');
			} else if($result == 3) {
				$this->Session->write('mon_f_suc', '<b>End-use Mineral Based Industries - II</b> section succesfully <b><u>approved</u></b>!');
				$this->nextSection('productManufactureDetails', 'mmsenduser');
			} else if($result == 4) {
				$this->Session->write('process_msg', $returnType.' return successfully approved!');
				$this->redirect(array('controller'=>'mms','action'=>'home'));
			} else {
				$this->Session->write('mon_f_err', 'Something went wrong for <b>End-use Mineral Based Industries - II</b>! Please, try again later.');
				$this->redirect(array('controller'=>'mmsenduser','action'=>'productManufactureDetails'));
			}

		}

	}

	//PART II: Iron and Steel Industry
	public function ironSteelIndustries(){

		$this->viewBuilder()->setLayout('mms/form_layout');

        //==============================FIXED VARIABLES=========================
        $section = 3;
        $userType = 'C';
        $partNo = 'partIII';

        $mmsPreExeArr = $this->Clscommon->mmsPreExecute($section, $partNo, $userType);

        $formType = $mmsPreExeArr['formType'];
        $returnDate = $mmsPreExeArr['returnDate'];
        $endUserId = $mmsPreExeArr['endUserId'];
        $ibmUniqueRegNo = $mmsPreExeArr['ibmUniqueRegNo'];
        $returnType = $mmsPreExeArr['returnType'];
        $getDate = $mmsPreExeArr['getDate'];
        $returnDatePeriod = $mmsPreExeArr['returnDatePeriod'];
        $master_admin = $mmsPreExeArr['master_admin'];
        $is_pri_pending = $mmsPreExeArr['is_pri_pending'];
        $viewOnly = $mmsPreExeArr['viewOnly'];
        $returnDataArray = $mmsPreExeArr['returnDataArray'];
		$returnDataArr = end($returnDataArray);
		$return_id = $returnDataArr['id'];
        $reasons = $mmsPreExeArr['reasons'];
        $mineralsData = $mmsPreExeArr['mineralData'];
        $dbAppliStatus = $mmsPreExeArr['dbAppliStatus']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN
        $dbVerifiedFlag = $mmsPreExeArr['dbVerifiedFlag']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN

        //=============================FOR FORM DATA============================
        $return_home_page = $this->Session->read('report_home_page');

		// section data
        $formFlag = 2;
        $ironData = $this->OProdDetails->getAllData('O', 'ANNUAL', $returnDate, $endUserId, $formFlag);
		$this->set('ironData', $ironData);

        // $approvedSections = $this->getUser()->getAttribute('approved_sections');
        // $rejectedReasons = $this->getUser()->getAttribute('rejected_reasons');
        $approvedSections = array();
        $rejectedReasons = array();

        // if ($approvedSections[$mineral][2] == "Rejected") {
        if (isset($approvedSections['mineral'][2]) && $approvedSections['mineral'][2] == "Rejected") {
            $is_rejected_section = 1;
            $rejected_reason = $rejectedReasons[$mineral][2];
        // } else if ($approvedSections[$mineral][2] == "Approved") {
        } else if (isset($approvedSections['mineral'][2]) && $approvedSections['mineral'][2] == "Approved") {
            $is_rejected_section = 2;
        }


		/* create a new session variable to get applicant id on userprofile section, Done by pravin bhakare 22-12-2020 */
        $this->Session->write('report_home_page', $endUserId);

		$regNoTemp = $this->Session->read('ibm_unique_reg_no');
		$checkUnderScore = strpos($regNoTemp, '_');
		if ($checkUnderScore > 0) {
			$regNo = str_replace('_', '/', $regNoTemp);
		} else {
			$regNo = $ibmUniqueRegNo;
		}

        $activityType = $activityType = $this->McUser->getActivityType($endUserId);
        $currActivity = $this->Clscommon->userTypeFullForm($activityType);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('iron_steel_industries', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId, $return_id);
        $this->commentMode($return_id, 'partIII', '3');

		// APPROVED / REJECTION SECTION ON HOLD
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

		//communication
        //fetch the particular rejected reason
		$return_id_arr = $this->TblEndUserFinalSubmit->getReturnId($endUserId, $returnDate, $returnType, $ibmUniqueRegNo);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id_arr as $r){
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partIII', 3);
            $reason_data = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partIII', 3, $this->Session->read('mms_user_role'));

            if((isset($reason_data['commented'])) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');

		$commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));

		$this->set('reasons', $reasons);
		$this->set('commentLabel', $commentLabel);
		$this->set('commented_status', $commented_status);

		$form_status = $this->Session->read('form_status');

		$this->set('regNo', $regNo);
	    $this->set('userType',$userType);
		$this->set('activityType', $activityType);
		$this->set('currActivity', $currActivity);
		$this->set('section_no',$section);
		$this->set('returnDataArray',$returnDataArray);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('sectionId', $section);
		$this->set('return_id', $return_id);
		$this->set('part_no', $partNo);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('view', $form_status);
		$this->set('viewOnly', $viewOnly);
		$this->set('is_pri_pending', $is_pri_pending);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/iron_steel_industries');

		if($this->request->is('post')){

			$result = $this->TblEndUserFinalSubmit->saveApproveReject($this->request->getData());

			if ($result == 1) {
				$this->Session->write('mon_f_suc', 'Comment added in <b>Iron and Steel Industry</b> successfully!');
				$this->nextSection('ironSteelIndustries', 'mmsenduser');
			} else if($result == 3) {
				$this->Session->write('mon_f_suc', '<b>Iron and Steel Industry</b> section succesfully <b><u>approved</u></b>!');
				$this->nextSection('ironSteelIndustries', 'mmsenduser');
			} else if($result == 4) {
				$this->Session->write('process_msg', $returnType.' return successfully approved!');
				$this->redirect(array('controller'=>'mms','action'=>'home'));
			} else {
				$this->Session->write('mon_f_err', 'Something went wrong for <b>Iron and Steel Industry</b>! Please, try again later.');
				$this->redirect(array('controller'=>'mmsenduser','action'=>'ironSteelIndustries'));
			}

		}

	}

	//PART II: Raw Materials Consumed In Production
	public function rawMaterialConsumed(){

		$this->viewBuilder()->setLayout('mms/form_layout');

        //==============================FIXED VARIABLES=========================
        $section = 4;
        $userType = 'C';
        $partNo = 'partIII';

        $mmsPreExeArr = $this->Clscommon->mmsPreExecute($section, $partNo, $userType);

        $formType = $mmsPreExeArr['formType'];
        $returnDate = $mmsPreExeArr['returnDate'];
        $endUserId = $mmsPreExeArr['endUserId'];
        $ibmUniqueRegNo = $mmsPreExeArr['ibmUniqueRegNo'];
        $returnType = $mmsPreExeArr['returnType'];
        $getDate = $mmsPreExeArr['getDate'];
        $returnDatePeriod = $mmsPreExeArr['returnDatePeriod'];
        $master_admin = $mmsPreExeArr['master_admin'];
        $is_pri_pending = $mmsPreExeArr['is_pri_pending'];
        $viewOnly = $mmsPreExeArr['viewOnly'];
        $returnDataArray = $mmsPreExeArr['returnDataArray'];
		$returnDataArr = end($returnDataArray);
		$return_id = $returnDataArr['id'];
        $reasons = $mmsPreExeArr['reasons'];
        $mineralsData = $mmsPreExeArr['mineralData'];
        $dbAppliStatus = $mmsPreExeArr['dbAppliStatus']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN
        $dbVerifiedFlag = $mmsPreExeArr['dbVerifiedFlag']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN

        //=============================FOR FORM DATA============================
        $return_home_page = $this->Session->read('report_home_page');

        // $approvedSections = $this->getUser()->getAttribute('approved_sections');
        // $rejectedReasons = $this->getUser()->getAttribute('rejected_reasons');
        $approvedSections = array();
        $rejectedReasons = array();

        // if ($approvedSections[$mineral][2] == "Rejected") {
        if (isset($approvedSections['mineral'][2]) && $approvedSections['mineral'][2] == "Rejected") {
            $is_rejected_section = 1;
            $rejected_reason = $rejectedReasons[$mineral][2];
        // } else if ($approvedSections[$mineral][2] == "Approved") {
        } else if (isset($approvedSections['mineral'][2]) && $approvedSections['mineral'][2] == "Approved") {
            $is_rejected_section = 2;
        }


		/* create a new session variable to get applicant id on userprofile section, Done by pravin bhakare 22-12-2020 */
        $this->Session->write('report_home_page', $endUserId);

		$regNoTemp = $this->Session->read('ibm_unique_reg_no');
		$checkUnderScore = strpos($regNoTemp, '_');
		if ($checkUnderScore > 0) {
			$regNo = str_replace('_', '/', $regNoTemp);
		} else {
			$regNo = $ibmUniqueRegNo;
		}

        $activityType = $activityType = $this->McUser->getActivityType($endUserId);
        $currActivity = $this->Clscommon->userTypeFullForm($activityType);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('raw_material_consumed', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId, $return_id);
        $this->commentMode($return_id, 'partIII', '4');

		// APPROVED / REJECTION SECTION ON HOLD
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

		// section data
        /**
         * GETTING THE GRADE NAMES ALL AT ONCE SO THAT JUST HAVE TO CHECK IN THE
         * ARRAY TO GET THE CORRESPONDING GRADE
         * @author Uday Shankar Singh<usingh@ubicsindia.com>
         * @version 4th Feb 2014
         */
        $mineralWithUnitArr = $this->DirMeMineral->getAllMineralWithUnit();

		$minWithUnit = json_encode($mineralWithUnitArr);
		$mineralOptions = $this->DirMeMineral->getAllMinerals();
		$rawMatdata = $this->ORawMatConsume->getAllData($formType, $returnType, $returnDate, $endUserId, "C");
		/**
		 * CREATE HTML FORM STRUCTURE BY PASSING ARRAYS DATA
		 * @version 06th Dec 2021
		 * @author Aniket Ganvir
		 */
		$rowArr = array();
		$rowArr[0] = $rawMatdata;
		$rowArr[1] = $mineralOptions['returnValue'];
		$tableForm[] = $this->Formcreation->formTableArr('raw_material_consumed', $lang, $rowArr);
		$jsonTableForm = json_encode($tableForm);

		$this->set('tableForm', $jsonTableForm);
		$this->set('minWithUnit', $minWithUnit);

		//communication
        //fetch the particular rejected reason
		$return_id_arr = $this->TblEndUserFinalSubmit->getReturnId($endUserId, $returnDate, $returnType, $ibmUniqueRegNo);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id_arr as $r){
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partIII', 4);
            $reason_data = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partIII', 4, $this->Session->read('mms_user_role'));

            if((isset($reason_data['commented'])) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');

		$commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));

		$this->set('reasons', $reasons);
		$this->set('commentLabel', $commentLabel);
		$this->set('commented_status', $commented_status);

		$form_status = $this->Session->read('form_status');

		$this->set('regNo', $regNo);
	    $this->set('userType',$userType);
		$this->set('activityType', $activityType);
		$this->set('currActivity', $currActivity);
		$this->set('section_no',$section);
		$this->set('returnDataArray',$returnDataArray);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('sectionId', $section);
		$this->set('return_id', $return_id);
		$this->set('part_no', $partNo);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('view', $form_status);
		$this->set('viewOnly', $viewOnly);
		$this->set('is_pri_pending', $is_pri_pending);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/raw_material_consumed');

		if($this->request->is('post')){

			$result = $this->TblEndUserFinalSubmit->saveApproveReject($this->request->getData());

			if ($result == 1) {
				$this->Session->write('mon_f_suc', 'Comment added in <b>Raw Materials consumed in Production</b> successfully!');
				$this->nextSection('rawMaterialConsumed', 'mmsenduser');
			} else if($result == 3) {
				$this->Session->write('mon_f_suc', '<b>Raw Materials consumed in Production</b> section succesfully <b><u>approved</u></b>!');
				$this->nextSection('rawMaterialConsumed', 'mmsenduser');
			} else if($result == 4) {
				$this->Session->write('process_msg', $returnType.' return successfully approved!');
				$this->redirect(array('controller'=>'mms','action'=>'home'));
			} else {
				$this->Session->write('mon_f_err', 'Something went wrong for <b>Raw Materials consumed in Production</b>! Please, try again later.');
				$this->redirect(array('controller'=>'mmsenduser','action'=>'rawMaterialConsumed'));
			}

		}

	}

	//PART III: Source Of Supply
	public function sourceOfSupply(){

		$this->viewBuilder()->setLayout('mms/form_layout');

        //==============================FIXED VARIABLES=========================
        $section = 5;
        $userType = 'C';
        $partNo = 'partIII';

        $mmsPreExeArr = $this->Clscommon->mmsPreExecute($section, $partNo, $userType);

        $formType = $mmsPreExeArr['formType'];
        $returnDate = $mmsPreExeArr['returnDate'];
        $endUserId = $mmsPreExeArr['endUserId'];
        $ibmUniqueRegNo = $mmsPreExeArr['ibmUniqueRegNo'];
        $returnType = $mmsPreExeArr['returnType'];
        $getDate = $mmsPreExeArr['getDate'];
        $returnDatePeriod = $mmsPreExeArr['returnDatePeriod'];
        $master_admin = $mmsPreExeArr['master_admin'];
        $is_pri_pending = $mmsPreExeArr['is_pri_pending'];
        $viewOnly = $mmsPreExeArr['viewOnly'];
        $returnDataArray = $mmsPreExeArr['returnDataArray'];
		$returnDataArr = end($returnDataArray);
		$return_id = $returnDataArr['id'];
        $reasons = $mmsPreExeArr['reasons'];
        $mineralsData = $mmsPreExeArr['mineralData'];
        $dbAppliStatus = $mmsPreExeArr['dbAppliStatus']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN
        $dbVerifiedFlag = $mmsPreExeArr['dbVerifiedFlag']; // THESE 2 VARIABLES ARE FOR CHECKING THE STATUS OF THE RETURN

        //=============================FOR FORM DATA============================
        $return_home_page = $this->Session->read('report_home_page');

        // $approvedSections = $this->getUser()->getAttribute('approved_sections');
        // $rejectedReasons = $this->getUser()->getAttribute('rejected_reasons');
        $approvedSections = array();
        $rejectedReasons = array();

        // if ($approvedSections[$mineral][2] == "Rejected") {
        if (isset($approvedSections['mineral'][2]) && $approvedSections['mineral'][2] == "Rejected") {
            $is_rejected_section = 1;
            $rejected_reason = $rejectedReasons[$mineral][2];
        // } else if ($approvedSections[$mineral][2] == "Approved") {
        } else if (isset($approvedSections['mineral'][2]) && $approvedSections['mineral'][2] == "Approved") {
            $is_rejected_section = 2;
        }

		/* create a new session variable to get applicant id on userprofile section, Done by pravin bhakare 22-12-2020 */
        $this->Session->write('report_home_page', $endUserId);

		$regNoTemp = $this->Session->read('ibm_unique_reg_no');
		$checkUnderScore = strpos($regNoTemp, '_');
		if ($checkUnderScore > 0) {
			$regNo = str_replace('_', '/', $regNoTemp);
		} else {
			$regNo = $ibmUniqueRegNo;
		}

        $activityType = $activityType = $this->McUser->getActivityType($endUserId);
        $currActivity = $this->Clscommon->userTypeFullForm($activityType);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('source_of_supply', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId, $return_id);
        $this->commentMode($return_id, 'partIII', '5');

		// APPROVED / REJECTION SECTION ON HOLD
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

		// section data
		$sourceData = $this->OSourceSupply->getAllData($formType, $returnType, $returnDate, $endUserId, "C");
		$mineralBasedOnRaw = $this->ORawMatConsume->getMineralSelectedInRawMaterialForm($formType, $returnType, $returnDate, $endUserId);
		$minBasedOnRaw = array();
		foreach ($mineralBasedOnRaw as $ind=>$item) {
			$minBasedOnRaw[$item] = $item;
		}

        $districts = $this->DirDistrict->getDistrctNameWithDistrictName();
        $mode = $this->OSupplyMode->getModes();
		$modeOption = array();
		foreach ($mode as $ind=>$item) {
			$modeOption[$item] = $item;
		}

        $country = $this->DirCountry->getcountryNameNseries();
		$countryOption = array();
		foreach ($country as $ind=>$item) {
			$countryOption[$item] = $item;
		}

		$this->set('minBasedOnRaw', $minBasedOnRaw);
		$this->set('districts', $districts);
		$this->set('modeOption', $modeOption);
		$this->set('countryOption', $countryOption);
		$this->set('sourceData', $sourceData);

		//communication
        //fetch the particular rejected reason
		$return_id_arr = $this->TblEndUserFinalSubmit->getReturnId($endUserId, $returnDate, $returnType, $ibmUniqueRegNo);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id_arr as $r){
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partIII', 5);
            $reason_data = $this->TblEndUserFinalSubmit->getReason($r['id'], 'partIII', 5, $this->Session->read('mms_user_role'));

            if((isset($reason_data['commented'])) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');

		$commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));

		$this->set('reasons', $reasons);
		$this->set('commentLabel', $commentLabel);
		$this->set('commented_status', $commented_status);

		$form_status = $this->Session->read('form_status');

		$this->set('regNo', $regNo);
	    $this->set('userType',$userType);
		$this->set('activityType', $activityType);
		$this->set('currActivity', $currActivity);
		$this->set('section_no',$section);
		$this->set('returnDataArray',$returnDataArray);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('sectionId', $section);
		$this->set('return_id', $return_id);
		$this->set('part_no', $partNo);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('view', $form_status);
		$this->set('viewOnly', $viewOnly);
		$this->set('is_pri_pending', $is_pri_pending);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/source_of_supply');

		if($this->request->is('post')){

			$result = $this->TblEndUserFinalSubmit->saveApproveReject($this->request->getData());

			if ($result == 1) {
				$this->Session->write('mon_f_suc', 'Comment added in <b>Source of Supply</b> successfully!');
				$this->redirect(array('controller'=>'mmsenduser','action'=>'sourceOfSupply'));
			} else if($result == 3) {
				$this->Session->write('mon_f_suc', '<b>Source of Supply</b> section succesfully <b><u>approved</u></b>!');
				$this->redirect(array('controller'=>'mmsenduser','action'=>'sourceOfSupply'));
			} else if($result == 4) {
				$this->Session->write('process_msg', $returnType.' return successfully approved!');
				$this->redirect(array('controller'=>'mms','action'=>'home'));
			} else {
				$this->Session->write('mon_f_err', 'Something went wrong for <b>Source of Supply</b>! Please, try again later.');
				$this->redirect(array('controller'=>'mmsenduser','action'=>'sourceOfSupply'));
			}

		}

	}



    /**
     * UPDATE REJECT REASON COMMENT THROUGH AJAX CALL
     * @addedon: 16th JUL 2021 (by Aniket Ganvir)
     */
    public function updateComment(){

    	$this->autoRender = false;

		if($this->request->is('post')){

			$return_id = $this->request->getData('return_id');
			$result = $this->TblEndUserFinalSubmit->saveApproveReject($this->request->getData(),$return_id);
			echo $result;

		}

    }

    /**
     * REMOVE REJECT REASON COMMENT THROUGH AJAX CALL
     * @addedon: 16th JUL 2021 (by Aniket Ganvir)
     */
    public function removeComment(){

    	$this->autoRender = false;

		if($this->request->is('post')){

			$result = $this->TblEndUserFinalSubmit->remComment($this->request->getData());
			echo $result;

		}

    }


    /**
     * FUNCTION TO CHECK SUPERVISOR COMMENT ON SECTIONS
     * @return RETURN '1' IF ONE OR MORE COMMENT MADE ON SECTION
     * @return RETURN '0' IF NO COMMENT MADE ON ANY SECTION
     * @version 16th JUL 2021
	 * @author Aniket Ganvir
     */
	public function commentStatus($returnType, $returnDate, $endUserId, $activityType){

        $latestReason = $this->TblEndUserFinalSubmit->getLatestReasons($endUserId, $returnDate, $returnType);
		$this->set('latest_reason', $latestReason);
        $reasons = unserialize($latestReason['rejected_section_remarks']);

        $commentStatus = '0';

        if($reasons != ''){
	        foreach($reasons as $reason){

	        	foreach($reason as $rsn){
	        		if($rsn != ''){
        				$commentStatus = '1';
	        		}
	        	}

	        }
        }

		$this->Session->write('comment_status',$commentStatus);

	}

    /**
     * REDIRECT TO THE NEXT SECTION
     * @addedon: 29th APR 2021 (by Aniket Ganvir)
     */
	public function nextSection($action_name,$cntrl = null,$mineral = null,$sub_min = null){

		$section_url = '/mmsenduser/'.$action_name;
		$section_url.= ($mineral != null) ? '/'.$mineral : '';
		$section_url.= ($sub_min != null) ? '/'.$sub_min : '';

    	$sec_link = $this->Session->read('sec_link');

    	$part_no = '1';
    	foreach($sec_link as $min){
    		foreach($min as $key => $val){
    			$val = str_replace('_','',$val);
    			if(strtolower($val) == strtolower($section_url)){
    				$data['key'] = $key;
    				$data['part_no'] = $part_no;
    			}
    		}

    		$part_no++;
    	}

    	$nextPartNo = $data['key'] + 1;
    	if(!$this->Session->read('sec_link.part_'.$data['part_no'].'.'.$nextPartNo)){
    		$nextPartNo = 0;
			$data['part_no'] = $data['part_no'] + 1;

			if(!$this->Session->read('sec_link.part_'.$data['part_no'].'.'.$nextPartNo)){
				$nextPartNo = $data['key'];
				$data['part_no'] = $data['part_no'] - 1;
			}
    	}

    	$data = 'sec_link.part_'.$data['part_no'].'.'.$nextPartNo;

    	$this->redirect($this->Session->read($data));

	}


	/**
     * REDIRECT TO THE PREVIOUS SECTION
     * @addedon: 29th JUL 2021 (by Aniket Ganvir)
     */
	public function prevSection($action_name, $cntrl = null, $mineral = null, $sub_min = null){

		$section_url = '/mmsenduser/'.$action_name;

    	$sec_link = $this->Session->read('sec_link');

    	$part_no = '1';
    	foreach($sec_link as $min){
    		foreach($min as $key => $val){
    			$val = str_replace('_','',$val);
    			if(strtolower($val) == strtolower($section_url)){
    				$data['key'] = $key;
    				$data['part_no'] = $part_no;
    			}
    		}

    		$part_no++;
    	}

    	$nextPartNo = $data['key'] - 1;

    	if(!$this->Session->read('sec_link.part_'.$data['part_no'].'.'.$nextPartNo)){

			$data['part_no'] = $data['part_no'] - 1;
    		$dataNext = 'sec_link.part_'.$data['part_no'];
    		$nextPartNo = array_key_last($this->Session->read($dataNext));

			if(!$this->Session->read('sec_link.part_'.$data['part_no'].'.'.$nextPartNo)){
				$nextPartNo = $data['key'];
				$data['part_no'] = $data['part_no'] + 1;
			}
    	}

    	$data = 'sec_link.part_'.$data['part_no'].'.'.$nextPartNo;

    	$this->redirect($this->Session->read($data));

	}

	/**
	 * REFERRED BACK TO THE USER
	 * @addedon: 16th JUL 2021
	 */
	public function referredBack(){

		$this->autoRender = false;

		if($this->request->is('post')){


			$result = $this->TblEndUserFinalSubmit->saveApproveReject($this->request->getData());

			echo $result;


		}

	}
	/**
	 * DISAPPROVE THE RETURN
	 * @addedon: 17th DEC 2022
	 */
	public function disapproveReturn(){

		$this->autoRender = false;

		if($this->request->is('post')){

			$result = $this->TblEndUserFinalSubmit->saveApproveReject($this->request->getData());

			echo $result;

		}

	}

	/**
	 * APPROVE MONTHLY RETURN
	 * @addedon: 20th APR 2021
	 */
	public function approveReturn(){

		$this->autoRender = false;

		if($this->request->is('post')){

			$result = $this->TblEndUserFinalSubmit->saveApproveReject($this->request->getData());
			
			echo $result;

		}

	}

	//set enduser form sidebar menus and progress bar variables
	public function setEnduserMenus($formType, $returnType, $returnDate, $endUserId, $returnId){

		$this->Customfunctions->setEnduserSectionColorCode($formType, $returnType, $returnDate, $endUserId);
        $partIIM1 = array();
        $partIIM1[0] = null;
        $partIIM1[1] = null;
        $partIIM1['formNo'] = null;
        $this->set('partIIM1', $partIIM1);
        $this->set('is_hematite', false);
        $this->set('partIIMOther', array());
		$this->set('section_mode', null);
		$this->set('tableForm', null);
		$activityType = $this->McUser->getActivityType($endUserId);
		$this->Session->write('activityType', $activityType);
		$this->set('sectionType', $activityType);
		$this->set('return_home_page', '/mms/home');

		$this->set('mineCode', $endUserId);
		$this->set('mmsUserId', $this->Session->read('mms_user_id'));
		$this->set('mmsUserRole', $this->Session->read('mms_user_role'));
		$this->set('mineral', null);
		$this->set('sub_min', null);

		$this->commentStatus($returnType, $returnDate, $endUserId, $activityType);

		// set comment mode "editable" or "readable" as per return status
		$returnData = $this->TblEndUserFinalSubmit->findReturnById($returnId);
		$comment_mode = ($returnData['status'] == 0) ? 'edit' : 'read';
		$this->set('comment_mode', $comment_mode);

	}

    /**
     * SET COMMENT MODE "EDITABLE" OR "READABLE" AS PER RETURN STATUS
     * @version 22nd Dec 2021
     * @author Aniket Ganvir
     */
    public function commentMode($returnId, $partNo, $secId) {

		$returnData = $this->TblEndUserFinalSubmit->findReturnById($returnId);
		$status = array('0','2');
		$comment_mode = (in_array($returnData['status'], $status)) ? 'edit' : 'read';
        $referBackBtn = 0;
        $disapproveBtn = 0;
        $verifiedFlag = $returnData['verified_flag'];
        $main_sec = $this->getRequest()->getSession()->read("main_sec");

        $LastAppSec = $this->TblEndUserFinalSubmit->checkIsLastApproved($returnId,serialize($main_sec));

        if ($comment_mode == 'edit') {

            $tmpSec = $returnData['approved_sections'];
            $appSec = unserialize($tmpSec);

			if (isset($appSec[$partNo][$secId]) && $appSec[$partNo][$secId] == 'Approved') {
				$comment_mode = 'read';
			}

            // SET REFERRED BACK BUTTON STATUS
            if (is_array($appSec)) {
                foreach ($appSec as $partK=>$partV) {

					foreach ($partV as $k => $status) {
						//print_r($status);
						if ($status == 'Rejected') {
							$referBackBtn = 1;
						} else if ($status == 'Approved') {
							$disapproveBtn = 1;
						}
					}

                }
            }

        }

		$this->set('comment_mode', $comment_mode);
		$this->set('return_id', $returnId);
		$this->set('referBackBtn', $referBackBtn);
		$this->set('verifiedFlag', $verifiedFlag);
		$this->set('disapproveBtn', $disapproveBtn);
		$this->set('lastPart', $LastAppSec['lastPart']);
		$this->set('lastSec', $LastAppSec['lastSec']);

    }


}
