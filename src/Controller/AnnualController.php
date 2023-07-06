<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Network\Email\Email;
use Cake\ORM\Entity;
use Cake\ORM\Locator\LocatorAwareTrait;

class AnnualController extends AppController{
		
	var $name = 'Annual';
	var $uses = array();
	
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);
		$this->userSessionExits();
	}
	
    public function initialize(): void {

        parent::initialize();
		$this->loadComponent('Createcaptcha');
		$this->loadComponent('Authentication');
		$this->loadComponent('Customfunctions');
		$this->loadComponent('Formcreation');
		$this->loadComponent('Clscommon');
		$this->loadComponent('Language');
		$this->viewBuilder()->setHelpers(['Form','Html']);
		$this->Session = $this->getRequest()->getSession();
		$this->CapitalStructure = $this->getTableLocator()->get('CapitalStructure');
		$this->CostProduction = $this->getTableLocator()->get('CostProduction');
		$this->DirMachinery = $this->getTableLocator()->get('DirMachinery');
		$this->DirMcpMineral = $this->getTableLocator()->get('DirMcpMineral');
		$this->DirWorkStoppage = $this->getTableLocator()->get('DirWorkStoppage');
		$this->Employment = $this->getTableLocator()->get('Employment');
		$this->ExplorationDetails = $this->getTableLocator()->get('ExplorationDetails');
		$this->ExplosiveConsumption = $this->getTableLocator()->get('ExplosiveConsumption');
		$this->ExplosiveReturn = $this->getTableLocator()->get('ExplosiveReturn');
		$this->GradeProd = $this->getTableLocator()->get('GradeProd');
		$this->LeaseReturn = $this->getTableLocator()->get('LeaseReturn');
		$this->Machinery = $this->getTableLocator()->get('Machinery');
		$this->MaterialConsumption = $this->getTableLocator()->get('MaterialConsumption');
		$this->McpLease = $this->getTableLocator()->get('McpLease');
		$this->McUser = $this->getTableLocator()->get('McUser');
		$this->Mine = $this->getTableLocator()->get('Mine');
		$this->MineralWorked = $this->getTableLocator()->get('MineralWorked');
		$this->OverburdenWaste = $this->getTableLocator()->get('OverburdenWaste');
		$this->Prod1 = $this->getTableLocator()->get('Prod1');
		$this->Prod5 = $this->getTableLocator()->get('Prod5');
		$this->Pulverisation = $this->getTableLocator()->get('Pulverisation');
		$this->RecovSmelter = $this->getTableLocator()->get('RecovSmelter');
		$this->RentReturns = $this->getTableLocator()->get('RentReturns');
		$this->Reserves = $this->getTableLocator()->get('Reserves');
		$this->ReservesResources = $this->getTableLocator()->get('ReservesResources');
		$this->Rom5 = $this->getTableLocator()->get('Rom5');
		$this->RomMetal5 = $this->getTableLocator()->get('RomMetal5');
		$this->RomStone = $this->getTableLocator()->get('RomStone');
		$this->Sale5 = $this->getTableLocator()->get('Sale5');
		$this->SubgradeMineralReject = $this->getTableLocator()->get('SubgradeMineralReject');
		$this->TblAllocationDetails = $this->getTableLocator()->get('TblAllocationDetails');
		$this->TblFinalSubmit = $this->getTableLocator()->get('TblFinalSubmit');
		$this->TblMinWorked = $this->getTableLocator()->get('TblMinWorked');
		$this->TreesPlantSurvival = $this->getTableLocator()->get('TreesPlantSurvival');
		$this->WorkStoppage = $this->getTableLocator()->get('WorkStoppage');

		if(null == $this->getRequest()->getSession()->read('lang')) {
			$this->getRequest()->getSession()->write('lang','english');
		}
		
		$this->Customfunctions->formReturnTitle();

    }
	
	/**
	 * FILE ANNUAL RETURNS
	 */
	public function selectReturn() {

		$this->viewBuilder()->setLayout('mc_panel');
		
		if (null !== $this->Session->read('mc_form_type') && $this->Session->read('mc_form_type') == 6) {
			$this->redirect(array('controller'=>'auth', 'action'=>'home'));
		}
		
		$this->Session->delete('is_all_approved');
		
		// get pending return years for filing annual return (G Series)
		$mineCode = $this->Session->read('mc_mine_code');
		$annualFileReturn = $this->TblFinalSubmit->getAnnualFileReturnYear($mineCode);
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
				$alert_redirect_url = 'selectReturn';

			} else {

                $returnDate = $returnYear . "-04-01";
                $returnType = "ANNUAL";

				$finalSubmiStatus = $this->checkFinalSubmit($returnDate);

				if($finalSubmiStatus == true){

					$alert_message = "Annual return has been already submitted for this year.";
					$alert_redirect_url = 'selectReturn';

				} else {

					$this->Session->write('mc_sel_year', $returnYear);
					$this->Session->write('returnDate', date('Y-m-d', strtotime($returnDate)));
					$this->Session->write('returnType', $returnType);
					$this->redirect('/monthly/mine');

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
	public function checkFinalSubmit($returnDate) {

		$user_id = $this->Session->read('username');
		$user = $this->McUser->getUserDatabyId($user_id);
		$mineCode = $user['mcu_mine_code'];

		$result = false;

		$is_final_submitted = $this->TblFinalSubmit->checkIsSubmitted($mineCode, $returnDate, 'ANNUAL');

		if ($is_final_submitted == true) {
			$result = true;
		}

		return $result;
	}

	
    // PART I: PARTICULARS OF AREA OPERATED
    public function particulars(){

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('particulars', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label',$labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //rent details edit form
        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partI', 3, '', 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partI'][3])) && $approvedSections['partI'][3] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partI', 3, '', 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partI', 3, '', 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral','');
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('sectionId','3');
	        $this->set('part_no','partI');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
		//==============================CONSUMING WEB SERVICE=======================
		//consume the list of minecodes and minenames of the mine owner
		$mineOwner = $this->Session->read('parentid');
		$applicantMinesDetails = $this->McpLease->getApplicantMinesDetails($mineOwner, $mineCode);

		// $loadUrl = $data;
		// try{
		// 	$ch = curl_init();
		// 	curl_setopt($ch, CURLOPT_URL, $loadUrl);
		// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
		// 	curl_setopt($ch, CURLOPT_HEADER, false);
		// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// 	$output = curl_exec($ch);
		// 	curl_close($ch);

		// 	$xmlTree = new SimpleXMLElement($output);
		// 	$xml = (array) $xmlTree;
		// }
		// catch(Exception $e) {
		// 	unset($xml);
		// }
		// function objectToArray($object) {
		// 	if (!is_object($object) && !is_array($object)) {
		// 		return $object;
		// 	}
		// 	if (is_object($object)) {
		// 		$object = get_object_vars($object);
		// 	}
		// 	return array_map('objectToArray', $object);
		// }

		//print_r($applicantMinesDetails); exit;

		// $mineData = objectToArray($xml);
		$mineData = $applicantMinesDetails;
		// $mine_data = array();
		// foreach ($mineData['complexMinesDetails'] as $m) {
		foreach ($mineData as $m) {
			$mineral_sep_name = $this->MineralWorked->getSnCalMineralName($m['mcm_mine_code']);
			$mine_codes[] = $m['mcm_mine_code'];
			// $mine_data[$m['mcmd_mine_name'] . " - " . $m['mcm_mine_code'] . " - " . $mineral_sep_name] = $m['mcmd_mine_name'] . " - " . $m['mcm_mine_code'] . " - " . $mineral_sep_name;
			$mine_data[$m['mcm_mine_desc'] . " - " . $m['mcm_mine_code'] . " - " . $mineral_sep_name] = $m['mcm_mine_desc'] . " - " . $m['mcm_mine_code'] . " - " . $mineral_sep_name;
		}
		
		if(count($mine_data) < 2){
			$mine_data = array();
		}
		//this session is used in the drop down box
		$this->Session->write('mine_data', $mine_data);
		
		//check if the form is already submitted by any other second level user
		//if so, dont allow him to save by disabling the Save&Next button
		$filedMines = $this->CapitalStructure->getFiledMines($mineOwner, $returnDate);
		// $unFiledMines = array_diff($mine_codes, $filedMines);
		//append the minecodes for the rest of the user
		
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1 = $this->Clscommon->getFormRuleNumber($form_count);
		
		$particularsDetails = $this->McpLease->getParticularsDetails($mineCode, $returnYear);
		$particulars = $particularsDetails;

		$max_date = ($returnYear + 1).'-03-01';
		$max_date = date('Y-m-t', strtotime($max_date));

		$this->set('mine_data', $mine_data);
		$this->set('particulars', $particulars);
		$this->set('max_date', $max_date);


		$this->render('/element/annual/particulars');

		if($this->request->is('post')){

            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->McpLease->saveFormDetails($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Particualrs of Area Operated</b> successfully!');
					$this->redirect(array('controller'=>'annual','action'=>'area_utilisation'));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Particualrs of Area Operated</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'particulars'));
                }
            } else {
				$result = $this->McpLease->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Particualrs of Area Operated</b> successfully saved!');
					$this->redirect(array('controller'=>'annual','action'=>'area_utilisation'));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Particualrs of Area Operated</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'particulars'));
				}
            }
		}

    }
	
    // PART I: LEASE AREA UTILISATION
    public function areaUtilisation(){

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('area_utilisation', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partI', 4, '', 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partI'][4])) && $approvedSections['partI'][4] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partI', 4, '', 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partI', 4, '', 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral','');
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partI');
	        $this->set('sectionId','4');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1 = $this->Clscommon->getFormRuleNumber($form_count);
		
		$lease = $this->LeaseReturn->getLeaseData($mineCode, $returnDate);
		$owner = $this->Mine->getMineOwnerDetails($mineCode);

		$agency_choices = $this->Clscommon->leaseAreaAgencyOptions($lang);

		$this->set('lease', $lease);
		$this->set('agency_choices', $agency_choices);


		$this->render('/element/annual/area_utilisation');

		if($this->request->is('post')){

            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->LeaseReturn->saveFormDetails($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Lease Area Utilisation</b> successfully!');
					$this->redirect(array('controller'=>'annual','action'=>'employment_wages'));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Lease Area Utilisation</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'area_utilisation'));
                }
            } else {
				$result = $this->LeaseReturn->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Lease Area Utilisation</b> successfully saved!');
					$this->redirect(array('controller'=>'annual','action'=>'employment_wages'));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Lease Area Utilisation</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'area_utilisation'));
				}
            }
		}

    }
	
    // PART II: EMPLOYMENT & WAGES I
    public function employmentWages(){

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('employment_wages', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partII', 1, '', 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partII'][1])) && $approvedSections['partII'][1] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partII', 1, '', 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partII', 1, '', 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral','');
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partII');
	        $this->set('sectionId','1');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);
		
		$formType = 1;
		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();
		$reasonsLen = count($reasonsArr);
		$empWages = $this->RentReturns->getAllData($mineCode, $returnType, $returnDate, $formType);
        $workData = $this->WorkStoppage->fetchWorkingDetails($mineCode, $returnType, $returnDate);

		$startDate = date_create(date('Y', strtotime($returnDate)).'-04-01');
		$endDate = date_create((date('Y', strtotime($returnDate))+1).'-04-01');
		$interval = date_diff($startDate, $endDate);
		$noDays = ($interval->days);

		$this->set('reasonsArr', $reasonsArr);
		$this->set('reasonsLen', $reasonsLen);
		$this->set('empWages', $empWages);
		$this->set('workData', $workData);
		$this->set('noDays', $noDays);


		$this->render('/element/annual/employment_wages');

		if($this->request->is('post')){

            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->RentReturns->saveEmpWagesForm($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Employment & Wages (I)</b> successfully!');
					$this->redirect(array('controller'=>'annual','action'=>'employment_wages_part'));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Employment & Wages (I)</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'employment_wages'));
                }
            } else {
				$result = $this->RentReturns->saveEmpWagesForm($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Employment & Wages (I)</b> successfully saved!');
					$this->redirect(array('controller'=>'annual','action'=>'employment_wages_part'));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Employment & Wages (I)</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'employment_wages'));
				}
            }
		}

    }

	
    // PART II: EMPLOYMENT & WAGES II
    public function employmentWagesPart(){

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('employment_wages_part', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partII', 3, '', 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partII'][3])) && $approvedSections['partII'][3] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partII', 3, '', 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partII', 3, '', 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral','');
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partII');
	        $this->set('sectionId','3');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		$startDate = (date('Y',strtotime($returnDate))).'-04-01';
		$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
		$endDate = date('Y-m-t', strtotime($endDate));
		
		$formType = 5;
		$empData = $this->Employment->getEmploymentWagesPart2Details($mineCode, $returnDate, $formType);

		$this->set('startDate', $startDate);
		$this->set('endDate', $endDate);
		$this->set('empData', $empData);


		$this->render('/element/annual/employment_wages_part');

		if($this->request->is('post')){

            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->RentReturns->saveEmpWagesPartForm($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Employment & Wages (II)</b> successfully!');
					$this->redirect(array('controller'=>'annual','action'=>'capital_structure'));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Employment & Wages (II)</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'employment_wages_part'));
                }
            } else {
				$result = $this->RentReturns->saveEmpWagesPartForm($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Employment & Wages (II)</b> successfully saved!');
					$this->redirect(array('controller'=>'annual','action'=>'capital_structure'));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Employment & Wages (II)</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'employment_wages_part'));
				}
            }
		}

    }

	
    // PART II: CAPITAL STRUCTURE
    public function capitalStructure(){

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('capital_structure', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partII', 2, '', 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partII'][2])) && $approvedSections['partII'][2] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partII', 2, '', 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partII', 2, '', 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral','');
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partII');
	        $this->set('sectionId','2');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		//==============================CONSUMING WEB SERVICE=======================
		//consume the list of minecodes and minenames of the mine owner
		$mineOwner = $this->Session->read('parentid');
		// $applicantMinesData = $this->McpLease->getApplicantMinesDetails($mineOwner, $mineCode);
		$applicantMinesData = $this->McpLease->getApplicantAllMinesDetails($mineOwner);
		
		// try{
		// 	$ch = curl_init();
		// 	curl_setopt($ch, CURLOPT_URL, $loadUrl);
		// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
		// 	curl_setopt($ch, CURLOPT_HEADER, false);
		// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// 	$output = curl_exec($ch);
		// 	curl_close($ch);
		
		// 	$xmlTree = new SimpleXMLElement($output);
		// 	$xml = (array) $xmlTree;
		// }
		// catch(Exception $e) {
		// 	unset($xml);
		// }
    	// function objectToArray($object) {
		// if (!is_object($object) && !is_array($object)) {
		//   return $object;
		// }
		// if (is_object($object)) {
		//   $object = get_object_vars($object);
		// }
		// return array_map('objectToArray', $object);
	  	// }
		
		// $mineData = objectToArray($xml);
		$mineData = $applicantMinesData;
		// foreach ($mineData['complexMinesDetails'] as $m) {
		foreach ($mineData as $m) {
			$mineral_sep_name = $this->MineralWorked->getSnCalMineralName($m['mcm_mine_code']);
			$mine_codes[] = $m['mcm_mine_code'];
			// $mine_data[$m['mcmd_mine_name'] . " - " . $m['mcm_mine_code'] . " - " . $mineral_sep_name] = $m['mcmd_mine_name'] . " - " . $m['mcm_mine_code'] . " - " . $mineral_sep_name;
			$mine_data[$m['mcm_mine_desc'] . " - " . $m['mcm_mine_code'] . " - " . $mineral_sep_name] = $m['mcm_mine_desc'] . " - " . $m['mcm_mine_code'] . " - " . $mineral_sep_name;
		}
		
		//this session is used in the drop down box
		$this->Session->write('mine_data', $mine_data);
		
		$filedMines = $this->CapitalStructure->getFiledMines($mineOwner, $returnDate);

		// if ($filedMines == NULL) {
		// 	$filedMines = array();
		// }
		// $unFiledMines = array_diff($mine_codes, $filedMines);

		// $filedByCurrentUser = $this->CapitalStructure->getFiledMinesByCurrentUser($mineCode, $returnDate);
		// if ($filedByCurrentUser == NULL) {
		// 	$filedByCurrentUser = array();
		// }
		// $minesForCurrentUser = array_merge($unFiledMines, $filedByCurrentUser);

		//foreach($mine_data as $mc => $mn){
		// if(in_array($mc, $minesForCurrentUser)){
		//  $dropDownMines[$mc] = $mc." - ".$mn; 
		//  }
		// }

		//this session is used in the drop down box
		//$this->getUser()->setAttribute('mine_data', json_encode($dropDownMines));

		//append the minecodes for the user u had already filed for.

		$csData = $this->CapitalStructure->getAllData($mineCode, $returnDate);

		$this->set('mine_data', $mine_data);
		$this->set('mineOwner', $mineOwner);
		$this->set('csData', $csData);



		$this->render('/element/annual/capital_structure');

		if($this->request->is('post')){

            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->CapitalStructure->savePostData($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Capital Structure</b> successfully!');
					$this->redirect(array('controller'=>'annual','action'=>'material_consumption_quantity'));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Capital Structure</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'capital_structure'));
                }
            } else {
				$result = $this->CapitalStructure->savePostData($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Capital Structure</b> successfully saved!');
					$this->redirect(array('controller'=>'annual','action'=>'material_consumption_quantity'));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Capital Structure</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'capital_structure'));
				}
            }
		}

    }

	
    // PART III: QUANTITY & COST OF MATERIAL
    public function materialConsumptionQuantity(){

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('material_consumption_quantity', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partIII', 1, '', 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partIII'][1])) && $approvedSections['partIII'][1] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partIII', 1, '', 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partIII', 1, '', 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral','');
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partIII');
	        $this->set('sectionId','1');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);
		
		//=======================CHECKING PART - 3 EXPLOSIVE VALUE==================

		/**
		 * 1 -> FIELD IS IN DB
		 * 0 -> NO FIELD IN DB 
		 */
		$explosiveConsumption = $this->ExplosiveConsumption->getExplosiveConsumptionId($mineCode, $returnDate);
		if ($explosiveConsumption == 1) {
			$explConsumpFieldsCheck = 1;
		}
		else {
			$explConsumpFieldsCheck = 0;
		}
		//===========================CHECKING PART - 3 ENDS=========================

		$matConsData = $this->MaterialConsumption->getMatConsDetails($mineCode, $returnDate);
		$this->set('matConsData', $matConsData);


		$this->render('/element/annual/material_consumption_quantity');

		if($this->request->is('post')){

            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->MaterialConsumption->saveFormData($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Quantity & Cost of Material</b> successfully!');
					$this->redirect(array('controller'=>'annual','action'=>'material_consumption_royalty'));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Quantity & Cost of Material</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'material_consumption_quantity'));
                }
            } else {
				$result = $this->MaterialConsumption->saveFormData($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Quantity & Cost of Material</b> successfully saved!');
					$this->redirect(array('controller'=>'annual','action'=>'material_consumption_royalty'));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Quantity & Cost of Material</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'material_consumption_quantity'));
				}
            }
		}

    }

	
    // PART III: ROYALTY / COMPENSATION / DEPRECIATION
    public function materialConsumptionRoyalty(){

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('material_consumption_royalty', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partIII', 2, '', 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partIII'][2])) && $approvedSections['partIII'][2] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partIII', 2, '', 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partIII', 2, '', 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral','');
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partIII');
	        $this->set('sectionId','2');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);
		
		//========GETTING DEPRICIATION TOTAL VALUE FROM CAPITAL STRUCTURE===========
		$depriciationAllData = $this->CapitalStructure->getAllData($mineCode, $returnDate);
		$depriciationTotal = $depriciationAllData['common_result']['total_depreciated'];
		//==========================================================================
		//====================ROYALTY CHECKING FOR 12 MONTH TOTAL===================
		/**
		 * AS $this->returnDate IS HARDCODED TO '2011-04-01' BECAUSE RETURN YEAR START 
		 * FROM THIS DATE,
		 * SO START DATE FOR MONTHLY RETURN IS 'XXXX-04-01'
		 * AND END DATE FOR MONTHLY RETURN IS 'XXXX-03-01'
		 */
		$temp = explode('-', $returnDate);
		$returnYear = $temp[0];
		$period = $returnYear . " - " . ($temp[0] + 1);
		$startDate = $returnDate;
		$endMonthTemp = $temp[1] - 1;
		$endMonth = "0" . $endMonthTemp;
		$endYear = $temp[0] + 1;
		$endDate = $endYear. "-". $endMonth."-". "01";

		$monthlyRoyalty = $this->RentReturns->getRoyaltyMonthlyTotal($mineCode, 'MONTHLY', $startDate, $endDate);
		if ($monthlyRoyalty == "") {
			$monthlyRoyaltyTotal = 0;
		}
		else {
			$monthlyRoyaltyTotal = $monthlyRoyalty;
		}

		$formType = 2;
		$matConsRoyData = $this->RentReturns->getMatConsRoyaltyDetails($mineCode, $returnDate, $formType);

		$this->set('depriciationTotal', $depriciationTotal);
		$this->set('monthlyRoyaltyTotal', $monthlyRoyaltyTotal);
		$this->set('matConsRoyData', $matConsRoyData);



		$this->render('/element/annual/material_consumption_royalty');

		if($this->request->is('post')){

            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->RentReturns->saveMatConsRoyaltyForm($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Royalty / Compensation / Depreciation</b> successfully!');
					$this->redirect(array('controller'=>'annual','action'=>'material_consumption_tax'));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Royalty / Compensation / Depreciation</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'material_consumption_royalty'));
                }
            } else {
				$result = $this->RentReturns->saveMatConsRoyaltyForm($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Royalty / Compensation / Depreciation</b> successfully saved!');
					$this->redirect(array('controller'=>'annual','action'=>'material_consumption_tax'));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Royalty / Compensation / Depreciation</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'material_consumption_royalty'));
				}
            }
		}

    }

	
    // PART III: TAXES / OTHER EXPENSES
    public function materialConsumptionTax(){

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('material_consumption_tax', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partIII', 3, '', 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partIII'][3])) && $approvedSections['partIII'][3] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partIII', 3, '', 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partIII', 3, '', 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral','');
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partIII');
	        $this->set('sectionId','3');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		$formType = 3;
		$matConsTaxData = $this->RentReturns->getMatConsTaxDetails($mineCode, $returnDate, $formType);

		$this->set('matConsTaxData', $matConsTaxData);
		



		$this->render('/element/annual/material_consumption_tax');

		if($this->request->is('post')){

            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->RentReturns->saveMatConsTaxForm($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Taxes / Other Expenses</b> successfully!');
					$this->redirect(array('controller'=>'annual','action'=>'explosive_consumption'));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Taxes / Other Expenses</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'material_consumption_tax'));
                }
            } else {
				$result = $this->RentReturns->saveMatConsTaxForm($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Taxes / Other Expenses</b> successfully saved!');
					$this->redirect(array('controller'=>'annual','action'=>'explosive_consumption'));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Taxes / Other Expenses</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'material_consumption_tax'));
				}
            }
		}

    }

    // PART IV: CONSUMPTION OF EXPLOSIVES
    public function explosiveConsumption(){

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('explosive_consumption', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partIV', 1, '', 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partIV'][1])) && $approvedSections['partIV'][1] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partIV', 1, '', 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partIV', 1, '', 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral','');
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partIV');
	        $this->set('sectionId','1');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
	
		$period = $returnYear . " - " . ($returnYear[0] + 1);
		
		//=======================CHECKING PART - 3 EXPLOSIVE VALUE==================
		/**
		 * if $explosiveCheckVal == 0 -----> DATA FOUND IN THE DB 
		 * if $explosiveCheckVal == 1 -----> NO DATA FOUND IN THE DB 
		 */
		$explosiveCheckVal = $this->MaterialConsumption->explosiveCheckForPart4($mineCode, $returnType, $returnDate);
		
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		$explosiveReturnData = $this->ExplosiveConsumption->getExplosiveReturnRecords($mineCode, $returnDate, $returnType);
		$explosiveConsumptData = $this->ExplosiveConsumption->getExplosiveConDetails($mineCode, $returnDate);

		$this->set('explosiveCheckVal', $explosiveCheckVal);
		$this->set('explReturn', $explosiveReturnData);
		$this->set('explConsum', $explosiveConsumptData);



		$this->render('/element/annual/explosive_consumption');

		if($this->request->is('post')){

            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->ExplosiveConsumption->saveFormDetails($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Consumption of Explosives</b> successfully!');
					$this->redirect(array('controller'=>'annual','action'=>'geology_exploration'));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Consumption of Explosives</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'explosive_consumption'));
                }
            } else {
				$result = $this->ExplosiveConsumption->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Consumption of Explosives</b> successfully saved!');
					$this->redirect(array('controller'=>'annual','action'=>'geology_exploration'));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Consumption of Explosives</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'explosive_consumption'));
				}
            }
		}

    }

	
    // PART V: SEC 1 : EXPLORATION
    public function geologyExploration(){

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('geology_exploration', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partV', 1, '', 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partV'][1])) && $approvedSections['partV'][1] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 1, '', 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 1, '', 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral','');
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partV');
	        $this->set('sectionId','1');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		$formData = $this->ExplorationDetails->getAllData($mineCode, $returnType, $returnDate);

		$this->set('formData', $formData);


		$this->render('/element/annual/geology_exploration');

		if($this->request->is('post')){

			$nextSection = $this->findNextSection('/annual/geology_exploration');
            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->ExplorationDetails->saveFormDetails($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Geology Exploration</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Geology Exploration</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'geology_exploration'));
                }
            } else {
				$result = $this->ExplorationDetails->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Geology Exploration</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Geology Exploration</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'geology_exploration'));
				}
            }
		}

    }
	
    // PART V: SEC 2/3 : RESERVES AND RESOURCES ESTIMATED / SUBGRADE-MINERAL REJECT
    public function geologyReservesSubgrade($mineral){

		$this->viewBuilder()->setLayout('mc/form_layout');
		$min_und_low = strtolower(str_replace(' ','_',$mineral)); // mineral underscore lowercase

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('geology_reserves_subgrade', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partV', 2, $mineral, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partV'][2][$min_und_low])) && $approvedSections['partV'][2][$min_und_low] == "Rejected") {
        	//print_r($approvedSections);die;
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 2, $mineral, 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 2, $mineral, 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

            //print_r($commented_status);die;

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral',$mineral);
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partV');
	        $this->set('sectionId','2');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		$mineMinerals = $this->Session->read('mineralArr');
		$mineralName = strtolower(str_replace(' ', '_', $mineral));
		
		$reservesFormData = $this->ReservesResources->getAllData($mineCode, $returnType, $returnDate, $mineralName);
		$subgradeFormData = $this->SubgradeMineralReject->getAllData($mineCode, $returnType, $returnDate, $mineralName);

		$this->set('mineralName', $mineralName);
		$this->set('reserves', $reservesFormData);
		$this->set('subgrade', $subgradeFormData);
		

		$this->render('/element/annual/geology_reserves_subgrade');

		if($this->request->is('post')){

			$nextSection = $this->findNextSection('/annual/geology_reserves_subgrade/'.str_replace('_',' ',strtoupper($mineral)));
			//print_r($nextSection);die;
            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->ReservesResources->saveFormDetails($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Reserves Resources Estimated & Subgrade-Mineral Reject</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Reserves Resources Estimated & Subgrade-Mineral Reject</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'geologyReservesSubgrade', $mineral));
                }
            } else {
				$result = $this->ReservesResources->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Reserves Resources Estimated & Subgrade-Mineral Reject</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Reserves Resources Estimated & Subgrade-Mineral Reject</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'geologyReservesSubgrade', $mineral));
				}
            }
		}

    }
	
    // PART V: SEC 4/5 : OVERBURDEN AND WASTE / TREES PLANTED- SURVIVAL RATE
    public function geologyOverburdenTrees(){

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('geology_overburden_trees', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partV', 3, '', 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partV'][3])) && $approvedSections['partV'][3] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 3, '', 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 3, '', 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral','');
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partV');
	        $this->set('sectionId','3');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		$treesFormData = $this->TreesPlantSurvival->getAllData($mineCode, $returnType, $returnDate);
		$overburdenFormData = $this->OverburdenWaste->getAllData($mineCode, $returnType, $returnDate);

		$this->set('treesPlant', $treesFormData);
		$this->set('overburden', $overburdenFormData);


		$this->render('/element/annual/geology_overburden_trees');

		if($this->request->is('post')){

            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->OverburdenWaste->saveFormDetails($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Overburden, Waste & Trees Planted - Survival Rate</b> successfully!');
					$this->redirect(array('controller'=>'annual','action'=>'geology_part_three'));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Overburden, Waste & Trees Planted - Survival Rate</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'geology_overburden_trees'));
                }
            } else {
				$result = $this->OverburdenWaste->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Overburden, Waste & Trees Planted - Survival Rate</b> successfully saved!');
					$this->redirect(array('controller'=>'annual','action'=>'geology_part_three'));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Overburden, Waste & Trees Planted - Survival Rate</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'geology_overburden_trees'));
				}
            }
		}

    }

    // PART V: SEC 6 :  TYPE OF MACHINERY
    public function geologyPartThree(){

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('geology_part_three', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partV', 4, '', 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partV'][4])) && $approvedSections['partV'][4] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 4, '', 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 4, '', 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral','');
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partV');
	        $this->set('sectionId','4');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		// $this->set('tableForm','');


		//section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		// $machineryType = $this->DirMachinery->getAllData();
		$dynamicFormType = 1;
		$machineryTypeArr = $this->DirMachinery->machineryTypeArr();
		$machineryData = $this->Machinery->getAllData($mineCode, $returnType, $returnDate, $formType12, $dynamicFormType);

		$this->set('formType', $formType12);
		// $this->set('machineryType', $machineryType);
		$this->set('machinery', $machineryData);
		$this->set('lang', $lang);

		
		// create html form structure by passing array
		// @addedon: 13th Oct 2021 (by Aniket Ganvir)
		$rowArr[0] = $machineryData;
		$rowArr[1] = $machineryTypeArr;
		$tableForm = array();
		$tableForm[] = $this->Formcreation->formTableArr('geology_part_three', $lang, $rowArr);
		$jsonTableForm = json_encode($tableForm);
		$this->set('tableForm', $jsonTableForm);


		$this->render('/element/annual/geology_part_three');

		if($this->request->is('post')){

			$nextSection = $this->findNextSection('/annual/geology_part_three');
            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->Machinery->saveFormDetails($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Type of Machinery</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Type of Machinery</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'geology_part_three'));
                }
            } else {
				$result = $this->Machinery->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Type of Machinery</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Type of Machinery</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'geology_part_three'));
				}
            }
		}

    }

	
    // PART V: SEC 7 : MINERAL TREATMENT PLANT
    public function geologyPartSix($mineral){

		$this->viewBuilder()->setLayout('mc/form_layout');
		$min_und_low = strtolower(str_replace(' ','_',$mineral)); // mineral underscore lowercase

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('geology_part_six', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partV', 5, $mineral, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);
		//print_r($approvedSections);die;
		//current comment history
        if ((isset($approvedSections['partV'][5][$min_und_low])) && $approvedSections['partV'][5][$min_und_low] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 5, $mineral, 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partV', 5, $mineral, 'applicant');
            //print_r($reason_data);die;
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral',$mineral);
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partV');
	        $this->set('sectionId','5');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		$formType = 2;

		$mineralName = strtolower(str_replace(' ', '_', $mineral));

		$machineryAllData = $this->Machinery->getAllPart6Data($mineCode, $returnType, $returnDate, $mineralName, $formType);

		$this->set('formType', $formType12);
		$this->set('mineralName', $mineralName);
		$this->set('machineryData', $machineryAllData);



		$this->render('/element/annual/geology_part_six');

		if($this->request->is('post')){

			$nextSection = $this->findNextSection('/annual/geology_part_six/'.str_replace('_',' ',strtoupper($mineral)));
            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->Machinery->postFormDataPartSix($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Mineral Treatment Plant ('.$mineral.')</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Mineral Treatment Plant ('.$mineral.')</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'geology_part_six', $mineral));
                }
            } else {
				$result = $this->Machinery->postFormDataPartSix($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Mineral Treatment Plant ('.$mineral.')</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Mineral Treatment Plant ('.$mineral.')</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'geology_part_six', $mineral));
				}
            }
		}

    }
	
    // PART VII: COST OF PRODUCTION
    public function productionCost(){

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
        $returnType = $this->Session->read('returnType');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('production_cost', $lang);

        //get the approved & rejected sections
        $approvedSections = $this->Session->read('approved_sections');
        $rejectedReasons = $this->Session->read('rejected_reasons');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        $isMineOwner = $this->Session->read('is_mine_owner');

        //check if the return is all approved - to show the final submit button
        $is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnYear', $returnYear);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$section_mode = $this->Session->read('section_mode');

        //check is rejected or approved section
        $commented_status = '0';
        $reasons = array();
        $reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if(count($return_ids) > 0){
			foreach($return_ids as $return_id){
				$reasons_old[] = $this->TblFinalSubmit->getReasonAnnual($return_id['id'], 'partVII', 1, '', 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
        if ((isset($approvedSections['partVII'][1])) && $approvedSections['partVII'][1] == "Rejected") {
            $is_rejected_section = 1;
            $return_id = $this->Session->read('return_id');
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partVII', 1, '', 'applicant');
            $section_mode = 'edit';

            $reason_data = $this->TblFinalSubmit->getReasonAnnual($return_id, 'partVII', 1, '', 'applicant');
            if($reason_data['commented'] == '1'){
            	$commented_status = '1';
            }

	        $this->set('reasons',$reasons);
	        $this->set('viewOnly',false);
	        $this->set('view','view');
	        $this->set('return_home_page','');
	        $this->set('is_pri_pending',false);

	        $this->set('returnDate',$returnDate);
	        $this->set('mineral','');
	        $this->set('sub_min','');
	        $this->set('mmsUserRole','applicant');
	        $this->set('part_no','partVII');
	        $this->set('sectionId','1');
        // } else if ($approvedSections['partI'][3] == "Approved") {
        //     $is_rejected_section = 2;
        } else {
            $is_rejected_section = ''; // need to review
        }

		$this->set('mmsUserId',$this->Session->read('username'));
        $this->set('commented_status', $commented_status);
        $this->set('section_mode',$section_mode);
		$this->set('is_rejected_section',$is_rejected_section);
		$this->set('tableForm','');


		//section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		//================CHECKING FOR PART- 3 FORM-3 OVERHEAD FIELDS===============
		// THIS IS FOR IMPLEMENTING THE VALIDATION GIVEN IN THE PART- 3 FORM-3
		$overHeadFormType = 3;
		$overHeadField = $this->RentReturns->checkOverHead($mineCode, $returnType, $returnDate, $overHeadFormType);
		$costData = $this->CostProduction->getData($mineCode, $returnType, $returnDate);
		$this->set('overHead', $overHeadField);
		$this->set('costData', $costData);


		$this->render('/element/annual/production_cost');

		if($this->request->is('post')){

            if($this->request->getData('submit') == 'save_comment'){
                $result1 = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->CostProduction->saveFormDetails($this->request->getData());

                if($result1 == 1){
                    $this->Session->write('mon_f_suc','Reply saved in <b>Cost of Production</b> successfully!');
					$this->redirect(array('controller'=>'annual','action'=>'production_cost'));
                } else {
                    $this->Session->write('mon_f_err','Failed to saved reply <b>Cost of Production</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'production_cost'));
                }
            } else {
				$result = $this->CostProduction->saveFormDetails($this->request->getData());

				if($result == 1){
					$this->Session->write('mon_f_suc','<b>Cost of Production</b> successfully saved!');
					$this->redirect(array('controller'=>'annual','action'=>'production_cost'));
				} else {
					$this->Session->write('mon_f_err','Failed to update <b>Cost of Production</b>! Please, try again later.');
					$this->redirect(array('controller'=>'annual','action'=>'production_cost'));
				}
            }
		}

    }

	
    /**
     * Annual final submit saving and validation
     * @version 30th Oct 2021
	 * @author Aniket Ganvir
     */
    public function finalSubmit(){

    	$this->autoRender = false;

        $mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
        $returnType = $this->Session->read('returnType');
        $returnType = 'ANNUAL';

		/***** Added by saranya raj 18th April 2016 *******************/
        // $is_hematite = $this->getUser()->getAttribute('is_hematite');
        // $is_magnetite = $this->getUser()->getAttribute('is_magnetite');
        $is_hematite = '';
        $is_magnetite = '';

        /**
         * GETTING THE USER ID AND THEN EXPLODING IT WITH '/' 
         * TO CHECK THE MINE USER AS IF 2 '/' COMES THEN THE USER IS A 3rd LEVEL
         * USER ELSE IF 1 '/' COMES IT'S A SECONDAY USER
         * 
         * eg:- the o/p of above user is : 57/40MSH14010/1
         * then exploding with '/' and since only one '/' is there it's a 
         * SECONDARY USER
         */
        $mcu_user_id = $this->Session->read('username');

        $temp = explode('/', $mcu_user_id);
        $app_id = $temp[0] . "/" . $temp[1];

        if (count($temp) == 3)
            $submitted_by = $temp[2];
        else
            $submitted_by = $app_id;

        //======================GETTING MINERAL FROM THE SESSION====================
        $mineMinerals = $this->Session->read('mineralArr');
		
		//primary form no
        $primaryMineral = $mineMinerals[0];
        $primaryFormNo = $this->DirMcpMineral->getFormNumber($primaryMineral);
		
        //=======================CHECKING NAME AND ADDRESS PAGE=====================
        $nameAndAddress = $this->Mine->nameAndAddressCheck($mineCode);
		
        //=====================CHECKING PARTICULARS OF AREA OPERATED================
		/*
		 * Added one more parameter returnDate for validation with Lease_Year. Earlier it was being compared with 'CurrentYear' resulting in issue.
		 * Author : Naveen Jha naveenj@ubicsindia.com
		 * Date : 17th Jan 2015
		 */
        $particular = $this->McpLease->particularAnnualCheck($mineCode,$returnDate);

        //==========================CHECKING AREA UTILIZATION=======================
        $areaUtilisation = $this->LeaseReturn->lesseeCheck($mineCode, $returnDate);
		
        //====================CHECKING EMPLOYMENT & WAGES PART 1====================
        /**
         * form type for employment fields = 1 in RENT_RETURNS TABLE 
         */
        $wagesFormType = 1;
        $wagesFromReturn = $this->RentReturns->getReturnsId($mineCode, $returnType, $returnDate, $wagesFormType);
        if ($wagesFromReturn != "") {
            $wageErrorCount = 0;
		}
        else {
            $wageErrorCount = 1;
		}

        $wagesFromWorkStoppage = $this->WorkStoppage->isFilled($mineCode, $returnDate, $returnType);
		
        //=====================CHECKING EMPLOYMENT & WAGES PART 2===================
        $employment = $this->Employment->employmentAnnualCheck($mineCode, $returnDate, $returnType);

        //========================CHECKING CAPITAL STRUCTURE========================
        $capitalStruc = $this->CapitalStructure->getRecordId($mineCode, $returnDate);
        if ($capitalStruc == 1)
            $capitalError = 0;
        else
            $capitalError = 1;

			
        //======================QUANTITY AND COST OF MATERIAL=======================
        $quantity = $this->MaterialConsumption->materialQuantityAnnualCheck($mineCode, $returnDate, $returnType);

        //==========================ROYALITY/COMPENSATION===========================
        /**
         * form type for royality fields = 2 in RENT_RETURNS TABLE 
         */
        $royalityFormType = 2;
        $royality = $this->RentReturns->getReturnsId($mineCode, $returnType, $returnDate, $royalityFormType);
        if ($royality == "")
            $royalityError = 1;
        else
            $royalityError = 0;

			
        //==========================MATERIAL CONSUMPTION TAX========================
        /**
         * form type for consumption tax fields = 3 in RENT_RETURNS TABLE 
         */
        $taxFormType = 3;
        $tax = $this->RentReturns->getReturnsId($mineCode, $returnType, $returnDate, $taxFormType);
        if ($tax == "")
            $taxError = 1;
        else
            $taxError = 0;
			
        //===========================EXPLOSIVE CONSUMPTION==========================
        /**
         * COMMENTED THE FUNCTION AS THE VALIDATION HAS BEEN CHANGED 
         * NOW WE ONLY HAVE TO CHECK "QUANTITY CONSUMED DURING THE YEAR"
         * AS PER THE GUIDANCE GIVEN BY IBM, SO NO NEED TO CHECK THIS FUNCTION
         * ANY MORE
         * 
         * @author Uday Shankar Singh<using@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 26th Feb 2014 
         */
		// $explosiveReturn = EXPLOSIVE_CONSUMPTIONTable::getExplosiveReturnsId($this->mineCode, $this->returnDate, $this->returnType);
        // $checkQuantityForExplosiveValue = 0 -> VALUE GREATER THAN 0 IS ENTERED IN QUANTITY FORM
        // ELSE 1 THEN VALUE ENTERED IS 0
        /**
         * THE BELOW FUNCTION CALL IS ADDED TO CHECK THE QUANTITY FORM ALSO NOW
         * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 25th March 2014 
         */
        $checkQuantityForExplosiveValue = $this->MaterialConsumption->explosiveCheckForPart4($mineCode, 'ANNUAL', $returnDate);
        // $explosiveConsumption = 1 THAN VALUE ENTERED IN EXPLOSIVE IS GREATER THAN 0
        // ELSE 0 THEN 0 IS ENTERED IN ALL THE FIELD OF EXPLOSIVE CONSUMPTION
		
		/**
         * The below function is now being called with one more parameter 'calledfrom = finalSubmit'
         * This was done to handle a special case where 'explosive value' in part III is zero but future consumption in Part IV is not zero.
         * On Final submit error was being flashed. 
         * @author Uday Shankar Singh<usingh@ubicsindia.com>
         * @version 26th June 2015
         */
		// $explosiveConsumption = EXPLOSIVE_CONSUMPTIONTable::getExplosiveConsumptionId($this->mineCode, $this->returnDate);
		$explosiveConsumption = $this->ExplosiveConsumption->getExplosiveConsumptionId($mineCode, $returnDate, 'finalSubmit');

	  
		if (($checkQuantityForExplosiveValue == 0 && $explosiveConsumption == 1) || ($checkQuantityForExplosiveValue == 1 && $explosiveConsumption == 0))//BOTH HAVE VALUE GREATER THAN 0 or 0
			$expConError = 0;
		else
			$expConError = 1;
		/**
		 * BELOW 4 LINES ARE COMMENTED AS I MADE A LITTLE CHANGE IN THE VALIDATION
		 * AS NOW I AM CHECKING THE QUANTITY FORM ALSO FOR VALUE TO DOUBLE ENSURE THAT
		 * VALUE IS EITHER FILLED IN BOTH THE FORMS OR ENTERED 0 IN BOTH THE FORMS
		 * 
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 25th March 2014 
		 */
		// if ($explosiveConsumption == 1)
		// 	$expConError = 0;
		// else
		// 	$expConError = 1;
        //===========================GEOLOGY PART 1 FORM NEED TO BE COMPLETE====================================
		
        // $i = 1;
        // foreach ($mineMinerals as $name) {
        //     $mineralName = $name;
        //     $geoPart1[$i] = $this->TblMinWorked->checkDBForAnnualFinalSubmit($mineCode, $returnDate, $mineralName);
        //     if ($geoPart1[$i] == 1)
        //         $part1Error[$i] = 0;
        //     else
        //         $part1Error[$i] = 1;
        //     $i++;
        // }
        // foreach ($part1Error as $errorCheck) {
        //     //==================ERROR FOUND======================
        //     if ($errorCheck == 1) {
        //         $geoPart1Error = 1;
        //     }
        //     //=================NO ERROR FOUND====================
        //     else {
        //         $geoPart1Error = 0;
        //     }
        // }
		
		// PART V: Sec 1
		$geoExpRecord = $this->ExplorationDetails->isFilled($mineCode, $returnType, $returnDate);

		// PART V:
		$geoResSubgradeRecordError = 0;
		$geoPartSixRecordError = 0;
        foreach ($mineMinerals as $name) {
            $mineralName = $name;
			$mineral_name = strtolower($mineralName);
			$mineral_sp = str_replace('_',' ',$mineralName);

			// PART V: Sec 2/3
			$geoResSubgradeRecord = $this->ReservesResources->isFilled($mineCode, $returnType, $returnDate, $mineral_name);
			if ($geoResSubgradeRecord == 0) {
				$geoResSubgradeRecordError++;
			}

			// PART V: Sec 7
			$geoPartSixRecord = $this->Machinery->isFilledPartSix($mineCode, $returnType, $returnDate, $mineral_name, 2, 2);
			if ($geoPartSixRecord == 0) {
				$geoPartSixRecordError++;
			}
           
        }

		// PART V: Sec 4/5
		$geoOverburdTreeRecord = $this->TreesPlantSurvival->isFilled($mineCode, $returnType, $returnDate);

		// PART V: Sec 6
		$formType12 = $this->Session->read('mc_form_type');
		$geoPartThreeRecord = $this->Machinery->isFilled($mineCode, $returnType, $returnDate, $formType12, 1);
		
        //=============================GEOLOGY PART 2===============================
        /**
         * form type for geology part 2 = 4 in RENT_RETURNS table 
         */
        // $geoFormType = 4;
        // $mineralName = '0';
        // $geoPart2 = $this->RentReturns->checkGeologyPart2Id($mineCode, $returnType, $returnDate, $geoFormType, $mineralName);
        // if ($geoPart2['db_check'] == 1)
        //     $geoPart2Error = 0;
        // else
        //     $geoPart2Error = 1;

        //=============================GEOLOGY PART 3===============================
        $formType = 1;
        $geoPart3 = $this->Machinery->checkDB($mineCode, $returnType, $returnDate, $formType);
        if ($geoPart3 == 1)
            $geoPart3Error = 0;
        else
            $geoPart3Error = 1;

			
		$i = 1;
		foreach ($mineMinerals as $name) {
			$mineralName = $name;
			$geoPartRejects1[$i] = $this->RentReturns->checkMineralDB($mineCode, $returnType, $returnDate, $mineralName);
			//RESERVESTable::checkDBForAnnual($this->mineCode, $this->returnType, $this->returnDate, $mineralName);
			if ($geoPartRejects1[$i] == 1)
				$partRejectsError[$i] = 0;
			else
				$partRejectsError[$i] = 1;
			$i++;
		}
		foreach ($partRejectsError as $errorRejectsCheck) {
			//==================ERROR FOUND======================
			if ($errorRejectsCheck == 1) {
				$mineralRejects = 1;
			}
			//=================NO ERROR FOUND====================
			else {
				$mineralRejects = 0;
			}
		}

		
        /*
          $mineralRejects = RETURNSTable::checkMineralDB($this->mineCode, $this->returnType, $this->returnDate);
          if ($mineralRejects == 1)
          $mineralRejects = 0;
          else
          $mineralRejects = 1; */
        //=============================GEOLOGY PART 4===============================
        $i = 1;
        foreach ($mineMinerals as $name) {
            $mineralName = $name;
            $geoPart4[$i] = $this->Reserves->checkDBForAnnual($mineCode, $returnType, $returnDate, $mineralName);
            if ($geoPart4[$i] == 1)
                $part4Error[$i] = 0;
            else
                $part4Error[$i] = 1;
            $i++;
        }
        foreach ($part4Error as $errorCheck) {
            //==================ERROR FOUND======================
            if ($errorCheck == 1) {
                $geoPart4Error = 1;
            }
            //=================NO ERROR FOUND====================
            else {
                $geoPart4Error = 0;
            }
        }
		
        //================================SALE AND DISPATCH=========================
        /*
          $i = 1;
          foreach ($this->mineMinerals as $name) {
          $mineralName = $name;
          $mineralSaleGrade[$i] = GRADE_SALETable::checkdSaleMineralDB($this->mineCode, $this->returnType, $this->returnDate,$mineralName);
          if ($mineralSaleGrade[$i] == 1)
          $partSaleError[$i] = 0;
          else
          $partSaleError[$i] = 1;
          $i++;
          }
          foreach ($partSaleError as $errorSaleCheck) {
          //==================ERROR FOUND======================
          if ($errorSaleCheck == 1) {
          $geoPartSaleError = 1;
          }
          //=================NO ERROR FOUND====================
          else {
          $geoPartSaleError = 0;
          }
          } */
        //===========================COST OF PRODUCTION=============================
        // $cost = $this->CostProduction->getCostId($mineCode, $returnType, $returnDate);
		$prodCost = $this->CostProduction->isFilled($mineCode, $returnType, $returnDate);
        // if ($cost != "")
        //     $costError = 0;
        // else
        //     $costError = 1;


        //====================CHECKING GRADE WISE PRODUCTION AND ROM FOR PRODUCTION VALUE CHECK==========
        $romTotalForAllMineral = 0;
        foreach ($mineMinerals as $name) {
            $formNo = $this->DirMcpMineral->getFormNumber($name);
            if ($formNo == 6) {
                $gradeTotalCheck = $this->ProdMica->getProductionTotalfn($mineCode, $returnType, $returnDate, $name, $formNo);
                $romData = $this->ProdMica->getRomProductionTotalfn($mineCode, $returnType, $returnDate, $name);
                $tmp = $romData / 1000;
                $romTotalForAllMineral = $romTotalForAllMineral + $tmp;
            } else if ($formNo == 5) {
                $gradeTotalCheck = $this->Rom5->getTotalProduction($mineCode, $returnDate, $returnType, $name);
                $romData = $gradeTotalCheck;
                $romTotalForAllMineral = $romTotalForAllMineral + $romData;
            } else if ($formNo == 7) {
                $gradeTotalCheck = $this->RomStone->getRomProductionTotal($mineCode, $returnType, $returnDate, $name);
                /**
                 * CHANGED THE FUNCTION CALL FROM
                 * 
                 * PROD_STONETable::getProductionTotal TO  
                 * ROM_STONETable::getProductionTotal AS 
                 * PER THE CHANGES FOUND IN THE RELEASE VERSION 
                 * 
                 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                 * @version 21st Jan 2014
                 * 
                 */
                $romData = $this->RomStone->getProductionTotal($mineCode, $returnType, $returnDate, $name);
                $romTotalForAllMineral = $romTotalForAllMineral + $romData;
            } else {
                $gradeTotalCheck = $this->GradeProd->getProductionTotal($mineCode, $returnType, $returnDate, $name);
                $romData = $this->Prod1->getRomProductionTotal($mineCode, $returnType, $returnDate, $name);
                $romTotalForAllMineral = $romTotalForAllMineral + $romData;
            }
        }
		
        $expConProdTot = $this->ExplosiveReturn->getProductionDuringTheYear($mineCode, $returnDate, $returnType);
		// print_r($romTotalForAllMineral);
		// print_r("-------");
		// print_r($expConProdTot);
		// die;

		// COMMENTED THESE LINES FOR NOW LATER WILL BE UNCOMMENTED
		// Uday Shankar Singh @30th May 2014
		// if (trim($romTotalForAllMineral) != trim($expConProdTot)) {
		// //        if($gradeTotalCheck != $romData){
		// //        return $this->renderText("bothVary");
		// //      }
		// return $this->renderText("singleVary");
		// }
		// print_r("--->");
		// print_r($romTotalForAllMineral);
		// die;
        //====================CHECKING FOR ERROR IN ALL ABOVE PAGES=================
        $annualError = Array();
        if ($nameAndAddress != 0) {
            $annualError[] = "Please enter Name and Address details in Part I";
        }
        if ($particular != 0) {
            $annualError[] = "Please enter particulars of area operated details in Part I";
        }
        if ($areaUtilisation != 0) {
            $annualError[] = "Please enter lease area utilisation details in Part I";
        }
        if ($wageErrorCount != 0 || $wagesFromWorkStoppage != 0) {
            $annualError[] = "Please enter employment & wages (I) in Part II";
        }
        if ($employment != 0) {
            $annualError[] = "Please enter employment & wages (II) in Part II";
        }
        if ($capitalError != 0) {
            $annualError[] = "Please enter capital structure details in Part II";
        }
        if ($quantity != 0) {
            $annualError[] = "Please enter quantity and cost of material details in Part III";
        }
        if ($royalityError != 0) {
            $annualError[] = "Please enter royalty/compensation/depriciation details in Part III";
        }
        if ($taxError != 0) {
            $annualError[] = "Please enter taxes/other expenses details in Part III";
        }
		
        /**
         * COMMENTED THE BELOW LINE AND REMOVE THE  $explosiveReturn != 0 CONDITION
         * AS THE VALIDATION HAS BEEN CHANGED 
         * NOW WE ONLY HAVE TO CHECK "QUANTITY CONSUMED DURING THE YEAR"
         * AS PER THE GUIDANCE GIVEN BY IBM, SO NO NEED TO CHECK THIS 
         * ANY MORE
         * 
         * @author Uday Shankar Singh<using@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 26th Feb 2014 
         */
		// if ($explosiveReturn != 0 && $expConError != 0) {
		if ($expConError != 0) {
			$annualError[] = "Please enter explosive consumption details in Part IV";
		}
		// if ($geoPart1Error == 0) {
			// $annualError[] = "Please enter Sec 1/2 details for all minerals in Part V";
		// }

		// if ($geoPart2Error != 0) {
		// 	$annualError[] = "Please enter Sec 4 details in Part V";
		// }

		// if ($mineralRejects != 0) {
		// 	$annualError[] = "Please enter Sec 4 - Mineral Rejects for all mineral in Part V";
		// }

		// if ($geoPart3Error != 0) {
		// 	$annualError[] = "Please enter Sec 5/6/8/9 details in Part V";
		// }
		// if ($geoPart4Error != 0) {
		// 	$annualError[] = "Please enter Sec 3 details for all minerals in Part V";
		// }

		
		if ($geoExpRecord == 0) {
			$annualError[] = "Please enter Sec 1 details in Part V";
		}

		if ($geoResSubgradeRecordError != 0) {
			$annualError[] = "Please enter Sec 2/3 details for all minerals in Part V";
		}

		if ($geoOverburdTreeRecord == 0) {
			$annualError[] = "Please enter Sec 4/5 details in Part V";
		}

		if ($geoPartThreeRecord == 0) {
			$annualError[] = "Please enter Sec 6 details in Part V";
		}

		if ($geoPartSixRecordError != 0) {
			$annualError[] = "Please enter Sec 7 details for all minerals in Part V";
		}

		if ($prodCost == 0) {
			$annualError[] = "Please enter Cost of Production details in Part VII";
		}
		
        /* if ($geoPartSaleError != 0) {
          $annualError[] = "Please enter sales/dispatches for all mineral";
          } */
        //==============================COMMON PART=================================
        //check rom
        $is_submitted = Array();
        $is_submitted['rom'] = $this->Prod1->isFilled($mineCode, $returnDate, $returnType, $mineMinerals);
		
        //check gradewise production
        /**
         * 
         * @author Uday Shankar Singh
         * @version 10th June 2014
         * 
         * ADDED THE BELOW CALL TO FUNCTION removeTableExtraRowsForIronOre() TO REMOVE THE RECORDS THAT ARE EXTRA IN GRADE_PROD TABLE
         * THE EXTRA RECORDS COMES WHEN THE USER FIRST CHECKED HEMATITE AND THEN WENT TO GRADE WISE PRODUCTION FORM
         * AT THAT TIME SOME ROWS ARE DEFAULT GETS INSERTED INTO THE GRADE_PROD TABLE.
         * AND THEN IF USER GOES BACK AND DE-SELECT THE HEMATITE AND SELECTED THE MEGNATITE AT THAT TIME THE HEMATITTE REDCORDS ARE
         * WASTE OR EXTRA IN THE GRADE_PROD TABBLE, SO THE BELOW LOGIC WILL REMOVE THOSE EXTRA ROWS OF HEMATITE
         * 
         * THIS IS THE ONLY WAY IS AM ABLE TO THINK RIGHT NOW, AS THE TIME IS A CONSTRAINT THESE DAYS
         * LATER CAN BE IMPLEMENTED IN BETTER WAY IS POSSIBLE
         * 
         */
        $this->GradeProd->removeTableExtraRowsForIronOre($mineCode, $returnDate, $returnType);
        $is_submitted['grade_wise'] = $this->GradeProd->isFilled($mineCode, $returnDate, $returnType, $is_hematite, $is_magnetite);
        //check deduction details
        $is_submitted['deduction'] = $this->Prod1->isDeductionFilled($mineCode, $returnDate, $returnType, $is_hematite, $is_magnetite);
        //check sales and despatches - Dont need to check the sales and dispatch entry  

        $error_msg = Array();
        if ($is_submitted['rom'] != 0) {
            foreach ($is_submitted['rom'] as $r) {
                $error_msg[] = "Please enter ROM details for " . ucwords(str_replace('_', ' ', $r));
            }
        }
        if ($is_submitted['grade_wise'] != 0) {
            foreach ($is_submitted['grade_wise'] as $g) {
                if (strtolower($g) == "mica")
                    $error_msg[] = "Please enter production, despatches & stocks for Mica";
                else
                    $error_msg[] = "Please enter gradewise production details for " . ucwords(str_replace('_', ' ', $g));
            }
        }
        if ($is_submitted['deduction'] != 0) {
            foreach ($is_submitted['deduction'] as $g) {
                $error_msg[] = "Please enter deduction details for " . ucwords(str_replace('_', ' ', $g));
            }
        }

        //extra forms check
        foreach ($mineMinerals as $m) {
            $formNo = $this->DirMcpMineral->getFormNumber($m);
            if ($formNo == 8) {
                $is_pulverised = $this->Pulverisation->chkPulRecord($mineCode, $returnType, $returnDate, $m);
                if ($is_pulverised == false)
                    $error_msg[] = "Please enter pulverization details for " . ucwords(str_replace('_', ' ', $m));
            } else if ($formNo == 5) {
                //for ex mine price
                $is_exmine_filled = $this->Prod5->isFilled($mineCode, $returnDate, $returnType, $m);
                if ($is_exmine_filled != 0)
                    $error_msg[] = "Please enter ex-mine price for " . ucwords(str_replace('_', ' ', $m));

                //for conReco
                $is_conreco_filled = $this->RomMetal5->isFilled($mineCode, $returnDate, $returnType, $m);

                if ($is_conreco_filled != 0)
                    $error_msg[] = "Please enter recovery at concentrator details for " . ucwords(str_replace('_', ' ', $m));

                //for smelter
                $is_smelter_filled = $this->RecovSmelter->isFilled($mineCode, $returnDate, $returnType, $m);
                if ($is_smelter_filled != 0)
                    $error_msg[] = "Please enter recovery at smelter details for " . ucwords(str_replace('_', ' ', $m));

                //for sales
                $is_sales_filled = $this->Sale5->isFilled($mineCode, $returnDate, $returnType, $m);
                if ($is_sales_filled != 0)
                    $error_msg[] = "Please enter recovery at sales(metal/byproduct) details for " . ucwords(str_replace('_', ' ', $m));
            }
        }
		

        if (count($annualError) == 0 && count($error_msg) == 0) {
			// Below functionality now call after successfull esigning.
			// Commented on 02-03-2022 by AG.
			/*
            //primary form no
            $primaryMineral = $mineMinerals[0];
            $primaryFormNo = $this->DirMcpMineral->getFormNumber($primaryMineral);

            //$remove_record = TBL_FINAL_SUBMITTable::removeFinalSubmit($this->app_id, $this->submitted_by, $this->returnDate);
            $update_record = $this->TblFinalSubmit->updateLastSubmittedRecord($app_id, $submitted_by, $mineCode, $returnDate, $returnType);

			$newEntity = $this->TblFinalSubmit->newEntity(array(
				'applicant_id'=>$app_id,
				'submitted_by'=>$submitted_by,
				'mine_code'=>$mineCode,
				'return_date'=>$returnDate,
				'return_type'=>$returnType,
				'form_type'=>$primaryFormNo,
				'created_at'=>date('Y-m-d H:i:s'),
				'status_date'=>date('Y-m-d'),
				'is_latest'=>'1'
			));
			$this->TblFinalSubmit->save($newEntity);

			// send sms 
			// $customer_id ='';
			// $this->loadModel('DirSmsEmailTemplates');
			// $this->DirSmsEmailTemplates->sendMessage(7,$customer_id);

            $mine_id = $app_id;
            $checkMineExistence = $this->TblAllocationDetails->checkMineExistence($mine_id);
            if ($checkMineExistence == 0) {
				
				$tblAllocEntity = $this->TblAllocationDetails->newEntity(array(
					'mine_id' => $mine_id,
					'pri_flag' => 'n',
					'sup_flag' => 'n'
				));
				$this->TblAllocationDetails->save($tblAllocEntity);

            }
			*/
        }
		
        //==========================================================================
        //=======================CHECK THE ERROR MESSAGE ARRAY======================
        if (count($annualError) > 0) {
            $errors = implode('|', $annualError);
            echo $errors;
        }
        if (count($error_msg) > 0) {
            $commonErrors = implode('|', $error_msg);
            echo $commonErrors;
        }

        // $errors = implode('|', $error_msg);
        // echo $errors;

    }

	/**
     * GET NEXT SECTION LINK FOR REDIRECTION PURPOSE
     * @version 01st Nov 2021
	 * @author Aniket Ganvir
     */
    public function findNextSection($section_url){
		//echo $section_url; exit;
		// /monthly/rom_stocks/MANGANESE_ORE

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
	 * REMOVE APPLICANT COMMUNICATION REPLY THROUGH AJAX CALL
	 * @addedon: 08th APR 2021 (by Aniket Ganvir)
	 */
	public function removeComment()
	{

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$result = $this->TblFinalSubmit->remReplyAnnual($this->request->getData());
			echo $result;
		}
	}

}

?>