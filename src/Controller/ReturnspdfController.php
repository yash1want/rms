<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Network\Email\Email;
use Cake\ORM\Entity;
use Cake\ORM\Locator\LocatorAwareTrait;
use tcpdf;
use MyCustomPDFWithWatermark;
use PDF_Rotate;
use xmldsign;
use Cake\Utility\Xml;
use FR3D;
use Cake\View;

class ReturnspdfController extends AppController{

    var $name = 'Returnspdf';
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
		$this->CapitalStructure = $this->getTableLocator()->get('CapitalStructure');
		$this->CostProduction = $this->getTableLocator()->get('CostProduction');
		$this->DirCountry = $this->getTableLocator()->get('DirCountry');
		$this->DirDistrict = $this->getTableLocator()->get('DirDistrict');
		$this->DirGrid = $this->getTableLocator()->get('DirGrid');
		$this->DirMachinery = $this->getTableLocator()->get('DirMachinery');
		$this->DirMcpMineral = $this->getTableLocator()->get('DirMcpMineral');
		$this->DirMeMineral = $this->getTableLocator()->get('DirMeMineral');
		$this->DirMetal = $this->getTableLocator()->get('DirMetal');
		$this->DirMineralGrade = $this->getTableLocator()->get('DirMineralGrade');
		$this->DirNmiGrade = $this->getTableLocator()->get('DirNmiGrade');
		$this->DirProduct = $this->getTableLocator()->get('DirProduct');
		$this->DirRomGrade = $this->getTableLocator()->get('DirRomGrade');
		$this->DirSizeRange = $this->getTableLocator()->get('DirSizeRange');
		$this->DirState = $this->getTableLocator()->get('DirState');
		$this->DirWorkStoppage = $this->getTableLocator()->get('DirWorkStoppage');
		$this->Employment = $this->getTableLocator()->get('Employment');
		$this->EsignPdfRecords = $this->getTableLocator()->get('EsignPdfRecords');
		$this->ExplorationDetails = $this->getTableLocator()->get('ExplorationDetails');
		$this->ExplosiveConsumption = $this->getTableLocator()->get('ExplosiveConsumption');
		$this->ExplosiveReturn = $this->getTableLocator()->get('ExplosiveReturn');
		$this->ExtraNSeriesProdActivity = $this->getTableLocator()->get('ExtraNSeriesProdActivity');
		$this->GradeProd = $this->getTableLocator()->get('GradeProd');
		$this->GradeRom = $this->getTableLocator()->get('GradeRom');
		$this->GradeSale = $this->getTableLocator()->get('GradeSale');
		$this->IncrDecrReasons = $this->getTableLocator()->get('IncrDecrReasons');
		$this->KwClientType = $this->getTableLocator()->get('KwClientType');
		$this->LeaseReturn = $this->getTableLocator()->get('LeaseReturn');
		$this->Machinery = $this->getTableLocator()->get('Machinery');
		$this->MaterialConsumption = $this->getTableLocator()->get('MaterialConsumption');
		$this->McApplicantDet = $this->getTableLocator()->get('McApplicantDet');
		$this->McMclatlongDet = $this->getTableLocator()->get('McMclatlongDet');
		$this->McMineralconsumptionDet = $this->getTableLocator()->get('McMineralconsumptionDet');
		$this->McMineralconsumptiondistrictDet = $this->getTableLocator()->get('McMineralconsumptiondistrictDet');
		$this->McMineraltradingstorageexportDet = $this->getTableLocator()->get('McMineraltradingstorageexportDet');
		$this->McMineraltradingstorageexportdistrictDet = $this->getTableLocator()->get('McMineraltradingstorageexportdistrictDet');
		$this->McpLease = $this->getTableLocator()->get('McpLease');
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
		$this->OverburdenWaste = $this->getTableLocator()->get('OverburdenWaste');
		$this->Prod1 = $this->getTableLocator()->get('Prod1');
		$this->Prod5 = $this->getTableLocator()->get('Prod5');
		$this->ProdMica = $this->getTableLocator()->get('ProdMica');
		$this->ProdStone = $this->getTableLocator()->get('ProdStone');
		$this->Pulverisation = $this->getTableLocator()->get('Pulverisation');
		$this->RecovSmelter = $this->getTableLocator()->get('RecovSmelter');
		$this->Returns = $this->getTableLocator()->get('Returns');
		$this->RentReturns = $this->getTableLocator()->get('RentReturns');
		$this->Reserves = $this->getTableLocator()->get('Reserves');
		$this->ReservesResources = $this->getTableLocator()->get('ReservesResources');
		$this->Rom5 = $this->getTableLocator()->get('Rom5');
		$this->RomMetal5 = $this->getTableLocator()->get('RomMetal5');
		$this->RomStone = $this->getTableLocator()->get('RomStone');
		$this->Sale5 = $this->getTableLocator()->get('Sale5');
		$this->SubgradeMineralReject = $this->getTableLocator()->get('SubgradeMineralReject');
		$this->TblEndUserFinalSubmit = $this->getTableLocator()->get('TblEndUserFinalSubmit');
		$this->TblFinalSubmit = $this->getTableLocator()->get('TblFinalSubmit');
		$this->TblMinWorked = $this->getTableLocator()->get('TblMinWorked');
		$this->TreesPlantSurvival = $this->getTableLocator()->get('TreesPlantSurvival');
		$this->WorkStoppage = $this->getTableLocator()->get('WorkStoppage');

		if(null == $this->getRequest()->getSession()->read('lang')) {
			$this->getRequest()->getSession()->write('lang','english');
		}
		
