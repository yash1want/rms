<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Network\Email\Email;
use Cake\ORM\Entity;
use Cake\ORM\Locator\LocatorAwareTrait;

class EnduserController extends AppController{

	var $name = 'Enduser';
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
		$this->loadComponent('Formcreation');
		$this->loadComponent('Clscommon');
		$this->loadComponent('Language');
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
		$this->DirState = $this->getTableLocator()->get('DirState');
		$this->DirWorkStoppage = $this->getTableLocator()->get('DirWorkStoppage');
		$this->Employment = $this->getTableLocator()->get('Employment');
		$this->ExplosiveReturn = $this->getTableLocator()->get('ExplosiveReturn');
		$this->GradeProd = $this->getTableLocator()->get('GradeProd');
		$this->DirFinishedProducts = $this->getTableLocator()->get('DirFinishedProducts');
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
		$this->NSeriesProdActivity = $this->getTableLocator()->get('NSeriesProdActivity');
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
		$this->Returns = $this->getTableLocator()->get('Returns');
		$this->RentReturns = $this->getTableLocator()->get('RentReturns');
		$this->Rom5 = $this->getTableLocator()->get('Rom5');
		$this->RomMetal5 = $this->getTableLocator()->get('RomMetal5');
		$this->RomStone = $this->getTableLocator()->get('RomStone');
		$this->Sale5 = $this->getTableLocator()->get('Sale5');
		$this->TblEndUserFinalSubmit = $this->getTableLocator()->get('TblEndUserFinalSubmit');
		$this->TblFinalSubmit = $this->getTableLocator()->get('TblFinalSubmit');
		$this->WorkStoppage = $this->getTableLocator()->get('WorkStoppage');

		if(null == $this->getRequest()->getSession()->read('lang')) {
			$this->getRequest()->getSession()->write('lang','english');
		}

