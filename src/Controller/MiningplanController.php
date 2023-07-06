<?php

    namespace App\Controller;

    use Cake\Event\EventInterface;
    use App\Network\Email\Email;
    use Cake\ORM\Entity;
    use Cake\Core\Configure;
    use Cake\Datasource\ConnectionManager;

    class MiningplanController extends AppController
    {

        var $name = 'Miningplan';
        var $uses = array();

        public function beforeFilter(EventInterface $event)
        {
            parent::beforeFilter($event);

            $this->userSessionExits();
        }

        public function initialize(): void
        {
            parent::initialize();

            $this->loadComponent('Authentication');
            $this->loadComponent('Customfunctions');
            $this->loadComponent('Returnslist');
            $this->loadComponent('Clscommon');

            $this->viewBuilder()->setHelpers(['Form', 'Html']);
            $this->Connection = ConnectionManager::get('default');
            $this->Session = $this->getRequest()->getSession();
            $this->viewBuilder()->setLayout('mc_panel');
            
        }


        public function productionProposalList(){


        }
        //fetch miningplan id Date : 08/02/2022 Shalini D
        public function getMiningplanId($id)
        {
            $this->loadModel('MiningPlan');
            $result = $this->MiningPlan->find('all',array('conditions'=>array('id '=>$id),'order'=>'ID DESC'))->first();
            
            $this->Session->write('mc_mine_code',$result['mine_code']);
            $this->Session->write('mc_mineral',$result['MINERAL_NAME']);
            $this->Session->write('mc_miningplan_id',$id);
            
            $this->redirect(array('Controller'=>'miningplan','action'=>'set-production-schedule'));
        }

        public function setProductionSchedule()
        {
            $ro_dashboard = 'no';
            if($this->Session->read('loginusertype')=='mmsuser'){
                $this->viewBuilder()->setLayout('mms_panel');
                $ro_dashboard = 'yes';
            }
            $ro_selected_mineral = $this->Session->read('mc_mineral');

            $this->MiningPlan = $this->getTableLocator()->get('MiningPlan');
            $this->MineralWorked = $this->getTableLocator()->get('MineralWorked');

            $mineCode = $this->Session->read('mc_mine_code');
            
            $plan['id'] = '';

            if(isset($_SESSION['mc_miningplan_id']))
            {
                $id = $this->Session->read('mc_miningplan_id');
                $plan['id'] = $id;
            }
            //print_r($plan);die;
            $this->set('plan_data',$plan);
            //$mineCode = '49GUJ12042';

            $mine_data = $this->MiningPlan->getMineData($mineCode);

            $minerals =  $this->MineralWorked->fetchMineralInfo($mineCode);

            if($ro_dashboard == 'yes'){
                if($ro_selected_mineral == 1){
                    $mineralsData[1] = 'IRON ORE-HEMATITE';
                }elseif($ro_selected_mineral == 2){
                    $mineralsData[2] = 'IRON ORE-MEGNATITE';
                }else{
                    $mineralsData[$ro_selected_mineral] = $ro_selected_mineral;
                }
                
            }else{
                foreach($minerals as $each){

                    if($each['mineral_name'] == 'IRON ORE' ){
                        $mineralsData[1] = 'IRON ORE-HEMATITE';
                        $mineralsData[2] = 'IRON ORE-MEGNATITE';
                    }else{
                        $mineralsData[$each['mineral_name']] = $each['mineral_name'];
                    }                
                }
            }
            

            $documentTypes = array('1'=>'Mining Plan','2'=>'Modification of Mining Plan',
                                    '3'=>'Schemes of Mining','4'=>'Modification of Scheme of Mining');

            $this->set('mine_data',$mine_data);
            $this->set('minerals',$mineralsData);
            $this->set('document_types',$documentTypes);
            $this->set('ro_dashboard',$ro_dashboard);
            $this->set('ro_selected_mineral',$ro_selected_mineral);
            

            $error = 0;
            $record_id = '';
            $form_status = 0;
            $status = 0;
            $reason_text = '';

            if ($this->request->is('post')) {

               $date_approval =  $this->Customfunctions->dateValidation($this->request->getData('date_approval'));
               $date_conmmencement =  $this->Customfunctions->dateValidation($this->request->getData('date_conmmencement'));
               $date_execution =  $this->Customfunctions->dateValidation($this->request->getData('date_execution'));
               
               
               $year_1 = htmlentities($this->request->getData('year_1'), ENT_QUOTES);
               $year_2 = htmlentities($this->request->getData('year_2'), ENT_QUOTES);
               $year_3 = htmlentities($this->request->getData('year_3'), ENT_QUOTES);
               $year_4 = htmlentities($this->request->getData('year_4'), ENT_QUOTES);
               $year_5 = htmlentities($this->request->getData('year_5'), ENT_QUOTES);
               $start_year =  htmlentities($this->request->getData('start_year'), ENT_QUOTES); 

               $mineral_name = htmlentities($this->request->getData('mineral_name'), ENT_QUOTES);
               $document_type = htmlentities($this->request->getData('document_type'), ENT_QUOTES);

               
               
               if($date_approval == '' || $date_conmmencement == '' || $date_execution == ''
                  || $year_1 == '' || $year_2 == '' || $year_3 == '' || $year_4 == '' ||
                  $year_5 == '' || $start_year == '' || $mineral_name =='' || $document_type == ''){

                    $this->alert_message = "Some fileds are not filled, please filled all information";  
                    $this->alert_redirect_url = "set-production-schedule";  
                    $this->alert_theme  = "error";    
                    $error = 1;
                }else{
                    $created_date = date('Y-m-d H:s:m');
                    $updated_date = date('Y-m-d H:s:m');
                    $explode_start_year = explode('-',$start_year);
                    $strtotime_date_approval = strtotime($date_approval);
                    $strtotime_date_conmmencement = strtotime($date_conmmencement);
                    $strtotime_date_execution = strtotime($date_execution);

                    if(!(($strtotime_date_execution < $strtotime_date_approval) 
                     && ($strtotime_date_execution < $strtotime_date_conmmencement)) )
                    {
                        $this->alert_message = "Date of execution of mining lease should be greater than Approval Date and Commencement Date";  
                        $this->alert_redirect_url = "set-production-schedule"; 
                        $this->alert_theme  = "error";   
                        $error = 1;
                    }
                    
                    if(!array_key_exists($mineral_name,$mineralsData)){

                        $this->alert_message = "Invalid Mineral Name";  
                        $this->alert_redirect_url = "set-production-schedule";
                        $this->alert_theme  = "error";   
                        $error = 1;
                    }
                   
                    if(!array_key_exists($document_type, $documentTypes)){

                        $this->alert_message = "Invalid Document Type";  
                        $this->alert_redirect_url = "set-production-schedule";
                        $this->alert_theme  = "error";   
                        $error = 1;
                    }

                   
                    if($error == 0)
                    {
                        $action_msg = "Proposal production details saved successfully";

                        $productionDetails = $this->MiningPlan->find('all',array(
                            'conditions'=>array('mine_code IS'=>$mineCode,'MINERAL_NAME IS'=>$mineral_name),
                            'order'=>array('id desc')))->first();

                        if (null !== ($this->request->getData('save'))){

                            if($productionDetails  != ''){

                                if($productionDetails['STATUS'] == 0 && $productionDetails['FORM_STATUS'] == 0){
                                    $record_id = $productionDetails['ID'];
                                    $form_status = 0;
                                    $status = 0;
                                    $created_date = $productionDetails['CREATED_AT'];
                                    $action_msg = "Proposal production details updated successfully";
                                }
                            }

                        } 

                        if (null !== ($this->request->getData('final_submit'))){

                            $record_id = $productionDetails['ID'];
                            $form_status = 1;
                            $status = 0;
                            $created_date = $productionDetails['CREATED_AT'];
                            $action_msg = "Proposal production details updated and send to RO for scrutiny";
                        }

                        if (null !== ($this->request->getData('accepted'))){

                            $record_id = $productionDetails['ID'];
                            $form_status = 1;
                            $status = 1;
                            $created_date = $productionDetails['CREATED_AT'];
                            $action_msg = "Proposal production details successfully Approved";
                            $reason_text = htmlentities($this->request->getData('reason_text'), ENT_QUOTES);
                        }

                       
                        $newEntity = $this->MiningPlan->newEntity(array(
                            'ID'=>$record_id,
                            'REGISTRATION_NO'=>$mine_data['registration_no'],
                            'OWNER_NAME'=>$mine_data['owner_name'],
                            'mine_code'=>$mine_data['mine_code'],
                            'MINE_NAME'=>$mine_data['mine_name'],
                            'DOCUMENT_TYPE'=>$document_type,
                            'APPR_DATE'=>$date_approval,
                            'EFF_APPR_DATE'=>$date_execution,
                            'COMMENCEMENT_DATE'=>$date_conmmencement,
                            'MINERAL_NAME'=>$mineral_name,
                            'YEAR_1'=>$year_1,
                            'YEAR_2'=>$year_2,
                            'YEAR_3'=>$year_3,
                            'YEAR_4'=>$year_4,
                            'YEAR_5'=>$year_5,
                            'FIRST_SUBMIT_DATE'=>$explode_start_year[1],
                            'STATUS'=>$status,
                            'FORM_STATUS'=>$form_status,
                            'REFERRED_BACK_REASON'=>$reason_text,
                            'created_at'=>$created_date,
                            'updated_at'=>$updated_date
                        ));

                        //print_r($newEntity);die;

                        if($this->MiningPlan->save($newEntity)){
                            $this->alert_message = $action_msg; 
                            $this->alert_redirect_url = "set-production-schedule";
                            $this->alert_theme  = "success";   

                        }else{
                            $this->alert_message = 'Record not saved'; 
                            $this->alert_redirect_url = "set-production-schedule";
                            $this->alert_theme  = "error";   
                        }                        
                    } 
                }
            }

            $this->set('alert_message',$this->alert_message);
            $this->set('alert_redirect_url',$this->alert_redirect_url);
            $this->set('alert_theme',$this->alert_theme);

        }
        //ownerlist function to get mine owner data to show in crud ......by pranov
        public function ownerlist(){
            $this->loadModel('MiningPlan');
            //$this->viewBuilder()->setLayout('mc_panel');    
        
            // username from session
            $owner_id = $this->Session->read('username');

            // mine owner total record and count
            $records = $this->MiningPlan->getMiningPlanForMineOwner($owner_id);

            
            $mine_records = $records['miningPlan'];
            $count_totalRecords = $records['totalRecords'];

            $this->set(Compact('mine_records','count_totalRecords'));
        }
        //ownerlist function to get mine owner data to show in crud ......by pranov
        public function ownerdetails(){
            $this->loadModel('MiningPlan');
            //$this->viewBuilder()->setLayout('mc_panel');    
            
            $id = $this->Session->read('mine_id_ownerlist');
            $mine_code = $this->Session->read('mine_code_ownerlist');

            $plan_data = $this->MiningPlan->getMiningPlanDetails($id,$mine_code);
            
            $data = $plan_data['static_data'];
            $dynamicData = $plan_data['dynamic_data'];

            $this->set(Compact('data','dynamicData'));
        }

        public function ownerdetailsFetchID($ID,$MineCode){

            $this->Session->write('mine_id_ownerlist',$ID);
            $this->Session->write('mine_code_ownerlist',$MineCode);
            
            $this->redirect(array('Controller'=>'Miningplan','action'=>'ownerdetails'));
        }

        public function getMineralDetails(){

            $this->autoRender = false;
            
            $mineral_name = htmlentities($_POST['mineral_name'], ENT_QUOTES);
            $plan_id = htmlentities($_POST['plan_id'], ENT_QUOTES);
            $mineCode = $this->Session->read('mc_mine_code');
            $usertype = $this->Session->read('loginusertype');

            $this->MiningPlan = $this->getTableLocator()->get('MiningPlan');

            $approveRecord = $this->MiningPlan->find('all',array('conditions'=>array('mine_code IS'=>$mineCode,'MINERAL_NAME IS'=>$mineral_name,
                                                            'FORM_STATUS IS'=>'1','STATUS'=>'1'),'order'=>'ID DESC'))->first();
            $approvedRecord = 'no';
            if($approveRecord != ''){
                $approvedRecord = 'yes';
            }
            if($plan_id=='')
            {
                $result = $this->MiningPlan->find('all',array('conditions'=>array('mine_code IS'=>$mineCode,'MINERAL_NAME IS'=>$mineral_name),'order'=>'ID DESC'))->first();
            }else{
                $result = $this->MiningPlan->find('all',array('conditions'=>array('id'=>$plan_id),'order'=>'ID DESC'))->first();
            }
            $status ='';
            //print_r($result);die;
            if($result  != ''){

                if($result['STATUS'] == 0 && $result['FORM_STATUS'] == 0){

                $result['reset_year_btn'] = false;
                    $status = 'saved';
                    $result['reset_year_btn'] = true;
                    if($approvedRecord == 'yes')
                    {
                        // $result['reset_start_year'] = $approveRecord['FIRST_SUBMIT_DATE'];
                        $result['reset_start_year'] = (int)date('Y') - (int)5;
                    }
                    else
                    {
                        $result['reset_start_year'] = (int)date('Y') - (int)5;
                    }
                    
                }elseif($result['STATUS'] == 0 && $result['FORM_STATUS'] == 1 && $usertype != 'mmsuser'){
                    $status = 'final_submitted';

                }elseif($result['STATUS'] == 0 && $result['FORM_STATUS'] == 1 && $usertype == 'mmsuser'){
                    $status = 'pending';

                }elseif($result['STATUS'] == 1 && $result['FORM_STATUS'] == 1){

                    $status = 'accepted';
                }
                $result['approved_record'] = $approvedRecord;
                echo json_encode(array($status,$result));

            }else{

                echo 0;
            }
           
        }
        //mms mining plan list date:07/02/2022 by Shalini D
        public function miningPlanList()
        {
            $this->loadComponent('Customfunctions');
            $this->viewBuilder()->setLayout('mms_panel');
            $this->loadModel('MiningPlan');

            $regionName = $this->Customfunctions->getUserRegion();
            $district_list = $this->Customfunctions->getRegionDistrict($regionName);
            
            $cur_yr = date('Y');
            for ($i = $cur_yr; ($i >= ($cur_yr - 10) && $i >= 2005); $i--) {
                $years[$i] = $i ;
            }
            $formData['mine_code'] = '';
            $formData['year'] = '';
            $formData['reg_no'] = '';
            $formData['district'] = '';
            if($this->request->is('post')) {
                if($this->request->getData('submit')){
                    $formData['mine_code'] = $this->request->getData('mine_code');
                    $formData['year'] = $this->request->getData('year');
                    $formData['reg_no'] = $this->request->getData('reg_no');
                    $formData['district'] = $this->request->getData('district');
                }
            }

            $allData = $this->MiningPlan->getAllApprovedMiningPlans($formData);
            //print_r($allData);die;
            $this->set(Compact('district_list','years','regionName','allData','formData'));


        }
        


    }

?>