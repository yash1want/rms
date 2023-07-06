<?php

    namespace App\Controller;

    use Cake\Event\EventInterface;
    use App\Network\Email\Email;
    use Cake\ORM\Entity;
    use Cake\Core\Configure;
    use Cake\Datasource\ConnectionManager;

    class MmsMiningplanController extends AppController
    {

        var $name = 'mmsMiningplan';
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

        public function setProductionSchedule(){

            $this->MiningPlan = $this->getTableLocator()->get('MiningPlan');
            $this->MineralWorked = $this->getTableLocator()->get('MineralWorked');

            $mineCode = $this->Session->read('mc_mine_code');

            $mine_data = $this->MiningPlan->getMineData($mineCode);
            $minerals =  $this->MineralWorked->fetchMineralInfo($mineCode);

            foreach($minerals as $each){

                if($each['mineral_name'] == 'IRON ORE' ){
                    $mineralsData[1] = 'IRON ORE-HEMATITE';
                    $mineralsData[2] = 'IRON ORE-MEGNATITE';
                }else{
                    $mineralsData[$each['mineral_name']] = $each['mineral_name'];
                }                
            }

            $documentTypes = array('1'=>'Mining Plan','2'=>'Modification of Mining Plan',
                                    '3'=>'Schemes of Mining','4'=>'Modification of Scheme of Mining');

            $this->set('mine_data',$mine_data);
            $this->set('minerals',$mineralsData);
            $this->set('document_types',$documentTypes);

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