<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Network\Email\Email;
use Cake\ORM\Entity;
use Cake\ORM\Locator\LocatorAwareTrait;

class MonthlyController extends AppController
{

	var $name = 'Monthly';
	var $uses = array();

	public function beforeFilter(EventInterface $event)
	{
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
		$this->loadComponent('Validate');
		$this->viewBuilder()->setHelpers(['Form', 'Html']);
		$this->Session = $this->getRequest()->getSession();
		$this->DirCountry = $this->getTableLocator()->get('DirCountry');
		$this->DirDistrict = $this->getTableLocator()->get('DirDistrict');
		$this->DirMcpMineral = $this->getTableLocator()->get('DirMcpMineral');
		$this->DirMetal = $this->getTableLocator()->get('DirMetal');
		$this->DirMineralGrade = $this->getTableLocator()->get('DirMineralGrade');
		$this->DirProduct = $this->getTableLocator()->get('DirProduct');
		$this->DirRomGrade = $this->getTableLocator()->get('DirRomGrade');
		$this->DirWorkStoppage = $this->getTableLocator()->get('DirWorkStoppage');
		$this->Employment = $this->getTableLocator()->get('Employment');
		$this->ExplosiveReturn = $this->getTableLocator()->get('ExplosiveReturn');
		$this->GradeProd = $this->getTableLocator()->get('GradeProd');
		$this->GradeRom = $this->getTableLocator()->get('GradeRom');
		$this->GradeSale = $this->getTableLocator()->get('GradeSale');
		$this->IncrDecrReasons = $this->getTableLocator()->get('IncrDecrReasons');
		$this->KwClientType = $this->getTableLocator()->get('KwClientType');
		$this->McApplicantDet = $this->getTableLocator()->get('McApplicantDet');
		$this->McUser = $this->getTableLocator()->get('McUser');
		$this->Mine = $this->getTableLocator()->get('Mine');
		$this->MineralWorked = $this->getTableLocator()->get('MineralWorked');
		$this->MiningPlan = $this->getTableLocator()->get('MiningPlan');
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

		if (null == $this->getRequest()->getSession()->read('lang')) {
			$this->getRequest()->getSession()->write('lang', 'english');
		}

		$this->Customfunctions->formReturnTitle();
	}

	/**
	 * function to add selected menu's part ID, form Id and mineral name
	 * to the session and redirect to page
	 * @added on: 26th FEB 2021 (by Aniket Ganvir)
	 */
	public function activeForm($partId, $formId, $mineralName = null)
	{

		$this->Session->write('partId', $partId);
		$this->Session->write('formId', $formId);
		$this->Session->write('mineralName', $mineralName);
		$this->redirect(array('controller' => 'monthly', 'action' => 'fOne'));
	}



	/**
	 * GET RETURN MONTH AND YEAR
	 * @addedon: 26th FEB 2021 (by Aniket Ganvir)
	 */
	public function selectReturn()
	{

		$this->viewBuilder()->setLayout('mc_panel');

		if (null !== $this->Session->read('mc_form_type') && $this->Session->read('mc_form_type') == 6) {
			$this->redirect(array('controller'=>'auth', 'action'=>'home'));
		}
		
		$this->Session->delete('is_all_approved');
		
		$mineCode = $this->Session->read('mc_mine_code');
		$fileReturnYear = $this->TblFinalSubmit->getFileReturnYear($mineCode);
		$this->set('file_return_year', $fileReturnYear);
		$this->set('mine_code', $mineCode);

		if ($this->request->is('post')) {

			// destroy previous session variables
			$this->Session->delete('form_status');
			$this->Session->delete('secStatus');
			$this->Session->delete('approved_sections');
			$this->Session->delete('rejected_reasons');
			$this->Session->write('section_mode', 'edit');

			$selMonth = htmlentities($this->request->getData('month'), ENT_QUOTES);
			$selYear = htmlentities($this->request->getData('year'), ENT_QUOTES);

			$postDataStatus = $this->Customfunctions->selectReturnValidation($this->request->getData());

			if ($postDataStatus) {

				$alert_message = $postDataStatus;
				$alert_redirect_url = 'selectReturn';
			} else {

				$returnDate = $selYear . '-' . $selMonth . '-01';
				$returnType = 'MONTHLY';

				$finalSubmiStatus = $this->checkFinalSubmit($returnDate);

				if ($finalSubmiStatus == true) {

					$alert_message = "This month's return has been already submitted.";
					$alert_redirect_url = 'selectReturn';
				} else {

					$this->Session->write('mc_sel_month', $selMonth);
					$this->Session->write('mc_sel_year', $selYear);
					$this->Session->write('returnDate', date('Y-m-d', strtotime($returnDate)));
					$this->Session->write('returnType', $returnType);
					$this->Session->write('color_code', 'show');

					$this->redirect('/monthly/mine');
				}
			}

			// set variables to show popup messages from view file
			$this->set('alert_message', $alert_message);
			$this->set('alert_redirect_url', $alert_redirect_url);
		}
	}


	public function monthlyReturns($mine_code, $return_month, $return_year, $return_type, $action = 'read')
	{

		if (str_contains($mine_code, 'SPRblock')) { // for end user

			$mine_code = str_replace('SPR', '/', $mine_code);
			$form_name = 'instruction';
			$user_type = 'enduser';
			$controller = 'enduser';
		} else { // for mine user

			$form_name = 'mine';
			$user_type = 'authuser';
			$controller = 'monthly';
		}

		$date = trim($return_month) . ' 01 ' . trim($return_year);
		$return_month = date('m', strtotime($date));
		$return_year = trim($return_year);
		$return_date = $return_year . "-" . $return_month . "-01";

		if ($user_type == 'authuser') {
			$returnId = $this->TblFinalSubmit->getLatestReturnId($mine_code, $return_date, $return_type);
			$this->backReturns(base64_encode($returnId), $action);
		} else {
			$returnId = $this->TblEndUserFinalSubmit->getLatestReturnId($mine_code, $return_date, $return_type);
			$this->backReturnsEndUser(base64_encode($returnId), $action);
		}

		//fetch applicant id
		$applicantid = $this->TblFinalSubmit->getReturnApplicantId($mine_code, $return_date, $return_type);

		$mineral_name = $this->MineralWorked->getMineralName($mine_code);
		$form_type = $this->DirMcpMineral->getFormNumber($mineral_name);
		$form_one = array('1', '2', '3', '4', '8');
		if (in_array($form_type, $form_one)) {
			$form_main = '1';
		} else if ($form_type == '5') {
			$form_main = '2';
		} else if ($form_type == '7') {
			$form_main = '3';
		} else {
			if ($user_type != 'enduser') {
				$this->set('message', 'Invalid form type');
				$this->set('redirect_to', 'login');
				$this->render('/element/message_box');
				return false;
			}
		}

		$this->Session->write('color_code', 'show');

		$this->Session->write('mc_form_main', $form_main);

		$this->Session->write('applicantid', $applicantid['applicant_id']);
		$this->Session->write('mc_mine_code', $mine_code);
		$this->Session->write('returnDate', $return_date);
		$this->Session->write('returnType', $return_type);
		$this->Session->write('mc_sel_year', $return_year);
		$this->Session->write('mc_sel_month', $return_month);
		$this->Session->write('lang', 'english');
		$this->Session->write('form_status', $action);
		$this->Session->write('view_user_type', $user_type);
		$this->Session->write('report_home_page', 'monthyreturn/allreturns');
		if ($this->Session->read('loginusertype') == 'primaryuser') {
			// Added below variable for Mine Owner application viewing purpose - Aniket G [16-01-2023]
			$this->Session->write('registration_code', $mine_code);
			$this->loadModel('McUser');
			$regNo = $this->McUser->getAppIdWithRegNo($mine_code);
			$this->Session->write('regNo', $regNo);

			if($user_type == 'enduser'){
				$activityType = $this->McUser->getActivityType($mine_code);
				$this->Session->write('activityType', $activityType);
			}
		}
		$this->redirect(array('controller' => $controller, 'action' => $form_name));
	}

	/**
	 * Show PDF for older returns i.e. before MCDR 2017 get's in effect
	 * @version 29th Nov 2021
	 * @author Aniket Ganvir
	 */
	public function monthlyReturnsPdf($mine_code, $return_month, $return_year, $return_type, $action = 'read')
	{

		if (str_contains(strtolower($mine_code), 'sprblock')) { // for end user
			$mine_code = str_replace('SPR', '/', $mine_code);
			$user_type = 'enduser';
			$pdf_action = 'enduserPrintPdfOld';
		} else { // for mine user
			$user_type = 'authuser';
			$pdf_action = 'minerPrintPdfOld';
		}

		$date = trim($return_month) . ' 01 ' . trim($return_year);
		$return_month = date('m', strtotime($date));
		$return_year = trim($return_year);
		$return_date = $return_year . "-" . $return_month . "-01";

		if ($user_type == 'authuser') {
			$returnId = $this->TblFinalSubmit->getLatestReturnId($mine_code, $return_date, $return_type);
			$this->backReturns(base64_encode($returnId), $action);
		} else {
			$returnId = $this->TblEndUserFinalSubmit->getLatestReturnId($mine_code, $return_date, $return_type);
			$this->backReturnsEndUser(base64_encode($returnId), $action);
		}

		//fetch applicant id
		$applicantid = $this->TblFinalSubmit->getReturnApplicantId($mine_code, $return_date, $return_type);

		$mineral_name = $this->MineralWorked->getMineralName($mine_code);
		$form_type = $this->DirMcpMineral->getFormNumber($mineral_name);
		$form_one = array('1', '2', '3', '4', '8');
		if (in_array($form_type, $form_one)) {
			$form_main = '1';
		} else if ($form_type == '5') {
			$form_main = '2';
		} else if ($form_type == '7') {
			$form_main = '3';
		} else if ($form_type == '6') {
			$form_main = '0';
		} else {
			if ($user_type != 'enduser') {
				$this->set('message', 'Invalid form type');
				$this->set('redirect_to', 'login');
				$this->render('/element/message_box');
				return false;
			}
		}

		//========CONTAINS THE LIST OF ALL THE MINERAL OF THE PARTICULAR MINE=======
		$minerals = $this->MineralWorked->fetchMineralInfo($mine_code);
		foreach ($minerals as $mineral) {
			$mineralArr[] = $mineral['mineral_name'];
		}

		$mineralWorked = $this->MineralWorked->getMineralName($mine_code);

		$this->Session->write('mineralArr', $mineralArr);
		$this->Session->write('mc_mineral', $mineralWorked);

		$this->Session->write('mc_form_main', $form_main);

		$this->Session->write('applicantid', $applicantid['applicant_id']);
		$this->Session->write('mc_mine_code', $mine_code);
		$this->Session->write('returnDate', $return_date);
		$this->Session->write('returnType', $return_type);
		$this->Session->write('mc_sel_year', $return_year);
		$this->Session->write('mc_sel_month', $return_month);
		$this->Session->write('lang', 'english');
		$this->Session->write('form_status', $action);
		$this->Session->write('view_user_type', $user_type);
		$this->Session->write('report_home_page', 'monthyreturn/allreturns');
		$this->redirect(array('controller' => 'Returnspdf', 'action' => $pdf_action));
	}

	/**
	 * Checks if the return has been already final submitted or not
	 * @param type $returnDate
	 */
	public function checkFinalSubmit($returnDate)
	{

		$user_id = $this->Session->read('username');
		$user = $this->McUser->getUserDatabyId($user_id);
		$mineCode = $user['mcu_mine_code'];

		$result = false;

		$is_final_submitted = $this->TblFinalSubmit->checkIsSubmitted($mineCode, $returnDate, 'MONTHLY');

		if ($is_final_submitted == true) {
			$result = true;
		}

		return $result;
	}

	public function getRejectedReasons($mineCode, $returnDate, $min = '', $subMin = '', $section)
	{

		// $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
		$return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate);
		$reasons = array();
		foreach ($return_id as $r) {
			$reasons[] = $this->TblFinalSubmit->getReason($r['id'], $min, $subMin, $section);
		}