		$this->Customfunctions->formReturnTitle();

    }

	/**
	 * function to add selected menu's part ID, form Id and mineral name
	 * to the session and redirect to page
	 * @added on: 26th FEB 2021 (by Aniket Ganvir)
	 */
	public function activeForm($partId, $formId, $mineralName=null){

		$this->Session->write('partId', $partId);
		$this->Session->write('formId', $formId);
		$this->Session->write('mineralName', $mineralName);
		$this->redirect(array('controller'=>'monthly', 'action'=>'fOne'));

	}


	/**
	 * GET RETURN MONTH AND YEAR
	 * @addedon: 05th JUL 2021 (by Aniket Ganvir)
	 */
	public function selectReturn() {
		
		$this->viewBuilder()->setLayout('mc_panel');
		$this->Session->delete('is_all_approved');
		$applicantId = $this->Session->read('username');
		$regNo = $this->Session->read('regNo');
		$fileReturnYear = $this->TblEndUserFinalSubmit->getFileReturnYear($regNo, $applicantId);
		$this->set('file_return_year', $fileReturnYear);
		$this->set('applicant_id', $applicantId);

		if($this->request->is('post')){

            //remove approved sections and rejected remarks by default
			$this->Session->delete('form_status');
			$this->Session->delete('secStatus');
			$this->Session->delete('approved_sections');
			$this->Session->delete('rejected_reasons');
			$this->Session->write('section_mode', 'edit');

			$selMonth = htmlentities($this->request->getData('month'), ENT_QUOTES);
			$selYear = htmlentities($this->request->getData('year'), ENT_QUOTES);

			$postDataStatus = $this->Customfunctions->selectReturnValidation($this->request->getData());

			if($postDataStatus){

				$alert_message = $postDataStatus;
				$alert_redirect_url = 'selectReturn';

			} else {

	        	$returnDate = $selYear . '-' . $selMonth . '-01';
	            $returnType = 'MONTHLY';

                //====CHECKING WHETHER THE RETURN HAS BEEN FILED FOR THIS MONTH OR NOT====
				$finalSubmiStatus = $this->checkFinalSubmit($returnDate, $returnType);

				if($finalSubmiStatus == true){

					$alert_message = "This month's return has been already submitted.";
					$alert_redirect_url = 'selectReturn';

				} else {

					$this->Session->write('mc_sel_month', $selMonth);
					$this->Session->write('mc_sel_year', $selYear);
					$this->Session->write('returnDate', date('Y-m-d', strtotime($returnDate)));
					$this->Session->write('returnType', $returnType);
					$this->Session->write('formType', 'N');

					$this->redirect(array('controller'=>'enduser','action'=>'instruction'));

				}

			}

			// set variables to show popup messages from view file
			$this->set('alert_message',$alert_message);
			$this->set('alert_redirect_url',$alert_redirect_url);

		}

	}

	/**
	 * File Annual Return
	 */
	public function selectAnnualReturn() {

		$this->viewBuilder()->setLayout('mc_panel');

		$this->Session->delete('is_all_approved');
		// get pending return years for filing annual return (M Series)
		$applicantId = $this->Session->read('username');
		$regNo = $this->Session->read('regNo');
		$annualFileReturn = $this->TblEndUserFinalSubmit->getAnnualFileReturnYear($regNo, $applicantId);
		$this->set('annualFileReturn', $annualFileReturn);

		if($this->request->is('post')){

			// destroy previous session variables
			$this->Session->delete('form_status');
			$this->Session->delete('secStatus');
			$this->Session->delete('approved_sections');
			$this->Session->delete('rejected_reasons');
			$this->Session->write('section_mode', 'edit');

			$returnYear = htmlentities($this->request->getData('year'), ENT_QUOTES);

			$postDataStatus = $this->Customfunctions->selectAnnualReturnValidation($this->request->getData());

			if($postDataStatus){

				$alert_message = $postDataStatus;
				$alert_redirect_url = 'selectAnnualReturn';

			} else {

                $returnDate = $returnYear . "-04-01";
                $returnType = "ANNUAL";

				$finalSubmitStatus = $this->checkFinalSubmit($returnDate, $returnType);

				if($finalSubmitStatus == true){

					$alert_message = "Annual return has been already submitted for this year.";
					$alert_redirect_url = 'selectAnnualReturn';

				} else {

					$this->Session->write('mc_sel_year', $returnYear);
					$this->Session->write('returnDate', date('Y-m-d', strtotime($returnDate)));
					$this->Session->write('returnType', $returnType);
					$this->Session->write('formType', 'O');
					$this->redirect(array('controller'=>'enduser','action'=>'instruction'));

				}

			}

			// set variables to show popup messages from view file
			$this->set('alert_message',$alert_message);
			$this->set('alert_redirect_url',$alert_redirect_url);

		}

	}

	/**
	 * Checks if the return has been already final submitted or not
	 * @param type $returnDate
	 */
	public function checkFinalSubmit($returnDate, $returnType) {

		$user_id = $this->Session->read('registration_code');
        // $user = Doctrine_Core::getTable('MC_USER')->findOneByMcuChildUserName($user_id);
        // $mcuChildUserName = $user->getMcuChildUserName();
        $endUserIdTemp = explode('/', $user_id);
        $endUserId = $this->Session->read('regNo');
        $mcu_user_id = $this->Session->read('mcu_user_id');
        $is_final_submitted = $this->TblEndUserFinalSubmit->checkIsSubmitted($endUserId, $returnDate, $returnType, $mcu_user_id);

		$result = false;

        if ($is_final_submitted == true) {
			$result = true;
        }

		return $result;

	}

    public function getRejectedReasons($mineCode, $returnDate, $min = '', $subMin = '', $section = '') {

        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate);
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $min, $subMin, $section);
        }

        return $reasons;
    }


    // PART I: INSTRUCTION
    public function instruction(){

		$this->viewBuilder()->setLayout('mc/form_layout');

        $endUserId = $this->Session->read('registration_code');
        $returnType = $this->Session->read('returnType');
		$lang = $this->Session->read('lang');

		if ($returnType == 'MONTHLY') {
			$getDate = $this->Session->read('returnDate');
		} else {
			$this->Session->read('returnYear');
			if(!isset($getDate)){
				$tempDate = $this->Session->read('returnDate');
				$dateExplode = explode("-", $tempDate);
                $getDate = $dateExplode[0] . "-" . ($dateExplode[0] + 1);
			}
		}

		$formType = $this->Session->read('formType');
		$returnDatePeriod = $this->Clscommon->getDatePeriod($getDate, $returnType, " "); // Parameter date , return type , separator
		$returnDate = $this->Session->read('returnDate');
		$activityType = $this->Session->read('activityType');
		$userType = 1;

		// $this->Customfunctions->executeUserleftnav($mine_code);
		$labels = $this->Language->getFormInputLabels('instruction', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId);

        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
        }

		// APPROVED / REJECTION SECTION ON HOLD
		$is_all_approved = false;
		$is_rejected_section = false;

        // $section_mode = $this->Session->read('form_status');
        // if(null !== $this->Session->read('form_status') && $this->Session->read('form_status') == 'referred_back'){
        // 	$section_mode = 'read';
        // }

        // $section_mode = '';
        // if(null !== $this->Session->read('form_status') && $this->Session->read('form_status') == 'referred_back'){
        // 	$section_mode = 'read';
        // }

		$form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
		$section_mode = ($form_status != '') ? (($this->Session->read('sess_status') == 'referredback') ? 'read' : $form_status) : $form_status;

		// if(null !== $this->Session->read('form_status')) {
		// 	if($this->Session->read('sess_status') == 'referredback') {
		// 		$section_mode = 'read';
		// 	} else {
		// 		$section_mode = $this->Session->read('sess_status');
		// 	}

		// } else {
		// 	$section_mode = '';
		// }

		// $sess_status = (null !== $this->Session->read('sess_status')) ? $this->Session->read('sess_status') : '';
        // $section_mode = ($sess_status == 'referredback') ? 'read' : $sess_status;

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //check is rejected or approved section
        $commented_status = '0';

        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
        $this->set('part_no','partI');
		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('returnDate', $returnDate);

		$this->set('label',$labels);
		$this->set('returnType', $returnType);
		$this->set('formType', $formType);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('is_rejected_section', $is_rejected_section);

		$this->render('/element/enduser/forms/instruction');

    }

    // PART I: GENERAL PARTICULARS
    public function generalParticular(){

		$this->viewBuilder()->setLayout('mc/form_layout');

        $section = 1; // THIS IS FIXED FOR EVERY FORM AND USED FOR APPROVAL REJECTION LOGIC... DON'T EVER CHANGE IT.. OTHER WISE NO DATA WILL COME RIGHT
        $userType = 1; // NEED TO CHECK THE USE
        $partNo = 'partI'; // NOT IN USE  CURRENTLY

        $endUserId = $this->Session->read('registration_code');
        $returnType = $this->Session->read('returnType');
		$lang = $this->Session->read('lang');

        //ON HOLD
		// $this->Customfunctions->executeUserleftnav($mine_code);
		$labels = $this->Language->getFormInputLabels('general_particular', $lang);

        /**
         * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 15th Jan 2014
         *
         * CHANGES ADDED FROM THE RELEASE FILE
         * ADDED THE $this->activityType AS WE ARE USING IT IN THE POST
         */
        $activityType = $this->Session->read('activityType');
        if ($returnType == 'MONTHLY') {
            $getDate = $this->Session->read('returnDate');
        } else {
            $getDate = $this->Session->read('returnYear');
            if (!$getDate) {
                $tempDate = $this->Session->read('returnDate');
                $dateExplode = explode("-", $tempDate);
                $getDate = $dateExplode[0] . "-" . ($dateExplode[0] + 1);
            }
        }

        $formType = $this->Session->read('formType');
        $returnDatePeriod = $this->Clscommon->getDatePeriod($getDate, $returnType, " "); // Parameter date , return type , separator
        $returnDate = $this->Session->read('returnDate');
        $regNo = $this->Session->read('regNo');

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId);

        $currActivity = $this->Clscommon->userTypeFullForm($activityType);
        $fullName = $this->McApplicantDet->getFullName($endUserId);
		$userdata = $this->McUser->getUserDatabyId($endUserId);
		$email = $userdata['mcu_email'];
		$phoneno = $userdata['mcu_mob_num'];
        // Ganesh satav change the below line so comment below line
        // $registrationCodeNumericPart = substr($this->endUserId, 0, 2);
        // below added line add by the ganesh satav
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
		$latiLongiDetails = null;

        $appAdd = $this->McApplicantDet->fetchAllDetailsByAppId($registrationCodeNumericPart['0']);
		$districtData = ($appAdd[0]["mcappd_state"] && $appAdd[0]["mcappd_district"]) ? $this->DirDistrict->getDistrictName($appAdd[0]["mcappd_district"], $appAdd[0]["mcappd_state"]) : array('name'=>'');
		$districtName = (isset($districtData['name'])) ? $districtData['name'] : '';
		$appAdd[0]["mcappd_district"] = (!empty($districtName)) ? $districtName . ",<br/>" : "";
		$appAdd[0]["mcappd_state"] = $appAdd[0]["mcappd_state"] ? $this->DirState->getStateNameAsArray($appAdd[0]["mcappd_state"]) . ",<br/>" : "";

        if ($activityType == 'C') {

            $addressDetails = $this->McMineralconsumptionDet->getConsumptionDetailsBasedOnAppId($endUserId);
			$stateCode = $addressDetails[0]['mcmd_state'];
			if(empty ($stateCode)) {
				$addressDetails[0]['mcmd_state'] = "";
			} else {
                $stateNameTemp = $this->DirState->getStateName($stateCode);
                $addressDetails[0]['mcmd_state'] = (isset($stateNameTemp[0]['state_name'])) ? $stateNameTemp[0]['state_name'] : '';
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

        //====================GETTING REASON FOR REJECTIN AND CHECK WHETHER PARTICULAR SECTION IS APPROVED OR REJECTED

        $finalSubmitData = $this->Clscommon->getNOrOFinalSubmitData($section, $partNo, $userType);

        if ($finalSubmitData['count'] > 0) {
            $finalSubmitData = $finalSubmitData;
        } else {
            $finalSubmitData['countFlag'] = FALSE;
        }

        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
        }

		// APPROVED / REJECTION SECTION ON HOLD
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        // $section_mode = '';
        // if(null !== $this->Session->read('form_status') && $this->Session->read('form_status') == 'referred_back'){
        // 	$section_mode = 'read';
        // }

		// $form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
        // $section_mode = ($form_status == 'referred_back') ? 'read' : $form_status;

		$form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
		$section_mode = ($form_status != '') ? (($this->Session->read('sess_status') == 'referredback') ? 'read' : $form_status) : $form_status;

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //check is rejected or approved section
        $commented_status = '0';

        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);

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

		$this->set('regNo', $regNo);
		$this->set('fullName', $fullName);
		$this->set('email', $email);
		$this->set('phoneno', $phoneno);

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
        $this->set('part_no',$partNo);
		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('returnDate', $returnDate);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/general_particular');

    }


    // PART II: TRADING ACTIVITY
    public function tradingActivity(){

		$this->viewBuilder()->setLayout('mc/form_layout');

        $section = 1; // THIS IS FIXED FOR EVERY FORM AND USED FOR APPROVAL REJECTION LOGIC... DON'T EVER CHANGE IT.. OTHER WISE NO DATA WILL COME RIGHT
        $userType = 'T';
        $partNo = 'partII';
        $formType = $this->Session->read('formType');

        $endUserId = $this->Session->read('registration_code');
        $returnType = $this->Session->read('returnType');

        if ($returnType == 'MONTHLY') {
            $getDate = $this->Session->read('returnDate');
        } else {
            $getDate = $this->Session->read('returnYear');
			if(!$getDate){
                $tempDate = $this->Session->read('returnDate');
                $dateExplode = explode("-", $tempDate);
                $getDate = $dateExplode[0]."-".($dateExplode[0]+1);
            }
        }

        $returnDatePeriod = $this->Clscommon->getDatePeriod($getDate, $returnType, " "); // Parameter date , return type , separator
        $returnDate = $this->Session->read('returnDate');
        $regNo = $this->Session->read('regNo');

        //==================GETTING TRADING ACTIVITY DATA FOR FORM==================
        //====GETTING THE DATA FROM N SERIES BASED ON IF CURRENT MONTH IS FILLED THEN GET CURRENT MONTH DATA ELSE GET LAST MONTH DATA
		$countries = $this->DirCountry->getCountryNameLMSeries();
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
			$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $getDate);
			$min_grade_arr[$key] = $min_grade['gradeData'];

		}

        //=============ENCODING THE DATA FOR PASSING IN THE JS CODE=============
        $mineralsData = json_encode($resultSet['mineralsData']);
        $gradeforMineral = json_encode($resultSet['gradeforMineral']);

        //==========================================================================

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $period = $returnYear . " - " . ($temp[0] + 1);

        //====================GETTING REASON FOR REJECTIN AND CHECK WHETHER PARTICULAR SECTION IS APPROVED OR REJECTED
        $finalSubmitData = $this->Clscommon->getNOrOFinalSubmitData($section, $partNo, $userType);

        if ($finalSubmitData['count'] > 0) {
            $finalSubmitData = $finalSubmitData;
        } else{
            $finalSubmitData['countFlag'] = FALSE;
            $finalSubmitData = $finalSubmitData;
        }

		// get minerals
	    $minerals = $this->DirMeMineral->getMineralList();
	    $mineralsArr = [];
	    foreach($minerals as $key=>$val){
	    	$mineralsArr[$val] = $val;
	    }
		$mineralsArr['NIL'] = 'NIL';

		$lang = $this->Session->read('lang');

        //ON HOLD
		// $this->Customfunctions->executeUserleftnav($mine_code);
		$labels = $this->Language->getFormInputLabels('trading_activity', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId);

        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
        }

		// APPROVED / REJECTION SECTION
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        // $section_mode = '';
        // if(null !== $this->Session->read('form_status') && $this->Session->read('form_status') == 'referred_back'){
        // 	$section_mode = 'read';
        // }

		// $form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
        // $section_mode = ($form_status == 'referred_back') ? 'read' : $form_status;

		$form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
		$section_mode = ($form_status != '') ? (($this->Session->read('sess_status') == 'referredback') ? 'read' : $form_status) : $form_status;

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblEndUserFinalSubmit->getReturnIdExceptLatest($endUserId, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblEndUserFinalSubmit->getReason($return_id['id'], 'partII', 1, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel',$commentLabel);

		//current comment history
        if (isset($approvedSections['partII'][1]) && $approvedSections['partII'][1] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partII', 1, 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblEndUserFinalSubmit->getReason($return_id, 'partII', 1, 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mmsUserId',$this->Session->read('username'));
	        $this->set('mmsUserRole','applicant');
	        $this->set('sectionId','1');
        // } else if ($approvedSections['partI'][1] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);

		$this->set('regNo', $regNo);
	    $this->set('minerals',$mineralsArr);
		$this->set('countries',$countries);
	    $this->set('userType',$userType);
		$this->set('tradingAc',$resultSet);
		$this->set('min_row_span',$min_row_span);
		$this->set('min_grade_arr',$min_grade_arr);
		$this->set('section_no',$section);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
        $this->set('part_no',$partNo);
		$this->set('endUserId', $endUserId);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/trading_activity');

		if($this->request->is('post')){

			if($this->request->getData('submit') == 'save_comment'){
				$result1 = $this->TblEndUserFinalSubmit->saveApplicantReply($this->request->getData());
				$result = $this->NSeriesProdActivity->saveFormDetails($this->request->getData());

				if($result1 == 1){
					$this->Session->write('mon_f_suc','Reply saved in <b>Trading Activity</b> successfully!');
					// $this->redirect(array('controller'=>'enduser','action'=>'tradingActivity'));
					$this->nextSection('tradingActivity', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Failed to saved reply <b>Trading Activity</b>! Please, try again later.');
					// $this->redirect(array('controller'=>'enduser','action'=>'tradingActivity'));
					$this->nextSection('tradingActivity', 'Enduser');
				}
			} else {
				$result = $this->NSeriesProdActivity->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Trading Activity</b> successfully saved!');
					// $this->redirect(array('controller'=>'enduser','action'=>'exportOfOre'));
					// $this->redirect(array('controller'=>'enduser','action'=>'tradingActivity'));
					$this->nextSection('tradingActivity', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Problem in saving <b>Trading Activity</b> details! Please, try again later.');
					$this->redirect(array('controller'=>'enduser','action'=>'tradingActivity'));
				}
			}

		}

    }


    // PART II: EXPORT ACTIVITY
    public function exportOfOre(){

		$this->viewBuilder()->setLayout('mc/form_layout');

        $section = 2; // THIS IS FIXED FOR EVERY FORM AND USED FOR APPROVAL REJECTION LOGIC... DON'T EVER CHANGE IT.. OTHER WISE NO DATA WILL COME RIGHT
        $userType = 'E';
        $partNo = 'partII';
        $formType = $this->Session->read('formType');

        $endUserId = $this->Session->read('registration_code');
        $returnType = $this->Session->read('returnType');

        if ($returnType == 'MONTHLY') {
            $getDate = $this->Session->read('returnDate');
        } else {
            $getDate = $this->Session->read('returnYear');
			if(!$getDate){
                $tempDate = $this->Session->read('returnDate');
                $dateExplode = explode("-", $tempDate);
                $getDate = $dateExplode[0]."-".($dateExplode[0]+1);
            }
        }

        $returnDatePeriod = $this->Clscommon->getDatePeriod($getDate, $returnType, " "); // Parameter date , return type , separator
        $returnDate = $this->Session->read('returnDate');
        $regNo = $this->Session->read('regNo');

        //================GETTING TRADING ORE EXPORT DATA FOR FORM==================
        //====GETTING THE DATA FROM N SERIES BASED ON IF CURRENT MONTH IS FILLED THEN GET CURRENT MONTH DATA ELSE GET LAST MONTH DATA
		$countries = $this->DirCountry->getCountryNameLMSeries();
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
		// print_r($resultSet['mineralsData']); exit;
		foreach($resultSet['mineralsData'] as $key=>$val){

			//set mineral rowspan structure
			if($val['local_mineral_code'] == ''){
				$min_count = 1;
			} else if($min_val == $val['local_mineral_code']){
				$min_count = 0;
				// $min_row_span[$key-1] = $min_row_span[$key-1] + 1;
				// $min_row_span[$min_code_key] = $min_row_span[$key-1] + 1;
				$min_code_key = $min_code_row[$val['local_mineral_code']];
				$min_row_span[$min_code_key] = $min_row_span[$min_code_key] + 1;
			} else {
				$min_count = 1;
				$min_code_row[$val['local_mineral_code']] = $key;
			}

			$min_row_span[$key] = $min_count;
			$min_val = $val['local_mineral_code'];

			//grades data
			$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $getDate);
			$min_grade_arr[$key] = $min_grade['gradeData'];

		}

        //=============ENCODING THE DATA FOR PASSING IN THE JS CODE=============
        $mineralsData = json_encode($resultSet['mineralsData']);
        $gradeforMineral = json_encode($resultSet['gradeforMineral']);

        //==========================================================================

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $period = $returnYear . " - " . ($temp[0] + 1);

        //====================GETTING REASON FOR REJECTIN AND CHECK WHETHER PARTICULAR SECTION IS APPROVED OR REJECTED
        $finalSubmitData = $this->Clscommon->getNOrOFinalSubmitData($section, $partNo, $userType);

        if ($finalSubmitData['count'] > 0) {
            $finalSubmitData = $finalSubmitData;
        } else{
            $finalSubmitData['countFlag'] = FALSE;
            $finalSubmitData = $finalSubmitData;
        }

		// get minerals
	    $minerals = $this->DirMeMineral->getMineralList();
	    $mineralsArr = [];
	    foreach($minerals as $key=>$val){
	    	$mineralsArr[$val] = $val;
	    }
		$mineralsArr['NIL'] = 'NIL';

		$lang = $this->Session->read('lang');

        //ON HOLD
		// $this->Customfunctions->executeUserleftnav($mine_code);
		$labels = $this->Language->getFormInputLabels('export_of_ore', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId);

        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
        }

		// APPROVED / REJECTION SECTION
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        // $section_mode = '';
        // if(null !== $this->Session->read('form_status') && $this->Session->read('form_status') == 'referred_back'){
        // 	$section_mode = 'read';
        // }

		// $form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
        // $section_mode = ($form_status == 'referred_back') ? 'read' : $form_status;

		$form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
		$section_mode = ($form_status != '') ? (($this->Session->read('sess_status') == 'referredback') ? 'read' : $form_status) : $form_status;

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
		$reasons_old = array();

        //old comment history
        $return_ids = $this->TblEndUserFinalSubmit->getReturnIdExceptLatest($endUserId, $returnDate, $returnType);
        if(count($return_ids) > 0){
            foreach($return_ids as $return_id){
                $reasons_old[] = $this->TblEndUserFinalSubmit->getReason($return_id['id'], 'partII', 2, 'applicant');
            }
        }
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel',$commentLabel);

        //current comment history
        if (isset($approvedSections['partII'][2]) && $approvedSections['partII'][2] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partII', 2, 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblEndUserFinalSubmit->getReason($return_id, 'partII', 2, 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mmsUserId',$this->Session->read('username'));
	        $this->set('mmsUserRole','applicant');
	        $this->set('sectionId','2');
        // } else if ($approvedSections['partI'][1] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);

		$this->set('regNo', $regNo);
	    $this->set('minerals',$mineralsArr);
		$this->set('countries',$countries);
	    $this->set('userType',$userType);
		$this->set('tradingAc',$resultSet);
		$this->set('min_row_span',$min_row_span);
		$this->set('min_grade_arr',$min_grade_arr);
		$this->set('section_no',$section);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
        $this->set('part_no',$partNo);
		$this->set('endUserId', $endUserId);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/trading_activity');

		if($this->request->is('post')){

			if($this->request->getData('submit') == 'save_comment'){
				$result1 = $this->TblEndUserFinalSubmit->saveApplicantReply($this->request->getData());
				$result = $this->NSeriesProdActivity->saveFormDetails($this->request->getData());

				if($result1 == 1){
					$this->Session->write('mon_f_suc','Reply saved in <b>Export Activity</b> successfully!');
					// $this->redirect(array('controller'=>'enduser','action'=>'exportOfOre'));
					$this->nextSection('exportOfOre', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Failed to saved reply <b>Export Activity</b>! Please, try again later.');
					// $this->redirect(array('controller'=>'enduser','action'=>'exportOfOre'));
					$this->nextSection('exportOfOre', 'Enduser');
				}
			} else {
				$result = $this->NSeriesProdActivity->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Export Activity</b> successfully saved!');
					// $this->redirect(array('controller'=>'enduser','action'=>'mineralBaseActivity'));
					// $this->redirect(array('controller'=>'enduser','action'=>'exportOfOre'));
					$this->nextSection('exportOfOre', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Problem in saving <b>Export Activity</b> details! Please, try again later.');
					$this->redirect(array('controller'=>'enduser','action'=>'exportOfOre'));
				}
			}

		}

    }


    // PART II: END-USE MINERAL BASED ACTIVITY
    public function mineralBaseActivity(){

		$this->viewBuilder()->setLayout('mc/form_layout');

        $section = 3; // THIS IS FIXED FOR EVERY FORM AND USED FOR APPROVAL REJECTION LOGIC... DON'T EVER CHANGE IT.. OTHER WISE NO DATA WILL COME RIGHT
        $userType = 'C';
        $partNo = 'partII';
        $formType = $this->Session->read('formType');

        $endUserId = $this->Session->read('registration_code');
        $returnType = $this->Session->read('returnType');

        if ($returnType == 'MONTHLY') {
            $getDate = $this->Session->read('returnDate');
        } else {
            $getDate = $this->Session->read('returnYear');
			if(!$getDate){
                $tempDate = $this->Session->read('returnDate');
                $dateExplode = explode("-", $tempDate);
                $getDate = $dateExplode[0]."-".($dateExplode[0]+1);
            }
        }

        $returnDatePeriod = $this->Clscommon->getDatePeriod($getDate, $returnType, " "); // Parameter date , return type , separator
        $returnDate = $this->Session->read('returnDate');
        $regNo = $this->Session->read('regNo');

		//get country list
		$country_arr = $this->DirCountry->getCountryList();
		$country_list = array();
		foreach($country_arr as $key=>$val){
			$country_list[] = $val['country_name'];
		}

		$countries = $this->DirCountry->getCountryNameLMSeries();

        //====GETTING THE DATA FROM N SERIES BASED ON IF CURRENT MONTH IS FILLED THEN GET CURRENT MONTH DATA ELSE GET LAST MONTH DATA
        $resultSet = $this->Clscommon->NSeriesPrevMonthVsCurrentData($formType, $returnType, $returnDate, $endUserId, $userType);

		// echo '<pre>';
		// print_r($resultSet); exit;

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
			$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $getDate);
			$min_grade_arr[$key] = ($min_grade['gradeData'] != '') ? $min_grade['gradeData'] : 'NIL';
		}

        //=============ENCODING THE DATA FOR PASSING IN THE JS CODE=============
        $mineralsData = json_encode($resultSet['mineralsData']);
        $gradeforMineral = json_encode($resultSet['gradeforMineral']);

        //==========================================================================

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $period = $returnYear . " - " . ($temp[0] + 1);

        //====================GETTING REASON FOR REJECTIN AND CHECK WHETHER PARTICULAR SECTION IS APPROVED OR REJECTED
        $finalSubmitData = $this->Clscommon->getNOrOFinalSubmitData($section, $partNo, $userType);

        if ($finalSubmitData['count'] > 0) {
            $finalSubmitData = $finalSubmitData;
        } else{
            $finalSubmitData['countFlag'] = FALSE;
        }

		// get minerals
	    $minerals = $this->DirMeMineral->getMineralList();
	    $mineralsArr = [];
	    foreach($minerals as $key=>$val){
	    	$mineralsArr[$val] = $val;
	    }
		$mineralsArr['NIL'] = 'NIL';

		$lang = $this->Session->read('lang');

        //ON HOLD
		// $this->Customfunctions->executeUserleftnav($mine_code);
		$labels = $this->Language->getFormInputLabels('mineral_base_activity', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId);

        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
        }

		// APPROVED / REJECTION SECTION
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        // $section_mode = '';
        // if(null !== $this->Session->read('form_status') && $this->Session->read('form_status') == 'referred_back'){
        // 	$section_mode = 'read';
        // }

		// $form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
        // $section_mode = ($form_status == 'referred_back') ? 'read' : $form_status;

		$form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
		$section_mode = ($form_status != '') ? (($this->Session->read('sess_status') == 'referredback') ? 'read' : $form_status) : $form_status;

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
		$reasons_old = array();

        //old comment history
        $return_ids = $this->TblEndUserFinalSubmit->getReturnIdExceptLatest($endUserId, $returnDate, $returnType);
        if(count($return_ids) > 0){
            foreach($return_ids as $return_id){
                $reasons_old[] = $this->TblEndUserFinalSubmit->getReason($return_id['id'], 'partII', 3, 'applicant');
            }
        }
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel',$commentLabel);

        //current comment history
        if (isset($approvedSections['partII'][3]) && $approvedSections['partII'][3] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partII', 3, 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblEndUserFinalSubmit->getReason($return_id, 'partII', 3, 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mmsUserId',$this->Session->read('username'));
	        $this->set('mmsUserRole','applicant');
	        $this->set('sectionId','3');
        // } else if ($approvedSections['partI'][1] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);

		$this->set('country_list', json_encode($country_list));
		$this->set('countries', $countries);
		$this->set('regNo', $regNo);
	    $this->set('minerals',$mineralsArr);
	    $this->set('userType',$userType);
		$this->set('tradingAc',$resultSet);
		$this->set('min_row_span',$min_row_span);
		$this->set('min_grade_arr',$min_grade_arr);
        $this->set('part_no',$partNo);
		$this->set('section_no',$section);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/trading_activity');

		if($this->request->is('post')){

			if($this->request->getData('submit') == 'save_comment'){
				$result1 = $this->TblEndUserFinalSubmit->saveApplicantReply($this->request->getData());
				$result = $this->NSeriesProdActivity->saveFormDetails($this->request->getData());

				if($result1 == 1){
					$this->Session->write('mon_f_suc','Reply saved in <b>Mineral Based Activity</b> successfully!');
					// $this->redirect(array('controller'=>'enduser','action'=>'mineralBaseActivity'));
					$this->nextSection('mineralBaseActivity', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Failed to saved reply <b>Mineral Based Activity</b>! Please, try again later.');
					// $this->redirect(array('controller'=>'enduser','action'=>'mineralBaseActivity'));
					$this->nextSection('mineralBaseActivity', 'Enduser');
				}
			} else {
				$result = $this->NSeriesProdActivity->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Mineral Based Activity</b> successfully saved!');
					// $this->redirect(array('controller'=>'enduser','action'=>'storageActivity'));
					// $this->redirect(array('controller'=>'enduser','action'=>'mineralBaseActivity'));
					$this->nextSection('mineralBaseActivity', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Problem in saving <b>Mineral Based Activity</b> details! Please, try again later.');
					$this->redirect(array('controller'=>'enduser','action'=>'mineralBaseActivity'));
				}
			}

		}

    }


    // PART II: STORAGE ACTIVITY
    public function storageActivity(){

		$this->viewBuilder()->setLayout('mc/form_layout');

        $section = 4; // THIS IS FIXED FOR EVERY FORM AND USED FOR APPROVAL REJECTION LOGIC... DON'T EVER CHANGE IT.. OTHER WISE NO DATA WILL COME RIGHT
        $userType = 'S';
        $partNo = 'partII';
        $formType = $this->Session->read('formType');

        $endUserId = $this->Session->read('registration_code');
        $returnType = $this->Session->read('returnType');

        if ($returnType == 'MONTHLY') {
            $getDate = $this->Session->read('returnDate');
        } else {
            $getDate = $this->Session->read('returnYear');
			if(!$getDate){
                $tempDate = $this->Session->read('returnDate');
                $dateExplode = explode("-", $tempDate);
                $getDate = $dateExplode[0]."-".($dateExplode[0]+1);
            }
        }

        $returnDatePeriod = $this->Clscommon->getDatePeriod($getDate, $returnType, " "); // Parameter date , return type , separator
        $returnDate = $this->Session->read('returnDate');
        $regNo = $this->Session->read('regNo');

        //================GETTING TRADING ORE EXPORT DATA FOR FORM==================
        //====GETTING THE DATA FROM N SERIES BASED ON IF CURRENT MONTH IS FILLED THEN GET CURRENT MONTH DATA ELSE GET LAST MONTH DATA
		$countries = $this->DirCountry->getCountryNameLMSeries();
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
			$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $getDate);
			$min_grade_arr[$key] = $min_grade['gradeData'];

		}

        //=============ENCODING THE DATA FOR PASSING IN THE JS CODE=============
        $mineralsData = json_encode($resultSet['mineralsData']);
        $gradeforMineral = json_encode($resultSet['gradeforMineral']);

        //==========================================================================

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $period = $returnYear . " - " . ($temp[0] + 1);

        //====================GETTING REASON FOR REJECTIN AND CHECK WHETHER PARTICULAR SECTION IS APPROVED OR REJECTED
        $finalSubmitData = $this->Clscommon->getNOrOFinalSubmitData($section, $partNo, $userType);

        if ($finalSubmitData['count'] > 0) {
            $finalSubmitData = $finalSubmitData;
        } else{
            $finalSubmitData['countFlag'] = FALSE;
        }

		// get minerals
	    $minerals = $this->DirMeMineral->getMineralList();
	    $mineralsArr = [];
	    foreach($minerals as $key=>$val){
	    	$mineralsArr[$val] = $val;
	    }
		$mineralsArr['NIL'] = 'NIL';

		$lang = $this->Session->read('lang');

        //ON HOLD
		// $this->Customfunctions->executeUserleftnav($mine_code);
		$labels = $this->Language->getFormInputLabels('storage_activity', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId);

        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
        }

		// APPROVED / REJECTION SECTION
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

        // $section_mode = '';
        // if(null !== $this->Session->read('form_status') && $this->Session->read('form_status') == 'referred_back'){
        // 	$section_mode = 'read';
        // }

		// $form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
        // $section_mode = ($form_status == 'referred_back') ? 'read' : $form_status;

		$form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
		$section_mode = ($form_status != '') ? (($this->Session->read('sess_status') == 'referredback') ? 'read' : $form_status) : $form_status;

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
		$reasons_old = array();

        //old comment history
        $return_ids = $this->TblEndUserFinalSubmit->getReturnIdExceptLatest($endUserId, $returnDate, $returnType);
        if(count($return_ids) > 0){
            foreach($return_ids as $return_id){
                $reasons_old[] = $this->TblEndUserFinalSubmit->getReason($return_id['id'], 'partII', 4, 'applicant');
            }
        }
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel',$commentLabel);

        //current comment history
        if (isset($approvedSections['partII'][4]) && $approvedSections['partII'][4] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partII', 4, 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblEndUserFinalSubmit->getReason($return_id, 'partII', 4, 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mmsUserId',$this->Session->read('username'));
	        $this->set('mmsUserRole','applicant');
	        $this->set('sectionId','4');
        // } else if ($approvedSections['partI'][1] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);

		$this->set('regNo', $regNo);
	    $this->set('minerals',$mineralsArr);
		$this->set('countries',$countries);
	    $this->set('userType',$userType);
		$this->set('tradingAc',$resultSet);
		$this->set('min_row_span',$min_row_span);
		$this->set('min_grade_arr',$min_grade_arr);
        $this->set('part_no',$partNo);
		$this->set('section_no',$section);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/trading_activity');

		if($this->request->is('post')){

			if($this->request->getData('submit') == 'save_comment'){
				$result1 = $this->TblEndUserFinalSubmit->saveApplicantReply($this->request->getData());
				$result = $this->NSeriesProdActivity->saveFormDetails($this->request->getData());

				if($result1 == 1){
					$this->Session->write('mon_f_suc','Reply saved in <b>Storage Activity</b> successfully!');
					// $this->redirect(array('controller'=>'enduser','action'=>'storageActivity'));
					$this->nextSection('storageActivity', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Failed to saved reply <b>Storage Activity</b>! Please, try again later.');
					// $this->redirect(array('controller'=>'enduser','action'=>'storageActivity'));
					$this->nextSection('storageActivity', 'Enduser');
				}
			} else {
				$result = $this->NSeriesProdActivity->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Storage Activity</b> successfully saved!');
					// $this->redirect(array('controller'=>'enduser','action'=>'storageActivity'));
					$this->nextSection('storageActivity', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Problem in saving <b>Storage Activity</b> details! Please, try again later.');
					$this->redirect(array('controller'=>'enduser','action'=>'storageActivity'));
				}
			}

		}

    }

    // FORM M: PART III: END-USE MINERAL BASED INDUSTRIES - I
    public function mineralBasedIndustries(){

		$this->viewBuilder()->setLayout('mc/form_layout');

        //==============================FIXED VARIABLES=========================
        $section = 1;
        $userType = 'C';
        $partNo = 'partIII';

        //=============CHECKING FOR THE ACTIVITY TYPE .. IF NOT END USE THEN REDIRECT WITH THE FLASH MESSAGE
        $activityType = $this->Session->read('activityType');
        if ($activityType != 'C') {
            // $this->getUser()->setFlash('errorMsg', 'Sorry, you are not authorized to view this section.');
            // $this->redirect('oSeries/generalParticulars');
			$this->autoRender = false;
			$this->Session->write('mon_f_err','Sorry, you are not authorized to view this section.');
			$this->redirect(array('controller'=>'enduser', 'action'=>'instruction'));
        }

        $endUserId = $this->Session->read('registration_code');
        $returnType = $this->Session->read('returnType');

        if ($returnType == 'MONTHLY') {
            $getDate = $this->Session->read('returnDate');
        } else {
            $getDate = $this->Session->read('returnYear');
			if(!$getDate){
                $tempDate = $this->Session->read('returnDate');
                $dateExplode = explode("-", $tempDate);
                $getDate = $dateExplode[0]."-".($dateExplode[0]+1);
            }
        }

        $formType = $this->Session->read('formType');
        $returnDatePeriod = $this->Clscommon->getDatePeriod($getDate, $returnType, " "); // Parameter date , return type , separator
        $returnDate = $this->Session->read('returnDate');
        $regNo = $this->Session->read('regNo');

        //==========================================================================

        $finalSubmitData = $this->Clscommon->getNOrOFinalSubmitData($section, $partNo, $userType);
        if ($finalSubmitData['count'] > 0) {
            $finalSubmitData = $finalSubmitData;
        } else {
            $finalSubmitData['countFlag'] = FALSE;
		}

		// Added by Naveen Jha on 03/07/18 to get the registration number irrespective of the length of number. "/" used for splitting
		$regid = explode("/", $endUserId);
		$registrationCodeNumericPart = $regid[0];
		// Added by Naveen Jha
      	// $registrationCodeNumericPart = substr($this->endUserId, 0, 2); // Commented by Naveen Jha on 03/07/18
		$stateData = true;
        if ($activityType == 'C') {
            $addressDetails = $this->McMineralconsumptionDet->getConsumptionDetailsBasedOnAppId($endUserId);
			if(count($addressDetails) == 0) {
				$stateData = false;
				$addressDetails[0]['mcmd_state'] = 3;
			}
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
		// $this->states = DIR_STATETable::getAllStateNames();
		// if ($this->fetchData['state'] != '') {
		// 	$this->districts = DIR_DISTRICTTable::getDistrctNameWithDistrictCodeOSeries($this->fetchData['state']);
		// } else {
		// 	$this->districts = DIR_DISTRICTTable::getDistrctNameWithDistrictCodeforReport();
		// }

        //==========================================================================

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $period = $returnYear . " - " . ($temp[0] + 1);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('mineral_based_industries', $lang);

        //ON HOLD
		// $this->Customfunctions->executeUserleftnav($mine_code);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId);

        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
        }

		// APPROVED / REJECTION SECTION
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

		$form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
		$section_mode = ($form_status != '') ? (($this->Session->read('sess_status') == 'referredback') ? 'read' : $form_status) : $form_status;

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
		$reasons_old = array();

        //old comment history
        $return_ids = $this->TblEndUserFinalSubmit->getReturnIdExceptLatest($endUserId, $returnDate, $returnType);
        if(count($return_ids) > 0){
            foreach($return_ids as $return_id){
                $reasons_old[] = $this->TblEndUserFinalSubmit->getReason($return_id['id'], 'partIII', 1, 'applicant');
            }
        }
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel',$commentLabel);
		$this->set('stateData',$stateData);

        //current comment history
        if (isset($approvedSections['partIII'][1]) && $approvedSections['partIII'][1] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 1, 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 1, 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mmsUserId',$this->Session->read('username'));
	        $this->set('mmsUserRole','applicant');
	        $this->set('sectionId','1');
        // } else if ($approvedSections['partI'][1] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);

		$this->set('fetchData', $fetchData);
		$this->set('addressDetails', $addressDetails);
		$this->set('regionAndDistrictName', $regionAndDistrictName);
		$this->set('latiLongiDetails', $latiLongiDetails);
		$this->set('industries', $industries);
		$this->set('industries_op', $industries_op);

		$this->set('regNo', $regNo);
	    $this->set('userType',$userType);
        $this->set('part_no',$partNo);
		$this->set('section_no',$section);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/mineral_based_industries');

		if($this->request->is('post')){

			if($this->request->getData('submit') == 'save_comment'){
				$result1 = $this->TblEndUserFinalSubmit->saveApplicantReply($this->request->getData());
				$result = $this->OMineralIndustryInfo->saveFormDetails($this->request->getData());

				if($result1 == 1){
					$this->Session->write('mon_f_suc','Reply saved in <b>End-use Mineral Based Industries - I</b> successfully!');
					// $this->redirect(array('controller'=>'enduser','action'=>'mineralBasedIndustries'));
					$this->nextSection('mineralBasedIndustries', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Failed to saved reply <b>End-use Mineral Based Industries - I</b>! Please, try again later.');
					// $this->redirect(array('controller'=>'enduser','action'=>'mineralBasedIndustries'));
					$this->nextSection('mineralBasedIndustries', 'Enduser');
				}
			} else {
				$result = $this->OMineralIndustryInfo->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>End-use Mineral Based Industries - I</b> successfully saved!');
					// $this->redirect(array('controller'=>'enduser','action'=>'mineralBasedIndustries'));
					$this->nextSection('mineralBasedIndustries', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Problem in saving <b>End-use Mineral Based Industries - I</b> details! Please, try again later.');
					$this->redirect(array('controller'=>'enduser','action'=>'mineralBasedIndustries'));
				}
			}

		}

    }


    // FORM M: PART III: END-USE MINERAL BASED INDUSTRIES - II
    public function productManufactureDetails(){

		$this->viewBuilder()->setLayout('mc/form_layout');

        //==============================FIXED VARIABLES=========================
        $section = 2;
        $userType = 'C';
        $partNo = 'partIII';

        //=============CHECKING FOR THE ACTIVITY TYPE .. IF NOT END USE THEN REDIRECT WITH THE FLASH MESSAGE
        $activityType = $this->Session->read('activityType');
        if ($activityType != 'C') {
            // $this->getUser()->setFlash('errorMsg', 'Sorry, you are not authorized to view this section.');
            // $this->redirect('oSeries/generalParticulars');
			$this->autoRender = false;
			$this->Session->write('mon_f_err','Sorry, you are not authorized to view this section.');
			$this->redirect(array('controller'=>'enduser', 'action'=>'instruction'));
        }

        $endUserId = $this->Session->read('registration_code');
        $returnType = $this->Session->read('returnType');

        if ($returnType == 'MONTHLY') {
            $getDate = $this->Session->read('returnDate');
        } else {
            $getDate = $this->Session->read('returnYear');
			if(!$getDate){
                $tempDate = $this->Session->read('returnDate');
                $dateExplode = explode("-", $tempDate);
                $getDate = $dateExplode[0]."-".($dateExplode[0]+1);
            }
        }

        $formType = $this->Session->read('formType');
        $returnDatePeriod = $this->Clscommon->getDatePeriod($getDate, $returnType, " "); // Parameter date , return type , separator
        $returnDate = $this->Session->read('returnDate');
        $regNo = $this->Session->read('regNo');

        //==========================================================================

        $finalSubmitData = $this->Clscommon->getNOrOFinalSubmitData($section, $partNo, $userType);
        if ($finalSubmitData['count'] > 0) {
            $finalSubmitData = $finalSubmitData;
        } else {
            $finalSubmitData['countFlag'] = FALSE;
		}


        //==========================================================================

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $period = $returnYear . " - " . ($temp[0] + 1);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('product_manufacture_details', $lang);

        //ON HOLD
		// $this->Customfunctions->executeUserleftnav($mine_code);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId);

        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
        }

		// APPROVED / REJECTION SECTION
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

		$form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
		$section_mode = ($form_status != '') ? (($this->Session->read('sess_status') == 'referredback') ? 'read' : $form_status) : $form_status;

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
		$reasons_old = array();

        //old comment history
        $return_ids = $this->TblEndUserFinalSubmit->getReturnIdExceptLatest($endUserId, $returnDate, $returnType);
        if(count($return_ids) > 0){
            foreach($return_ids as $return_id){
                $reasons_old[] = $this->TblEndUserFinalSubmit->getReason($return_id['id'], 'partIII', 2, 'applicant');
            }
        }
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel',$commentLabel);

        //current comment history
        if (isset($approvedSections['partIII'][2]) && $approvedSections['partIII'][2] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 2, 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 2, 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mmsUserId',$this->Session->read('username'));
	        $this->set('mmsUserRole','applicant');
	        $this->set('sectionId','2');
        // } else if ($approvedSections['partI'][1] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);

		//

		$this->set('regNo', $regNo);
	    $this->set('userType',$userType);
        $this->set('part_no',$partNo);
		$this->set('section_no',$section);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);

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

		$this->render('/element/enduser/forms/product_manufacture_details');

		if($this->request->is('post')){

			if($this->request->getData('submit') == 'save_comment'){
				$result1 = $this->TblEndUserFinalSubmit->saveApplicantReply($this->request->getData());
				$result = $this->OProdDetails->saveFormDetails($this->request->getData());

				if($result1 == 1){
					$this->Session->write('mon_f_suc','Reply saved in <b>End-use Mineral Based Industries - II</b> successfully!');
					// $this->redirect(array('controller'=>'enduser','action'=>'productManufactureDetails'));
					$this->nextSection('productManufactureDetails', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Failed to saved reply <b>End-use Mineral Based Industries - II</b>! Please, try again later.');
					// $this->redirect(array('controller'=>'enduser','action'=>'productManufactureDetails'));
					$this->nextSection('productManufactureDetails', 'Enduser');
				}
			} else {
				$result = $this->OProdDetails->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>End-use Mineral Based Industries - II</b> successfully saved!');
					// $this->redirect(array('controller'=>'enduser','action'=>'productManufactureDetails'));
					$this->nextSection('productManufactureDetails', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Problem in saving <b>End-use Mineral Based Industries - II</b> details! Please, try again later.');
					$this->redirect(array('controller'=>'enduser','action'=>'productManufactureDetails'));
				}
			}

		}

    }


    // FORM M: PART III: Iron And Steel Industry
    public function ironSteelIndustries(){

		$this->viewBuilder()->setLayout('mc/form_layout');

        //==============================FIXED VARIABLES=========================
        $section = 3;
        $userType = 'C';
        $partNo = 'partIII';

        //=============CHECKING FOR THE ACTIVITY TYPE .. IF NOT END USE THEN REDIRECT WITH THE FLASH MESSAGE
        $activityType = $this->Session->read('activityType');
        if ($activityType != 'C') {
            // $this->getUser()->setFlash('errorMsg', 'Sorry, you are not authorized to view this section.');
            // $this->redirect('oSeries/generalParticulars');
			$this->autoRender = false;
			$this->Session->write('mon_f_err','Sorry, you are not authorized to view this section.');
			$this->redirect(array('controller'=>'enduser', 'action'=>'instruction'));
        }

        $endUserId = $this->Session->read('registration_code');
        $returnType = $this->Session->read('returnType');

        if ($returnType == 'MONTHLY') {
            $getDate = $this->Session->read('returnDate');
        } else {
            $getDate = $this->Session->read('returnYear');
			if(!$getDate){
                $tempDate = $this->Session->read('returnDate');
                $dateExplode = explode("-", $tempDate);
                $getDate = $dateExplode[0]."-".($dateExplode[0]+1);
            }
        }

        $formType = $this->Session->read('formType');
        $returnDatePeriod = $this->Clscommon->getDatePeriod($getDate, $returnType, " "); // Parameter date , return type , separator
        $returnDate = $this->Session->read('returnDate');
        $regNo = $this->Session->read('regNo');

        //==========================================================================

        $finalSubmitData = $this->Clscommon->getNOrOFinalSubmitData($section, $partNo, $userType);
        if ($finalSubmitData['count'] > 0) {
            $finalSubmitData = $finalSubmitData;
        } else {
            $finalSubmitData['countFlag'] = FALSE;
		}

        //==========================================================================

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $period = $returnYear . " - " . ($temp[0] + 1);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('iron_steel_industries', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId);

        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
        }

		// APPROVED / REJECTION SECTION
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

		$form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
		$section_mode = ($form_status != '') ? (($this->Session->read('sess_status') == 'referredback') ? 'read' : $form_status) : $form_status;

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
		$reasons_old = array();

        //old comment history
        $return_ids = $this->TblEndUserFinalSubmit->getReturnIdExceptLatest($endUserId, $returnDate, $returnType);
        if(count($return_ids) > 0){
            foreach($return_ids as $return_id){
                $reasons_old[] = $this->TblEndUserFinalSubmit->getReason($return_id['id'], 'partIII', 3, 'applicant');
            }
        }
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel',$commentLabel);

        //current comment history
        if (isset($approvedSections['partIII'][3]) && $approvedSections['partIII'][3] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 3, 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 3, 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mmsUserId',$this->Session->read('username'));
	        $this->set('mmsUserRole','applicant');
	        $this->set('sectionId','3');
        // } else if ($approvedSections['partI'][1] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);

		// section data
		$formFlagIndus = 2;
		$ironData = $this->OProdDetails->getAllData($formType, $returnType, $returnDate, $endUserId, $formFlagIndus);
		$this->set('ironData', $ironData);

		$this->set('regNo', $regNo);
	    $this->set('userType',$userType);
        $this->set('part_no',$partNo);
		$this->set('section_no',$section);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);

		$this->render('/element/enduser/forms/iron_steel_industries');

		if($this->request->is('post')){

			if($this->request->getData('submit') == 'save_comment'){
				$result1 = $this->TblEndUserFinalSubmit->saveApplicantReply($this->request->getData());
				$result = $this->OProdDetails->saveFormIronSteel($this->request->getData());

				if($result1 == 1){
					$this->Session->write('mon_f_suc','Reply saved in <b>Iron and Steel Industry</b> successfully!');
					// $this->redirect(array('controller'=>'enduser','action'=>'ironSteelIndustries'));
					$this->nextSection('ironSteelIndustries', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Failed to saved reply <b>Iron and Steel Industry</b>! Please, try again later.');
					// $this->redirect(array('controller'=>'enduser','action'=>'ironSteelIndustries'));
					$this->nextSection('ironSteelIndustries', 'Enduser');
				}
			} else {
				$result = $this->OProdDetails->saveFormIronSteel($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Iron and Steel Industry</b> successfully saved!');
					// $this->redirect(array('controller'=>'enduser','action'=>'ironSteelIndustries'));
					$this->nextSection('ironSteelIndustries', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Problem in saving <b>Iron and Steel Industry</b> details! Please, try again later.');
					$this->redirect(array('controller'=>'enduser','action'=>'ironSteelIndustries'));
				}
			}

		}

    }


    // FORM M: PART III: Raw Materials Consumed In Production
    public function rawMaterialConsumed(){

		$this->viewBuilder()->setLayout('mc/form_layout');

        //==============================FIXED VARIABLES=========================
        $section = 4;
        $userType = 'C';
        $partNo = 'partIII';

        //=============CHECKING FOR THE ACTIVITY TYPE .. IF NOT END USE THEN REDIRECT WITH THE FLASH MESSAGE
        $activityType = $this->Session->read('activityType');
        if ($activityType != 'C') {
            // $this->getUser()->setFlash('errorMsg', 'Sorry, you are not authorized to view this section.');
            // $this->redirect('oSeries/generalParticulars');
			$this->autoRender = false;
			$this->Session->write('mon_f_err','Sorry, you are not authorized to view this section.');
			$this->redirect(array('controller'=>'enduser', 'action'=>'instruction'));
        }

        $endUserId = $this->Session->read('registration_code');
        $returnType = $this->Session->read('returnType');

        if ($returnType == 'MONTHLY') {
            $getDate = $this->Session->read('returnDate');
        } else {
            $getDate = $this->Session->read('returnYear');
			if(!$getDate){
                $tempDate = $this->Session->read('returnDate');
                $dateExplode = explode("-", $tempDate);
                $getDate = $dateExplode[0]."-".($dateExplode[0]+1);
            }
        }

        $formType = $this->Session->read('formType');
        $returnDatePeriod = $this->Clscommon->getDatePeriod($getDate, $returnType, " "); // Parameter date , return type , separator
        $returnDate = $this->Session->read('returnDate');
        $regNo = $this->Session->read('regNo');

        //==========================================================================

        $finalSubmitData = $this->Clscommon->getNOrOFinalSubmitData($section, $partNo, $userType);
        if ($finalSubmitData['count'] > 0) {
            $finalSubmitData = $finalSubmitData;
        } else {
            $finalSubmitData['countFlag'] = FALSE;
		}

        //==========================================================================

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $period = $returnYear . " - " . ($temp[0] + 1);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('raw_material_consumed', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId);

        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
        }

		// APPROVED / REJECTION SECTION
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

		$form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
		$section_mode = ($form_status != '') ? (($this->Session->read('sess_status') == 'referredback') ? 'read' : $form_status) : $form_status;

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
		$reasons_old = array();

        //old comment history
        $return_ids = $this->TblEndUserFinalSubmit->getReturnIdExceptLatest($endUserId, $returnDate, $returnType);
        if(count($return_ids) > 0){
            foreach($return_ids as $return_id){
                $reasons_old[] = $this->TblEndUserFinalSubmit->getReason($return_id['id'], 'partIII', 4, 'applicant');
            }
        }
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel',$commentLabel);

        //current comment history
        if (isset($approvedSections['partIII'][4]) && $approvedSections['partIII'][4] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 4, 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 4, 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mmsUserId',$this->Session->read('username'));
	        $this->set('mmsUserRole','applicant');
	        $this->set('sectionId','4');
        // } else if ($approvedSections['partI'][1] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);

		$this->set('regNo', $regNo);
	    $this->set('userType',$userType);
        $this->set('part_no',$partNo);
		$this->set('section_no',$section);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);

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

		$this->render('/element/enduser/forms/raw_material_consumed');

		if($this->request->is('post')){

			if($this->request->getData('submit') == 'save_comment'){
				$result1 = $this->TblEndUserFinalSubmit->saveApplicantReply($this->request->getData());
				$result = $this->ORawMatConsume->saveFormDetails($this->request->getData());

				if($result1 == 1){
					$this->Session->write('mon_f_suc','Reply saved in <b>Iron and Steel Industry</b> successfully!');
					// $this->redirect(array('controller'=>'enduser','action'=>'rawMaterialConsumed'));
					$this->nextSection('rawMaterialConsumed', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Failed to saved reply <b>Iron and Steel Industry</b>! Please, try again later.');
					// $this->redirect(array('controller'=>'enduser','action'=>'rawMaterialConsumed'));
					$this->nextSection('rawMaterialConsumed', 'Enduser');
				}
			} else {
				$result = $this->ORawMatConsume->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Iron and Steel Industry</b> successfully saved!');
					// $this->redirect(array('controller'=>'enduser','action'=>'rawMaterialConsumed'));
					$this->nextSection('rawMaterialConsumed', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Problem in saving <b>Iron and Steel Industry</b> details! Please, try again later.');
					$this->redirect(array('controller'=>'enduser','action'=>'rawMaterialConsumed'));
				}
			}

		}

    }


    // FORM M: PART III: SOURCE OF SUPPLY
    public function sourceOfSupply(){

		$this->viewBuilder()->setLayout('mc/form_layout');

        //==============================FIXED VARIABLES=========================
        $section = 5;
        $userType = 'C';
        $partNo = 'partIII';

        //=============CHECKING FOR THE ACTIVITY TYPE .. IF NOT END USE THEN REDIRECT WITH THE FLASH MESSAGE
        $activityType = $this->Session->read('activityType');
        if ($activityType != 'C') {
            // $this->getUser()->setFlash('errorMsg', 'Sorry, you are not authorized to view this section.');
            // $this->redirect('oSeries/generalParticulars');
			$this->autoRender = false;
			$this->Session->write('mon_f_err','Sorry, you are not authorized to view this section.');
			$this->redirect(array('controller'=>'enduser', 'action'=>'instruction'));
        }

        $endUserId = $this->Session->read('registration_code');
        $returnType = $this->Session->read('returnType');

        if ($returnType == 'MONTHLY') {
            $getDate = $this->Session->read('returnDate');
        } else {
            $getDate = $this->Session->read('returnYear');
			if(!$getDate){
                $tempDate = $this->Session->read('returnDate');
                $dateExplode = explode("-", $tempDate);
                $getDate = $dateExplode[0]."-".($dateExplode[0]+1);
            }
        }

        $formType = $this->Session->read('formType');
        $returnDatePeriod = $this->Clscommon->getDatePeriod($getDate, $returnType, " "); // Parameter date , return type , separator
        $returnDate = $this->Session->read('returnDate');
        $regNo = $this->Session->read('regNo');

        //==========================================================================

        $finalSubmitData = $this->Clscommon->getNOrOFinalSubmitData($section, $partNo, $userType);
        if ($finalSubmitData['count'] > 0) {
            $finalSubmitData = $finalSubmitData;
        } else {
            $finalSubmitData['countFlag'] = FALSE;
		}

        //==========================================================================

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $period = $returnYear . " - " . ($temp[0] + 1);

		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('source_of_supply', $lang);

		$this->setEnduserMenus($formType, $returnType, $returnDate, $endUserId);

        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
        }

		// APPROVED / REJECTION SECTION
		$is_rejected_section = false;
		$isMineOwner = false;
		$is_all_approved = false;

		$form_status = (null !== $this->Session->read('form_status')) ? $this->Session->read('form_status') : '';
		$section_mode = ($form_status != '') ? (($this->Session->read('sess_status') == 'referredback') ? 'read' : $form_status) : $form_status;

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
		$reasons_old = array();

        //old comment history
        $return_ids = $this->TblEndUserFinalSubmit->getReturnIdExceptLatest($endUserId, $returnDate, $returnType);
        if(count($return_ids) > 0){
            foreach($return_ids as $return_id){
                $reasons_old[] = $this->TblEndUserFinalSubmit->getReason($return_id['id'], 'partIII', 5, 'applicant');
            }
        }
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel',$commentLabel);

        //current comment history
        if (isset($approvedSections['partIII'][5]) && $approvedSections['partIII'][5] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 5, 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblEndUserFinalSubmit->getReason($return_id, 'partIII', 5, 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mmsUserId',$this->Session->read('username'));
	        $this->set('mmsUserRole','applicant');
	        $this->set('sectionId','5');
        // } else if ($approvedSections['partI'][1] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);

		$this->set('regNo', $regNo);
	    $this->set('userType',$userType);
        $this->set('part_no',$partNo);
		$this->set('section_no',$section);

		$this->set('label',$labels);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formType', $formType);
		$this->set('endUserId', $endUserId);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);

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


		$this->render('/element/enduser/forms/source_of_supply');

		if($this->request->is('post')){

			if($this->request->getData('submit') == 'save_comment'){
				$result = $this->OSourceSupply->saveFormDetails($this->request->getData());
				$result1 = $this->TblEndUserFinalSubmit->saveApplicantReply($this->request->getData());

				if($result1 == 1){
					$this->Session->write('mon_f_suc','Reply saved in <b>Source of Supply</b> successfully!');
					// $this->redirect(array('controller'=>'enduser','action'=>'sourceOfSupply'));
					$this->nextSection('sourceOfSupply', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Failed to saved reply <b>Source of Supply</b>! Please, try again later.');
					// $this->redirect(array('controller'=>'enduser','action'=>'sourceOfSupply'));
					$this->nextSection('sourceOfSupply', 'Enduser');
				}
			} else {
				$result = $this->OSourceSupply->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Source of Supply</b> successfully saved!');
					// $this->redirect(array('controller'=>'enduser','action'=>'sourceOfSupply'));
					$this->nextSection('sourceOfSupply', 'Enduser');
				} else {
					$this->Session->write('mon_f_err','Problem in saving <b>Source of Supply</b> details! Please, try again later.');
					$this->redirect(array('controller'=>'enduser','action'=>'sourceOfSupply'));
				}
			}

		}

    }


	//set enduser form sidebar menus and progress bar variables
	public function setEnduserMenus($formType, $returnType, $returnDate, $endUserId){

		$this->Customfunctions->enduserSectionFillStatus($formType, $returnType, $returnDate, $endUserId);
		$finalSubmitBtnStatus = $this->Customfunctions->finalSubmitButtonEndUser();

		$this->set('final_submit_button', $finalSubmitBtnStatus);
        $partIIM1 = array();
        $partIIM1[0] = null;
        $partIIM1[1] = null;
        $partIIM1['formNo'] = null;
        $this->set('partIIM1', $partIIM1);
        $this->set('is_hematite', false);
        $this->set('partIIMOther', array());
		$this->set('tableForm', null);
		$activityType = $this->Session->read('activityType');
		$this->set('sectionType', $activityType);
		$this->set('mineCode', $endUserId);
		$this->set('mineral', null);
		$this->set('sub_min', null);

		$return_id = (null !== $this->Session->read('return_id')) ? $this->Session->read('return_id') : "";
		$this->set('return_id', $return_id);

		$replyStatus = $this->TblEndUserFinalSubmit->checkReplyStatus($endUserId, $returnType, $returnDate);
		$this->set('replyStatus', $replyStatus);

	}

    /**
     * GET NEXT SECTION LINK FOR REDIRECTION PURPOSE
     * @version 01st APR 2021
	 * @author Aniket Ganvir
     */
    public function findNextSection($section_url){

    	$sec_link = $this->Session->read('sec_link');

    	$part_no = '1';
    	foreach($sec_link as $min){
    		foreach($min as $key => $val){
    			if($val == $section_url){
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
    	return $data;

    }

    /**
     * FINAL SUBMIT VALIDATIONS AND SAVING
     * @addedon: 14th JUL 2021 (by Aniket Ganvir)
     */
    public function finalSubmit(){

    	$this->autoRender = false;

        $user = $this->Session->read('username');
		$endUserId = $this->Session->read('registration_code');
		$uniqueRegNO = $this->Session->read('regNo');
		$returnType = $this->Session->read('returnType');
		$activityType = $this->Session->read('activityType');
		if($returnType == 'MONTHLY')
		{
		   $getDate = $this->Session->read('returnDate');
		}
		else{
			$getDate = $this->Session->read('returnYear');
		}
		$formType = $this->Session->read('formType');
		$returnDatePeriod = $this->Clscommon->getDatePeriod($getDate, $returnType, " "); // Parameter date , return type , separator
		$returnDate = $this->Session->read('returnDate');

		//==========================================================================

		$temp = explode('-', $returnDate);
		$returnYear = $temp[0];
		$period = $returnYear . " - " . ($temp[0] + 1);

		//check is rejected or approved section
		// $approvedSections = $this->Session->read('approved_sections');
		// $rejectedReasons = $this->Session->read('rejected_reasons');

		// if ($approvedSections['partII'][2] == "Rejected") {
		// 	$is_rejected_section = 1;
		// 	$rejected_reason = $rejectedReasons['partII'][2];
		// } else if ($approvedSections['partII'][2] == "Approved") {
		// 	$is_rejected_section = 2;
		// }

		$mineralData = $this->NSeriesProdActivity->getSeriesActivityDetails($formType, $returnType, $returnDate, $endUserId, 4);
		$gradeforMineral = array();

		foreach ($mineralData as $n) {
			$gradeforMineral[] = $this->ExtraNSeriesProdActivity->getSeriesExtraActivityDetails($returnType, $returnDate, $endUserId, $n['local_mineral_code'], $n['local_grade_code'], 4);
		}
		$this->mineralsData = json_encode($mineralData);
		$this->gradeforMineral = json_encode($gradeforMineral);


		//=======================CHECKING GENERAL PARTICULARS=======================
		// NEED TO CREATE THE TABLE
		//    $generalParticular = '';
		$generalParticular = '1';


		/**
		 * VALIDATING SECTION AS PER USER'S ACTIVITY TYPE (PHASE-II)
		 * @version 20th JUL 2021
		 * @author Aniket Ganvir
		 */
		$userType = $this->Session->read('activityType');
		$userType = ($userType == 'W') ? 'T' : $userType; // Set $userType 'T' for "Trader without storage" user
		$sectionActivity = $this->NSeriesProdActivity->checkForValue($formType, $returnType, $returnDate, $endUserId, $userType);

		//commented following Phase-I validations
		//========================CHECKING TRADING ACTIVITY=========================
		// $tradingUserType = 'T';
		// $tradingActivity = $this->NSeriesProdActivity->checkForValue($formType, $returnType, $returnDate, $endUserId, $tradingUserType);

		// //==========================CHECKING EXPORT OF ORE==========================
		// $exportUserType = 'E';
		// $oreExport = $this->NSeriesProdActivity->checkForValue($formType, $returnType, $returnDate, $endUserId, $exportUserType);

		// //======================CHECKING MINERAL BASED ACTIVITY=====================
		// $mineralUserType = 'C';
		// $mineralActivity = $this->NSeriesProdActivity->checkForValue($formType, $returnType, $returnDate, $endUserId, $mineralUserType);

		// //==========================CHECKING STORAGE ACTIVITY=======================
		// $storageUserType = 'S';
		// $storageActivity = $this->NSeriesProdActivity->checkForValue($formType, $returnType, $returnDate, $endUserId, $storageUserType);

		//====================CHECKING FOR ERROR IN ALL ABOVE PAGES=================
		$nFormError = Array();
		if ($generalParticular == 0) {
		$nFormError[] = "Please enter General Particular details";
		}

		if ($sectionActivity == 0) {
			$sectionName = $this->Clscommon->userTypeFullForm($userType);
			$nFormError[] = "Please enter ".$sectionName." details";
		}

		//commented following Phase-I validations
		// if ($tradingActivity == 0) {
		// $nFormError[] = "Please enter Trading Activity details";
		// }
		// if ($oreExport == 0) {
		// $nFormError[] = "Please enter Ore Export details";
		// }
		// if ($mineralActivity == 0) {
		// $nFormError[] = "Please enter Mineral Acivity Details";
		// }
		// if ($storageActivity == 0) {
		// $nFormError[] = "Please enter storage Activity Details";
		// }

		// FORM M VALIDATIONS
		if ($returnType == 'ANNUAL') {
			if ($activityType == 'C') {

				// optionalItemCheck
				//============END-USE MINERAL BASED INDUXTRIES-II===========
				//                $mineral_name = 'SILVER';
				$formFlag = 1;
				$exsistanceCheck2 = $this->OProdDetails->checkRecordForFinalSubmit($formType, $returnType, $returnDate, $endUserId, $formFlag);

				//====================IRON AND STEEL INDUSTRY===============
				$formFlagTwo = 2;
				$exsistanceCheck5 = $this->OProdDetails->checkRecordForFinalSubmit($formType, $returnType, $returnDate, $endUserId, $formFlagTwo);

				$item3Check = $exsistanceCheck2;
				$item4Check = $exsistanceCheck5;
				if ($item3Check == 0 && $item4Check == 0) {
					$nFormError[] = "Either 'End-Use mineral based activity-II' or 'Iron and Steel industry' or both must be filled. Currently both of them are empty. Without filling either one of them or both you can't proceed.";
				}

				// checkRawVsSource
				$exsistanceCheck3 = $this->ORawMatConsume->getRecordIdNew($formType, $returnType, $returnDate, $endUserId, $userType);
				$exsistanceCheck4 = $this->OSourceSupply->getRecordId($formType, $returnType, $returnDate, $endUserId, $userType);
				/**
				 * CHANGED THE ARRAY PARAMETER FROM count to status
				 */
				$checkRawMaterial = $exsistanceCheck3['status'];
				$checkSourceOfSuply = $exsistanceCheck4['status'];

				if ($checkRawMaterial != $checkSourceOfSuply) {
					$nFormError[] = "Either one of form 'Raw Metarial Consumed in Production' OR 'Source of Supply' not filled. Kindly fill both of them or none of them then proceed.";
				}

				// form validation
				//============================END-USE MINERAL BASED INDUXTRIES-I============
				$exsistanceCheck1 = $this->OMineralIndustryInfo->getRecordIdNew('O', $returnType, $returnDate, $endUserId, $userType);

				//============================END-USE MINERAL BASED INDUXTRIES-II===========
				// $mineral_name = 'SILVER';
				$formFlag = 1;
				$exsistanceCheck2 = $this->OProdDetails->checkRecordForFinalSubmit($formType, $returnType, $returnDate, $endUserId, $formFlag);

				//============================ RAW MATERIALS CONSUMED IN PRODUCTION=========
				$exsistanceCheck3 = $this->ORawMatConsume->getRecordIdNew($formType, $returnType, $returnDate, $endUserId, $userType);

				//=================================== SOURCE OF SUPPLY======================
				$exsistanceCheck4 = $this->OSourceSupply->getRecordId($formType, $returnType, $returnDate, $endUserId, $userType);

				//============================IRON AND STEEL INDUSTRIES===========
				// $mineral_name = 'IRON ORE';
				$formFlagTwo = 2;
				$exsistanceCheck5 = $this->OProdDetails->checkRecordForFinalSubmit($formType, $returnType, $returnDate, $endUserId, $formFlagTwo);


				if ($exsistanceCheck1 == 0) {
					$nFormError[] = "Please enter end-user mineral based industries-I details";
				}
				if ($exsistanceCheck2 == 0 && $exsistanceCheck5 == 0) {
					$nFormError[] = "Either 'End-Use mineral based activity-II' or 'Iron and Steel industry' or both must be filled. Currently both of them are empty. Without filling either one of them or both you can't proceed.";
				}
				// if ($exsistanceCheck5 == 0) {
				// 	$oFormError[] = "Please enter Iron and steel industry";
				// }
				// print_r($exsistanceCheck3);
				// print_r($exsistanceCheck4);
				// die;
				if ($exsistanceCheck3 == 0) {
					$nFormError[] = "Please enter raw materials consumed in production details";
				}
				if ($exsistanceCheck4 == 0) {
					$nFormError[] = "Please enter source of supply details";
				}

			}
		}


		//==========================================================================
		//=======================CHECK THE ERROR MESSAGE ARRAY======================

		if (count($nFormError) == 0) {
			//primary form no
			// $primaryMineral = $this->mineMinerals[0];
			// $primaryFormNo = DIR_MCP_MINERALTable::getFormNumber($primaryMineral);
			// not to be use -- uday
			// $remove_record = TBL_FINAL_SUBMITTable::removeFinalSubmit($this->app_id, $this->submitted_by, $this->returnDate);

		   //$this->userId = $this->getUser()->getAttribute('mcu_user_id');

			/**
			 * @author Uday Shankar Singh <usingh@ubicsindia.com>
			 * FOR SAVING THE RECORD IN TBL_FINAL_SUBMIT TABLE
			 */
	        //  print_r(serialize($this->getUser()->getAttribute('replied_section_remarks')));
	        //  die;
			echo '';
			exit;
			/* commented below code cause we shift it after successfull e-signing
			$update_record = $this->TblEndUserFinalSubmit->updateLastSubmittedRecord($endUserId, $endUserId, $returnDate, $returnType);

			$newEntity = $this->TblEndUserFinalSubmit->newEntity(array(
				'applicant_id'=>$endUserId,
				'submitted_by'=>$endUserId,
				'ibm_unique_reg_no'=>htmlentities($uniqueRegNO, ENT_QUOTES),
				'return_date'=>$returnDate,
				'return_type'=>$returnType,
				// 'replied_section_remarks'=>htmlentities(serialize($this->getUser()->getAttribute('replied_section_remarks')), ENT_QUOTES);
				'verified_flag'=>0,
				'status'=>0,
				'form_type'=>$formType,
				'status_date'=>date('Y-m-d'),
				'created_at'=>date('Y-m-d H:i:s'),
				'is_latest'=>1
			));
			$this->TblEndUserFinalSubmit->save($newEntity);

			// send sms
			$customer_id = $_SESSION['username'];
			$this->loadModel('DirSmsEmailTemplates');
			// $this->DirSmsEmailTemplates->sendMessage(8,$customer_id);
			*/

			// $recordId = $this->endUserId;
			// $checkRecordExistence = TBL_ALLOCATION_N_O_DETAILS::checkRecordExistence($recordId);
			// if($checkRecordExistence == 0) {
			// 	$allocationObj = new TBL_ALLOCATION_N_O_DETAILS();
			// 	$allocationObj->REGISTRATION_CODE = $recordId;
			// 	$allocationObj->PRI_FLAG = 'n';
			// 	$allocationObj->SUP_FLAG = 'n';
			// 	$allocationObj->NOFlag = $this->formType;
			// 	$allocationObj->save();
			// }

		}

		if (count($nFormError) > 0) {
			$errors = implode('|', $nFormError);
			echo $errors;
		}

    }

    public function rejectedReturns($returnType = 'MONTHLY'){

		$this->viewBuilder()->setLayout('mc_panel');

		$this->set('returnType',$returnType);

	    // PAGINATION IMPLEMENTAION
	    // $this->limit = 10;
	    // $page_no = $this->getRequestParameter('page');
	    // $this->page = (int) (!isset($page_no) ? 1 : $page_no);
	    // for making the symfony recognize url_for()
	    // sfProjectConfiguration::getActive()->loadHelpers(Array('Url', 'Tag'));
	    // $this->url = url_for("monthly/rejectedReturns")."?return_type=".$this->returnType."&";
	    // $this->startpoint = ($this->page * $this->limit) - $this->limit;


	    $is_mine_owner = $this->Session->read('is_mine_owner');
	    $owner_id = $this->Session->read('username');
	    $userId = $this->Session->read('username');

	    $temp = explode('/', $userId);
	    $app_id = $temp[0] . "/" . $temp[1];

	    if (count($temp) == 3){
	      $submitted_by = $temp[2];
	    } else {
	      $submitted_by = $app_id;
	    }


		/**
		 * ADDED MINE ONWER FALSE FLAG
		 * CHANGES ARE AS PER THE THE RELEASE VERSION FROM NAGPUR
		 *
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 21st Jan 2014
		 */
		$mineOwner = FALSE;
		if($is_mine_owner == true) {
			// CHANGED TO IMPLEMENT THE PAGINATION
			$temp = $this->TblFinalSubmit->getRejectedReturnsOwner($owner_id, $returnType);
			$totalRecords = count($temp);

			// $data = Array();
			// foreach ($temp as $key => $value) {
			// if ($key >= $startpoint && $key < ($startpoint + $limit))
			//   $data[$key] = $value;
			// }
			// $returns = $data;
			$returns = $temp;
			$mineOwner = TRUE; // AS SAME FORM (viewAllReturnSuccess.php) is used now for both mine Owner and applicant so this flag will help to
	                            // redirect the applicant to edit form and mine owner to print all page of reffered back

	    } else {
			$temp = $this->TblFinalSubmit->getRejectedReturns($app_id, $submitted_by, $returnType);
			$totalRecords = count($temp);

			// $data = Array();
			// foreach ($temp as $key => $value) {
			// if ($key >= $startpoint && $key < ($startpoint + $limit))
			//   $data[$key] = $value;
			// }
			// $returns = $data;
			$returns = $temp;
	    }

	    $this->set('returns',$returns);
	    $this->set('mineOwner',$mineOwner);


	    if (count($returns) == 0){
	      // $this->getUser()->setFlash('errorMsg', 'No Returns Found!');
	    	echo 'No Returns Found!';
	    }

    }

    public function redirectRejectedReturns($returnId){

        //remove the approved sections and rejected remarks if set already
        $this->Session->delete('approved_sections');
        $this->Session->delete('rejected_reasons');

        $rejected_return_id = base64_decode($returnId);
        $return = $this->TblFinalSubmit->findReturnById($rejected_return_id);

        $mineCode = $return['mine_code'];
        $returnDate = $return['return_date'];
        $returnType = $return['return_type'];

        // below added code add by ganesh satav because solve the serial no and rule no issue.
        // below set the form type value and minaral name in the session
        // added on the date 2 july 2014
        // start code

        // $formTypevalue = $this->Session->read('mc_form_type');
        // if($formTypevalue=='')
        // {
         $mineralWorked = $this->MineralWorked->getMineralName($mineCode);
        //set minerals as session
        $this->Session->write('mc_mineral', $mineralWorked);

        $formType = $this->DirMcpMineral->getFormNumber($mineralWorked);
        //set Form type as session
        $this->Session->write('mc_form_type', $formType);
        // }
        // end code

        $status = $return['status'];
        if ($status == 3){
            $this->Session->write('is_all_approved', true);
        } else {
            $this->Session->write('is_all_approved', false);
        }

        $tmpSections = $return['approved_sections'];
        $approvedSections = unserialize($tmpSections);

        $tmpReasons = $return['rejected_section_remarks'];
        $rejectedReasons = unserialize($tmpReasons);

        $temp = explode('-', date('Y-m-d',strtotime($returnDate)));
        $year = $temp[0];
        $month = $temp[1];

        $rejected_sections = $this->Session->write('approved_sections', $approvedSections);
        $rejected_sections = $this->Session->write('rejected_reasons', $rejectedReasons);

        $this->Session->write('returnDate', date('Y-m-d', strtotime($returnDate)));
        $this->Session->write('returnType', $returnType);
        $this->Session->write('mc_sel_month', $month);
        $this->Session->write('mc_sel_year', $year);
        $this->Session->write('form_status','referred_back');
        $this->Session->write('return_id',$rejected_return_id);

        $this->redirect(array('controller'=>'monthly','action'=>'mine'));

    }


    /**
     * UPDATE APPLICANT COMMUNICATION REPLY THROUGH AJAX CALL
     * @addedon: 16th JUL 2021 (by Aniket Ganvir)
     */
    public function updateComment(){

    	$this->autoRender = false;

		if($this->request->is('post')){

			$return_id = $this->request->getData('returnId');
			$result = $this->TblEndUserFinalSubmit->saveApplicantReply($this->request->getData(),$return_id);
			echo $result;

		}

    }

    /**
     * REMOVE APPLICANT COMMUNICATION REPLY THROUGH AJAX CALL
     * @addedon: 16th JUL 2021 (by Aniket Ganvir)
     */
    public function removeComment(){

    	$this->autoRender = false;

		if($this->request->is('post')){

			$result = $this->TblEndUserFinalSubmit->remReply($this->request->getData());
			echo $result;

		}

    }

    /**
     * FINAL SUBMIT AFTER REFERRED BACK FROM SUPERVISOR
     * @addedon: 16th JUL 2021 (by Aniket Ganvir)
     */
    public function finalSubmitRef(){

    	$this->autoRender = false;

			if($this->request->is('post')){
				
				// send sms
				$customer_id = $_SESSION['username'];
				$this->loadModel('DirSmsEmailTemplates');
				//$this->DirSmsEmailTemplates->sendMessage(8,$customer_id);

				$result = $this->TblEndUserFinalSubmit->finalSubmitRef($this->request->getData());
				echo $result;

			}
    }

    /**
     * REDIRECT TO THE NEXT SECTION
     * @addedon: 16TH JUL 2021 (by Aniket Ganvir)
     */
	public function nextSection($action_name,$cntrl = null,$mineral = null,$sub_min = null){

		$section_url = '/enduser/'.$action_name;

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
     * @addedon: 29th APR 2021 (by Aniket Ganvir)
     */
	public function prevSection($action_name,$cntrl = null,$mineral = null,$sub_min = null){

		$section_url = '/enduser/'.$action_name;
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

	public function getAppId(){

		$this->autoRender = false;

		if($this->request->is('post')){

			$result = $this->McApplicantDet->getRegNo($this->request->getData());
			echo $result;

		}

	}

	public function getPrevClosingStocks(){

		$this->autoRender = false;

	}

	public function changeLanguage(){

		$this->autoRender = false;
		$cur_lang = $this->Session->read('lang');
		if($cur_lang == 'english'){

			$new_lang = 'hindi';

		} else {
			$new_lang = 'english';
		}

		$this->Session->write('lang',$new_lang);

	}
	//get mineral code by shalini date : 12/01/2022
	public function getMineCode()
	{
		$this->autoRender = false;

		if($this->request->is('post')){

			$result = $this->MineralWorked->getMineCode($this->request->getData());
			echo $result;

		}
	}//end


}
