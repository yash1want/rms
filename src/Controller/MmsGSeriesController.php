<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Network\Email\Email;
use Cake\ORM\Entity;
use Cake\Datasource\ConnectionManager;

class MmsGSeriesController extends AppController{
		
	var $name = 'MmsGSeries';
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
		$this->CapitalStructure = $this->getTableLocator()->get('CapitalStructure');
		$this->CostProduction = $this->getTableLocator()->get('CostProduction');
		$this->DirMachinery = $this->getTableLocator()->get('DirMachinery');
		$this->DirMcpMineral = $this->getTableLocator()->get('DirMcpMineral');
		$this->DirWorkStoppage = $this->getTableLocator()->get('DirWorkStoppage');
		$this->Employment = $this->getTableLocator()->get('Employment');
		$this->ExplorationDetails = $this->getTableLocator()->get('ExplorationDetails');
		$this->ExplosiveConsumption = $this->getTableLocator()->get('ExplosiveConsumption');
		$this->LeaseReturn = $this->getTableLocator()->get('LeaseReturn');
		$this->Machinery = $this->getTableLocator()->get('Machinery');
		$this->MaterialConsumption = $this->getTableLocator()->get('MaterialConsumption');
		$this->McpLease = $this->getTableLocator()->get('McpLease');
		$this->Mine = $this->getTableLocator()->get('Mine');
		$this->MineralWorked = $this->getTableLocator()->get('MineralWorked');
		$this->OverburdenWaste = $this->getTableLocator()->get('OverburdenWaste');
		$this->Prod1 = $this->getTableLocator()->get('Prod1');
		$this->RentReturns = $this->getTableLocator()->get('RentReturns');
		$this->ReservesResources = $this->getTableLocator()->get('ReservesResources');
		$this->SubgradeMineralReject = $this->getTableLocator()->get('SubgradeMineralReject');
		$this->TblFinalSubmit = $this->getTableLocator()->get('TblFinalSubmit');
		$this->TreesPlantSurvival = $this->getTableLocator()->get('TreesPlantSurvival');
		$this->WorkStoppage = $this->getTableLocator()->get('WorkStoppage');
		
    }
    
    // PART I: PARTICULARS OF AREA OPERATED
    public function particulars(){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partI', 3);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partI', 3, '', $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','3');
        $this->set('part_no','partI');
        $this->set('mineral','');
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partI', '3', '');

		$labels = $this->Language->getFormInputLabels('particulars', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
		//==============================CONSUMING WEB SERVICE=======================
		//consume the list of minecodes and minenames of the mine owner
		$mineOwner = $this->Session->read('mc_parent_id');
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

		
		// $mineData = objectToArray($xml);
		$mineData = $applicantMinesDetails;
		// foreach ($mineData['complexMinesDetails'] as $m) {
		foreach ($mineData as $m) {
			$mineral_sep_name = $this->MineralWorked->getSnCalMineralName($m['mcm_mine_code']);
			$mine_codes[] = $m['mcm_mine_code'];
			// $mine_data[$m['mcmd_mine_name'] . " - " . $m['mcm_mine_code'] . " - " . $mineral_sep_name] = $m['mcmd_mine_name'] . " - " . $m['mcm_mine_code'] . " - " . $mineral_sep_name;
			$mine_data[$m['mcm_mine_desc'] . " - " . $m['mcm_mine_code'] . " - " . $mineral_sep_name] = $m['mcm_mine_desc'] . " - " . $m['mcm_mine_code'] . " - " . $mineral_sep_name;
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

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Particulars of Area Operated</b> successfully!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'area_utilisation'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Particulars of Area Operated</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'area_utilisation'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Particulars of Area Operated</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'particulars'));
            }

		}

    }
	
    // PART I: LEASE AREA UTILISATION
    public function areaUtilisation(){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partI', 4);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partI', 4, '', $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','4');
        $this->set('part_no','partI');
        $this->set('mineral','');
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partI', '4', '');

		$labels = $this->Language->getFormInputLabels('area_utilisation', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
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

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Lease Area Utilisation</b> successfully!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'employmentWages'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Lease Area Utilisation</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'employmentWages'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Lease Area Utilisation</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'areaUtilisation'));
            }

		}

    }
	
    // PART II: EMPLOYMENT & WAGES I
    public function employmentWages(){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partII', 1);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partII', 1, '', $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','1');
        $this->set('part_no','partII');
        $this->set('mineral','');
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partII', '1', '');

		$labels = $this->Language->getFormInputLabels('employment_wages', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);
		
		$formType = 1;
		$reasonsArr = $this->DirWorkStoppage->getReasonsArr();
		$reasonsLen = count($reasonsArr);
		$empWages = $this->RentReturns->getAllData($mineCode, $returnType, $returnDate, $formType);
        $workData = $this->WorkStoppage->fetchWorkingDetails($mineCode, $returnType, $returnDate);
        $workDataMonthly = $this->WorkStoppage->fetchWorkingDetailsMonthly($mineCode, $returnDate);

		$startDate = date_create(date('Y', strtotime($returnDate)).'-04-01');
		$endDate = date_create((date('Y', strtotime($returnDate))+1).'-04-01');
		$interval = date_diff($startDate, $endDate);
		$noDays = ($interval->days);

		$this->set('reasonsArr', $reasonsArr);
		$this->set('reasonsLen', $reasonsLen);
		$this->set('empWages', $empWages);
		$this->set('workData', $workData);
		$this->set('workDataMonthly', $workDataMonthly);
		$this->set('noDays', $noDays);
		$this->set('diff_color_code', 1); // to display color code for difference between cumulative monthly data & annual return
        
		$this->render('/element/annual/employment_wages');

		if($this->request->is('post')){

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Employment Wages</b> successfully!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'employmentWagesPart'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Employment Wages</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'employmentWagesPart'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Employment Wages</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'employmentWages'));
            }

		}

    }

	
    // PART II: EMPLOYMENT & WAGES II
    public function employmentWagesPart(){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partII', 3);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partII', 3, '', $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','3');
        $this->set('part_no','partII');
        $this->set('mineral','');
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partII', '3', '');

		$labels = $this->Language->getFormInputLabels('employment_wages_part', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		$startDate = (date('Y',strtotime($returnDate))).'-04-01';
		$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
		$endDate = date('Y-m-t', strtotime($endDate));
		
		$formType = 5;
		$empData = $this->Employment->getEmploymentWagesPart2Details($mineCode, $returnDate, $formType);
		$empDataMonthly = $this->Employment->getEmploymentWagesPart2DataMonthly($mineCode, $returnDate, $formType);

		$this->set('startDate', $startDate);
		$this->set('endDate', $endDate);
		$this->set('empData', $empData);
		$this->set('empDataMonthly', $empDataMonthly);
        
		$this->render('/element/annual/employment_wages_part');

		if($this->request->is('post')){

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Employment & Wages (II)</b> successfully!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'capitalStructure'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Employment & Wages (II)</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'capitalStructure'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Employment & Wages (II)</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'employmentWagesPart'));
            }

		}

    }

	
    // PART II: CAPITAL STRUCTURE
    public function capitalStructure(){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partII', 2);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partII', 2, '', $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','2');
        $this->set('part_no','partII');
        $this->set('mineral','');
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partII', '2', '');

		$labels = $this->Language->getFormInputLabels('capital_structure', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		//==============================CONSUMING WEB SERVICE=======================
		//consume the list of minecodes and minenames of the mine owner
		$mineOwner = $this->Session->read('mc_parent_id');
		$applicantMinesData = $this->McpLease->getApplicantMinesDetails($mineOwner, $mineCode);
		
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

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Capital Structure</b> successfully!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'materialConsumptionQuantity'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Capital Structure</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'materialConsumptionQuantity'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Capital Structure</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'capital_structure'));
            }

		}

    }
	
    // PART III: QUANTITY & COST OF MATERIAL
    public function materialConsumptionQuantity(){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partIII', 1);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partIII', 1, '', $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','1');
        $this->set('part_no','partIII');
        $this->set('mineral','');
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partIII', '1', '');

		$labels = $this->Language->getFormInputLabels('material_consumption_quantity', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
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

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Quantity & Cost of Material</b> successfully!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'materialConsumptionRoyalty'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Quantity & Cost of Material</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'materialConsumptionRoyalty'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Quantity & Cost of Material</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'material_consumption_quantity'));
            }

		}

    }

	
    // PART III: ROYALTY / COMPENSATION / DEPRECIATION
    public function materialConsumptionRoyalty(){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partIII', 2);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partIII', 2, '', $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','2');
        $this->set('part_no','partIII');
        $this->set('mineral','');
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partIII', '2', '');

		$labels = $this->Language->getFormInputLabels('material_consumption_royalty', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
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
		$matConsRoyDataMonthly = $this->RentReturns->getMatConsRoyaltyDataMonthly($mineCode, $returnDate, $formType);

		$this->set('depriciationTotal', $depriciationTotal);
		$this->set('monthlyRoyaltyTotal', $monthlyRoyaltyTotal);
		$this->set('matConsRoyData', $matConsRoyData);
		$this->set('matConsRoyDataMonthly', $matConsRoyDataMonthly);

		$this->render('/element/annual/material_consumption_royalty');

		if($this->request->is('post')){

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Royalty / Compensation / Depreciation</b> successfully!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'materialConsumptionTax'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Royalty / Compensation / Depreciation</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'materialConsumptionTax'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Royalty / Compensation / Depreciation</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'material_consumption_royalty'));
            }

		}

    }

	
    // PART III: TAXES / OTHER EXPENSES
    public function materialConsumptionTax(){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partIII', 3);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partIII', 3, '', $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','3');
        $this->set('part_no','partIII');
        $this->set('mineral','');
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partIII', '3', '');

		$labels = $this->Language->getFormInputLabels('material_consumption_tax', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		$formType = 3;
		$matConsTaxData = $this->RentReturns->getMatConsTaxDetails($mineCode, $returnDate, $formType);

		$this->set('matConsTaxData', $matConsTaxData);
        
		$this->render('/element/annual/material_consumption_tax');

		if($this->request->is('post')){

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Taxes/Other Expenses</b> successfully!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'explosiveConsumption'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Taxes/Other Expenses</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'explosiveConsumption'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Taxes/Other Expenses</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'material_consumption_tax'));
            }

		}

    }

	
    // PART IV: CONSUMPTION OF EXPLOSIVES
    public function explosiveConsumption(){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partIV', 1);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partIV', 1, '', $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','1');
        $this->set('part_no','partIV');
        $this->set('mineral','');
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partIV', '1', '');

		$labels = $this->Language->getFormInputLabels('explosive_consumption', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
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

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Consumption of Explosives</b> successfully!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'geologyExploration'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Consumption of Explosives</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'geologyExploration'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Consumption of Explosives</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'explosive_consumption'));
            }

		}

    }

	
    // PART V: SEC 1 : EXPLORATION
    public function geologyExploration(){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partV', 1);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partV', 1, '', $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','1');
        $this->set('part_no','partV');
        $this->set('mineral','');
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partV', '1', '');

		$labels = $this->Language->getFormInputLabels('geology_exploration', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
		$period = $returnYear . " - " . ($returnYear + 1);
		$formType12 = $this->Session->read('mc_form_type');
		$form_count = substr($formType12, -1);
		$formtype1= $this->Clscommon->getFormRuleNumber($form_count);

		$formData = $this->ExplorationDetails->getAllData($mineCode, $returnType, $returnDate);

		$this->set('formData', $formData);
        
		$this->render('/element/annual/geology_exploration');

		if($this->request->is('post')){

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Geology Exploration</b> successfully!');
                $this->redirect($this->nextSection('geologyExploration', 'mmsGSeries'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Geology Exploration</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('geologyExploration', 'mmsGSeries'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Geology Exploration</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'geology_exploration'));
            }

		}

    }

	
    // PART V: SEC 2/3 : RESERVES AND RESOURCES ESTIMATED / SUBGRADE-MINERAL REJECT
    public function geologyReservesSubgrade($mineral){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partV', 2, $mineral);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partV', 2, $mineral, $userRole);
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','2');
        $this->set('part_no','partV');
        $this->set('mineral',$mineral);
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partV', '2', $mineral);

		$labels = $this->Language->getFormInputLabels('geology_reserves_subgrade', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
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

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Reserves Resources Estimated & Subgrade-Mineral Reject</b> successfully!');
                $this->redirect($this->nextSection('geologyReservesSubgrade', 'mmsGSeries', $mineral));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Reserves Resources Estimated & Subgrade-Mineral Reject</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('geologyReservesSubgrade', 'mmsGSeries', $mineral));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Reserves Resources Estimated & Subgrade-Mineral Reject</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'geology_reserves_subgrade', $mineral));
            }

		}

    }

    // PART V: SEC 4/5 : OVERBURDEN AND WASTE / TREES PLANTED- SURVIVAL RATE
    public function geologyOverburdenTrees(){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partV', 3);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partV', 3, '', $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','3');
        $this->set('part_no','partV');
        $this->set('mineral','');
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partV', '3', '');

		$labels = $this->Language->getFormInputLabels('geology_overburden_trees', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
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

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Overburden, Waste & Trees Planted - Survival Rate</b> successfully!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'geologyPartThree'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Overburden, Waste & Trees Planted - Survival Rate</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'geologyPartThree'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Overburden, Waste & Trees Planted - Survival Rate</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'geology_overburden_trees'));
            }

		}

    }

    // PART V: SEC 6 :  TYPE OF MACHINERY
    public function geologyPartThree(){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partV', 4);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partV', 4, '', $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','4');
        $this->set('part_no','partV');
        $this->set('mineral','');
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partV', '4', '');

		$labels = $this->Language->getFormInputLabels('geology_part_three', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
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

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Type of Machinery</b> successfully!');
                $this->redirect($this->nextSection('geologyPartThree', 'mmsGSeries'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Type of Machinery</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('geologyPartThree', 'mmsGSeries'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Type of Machinery</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'geology_part_three'));
            }

		}

    }
	
    // PART V: SEC 7 : MINERAL TREATMENT PLANT
    public function geologyPartSix($mineral){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partV', 5, $mineral);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partV', 5, $mineral, $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','5');
        $this->set('part_no','partV');
        $this->set('mineral',$mineral);
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partV', '5', $mineral);

		$labels = $this->Language->getFormInputLabels('geology_part_six', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
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

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Mineral Treatment Plant ('.$mineral.')</b> successfully!');
                $this->redirect($this->nextSection('geologyPartSix', 'mmsGSeries', $mineral));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Mineral Treatment Plant ('.$mineral.')</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('geologyPartSix', 'mmsGSeries', $mineral));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Mineral Treatment Plant ('.$mineral.')</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'geology_part_six', $mineral));
            }

		}

    }

	
    // PART VII: COST OF PRODUCTION
    public function productionCost(){

		$this->viewBuilder()->setLayout('mms/form_layout');

		$mineCode = $this->Session->read('mc_mine_code');
		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');
		$returnYear = $this->Session->read('mc_sel_year');
		$formNo = $this->Session->read('mc_form_type');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        if ($returnType == "") {
            $returnType = 'MONTHLY';
		}

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1) {
            $master_admin = true;
		}

        $is_pri_pending = false;
        if(null !== $this->Session->read('is_pri_pending')){
        	$is_pending = $this->Session->read('is_pri_pending');
        	if ($is_pending == 1){
            	$is_pri_pending = true;
        	}
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly',$viewOnly);
        $this->set('is_pri_pending',$is_pri_pending);
        $this->set('view',$this->Session->read('form_status'));
        $this->set('returnDate',$returnDate);
        $this->set('returnYear',$returnYear);

        // $this->form = new mineDetailsForm();
        $userRole = $role;

        // below added code added by ganesh satav
        // below added code for take for no 
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;
        
        $this->Session->write('mc_form_type',$formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page',$return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED..... 
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        // communication
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r){
            $reasons[] = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partVII', 1);
            $reason_data = $this->TblFinalSubmit->getReasonAnnual($r['id'], 'partVII', 1, '', $this->Session->read('mms_user_role'));
            if(isset($reason_data['commented']) && $reason_data['commented'] == '1'){
            	$commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole',$mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId',$mmsUserId);
        $this->set('sectionId','1');
        $this->set('part_no','partVII');
        $this->set('mineral','');
        $this->set('sub_min','');

		$lang = $this->Session->read('lang');

		$this->ironOreCategory($mineCode, $returnType, $returnDate);
		$this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, 'partVII', '1', '');

		$labels = $this->Language->getFormInputLabels('production_cost', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

		$commentLabel = $this->Customfunctions->getCommentLabel($mmsUserRole);

		$this->set('reasons',$reasons);
		$this->set('commentLabel',$commentLabel);
		$this->set('label',$labels);
		$this->set('tableForm', '');
		$this->set('formId', 'F01');
		$this->set('mineCode', $mineCode);
		$this->set('isMineOwner', $isMineOwner);
		$this->set('is_all_approved', $is_all_approved);
		$this->set('returnType', $returnType);
		$this->set('formNo', $formNo);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);

        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . '-' . $returnMonth . '-01';

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

		$is_rejected_section = ''; // need to review
		$this->set('is_rejected_section',$is_rejected_section);



		// section data
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

			$result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());
            
            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Cost of Production</b> successfully!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'production_cost'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Cost of Production</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'production_cost'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Cost of Production</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mmsGSeries', 'action' => 'production_cost'));
            }

		}

    }
    
	public function executeUserleftnav($mine_code, $mineral_name = null){
        
        $returnType = $this->Session->read('returnType');
        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . "-" . $returnMonth . "-01";

		//========CONTAINS THE LIST OF ALL THE MINERAL OF THE PARTICULAR MINE=======
		$this->loadModel('MineralWorked');
		$minerals = $this->MineralWorked->fetchMineralInfo($mine_code);
		foreach($minerals as $mineral){
			$mineralArr[] = $mineral['mineral_name'];	
		}

		$this->Session->write('mineralArr',$mineralArr);

		// $this->sectionFillStatus($mine_code);
        $returnId = $this->TblFinalSubmit->getLatestReturnId($mine_code, $returnDate, $returnType);
        $this->Customfunctions->setMinerSectionColorCode($returnId);
		//$this->Customfunctions->sectionFillStatus($mine_code);

		$this->commentStatus($mine_code);

        //=====================$mineralWorked CONTAINS THE WHOLE ARRAY AND HENCE WE 
        //=============================ARE STORIG WHOLE ARRAY TO SESSION============
		$mineralWorked = $minerals[0];
		$this->set('primary_min', $mineralWorked);

		//=========CODE RETURN TRUE IF DATA IS FOUND IN THE DB ELSE FALSE===========
		//code for HEMATITE, MAGNETITE:start
		// $returnType = 'MONTHLY';
		$returnType = $this->Session->read('returnType');
		$returnYear = $this->Session->read('mc_sel_year');
		$returnMonth = $this->Session->read('mc_sel_month');
		$returnDate = $returnYear . "-" . $returnMonth . "-01";
		$minHematite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'hematite');
		$minMagnetite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'magnetite');

		if($minHematite == true){
			$is_hematite = true;
		} else {
			$is_hematite = false;
		}

		if($minMagnetite == true){
			$is_magnetite = true;
		} else {
			$is_magnetite = false;
		}
		$this->set('is_hematite',$is_hematite);
		$this->set('is_magnetite',$is_magnetite);

		//======STORING THE VARIABLE IN BOTH UPPER CASE AND IN LOWER CASE IN $this->partIIM1
        //========OUTPUT OF THE BELOW CODE PRITING IS: Array ( [0] => MICA [1] => mica ) 
		$mineralWorked['mineral_name'] = trim($mineralWorked['mineral_name']);
		$partIIM1 = array($mineralWorked['mineral_name'], strtolower(str_replace(' ','_', $mineralWorked['mineral_name'])));
		$partIIM1['formNo'] = $this->DirMcpMineral->getFormNumber($partIIM1[1]);

		$this->set('partIIM1',$partIIM1);

		//=============GETS THE FORM TYPE FROM THE SESSION LIKE F5==================
		$formType = $this->Session->read('mc_form_type');

		//=====STORING THE OTHER MINERALS IF PRESENT IN THE $this->partIIMOther[] AS
        //=========( [0] => Array ( [0] => COPPER ORE [1] => copper_ore ))==========
        $partIIMOther = [];
        if(count($minerals) > 1){
        	$otherMinerals = [];
        	for($i=1; $i<count($minerals); $i++){
        		$otherMinerals[] = $minerals[$i]['mineral_name'];
        	}

        	foreach($otherMinerals as $otrMineral){
        		$otrMineral = trim($otrMineral);
        		if($otrMineral != ''){
        			$partIIMOther[] = array($otrMineral, strtolower(str_replace(' ','_', $otrMineral)));
        		}
        	}
        }

        foreach ($partIIMOther as $key=>$value){
        	$partIIMOther[$key]['formNo'] = $this->DirMcpMineral->getFormNumber($partIIMOther[$key][0]);
        }

        $this->set('partIIMOther',$partIIMOther);

		//show grades as per primary minerals
		$mineralArr = $this->Session->read('mineralArr');
		$rom_grade = false;
		$mineral_sp = strtoupper(str_replace('_', ' ', $mineral_name));

		if(in_array($mineralArr[0], array('IRON ORE', 'CHROMITE'))){

			if($mineral_sp == $mineralArr[0]){
				$rom_grade = true;
			}

		}
		$this->set('rom_grade', $rom_grade);

		//set comment mode "editable" or "readable" as per return status
		$returnId = $this->TblFinalSubmit->getLatestReturnId($mine_code, $returnDate, $returnType);
		$returnData = $this->TblFinalSubmit->findReturnById($returnId);
		$comment_mode = ($returnData['status'] == 0) ? 'edit' : 'read';
		$this->set('comment_mode', $comment_mode);
		
		if ($returnType == 'ANNUAL') {
			$allMin = $this->Session->read('mineralArr');
			$this->set('allMin',$allMin);
		}

	}

	/**
     * FUNCTION TO CHECK SUPERVISOR COMMENT ON SECTIONS
     * RETURN '1' IF ONE OR MORE COMMENT MADE ON SECTION
     * RETURN '0' IF NO COMMENT MADE ON ANY SECTION
     * @addedon: 12th APR 2021 (by Aniket Ganvir)
     */
	public function commentStatus($mine_code){

		$returnType = $this->Session->read('returnType');
		$returnDate = $this->Session->read('returnDate');

        $latestReason = $this->TblFinalSubmit->getLatestReasons($mine_code, $returnDate, $returnType);
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

	public function ironOreCategory($mine_code, $returnType, $returnDate){
		
		$minHematite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'hematite');
		$minMagnetite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'magnetite');

		if($minHematite == true){
			$is_hematite = true;
		} else {
			$is_hematite = false;
		}

		if($minMagnetite == true){
			$is_magnetite = true;
		} else {
			$is_magnetite = false;
		}
		$this->Session->write('is_hematite',$is_hematite);
		$this->Session->write('is_magnetite',$is_magnetite);

	}
    
    /**
     * SET COMMENT MODE "EDITABLE" OR "READABLE" AS PER RETURN STATUS
     * @version 22nd Dec 2021
     * @author Aniket Ganvir
     */
    public function commentMode($mineCode, $returnDate, $returnType, $partNo, $secId, $min) {
		$returnId = $this->TblFinalSubmit->getLatestReturnId($mineCode, $returnDate, $returnType);
		$returnData = $this->TblFinalSubmit->findReturnById($returnId);

        $status = array('0','2');
        $comment_mode = (in_array($returnData['status'], $status)) ? 'edit' : 'read';

		//$comment_mode = ($returnData['status'] == 0) ? 'edit' : 'read';
        $minUndLow = strtolower(str_replace(' ','_',$min)); // mineral underscore lowercase
        $referBackBtn = 0;
        $disapproveBtn = 0;
        $verifiedFlag = $returnData['verified_flag'];


        if ($comment_mode == 'edit') {

            $tmpSec = $returnData['approved_sections'];
            $appSec = unserialize($tmpSec);
            
            if ($min == '') {
                
                if (isset($appSec[$partNo][$secId]) && $appSec[$partNo][$secId] == 'Approved') {
                    $comment_mode = 'read';
                }

            } else {

                if (isset($appSec[$partNo][$secId][$minUndLow]) && $appSec[$partNo][$secId][$minUndLow] == 'Approved') {
                    $comment_mode = 'read';
                }
                

            }


            // SET REFERRED BACK BUTTON STATUS
            if (is_array($appSec)) {
                foreach ($appSec as $partK=>$partV) {

                    if ($partK == 'iron_ore') {

                        foreach ($partV as $k => $v) {
                            foreach ($v as $status) {
                                if ($status == 'Rejected') {
                                    $referBackBtn = 1;
                                }
                                else if ($status == 'Approved') {
                                    $disapproveBtn = 1;
                                }
                            }
                        }

                    } else {
                        foreach($partV as $k => $status) {
                            if(gettype($status)=='array')
                            {
                                foreach ($status as $mine) {
                                    if ($mine == 'Rejected') {
                                        $referBackBtn = 1;
                                    } else if ($status == 'Approved') {
                                        $disapproveBtn = 1;
                                    }
                                }
                            }else{
                                if ($status == 'Rejected') {
                                $referBackBtn = 1;
                                } else if ($status == 'Approved') {
                                    $disapproveBtn = 1;
                                }
                            }

                            
                        }
                    }

                }

            } 

        }

        $main_sec = $this->getRequest()->getSession()->read("main_sec");
        //$LastAppSec = $this->TblFinalSubmit->checkIsLastApproved($returnId,serialize($main_sec));
        $LastAppSec = $this->TblFinalSubmit->checkIsLastApprovedAnnual($returnId,serialize($main_sec),$minUndLow);

		$this->set('comment_mode', $comment_mode);
		$this->set('return_id', $returnId);
		$this->set('referBackBtn', $referBackBtn);
        $this->set('disapproveBtn', $disapproveBtn);
        $this->set('lastPart', $LastAppSec['lastPart']);
        $this->set('lastSec', $LastAppSec['lastSec']);
        $this->set('verifiedFlag', $verifiedFlag);


    }
    /**
     * REDIRECT TO THE NEXT SECTION
     * @addedon: 13th APR 2021 (by Aniket Ganvir)
     */
    public function nextSection($action_name,$cntrl = null,$mineral = null,$sub_min = null){
        
        $controller = ($cntrl == null) ? 'mms' : strtolower($cntrl);
        $section_url = '/'.$controller.'/'.$action_name;
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
     * @addedon: 23th JUL 2021 (by Aniket Ganvir)
     */
    public function prevSection($action_name,$cntrl = null,$mineral = null,$sub_min = null){
        
        $controller = ($cntrl == null) ? 'mms' : strtolower($cntrl);
        $section_url = '/'.$controller.'/'.$action_name;
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

            $dataNext = 'sec_link.part_'.$data['part_no'];
            $nextPartNo = array_key_last($this->Session->read($dataNext));
            $data['part_no'] = $data['part_no'] - 1;

            if(!$this->Session->read('sec_link.part_'.$data['part_no'].'.'.$nextPartNo)){
                $nextPartNo = $data['key'];
                $data['part_no'] = $data['part_no'] + 1;
            }
        }

        $data = 'sec_link.part_'.$data['part_no'].'.'.$nextPartNo;

        $this->redirect($this->Session->read($data));

    }

    /**
     * Get next section link for redirection purpose
     * @version 24th Nov 2021
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
     * DISAPPROVE THE RETURN
     * @addedon: 19th DEC 2022
     */
    public function disapproveReturn()
    {
        $this->autoRender = false;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData());

            echo $result;
        }
    }

}
