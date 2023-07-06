<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Controller\Component\ReporticoCustomComponent;
use Cake\Datasource\ConnectionManager;
use Reportico\Engine\Builder;

class ReportLMController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('ReporticoCustom');
        $this->loadModel('DirState');
        $this->loadModel('DirZone');
        $this->loadModel('Status');
        $this->loadModel('BusinessActivity');
        $this->loadModel('DirRegion');
        $this->loadModel('DirDistrict');
        $this->loadModel('OMineralIndustryInfo');
        $this->loadModel('TblEndUserFinalSubmit');
        $this->loadModel('DirMeMineral');
        $this->loadModel('McApplicantDet');
        $this->loadModel('NSeriesProdActivity');
        $this->loadModel('OSourceSupply');
        $this->loadModel('DirMineralGrade');
		$this->loadModel('OIndustry');
        $this->userSessionExits();
        $this->viewBuilder()->setLayout('mms_panel');
    }

    public function index()
    {
        $this->viewBuilder()->setLayout('mms_panel');
    }

    public function monthlyFilter()
    {
        $title = $this->request->getQuery('title');
        $this->set('title', $title);

        $this->viewBuilder()->setLayout('mms_panel');

        $queryZone = $this->DirZone->find('list', [
            'keyField' => 'zone_name',
            'valueField' => 'zone_name',
        ])
            ->select(['zone_name']);
        $zones = $queryZone->order('zone_name asc')->toArray();
        $this->set('zones', $zones);

        $queryStatus = $this->Status->find('list', [
            'keyField' => 'status_code',
            'valueField' => 'status_name',
        ])
            ->select(['status_name'])->where(['status_code !=' => 3]);
        $status = $queryStatus->toArray();
        $this->set('status', $status);

        $queryActivity = $this->BusinessActivity->find('list', [
            'keyField' => 'activity_code',
            'valueField' => 'activity_name',
        ])
            ->select(['activity_name'])->where(['activity_code !=' => 1]);
        $activity = $queryActivity->order('activity_name asc')->toArray();
        $this->set('activity', $activity);

        $queryState = $this->DirState->find('list', [
            'keyField' => 'state_code',
            'valueField' => 'state_name',
        ])
            ->select(['state_name']);
        $states = $queryState->order('state_name asc')->toArray();
        $this->set('states', $states);

        $queryIbmReg = $this->TblEndUserFinalSubmit->find('list', [
            'keyField' => 'ibm_unique_reg_no',
            'valueField' => 'ibm_unique_reg_no',
        ])
            ->select(['ibm_unique_reg_no'])->group(['ibm_unique_reg_no'])->order(['ibm_unique_reg_no' => 'ASC']);
        $ibmRegs = $queryIbmReg->toArray();
        $this->set('ibmRegs', $ibmRegs);

        $queryMineral = $this->DirMeMineral->find('list', [
            'keyField' => 'mineral_name',
            'valueField' => 'mineral_name',
        ])
            ->select(['mineral_name'])->order(['mineral_name' => 'ASC'])->where(['input_unit' => 'TONNE', 'output_unit' => 'TONNE']);
        $minerals = $queryMineral->toArray();
        $this->set('minerals', $minerals);

        $queryGrade = $this->DirMineralGrade->find('list', [
            'keyField' => 'id',
            'valueField' => 'grade_name',
        ])
            ->select(['grade_name'])->order(['grade_name' => 'ASC']);
        $grade = $queryGrade->toArray();
        $this->set('grade', $grade);

        $queryMinerals = $this->DirMeMineral->find('list', [
            'keyField' => 'mineral_name',
            'valueField' => 'mineral_name',
        ])
            ->select(['mineral_name'])->order(['mineral_name' => 'ASC']);
        $mineralsAll = $queryMinerals->toArray();
        $this->set('mineralsAll', $mineralsAll);

        $queryPlants = $this->OMineralIndustryInfo->find('list', [
            'keyField' => function ($row) {
                if ($row['plant_name2'] == 'NULL' || $row['plant_name2'] == '') {
                    $row['plant_name1'] = $row['plant_name1'] . '' . $row['plant_name2'];
                    return $row['plant_name1'];
                } else {
                    return $row['plant_name1'];
                }
            },
            'valueField' => function ($row) {
                if ($row['plant_name2'] == 'NULL' || $row['plant_name2'] == '') {
                    $row['plant_name1'] = $row['plant_name1'] . '' . $row['plant_name2'];
                    return $row['plant_name1'];
                } else {
                    return $row['plant_name1'];
                }
            }
        ])
            ->select(['plant_name1', 'plant_name2'])->order(['plant_name1' => 'ASC'])->group(['plant_name1']);
        $plants = $queryPlants->toArray();
        $this->set('plants', $plants);
    }

    public function annualFilter()
    {
        $title = $this->request->getQuery('title');
        $this->set('title', $title);

        $this->viewBuilder()->setLayout('mms_panel');

        $queryZone = $this->DirZone->find('list', [
            'keyField' => 'zone_name',
            'valueField' => 'zone_name',
        ])
            ->select(['zone_name']);
        $zones = $queryZone->order('zone_name asc')->toArray();
        $this->set('zones', $zones);

        $queryStatus = $this->Status->find('list', [
            'keyField' => 'status_code',
            'valueField' => 'status_name',
        ])
            ->select(['status_name'])->where(['status_code !=' => 3]);
        $status = $queryStatus->toArray();
        $this->set('status', $status);

        $queryActivity = $this->BusinessActivity->find('list', [
            'keyField' => 'activity_code',
            'valueField' => 'activity_name',
        ])
            ->select(['activity_name'])->where(['activity_code !=' => 1]);
        $activity = $queryActivity->order('activity_name asc')->toArray();
        $this->set('activity', $activity);

        $queryState = $this->DirState->find('list', [
            'keyField' => 'state_code',
            'valueField' => 'state_name',
        ])
            ->select(['state_name']);
        $states = $queryState->order('state_name asc')->toArray();
        $this->set('states', $states);

        // $queryRegion = $this->DirRegion->find('list', [
        //     'keyField' => 'region_name',
        //     'valueField' => 'region_name',
        // ])
        //     ->select(['region_name']);
        // $regions = $queryRegion->toArray();
        // $this->set('regions', $regions);

        $queryRegion = $this->DirDistrict->find('list', [
            'keyField' => 'region_code',
            'valueField' => 'region_name',
        ])
            ->select(['region_code', 'region_name'])->order(['region_name' => 'ASC']);
        $regions = $queryRegion->toArray();
        $this->set('regions', $regions);


        $queryIndustries = $this->OIndustry->find('list', [
            'keyField' => 'industry_name',
            'valueField' => 'industry_name'
        ])
            ->select(['industry_name'])->order(['industry_name' => 'ASC'])->group(['industry_name']);
        $industries = $queryIndustries->toArray();
		$industries ['other'] = 'Other';
        $this->set('industries', $industries);

        $queryIbmReg = $this->TblEndUserFinalSubmit->find('list', [
            'keyField' => 'applicant_id',
            'valueField' => 'applicant_id',
        ])
            ->select(['applicant_id'])->group(['applicant_id'])->order(['applicant_id' => 'ASC']);
        $ibmRegs = $queryIbmReg->toArray();
        $this->set('ibmRegs', $ibmRegs);

        $queryMineral = $this->DirMeMineral->find('list', [
            'keyField' => 'mineral_name',
            'valueField' => 'mineral_name',
        ])
            ->select(['mineral_name'])->order(['mineral_name' => 'ASC'])->where(['input_unit' => 'TONNE', 'output_unit' => 'TONNE']);
        $minerals = $queryMineral->toArray();
        $this->set('minerals', $minerals);

        $queryMinerals = $this->DirMeMineral->find('list', [
            'keyField' => 'mineral_name',
            'valueField' => 'mineral_name',
        ])
            ->select(['mineral_name'])->order(['mineral_name' => 'ASC']);
        $mineralsAll = $queryMinerals->toArray();
        $this->set('mineralsAll', $mineralsAll);

        $queryCompany = $this->McApplicantDet->find('list', [
            'keyField' => 'mcappd_concession_code',

            'valueField' => function ($row) {
                $company = $row['mcappd_fname'] . ' ' . $row['mcappd_mname'] . ' ' . $row['mcappd_lastname'];
                return $company;
            }
        ])
            ->select(['mcappd_concession_code', 'mcappd_fname', 'mcappd_mname', 'mcappd_lastname'])->order(['mcappd_fname' => 'ASC']);
        $company = $queryCompany->toArray();
        $this->set('company', $company);

        $queryGrade = $this->DirMineralGrade->find('list', [
            'keyField' => 'id',
            'valueField' => 'grade_name',
        ])
            ->select(['grade_name'])->order(['grade_name' => 'ASC']);
        $grade = $queryGrade->toArray();
        $this->set('grade', $grade);

        $querySupplier = $this->OSourceSupply->find('list', [
            'keyField' => 'ind_sup_name',
            'valueField' => 'ind_sup_name',
        ])
            ->select(['ind_sup_name'])->where(['ind_sup_name != ' => ''])->order(['ind_sup_name' => 'ASC']);
        $supplier = $querySupplier->toArray();
        $this->set('supplier', $supplier);

        $queryTransport = $this->OSourceSupply->find('list', [
            'keyField' => 'ind_trans_mode',
            'valueField' => 'ind_trans_mode',
        ])
            ->select(['ind_trans_mode'])->where(['ind_trans_mode != ' => 'nil'])->order(['ind_trans_mode' => 'ASC']);
        $transport = $queryTransport->toArray();
        $this->set('transport', $transport);

        $queryCountry = $this->OSourceSupply->find('list', [
            'keyField' => 'import_country',
            'valueField' => 'import_country',
        ])
            ->select(['import_country'])->where(['import_country != ' => ' '])->order(['import_country' => 'ASC']);
        $country = $queryCountry->toArray();
        $this->set('country', $country);

        $queryPlants = $this->OMineralIndustryInfo->find('list', [
            'keyField' => function ($row) {
                if ($row['plant_name2'] == 'NULL' || $row['plant_name2'] == '') {
                    $row['plant_name1'] = $row['plant_name1'] . '' . $row['plant_name2'];
                    return $row['plant_name1'];
                } else {
                    return $row['plant_name1'];
                }
            },
            'valueField' => function ($row) {
                if ($row['plant_name2'] == 'NULL' || $row['plant_name2'] == '') {
                    $row['plant_name1'] = $row['plant_name1'] . '' . $row['plant_name2'];
                    return $row['plant_name1'];
                } else {
                    return $row['plant_name1'];
                }
            }
        ])
            ->select(['plant_name1', 'plant_name2'])->order(['plant_name1' => 'ASC'])->group(['plant_name1']);
        $plants = $queryPlants->toArray();
        $this->set('plants', $plants);
    }

    public function reportM02()
    {
		$this->viewBuilder()->setLayout('report_layout');
		
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $month = $this->request->getData('month');
            $year = $this->request->getData('year');
            $business = $this->request->getData('business');
            $zone = $this->request->getData('zone');

            $region = $this->request->getData('region');
            $region = explode('-', $region);
            $region = $region[0];
            if (strlen($region) == 1) {
                $region = $region;
            }

            $state = $this->request->getData('state');

            $district = $this->request->getData('district');
            $district = explode('-', $district);
            $district = $district[0];

            $status = $this->request->getData('status');
            $date = $month . '-' . $year;
            $date = $this->ReporticoCustom->changeReportDateFormat($date);

            $businessName = $this->BusinessActivity
                ->find()
                ->where(['activity_code' => $business])
                ->first();

            $statusName = $this->Status
                ->find()
                ->where(['status_code' => $status])
                ->first();


			$con = ConnectionManager::get('default');
			$con->execute("CALL SP_not_submitted_returns('$returnType','$date')");
			$con->execute("CALL sp_lm_report_a02('$returnType','$status','$date','$business','$state','$district','$region')");
			
			$query =  $con->execute("SELECT * FROM view_lm_report_a02");
			$records = $query->fetchAll('assoc');
			
           // $query = ReporticoCustomComponent::getReportM02RegionWise($returnType, $status, $date, $business, $state, $district, $region);
            if ($returnType == 'MONTHLY') {
                $month = explode('-', $month);
                $month = $month[1];
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($date));
                $report = 'Returns ' . $statusName['status_name'] . ' for ' . $businessName['activity_name'] . ' Status Report for the Month of ' . $displayDate;
            }
			
			$this->set('records',$records);
            $this->set('report',$report);
            
        }
    }

    public function reportA03()
    {
		$this->viewBuilder()->setLayout('report_layout');
		
        if ($this->request->is('post')) {

            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $business = $this->request->getData('business');
            $zone = $this->request->getData('zone');

            $region = $this->request->getData('region');
            $region = explode('-', $region);
            $region = $region[0];
            if (strlen($region) == 1) {
                $region = $region;
            }

            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $district = explode('-', $district);
            $district = $district[0];
            $status = $this->request->getData('status');
            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $businessName = $this->BusinessActivity
                ->find()
                ->where(['activity_code' => $business])
                ->first();

            $statusName = $this->Status
                ->find()
                ->where(['status_code' => $status])
                ->first();

			$con = ConnectionManager::get('default');
			$con->execute("CALL SP_not_submitted_returns('$returnType','$from_date')");
			$con->execute("CALL sp_lm_report_a02('$returnType','$status','$from_date','$business','$state','$district','$region')");
			
			$query =  $con->execute("SELECT * FROM view_lm_report_a02");
			$records = $query->fetchAll('assoc');
			
            //$query = ReporticoCustomComponent::getReportA03RegionWise($returnType, $status, $from_date, $business, $state, $district, $region);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Returns ' . $statusName['status_name'] . ' for ' . $businessName['activity_name'] . ' Status Report for ' . $displayDate;
            }
			
            $this->set('records',$records);
            $this->set('report',$report); 
        }
    }

    public function reportM04()
    {
		$this->viewBuilder()->setLayout('report_layout');
		
        if ($this->request->is('post')) {

            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $month = $this->request->getData('month');
            $year = $this->request->getData('year');
            $business = $this->request->getData('business');
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $district = explode('-', $district);
            $district = $district[0];
            $status = $this->request->getData('status');
            $date = $month . '-' . $year;
            $date = $this->ReporticoCustom->changeReportDateFormat($date);

            $businessName = $this->BusinessActivity
                ->find()
                ->where(['activity_code' => $business])
                ->first();

            $statusName = $this->Status
                ->find()
                ->where(['status_code' => $status])
                ->first();
			
			$con = ConnectionManager::get('default');
			$con->execute("CALL SP_not_submitted_returns('$returnType','$date')");
			$con->execute("CALL sp_lm_report_a02('$returnType','$status','$date','$business','$state','$district','')");
			
			$query =  $con->execute("SELECT * FROM view_lm_report_a02");
			$records = $query->fetchAll('assoc');
			
            //$query = ReporticoCustomComponent::getReportM04StateWise($returnType, $status, $date, $business, $state, $district);
            if ($returnType == 'MONTHLY') {
                $month = explode('-', $month);
                $month = $month[1];
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($date));
                $report = 'Returns ' . $statusName['status_name'] . ' for ' . $businessName['activity_name'] . ' Status Report for the Month of ' . $displayDate;
            }
			
			$this->set('records',$records);
            $this->set('report',$report);  
            
        }
    }

    public function reportA05()
    {
		$this->viewBuilder()->setLayout('report_layout');
		
        if ($this->request->is('post')) {

            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $business = $this->request->getData('business');
            $zone = $this->request->getData('zone');
            $region = $this->request->getData('region');
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');
            $district = explode('-', $district);
            $district = $district[0];
            $status = $this->request->getData('status');
            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $businessName = $this->BusinessActivity
                ->find()
                ->where(['activity_code' => $business])
                ->first();

            $statusName = $this->Status
                ->find()
                ->where(['status_code' => $status])
                ->first();
			
			$con = ConnectionManager::get('default');
			$con->execute("CALL SP_not_submitted_returns('$returnType','$from_date')");
			$con->execute("CALL sp_lm_report_a02('$returnType','$status','$from_date','$business','$state','$district','')");
			
			$query =  $con->execute("SELECT * FROM view_lm_report_a02");
			$records = $query->fetchAll('assoc');
			
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Returns ' . $statusName['status_name'] . ' for ' . $businessName['activity_name'] . ' Status Report for ' . $displayDate;
            }
			
			$this->set('records',$records);
            $this->set('report',$report);           
        }
    }

    public function reportA06()
    {
		$this->viewBuilder()->setLayout('report_layout');
		
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
			
			if(!empty($this->request->getData('region'))){
				$region = implode(',', $this->request->getData('region'));
			}else{
				$region = "";
			}
            
			if(!empty($this->request->getData('ibm'))){
				$registration_nos = implode(',', $this->request->getData('ibm'));
			}else{
				$registration_nos = "";
			}
			
            $industry = $this->request->getData('industry');
            

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);
			
			//print_r("CALL sp_lm_report_a07('$returnType','','$registration_nos','$region','$from_date','$industry')"); exit;
			
			$con = ConnectionManager::get('default');
			$con->execute("CALL sp_lm_report_a07('$returnType','','$registration_nos','$region','$from_date','$industry')");
			
			$query =  $con->execute("SELECT * FROM view_lm_report_a07");
			$records = $query->fetchAll('assoc');

            //$query = ReporticoCustomComponent::getReportA06PlantWiseIndustryRegionWise($returnType, $from_date, $region, $industry, $ibm);
           
		   if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Plant wise installed capacity Report for ' . $displayDate;
            }
			
			$this->set('records',$records);
            $this->set('report',$report);           
            
        }
    }

    public function reportA07()
    {
		$this->viewBuilder()->setLayout('report_layout');
		
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            //$state = $this->request->getData('state');
            $industry = $this->request->getData('industry');
            //$ibm = $this->request->getData('ibm');
			
			if(!empty($this->request->getData('state'))){
				$state = implode(',', $this->request->getData('state'));
			}else{
				$state = "";
			}
            
			if(!empty($this->request->getData('ibm'))){
				$registration_nos = implode(',', $this->request->getData('ibm'));
			}else{
				$registration_nos = "";
			}
			

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

			$con = ConnectionManager::get('default');
			$con->execute("CALL sp_lm_report_a07('$returnType','$state','$registration_nos','','$from_date','$industry')");
			
			$query =  $con->execute("SELECT * FROM view_lm_report_a07");
			$records = $query->fetchAll('assoc');
			
            //$query = ReporticoCustomComponent::getReportA07PlantWiseIndustryStateWise($returnType, $from_date, $state, $industry, $ibm);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Plant wise installed capacity Report for ' . $displayDate;
            }
            
			$this->set('records',$records);
            $this->set('report',$report);
        }
    }

    public function reportA08()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }
            
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $ibm = $this->request->getData('ibm');
            $business = $this->request->getData('business');
            $status = $this->request->getData('status');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $businessName = $this->BusinessActivity
                ->find()
                ->where(['activity_code' => $business])
                ->first();

            $query = ReporticoCustomComponent::getReportA08SubmissionForRegNo($returnType, $from_date, $status, $business, $ibm);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Report  for ' . $businessName['activity_name'] . '  Registration Number for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT fname, mname, lname, address1, address2, address3,  applicant_id, email, status_name, plant_name FROM temp_reportico_report_A08";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT fname, mname, lname, address1, address2, address3,  applicant_id, email, status_name, plant_name FROM temp_reportico_report_A08")

                    ->expression("fullname")
                    ->set("{fname}.' '.{mname}.' '.{lname}")
                    ->expression("address")
                    ->set("{address1}.' '.{address2}.' '.{address3}")

                    ->column("fullname")->justify("center")->label("Name of Company")
                    ->column("plant_name")->justify("center")->label("Plant Name / Storage location")
                    ->column("address")->justify("center")->label("Address of Plant")
                    ->column("email")->justify("center")->label("Email Id")
                    ->column("status_name")->justify("center")->label("Status of return")
                    ->column('fname')->hide()
                    ->column('mname')->hide()
                    ->column('lname')->hide()
                    ->column('address1')->hide()
                    ->column('address2')->hide()
                    ->column('address3')->hide()

                    ->to($reportAction) //Auto download excel file

                    ->group("applicant_id")
                    ->header("applicant_id")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA09()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $ibm = $this->request->getData('ibm');
            $business = $this->request->getData('business');
            $region = $this->request->getData('region');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $businessName = $this->BusinessActivity
                ->find()
                ->where(['activity_code IN' => $business])
                ->all();

            $query = ReporticoCustomComponent::getReportA09CompanywiseActivtyRegionwise($returnType, $from_date, $business, $region, $ibm);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Report  for company-wise plant / storage location details ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id, region, activity_name, region_total, region_outof,fname, mname, lname,plant_name,address1, address2, address3, email FROM temp_reportico_report_A09";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id, region, activity_name, region_total, region_outof,fname, mname, lname,plant_name,address1, address2, address3, email FROM temp_reportico_report_A09")

                    ->expression("fullname")
                    ->set("{fname}.' '.{mname}.' '.{lname}")
                    ->expression("address")
                    ->set("{address1}.' '.{address2}.' '.{address3}")

                    ->column("fullname")->justify("center")->label("Name of Company")
                    ->column("plant_name")->justify("center")->label("Name of Plant / Storage Location")
                    ->column("address")->justify("center")->label("Address of Plant")
                    ->column("email")->justify("center")->label("Email Id")
                    ->column("applicant_id")->justify("center")->label("IBM Registration No")
                    ->column('activity_name')->justify("center")->label("Business Activity")
                    ->column('fname')->hide()
                    ->column('mname')->hide()
                    ->column('lname')->hide()
                    ->column('address1')->hide()
                    ->column('address2')->hide()
                    ->column('address3')->hide()
                    ->column('region_total')->hide()
                    ->column('region_outof')->hide()

                    ->to($reportAction) //Auto download excel file

                    ->group("region")
                    ->header("region")

                    ->group("region_total")
                    ->group("region_outof")
                    ->customTrailer("{region} ", "font-size:14px;font-weight:bold;color:#003F87; padding-bottom:80px;margin-top:40px")
                    ->customTrailer("Total Region {region_total} out of {region_outof}", " color: #000;  right: 0px; margin-left: auto;  width: 29%; padding-bottom: 80px;margin-top:50px;")

                    ->group("applicant_id")
                    ->header("applicant_id")

                    ->group("activity_name")
                    ->header("activity_name")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA10()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $ibm = $this->request->getData('ibm');
            $business = $this->request->getData('business');
            $state = $this->request->getData('state');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA10CompanywiseActivtyStatewise($returnType, $from_date, $business, $state, $ibm);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Report  for Company wise plant details ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT fname, mname, lname, address1, address2, address3,  applicant_id, email, state_name, activity_name, state_total, state_outof, plant_name FROM temp_reportico_report_A10";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT fname, mname, lname, address1, address2, address3,  applicant_id, email, state_name, activity_name, state_total, state_outof, plant_name FROM temp_reportico_report_A10")

                    ->expression("fullname")
                    ->set("{fname}.' '.{mname}.' '.{lname}")
                    ->expression("address")
                    ->set("{address1}.' '.{address2}.' '.{address3}")

                    ->column("fullname")->justify("center")->label("Name of Company")
                    ->column("plant_name")->justify("center")->label("Name of plant/storage location")
                    ->column("address")->justify("center")->label("Address of Plant")
                    ->column("email")->justify("center")->label("Email Id")
                    ->column("applicant_id")->justify("center")->label("IBM Registration No")
                    ->column('activity_name')->justify("center")->label("Business Activity")
                    ->column('fname')->hide()
                    ->column('mname')->hide()
                    ->column('lname')->hide()
                    ->column('address1')->hide()
                    ->column('address2')->hide()
                    ->column('address3')->hide()
                    ->column('state_total')->hide()
                    ->column('state_outof')->hide()

                    ->to($reportAction) //Auto download excel file

                    ->group("state_name")
                    ->header("state_name")

                    ->group("applicant_id")
                    ->header("applicant_id")

                    ->group("activity_name")
                    ->header("activity_name")

                    ->group("state_total")
                    ->group("state_outof")
                    ->customTrailer("{state_name} ", "font-size:14px;font-weight:bold;color:#003F87; padding-bottom:50px;margin-top:20px")
                    ->customTrailer("Total State {state_total} out of {state_outof}", " color: #000;  right: 0px; margin-left: auto;  width: 29%; padding-bottom: 50px;margin-top:30px;")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA11()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $business = $this->request->getData('business');
            $region = $this->request->getData('region');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $businessName = $this->BusinessActivity
                ->find()
                ->where(['activity_code' => $business])
                ->first();

            $query = ReporticoCustomComponent::getReportA11RegionwisePercentageStatus($returnType, $from_date, $business, $region);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Report status percentage for ' . $businessName['activity_name'] . ' ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT company, registered_activity, return_status, received, region FROM temp_reportico_report_A11";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT company, registered_activity, return_status, received, region FROM temp_reportico_report_A11")

                    ->column("company")->justify("center")->label("No. of Registered Company")
                    ->column("registered_activity")->justify("center")->label("Nos. of Registered Plant/Storage Location (for selected business activity)")
                    ->column("return_status")->justify("center")->label("Nos. of Returns Received for Plant/Storage Location (for selected business activity)")
                    ->column("received")->justify("center")->label("% Received")

                    ->to($reportAction) //Auto download excel file

                    ->group("region")
                    ->header("region")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA12()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $business = $this->request->getData('business');
            $state = $this->request->getData('state');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $businessName = $this->BusinessActivity
                ->find()
                ->where(['activity_code' => $business])
                ->first();

            $query = ReporticoCustomComponent::getReportA12StatewisePercentageStatus($returnType, $from_date, $business, $state);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Report status percentage for ' . $businessName['activity_name'] . ' ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT company, registered_activity, return_status, received, state FROM temp_reportico_report_A12";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT company, registered_activity, return_status, received, state FROM temp_reportico_report_A12")

                    ->column("company")->justify("center")->label("No. of Registered Company")
                    ->column("registered_activity")->justify("center")->label("Nos. of Registered Plant/Storage Location (for selected business activity)")
                    ->column("return_status")->justify("center")->label("Nos. of Returns Received for Plant/Storage Location (for selected business activity)")
                    ->column("received")->justify("center")->label("% Received")

                    ->to($reportAction) //Auto download excel file

                    ->group("state")
                    ->header("state")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportM13()
    {
		$this->viewBuilder()->setLayout('report_layout');
		
        if ($this->request->is('post')) {
			
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_month = $this->request->getData('from_month');
            $to_month = $this->request->getData('to_month');
            $year = $this->request->getData('year');
            $mineral = $this->request->getData('mineral');
           // $ibm = $this->request->getData('ibm');
			
			if(!empty($this->request->getData('ibm'))){
				$registration_nos = implode(',', $this->request->getData('ibm'));
			}else{
				$registration_nos = "";
			}
			
            $from_date = $from_month . '-' . $year;
            $to_date = $to_month . '-' . $year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);
            $to_date = $this->ReporticoCustom->changeReportDateFormat($to_date);
			
			$con = ConnectionManager::get('default');
			$con->execute("CALL sp_lm_report_a13('$returnType','$registration_nos','$from_date','$to_date','$mineral')");
			
			$query =  $con->execute("SELECT * FROM view_lm_report_a13");
			$records = $query->fetchAll('assoc');

            //$query = ReporticoCustomComponent::getReportM13EnduseConsumption($returnType, $from_date, $to_date, $mineral, $ibm);
			
            if ($returnType == 'MONTHLY') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $displayDate = " from $displayDate " . "to " . date('F Y', strtotime($to_date));
                $report = 'End Use Mineral Consumption for ' . $displayDate;
            }
			
			$this->set('records',$records);
            $this->set('report',$report);		
			
        }
    }

    public function reportA14()
    {
		$this->viewBuilder()->setLayout('report_layout');
		
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }
				
            
			$report_query = "SELECT tfs.*,ormc.mineral_name,ormc.prev_ind_year,ormc.prev_imp_year,ormc.pres_ind_year,ormc.pres_inm_year
									FROM view_lm_report_a07 tfs
									LEFT JOIN o_raw_mat_consume ormc ON ormc.end_user_id = tfs.applicant_id and ormc.return_type = tfs.return_type and ormc.return_date = tfs.return_date and ormc.srno = tfs.srno 
							where 1=1
							";

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
			
            if(!empty($this->request->getData('state'))){
				$state = implode(',', $this->request->getData('state'));				
			}else{
				$state = "";
			}
			
			if(!empty($this->request->getData('district'))){
				$districts = implode(',', $this->request->getData('district'));
				$report_query .= "AND FIND_IN_SET(tfs.district_code,'".$districts."' )";
			}else{
				$districts = "";
			}
			
			if(!empty($this->request->getData('ibm'))){
				$registration_nos = implode(',', $this->request->getData('ibm'));
				$report_query .= "AND FIND_IN_SET(tfs.concession_code,'".$registration_nos."' )";
			}else{
				$registration_nos = "";
			}
			
			if(!empty($this->request->getData('company'))){
				$company_names_filter = array_filter(array_map('trim', $this->request->getData('company')), 'strlen');
				$company_names = implode(',',$company_names_filter);
				$report_query .= "AND FIND_IN_SET(tfs.fname,'".$company_names."' )";
			}else{
				$company_names = "";
			}
			
			if(!empty($this->request->getData('plant'))){
				$plant_names_filter = array_filter(array_map('trim', $this->request->getData('plant')), 'strlen');
				$plant_names = implode(',', $plant_names_filter);
				$report_query .= "AND FIND_IN_SET(tfs.address1,'".$plant_names."' )";
			}else{
				$plant_names = "";
			}
			
			$report_query .= "order by tfs.return_date,tfs.applicant_id,tfs.srno";

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);
			
			//print_r("CALL sp_lm_report_a07('$returnType','$state','$registration_nos','','$from_date','')"); exit;	
			
			$con = ConnectionManager::get('default');
			$con->execute("CALL sp_lm_report_a07('$returnType','$state','$registration_nos','','$from_date','')");
			
						
			$query =  $con->execute($report_query);
			$records = $query->fetchAll('assoc');
			

            //$query = ReporticoCustomComponent::getReportA14StatewiseProductMineralConsumption($returnType, $from_date, $plant);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Report for State wise Production of product and Mineral Consumption Report ' . $displayDate;
            }
			
			$this->set('records',$records);
            $this->set('report',$report);
            
        }
    }

    public function reportA15()
    {
		$this->viewBuilder()->setLayout('report_layout');
		
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

			
            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
			$to_year = $this->request->getData('to_year');
            $mineral_name = $this->request->getData('mineral');
			
			if(!empty($this->request->getData('industry'))){
				$industry_name = implode(',', $this->request->getData('industry'));
			}else{
				$industry_name = "";
			}

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);
			
			$to_date = '01-04' . '-' . $to_year;
            $to_date = $this->ReporticoCustom->changeReportDateFormat($to_date);
			
			$dateRange = $to_year - $from_year;
			
			$year1 = ''; $year2 = ''; $year3 = ''; $year4 = ''; $year5 = ''; 
			$year6 = ''; $year7 = ''; $year8 = ''; $year9 = ''; $year10 = ''; 
			
			//print_r($dateRange); exit;
			
			$i = 1; $j = 0;
			while($i <= $dateRange+1){
				
				switch ($i) {
					case 1 :
					$year1 = ($from_year + $j).'-'.'04-01';
					break;
					case 2 :
					$year2 = ($from_year + $j).'-'.'04-01';
					break;
					case 3 :
					$year3 = ($from_year + $j).'-'.'04-01';
					break;
					case 4 :
					$year4 = ($from_year + $j).'-'.'04-01';
					break;
					case 5 :
					$year5 = ($from_year + $j).'-'.'04-01';
					break;
					case 6 :
					$year6 = ($from_year + $j).'-'.'04-01';
					break;
					case 7 :
					$year7 = ($from_year + $j).'-'.'04-01';
					break;
					case 8 :
					$year8 = ($from_year + $j).'-'.'04-01';
					break;
					case 9 :
					$year9 = ($from_year + $j).'-'.'04-01';
					break;
					case 10 :
					$year10 = ($from_year + $j).'-'.'04-01';
					break;
				}
				
				$i++;
				$j++;
			}
			
			/*print_r("CALL sp_lm_report_a15('$mineral_name','$industry_name','$from_date','$to_date',
												 '$year1','$year2','$year3','$year4','$year5',
												 '$year6','$year7','$year8','$year9','$year10')") ; exit;*/
			
			$con = ConnectionManager::get('default');
			$query = $con->execute("CALL sp_lm_report_a15('$mineral_name','$industry_name','$from_date','$to_date','$year1','$year2','$year3','$year4','$year5','$year6','$year7','$year8','$year9','$year10')");
			$records = $query->fetchAll('assoc');
			
            //$query = ReporticoCustomComponent::getReportA15MineralwiseEnduse($returnType, $from_date, $mineral, $industry);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Report for Mineral wise End use Mineral Consumption for ' . $displayDate;
                $nextYear = date("y", strtotime($from_date));
                $nextYear = $nextYear + 1;
                $dateColumn = date("Y", strtotime($from_date)) . "-" . $nextYear;
            }
			
			$this->set('records',$records);
            $this->set('report',$report);
			$this->set('daterange',$dateRange);
			$this->set('from_year',$from_year);
            
        }
    }

    public function reportA16()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $mineral = $this->request->getData('mineral');
            $industry = $this->request->getData('industry');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA16MineralwiseEnduse($returnType, $from_date, $mineral, $industry);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));

                $report = 'Report for Industry wise End use Mineral Consumption for ' . $displayDate;

                $nextYear = date("y", strtotime($from_date));
                $nextYear = $nextYear + 1;

                $dateColumn = date("Y", strtotime($from_date)) . "-" . $nextYear;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");


            $con = ConnectionManager::get('default');
            $sql = "SELECT industry, local_mineral_code AS Mineral, sum_quantity FROM temp_reportico_report_A16";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT industry, local_mineral_code AS Mineral, sum_quantity FROM temp_reportico_report_A16")

                    ->column("Mineral")->justify("center")
                    ->column("sum_quantity")->justify("center")->label($dateColumn)

                    ->to($reportAction) //Auto download excel file

                    ->group("industry")
                    ->header("industry")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA17()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_month = $this->request->getData('from_month');
            $from_year = $this->request->getData('from_year');
            $to_month = $this->request->getData('to_month');
            $mineral = $this->request->getData('mineral');
            $ibm = $this->request->getData('ibm');

            if ($from_month == '01-01' || $from_month == '01-02' || $from_month == '01-03') {
                $from_date = $from_month . '-' . $from_year + 1;
                $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);
            }
            if ($to_month == '01-01' || $to_month == '01-02' || $to_month == '01-03') {
                $to_date = $to_month . '-' . $from_year + 1;
                $to_date = $this->ReporticoCustom->changeReportDateFormat($to_date);
            }
            if ($from_month == '01-04' || $from_month == '01-05' || $from_month == '01-06' || $from_month == '01-07' || $from_month == '01-08' || $from_month == '01-09' || $from_month == '01-10' || $from_month == '01-11' || $from_month == '01-12') {
                $from_date = $from_month . '-' . $from_year;
                $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);
            }
            if ($to_month == '01-04' || $to_month == '01-05' || $to_month == '01-06' || $to_month == '01-07' || $to_month == '01-08' || $to_month == '01-09' || $to_month == '01-10' || $to_month == '01-11' || $to_month == '01-12') {
                $to_date = $to_month . '-' . $from_year;
                $to_date = $this->ReporticoCustom->changeReportDateFormat($to_date);
            }
            $query = ReporticoCustomComponent::getReportA17MonthlyVsYearlyEnduse($returnType, $from_date, $to_date, $mineral, $ibm);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $displayDate = " from $displayDate " . "to " . date('F Y', strtotime($to_date));
                $report = 'Report for End Use Mineral Consumption Monthly V/s Yearly Report for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");


            $con = ConnectionManager::get('default');
            $sql = "SELECT ibm AS IBM_Registration_Number,company, plant_name, address, mineral_name, monthly_quantity, annual_quantity FROM temp_reportico_report_A17";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT ibm AS IBM_Registration_Number,company, plant_name, address, mineral_name, monthly_quantity, annual_quantity FROM temp_reportico_report_A17")

                    ->column("company")->justify("center")->label("Name of Company")
                    ->column("plant_name")->justify("center")->label("Name of Plant / Storage Location")
                    ->column("address")->justify("center")->label("Addres of Plant / Storage Location")
                    ->column("monthly_quantity")->justify("center")->label("Mineral Ore Consumed in Tonnes (Monthly)")
                    ->column("annual_quantity")->justify("center")->label("Mineral Ore Consumed in Tonnes (Annual)")

                    ->to($reportAction) //Auto download excel file

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("IBM_Registration_Number")
                    ->header("IBM_Registration_Number")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA18()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $mineral = $this->request->getData('mineral');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA18CostMineralVsIndigenous($returnType, $from_date, $mineral);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Report for Cost of Mineral Imported v/s Indigenous for ' . $displayDate;
            }

            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id, plant_name, ind_price, import_cost, difference_cost, mineral_name FROM temp_reportico_report_A18";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id, plant_name, ind_price, import_cost, difference_cost, mineral_name FROM temp_reportico_report_A18")

                    ->column("applicant_id")->justify("center")->label("IBM Registration No")
                    ->column("plant_name")->justify("center")->label("Name of Plant")
                    ->column("ind_price")->justify("center")->label("Cost of Mineral Indigenous")
                    ->column("import_cost")->justify("center")->label("Cost of Mineral Imported")
                    ->column("difference_cost")->justify("center")->label("Difference")

                    ->to($reportAction) //Auto download excel file

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("applicant_id")
                    ->header("applicant_id")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA19()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $mineral = $this->request->getData('mineral');
            $from_year = $this->request->getData('from_year');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA19MineralewiseTransportationCost($returnType, $from_date, $mineral);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Report for Cost of Mineral Imported v/s Indigenous for ' . $displayDate;
            }

            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id, plant_name, ind_trans_cost, ind_distance, ind_price, landing_cost, mineral_name FROM temp_reportico_report_A19";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id, plant_name, ind_trans_cost, ind_distance, ind_price, landing_cost, mineral_name FROM temp_reportico_report_A19")

                    ->column("applicant_id")->justify("center")->label("IBM Registration No")
                    ->column("plant_name")->justify("center")->label("Name of Plant")
                    ->column("ind_trans_cost")->justify("center")->label("Cost of Transportation")
                    ->column("ind_distance")->justify("center")->label("Average Distance")
                    ->column("ind_price")->justify("center")->label("Cost of Mineral")
                    ->column("landing_cost")->justify("center")->label("Landing Cost of Mineral")

                    ->to($reportAction) //Auto download excel file

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("applicant_id")
                    ->header("applicant_id")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA20()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $company = $this->request->getData('company');
            $from_year = $this->request->getData('from_year');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA20TransportationCostForRegNo($returnType, $from_date, $company);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = '	Transportation Cost for Registration Number for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id, plant_name, ind_trans_cost, ind_distance, ind_price, landing_cost,company FROM temp_reportico_report_A20";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id, plant_name, ind_trans_cost, ind_distance, ind_price, landing_cost,company FROM temp_reportico_report_A20")

                    ->column("applicant_id")->justify("center")->label("IBM Registration No")
                    ->column("plant_name")->justify("center")->label("Name of Plant")
                    ->column("ind_trans_cost")->justify("center")->label("Cost of Transportation")
                    ->column("ind_distance")->justify("center")->label("Average Distance")
                    ->column("ind_price")->justify("center")->label("Cost of Mineral")
                    ->column("landing_cost")->justify("center")->label("Landing Cost of Mineral")

                    ->to($reportAction) //Auto download excel file

                    ->group("company")
                    ->header("company")

                    ->group("applicant_id")
                    ->header("applicant_id")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA21()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $mineral = $this->request->getData('mineral');
            $from_year = $this->request->getData('from_year');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA21SectorwiseMineralConsumptionStatewise($returnType, $from_date, $mineral);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = '	Sector-wise Mineral Consumption Report (State-wise) for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT company, mineral_name, state_name, total_quantity, total_consumed, state_total, state_outof FROM temp_reportico_report_A21 WHERE company != ''";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT company, mineral_name, state_name, total_quantity, total_consumed, state_total, state_outof FROM temp_reportico_report_A21 WHERE company != ''")

                    ->column("company")->justify("center")->label("Name of Company")
                    ->column("total_quantity")->justify("center")->label("Total Quantity Purchased / Procured / Imported")
                    ->column("total_consumed")->justify("center")->label(" Quantity Consumed")
                    ->column("state_total")->hide()
                    ->column("state_outof")->hide()

                    ->to($reportAction) //Auto download excel file

                    ->expression("total_qt")->sum("total_quantity", "state_name")
                    ->expression("total_con")->sum("total_consumed", "state_name")

                    ->group("state_name")
                    ->header("state_name")

                    ->group("state_total")
                    ->group("state_outof")
                    ->customTrailer("{state_name} ", "font-size:14px;font-weight:bold;color:#003F87; padding-bottom:80px;margin-top:40px")
                    ->customTrailer("Total State {state_total} out of {state_outof}", "color: #000;  right: 0px; margin-left: auto;  width: 29%; padding-bottom: 80px;margin-top:50px;")

                    ->group("mineral_name")
                    ->header("mineral_name")
                    ->trailer("total_qt")->below("total_quantity")->label("Total Quantity : ")

                    // ->customTrailer("{mineral_name} ", "font-size:14px;font-weight:bold;color:#003F87; padding-bottom:50px;margin-top:20px")
                    // ->customTrailer("Total Quantity for {mineral_name} is {total_qt}", "color: #000;  right: 0px; margin-left: auto;  width: 29%; padding-bottom: 50px;margin-top:30px;")

                    ->trailer("total_con")->below("total_consumed")->label("Total Consumed : ")
                    // ->customTrailer("{mineral_name} ", "font-size:14px;font-weight:bold;color:#003F87;")
                    // ->customTrailer("Total Consumed for {mineral_name} is {total_con}", "color: #000;  right: 0px; margin-left: auto;  width: 30%; padding: 10px;")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA22()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $mineral = $this->request->getData('mineral');
            $from_year = $this->request->getData('from_year');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA22SectorwiseMineralConsumptionRegionwise($returnType, $from_date, $mineral);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = '	Sector-wise Mineral Consumption Report (Region-wise) for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT company, region_name, mineral_name, total_quantity, total_consumed, region_total, region_outof FROM temp_reportico_report_A22 WHERE company != ''";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT company, region_name, mineral_name, total_quantity, total_consumed, region_total, region_outof FROM temp_reportico_report_A22 WHERE company != ''")

                    ->column("company")->justify("center")->label("Name of Company")
                    ->column("total_quantity")->justify("center")->label("Total Quantity Purchased / Procured/ Imported")
                    ->column("total_consumed")->justify("center")->label("Quantity Consumed")
                    ->column("region_total")->hide()
                    ->column("region_outof")->hide()

                    ->to($reportAction) //Auto download excel file

                    ->expression("total_qt")->sum("total_quantity", "region_name")
                    ->expression("total_con")->sum("total_consumed", "region_name")

                    ->group("region_name")
                    ->header("region_name")

                    ->group("region_total")
                    ->group("region_outof")
                    ->customTrailer("{region_name} ", "font-size:14px;font-weight:bold;color:#003F87; padding-bottom:80px;margin-top:40px")
                    ->customTrailer("Total Region {region_total} out of {region_outof}", "color: #000;  right: 0px; margin-left: auto;  width: 29%; padding-bottom: 80px;margin-top:50px;")

                    ->group("mineral_name")
                    ->header("mineral_name")
                    ->trailer("total_qt")->below("total_quantity")->label("Total Quantity : ")

                    // ->customTrailer("{mineral_name} ", "font-size:14px;font-weight:bold;color:#003F87; padding-bottom:50px;margin-top:20px")
                    // ->customTrailer("Total Quantity for {mineral_name} is {total_qt}", "color: #000;  right: 0px; margin-left: auto;  width: 29%; padding-bottom: 50px;margin-top:30px;")

                    ->trailer("total_con")->below("total_consumed")->label("Total Consumed : ")
                    // ->customTrailer("{mineral_name} ", "font-size:14px;font-weight:bold;color:#003F87;")
                    // ->customTrailer("Total Consumed for {mineral_name} is {total_con}", "color: #000;  right: 0px; margin-left: auto;  width: 30%; padding: 10px;")


                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA23()
    {
		$this->viewBuilder()->setLayout('report_layout');
		
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
			           
			if(!empty($this->request->getData('industry'))){
				$industry = implode(',', $this->request->getData('industry'));				
			}else{
				$industry = "";
			}
			
			if(!empty($this->request->getData('state'))){
				$states_name = implode(',', $this->request->getData('state'));				
			}else{
				$states_name = "";
			}
			
			$con = ConnectionManager::get('default');
			$query = $con->execute("CALL sp_lm_report_a23('$returnType','$industry','$states_name')");
			$records = $query->fetchAll('assoc');
			
            //$query = ReporticoCustomComponent::getReportA23IndustrywisePlant($returnType, $from_date, $industry);
           
		   if ($returnType == 'ANNUAL') {               
                $report = '	Industry-wise List of Plants for ' . $industry;
            }
			
			$this->set('records',$records);
            $this->set('report',$report);
        }
    }

    public function reportA24()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $mineral = $this->request->getData('mineral');
            $grade = $this->request->getData('grade');
            $state = $this->request->getData('state');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA24MaterTradingActivity($returnType, $from_date, $mineral, $grade, $state);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Master Report for Trading Activity for' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, district, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_A24";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, district, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_A24")

                    ->column("plant_name")->justify("center")->label("Plant name / Storage Location")
                    ->column("opening_stock")->justify("center")->label("Opening Stock (Quantity)")
                    ->column("ore_purchased_quantity")->justify("center")->label("Ore Purchased (Quantity)")
                    ->column("ore_purchased_value")->justify("center")->label("Ore Purchased (Value)")
                    ->column("ore_import_quantity")->justify("center")->label("Ore Import (Quantity)")
                    ->column("ore_import_value")->justify("center")->label("Ore Import (Value)")
                    ->column("ore_dispatched_quantity")->justify("center")->label("Ore Dispatched (Quantity)")
                    ->column("ore_dispatched_value")->justify("center")->label("Ore Dispatched (Value)")
                    ->column("closing_stock")->justify("center")->label("CLosing Stock (Quantity)")

                    ->to($reportAction) //Auto download excel file
                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("mineral_grade")
                    ->header("mineral_grade")

                    ->group("state")
                    ->header("state")

                    ->group("district")
                    ->header("district")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA25()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $mineral = $this->request->getData('mineral');
            $grade = $this->request->getData('grade');
            $state = $this->request->getData('state');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA25MaterExportActivity($returnType, $from_date, $mineral, $grade, $state);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Master Report for Export Activity for' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");


            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, district, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_A25";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, district, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_A25")

                    ->column("plant_name")->justify("center")->label("Plant name / Storage Location")
                    ->column("opening_stock")->justify("center")->label("Opening Stock (Quantity)")
                    ->column("ore_purchased_quantity")->justify("center")->label("Ore Purchased (Quantity)")
                    ->column("ore_purchased_value")->justify("center")->label("Ore Purchased (Value)")
                    ->column("ore_import_quantity")->justify("center")->label("Ore Import (Quantity)")
                    ->column("ore_import_value")->justify("center")->label("Ore Import (Value)")
                    ->column("ore_dispatched_quantity")->justify("center")->label("Ore Dispatched (Quantity)")
                    ->column("ore_dispatched_value")->justify("center")->label("Ore Dispatched (Value)")
                    ->column("closing_stock")->justify("center")->label("CLosing Stock (Quantity)")

                    ->to($reportAction) //Auto download excel file
                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("mineral_grade")
                    ->header("mineral_grade")

                    ->group("state")
                    ->header("state")

                    ->group("district")
                    ->header("district")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA26()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $mineral = $this->request->getData('mineral');
            $grade = $this->request->getData('grade');
            $state = $this->request->getData('state');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA26MaterEndUserActivity($returnType, $from_date, $mineral, $grade, $state);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Master Report for End Use Activity for' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, district, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_A26";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, district, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_A26")

                    ->column("plant_name")->justify("center")->label("Plant name / Storage Location")
                    ->column("opening_stock")->justify("center")->label("Opening Stock (Quantity)")
                    ->column("ore_purchased_quantity")->justify("center")->label("Ore Purchased (Quantity)")
                    ->column("ore_purchased_value")->justify("center")->label("Ore Purchased (Value)")
                    ->column("ore_import_quantity")->justify("center")->label("Ore Import (Quantity)")
                    ->column("ore_import_value")->justify("center")->label("Ore Import (Value)")
                    ->column("ore_dispatched_quantity")->justify("center")->label("Ore Dispatched (Quantity)")
                    ->column("ore_dispatched_value")->justify("center")->label("Ore Dispatched (Value)")
                    ->column("closing_stock")->justify("center")->label("CLosing Stock (Quantity)")

                    ->to($reportAction) //Auto download excel file
                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("mineral_grade")
                    ->header("mineral_grade")

                    ->group("state")
                    ->header("state")

                    ->group("district")
                    ->header("district")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA27()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $mineral = $this->request->getData('mineral');
            $grade = $this->request->getData('grade');
            $state = $this->request->getData('state');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA27MaterStockistActivity($returnType, $from_date, $mineral, $grade, $state);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Master Report for Stockist Activity for' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, district, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_A27 GROUP BY plant_name";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, district, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_A27 GROUP BY plant_name")

                    ->column("plant_name")->justify("center")->label("Plant name / Storage Location")
                    ->column("opening_stock")->justify("center")->label("Opening Stock (Quantity)")
                    ->column("ore_purchased_quantity")->justify("center")->label("Ore Purchased (Quantity)")
                    ->column("ore_purchased_value")->justify("center")->label("Ore Purchased (Value)")
                    ->column("ore_import_quantity")->justify("center")->label("Ore Import (Quantity)")
                    ->column("ore_import_value")->justify("center")->label("Ore Import (Value)")
                    ->column("ore_dispatched_quantity")->justify("center")->label("Ore Dispatched (Quantity)")
                    ->column("ore_dispatched_value")->justify("center")->label("Ore Dispatched (Value)")
                    ->column("closing_stock")->justify("center")->label("CLosing Stock (Quantity)")

                    ->to($reportAction) //Auto download excel file
                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("mineral_grade")
                    ->header("mineral_grade")

                    ->group("state")
                    ->header("state")

                    ->group("district")
                    ->header("district")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA28()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $mineral = $this->request->getData('mineral');
            $plant = $this->request->getData('plant');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA28MaterRawMaterialConsumed($returnType, $from_date, $mineral, $plant);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Master Report for Raw Material Consumed for' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, state, district, plant_name, industry, prev_ind_year, prev_imp_year, pres_ind_year, pres_inm_year, next_year_est, future_est FROM temp_reportico_report_A28";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, state, district, plant_name, industry, prev_ind_year, prev_imp_year, pres_ind_year, pres_inm_year, next_year_est, future_est FROM temp_reportico_report_A28")

                    ->column("plant_name")->justify("center")->label("Name of Plant")
                    ->column("prev_ind_year")->justify("center")->label("Actual indigenous consumption (Previous Financial Year)")
                    ->column("prev_imp_year")->justify("center")->label("Actual imported consumption (Previous Financial Year)")
                    ->column("pres_ind_year")->justify("center")->label("Actual indigenous consumption (Present Financial Year)")
                    ->column("pres_inm_year")->justify("center")->label("Actual imported consumption (Present Financial Year)")
                    ->column("next_year_est")->justify("center")->label("Estimated requirement (next Financial year)")
                    ->column("future_est")->justify("center")->label("Estimated Requirement (Next to Next Financial Year)")

                    ->to($reportAction) //Auto download excel file
                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("state")
                    ->header("state")

                    ->group("district")
                    ->header("district")

                    ->group("industry")
                    ->header("industry")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA29()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $mineral = $this->request->getData('mineral');
            $plant = $this->request->getData('plant');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA29SourceSupplyIndigenous($returnType, $from_date, $mineral, $plant);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Master Report Source of Supply (Indigenous) for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, state, plant_name, industry, ind_sup_name,ind_quantity, ind_price, ind_trans_mode, ind_trans_cost FROM temp_reportico_report_A29";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, state, plant_name, industry, ind_sup_name,ind_quantity, ind_price, ind_trans_mode, ind_trans_cost FROM temp_reportico_report_A29")

                    ->column("plant_name")->justify("center")->label("Name of Plant")
                    ->column("ind_sup_name")->justify("center")->label("Name and address of Supplier")
                    ->column("ind_trans_mode")->justify("center")->label("Mode of Transportation")
                    ->column("ind_trans_cost")->justify("center")->label("Transportation cost per unit")
                    ->column("ind_quantity")->justify("center")->label("Indigenous Quantity ")
                    ->column("ind_price")->justify("center")->label("Price per unit at factory site")

                    ->to($reportAction) //Auto download excel file

                    ->group("state")
                    ->header("state")

                    ->group("industry")
                    ->header("industry")

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA30()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $mineral = $this->request->getData('mineral');
            $plant = $this->request->getData('plant');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA30SourceSupplyImported($returnType, $from_date, $mineral, $plant);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = 'Master Report Source of Supply (Imported) for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, state, plant_name,ind_sup_name,import_addr, industry,import_pur_quantity, import_cost FROM temp_reportico_report_A30";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, state, plant_name,ind_sup_name,import_addr, industry,import_pur_quantity, import_cost FROM temp_reportico_report_A30")

                    ->expression("supplier")
                    ->set("{ind_sup_name}.' '.{import_addr}")

                    ->column("plant_name")->justify("center")->label("Name of Plant")
                    ->column("supplier")->justify("center")->label("Name & address of Suppilers")
                    ->column("import_pur_quantity")->justify("center")->label("Imported Quantity")
                    ->column("import_cost")->justify("center")->label("Price per unit at factory site")
                    ->column("ind_sup_name")->hide()
                    ->column("import_addr")->hide()

                    ->to($reportAction) //Auto download excel file
                    ->group("state")
                    ->header("state")

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("industry")
                    ->header("industry")

                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA31()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $from_year = $this->request->getData('from_year');
            $mineral = $this->request->getData('mineral');
            $plant = $this->request->getData('plant');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA31TransportationCost($returnType, $from_date, $mineral, $plant);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));
                $report = ' Report for Transportation Cost for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, plant_name, industry, company, ind_sup_name,ind_trans_cost, ind_price FROM temp_reportico_report_A31";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, plant_name, industry, company, ind_sup_name,ind_trans_cost, ind_price FROM temp_reportico_report_A31")

                    ->column("company")->justify("center")->label("Company Name")
                    ->column("plant_name")->justify("center")->label("Plant name/Storage Location")
                    ->column("ind_sup_name")->justify("center")->label("Name and address of Supplier")
                    ->column("ind_trans_cost")->justify("center")->label("Transportation cost per unit")
                    ->column("ind_price")->justify("center")->label("Price per unit at factory site")

                    ->to($reportAction) //Auto download excel file
                    ->group("industry")
                    ->header("industry")

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA32()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $mineral = $this->request->getData('mineral');
            $from_year = $this->request->getData('from_year');
            $plant = $this->request->getData('plant');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA32SupplierIndigenous($returnType, $from_date, $mineral, $plant);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));

                $report = ' Report for Indigenous Supplier List for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, company, plant_name, ind_sup_name,reg_id FROM temp_reportico_report_A32";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, company, plant_name, ind_sup_name,reg_id FROM temp_reportico_report_A32")

                    ->column("company")->justify("center")->label("Company Name")
                    ->column("plant_name")->justify("center")->label("Plant name/Storage Location")
                    ->column("ind_sup_name")->justify("center")->label("Name and address of Supplier")
                    ->column("reg_id")->justify("center")->label("Registration Number  of Indigenous Supplier ")

                    ->to($reportAction) //Auto download excel file
                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->group("plant_name")
                    ->header("plant_name")

                    ->group("company")
                    ->header("company")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportA33()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $mineral = $this->request->getData('mineral');
            $from_year = $this->request->getData('from_year');
            $plant = $this->request->getData('plant');
            $country = $this->request->getData('country');

            $from_date = '01-04' . '-' . $from_year;
            $from_date = $this->ReporticoCustom->changeReportDateFormat($from_date);

            $query = ReporticoCustomComponent::getReportA33SupplierImported($returnType, $from_date, $mineral, $plant, $country);
            if ($returnType == 'ANNUAL') {
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($from_date));

                $report = ' Report for Imported Supplier List for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, company, plant_name, imp_sup_name FROM temp_reportico_report_A33";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, company, plant_name, imp_sup_name FROM temp_reportico_report_A33")

                    ->column("company")->justify("center")->label("Company Name")
                    ->column("plant_name")->justify("center")->label("Plant name/Storage Location")
                    ->column("imp_sup_name")->justify("center")->label("Name & Address of Supplier")

                    ->to($reportAction) //Auto download excel file
                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->group("company")
                    ->header("company")

                    ->group("plant_name")
                    ->header("plant_name")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportM36()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            } 

            $returnType = $this->request->getData('returnType');
            $month = $this->request->getData('month');
            $year = $this->request->getData('year');
            $mineral = $this->request->getData('mineral');
            $grade = $this->request->getData('grade');
            $plant = $this->request->getData('plant');
            $date = $month . '-' . $year;
            $date = $this->ReporticoCustom->changeReportDateFormat($date);

            $query = ReporticoCustomComponent::getReportM36TradingActivity($returnType, $date, $mineral, $grade, $plant);
            if ($returnType == 'MONTHLY') {
                $month = explode('-', $month);
                $month = $month[1];
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($date));
                $report = ' Report for Trading Activity for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_M36";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_M36")

                    ->column("plant_name")->justify("center")->label("Plant name / Storage Location")
                    ->column("opening_stock")->justify("center")->label("Opening Stock (Quantity)")
                    ->column("ore_purchased_quantity")->justify("center")->label("Ore Purchased (Quantity)")
                    ->column("ore_purchased_value")->justify("center")->label("Ore Purchased (Value)")
                    ->column("ore_import_quantity")->justify("center")->label("Ore Import (Quantity)")
                    ->column("ore_import_value")->justify("center")->label("Ore Import (Value)")
                    ->column("ore_dispatched_quantity")->justify("center")->label("Ore Dispatched (Quantity)")
                    ->column("ore_dispatched_value")->justify("center")->label("Ore Dispatched (Value)")
                    ->column("closing_stock")->justify("center")->label("CLosing Stock (Quantity)")

                    ->to($reportAction) //Auto download excel file
                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("mineral_grade")
                    ->header("mineral_grade")

                    ->group("state")
                    ->header("state")

                    ->group("plant_name")
                    ->header("plant_name")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportM37()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $month = $this->request->getData('month');
            $year = $this->request->getData('year');
            $mineral = $this->request->getData('mineral');
            $grade = $this->request->getData('grade');
            $plant = $this->request->getData('plant');
            $date = $month . '-' . $year;
            $date = $this->ReporticoCustom->changeReportDateFormat($date);

            $query = ReporticoCustomComponent::getReportM37ExportActivity($returnType, $date, $mineral, $grade, $plant);
            if ($returnType == 'MONTHLY') {
                $month = explode('-', $month);
                $month = $month[1];
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($date));
                $report = ' Report for Export Activity for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_M37";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_M37")

                    ->column("plant_name")->justify("center")->label("Plant name / Storage Location")
                    ->column("opening_stock")->justify("center")->label("Opening Stock (Quantity)")
                    ->column("ore_purchased_quantity")->justify("center")->label("Ore Purchased (Quantity)")
                    ->column("ore_purchased_value")->justify("center")->label("Ore Purchased (Value)")
                    ->column("ore_import_quantity")->justify("center")->label("Ore Import (Quantity)")
                    ->column("ore_import_value")->justify("center")->label("Ore Import (Value)")
                    ->column("ore_dispatched_quantity")->justify("center")->label("Ore Dispatched (Quantity)")
                    ->column("ore_dispatched_value")->justify("center")->label("Ore Dispatched (Value)")
                    ->column("closing_stock")->justify("center")->label("CLosing Stock (Quantity)")

                    ->to($reportAction) //Auto download excel file
                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("mineral_grade")
                    ->header("mineral_grade")

                    ->group("state")
                    ->header("state")

                    ->group("plant_name")
                    ->header("plant_name")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportM38()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }

            $returnType = $this->request->getData('returnType');
            $month = $this->request->getData('month');
            $year = $this->request->getData('year');
            $mineral = $this->request->getData('mineral');
            $grade = $this->request->getData('grade');
            $plant = $this->request->getData('plant');
            $date = $month . '-' . $year;
            $date = $this->ReporticoCustom->changeReportDateFormat($date);

            $query = ReporticoCustomComponent::getReportM38EndUseActivity($returnType, $date, $mineral, $grade, $plant);
            if ($returnType == 'MONTHLY') {
                $month = explode('-', $month);
                $month = $month[1];
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($date));
                $report = ' Report for End Use Activity for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_M38";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_M38")

                    ->column("plant_name")->justify("center")->label("Plant name / Storage Location")
                    ->column("opening_stock")->justify("center")->label("Opening Stock (Quantity)")
                    ->column("ore_purchased_quantity")->justify("center")->label("Ore Purchased (Quantity)")
                    ->column("ore_purchased_value")->justify("center")->label("Ore Purchased (Value)")
                    ->column("ore_import_quantity")->justify("center")->label("Ore Import (Quantity)")
                    ->column("ore_import_value")->justify("center")->label("Ore Import (Value)")
                    ->column("ore_dispatched_quantity")->justify("center")->label("Ore Dispatched (Quantity)")
                    ->column("ore_dispatched_value")->justify("center")->label("Ore Dispatched (Value)")
                    ->column("closing_stock")->justify("center")->label("CLosing Stock (Quantity)")

                    ->to($reportAction) //Auto download excel file
                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("mineral_grade")
                    ->header("mineral_grade")

                    ->group("state")
                    ->header("state")

                    ->group("plant_name")
                    ->header("plant_name")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }

    public function reportM39()
    {
        if ($this->request->is('post')) {
            $reportAction = '';
            if(array_key_exists('download_report',$this->request->getData())){
                $reportAction = 'CSV';
            }
            
            $returnType = $this->request->getData('returnType');
            $month = $this->request->getData('month');
            $year = $this->request->getData('year');
            $mineral = $this->request->getData('mineral');
            $grade = $this->request->getData('grade');
            $plant = $this->request->getData('plant');
            $date = $month . '-' . $year;
            $date = $this->ReporticoCustom->changeReportDateFormat($date);

            $query = ReporticoCustomComponent::getReportM39StorageActivity($returnType, $date, $mineral, $grade, $plant);
            if ($returnType == 'MONTHLY') {
                $month = explode('-', $month);
                $month = $month[1];
                $getMonthYear = 'FY';
                $getMonthYearName = 'month';
                $getMonthYearLabel = 'F Y';
                $displayDate =  date("F Y", strtotime($date));
                $report = ' Report for Storage Activity for ' . $displayDate;
            }
            ini_set("include_path", reporticoReport);
            require_once("vendor/autoload.php");
            require_once("vendor/reportico-web/reportico/src/Reportico.php");

            $con = ConnectionManager::get('default');
            $sql = "SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_M39";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            if (!empty($records)) {
                Builder::build()
                    ->properties(["bootstrap_preloaded" => true])
                    ->datasource()->database("mysql:host=" . ForReportConnection . "; dbname=" . ForReportDB)->user(ForReportUserName)->password(ForReportPassword)
                    ->title($report)

                    ->sql("SELECT applicant_id AS Registration_No, mineral_name, mineral_grade, state, plant_name, opening_stock, ore_purchased_quantity, ore_purchased_value, ore_import_quantity, ore_import_value, ore_dispatched_quantity, ore_dispatched_value, closing_stock FROM temp_reportico_report_M39")

                    ->column("plant_name")->justify("center")->label("Plant name / Storage Location")
                    ->column("opening_stock")->justify("center")->label("Opening Stock (Quantity)")
                    ->column("ore_purchased_quantity")->justify("center")->label("Ore Purchased (Quantity)")
                    ->column("ore_purchased_value")->justify("center")->label("Ore Purchased (Value)")
                    ->column("ore_import_quantity")->justify("center")->label("Ore Import (Quantity)")
                    ->column("ore_import_value")->justify("center")->label("Ore Import (Value)")
                    ->column("ore_dispatched_quantity")->justify("center")->label("Ore Dispatched (Quantity)")
                    ->column("ore_dispatched_value")->justify("center")->label("Ore Dispatched (Value)")
                    ->column("closing_stock")->justify("center")->label("CLosing Stock (Quantity)")

                    ->to($reportAction) //Auto download excel file
                    ->group("Registration_No")
                    ->header("Registration_No")

                    ->group("mineral_name")
                    ->header("mineral_name")

                    ->group("mineral_grade")
                    ->header("mineral_grade")

                    ->group("state")
                    ->header("state")

                    ->group("plant_name")
                    ->header("plant_name")

                    ->expression()
                    ->section("COLUMNHEADERS")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("GROUPHEADERLABEL")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("GROUPHEADERVALUE")
                    ->style("color:#003F87;")

                    ->expression()
                    ->section("ROW")
                    ->style("border: 1px solid #000;")

                    ->expression()
                    ->section("ALLCELLS")
                    ->style("border: 1px solid #000;")

                    ->page()
                    ->pagetitledisplay("TopOfFirstPage")
                    ->header("INDIAN BUREAU OF MINES", "border-width: 0px 0px 1px 0px; margin: 25px 0px 0px 0px; border-color: #000000; font-size: 20; border-style: solid;padding:0px 0px 0px 0px; width: 100%; background-color: inherit; color: #000; margin-left: 0%;margin-bottom: 70px;text-align:center; font-weight:bold;")

                    ->footer("Page: {PAGE} of {PAGETOTAL}", "border-width: 1 0 0 0; top: 0px; font-size: 8pt; margin: 2px 0px 0px 0px; font-style: italic; margin-top: 30px;")
                    ->footer("Time: date('Y-m-d H:i:s')", "font-size: 8pt; text-align: right; font-style: italic; width: 100%; margin-top: 30px;")
                    ->execute();
            } else {
                $this->set('records', array());
                $alert_message = "<strong> Records Not Found!!! </strong>";
                $alert_redirect_url = "index";
                $alert_theme = "success";

                $this->set('alert_message', $alert_message);
                $this->set('alert_redirect_url', $alert_redirect_url);
                $this->set('alert_theme', $alert_theme);
            }
        }
    }
}
