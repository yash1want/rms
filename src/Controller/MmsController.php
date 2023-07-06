<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Network\Email\Email;
use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

class MmsController extends AppController
{

    var $name = 'Mms';
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
        $this->loadComponent('Language');
        $this->loadComponent('Counts');
        $this->loadComponent('Returnslist');
        $this->loadComponent('Clscommon');
        $this->loadComponent('Formcreation');
        $this->loadComponent('Sitemails'); //Added by Shweta Apale  on 03-02-2022
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
        $this->DirRegion = $this->getTableLocator()->get('DirRegion');
        $this->DirZone = $this->getTableLocator()->get('DirZone');
        $this->DirState = $this->getTableLocator()->get('DirState');
        $this->Employment = $this->getTableLocator()->get('Employment');
        $this->ExplosiveReturn = $this->getTableLocator()->get('ExplosiveReturn');
        $this->GradeProd = $this->getTableLocator()->get('GradeProd');
        $this->GradeRom = $this->getTableLocator()->get('GradeRom');
        $this->GradeSale = $this->getTableLocator()->get('GradeSale');
        $this->IncrDecrReasons = $this->getTableLocator()->get('IncrDecrReasons');
        $this->KwClientType = $this->getTableLocator()->get('KwClientType');
        $this->Mine = $this->getTableLocator()->get('Mine');
        $this->MineralWorked = $this->getTableLocator()->get('MineralWorked');
        $this->MiningPlan = $this->getTableLocator()->get('MiningPlan');
        $this->MmsUser = $this->getTableLocator()->get('MmsUser');
        $this->MmsDashboardCounts = $this->getTableLocator()->get('MmsDashboardCounts');
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
        $this->TblFinalSubmit = $this->getTableLocator()->get('TblFinalSubmit');
        $this->TblEndUserFinalSubmit = $this->getTableLocator()->get('TblEndUserFinalSubmit');
        $this->WorkStoppage = $this->getTableLocator()->get('WorkStoppage');