		$this->Customfunctions->formReturnTitle();

    }

	// Generate F and G returns Pdf
    public function minerPrintPdf(){

		$this->viewBuilder()->setLayout('print_panel');

		// Common data
		$pdfStatus = 1;
        //=================GETTING CLIENT IP ADDRESS AND MAKING TIMESTAMP===========
        $ipAddress = $this->Clscommon->getIpAddresses();
        $timeStamp = date('Y-m-d H:i:s');
        $ipTimeFormat = "From: " . $ipAddress . " at " . $timeStamp;

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
        $returnType = $this->Session->read('returnType');
		$lang = $this->Session->read('lang');
		
        $mineral = $this->Session->read('mc_mineral');
        if ($mineral == null) {
            $mineral = $this->MineralWorked->getMineralName($mineCode);
        }

		$min_sp = strtolower(str_replace('_', ' ', $mineral));
        $mineral = strtolower(str_replace(' ', '_', $mineral));
        
		$this->Customfunctions->executeUserleftnav($mineCode);

        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
		}

		$formNo = $this->Session->read('mc_form_type');
		$formNoMain = $this->Session->read('mc_form_main');
		
        $mine = $this->Mine->getMineDetails($mineCode, $returnType, $returnDate);
        //=====ADDED BY UDAY FOR GETTING THE REGION NAME BASED ON THE DISTRICT NAME=====
        $districtName = $mine['district'];
        // $regionName = $this->DirDistrict->getRegionNameByDistrictName($districtName);
        $regionName = $this->DirDistrict->getRegionNameByDistrictName($districtName, $mine['state_code'], $mine['district_code']);

        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);

        if(null!==$this->request->getQuery('iron_sub_min')){
        	$ironSubMin = $this->request->getQuery('iron_sub_min');
            $ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
        } else {
        	$ironSubMin = "";
            $ironSubMinStr = '';
        }

        $isExists = $this->Mine->checkMine($mineCode);

		$finalSubmitDate = null;
        $is_final_submitted = $this->TblFinalSubmit->checkIsSubmitted($mineCode, $returnDate, $returnType);

        if ($is_final_submitted == true) {
            $finalSubmitDate = $this->TblFinalSubmit->getDateForPrintAndPdf($mineCode, $returnDate, $returnType);
			$finalSubmitDate = date('d-m-Y', strtotime($finalSubmitDate));
            $img_name = "final-submited.jpg";
        } else {
            $img_name = "draft.jpg";
        }

        // $bg_img = $this->getUser()->setAttribute('bg_image', $this->img_name);
		$this->Session->write('bg_image'.$img_name);

		$returnPdfStatus = $this->TblFinalSubmit->getPdfStatus($mineCode, $returnDate, $returnType);
		$this->Session->write('pdfBgText', $returnPdfStatus);
		
		// pravin bhakare 01-07-2021
		$size_ranges = $this->DirSizeRange->getSizeRange();

        // if ($mineralProduced == '')
        //     $this->mineralProduced = $this->getUser()->getAttribute('mine_minerals');
		// if(!$this->mineralProduced)
		// 	$this->mineralProduced []= $this->mineral;     // NOW ASSIGNING THE ALL USER MINERALS TO MINERAL PRODUCED ARRAY, DONE BY PRAVIN BHAKARE, 01-07-2019
		// 	//$this->mineralProduced []= $this->getRequestParameter('min');
		$mineralProduced []= $mineral;

		$loginusertype = $this->Session->read('loginusertype');
		$username = (null!==$this->Session->read('username')) ? $this->Session->read('username') : null;
		$mc_data = $this->McUser->getMCNameDesi($mineCode, $returnDate, $returnType, $loginusertype, $username);
        $fillerName = $mc_data['Name'];
        $fillerdesignation = $mc_data['desi'];

		$returnMonth = date('F', strtotime($returnDate));
		$returnYear = date('Y', strtotime($returnDate));
        $period = $returnYear . " - " . ($returnYear + 1);

        /**
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 17th Jan 2014 
		 * 
		 * ADDED AS THE WORK DONE FROM BANGALORE IN NOV 2013
		 * ADDED THE HARD CODED VALUES AND NOW USING THE MASTER TO GET THESE VALUES 
		 */

		// $nmiGrades = DIR_NMI_GRADETable::getNmiGrades();
		$nmiGrades = $this->DirNmiGrade->getNmiGrades();
		// NOT DELETED THE HARD-CODED ARRAY AS IF SOMETHING WENT WRONG WITH THIS FORM
		// THIS MIGHT BE HELP FULL TO CHECK IF IT'S THE PROBLEM OF DATA STRUCTURE -- DATED - 20th Aug 2013
		// $this->nmiGrades = Array(
		// 	'1' => 'Lump High Grade',
		// 	'2' => 'Lump Medium Grade',
		// 	'3' => 'Lump Low Grade',
		// 	'4' => 'Lump Unclassified Grade',
		// 	'5' => 'Fines High Grade',
		// 	'6' => 'Fines Medium Grade',
		// 	'7' => 'Fines Low Grade',
		// 	'8' => 'Fines Unclassified Grade'
		// );

		/**
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 17th Jan 2014 
		 * 
		 * ADDED AS THE WORK DONE FROM BANGALORE IN NOV 2013
		 * ADDED THE HARD CODED VALUES AND NOW USING THE MASTER TO GET THESE VALUES 
		 */
		$nmiGradesmeter = $this->DirGrid->getGridByIdKey();
		// NOT DELETED THE HARD-CODED ARRAY AS IF SOMETHING WENT WRONG WITH THIS FORM
		// THIS MIGHT BE HELP FULL TO CHECK IF IT'S THE PROBLEM OF DATA STRUCTURE -- DATED - 20th Aug 2013
		// $this->nmiGradesmeter = Array(
		// 	'1' => '> 200',
		// 	'2' => '200 x 200',
		// 	'3' => '100 x 100',
		// 	'4' => '50 x 50',
		// 	'5' => '25 x 25',
		// 	'6' => 'Not to Grid',
		// );

		$pdfLabel = $this->Language->pdfLabel($lang, $returnDate, $returnType, $formNoMain);

		$this->set('mineCode', $mineCode);
		$this->set('returnDate', $returnDate);
		$this->set('returnType', $returnType);
		$this->set('returnMonth', $returnMonth);
		$this->set('returnYear', $returnYear);
		$this->set('formNo', $formNo);
		$this->set('regionName', $regionName);
		$this->set('ipTimeFormat',$ipTimeFormat);
		$this->set('tableForm','');
		$this->set('finalSubmitDate', $finalSubmitDate);
		$this->set('fillerName', $fillerName);
		$this->set('fillerdesignation', $fillerdesignation);
		$this->set('mineral', $min_sp);
		$this->set('period', $period);
		$this->set('size_ranges', $size_ranges);
		$this->set('pdfLabel', $pdfLabel);

		// PART I
		// MINE DETAILS
		$label = array();
		$label['mine'] = $this->Language->getFormInputLabels('mine', $lang);
		$this->set('mine', $mine);
		
		// NAME AND ADDRESS
		$label['name_address'] = $this->Language->getFormInputLabels('name_address', $lang);
        $owner = $this->Mine->getMineOwnerDetails($mineCode,$returnDate); // Added $returnDate parameter on 20-06-2023 by Shweta Apale
		$this->set('owner', $owner);

        if ($returnType != 'ANNUAL') {
			// RENT DETAILS
			$label['rent'] = $this->Language->getFormInputLabels('rent', $lang);
			$rentDetail = $this->RentReturns->getRentReturnsDetails($mineCode, $returnType, $returnDate);
			$this->set('rentDetail', $rentDetail);
	
			// WORKING DETAILS
			$label['working_detail'] = $this->Language->getFormInputLabels('working_detail', $lang);
			$reasonsArr = $this->DirWorkStoppage->getReasonsArr();
			$workDetail = $this->WorkStoppage->fetchWorkingDetails($mineCode, $returnType, $returnDate);
			$this->set('reasonsArr',$reasonsArr);
			$this->set('workDetail',$workDetail);
	
			// AVERAGE DAILY EMPLOYMENT
			$label['daily_average'] = $this->Language->getFormInputLabels('daily_average', $lang);
			$openCastId = '5';
			$belowId = '1';
			$aboveId = '9';
			$openArr = $this->Employment->fetchEmpWageDetails($mineCode, $returnType, $returnDate, $openCastId);
			$belowArr = $this->Employment->fetchEmpWageDetails($mineCode, $returnType, $returnDate, $belowId);
			$aboveArr = $this->Employment->fetchEmpWageDetails($mineCode, $returnType, $returnDate, $aboveId);
			$this->set('openArr',$openArr);
			$this->set('belowArr',$belowArr);
			$this->set('aboveArr',$aboveArr);
        }

		// PART II
		$gradesArrayRom = array();
		$gradeWiseArrRom = array();
		$gradesArray = array();
		$gradeWiseArr = array();
		$pulverArr = array();
		$pulverGrade = array();
		$deductDetail = array();
		$saleDespatch = array();
		$saleDespatchGrade = array();
		$countryList = array();
		$reasonData = array();
		$oreType = null;
		$chemRep = null;
		$romDataOre = null;
		$exMine = null;
		$recovCon = null;
		$smeltReco = null;
		$salesMetalProduct = null;
		$romDataThree = null;
		$romDataThreeMinUnit = null;
		
		// ORE TYPE
		$label['ore_type'] = $this->Language->getFormInputLabels('ore_type', $lang);
		$oreType = $this->Prod1->getOreType($mineCode, $returnType, $returnDate);

		$mineralArr = $this->Session->read('mineralArr');
		foreach($mineralArr as $key=>$val){

			$is_hematite = $this->Session->read('is_hematite');
			$is_magnetite = $this->Session->read('is_magnetite');
			$mineral = strtolower($val);

			// PRODUCTION / STOCKS (ROM)
			$label['rom_stocks'] = $this->Language->getFormInputLabels('rom_stocks', $lang, $this->Session->read('mc_form_type'));
			if($mineral == 'iron ore'){

				if($is_hematite == true){
					$prodArr[$mineral]['hematite'] = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, str_replace(' ', '_', $mineral), 'hematite', '', $pdfStatus);
				}
				
				if($is_magnetite == true){
					$prodArr[$mineral]['magnetite'] = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, str_replace(' ', '_', $mineral), 'magnetite', '', $pdfStatus);
				}

				if($is_hematite == false && $is_magnetite == false){
					$prodArr[$mineral] = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '', '', $pdfStatus);
				}

			} else {
				$prodArr[$mineral] = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '', '', $pdfStatus);
			}

			// GRADE-WISE PRODUCTION
			$label['gradewise_prod'] = $this->Language->getFormInputLabels('gradewise_prod', $lang, $this->Session->read('mc_form_type'));
			$chemRep = $this->Clscommon->getChemRep($mineral);
			$mineralArr = $this->Session->read('mineralArr');
			$min_und_low = strtolower(str_replace(' ','_',$mineral));
			if (in_array($min_und_low, array('iron_ore', 'chromite'))) {
				
				if ($mineral == "iron ore") {
					if ($is_hematite == true) {
						$gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetailsRom($mineCode, $returnType, $returnDate, "iron ore", "hematite", $pdfStatus);
						$gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMinRom($mineral, $returnDate, $mineralArr[0]);
						if(empty($gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeValues'])){
							foreach($gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeNames'] as $gradeKey => $gradeVal){
								foreach($gradeVal as $subgradeKey => $subgradeVal){
									$gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeValues'][$subgradeKey] = ['id'=>'', 'opening_stock'=>(isset($prevClStock[$subgradeKey]['closing_stock'])) ? $prevClStock[$subgradeKey]['closing_stock'] : '', 'production'=>'', 'despatches'=>'', 'closing_stock'=>'', 'pmv'=>'', 'reason_1'=>null, 'reason_2'=>null, 'average_grade'=>null];
								}
							}
						}
					}
					if ($is_hematite == true && $is_magnetite == true) {
						$gradeWiseArrRom[$mineral][$key + 1]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetailsRom($mineCode, $returnType, $returnDate, "iron ore", "magnetite", $pdfStatus);
						$gradeWiseArrRom[$mineral][$key + 1]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMinRom($mineral, $returnDate, $mineralArr[0]);
						if(empty($gradeWiseArrRom[$mineral][$key + 1]['gradeProd']['gradeValues'])){
							foreach($gradeWiseArrRom[$mineral][$key + 1]['gradeProd']['gradeNames'] as $gradeKey => $gradeVal){
								foreach($gradeVal as $subgradeKey => $subgradeVal){
									$gradeWiseArrRom[$mineral][$key + 1]['gradeProd']['gradeValues'][$subgradeKey] = ['id'=>'', 'opening_stock'=>(isset($prevClStock[$subgradeKey]['closing_stock'])) ? $prevClStock[$subgradeKey]['closing_stock'] : '', 'production'=>'', 'despatches'=>'', 'closing_stock'=>'', 'pmv'=>'', 'reason_1'=>null, 'reason_2'=>null, 'average_grade'=>null];
								}
							}
						}
					} else if ($is_hematite == false && $is_magnetite == true) {
						$gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetailsRom($mineCode, $returnType, $returnDate, "iron ore", "magnetite", $pdfStatus);
						$gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMinRom($mineral, $returnDate, $mineralArr[0]);
						if(empty($gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeValues'])){
							foreach($gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeNames'] as $gradeKey => $gradeVal){
								foreach($gradeVal as $subgradeKey => $subgradeVal){
									$gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeValues'][$subgradeKey] = ['id'=>'', 'opening_stock'=>(isset($prevClStock[$subgradeKey]['closing_stock'])) ? $prevClStock[$subgradeKey]['closing_stock'] : '', 'production'=>'', 'despatches'=>'', 'closing_stock'=>'', 'pmv'=>'', 'reason_1'=>null, 'reason_2'=>null, 'average_grade'=>null];
								}
							}
						}
					}
					if($is_hematite == false && $is_magnetite == false){
						$gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMinRom($mineral, $returnDate, $mineralArr[0]);
						$gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetailsRom($mineCode, $returnType, $returnDate, $mineral, '', $pdfStatus);
						if(empty($gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeValues'])){
							foreach($gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeNames'] as $gradeKey => $gradeVal){
								foreach($gradeVal as $subgradeKey => $subgradeVal){
									$gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeValues'][$subgradeKey] = ['id'=>'', 'opening_stock'=>(isset($prevClStock[$subgradeKey]['closing_stock'])) ? $prevClStock[$subgradeKey]['closing_stock'] : '', 'production'=>'', 'despatches'=>'', 'closing_stock'=>'', 'pmv'=>'', 'reason_1'=>null, 'reason_2'=>null, 'average_grade'=>null];
								}
							}
						}
					}
				} else {
					$gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMinRom($mineral, $returnDate, $mineralArr[0]);
					$gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetailsRom($mineCode, $returnType, $returnDate, $mineral, '', $pdfStatus);
					if(empty($gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeValues'])){
						foreach($gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeNames'] as $gradeKey => $gradeVal){
							foreach($gradeVal as $subgradeKey => $subgradeVal){
								$gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeValues'][$subgradeKey] = ['id'=>'', 'opening_stock'=>(isset($prevClStock[$subgradeKey]['closing_stock'])) ? $prevClStock[$subgradeKey]['closing_stock'] : '', 'production'=>'', 'despatches'=>'', 'closing_stock'=>'', 'pmv'=>'', 'reason_1'=>null, 'reason_2'=>null, 'average_grade'=>null];
							}
						}
					}
				}
				
				foreach($gradeWiseArrRom[$mineral][$key]['gradeProd']['gradeNames'] as $gradeLblKey => $gradeLblVal){
					foreach($gradeLblVal as $grKey => $grVal){
						$gradesArrayRom[$mineral][$grKey] = $grVal;
					}
				}

			}


			if ($mineral == "iron ore") {
				if ($is_hematite == true) {
					$gradeWiseArr[$mineral][$key]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, "iron ore", "hematite", $pdfStatus);
					$gradeWiseArr[$mineral][$key]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMin($mineral, $returnDate, $mineralArr[0]);
					if(empty($gradeWiseArr[$mineral][$key]['gradeProd']['gradeValues'])){
						foreach($gradeWiseArr[$mineral][$key]['gradeProd']['gradeNames'] as $gradeKey => $gradeVal){
							foreach($gradeVal as $subgradeKey => $subgradeVal){
								$gradeWiseArr[$mineral][$key]['gradeProd']['gradeValues'][$subgradeKey] = ['id'=>'', 'opening_stock'=>(isset($prevClStock[$subgradeKey]['closing_stock'])) ? $prevClStock[$subgradeKey]['closing_stock'] : '', 'production'=>'', 'despatches'=>'', 'closing_stock'=>'', 'pmv'=>'', 'reason_1'=>null, 'reason_2'=>null, 'average_grade'=>null];
							}
						}
					}
				}
				if ($is_hematite == true && $is_magnetite == true) {
					$gradeWiseArr[$mineral][$key + 1]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, "iron ore", "magnetite", $pdfStatus);
					$gradeWiseArr[$mineral][$key + 1]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMin($mineral, $returnDate, $mineralArr[0]);
					if(empty($gradeWiseArr[$mineral][$key + 1]['gradeProd']['gradeValues'])){
						foreach($gradeWiseArr[$mineral][$key + 1]['gradeProd']['gradeNames'] as $gradeKey => $gradeVal){
							foreach($gradeVal as $subgradeKey => $subgradeVal){
								$gradeWiseArr[$mineral][$key + 1]['gradeProd']['gradeValues'][$subgradeKey] = ['id'=>'', 'opening_stock'=>(isset($prevClStock[$subgradeKey]['closing_stock'])) ? $prevClStock[$subgradeKey]['closing_stock'] : '', 'production'=>'', 'despatches'=>'', 'closing_stock'=>'', 'pmv'=>'', 'reason_1'=>null, 'reason_2'=>null, 'average_grade'=>null];
							}
						}
					}
				} else if ($is_hematite == false && $is_magnetite == true) {
					$gradeWiseArr[$mineral][$key]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, "iron ore", "magnetite", $pdfStatus);
					$gradeWiseArr[$mineral][$key]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMin($mineral, $returnDate, $mineralArr[0]);
					if(empty($gradeWiseArr[$mineral][$key]['gradeProd']['gradeValues'])){
						foreach($gradeWiseArr[$mineral][$key]['gradeProd']['gradeNames'] as $gradeKey => $gradeVal){
							foreach($gradeVal as $subgradeKey => $subgradeVal){
								$gradeWiseArr[$mineral][$key]['gradeProd']['gradeValues'][$subgradeKey] = ['id'=>'', 'opening_stock'=>(isset($prevClStock[$subgradeKey]['closing_stock'])) ? $prevClStock[$subgradeKey]['closing_stock'] : '', 'production'=>'', 'despatches'=>'', 'closing_stock'=>'', 'pmv'=>'', 'reason_1'=>null, 'reason_2'=>null, 'average_grade'=>null];
							}
						}
					}
				}
				if($is_hematite == false && $is_magnetite == false){
					$gradeWiseArr[$mineral][$key]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMin($mineral, $returnDate, $mineralArr[0]);
					$gradeWiseArr[$mineral][$key]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, $mineral, '', $pdfStatus);
					if(empty($gradeWiseArr[$mineral][$key]['gradeProd']['gradeValues'])){
						foreach($gradeWiseArr[$mineral][$key]['gradeProd']['gradeNames'] as $gradeKey => $gradeVal){
							foreach($gradeVal as $subgradeKey => $subgradeVal){
								$gradeWiseArr[$mineral][$key]['gradeProd']['gradeValues'][$subgradeKey] = ['id'=>'', 'opening_stock'=>(isset($prevClStock[$subgradeKey]['closing_stock'])) ? $prevClStock[$subgradeKey]['closing_stock'] : '', 'production'=>'', 'despatches'=>'', 'closing_stock'=>'', 'pmv'=>'', 'reason_1'=>null, 'reason_2'=>null, 'average_grade'=>null];
							}
						}
					}
				}
			} else {
				$gradeWiseArr[$mineral][$key]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMin($mineral, $returnDate, $mineralArr[0]);
				$gradeWiseArr[$mineral][$key]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, $mineral, '', $pdfStatus);
				if(empty($gradeWiseArr[$mineral][$key]['gradeProd']['gradeValues'])){
					foreach($gradeWiseArr[$mineral][$key]['gradeProd']['gradeNames'] as $gradeKey => $gradeVal){
						foreach($gradeVal as $subgradeKey => $subgradeVal){
							$gradeWiseArr[$mineral][$key]['gradeProd']['gradeValues'][$subgradeKey] = ['id'=>'', 'opening_stock'=>(isset($prevClStock[$subgradeKey]['closing_stock'])) ? $prevClStock[$subgradeKey]['closing_stock'] : '', 'production'=>'', 'despatches'=>'', 'closing_stock'=>'', 'pmv'=>'', 'reason_1'=>null, 'reason_2'=>null, 'average_grade'=>null];
						}
					}
				}
			}
			
			foreach($gradeWiseArr[$mineral][$key]['gradeProd']['gradeNames'] as $gradeLblKey => $gradeLblVal){
				foreach($gradeLblVal as $grKey => $grVal){
					$gradesArray[$mineral][$grKey] = $grVal;
				}
			}

			// PULVERISATION
			$label['pulverisation'] = $this->Language->getFormInputLabels('pulverisation', $lang);
			$pulverArr[$mineral] = $this->Pulverisation->getPulverData($mineCode, $returnType, $returnDate, $mineral, $pdfStatus);
			$pulverGrade[$mineral] = $this->Clscommon->getGradeArr(strtoupper(str_replace('_', ' ', $mineral)));

			// DEDUCTION DETAILS
			$label['deduct_detail'] = $this->Language->getFormInputLabels('deduct_detail', $lang, $this->Session->read('mc_form_type'));
			if($mineral == 'iron ore') {
				
                /**
                 * @author: uday shankar singh
                 * @date: 15th Jan 2013
                 * 
                 * REVERSED THE CONDITION AS DEDUCTION DETAILS ARE ALWAYS SAVED IN HEMATITE ROW  
                 */
                if ($is_magnetite == true && $is_hematite == true) {
                    $deductDetail[$mineral] = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, "iron_ore", 2, '', $pdfStatus);

                    $estimationDetails[1] = $this->MiningPlan->getEstimationDetailsForPrintAll($mineCode, $mineral, "MAGNETITE", $returnDate, $returnType);
                    $estimationDetails[1]['min'] = 'IRON ORE - MAGNETITE';
					
                    $deductDetail[$mineral] = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, "iron_ore", 1, '', $pdfStatus);
                    /**
                     * ADDED THE [0] in $estimation as THERE WAS SOME LOOPING PROBLEM 
                     * WHICH CAUSING THE PROBLEM WHILE DISPLAYING THE DATA
                     * LINE 277, 283 AND 289
                     * 
                     */
                    $estimationDetails[0] = $this->MiningPlan->getEstimationDetailsForPrintAll($mineCode, $mineral, "HEMATITE", $returnDate, $returnType);
                    $estimationDetails[0]['min'] = 'IRON ORE - HEMATITE';
                } else if ($is_hematite == true) {
                    $deductDetail[$mineral] = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, "iron_ore", 1, '', $pdfStatus);
                    /**
                     * ADDED THE [0] in $estimation as THERE WAS SOME LOOPING PROBLEM 
                     * WHICH CAUSING THE PROBLEM WHILE DISPLAYING THE DATA
                     * LINE 277, 283 AND 289
                     * 
                     */
                    $estimationDetails[0] = $this->MiningPlan->getEstimationDetailsForPrintAll($mineCode, $mineral, "HEMATITE", $returnDate, $returnType);
                    $estimationDetails[0]['min'] = 'IRON ORE - HEMATITE';
                } else if ($is_magnetite == true) {
                    $deductDetail[$mineral] = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, "iron_ore", 2, '', $pdfStatus);
                    /**
                     * ADDED THE [0] in $estimation as THERE WAS SOME LOOPING PROBLEM 
                     * WHICH CAUSING THE PROBLEM WHILE DISPLAYING THE DATA
                     * LINE 277, 283 AND 289
                     * 
                     */
                    $estimationDetails[0] = $this->MiningPlan->getEstimationDetailsForPrintAll($mineCode, $mineral, "MAGNETITE", $returnDate, $returnType);
                    $estimationDetails[0]['min'] = 'IRON ORE - MAGNETITE';
                }
				if($is_hematite == false && $is_magnetite == false){
					$deductDetail[$mineral] = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '', '', $pdfStatus);
					$estimationDetails[] = $this->MiningPlan->getEstimationDetails($mineCode, $mineral, '', '', $returnDate, $returnType);
				}

			} else {
                // $deductDetail[$mineral] = $this->Prod1->getDeductionDetails($mineCode, $returnType, $returnDate, $mineral);
		        $deductDetail[$mineral] = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '', '', $pdfStatus);

				// $estimationDetails[] = MINING_PLANTable::getEstimationDetails($this->mineCode, $mineral_names[$i], $is_hematite, $is_magnetite, $this->returnDate, $this->returnType);
                /**
                 * @author Uday Shankar Singh
                 * @version 30th May 2014
                 * 
                 * COMMENTED THE BELOW LINE AND ADDED THE LINE AFTER THAT AS
                 * THIS IS FOR THE PRODUCTION PROPOSAL AND EARLIER PRODUCTION PROPOSAL 
                 * FOR ONLY ONE MINERAL COMING IN THE PRINT ALL AND PDF, SO 
                 * NOW CREATING THE ARRAY AS ARRAY IS BEING PRINTED IN THE PRINT ALL 
                 * AND PDF ALREADY
                 *  
                 */
				// $estimationDetails[0] = MINING_PLANTable::getEstimationDetails($this->mineCode, $mineral_names[$i], '', '', $this->returnDate, $this->returnType);
                $estimationDetails[] = $this->MiningPlan->getEstimationDetails($mineCode, $mineral, '', '', $returnDate, $returnType);
            }
			// Added by Naveen Jha on 29/06/208 as Mining Plan details of only one mineral were getting saved as the array assignment was outside the loop
			// estimation_1 is a new temporary array in which details of all the minerals will be added. The same is being set to Success on line no. 366
			// $estimation_1 = array();
			// if($estimationDetails[0]['est'] > 0){
			// 	$estimation_1[] = $estimationDetails;
			// }

			// SALES/DISPATCHES
			$label['sale_despatch'] = $this->Language->getFormInputLabels('sale_despatch', $lang, $this->Session->read('mc_form_type'));
			$saleDespatch[$mineral] = $this->GradeSale->fetchSalesData($mineCode, $returnType, $returnDate, $mineral, $pdfStatus);
			$saleDespatchGrade[$mineral] = $this->Clscommon->getGradeArr(strtoupper(str_replace('_', ' ', $mineral)), $returnDate);
			$unit[$mineral] = $this->DirMcpMineral->getMineralUnit(strtoupper(str_replace('_', ' ', $mineral)));
			$countryList[$mineral] = $this->DirCountry->getCountryList();
			$reasonData[$mineral] = $this->IncrDecrReasons->getAllData($mineCode, $returnType, $returnDate, $mineral);

			// FORM F2
			// PRODUCTION / STOCKS (ROM)
			$label['rom_stocks_ore'] = $this->Language->getFormInputLabels('rom_stocks_ore', $lang);
			$romDataOre[$mineral] = $this->Rom5->getRomData($mineCode, $returnDate, $returnType, $mineral, $pdfStatus);

			// EX-MINE PRICE
			$label['ex_mine'] = $this->Language->getFormInputLabels('ex_mine', $lang);
			$exMine[$mineral] = $this->Prod5->getExMineProd5($mineCode, $returnType, $returnDate, $mineral, $pdfStatus);

			// RECOVERIES AT CONCENTRATOR
			$label['con_reco'] = $this->Language->getFormInputLabels('con_reco', $lang);
			$recovCon[$mineral] = $this->RomMetal5->getConRomData($mineCode, $returnDate, $returnType, $mineral, $pdfStatus);

			// RECOVERY AT THE SMELTER
			$label['smelt_reco'] = $this->Language->getFormInputLabels('smelt_reco', $lang);
			$smeltReco[$mineral] = $this->RecovSmelter->getRecoveryData($mineCode, $returnDate, $returnType, $mineral, $pdfStatus);

            // SALES(METALS/BY PRODUCT)
            $label['sales_metal_product'] = $this->Language->getFormInputLabels('sales_metal_product', $lang);
            $salesMetalProduct[$mineral] = $this->Sale5->getSalesData($mineCode, $returnDate, $returnType, $mineral, $pdfStatus);

			// FORM F3
			// PRODUCTION / STOCKS (ROM)
			$label['rom_stocks_three'] = $this->Language->getFormInputLabels('rom_stocks_three', $lang);
			$romDataThreeMinUnit[$mineral] = $this->DirMcpMineral->getMineralUnit($mineral);
			$romDataThree[$mineral] = $this->RomStone->getRomData($mineCode, $returnType, $returnDate, $mineral, $pdfStatus);

			// PRODUCTION, STOCKS AND DESPATCHES
			$label['prod_stock_dis'] = $this->Language->getFormInputLabels('prod_stock_dis', $lang);
			$roughStoneData[$mineral] = $this->ProdStone->getProdStoneData($mineCode, $returnDate, $mineral, 1, $returnType, $pdfStatus);
			$cutStoneData[$mineral] = $this->ProdStone->getProdStoneData($mineCode, $returnDate, $mineral, 2, $returnType, $pdfStatus);
			$indStoneData[$mineral] = $this->ProdStone->getProdStoneData($mineCode, $returnDate, $mineral, 3, $returnType, $pdfStatus);
			$othStoneData[$mineral] = $this->ProdStone->getProdStoneData($mineCode, $returnDate, $mineral, 99, $returnType, $pdfStatus);

		}

		/** ********************* ANNUAL RETURNS ************************ */
		if ($returnType == 'ANNUAL') {

			//particulars
			/**
			* COMMENTED THE FOLLOWING ONE LINE AND ADDED THE LINE AFTER THAT FOR PASSING THE CURRENT YEAR WHOSE RETURN IS BEING VISITED
			* @auhor uday Shankar singh <udayshankar1306@gmail.com, usingh@ubicsindia.com>
			* @version 7th Oct 2014
			*/
			//$particularsDetails = MCP_LEASETable::getParticularsDetails($this->mineCode);
			// $particularsDetails = $this->McpLease->getParticularsDetails($mineCode, $returnYear);
			// $particulars = $particularsDetails;
			// //$this->leaseDetails = $particularsDetails['lease_details'];
			// $totalParticulars = count($particularsDetails);
			// G: PART I: PARTICULARS
			$label['particulars'] = $this->Language->getFormInputLabels('particulars', $lang);
			$particulars = $this->McpLease->getParticularsDetails($mineCode, $returnYear);
			$this->set('particulars', $particulars);


			//area of utilisation
			// $utilisation = $this->LeaseReturn->getLeaseDetails($mineCode, $returnDate);
			// G: PART I: AREA OF UTILISATION
			$label['area_utilisation'] = $this->Language->getFormInputLabels('area_utilisation', $lang);
			$lease = $this->LeaseReturn->getLeaseData($mineCode, $returnDate);
			$agency_choices = $this->Clscommon->leaseAreaAgencyOptions($lang);
			$this->set('lease', $lease);
			$this->set('agency_choices', $agency_choices);


			//employment wages
			// $empWages = $this->RentReturns->getAllData($mineCode, $returnType, $returnDate, 1);
			// $workStoppageReasons = $this->Clscommon->getReasonsArr();
			// $returnDetails = $empWages['returnDetails'];
			// $workStoppageDetails = $empWages['workStoppageDetails'];
			// $empWages = $empWages['empDetails'];
			// G: PART II: EMPLOYMENT & WAGES (I)
			$label['employment_wages'] = $this->Language->getFormInputLabels('employment_wages', $lang);
			$reasonsArr = $this->DirWorkStoppage->getReasonsArr();
			$reasonsLen = count($reasonsArr);
			$empWages = $this->RentReturns->getAllData($mineCode, $returnType, $returnDate, 1);
			$workData = $this->WorkStoppage->fetchWorkingDetails($mineCode, $returnType, $returnDate, $pdfStatus);
			$this->set('empWages', $empWages);
			$this->set('workData', $workData);
			$this->set('reasonsLen', $reasonsLen);
			$this->set('reasonsArr', $reasonsArr);


			//employment wages part II
			// $empWagesPart2 = $this->Employment->getEmploymentWagesPart2Details($mineCode, $returnDate, 5);
			// $returnDetailspart2 = $empWagesPart2['returnDetails'];
			// $empWagesPart2 = $empWagesPart2['empDetails'];
			// G: PART II: EMPLOYMENT & WAGES (II)
			$label['employment_wages_part'] = $this->Language->getFormInputLabels('employment_wages_part', $lang);
			$empData = $this->Employment->getEmploymentWagesPart2Details($mineCode, $returnDate, 5, $pdfStatus);
			$this->set('empData', $empData);


			//capital structure
			// $capitalData = $this->CapitalStructure->getAllData($mineCode, $returnDate);
			// $fixedResult = $capitalData['fixed_result'];
			// $tableData = $capitalData['common_result'];
			// $dynamicData = $capitalData['dynamic_result'];
			// $capMineCodes = $capitalData['fixed_result']['selected_mine_code'];
			// G: PART II: CAPITAL STRUCTURE
			$label['capital_structure'] = $this->Language->getFormInputLabels('capital_structure', $lang);
			$csData = $this->CapitalStructure->getAllData($mineCode, $returnDate);
			$this->set('csData', $csData);


			//material consumption quantity
			// $matConsQuant = $this->MaterialConsumption->getMatConsDetails($mineCode, $returnDate);
			// G: PART III: MATERIAL CONSUMPTION QUANTITY
			$label['material_consumption_quantity'] = $this->Language->getFormInputLabels('material_consumption_quantity', $lang);
			$matConsData = $this->MaterialConsumption->getMatConsDetails($mineCode, $returnDate);
			$this->set('matConsData', $matConsData);

			//material consumption royalty
			// $matConsRoyalty = $this->RentReturns->getMatConsRoyaltyDetails($mineCode, $returnDate, 2);
			// G: PART III: MATERIAL CONSUMPTION ROYALTY
			$label['material_consumption_royalty'] = $this->Language->getFormInputLabels('material_consumption_royalty', $lang);
			$matConsRoyData = $this->RentReturns->getMatConsRoyaltyDetails($mineCode, $returnDate, 2, $pdfStatus);
			$this->set('matConsRoyData', $matConsRoyData);

			//material consumption tax
			// $matConsTax = $this->RentReturns->getMatConsTaxDetails($mineCode, $returnDate, 3);
			// G: PART III: MATERIAL CONSUMPTION TAX
			$label['material_consumption_tax'] = $this->Language->getFormInputLabels('material_consumption_tax', $lang);
			$matConsTaxData = $this->RentReturns->getMatConsTaxDetails($mineCode, $returnDate, 3);
			$this->set('matConsTaxData', $matConsTaxData);

			//explosive consumption
			// $expConReturn = $this->ExplosiveConsumption->getExplosiveReturnRecords($mineCode, $returnDate, 'ANNUAL');
			// $expCon = $this->ExplosiveConsumption->getExplosiveConDetails($mineCode, $returnDate);
			// G: PART IV: EXPLOSIVE CONSUMPTION
			$label['explosive_consumption'] = $this->Language->getFormInputLabels('explosive_consumption', $lang);
			$explosiveReturnData = $this->ExplosiveConsumption->getExplosiveReturnRecords($mineCode, $returnDate, $returnType);
			$explosiveConsumptData = $this->ExplosiveConsumption->getExplosiveConDetails($mineCode, $returnDate);
			$this->set('explReturn', $explosiveReturnData);
			$this->set('explConsum', $explosiveConsumptData);

			// G: PART V: SEC 1: EXPLORATION
			$label['geology_exploration'] = $this->Language->getFormInputLabels('geology_exploration', $lang);
			$geoExp = $this->ExplorationDetails->getAllData($mineCode, $returnType, $returnDate);
			$this->set('geoExp', $geoExp);

			//sec 1/2 copper ore
			// foreach ($mineralProduced as $mineralData) {
			// 	// $this->geologyPart1 = TBL_MIN_WORKEDTable::getFormData($this->mineCode, $this->returnDate, $this->mineral);
			// 	$geoPart1Data[$mineralData] = $this->TblMinWorked->getFormData($mineCode, $returnDate, $mineralData);
			// }
			// $geologyPart1 = $geoPart1Data;

			// G: PART V: SEC 2/3: GEOLOGY EXPLORATION SUBGRADE
			$label['geology_reserves_subgrade'] = $this->Language->getFormInputLabels('geology_reserves_subgrade', $lang);
			
			// foreach ($mineralProduced as $mineralData) {
			foreach($mineralArr as $mineralData){
				$min_un = strtolower(str_replace(' ', '_', $mineralData));
				$reservesFormData[$min_un] = $this->ReservesResources->getAllData($mineCode, $returnType, $returnDate, $min_un);
				$subgradeFormData[$min_un] = $this->SubgradeMineralReject->getAllData($mineCode, $returnType, $returnDate, $min_un);
			}
			$this->set('reserves', $reservesFormData);
			$this->set('subgrade', $subgradeFormData);

			// G: PART V: SEC 4/5: GEOLOGY OVERBURDEN TREES
			$label['geology_overburden_trees'] = $this->Language->getFormInputLabels('geology_overburden_trees', $lang);
			$treesFormData = $this->TreesPlantSurvival->getAllData($mineCode, $returnType, $returnDate);
			$overburdenFormData = $this->OverburdenWaste->getAllData($mineCode, $returnType, $returnDate);
			$this->set('treesPlant', $treesFormData);
			$this->set('overburden', $overburdenFormData);

			// G: PART V: SEC 6: TYPE OF MACHINERY
			$label['geology_part_three'] = $this->Language->getFormInputLabels('geology_part_three', $lang);
			$formType12 = $this->Session->read('mc_form_type');
			$machineryTypeArr = $this->DirMachinery->machineryTypeArr();
			$machineryData = $this->Machinery->getAllData($mineCode, $returnType, $returnDate, $formType12, 1);
			$this->set('machinery', $machineryData);
			$this->set('machineryTypeArr', $machineryTypeArr);

			// G: PART V: SEC 7. MINERAL TREATMENT PLANT
			$label['geology_part_six'] = $this->Language->getFormInputLabels('geology_part_six', $lang);
			// foreach ($mineralProduced as $mineralData) {
			foreach($mineralArr as $mineralData){
				$min_un = strtolower(str_replace(' ', '_', $mineralData));
				$minTreatPlant[$min_un] = $this->Machinery->getAllPart6Data($mineCode, $returnType, $returnDate, $min_un, 2);
			}
			$this->set('minTreatPlant', $minTreatPlant);

			//production cost
			// $costId = $this->CostProduction->getCostId($mineCode, 'ANNUAL', $returnDate);
			// $productionCost = $this->CostProduction->getAllData($costId);
			// G: PART VII: COST OF PRODUCTION
			$label['production_cost'] = $this->Language->getFormInputLabels('production_cost', $lang);
			$costData = $this->CostProduction->getData($mineCode, $returnType, $returnDate);
			$this->set('costData', $costData);

		}

		$estimation = $estimationDetails;
		
		$this->set('prodArr',$prodArr);
		$this->set('gradesArr',$gradesArray);
		$this->set('gradeWiseProd',$gradeWiseArr);
		$this->set('gradesArrRom',$gradesArrayRom);
		$this->set('gradeWiseProdRom',$gradeWiseArrRom);
		$this->set('chemRep',$chemRep);
		$this->set('pulverArr',$pulverArr);
		$this->set('pulverGrade',$pulverGrade);
		$this->set('deductDetail',$deductDetail);
		$this->set('estimation',$estimation);
		$this->set('saleDespatch',$saleDespatch);
		$this->set('saleDespatchGrade',$saleDespatchGrade);
		$this->set('unit',$unit);
		$this->set('countryList',$countryList);
		$this->set('reasonData',$reasonData);
		$this->set('oreType',$oreType);
		$this->set('romDataOre',$romDataOre);
		$this->set('exMine',$exMine);
		$this->set('recovCon',$recovCon);
		$this->set('smeltReco',$smeltReco);
		$this->set('salesMetalProduct',$salesMetalProduct);
		$this->set('romDataThree',$romDataThree);
		$this->set('romDataThreeMinUnit',$romDataThreeMinUnit);
		$this->set('roughStone',$roughStoneData);
		$this->set('cutStone',$cutStoneData);
		$this->set('indStone',$indStoneData);
		$this->set('othStone',$othStoneData);

		$this->set('label', $label);
		
		$esign_status = null;
		if ($this->request->is('post')) {

			$action = $this->request->getData('action');
			if ($action == 'esign') {
				$esign_status = 1;
				$this->Session->write('pdf_status', true);
			}

		}
		
		$loginUserType = $this->Session->read('loginusertype');
		$returnPdfStatus = $this->TblFinalSubmit->getPdfStatus($mineCode, $returnDate, $returnType);
		$returnPdfStatus = ($returnPdfStatus == 'draft' && $esign_status == 1) ? 'submit' : $returnPdfStatus; // set return status as 'submit' on the time of first e-signing
		$returnPdfStatus = ($loginUserType == 'mmsuser' && $returnPdfStatus == 'submit' && $esign_status == 1) ? 'approve' : $returnPdfStatus; // set return status as 'approve' on the time of supervisor approval
		$this->Session->write('pdfBgText', $returnPdfStatus);

		//call custom function from appcontroller to create pdf
		// if($mineCode != '38RAJ13008'){
			$this->generateReturnsPdf('/Returnspdf/minerPrintPdf', $esign_status);
		// }

	}

	
	// Generate F and G returns Pdf (OLD RETURNS)
    public function minerPrintPdfOld(){

		$this->viewBuilder()->setLayout('print_panel_old');

		// COMMON DATA
		$pdfStatus = 1;
        //=================GETTING CLIENT IP ADDRESS AND MAKING TIMESTAMP===========
        $ipAddress = $this->Clscommon->getIpAddresses();
        $timeStamp = date('Y-m-d H:i:s');
        $ipTimeFormat = "From: " . $ipAddress . " at " . $timeStamp;

		$mineCode = $this->Session->read('mc_mine_code');
        $returnDate = $this->Session->read('returnDate');
        $returnType = $this->Session->read('returnType');
		$lang = 'english';
		// $this->Customfunctions->executeUserleftnav($mineCode);

		$oldreturns = null;
		if (null != $this->Session->read('oldreturns')) {
			$oldreturns = $this->Session->read('oldreturns');
		}

        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
		}
		
        $mineral = $this->Session->read('mc_mineral');
        if ($mineral == null) {
            $mineral = $this->MineralWorked->getMineralName($mineCode);
			$this->Session->write('mineral', $mineral);
        }

        $mineral = strtolower(str_replace(' ', '_', $mineral));

        $grade = $this->Clscommon->getGradeArr(strtoupper(str_replace('_', ' ', $mineral)), $returnDate);
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("F", mktime(0, 0, 0, $temp[1], 1, $temp[0]));

        $period = $returnYear . " - " . ($temp[0] + 1);

        $is_final_submitted = $this->TblFinalSubmit->checkIsSubmitted($mineCode, $returnDate, $returnType);
		$finalSubmitDate = null;

        if ($is_final_submitted == true) {
            $finalSubmitDate = $this->TblFinalSubmit->getDateForPrintAndPdf($mineCode, $returnDate, $returnType);
			$finalSubmitDate = date('d-m-Y', strtotime($finalSubmitDate));
            $img_name = "final-submited.jpg";
        } else {
            $img_name = "draft.jpg";
        }

        $this->Session->write('bg_image', $img_name);
		$bg_img = $img_name;
		
		$returnPdfStatus = $this->TblFinalSubmit->getPdfStatus($mineCode, $returnDate, $returnType);
		$this->Session->write('pdfBgText', $returnPdfStatus);

		// pravin bhakare 01-07-2021
		$size_ranges = $this->DirSizeRange->getSizeRange();
		
		// $this->getUser()->setAtrribute('bg_image', $this->img_name);
		//to create url for Back button
        if (null !== $this->Session->read('mms_user_id')){
            $is_mms_user = true;
		}

		// $mineralProduced = $this->Session->read('mineralArr');
		$minArray = $this->MineralWorked->getMineralName($mineCode);
		$mineralProduced[] = $minArray;
		
		// NOW ASSIGNING THE ALL USER MINERALS TO MINERAL PRODUCED ARRAY, DONE BY PRAVIN BHAKARE, 01-07-2019
		//$this->mineralProduced []= $this->getRequestParameter('min');
		
        //=========================NAME AND DESIGNATION=============================
		//    $this->fillerName = $this->getUser()->getAttribute('mcu_first');
		//    $this->fillerdesignation = $this->getUser()->getAttribute('mcu_design');

        $mc_data = $this->McUser->getMCNameDesi($mineCode);

        $fillerName = $mc_data['Name'];
        $fillerdesignation = $mc_data['desi'];

        //=======================================================================

        /**
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 17th Jan 2014 
		 * 
		 * ADDED AS THE WORK DONE FROM BANGALORE IN NOV 2013
		 * ADDED THE HARD CODED VALUES AND NOW USING THE MASTER TO GET THESE VALUES 
		 */

		// $nmiGrades = DIR_NMI_GRADETable::getNmiGrades();
        $nmiGrades = $this->DirNmiGrade->getNmiGrades();
		// NOT DELETED THE HARD-CODED ARRAY AS IF SOMETHING WENT WRONG WITH THIS FORM
		// THIS MIGHT BE HELP FULL TO CHECK IF IT'S THE PROBLEM OF DATA STRUCTURE -- DATED - 20th Aug 2013
		// $this->nmiGrades = Array(
		// 	'1' => 'Lump High Grade',
		// 	'2' => 'Lump Medium Grade',
		// 	'3' => 'Lump Low Grade',
		// 	'4' => 'Lump Unclassified Grade',
		// 	'5' => 'Fines High Grade',
		// 	'6' => 'Fines Medium Grade',
		// 	'7' => 'Fines Low Grade',
		// 	'8' => 'Fines Unclassified Grade'
		// );

        /**
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 17th Jan 2014 
		 * 
		 * ADDED AS THE WORK DONE FROM BANGALORE IN NOV 2013
		 * ADDED THE HARD CODED VALUES AND NOW USING THE MASTER TO GET THESE VALUES 
		 */
        $nmiGradesmeter = $this->DirGrid->getGridByIdKey();
		// NOT DELETED THE HARD-CODED ARRAY AS IF SOMETHING WENT WRONG WITH THIS FORM
		// THIS MIGHT BE HELP FULL TO CHECK IF IT'S THE PROBLEM OF DATA STRUCTURE -- DATED - 20th Aug 2013
		// $this->nmiGradesmeter = Array(
		// 	'1' => '> 200',
		// 	'2' => '200 x 200',
		// 	'3' => '100 x 100',
		// 	'4' => '50 x 50',
		// 	'5' => '25 x 25',
		// 	'6' => 'Not to Grid',
		// );

		
        $oreType = $this->Prod1->getOreType($mineCode, $returnType, $returnDate);

        $mineral_names = $this->Clscommon->getMineralNames($mineCode);
        //fetches the mine details 
        $mine = $this->Mine->getMineDetails($mineCode, $returnType, $returnDate);
        //=====ADDED BY UDAY FOR GETTING THE REGION NAME BASED ON THE DISTRICT NAME=====
        $districtName = $mine['district'];
        $regionName = $this->DirDistrict->getRegionNameByDistrictName($districtName);
        //==========================================================================
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);

        if ($returnType == 'ANNUAL'){
            $formName = 'H-' . $formNumber;
		}
        else {
            $formName = 'F-' . $formNumber;
		}
        
        // Below Function call for the label array updated by ganesh satavdated on the 14 feb 2014
		$FormLabelNameWithFormNo = $this->Clscommon->getFormLabelNameWithFormNo($formNumber,$returnType);      
     	// echo "<pre>"; print_r($this->FormLabelNameWithFormNo); exit;
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        //fetches the address details
        $owner = $this->Mine->getMineOwnerDetails($mineCode);

		$this->set('period', $period);

        if ($returnType != 'ANNUAL') {
            //fetches the rent details
            // $rent = $this->Returns->getRentReturnDetails($mineCode, $returnType, $returnDate);
            $rent = $this->RentReturns->getRentReturnsDetails($mineCode, $returnType, $returnDate);

            $pastSurfaceRent = (isset($rent['past_surface_rent'])) ? $rent['past_surface_rent'] : null;
            $pastRoyaltyRent = (isset($rent['past_royalty'])) ? $rent['past_royalty'] : null;
            $pastDeadRent = (isset($rent['past_dead_rent'])) ? $rent['past_dead_rent'] : null;

            //fetches the working details
            $working_details = $this->WorkStoppage->getWorkingDetails($mineCode, $returnType, $returnDate);

            $total_days = $working_details['total_days'];
            $reason = $working_details['reason'];
            $no_of_days = $working_details['no_of_days'];

            //fetches the average daily details
            $daily_avg = $this->Employment->getDailyAverage($mineCode, $returnType, $returnDate);

            $open = $daily_avg['opencast'];
            $below = $daily_avg['below'];
            $above = $daily_avg['above'];
            $total = $daily_avg['total'];

			$this->set('pastSurfaceRent', $pastSurfaceRent);
			$this->set('pastRoyaltyRent', $pastRoyaltyRent);
			$this->set('pastDeadRent', $pastDeadRent);
			$this->set('total_days', $total_days);
			$this->set('reason', $reason);
			$this->set('no_of_days', $no_of_days);

			$this->set('open', $open);
			$this->set('below', $below);
			$this->set('above', $above);
			$this->set('total', $total);
        }

        $mineral_names = $this->Clscommon->getMineralNames($mineCode);

        //GLOBAL LOOP
        for ($i = 0; $i < count($mineral_names); $i++) {

            //GENERIC DETAILS
            $data[$i]['mineral'] = $mineral_names[$i];
            $data[$i]['formType'] = $this->DirMcpMineral->getFormNumber($mineral_names[$i]);

            if ($data[$i]['formType'] == 5) {

                // ROM
                $data[$i]['romF5'] = $this->Rom5->getRomPrintData($mineCode, $returnDate, $returnType, $mineral_names[$i]);

                //EX-MINE
                $data[$i]['exmineF5'] = $this->Prod5->getExMinePrintDetails($mineCode, $returnDate, $returnType, $mineral_names[$i]);

                //CON RECO
                $data[$i]['conRecoF5'] = $this->RomMetal5->getConPrintDetails($mineCode, $returnDate, $returnType, $mineral_names[$i]);

                //SMELTER
                $data[$i]['smelterF5'] = $this->RecovSmelter->getRecoveryData($mineCode, $returnDate, $returnType, $mineral_names[$i]);

                //SALES METALS
                $data[$i]['salesMetals'] = $this->Sale5->getSalesPrintData($mineCode, $returnDate, $returnType, $mineral_names[$i]);
            } else if ($data[$i]['formType'] == 6) {
                // FORM F-6 PRODUCTION, DESPATCHES AND STOCKS 
                $data[$i]['prodistocksF6'] = $this->ProdMica->getAllProdMicaDetails($mineCode, $returnType, $returnDate);
            } else if ($data[$i]['formType'] == 7) {

                $min = strtoupper($mineral);
                $minUnit = $this->DirMcpMineral->getMineralUnit($min);
                // FORM F-7 ROM 
                $data[$i]['romStone'] = $this->RomStone->getRomStoneDetails($mineCode, $returnDate, $returnType, $mineral_names[$i]);

                /* AS UNITS ARE NOT COMING FOR DB, MANUALLY ASSIGNING RESPECTIVE STRING VALUES TO UNIT ELEMENTS 
                 *  FOR PRINTING PURPOSE ONLY
                 */
                if ($data[$i]['romStone']['OC_TYPE'] == "1")
                    $data[$i]['romStone']['OC_TYPE'] = "Carat";
                else if ($data[$i]['romStone']['OC_TYPE'] == "2")
                    $data[$i]['romStone']['OC_TYPE'] = "Kilogram";


                if ($data[$i]['romStone']['UG_TYPE'] == "1")
                    $data[$i]['romStone']['UG_TYPE'] = "Carat";
                else if ($data[$i]['romStone']['UG_TYPE'] == "2")
                    $data[$i]['romStone']['UG_TYPE'] = "Kilogram";


                // FORM F-7 PRODUCTION, DESPATCHES AND STOCKS 
                $data[$i]['prodistocksF7'] = $this->ProdStone->getProdStoneDetails($mineCode, $returnType, $returnDate, $mineral_names[$i]);

				$this->set('minUnit', $minUnit);

            } else {
                $checkFormType = $data[$i]['formType']; //$checkFormType
                // FORM F-1 TO F-4 AND FORM F-8

                if ($mineral_names[$i] == "iron_ore") {
                    $is_hematite = $this->Prod1->fetchIronTypeProduction($mineCode, $returnType, $returnDate, 'iron_ore', 'hematite');
                    $is_magnetite = $this->Prod1->fetchIronTypeProduction($mineCode, $returnType, $returnDate, 'iron_ore', 'magnetite');

                    if ($is_hematite == true) {
                        $data[$i]['sub_min'] = "hematite";
                        $data[$i]['rom_prod'] = $this->Prod1->printRomDetails($mineCode, $returnType, $returnDate, $mineral_names[$i], 1);
                    }

                    if ($is_hematite == true && $is_magnetite == true) {
                        $data[$i + 1]['rom_prod'] = $this->Prod1->printRomDetails($mineCode, $returnType, $returnDate, $mineral_names[$i], 2);
                        $data[$i + 1]['mineral'] = $mineral_names[$i];
                        $data[$i + 1]['sub_min'] = "magnetite";

						// Set 'formType' for 'magnetite' to handle warning 'Undefined array key "formType"' in magnetite loop
						// Added on 13th Nov 2021 by Aniket Ganvir
						$data[$i + 1]['formType'] = $data[$i]['formType'];

                    } else if ($is_hematite == false && $is_magnetite == true) {
                        $data[$i]['sub_min'] = "magnetite";
                        /**
                         * @author uday shankar singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
                         * CHANGES ARE MADE DATED: 14th Jan 2014
                         * 
                         * REMOVED THE ['magnetite'] array and now whole 
                         */
						// $data[$i]['rom_prod']['magnetite'] = PROD_1Table::printRomDetails($this->mineCode, $this->returnType, $this->returnDate, $mineral_names[$i], 2);
                        $data[$i]['rom_prod'] = $this->Prod1->printRomDetails($mineCode, $returnType, $returnDate, $mineral_names[$i], 2);
                    }
                } else {
                    $data[$i]['rom_prod'] = $this->Prod1->printRomDetails($mineCode, $returnType, $returnDate, $mineral_names[$i]);
                }

                $min_name = strtoupper(str_replace('_', ' ', $mineral_names[$i]));

                //GRADE WISE
                $data[$i]['formNo'] = $this->DirMcpMineral->getFormNumber($mineral_names[$i]);
                if ($mineral_names[$i] == "iron_ore") {
                    if ($is_hematite == true) {
                        $data[$i]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, "iron_ore", "hematite", $pdfStatus);
                        $data[$i]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMin($min_name);
                    }
                    if ($is_hematite == true && $is_magnetite == true) {
                        $data[$i + 1]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, "iron_ore", "magnetite", $pdfStatus);
                        $data[$i + 1]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMin($min_name);

						// Set below 'formNo' variable for magentite iron ore to
						// handle warning "Undefined array key 'formNo'"
						// Added on 13th Nov 2021 by Aniket Ganvir
						$data[$i + 1]['formNo'] = $data[$i]['formNo'];

                    } else if ($is_hematite == false && $is_magnetite == true) {
                        $data[$i]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, "iron_ore", "magnetite", $pdfStatus);
                        $data[$i]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMin($min_name);
                    }
                } else {
                    $data[$i]['gradeProd']['gradeNames'] = $this->DirMineralGrade->getGradsArrByMin($min_name);
                    $data[$i]['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, $mineral_names[$i], '', $pdfStatus);
                }

                if ($data[$i]['formType'] == 8) {
                    // FORM F-8 ONLY FOR PULVERISATION
                    $isPulverised = $this->Pulverisation->isPulverised($mineCode, $returnType, $returnDate, $mineral_names[$i]);
                  	// print_r('Out');
					if ($isPulverised == true) {
						
                        $data[$i]['pulverisation'] = $this->Pulverisation->getPulvRecords($mineCode, $returnType, $returnDate, $mineral_names[$i]);
						// print_r($data[$i]['pulverisation']); exit();
                    }
                }
            }

            // FOLLOWING CODE IS COMMON FOR ALL FORMS FOR DEDUCTION DETAILS AND SALES & DESPATCHES 
            $data[$i]['chemRep'] = $this->Clscommon->getChemRep($mineral_names[$i]);

            //DEDUCTION DETAILS
			$estimation_1 = array();
            if ($mineral_names[$i] == 'iron_ore') {
                
                /**
                 * @author: uday shankar singh
                 * @date: 15th Jan 2013
                 * 
                 * 
                 * REVERSED THE CONDITION AS DEDUCTION DETAILS ARE ALWAYS SAVED IN HEMATITE ROW  
                 */
                if ($is_magnetite == true) {
                    $data[$i]['deduction'] = $this->Prod1->getDeductionDetails($mineCode, $returnType, $returnDate, "iron_ore", 2);

                    $estimationDetails[1] = $this->MiningPlan->getEstimationDetailsForPrintAll($mineCode, $mineral_names[$i], "MAGNETITE", $returnDate, $returnType);
                    $estimationDetails[1]['min'] = 'IRON ORE - MAGNETITE';

					// Set below variable for magnetite iron ore to handle warning "Undefined array key 'chemRep'"
					// Added on 13th Nov 2021 by Aniket Ganvir
					$data[$i + 1]['chemRep'] = $data[$i]['chemRep'];
					$data[$i + 1]['deduction'] = null;

                }
                if ($is_hematite == true) {
                    $data[$i]['deduction'] = $this->Prod1->getDeductionDetails($mineCode, $returnType, $returnDate, "iron_ore", 1);
                    /**
                     * ADDED THE [0] in $estimation as THERE WAS SOME LOOPING PROBLEM 
                     * WHICH CAUSING THE PROBLEM WHILE DISPLAYING THE DATA
                     * LINE 277, 283 AND 289
                     * 
                     */
                    $estimationDetails[0] = $this->MiningPlan->getEstimationDetailsForPrintAll($mineCode, $mineral_names[$i], "HEMATITE", $returnDate, $returnType);
                    $estimationDetails[0]['min'] = 'IRON ORE - HEMATITE';
                } 
                 
            } else {
                $data[$i]['deduction'] = $this->Prod1->getDeductionDetails($mineCode, $returnType, $returnDate, $mineral_names[$i]);

				// $estimationDetails[] = MINING_PLANTable::getEstimationDetails($this->mineCode, $mineral_names[$i], $is_hematite, $is_magnetite, $this->returnDate, $this->returnType);
                /**
                 * @author Uday Shankar Singh
                 * @version 30th May 2014
                 * 
                 * COMMENTED THE BELOW LINE AND ADDED THE LINE AFTER THAT AS
                 * THIS IS FOR THE PRODUCTION PROPOSAL AND EARLIER PRODUCTION PROPOSAL 
                 * FOR ONLY ONE MINERAL COMING IN THE PRINT ALL AND PDF, SO 
                 * NOW CREATING THE ARRAY AS ARRAY IS BEING PRINTED IN THE PRINT ALL 
                 * AND PDF ALREADY
                 *  
                 */
				// $estimationDetails[0] = MINING_PLANTable::getEstimationDetails($this->mineCode, $mineral_names[$i], '', '', $this->returnDate, $this->returnType);
                $estimationDetails[] = $this->MiningPlan->getEstimationDetails($mineCode, $mineral_names[$i], '', '', $returnDate, $returnType);
            }

            //SALES DISPATCHES
            $data[$i]['sales'] = $this->GradeSale->getSalesDispatches($mineCode, $returnType, $returnDate, $mineral_names[$i]);

            $unit = $this->DirMcpMineral->getMineralUnit(strtoupper(str_replace('_', ' ', $mineral_names[$i])));
			// if ($mineral_names[$i] == 'iron_ore') {
			// 	if ($is_hematite == true)
			// 		$subMin = "HEMATITE";
			// 	if ($isMagnetite == true)
			// 		$subMin = "MAGNETITE";

			// 	$estimationDetails[] = MINING_PLANTable::getEstimationDetailsForPrintAll($this->mineCode, $mineral_names[$i], $subMin, $this->returnDate, $this->returnType);
			// 	// $estimationDetails[] = MINING_PLANTable::getEstimationDetails($this->mineCode, $mineral_names[$i], $is_hematite, $is_magnetite, $this->returnDate, $this->returnType);
			// }


			// Added by Naveen Jha on 29/06/208 as Mining Plan details of only one mineral were getting saved as the array assignment was outside the loop
			// estimation_1 is a new temporary array in which details of all the minerals will be added. The same is being set to Success on line no. 366
			// if($estimationDetails[0]['est'] > 0){
			// 	$estimation_1[] = $estimationDetails;
			// }

			$this->set('unit', $unit);
		}  // end of for loop

		$formData = $data;
		// $estimation = $estimation_1;
		$estimation = $estimationDetails;

		/** ********************* ANNUAL RETURNS ************************ */
		if ($returnType == 'ANNUAL') {
			//particulars
			/**
			* COMMENTED THE FOLLOWING ONE LINE AND ADDED THE LINE AFTER THAT FOR PASSING THE CURRENT YEAR WHOSE RETURN IS BEING VISITED
			* @auhor uday Shankar singh <udayshankar1306@gmail.com, usingh@ubicsindia.com>
			* @version 7th Oct 2014
			*/
			//$particularsDetails = MCP_LEASETable::getParticularsDetails($this->mineCode);
			$particularsDetails = $this->McpLease->getParticularsDetails($mineCode, $returnYear);
			$particulars = $particularsDetails;
			//$this->leaseDetails = $particularsDetails['lease_details'];
			$totalParticulars = count($particularsDetails);
			$this->set('totalParticulars', $totalParticulars);
			$this->set('particulars', $particulars);

			//area of utilisation
			$utilisation = $this->LeaseReturn->getLeaseDetails($mineCode, $returnDate);
			$this->set('utilisation', $utilisation);

			//employment wages
            $empWages = $this->Employment->getEmploymentWagesDetails($mineCode, $returnDate, 1);

			$workStoppageReasons = $this->Clscommon->getReasonsArr();
			$returnDetails = $empWages['returnDetails'];
			$workStoppageDetails = $empWages['workStoppageDetails'];
			// $empWages = $empWages['empDetails'];
			$this->set('returnDetails', $returnDetails);
			$this->set('workStoppageDetails', $workStoppageDetails);
			$this->set('workStoppageReasons', $workStoppageReasons);

			//employment wages part II
			$empWagesPart2 = $this->Employment->getEmploymentWagesPart2Details($mineCode, $returnDate, 5);
			$returnDetailspart2 = $empWagesPart2['returnDetails'];
			$empWagesPart2 = $empWagesPart2['empDetails'];
			$this->set('returnDetailsPart2', $returnDetailspart2);
			$this->set('empWagesPart2', $empWagesPart2);

			//capital structure
			$capitalData = $this->CapitalStructure->getAllData($mineCode, $returnDate);
			$fixedResult = $capitalData['fixed_result'];
			$tableData = $capitalData['common_result'];
			$dynamicData = $capitalData['dynamic_result'];
			$capMineCodes = $capitalData['fixed_result']['selected_mine_code'];
			$this->set('fixedResult', $fixedResult);
			$this->set('tableData', $tableData);
			$this->set('dynamicData', $dynamicData);
			$this->set('capMineCodes', $capMineCodes);

			//material consumption quantity
			$matConsQuant = $this->MaterialConsumption->getMatConsDetails($mineCode, $returnDate);
			$this->set('matConsQuant', $matConsQuant);

			//material consumption royalty
			$matConsRoyalty = $this->RentReturns->getMatConsRoyaltyDetails($mineCode, $returnDate, 2);
			$this->set('matConsRoyalty', $matConsRoyalty);

			//material consumption tax
			$matConsTax = $this->RentReturns->getMatConsTaxDetails($mineCode, $returnDate, 3);
			$this->set('matConsTax', $matConsTax);

			//explosive consumption
			$expConReturn = $this->ExplosiveConsumption->getExplosiveReturnRecords($mineCode, $returnDate, 'ANNUAL');
			$expCon = $this->ExplosiveConsumption->getExplosiveConDetails($mineCode, $returnDate);
			$this->set('expConReturn', $expConReturn);
			$this->set('expCon', $expCon);

			//sec 1/2 copper ore
            $i = 1;
			foreach ($mineralProduced as $mineralProd) {
                $mineralProd = str_replace(" ", "_", strtolower($mineralProd));
                $geologyPart1Temp[$i] = $this->TblMinWorked->getFormData($mineCode, $returnDate, $mineralProd);
                $i++;
			}
			$this->set('geologyPart1', $geologyPart1Temp);
			$this->set('mineralProduced', $mineralProduced);
			//geology4 - sec 3
			
            $j = 1;
            foreach ($mineralProduced as $mineralProd) {
                $mineralProd = str_replace(" ", "_", strtolower($mineralProd));
                $geologyPart4Temp[$j] = $this->Reserves->getAllData($mineCode, $returnType, $returnDate, $mineralProd);

                $totalProvedTemp = (isset($geologyPart4Temp[$j]['count']['provedCount'])) ? $geologyPart4Temp[$j]['count']['provedCount'] : '';
                $totalProbableFirstTemp = (isset($geologyPart4Temp[$j]['count']['probableFirstCount'])) ? $geologyPart4Temp[$j]['count']['probableFirstCount'] : '';
                $totalProbableSecondTemp = (isset($geologyPart4Temp[$j]['count']['probableSecondCount'])) ? $geologyPart4Temp[$j]['count']['probableSecondCount'] : '';
                $totalFeasibilityTemp = (isset($geologyPart4Temp[$j]['count']['feasibilityCount'])) ? $geologyPart4Temp[$j]['count']['feasibilityCount'] : '';
                $totalPreFeasiFirstTemp = (isset($geologyPart4Temp[$j]['count']['preFeasiFirstCount'])) ? $geologyPart4Temp[$j]['count']['preFeasiFirstCount'] : '';
                $totalPreFeasiSecondTemp = (isset($geologyPart4Temp[$j]['count']['preFeasiSecondCount'])) ? $geologyPart4Temp[$j]['count']['preFeasiSecondCount'] : '';
                $totalMeasuredTemp = (isset($geologyPart4Temp[$j]['count']['measuredCount'])) ? $geologyPart4Temp[$j]['count']['measuredCount'] : '';
                $totalIndicatedTemp = (isset($geologyPart4Temp[$j]['count']['indicatedCount'])) ? $geologyPart4Temp[$j]['count']['indicatedCount'] : '';
                $totalInferredTemp = (isset($geologyPart4Temp[$j]['count']['inferredCount'])) ? $geologyPart4Temp[$j]['count']['inferredCount'] : '';
                $totalReconTemp = (isset($geologyPart4Temp[$j]['count']['reconCount'])) ? $geologyPart4Temp[$j]['count']['reconCount'] : '';

                $j++;
            }
            $geologyPart3 = $geologyPart4Temp;

            $totalProved = $totalProvedTemp;
            $totalProbableFirst = $totalProbableFirstTemp;
            $totalProbableSecond = $totalProbableSecondTemp;
            $totalFeasibility = $totalFeasibilityTemp;
            $totalPreFeasiFirst = $totalPreFeasiFirstTemp;
            $totalPreFeasiSecond = $totalPreFeasiSecondTemp;
            $totalMeasured = $totalMeasuredTemp;
            $totalIndicated = $totalIndicatedTemp;
            $totalInferred = $totalInferredTemp;
            $totalRecon = $totalReconTemp;
			$this->set('geologyPart3', $geologyPart3);
			$this->set('totalProved', $totalProved);
			$this->set('totalProbableFirst', $totalProbableFirst);
			$this->set('totalProbableSecond', $totalProbableSecond);
			$this->set('totalFeasibility', $totalFeasibility);
			$this->set('totalPreFeasiFirst', $totalPreFeasiFirst);
			$this->set('totalPreFeasiSecond', $totalPreFeasiSecond);
			$this->set('totalMeasured', $totalMeasured);
			$this->set('totalIndicated', $totalIndicated);
			$this->set('totalRecon', $totalRecon);

			// $this->grades = clsCommon::getMineGradeArr(); // HARD-CODED IN CLS COMMON .. NEED TO REMOVE IT WITH THE DYNAMIC LIST
			/**
			* REMOVING THE HARD CODED VALUES 
			* WHICH WERE DEFINED IN CLS COMMON CLASS
			* AS NOW WE HAVE THE MASTER FOR THEM
			* 
			*  @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
			*  @version 17th Jan 2014
			* 
			*  UPDATED THIS CODE AS THE PER THE CHANGES MADE TILL NOV 2013 FROM BANGALORE
			*/
			$grades = $this->DirNmiGrade->getNmiGrades();
			$this->set('grades', $grades);
	
			//geology2 i.e, SEC 4
			$geo2Data = $this->RentReturns->getAllGeology2Details($mineCode, $returnType, $returnDate, '');
			$benchGeo2 = $geo2Data['bench'];
			$heightGeo2 = $geo2Data['height'];
			$depthGeo2 = $geo2Data['depth'];
			$staticGeo2 = $geo2Data['static'];
			$drillGeo2 = $geo2Data['drill'];
			$trenchGeo2 = $geo2Data['trench'];
			$pitGeo2 = $geo2Data['pit'];
			$benchOptions = array('1' => 'Manual', '2' => 'Mechanised');
			$this->set('benchGeo2', $benchGeo2);
			$this->set('heightGeo2', $heightGeo2);
			$this->set('depthGeo2', $depthGeo2);
			$this->set('staticGeo2', $staticGeo2);
			$this->set('drillGeo2', $drillGeo2);
			$this->set('trenchGeo2', $trenchGeo2);
			$this->set('pitGeo2', $pitGeo2);
			$this->set('benchOptions', $benchOptions);
			$this->set('nmiGradesmeter', $nmiGradesmeter);

			//geology sec 4 - Mineral Rejects
			$mineralRejectsData = Array();
			foreach ($mineralProduced as $mineralData) {
                $mineralData = str_replace(" ", "_", strtolower($mineralData));
				$mineralRejectsData[$mineralData] = $this->RentReturns->getMineralRejectsDetails($mineCode, $returnType, $returnDate, $mineralData);
			}
			$this->set('mineralRejects', $mineralRejectsData);

			//geology3 SEC 5/6/8
			$formType = 1;
			$machineFormData = $this->Machinery->getAllData($mineCode, $returnType, $returnDate, $formType);
            $yearlyCount = count($machineFormData['aggregation']);
            $data = ($yearlyCount - 1) / 5;
            $machineryName = Array();
            for ($i = 1; $i <= $data; $i++) {
				if (isset($machineFormData['aggregation']["machine_select_" . $i])) {
					$machineryCode = $machineFormData['aggregation']["machine_select_" . $i];
					$machine_code = explode('-', $machineryCode);
					$machineryName[$i] = $this->DirMachinery->getMachineByCode($machine_code[0]);
				}
            }
			$this->set('machineryName', $machineryName);
			$this->set('machineFormData', $machineFormData);

			//geology3 SEC 7
			$sec6FormType = 2;
			foreach ($mineralProduced as $mineralData) {
                $mineralData = str_replace(" ", "_", strtolower($mineralData));
				$sec7Data[$mineralData] = $this->Machinery->getFormDataForSec6($mineCode, $returnType, $returnDate, $sec6FormType, $mineralData);
			}
			$this->set('sec7FormData', $sec7Data);

			//production cost
			$costId = $this->CostProduction->getCostId($mineCode, 'ANNUAL', $returnDate);
			$productionCost = $this->CostProduction->getAllData($costId);
			$this->set('productionCost', $productionCost);
		}

		if (!empty($oldreturns)) { 
			$this->Session->write('oldreturns', $oldreturns);
		}

		$this->set('mineCode', $mineCode);
		$this->set('returnType', $returnType);
		$this->set('formName', $formName);
		$this->set('returnMonth', $returnMonth);
		$this->set('returnYear', $returnYear);
		$this->set('formRuleNumber', $formRuleNumber);
		$this->set('regionName', $regionName);
		$this->set('mine', $mine);
		$this->set('bg_img', $bg_img);
		$this->set('img_name', $img_name);
		$this->set('owner', $owner);
		$this->set('formData', $formData);
		$this->set('FormLabelNameWithFormNo', $FormLabelNameWithFormNo);
		$this->set('oreType', $oreType);
		$this->set('estimation', $estimation);
		$this->set('finalSubmitDate', $finalSubmitDate);
		$this->set('fillerName', $fillerName);
		$this->set('fillerdesignation', $fillerdesignation);
		$this->set('ipTimeFormat', $ipTimeFormat);
		
		//call custome function from appcontroller to create pdf
		$this->generateReturnsPdf('/Returnspdf/minerPrintPdfOld');

	}


	// Generate M and L returns Pdf
    public function enduserPrintPdf(){

		$this->viewBuilder()->setLayout('print_panel');

		$pdfStatus = 1;

		// COMMON DATA
        //=================GETTING CLIENT IP ADDRESS AND MAKING TIMESTAMP===========
        $ipAddress = $this->Clscommon->getIpAddresses();
        $timeStamp = date('Y-m-d H:i:s');
        $ipTimeFormat = "From: " . $ipAddress . " at " . $timeStamp;

		if(null == $this->Session->read('registration_code')){
			if(null == $this->Session->read('mcu_user_id')){
				$endUserId = $this->Session->read('mc_mine_code');
			} else {
				$endUserId = $this->Session->read('mcu_user_id');
			}
		} else {
			$endUserId = $this->Session->read('registration_code');
		}

        $checkUnderScore = strpos($endUserId, '_');
        if ($checkUnderScore > 0) {
            $endUserId = str_replace('_', '/', $endUserId);
        }

        $returnDate = $this->Session->read('returnDate');
        $formType = $this->Session->read('formType');
		$lang = $this->Session->read('lang');
		$labels = $this->Language->getFormInputLabels('rent', $lang);
        
        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
		}
		
        //fetches the data applicant details 
        $aplicant_info = $this->McApplicantDet->getapplicantDetails();
		
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, $temp[0]));
        $period = $returnYear . " - " . ($temp[0] + 1);
		
        $mcu_user_id = $this->Session->read('mcu_user_id');

		$returnPdfStatus = $this->TblEndUserFinalSubmit->getPdfStatus($endUserId, $returnDate, $returnType);
		$this->Session->write('pdfBgText', $returnPdfStatus);

		$endUserIdBreak = explode('/', $endUserId);
        $regNoTemp = $this->McApplicantDet->findByDql($endUserIdBreak[0]);
        /**
         * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 16th Jan 2014
         * 
         * THESE CHANGES ARE MADE AS PER THE FILES I GET FROM AMOD SIR 
         * WHEN WE ARE WORKING FROM BANGLORE DATED 22nd Oct 2013
         *  
         * ADDED THE EXCEPTION HANDLING IS STATE IS NOT FOUND
         * 
         */
        if (empty($regNoTemp[0]['mcappd_state']) && empty($regNoTemp[0]['mcappd_district'])) {
            // $this->getUser()->setFlash('errorMsg', "Sorry !!! You can't proceed. State Code Or District Code is not present in the system. Make sure you have entered Region in form M.");
            $this->Session->write('mon_f_err',"Sorry !!! You can't proceed. State Code Or District Code is not present in the system. Make sure you have entered Region in form L.");
			$this->redirect(array('controller'=>'auth','action'=>'home'));
        }
        
        $regNO = $regNoTemp[0]['mcappd_concession_code'];
        /**
         * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 16th Jan 2014
         * 
         * THESE CHANGES ARE MADE AS PER THE FILES I GET FROM AMOD SIR 
         * WHEN WE ARE WORKING FROM BANGLORE DATED 22nd Oct 2013
         *  
         * ADDED THE EXCEPTION HANDLING IS DISTRICT IS NOT FOUND
         * 
         */
		$activityType = $this->McUser->getActivityType($endUserId);
        
        $mcu_design = $regNoTemp[0]['mcappd_officer_desig'];
        $finalSubmitDate = $this->TblEndUserFinalSubmit->getCreatedAt($endUserId, $returnDate, $returnType, $mcu_user_id);
        $pinCode = $regNoTemp[0]['mcappd_pincode'];
		
		$pdfLabel = $this->Language->pdfLabelEnduser($lang, $returnDate, $returnType, $activityType);
		
		$this->set('pinCode', $pinCode);
		$this->set('mcu_design', $mcu_design);
		$this->set('printAllDate', $finalSubmitDate);
		$this->set('userType', 1);

		$returnMonth = date('F', strtotime($returnDate));
		$returnYear = date('Y', strtotime($returnDate));

		$this->set('label', $labels);
		$this->set('pdfLabel', $pdfLabel);
		// $this->set('mineCode', $mineCode);
		$this->set('returnDate', $returnDate);
		$this->set('returnType', $returnType);
		$this->set('returnMonth', $returnMonth);
		$this->set('returnMonthShort', date('M', strtotime($returnDate)));
		$this->set('returnYear', $returnYear);
		$this->set('formNo', $formType);
		// $this->set('regionName', $regionName);
		$this->set('ipTimeFormat',$ipTimeFormat);
		$this->set('tableForm','');
		$this->set('finalSubmitDate', $finalSubmitDate);

		$label = array();
		$data = array();

		// PART I
		// GENERAL PARTICULARS
		$label['genp'] = $this->Language->getFormInputLabels('general_particular', $lang);
		$data['genp']['regNO'] = $this->McUser->getAppIdWithRegNo($endUserId);
        $data['genp']['fullName'] = $this->McApplicantDet->getFullName($endUserId);
        $registrationCodeNumericPart = explode("/",$endUserId);
        $appAdd = $this->McApplicantDet->fetchAllDetailsByAppId($registrationCodeNumericPart['0']);
		$districtData = ($appAdd[0]["mcappd_state"] && $appAdd[0]["mcappd_district"]) ? $this->DirDistrict->getDistrictName($appAdd[0]["mcappd_district"], $appAdd[0]["mcappd_state"]) : array('name'=>'');
		$districtName = $districtData['name'];
		$appAdd[0]["mcappd_district"] = (!empty($districtName)) ? $districtName . ",<br/>" : "";
		$appAdd[0]["mcappd_state"] = $appAdd[0]["mcappd_state"] ? $this->DirState->getStateNameAsArray($appAdd[0]["mcappd_state"]) . ",<br/>" : "";
		$data['genp']['appAdd'] = $appAdd;
		
        if ($activityType == 'C') {

            $addressDetails = $this->McMineralconsumptionDet->getConsumptionDetailsBasedOnAppId($endUserId);
			$stateCode = $addressDetails[0]['mcmd_state'];
			if(empty ($stateCode)) {
				$addressDetails[0]['mcmd_state'] = "";
			} else {
                $stateNameTemp = $this->DirState->getStateName($stateCode);
                $addressDetails[0]['mcmd_state'] = $stateNameTemp[0]['state_name'];
			}
            $data['genp']['regionAndDistrictName'] = $this->McMineralconsumptionDet->getRegionAndDistrictName($registrationCodeNumericPart['0'], $stateCode, $endUserId);
            $slNo = $addressDetails[0]['mcmd_slno'];
            $data['genp']['latiLongiDetails'] = $this->McMclatlongDet->getLatitudeLongitude($registrationCodeNumericPart['0'], $slNo);

        } else {

            $addressDetails = $this->McMineraltradingstorageexportDet->getTSEDetailsBasedOnAppId($endUserId);
            $stateCode = $addressDetails[0]['mcmd_state'];
            $stateNameTemp = $this->DirState->getStateName($stateCode);
            $addressDetails[0]['mcmd_state'] = $stateNameTemp[0]['state_name'];
            $data['genp']['regionAndDistrictName'] = $this->McMineraltradingstorageexportdistrictDet->getRegionAndDistrictName($registrationCodeNumericPart['0'], $stateCode, $endUserId);
            if ($activityType == 'S') {
                $slNo = $addressDetails[0]['mcmd_slno'];
                $data['genp']['latiLongiDetails'] = $this->McSflatlongDet->getLatitudeLongitude($registrationCodeNumericPart['0'], $slNo);
            }

        }
		
        $placeTemp = $addressDetails[0]['mcmd_village'] . ', ' . $addressDetails[0]['mcmd_tehsil'];
		$data['genp']['currActivity'] = $this->Clscommon->userTypeFullForm($activityType);
		$data['genp']['addressDetails'] = $addressDetails;
		$data['genp']['activityType'] = $activityType;
		$this->set('placeTemp', $placeTemp);

		// REGION ADDRESS
		// Get Registered Office location region for 'Trader without storage' enduser
		// And plant location region for other endusers
		// Effective from Phase-II (By Aniket Ganvir on 12-02-2022)

		$printAllRegion = $this->DirDistrict->getRegionNameForPrint($registrationCodeNumericPart['0'], $stateCode, $endUserId, $activityType);

        if (empty($printAllRegion)) {
			$loginUserType = $this->Session->read('loginusertype');
			$homeCntrl = (in_array($loginUserType, array('authuser','enduser'))) ? 'auth' : 'mms';
            // $this->getUser()->setFlash('errorMsg', "Sorry !!! You can't proceed. Region Name is not present in the system. Kindly contact IBM mentioning your mine details.");
            $this->Session->write('mon_f_err',"Sorry !!! You can't proceed. Region Name is not present in the system. Kindly contact IBM mentioning your mine details.");
			return $this->redirect(array('controller'=>$homeCntrl, 'action'=>'home'));
        }
		
		$this->set('printAllRegion', $printAllRegion);
		
		// TRADING ACTIVITY
		$label['ta'] = $this->Language->getFormInputLabels('trading_activity', $lang);
		$data['ta']['sec_no'] = 1;
        $resultSet = $this->Clscommon->NSeriesPrevMonthVsCurrentData($formType, $returnType, $returnDate, $endUserId, 'T');

		if($resultSet['mineralsData']==null){
			if($activityType != 'T'){
				$resultSet['mineralsData'][0] = ['local_mineral_code'=>'NIL', 'local_grade_code'=>'0', 'opening_stock'=>'0.000', 'closing_stock'=>'0.000', 'mineral_unit'=>''];
			} else {
				$resultSet['mineralsData'][0] = ['local_mineral_code'=>'', 'local_grade_code'=>'', 'opening_stock'=>'', 'closing_stock'=>'', 'mineral_unit'=>''];
			}
		}
		
		if($resultSet['gradeforMineral']==null){
			if($activityType != 'T'){
				$resultSet['gradeforMineral'][0]['supplier'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'0', 'registration_no_1'=>'0', 'quantity_1'=>'0.000', 'value_1'=>'0.00', 'suppliercount'=>1];
				$resultSet['gradeforMineral'][0]['importData'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'0', 'country_name_1'=>'0', 'quantity_1'=>'0.000', 'value_1'=>'0.00', 'importcount'=>1];
				$resultSet['gradeforMineral'][0]['despatch'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'0', 'registration_no_1'=>'0', 'quantity_1'=>'0.000', 'value_1'=>'0.00', 'despatchcount'=>1];
				$resultSet['gradeforMineral'][0]['consumeData'] = ['quantity'=>'0.000', 'value'=>'0.00'];
			} else {
				$resultSet['gradeforMineral'][0]['supplier'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'suppliercount'=>1];
				$resultSet['gradeforMineral'][0]['importData'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'country_name_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'importcount'=>1];
				$resultSet['gradeforMineral'][0]['despatch'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'despatchcount'=>1];
				$resultSet['gradeforMineral'][0]['consumeData'] = ['quantity'=>'', 'value'=>''];
			}

		}
		
		$min_row_span = array();
		$min_val = "";
		$min_grade_arr = array();
		$min_code_row = array();
		$vall = 1;
		foreach($resultSet['mineralsData'] as $key=>$val){
			
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

			$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $returnDate);
			$min_grade_arr[$key] = $min_grade['gradeData'];

		}
		
	    $minerals = $this->DirMeMineral->getMineralList();
	    $mineralsArr = [];
	    foreach($minerals as $key=>$val){
	    	$mineralsArr[$val] = $val;
	    }

		$data['ta']['tradingAc'] = $resultSet;
		$data['ta']['min_grade_arr'] = $min_grade_arr;
		$data['ta']['min_row_span'] = $min_row_span;
		$data['ta']['minerals'] = $minerals;

		// EXPORT ACTIVITY
		$label['ea'] = $this->Language->getFormInputLabels('export_of_ore', $lang);
		$data['ea']['sec_no'] = 2;
        $resultSet = $this->Clscommon->NSeriesPrevMonthVsCurrentData($formType, $returnType, $returnDate, $endUserId, 'E');

		if($resultSet['mineralsData']==null){
			if($activityType != 'E'){
				$resultSet['mineralsData'][0] = ['local_mineral_code'=>'NIL', 'local_grade_code'=>'0', 'opening_stock'=>'0.000', 'closing_stock'=>'0.000', 'mineral_unit'=>''];
			} else {
				$resultSet['mineralsData'][0] = ['local_mineral_code'=>'', 'local_grade_code'=>'', 'opening_stock'=>'', 'closing_stock'=>'', 'mineral_unit'=>''];
			}
		}
		
		if($resultSet['gradeforMineral']==null){
			if($activityType != 'E'){
				$resultSet['gradeforMineral'][0]['supplier'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'0', 'registration_no_1'=>'0', 'quantity_1'=>'0.000', 'value_1'=>'0.00', 'suppliercount'=>1];
				$resultSet['gradeforMineral'][0]['importData'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'0', 'country_name_1'=>'0', 'quantity_1'=>'0.000', 'value_1'=>'0.00', 'importcount'=>1];
				$resultSet['gradeforMineral'][0]['despatch'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'0', 'registration_no_1'=>'0', 'quantity_1'=>'0.000', 'value_1'=>'0.00', 'despatchcount'=>1];
				$resultSet['gradeforMineral'][0]['consumeData'] = ['quantity'=>'0.000', 'value'=>'0.00'];
			} else {
				$resultSet['gradeforMineral'][0]['supplier'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'suppliercount'=>1];
				$resultSet['gradeforMineral'][0]['importData'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'country_name_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'importcount'=>1];
				$resultSet['gradeforMineral'][0]['despatch'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'despatchcount'=>1];
				$resultSet['gradeforMineral'][0]['consumeData'] = ['quantity'=>'', 'value'=>''];
			}
		}
		
		$min_row_span = array();
		$min_val = "";
		$min_grade_arr = array();
		$min_code_row = array();
		$vall = 1;
		foreach($resultSet['mineralsData'] as $key=>$val){
			
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

			$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $returnDate);
			$min_grade_arr[$key] = $min_grade['gradeData'];

		}
		
	    $minerals = $this->DirMeMineral->getMineralList();
	    $mineralsArr = [];
	    foreach($minerals as $key=>$val){
	    	$mineralsArr[$val] = $val;
	    }

		$data['ea']['tradingAc'] = $resultSet;
		$data['ea']['min_grade_arr'] = $min_grade_arr;
		$data['ea']['min_row_span'] = $min_row_span;
		$data['ea']['minerals'] = $minerals;
		
		// MINERAL BASED ACTIVITY
		$label['mba'] = $this->Language->getFormInputLabels('mineral_base_activity', $lang);
		$data['mba']['sec_no'] = 3;
        $resultSet = $this->Clscommon->NSeriesPrevMonthVsCurrentData($formType, $returnType, $returnDate, $endUserId, 'C', $pdfStatus);

		if($resultSet['mineralsData']==null){
			if($activityType != 'C'){
				$resultSet['mineralsData'][0] = ['local_mineral_code'=>'NIL', 'local_grade_code'=>'0', 'opening_stock'=>'0.000', 'closing_stock'=>'0.000', 'mineral_unit'=>''];
			} else {
				$resultSet['mineralsData'][0] = ['local_mineral_code'=>'', 'local_grade_code'=>'', 'opening_stock'=>'', 'closing_stock'=>'', 'mineral_unit'=>''];
			}
		}
		
		if($resultSet['gradeforMineral']==null){
			if($activityType != 'C'){
				$resultSet['gradeforMineral'][0]['supplier'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'0', 'registration_no_1'=>'0', 'quantity_1'=>'0.000', 'value_1'=>'0.00', 'suppliercount'=>1];
				$resultSet['gradeforMineral'][0]['importData'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'0', 'country_name_1'=>'0', 'quantity_1'=>'0.000', 'value_1'=>'0.00', 'importcount'=>1];
				$resultSet['gradeforMineral'][0]['despatch'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'0', 'registration_no_1'=>'0', 'quantity_1'=>'0.000', 'value_1'=>'0.00', 'despatchcount'=>1];
				$resultSet['gradeforMineral'][0]['consumeData'] = ['quantity'=>'0.000', 'value'=>'0.00'];
			} else {
				$resultSet['gradeforMineral'][0]['supplier'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'suppliercount'=>1];
				$resultSet['gradeforMineral'][0]['importData'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'country_name_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'importcount'=>1];
				$resultSet['gradeforMineral'][0]['despatch'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'despatchcount'=>1];
				$resultSet['gradeforMineral'][0]['consumeData'] = ['quantity'=>'', 'value'=>''];
			}

		}
		
		$min_row_span = array();
		$min_val = "";
		$min_grade_arr = array();
		$min_code_row = array();
		$vall = 1;
		foreach($resultSet['mineralsData'] as $key=>$val){
			
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

			$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $returnDate);
			$min_grade_arr[$key] = $min_grade['gradeData'];

		}
		$data['mba']['tradingAc'] = $resultSet;
		$data['mba']['min_grade_arr'] = $min_grade_arr;
		$data['mba']['min_row_span'] = $min_row_span;
		$data['mba']['minerals'] = $minerals;

		
		// STORAGE ACTIVITY
		$label['sa'] = $this->Language->getFormInputLabels('storage_activity', $lang);
		$data['sa']['sec_no'] = 4;
        $resultSet = $this->Clscommon->NSeriesPrevMonthVsCurrentData($formType, $returnType, $returnDate, $endUserId, 'S');

		if($resultSet['mineralsData']==null){
			if($activityType != 'S'){
				$resultSet['mineralsData'][0] = ['local_mineral_code'=>'NIL', 'local_grade_code'=>'0', 'opening_stock'=>'0.000', 'closing_stock'=>'0.000', 'mineral_unit'=>''];
			} else {
				$resultSet['mineralsData'][0] = ['local_mineral_code'=>'', 'local_grade_code'=>'', 'opening_stock'=>'', 'closing_stock'=>'', 'mineral_unit'=>''];
			}
		}
		
		if($resultSet['gradeforMineral']==null){
			if($activityType != 'S'){
				$resultSet['gradeforMineral'][0]['supplier'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'0', 'registration_no_1'=>'0', 'quantity_1'=>'0.000', 'value_1'=>'0.00', 'suppliercount'=>1];
				$resultSet['gradeforMineral'][0]['importData'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'0', 'country_name_1'=>'0', 'quantity_1'=>'0.000', 'value_1'=>'0.00', 'importcount'=>1];
				$resultSet['gradeforMineral'][0]['despatch'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'0', 'registration_no_1'=>'0', 'quantity_1'=>'0.000', 'value_1'=>'0.00', 'despatchcount'=>1];
				$resultSet['gradeforMineral'][0]['consumeData'] = ['quantity'=>'0.000', 'value'=>'0.00'];
			} else {
				$resultSet['gradeforMineral'][0]['supplier'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'suppliercount'=>1];
				$resultSet['gradeforMineral'][0]['importData'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'country_name_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'importcount'=>1];
				$resultSet['gradeforMineral'][0]['despatch'] = ['local_mineral_code_1'=>'', 'activity_status_1'=>'', 'registration_no_1'=>'', 'quantity_1'=>'', 'value_1'=>'', 'despatchcount'=>1];
				$resultSet['gradeforMineral'][0]['consumeData'] = ['quantity'=>'', 'value'=>''];
			}
		}
		
		$min_row_span = array();
		$min_val = "";
		$min_grade_arr = array();
		$min_code_row = array();
		$vall = 1;
		foreach($resultSet['mineralsData'] as $key=>$val){
			
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

			$min_grade = $this->DirMineralGrade->getAllMineralGradeinfo($val['local_mineral_code'], $returnDate);
			$min_grade_arr[$key] = $min_grade['gradeData'];

		}
		
	    $minerals = $this->DirMeMineral->getMineralList();
	    $mineralsArr = [];
	    foreach($minerals as $key=>$val){
	    	$mineralsArr[$val] = $val;
	    }

		$data['sa']['tradingAc'] = $resultSet;
		$data['sa']['min_grade_arr'] = $min_grade_arr;
		$data['sa']['min_row_span'] = $min_row_span;
		$data['sa']['minerals'] = $minerals;

        if ($returnType == 'ANNUAL') {
			if ($activityType == 'C') {

				// END-USE MINERAL BASED INDUSTRIES - I
				$regid = explode("/", $endUserId);
				$registrationCodeNumericPart = $regid[0];
				$label['mbi'] = $this->Language->getFormInputLabels('mineral_based_industries', $lang);
				$addressDetails = $this->McMineralconsumptionDet->getConsumptionDetailsBasedOnAppId($endUserId);
				$stateCode = $addressDetails[0]['mcmd_state'];
				$data['mbi']['regionAndDistrictName'] = $this->McMineralconsumptiondistrictDet->getRegionAndDistrictName($registrationCodeNumericPart, $stateCode, $endUserId);
				$stateFullName = $this->DirState->getState($addressDetails[0]['mcmd_state']);
				$addressDetails[0]['mcmd_state'] = ($stateFullName == '--') ? $addressDetails[0]['mcmd_state'] : $stateFullName;
				$slNo = $addressDetails[0]['mcmd_slno'];
				$data['mbi']['latiLongiDetails'] = $this->McMclatlongDet->getLatitudeLongitude($registrationCodeNumericPart, $slNo);
				$data['mbi']['fetchData'] = $this->OMineralIndustryInfo->getAllRecord($formType, $returnType, $returnDate, $endUserId, 'C');
				$data['mbi']['addressDetails'] = $addressDetails;

				// END-USE MINERAL BASED INDUSTRIES - II
				$formFlagProd = 1;
				$label['pmd'] = $this->Language->getFormInputLabels('product_manufacture_details', $lang);
				$data['pmd']['mineralData'] = $this->OProdDetails->getMineralData($formType, $returnType, $returnDate, $endUserId, $formFlagProd);

				// IRON AND STEEL INDUSTRY
				$formFlagIndus = 2;
				$label['isi'] = $this->Language->getFormInputLabels('iron_steel_industries', $lang);
				$data['isi'] = $this->OProdDetails->getAllData($formType, $returnType, $returnDate, $endUserId, $formFlagIndus);
				
				// RAW MATERIAL CONSUMED IN PRODUCTION
				$label['rmc'] = $this->Language->getFormInputLabels('raw_material_consumed', $lang);
				$data['rmc']['mineralOptions'] = $this->DirMeMineral->getAllMinerals();
				$data['rmc']['rawMatdata'] = $this->ORawMatConsume->getAllData($formType, $returnType, $returnDate, $endUserId, "C");

				// SOURCE OF SUPPLY
				$label['sos'] = $this->Language->getFormInputLabels('source_of_supply', $lang);
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

				$data['sos']['minBasedOnRaw'] = $minBasedOnRaw;
				$data['sos']['districts'] = $districts;
				$data['sos']['modeOption'] = $modeOption;
				$data['sos']['countryOption'] = $countryOption;
				$data['sos']['sourceData'] = $sourceData;

			}
		}

		$this->set('label', $label);
		$this->set('data', $data);
		
		$esign_status = null;
		if ($this->request->is('post')) {

			$action = $this->request->getData('action');
			if ($action == 'esign') {
				$esign_status = 1;
				$this->Session->write('pdf_status', true);
			}

		}
		
		$loginUserType = $this->Session->read('loginusertype');
		
		$returnPdfStatus = $this->TblEndUserFinalSubmit->getPdfStatus($endUserId, $returnDate, $returnType);
		$returnPdfStatus = ($returnPdfStatus == 'draft' && $esign_status == 1) ? 'submit' : $returnPdfStatus; // set return status as 'submit' on the time of first e-signing
		$returnPdfStatus = ($loginUserType == 'mmsuser' && $returnPdfStatus == 'submit' && $esign_status == 1) ? 'approve' : $returnPdfStatus; // set return status as 'approve' on the time of supervisor approval
		$this->Session->write('pdfBgText', $returnPdfStatus);
		
		//call custome function from appcontroller to create pdf
		$this->generateReturnsPdf('/Returnspdf/enduserPrintPdf', $esign_status);

	}

	
	// Generate Enduser Print Pdf for Old returns
    public function enduserPrintPdfOld(){

		$this->viewBuilder()->setLayout('print_panel_old');

		// COMMON DATA
        //=================GETTING CLIENT IP ADDRESS AND MAKING TIMESTAMP===========
        $ipAddress = $this->Clscommon->getIpAddresses();
        $timeStamp = date('Y-m-d H:i:s');
        $ipTimeFormat = "From: " . $ipAddress . " at " . $timeStamp;

		if(null == $this->Session->read('registration_code')){
			if(null == $this->Session->read('mcu_user_id')){
				$endUserId = $this->Session->read('mc_mine_code');
			} else {
				$endUserId = $this->Session->read('mcu_user_id');
			}
		} else {
			$endUserId = $this->Session->read('registration_code');
		}

		$oldreturns = null;
		if (null != $this->Session->read('oldreturns')) {
			$oldreturns = $this->Session->read('oldreturns');
		}

        $checkUnderScore = strpos($endUserId, '_');
        if ($checkUnderScore > 0) {
            $endUserId = str_replace('_', '/', $endUserId);
        }

        $returnDate = $this->Session->read('returnDate');
        $formType = $this->Session->read('formType');
		$lang = $this->Session->read('lang');
        
        $returnType = $this->Session->read('returnType');
        if ($returnType == ""){
            $returnType = 'MONTHLY';
		}
		
        //fetches the data applicant details 
        $aplicant_info = $this->McApplicantDet->getapplicantDetails();

        //$this->mineral = strtolower(str_replace(' ', '_', $this->mineral));

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, $temp[0]));
        $period = $returnYear . " - " . ($temp[0] + 1);

        $mcu_user_id = $endUserId;
        /**
         * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 16th Jan 2014
         * 
         * THESE CHANGES ARE MADE AS PER THE FILES I GET FROM AMOD SIR 
         * WHEN WE ARE WORKING FROM BANGLORE DATED 22nd Oct 2013
         *  
         * COMMENTED THESES LINES AS THE FUNTION  checkIsSubmitted IS NOT NEEDED ANY MORE AND ONLY
         * ONE FUNCTION CAN SOLVE THE PROBLEM
         * 
         */
		// if ($mcu_user_id) {
		// 	$is_final_submitted = TBL_END_USER_FINAL_SUBMITTable::checkIsSubmitted($this->endUserId, $this->returnDate, $this->returnType, $mcu_user_id);
		// } else {
            $is_final_submitted = $this->TblEndUserFinalSubmit->checkIsSubmittedForMMS($endUserId, $returnDate, $returnType);
		// }

        if ($is_final_submitted == true) {
            $img_name = "final-submited.jpg";
        } else {
            $img_name = "draft.jpg";
        }

        $this->Session->write('bg_image', $img_name);
        $bg_img = $img_name;

		$returnPdfStatus = $this->TblEndUserFinalSubmit->getPdfStatus($endUserId, $returnDate, $returnType);
		$this->Session->write('pdfBgText', $returnPdfStatus);

        //to create url for Back button
        $mmsUser = $this->Session->read('mms_user_id');
        if (isset($mmsUser)){
            $is_mms_user = true;
		}

        //=========================NAME AND DESIGNATION=============================
		// $this->fillerName = $this->getUser()->getAttribute('mcu_first');
		// $this->mcu_design = $this->getUser()->getAttribute('mcu_design');
		// print_r($_SESSION);
		// die;
		// $this->setLayout('print_layout');

        $userType = 1;


		
        /**
         * GETTING THE GRADE NAMES ALL AT ONCE SO THAT JUST HAVE TO CHECK IN THE 
         * ARRAY TO GET THE CORRESPONDING GRADE
         * @author Uday Shankar Singh<usingh@ubicsindia.com>
         * @version 4th Feb 2014
         *  
         */
        $mineralWithUnitArr = $this->DirMeMineral->getAllMineralWithUnit();

        //=======================GENERAL PARTICULAR=============================
        // $activityType = $this->Session->read('activityType');
        // if (!$activityType) {
            $activityTypeTemp = $this->McUser->find('all')->where(['mcu_child_user_name'=>$endUserId])->toArray();
            $activityType = $activityTypeTemp[0]['mcu_activity'];
        // }
        $returnDatePeriod = $this->Clscommon->getDatePeriod($returnDate, $returnType, " "); // Parameter date , return type , separator
        $endUserIdBreak = explode('/', $endUserId);
        // $regNoTemp = Doctrine_Core::getTable('MC_APPLICANT_DET')->findByDql('where mcappd_app_id = ?', $endUserIdBreak[0])->toArray();
        $regNoTemp = $this->McApplicantDet->find('all')->where(['mcappd_app_id'=>$endUserIdBreak[0]])->toArray();
        
        /**
         * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 16th Jan 2014
         * 
         * THESE CHANGES ARE MADE AS PER THE FILES I GET FROM AMOD SIR 
         * WHEN WE ARE WORKING FROM BANGLORE DATED 22nd Oct 2013
         *  
         * ADDED THE EXCEPTION HANDLING IS STATE IS NOT FOUND
         * 
         */
        if (empty($regNoTemp[0]['mcappd_state']) && empty($regNoTemp[0]['mcappd_district'])) {
            // $this->getUser()->setFlash('errorMsg', "Sorry !!! You can't proceed. State Code Or District Code is not present in the system. Make sure you have entered Region in form M.");
            $this->Session->write('mon_f_err',"Sorry !!! You can't proceed. State Code Or District Code is not present in the system. Make sure you have entered Region in form M.");
			$this->redirect(array('controller'=>'auth','action'=>'home'));
        }
        

        $regNO = $regNoTemp[0]['mcappd_concession_code'];
        /**
         * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 16th Jan 2014
         * 
         * THESE CHANGES ARE MADE AS PER THE FILES I GET FROM AMOD SIR 
         * WHEN WE ARE WORKING FROM BANGLORE DATED 22nd Oct 2013
         *  
         * ADDED THE EXCEPTION HANDLING IS DISTRICT IS NOT FOUND
         * 
         */
        $printAllRegion = $this->DirDistrict->getRegionNameByDistrictcode($regNoTemp[0]['mcappd_state'], $regNoTemp[0]['mcappd_district']);
        if (empty($printAllRegion)) {
            // $this->getUser()->setFlash('errorMsg', "Sorry !!! You can't proceed. Region Name is not present in the system. Kindly contact IBM mentioning your mine details.");
            $this->Session->write('mon_f_err',"Sorry !!! You can't proceed. Region Name is not present in the system. Kindly contact IBM mentioning your mine details.");
			$this->redirect(array('controller'=>'auth','action'=>'home'));
        }
        
        $printAllRegion = $printAllRegion;
        $mcu_design = $regNoTemp[0]['mcappd_officer_desig'];
        $finalSubmitDate = $this->TblEndUserFinalSubmit->getCreatedAt($endUserId, $returnDate, $returnType, $mcu_user_id);
        $printAllDate = $finalSubmitDate;
        $pinCode = $regNoTemp[0]['mcappd_pincode'];
        $currActivity = $this->Clscommon->userTypeFullForm($activityType);

        $fullName = $this->McApplicantDet->getFullName($endUserId);
        $fillerName = $fullName;

		// Ganesh satav change the below line so comment below line
		// $re gistrationCodeNumericPart = substr($this->endUserId, 0, 2);
		// below added line add by the ganesh satav 
        $registrationCodeNumericPart = explode("/",$endUserId);
        /**
         * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 16th Jan 2014
         * 
         * THESE CHANGES ARE MADE AS PER THE FILES I GET FROM AMOD SIR 
         * WHEN WE ARE WORKING FROM BANGLORE DATED 22nd Oct 2013
         *  
         * ADDED THE CALL TO fetchAllDetailsByAppId($registrationCodeNumericPart)
         * 
         */        
		//===============GETTING AND MANAGING THE APPLICANT ADDRESS=============
		
		// GENERAL PARTICULARS
		// $label['genp'] = $this->Language->getFormInputLabels('general_particular', $lang);
		// $data['genp']['regNO'] = $this->McUser->getAppIdWithRegNo($endUserId);
        // $data['genp']['fullName'] = $this->McApplicantDet->getFullName($endUserId);
        // $registrationCodeNumericPart = explode("/",$endUserId);

        $appAdd = $this->McApplicantDet->fetchAllDetailsByAppId($registrationCodeNumericPart['0']);
		
		$districtData = ($appAdd[0]["mcappd_state"] && $appAdd[0]["mcappd_district"]) ? $this->DirDistrict->getDistrictName($appAdd[0]["mcappd_district"], $appAdd[0]["mcappd_state"]) : array('name'=>'');
		$districtName = $districtData['name'];
		$appAdd[0]["mcappd_district"] = (!empty($districtName)) ? $districtName . ",<br/>" : "";
		$appAdd[0]["mcappd_state"] = $appAdd[0]["mcappd_state"] ? $this->DirState->getStateNameAsArray($appAdd[0]["mcappd_state"]) . ",<br/>" : "";
		$latiLongiDetails = null;
		
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
        $placeTemp = $addressDetails[0]['mcmd_village'] . ', ' . $addressDetails[0]['mcmd_tehsil'];
		$currActivity = $this->Clscommon->userTypeFullForm($activityType);
		$addressDetails = $addressDetails;
		$activityType = $activityType;
		$this->set('placeTemp', $placeTemp);

        //======= CODE FOR TRADING ACTIVITY ===================================//
        $mineralsData = array();
        $gradesData = array();
		$gradeData = array();
        $mineralData = $this->NSeriesProdActivity->getSeriesActivityDetails($formType, $returnType, $returnDate, $endUserId, 'T');
        $gradeforMineral = array();
        foreach ($mineralData as $n) {
            $gradeforMineral[] = $this->ExtraNSeriesProdActivity->getSeriesExtraActivityDetails($returnType, $returnDate, $endUserId, $n['local_mineral_code'], $n['local_grade_code'], 'T');
			// $gradeData[] = DIR_MINERAL_GRADETable::getGradeName($n['LOCAL_GRADE_CODE'], 1);
            $gradeData[] = $this->DirMineralGrade->getGradeName($n['local_grade_code']);
			$districtName = (isset($regionAndDistrictName['district_name'])) ? $regionAndDistrictName['district_name'] : (isset($regionAndDistrictName[0][1]) ? $regionAndDistrictName[0][1] : '');
			$regionName = $this->DirDistrict->getRegionNameByDistrictName($districtName);
		}
        $mineralsData = $mineralData;
        $gradesData = $gradeData;
        $gradeforMineral = $gradeforMineral;

        //=========CODE FOR THE EXPORT OF ORE ======================================// 
        $mineralsExportData = array();
        $gradesExportData = array();
        $mineralExportData = $this->NSeriesProdActivity->getSeriesActivityDetails($formType, $returnType, $returnDate, $endUserId, 'E');
        $displayMineralData = array();
		$gradeExportData = array();
        foreach ($mineralExportData as $exp) {
            $displayMineralData[] = $this->ExtraNSeriesProdActivity->getSeriesExtraActivityDetails($returnType, $returnDate, $endUserId, $exp['local_mineral_code'], $exp['local_grade_code'], 'E');
			// $gradeExportData[] = DIR_MINERAL_GRADETable::getGradeName($exp['LOCAL_GRADE_CODE'], 2);
            $gradeExportData[] = $this->DirMineralGrade->getGradeName($exp['local_grade_code']);
        }
        $mineralsExportData = $mineralExportData;
        $gradesExportData = $gradeExportData;
        $showMineralData = $displayMineralData;

        //=========End Use Mineral Base Activity ======================================// 
        $mineralsBaseData = array();
        $gradesBaseData = array();
        $mineralBaseData = $this->NSeriesProdActivity->getSeriesActivityDetails($formType, $returnType, $returnDate, $endUserId, 'C');
        $displayMineralBaseData = array();
        $gradeBaseData = array();
        foreach ($mineralBaseData as $m) {
            $displayMineralBaseData[] = $this->ExtraNSeriesProdActivity->getSeriesExtraActivityDetails($returnType, $returnDate, $endUserId, $m['local_mineral_code'], $m['local_grade_code'], 'C');
			// $gradeBaseData[] = DIR_MINERAL_GRADETable::getGradeName($m['LOCAL_GRADE_CODE'], 3);
            $gradeBaseData[] = $this->DirMineralGrade->getGradeName($m['local_grade_code']);
        }
        $mineralsBaseData = $mineralBaseData;
        $gradesBaseData = $gradeBaseData;
        $showMineralBaseData = $displayMineralBaseData;
		
        //======= CODE FOR Storage Activity ===================================//
        $mineralsStorageData = array();
        $gradesStorageData = array();
        $mineralStorageData = $this->NSeriesProdActivity->getSeriesActivityDetails($formType, $returnType, $returnDate, $endUserId, 'S');
        $displayStoragedata = array();
        $gradeStorageData = array();
        foreach ($mineralStorageData as $s) {
            $displayStoragedata[] = $this->ExtraNSeriesProdActivity->getSeriesExtraActivityDetails($returnType, $returnDate, $endUserId, $s['local_mineral_code'], $s['local_grade_code'], 'S');
			// $gradeStorageData[] = DIR_MINERAL_GRADETable::getGradeName($s['LOCAL_GRADE_CODE'], 4);
            $gradeStorageData[] = $this->DirMineralGrade->getGradeName($s['local_grade_code']);
        }
        $mineralsStorageData = $mineralStorageData;
        $gradesStorageData = $gradeStorageData;
        $showStorageData = $displayStoragedata;

        if ($returnType == 'ANNUAL') {
            if ($activityType == 'C') {
				//O Series
                //END - use Mineral Based Industries I
                $mineralIndustrial = $this->OMineralIndustryInfo->getAllRecord($formType, $returnType, $returnDate, $endUserId, 'C');
                $state_name = $this->DirState->getState($mineralIndustrial['state']);
                $district_name = $this->DirDistrict->getDistrict($mineralIndustrial['district'], $mineralIndustrial['state']);
				$this->set('mineralIndustrial', $mineralIndustrial);

                $formFlagProd = 1;
                $mineralData = $this->OProdDetails->getMineralData($formType, $returnType, $returnDate, $endUserId, $formFlagProd);
				$this->set('mineralData', $mineralData);

                //Raw Material Consumed
				$rawMatdata = $this->ORawMatConsume->getAllData($formType, $returnType, $returnDate, $endUserId, "C");
				$this->set('rawMatdata', $rawMatdata);

                //Source of Supply
				$sourceData = $this->OSourceSupply->getAllData($formType, $returnType, $returnDate, $endUserId, "C");
				$this->set('sourceData', $sourceData);

                //Iron and Steel Industries
                $formFlagIndus = 2;
				$ironData = $this->OProdDetails->getAllData($formType, $returnType, $returnDate, $endUserId, $formFlagIndus);
				$this->set('ironData', $ironData);
			}
        }

		if (!empty($oldreturns)) { 
			$this->Session->write('oldreturns', $oldreturns);
		}

		$this->set('returnType', $returnType);
		$this->set('returnMonth', $returnMonth);
		$this->set('returnYear', $returnYear);
		$this->set('returnDate', $returnDate);
		$this->set('bg_img', $bg_img);
		$this->set('img_name', $img_name);
		$this->set('printAllRegion', $printAllRegion);
		$this->set('pinCode', $pinCode);
		$this->set('appAdd', $appAdd);
		$this->set('regNO', $regNO);
		$this->set('fullName', $fullName);
		$this->set('addressDetails', $addressDetails);
		$this->set('regionAndDistrictName', $regionAndDistrictName);
		$this->set('activityType', $activityType);
		$this->set('currActivity', $currActivity);
		$this->set('mineralsData', $mineralsData);
		$this->set('gradesData', $gradesData);
		$this->set('mineralWithUnitArr', $mineralWithUnitArr);
		$this->set('gradeforMineral', $gradeforMineral);
		$this->set('mineralsExportData', $mineralsExportData);
		$this->set('gradesExportData', $gradesExportData);
		$this->set('latiLongiDetails', $latiLongiDetails);
		$this->set('showMineralData', $showMineralData);
		$this->set('mineralsBaseData', $mineralsBaseData);
		$this->set('showMineralBaseData', $showMineralBaseData);
		$this->set('mineralsStorageData', $mineralsStorageData);
		$this->set('gradesStorageData', $gradesStorageData);
		$this->set('showStorageData', $showStorageData);
		$this->set('placeTemp', $placeTemp);
		$this->set('printAllDate', $printAllDate);
		$this->set('fillerName', $fillerName);
		$this->set('mcu_design', $mcu_design);
		$this->set('ipTimeFormat', $ipTimeFormat);
		
		//call custom function from appcontroller to create pdf
		$this->generateReturnsPdf('/Returnspdf/enduserPrintPdfOld');

	}

	// Create Return Final Submitted and Granted Pdf File
	public function generateReturnsPdf($pdf_view_path, $esign_status = null){

		$all_data_pdf = $this->render($pdf_view_path);
		if ($esign_status == true) {
			
			$loginusertype = $this->Session->read('loginusertype');
			$applicantid = $this->Session->read('applicantid');
			$returnDate = $this->Session->read('returnDate');
			$returnType = $this->Session->read('returnType');

			if($loginusertype == 'authuser' || $loginusertype == 'enduser')
			{
				$status = 'finalsubmitted';
				$pdfPrifix = 'FS';
				$applicantid = $this->Session->read('username');
				$this->Session->write('pdf_sign_status','submit');
			}else{
				$view_user_type = $this->Session->read('view_user_type');
				$applicantid = ($view_user_type == 'enduser') ? $this->Session->read('mc_mine_code') : $applicantid;
				$status = 'approved';
				$pdfPrifix = 'A';
				$this->Session->write('pdf_sign_status','approve');
			}

			//check applicant last record version to increment		
			$list_id = $this->EsignPdfRecords->find('all', array('fields'=>'version', 'conditions'=>array('applicant_id IS'=>$applicantid,'return_type'=>$returnType,'return_date'=>$returnDate)))
						->order('id desc')
						->limit(1)
						->first();
						
			if(!empty($list_id))
			{
				$last_pdf_version 	=	$list_id['version'];
			}
			else{					
				$last_pdf_version = 0;
			}

			$current_pdf_version = $last_pdf_version+1; //increment last version by 1

			//taking complete file name in session, which will be use in esign controller to esign the file.
			$appId = str_replace('/','_',$applicantid);
			$this->Session->write('pdf_file_name',$pdfPrifix.'-'.$appId.'('.$current_pdf_version.')'.'.pdf');

			$esign_xml_confirm = false;
			if ($esign_xml_confirm == true) {
				
				$file_path = $this->Customfunctions->pdfFilePath();
				
				$pdfRecords = $this->EsignPdfRecords->newEntity(array(		
					'applicant_id'=>$applicantid,
					'return_type'=>$returnDate,
					'return_date'=>$returnType,
					'pdf_file'=>$file_path,
					'date'=>date('Y-m-d'),
					'status'=>$status,
					'version'=>$current_pdf_version,
					'created'=>date('Y-m-d H:i:s'),
					'modified'=>date('Y-m-d H:i:s')				
				)); 
				$this->EsignPdfRecords->save($pdfRecords);

			} else {
				
				$this->callTcpdf($all_data_pdf,'F');//on 23-01-2020 with save mode

			}

		} else {

			$this->callTcpdf($all_data_pdf,'I');//on 23-01-2020 with preview mode
			// $this->callTcpdf($all_data_pdf,'F');//on 23-01-2020 with save mode

		}

	}


	public function callTcpdf($html,$mode){
	
		//$with_esign = $this->Session->read('with_esign');
		//$current_level = $this->Session->read('current_level');

		$file_path = $this->Customfunctions->pdfFilePath();
		$pdf_sign_status = $this->Session->read('pdf_sign_status'); // added on 25-08-2022 to check with eSign or without eSign

		//generatin pdf starts here
		//create new pdf using tcpdf including signature apprearence to generate its hash below
		require_once(ROOT . DS .'vendor' . DS . 'tcpdf' . DS . 'tcpdf.php');
		require_once(ROOT . DS .'vendor' . DS . 'tcpdf' . DS . 'tcpdf_text.php');
		// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// To use with watermark, use the overrided class that expects the same parameters that TCPDF
		// because the class simply extends the original
		$pdf = new PDF_Rotate(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// remove default header/footer
		// $pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		
		$pdf->SetFooterMargin(5);

		$pdf->SetFont('dejavuserifcondensed', '', 14);

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

		//only for save mode 'F' else no need in preview mode 'I'
		if($mode == 'F' && $pdf_sign_status == 'submit') {
			//to set signature content block in pdf
			$info = array();
			$pdf->my_set_sign('', '', '', '', 2, $info);
		}
		
		$pdf->SetMargins(10, 10, 10, 10);
		$pdf->AddPage();//print_r($html);exit;
		$pdf->writeHTML($html, true, false, true, false, '');

		//get signer details
		$login_user_type = $this->Session->read('loginusertype');
		if (in_array($login_user_type, array('authuser', 'enduser'))) {
			$esigner = $this->Session->read('user_first_name');
		} else {
			$esigner = $this->Session->read('mms_user_first_name');
		}
		$_SESSION['sign_timestamp'] = date('d/m/Y h:i:s A');
		//start to add bg image for the 'esigned by' cell on document
		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();		
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();
		//end to add bg image on cell

		//only for save mode 'F' else no need in preview mode 'I'
		//to show esigned by block on pdf
		if($mode == 'F') {
			if($pdf_sign_status == 'submit'){
				// set bacground image on cell
				$img_file = 'img/checked.png';
				$pdf->Image($img_file, 165, 266, 8, 8, '', '', '', false, 300, '', false, false, 0);
				// $pdf->Image($img_file, 65, 266, 8, 8, '', '', '', false, 300, '', false, false, 0);
				
				$pdf->SetFont('times', '', 8);
				$pdf->setCellPaddings(1, 2, 1, 1);
				$pdf->MultiCell(40, 10, 'Esigned by: '.$esigner."\n".'Date: '.$_SESSION['sign_timestamp'], 1, '', 0, 1, 150, 265, true);
				// $pdf->MultiCell(40, 10, 'Esigned by: '.'Test user 2'."\n".'Date: '.$_SESSION['sign_timestamp'], 1, '', 0, 1, 50, 265, true);
	
				// define active area for signature appearance
				$pdf->setSignatureAppearance(150, 265, 40, 10);
				// $pdf->setSignatureAppearance(50, 265, 40, 10);
			} else {
				// set bacground image on cell
				$img_file = 'img/checked2.png';
				$pdf->Image($img_file, 165, 266, 8, 8, '', '', '', false, 300, '', false, false, 0);
				
				$pdf->SetFont('times', '', 8);
				$pdf->setCellPaddings(1, 2, 1, 1);
				$pdf->MultiCell(40, 10, 'Approved by: '.$esigner."\n".'Date: '.$_SESSION['sign_timestamp'], 1, '', 0, 1, 150, 265, true);
			}
		}
		
		// reset pointer to the last page
		$pdf->lastPage();
		
		// Clean any content of the output buffer
		if(ob_get_length() > 0) {
			ob_end_clean();
		}

		//Close and output PDF document
		$pdf->my_output($file_path, $mode);
		//generatin pdf ends here	

	}
	
}    

?>