		return $reasons;
	}


	//Update mine details by ajax
	public function mineUpdates($var1, $val1, $var2, $val2)
	{

		$this->autoRender = false;

		$newFaxNo = ($var2 == 'F') ? $val2 : "";
		$newPhoneNo = ($var2 == 'P') ? $val2 : "";
		$newMobileNo = ($var2 == 'M') ? $val2 : "";
		$newEMail = ($var2 == 'E') ? $val2 : "";

		$newAFaxNo = ($var2 == 'FA') ? $val2 : "";
		$newAPhoneNo = ($var2 == 'PA') ? $val2 : "";
		$newAMobileNo = ($var2 == 'MA') ? $val2 : "";
		$newAEMail = ($var2 == 'EA') ? $val2 : "";

		$mineCode = ($var1 == 'MC') ? $val1 : "";

		$replyMsg = '';

		if ($newFaxNo != '' && $mineCode != '') {
			if ((!is_numeric($newFaxNo)) || strlen($newFaxNo) > 15 || strlen($newFaxNo) < 1) {
				$replyMsg = "Fax number is not valid.";
			} else {
				$replyMsg = $this->Mine->changeFaxNo($newFaxNo, $mineCode);
			}
		} elseif ($newPhoneNo != '' && $mineCode != '') {
			if ((!is_numeric($newPhoneNo)) || strlen($newPhoneNo) > 15 || strlen($newPhoneNo) < 8) {
				$replyMsg = "Phone number is not valid.";
			} else {
				$replyMsg = $this->Mine->changePhoneNo($newPhoneNo, $mineCode);
			}
		} elseif ($newMobileNo != '' && $mineCode != '') {
			if ((!is_numeric($newMobileNo)) || strlen($newMobileNo) > 15 || strlen($newMobileNo) < 8) {
				$replyMsg = "Mobile number is not valid.";
			} else {
				$replyMsg = $this->Mine->changeMobileNo($newMobileNo, $mineCode);
			}
		} elseif ($newEMail != '' && $mineCode != '') {
			if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $newEMail)) {
				$replyMsg = "e-mail is not valid.";
			} else {
				$replyMsg = $this->Mine->changeEMail($newEMail, $mineCode);
			}
		// } elseif ($newAFaxNo != '' && $mineCode != '') {
		} elseif ($mineCode != '') {
			// if ((!is_numeric($newAFaxNo)) || strlen($newAFaxNo) > 15 || strlen($newAFaxNo) < 8) {
			if (($newAFaxNo != '' && (!is_numeric($newAFaxNo))) || strlen($newAFaxNo) > 15) {
				$replyMsg = "Fax number is not valid.";
			} else {
				$replyMsg = $this->Mine->changeAFaxNo($newAFaxNo, $mineCode);
			}
		} elseif ($newAPhoneNo != '' && $mineCode != '') {
			if ((!is_numeric($newAPhoneNo)) || strlen($newAPhoneNo) > 15 || strlen($newAPhoneNo) < 8) {
				$replyMsg = "Phone number is not valid.";
			} else {
				$replyMsg = $this->Mine->changeAPhoneNo($newAPhoneNo, $mineCode);
			}
		} elseif ($newAMobileNo != '' && $mineCode != '') {
			if ((!is_numeric($newAMobileNo)) || strlen($newAMobileNo) > 15 || strlen($newAMobileNo) < 8) {
				$replyMsg = "Mobile number is not valid.";
			} else {
				$replyMsg = $this->Mine->changeAMobileNo($newAMobileNo, $mineCode);
			}
		} elseif ($newAEMail != '' && $mineCode != '') {
			if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $newAEMail)) {
				$replyMsg = "e-mail is not valid.";
			} else {
				$replyMsg = $this->Mine->changeAEMail($newAEMail, $mineCode);
			}
		} else {
			$replyMsg = "Invalid Data";
		}
		echo $replyMsg;
	}


	// PART I: mine details
	public function mine()
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		//check second mineral to redirect
		$partId = $this->Session->read('partId');
		$mine_code = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mine_code);

		$labels = $this->Language->getFormInputLabels('mine', $lang);

		// CREATE HTML FORM STRUCTURE BY PASSING ARRAYS DATA
		// @addedon: 03rd MAR 2021 (by Aniket Ganvir)
		$tableForm = $this->Formcreation->formTableArr($formId, $lang);
		$jsonTableForm = json_encode($tableForm);

		//fetching mine details : by natarajan
		$mine = $this->Mine->getMineDetails($mine_code);
		$mineCode = $this->Session->read('mc_mine_code');

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "") {
			$returnType = 'MONTHLY';
		}

		$formNo = $this->Session->read('mc_form_type');
		$returnYear = $this->Session->read('mc_sel_year');
		$returnMonth = $this->Session->read('mc_sel_month');
		$returnDate = $returnYear . '-' . $returnMonth . '-01';

		$this->set('label', $labels);
		$this->set('tableForm', $jsonTableForm);
		$this->set('mine', $mine);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);

		$this->loadModel('MineralWorked');
		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

		if (null !== $this->request->getQuery('iron_sub_min')) {
			$ironSubMin = $this->request->getQuery('iron_sub_min');
			$ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
		} else {
			$ironSubMin = "";
			$ironSubMinStr = '';
		}

		$count = 0;
		$chkReturnsRcd1 = true;
		$isExists = $this->Mine->checkMine($mineCode);

		$section_mode = $this->Session->read('section_mode');

		//mine details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], '', '', 1, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if (isset($approvedSections['partI'][1]) && $approvedSections['partI'][1] == "Rejected") {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, '', '', 1, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, '', '', 1, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('mineral', '');
			$this->set('sub_min', '');
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '1');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][1] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);
		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->render('/element/monthly/forms/mine_details');

		if ($this->request->is('post')) {

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData());
				$result = $this->Mine->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					// $app_sec_new = $this->Session->read('app_sec_new');
					// $app_sec_new['partI'][1] = 'Filled';
					// $this->Session->write('app_sec_new', $app_sec_new);

					$this->Session->write('mon_f_suc', 'Reply saved in <b>Details of the Mine</b> successfully!');
					$this->redirect(array('controller' => 'monthly', 'action' => 'name_address'));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Details of the Mine</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'mine'));
				}
			} else {
				$result = $this->Mine->saveFormDetails($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Details of the Mine</b> successfully saved!');
					$this->redirect(array('controller' => 'monthly', 'action' => 'name_address'));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Details of the Mine</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'mine'));
				}
			}
		}
	}

	// PART I: name and address
	public function nameAddress()
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		//check second mineral to redirect
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$returnType = $this->Session->read('returnType');
		$returnType = ($returnType == "") ? 'MONTHLY' : $returnType;
		$returnYear = $this->Session->read('mc_sel_year');
		$returnMonth = $this->Session->read('mc_sel_month');
		$returnDate = $returnYear . '-' . $returnMonth . '-01';
		$annualReturnDate = $returnYear . '-04-01';

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('name_address', $lang);

		//fetching owner details : by natarajan
		$owner = $this->Mine->getMineOwnerDetails($mineCode, $annualReturnDate);

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('owner', $owner);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('annualReturnDate', $annualReturnDate);
		$this->set('formNo', $formNo);

		if ($returnType == 'ANNUAL') {
			$returnYear = $this->Session->read('mc_sel_year');
			$max_date = ($returnYear + 1) . '-03-01';
			$max_date = date('Y-m-t', strtotime($max_date));
			$this->set('max_date', $max_date);
		}

		$this->loadModel('MineralWorked');
		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);

		$section_mode = $this->Session->read('section_mode');

		//name and address edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], '', '', 2, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if (isset($approvedSections['partI'][2]) && $approvedSections['partI'][2] == "Rejected") {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, '', '', 2, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, '', '', 2, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('mineral', '');
			$this->set('sub_min', '');
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '2');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][2] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);
		$this->set('section_mode', $section_mode);
		$this->set('returnDate', $returnDate);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('tableForm', null);
		$this->render('/element/monthly/forms/name_address');

		if ($this->request->is('post')) {

			$nextSection = $this->findNextSection('/monthly/name_address');
			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData());
				$result = $this->Mine->saveOwnerFormDetails($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Name &amp; Address details</b> successfully!');
					$nextAction = ($returnType == 'MONTHLY') ? 'rent' : 'particulars';
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Name &amp; Address details</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'name_address'));
				}
			} else {
				$result = $this->Mine->saveOwnerFormDetails($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Name &amp; Address details</b> successfully saved!');
					$nextAction = ($returnType == 'MONTHLY') ? 'rent' : 'particulars';
					// $this->redirect(array('controller'=>strtolower($returnType),'action'=>$nextAction));
					// $this->redirect(array('controller'=>'monthly','action'=>'name_address'));
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Name &amp; Address details</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'name_address'));
				}
			}
		}
	}

	// PART I: details of rent/royalty
	public function rent()
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		//check second mineral to redirect
		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('rent', $lang);

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		$returnDate = $this->Session->read('returnDate');
		$returnType = $this->Session->read('returnType');

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnDate', $returnDate);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

		$this->loadModel('MineralWorked');
		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

		if (null !== $this->request->getQuery('iron_sub_min')) {
			$ironSubMin = $this->request->getQuery('iron_sub_min');
			$ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
		} else {
			$ironSubMin = "";
			$ironSubMinStr = '';
		}

		$isExists = $this->Mine->checkMine($mineCode);

		$section_mode = $this->Session->read('section_mode');

		//rent details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], '', '', 3, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if ((isset($approvedSections['partI'][3])) && $approvedSections['partI'][3] == "Rejected") {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, '', '', 3, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, '', '', 3, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('mineral', '');
			$this->set('sub_min', '');
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '3');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][3] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$rentDetail = $this->RentReturns->getRentReturnsDetails($mineCode, $returnType, $returnDate);

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);
		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('rentDetail', $rentDetail);
		$this->set('tableForm', '');

		$this->render('/element/monthly/forms/rent_details');

		if ($this->request->is('post')) {

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->RentReturns->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					// $app_sec_new = $this->Session->read('app_sec_new');
					// $app_sec_new['partI'][3] = 'Filled';
					// $this->Session->write('app_sec_new', $app_sec_new);

					$this->Session->write('mon_f_suc', 'Reply saved in <b>Rent Details</b> successfully!');
					$this->redirect(array('controller' => 'monthly', 'action' => 'working_detail'));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Rent Details</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'rent'));
				}
			} else {
				$result = $this->RentReturns->saveFormDetails($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Rent Details</b> successfully saved!');
					$this->redirect(array('controller' => 'monthly', 'action' => 'working_detail'));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Rent Details</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'rent'));
				}
			}
		}
	}

	// PART I: details on working
	public function workingDetail()
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		//check second mineral to redirect
		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('working_detail', $lang);

		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('reasonsArr', $reasonsArr);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);

		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

		$returnYear = $this->Session->read('mc_sel_year');
		$returnMonth = $this->Session->read('mc_sel_month');
		$returnDate = $returnYear . '-' . $returnMonth . '-01';

		if (null !== $this->request->getQuery('iron_sub_min')) {
			$ironSubMin = $this->request->getQuery('iron_sub_min');
			$ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
		} else {
			$ironSubMin = "";
			$ironSubMinStr = '';
		}

		$isExists = $this->Mine->checkMine($mineCode);

		$section_mode = $this->Session->read('section_mode');

		//working details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], '', '', 4, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if (isset($approvedSections['partI'][4]) && $approvedSections['partI'][4] == "Rejected") {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, '', '', 4, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, '', '', 4, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('mineral', '');
			$this->set('sub_min', '');
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '4');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][4] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$return_m = date('m', strtotime($returnDate));
		$return_Y = date('Y', strtotime($returnDate));
		$month_days = cal_days_in_month(CAL_GREGORIAN, $return_m, $return_Y);

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);
		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$workDetail = $this->WorkStoppage->fetchWorkingDetails($mineCode, $returnType, $returnDate);
		$this->set('workDetail', $workDetail);
		$this->set('month_days', $month_days);
		$this->set('tableForm', '');

		$this->render('/element/monthly/forms/working_details');

		if ($this->request->is('post')) {

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->WorkStoppage->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Details on Working</b> successfully!');
					$this->redirect(array('controller' => 'monthly', 'action' => 'daily_average'));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Details on Working</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'working_detail'));
				}
			} else {
				$result = $this->WorkStoppage->saveFormDetails($this->request->getData());

				if ($result['err'] == 1) {
					$this->Session->write('mon_f_suc', '<b>Details on Working</b> successfully saved!');
					$this->redirect(array('controller' => 'monthly', 'action' => 'daily_average'));
				} else {
					$this->Session->write('mon_f_err', $result['msg']);
					$this->redirect(array('controller' => 'monthly', 'action' => 'working_detail'));
				}
			}
		}
	}

	// PART I: average daily employment
	public function dailyAverage()
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		//check second mineral to redirect
		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('daily_average', $lang);

		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('reasonsArr', $reasonsArr);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);

		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

		if (null !== $this->request->getQuery('iron_sub_min')) {
			$ironSubMin = $this->request->getQuery('iron_sub_min');
			$ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
		} else {
			$ironSubMin = "";
			$ironSubMinStr = '';
		}

		$isExists = $this->Mine->checkMine($mineCode);

		$openCastId = '5';
		$belowId = '1';
		$aboveId = '9';

		$section_mode = $this->Session->read('section_mode');

		//avg details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], '', '', 5, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if (isset($approvedSections['partI'][5]) && $approvedSections['partI'][5] == "Rejected") {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, '', '', 5, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, '', '', 5, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('returnDate', $returnDate);
			$this->set('mineral', '');
			$this->set('sub_min', '');
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '5');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][5] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$returnMonth = $this->Session->read('mc_sel_month');
		$returnYear = $this->Session->read('mc_sel_year');
		$returnMonthTotalDays = cal_days_in_month(CAL_GREGORIAN, $returnMonth, $returnYear);

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);
		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$openArr = $this->Employment->fetchEmpWageDetails($mineCode, $returnType, $returnDate, $openCastId);
		$belowArr = $this->Employment->fetchEmpWageDetails($mineCode, $returnType, $returnDate, $belowId);
		$aboveArr = $this->Employment->fetchEmpWageDetails($mineCode, $returnType, $returnDate, $aboveId);
		$this->set('openArr', $openArr);
		$this->set('belowArr', $belowArr);
		$this->set('aboveArr', $aboveArr);

		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('openCastId', $openCastId);
		$this->set('belowId', $belowId);
		$this->set('aboveId', $aboveId);
		$this->set('returnMonthTotalDays', $returnMonthTotalDays);
		$this->set('tableForm', null);

		$this->render('/element/monthly/forms/daily_average');

		if ($this->request->is('post')) {

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->Employment->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					// $app_sec_new = $this->Session->read('app_sec_new');
					// $app_sec_new['partI'][5] = 'Filled';
					// $this->Session->write('app_sec_new', $app_sec_new);

					$this->Session->write('mon_f_suc', 'Reply saved in <b>Average Daily Employment</b> successfully!');
					$this->redirect($this->Session->read('sec_link.part_2.0'));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Average Daily Employment</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'daily_average'));
				}
			} else {
				$result = $this->Employment->saveFormDetails($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Average Daily Employment</b> successfully saved!');
					// $this->redirect(array('controller'=>'monthly','action'=>'daily_average'));
					$this->redirect($this->Session->read('sec_link.part_2.0'));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Average Daily Employment</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'daily_average'));
				}
			}
		}
	}


	// PART II: type of ore
	public function oreType($mineral, $sub_min = '')
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineral = str_replace(' ', '_', strtolower($mineral));

		$mineralArr = $this->Session->read('mineralArr');
		$primary_mineral = $mineralArr[0];
		$formNumber = $this->DirMcpMineral->getFormNumber($primary_mineral);
		$returnType = $this->Session->read('returnType');
		//$formLabelNameWithFormNo = $this->Clscommon->getFormLabelNameWithFormNo($formNumber, $returnType);
		//$this->set('FormLabelNameWithFormNo',$formLabelNameWithFormNo);

		//check second mineral to redirect
		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('ore_type', $lang, $this->Session->read('mc_form_type'));

		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');

		if ($returnType == 'ANNUAL') {
			//check ore type selected value for in monthly returns for annual returns
			$selectedOreType = $this->Prod1->getMonSubOreType($mineCode, $returnType, $returnDate, $mineral);
			$is_hematite = $selectedOreType['hematite'] > 0 ? true : false;
			$is_magnetite = $selectedOreType['magnetite'] > 0 ? true : false;
			$this->set('is_hematite', $is_hematite);
			$this->set('is_magnetite', $is_magnetite);
		}

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('reasonsArr', $reasonsArr);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);



		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

		if (null !== $sub_min) {
			$ironSubMin = $sub_min;
			$ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
		} else {
			$ironSubMin = "";
			$ironSubMinStr = '';
		}

		$count = 0;
		$chkReturnsRcd1 = true;
		$isExists = $this->Mine->checkMine($mineCode);

		$section_mode = $this->Session->read('section_mode');

		//avg details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$viewOnly = true;
		$reasons = array();
		$is_rejected_section = '';

		$this->set('viewOnly', $viewOnly);
		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);


		if ($ironSubMin != '') {
			$chkProdRcd = $this->Prod1->chkProdDetails($mineCode, $returnType, $returnDate, $mineral, $ironSubMin);
		} else {
			$chkProdRcd = $this->Prod1->chkProdDetails($mineCode, $returnType, $returnDate, $mineral, '');
		}

		if ($chkProdRcd == true && $chkReturnsRcd1 == true) {

			if ($ironSubMin != '') {
				$prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, $ironSubMin);
			} else {
				$prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '');
			}

			$prodId = $prodArr['id'];
			$objProd = $this->Prod1->findOneById($prodId);
			$prodRecCnt = $this->Prod1->prodRecCount($mineCode, $returnType, $returnDate, $mineral);

			$objProdHematite = '0';
			$objProdMagnetite = '0';
			if ($prodRecCnt > 1) { //-- UDAY SHANKAR SINGH.. OK SO HERE THE LOGIC AS PER MY KNOWLEDGE IS
				$objProdHematite = '1';             // AS THERE WILL BE ONE ENTRY OF HEMATITE AND ONE FOR MAGNETITE SO THE COUNT IN THAT
				$objProdMagnetite = '1';           // CASE WILL BE > 1, SO THIS GUY IS CHECKING IF BOTH THE MINERAL ARE SELECTED AND IF YES HE IS SETTING THEM.. I HATE THIS ... ARMATURES
			}

			/**
			 * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
			 * @dated 15th Jan 2014
			 *
			 * ADDED THIS AS THE ABOVE CONDITION IS IF BOTH THE MINERALS ARE SELECTED
			 * AND NOW THE PROBLEM IS IF ONE MINERAL IS SELECTED, STILL BOTH THE CHECKBOX ARE
			 * SELECTED AS THEIR VALUES ARE SET TO 1 IN FORM ITSELF
			 *
			 * SO, I WILL FIND WHICH OF THE ONE IS SELECTED AND THEN I WILL MAKE THE OTHER ONE
			 * UN SELECTED USING FORCING IT TO DO SO USING JQUERY........COOOOLLLLLLLLLL
			 *
			 */
			$isHematite = $objProdHematite;
			$isMagnetite = $objProdMagnetite;
		}

		$formType = $this->DirMcpMineral->getFormNumber($mineral);

		//if ore is not selected redirect them (only for iron ore)
		if ($mineral == "iron ore") {
			$is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, $mineral);
			if ($is_ore_exists == false) {
				echo 'Please select the type of ore';
				// redirect to "SELECT ORE" page
			}
		}

		$is_rejected_section = '';

		/**
		 * ADDED BY UDAY
		 * FOR ANNUAL RETURNS
		 * GETS THE DATA FROM THE EXPLOSIVE CONSUMPTION AND THEN COMPARE THEM WITH THE
		 * VALUE ENTERED IN THE ROM TABLE FIELD, IF THE FIELD VALUE DOESN'T MATCH
		 * A ALERT WILL POP-UP
		 */
		$explosiveData = $this->ExplosiveReturn->getExplosiveReturnRecords($mineCode, $returnDate, $returnType);
		$explosiveTotalRomOre = $explosiveData['TOTAL_ROM_ORE'];
		//===========explosive consumption value getting ends here============

		$prev_month = date('Y-m-d', strtotime(date("Y-m-d", strtotime($returnDate)) . " -1 month"));

		//GETTING THE ESTIMATED PRODUCTION AND CUMULATIVE PRODUCTION FROM PREVIOUS PRODUCTION
		$returnYear = $this->Session->read('mc_sel_year');
		$returnMonth = $this->Session->read('mc_sel_month');
		$estProd = $this->MiningPlan->getEstimatedProd($mineCode, $mineral, $ironSubMin, $returnYear, $returnDate);
		$cumProd = $this->MiningPlan->getCumProd($mineCode, $mineral, $ironSubMin, $returnYear, $returnMonth, $returnType);

		// FOR DISPLAYING ON THE PRODUCTION TABLE----- ADDED BY UDAY
		$mineralName = $mineral;
		$prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '');

		$this->set('tableForm', '');
		$this->set('prev_month', $prev_month);
		$this->set('estProd', $estProd);
		$this->set('cumProd', $cumProd);
		$this->set('prodArr', $prodArr);
		$this->set('mineralName', $mineralName);
		$this->set('ironSubMin', $ironSubMin);
		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);

		$this->render('/element/monthly/forms/ore_type');

		if ($this->request->is('post')) {


			$f_hematite = $this->request->getData('f_hematite');
			$f_magnetite = $this->request->getData('f_magnetite');

			// if ($returnType == 'ANNUAL') {
			// 	$invalidOreType = $f_hematite == $is_hematite && $f_magnetite == $is_magnetite ? true : false;
			// 	if ($invalidOreType ==  false) {
			// 		$this->Session->write('mon_f_err', 'Failed to update <b>Type of Ore</b>! Please, try again later.');
			// 		$this->redirect(array('controller' => 'monthly', 'action' => 'ore_type', str_replace('_', ' ', $mineral), $sub_min));
			// 		return null;
			// 	}
			// }

			$sub_min_link = ($sub_min == '') ? '' : '/' . $sub_min;
			$nextSection = $this->findNextSection('/monthly/ore_type/' . strtoupper($mineral) . $sub_min_link); // get next sectinn url for redirection

			if ($this->request->getData('submit') == 'save_comment') {

				$sub_min = ($f_hematite == 1) ? 'hematite' : (($f_magnetite == 1) ? 'magnetite' : '');

				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				// $result = $this->Prod1->saveFormDetails($this->request->getData());
				$result = $this->Prod1->updateOreType($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Production/Stocks (ROM)</b> successfully!');
					$this->redirect(array('controller' => 'monthly', 'action' => 'rom_stocks', $mineral, $sub_min));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Production/Stocks (ROM)</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'rom_stocks', $mineral, $sub_min));
				}
			} else {

				$sub_min = ($f_hematite == 1) ? 'hematite' : (($f_magnetite == 1) ? 'magnetite' : '');
				$result = $this->Prod1->updateOreType($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Type of Ore</b> successfully saved!');
					$this->redirect(array('controller' => 'monthly', 'action' => 'rom_stocks', str_replace('_', ' ', $mineral), $sub_min));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Type of Ore</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'ore_type', str_replace('_', ' ', $mineral), $sub_min));
				}
			}
		}
	}

	// PART II: production / stoks ROM
	public function romStocks($mineral, $sub_min = '')
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineral = str_replace(' ', '_', strtolower($mineral));
		$min_und_low = str_replace(' ', '_', strtolower($mineral));

		//check second mineral to redirect
		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('formId');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('rom_stocks', $lang, $this->Session->read('mc_form_type'));

		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('reasonsArr', $reasonsArr);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);

		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

		if (null !== $sub_min) {
			$ironSubMin = $sub_min;
			$ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
		} else {
			$ironSubMin = "";
			$ironSubMinStr = '';
		}

		$count = 0;
		$chkReturnsRcd1 = true;
		$isExists = $this->Mine->checkMine($mineCode);

		$section_mode = $this->Session->read('section_mode');

		//avg details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$mineral_sp = str_replace('_', ' ', $mineral); //mineral name with space
		$reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], $mineral_sp, $sub_min, 1, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if ((isset($approvedSections[$min_und_low][1]) && $approvedSections[$min_und_low][1] == "Rejected") || (isset($approvedSections[$min_und_low][$sub_min][1]) && $approvedSections[$min_und_low][$sub_min][1] == "Rejected")) {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $sub_min, 1, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $sub_min, 1, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('returnDate', $returnDate);
			$this->set('mineral', $mineral_sp);
			$this->set('sub_min', $sub_min);
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '1');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][5] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);


		if ($ironSubMin != '') {
			$chkProdRcd = $this->Prod1->chkProdDetails($mineCode, $returnType, $returnDate, $mineral, $ironSubMin);
		} else {
			$chkProdRcd = $this->Prod1->chkProdDetails($mineCode, $returnType, $returnDate, $mineral, '');
		}

		if ($chkProdRcd == true && $chkReturnsRcd1 == true) {

			if ($ironSubMin != '') {
				$prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, $ironSubMin);
			} else {
				$prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '');
			}

			$prodId = $prodArr['id'];
			$objProd = $this->Prod1->findOneById($prodId);
			$prodRecCnt = $this->Prod1->prodRecCount($mineCode, $returnType, $returnDate, $mineral);

			// $isHematite = $objProd['hematite'];
			// $isMagnetite = $objProd['magnetite'];

		}

		//ROM edit form

		$formType = $this->DirMcpMineral->getFormNumber($mineral);

		//if ore is not selected redirect them (only for iron ore)
		if (str_replace(' ', '_', $mineral) == "iron_ore") {
			$is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, str_replace(' ', '_', $mineral));
			if ($is_ore_exists == false) {
				$this->Session->write('mon_f_err', 'Please select the type of ore');
				$this->redirect(array('controller' => 'monthly', 'action' => 'ore_type', str_replace('_', ' ', $mineral), $sub_min));
			}
		}

		//check is rejected or approved section
		// if ($mineral == "iron_ore") {
		//     if ($approvedSections[$mineral][$ironSubMin][1] == "Rejected") {
		//         $is_rejected_section = 1;
		//         $reasons = $this->getRejectedReasons($mineCode, $returnDate, $mineral, $ironSubMin, 1);
		//     } else if ($approvedSections[$mineral][$ironSubMin][1] == "Approved") {
		//         $is_rejected_section = 2;
		//     }
		// } else {
		//     if ($approvedSections[$mineral][1] == "Rejected") {
		//         $is_rejected_section = 1;
		//         $reasons = $this->getRejectedReasons($mineCode, $returnDate, $mineral, '', 1);
		//     } else if ($approvedSections[$mineral][1] == "Approved") {
		//         $is_rejected_section = 2;
		//     }
		// }
		$is_rejected_section = '';

		/**
		 * ADDED BY UDAY
		 * FOR ANNUAL RETURNS
		 * GETS THE DATA FROM THE EXPLOSIVE CONSUMPTION AND THEN COMPARE THEM WITH THE
		 * VALUE ENTERED IN THE ROM TABLE FIELD, IF THE FIELD VALUE DOESN'T MATCH
		 * A ALERT WILL POP-UP
		 */
		$explosiveData = $this->ExplosiveReturn->getExplosiveReturnRecords($mineCode, $returnDate, $returnType);
		$explosiveTotalRomOre = $explosiveData['TOTAL_ROM_ORE'];
		//===========explosive consumption value getting ends here============

		$prev_month = date('Y-m-d', strtotime(date("Y-m-d", strtotime($returnDate)) . " -1 month"));

		//GETTING THE ESTIMATED PRODUCTION AND CUMULATIVE PRODUCTION FROM PREVIOUS PRODUCTION
		$returnYear = $this->Session->read('mc_sel_year');
		$returnMonth = $this->Session->read('mc_sel_month');
		$estProd = $this->MiningPlan->getEstimatedProd($mineCode, $mineral, $ironSubMin, $returnYear, $returnDate);
		$cumProd = $this->MiningPlan->getCumProd($mineCode, $mineral, $ironSubMin, $returnYear, $returnMonth, $returnType);

		// FOR DISPLAYING ON THE PRODUCTION TABLE----- ADDED BY UDAY
		$mineralName = $mineral;
		$prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, $sub_min);

		$this->set('tableForm', '');
		$this->set('prev_month', $prev_month);
		$this->set('estProd', $estProd);
		$this->set('cumProd', $cumProd);
		$this->set('prodArr', $prodArr);
		$this->set('mineralName', $mineralName);
		$this->set('ironSubMin', $ironSubMin);
		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);

		$this->render('/element/monthly/forms/rom_stocks');

		$sub_min_url = ($sub_min == null) ? '' : '/' . strtolower($sub_min);

		if ($this->request->is('post')) {

			$nextSection = $this->findNextSection('/monthly/rom_stocks/' . str_replace('_', ' ', strtoupper($mineral)) . $sub_min_url); // get next sectinn url for redirection

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->Prod1->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Production/Stocks (ROM)</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Production/Stocks (ROM)</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'rom_stocks', $mineral_sp, $sub_min));
				}
			} else {
				$result = $this->Prod1->saveFormDetails($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Production/Stocks (ROM)</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Production/Stocks (ROM)</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'rom_stocks', $mineral, $sub_min));
				}
			}
		}
	}

	// PART II: Grade-Wise Production
	public function gradewiseProd($mineral, $ironSubMin = null)
	{
		
		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineral = strtolower($mineral);
		$minUndLow = str_replace(' ', '_', $mineral); //mineral underscore lowercase
		$sub_min = $ironSubMin;

		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('mc_form_type');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode, $mineral);

		$labels = $this->Language->getFormInputLabels('gradewise_prod', $lang, $this->Session->read('mc_form_type'), $this->Session->read('mc_mineral'));

		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "") {
			$returnType = 'MONTHLY';
		}

		$formNo = $this->Session->read('mc_form_type');
        

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('reasonsArr', $reasonsArr);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);
		$this->set('lang', $lang);
		$this->set('mineral', $mineral);
		$this->set('returnMonth', $this->Session->read('mc_sel_month'));
		$this->set('returnYear', $this->Session->read('mc_sel_year'));

		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
         

		$count = 0;
		$chkReturnsRcd1 = true;
		$isExists = $this->Mine->checkMine($mineCode);

		$section_mode = $this->Session->read('section_mode');

        
		//if sales/dispatches is fill selected redirect them (only for sales/dispatches)
        
		$sales_dispatches_exists = $this->GradeSale->chkSalesRecord($mineCode, $returnType, $returnDate,str_replace(' ', '_', $mineral));
		 
		
		 if ($sales_dispatches_exists == false) {
			 

			
				$this->Session->write('mon_f_err', 'First, you need to fill out the sales and dispatch option.');
				return $this->redirect(array('controller' => 'monthly', 'action' => 'sale_despatch', str_replace('_', ' ',strtoupper($mineral)), $sub_min));
			}
		
         // print_r('Ankush');die;
		//avg details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$mineral_sp = str_replace('_', ' ', $mineral); //mineral name with space
		$min_und_low = strtolower(str_replace(' ', '_', $mineral)); //mineral underscore lowercase
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], $min_und_low, $sub_min, 2, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if ((isset($approvedSections[$min_und_low][2]) && $approvedSections[$min_und_low][2] == "Rejected") || (isset($approvedSections[$min_und_low][$sub_min][2]) && $approvedSections[$min_und_low][$sub_min][2] == "Rejected")) {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, $min_und_low, $sub_min, 2, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, $min_und_low, $sub_min, 2, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('returnDate', $returnDate);
			$this->set('mineral', $min_und_low);
			$this->set('sub_min', $sub_min);
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '2');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][5] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);

		//if ore is not selected redirect them (only for iron ore)
		if (str_replace(' ', '_', $mineral) == "iron_ore") {
			$is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, str_replace(' ', '_', $mineral));
			if ($is_ore_exists == false) {
				$this->Session->write('mon_f_err', 'Please select the type of ore');
				$this->redirect(array('controller' => 'monthly', 'action' => 'ore_type', str_replace('_', ' ', $mineral), $sub_min));
			}
		}

		//Gradewise edit form
		//check is rejected or approved section
		// if ($mineral == "iron_ore") {
		//     if ($approvedSections[$mineral][$ironSubMin][2] == "Rejected") {
		//         $is_rejected_section = 1;
		//         $reasons = $this->getRejectedReasons($mineCode, $returnDate, $mineral, $ironSubMin, 2);
		//     } else if ($approvedSections[$mineral][$ironSubMin][2] == "Approved") {
		//         $is_rejected_section = 2;
		//     }
		// } else {
		//     if ($approvedSections[$mineral][2] == "Rejected") {
		//         $is_rejected_section = 1;
		//         $reasons = $this->getRejectedReasons($mineCode, $returnDate, $mineral, '', 2);
		//     } else if ($approvedSections[$mineral][2] == "Approved") {
		// $is_rejected_section = 2;
		//     }
		// }

		// get Grade wise ROM details, Done By Pravin Bhakare, 9/9/2020
		$prodRomGradeArray = $this->DirRomGrade->getGradsArrByMin(strtoupper(str_replace('_', ' ', $mineral)));

		$grdFrmName = 'A';
		$gf = 1;
		foreach ($prodRomGradeArray as $romGradeKey => $romGradeVal) {

			$chkGradeRom = $this->GradeRom->chkGradeWiseRom($mineCode, $returnType, $returnDate, $mineral, $romGradeVal['id'], $ironSubMin);
			if ($chkGradeRom == true && $chkReturnsRcd1 == true) {
				$gradeRomArr = $this->GradeRom->fetchGradeWiseRom($mineCode, $returnType, $returnDate, $mineral, $romGradeVal['id'], $ironSubMin);
				$openGradeRomId = $gradeRomArr['id'];
				$objGradeRom = $this->GradeRom->findOneById($openGradeRomId);
			} else {
				// $objGradeRom = new GRADE_ROM();
				// $objGradeRom->MINE_CODE = $this->mineCode;
				// $objGradeRom->RETURN_TYPE = $this->returnType;
				// $objGradeRom->RETURN_DATE = $this->returnDate;
				// $objGradeRom->MINERAL_NAME = $this->mineral;
				// $objGradeRom->GRADE_CODE = $romGradeVal['ID'];
				// $objGradeRom->IRON_TYPE = $this->ironSubMin;
				// $objGradeRom->save();
			}

			// $tmpGradeRomFormName = "gradeRomForm" . $gf;
			// $$tmpGradeRomFormName = new gradeRomForm($objGradeRom, array('g_form_name' => $grdFrmName));
			$grdFrmName++;
			$gf++;
		}

		// get product grade name in Hindi Version, Done By Pravin Bhakare, 03-09-2020
		$prodGradeArrayInHindi = $this->DirMineralGrade->getGradsArrByMinInHindi(strtoupper(str_replace('_', ' ', $mineral)));

		$prodGradeArray = $this->DirMineralGrade->getGradsArrByMin(strtoupper(str_replace('_', ' ', $mineral)), $returnDate);
		// THIS IS FOR THE GETTING THE COUNT FOR RUNNING THE LOOP OF LUMP AND FINES THAT IS USED
		// TO CALULATE THE TOTAL EXCEPT CONCENTRATE
		$lumpsCount = (isset($prodGradeArray['lumps']) && null !== $prodGradeArray['lumps']) ? count($prodGradeArray['lumps']) : 0;
		$finesCount = (isset($prodGradeArray['fines']) && null !== $prodGradeArray['fines']) ? count($prodGradeArray['fines']) : 0;
		$prodGradeArrayCount = $lumpsCount + $finesCount;

		//if F3, show the average column in the table
		$formNo = $this->DirMcpMineral->getFormNumber($mineral);

		//prev_month is to get the opening stock for the last month
		$prev_month = date('Y-m-d', strtotime(date("Y-m-d", strtotime($returnDate)) . " -1 month"));

		$chFrmName = '0';
		$i = 1;
		$gradesArr = array();
		foreach ($prodGradeArray as $gradeKey => $gradeVal) {
			foreach ($gradeVal as $gradeId => $gradeLbl) {
				$tmpChkGrade = "chkGrade" . $i;

				$chkGrade = $this->GradeProd->chkGradeWiseProd($mineCode, $returnType, $returnDate, $mineral, $gradeId, $ironSubMin);

				$gradeArr = $this->GradeProd->fetchGradeWiseProd($mineCode, $returnType, $returnDate, $mineral, $gradeId, $ironSubMin);
				$openGradeId = $gradeArr['id'];
				$gradesArr[$i] = $gradeArr;
				$objGrade = $this->GradeProd->findOneById($openGradeId);

				// $tmpGradeFormName = "gradeForm" . $i;
				// $$tmpGradeFormName = new gradeProdForm($objGrade, array('form_name' => $chFrmName));
				$chFrmName++;
				$i++;
			}
		}
		
		

		// $tmpGradeFormName = "gradeForm" . $i;
		// $this->$tmpGradeFormName = new gradeProdReasonForm($objGrade);
		/** **** Used for the hidden fields for the validation purpose ****** */

		$prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, $ironSubMin);
		$openOcRom = $prodArr['open_oc_rom'];
		$prodOcRom = $prodArr['prod_oc_rom'];
		$closeOcRom = $prodArr['clos_oc_rom'];
		$openUgRom = $prodArr['open_ug_rom'];
		$prodUgRom = $prodArr['prod_ug_rom'];
		$closeUgRom = $prodArr['clos_ug_rom'];
		$openDwRom = $prodArr['open_dw_rom'];
		$prodDwRom = $prodArr['prod_dw_rom'];
		$closeDwRom = $prodArr['clos_dw_rom'];

		// get gradewise data
		$chemRep = $this->Clscommon->getChemRep($mineral);
		$gradeWiseArrRom = array();
		$gradesArrayRom = array();
		$prevClStockRom = array();
		$gradeWiseArr = array();
		$gradesArray = array();
		$prevClStock = array();
		$mineralArr = $this->Session->read('mineralArr');

		if (in_array($minUndLow, array('iron_ore', 'chromite'))) {

			if ($minUndLow == "iron_ore") {
				if ($ironSubMin == 'hematite') {
					$gradeWiseArrRom['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetailsRom($mineCode, $returnType, $returnDate, "iron ore", "hematite");
					$gradeWiseArrRom['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMinRom($mineral);

					$prevClStockRom = $this->GradeProd->getPrevClosingStocks($mineCode, $returnType, $returnDate, $mineral, 'hematite');
					if (empty($gradeWiseArrRom['gradeProd']['gradeValues'])) {
						foreach ($gradeWiseArrRom['gradeProd']['gradeNames'] as $gradeKey => $gradeVal) {
							foreach ($gradeVal as $subgradeKey => $subgradeVal) {
								$gradeWiseArrRom['gradeProd']['gradeValues'][$subgradeKey] = ['id' => '', 'opening_stock' => (isset($prevClStockRom[$subgradeKey]['closing_stock'])) ? $prevClStockRom[$subgradeKey]['closing_stock'] : '', 'production' => '', 'despatches' => '', 'closing_stock' => '', 'pmv' => '', 'reason_1' => null, 'reason_2' => null, 'average_grade' => null];
							}
						}
					}
				}
				if ($ironSubMin == 'magnetite') {
					$gradeWiseArrRom['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetailsRom($mineCode, $returnType, $returnDate, "iron ore", "magnetite");
					$gradeWiseArrRom['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMinRom($mineral);

					$prevClStockRom = $this->GradeProd->getPrevClosingStocks($mineCode, $returnType, $returnDate, $mineral, 'magnetite');
					if (empty($gradeWiseArrRom['gradeProd']['gradeValues'])) {
						foreach ($gradeWiseArrRom['gradeProd']['gradeNames'] as $gradeKey => $gradeVal) {
							foreach ($gradeVal as $subgradeKey => $subgradeVal) {
								$gradeWiseArrRom['gradeProd']['gradeValues'][$subgradeKey] = ['id' => '', 'opening_stock' => (isset($prevClStockRom[$subgradeKey]['closing_stock'])) ? $prevClStockRom[$subgradeKey]['closing_stock'] : '', 'production' => '', 'despatches' => '', 'closing_stock' => '', 'pmv' => '', 'reason_1' => null, 'reason_2' => null, 'average_grade' => null];
							}
						}
					}
				}
			} else {
				$gradeWiseArrRom['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMinRom($mineral);
				$gradeWiseArrRom['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetailsRom($mineCode, $returnType, $returnDate, $mineral);
				$prevClStockRom = $this->GradeProd->getPrevClosingStocks($mineCode, $returnType, $returnDate, $mineral);
				if (empty($gradeWiseArrRom['gradeProd']['gradeValues'])) {
					foreach ($gradeWiseArrRom['gradeProd']['gradeNames'] as $gradeKey => $gradeVal) {
						foreach ($gradeVal as $subgradeKey => $subgradeVal) {
							$gradeWiseArrRom['gradeProd']['gradeValues'][$subgradeKey] = ['id' => '', 'opening_stock' => (isset($prevClStockRom[$subgradeKey]['closing_stock'])) ? $prevClStockRom[$subgradeKey]['closing_stock'] : '', 'production' => '', 'despatches' => '', 'closing_stock' => '', 'pmv' => '', 'reason_1' => null, 'reason_2' => null, 'average_grade' => null];
						}
					}
				}
			}
		}

		if ($minUndLow == "iron_ore") {
			if ($ironSubMin == 'hematite') {
				$gradeWiseArr['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, "iron ore", "hematite");
				$gradeWiseArr['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMin($mineral, $returnDate, $mineralArr[0]);

				$prevClStock = $this->GradeProd->getPrevClosingStocks($mineCode, $returnType, $returnDate, $mineral, 'hematite');
				if (empty($gradeWiseArr['gradeProd']['gradeValues'])) {
					foreach ($gradeWiseArr['gradeProd']['gradeNames'] as $gradeKey => $gradeVal) {
						foreach ($gradeVal as $subgradeKey => $subgradeVal) {
							$gradeWiseArr['gradeProd']['gradeValues'][$subgradeKey] = ['id' => '', 'opening_stock' => (isset($prevClStock[$subgradeKey]['closing_stock'])) ? $prevClStock[$subgradeKey]['closing_stock'] : '', 'production' => '', 'despatches' => '', 'closing_stock' => '', 'pmv' => '', 'reason_1' => null, 'reason_2' => null, 'average_grade' => null];
						}
					}
				}
			}
			if ($ironSubMin == 'magnetite') {
				$gradeWiseArr['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, "iron ore", "magnetite");
				$gradeWiseArr['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMin($mineral, $returnDate, $mineralArr[0]);

				$prevClStock = $this->GradeProd->getPrevClosingStocks($mineCode, $returnType, $returnDate, $mineral, 'magnetite');
				if (empty($gradeWiseArr['gradeProd']['gradeValues'])) {
					foreach ($gradeWiseArr['gradeProd']['gradeNames'] as $gradeKey => $gradeVal) {
						foreach ($gradeVal as $subgradeKey => $subgradeVal) {
							$gradeWiseArr['gradeProd']['gradeValues'][$subgradeKey] = ['id' => '', 'opening_stock' => (isset($prevClStock[$subgradeKey]['closing_stock'])) ? $prevClStock[$subgradeKey]['closing_stock'] : '', 'production' => '', 'despatches' => '', 'closing_stock' => '', 'pmv' => '', 'reason_1' => null, 'reason_2' => null, 'average_grade' => null];
						}
					}
				}
			}
		} else {
			$gradeWiseArr['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMin($mineral, $returnDate, $mineralArr[0]);
			$gradeWiseArr['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, $mineral);
			$prevClStock = $this->GradeProd->getPrevClosingStocks($mineCode, $returnType, $returnDate, $mineral);
			if (empty($gradeWiseArr['gradeProd']['gradeValues'])) {
				foreach ($gradeWiseArr['gradeProd']['gradeNames'] as $gradeKey => $gradeVal) {
					foreach ($gradeVal as $subgradeKey => $subgradeVal) {
						$gradeWiseArr['gradeProd']['gradeValues'][$subgradeKey] = ['id' => '', 'opening_stock' => (isset($prevClStock[$subgradeKey]['closing_stock'])) ? $prevClStock[$subgradeKey]['closing_stock'] : '', 'production' => '', 'despatches' => '', 'closing_stock' => '', 'pmv' => '', 'reason_1' => null, 'reason_2' => null, 'average_grade' => null];
					}
				}
			}
		}

		$this->set('prevClStockRom', $prevClStockRom);
		$this->set('prevClStock', $prevClStock);
		if (!empty($gradeWiseArrRom)) {
			foreach ($gradeWiseArrRom['gradeProd']['gradeNames'] as $gradeLblKey => $gradeLblVal) {
				foreach ($gradeLblVal as $grKey => $grVal) {
					$gradesArrayRom[$grKey] = $grVal;
				}
			}
		}
		if (!empty($gradeWiseArr)) {
			foreach ($gradeWiseArr['gradeProd']['gradeNames'] as $gradeLblKey => $gradeLblVal) {
				foreach ($gradeLblVal as $grKey => $grVal) {
					$gradesArray[$grKey] = $grVal;
				}
			}
		}

		$this->set('gradeWiseProdRom', $gradeWiseArrRom);
		$this->set('gradesArrayRom', $gradesArrayRom);

		$this->set('gradeWiseProd', $gradeWiseArr);
		$this->set('gradesArray', $gradesArray);

		$this->set('prev_month', $prev_month);

		$this->set('openOcRom', $openOcRom);
		$this->set('prodOcRom', $prodOcRom);
		$this->set('closeOcRom', $closeOcRom);
		$this->set('openUgRom', $openUgRom);
		$this->set('prodUgRom', $prodUgRom);
		$this->set('closeUgRom', $closeUgRom);
		$this->set('openDwRom', $openDwRom);
		$this->set('prodDwRom', $prodDwRom);
		$this->set('closeDwRom', $closeDwRom);

		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('prodRomGradeArray', $prodRomGradeArray);
		$this->set('prodGradeArray', $prodGradeArray);
		$this->set('prodGradeArrayInHindi', $prodGradeArrayInHindi);
		$this->set('prodGradeArrayCount', $prodGradeArrayCount);
		$this->set('primaryMineral', $primaryMineral);
		$this->set('gradesArr', $gradesArr);
		$this->set('ironSubMin', $ironSubMin);
		$this->set('tableForm', '');

		$this->render('/element/monthly/forms/grade_wise_production');

		$ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;

		if ($this->request->is('post')) {

			$nextSection = $this->findNextSection('/monthly/gradewise_prod/' . str_replace('_', ' ', strtoupper($mineral)) . $ironSubMin); // get next sectinn url for redirection

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->GradeProd->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Grade-Wise Production</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Grade-Wise Production</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'gradewise_prod', $mineral_sp, $sub_min));
				}
			} else {
				$result = $this->GradeProd->saveFormDetails($this->request->getData());

				if ($result['err'] == 1) {
					$this->Session->write('mon_f_suc', $result['msg']);
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', $result['msg']);
					$this->redirect(array('controller' => 'monthly', 'action' => 'gradewise_prod', $mineral, $sub_min));
				}
			}
		}
	}

	// PART II: Pulverisation
	public function pulverisation($mineral, $ironSubMin = null)
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineral = strtolower($mineral);
		$min_und_low = str_replace(' ', '_', strtolower($mineral));

		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('mc_form_type');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('pulverisation', $lang);

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);
		$this->set('lang', $lang);
		$this->set('mineral', $mineral);
		$this->set('returnMonth', $this->Session->read('mc_sel_month'));
		$this->set('returnYear', $this->Session->read('mc_sel_year'));

		$chkPulRcd = $this->Pulverisation->chkPulRecord($mineCode, $returnType, $returnDate, $mineral);
		$pulArr = $this->Pulverisation->fetchPulRcd($mineCode, $returnType, $returnDate, $mineral);
		$recCount = count($pulArr);
		$grade = $this->Clscommon->getGradeArr(strtoupper(str_replace('_', ' ', $mineral)), $returnDate);

		$pulArr = $this->Pulverisation->fetchPulRcd($mineCode, $returnType, $returnDate, $mineral);
		$pulId = (isset($pulArr[0])) ? $pulArr[0]['id'] : ''; //for hidden field of first row
		$pulRecords = $pulArr;
		$isPulverised = $this->Pulverisation->isPulverised($mineCode, $returnType, $returnDate, $mineral);

		$pulverArr = $this->Pulverisation->getPulverData($mineCode, $returnType, $returnDate, $mineral);

		// CREATE HTML FORM STRUCTURE BY PASSING ARRAYS DATA
		// @addedon: 22nd MAR 2021 (by Aniket Ganvir)
		$tableForm = array();
		$rowArr[0] = $pulverArr;
		$rowArr[1] = $grade;
		$tableForm[] = $this->Formcreation->formTableArr('pulverisation', $lang, $rowArr);
		$jsonTableForm = json_encode($tableForm);

		$this->set('tableForm', $jsonTableForm);

		$section_mode = $this->Session->read('section_mode');

		$sub_min = $ironSubMin;

		//Pulverisation edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$mineral_sp = str_replace('_', ' ', $mineral); //mineral name with space
		$viewOnly = true;
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], $mineral_sp, $sub_min, 5, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if (isset($approvedSections[$min_und_low][5]) && $approvedSections[$min_und_low][5] == "Rejected") {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $sub_min, 5, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $sub_min, 5, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$viewOnly = false;
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('returnDate', $returnDate);
			$this->set('mineral', $mineral_sp);
			$this->set('sub_min', $sub_min);
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '5');
			$this->set('part_no', '');
			// } else if ($approvedSections[$mineral][5] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = '';
		}

		$this->set('viewOnly', $viewOnly);

		// $this->pulverisationForm = new pulverisationForm($objPul, array('mineral_name' => strtoupper(str_replace('_', ' ', $this->mineral))));

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);
		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('pulverArr', $pulverArr);
		$this->set('grade', $grade);
		$this->set('isPulverised', $isPulverised);

		$this->render('/element/monthly/forms/pulverisation');

		$ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;

		if ($this->request->is('post')) {

			$nextSection = $this->findNextSection('/monthly/pulverisation/' . str_replace('_', ' ', strtoupper($mineral)) . $ironSubMin); // get next sectinn url for redirection

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->Pulverisation->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Pulverisation</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Pulverisation</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'pulverisation', $mineral_sp, $sub_min));
				}
			} else {
				$result = $this->Pulverisation->saveFormDetails($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Pulverisation</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Pulverisation</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'pulverisation', $mineral, $sub_min));
				}
			}
		}
	}


	// PART II: Details of Deductions
	public function deductDetail($mineral, $ironSubMin = '')
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineral = str_replace(' ', '_', strtolower($mineral));
		$sub_min = $ironSubMin;
		$min_und_low = str_replace(' ', '_', strtolower($mineral));

		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('mc_form_type');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('deduct_detail', $lang, $this->Session->read('mc_form_type'));

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);
		$this->set('lang', $lang);
		$this->set('mineral', $mineral);
		$this->set('returnMonth', $this->Session->read('mc_sel_month'));
		$this->set('returnYear', $this->Session->read('mc_sel_year'));
         

        //if sales/dispatches is fill selected redirect them (only for sales/dispatches)
        
		$sales_dispatches_exists = $this->GradeSale->chkSalesRecord($mineCode, $returnType, $returnDate,str_replace(' ', '_', $mineral));
		 
		
		 if ($sales_dispatches_exists == false) {
			 

			
				$this->Session->write('mon_f_err', 'First, you need to fill out the sales and dispatch option.');
				 return $this->redirect(array('controller' => 'monthly', 'action' => 'sale_despatch', str_replace('_', ' ',strtoupper($mineral)), $sub_min));
			}

		
		$chkReturnsRcd1 = true;

		$chkProdRcd = $this->Prod1->chkProdDetails($mineCode, $returnType, $returnDate, $mineral, '');

		if ($chkProdRcd == true && $chkReturnsRcd1 == true) {

			$prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '');

			$prodId = $prodArr['id'];
			$objProd = $this->Prod1->findOneById($prodId);
			$prodRecCnt = $this->Prod1->prodRecCount($mineCode, $returnType, $returnDate, $mineral);

			/**
			 * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
			 * @dated 15th Jan 2014
			 *
			 * ADDED THIS AS THE ABOVE CONDITION IS IF BOTH THE MINERALS ARE SELECTED
			 * AND NOW THE PROBLEM IS IF ONE MINERAL IS SELECTED, STILL BOTH THE CHECKBOX ARE
			 * SELECTED AS THEIR VALUES ARE SET TO 1 IN FORM ITSELF
			 *
			 * SO, I WILL FIND WHICH OF THE ONE IS SELECTED AND THEN I WILL MAKE THE OTHER ONE
			 * UN SELECTED USING FORCING IT TO DO SO USING JQUERY........COOOOLLLLLLLLLL
			 *
			 */
			$isHematite = (isset($objProd['hematite'])) ? $objProd['hematite'] : "";
			$isMagnetite = (isset($objProd['magnetite'])) ? $objProd['magnetite'] : "";
		}

		//if ore is not selected redirect them (only for iron ore)
		if (str_replace(' ', '_', $mineral) == "iron_ore") {
			$is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, str_replace(' ', '_', $mineral));
			if ($is_ore_exists == false) {
				$this->Session->write('mon_f_err', 'Please select the type of ore');
				$this->redirect(array('controller' => 'monthly', 'action' => 'ore_type', str_replace('_', ' ', $mineral), $sub_min));
			}
		}

		//Deduction details edit form
		// Below added code and passsing new value for the function for the fetch the form no as per the mineral this use for the sales_despatches section saving the reply.
		// added by ganesh satav dated on the 17 july 2014
		// Start code
		$sectionNoAsPerMin = $this->Clscommon->getFormNoFAndH('TRUE');
		$formNoForDeductionDetRejection =  $sectionNoAsPerMin = $sectionNoAsPerMin['deductions_details'];

		//check is rejected or approved section
		// if ($mineral == "iron_ore") {
		//     if ($approvedSections[$mineral][$ironSubMin][3] == "Rejected") {
		//         $is_rejected_section = 1;
		//         $reasons = $this->getRejectedReasons($mineCode, $returnDate, $mineral, $ironSubMin, 3);
		//     } else if ($approvedSections[$mineral][$ironSubMin][3] == "Approved") {
		//         $is_rejected_section = 2;
		//     }
		// } else {
		//     if ($approvedSections[$mineral][$sectionNoAsPerMin] == "Rejected") {
		//         $is_rejected_section = 1;
		/**
		 * ADDED THE  $formNoForDeductionDetRejection IN THE CALL
		 * EARLIER ONLY 3 WAS PASSING WHICH IS WRONG FOR FORM F5, F6 AND F8
		 * @author Uday Shankar Singh
		 * @version 10th March 2014
		 *
		 */
		// below line use the new variable value so we get the reply message. variable name $sectionNoAsPerMin
		// added by ganesh satav dated on the 21 july 2014
		//         $reasons = $this->getRejectedReasons($mineCode, $returnDate, $mineral, '', $sectionNoAsPerMin);
		//     } else if ($approvedSections[$mineral][$sectionNoAsPerMin] == "Approved") {
		//         $is_rejected_section = 2;
		//     }
		// }

		$section_mode = $this->Session->read('section_mode');

		//change storing format according to form type
		$formNo = $this->DirMcpMineral->getFormNumber($mineral);

		if ($formNo == 6)
			$reason_no = 2;
		else if ($formNo == 5)
			$reason_no = 6;
		else
			$reason_no = 3;

		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$mineral_sp = str_replace('_', ' ', $mineral); //mineral name with space
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], $mineral_sp, $sub_min, $reason_no, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if ((isset($approvedSections[$min_und_low][$reason_no]) && $approvedSections[$min_und_low][$reason_no] == "Rejected") || (isset($approvedSections[$min_und_low][$sub_min][$reason_no]) && $approvedSections[$min_und_low][$sub_min][$reason_no] == "Rejected")) {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $sub_min, $reason_no, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $sub_min, $reason_no, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('returnDate', $returnDate);
			$this->set('mineral', $mineral_sp);
			$this->set('sub_min', $sub_min);
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', $reason_no);
			$this->set('part_no', '');
			// } else if ($approvedSections[$mineral][5] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = '';
		}

		$prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, $ironSubMin, 'deductiondet');

		$prodId = $prodArr['id'];
		$objProd = $this->Prod1->findOneById($prodId);

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);
		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('prodArr', $prodArr);
		$this->set('ironSubMin', $ironSubMin);
		$this->set('tableForm', '');

		$this->render('/element/monthly/forms/deductions_details');

		$sub_min = $ironSubMin;
		$ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;

		if ($this->request->is('post')) {

			$nextSection = $this->findNextSection('/monthly/deduct_detail/' . str_replace('_', ' ', strtoupper($mineral)) . $ironSubMin); // get next sectinn url for redirection

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->Prod1->saveFormDetailsDeduction($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Details of Deductions</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Details of Deductions</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'deduct_detail', $mineral_sp, $sub_min));
				}
			} else {
				$result = $this->Prod1->saveFormDetailsDeduction($this->request->getData());
                // print_r('hello');die;
				if ($result['err'] == 1) {
					$this->Session->write('mon_f_suc', $result['msg']);
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', $result['msg']);
					$this->redirect(array('controller' => 'monthly', 'action' => 'deduct_detail', $mineral_sp, $sub_min));
				}
			}
		}
	}

	// PART II: Sales/Dispatches
	public function saleDespatch($mineral, $ironSubMin = null)
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

        


		$mineral = strtolower($mineral);
		$sub_min = $ironSubMin;
		$min_und_low = str_replace(' ', '_', strtolower($mineral));

		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('mc_form_type');
		$lang = $this->Session->read('lang');

		$this->Customfunctions->executeUserleftnav($mineCode);

		$labels = $this->Language->getFormInputLabels('sale_despatch', $lang, $this->Session->read('mc_form_type'));

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');
		$mc_form_main = $this->Session->read('mc_form_main');
        // echo '<pre>';print_r($labels);die;
		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);
		$this->set('lang', $lang);
		$this->set('mineral', $mineral);
		$this->set('returnMonth', $this->Session->read('mc_sel_month'));
		$this->set('returnYear', $this->Session->read('mc_sel_year'));
		$this->set('mc_form_main', $mc_form_main);

		$chkReturnsRcd1 = true;
		$grade = $this->Clscommon->getGradeArr(strtoupper(str_replace('_', ' ', $mineral)), $returnDate);
		$unit = $this->DirMcpMineral->getMineralUnit(strtoupper(str_replace('_', ' ', $mineral)));

		/* *** START OF SALES AND DESPATCHES FORM VIEW **** */

		//if ore is not selected redirect them (only for iron ore)
		if (str_replace(' ', '_', $mineral) == "iron_ore") {
			$is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, str_replace(' ', '_', $mineral));
			if ($is_ore_exists == false) {
				$this->Session->write('mon_f_err', 'Please select the type of ore');
				$this->redirect(array('controller' => 'monthly', 'action' => 'ore_type', str_replace('_', ' ', $mineral), $sub_min));
			}
		}

		$chkSalesRcd = $this->GradeSale->chkSalesRecord($mineCode, $returnType, $returnDate, $mineral);
		if ($chkSalesRcd == true && $chkReturnsRcd1 == true) {

			$salesArr = $this->GradeSale->fetchSalesRcd($mineCode, $returnType, $returnDate, $mineral);
			$salesId = $salesArr['id'];
			$objSales = $this->GradeSale->findOneById($salesId);
		}

		//Sales and despatches edit form
		//check is rejected or approved section
		$referedBackStatus = $this->TblFinalSubmit->getreferedBackCount($mineCode, $returnDate, $returnType);

		// Below added code and passsing new value for the function for the fetch the form no as per the mineral this use for the sales_despatches section saving the reply.
		// added by ganesh satav dated on the 17 july 2014
		// Start code
		$sectionNoAsPerMin = $this->Clscommon->getFormNoFAndH('TRUE');
		$formNoForSaleDispRejection =  $sectionNoAsPerMin = $sectionNoAsPerMin['sales_despatches'];

		// if ($mineral == "iron_ore") {
		//     if ($approvedSections[$mineral][$ironSubMin][4] == "Rejected") {
		//         $is_rejected_section = 1;
		//         $reasons = $this->getRejectedReasons($mineCode, $returnDate, $mineral, $ironSubMin, 4);
		//     } else if ($approvedSections[$mineral][$ironSubMin][4] == "Approved") {
		//         $is_rejected_section = 2;
		//     }
		// } else {

		// 	if ($approvedSections[$mineral][$sectionNoAsPerMin] == "Rejected") {
		//         $is_rejected_section = 1;
		/**
		 * ADDED THE  $formNoForDeductionDetRejection IN THE CALL
		 * EARLIER ONLY 4 WAS PASSING WHICH IS WRONG FOR FORM F5, F6 AND F8
		 * @author Uday Shankar Singh
		 * @version 10th March 2014
		 *
		 */
		//         	// below line use the new variable value so we get the reply message. variable name $sectionNoAsPerMin
		//           // added by ganesh satav dated on the 21 july 2014
		//         $reasons = $this->getRejectedReasons($mineCode, $returnDate, $mineral, '', $sectionNoAsPerMin);
		//   		// end code
		// 	} else if ($approvedSections[$mineral][$sectionNoAsPerMin] == "Approved") {
		//     	$is_rejected_section = 2;
		//     }
		// }

		//change storing format according to form type
		$formNo = $this->DirMcpMineral->getFormNumber($mineral);
		if ($formNo == 6)
			$reason_no = 3;
		else if ($formNo == 5)
			$reason_no = 7;
		else
			$reason_no = 4;

		$section_mode = $this->Session->read('section_mode');

		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$mineral_sp = str_replace('_', ' ', $mineral); //mineral name with space
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], $mineral_sp, $sub_min, $reason_no, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if ((isset($approvedSections[$min_und_low][$reason_no]) && $approvedSections[$min_und_low][$reason_no] == "Rejected") || (isset($approvedSections[$min_und_low][$sub_min][$reason_no]) && $approvedSections[$min_und_low][$sub_min][$reason_no] == "Rejected")) {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $sub_min, $reason_no, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, $mineral_sp, $sub_min, $reason_no, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('returnDate', $returnDate);
			$this->set('mineral', $mineral_sp);
			$this->set('sub_min', $sub_min);
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', $reason_no);
			$this->set('part_no', '');
			// } else if ($approvedSections[$mineral][5] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = '';
		}

		$gradeSaleArr = $this->GradeSale->fetchSalesData($mineCode, $returnType, $returnDate, $mineral);

		// echo '<pre>'; print_r($gradeSaleArr);die;
		$reasonData = $this->IncrDecrReasons->getAllData($mineCode, $returnType, $returnDate, $mineral);
		$clientType = $this->KwClientType->getAllClientType();
		$countryList = $this->DirCountry->getCountryList();

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);
		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('gradeSaleArr', $gradeSaleArr);
		$this->set('reasonData', $reasonData);
		$this->set('ironSubMin', $ironSubMin);
		
		// to check if Magnetite is selected or not, added on 16-08-2022 by Aniket
		$minMagnetite = $this->Prod1->fetchIronTypeProduction($mineCode, $returnType, $returnDate, 'iron_ore', 'magnetite');
		$isMagnetite = ($minMagnetite == true && in_array(strtolower($mineral), array('iron ore','iron_ore'))) ? true : false;

		// $app_id = $this->McApplicantDet->getAppId();
		// $this->set('appId',$app_id);

		// CREATE HTML FORM STRUCTURE BY PASSING ARRAYS DATA
		// @addedon: 22nd MAR 2021 (by Aniket Ganvir)
		$rowArr[0] = $gradeSaleArr;
		$rowArr[1] = $grade;
		$rowArr[2] = $clientType;
		$rowArr[3] = $countryList;

        // echo '<pre>';print_r($rowArr[0]);die;
		// $tableForm = $this->Formcreation->formTableArr('sale_despatch', $lang, $rowArr);
		// $jsonTableForm = json_encode($tableForm);

		$tableForm = array();
		$tableForm[] = $this->Formcreation->formTableArr('sale_despatch', $lang, $rowArr, $sub_min, $isMagnetite);
		$jsonTableForm = json_encode($tableForm);

         // echo '<pre>';print_r($tableForm);die;
		$this->set('tableForm', $jsonTableForm);

		$this->render('/element/monthly/forms/sales_despatches');

		$sub_min = $ironSubMin;
		$ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;

		if ($this->request->is('post')) {

			$nextSection = $this->findNextSection('/monthly/sale_despatch/' . str_replace('_', ' ', strtoupper($mineral)) . $ironSubMin); // get next section url for redirection

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->GradeSale->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Sales/Dispatches</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Sales/Dispatches</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'sale_despatch', $mineral_sp, $sub_min));
				}
			} else {
				$result = $this->GradeSale->saveFormDetails($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Sales/Dispatches</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Sales/Dispatches</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'sale_despatch', $mineral, $sub_min));
				}
			}
		}
	}


	// PART II: Production and Stocks of ROM ore
	public function romStocksOre($mineral, $ironSubMin = null)
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineral = strtolower($mineral);
		$sub_min = $ironSubMin;
		$min_und_low = str_replace(' ', '_', strtolower($mineral));

		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('mc_form_type');
		$lang = $this->Session->read('lang');
		$returnDate = $this->Session->read('returnDate');
		$returnType = $this->Session->read('returnType');

		$temp = explode('-', $returnDate);
		$returnYear = $temp[0];
		$returnMonth = $temp[1];
		$returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, $returnYear));
		$period = $returnYear . " - " . ($temp[0] + 1);

		$this->Customfunctions->executeUserleftnav($mineCode);

		//====CALCULATING THE ESTIMATED PRODUCTION AND CUMMULATIVE PRODUCTION=======
		$estProd = $this->MiningPlan->getEstimatedProd($mineCode, $mineral, '', $returnYear, $returnDate);
		$cumProd = $this->MiningPlan->getCumProd($mineCode, $mineral, '', $returnYear, $returnMonth);

		// get matals
		$metals = $this->DirMetal->getMetalList();
		$metalArr = [];
		foreach ($metals as $key => $val) {
			$metalArr[$val] = $val;
		}

		//rom data
		$romData = $this->Rom5->getRomData($mineCode, $returnDate, $returnType, $mineral);
		// $romData = json_encode(array_merge($data,array('csrf_code'=>'12')));

		$this->set('period', $period);
		$this->set('estProd', $estProd);
		$this->set('cumProd', $cumProd);
		$this->set('metals', $metalArr);
		$this->set('romData', $romData);

		// get display table data
		// $grade_table = $this->Rom5->getDisplayTableData($mineCode, $returnDate, $returnType, $mineral);
		// $result3 = json_encode(array_merge($grade_table,array('csrf_code'=>'1545')));

		$labels = $this->Language->getFormInputLabels('rom_stocks_ore', $lang);

		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		// if ($approvedSections[$this->mineral][1] == "Rejected") {
		//   $this->is_rejected_section = 1;
		//   $this->rejected_reason = $rejectedReasons[$this->mineral][1];
		// } else if ($approvedSections[$this->mineral][1] == "Approved") {
		//   $this->is_rejected_section = 2;
		// }

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('reasonsArr', $reasonsArr);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);
		$this->set('lang', $lang);
		$this->set('mineral', $mineral);
		$this->set('returnMonth', $this->Session->read('mc_sel_month'));
		$this->set('returnYear', $this->Session->read('mc_sel_year'));

		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

		// if(null!==$this->request->getQuery('iron_sub_min')){
		// 	$ironSubMin = $this->request->getQuery('iron_sub_min');
		//     $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
		// } else {
		// 	$ironSubMin = "";
		//     $ironSubMinStr = '';
		// }

		$count = 0;
		$chkReturnsRcd1 = true;
		$isExists = $this->Mine->checkMine($mineCode);

		$section_mode = $this->Session->read('section_mode');

		/**
		 * ADDED THE $this->returnType IN THE BELOW FUNCTION AS CURRENTLY THE REJECTION OF MONTHLY IS COMING IN REJECTION OF ANNUAL RETURNS
		 * FOR THE MONTH OF APRIL AS THE DATE IS SAME FOR MONTHLY AND ANNUAL FOR THIS MONTH IS SAME
		 * SO PASSING return_type IS NECESSARY.
		 *
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 15th July 2014
		 *
		 **/
		// $return_id = TBL_FINAL_SUBMITTable::getReturnId($this->mineCode, $this->returnDate, $this->returnType);
		// $reasons = array();
		// foreach ($return_id as $r) {
		//   $reasons[] = TBL_FINAL_SUBMITTable::getReason($r['id'], $this->mineral, '', 1);
		// }

		// $this->reasons = $reasons;

		//avg details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], $mineral, '', 1, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if (isset($approvedSections[$min_und_low][1]) && $approvedSections[$min_und_low][1] == "Rejected") {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 1, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 1, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('returnDate', $returnDate);
			$this->set('mineral', $mineral);
			$this->set('sub_min', $sub_min);
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '1');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][5] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);

		//if prev month prod varies more than 20% -> make reason field mandatory
		$prevMonth = date('Y-m-d', strtotime(date("Y-m-d", strtotime($returnDate)) . " -1 month"));
		$prevMonthProd = $this->Rom5->getTotalProduction($mineCode, $prevMonth, $returnType, $mineral);
		$this->set('prevMonthProd', $prevMonthProd);

		// $formType12 = $this->Session->read('mc_form_type');
		// $form_count=substr($formType12,-1);
		// $formtype_obj=new clsCommon();
		// $this->formtype1=$formtype_obj->getFormRuleNumber($form_count);

		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('primaryMineral', $primaryMineral);
		$this->set('ironSubMin', $ironSubMin);
		$this->set('tableForm', '');

		$this->render('/element/monthly/forms/rom_stocks_ore');

		$sub_min = $ironSubMin;
		$ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;

		if ($this->request->is('post')) {

			$nextSection = $this->findNextSection('/monthly/rom_stocks_ore/' . str_replace('_', ' ', strtoupper($mineral)) . $ironSubMin); // get next sectinn url for redirection

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->Rom5->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Production / Stocks (ROM)</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Production / Stocks (ROM)</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'rom_stocks_ore', $mineral, $sub_min));
				}
			} else {
				$result = $this->Rom5->saveFormDetails($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Production / Stocks (ROM)</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Production / Stocks (ROM)</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'rom_stocks_ore', $mineral, $sub_min));
				}
			}
		}
	}

	// PART II: Ex-Mine Price
	public function exMine($mineral, $ironSubMin = null)
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineral = strtolower($mineral);
		$sub_min = $ironSubMin;
		$min_und_low = str_replace(' ', '_', strtolower($mineral));

		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('mc_form_type');
		$lang = $this->Session->read('lang');
		$returnDate = $this->Session->read('returnDate');
		$returnType = $this->Session->read('returnType');

		$temp = explode('-', $returnDate);
		$returnYear = $temp[0];
		$returnMonth = $temp[1];
		$returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, $returnYear));
		$period = $returnYear . " - " . ($temp[0] + 1);

		$this->Customfunctions->executeUserleftnav($mineCode);

		//to make the exmine price max value > 0
		$romProduction = $this->Rom5->getTotalProduction($mineCode, $returnDate, $returnType, $mineral);

		$prod5Id = $this->Prod5->getExMineProd5Id($mineCode, $returnType, $returnDate, $mineral);
		$prod5 = $this->Prod5->getExMineProd5($mineCode, $returnType, $returnDate, $mineral);

		$this->set('period', $period);
		$this->set('romProduction', $romProduction);
		$this->set('prod5Id', $prod5Id);
		$this->set('prod5', $prod5);

		$labels = $this->Language->getFormInputLabels('ex_mine', $lang);

		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		// if ($approvedSections[$this->mineral][1] == "Rejected") {
		//   $this->is_rejected_section = 1;
		//   $this->rejected_reason = $rejectedReasons[$this->mineral][1];
		// } else if ($approvedSections[$this->mineral][1] == "Approved") {
		//   $this->is_rejected_section = 2;
		// }

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "") {
			$returnType = 'MONTHLY';
		}

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('reasonsArr', $reasonsArr);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);
		$this->set('lang', $lang);
		$this->set('mineral', $mineral);
		$this->set('returnMonth', $this->Session->read('mc_sel_month'));
		$this->set('returnYear', $this->Session->read('mc_sel_year'));

		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

		$count = 0;
		$chkReturnsRcd1 = true;
		$isExists = $this->Mine->checkMine($mineCode);

		$section_mode = $this->Session->read('section_mode');

		/**
		 * ADDED THE $this->returnType IN THE BELOW FUNCTION AS CURRENTLY THE REJECTION OF MONTHLY IS COMING IN REJECTION OF ANNUAL RETURNS
		 * FOR THE MONTH OF APRIL AS THE DATE IS SAME FOR MONTHLY AND ANNUAL FOR THIS MONTH IS SAME
		 * SO PASSING return_type IS NECESSARY.
		 *
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 15th July 2014
		 *
		 **/
		// $return_id = TBL_FINAL_SUBMITTable::getReturnId($this->mineCode, $this->returnDate, $this->returnType);
		// $reasons = array();
		// foreach ($return_id as $r) {
		//   $reasons[] = TBL_FINAL_SUBMITTable::getReason($r['id'], $this->mineral, '', 1);
		// }

		// $this->reasons = $reasons;

		//avg details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], $mineral, '', 2, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if (isset($approvedSections[$min_und_low][2]) && $approvedSections[$min_und_low][2] == "Rejected") {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 2, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 2, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('returnDate', $returnDate);
			$this->set('mineral', $mineral);
			$this->set('sub_min', $sub_min);
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '2');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][5] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);
		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('primaryMineral', $primaryMineral);
		$this->set('ironSubMin', $ironSubMin);
		$this->set('tableForm', '');

		$this->render('/element/monthly/forms/ex_mine');

		$sub_min = $ironSubMin;
		$ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;

		if ($this->request->is('post')) {

			$nextSection = $this->findNextSection('/monthly/ex_mine/' . str_replace('_', ' ', strtoupper($mineral)) . $ironSubMin); // get next sectinn url for redirection

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->Prod5->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Ex-Mine Price</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Ex-Mine Price</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'ex_mine', $mineral, $sub_min));
				}
			} else {
				$result = $this->Prod5->saveFormDetails($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Ex-Mine Price</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Ex-Mine Price</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'ex_mine', $mineral, $sub_min));
				}
			}
		}
	}

	// PART II: Recoveries at Concentrator
	public function conReco($mineral, $ironSubMin = null)
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineral = strtolower($mineral);
		$sub_min = $ironSubMin;
		$min_und_low = str_replace(' ', '_', strtolower($mineral));

		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('mc_form_type');
		$lang = $this->Session->read('lang');
		$returnDate = $this->Session->read('returnDate');
		$returnType = $this->Session->read('returnType');

		$temp = explode('-', $returnDate);
		$returnYear = $temp[0];
		$returnMonth = $temp[1];
		$returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, $returnYear));
		$period = $returnYear . " - " . ($temp[0] + 1);

		$this->Customfunctions->executeUserleftnav($mineCode);

		// get metals
		$metals = $this->DirMetal->getMetalList();
		$metalArr = [];
		foreach ($metals as $key => $val) {
			$metalArr[$val] = $val;
		}

		// con and rom data
		$conRomData = $this->RomMetal5->getConRomData($mineCode, $returnDate, $returnType, $mineral);

		$this->set('metals', $metalArr);
		$this->set('conRomData', $conRomData);

		$labels = $this->Language->getFormInputLabels('con_reco', $lang);

		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		// if ($approvedSections[$this->mineral][1] == "Rejected") {
		//   $this->is_rejected_section = 1;
		//   $this->rejected_reason = $rejectedReasons[$this->mineral][1];
		// } else if ($approvedSections[$this->mineral][1] == "Approved") {
		//   $this->is_rejected_section = 2;
		// }

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('reasonsArr', $reasonsArr);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);
		$this->set('lang', $lang);
		$this->set('mineral', $mineral);
		$this->set('returnMonth', $this->Session->read('mc_sel_month'));
		$this->set('returnYear', $this->Session->read('mc_sel_year'));

		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

		// if(null!==$this->request->getQuery('iron_sub_min')){
		// 	$ironSubMin = $this->request->getQuery('iron_sub_min');
		//     $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
		// } else {
		// 	$ironSubMin = "";
		//     $ironSubMinStr = '';
		// }

		$count = 0;
		$chkReturnsRcd1 = true;
		$isExists = $this->Mine->checkMine($mineCode);

		$section_mode = $this->Session->read('section_mode');

		/**
		 * ADDED THE $this->returnType IN THE BELOW FUNCTION AS CURRENTLY THE REJECTION OF MONTHLY IS COMING IN REJECTION OF ANNUAL RETURNS
		 * FOR THE MONTH OF APRIL AS THE DATE IS SAME FOR MONTHLY AND ANNUAL FOR THIS MONTH IS SAME
		 * SO PASSING return_type IS NECESSARY.
		 *
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 15th July 2014
		 *
		 **/
		// $return_id = TBL_FINAL_SUBMITTable::getReturnId($this->mineCode, $this->returnDate, $this->returnType);
		// $reasons = array();
		// foreach ($return_id as $r) {
		//   $reasons[] = TBL_FINAL_SUBMITTable::getReason($r['id'], $this->mineral, '', 1);
		// }

		// $this->reasons = $reasons;

		//avg details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], $mineral, '', 3, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if (isset($approvedSections[$min_und_low][3]) && $approvedSections[$min_und_low][3] == "Rejected") {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 3, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 3, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('returnDate', $returnDate);
			$this->set('mineral', $mineral);
			$this->set('sub_min', $sub_min);
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '3');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][5] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);

		//if prev month prod varies more than 20% -> make reason field mandatory
		$prevMonth = date('Y-m-d', strtotime(date("Y-m-d", strtotime($returnDate)) . " -1 month"));
		$prevMonthProd = $this->Rom5->getTotalProduction($mineCode, $prevMonth, $returnType, $mineral);
		$this->set('prevMonthProd', $prevMonthProd);

		// $formType12 = $this->Session->read('mc_form_type');
		// $form_count=substr($formType12,-1);
		// $formtype_obj=new clsCommon();
		// $this->formtype1=$formtype_obj->getFormRuleNumber($form_count);

		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('primaryMineral', $primaryMineral);
		$this->set('ironSubMin', $ironSubMin);
		$this->set('tableForm', '');

		$this->render('/element/monthly/forms/con_reco');

		$sub_min = $ironSubMin;
		$ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;

		if ($this->request->is('post')) {

			$nextSection = $this->findNextSection('/monthly/con_reco/' . str_replace('_', ' ', strtoupper($mineral)) . $ironSubMin); // get next sectinn url for redirection

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->Rom5->saveConReco($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Recoveries at Concentrator</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Recoveries at Concentrator</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'con_reco', $mineral, $sub_min));
				}
			} else {
				$result = $this->Rom5->saveConReco($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Recoveries at Concentrator</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Recoveries at Concentrator</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'con_reco', $mineral, $sub_min));
				}
			}
		}
	}

	// PART II: Recoveries at Concentrator
	public function smeltReco($mineral, $ironSubMin = null)
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineral = strtolower($mineral);
		$sub_min = $ironSubMin;
		$min_und_low = str_replace(' ', '_', strtolower($mineral));

		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('mc_form_type');
		$lang = $this->Session->read('lang');
		$returnDate = $this->Session->read('returnDate');
		$returnType = $this->Session->read('returnType');

		$temp = explode('-', $returnDate);
		$returnYear = $temp[0];
		$returnMonth = $temp[1];
		$returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, $returnYear));
		$period = $returnYear . " - " . ($temp[0] + 1);

		$this->Customfunctions->executeUserleftnav($mineCode);

		// get matals
		$metals = $this->DirMetal->getMetalList();
		$metalArr = [];
		foreach ($metals as $key => $val) {
			$metalArr[$val] = $val;
		}
		// get product list
		$products = $this->DirProduct->getProductList();
		$productArr = [];
		foreach ($products as $key => $val) {
			$productArr[$val] = $val;
		}

		// recovery data
		$recoveryData = $this->RecovSmelter->getRecoveryData($mineCode, $returnDate, $returnType, $mineral);

		$this->set('metals', $metalArr);
		$this->set('products', $productArr);
		$this->set('recoveryData', $recoveryData);

		$labels = $this->Language->getFormInputLabels('smelt_reco', $lang);

		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		// if ($approvedSections[$this->mineral][1] == "Rejected") {
		//   $this->is_rejected_section = 1;
		//   $this->rejected_reason = $rejectedReasons[$this->mineral][1];
		// } else if ($approvedSections[$this->mineral][1] == "Approved") {
		//   $this->is_rejected_section = 2;
		// }

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('reasonsArr', $reasonsArr);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);
		$this->set('lang', $lang);
		$this->set('mineral', $mineral);
		$this->set('returnMonth', $this->Session->read('mc_sel_month'));
		$this->set('returnYear', $this->Session->read('mc_sel_year'));

		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

		// if(null!==$this->request->getQuery('iron_sub_min')){
		// 	$ironSubMin = $this->request->getQuery('iron_sub_min');
		//     $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
		// } else {
		// 	$ironSubMin = "";
		//     $ironSubMinStr = '';
		// }

		$count = 0;
		$chkReturnsRcd1 = true;
		$isExists = $this->Mine->checkMine($mineCode);

		$section_mode = $this->Session->read('section_mode');

		/**
		 * ADDED THE $this->returnType IN THE BELOW FUNCTION AS CURRENTLY THE REJECTION OF MONTHLY IS COMING IN REJECTION OF ANNUAL RETURNS
		 * FOR THE MONTH OF APRIL AS THE DATE IS SAME FOR MONTHLY AND ANNUAL FOR THIS MONTH IS SAME
		 * SO PASSING return_type IS NECESSARY.
		 *
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 15th July 2014
		 *
		 **/
		// $return_id = TBL_FINAL_SUBMITTable::getReturnId($this->mineCode, $this->returnDate, $this->returnType);
		// $reasons = array();
		// foreach ($return_id as $r) {
		//   $reasons[] = TBL_FINAL_SUBMITTable::getReason($r['id'], $this->mineral, '', 1);
		// }

		// $this->reasons = $reasons;

		//avg details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], $mineral, '', 4, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if (isset($approvedSections[$min_und_low][4]) && $approvedSections[$min_und_low][4] == "Rejected") {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 4, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 4, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('returnDate', $returnDate);
			$this->set('mineral', $mineral);
			$this->set('sub_min', $sub_min);
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '4');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][5] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);

		//if prev month prod varies more than 20% -> make reason field mandatory
		$prevMonth = date('Y-m-d', strtotime(date("Y-m-d", strtotime($returnDate)) . " -1 month"));
		$prevMonthProd = $this->Rom5->getTotalProduction($mineCode, $prevMonth, $returnType, $mineral);
		$this->set('prevMonthProd', $prevMonthProd);

		// $formType12 = $this->Session->read('mc_form_type');
		// $form_count=substr($formType12,-1);
		// $formtype_obj=new clsCommon();
		// $this->formtype1=$formtype_obj->getFormRuleNumber($form_count);

		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('primaryMineral', $primaryMineral);
		$this->set('ironSubMin', $ironSubMin);
		$this->set('tableForm', '');

		$this->render('/element/monthly/forms/smelt_reco');

		$sub_min = $ironSubMin;
		$ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;

		if ($this->request->is('post')) {

			$nextSection = $this->findNextSection('/monthly/smelt_reco/' . str_replace('_', ' ', strtoupper($mineral)) . $ironSubMin); // get next sectinn url for redirection

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->RecovSmelter->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Recovery at the Smelter</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Recovery at the Smelter</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'smelt_reco', $mineral, $sub_min));
				}
			} else {
				$result = $this->RecovSmelter->saveFormDetails($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Recovery at the Smelter</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Recovery at the Smelter</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'smelt_reco', $mineral, $sub_min));
				}
			}
		}
	}


	// PART II: Sales(Metals/By Product)
	public function salesMetalProduct($mineral, $ironSubMin = null)
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineral = strtolower($mineral);
		$sub_min = $ironSubMin;
		$min_und_low = str_replace(' ', '_', strtolower($mineral));

		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('mc_form_type');
		$lang = $this->Session->read('lang');
		$returnDate = $this->Session->read('returnDate');
		$returnType = $this->Session->read('returnType');

		// CHECK "RECOVERY AT THE SMELTER/MILL/PLANT" SECTION FILLED OR NOT
		// IF NOT FILLED, THEN DON'T ALLOW TO VIEW OR FILLING OF THIS SECTION
		// Effective from Phase-II
		// Added on 17-03-2022 by Aniket Ganvir.
		$min_und_low = str_replace(' ', '_', strtolower($mineral));
		$recovSmelterEmpty = $this->RecovSmelter->isFilled($mineCode, $returnDate, $returnType, $mineral);
		if ($recovSmelterEmpty == 1) {
			$part_no = ($returnType == 'MONTHLY') ? 'Part II' : 'Part VI';
			$month_year = ($returnType == 'MONTHLY') ? 'month' : 'year';
			$this->Session->write('mon_f_err', 'Please fill <b>'.$part_no.': 4. Recovery at the Smelter-Mill-Plant</b> in order to fill <b>'.$part_no.': 5. Sales during the '.$month_year.'</b> section');
			return $this->redirect(array('controller' => 'monthly', 'action' => 'smelt_reco', $mineral, null));
		}

		$temp = explode('-', $returnDate);
		$returnYear = $temp[0];
		$returnMonth = $temp[1];
		$returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, $returnYear));
		$period = $returnYear . " - " . ($temp[0] + 1);

		$this->Customfunctions->executeUserleftnav($mineCode);

		// get product list
		$products = $this->DirProduct->getProductList();
		$productArr = [];
		foreach ($products as $key => $val) {
			$productArr[$val] = $val;
		}

		// sales data
		$salesData = $this->Sale5->getSalesData($mineCode, $returnDate, $returnType, $mineral);

		// recovery data for comparison with sales data
		$recoveryData = $this->RecovSmelter->getRecoveryData($mineCode, $returnDate, $returnType, $mineral, 1);

		$this->set('products', $productArr);
		$this->set('salesData', $salesData);
		$this->set('recoveryData', $recoveryData['con_metal']);

		$labels = $this->Language->getFormInputLabels('sales_metal_product', $lang);

		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		// if ($approvedSections[$this->mineral][1] == "Rejected") {
		//   $this->is_rejected_section = 1;
		//   $this->rejected_reason = $rejectedReasons[$this->mineral][1];
		// } else if ($approvedSections[$this->mineral][1] == "Approved") {
		//   $this->is_rejected_section = 2;
		// }

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('reasonsArr', $reasonsArr);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);
		$this->set('lang', $lang);
		$this->set('mineral', $mineral);
		$this->set('returnMonth', $this->Session->read('mc_sel_month'));
		$this->set('returnYear', $this->Session->read('mc_sel_year'));

		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

		// if(null!==$this->request->getQuery('iron_sub_min')){
		// 	$ironSubMin = $this->request->getQuery('iron_sub_min');
		//     $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
		// } else {
		// 	$ironSubMin = "";
		//     $ironSubMinStr = '';
		// }

		$count = 0;
		$chkReturnsRcd1 = true;
		$isExists = $this->Mine->checkMine($mineCode);

		$section_mode = $this->Session->read('section_mode');

		/**
		 * ADDED THE $this->returnType IN THE BELOW FUNCTION AS CURRENTLY THE REJECTION OF MONTHLY IS COMING IN REJECTION OF ANNUAL RETURNS
		 * FOR THE MONTH OF APRIL AS THE DATE IS SAME FOR MONTHLY AND ANNUAL FOR THIS MONTH IS SAME
		 * SO PASSING return_type IS NECESSARY.
		 *
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 15th July 2014
		 *
		 **/
		// $return_id = TBL_FINAL_SUBMITTable::getReturnId($this->mineCode, $this->returnDate, $this->returnType);
		// $reasons = array();
		// foreach ($return_id as $r) {
		//   $reasons[] = TBL_FINAL_SUBMITTable::getReason($r['id'], $this->mineral, '', 1);
		// }

		// $this->reasons = $reasons;

		//avg details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], $mineral, '', 5, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if (isset($approvedSections[$min_und_low][5]) && $approvedSections[$min_und_low][5] == "Rejected") {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 5, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 5, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('returnDate', $returnDate);
			$this->set('mineral', $mineral);
			$this->set('sub_min', $sub_min);
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '5');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][5] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);

		//if prev month prod varies more than 20% -> make reason field mandatory
		$prevMonth = date('Y-m-d', strtotime(date("Y-m-d", strtotime($returnDate)) . " -1 month"));
		$prevMonthProd = $this->Rom5->getTotalProduction($mineCode, $prevMonth, $returnType, $mineral);
		$this->set('prevMonthProd', $prevMonthProd);

		// $formType12 = $this->Session->read('mc_form_type');
		// $form_count=substr($formType12,-1);
		// $formtype_obj=new clsCommon();
		// $this->formtype1=$formtype_obj->getFormRuleNumber($form_count);

		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('primaryMineral', $primaryMineral);
		$this->set('ironSubMin', $ironSubMin);
		$this->set('tableForm', '');

		$this->render('/element/monthly/forms/sales_metal_product');

		$sub_min = $ironSubMin;
		$ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;

		if ($this->request->is('post')) {

			$nextSection = $this->findNextSection('/monthly/sales_metal_product/' . str_replace('_', ' ', strtoupper($mineral)) . $ironSubMin); // get next sectinn url for redirection

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->Sale5->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Sales (Metals/by Product)</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Sales (Metals/by Product)</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'sales_metal_product', $mineral, $sub_min));
				}
			} else {
				$result = $this->Sale5->saveFormDetails($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Sales (Metals/by Product)</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Sales (Metals/by Product)</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'sales_metal_product', $mineral, $sub_min));
				}
			}
		}
	}


	// PART II: Production / Stocks (ROM) for FORM 3
	public function romStocksThree($mineral, $ironSubMin = null)
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineral = strtolower($mineral);
		$sub_min = $ironSubMin;
		$min_und_low = str_replace(' ', '_', strtolower($mineral));

		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('mc_form_type');
		$lang = $this->Session->read('lang');
		$returnDate = $this->Session->read('returnDate');
		$returnType = $this->Session->read('returnType');

		$temp = explode('-', $returnDate);
		$returnYear = $temp[0];
		$returnMonth = $temp[1];
		$returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, $returnYear));
		$period = $returnYear . " - " . ($temp[0] + 1);

		$this->Customfunctions->executeUserleftnav($mineCode);

		//====CALCULATING THE ESTIMATED PRODUCTION AND CUMMULATIVE PRODUCTION=======
		$estProd = $this->MiningPlan->getEstimatedProd($mineCode, $mineral, '', $returnYear, $returnDate);
		$cumProd = $this->MiningPlan->getCumProd($mineCode, $mineral, '', $returnYear, $returnMonth, $returnType);

		$min = strtoupper($mineral);
		$minUnit = $this->DirMcpMineral->getMineralUnit($min);
		$romData = $this->RomStone->getRomData($mineCode, $returnType, $returnDate, $mineral);

		$this->set('mineralName', $mineral);
		$this->set('period', $period);
		$this->set('estProd', $estProd);
		$this->set('cumProd', $cumProd);
		$this->set('minUnit', $minUnit);
		$this->set('romData', $romData);

		$labels = $this->Language->getFormInputLabels('rom_stocks_three', $lang);

		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		// if ($approvedSections[$this->mineral][1] == "Rejected") {
		//   $this->is_rejected_section = 1;
		//   $this->rejected_reason = $rejectedReasons[$this->mineral][1];
		// } else if ($approvedSections[$this->mineral][1] == "Approved") {
		//   $this->is_rejected_section = 2;
		// }

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('reasonsArr', $reasonsArr);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);
		$this->set('lang', $lang);
		$this->set('mineral', $mineral);
		$this->set('returnMonth', $this->Session->read('mc_sel_month'));
		$this->set('returnYear', $this->Session->read('mc_sel_year'));

		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

		// if(null!==$this->request->getQuery('iron_sub_min')){
		// 	$ironSubMin = $this->request->getQuery('iron_sub_min');
		//     $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
		// } else {
		// 	$ironSubMin = "";
		//     $ironSubMinStr = '';
		// }

		$count = 0;
		$chkReturnsRcd1 = true;
		$isExists = $this->Mine->checkMine($mineCode);

		$section_mode = $this->Session->read('section_mode');

		/**
		 * ADDED THE $this->returnType IN THE BELOW FUNCTION AS CURRENTLY THE REJECTION OF MONTHLY IS COMING IN REJECTION OF ANNUAL RETURNS
		 * FOR THE MONTH OF APRIL AS THE DATE IS SAME FOR MONTHLY AND ANNUAL FOR THIS MONTH IS SAME
		 * SO PASSING return_type IS NECESSARY.
		 *
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 15th July 2014
		 *
		 **/
		// $return_id = TBL_FINAL_SUBMITTable::getReturnId($this->mineCode, $this->returnDate, $this->returnType);
		// $reasons = array();
		// foreach ($return_id as $r) {
		//   $reasons[] = TBL_FINAL_SUBMITTable::getReason($r['id'], $this->mineral, '', 1);
		// }

		// $this->reasons = $reasons;

		//avg details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], $mineral, '', 1, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if (isset($approvedSections[$min_und_low][1]) && $approvedSections[$min_und_low][1] == "Rejected") {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 1, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 1, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('returnDate', $returnDate);
			$this->set('mineral', $mineral);
			$this->set('sub_min', $sub_min);
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '1');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][5] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);

		//if prev month prod varies more than 20% -> make reason field mandatory
		$prevMonth = date('Y-m-d', strtotime(date("Y-m-d", strtotime($returnDate)) . " -1 month"));
		$prevMonthProd = $this->Rom5->getTotalProduction($mineCode, $prevMonth, $returnType, $mineral);
		$this->set('prevMonthProd', $prevMonthProd);

		// $formType12 = $this->Session->read('mc_form_type');
		// $form_count=substr($formType12,-1);
		// $formtype_obj=new clsCommon();
		// $this->formtype1=$formtype_obj->getFormRuleNumber($form_count);

		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('primaryMineral', $primaryMineral);
		$this->set('ironSubMin', $ironSubMin);
		$this->set('tableForm', '');

		$this->render('/element/monthly/forms/rom_stocks_three');

		$sub_min = $ironSubMin;
		$ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;

		if ($this->request->is('post')) {

			$nextSection = $this->findNextSection('/monthly/rom_stocks_three/' . str_replace('_', ' ', strtoupper($mineral)) . $ironSubMin); // get next sectinn url for redirection

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->RomStone->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Production / Stocks (ROM)</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Production / Stocks (ROM)</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'rom_stocks_three', $mineral, $sub_min));
				}
			} else {
				$result = $this->RomStone->saveFormDetails($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Production / Stocks (ROM)</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Production / Stocks (ROM)</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'rom_stocks_three', $mineral, $sub_min));
				}
			}
		}
	}

	// PART II: Production, Stocks and Dispatches (FORM F3)
	public function prodStockDis($mineral, $ironSubMin = null)
	{

		$this->viewBuilder()->setLayout('mc/form_layout');

		$mineral = strtolower($mineral);
		$sub_min = $ironSubMin;
		$min_und_low = str_replace(' ', '_', strtolower($mineral));

		$partId = $this->Session->read('partId');
		$mineCode = $this->Session->read('mc_mine_code');
		$formId = $this->Session->read('mc_form_type');
		$lang = $this->Session->read('lang');
		$returnDate = $this->Session->read('returnDate');
		$returnType = $this->Session->read('returnType');

		$temp = explode('-', $returnDate);
		$returnYear = $temp[0];
		$returnMonth = $temp[1];
		$returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, $returnYear));
		$period = $returnYear . " - " . ($temp[0] + 1);

		$this->Customfunctions->executeUserleftnav($mineCode);

		//====CALCULATING THE ESTIMATED PRODUCTION AND CUMMULATIVE PRODUCTION=======
		$estProd = $this->MiningPlan->getEstimatedProd($mineCode, $mineral, '', $returnYear, $returnDate);
		$cumProd = $this->MiningPlan->getCumProd($mineCode, $mineral, '', $returnYear, $returnMonth, $returnType);

		$min = strtoupper($mineral);
		$minUnit = $this->DirMcpMineral->getMineralUnit($min);

		$roughStoneData = $this->ProdStone->getProdStoneData($mineCode, $returnDate, $mineral, 1, $returnType);
		$cutStoneData = $this->ProdStone->getProdStoneData($mineCode, $returnDate, $mineral, 2, $returnType);
		$indStoneData = $this->ProdStone->getProdStoneData($mineCode, $returnDate, $mineral, 3, $returnType);
		$othStoneData = $this->ProdStone->getProdStoneData($mineCode, $returnDate, $mineral, 99, $returnType);

		$this->set('period', $period);
		$this->set('estProd', $estProd);
		$this->set('cumProd', $cumProd);
		$this->set('minUnit', $minUnit);
		$this->set('roughStone', $roughStoneData);
		$this->set('cutStone', $cutStoneData);
		$this->set('indStone', $indStoneData);
		$this->set('othStone', $othStoneData);

		$labels = $this->Language->getFormInputLabels('prod_stock_dis', $lang);

		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();

		//get the approved & rejected sections
		$approvedSections = $this->Session->read('approved_sections');
		$rejectedReasons = $this->Session->read('rejected_reasons');

		// if ($approvedSections[$this->mineral][1] == "Rejected") {
		//   $this->is_rejected_section = 1;
		//   $this->rejected_reason = $rejectedReasons[$this->mineral][1];
		// } else if ($approvedSections[$this->mineral][1] == "Approved") {
		//   $this->is_rejected_section = 2;
		// }

		//is mine owner - to show only the 'Next' button and hide the 'Save' button
		$isMineOwner = $this->Session->read('is_mine_owner');

		//check if the return is all approved - to show the final submit button
		$is_all_approved = $this->Session->read('is_all_approved');

		$returnDate = $this->Session->read('returnDate');

		$returnType = $this->Session->read('returnType');
		if ($returnType == "")
			$returnType = 'MONTHLY';

		$formNo = $this->Session->read('mc_form_type');

		$this->set('label', $labels);
		$this->set('formId', $formId);
		$this->set('mineCode', $mineCode);
		$this->set('reasonsArr', $reasonsArr);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('returnDate', $returnDate);
		$this->set('formNo', $formNo);
		$this->set('lang', $lang);
		$this->set('mineral', $mineral);
		$this->set('returnMonth', $this->Session->read('mc_sel_month'));
		$this->set('returnYear', $this->Session->read('mc_sel_year'));

		$primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
		$formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

		// if(null!==$this->request->getQuery('iron_sub_min')){
		// 	$ironSubMin = $this->request->getQuery('iron_sub_min');
		//     $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
		// } else {
		// 	$ironSubMin = "";
		//     $ironSubMinStr = '';
		// }

		$count = 0;
		$chkReturnsRcd1 = true;
		$isExists = $this->Mine->checkMine($mineCode);

		$section_mode = $this->Session->read('section_mode');

		/**
		 * ADDED THE $this->returnType IN THE BELOW FUNCTION AS CURRENTLY THE REJECTION OF MONTHLY IS COMING IN REJECTION OF ANNUAL RETURNS
		 * FOR THE MONTH OF APRIL AS THE DATE IS SAME FOR MONTHLY AND ANNUAL FOR THIS MONTH IS SAME
		 * SO PASSING return_type IS NECESSARY.
		 *
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 15th July 2014
		 *
		 **/
		// $return_id = TBL_FINAL_SUBMITTable::getReturnId($this->mineCode, $this->returnDate, $this->returnType);
		// $reasons = array();
		// foreach ($return_id as $r) {
		//   $reasons[] = TBL_FINAL_SUBMITTable::getReason($r['id'], $this->mineral, '', 1);
		// }

		// $this->reasons = $reasons;

		//avg details edit form
		//check is rejected or approved section
		$commented_status = '0';
		$reasons = array();
		$reasons_old = array();

		//old comment history
		$return_ids = $this->TblFinalSubmit->getReturnIdExceptLatest($mineCode, $returnDate, $returnType);
		if (count($return_ids) > 0) {
			foreach ($return_ids as $return_id) {
				$reasons_old[] = $this->TblFinalSubmit->getReason($return_id['id'], $mineral, '', 2, 'applicant');
			}
		}
		$commentLabel = $this->Customfunctions->getCommentLabel('1');
		$this->set('reasons_old', $reasons_old);
		$this->set('commentLabel', $commentLabel);

		//current comment history
		if (isset($approvedSections[$min_und_low][2]) && $approvedSections[$min_und_low][2] == "Rejected") {
			$is_rejected_section = 1;
			$return_id = $this->Session->read('return_id');
			$reasons[] = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 2, 'applicant');
			$section_mode = 'edit';

			$reason_data = $this->TblFinalSubmit->getReason($return_id, $mineral, '', 2, 'applicant');
			if ($reason_data['commented'] == '1') {
				$commented_status = '1';
			}

			$this->set('reasons', $reasons);
			$this->set('viewOnly', false);
			$this->set('view', 'view');
			$this->set('return_home_page', '');
			$this->set('is_pri_pending', false);

			$this->set('returnDate', $returnDate);
			$this->set('returnDate', $returnDate);
			$this->set('mineral', $mineral);
			$this->set('sub_min', $sub_min);
			$this->set('mmsUserRole', 'applicant');
			$this->set('sectionId', '2');
			$this->set('part_no', '');
			// } else if ($approvedSections['partI'][5] == "Approved") {
			//     $is_rejected_section = 2;
		} else {
			$is_rejected_section = ''; // need to review
		}

		$this->set('mmsUserId', $this->Session->read('username'));
		$this->set('commented_status', $commented_status);

		//if prev month prod varies more than 20% -> make reason field mandatory
		$prevMonth = date('Y-m-d', strtotime(date("Y-m-d", strtotime($returnDate)) . " -1 month"));
		$prevMonthProd = $this->Rom5->getTotalProduction($mineCode, $prevMonth, $returnType, $mineral);
		$this->set('prevMonthProd', $prevMonthProd);

		// $formType12 = $this->Session->read('mc_form_type');
		// $form_count=substr($formType12,-1);
		// $formtype_obj=new clsCommon();
		// $this->formtype1=$formtype_obj->getFormRuleNumber($form_count);

		$this->set('section_mode', $section_mode);
		$this->set('is_rejected_section', $is_rejected_section);
		$this->set('primaryMineral', $primaryMineral);
		$this->set('ironSubMin', $ironSubMin);
		$this->set('tableForm', '');

		$this->render('/element/monthly/forms/prod_stock_dis');

		$sub_min = $ironSubMin;
		$ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;

		if ($this->request->is('post')) {

			$nextSection = $this->findNextSection('/monthly/prod_stock_dis/' . str_replace('_', ' ', strtoupper($mineral)) . $ironSubMin); // get next sectinn url for redirection

			if ($this->request->getData('submit') == 'save_comment') {
				$result1 = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $this->Session->read('return_id'));
				$result = $this->ProdStone->saveFormDetails($this->request->getData());

				if ($result1 == 1) {
					$this->Session->write('mon_f_suc', 'Reply saved in <b>Production, Despatches and Stocks</b> successfully!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to saved reply <b>Production, Despatches and Stocks</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'prod_stock_dis', $mineral, $sub_min));
				}
			} else {
				$result = $this->ProdStone->saveFormDetails($this->request->getData());

				if ($result == 1) {
					$this->Session->write('mon_f_suc', '<b>Production, Despatches and Stocks</b> successfully saved!');
					$this->redirect($this->Session->read($nextSection));
				} else {
					$this->Session->write('mon_f_err', 'Failed to update <b>Production, Despatches and Stocks</b>! Please, try again later.');
					$this->redirect(array('controller' => 'monthly', 'action' => 'prod_stock_dis', $mineral, $sub_min));
				}
			}
		}
	}

	public function getConsigneeName()
	{

		$this->autoRender = false;
		if ($this->request->is('post')) {

			$keyword = $this->request->getData('keyword');
			$result = $this->McApplicantDet->getConsigneeByRegNo($keyword);
			print_r(count($result));
		}
	}

	// get previous rom closing stocks
	// @addedon: 01st APR 2021 (by Aniket Ganvir)
	public function getRomPrevClosingStocks()
	{

		$this->autoRender = false;
		if ($this->request->is('post')) {

			$prevMonthDate = $this->request->getData('prev_month');
			$mineCode = $this->request->getData('mine_code');
			$returnType = $this->request->getData('return_type');
			$ironSubMin = $this->request->getData('iron_sub_min');

			$mineralName = $this->request->getData('mineral');
			$closing_stocks = $this->Prod1->getRomPrevClosingStocks($prevMonthDate, $mineCode, $returnType, $mineralName, $ironSubMin);

			// return $this->renderText(json_encode($closing_stocks));
			print_r(json_encode($closing_stocks));
		}
	}

	/**
	 * GET NEXT SECTION LINK FOR REDIRECTION PURPOSE
	 * @addedon: 01st APR 2021 (by Aniket Ganvir)
	 */
	public function findNextSection($section_url)
	{
		//echo $section_url; exit;
		// /monthly/rom_stocks/MANGANESE_ORE
		$sec_link = $this->Session->read('sec_link');


		$part_no = '1';
		foreach ($sec_link as $min) {
			foreach ($min as $key => $val) {
				if ($val == $section_url) {
					$data['key'] = $key;
					$data['part_no'] = $part_no;
				}
			}

			$part_no++;
		}

		// print_r($data['key']);
  //       echo '<pre>';print_r($sec_link);die;

		$nextPartNo = $data['key'] + 1;
		if (!$this->Session->read('sec_link.part_' . $data['part_no'] . '.' . $nextPartNo)) {
			$nextPartNo = 0;
			$data['part_no'] = $data['part_no'] + 1;

			if (!$this->Session->read('sec_link.part_' . $data['part_no'] . '.' . $nextPartNo)) {
				$nextPartNo = $data['key'];
				$data['part_no'] = $data['part_no'] - 1;
			}
		}

		$data = 'sec_link.part_' . $data['part_no'] . '.' . $nextPartNo;
		return $data;
	}

	/**
	 * RETURNS FINAL SUBMIT VALIDATIONS AND SAVING
	 * @addedon: 02nd APR 2021 (by Aniket Ganvir)
	 */
	public function finalSubmit()
	{
		$this->autoRender = false;

		$mineCode = $this->Session->read('mc_mine_code');
		$returnDate = $this->Session->read('returnDate');
		$returnType = $this->Session->read('returnType');

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


		$error_msg = array();

		//primary form no
		$primaryMineral = $mineMinerals[0];
		$primaryFormNo = $this->DirMcpMineral->getFormNumber($primaryMineral);

		//check rent & royalty
		$is_submitted['rent'] = $this->RentReturns->isFilled($mineCode, $returnDate, $returnType);
		//check working details
		$is_submitted['working_details'] = $this->WorkStoppage->isFilled($mineCode, $returnDate, $returnType);
		//check daily average
		$is_submitted['daily_average'] = $this->Employment->isFilled($mineCode, $returnDate, $returnType);
		//check rom
		$is_submitted['rom'] = $this->Prod1->isFilled($mineCode, $returnDate, $returnType, $mineMinerals);
		//check gradewise production
		$is_submitted['grade_wise'] = $this->GradeProd->isFilled($mineCode, $returnDate, $returnType, $is_hematite, $is_magnetite);
		//check deduction details
		$is_submitted['deduction'] = $this->Prod1->isDeductionFilled($mineCode, $returnDate, $returnType, $is_hematite, $is_magnetite);
		//check sales and despatches - Dont need to check the sales and dispatch entry
		//$is_submitted['sales'] = GRADE_SALETable::isFilled($this->mineCode, $this->returnDate, $this->returnType);

		//echo "<pre>";print_R($is_submitted['grade_wise']);
		if ($is_submitted['rent'] != 0)
			$error_msg[] = "Please enter rent details.";
		if ($is_submitted['working_details'] != 0)
			$error_msg[] = "Please enter working details.";
		if ($is_submitted['daily_average'] != 0)
			$error_msg[] = "Please enter daily average details.";

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
					/* In new form, for Iron and chromite, the OpenStock, production and Closing Stock value
						is not required to fill grade-wise production details.
						So validate the production details if form number is not a 1 and 4.
						Done by Pravin Bhakare, 23-07-2020 */
					if ($primaryFormNo != 1 && $primaryFormNo != 4)
						$error_msg[] = "Please enter gradewise production details for " . ucwords(str_replace('_', ' ', $g));
			}
		}

		if ($is_submitted['deduction'] != 0) {
			foreach ($is_submitted['deduction'] as $g) {
				$error_msg[] = "Please enter deduction details for " . ucwords(str_replace('_', ' ', $g));
			}
		}

		/* if ($is_submitted['sales'] != 0) {
          foreach ($is_submitted['sales'] as $g) {
          $error_msg[] = "Please enter sales/dispatches details for " . ucwords($g);
          }
          } */

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
			// else if ($formNo == 7) {
			// 	//production / stocks (rom)
			// 	$prod_stock_rom_filled = $this->RomStone->isFilled($mineCode, $returnDate, $returnType);
			// 	if ($prod_stock_rom_filled != 0)
			// 		$error_msg[] = "Please enter <b>Production / Stocks (ROM)</b> for <b>" . ucwords(str_replace('_', ' ', $m))."</b>";

			// 	//production, despatches and stocks
			// 	$prod_stock_dis_filled = $this->ProdStone->isFilled($mineCode, $returnDate, $returnType);
			// 	if ($prod_stock_dis_filled != 0)
			// 		$error_msg[] = "Please enter <b>Production, Despatches and Stocks</b> for <b>" . ucwords(str_replace('_', ' ', $m))."</b>";

			// 	//details of deductions
			// 	$deduct_detail_filled = $this->Prod1->isFilled($mineCode, $returnDate, $returnType);
			// 	if ($deduct_detail_filled != 0)
			// 		$error_msg[] = "Please enter <b>Details of Deductions</b> for <b>" . ucwords(str_replace('_', ' ', $m))."</b>";

			// 	//sales/dispatches
			// 	$sale_despatch_filled = $this->GradeSale->isFilled($mineCode, $returnDate, $returnType);
			// 	if ($sale_despatch_filled != 0)
			// 		$error_msg[] = "Please enter <b>Sales/Dispatches</b> for <b>" . ucwords(str_replace('_', ' ', $m))."</b>";
			// }
		}

		if (count($error_msg) == 0) {

			// Added the below condition to check for empty ('/') app id in some special conditions
			// '/' was getting saved in Final Submit Table.
			// Now the user will be redirected to login screen where the previous session will be automatically destroyed.

			// 31-01-2019
			if ($app_id == '/') {
				// $this->getUser()->setFlash('errMsg', 'Your current session was closed for inactivity. Please login again.');
				echo "<script>alert('Your current session was closed for inactivity. Please login again.')</script>";

				$this->redirect('auth/login');
			}

			/*
				Final submit entry code disable here because now final submit entry done after successfully esign complete.
				New function created in esign module for final submit entry.
				Done by Pravin Bhakare, 31-07-2020
			*/
			//AS NOW THEY WANT ALL THE DETAILS OF NUMBER OF TIME THE FORM IS SUBMITTED
			//SO THE DELETE FUNCTIONALITY HAS BEEN COMMENTED OUT....
			//IF LATER THEY WANT IT BACK JUST UNCOMMENT HERE AND DONE ...!!!
			//if already final submitted - remove it and make a new entry
			//$remove_record = TBL_FINAL_SUBMITTable::removeFinalSubmit($this->app_id, $this->submitted_by, $this->returnDate);

			
	

			//$update_record = $this->TblFinalSubmit->updateLastSubmittedRecord($app_id, $submitted_by, $mineCode, $returnDate, $returnType);

			// $record = new TBL_FINAL_SUBMIT();
			// $record->applicant_id = $this->app_id;
			// $record->submitted_by = $this->submitted_by;
			// $record->mine_code = $this->mineCode;
			// $record->return_date = $this->returnDate;
			// $record->return_type = $this->returnType;
			// $record->form_type = $primaryFormNo;
			// $record->created_at = date('Y-m-d H:i:s');
			// $record->is_latest = 1;
			// $record->save();

			/*$newEntity = $this->TblFinalSubmit->newEntity(array(
				'applicant_id' => $app_id,
				'submitted_by' => $submitted_by,
				'mine_code' => $mineCode,
				'return_date' => $returnDate,
				'return_type' => $returnType,
				'form_type' => $primaryFormNo,
				'created_at' => date('Y-m-d H:i:s'),
				'status_date' => date('Y-m-d'),
				'is_latest' => '1'
			));
			$this->TblFinalSubmit->save($newEntity);

			// send sms
			$customer_id = $_SESSION['username'];
			$this->loadModel('DirSmsEmailTemplates');
			//$this->DirSmsEmailTemplates->sendMessage(7,$customer_id);
			*/

			// $this->redirect('monthly/downloadPdf?mine_code=' . $this->mineCode . "&date=" . $this->returnDate . "&return_type=" . $this->returnType);

		}

		$errors = implode('|', $error_msg);

		echo $errors;
	}

	public function rejectedReturns($returnType = 'MONTHLY')
	{

		$this->viewBuilder()->setLayout('mc_panel');

		$this->set('returnType', $returnType);

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

		if (count($temp) == 3) {
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
		if ($is_mine_owner == true) {
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

		$this->set('returns', $returns);
		$this->set('mineOwner', $mineOwner);


		if (count($returns) == 0) {
			// $this->getUser()->setFlash('errorMsg', 'No Returns Found!');
			echo 'No Returns Found!';
		}
	}

	public function redirectRejectedReturns($returnId)
	{

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
		if ($status == 3) {
			$this->Session->write('is_all_approved', true);
		} else {
			$this->Session->write('is_all_approved', false);
		}

		$tmpSections = $return['approved_sections'];
		$approvedSections = unserialize($tmpSections);

		$tmpReasons = $return['rejected_section_remarks'];
		$rejectedReasons = unserialize($tmpReasons);

		$temp = explode('-', date('Y-m-d', strtotime($returnDate)));
		$year = $temp[0];
		$month = $temp[1];

		$rejected_sections = $this->Session->write('approved_sections', $approvedSections);
		$rejected_sections = $this->Session->write('rejected_reasons', $rejectedReasons);

		$this->Session->write('returnDate', date('Y-m-d', strtotime($returnDate)));
		$this->Session->write('returnType', $returnType);
		$this->Session->write('mc_sel_month', $month);
		$this->Session->write('mc_sel_year', $year);
		$this->Session->write('form_status', 'referred_back');
		$this->Session->write('return_id', $rejected_return_id);

		$this->redirect(array('controller' => 'monthly', 'action' => 'mine'));
	}


	public function backReturns($returnId, $action)
	{

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
		if ($status == 3) {
			$this->Session->write('is_all_approved', true);
		} else {
			$this->Session->write('is_all_approved', false);
		}

		$tmpSections = $return['approved_sections'];
		$approvedSections = unserialize($tmpSections);

		$tmpReasons = $return['rejected_section_remarks'];
		$rejectedReasons = unserialize($tmpReasons);

		$temp = explode('-', date('Y-m-d', strtotime($returnDate)));
		$year = $temp[0];
		$month = $temp[1];

		$rejected_sections = $this->Session->write('approved_sections', $approvedSections);
		$rejected_sections = $this->Session->write('rejected_reasons', $rejectedReasons);

		$this->Session->write('returnDate', date('Y-m-d', strtotime($returnDate)));
		$this->Session->write('returnType', $returnType);
		$this->Session->write('mc_sel_month', $month);
		$this->Session->write('mc_sel_year', $year);
		$this->Session->write('form_status', $action);
		$this->Session->write('return_id', $rejected_return_id);

		// $this->redirect(array('controller'=>'monthly','action'=>'mine'));

	}

	public function backReturnsEndUser($returnId, $action)
	{

		//remove the approved sections and rejected remarks if set already
		$this->Session->delete('approved_sections');
		$this->Session->delete('rejected_reasons');

		$rejected_return_id = base64_decode($returnId);
		$return = $this->TblEndUserFinalSubmit->findReturnById($rejected_return_id);

		$endUserId = $return['applicant_id'];
		$returnDate = $return['return_date'];
		$returnType = $return['return_type'];

		$status = $return['status'];
		if ($status == 3) {
			$this->Session->write('is_all_approved', true);
		} else {
			$this->Session->write('is_all_approved', false);
		}

		$tmpSections = $return['approved_sections'];
		$approvedSections = unserialize($tmpSections);

		$tmpReasons = $return['rejected_section_remarks'];
		$rejectedReasons = unserialize($tmpReasons);

		$temp = explode('-', date('Y-m-d', strtotime($returnDate)));
		$selYear = $temp[0];
		$selMonth = $temp[1];
		$formType = ($returnType == 'MONTHLY') ? 'N' : 'O';

		$rejected_sections = $this->Session->write('approved_sections', $approvedSections);
		$rejected_sections = $this->Session->write('rejected_reasons', $rejectedReasons);

		$this->Session->write('mc_sel_month', $selMonth);
		$this->Session->write('mc_sel_year', $selYear);
		$this->Session->write('returnDate', date('Y-m-d', strtotime($returnDate)));
		$this->Session->write('returnType', $returnType);
		$this->Session->write('form_status', 'referred_back');
		$this->Session->write('return_id', $rejected_return_id);
		$this->Session->write('formType', $formType);

		// $this->redirect(array('controller'=>'monthly','action'=>'mine'));

	}



	/**
	 * UPDATE APPLICANT COMMUNICATION REPLY THROUGH AJAX CALL
	 * @addedon: 15th APR 2021 (by Aniket Ganvir)
	 */
	public function updateComment()
	{

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$return_id = $this->request->getData('returnId');
			$returnType = $this->request->getData('return_type');
			if($returnType =='ANNUAL'){

				$result = $this->TblFinalSubmit->saveApplicantReplyAnnual($this->request->getData(), $return_id);
			}else
			{
				$result = $this->TblFinalSubmit->saveApplicantReply($this->request->getData(), $return_id);
			}


			echo $result;
		}
	}

	/**
	 * REMOVE APPLICANT COMMUNICATION REPLY THROUGH AJAX CALL
	 * @addedon: 08th APR 2021 (by Aniket Ganvir)
	 */
	public function removeComment()
	{

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$result = $this->TblFinalSubmit->remReply($this->request->getData());
			echo $result;
		}
	}

	/**
	 * FINAL SUBMIT AFTER REFERRED BACK FROM SUPERVISOR
	 * @addedon: 19th APR 2021 (by Aniket Ganvir)
	 */
	public function finalSubmitRef()
	{

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$result = $this->TblFinalSubmit->finalSubmitRef($this->request->getData());
			// send sms
			$customer_id = $_SESSION['username'];
            $this->loadModel('DirSmsEmailTemplates');
            // $this->DirSmsEmailTemplates->sendMessage(7,$customer_id);
			echo $result;
		}
	}

	/**
	 * REDIRECT TO THE NEXT SECTION
	 * @addedon: 20th APR 2021 (by Aniket Ganvir)
	 */
	public function nextSection($action_name, $cntrl = null, $mineral = null, $sub_min = null)
	{

		$controller = ($cntrl == null) ? 'monthly' : strtolower($cntrl);
		$section_url = '/' . $controller . '/' . $action_name;
		$section_url .= ($mineral != null) ? '/' . $mineral : '';
		$section_url .= ($sub_min != null) ? '/' . $sub_min : '';

		$sec_link = $this->Session->read('sec_link');

		$part_no = '1';
		foreach ($sec_link as $min) {
			foreach ($min as $key => $val) {
				$val = str_replace('_', '', $val);
				if (strtolower($val) == strtolower($section_url)) {
					$data['key'] = $key;
					$data['part_no'] = $part_no;
				}
			}

			$part_no++;
		}

		$nextPartNo = $data['key'] + 1;

		if (!$this->Session->read('sec_link.part_' . $data['part_no'] . '.' . $nextPartNo)) {
			$nextPartNo = 0;
			$data['part_no'] = $data['part_no'] + 1;

			if (!$this->Session->read('sec_link.part_' . $data['part_no'] . '.' . $nextPartNo)) {
				$nextPartNo = $data['key'];
				$data['part_no'] = $data['part_no'] - 1;
			}
		}

		$data = 'sec_link.part_' . $data['part_no'] . '.' . $nextPartNo;

		$this->redirect($this->Session->read($data));
	}

	/**
	 * REDIRECT TO THE PREVIOUS SECTION
	 * @addedon: 20th APR 2021 (by Aniket Ganvir)
	 */
	public function prevSection($action_name, $cntrl = null, $mineral = null, $sub_min = null)
	{

		$controller = ($cntrl == null) ? 'monthly' : strtolower($cntrl);
		$section_url = '/' . $controller . '/' . $action_name;
		$section_url .= ($mineral != null) ? '/' . $mineral : '';
		$section_url .= ($sub_min != null) ? '/' . $sub_min : '';

		$sec_link = $this->Session->read('sec_link');

		$part_no = '1';
		foreach ($sec_link as $min) {
			foreach ($min as $key => $val) {
				$val = str_replace('_', '', $val);
				if (strtolower($val) == strtolower($section_url)) {
					$data['key'] = $key;
					$data['part_no'] = $part_no;
				}
			}

			$part_no++;
		}

		$nextPartNo = $data['key'] - 1;
		if (!$this->Session->read('sec_link.part_' . $data['part_no'] . '.' . $nextPartNo)) {

			$dataNext = 'sec_link.part_' . $data['part_no'];
			$nextPartNo = array_key_last($this->Session->read($dataNext));
			$data['part_no'] = $data['part_no'] - 1;

			if (!$this->Session->read('sec_link.part_' . $data['part_no'] . '.' . $nextPartNo)) {
				$nextPartNo = $data['key'];
				$data['part_no'] = $data['part_no'] + 1;
			}
		}

		$data = 'sec_link.part_' . $data['part_no'] . '.' . $nextPartNo;

		$this->redirect($this->Session->read($data));
	}

	public function getConsignee()
	{

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$result = $this->McApplicantDet->getConsigneeName($this->request->getData());
			echo $result;
		}
	}

	public function getAppId()
	{

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$result = $this->McApplicantDet->getRegNo($this->request->getData());
			echo $result;
		}
	}

	public function getPrevClosingStocks()
	{

		$this->autoRender = false;
	}

	public function changeLanguage()
	{

		$this->autoRender = false;
		$cur_lang = $this->Session->read('lang');
		if ($cur_lang == 'english') {

			$new_lang = 'hindi';
		} else {
			$new_lang = 'english';
		}

		$this->Session->write('lang', $new_lang);
	}


	/**
	 * Made by Shweta Apale 24-01-2022
	 * To check gold value between Smelter & Sale product section greter than 2% error allowed
	 * And give alert
	 */
	public function checkGoldValue()
	{
		$this->autoRender = false;
		$return = 0;
		if ($this->request->is('post')) {
			if (!empty($this->request->getData('rc_divide_smelter'))) {
				$rc_divide_smelter = $this->request->getData('rc_divide_smelter');
				$this->Session->write('smelter_gold', $rc_divide_smelter);
			}

			if (!empty($this->request->getData('rc_divide_sale'))) {
				$rc_divide_sale = $this->request->getData('rc_divide_sale');
				$this->Session->write('sale_gold', $rc_divide_sale);
			}

			if ($this->Session->read('smelter_gold') && $this->Session->read('sale_gold')) {
				$smelter_gold = $this->Session->read('smelter_gold');
				$sale_gold = $this->Session->read('sale_gold');
				$totalGold = $sale_gold + $smelter_gold;
				$diffGold = $smelter_gold - $sale_gold;
				$diffPercentGold = ($diffGold/$totalGold)*100;

				if($diffPercentGold > 2)
				{
					$return = 1;
				}
			}
		}
		echo $return;
	}
}
