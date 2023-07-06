<?php

namespace App\Controller;

include("../vendor/autoload.php");

use Cake\Datasource\ConnectionManager;
use Cake\ORM\Entity;
use Cake\ORM\Locator\LocatorAwareTrait;
use tcpdf;
use customReportGen;
use PHPReportMaker;
use xmldsign;
use Cake\Utility\Xml;
use FR3D;
use Cake\View;
use PhpOffice\PhpSpreadsheet\IOFactory;


class ReportsnextController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Commonreport');
        $this->loadModel('DirMcpMineral');
        $this->loadModel('DirState');
        $this->userSessionExits();

        ini_set('memory_limit', '-1');
        set_time_limit(0);
    }

    public function monthlyFilter()
    {
        $title = $this->request->getQuery('title');

        if (!in_array($title, array('reportm07', 'reportm08', 'reportm09', 'reportm34', 'reportm35', 'reportm07new'))) {
            $this->redirect(array('controller' => 'mms', 'action' => 'home'));
        }

        $this->set('title', $title);

        $this->viewBuilder()->setLayout('report_layout');

        $queryMineral = $this->DirMcpMineral->find('list', [
            'keyField' => 'mineral_name',
            'valueField' => 'mineral_name',
        ])
            ->select(['mineral_name'])->order(['mineral_name' => 'ASC']);
        $minerals = $queryMineral->toArray();
        $this->set('minerals', $minerals);

        $queryState = $this->DirState->find('list', [
            'keyField' => 'state_code',
            'valueField' => 'state_name',
        ])
            ->select(['state_name']);
        $states = $queryState->toArray();
        $this->set('states', $states);
    }

    public function reportm07()
    {
        $this->viewBuilder()->setLayout('reportnext');

        if ($this->request->is('post')) {

            $returnType = 'MONTHLY';
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];

            $month01 = explode('-', $month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $month1 = $year1 . $month1 . '-01';
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];

            $month02 = explode('-', $month2);
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $month2 = $year2 . $month2 . '-01';
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;
            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = ($mineral == '') ? array() : $mineral;
            $mineral = implode("|", $mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');

            $displayDate = $reportDate = date("F Y", strtotime($from_date));
            if (strtotime($from_date) == strtotime($to_date))
                $displayDate = "for the month of " . $displayDate;
            else
                $displayDate = "from " . $displayDate . " to " . date("F Y", strtotime($to_date));

            $query = $this->Commonreport->getReportM07($mineral, $state, $district, $from_date, $to_date, $returnType);
			//print_r($query);die;
            $displayDate = date("F Y", strtotime($from_date));

            if (strtotime($from_date) == strtotime($to_date))
                $displayDate = "for the month of " . $displayDate;
            else
                $displayDate = "from " . $displayDate . " to " . date("F Y", strtotime($to_date));

            //$displayDate = 'from January 2018 to June 2018';
            $report_name = "Mine-wise Average Daily Employment with Male/Female bifurcation $displayDate";
            $this->set('report_name',$report_name);

            $date1 = $from_date;
            $date2 = $to_date;
            $ts1 = strtotime($date1);
            $ts2 = strtotime($date2);
            $year1 = date('Y', $ts1);
            $year2 = date('Y', $ts2);
            $month1 = date('m', $ts1);
            $month2 = date('m', $ts2);
            $total_month = (($year2 - $year1) * 12) + ($month2 - $month1) + 1;
            $this->set('total_month',$total_month);
    
            $month_arr = array();
            $curr_date = $from_date;
            for($i=0; $i < $total_month; $i++){
    
                $month_arr[$i]['month_name'] = date('F', strtotime($curr_date));
                $month_arr[$i]['month_label'] = $month_arr[$i]['month_name'] . " " . date('Y', strtotime($curr_date));
                
                $time = strtotime($curr_date);
                $curr_date = date("Y-m-d", strtotime("+1 month", $time));
            }
    
            $this->set('month_arr',$month_arr);
    
            $conn = ConnectionManager::get('default');
            $records = $conn->execute($query)->fetchAll('assoc');
            $this->set('records',$records);

        } else {
            $this->redirect(array('controller'=>'reportsnext','action'=>'monthly_filter?title=reportm07'));
        }

    }

    public function reportm08()
    {

        $this->viewBuilder()->setLayout('reportnext');

        if ($this->request->is('post')) {

            $returnType = 'MONTHLY';
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];

            $month01 = explode('-', $month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $month1 = $year1 . $month1 . '-01';
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];

            $month02 = explode('-', $month2);
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $month2 = $year2 . $month2 . '-01';
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;
            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = ($mineral == '') ? array() : $mineral;
            $mineral = implode("|", $mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');

            $query = $this->Commonreport->getReportM08($mineral, $state, $district, $from_date, $to_date, $returnType);

            
            $displayDate = date("F Y", strtotime($from_date));

            if (strtotime($from_date) == strtotime($to_date))
                $displayDate = "for the month of " . $displayDate;
            else
                $displayDate = "from " . $displayDate . " to " . date("F Y", strtotime($to_date));

            //$displayDate = 'from January 2018 to June 2018';
            $report_name = "Mine-wise Average Daily Employment with Direct/Contract bifurcation $displayDate";
            $this->set('report_name',$report_name);

            $date1 = $from_date;
            $date2 = $to_date;
            $ts1 = strtotime($date1);
            $ts2 = strtotime($date2);
            $year1 = date('Y', $ts1);
            $year2 = date('Y', $ts2);
            $month1 = date('m', $ts1);
            $month2 = date('m', $ts2);
            $total_month = (($year2 - $year1) * 12) + ($month2 - $month1) + 1;
            $this->set('total_month',$total_month);
    
            $month_arr = array();
            $curr_date = $from_date;
            for($i=0; $i < $total_month; $i++){
    
                $month_arr[$i]['month_name'] = date('F', strtotime($curr_date));
                $month_arr[$i]['month_label'] = $month_arr[$i]['month_name'] . " " . date('Y', strtotime($curr_date));
                
                $time = strtotime($curr_date);
                $curr_date = date("Y-m-d", strtotime("+1 month", $time));
            }
    
            $this->set('month_arr',$month_arr);
    
            $conn = ConnectionManager::get('default');
            $records = $conn->execute($query)->fetchAll('assoc');
            $this->set('records',$records);

        } else {
            $this->redirect(array('controller'=>'reportsnext','action'=>'monthly_filter?title=reportm08'));
        }
		
    }


    public function reportm09()
    {

        $this->viewBuilder()->setLayout('reportnext');

        if ($this->request->is('post')) {

            $returnType = 'MONTHLY';
            $fromDate = $this->request->getData('from_date');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];

            $month01 = explode('-', $month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $month1 = $year1 . $month1 . '-01';
            $from_date = $year1 . '-' . $monthno . '-01';

            $toDate = $this->request->getData('to_date');
            $toDate = explode(' ', $toDate);
            $month2 = $toDate[0];

            $month02 = explode('-', $month2);
            $monthno = date('m', strtotime($month2));
            $year2 = $toDate[1];
            $month2 = $year2 . $month2 . '-01';
            $to_date = $year2 . '-' . $monthno . '-01';

            $from = $month1 . ' ' . $year1;
            $to =  $month2 . ' ' . $year2;
            $showDate = $month01[0] . ' ' . $year1 . ' To ' . $month02[0] . ' ' . $year2;

            $mineral = $this->request->getData('mineral');
            $mineral = ($mineral == '') ? array() : $mineral;
            $mineral = implode("|", $mineral);
            $state = $this->request->getData('state');
            $district = $this->request->getData('district');

            $query = $this->Commonreport->getReportM09($mineral, $state, $district, $from_date, $to_date, $returnType);

            $displayDate = date("F Y", strtotime($from_date));

            if (strtotime($from_date) == strtotime($to_date))
                $displayDate = "for the month of " . $displayDate;
            else
                $displayDate = "from " . $displayDate . " to " . date("F Y", strtotime($to_date));

            //$displayDate = 'from January 2018 to June 2018';
            $report_name = "Mine-wise / Work place wise Average Daily Employment and Total Wages paid from $displayDate";
            $this->set('report_name',$report_name);

            $date1 = $from_date;
            $date2 = $to_date;
            $ts1 = strtotime($date1);
            $ts2 = strtotime($date2);
            $year1 = date('Y', $ts1);
            $year2 = date('Y', $ts2);
            $month1 = date('m', $ts1);
            $month2 = date('m', $ts2);
            $total_month = (($year2 - $year1) * 12) + ($month2 - $month1) + 1;
            $this->set('total_month',$total_month);
    
            $month_arr = array();
            $curr_date = $from_date;
            for($i=0; $i < $total_month; $i++){
    
                $month_arr[$i]['month_name'] = date('F', strtotime($curr_date));
                $month_arr[$i]['month_label'] = $month_arr[$i]['month_name'] . " " . date('Y', strtotime($curr_date));
                
                $time = strtotime($curr_date);
                $curr_date = date("Y-m-d", strtotime("+1 month", $time));
            }
    
            $this->set('month_arr',$month_arr);
    
            $conn = ConnectionManager::get('default');
            $records = $conn->execute($query)->fetchAll('assoc');
            $this->set('records',$records);

        } else {
            $this->redirect(array('controller'=>'reportsnext','action'=>'monthly_filter?title=reportm09'));
        }
    }

    public function reportm34()
    {

        $this->viewBuilder()->setLayout('reportnext');

        if ($this->request->is('post')) {

            $returnType = 'MONTHLY';
            $fromDate = $this->request->getData('month_year');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];

            $month01 = explode('-', $month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $month1 = $year1 . $month1 . '-01';
            $from_date = $year1 . '-' . $monthno . '-01';

            $mineral = $this->request->getData('mineral');
            $mineral = ($mineral == '') ? array() : $mineral;
            $mineral = implode("|", $mineral);

            $query = $this->Commonreport->getReportM34('34', $mineral, $returnType, $from_date, $from_date);
             //print_r($query);die;

            $date1 = $from_date;
            $ts1 = strtotime($date1);
            $year1 = date('Y', $ts1);
            $month1 = date('m', $ts1);
            // pr($ts1);die;
            $total_month = $month1;
            $this->set('total_month',$total_month);

            $month_arr = array();
            $curr_date = $from_date;
            for($i=0; $i < $total_month; $i++){
    
                $month_arr[$i]['month_name'] = date('F', strtotime($curr_date));
                $month_arr[$i]['month_label'] = $month_arr[$i]['month_name'] . " " . date('Y', strtotime($curr_date));
                
                $time = strtotime($curr_date);
                $curr_date = date("Y-m-d", strtotime("+1 month", $time));
            }
    
            $this->set('month_arr',$month_arr);
                
            $displayDate = date("F Y", strtotime($from_date));            

            //$displayDate = 'from January 2018 to June 2018';
            $report_name = "Reasons for increase/decrease in production for the month of $displayDate";
            $this->set('report_name',$report_name);           
    
            $conn = ConnectionManager::get('default');
            $records = $conn->execute($query)->fetchAll('assoc');
            $this->set('records',$records);

        } else {
            $this->redirect(array('controller'=>'reportsnext','action'=>'monthly_filter?title=reportm34'));
        }
		
    }

    public function reportm35()
    {

        $this->viewBuilder()->setLayout('reportnext');

        if ($this->request->is('post')) {

            $returnType = 'MONTHLY';
            $fromDate = $this->request->getData('month_year');
            $fromDate = explode(' ', $fromDate);
            $month1 = $fromDate[0];

            $month01 = explode('-', $month1);
            $monthno = date('m', strtotime($month1));
            $year1 = $fromDate[1];
            $month1 = $year1 . $month1 . '-01';
            $from_date = $year1 . '-' . $monthno . '-01';

            $mineral = $this->request->getData('mineral');
            $mineral = ($mineral == '') ? array() : $mineral;
            $mineral = implode("|", $mineral);

            $query = $this->Commonreport->getReportM34('35', $mineral, $returnType, $from_date, $from_date);
            $date1 = $from_date;
            $ts1 = strtotime($date1);
            $year1 = date('Y', $ts1);
            $month1 = date('m', $ts1);
            // pr($ts1);die;
            $total_month = $month1;
            $this->set('total_month',$total_month);

            $month_arr = array();
            $curr_date = $from_date;
            for($i=0; $i < $total_month; $i++){
    
                $month_arr[$i]['month_name'] = date('F', strtotime($curr_date));
                $month_arr[$i]['month_label'] = $month_arr[$i]['month_name'] . " " . date('Y', strtotime($curr_date));
                
                $time = strtotime($curr_date);
                $curr_date = date("Y-m-d", strtotime("+1 month", $time));
            }
    
            $this->set('month_arr',$month_arr);
                
            $displayDate = date("F Y", strtotime($from_date));            

            //$displayDate = 'from January 2018 to June 2018';
            $report_name = "Reasons for increase/decrease in Ex-mine Price for the month of $displayDate";
            $this->set('report_name',$report_name);           
    
            $conn = ConnectionManager::get('default');
            $records = $conn->execute($query)->fetchAll('assoc');
            $this->set('records',$records);

        } else {
            $this->redirect(array('controller'=>'reportsnext','action'=>'monthly_filter?title=reportm35'));
        }
        
    }
}