        // Model, added on 11-05-2023 by Ankush
        $this->MmsRaisingTickets = $this->getTableLocator()->get('MmsRaisingTickets');
        $this->SupportingAttachments = $this->getTableLocator()->get('SupportingAttachments');
    }

    
    // Generate Ticket, added on 19-04-2023 by Ankush
    public function generateTicket()
    {

        $this->viewBuilder()->setLayout('mms_panel');
        $editTicketId = $this->Session->read('editTicketId');
        $buttonName = 'Save';

        $userId = $this->Session->read('username');
        $action=$this->Session->read('userAction');
        // print_r($userId);die;
        
        $currentDate = date("Y-m-d");

        if($action=='edit'){   // For edit ticket window

            // For Form Heading
           $heading = 'Edit Ticket';
           $buttonName = 'Update';
           $flag = 'edit';
           $ticketDetails = $this->MmsRaisingTickets->find('all',array('conditions'=>array('id IS'=>$editTicketId)))->first();

           $tokenNumber = $ticketDetails['token'];

           $this->set('tokenNumber',$tokenNumber);

           // print_r($tokenNumber);die;
           $this->Session->delete('userAction');

        }else if($action=='ReferenceTicket'){   // For View ticket Window  

           $ReferenceTicketId = $this->Session->read('ReferenceTicketId');

           $ticketDetails = $this->MmsRaisingTickets->find('all',array('conditions'=>array('id IS'=>$ReferenceTicketId)))->first();
            // For Form Heading
           $heading = 'Create a new ticket with this token reference : <span class="token">' . htmlspecialchars($ticketDetails['token'], ENT_QUOTES, 'UTF-8') . '</span>';

            // echo '<pre>';print_r($ticketDetails);die;
           $this->Session->delete('ReferenceTicketId');
           $this->Session->delete('userAction');


        }else {     // For Add ticket Window


            $heading = 'Generate Ticket';
            $flag = 'add';
            // Define blank array for add user window
            $ticketDetails = array('ticket_type'=>'','issued_raise_at'=>'','issued_type'=>'','form_type_monthly'=>'','form_type_annual'=>'','applicant_id'=>'','description'=>'','form_submission'=>'','mine_code'=>'','attachment'=>'','other_issue_type'=>'',
              'date'=>'');
            
        }


        if (null !== $this->request->getData('save')){

            $formData = $this->request->getData();

            // echo '<pre>';print_r($formData);die;

            if ($formData['issued_type'] == 'Others' || $formData['issued_type'] == 'Change Request') 

            {

                $formData['description']= $this->request->getData('other_description');

            } 
           
        if ($formData['save'] == 'Save') { 
            
            if ($formData['ticket_type'] == 'MPAS' && $formData['issued-raise-at'] == 'Applicant')
            {



                $lastToken = $this->MmsRaisingTickets->find()->select(['token'])->orderDesc('id')->first();
                $year = date('y');
                $lastCounter = (int)substr($lastToken->token, -3); // extract last 3 digits as integer
                $counter = $lastCounter + 1; // increment by 1
                $formData['token'] = sprintf("MPA%s%03d",$year, $counter);

            }

            if ($formData['ticket_type'] == 'MPAS' && $formData['issued-raise-at'] == 'IBM') {

               $lastToken = $this->MmsRaisingTickets->find()->select(['token'])->orderDesc('id')->first();
               
               $year = date('y');
                $lastCounter = (int)substr($lastToken->token, -3); // extract last 7 digits as integer
                $counter = $lastCounter + 1; // increment by 1
                $formData['token'] = sprintf("MPI%s%03d",$year, $counter);
             }

            if ($formData['ticket_type'] == 'RMS' && $formData['issued-raise-at'] == 'Applicant') {

             $lastToken = $this->MmsRaisingTickets->find()->select(['token'])->orderDesc('id')->first();
             $year = date('y');
                $lastCounter = (int)substr($lastToken->token, -3); // extract last 7 digits as integer
                $counter = $lastCounter + 1; // increment by 1
                $formData['token'] = sprintf("RMSA%s%03d",$year, $counter);
                


            }
            if ($formData['ticket_type'] == 'RMS' && $formData['issued-raise-at'] == 'IBM') {

              $lastToken = $this->MmsRaisingTickets->find()->select(['token'])->orderDesc('id')->first();
              $year = date('y');
                $lastCounter = (int)substr($lastToken->token, -3); // extract last 7 digits as integer
                $counter = $lastCounter + 1; // increment by 1
                $formData['token'] = sprintf("RMSI%s%03d",$year, $counter);
                


            }
        }


            $return=$this->MmsRaisingTickets->saveGenerateTicket($formData,$editTicketId,$userId);
            
            
            if($return == 'success'){
                
                $email_body = 'Dear Support Team'."\r\n\r\n".'';
                $email_body .= 'The ticket was generated with following details.'."\r\n\r\n".'';
                $email_body .= 'Token ID : '.$formData['token']."\r\n";
                foreach($formData as $key=>$val){
                    $email_body .= $key.' : '.$val."\r\n";
                }
                $email_body .= ''."\r\n\r\n\r\n".'';
                $email_body .= 'This was system generated email for IBM Support Team reference only.';
                $subject = "Ticket ID: ".$formData['token']." Generated";
				$to_1 = 'aniketaganvir@gmail.com';
				$to_2 = 'support.mts-ibm@nic.in';
                $txt = $email_body;
                require_once(ROOT . DS .'vendor' . DS . 'phpmailer' . DS . 'mail.php');
                $from = "no-reply@ibm.gov.in";
                send_mail($from, $to_1, $subject, $txt);
                send_mail($from, $to_2, $subject, $txt);
              
               $this->Session->delete('editTicketId');
               $this->Session->delete('userAction');
               $this->Session->write('usr_msg_suc', 'Ticket generated successfully');
               $this->redirect(['controller'=>'mms','action'=>'list-ticket']);

            }else{

               $this->Session->write('usr_msg_err', $return);
               $this->redirect(['controller'=>'mms','action'=>'generate-ticket']);

            }
            
            
            
          
           

       }

       $this->set('heading',$heading);
       $this->set('flag',$flag);
       $this->set('action',$action);
       $this->set('ticketDetails',$ticketDetails);
       $this->set('buttonlabel',$buttonName);



   }

     // List Ticket, added on 24-04-2023 by Ankush
    public function listTicket()
    {
        $userId = $this->Session->read('username');
        $this->viewBuilder()->setLayout('mms_panel');
       if($userId == 'usribm491'){
       $listTicket = $this->MmsRaisingTickets->find('all')
                    ->order('-id')
                    ->toArray();
       }else{
          
          $listTicket = $this->MmsRaisingTickets->find('all')
                     ->where(['user_id' => $userId])
                    ->order('-id')
                    ->toArray();

       }
                   // echo '<pre>'; print_r($listTicket);die;
        $this->set('listTicket',$listTicket);
    }


    

     // Edit Ticket, added on 25-04-2023 by Ankush
    
    public function ticketEdit($id){

        // print_r($id);die;
        $this->Session->write('editTicketId',$id);
        $this->Session->write('userAction','edit');
        $this->redirect(['controller'=>'mms','action'=>'generate-ticket']);
    }
    
    
     // Create New Ticket With This Reference, added on 05-05-2023 by Ankush
    
    public function ticketCreateWithReference($id){

        // print_r($id);die;
        $this->Session->write('ReferenceTicketId',$id);
        $this->Session->write('userAction','ReferenceTicket');
        $this->redirect(['controller'=>'mms','action'=>'generate-ticket']);
    }

     // View Ticket, added on 25-04-2023 by Ankush
    
    public function viewTicket($id){
        $this->viewBuilder()->setLayout('mms_panel');
        // print_r($id);die;
        
        $getTicketDetails = $this->MmsRaisingTickets->find('all',array('conditions'=>array('id IS'=>$id)))->first();

        $getReferenceNo = $this->MmsRaisingTickets->find('all',array('conditions'=>array('reference_no IS'=>$getTicketDetails['token'])))->first();

        $id = $getTicketDetails['id'];
        $token_number = $getTicketDetails['token'];
        $ticket_type = $getTicketDetails['ticket_type'];
        $issued_raise_at = $getTicketDetails['issued_raise_at'];
        $issued_type = $getTicketDetails['issued_type'];
        $description = $getTicketDetails['description'];
        $form_submission = $getTicketDetails['form_submission'];
        $form_type_monthly = $getTicketDetails['form_type_monthly'];
        $form_type_annual = $getTicketDetails['form_type_annual'];
        $other_issue_type = $getTicketDetails['other_issue_type'];
        $attachment = $getTicketDetails['add_more_attachment'];
        $attachDescription = $getTicketDetails['add_more_description'];
        $created_at = $getTicketDetails['created_at'];
        $suppTeam_id = $getTicketDetails['support_team_id'];
        $Ticketstatus = $getTicketDetails['status'];
        $support_firstname = $getTicketDetails['support_firstname'];
        $comment = $getTicketDetails['reply'];
        $commentDate = $getTicketDetails['reply_date'];
        $ticketStatus = $getTicketDetails['status'];

        /*$explodeAttach = explode('/',$attachment);*/
        $explodeAttach = explode(',',$attachment);
        //$splitLinkCount = count($explodeAttach);
        //$getSent = $explodeAttach[$splitLinkCount - 1];

        $getAttach =array();
        if(count($explodeAttach)!=0)
        {

            $getAttach =$explodeAttach;
            // print_r($getAttach);exit;
        }


        $explAttchDescript = explode(',',$attachDescription);
        $getAttachDescript =array();

        $getAttachDescript=$explAttchDescript;
        

        // START display View Ticket support Team add_more_attachment and add more discription, added on 11-05-2023 by Ankush
        
        $getSupportingAttachments = $this->SupportingAttachments->find('all',array('conditions'=>array('token_number_id'=>$token_number)))->first();
          
          $add_more_attachment = $getSupportingAttachments['add_more_attachment'];
          $add_more_description = $getSupportingAttachments['add_more_description'];
        
        $explodeSupportAttach = explode(',',$add_more_attachment);
        

        $getSupportAttach =array();
        if(count($explodeSupportAttach)!=0)
        {

            $getSupportAttach =$explodeSupportAttach;
            
        }


        $explSupportDescript = explode(',',$add_more_description);
        $getSupportDescript =array();

        $getSupportDescript=$explSupportDescript;
        
        // END display View Ticket support Team add_more_attachment and add more discription, added on 11-05-2023 by Ankush 

                                
        // START SET variable View Ticket $getSupportAttach and $getSupportDescript
        
        $this->set('getSupportAttach',$getSupportAttach);
        $this->set('getSupportDescript',$getSupportDescript);
        
        // END SET variable View Ticket $getSupportAttach and $getSupportDescript
        
        $this->set('id',$id);
        $this->set('token_number',$token_number);
        $this->set('ticket_type',$ticket_type);
        $this->set('issued_raise_at',$issued_raise_at);
        $this->set('issued_type',$issued_type);
        $this->set('description',$description);
        $this->set('form_submission',$form_submission);
        $this->set('form_type_monthly',$form_type_monthly);
        $this->set('form_type_annual',$form_type_annual);
        $this->set('other_issue_type',$other_issue_type);
        $this->set('attachment',$attachment);
        $this->set('explodeAttach',$explodeAttach);
        $this->set('comment',$comment);
        $this->set('commentDate',$commentDate);
        
        $this->set('getAttach',$getAttach);
        $this->set('getAttachDescript',$getAttachDescript);
        $this->set('created_at',$created_at);
        $this->set('support_team_id',$support_team_id);
        $this->set('session_support_team_id',$session_support_team_id);
        $this->set('suppTeam_id',$suppTeam_id);
        $this->set('ticket_record_id',$ticket_record_id);
        $this->set('Ticketstatus',$Ticketstatus);
        $this->set('support_firstname',$support_firstname);
        $this->set('username',$username);
        $this->set('ticketStatus',$ticketStatus);
        $this->set('ReferenceNo',$getReferenceNo);
        $this->render('/Mms/view_ticket');
        
    }

     

    //  // Delete Ticket, added on 25-04-2023 by Ankush
    // public function ticketDelete($id){
        
    //     // Get the entity with the given ID
    //      $ticketDelete = $this->MmsRaisingTickets->get($id);

    //    // Call the delete() method to delete the entity
    //      $data=$this->MmsRaisingTickets->delete($ticketDelete);
        
    //     // print_r($data);die;
    //      $this->Session->write('usr_msg_suc', 'Ticket deleted successfully');
    //      return $this->redirect(['action' => 'list-ticket']);
        
    // }
    
	
    // User trailing logs, added on 21-07-2022 by Aniket
	public function logs()
	{
		$userId = $this->Session->read('username');
		$this->viewBuilder()->setLayout('mms_panel');

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
		
		$this->loadModel('MmsUserLog');
		$logdata = $this->MmsUserLog->find('all')->where(['uname'=>$userId])->where(['DATE(login_time) BETWEEN :start AND :end'])->bind(':start',$from_date,'date')->bind(':end',$to_date,'date')->order(['id DESC'])->toArray();
		$this->set('from_date',$from_date);
		$this->set('to_date',$to_date);
		$this->set('log_filtered_txt',$log_filtered_txt);
		$this->set('logdata',$logdata);
	}
    
	// All mms user trailing logs, added on 21-07-2022 by Aniket
	public function mmsLogs(){
		
		$this->viewBuilder()->setLayout('mms_panel');

		$from_date = date('Y-m-d',strtotime('-5 days',strtotime(date('Y-m-d'))));
		$to_date = date('Y-m-d');
		$log_filtered_txt = "Last 5 days"; 
		$userId = "";
		
		if ($this->request->is('post')) {
			if (null !== $this->request->getData('log_search')) {
				$from_date = $this->request->getData('from_date');
				$to_date = $this->request->getData('to_date');
				$userId = $this->request->getData('user_id');
				$log_filtered_txt = "username : ".$userId. ", ". "Between ".date('d-m-Y',strtotime($from_date))." - ".date('d-m-Y',strtotime($to_date)); 
			}
		}
		
		$this->loadModel('MmsUserLog');
        
		$conn = ConnectionManager::get('default');
        if (!empty($userId)) {
            $sql = "SELECT mul.*,
                    mu.email as email
                    FROM mms_user_log mul
                    LEFT JOIN mms_user mu
                    ON mu.user_name = mul.uname
                    AND CONVERT(FROM_BASE64(mu.email)USING latin1) LIKE '%$userId%'
                    WHERE DATE(mul.login_time) BETWEEN '$from_date' AND '$to_date'
                    AND (
                        mul.uname = mu.user_name
                        OR uname LIKE '%$userId%'
                    )
                    ORDER BY mul.id DESC";
        } else {
            $sql = "SELECT mul.*,mu.email as email
                    FROM mms_user_log mul
                    LEFT JOIN mms_user mu
                    ON mu.user_name = mul.uname
                    WHERE DATE(mul.login_time) BETWEEN '$from_date' AND '$to_date'
                    ORDER BY mul.id DESC";
        }

        $logdata = $conn->execute($sql)->fetchAll('assoc');

		$this->set('from_date',$from_date);
		$this->set('to_date',$to_date);
		$this->set('log_filtered_txt',$log_filtered_txt);
		$this->set('logdata',$logdata);
		
	}
    
	// All auth user trailing logs, added on 21-07-2022 by Aniket
	public function userLogs(){
		
		$this->viewBuilder()->setLayout('mms_panel');

		$from_date = date('Y-m-d',strtotime('-5 days',strtotime(date('Y-m-d'))));
		$to_date = date('Y-m-d');
		$log_filtered_txt = "Last 5 days"; 
		$userId = "";
		
		if ($this->request->is('post')) {
			if (null !== $this->request->getData('log_search')) {
				$from_date = $this->request->getData('from_date');
				$to_date = $this->request->getData('to_date');
				$userId = $this->request->getData('user_id');

				$log_filtered_txt = "username : ".$userId." Between ".date('d-m-Y',strtotime($from_date))." - ".date('d-m-Y',strtotime($to_date)); 
			}
		}
		
		$this->loadModel('McUserLog');
		
		if($userId == ''){
			$logdata = $this->McUserLog->find('all')->where(['DATE(login_time) BETWEEN :start AND :end'])->bind(':start',$from_date,'date')->bind(':end',$to_date,'date')->order(['id DESC'])->toArray();
		}else{
			$logdata = $this->McUserLog->find('all')->where(['uname LIKE "%'.$userId.'%"'])->where(['DATE(login_time) BETWEEN :start AND :end'])->bind(':start',$from_date,'date')->bind(':end',$to_date,'date')->order(['id DESC'])->toArray();
		}
		$this->set('from_date',$from_date);
		$this->set('to_date',$to_date);
		$this->set('log_filtered_txt',$log_filtered_txt);
		$this->set('logdata',$logdata);
		
	}

    public function home()
    {
		$cronjob = (new CronjobController())->mmsDashboardCount();
		
        $this->viewBuilder()->setLayout('mms_panel');

        $userId = $this->Session->read('mms_user_id');
        $userRole = $this->Session->read('mms_user_role');
        $this->Session->write('color_code', 'hidden');

        $submitted = null;
        $pending = null;
        $approved = null;
        $referred = null;
        $submittedAnnual = null;
        $pendingAnnual = null;
        $approvedAnnual = null;
        $referredAnnual = null;
        $endUserSubmitted = null;
        $endUserPending = null;
        $endUserApproved = null;
        $endUserReferred = null;
        $endUserSubmittedAnnual = null;
        $endUserPendingAnnual = null;
        $endUserApprovedAnnual = null;
        $endUserReferredAnnual = null;

        //if(null == $this->Session->read('dashboardCountFetched')){

        switch ($userRole) {
            case 1:
				$userId = 1;	
                $monthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'adminuser', 'form_type' => 'F'), 'order' => 'status'))->toArray();
                $annualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'adminuser', 'form_type' => 'G'), 'order' => 'status'))->toArray();
                $endMonthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'endadminuser', 'form_type' => 'L'), 'order' => 'status'))->toArray();
                $endAnnualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'endadminuser', 'form_type' => 'M'), 'order' => 'status'))->toArray();
                if (!empty($monthlyCounts)) {
                    $monthlyCountResult = $this->Customfunctions->counts($monthlyCounts);
                    $submitted = $monthlyCountResult[0];
                    $pending = $monthlyCountResult[1];
                    $approved = $monthlyCountResult[3];
                    $referred = $monthlyCountResult[2];
                }
                if (!empty($annualCounts)) {
                    $annualCountResult = $this->Customfunctions->counts($annualCounts);
                    $submittedAnnual = $annualCountResult[0];
                    $pendingAnnual = $annualCountResult[1];
                    $approvedAnnual = $annualCountResult[3];
                    $referredAnnual = $annualCountResult[2];
                }
                if (!empty($endMonthlyCounts)) {
                    $endMonthlyCountResult = $this->Customfunctions->counts($endMonthlyCounts);
                    $endUserSubmitted = $endMonthlyCountResult[0];
                    $endUserPending = $endMonthlyCountResult[1];
                    $endUserApproved = $endMonthlyCountResult[3];
                    $endUserReferred = $endMonthlyCountResult[2];
                }
                if (!empty($endAnnualCounts)) {
                    $endAnnualCountResult = $this->Customfunctions->counts($endAnnualCounts);
                    $endUserSubmittedAnnual = $endAnnualCountResult[0];
                    $endUserPendingAnnual = $endAnnualCountResult[1];
                    $endUserApprovedAnnual = $endAnnualCountResult[3];
                    $endUserReferredAnnual = $endAnnualCountResult[2];
                }
                break;
            case 2:


                $monthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'supervisoruser', 'form_type' => 'F'), 'order' => 'status'))->toArray();
                $annualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'supervisoruser', 'form_type' => 'G'), 'order' => 'status'))->toArray();
                //$endMonthlyCounts = $this->MmsDashboardCounts->find('all',array('conditions'=>array('mms_user_id'=>$userId,'user_role'=>'supervisoruser','form_type'=>'L'),'order'=>'status'))->toArray();
                //$endAnnualCounts = $this->MmsDashboardCounts->find('all',array('conditions'=>array('mms_user_id'=>$userId,'user_role'=>'supervisoruser','form_type'=>'L'),'order'=>'status'))->toArray();

                if (!empty($monthlyCounts)) {
                    $monthlyCountResult = $this->Customfunctions->counts($monthlyCounts);
                    $submitted = $monthlyCountResult[0];
                    $pending = $monthlyCountResult[1];
                    $approved = $monthlyCountResult[3];
                    $referred = $monthlyCountResult[2];
                }

                if (!empty($annualCounts)) {
                    $annualCountResult = $this->Customfunctions->counts($annualCounts);
                    $submittedAnnual = $annualCountResult[0];
                    $pendingAnnual = $annualCountResult[1];
                    $approvedAnnual = $annualCountResult[3];
                    $referredAnnual = $annualCountResult[2];
                }

                if (!empty($endMonthlyCounts)) {
                    $endMonthlyCountResult = $this->Customfunctions->counts($endMonthlyCounts);
                    $endUserSubmitted = $endMonthlyCountResult[0];
                    $endUserPending = $endMonthlyCountResult[1];
                    $endUserApproved = $endMonthlyCountResult[3];
                    $endUserReferred = $endMonthlyCountResult[2];
                }
                //$endUserSubmittedAnnual = $endAnnualCounts[3]['counts'];  $endUserPendingAnnual = $endAnnualCounts[0]['counts'];
                //$endUserApprovedAnnual = $endAnnualCounts[1]['counts'];    $endUserReferredAnnual = $endAnnualCounts[2]['counts'];

                break;
            case 3:

                $monthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'primaryuser', 'form_type' => 'F'), 'order' => 'status'))->toArray();
                $annualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'primaryuser', 'form_type' => 'G'), 'order' => 'status'))->toArray();
                //$endMonthlyCounts = $this->MmsDashboardCounts->find('all',array('conditions'=>array('mms_user_id'=>$userId,'user_role'=>'primaryuser','form_type'=>'L'),'order'=>'status'))->toArray();
                //$endAnnualCounts = $this->MmsDashboardCounts->find('all',array('conditions'=>array('mms_user_id'=>$userId,'user_role'=>'primaryuser','form_type'=>'L'),'order'=>'status'))->toArray();

                if (!empty($monthlyCounts)) {
                    $monthlyCountResult = $this->Customfunctions->counts($monthlyCounts);
                    $submitted = $monthlyCountResult[0];
                    $pending = $monthlyCountResult[1];
                    $approved = $monthlyCountResult[3];
                    $referred = $monthlyCountResult[2];
                }
                if (!empty($annualCounts)) {
                    $annualCountResult = $this->Customfunctions->counts($annualCounts);
                    $submittedAnnual = $annualCountResult[0];
                    $pendingAnnual = $annualCountResult[1];
                    $approvedAnnual = $annualCountResult[3];
                    $referredAnnual = $annualCountResult[2];
                }
                if (!empty($endMonthlyCounts)) {
                    $endMonthlyCountResult = $this->Customfunctions->counts($endMonthlyCounts);
                    $endUserSubmitted = $endMonthlyCountResult[0];
                    $endUserPending = $endMonthlyCountResult[1];
                    $endUserApproved = $endMonthlyCountResult[3];
                    $endUserReferred = $endMonthlyCountResult[2];
                }
                //$endUserSubmittedAnnual = $endAnnualCounts[3]['counts'];  $endUserPendingAnnual = $endAnnualCounts[0]['counts'];
                //$endUserApprovedAnnual = $endAnnualCounts[1]['counts'];    $endUserReferredAnnual = $endAnnualCounts[2]['counts'];

                break;
            case 4: //FOR CCOM
                $monthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'adminuser', 'form_type' => 'F'), 'order' => 'status'))->toArray();
                $annualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'adminuser', 'form_type' => 'G'), 'order' => 'status'))->toArray();
                $endMonthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'endadminuser', 'form_type' => 'L'), 'order' => 'status'))->toArray();
                $endAnnualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'endadminuser', 'form_type' => 'M'), 'order' => 'status'))->toArray();

                if (!empty($monthlyCounts)) {
                    $monthlyCountResult = $this->Customfunctions->counts($monthlyCounts);
                    $submitted = $monthlyCountResult[0];
                    $pending = $monthlyCountResult[1];
                    $approved = $monthlyCountResult[3];
                    $referred = $monthlyCountResult[2];
                }
                if (!empty($annualCounts)) {
                    $annualCountResult = $this->Customfunctions->counts($annualCounts);
                    $submittedAnnual = $annualCountResult[0];
                    $pendingAnnual = $annualCountResult[1];
                    $approvedAnnual = $annualCountResult[3];
                    $referredAnnual = $annualCountResult[2];
                }
                if (!empty($endMonthlyCounts)) {
                    $endMonthlyCountResult = $this->Customfunctions->counts($endMonthlyCounts);
                    $endUserSubmitted = $endMonthlyCountResult[0];
                    $endUserPending = $endMonthlyCountResult[1];
                    $endUserApproved = $endMonthlyCountResult[3];
                    $endUserReferred = $endMonthlyCountResult[2];
                }
                if (!empty($endAnnualCounts)) {
                    $endAnnualCountResult = $this->Customfunctions->counts($endAnnualCounts);
                    $endUserSubmittedAnnual = $endAnnualCountResult[0];
                    $endUserPendingAnnual = $endAnnualCountResult[1];
                    $endUserApprovedAnnual = $endAnnualCountResult[3];
                    $endUserReferredAnnual = $endAnnualCountResult[2];
                }
                break;
            case 5: //FOR ZONAL USERS

                $monthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'zoneuser', 'form_type' => 'F'), 'order' => 'status'))->toArray();
                $annualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'zoneuser', 'form_type' => 'G'), 'order' => 'status'))->toArray();
                $endMonthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'zoneuser', 'form_type' => 'L'), 'order' => 'status'))->toArray();
                $endAnnualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'zoneuser', 'form_type' => 'M'), 'order' => 'status'))->toArray();

                if (!empty($monthlyCounts)) {
                    $monthlyCountResult = $this->Customfunctions->counts($monthlyCounts);
                    $submitted = $monthlyCountResult[0];
                    $pending = $monthlyCountResult[1];
                    $approved = $monthlyCountResult[3];
                    $referred = $monthlyCountResult[2];
                }
                if (!empty($annualCounts)) {
                    $annualCountResult = $this->Customfunctions->counts($annualCounts);
                    $submittedAnnual = $annualCountResult[0];
                    $pendingAnnual = $annualCountResult[1];
                    $approvedAnnual = $annualCountResult[3];
                    $referredAnnual = $annualCountResult[2];
                }
                if (!empty($endMonthlyCounts)) {
                    $endMonthlyCountResult = $this->Customfunctions->counts($endMonthlyCounts);
                    $endUserSubmitted = $endMonthlyCountResult[0];
                    $endUserPending = $endMonthlyCountResult[1];
                    $endUserApproved = $endMonthlyCountResult[3];
                    $endUserReferred = $endMonthlyCountResult[2];
                }
                if (!empty($endAnnualCounts)) {
                    $endAnnualCountResult = $this->Customfunctions->counts($endAnnualCounts);
                    $endUserSubmittedAnnual = $endAnnualCountResult[0];
                    $endUserPendingAnnual = $endAnnualCountResult[1];
                    $endUserApprovedAnnual = $endAnnualCountResult[3];
                    $endUserReferredAnnual = $endAnnualCountResult[2];
                }
                break;
            case 6: //FOR RO USERS

                $monthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'regionuser', 'form_type' => 'F'), 'order' => 'status'))->toArray();
                $annualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'regionuser', 'form_type' => 'G'), 'order' => 'status'))->toArray();
                $endMonthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'regionuser', 'form_type' => 'L'), 'order' => 'status'))->toArray();
                $endAnnualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'regionuser', 'form_type' => 'M'), 'order' => 'status'))->toArray();

                if (!empty($monthlyCounts)) {
                    $monthlyCountResult = $this->Customfunctions->counts($monthlyCounts);
                    $submitted = $monthlyCountResult[0];
                    $pending = $monthlyCountResult[1];
                    $approved = $monthlyCountResult[3];
                    $referred = $monthlyCountResult[2];
                }
                if (!empty($annualCounts)) {
                    $annualCountResult = $this->Customfunctions->counts($annualCounts);
                    $submittedAnnual = $annualCountResult[0];
                    $pendingAnnual = $annualCountResult[1];
                    $approvedAnnual = $annualCountResult[3];
                    $referredAnnual = $annualCountResult[2];
                }
                if (!empty($endMonthlyCounts)) {
                    $endMonthlyCountResult = $this->Customfunctions->counts($endMonthlyCounts);
                    $endUserSubmitted = $endMonthlyCountResult[0];
                    $endUserPending = $endMonthlyCountResult[1];
                    $endUserApproved = $endMonthlyCountResult[3];
                    $endUserReferred = $endMonthlyCountResult[2];
                }
                if (!empty($endAnnualCounts)) {
                    $endAnnualCountResult = $this->Customfunctions->counts($endAnnualCounts);
                    $endUserSubmittedAnnual = $endAnnualCountResult[0];
                    $endUserPendingAnnual = $endAnnualCountResult[1];
                    $endUserApprovedAnnual = $endAnnualCountResult[3];
                    $endUserReferredAnnual = $endAnnualCountResult[2];
                }
                break;
            case 7:
                $monthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => 1, 'user_role' => 'adminuser', 'form_type' => 'F'), 'order' => 'status'))->toArray();
                $annualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => 1, 'user_role' => 'adminuser', 'form_type' => 'G'), 'order' => 'status'))->toArray();
                $endMonthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => 1, 'user_role' => 'endadminuser', 'form_type' => 'L'), 'order' => 'status'))->toArray();
                $endAnnualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => 1, 'user_role' => 'endadminuser', 'form_type' => 'M'), 'order' => 'status'))->toArray();

                if (!empty($monthlyCounts)) {
                    $monthlyCountResult = $this->Customfunctions->counts($monthlyCounts);
                    $submitted = $monthlyCountResult[0];
                    $pending = $monthlyCountResult[1];
                    $approved = $monthlyCountResult[3];
                    $referred = $monthlyCountResult[2];
                }
                if (!empty($annualCounts)) {
                    $annualCountResult = $this->Customfunctions->counts($annualCounts);
                    $submittedAnnual = $annualCountResult[0];
                    $pendingAnnual = $annualCountResult[1];
                    $approvedAnnual = $annualCountResult[3];
                    $referredAnnual = $annualCountResult[2];
                }
                if (!empty($endMonthlyCounts)) {
                    $endMonthlyCountResult = $this->Customfunctions->counts($endMonthlyCounts);
                    $endUserSubmitted = $endMonthlyCountResult[0];
                    $endUserPending = $endMonthlyCountResult[1];
                    $endUserApproved = $endMonthlyCountResult[3];
                    $endUserReferred = $endMonthlyCountResult[2];
                }
                if (!empty($endAnnualCounts)) {
                    $endAnnualCountResult = $this->Customfunctions->counts($endAnnualCounts);
                    $endUserSubmittedAnnual = $endAnnualCountResult[0];
                    $endUserPendingAnnual = $endAnnualCountResult[1];
                    $endUserApprovedAnnual = $endAnnualCountResult[3];
                    $endUserReferredAnnual = $endAnnualCountResult[2];
                }
                break;
            case 8:
                $monthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'adminuser', 'form_type' => 'F'), 'order' => 'status'))->toArray();
                $annualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'adminuser', 'form_type' => 'G'), 'order' => 'status'))->toArray();
                $endMonthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'supervisoruser', 'form_type' => 'L'), 'order' => 'status'))->toArray();
                $endAnnualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'supervisoruser', 'form_type' => 'M'), 'order' => 'status'))->toArray();

                if (!empty($monthlyCounts)) {
                    $monthlyCountResult = $this->Customfunctions->counts($monthlyCounts);
                    $submitted = $monthlyCountResult[0];
                    $pending = $monthlyCountResult[1];
                    $approved = $monthlyCountResult[3];
                    $referred = $monthlyCountResult[2];
                }
                if (!empty($annualCounts)) {
                    $annualCountResult = $this->Customfunctions->counts($annualCounts);
                    $submittedAnnual = $annualCountResult[0];
                    $pendingAnnual = $annualCountResult[1];
                    $approvedAnnual = $annualCountResult[3];
                    $referredAnnual = $annualCountResult[2];
                }
                //$endUserSubmitted = $endMonthlyCounts[3]['counts']; $endUserPending = $endMonthlyCounts[0]['counts'];
                //$endUserApproved = $endMonthlyCounts[1]['counts'];   $endUserReferred = $endMonthlyCounts[2]['counts'];

                if (!empty($endMonthlyCounts)) {
                    $endMonthlyCountResult = $this->Customfunctions->counts($endMonthlyCounts);
                    $endUserSubmitted = $endMonthlyCountResult[0];
                    $endUserPending = $endMonthlyCountResult[1];
                    $endUserApproved = $endMonthlyCountResult[3];
                    $endUserReferred = $endMonthlyCountResult[2];
                }

                if (!empty($endAnnualCounts)) {
                    $endAnnualCountResult = $this->Customfunctions->counts($endAnnualCounts);
                    $endUserSubmittedAnnual = $endAnnualCountResult[0];
                    $endUserPendingAnnual = $endAnnualCountResult[1];
                    $endUserApprovedAnnual = $endAnnualCountResult[3];
                    $endUserReferredAnnual = $endAnnualCountResult[2];
                }

                $mmsRemark = $this->TblEndUserFinalSubmit->getEnduserComments($userId);
                $this->set('mmsRemark', $mmsRemark);

                break;
            case 9:
                $monthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'adminuser', 'form_type' => 'F'), 'order' => 'status'))->toArray();
                $annualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'adminuser', 'form_type' => 'G'), 'order' => 'status'))->toArray();
                $endMonthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'primaryuser', 'form_type' => 'L'), 'order' => 'status'))->toArray();
                $endAnnualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'primaryuser', 'form_type' => 'M'), 'order' => 'status'))->toArray();

                if (!empty($monthlyCounts)) {
                    $monthlyCountResult = $this->Customfunctions->counts($monthlyCounts);
                    $submitted = $monthlyCountResult[0];
                    $pending = $monthlyCountResult[1];
                    $approved = $monthlyCountResult[3];
                    $referred = $monthlyCountResult[2];
                }
                if (!empty($annualCounts)) {
                    $annualCountResult = $this->Customfunctions->counts($annualCounts);
                    $submittedAnnual = $annualCountResult[0];
                    $pendingAnnual = $annualCountResult[1];
                    $approvedAnnual = $annualCountResult[3];
                    $referredAnnual = $annualCountResult[2];
                }
                //$endUserSubmitted = $endMonthlyCounts[3]['counts']; $endUserPending = $endMonthlyCounts[0]['counts'];
                //$endUserApproved = $endMonthlyCounts[1]['counts'];   $endUserReferred = $endMonthlyCounts[2]['counts'];

                if (!empty($endMonthlyCounts)) {
                    $endMonthlyCountResult = $this->Customfunctions->counts($endMonthlyCounts);
                    $endUserSubmitted = $endMonthlyCountResult[0];
                    $endUserPending = $endMonthlyCountResult[1];
                    $endUserApproved = $endMonthlyCountResult[3];
                    $endUserReferred = $endMonthlyCountResult[2];
                }

                if (!empty($endAnnualCounts)) {
                    $endAnnualCountResult = $this->Customfunctions->counts($endAnnualCounts);
                    $endUserSubmittedAnnual = $endAnnualCountResult[0];
                    $endUserPendingAnnual = $endAnnualCountResult[1];
                    $endUserApprovedAnnual = $endAnnualCountResult[3];
                    $endUserReferredAnnual = $endAnnualCountResult[2];
                }

                break;
            case 10:

                $monthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'dgmuser', 'form_type' => 'F'), 'order' => 'status'))->toArray();
                $annualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'dgmuser', 'form_type' => 'G'), 'order' => 'status'))->toArray();
                $endMonthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'dgmuser', 'form_type' => 'L'), 'order' => 'status'))->toArray();
                $endAnnualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'dgmuser', 'form_type' => 'M'), 'order' => 'status'))->toArray();

                if (!empty($monthlyCounts)) {
                    $monthlyCountResult = $this->Customfunctions->counts($monthlyCounts);
                    $submitted = $monthlyCountResult[0];
                    $pending = $monthlyCountResult[1];
                    $approved = $monthlyCountResult[3];
                    $referred = $monthlyCountResult[2];
                }
                if (!empty($annualCounts)) {
                    $annualCountResult = $this->Customfunctions->counts($annualCounts);
                    $submittedAnnual = $annualCountResult[0];
                    $pendingAnnual = $annualCountResult[1];
                    $approvedAnnual = $annualCountResult[3];
                    $referredAnnual = $annualCountResult[2];
                }
                if (!empty($endMonthlyCounts)) {
                    $endMonthlyCountResult = $this->Customfunctions->counts($endMonthlyCounts);
                    $endUserSubmitted = $endMonthlyCountResult[0];
                    $endUserPending = $endMonthlyCountResult[1];
                    $endUserApproved = $endMonthlyCountResult[3];
                    $endUserReferred = $endMonthlyCountResult[2];
                }
                if (!empty($endAnnualCounts)) {
                    $endAnnualCountResult = $this->Customfunctions->counts($endAnnualCounts);
                    $endUserSubmittedAnnual = $endAnnualCountResult[0];
                    $endUserPendingAnnual = $endAnnualCountResult[1];
                    $endUserApprovedAnnual = $endAnnualCountResult[3];
                    $endUserReferredAnnual = $endAnnualCountResult[2];
                }
                break;
            case 11:
                $monthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'adminuser', 'form_type' => 'F'), 'order' => 'status'))->toArray();
                $annualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'adminuser', 'form_type' => 'G'), 'order' => 'status'))->toArray();
                $endMonthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'endadminuser', 'form_type' => 'L'), 'order' => 'status'))->toArray();
                $endAnnualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'endadminuser', 'form_type' => 'M'), 'order' => 'status'))->toArray();

                if (!empty($monthlyCounts)) {
                    $monthlyCountResult = $this->Customfunctions->counts($monthlyCounts);
                    $submitted = $monthlyCountResult[0];
                    $pending = $monthlyCountResult[1];
                    $approved = $monthlyCountResult[3];
                    $referred = $monthlyCountResult[2];
                }
                if (!empty($annualCounts)) {
                    $annualCountResult = $this->Customfunctions->counts($annualCounts);
                    $submittedAnnual = $annualCountResult[0];
                    $pendingAnnual = $annualCountResult[1];
                    $approvedAnnual = $annualCountResult[3];
                    $referredAnnual = $annualCountResult[2];
                }
                if (!empty($endMonthlyCounts)) {
                    $endMonthlyCountResult = $this->Customfunctions->counts($endMonthlyCounts);
                    $endUserSubmitted = $endMonthlyCountResult[0];
                    $endUserPending = $endMonthlyCountResult[1];
                    $endUserApproved = $endMonthlyCountResult[3];
                    $endUserReferred = $endMonthlyCountResult[2];
                }
                if (!empty($endAnnualCounts)) {
                    $endAnnualCountResult = $this->Customfunctions->counts($endAnnualCounts);
                    $endUserSubmittedAnnual = $endAnnualCountResult[0];
                    $endUserPendingAnnual = $endAnnualCountResult[1];
                    $endUserApprovedAnnual = $endAnnualCountResult[3];
                    $endUserReferredAnnual = $endAnnualCountResult[2];
                }
                break;
			case 20: //FOR Dealing Hand USERS
				$userId = $this->Session->read('parentid');
                $monthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'regionuser', 'form_type' => 'F'), 'order' => 'status'))->toArray();
                $annualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'regionuser', 'form_type' => 'G'), 'order' => 'status'))->toArray();
                $endMonthlyCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'endadminuser', 'form_type' => 'L'), 'order' => 'status'))->toArray();
                $endAnnualCounts = $this->MmsDashboardCounts->find('all', array('conditions' => array('mms_user_id' => $userId, 'user_role' => 'endadminuser', 'form_type' => 'M'), 'order' => 'status'))->toArray();

                if (!empty($monthlyCounts)) {
                    $monthlyCountResult = $this->Customfunctions->counts($monthlyCounts);
                    $submitted = $monthlyCountResult[0];
                    $pending = $monthlyCountResult[1];
                    $approved = $monthlyCountResult[3];
                    $referred = $monthlyCountResult[2];
                }
                if (!empty($annualCounts)) {
                    $annualCountResult = $this->Customfunctions->counts($annualCounts);
                    $submittedAnnual = $annualCountResult[0];
                    $pendingAnnual = $annualCountResult[1];
                    $approvedAnnual = $annualCountResult[3];
                    $referredAnnual = $annualCountResult[2];
                }
                if (!empty($endMonthlyCounts)) {
                    $endMonthlyCountResult = $this->Customfunctions->counts($endMonthlyCounts);
                    $endUserSubmitted = $endMonthlyCountResult[0];
                    $endUserPending = $endMonthlyCountResult[1];
                    $endUserApproved = $endMonthlyCountResult[3];
                    $endUserReferred = $endMonthlyCountResult[2];
                }
                if (!empty($endAnnualCounts)) {
                    $endAnnualCountResult = $this->Customfunctions->counts($endAnnualCounts);
                    $endUserSubmittedAnnual = $endAnnualCountResult[0];
                    $endUserPendingAnnual = $endAnnualCountResult[1];
                    $endUserApprovedAnnual = $endAnnualCountResult[3];
                    $endUserReferredAnnual = $endAnnualCountResult[2];
                }
                break;
        }

        $this->Session->write('submitted', $submitted);
        $this->Session->write('pending', $pending);
        $this->Session->write('approved', $approved);
        $this->Session->write('referred', $referred);
        $this->Session->write('submittedAnnual', $submittedAnnual);
        $this->Session->write('pendingAnnual', $pendingAnnual);
        $this->Session->write('approvedAnnual', $approvedAnnual);
        $this->Session->write('referredAnnual', $referredAnnual);
        $this->Session->write('endUserSubmitted', $endUserSubmitted);
        $this->Session->write('endUserPending', $endUserPending);
        $this->Session->write('endUserApproved', $endUserApproved);
        $this->Session->write('endUserReferred', $endUserReferred);
        $this->Session->write('endUserSubmittedAnnual', $endUserSubmittedAnnual);
        $this->Session->write('endUserPendingAnnual', $endUserPendingAnnual);
        $this->Session->write('endUserApprovedAnnual', $endUserApprovedAnnual);
        $this->Session->write('endUserReferredAnnual', $endUserReferredAnnual);
        $this->Session->write('dashboardCountFetched', 'yes');

        //}

        $this->set('userRole', $userRole);
    }

    public function returns($return_type, $form_type, $status, $oldreturns = null)
    {

        $this->Session->write('sess_return_type', $return_type);
        $this->Session->write('sess_form_type', $form_type);
        $this->Session->write('sess_status', $status);

        if (!empty($oldreturns)) {
            $this->Session->write('oldreturns', $oldreturns);
        } else {
            if (!empty($this->Session->read('oldreturns'))) {
                $this->Session->delete('oldreturns');
            }
        }

        $this->redirect(array('controller' => 'mms', 'action' => 'returns-records'));
    }

    public function returnsRecords()
    {
        $this->viewBuilder()->setLayout('mms_panel');

        $mms_user_id = $this->Session->read('mms_user_id');
        $userrole = $this->Session->read('mms_user_role');
        $return_type = strtoupper($this->Session->read('sess_return_type'));
        $form_type = $this->Session->read('sess_form_type');
        $status = $this->Customfunctions->returnStatus($userrole, $this->Session->read('sess_status'));

        $zoneArr = $this->DirZone->find('list', array('keyField' => 'zone_name', 'valueField' => 'zone_name'))->toArray();
        //$monthsArr = $this->Customfunctions->getMonthArr();
        $yearsArr = $this->Customfunctions->getYearArr();
        $formsArr = $this->Customfunctions->getFormArr($form_type);
        $returnPeriodArr = $this->Customfunctions->getReturnPeriodArr($form_type);
        $this->set('zoneArr', $zoneArr);
        //$this->set('monthsArr',$monthsArr);
        $this->set('yearsArr', $yearsArr);
        $this->set('formsArr', $formsArr);
        $this->set('returnPeriodArr', $returnPeriodArr);

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

        if (null !== $this->request->getData('f_search')) {

            $rb_period = $this->request->getData('rb_period');

            if ($rb_period == 'period') {

                $r_period = $this->Customfunctions->getReturnDateByReturnPeriod($this->request->getData('r_period'));

                $from_date = $r_period[0];
                $to_date = $r_period[1];
                
            } elseif ($rb_period == 'range') {

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

        switch ($userrole) {

            case 5:
                $zoneid = $this->MmsUser->find('all', array('fields' => 'zone_id', 'conditions' => array('id IS' => $mms_user_id)))->first();
                $zone = $this->DirZone->find('all', array('fields' => 'zone_name', 'conditions' => array('id IS' => $zoneid['zone_id'])))->first();
                $zoneName = $zone['zone_name'];
                $regionsList = $this->DirRegion->find('list', array('keyField' => 'region_name', 'valueField' => 'region_name', 'conditions' => array('zone_name IS' => $zoneName)))->toArray();
                break;
            case 6:
                $regionid = $this->MmsUser->find('all', array('fields' => 'region_id', 'conditions' => array('id IS' => $mms_user_id)))->first();
                $region = $this->DirRegion->find('all', array('fields' => 'region_name', 'conditions' => array('id IS' => $regionid['region_id'])))->first();
                $regionName = $region['region_name'];
                $statesList = $this->DirDistrict->getstateByregion($regionName);
                break;
            case 10:
                $stateData = $this->MmsUser->find('all', array('fields' => 'state_code', 'conditions' => array('id IS' => $mms_user_id)))->first();
                $stateResult = $this->DirState->find('all', array('fields' => 'state_code', 'conditions' => array('id IS' => $stateData['state_code'])))->first();
                $stateCode = $stateResult['state_code'];
                $districtsList = $this->DirDistrict->getDistrictCodesByStateCode($stateCode);
                break;
			case 20:
				$mms_user_id = $this->Session->read('parentid');
                $regionid = $this->MmsUser->find('all', array('fields' => 'region_id', 'conditions' => array('id IS' => $mms_user_id)))->first();
                $region = $this->DirRegion->find('all', array('fields' => 'region_name', 'conditions' => array('id IS' => $regionid['region_id'])))->first();
                $regionName = $region['region_name'];
                $statesList = $this->DirDistrict->getstateByregion($regionName);
                break;
        }

        $this->set('regionsList', $regionsList);
        $this->set('statesList', $statesList);
        $this->set('districtsList', $districtsList);
        $this->set('userrole', $userrole);

        $cutoffDate = Configure::read('cutoff_date');
        $returnsData = $this->Returnslist->getFilteredReturnsList($mine_code, $mms_user_id, $zoneName, $regionName, $stateCode, $district, $from_date, $to_date, $form, $status, $userrole, $return_type);
        $this->set('returnsData', $returnsData);
        $this->set('dashboard', 'mmsuser');
        $this->set('cutoffDate', $cutoffDate);
    }

    public function monthlyReturns($mine_code, $return_month, $return_year, $return_type, $action = '')
    {

        if (str_contains($mine_code, 'SPRblock')) { // for end user

            $mine_code = str_replace('SPR', '/', $mine_code);
            $form_name = 'generalParticular';
            $user_type = 'enduser';
            $controller = 'mmsenduser';
        } else { // for mine user

            $form_name = 'mine';
            $user_type = 'authuser';
            $controller = 'mms';
        }

        $date = trim($return_month) . ' 01 ' . trim($return_year);
        $return_month = date('m', strtotime($date));
        $return_year = trim($return_year);
        $return_date = $return_year . "-" . $return_month . "-01";

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

        $this->Session->write('mc_form_main', $form_main);
        $this->Session->write('applicantid', (isset($applicantid[0])) ? $applicantid[0]['applicant_id'] : $applicantid['applicant_id']);
        $this->Session->write('mc_mine_code', $mine_code);
        $this->Session->write('returnDate', $return_date);
        $this->Session->write('returnType', $return_type);
        $this->Session->write('mc_sel_year', $return_year);
        $this->Session->write('mc_sel_month', $return_month);
        $this->Session->write('lang', 'english');
        $this->Session->write('form_status', $action);
        $this->Session->write('view_user_type', $user_type);
        $this->Session->write('report_home_page', 'monthyreturn/allreturns');

        if ($return_type == 'ANNUAL') {
            $appId = ($applicantid[0]) ? $applicantid[0] : $applicantid;
            $appIdArr = explode('/', $appId['applicant_id']);
            $mc_parent_id = $appIdArr[0];
            $this->Session->write('mc_parent_id', $mc_parent_id);
        }

        $this->Session->write('color_code', 'show');
		
		$this->Customfunctions->formReturnTitle();
		
        $this->redirect(array('controller' => $controller, 'action' => $form_name));
    }

    /**
     * Show PDF for older returns i.e. before MCDR 2017 get's in effect
     * @version 29th Nov 2021
     * @author Aniket Ganvir
     */
    public function monthlyReturnsPdf($mine_code, $return_month, $return_year, $return_type, $action = '')
    {

        if (str_contains($mine_code, 'SPRblock')) { // for end user

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
        $formType = ($return_type == 'MONTHLY') ? 'N' : 'O';
        $this->Session->write('formType', $formType);

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

        //========CONTAINS THE LIST OF ALL THE MINERAL OF THE PARTICULAR MINE=======
        $minerals = $this->MineralWorked->fetchMineralInfo($mine_code);
        foreach ($minerals as $mineral) {
            $mineralArr[] = $mineral['mineral_name'];
        }

        $mineralWorked = $this->MineralWorked->getMineralName($mine_code);

        $this->Session->write('mineralArr', $mineralArr);
        $this->Session->write('mc_mineral', $mineralWorked);

        $this->Session->write('mc_form_main', $form_main);
        $this->Session->write('applicantid', (isset($applicantid[0])) ? $applicantid[0]['applicant_id'] : $applicantid['applicant_id']);
        $this->Session->write('mc_mine_code', $mine_code);
        $this->Session->write('returnDate', $return_date);
        $this->Session->write('returnType', $return_type);
        $this->Session->write('mc_sel_year', $return_year);
        $this->Session->write('mc_sel_month', $return_month);
        $this->Session->write('lang', 'english');
        $this->Session->write('form_status', $action);
        $this->Session->write('view_user_type', $user_type);
        $this->Session->write('report_home_page', 'monthyreturn/allreturns');

        if ($return_type == 'ANNUAL') {
            $appId = ($applicantid[0]) ? $applicantid[0] : $applicantid;
            $appIdArr = explode('/', $appId['applicant_id']);
            $mc_parent_id = $appIdArr[0];
            $this->Session->write('mc_parent_id', $mc_parent_id);
        }

        $this->redirect(array('controller' => 'Returnspdf', 'action' => $pdf_action));
    }

    public function mine()
    {

        $this->viewBuilder()->setLayout('mms/form_layout');

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

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

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        // below uncomment line by ganesh satav below line fetch the return list
        // added by ganesh satav dated 20 aug 2014
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);
        // THIS IS A TEMPORARY TRICK I APPLIED.....
        // PLEASE CHANGE IT WITH APPROPRIATE LOGIC---==========ADDED BY UD=========
        // below comment line by ganesh satav because this link fetch the current link that why this line comment.
        // added by ganesh satav dated 20 aug 2014
        //  $this->return_home_page = $_SERVER['HTTP_REFERER'];

        //fetches the mine details
        $mine = $this->Mine->getMineDetails($mineCode, $returnType, $returnDate);

        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], '', '', 1);
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], '', '', 1, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', '1');
        $this->set('part_no', '');
        $this->set('mineral', '');
        $this->set('sub_min', '');

        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, '1', '', '');

        $labels = $this->Language->getFormInputLabels('mine', $lang);

        //fetching mine details : by natarajan
        $mine = $this->Mine->getMineDetails($mineCode);
        $mine_code = $this->Session->read('mc_mine_code');

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

        $returnType = $this->Session->read('returnType');
        if ($returnType == "")
            $returnType = 'MONTHLY';

        $formNo = $this->Session->read('mc_form_type');

        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));

        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('label', $labels);
        $this->set('tableForm', '');
        $this->set('mine', $mine);
        $this->set('formId', 'F01');
        $this->set('mineCode', $mine_code);
        $this->set('isMineOwner', $isMineOwner);
        $this->set('is_all_approved', $is_all_approved);
        $this->set('returnType', $returnType);
        $this->set('formNo', $formNo);

        $this->loadModel('MineralWorked');
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mine_code);
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

        $count = 0;
        $chkReturnsRcd1 = true;
        $isExists = $this->Mine->checkMine($mine_code);

        //mine details edit form
        //check is rejected or approved section
        // if ($approvedSections['partI'][1] == "Rejected") {
        //     $is_rejected_section = 1;
        //     $reasons = $this->getRejectedReasons($mineCode, $returnDate, '', '', 1);
        // } else if ($approvedSections['partI'][1] == "Approved")
        //     $is_rejected_section = 2;
        // else
        $is_rejected_section = ''; // need to review

        $this->set('is_rejected_section', $is_rejected_section);

        $this->render('/element/monthly/forms/mine_details');

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Details of the Mine</b> successfully!');
                $this->redirect(array('controller' => 'mms', 'action' => 'name_address'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Details of the Mine</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mms', 'action' => 'name_address'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Details of the Mine</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'mine'));
            }
        }
    }

    public function executeUserleftnav($mine_code, $mineral_name = null)
    {

        $returnType = $this->Session->read('returnType');
        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $returnDate = $returnYear . "-" . $returnMonth . "-01";

        //========CONTAINS THE LIST OF ALL THE MINERAL OF THE PARTICULAR MINE=======
        $this->loadModel('MineralWorked');
        $minerals = $this->MineralWorked->fetchMineralInfo($mine_code);
        foreach ($minerals as $mineral) {
            $mineralArr[] = $mineral['mineral_name'];
        }

        $this->Session->write('mineralArr', $mineralArr);

        // $this->sectionFillStatus($mine_code);
        $returnId = $this->TblFinalSubmit->getLatestReturnId($mine_code, $returnDate, $returnType);
        $this->Customfunctions->setMinerSectionColorCode($returnId);
        $this->commentStatus($mine_code);

        //=====================$mineralWorked CONTAINS THE WHOLE ARRAY AND HENCE WE
        //=============================ARE STORIG WHOLE ARRAY TO SESSION============
        $mineralWorked = $minerals[0];
        $this->set('primary_min', $mineralWorked);

        //=========CODE RETURN TRUE IF DATA IS FOUND IN THE DB ELSE FALSE===========
        //code for HEMATITE, MAGNETITE:start
        $this->loadModel('Prod1');
        $minHematite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'hematite');
        $minMagnetite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'magnetite');

        if ($minHematite == true) {
            $is_hematite = true;
        } else {
            $is_hematite = false;
        }

        if ($minMagnetite == true) {
            $is_magnetite = true;
        } else {
            $is_magnetite = false;
        }
        $this->set('is_hematite', $is_hematite);
        $this->set('is_magnetite', $is_magnetite);

        //======STORING THE VARIABLE IN BOTH UPPER CASE AND IN LOWER CASE IN $this->partIIM1
        //========OUTPUT OF THE BELOW CODE PRITING IS: Array ( [0] => MICA [1] => mica )
        $mineralWorked['mineral_name'] = trim($mineralWorked['mineral_name']);
        $partIIM1 = array($mineralWorked['mineral_name'], strtolower(str_replace(' ', '_', $mineralWorked['mineral_name'])));
        $this->loadModel('DirMcpMineral');
        $partIIM1['formNo'] = $this->DirMcpMineral->getFormNumber($partIIM1[1]);

        $this->set('partIIM1', $partIIM1);

        //=============GETS THE FORM TYPE FROM THE SESSION LIKE F5==================
        $formType = $this->Session->read('mc_form_type');

        //=====STORING THE OTHER MINERALS IF PRESENT IN THE $this->partIIMOther[] AS
        //=========( [0] => Array ( [0] => COPPER ORE [1] => copper_ore ))==========
        $partIIMOther = [];
        if (count($minerals) > 1) {
            $otherMinerals = [];
            for ($i = 1; $i < count($minerals); $i++) {
                $otherMinerals[] = $minerals[$i]['mineral_name'];
            }

            foreach ($otherMinerals as $otrMineral) {
                $otrMineral = trim($otrMineral);
                if ($otrMineral != '') {
                    $partIIMOther[] = array($otrMineral, strtolower(str_replace(' ', '_', $otrMineral)));
                }
            }
        }

        foreach ($partIIMOther as $key => $value) {
            $partIIMOther[$key]['formNo'] = $this->DirMcpMineral->getFormNumber($partIIMOther[$key][0]);
        }

        $this->set('partIIMOther', $partIIMOther);

        //show grades as per primary minerals
        $mineralArr = $this->Session->read('mineralArr');
        $rom_grade = false;
        $mineral_sp = strtoupper(str_replace('_', ' ', $mineral_name));

        if (in_array($mineralArr[0], array('IRON ORE', 'CHROMITE'))) {

            if ($mineral_sp == $mineralArr[0]) {
                $rom_grade = true;
            }
        }
        $this->set('rom_grade', $rom_grade);


        if ($returnType == 'ANNUAL') {
            $allMin = $this->Session->read('mineralArr');
            $this->set('allMin', $allMin);
        }
    }

    public function nameAddress()
    {

        $this->viewBuilder()->setLayout('mms/form_layout');

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }


        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);
        $this->set('annualReturnDate', $returnDate);

        //if switched directly to part2 through left-nav
        $minerals = $this->Session->read('mineralArr');
        $this->Session->write('min', $minerals[0]);

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;


        // Below Function call for the label array updated by ganesh satavdated on the 14 feb 2014
        // $this->FormLabelNameWithFormNo = clsCommon::getFormLabelNameWithFormNo($this->formNumber,$this->returnType);
        // echo "<pre>"; print_r($this->FormLabelNameWithFormNo); exit;
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        $owner = $this->Mine->getMineOwnerDetails($mineCode, $returnDate);

        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], '', '', 2);
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], '', '', 2, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));

        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', '2');
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', '');
        $this->set('sub_min', '');

        //check second mineral to redirect
        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, '2', '', '');

        $labels = $this->Language->getFormInputLabels('name_address', $lang);

        //fetching owner details : by natarajan
        $owner = $this->Mine->getMineOwnerDetails($mineCode, $returnDate);

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

        $returnType = $this->Session->read('returnType');
        if ($returnType == "")
            $returnType = 'MONTHLY';

        $formNo = $this->Session->read('mc_form_type');

        $this->set('label', $labels);
        $this->set('owner', $owner);
        $this->set('formId', $formId);
        $this->set('mineCode', $mineCode);
        $this->set('isMineOwner', $isMineOwner);
        $this->set('is_all_approved', $is_all_approved);
        $this->set('returnType', $returnType);
        $this->set('formNo', $formNo);

        if ($returnType == 'ANNUAL') {
            $returnYear = $this->Session->read('mc_sel_year');
            $max_date = ($returnYear + 1) . '-03-01';
            $max_date = date('Y-m-t', strtotime($max_date));
            $this->set('max_date', $max_date);
        }

        $this->loadModel('MineralWorked');
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

        //name and address edit form
        //check is rejected or approved section
        // if ($approvedSections['partI'][2] == "Rejected") {
        //     $is_rejected_section = 1;
        //     $reasons = $this->getRejectedReasons($mineCode, $returnDate, '', '', 2);
        // } else if ($approvedSections['partI'][2] == "Approved")
        //     $is_rejected_section = 2;
        // else
        $is_rejected_section = ''; // need to review

        $this->set('is_rejected_section', $is_rejected_section);
        $this->set('tableForm', null);
        $this->render('/element/monthly/forms/name_address');

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Name and Address</b> successfully!');
                $this->redirect($this->nextSection('nameAddress', 'mms'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Name and Address</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('nameAddress', 'mms'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Name and Address</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'name_address'));
            }
        }
    }

    public function rent()
    {

        $this->viewBuilder()->setLayout('mms/form_layout');

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        //if switched directly to part2 through left-nav
        $minerals = $this->Session->read('mineralArr');
        $this->Session->write('min', $minerals[0]);

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        $rent = $this->RentReturns->getRentReturnsDetails($mineCode, $returnType, $returnDate);

        $pastSurfaceRent = $rent['past_surface_rent'];
        $pastRoyaltyRent = $rent['past_royalty'];
        $pastDeadRent = $rent['past_dead_rent'];

        /*As per new update of "Form-1", this new field added, Done By Pravin Bhakare 22-07-2020*/
        $pastPayDmf = $rent['past_pay_dmf'];
        $pastPayNmet = $rent['past_pay_nmet'];

        //fetch the particular rejected reason
        $return_id_arr = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id_arr as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], '', '', 3);
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], '', '', 3, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', '3');
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', '');
        $this->set('sub_min', '');


        //check second mineral to redirect
        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, '3', '', '');

        $labels = $this->Language->getFormInputLabels('rent', $lang);

        //get the approved & rejected sections
        // $approvedSections = $this->Session->read('approved_sections');
        // $rejectedReasons = $this->Session->read('rejected_reasons');
        $approvedSections = '';
        $rejectedReasons = '';

        $returnDate = $this->Session->read('returnDate');
        $returnType = $this->Session->read('returnType');

        //is mine owner - to show only the 'Next' button and hide the 'Save' button
        // $isMineOwner = $this->Session->read('is_mine_owner');
        $isMineOwner = '';

        //check if the return is all approved - to show the final submit button
        // $is_all_approved = $this->Session->read('is_all_approved');
        $is_all_approved = '';

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

        //rent details edit form
        //check is rejected or approved section
        // if ($approvedSections['partI'][3] == "Rejected") {
        //     $is_rejected_section = 1;
        //     $reasons = $this->getRejectedReasons($mineCode, $returnDate, '', '', 3);
        // } else if ($approvedSections['partI'][3] == "Approved")
        //     $is_rejected_section = 2;
        // else
        $is_rejected_section = ''; // need to review

        $rentDetail = $this->RentReturns->getRentReturnsDetails($mineCode, $returnType, $returnDate);

        $this->set('is_rejected_section', $is_rejected_section);
        $this->set('rentDetail', $rentDetail);
        $this->set('tableForm', null);

        $this->render('/element/monthly/forms/rent_details');

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Details of Rent/Royalty</b> successfully!');
                $this->redirect(array('controller' => 'mms', 'action' => 'working_detail'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Details of Rent/Royalty</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mms', 'action' => 'working_detail'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Details of Rent/Royalty</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'rent'));
            }
        }
    }

    public function workingDetail()
    {

        $this->viewBuilder()->setLayout('mms/form_layout');

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        //if switched directly to part2 through left-nav
        $minerals = $this->Session->read('mineralArr');
        $this->Session->write('min', $minerals[0]);

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        $working_details = $this->WorkStoppage->getWorkingDetails($mineCode, $returnType, $returnDate);

        $total_days = $working_details['total_days'];
        $reason = $working_details['reason'];
        $no_of_days = $working_details['no_of_days'];

        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], '', '', 4);
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], '', '', 4, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', '4');
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', '');
        $this->set('sub_min', '');


        //check second mineral to redirect
        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, '4', '', '');

        $labels = $this->Language->getFormInputLabels('working_detail', $lang);

        $reasonsArr = $this->DirWorkStoppage->getReasonsArr();

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

        //working details edit form
        //check is rejected or approved section
        // if ($approvedSections['partI'][4] == "Rejected") {
        //     $is_rejected_section = 1;
        //     $reasons = $this->getRejectedReasons($mineCode, $returnDate, '', '', 4);
        // } else if ($approvedSections['partI'][4] == "Approved")
        //     $is_rejected_section = 2;
        // else
        $is_rejected_section = ''; // need to review

        $return_m = date('m', strtotime($returnDate));
        $return_Y = date('Y', strtotime($returnDate));
        $month_days = cal_days_in_month(CAL_GREGORIAN, $return_m, $return_Y);
        $this->set('is_rejected_section', $is_rejected_section);
        $workDetail = $this->WorkStoppage->fetchWorkingDetails($mineCode, $returnType, $returnDate);
        $this->set('month_days', $month_days);
        $this->set('workDetail', $workDetail);
        $this->set('tableForm', null);

        $this->render('/element/monthly/forms/working_details');

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Details on Working</b> successfully!');
                $this->redirect(array('controller' => 'mms', 'action' => 'daily_average'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Details on Working</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect(array('controller' => 'mms', 'action' => 'daily_average'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Details on Working</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'working_detail'));
            }
        }
    }

    public function dailyAverage()
    {

        $this->viewBuilder()->setLayout('mms/form_layout');

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        //if switched directly to part2 through left-nav
        $minerals = $this->Session->read('mineralArr');
        $this->Session->write('min', $minerals[0]);

        $formNo = $this->DirMcpMineral->getFormNumber($minerals[0]);

        // below added code add for solve the redirect issues in the mms side.
        //below added code added by ganesh satav dated 9 July 2014
        if ($formNo == 5) {
            $link = 'mms/romF5?min=' . $minerals[0];
        } else if ($formNo == 6) {
            $link = 'mms/gradewiseProdF6?min=' . $minerals[0];
        } else if ($formNo == 7) {
            $link = 'mms/romStocksF7?min=' . $minerals[0];
        } else {
            if ($minerals[0] == 'iron_ore') {
                $link = 'mms/oreType';
            } else {
                $link = 'mms/romStocks?min=' . $minerals[0];
            }
        }

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        $daily_avg = $this->Employment->getDailyAverage($mineCode, $returnType, $returnDate);

        $this->open = $daily_avg['opencast'];
        $this->below = $daily_avg['below'];
        $this->above = $daily_avg['above'];
        $this->total = $daily_avg['total'];

        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], '', '', 5);
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], '', '', 5, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', '5');
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', '');
        $this->set('sub_min', '');


        //check second mineral to redirect
        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, '5', '', '');

        $labels = $this->Language->getFormInputLabels('daily_average', $lang);

        $reasonsArr = $this->DirWorkStoppage->getReasonsArr();

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

        //avg details edit form
        //check is rejected or approved section
        // if ($approvedSections['partI'][5] == "Rejected") {
        //     $is_rejected_section = 1;
        //     $reasons = $this->getRejectedReasons($mineCode, $returnDate, '', '', 5);
        // } else if ($approvedSections['partI'][5] == "Approved")
        //     $is_rejected_section = 2;
        // else
        $is_rejected_section = ''; // need to review

        $returnMonth = $this->Session->read('mc_sel_month');
        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonthTotalDays = cal_days_in_month(CAL_GREGORIAN, $returnMonth, $returnYear);

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

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Average Daily Employment</b> successfully!');
                $this->redirect($this->nextSection('dailyAverage', 'mms'));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Average Daily Employment</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('dailyAverage', 'mms'));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Average Daily Employment</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'daily_average'));
            }
        }
    }


    // PART II: type of ore
    public function oreType($mineral, $sub_min = '')
    {

        $mineral = strtolower($mineral);
        $this->viewBuilder()->setLayout('mms/form_layout');

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        //if switched directly to part2 through left-nav
        $minerals = $this->Session->read('mineralArr');
        $this->Session->write('min', $minerals[0]);

        $formNo = $this->DirMcpMineral->getFormNumber($minerals[0]);

        $estProd = $this->MiningPlan->getEstimatedProd($mineCode, $mineral, $sub_min, $returnYear, $returnDate);
        //below added commented code by ganesh satav call new line commented ganesh satav dated 9 july 2014
        //    $this->cumProd = MINING_PLANTable::getCumProd($this->mineCode, $this->mineral, $this->sub_min, $this->returnYear, $temp[1]);
        //below added code for solving the cumulative production issues by ganesh satav added by ganesh satav dated 9 july 2014
        $cumProd = $this->MiningPlan->getCumProd($mineCode, $mineral, $sub_min, $returnYear, $temp[1], $returnType);

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;


        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        // $rom_prod = $this->Prod1->getRomDetails($mineCode, $returnType, $returnDate, $mineral, $sub_min);
        // $mineral = $rom_prod['mineral_name'];
        // $oc = $rom_prod['oc'];
        // $ug = $rom_prod['ug'];
        // $dw = $rom_prod['dw'];

        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, $sub_min, 1);
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], $mineral, $sub_min, 1, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', '1');
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', $mineral);
        $this->set('sub_min', $sub_min);


        //check second mineral to redirect
        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);

        $labels = $this->Language->getFormInputLabels('ore_type', $lang, $this->Session->read('mc_form_type'));

        $reasonsArr = $this->DirWorkStoppage->getReasonsArr();

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

        $count = 0;
        $chkReturnsRcd1 = true;
        $isExists = $this->Mine->checkMine($mineCode);

        //avg details edit form
        //check is rejected or approved section
        // if ($approvedSections['partI'][5] == "Rejected") {
        //     $is_rejected_section = 1;
        //     $reasons = $this->getRejectedReasons($mineCode, $returnDate, '', '', 5);
        // } else if ($approvedSections['partI'][5] == "Approved")
        //     $is_rejected_section = 2;
        // else
        $is_rejected_section = ''; // need to review


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
        if ($mineral == "iron_ore") {
            $is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, $mineral);
            if ($is_ore_exists == false) {
                echo 'Please select the type of ore';
                // redirect to "SELECT ORE" page
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
        $explosiveTotalRomOre = (isset($explosiveData['total_rom_ore'])) ? $explosiveData['total_rom_ore'] : "";
        //===========explosive consumption value getting ends here============

        $prev_month = date('Y-m-d', strtotime(date("Y-m-d", strtotime($returnDate)) . " -1 month"));

        //GETTING THE ESTIMATED PRODUCTION AND CUMULATIVE PRODUCTION FROM PREVIOUS PRODUCTION
        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
        $estProd = $this->MiningPlan->getEstimatedProdForMms($mineCode, $mineral, $ironSubMin, $returnYear, $returnDate);
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
        $this->set('is_rejected_section', $is_rejected_section);

        $this->render('/element/monthly/forms/ore_type');
        $mineral_url = $mineral;
        $mineral_url .= ($sub_min == '' || $sub_min == null) ? '' : '/' . $sub_min;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Production / Stocks (ROM)</b> successfully!');
                $this->redirect(array('controller' => 'mms', 'action' => 'rom_stocks', $mineral_url));
            } else {
                $this->Session->write('mon_f_err', 'Failed to add comment in <b>Production / Stocks (ROM)</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'rom_stocks', $mineral_url));
            }
        }
    }

    // PART II: production / stoks ROM
    public function romStocks($mineral, $sub_min = '')
    {

        $mineral = strtolower($mineral);
        $this->viewBuilder()->setLayout('mms/form_layout');

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');
        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        //if switched directly to part2 through left-nav
        $minerals = $this->Session->read('mineralArr');
        $this->Session->write('min', $minerals[0]);

        $formNo = $this->DirMcpMineral->getFormNumber($minerals[0]);

        $estProd = $this->MiningPlan->getEstimatedProd($mineCode, $mineral, $sub_min, $returnYear, $returnDate);
        //below added commented code by ganesh satav call new line commented ganesh satav dated 9 july 2014
        //    $this->cumProd = MINING_PLANTable::getCumProd($this->mineCode, $this->mineral, $this->sub_min, $this->returnYear, $temp[1]);
        //below added code for solving the cumulative production issues by ganesh satav added by ganesh satav dated 9 july 2014
        $cumProd = $this->MiningPlan->getCumProd($mineCode, $mineral, $sub_min, $returnYear, $temp[1], $returnType);

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;


        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        // $rom_prod = $this->Prod1->getRomDetails($mineCode, $returnType, $returnDate, $mineral, $sub_min);
        // $mineral = $rom_prod['mineral_name'];
        // $oc = $rom_prod['oc'];
        // $ug = $rom_prod['ug'];
        // $dw = $rom_prod['dw'];

        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, $sub_min, 1, $this->Session->read('mms_user_role'));
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], $mineral, $sub_min, 1, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', '1');
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', $mineral);
        $this->set('sub_min', $sub_min);
        $this->set('ironSubMin', $sub_min);


        //check second mineral to redirect
        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, '1', $mineral, $sub_min);

        $labels = $this->Language->getFormInputLabels('rom_stocks', $lang, $this->Session->read('mc_form_type'));

        $reasonsArr = $this->DirWorkStoppage->getReasonsArr();

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

        //avg details edit form
        //check is rejected or approved section
        // if ($approvedSections['partI'][5] == "Rejected") {
        //     $is_rejected_section = 1;
        //     $reasons = $this->getRejectedReasons($mineCode, $returnDate, '', '', 5);
        // } else if ($approvedSections['partI'][5] == "Approved")
        //     $is_rejected_section = 2;
        // else
        $is_rejected_section = ''; // need to review


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
        if ($mineral == "iron_ore") {
            $is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, $mineral);
            if ($is_ore_exists == false) {
                echo 'Please select the type of ore';
                // redirect to "SELECT ORE" page
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
        $explosiveTotalRomOre = (isset($explosiveData['total_rom_ore'])) ? $explosiveData['total_rom_ore'] : "";
        //===========explosive consumption value getting ends here============

        $prev_month = date('Y-m-d', strtotime(date("Y-m-d", strtotime($returnDate)) . " -1 month"));

        //GETTING THE ESTIMATED PRODUCTION AND CUMULATIVE PRODUCTION FROM PREVIOUS PRODUCTION
        $returnYear = $this->Session->read('mc_sel_year');
        $returnMonth = $this->Session->read('mc_sel_month');
		$estProd = $this->MiningPlan->getEstimatedProd($mineCode, $mineral, $ironSubMin, $returnYear, $returnDate);
        $cumProd = $this->MiningPlan->getCumProd($mineCode, $mineral, $ironSubMin, $returnYear, $returnMonth, $returnType);

        // FOR DISPLAYING ON THE PRODUCTION TABLE----- ADDED BY UDAY
        $mineralName = $mineral;
        $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, $ironSubMin);
        if ($returnType == 'ANNUAL') {
            $prodArrMonthly = $this->Prod1->fetchProductionMonthly($mineCode, $returnType, $returnDate, $mineral, '');
            $this->set('prodArrMonthly', $prodArrMonthly);
        }

        $this->set('tableForm', '');
        $this->set('prev_month', $prev_month);
        $this->set('estProd', $estProd);
        $this->set('cumProd', $cumProd);
        $this->set('prodArr', $prodArr);
        $this->set('mineralName', $mineralName);
        $this->set('ironSubMin', $ironSubMin);
        $this->set('is_rejected_section', $is_rejected_section);

        $this->render('/element/monthly/forms/rom_stocks');

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Production / Stocks (ROM)</b> successfully!');
                $this->redirect($this->nextSection('romStocks', 'mms', $mineral, $sub_min));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Production / Stocks (ROM)</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('romStocks', 'mms', $mineral, $sub_min));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Production / Stocks (ROM)</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'romStocks', $mineral, $sub_min));
            }
        }
    }

    // PART II: Grade-Wise Production
    public function gradewiseProd($mineral, $sub_min = null)
    {

        $this->viewBuilder()->setLayout('mms/form_layout');
        $mineral = strtolower($mineral);
        $minUndLow = str_replace(' ', '_', $mineral); //mineral underscore lowercase

        $ironSubMin = $sub_min;

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        $mineralWorked = $this->MineralWorked->getMineralName($mineCode);
        $formType = $this->DirMcpMineral->getFormNumber($mineralWorked);

        $formNo = $this->DirMcpMineral->getFormNumber($mineral);
        $chemRep = $this->Clscommon->getChemRep($mineral);

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);


        $prodGradeArray = $this->DirMineralGrade->getGradsArrByMin(strtoupper(str_replace('_', ' ', $mineral)), $returnDate);
        // get Grade wise ROM details, Done By Pravin Bhakare, 9/9/2020
        $prodRomGradeArray = $this->DirRomGrade->getGradsArrByMin(strtoupper(str_replace('_', ' ', $mineral)));

        $sub_mineral = '';
        if ($mineral == 'iron_ore') {
            // $sub_min = $this->getRequestParameter('sub_min');
            if ($sub_min == 1)
                $sub_mineral = 'hematite';
            else if ($sub_min == 2)
                $sub_mineral = 'magnetite';
        }


        $grade_prod = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, $mineral, $sub_mineral);

        // Fetch the Grade Rom detail, Done by Pravin Bhakare	14-09-2020
        $grade_rom = $this->GradeRom->getProductionDetails($mineCode, $returnType, $returnDate, $mineral, $sub_mineral);

        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, $sub_min, 2, $this->Session->read('mms_user_role'));
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], $mineral, $sub_min, 2, $this->Session->read('mms_user_role'));
            if (!empty($reason_data) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', '2');
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', $mineral);
        $this->set('sub_min', $sub_min);

        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode, $mineral);
        $this->commentMode($mineCode, $returnDate, $returnType, '2', $mineral, $sub_min);

        $labels = $this->Language->getFormInputLabels('gradewise_prod', $lang, $this->Session->read('mc_form_type'), $this->Session->read('mc_mineral'));

        $reasonsArr = $this->DirWorkStoppage->getReasonsArr();

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

        $returnDate = $this->Session->read('returnDate');

        $returnType = $this->Session->read('returnType');
        if ($returnType == "")
            $returnType = 'MONTHLY';

        $formNo = $this->Session->read('mc_form_type');
        //print_r($formNo); exit;
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

        //avg details edit form
        //check is rejected or approved section
        // if ($approvedSections['partI'][5] == "Rejected") {
        //     $is_rejected_section = 1;
        //     $reasons = $this->getRejectedReasons($mineCode, $returnDate, '', '', 5);
        // } else if ($approvedSections['partI'][5] == "Approved")
        //     $is_rejected_section = 2;
        // else
        $is_rejected_section = ''; // need to review

        //if ore is not selected redirect them (only for iron ore)
        if ($mineral == "iron_ore") {
            $is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, $mineral);
            if ($is_ore_exists == false) {
                echo 'Please select the type of ore';
                // $this->redirect('monthly/F1?partII=ore_type&minaral=iron_ore&MC=' . $this->mineCode . '&M=' . $this->returnMonth . '&Y=' . $this->returnYear);
                // redirect to login
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
        $lumpsCount = (!isset($prodGradeArray['lumps']) || null == $prodGradeArray['lumps']) ? 0 : count($prodGradeArray['lumps']);
        $finesCount = (!isset($prodGradeArray['fines']) || null == $prodGradeArray['fines']) ? 0 : count($prodGradeArray['fines']);
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
        $gradeWiseArrRomMonthly = array();
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
                    $gradeWiseArrRomMonthly = $this->GradeProd->getProductionDataRomMonthly($mineCode, $returnType, $returnDate, "iron ore", "hematite");
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
                    $gradeWiseArrRomMonthly = $this->GradeProd->getProductionDataRomMonthly($mineCode, $returnType, $returnDate, "iron ore", "magnetite");
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
                $gradeWiseArrRomMonthly = $this->GradeProd->getProductionDataRomMonthly($mineCode, $returnType, $returnDate, $mineral);
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

        if ($mineral == "iron ore") {
            if ($ironSubMin == 'hematite') {
                $gradeWiseArr['gradeProd']['gradeValues'] = $this->GradeProd->getProductionDetails($mineCode, $returnType, $returnDate, "iron ore", "hematite");
                $gradeWiseArrMonthly = $this->GradeProd->getProductionDataMonthly($mineCode, $returnType, $returnDate, "iron ore", "hematite");
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
                $gradeWiseArrMonthly = $this->GradeProd->getProductionDataMonthly($mineCode, $returnType, $returnDate, "iron ore", "magnetite");
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
            $gradeWiseArrMonthly = $this->GradeProd->getProductionDataMonthly($mineCode, $returnType, $returnDate, $mineral);
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
        foreach ($gradeWiseArr['gradeProd']['gradeNames'] as $gradeLblKey => $gradeLblVal) {
            foreach ($gradeLblVal as $grKey => $grVal) {
                $gradesArray[$grKey] = $grVal;
            }
        }

        $this->set('gradeWiseProdRom', $gradeWiseArrRom);
        $this->set('gradesArrayRom', $gradesArrayRom);
        $this->set('gradeWiseProd', $gradeWiseArr);
        if ($returnType == 'ANNUAL') {
            $this->set('gradeWiseProdMonthly', $gradeWiseArrMonthly);
            $this->set('gradeWiseProdRomMonthly', $gradeWiseArrRomMonthly);
        }

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

        $this->set('is_rejected_section', $is_rejected_section);
        $this->set('prodRomGradeArray', $prodRomGradeArray);
        $this->set('prodGradeArray', $prodGradeArray);
        $this->set('prodGradeArrayCount', $prodGradeArrayCount);
        $this->set('primaryMineral', $primaryMineral);
        $this->set('gradesArr', $gradesArr);
        $this->set('ironSubMin', $ironSubMin);
        $this->set('tableForm', '');

        $this->render('/element/monthly/forms/grade_wise_production');

        $ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Grade-Wise Production</b> successfully!');
                $this->redirect($this->nextSection('gradewiseProd', 'mms', $mineral, $sub_min));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Grade-Wise Production</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('gradewiseProd', 'mms', $mineral, $sub_min));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Grade-Wise Production</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'gradewiseProd', $mineral, $sub_min));
            }
        }
    }


    // PART II: Pulverisation
    public function pulverisation($mineral, $sub_min = null)
    {

        $this->viewBuilder()->setLayout('mms/form_layout');
        $mineral = strtolower($mineral);

        $ironSubMin = $sub_min;

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);


        $isPulverised = $this->Pulverisation->isPulverised($mineCode, $returnType, $returnDate, $mineral);

        $pulArr = $this->Pulverisation->fetchPulRcd($mineCode, $returnType, $returnDate, $mineral);

        $grades = $this->DirMineralGrade->getGradsbyNameForMMS($mineral);

        //fetch the particular rejected reason
        // Below chnaged line by ganesh satav dated 10 july 2014
        // In the line pass the $this->returnType value before this value not pass that why PULVERISATIONT section reply and refered back not working.
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', 5);
        }

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', 5, $this->Session->read('mms_user_role'));
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', 5, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', '5');
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', $mineral);
        $this->set('sub_min', '');

        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, '5', $mineral, '');

        $labels = $this->Language->getFormInputLabels('pulverisation', $lang);

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
        $grade = $this->Clscommon->getGradeArr(strtoupper(str_replace('_', ' ', $mineral)));

        $pulArr = $this->Pulverisation->fetchPulRcd($mineCode, $returnType, $returnDate, $mineral);
        $pulId = $pulArr[0]['id']; //for hidden field of first row
        $pulRecords = $pulArr;
        $isPulverised = $this->Pulverisation->isPulverised($mineCode, $returnType, $returnDate, $mineral);

        $pulverArr = $this->Pulverisation->getPulverData($mineCode, $returnType, $returnDate, $mineral);
        $pulverArrMonthAll = $this->Pulverisation->getPulverDataMonthAll($mineCode, $returnType, $returnDate, $mineral);

        // CREATE HTML FORM STRUCTURE BY PASSING ARRAYS DATA
        // @addedon: 22nd MAR 2021 (by Aniket Ganvir)
        $tableForm = array();
        $rowArr[0] = $pulverArr;
        $rowArr[1] = $grade;
        $rowArr[2] = $pulverArrMonthAll;
        $tableForm[] = $this->Formcreation->formTableArr('pulverisation', $lang, $rowArr);
        $jsonTableForm = json_encode($tableForm);

        $this->set('tableForm', $jsonTableForm);

        //Pulverisation edit form
        //check is rejected or approved section

        // if ($approvedSections[$mineral][5] == "Rejected") {
        //     $is_rejected_section = 1;
        //     $reasons = $this->getRejectedReasons($mineCode, $returnDate, $mineral, '', 5);
        // } else if ($approvedSections[$mineral][5] == "Approved") {
        //     $is_rejected_section = 2;
        // }
        $is_rejected_section = ''; // need to review

        // $this->pulverisationForm = new pulverisationForm($objPul, array('mineral_name' => strtoupper(str_replace('_', ' ', $this->mineral))));

        $this->set('is_rejected_section', $is_rejected_section);
        $this->set('pulverArr', $pulverArr);
        $this->set('grade', $grade);
        $this->set('isPulverised', $isPulverised);

        $this->render('/element/monthly/forms/pulverisation');

        $ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Pulverisation</b> successfully!');
                $this->redirect($this->nextSection('pulverisation', 'mms', $mineral, $sub_min));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Pulverisation</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('pulverisation', 'mms', $mineral, $sub_min));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Pulverisation</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'pulverisation', $mineral, $sub_min));
            }
        }
    }

    // PART II: Details of Deductions
    public function deductDetail($mineral, $sub_min = null)
    {

        $this->viewBuilder()->setLayout('mms/form_layout');
        $mineral = strtolower($mineral);

        $ironSubMin = $sub_min;

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        if ($sub_min != "")
            $sub_mineral = "&sub_min=" . $sub_min;

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        // print_r("About to call get deduction details");die;
        $deduction = $this->Prod1->getDeductionDetails($mineCode, $returnType, $returnDate, $mineral, $sub_min);
        // $trans = $deduction['trans'];
        // $loading = $deduction['loading'];
        // $railway = $deduction['railway'];
        // $port = $deduction['port'];
        // $sampling = $deduction['sampling'];
        // $plot = $deduction['plot'];
        // $other = $deduction['other'];
        // $totalProd = $deduction['totalProd'];


        $sub_mineral = '';
        if ($mineral == 'iron_ore') {
            $sub_mineral = $sub_min;
        }

        //change storing format according to form type
        $formNo = $this->DirMcpMineral->getFormNumber($mineral);

        if ($formNo == 6)
            $reason_no = 2;
        else if ($formNo == 5)
            $reason_no = 6;
        else
            $reason_no = 3;


        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, $sub_min, $reason_no, $this->Session->read('mms_user_role'));
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], $mineral, $sub_min, $reason_no, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', $reason_no);
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', $mineral);
        $this->set('sub_min', $sub_min);

        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, $reason_no, $mineral, $sub_min);

        $labels = $this->Language->getFormInputLabels('deduct_detail', $lang, $this->Session->read('mc_form_type'));

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
            $isHematite = $objProd['hematite'];
            $isMagnetite = $objProd['magnetite'];
        }

        if ($mineral == "iron_ore") {
            $is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, $mineral);
            if ($is_ore_exists == false) {

                echo 'Please select the type of ore';
                exit;
                // $this->redirect('monthly/F1?partII=ore_type&mineral=iron_ore&MC=' . $this->mineCode . '&M=' . $this->returnMonth . '&Y=' . $this->returnYear);

            }
        }

        //Deduction details edit form
        // Below added code and passsing new value for the function for the fetch the form no as per the mineral this use for the sales_despatches section saving the reply.
        // added by ganesh satav dated on the 17 july 2014
        // Start code
        // $sectionNoAsPerMin = $this->Clscommon->getFormNoFAndH('TRUE');
        // $formNoForDeductionDetRejection =  $sectionNoAsPerMin = $sectionNoAsPerMin['deductions_details'];

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
        $is_rejected_section = ''; // need to review

        if ($ironSubMin != '') {
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, $ironSubMin, 'deductiondet');
            $prodArrMonthAll = $this->Prod1->fetchProductionMonthly($mineCode, $returnType, $returnDate, $mineral, $ironSubMin);
        } else {
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '', 'deductiondet');
            $prodArrMonthAll = $this->Prod1->fetchProductionMonthly($mineCode, $returnType, $returnDate, $mineral, '');
        }

        $prodId = $prodArr['id'];
        $objProd = $this->Prod1->findOneById($prodId);

        $this->set('is_rejected_section', $is_rejected_section);
        $this->set('prodArr', $prodArr);
        if ($returnType == 'ANNUAL') {
            $this->set('prodArrMonthAll', $prodArrMonthAll);
        }
        $this->set('ironSubMin', $ironSubMin);
        $this->set('tableForm', '');

        $this->render('/element/monthly/forms/deductions_details');

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Details Of Deductions</b> successfully!');
                $this->redirect($this->nextSection('deductDetail', 'mms', $mineral, $sub_min));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Details Of Deductions</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('deductDetail', 'mms', $mineral, $sub_min));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Details Of Deductions</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'deductDetail', $mineral, $sub_min));
            }
        }
    }

    // PART II: Sales/Dispatches
    public function saleDespatch($mineral, $sub_min = null)
    {

        $this->viewBuilder()->setLayout('mms/form_layout');
        $mineral = strtolower($mineral);

        $ironSubMin = $sub_min;

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        // $sales = $this->GradeSale->getSalesDispatches($mineCode, $returnType, $returnDate, $mineral);
        // sales data
        $salesData = $this->Sale5->getSalesData($mineCode, $returnDate, $returnType, $mineral);

        $sub_mineral = '';
        if ($mineral == 'iron_ore') {
            $sub_mineral = $sub_min;
        }

        //change storing format according to form type
        $formNo = $this->DirMcpMineral->getFormNumber($mineral);
        if ($formNo == 6)
            $reason_no = 3;
        else if ($formNo == 5)
            $reason_no = 7;
        else
            $reason_no = 4;

        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, $sub_min, $reason_no, $this->Session->read('mms_user_role'));
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], $mineral, $sub_min, $reason_no, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', $reason_no);
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', $mineral);
        $this->set('sub_min', $sub_min);

        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $form_one = array('1', '2', '3', '4', '8');
        $form_main = null;
        if (in_array($formId, $form_one)) {
            $form_main = '1';
        } else if ($formId == '5') {
            $form_main = '2';
        } else if ($formId == '7') {
            $form_main = '3';
        }

        $this->set('mc_form_main', $form_main);

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, $reason_no, $mineral, $sub_min);

        $labels = $this->Language->getFormInputLabels('sale_despatch', $lang, $this->Session->read('mc_form_type'));

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

        $chkReturnsRcd1 = true;
        $grade = $this->Clscommon->getGradeArr(strtoupper(str_replace('_', ' ', $mineral)), $returnDate);
        $unit = $this->DirMcpMineral->getMineralUnit(strtoupper(str_replace('_', ' ', $mineral)));

        /* *** START OF SALES AND DESPATCHES FORM VIEW **** */

        //if ore is not selected redirect them (only for iron ore)
        if ($mineral == "iron_ore") {
            $is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, $mineral);
            if ($is_ore_exists == false) {
                echo 'Please select the type of ore';
                exit;
                // $this->redirect('monthly/F1?partII=ore_type&mineral=iron_ore&MC=' . $this->mineCode . '&M=' . $this->returnMonth . '&Y=' . $this->returnYear);
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
        // $sectionNoAsPerMin = $this->Clscommon->getFormNoFAndH('TRUE');
        // $formNoForSaleDispRejection =  $sectionNoAsPerMin = $sectionNoAsPerMin['sales_despatches'];

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
        $is_rejected_section = ''; // need to review

        $gradeSaleArr = $this->GradeSale->fetchSalesData($mineCode, $returnType, $returnDate, $mineral);
        $gradeSaleMonthlyArr = $this->GradeSale->fetchSalesDataMonthly($mineCode, $returnDate, $mineral);
        $reasonData = $this->IncrDecrReasons->getAllData($mineCode, $returnType, $returnDate, $mineral);
        $clientType = $this->KwClientType->getAllClientType();
        $countryList = $this->DirCountry->getCountryList();

        $this->set('is_rejected_section', $is_rejected_section);
        $this->set('gradeSaleArr', $gradeSaleArr);
        $this->set('reasonData', $reasonData);
        $this->set('ironSubMin', $ironSubMin);
        
		// to check if Magnetite is selected or not, added on 16-08-2022 by Aniket
		$minMagnetite = $this->Prod1->fetchIronTypeProduction($mineCode, $returnType, $returnDate, 'iron_ore', 'magnetite');
		$isMagnetite = ($minMagnetite == true && in_array(strtolower($mineral), array('iron ore','iron_ore'))) ? true : false;

        // CREATE HTML FORM STRUCTURE BY PASSING ARRAYS DATA
        // @addedon: 22nd MAR 2021 (by Aniket Ganvir)
        $rowArr[0] = $gradeSaleArr;
        $rowArr[1] = $grade;
        $rowArr[2] = $clientType;
        $rowArr[3] = $countryList;
        if ($returnType == 'ANNUAL') {
            $rowArr[4] = $gradeSaleMonthlyArr;
        }

        $tableForm = array();
        $tableForm[] = $this->Formcreation->formTableArr('sale_despatch', $lang, $rowArr,$ironSubMin, $isMagnetite);
        $jsonTableForm = json_encode($tableForm);

        $this->set('tableForm', $jsonTableForm);
        if ($returnType == 'ANNUAL') {
            $this->set('diff_color_code', 1); // to display color code for difference between cumulative monthly data & annual return
        }

        $this->render('/element/monthly/forms/sales_despatches');

        $ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;
        $mineral_url = $mineral;
        $mineral_url .= ($sub_min == '' || $sub_min == null) ? '' : '/' . $sub_min;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Sales/Dispatches</b> successfully!');
                $this->redirect($this->nextSection('saleDespatch', 'mms', $mineral, $sub_min));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Sales/Dispatches</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('saleDespatch', 'mms', $mineral, $sub_min));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Sales/Dispatches</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'saleDespatch', $mineral, $sub_min));
            }
        }
    }

    // PART II: Production and Stocks of ROM ore
    public function romStocksOre($mineral, $ironSubMin = null)
    {

        $this->viewBuilder()->setLayout('mms/form_layout');
        $mineral = strtolower($mineral);

        $sub_min = $ironSubMin;

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $period = $returnYear . " - " . ($temp[0] + 1);

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);
        $this->set('period', $period);

        $estProd = $this->MiningPlan->getEstimatedProd($mineCode, $mineral, '', $returnYear, $returnDate);
        $cumProd = $this->MiningPlan->getCumProd($mineCode, $mineral, '', $returnYear, $returnMonth);

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        // get matals
        $metals = $this->DirMetal->getMetalList();
        $metalArr = [];
        foreach ($metals as $key => $val) {
            $metalArr[$val] = $val;
        }
        $prevMonthProd = 0;

        //rom data
        $romData = $this->Rom5->getRomData($mineCode, $returnDate, $returnType, $mineral);
        $romDataMonthAll = $this->Rom5->getRomDataMonthAll($mineCode, $returnDate, $returnType, $mineral);
        // $romData = json_encode(array_merge($data,array('csrf_code'=>'12')));

        $this->set('peirod', $period);
        $this->set('estProd', $estProd);
        $this->set('cumProd', $cumProd);
        $this->set('metals', $metalArr);
        $this->set('romData', $romData);
        if ($returnType == 'ANNUAL') {
            $this->set('romDataMonthAll', $romDataMonthAll);
        }
        $this->set('prevMonthProd', $prevMonthProd);

        $sub_mineral = '';
        if ($mineral == 'iron_ore') {
            $sub_mineral = $sub_min;
        }

        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', 1, $this->Session->read('mms_user_role'));
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', 1, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', 1);
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', $mineral);
        $this->set('sub_min', $sub_min);

        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, '1', $mineral, $sub_min);

        $labels = $this->Language->getFormInputLabels('rom_stocks_ore', $lang);

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

        $chkReturnsRcd1 = true;
        $grade = $this->Clscommon->getGradeArr(strtoupper(str_replace('_', ' ', $mineral)));
        $unit = $this->DirMcpMineral->getMineralUnit(strtoupper(str_replace('_', ' ', $mineral)));

        /* *** START OF SALES AND DESPATCHES FORM VIEW **** */

        //if ore is not selected redirect them (only for iron ore)
        if ($mineral == "iron_ore") {
            $is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, $mineral);
            if ($is_ore_exists == false) {
                echo 'Please select the type of ore';
                exit;
                // $this->redirect('monthly/F1?partII=ore_type&mineral=iron_ore&MC=' . $this->mineCode . '&M=' . $this->returnMonth . '&Y=' . $this->returnYear);
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
        // $sectionNoAsPerMin = $this->Clscommon->getFormNoFAndH('TRUE');
        // $formNoForSaleDispRejection =  $sectionNoAsPerMin = $sectionNoAsPerMin['sales_despatches'];

        // if ($mineral == "iron_ore") {
        //     if ($approvedSections[$mineral][$ironSubMin][4] == "Rejected") {
        //         $is_rejected_section = 1;
        //         $reasons = $this->getRejectedReasons($mineCode, $returnDate, $mineral, $ironSubMin, 4);
        //     } else if ($approvedSections[$mineral][$ironSubMin][4] == "Approved") {
        //         $is_rejected_section = 2;
        //     }
        // } else {

        //     if ($approvedSections[$mineral][$sectionNoAsPerMin] == "Rejected") {
        //         $is_rejected_section = 1;
        /**
         * ADDED THE  $formNoForDeductionDetRejection IN THE CALL
         * EARLIER ONLY 4 WAS PASSING WHICH IS WRONG FOR FORM F5, F6 AND F8
         * @author Uday Shankar Singh
         * @version 10th March 2014
         *
         */
        //             // below line use the new variable value so we get the reply message. variable name $sectionNoAsPerMin
        //         // added by ganesh satav dated on the 21 july 2014
        //         $reasons = $this->getRejectedReasons($mineCode, $returnDate, $mineral, '', $sectionNoAsPerMin);
        //         // end code
        //     } else if ($approvedSections[$mineral][$sectionNoAsPerMin] == "Approved") {
        //         $is_rejected_section = 2;
        //     }
        // }
        $is_rejected_section = ''; // need to review

        $gradeSaleArr = $this->GradeSale->fetchSalesData($mineCode, $returnType, $returnDate, $mineral);
        $reasonData = $this->IncrDecrReasons->getAllData($mineCode, $returnType, $returnDate, $mineral);
        $clientType = $this->KwClientType->getAllClientType();
        $countryList = $this->DirCountry->getCountryList();

        $this->set('is_rejected_section', $is_rejected_section);
        $this->set('gradeSaleArr', $gradeSaleArr);
        $this->set('reasonData', $reasonData);
        $this->set('ironSubMin', $ironSubMin);

        $this->set('tableForm', null);
        if ($returnType == 'ANNUAL') {
            $this->set('diff_color_code', 1); // to display color code for difference between cumulative monthly data & annual return
        }

        $this->render('/element/monthly/forms/rom_stocks_ore');

        $ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;
        $mineral_url = $mineral;
        $mineral_url .= ($sub_min == '' || $sub_min == null) ? '' : '/' . $sub_min;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Production / Stocks (ROM)</b> successfully!');
                $this->redirect($this->nextSection('romStocksOre', 'mms', $mineral, $sub_min));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Production / Stocks (ROM)</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('romStocksOre', 'mms', $mineral, $sub_min));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Production / Stocks (ROM)</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'romStocksOre', $mineral, $sub_min));
            }
        }
    }

    // PART II: Production / Stocks (ROM) for Form F3
    public function romStocksThree($mineral, $sub_min = null)
    {

        $this->viewBuilder()->setLayout('mms/form_layout');
        $mineral = strtolower($mineral);

        $ironSubMin = $sub_min;

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = $temp[1];
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, $returnYear));
        $period = $returnYear . " - " . ($temp[0] + 1);

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        if ($sub_min != "")
            $sub_mineral = "&sub_min=" . $sub_min;

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        //content start

        $estProd = $this->MiningPlan->getEstimatedProd($mineCode, $mineral, $sub_min, $returnYear, $returnDate);
        // $cumProd = $this->MiningPlan->getCumProd($mineCode, $mineral, $sub_min, $returnYear, $temp[1]);
        $cumProd = $this->MiningPlan->getCumProd($mineCode, $mineral, $ironSubMin, $returnYear, $returnMonth, $returnType);
        $min = strtoupper($mineral);
        $minUnit = $this->DirMcpMineral->getMineralUnit($min);
        $romData = $this->RomStone->getRomData($mineCode, $returnType, $returnDate, $mineral);
        $romDataMonthAll = $this->RomStone->getRomDataMonthAll($mineCode, $returnType, $returnDate, $mineral);
        $this->set('mineralName', $mineral);
        $this->set('period', $period);
        $this->set('estProd', $estProd);
        $this->set('cumProd', $cumProd);
        $this->set('minUnit', $minUnit);
        $this->set('romData', $romData);
        if ($returnType == 'ANNUAL') {
            $this->set('romDataMonthAll', $romDataMonthAll);
        }

        //content end

        $sub_mineral = '';
        if ($mineral == 'iron_ore') {
            $sub_mineral = $sub_min;
        }

		if (null !== $sub_min) {
			$ironSubMin = $sub_min;
			$ironSubMinStr = "&iron_sub_min=" . $ironSubMin;
		} else {
			$ironSubMin = "";
			$ironSubMinStr = '';
		}

        //change storing format according to form type
        $formNo = $this->DirMcpMineral->getFormNumber($mineral);

        if ($formNo == 6)
            $reason_no = 3;
        else if ($formNo == 5)
            $reason_no = 7;
        else
            $reason_no = 4;


        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', 2);
        }

        $reason_no = 1;
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', $reason_no, $this->Session->read('mms_user_role'));
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', $reason_no, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', $reason_no);
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', $mineral);
        $this->set('sub_min', $sub_min);

        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, $reason_no, $mineral, $sub_min);

        $labels = $this->Language->getFormInputLabels('rom_stocks_three', $lang);

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
            $isHematite = $objProd['hematite'];
            $isMagnetite = $objProd['magnetite'];
        }

        if ($mineral == "iron_ore") {
            $is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, $mineral);
            if ($is_ore_exists == false) {

                echo 'Please select the type of ore';
                exit;
                // $this->redirect('monthly/F1?partII=ore_type&mineral=iron_ore&MC=' . $this->mineCode . '&M=' . $this->returnMonth . '&Y=' . $this->returnYear);

            }
        }

        //Deduction details edit form
        // Below added code and passsing new value for the function for the fetch the form no as per the mineral this use for the sales_despatches section saving the reply.
        // added by ganesh satav dated on the 17 july 2014
        // Start code
        // $sectionNoAsPerMin = $this->Clscommon->getFormNoFAndH('TRUE');
        // $formNoForDeductionDetRejection =  $sectionNoAsPerMin = $sectionNoAsPerMin['deductions_details'];

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
        $is_rejected_section = ''; // need to review

        if ($ironSubMin != '')
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, $ironSubMin);
        else
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '');

        $prodId = $prodArr['id'];
        $objProd = $this->Prod1->findOneById($prodId);

        $this->set('is_rejected_section', $is_rejected_section);
        $this->set('prodArr', $prodArr);
        $this->set('ironSubMin', $ironSubMin);
        $this->set('tableForm', null);

        $this->render('/element/monthly/forms/rom_stocks_three');

        $ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;
        $mineral_url = $mineral;
        $mineral_url .= ($sub_min == '' || $sub_min == null) ? '' : '/' . $sub_min;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Production / Stocks (ROM)</b> successfully!');
                $this->redirect($this->nextSection('romStocksThree', 'mms', $mineral, $sub_min));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Production / Stocks (ROM)</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('romStocksThree', 'mms', $mineral, $sub_min));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Production / Stocks (ROM)</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'romStocksThree', $mineral, $sub_min));
            }
        }
    }


    // PART II: Production, Despatches and Stocks for Form F3
    public function prodStockDis($mineral, $sub_min = null)
    {

        $this->viewBuilder()->setLayout('mms/form_layout');
        $mineral = strtolower($mineral);

        $ironSubMin = $sub_min;

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        if ($sub_min != "")
            $sub_mineral = "&sub_min=" . $sub_min;

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        //content start

        $min = strtoupper($mineral);
        $minUnit = $this->DirMcpMineral->getMineralUnit($min);
        $roughStoneData = $this->ProdStone->getProdStoneData($mineCode, $returnDate, $mineral, 1, $returnType);
        $cutStoneData = $this->ProdStone->getProdStoneData($mineCode, $returnDate, $mineral, 2, $returnType);
        $indStoneData = $this->ProdStone->getProdStoneData($mineCode, $returnDate, $mineral, 3, $returnType);
        $othStoneData = $this->ProdStone->getProdStoneData($mineCode, $returnDate, $mineral, 99, $returnType);
        $stoneDataMonthAll['rough'] = $this->ProdStone->getProdStoneDataMonthAll($mineCode, $returnDate, $mineral, 1, $returnType);
        $stoneDataMonthAll['cut'] = $this->ProdStone->getProdStoneDataMonthAll($mineCode, $returnDate, $mineral, 2, $returnType);
        $stoneDataMonthAll['ind'] = $this->ProdStone->getProdStoneDataMonthAll($mineCode, $returnDate, $mineral, 3, $returnType);
        $stoneDataMonthAll['oth'] = $this->ProdStone->getProdStoneDataMonthAll($mineCode, $returnDate, $mineral, 99, $returnType);
        $this->set('minUnit', $minUnit);
        $this->set('roughStone', $roughStoneData);
        $this->set('cutStone', $cutStoneData);
        $this->set('indStone', $indStoneData);
        $this->set('othStone', $othStoneData);
        if ($returnType == 'ANNUAL') {
            $this->set('stoneDataMonthAll', $stoneDataMonthAll);
        }

        //content end

        $sub_mineral = '';
        if ($mineral == 'iron_ore') {
            $sub_mineral = $sub_min;
        }

        //change storing format according to form type
        $formNo = $this->DirMcpMineral->getFormNumber($mineral);

        if ($formNo == 6)
            $reason_no = 3;
        else if ($formNo == 5)
            $reason_no = 7;
        else
            $reason_no = 4;


        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', 1);
        }

        $reason_no = 2;
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', $reason_no, $this->Session->read('mms_user_role'));
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', $reason_no, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', $reason_no);
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', $mineral);
        $this->set('sub_min', $sub_min);

        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, $reason_no, $mineral, $sub_min);

        $labels = $this->Language->getFormInputLabels('prod_stock_dis', $lang);

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
            $isHematite = $objProd['hematite'];
            $isMagnetite = $objProd['magnetite'];
        }

        if ($mineral == "iron_ore") {
            $is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, $mineral);
            if ($is_ore_exists == false) {

                echo 'Please select the type of ore';
                exit;
                // $this->redirect('monthly/F1?partII=ore_type&mineral=iron_ore&MC=' . $this->mineCode . '&M=' . $this->returnMonth . '&Y=' . $this->returnYear);

            }
        }

        //Deduction details edit form
        // Below added code and passsing new value for the function for the fetch the form no as per the mineral this use for the sales_despatches section saving the reply.
        // added by ganesh satav dated on the 17 july 2014
        // Start code
        // $sectionNoAsPerMin = $this->Clscommon->getFormNoFAndH('TRUE');
        // $formNoForDeductionDetRejection =  $sectionNoAsPerMin = $sectionNoAsPerMin['deductions_details'];

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
        $is_rejected_section = ''; // need to review

        if ($ironSubMin != '')
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, $ironSubMin);
        else
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '');

        $prodId = $prodArr['id'];
        $objProd = $this->Prod1->findOneById($prodId);

        $this->set('is_rejected_section', $is_rejected_section);
        $this->set('prodArr', $prodArr);
        $this->set('ironSubMin', $ironSubMin);
        $this->set('tableForm', '');

        $this->render('/element/monthly/forms/prod_stock_dis');

        $ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;
        $mineral_url = $mineral;
        $mineral_url .= ($sub_min == '' || $sub_min == null) ? '' : '/' . $sub_min;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Production, Despatches and Stocks</b> successfully!');
                $this->redirect($this->nextSection('prodStockDis', 'mms', $mineral, $sub_min));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Production, Despatches and Stocks</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('prodStockDis', 'mms', $mineral, $sub_min));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Production, Despatches and Stocks</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'prodStockDis', $mineral, $sub_min));
            }
        }
    }


    // PART II: EX-MINE
    public function exMine($mineral, $sub_min = null)
    {

        $this->viewBuilder()->setLayout('mms/form_layout');
        $mineral = strtolower($mineral);

        $ironSubMin = $sub_min;

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        if ($sub_min != "")
            $sub_mineral = "&sub_min=" . $sub_min;

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        //content start

        $period = $returnYear . " - " . ($temp[0] + 1);
        //to make the exmine price max value > 0
        $romProduction = $this->Rom5->getTotalProduction($mineCode, $returnDate, $returnType, $mineral);
        $prod5Id = $this->Prod5->getExMineProd5Id($mineCode, $returnType, $returnDate, $mineral);
        $prod5 = $this->Prod5->getExMineProd5($mineCode, $returnType, $returnDate, $mineral);
        $prod5MonthAll = $this->Prod5->getExMineProd5MonthAll($mineCode, $returnType, $returnDate, $mineral);
        $this->set('period', $period);
        $this->set('romProduction', $romProduction);
        $this->set('prod5Id', $prod5Id);
        $this->set('prod5', $prod5);
        if ($returnType == 'ANNUAL') {
            $this->set('prod5MonthAll', $prod5MonthAll);
        }

        //content end

        $sub_mineral = '';
        if ($mineral == 'iron_ore') {
            $sub_mineral = $sub_min;
        }

        //change storing format according to form type
        $formNo = $this->DirMcpMineral->getFormNumber($mineral);

        if ($formNo == 6)
            $reason_no = 3;
        else if ($formNo == 5)
            $reason_no = 7;
        else
            $reason_no = 4;


        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', 1);
        }

        $reason_no = 2;
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', $reason_no, $this->Session->read('mms_user_role'));
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', $reason_no, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', $reason_no);
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', $mineral);
        $this->set('sub_min', $sub_min);

        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, $reason_no, $mineral, '');

        $labels = $this->Language->getFormInputLabels('ex_mine', $lang);

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
            $isHematite = $objProd['hematite'];
            $isMagnetite = $objProd['magnetite'];
        }

        if ($mineral == "iron_ore") {
            $is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, $mineral);
            if ($is_ore_exists == false) {

                echo 'Please select the type of ore';
                exit;
                // $this->redirect('monthly/F1?partII=ore_type&mineral=iron_ore&MC=' . $this->mineCode . '&M=' . $this->returnMonth . '&Y=' . $this->returnYear);

            }
        }

        //Deduction details edit form
        // Below added code and passsing new value for the function for the fetch the form no as per the mineral this use for the sales_despatches section saving the reply.
        // added by ganesh satav dated on the 17 july 2014
        // Start code
        // $sectionNoAsPerMin = $this->Clscommon->getFormNoFAndH('TRUE');
        // $formNoForDeductionDetRejection =  $sectionNoAsPerMin = $sectionNoAsPerMin['deductions_details'];

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
        $is_rejected_section = ''; // need to review

        if ($ironSubMin != '')
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, $ironSubMin);
        else
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '');

        $prodId = $prodArr['id'];
        $objProd = $this->Prod1->findOneById($prodId);

        $this->set('is_rejected_section', $is_rejected_section);
        $this->set('prodArr', $prodArr);
        $this->set('ironSubMin', $ironSubMin);
        $this->set('tableForm', '');

        $this->render('/element/monthly/forms/ex_mine');

        $ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;
        $mineral_url = $mineral;
        $mineral_url .= ($sub_min == '' || $sub_min == null) ? '' : '/' . $sub_min;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Ex-Mine Price</b> successfully!');
                $this->redirect($this->nextSection('exMine', 'mms', $mineral));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Ex-Mine Price</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('exMine', 'mms', $mineral));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Ex-Mine Price</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'exMine', $mineral));
            }
        }
    }

    // PART II: Recoveries at Concentrator
    public function conReco($mineral, $sub_min = null)
    {

        $this->viewBuilder()->setLayout('mms/form_layout');
        $mineral = strtolower($mineral);

        $ironSubMin = $sub_min;

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        if ($sub_min != "")
            $sub_mineral = "&sub_min=" . $sub_min;

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        //content start

        // get metals
        $metals = $this->DirMetal->getMetalList();
        $metalArr = [];
        foreach ($metals as $key => $val) {
            $metalArr[$val] = $val;
        }
        // con and rom data
        $conRomData = $this->RomMetal5->getConRomData($mineCode, $returnDate, $returnType, $mineral);
        $conRomDataMonthAll = $this->RomMetal5->getConRomDataMonthAll($mineCode, $returnDate, $returnType, $mineral);
        $this->set('metals', $metalArr);
        $this->set('conRomData', $conRomData);
        if ($returnType == 'ANNUAL') {
            $this->set('conRomDataMonthAll', $conRomDataMonthAll);
        }
        $this->set('prevMonthProd', 0);

        //content end

        $sub_mineral = '';
        if ($mineral == 'iron_ore') {
            $sub_mineral = $sub_min;
        }

        //change storing format according to form type
        $formNo = $this->DirMcpMineral->getFormNumber($mineral);

        if ($formNo == 6)
            $reason_no = 3;
        else if ($formNo == 5)
            $reason_no = 7;
        else
            $reason_no = 4;


        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', 1);
        }

        $reason_no = 3;
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', $reason_no, $this->Session->read('mms_user_role'));
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', $reason_no, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', $reason_no);
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', $mineral);
        $this->set('sub_min', $sub_min);

        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, $reason_no, $mineral, '');

        $labels = $this->Language->getFormInputLabels('con_reco', $lang);

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
            $isHematite = $objProd['hematite'];
            $isMagnetite = $objProd['magnetite'];
        }

        if ($mineral == "iron_ore") {
            $is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, $mineral);
            if ($is_ore_exists == false) {

                echo 'Please select the type of ore';
                exit;
                // $this->redirect('monthly/F1?partII=ore_type&mineral=iron_ore&MC=' . $this->mineCode . '&M=' . $this->returnMonth . '&Y=' . $this->returnYear);

            }
        }

        //Deduction details edit form
        // Below added code and passsing new value for the function for the fetch the form no as per the mineral this use for the sales_despatches section saving the reply.
        // added by ganesh satav dated on the 17 july 2014
        // Start code
        // $sectionNoAsPerMin = $this->Clscommon->getFormNoFAndH('TRUE');
        // $formNoForDeductionDetRejection =  $sectionNoAsPerMin = $sectionNoAsPerMin['deductions_details'];

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
        $is_rejected_section = ''; // need to review

        if ($ironSubMin != '')
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, $ironSubMin);
        else
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '');

        $prodId = $prodArr['id'];
        $objProd = $this->Prod1->findOneById($prodId);

        $this->set('is_rejected_section', $is_rejected_section);
        $this->set('prodArr', $prodArr);
        $this->set('ironSubMin', $ironSubMin);
        $this->set('tableForm', '');

        $this->render('/element/monthly/forms/con_reco');

        $ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;
        $mineral_url = $mineral;
        $mineral_url .= ($sub_min == '' || $sub_min == null) ? '' : '/' . $sub_min;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Recoveries at Concentrator</b> successfully!');
                $this->redirect($this->nextSection('conReco', 'mms', $mineral, $sub_min));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Recoveries at Concentrator</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('conReco', 'mms', $mineral, $sub_min));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Recoveries at Concentrator</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'conReco', $mineral, $sub_min));
            }
        }
    }

    // PART II: Recoveries at the Smelter
    public function smeltReco($mineral, $sub_min = null)
    {

        $this->viewBuilder()->setLayout('mms/form_layout');
        $mineral = strtolower($mineral);

        $ironSubMin = $sub_min;

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        if ($sub_min != "")
            $sub_mineral = "&sub_min=" . $sub_min;

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        //content start

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
        $recoveryDataMonthAll = $this->RecovSmelter->getRecoveryDataMonthAll($mineCode, $returnDate, $returnType, $mineral);
        $this->set('metals', $metalArr);
        $this->set('products', $productArr);
        $this->set('recoveryData', $recoveryData);
        if ($returnType == 'ANNUAL') {
            $this->set('recoveryDataMonthAll', $recoveryDataMonthAll);
        }

        //content end

        $sub_mineral = '';
        if ($mineral == 'iron_ore') {
            $sub_mineral = $sub_min;
        }

        //change storing format according to form type
        $formNo = $this->DirMcpMineral->getFormNumber($mineral);

        if ($formNo == 6)
            $reason_no = 3;
        else if ($formNo == 5)
            $reason_no = 7;
        else
            $reason_no = 4;


        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', 1);
        }

        $reason_no = 4;
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', $reason_no, $this->Session->read('mms_user_role'));
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', $reason_no, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', $reason_no);
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', $mineral);
        $this->set('sub_min', $sub_min);

        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, $reason_no, $mineral, '');

        $labels = $this->Language->getFormInputLabels('smelt_reco', $lang);

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
            $isHematite = $objProd['hematite'];
            $isMagnetite = $objProd['magnetite'];
        }

        if ($mineral == "iron_ore") {
            $is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, $mineral);
            if ($is_ore_exists == false) {

                echo 'Please select the type of ore';
                exit;
                // $this->redirect('monthly/F1?partII=ore_type&mineral=iron_ore&MC=' . $this->mineCode . '&M=' . $this->returnMonth . '&Y=' . $this->returnYear);

            }
        }

        //Deduction details edit form
        // Below added code and passsing new value for the function for the fetch the form no as per the mineral this use for the sales_despatches section saving the reply.
        // added by ganesh satav dated on the 17 july 2014
        // Start code
        // $sectionNoAsPerMin = $this->Clscommon->getFormNoFAndH('TRUE');
        // $formNoForDeductionDetRejection =  $sectionNoAsPerMin = $sectionNoAsPerMin['deductions_details'];

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
        $is_rejected_section = ''; // need to review

        if ($ironSubMin != '')
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, $ironSubMin);
        else
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '');

        $prodId = $prodArr['id'];
        $objProd = $this->Prod1->findOneById($prodId);

        $this->set('is_rejected_section', $is_rejected_section);
        $this->set('prodArr', $prodArr);
        $this->set('ironSubMin', $ironSubMin);
        $this->set('tableForm', '');
		$this->set('diff_color_code', 1); // to display color code for difference between cumulative monthly data & annual return

        $this->render('/element/monthly/forms/smelt_reco');

        $ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;
        $mineral_url = $mineral;
        $mineral_url .= ($sub_min == '' || $sub_min == null) ? '' : '/' . $sub_min;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Recovery at the Smelter</b> successfully!');
                $this->redirect($this->nextSection('smeltReco', 'mms', $mineral));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Recovery at the Smelter</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('smeltReco', 'mms', $mineral));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Recovery at the Smelter</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'smeltReco', $mineral));
            }
        }
    }

    // PART II: Sales(Metals/By Product)
    public function salesMetalProduct($mineral, $sub_min = null)
    {

        $this->viewBuilder()->setLayout('mms/form_layout');
        $mineral = strtolower($mineral);

        $ironSubMin = $sub_min;

        $mineCode = $this->Session->read('mc_mine_code');
        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');

        $temp = explode('-', $returnDate);
        $returnYear = $temp[0];
        $returnMonth = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));
        $returnMonthName = date("M", mktime(0, 0, 0, $temp[1], 1, 2011));

        //for hiding the action buttons for master admin alone
        $master_admin = false;
        $role = $this->Session->read('mms_user_role');
        if ($role == 1)
            $master_admin = true;

        $is_pri_pending = false;
        if (null !== $this->Session->read('is_pri_pending')) {
            $is_pending = $this->Session->read('is_pri_pending');
            if ($is_pending == 1) {
                $is_pri_pending = true;
            }
        }

        $viewOnly = ($role == 2 || $role == 3) ? false : true;
        $this->set('viewOnly', $viewOnly);
        $this->set('is_pri_pending', $is_pri_pending);
        $this->set('view', $this->Session->read('form_status'));
        $this->set('returnDate', $returnDate);

        if ($sub_min != "")
            $sub_mineral = "&sub_min=" . $sub_min;

        // below added code added by ganesh satav
        // below added code for take for no
        // start code
        $primaryMineral = $this->MineralWorked->getPrimaryMineralName($mineCode);
        $formNumber = $this->DirMcpMineral->getFormNumber($primaryMineral);
        $secondaryMineral = $this->MineralWorked->getOtherMinerals($mineCode);
        if ($returnType == 'ANNUAL')
            $formName = 'H-' . $formNumber;
        else
            $formName = 'F-' . $formNumber;

        $this->Session->write('mc_form_type', $formNumber);
        //=========================DECIDING THE RULE TYPE===========================
        $formRuleNumber = $this->Clscommon->getFormRuleNumber($formNumber);

        // GETS THE REPORT HOME PAGE
        $return_home_page = $this->Session->read('report_home_page');
        $this->set('return_home_page', $return_home_page);

        //content start

        // get product list
        $products = $this->DirProduct->getProductList();
        $productArr = [];
        foreach ($products as $key => $val) {
            $productArr[$val] = $val;
        }
        // sales data
        $salesData = $this->Sale5->getSalesData($mineCode, $returnDate, $returnType, $mineral);
        $salesDataMonthAll = $this->Sale5->getSalesDataMonthAll($mineCode, $returnDate, $returnType, $mineral);

		// recovery data for comparison with sales data
		$recoveryData = $this->RecovSmelter->getRecoveryData($mineCode, $returnDate, $returnType, $mineral, 1);
        $this->set('products', $productArr);
        $this->set('salesData', $salesData);
		$this->set('recoveryData', $recoveryData['con_metal']);
        if ($returnType == 'ANNUAL') {
            $this->set('salesDataMonthAll', $salesDataMonthAll);
        }

        //content end

        $sub_mineral = '';
        if ($mineral == 'iron_ore') {
            $sub_mineral = $sub_min;
        }

        //change storing format according to form type
        $formNo = $this->DirMcpMineral->getFormNumber($mineral);

        if ($formNo == 6)
            $reason_no = 3;
        else if ($formNo == 5)
            $reason_no = 7;
        else
            $reason_no = 4;


        //fetch the particular rejected reason
        $return_id = $this->TblFinalSubmit->getReturnId($mineCode, $returnDate, $returnType);

        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', 1);
        }

        $reason_no = 5;
        $commented_status = '0';
        $reasons = array();
        foreach ($return_id as $r) {
            $reasons[] = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', $reason_no, $this->Session->read('mms_user_role'));
            $reason_data = $this->TblFinalSubmit->getReason($r['id'], $mineral, '', $reason_no, $this->Session->read('mms_user_role'));
            if (isset($reason_data['commented']) && $reason_data['commented'] == '1') {
                $commented_status = '1';
            }
        }

        $mmsUserId = $this->Session->read('mms_user_id');
        $mmsUserRole = $this->Session->read('mms_user_role');
        $commentLabel = $this->Customfunctions->getCommentLabel($this->Session->read('mms_user_role'));
        $this->set('mmsUserRole', $mmsUserRole);
        $this->set('commented_status', $commented_status);
        $this->set('mmsUserId', $mmsUserId);
        $this->set('sectionId', $reason_no);
        $this->set('reasons', $reasons);
        $this->set('commentLabel', $commentLabel);
        $this->set('part_no', '');
        $this->set('mineral', $mineral);
        $this->set('sub_min', $sub_min);

        $mineCode = $this->Session->read('mc_mine_code');
        $formId = $this->Session->read('mc_form_type');
        $lang = $this->Session->read('lang');

        $this->ironOreCategory($mineCode, $returnType, $returnDate);
        $this->executeUserleftnav($mineCode);
        $this->commentMode($mineCode, $returnDate, $returnType, $reason_no, $mineral, '');

        $labels = $this->Language->getFormInputLabels('sales_metal_product', $lang);

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
            $isHematite = $objProd['hematite'];
            $isMagnetite = $objProd['magnetite'];
        }

        if ($mineral == "iron_ore") {
            $is_ore_exists = $this->Prod1->isOreExists($mineCode, $returnType, $returnDate, $mineral);
            if ($is_ore_exists == false) {

                echo 'Please select the type of ore';
                exit;
                // $this->redirect('monthly/F1?partII=ore_type&mineral=iron_ore&MC=' . $this->mineCode . '&M=' . $this->returnMonth . '&Y=' . $this->returnYear);

            }
        }

        //Deduction details edit form
        // Below added code and passsing new value for the function for the fetch the form no as per the mineral this use for the sales_despatches section saving the reply.
        // added by ganesh satav dated on the 17 july 2014
        // Start code
        // $sectionNoAsPerMin = $this->Clscommon->getFormNoFAndH('TRUE');
        // $formNoForDeductionDetRejection =  $sectionNoAsPerMin = $sectionNoAsPerMin['deductions_details'];

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
        $is_rejected_section = ''; // need to review

        if ($ironSubMin != '')
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, $ironSubMin);
        else
            $prodArr = $this->Prod1->fetchProduction($mineCode, $returnType, $returnDate, $mineral, '');

        $prodId = $prodArr['id'];
        $objProd = $this->Prod1->findOneById($prodId);

        $this->set('is_rejected_section', $is_rejected_section);
        $this->set('prodArr', $prodArr);
        $this->set('ironSubMin', $ironSubMin);
        $this->set('tableForm', '');

        $this->render('/element/monthly/forms/sales_metal_product');

        $ironSubMin = ($ironSubMin == null) ? "" : "/" . $ironSubMin;
        $mineral_url = $mineral;
        $mineral_url .= ($sub_min == '' || $sub_min == null) ? '' : '/' . $sub_min;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            if ($result == 1) {
                $this->Session->write('mon_f_suc', 'Comment added in <b>Sales (Metal/by Product)</b> successfully!');
                $this->redirect($this->nextSection('salesMetalProduct', 'mms', $mineral));
            } else if ($result == 3) {
                $this->Session->write('mon_f_suc', '<b>Sales (Metal/by Product)</b> section succesfully <b><u>approved</u></b>!');
                $this->redirect($this->nextSection('salesMetalProduct', 'mms', $mineral));
            } else if ($result == 4) {
                $this->Session->write('process_msg', $returnType . ' return successfully approved!');
                $this->redirect(array('controller' => 'mms', 'action' => 'home'));
            } else if ($result == 5) {
                $this->Session->write('mon_f_err', 'You cannot approve section <b>5. Sales during the month</b> because section <b>5. Sales during the month</b> is dependent on section <b>4. Recovery at the Smelter-Mill-Plant</b>: which is currently referred!');
                $this->redirect($this->nextSection('salesMetalProduct', 'mms', $mineral));
            } else {
                $this->Session->write('mon_f_err', 'Something went wrong for <b>Sales (Metal/by Product)</b>! Please, try again later.');
                $this->redirect(array('controller' => 'mms', 'action' => 'salesMetalProduct', $mineral));
            }
        }
    }

    /**
     * UPDATE REJECT REASON COMMENT THROUGH AJAX CALL
     * @addedon: 08th APR 2021 (by Aniket Ganvir)
     */
    public function updateComment()
    {

        $this->autoRender = false;

        if ($this->request->is('post')) {

            $return_id = $this->request->getData('returnId');
            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData(), $return_id);
            echo $result;
        }
    }


    /**
     * Update reject reason comment through ajax call
     * @version 06th Nov 2021
     * @author Aniket Ganvir
     */
    public function updateCommentAnnual()
    {

        $this->autoRender = false;

        if ($this->request->is('post')) {

            $return_id = $this->request->getData('returnId');
            $result = $this->TblFinalSubmit->saveApproveRejectAnnual($this->request->getData(), $return_id);
            echo $result;
        }
    }

    /**
     * REMOVE REJECT REASON COMMENT THROUGH AJAX CALL
     * @addedon: 08th APR 2021 (by Aniket Ganvir)
     */
    public function removeComment()
    {

        $this->autoRender = false;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->remComment($this->request->getData());
            echo $result;
        }
    }


    /**
     * Remove reject reason comment through ajax call
     * @version 06th Nov 2021
     * @author Aniket Ganvir
     */
    public function removeCommentAnnual()
    {

        $this->autoRender = false;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->remCommentAnnual($this->request->getData());
            echo $result;
        }
    }


    /**
     * FUNCTION TO CHECK SUPERVISOR COMMENT ON SECTIONS
     * RETURN '1' IF ONE OR MORE COMMENT MADE ON SECTION
     * RETURN '0' IF NO COMMENT MADE ON ANY SECTION
     * @addedon: 12th APR 2021 (by Aniket Ganvir)
     */
    public function commentStatus($mine_code)
    {

        $returnType = $this->Session->read('returnType');
        $returnDate = $this->Session->read('returnDate');

        $latestReason = $this->TblFinalSubmit->getLatestReasons($mine_code, $returnDate, $returnType);
        $reasons = unserialize($latestReason['rejected_section_remarks']);

        $commentStatus = '0';

        if ($reasons != '') {
            foreach ($reasons as $reason) {

                foreach ($reason as $rsn) {
                    if ($rsn != '') {
                        $commentStatus = '1';
                    }
                }
            }
        }

        $this->Session->write('comment_status', $commentStatus);
    }

    /**
     * REDIRECT TO THE NEXT SECTION
     * @addedon: 13th APR 2021 (by Aniket Ganvir)
     */
    public function nextSection($action_name, $cntrl = null, $mineral = null, $sub_min = null)
    {

        $controller = ($cntrl == null) ? 'mms' : strtolower($cntrl);
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
     * @addedon: 23th JUL 2021 (by Aniket Ganvir)
     */
    public function prevSection($action_name, $cntrl = null, $mineral = null, $sub_min = null)
    {

        $controller = ($cntrl == null) ? 'mms' : strtolower($cntrl);
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

    /**
     * Get next section link for redirection purpose
     * @version 24th Nov 2021
     * @author Aniket Ganvir
     */
    public function findNextSection($section_url)
    {

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
     * REFERRED BACK TO THE USER
     * @addedon: 13th APR 2021
     */
    public function referredBack()
    {

        $this->autoRender = false;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());
            
            $user_id = $this->request->getData('mms_user_id');
            $this->loadModel('MmsUser');
            $user = $this->MmsUser->findOneById($user_id);
            $role = $user['role_id'];
            if ($role == 2){
                $is_supervisor = true;
                // send sms
                $customer_id = $_SESSION['applicantid'];
                $this->loadModel('DirSmsEmailTemplates');
                $this->DirSmsEmailTemplates->sendMessage(9,$customer_id);
            }
            
            echo $result;
        }
    }

    /**
     * APPROVE MONTHLY RETURN
     * @addedon: 20th APR 2021
     */
    public function approveReturn()
    {

        $this->autoRender = false;

        if ($this->request->is('post')) {

            // $postData = $this->request->getData();
            // if (null !== $this->Sesssion->read("main_sec")) {
            //     $main_sec = serialize($this->Sesssion->read("main_sec"));
            //     $postData['main_sec']
            // }

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            echo $result;
        }
    }
    /**
     * DISAPPROVE THE RETURN
     * @addedon: 19th DEC 2022
     */
    public function disapproveReturn()
    {

        $this->autoRender = false;

        if ($this->request->is('post')) {

            $result = $this->TblFinalSubmit->saveApproveReject($this->request->getData());

            echo $result;
        }
    }

    public function ironOreCategory($mine_code, $returnType, $returnDate)
    {

        $minHematite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'hematite');
        $minMagnetite = $this->Prod1->fetchIronTypeProduction($mine_code, $returnType, $returnDate, 'iron_ore', 'magnetite');

        if ($minHematite == true) {
            $is_hematite = true;
        } else {
            $is_hematite = false;
        }

        if ($minMagnetite == true) {
            $is_magnetite = true;
        } else {
            $is_magnetite = false;
        }
        $this->Session->write('is_hematite', $is_hematite);
        $this->Session->write('is_magnetite', $is_magnetite);
    }


    /**
     * SET COMMENT MODE "EDITABLE" OR "READABLE" AS PER RETURN STATUS
     * @version 16th Dec 2021
     * @author Aniket Ganvir
     */
    public function commentMode($mineCode, $returnDate, $returnType, $secId, $min, $subMin)
    {

        $returnId = $this->TblFinalSubmit->getLatestReturnId($mineCode, $returnDate, $returnType);
        $returnData = $this->TblFinalSubmit->findReturnById($returnId);
        $status = array('0', '2');
        $comment_mode = (in_array($returnData['status'], $status)) ? 'edit' : 'read';
        //$comment_mode = ($returnData['status'] == 0) ? 'edit' : 'read';
        $min = strtolower(str_replace(' ', '_', $min));
        $referBackBtn = 0;
        $disapproveBtn = 0;
        $verifiedFlag = $returnData['verified_flag'];

        if ($comment_mode == 'edit') {

            $tmpSec = $returnData['approved_sections'];
            $appSec = unserialize($tmpSec);

            if ($min == '') {

                if (isset($appSec['partI'][$secId]) && $appSec['partI'][$secId] == 'Approved') {
                    $comment_mode = 'read';
                }
            } else if ($min == 'iron_ore') {

                if (isset($appSec[$min][$subMin][$secId]) && $appSec[$min][$subMin][$secId] == 'Approved') {
                    $comment_mode = 'read';
                }
            } else {

                if (isset($appSec[$min][$secId]) && $appSec[$min][$secId] == 'Approved') {
                    $comment_mode = 'read';
                }
            }

            // SET REFERRED BACK BUTTON STATUS
            if (is_array($appSec)) {
                foreach ($appSec as $partK => $partV) {

                    if ($partK == 'iron_ore') {

                        foreach ($partV as $k => $v) {
                            foreach ($v as $status) {

                                if ($status == 'Rejected') {
                                    $referBackBtn = 1;
                                } else if ($status == 'Approved') {
                                    $disapproveBtn = 1;
                                }
                            }
                        }
                    } else {
                        foreach ($partV as $k => $status) {
                            if (gettype($status) == 'array') {
                                foreach ($status as $mine) {
                                    if ($mine == 'Rejected') {
                                        $referBackBtn = 1;
                                    } else if ($status == 'Approved') {
                                        $disapproveBtn = 1;
                                    }
                                }
                            } else {
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
        $LastAppSec = $this->TblFinalSubmit->checkIsLastApproved($returnId, serialize($main_sec));
        //print_r($LastAppSec);die;

        $this->set('comment_mode', $comment_mode);
        $this->set('return_id', $returnId);
        $this->set('referBackBtn', $referBackBtn);
        $this->set('verifiedFlag', $verifiedFlag);
        $this->set('disapproveBtn', $disapproveBtn);
        $this->set('lastPart', $LastAppSec['lastPart']);
        $this->set('lastSec', $LastAppSec['lastSec']);
    }

    /**
     * Added by Shweta Apale on 02-02-2022
     * To set Return Type
     */

    public function violationpending($return_type, $sess_form_type)
    {
        $this->Session->write('sess_return_type', $return_type);
        $this->Session->write('sess_form_type', $sess_form_type);
        $this->redirect(array('controller' => 'mms', 'action' => 'violation-notice-pending'));
    }

    /***
     * Added by Shweta Apale on 01-0-2022
     * To get Violation List
     * Update on 02-02-2022
     */
    public function violationNoticePending()
    {
        $this->viewBuilder()->setLayout('mms_panel');
        $return_type = strtoupper($this->Session->read('sess_return_type'));
        $mms_user_id = $this->Session->read('mms_user_id');

        if ($this->request->is('post')) {
            if ($return_type == 'MONTHLY') {
                $month_return = $this->request->getData('month_return');
                $month_returns = $month_return . '-01';
                $month_return = date('F Y', strtotime($month_return));
				$this->Session->write('month', $month_return);											  
            } else {
                $year_return = $this->request->getData('year_returns');
                $year_returns = $year_return . '-04-01';
                $year_return_display = $year_return . '-' . $year_return + 1;
            }

            $regionid = $this->MmsUser->find('all', array('fields' => 'region_id', 'conditions' => array('id IS' => $mms_user_id)))->first();
            $region = $this->DirRegion->find('all', array('fields' => 'region_name', 'conditions' => array('id IS' => $regionid['region_id'])))->first();
            $regionName = $region['region_name'];
            $statesList = $this->DirDistrict->getstateByregion($regionName);

            $con = ConnectionManager::get('default');

            if ($return_type == 'MONTHLY') {

                $sql = "SELECT DISTINCT fs.mine_code AS MineCode, m.registration_no AS RegistrationNumber, m.lessee_owner_name AS NameOfTheOwner, fs.return_type AS ReturnType
                    FROM
                    TBL_FINAL_SUBMIT fs
                    RIGHT JOIN
                    MINE m ON m.mine_code = fs.mine_code
                    WHERE fs.is_latest = 1 AND (fs.return_type LIKE '$return_type')
                    AND (fs.mine_code NOT IN(SELECT mine_code FROM tbl_final_submit where return_date = '$month_returns'))
                    AND (fs.mine_code NOT IN(SELECT mine FROM tbl_violation_notice tvn where tvn.return_type = '$return_type' AND tvn.return_month = '$month_returns' AND applicant_id IS NULL))
                    AND (fs.mine_code IN (SELECT DISTINCT mine_code FROM mine m
                        WHERE
                        m.district_code IN (SELECT DISTINCT district_code
                        FROM DIR_DISTRICT
                        WHERE state_code = m.state_code AND region_name = '$regionName')))";
                // pr($sql);die;
                $query = $con->execute($sql);
                $records = $query->fetchAll('assoc');
                if (!empty($records)) {
                    $this->set('records', $records);
                } else {
                    $this->set('records', array());
                    $alert_message = "<strong> Records Not Found!!! </strong>";
                    $alert_theme = "success";
                    $alert_redirect_url = "violation-notice-pending";

                    $this->set('alert_message', $alert_message);
                    $this->set('alert_theme', $alert_theme);
                    $this->set('alert_redirect_url', $alert_redirect_url);
                }
                $this->set('month_return', $month_return);
            } else {
                $sql = "SELECT DISTINCT fs.mine_code AS MineCode, m.registration_no AS RegistrationNumber, m.lessee_owner_name AS NameOfTheOwner, fs.return_type AS ReturnType
                    FROM
                    TBL_FINAL_SUBMIT fs
                    RIGHT JOIN
                    MINE m ON m.mine_code = fs.mine_code
                    WHERE fs.is_latest = 1 AND (fs.return_type LIKE '$return_type')
                    AND (fs.mine_code NOT IN(SELECT mine_code FROM tbl_final_submit where return_date = '$year_returns'))
                    AND (fs.mine_code NOT IN(SELECT mine FROM tbl_violation_notice tvn where tvn.return_type = '$return_type' AND tvn.return_month = '$year_returns' AND applicant_id IS NULL))
                    AND (fs.mine_code IN (SELECT DISTINCT mine_code FROM mine m
                        WHERE
                        m.district_code IN (SELECT DISTINCT district_code
                        FROM DIR_DISTRICT
                        WHERE state_code = m.state_code AND region_name = '$regionName')))";
                $query = $con->execute($sql);
                $records = $query->fetchAll('assoc');
                if (!empty($records)) {
                    $this->set('records', $records);
                } else {
                    $this->set('records', array());
                    $alert_message = "<strong> Records Not Found!!! </strong>";
                    $alert_theme = "success";
                    $alert_redirect_url = "violation-notice-pending";

                    $this->set('alert_message', $alert_message);
                    $this->set('alert_theme', $alert_theme);
                    $this->set('alert_redirect_url', $alert_redirect_url);
                }
                $this->set('year_return_display', $year_return_display);
            }
        }
    }
    /**
     * Added by Shweta Apale on 02-02-2022
     * To get Form Number in Roman Number
     */
    public static function getFormRuleNumber($formNumber)
    {
        switch ($formNumber) {
            case 1:
            case 2:
            case 3:
            case 4:
            case 8:
                return "(i)";
                break;
            case 5:
                return "(ii)";
                break;
            case 7:
                return "(iii)";
                break;
        }
    }

    /**
     * Added by Shweta Apale on 01-02-2022
     * To Display Voialtion Notice
     */
    public function violationNoticePendingDisplay()
    {
        if ($this->request->is('post')) {
            $check_array = implode('\', \'', $this->request->getData('check_array'));
            $return_type = strtoupper($this->request->getData('return_type'));
            if ($return_type == 'MONTHLY') {
                $month_return = $this->request->getData('month_return');
                $month = explode(' ', $month_return);
                $month_num  = date("m", strtotime($month[0]));
                $month_return = $month[1] . '-' . $month_num . '-01';
            } else {
                $year_return = $this->request->getData('year_return');
                $year = explode('-', $year_return);
                $year_return = $year[0] . '-04-01';
            }

            $con = ConnectionManager::get('default');

            $sql = "SELECT M.lessee_owner_name AS ownerName, M.registration_no AS registrationNo, M.a_line_1 AS ownerAddres1, M.a_line_2 AS ownerAddres2,
                    D_O.district_name AS ownerDistrict, S_O.state_name AS ownerState, M.a_pin AS ownerPin, M.a_taluk_name AS ownerTehsil, D_O.region_name AS ownerRegion,
                    M.MINE_NAME AS mine_name, M.mine_code AS mine_code, M.taluk_name AS mineTehsil, S_M.state_name AS mineState, D_M.district_name AS mineDistrict,
                    M.pin AS minePin, D_M.region_name AS mineRegion, R_M.zone_name AS mineZone, M.form_type, GROUP_CONCAT(MW.mineral_name) AS mineral_name, mcu.mcu_email, mcu.mcu_parent_app_id
                    FROM
                    MINE M
                        INNER JOIN
                    DIR_DISTRICT D_O ON D_O.district_code = M.a_dist
                        AND D_O.state_code = M.a_state
                        INNER JOIN
                    DIR_DISTRICT D_M ON D_M.district_code = M.district_code
                        AND D_M.state_code = M.state_code
                        INNER JOIN
                    DIR_STATE S_O ON S_O.state_code = M.a_state
                        INNER JOIN
                    DIR_STATE S_M ON S_M.state_code = M.state_code
                        INNER JOIN
                    DIR_REGION R_M ON R_M.region_name = D_M.region_name
                        INNER JOIN
                    mineral_worked MW ON MW.mine_code = M.mine_code AND M.mine_code  IN('$check_array')
                        INNER JOIN
                    mc_user mcu ON mcu.mcu_mine_code = MW.mine_code
                    WHERE
                    M.mine_code IN('$check_array') GROUP BY mcu.mcu_mine_code ";
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');

            $fSeriesFormNo = '';

            foreach ($records as $record) {
                $numericValue = $this->getFormRuleNumber($record['form_type']);
                $to = base64_decode($record['mcu_email']);
                $ins_mine_code = $record['mine_code'];
                $ins_reg_no = $record['registrationNo'];
                $ins_email = base64_decode($record['mcu_email']);
                $ins_app_id = $record['mcu_parent_app_id'];

                if ($return_type == 'ANNUAL') {
                    if ($record['form_type'] == 1 || $record['form_type'] == 2 || $record['form_type'] == 3 || $record['form_type'] == 4 || $record['form_type'] == 8) {
                        $fSeriesFormNo = 'G-1';
                    }
                    if ($record['form_type'] == 5) {
                        $fSeriesFormNo = 'G-2';
                    }
                    if ($record['form_type'] == 7) {
                        $fSeriesFormNo = 'G-3';
                    }
                } else {
                    if ($record['form_type'] == 1 || $record['form_type'] == 2 || $record['form_type'] == 3 || $record['form_type'] == 4 || $record['form_type'] == 8) {
                        $fSeriesFormNo = 'F-1';
                    }
                    if ($record['form_type'] == 5) {
                        $fSeriesFormNo = 'F-2';
                    }
                    if ($record['form_type'] == 7) {
                        $fSeriesFormNo = 'F-3';
                    }
                }

                $subject = " Subject : Violation of provisions of Mineral Conservation and Development Rules, 2017 (MCDR, 2017) in respect of your "
                    .  $record['mine_name'] . '(' . $record["mine_code"] . ') . situated in Tehsil : ' . $record['mineTehsil'] . '
                            District : ' . $record['mineDistrict'] . ' , State : ' . $record['mineState'] . ' on Date : ' . date("d-F-Y");

                $body = '
                <table width="100%">
                    <tr>
                        <td>
                            <div align="center" style="font-size: 12px;">
                                <b>
                                    GOVERNMENT OF INDIA<br />
                                    MINISTRY OF MINES<br />
                                    INDIAN BUREAU OF MINES<br />
                                    OFFICE OF THE REGIONAL CONTROLLER OF MINES
                                </b>
                            </div>
                        </td>
                    </tr>
                </table>
                <table width="100%">
                    <tr>
                        <td width="2%">No.</td>
                        <td width="56%" align="left">-</td>
                        <td>' . $record["ownerRegion"] . ', Dated ' . date("d-F-Y") . '</td>
                    </tr>
                </table>
                <br />
                <table width="100%">
                    <tr>
                        <td width="5%">To,</td>
                    </tr>
                    <tr>
                        <td>' . $record["ownerName"] . '
                            <br>' . $record["registrationNo"] . '(' . $record["registrationNo"] . ')' . '
                            <br>' . $record["ownerAddres1"] . '
                            <br>' . $record["ownerAddres2"] . '
                            <br>' . $record["ownerDistrict"] . '
                            <br>' . $record["ownerState"] . '-' . $record["ownerPin"] . '
                        </td>
                    </tr>
                </table>
                <br />
                <table width="100%">
                    <tr>
                        <td colspan="2">Sir,</td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td>The following provision of Mineral Conservation and Development Rules, 2017 (MCDR, 2017), was found violated in case of your above referred mine.</td>
                    </tr>
                </table>
                <table width="100%" class="violationLetterDisplay">
                    <tr>
                        <td width="25%"><strong>Rule No.</strong></td>
                        <td align="left" width="75%"><strong>Nature of violation observed</strong></td>
                    </tr>
                </table>
                <table width="100%">
                    <tr>
                        <td valign="top" width="10%">
                            Rule 45(5)
                        </td>
                        <td width="80%">
                            The owner, agent, mining engineer or manager of every mine shall submit to the Regional Controller of Mines in the Indian Bureau of Mines or any other authorised official of the Indian Bureau of Mines, return in
                            respect of each mine, in the following manner, namely:-
                            <br />';
                if ($return_type == "ANNUAL") {
                    $return_notation1 =  ' (b) ';
                } else {
                    $return_notation1 =  '(a)';
                }
                $body .= $return_notation1 . ' a ' . ucfirst(strtolower($return_type)) . ' return which shall be submitted before';
                if ($return_type == "ANNUAL") {
                    $return_data1 = ' the 1st July each year for the preceding financial year in the forms as indicated below:- ';
                } else {
                    $return_data1 = ' the 10th of every month in respect of preceding month in the forms as indicated below:- ';
                }
                $body .=  $return_data1 . '<br /><span style="width:100px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                ' . $numericValue . ' for ' . $record["mineral_name"] . ' in ' . $fSeriesFormNo . ' .
                                <br />';
                if ($return_type == "ANNUAL") {
                    $return_data2 = 'Provided that in case of abandonment of a mine, the annual return shall be submitted within 105 ( One hundred five) days from the date of abandonment.<br>';
                } else {
                    $return_data2 = '';
                }

                $body .= $return_data2 . '<br>
                            However, it is observed from system that, you have not submitted
                            ' . ucfirst(strtolower($return_type)) . ' return for above referred mine before stipulated date as specified in Rule 45(5)';
                if ($return_type == "ANNUAL") {
                    $return_notation2 = '(b)';
                } else {
                    $return_notation2 = '(a) . ';
                }
                $body .= $return_notation2 . ' This leads to violation of provisions of MCDR, 2017.
                                <br>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="5" cellspacing="1">
                    <tr class="violationLetterDisplay"></tr>
                    <tr>
                        <td width="10%">02</td>
                        <td width="80%">In this connection, it is brought to your notice that the above violation constitute an offence punishable under Rule 45(7) (i) of MCDR, 2017 as specified.</td>
                    </tr>
                    <tr>
                        <td>03</td>
                        <td>You are advised to rectify the above violation by submitting the ' . ucfirst(strtolower($return_type)) . ' return in case of your above referred mine on-line immediately within 15 (fifteen) days from the date of issue of this letter.
                        </td>
                    </tr>
                    <tr>
                        <td>04</td>
                        <td>Please note that no further notice will be given to you in this regard.</td>
                    </tr>
                    <tr>
                        <td>05</td>
                        <td>This is a system generated violation letter and requires no signature. </td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="65%">&nbsp;</td>
                        <td align="center">Regional Controller of Mines</td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td colspan="2">Copy for information to</td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td>1. The Director, Directorate of Geology and Mining, Government of ' . $record["mineState"] . ' </td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td>2. The District Collector, Collectorate office, District : ' . $record["mineDistrict"] . ', ' . $record["mineState"] . '</td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="65%">&nbsp;</td>
                        <td align="center">Regional Controller of Mines</td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td colspan="2" align="left">BC<br />N.O.O.</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td> Copy for kind information to the Controller of Mines (' . $record["mineZone"] . '), Indian Bureau of Mines, ' . $record["mineZone"] . '.</td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="65%">&nbsp;</td>
                        <td align="center">Regional Controller of Mines</td>
                    </tr>
                </table>';

                // Maintaining log of mail
                $date = date('Y-m-d h:i:s');
                if ($return_type == 'MONTHLY') {
                    $insert = "INSERT INTO tbl_violation_notice
                        (mine, app_id, registration_no, return_month, return_type, mail_date, email_id, email_sent)
                        VALUES
                        ('$ins_mine_code','$ins_app_id','$ins_reg_no','$month_return','$return_type','$date','$ins_email','Y')";
                    // pr($insert);die;
                    $query = $con->execute($insert);
                } else {
                    $insert = "INSERT INTO tbl_violation_notice
                    (mine, app_id, registration_no, return_month, return_type, mail_date, email_id, email_sent)
                    VALUES
                    ('$ins_mine_code','$ins_app_id','$ins_reg_no','$year_return','$return_type','$date','$ins_email','Y')";
                    $query = $con->execute($insert);
                }

                $this->Sitemails->sendMailCommon($to, $subject, $body);

                // send sms
                $customer_id = $_SESSION['applicantid'];
                $this->loadModel('DirSmsEmailTemplates');
                $this->DirSmsEmailTemplates->sendMessage(13,$ins_mine_code);
            }

            $alert_message = "Sending Mail !!!";
            $alert_redirect_url = "violation-notice-pending";
            $alert_theme = "success";
            $this->set('alert_message', $alert_message);
            $this->set('alert_redirect_url', $alert_redirect_url);
            $this->set('alert_theme', $alert_theme);
        }
    }

    /**
     * Added by Shweta Apale on 05-02-2022
     * Violation Notice List for L & M
     */
    public function violationlmpending($return_type, $sess_form_type)
    {
        $this->Session->write('sess_return_type', $return_type);
        $this->Session->write('sess_form_type', $sess_form_type);
        $this->redirect(array('controller' => 'mms', 'action' => 'violation-notice-list_l_m_pending'));
    }

    /**
     * Added by Shweta Apale on 05-02-2022
     * To fetch Violation Notice of L & M
     */
    public function violationNoticeListLMPending()
    {
        $this->viewBuilder()->setLayout('mms_panel');
        $return_type = strtoupper($this->Session->read('sess_return_type'));
        $sess_form_type = strtoupper($this->Session->read('sess_form_type'));
        $mms_user_id = $this->Session->read('mms_user_id');

        if ($this->request->is('post')) {
            if ($return_type == 'MONTHLY') {
                $month_return = $this->request->getData('month_return');
                $month_returns = $month_return . '-01';
                $month_return = date('F Y', strtotime($month_return));
				$this->Session->write('month',$month_return);											 
            } else {
                $year_return = $this->request->getData('year_returns');
                $year_returns = $year_return . '-04-01';
                $year_return_display = $year_return . '-' . $year_return + 1;
            }

            $regionid = $this->MmsUser->find('all', array('fields' => 'region_id', 'conditions' => array('id IS' => $mms_user_id)))->first();
            $region = $this->DirRegion->find('all', array('fields' => 'region_name', 'conditions' => array('id IS' => $regionid['region_id'])))->first();
            $regionName = $region['region_name'];
            $statesList = $this->DirDistrict->getstateByregion($regionName);

            $con = ConnectionManager::get('default');

            if ($return_type == 'MONTHLY' && $sess_form_type == 'M') {
                $sql = "SELECT DISTINCT fs.applicant_id as applicantId, fs.return_type as ReturnType, fs.ibm_unique_reg_no as RegistrationNumber, mcmcd_nameofplant as plant_name
                FROM  TBL_END_USER_FINAL_SUBMIT fs
                    INNER JOIN
                mc_user mcu ON fs.applicant_id = mcu.mcu_child_user_name
                    INNER JOIN
                mc_mineralconsumption_det mc ON SUBSTRING_INDEX(fs.applicant_id,'/',1) = mc.mcmcd_app_id AND SUBSTRING_INDEX(fs.applicant_id,'/',-1) = mc.mcmd_slno
                    INNER JOIN
                MC_APPLICANT_DET m ON m.mcappd_concession_code = fs.ibm_unique_reg_no and m.mcappd_concession_code !=''
                WHERE fs.is_latest = 1 AND (fs.return_type LIKE '$return_type')
                  AND (fs.ibm_unique_reg_no NOT IN(SELECT ibm_unique_reg_no FROM TBL_END_USER_FINAL_SUBMIT where return_date = '$month_returns'))
                  AND (fs.ibm_unique_reg_no NOT IN(SELECT registration_no FROM tbl_violation_notice tvn where tvn.return_type = '$return_type' AND tvn.return_month = '$month_returns' AND tvn.mine IS NULL))
                  AND (fs.ibm_unique_reg_no IN (SELECT DISTINCT mcappd_concession_code FROM mine m
                WHERE
                    m.mcappd_district IN (SELECT DISTINCT district_code
                    FROM DIR_DISTRICT
                    WHERE state_code = m.mcappd_state AND region_name = '$regionName')))";
                // pr($sql);die;
                $query = $con->execute($sql);
                $records = $query->fetchAll('assoc');

                if (!empty($records)) {
                    $this->set('records', $records);
                } else {
                    $this->set('records', array());
                    $alert_message = "<strong> Records Not Found!!! </strong>";
                    $alert_theme = "success";
                    $alert_redirect_url = "violation-notice-list-l-m-pending";

                    $this->set('alert_message', $alert_message);
                    $this->set('alert_theme', $alert_theme);
                    $this->set('alert_redirect_url', $alert_redirect_url);
                }
                $this->set('month_return', $month_return);
            } else {
                $sql = "SELECT DISTINCT fs.applicant_id as applicantId, fs.return_type as ReturnType, fs.ibm_unique_reg_no as RegistrationNumber, mcmcd_nameofplant as plant_name
                FROM  TBL_END_USER_FINAL_SUBMIT fs
                    INNER JOIN
                mc_user mcu ON fs.applicant_id = mcu.mcu_child_user_name
                    INNER JOIN
                mc_mineralconsumption_det mc ON SUBSTRING_INDEX(fs.applicant_id,'/',1) = mc.mcmcd_app_id AND SUBSTRING_INDEX(fs.applicant_id,'/',-1) = mc.mcmd_slno
                    INNER JOIN
                MC_APPLICANT_DET m ON m.mcappd_concession_code = fs.ibm_unique_reg_no and m.mcappd_concession_code !=''
                WHERE fs.is_latest = 1 AND (fs.return_type LIKE '$return_type')
                  AND (fs.ibm_unique_reg_no NOT IN(SELECT ibm_unique_reg_no FROM TBL_END_USER_FINAL_SUBMIT where return_date = '$year_returns'))
                  AND (fs.ibm_unique_reg_no NOT IN(SELECT registration_no FROM tbl_violation_notice tvn where tvn.return_type = '$return_type' AND tvn.return_month = '$year_returns' AND tvn.mine IS NULL))
                  AND (fs.ibm_unique_reg_no IN (SELECT DISTINCT mcappd_concession_code FROM mine m
                WHERE
                    m.mcappd_district IN (SELECT DISTINCT district_code
                    FROM DIR_DISTRICT
                    WHERE state_code = m.mcappd_state AND region_name = '$regionName')))";
                $query = $con->execute($sql);
                $records = $query->fetchAll('assoc');
                if (!empty($records)) {
                    $this->set('records', $records);
                } else {
                    $this->set('records', array());
                    $alert_message = "<strong> Records Not Found!!! </strong>";
                    $alert_theme = "success";
                    $alert_redirect_url = "violation-notice-list-l-m-pending";

                    $this->set('alert_message', $alert_message);
                    $this->set('alert_theme', $alert_theme);
                    $this->set('alert_redirect_url', $alert_redirect_url);
                }
                $this->set('year_return_display', $year_return_display);
            }
        }
    }

    /**
     * Added by Shweta Apale on 05-02-2022
     * To Display Voialtion Notice for L & M
     */
    public function violationNoticeDisplayPendingLM()
    {
        if ($this->request->is('post')) {
            $check_array = implode('\', \'', $this->request->getData('check_array'));

            $return_type = strtoupper($this->request->getData('return_type'));
            $form_type = strtoupper($this->request->getData('form_type'));

            if ($return_type == 'MONTHLY' && $form_type == 'M') {
                $month_return = $this->request->getData('month_return');
                $month = explode(' ', $month_return);
                $month_num  = date("m", strtotime($month[0]));
                $month_return = $month[1] . '-' . $month_num . '-01';
                // pr($month_return);die;
            } else {
                $year_return = $this->request->getData('year_return');
                $year_return = $this->request->getData('year_return');
                $year = explode('-', $year_return);
                $year_return = $year[0] . '-04-01';
            }

            $con = ConnectionManager::get('default');

            $sql = "SELECT DISTINCT mcmcd.mcmcd_nameofplant, mcmcd.mcmd_tehsil, s.state_name, fs.applicant_id, mcu.mcu_email,mcu.mcu_parent_app_id, fs.ibm_unique_reg_no, d.district_name, d.region_name, r.zone_name
                    FROM
                    mc_mineralconsumption_det mcmcd
                        INNER JOIN
                    dir_state s ON mcmcd.mcmd_state = s.state_code
                        INNER JOIN
                    tbl_end_user_final_submit fs ON SUBSTRING_INDEX(fs.applicant_id, '/', 1) = mcmcd.mcmcd_app_id
                        AND SUBSTRING_INDEX(fs.applicant_id, '/', - 1) = mcmcd.mcmd_slno
                        INNER JOIN
                    mc_user mcu ON fs.applicant_id = mcu.mcu_child_user_name
                        INNER JOIN
                    mc_applicant_det mc ON fs.ibm_unique_reg_no = mc.mcappd_concession_code
                        INNER JOIN
                    dir_district d ON mc.mcappd_district = d.district_code AND  mc.mcappd_regioncode = d.region_code  AND mc.mcappd_state = d.state_code
                        INNER JOIN
                    dir_region r ON d.region_name = r.region_name
                    WHERE fs.applicant_id IN ('$check_array')";
            // pr($sql);
            // die;
            $query = $con->execute($sql);
            $records = $query->fetchAll('assoc');
            $fSeriesFormNo = '';

            foreach ($records as $record) {
                $to = base64_decode($record['mcu_email']);
                $ins_applicant_id = $record['applicant_id'];
                $ins_reg_no = $record['ibm_unique_reg_no'];
                $ins_email = base64_decode($record['mcu_email']);
                $ins_app_id = $record['mcu_parent_app_id'];

                if ($return_type == 'ANNUAL') {
                    $fSeriesFormNo = 'M';
                } else {
                    $fSeriesFormNo = 'L';
                }

                $subject = " Subject : Violation of provisions of Mineral Conservation and Development Rules, 2017 (MCDR, 2017) in respect of your "
                    .  $record['mcmcd_nameofplant'] . '(' . $record["ibm_unique_reg_no"] . ') . situated in Tehsil : ' . $record['mcmd_tehsil'] . '
                            District : ' . $record['district_name'] . ', State : ' . $record['state_name'] . ' on Date : ' . date("d-F-Y");

                $body = '
                <table width="100%">
                    <tr>
                        <td>
                            <div align="center" style="font-size: 12px;">
                                <b>
                                    GOVERNMENT OF INDIA<br />
                                    MINISTRY OF MINES<br />
                                    INDIAN BUREAU OF MINES<br />
                                    OFFICE OF THE REGIONAL CONTROLLER OF MINES
                                </b>
                            </div>
                        </td>
                    </tr>
                </table>
                <table width="100%">
                    <tr>
                        <td width="2%">No.</td>
                        <td width="56%" align="left">-</td>
                        <td>' . $record["region_name"] . ', Dated ' . date("d-F-Y") . '</td>
                    </tr>
                </table>
                <br />
                <table width="100%">
                    <tr>
                        <td width="5%">To,</td>
                    </tr>
                    <tr>
                        <td>' . $record["mcmcd_nameofplant"] . '
                            <br>' . $record["ibm_unique_reg_no"] . '(' . $record["ibm_unique_reg_no"] . ')' . '

                            <br>' . $record["state_name"] . '
                        </td>
                    </tr>
                </table>
                <br />
                <table width="100%">
                    <tr>
                        <td colspan="2">Sir,</td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td>The following provision of Mineral Conservation and Development Rules, 2017 (MCDR, 2017), was found violated in case of your above referred mine.</td>
                    </tr>
                </table>
                <table width="100%" class="violationLetterDisplay">
                    <tr>
                        <td width="25%"><strong>Rule No.</strong></td>
                        <td align="left" width="75%"><strong>Nature of violation observed</strong></td>
                    </tr>
                </table>
                <table width="100%">
                    <tr>
                        <td valign="top" width="10%">
                            Rule 45(5)
                        </td>
                        <td width="80%">
                            The owner, agent, mining engineer or manager of every mine shall submit to the Regional Controller of Mines in the Indian Bureau of Mines or any other authorised official of the Indian Bureau of Mines, return in
                            respect of each mine, in the following manner, namely:-
                            <br />';
                if ($return_type == "ANNUAL") {
                    $return_notation1 =  ' (b) ';
                } else {
                    $return_notation1 =  '(a)';
                }
                $body .= $return_notation1 . ' a ' . ucfirst(strtolower($return_type)) . ' return which shall be submitted before';
                if ($return_type == "ANNUAL") {
                    $return_data1 = ' the 1st July each year for the preceding financial year in the forms as indicated below:- ';
                } else {
                    $return_data1 = ' the 10th of every month in respect of preceding month in the forms as indicated below:- ';
                }
                $body .=  $return_data1 . '<br /><span style="width:100px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                 for ' . $fSeriesFormNo . ' .
                                <br />';
                if ($return_type == "ANNUAL") {
                    $return_data2 = 'Provided that in case of abandonment of a mine, the annual return shall be submitted within 105 ( One hundred five) days from the date of abandonment.<br>';
                } else {
                    $return_data2 = '';
                }

                $body .= $return_data2 . '<br>
                            However, it is observed from system that, you have not submitted
                            ' . ucfirst(strtolower($return_type)) . ' return for above referred mine before stipulated date as specified in Rule 45(5)';
                if ($return_type == "ANNUAL") {
                    $return_notation2 = '(b)';
                } else {
                    $return_notation2 = '(a) . ';
                }
                $body .= $return_notation2 . ' This leads to violation of provisions of MCDR, 2017.
                                <br>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="5" cellspacing="1">
                    <tr class="violationLetterDisplay"></tr>
                    <tr>
                        <td width="10%">02</td>
                        <td width="80%">In this connection, it is brought to your notice that the above violation constitute an offence punishable under Rule 45(7) (i) of MCDR, 2017 as specified.</td>
                    </tr>
                    <tr>
                        <td>03</td>
                        <td>You are advised to rectify the above violation by submitting the ' . ucfirst(strtolower($return_type)) . ' return in case of your above referred mine on-line immediately within 15 (fifteen) days from the date of issue of this letter.
                        </td>
                    </tr>
                    <tr>
                        <td>04</td>
                        <td>Please note that no further notice will be given to you in this regard.</td>
                    </tr>
                    <tr>
                        <td>05</td>
                        <td>This is a system generated violation letter and requires no signature. </td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="65%">&nbsp;</td>
                        <td align="center">Regional Controller of Mines</td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td colspan="2">Copy for information to</td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td>1. The Director, Directorate of Geology and Mining, Government of ' . $record["state_name"] . ' </td>
                    </tr>
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td>2. The District Collector, Collectorate office, District : ' . $record['district_name'] . ', ' . $record["state_name"] . '</td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="65%">&nbsp;</td>
                        <td align="center">Regional Controller of Mines</td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td colspan="2" align="left">BC<br />N.O.O.</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td> Copy for kind information to the Controller of Mines (' . $record['zone_name'] . '), Indian Bureau of Mines, ' . $record['zone_name'] . '.</td>
                    </tr>
                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="65%">&nbsp;</td>
                        <td align="center">Regional Controller of Mines</td>
                    </tr>
                </table>';

                // Maintaining log of mail
                $date = date('Y-m-d h:i:s');
                if ($return_type == 'MONTHLY') {
                    $insert = "INSERT INTO tbl_violation_notice
                        (app_id, registration_no, return_month, return_type, mail_date, email_id, email_sent, applicant_id)
                        VALUES
                        ('$ins_app_id','$ins_reg_no','$month_return','$return_type','$date','$ins_email','Y','$ins_applicant_id')";
                    //    pr($insert);die;
                    $query = $con->execute($insert);
                } else {
                    $insert = "INSERT INTO tbl_violation_notice
                    (app_id, registration_no, return_month, return_type, mail_date, email_id, email_sent, applicant_id)
                    VALUES
                    ('$ins_app_id','$ins_reg_no','$year_return','$return_type','$date','$ins_email','Y','$ins_applicant_id')";
                    $query = $con->execute($insert);
                }

                $this->Sitemails->sendMailCommon($to, $subject, $body);
                // send sms
                $customer_id = $_SESSION['applicantid'];
                $this->loadModel('DirSmsEmailTemplates');
                $this->DirSmsEmailTemplates->sendMessage(14,$ins_applicant_id);
            }
        }
        $alert_message = "Sending Mail !!!";
        $alert_redirect_url = "violation-notice-list-l-m-pending";
        $alert_theme = "success";

        $this->set('alert_message', $alert_message);
        $this->set('alert_redirect_url', $alert_redirect_url);
        $this->set('alert_theme', $alert_theme);
    }

    /**
     * Added by Shweta Apale on 03-03-2022
     * To set Return Type
     */

    public function violationserve($return_type, $sess_form_type)
    {
        $this->Session->write('sess_return_type', $return_type);
        $this->Session->write('sess_form_type', $sess_form_type);
        $this->redirect(array('controller' => 'mms', 'action' => 'violation-notice-serve'));
    }

    /***
     * Added by Shweta Apale on 03-03-2022
     * To get Report for violation notice send
     */
    public function violationNoticeServe()
    {
        $this->viewBuilder()->setLayout('report_layout');

        $return_type = strtoupper($this->Session->read('sess_return_type'));
        if ($this->request->is('post')) {
            if ($return_type == 'MONTHLY') {
                $month_return = $this->request->getData('month_return');
                $mine_code = $this->request->getData('mine_code');

                $month_returns = explode(' ', $month_return);
                $month_num  = date("m", strtotime($month_returns[0]));
                $month_returns = $month_returns[1] . '-' . $month_num . '-01';

                $month_return = date('F Y', strtotime($month_return));
            } else {
                $year_return = $this->request->getData('year_returns');
                $mine_code = $this->request->getData('mine_code');

                $year_returns = $year_return . '-04-01';
                $year_return_display = $year_return . '-' . $year_return + 1;
            }

            $con = ConnectionManager::get('default');

            if ($return_type == 'MONTHLY') {

                $sql = "SELECT mine, registration_no, EXTRACT(MONTH FROM return_month)  AS showMonth, EXTRACT(YEAR FROM return_month)  AS showYear, email_id, mail_date FROM tbl_violation_notice 
                        WHERE return_type = '$return_type' AND return_month = '$month_returns' AND applicant_id IS NULL";
                if ($mine_code != '') {
                    $sql .= " AND mine = '$mine_code'";
                }
                // pr($sql);die;
                $query = $con->execute($sql);
                $records = $query->fetchAll('assoc');
                if (!empty($records)) {
                    $this->set('records', $records);
                } else {
                    $this->set('records', array());
                    $alert_message = "<strong> Records Not Found!!! </strong>";
                    $alert_theme = "success";
                    $alert_redirect_url = "violation-notice-serve";

                    $this->set('alert_message', $alert_message);
                    $this->set('alert_theme', $alert_theme);
                    $this->set('alert_redirect_url', $alert_redirect_url);
                }
                $this->set('month_return', $month_return);
            } else {
                $sql = "SELECT mine, registration_no, email_id, mail_date FROM tbl_violation_notice 
                WHERE return_type = '$return_type' AND return_month = '$year_returns' AND applicant_id IS NULL";
                if ($mine_code != '') {
                    $sql .= " AND mine = '$mine_code'";
                }
                $query = $con->execute($sql);
                $records = $query->fetchAll('assoc');
                if (!empty($records)) {
                    $this->set('records', $records);
                } else {
                    $this->set('records', array());
                    $alert_message = "<strong> Records Not Found!!! </strong>";
                    $alert_theme = "success";
                    $alert_redirect_url = "violation-notice-serve";

                    $this->set('alert_message', $alert_message);
                    $this->set('alert_theme', $alert_theme);
                    $this->set('alert_redirect_url', $alert_redirect_url);
                }
                $this->set('year_return_display', $year_return_display);
            }
        }
    }

    /**
     * Added by Shweta Apale on 03-03-2022
     * Violation Notice Serve for L & M
     */
    public function violationservelm($return_type, $sess_form_type)
    {
        $this->Session->write('sess_return_type', $return_type);
        $this->Session->write('sess_form_type', $sess_form_type);
        $this->redirect(array('controller' => 'mms', 'action' => 'violation-notice-serve-l-m'));
    }

    /***
     * Added by Shweta Apale on 03-03-2022
     * To get Report for violation notice send
     */
    public function violationNoticeServeLM()
    {
        $this->viewBuilder()->setLayout('report_layout');

        $return_type = strtoupper($this->Session->read('sess_return_type'));
        if ($this->request->is('post')) {
            if ($return_type == 'MONTHLY') {
                $month_return = $this->request->getData('month_return');
                $applicant_id = $this->request->getData('applicant_id');

                $month_returns = explode(' ', $month_return);
                $month_num  = date("m", strtotime($month_returns[0]));
                $month_returns = $month_returns[1] . '-' . $month_num . '-01';

                $month_return = date('F Y', strtotime($month_return));
            } else {
                $year_return = $this->request->getData('year_returns');
                $applicant_id = $this->request->getData('applicant_id');

                $year_returns = $year_return . '-04-01';
                $year_return_display = $year_return . '-' . $year_return + 1;
            }

            $con = ConnectionManager::get('default');

            if ($return_type == 'MONTHLY') {

                $sql = "SELECT applicant_id, registration_no, EXTRACT(MONTH FROM return_month)  AS showMonth, EXTRACT(YEAR FROM return_month)  AS showYear, email_id, mail_date FROM tbl_violation_notice 
                        WHERE return_type = '$return_type' AND return_month = '$month_returns' AND mine IS NULL";
                if ($applicant_id != '') {
                    $sql .= " AND applicant_id = '$applicant_id'";
                }
                $query = $con->execute($sql);
                $records = $query->fetchAll('assoc');
                if (!empty($records)) {
                    $this->set('records', $records);
                } else {
                    $this->set('records', array());
                    $alert_message = "<strong> Records Not Found!!! </strong>";
                    $alert_theme = "success";
                    $alert_redirect_url = "violation-notice-serve-l-m";

                    $this->set('alert_message', $alert_message);
                    $this->set('alert_theme', $alert_theme);
                    $this->set('alert_redirect_url', $alert_redirect_url);
                }
                $this->set('month_return', $month_return);
            } else {
                $sql = "SELECT applicant_id, registration_no, email_id, mail_date FROM tbl_violation_notice 
                WHERE return_type = '$return_type' AND return_month = '$year_returns' AND mine IS NULL";
                if ($applicant_id != '') {
                    $sql .= " AND applicant_id = '$applicant_id'";
                }
                // pr($sql);die;
                $query = $con->execute($sql);
                $records = $query->fetchAll('assoc');
                if (!empty($records)) {
                    $this->set('records', $records);
                } else {
                    $this->set('records', array());
                    $alert_message = "<strong> Records Not Found!!! </strong>";
                    $alert_theme = "success";
                    $alert_redirect_url = "violation-notice-serve-l-m";

                    $this->set('alert_message', $alert_message);
                    $this->set('alert_theme', $alert_theme);
                    $this->set('alert_redirect_url', $alert_redirect_url);
                }
                $this->set('year_return_display', $year_return_display);
            }
        }
    }

    /**
     * Added by Shweta Apale on 04-03-2022
     * To set Return Type
     */

    public function violation($return_type, $sess_form_type)
    {
        $this->Session->write('sess_return_type', $return_type);
        $this->Session->write('sess_form_type', $sess_form_type);
        $this->redirect(array('controller' => 'mms', 'action' => 'violation-notice-list'));
    }

    /***
     * Added by Shweta Apale on 04-03-2022
     * To get All Violation List 
     */
    public function violationNoticeList()
    {
        $this->viewBuilder()->setLayout('mms_panel');
        $return_type = strtoupper($this->Session->read('sess_return_type'));
        $mms_user_id = $this->Session->read('mms_user_id');

        if ($this->request->is('post')) {
            if ($return_type == 'MONTHLY') {
                $month_return = $this->request->getData('month_return');
                $month_returns = $month_return . '-01';
                $month_return = date('F Y', strtotime($month_return));
            } else {
                $year_return = $this->request->getData('year_returns');
                $year_returns = $year_return . '-04-01';
                $year_return_display = $year_return . '-' . $year_return + 1;
            }

            $regionid = $this->MmsUser->find('all', array('fields' => 'region_id', 'conditions' => array('id IS' => $mms_user_id)))->first();
            $region = $this->DirRegion->find('all', array('fields' => 'region_name', 'conditions' => array('id IS' => $regionid['region_id'])))->first();
            $regionName = $region['region_name'];
            $statesList = $this->DirDistrict->getstateByregion($regionName);

            $con = ConnectionManager::get('default');

            if ($return_type == 'MONTHLY') {

                $sql = "SELECT DISTINCT fs.mine_code AS MineCode, m.registration_no AS RegistrationNumber, m.lessee_owner_name AS NameOfTheOwner, fs.return_type AS ReturnType
                    FROM
                    TBL_FINAL_SUBMIT fs
                    RIGHT JOIN
                    MINE m ON m.mine_code = fs.mine_code
                    WHERE fs.is_latest = 1 AND (fs.return_type LIKE '$return_type')
                    AND (fs.mine_code NOT IN(SELECT mine_code FROM tbl_final_submit where return_date = '$month_returns' AND return_type = '$return_type'))
                    AND (fs.mine_code IN (SELECT DISTINCT mine_code FROM mine m
                        WHERE
                        m.district_code IN (SELECT DISTINCT district_code
                        FROM DIR_DISTRICT
                        WHERE state_code = m.state_code AND region_name = '$regionName')))";
                 //pr($sql);die;
                $query = $con->execute($sql);
                $records = $query->fetchAll('assoc');
                if (!empty($records)) {
                    $this->set('records', $records);
                } else {
                    $this->set('records', array());
                    $alert_message = "<strong> Records Not Found!!! </strong>";
                    $alert_theme = "success";
                    $alert_redirect_url = "violation-notice-list";

                    $this->set('alert_message', $alert_message);
                    $this->set('alert_theme', $alert_theme);
                    $this->set('alert_redirect_url', $alert_redirect_url);
                }
                $this->set('month_return', $month_return);
            } else {
                $sql = "SELECT DISTINCT fs.mine_code AS MineCode, m.registration_no AS RegistrationNumber, m.lessee_owner_name AS NameOfTheOwner, fs.return_type AS ReturnType
                    FROM
                    TBL_FINAL_SUBMIT fs
                    RIGHT JOIN
                    MINE m ON m.mine_code = fs.mine_code
                    WHERE fs.is_latest = 1 AND (fs.return_type LIKE '$return_type')
                    AND (fs.mine_code NOT IN(SELECT mine_code FROM tbl_final_submit where return_date = '$year_returns' AND return_type = '$return_type'))
                    AND (fs.mine_code IN (SELECT DISTINCT mine_code FROM mine m
                        WHERE
                        m.district_code IN (SELECT DISTINCT district_code
                        FROM DIR_DISTRICT
                        WHERE state_code = m.state_code AND region_name = '$regionName')))";
                // pr($sql);die;
                $query = $con->execute($sql);
                $records = $query->fetchAll('assoc');
                if (!empty($records)) {
                    $this->set('records', $records);
                } else {
                    $this->set('records', array());
                    $alert_message = "<strong> Records Not Found!!! </strong>";
                    $alert_theme = "success";
                    $alert_redirect_url = "violation-notice-list";

                    $this->set('alert_message', $alert_message);
                    $this->set('alert_theme', $alert_theme);
                    $this->set('alert_redirect_url', $alert_redirect_url);
                }
                $this->set('year_return_display', $year_return_display);
            }

            // For checking mail already send or not
            $mine = array();
            if ($return_type == 'MONTHLY') {
                $sqlEmailSent = "SELECT v.mine, v.return_type, v.email_sent FROM tbl_violation_notice v Where v.return_type = '$return_type' AND v.return_month= '$month_returns' AND v.email_sent = 'Y' AND v.mine IS NOT NULL";
                $queryEmailSent = $con->execute($sqlEmailSent);
                $recordsEmailSents = $queryEmailSent->fetchAll('assoc');
                foreach ($recordsEmailSents as $recordsEmailSent) {
                    $mine_code = $recordsEmailSent['mine'];
                    array_push($mine, $mine_code);
                }
                $this->set('mine', $mine);
            } else {
                $sqlEmailSent = "SELECT v.mine, v.return_type, v.email_sent FROM tbl_violation_notice v Where v.return_type = '$return_type' AND v.return_month= '$year_returns' AND v.email_sent = 'Y' AND v.mine IS NOT NULL";
                $queryEmailSent = $con->execute($sqlEmailSent);
                $recordsEmailSents = $queryEmailSent->fetchAll('assoc');
                foreach ($recordsEmailSents as $recordsEmailSent) {
                    $mine_code = $recordsEmailSent['mine'];
                    array_push($mine, $mine_code);
                }
                $this->set('mine', $mine);
            }
        }
    }

    /**
     * Added by Shweta Apale on 04-03-2022
     * Violation Notice List for L & M
     */
    public function violationlm($return_type, $sess_form_type)
    {
        $this->Session->write('sess_return_type', $return_type);
        $this->Session->write('sess_form_type', $sess_form_type);
        $this->redirect(array('controller' => 'mms', 'action' => 'violation-notice-list_l_m'));
    }

    /**
     * Added by Shweta Apale on 04-03-2022
     * To fetch Violation Notice of L & M
     */
    public function violationNoticeListLM()
    {
        $this->viewBuilder()->setLayout('mms_panel');
        $return_type = strtoupper($this->Session->read('sess_return_type'));
        $sess_form_type = strtoupper($this->Session->read('sess_form_type'));
        $mms_user_id = $this->Session->read('mms_user_id');

        if ($this->request->is('post')) {
            if ($return_type == 'MONTHLY') {
                $month_return = $this->request->getData('month_return');
                $month_returns = $month_return . '-01';
                $month_return = date('F Y', strtotime($month_return));
            } else {
                $year_return = $this->request->getData('year_returns');
                $year_returns = $year_return . '-04-01';
                $year_return_display = $year_return . '-' . $year_return + 1;
            }

            $regionid = $this->MmsUser->find('all', array('fields' => 'region_id', 'conditions' => array('id IS' => $mms_user_id)))->first();
            $region = $this->DirRegion->find('all', array('fields' => 'region_name', 'conditions' => array('id IS' => $regionid['region_id'])))->first();
            $regionName = $region['region_name'];
            $statesList = $this->DirDistrict->getstateByregion($regionName);

            $con = ConnectionManager::get('default');

            if ($return_type == 'MONTHLY' && $sess_form_type == 'M') {
                $sql = "SELECT DISTINCT fs.applicant_id as applicantId, fs.return_type as ReturnType, fs.ibm_unique_reg_no as RegistrationNumber, mcmcd_nameofplant as plant_name
                FROM  TBL_END_USER_FINAL_SUBMIT fs
                    INNER JOIN
                mc_user mcu ON fs.applicant_id = mcu.mcu_child_user_name
                    INNER JOIN
                mc_mineralconsumption_det mc ON SUBSTRING_INDEX(fs.applicant_id,'/',1) = mc.mcmcd_app_id AND SUBSTRING_INDEX(fs.applicant_id,'/',-1) = mc.mcmd_slno
                    INNER JOIN
                MC_APPLICANT_DET m ON m.mcappd_concession_code = fs.ibm_unique_reg_no and m.mcappd_concession_code !=''
                WHERE fs.is_latest = 1 AND (fs.return_type LIKE '$return_type')
                  AND (fs.ibm_unique_reg_no NOT IN(SELECT ibm_unique_reg_no FROM TBL_END_USER_FINAL_SUBMIT where return_date = '$month_returns' AND return_type = '$return_type'))
                  AND (fs.ibm_unique_reg_no IN (SELECT DISTINCT mcappd_concession_code FROM mine m
                WHERE
                    m.mcappd_district IN (SELECT DISTINCT district_code
                    FROM DIR_DISTRICT
                    WHERE state_code = m.mcappd_state AND region_name = '$regionName')))";
                // pr($sql);die;
                $query = $con->execute($sql);
                $records = $query->fetchAll('assoc');

                $this->set('records', $records);
                $this->set('month_return', $month_return);
            } else {
                $sql = "SELECT DISTINCT fs.applicant_id as applicantId, fs.return_type as ReturnType, fs.ibm_unique_reg_no as RegistrationNumber, mcmcd_nameofplant as plant_name
                FROM  TBL_END_USER_FINAL_SUBMIT fs
                    INNER JOIN
                mc_user mcu ON fs.applicant_id = mcu.mcu_child_user_name
                    INNER JOIN
                mc_mineralconsumption_det mc ON SUBSTRING_INDEX(fs.applicant_id,'/',1) = mc.mcmcd_app_id AND SUBSTRING_INDEX(fs.applicant_id,'/',-1) = mc.mcmd_slno
                    INNER JOIN
                MC_APPLICANT_DET m ON m.mcappd_concession_code = fs.ibm_unique_reg_no and m.mcappd_concession_code !=''
                WHERE fs.is_latest = 1 AND (fs.return_type LIKE '$return_type')
                  AND (fs.ibm_unique_reg_no NOT IN(SELECT ibm_unique_reg_no FROM TBL_END_USER_FINAL_SUBMIT where return_date = '$year_returns' AND return_type = '$return_type'))
                  AND (fs.ibm_unique_reg_no IN (SELECT DISTINCT mcappd_concession_code FROM mine m
                WHERE
                    m.mcappd_district IN (SELECT DISTINCT district_code
                    FROM DIR_DISTRICT
                    WHERE state_code = m.mcappd_state AND region_name = '$regionName')))";
                $query = $con->execute($sql);
                $records = $query->fetchAll('assoc');
                if (!empty($records)) {
                    $this->set('records', $records);
                } else {
                    $this->set('records', array());
                    $alert_message = "<strong> Records Not Found!!! </strong>";
                    $alert_theme = "success";
                    $alert_redirect_url = "violation-notice-list-l-m";

                    $this->set('alert_message', $alert_message);
                    $this->set('alert_theme', $alert_theme);
                    $this->set('alert_redirect_url', $alert_redirect_url);
                }
                $this->set('year_return_display', $year_return_display);
            }
            // For checking mail already send or not
            $applicant_id_array = array();
            if ($return_type == 'MONTHLY' && $sess_form_type == 'M') {
                $sqlEmailSent = "SELECT v.applicant_id, v.return_type, v.email_sent FROM tbl_violation_notice v Where v.return_type = '$return_type' AND v.return_month = '$month_returns' AND v.email_sent = 'Y' AND v.applicant_id IS NOT NULL";
                $queryEmailSent = $con->execute($sqlEmailSent);
                $recordsEmailSents = $queryEmailSent->fetchAll('assoc');
                foreach ($recordsEmailSents as $recordsEmailSent) {
                    $applicant_id = $recordsEmailSent['applicant_id'];
                    array_push($applicant_id_array, $applicant_id);
                }
                $this->set('applicant_id_array', $applicant_id_array);
            } else {
                $sqlEmailSent = "SELECT v.applicant_id, v.return_type, v.email_sent FROM tbl_violation_notice v Where v.return_type = '$return_type' AND v.return_month = '$year_returns' AND v.email_sent = 'Y' AND v.applicant_id IS NOT NULL";
                $queryEmailSent = $con->execute($sqlEmailSent);
                $recordsEmailSents = $queryEmailSent->fetchAll('assoc');
                foreach ($recordsEmailSents as $recordsEmailSent) {
                    $applicant_id = $recordsEmailSent['applicant_id'];
                    array_push($applicant_id_array, $applicant_id);
                }
                $this->set('applicant_id_array', $applicant_id_array);
            }
        }
    }
}
