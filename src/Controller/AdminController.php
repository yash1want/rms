<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Network\Email\Email;
use Cake\ORM\Entity;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;

class AdminController extends AppController{

    var $name = 'Admin';
	var $uses = array();
	
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Customfunctions');
        $this->viewBuilder()->setHelpers(['Form','Html']);
        $this->Session = $this->getRequest()->getSession();
        $this->MmsUser = $this->getTableLocator()->get('MmsUser');
        $this->MmsUserRole = $this->getTableLocator()->get('MmsUserRole');
        $this->MmsUserStatusLog = $this->getTableLocator()->get('MmsUserStatusLog');
        $this->DirState = $this->getTableLocator()->get('DirState');
        $this->DirZone = $this->getTableLocator()->get('DirZone');
        $this->DirRegion = $this->getTableLocator()->get('DirRegion');
        $this->DirDistrict = $this->getTableLocator()->get('DirDistrict');   

        $this->userSessionExits();     
    }    
    public function listUsers(){

        $this->viewBuilder()->setLayout('mms_panel');
        $this->Session->delete('editUserId');
        $this->Session->delete('userAction');

        $mmsUserRole = $this->Session->read('mms_user_role');
        $mmsUserId = $this->Session->read('mms_user_id');
        
        if(in_array($mmsUserRole,array('2','5','8'))){

            $listUser = $this->MmsUser->find('all',array('conditions'=>array('parent_id'=>$mmsUserId,'is_delete IN'=>array('0','1'))))
                    ->order('first_name','is_delete')
                    ->toArray();
        }else{

            $listUser = $this->MmsUser->find('all',array('conditions'=>array('is_delete IN'=>array('0','1'))))
                    ->order('first_name','is_delete')
                    ->toArray();
        }
            
        $rolelist =  $this->MmsUserRole->find('list',array('keyField'=>'id','valueField'=>'role'))->toArray();
        $this->set('rolelist',$rolelist);
                   
        $this->set('listUser',$listUser);
        
    }

    public function userEdit($id){
        $this->Session->write('editUserId',$id);
        $this->Session->write('userAction','edit');
        $this->redirect(array('controller'=>'admin','action'=>'edit'));
    }

    // user deactivation
    public function userDeactivate(){
        
		$this->autoRender = false;

		if ($this->request->is('post')) {

			$userId = $_POST['user_id'];
			$action = $_POST['action'];
            $mmsUserId = $this->Session->read('mms_user_id');
            
            if ($action == 'deactivate') {

                $query = $this->MmsUser->query();
                $query->update()
                    ->set(['is_delete'=>1])
                    ->where(['id'=>$userId])
                    ->execute();

                if ($query) {
                    $result = 1;
                    $this->Session->write('usr_msg_suc', 'Successfully deactivated the user!');
                    $this->MmsUserStatusLog->saveUserStatusLog($userId, $mmsUserId, 1); // save user status log
                } else {
                    $result = 0;
                }

                echo $result;

            }
			
		}
        
    }
    
    // user activation
    public function userActivate(){
        
		$this->autoRender = false;

		if ($this->request->is('post')) {

			$userId = $_POST['user_id'];
			$action = $_POST['action'];
            $mmsUserId = $this->Session->read('mms_user_id');
            
            if ($action == 'activate') {

                $query = $this->MmsUser->query();
                $query->update()
                    ->set(['is_delete'=>0])
                    ->where(['id'=>$userId])
                    ->execute();

                if ($query) {
                    $result = 1;
                    $this->Session->write('usr_msg_suc', 'Successfully activated the user!');
                    $this->MmsUserStatusLog->saveUserStatusLog($userId, $mmsUserId, 0); // save user status log
                } else {
                    $result = 0;
                }

                echo $result;

            }
			
		}
        
    }

    public function userDeactivited($id){
        $this->Session->write('editUserId',$id);        
    }

    public function userProfile(){
        $this->Session->write('editUserId',$this->Session->read('mms_user_id'));
        $this->Session->write('userAction','profile');
        $this->redirect(array('controller'=>'admin','action'=>'profile'));
    }

    public function addUser(){
        
        $this->viewBuilder()->setLayout('mms_panel');
        $resultList = array();
        $parentUserList = array();
        $zoneRegionValue = null;
        $zoneRegionLabel = null;
        $districts = array();
        $editUserId = null;
        $created_at = date('Y-m-d H:i:s');
        $heading = '';
        $userCreateByNonAdminUser  = '';
        $action  = 'add';
        $buttonName = 'Save';
		$parentUserLabel = 'Parent User';

        $mmsUserRole = $this->Session->read('mms_user_role');
        $mmsUserId = $this->Session->read('mms_user_id');
        $mms_user_first_name = $this->Session->read('mms_user_first_name');
        $mms_user_name = $this->Session->read('mms_user_name');

        $userAllocationStatus = false;

        // For add user window
        if(null == $this->Session->read('userAction')){
            $this->Session->write('userAction','add');
        }  


        // For edit user window
        if(null != $this->Session->read('editUserId')){

            $action  = 'edit';

            // For Form Heading
            if($this->Session->read('userAction') == 'profile'){
                $heading = 'Edit Profile';
            }else{
                $heading = 'Edit User';
            }
            
            $buttonName = 'Update';

            $editUserId = $this->Session->read('editUserId');
            
            $userDetails = $this->MmsUser->find('all',array('conditions'=>array('id IS'=>$editUserId)))->first();
           
            $roleid = $userDetails['role_id'];
            $parentid = $userDetails['parent_id'];
            $created_at = $userDetails['created_at'];
            $parentroleid =0;

            $districts = $this->DirDistrict->getDistrictCodesByStateCode($userDetails['state_code']);

            $checkAllocationStatus = false;
            if($roleid == 2){				
				$parentroleid = '1';
			}elseif($roleid == 3){
				$parentroleid = '2';
			}elseif($roleid == 5){				
				$parentroleid = '4';
			}elseif($roleid == 6){
				$parentroleid = '5';
			}elseif($roleid == 8){
				$parentroleid = '7';
			}elseif($roleid == 9){
				$parentroleid = '8';
			}elseif($roleid == 20){
				$parentroleid = '6';
			}elseif($roleid == 21){
				$parentroleid = '6';
                $checkAllocationStatus = true;
			}elseif($roleid == 22){
				$parentroleid = '6';
                $usercol = 'scru_id';
                $checkAllocationStatus = true;
			}elseif($roleid == 23){
				$parentroleid = '0';
                $usercol = 'odo_id';
                $checkAllocationStatus = true;
			}elseif($roleid == 24){ // added condition for COM user on 22-09-2022 by Aniket
				$parentroleid = '0';
                $usercol = 'com_id';
                $checkAllocationStatus = true;
			}elseif($roleid == 25){ // added condition for CMG user - Aniket G [2023-04-26]
				$parentroleid = '4';
			}

            // Check user allocation status
            if($checkAllocationStatus == true){
                if($roleid != 21) {
					$userAllocData = $this->mpasconn->newQuery()
								->select($usercol)
								->from('mp_allocation_details')
								->where([$usercol=>$editUserId]) 	
								->execute()
								->fetchAll('assoc');
                } else {
                    // added condition for DDO work allocation check
                    $conn = ConnectionManager::get('default');
                    $userAllocData = $conn->newQuery()
                                ->select('ddo_id')
                                ->from('ddo_allocation')
                                ->where(['ddo_id'=>$editUserId]) 	
                                ->execute()
                                ->fetchAll('assoc');
                }

                if(count($userAllocData) > 0){
                    $userAllocationStatus = true;
                }
            }

            // Get the Parent user lists
            if($parentroleid != 0){

                $supUsersList = $this->MmsUser->find('all',array('fields'=>array('id','first_name','last_name','user_name'),
                                        'conditions'=>array('is_delete IS'=>0,'role_id IS'=>$parentroleid)))
                                    ->order('first_name')
                                    ->toArray();
                                    
                foreach($supUsersList as $eachUser){ 
                    $name = $eachUser['first_name'].' '.$eachUser['last_name'].'('.$eachUser['user_name'].')';
                    $parentUserList[$eachUser['id']] = $name;               
                }
                
            } 

            if($roleid == 5){

                $resultList =   $this->DirZone->find('list',array('keyField'=>'id','valueField'=>'zone_name'))->order('id')->toArray();             
                $zoneRegionValue = $userDetails['zone_id'];
                $zoneRegionLabel = 'Zone'; 
            
            }elseif($roleid == 6){

                $usrZoneName = $this->MmsUser->find('all',array('fields'=>array('zone.zone_name'),
                                                            'join'=>array(array('table' => 'dir_zone','alias' => 'zone','type' => 'INNER','conditions'=>array('zone.id = MmsUser.zone_id'))),
                                                            'conditions'=>array('MmsUser.id is'=>$parentid)))->first();
                                                            
                $resultList = $this->DirRegion->find('list',array('keyField'=>'id','valueField'=>'region_name','conditions'=>array('zone_name IS'=>$usrZoneName['zone']['zone_name'])))->order('id')->toArray();
                $zoneRegionValue = $userDetails['region_id'];
                $zoneRegionLabel = 'Region';

            }elseif($roleid == 10){

                $parentUserList =   $this->DirState->find('list',array('keyField'=>'id','valueField'=>'state_name'))->order('state_name')->toArray();
                $userDetails['parent_id'] = $userDetails['state_code'];
                $parentUserLabel = 'State';
            }


            // For Add user Window
        }else{


            $heading = 'Add User';

            // Define blank array for add user window
            $userDetails = array('parent_id'=>'','user_name'=>'','role_id'=>'','zone_id'=>'','region_id'=>'','first_name'=>'','mid_name'=>'','last_name'=>'','state_code'=>'','district_id'=>'','phone'=>'',
                                  'mobile'=>'','email'=>'','designation'=>'','user_image'=>'','email_alts'=>'');
        }

        // Get MMS user role lists
        $rolelist =  $this->MmsUserRole->find('list',array('keyField'=>'id','valueField'=>'role','conditions'=>array('id NOT IN'=>array('14','12','13','15','17','16'))))->toArray();
        
        
        $statelist =  $this->DirState->find('list',array('keyField'=>'state_code','valueField'=>'state_name'))
                    ->order('state_name')
                    ->toArray();        
                    

        if (null !== $this->request->getData('save')){

            $formData = $this->request->getData();            
            $formData['id'] = $editUserId;
            $formData['created_at'] = $created_at;
            $saveResult = $this->MmsUser->saveUserDetails($formData);

            if($saveResult == 1){

                if($this->Session->read('userAction') == 'profile'){

                    $this->Session->write('mms_user_first_name', (isset($formData['first_name'])) ? $formData['first_name'] : $this->Session->read('mms_user_first_name'));
                    $this->Session->write('mms_user_last_name', (isset($formData['last_name'])) ? $formData['last_name'] : $this->Session->read('mms_user_last_name'));

                    $this->alert_message = "Profile successfully updated";
                    $this->alert_redirect_url = "user-profile";
                    $this->alert_theme = "success";

                }elseif($this->Session->read('userAction') == 'add'){

                    $this->alert_message = "User Created Successfully";
                    $this->alert_redirect_url = "list-users";
                    $this->alert_theme = "success";

                }elseif($this->Session->read('userAction') == 'edit'){

                    $this->alert_message = "User Details updated Successfully";
                    $this->alert_redirect_url = "list-users";
                    $this->alert_theme = "success";
                }
                
                
            }else{

                  $this->alert_message = "Something went wrong. Try again";
                  $this->alert_theme = "error";

                if($this->Session->read('userAction') == 'profile'){
                  
                    $this->alert_redirect_url = "user-profile";

                }elseif($this->Session->read('userAction') == 'add'){
                   
                    $this->alert_redirect_url = "add-user";

                }elseif($this->Session->read('userAction') == 'edit'){
                    
                    $this->alert_redirect_url = "edit";
                }
                

            }

        }            
        
        //print_r($this->alert_message); exit;
        $this->set('alert_message',$this->alert_message);
        $this->set('alert_redirect_url',$this->alert_redirect_url);
        $this->set('alert_theme',$this->alert_theme);

        $this->set('statelist',$statelist);
        $this->set('userDetails',$userDetails);
        $this->set('parentUserList',$parentUserList);
        $this->set('zoneRegion',$resultList);
        $this->set('zoneRegionValue',$zoneRegionValue);
        $this->set('zoneRegionLabel',$zoneRegionLabel);
        $this->set('districts',$districts);
        $this->set('heading',$heading);
        $this->set('rolelist',$rolelist);        
        $this->set('buttonlabel',$buttonName);
        $this->set('parentUserLabel',$parentUserLabel);
        $this->set('userAllocationStatus',$userAllocationStatus);

        $this->set('userCreateByNonAdminUser',$userCreateByNonAdminUser);

    }


    public function allocationType($alloType){


        $this->viewBuilder()->setLayout('mms_panel');

        $userRole = $this->Session->read('mms_user_role');

        // For Admin user
        if($userRole==1){

            $seriesType = array('fseries'=>'F and G Series','lseries'=>'L and M Series');  
        
        // For ME Admin User
        }elseif($userRole==7){

            $seriesType = array('lseries'=>'L and M Series');  
        }

           
        $this->set('seriestype',$seriesType);

        if (null !== $this->request->getData('save')){ 

            $type = $this->request->getData('seriestype');
            
            if(array_key_exists($type,$seriesType)){

                $this->Session->write('seriestype',$type);

                if($alloType=='allocate'){

                    $this->redirect(['controller'=>'admin','action'=>'allocation']);

                }elseif($alloType=='reallocate'){

                    $this->redirect(['controller'=>'admin','action'=>'reallocation']);
                }

            }else{

                $this->Session->write('error_msg','Invalid Series Type Selected');
                $this->redirect(['controller'=>'admin','action'=>'allocation-type']);
            }

        }

        if($alloType=='allocate'){

            $title = 'User Allocation';

        }elseif($alloType=='reallocate'){

            $title = 'User Reallocation';
        }

        $this->set('title',$title);

    }


    public function allocation(){

        $conn = ConnectionManager::get('default');

        $this->viewBuilder()->setLayout('mms_panel');   


        $userRole = $this->Session->read('mms_user_role');
        $userid = $this->Session->read('mms_user_id');
        $seriestype = $this->Session->read('seriestype');
        

        // For End User Allocation
        if($seriestype == 'lseries'){


            $businessactivity = $conn->execute("select mcbd_code,mcbd_desc from mc_businessactivity_directory order by mcbd_code")->fetchAll('assoc');

            foreach($businessactivity as $eachactivity){

                $activity_result[$eachactivity['mcbd_code']] = $eachactivity['mcbd_desc'];
            }

            $this->set('activity_result',$activity_result);


            $dir_state = $conn->execute("select state_code,state_name from dir_state order by state_name")->fetchAll('assoc');

            foreach($dir_state as $each_dir_state){

                $dir_state_result[$each_dir_state['state_code']] = $each_dir_state['state_name'];
            }

            $this->set('dir_state_result',$dir_state_result);


            $supRoleid = 8;
            $priRoleid = 9;

        }


        // For miner user allocation
        if($seriestype == 'fseries'){

            $mineral_name = $conn->execute("SELECT mineral_name FROM mineral_worked where mineral_sn = 1 group by mineral_name;")->fetchAll('assoc');

            foreach($mineral_name as $mineral){

                $mineral_name_list[$mineral['mineral_name']] = $mineral['mineral_name'];
            }

            $this->set('mineral_name_list',$mineral_name_list);

            
            $dir_state = $conn->execute("select state_code,state_name from dir_state order by state_name")->fetchAll('assoc');

            foreach($dir_state as $each_dir_state){

                $dir_state_result[$each_dir_state['state_code']] = $each_dir_state['state_name'];
            }

            $this->set('dir_state_result',$dir_state_result);

            $supRoleid = 2;
            $priRoleid = 3;

        }
        

        $supList = $this->MmsUser->find('all',array('fields'=>array('id','first_name','last_name','user_name'),
                                        'conditions'=>array('is_delete IS'=>0,'role_id IS'=>$supRoleid)))
                                    ->order('first_name')
                                    ->toArray();

        foreach($supList as $each){
            $suplistarr[$each['id']] = $each['first_name'].' '.$each['last_name'].'('.$each['user_name'] .')';
        }    

        $primaryList = $this->MmsUser->find('all',array('fields'=>array('id','first_name','last_name','user_name'),
            'conditions'=>array('is_delete IS'=>0,'role_id IS'=>$priRoleid)))
        ->order('first_name')
        ->toArray();                            
            
        foreach($primaryList as $each){
            $prilistarr[$each['id']] = $each['first_name'].' '.$each['last_name'].'('.$each['user_name'] .')';
        }
      
        $this->set('suplist',$suplistarr);
        $this->set('primarylist',$prilistarr);
            
    }


    public function reallocation(){

        $conn = ConnectionManager::get('default');        
        $this->viewBuilder()->setLayout('mms_panel');

        $userRole = $this->Session->read('mms_user_role');        
        $userid = $this->Session->read('mms_user_id');
        $seriestype = $this->Session->read('seriestype');

        
        // For End User Allocation
        if($seriestype == 'lseries'){


            $businessactivity = $conn->execute("select mcbd_code,mcbd_desc from mc_businessactivity_directory order by mcbd_code")->fetchAll('assoc');

            foreach($businessactivity as $eachactivity){

                $activity_result[$eachactivity['mcbd_code']] = $eachactivity['mcbd_desc'];
            }

            $this->set('activity_result',$activity_result);


            $dir_state = $conn->execute("select state_code,state_name from dir_state order by state_name")->fetchAll('assoc');

            foreach($dir_state as $each_dir_state){

                $dir_state_result[$each_dir_state['state_code']] = $each_dir_state['state_name'];
            }

            $this->set('dir_state_result',$dir_state_result);


            $supRoleid = 8;
            $priRoleid = 9;

        }


        // For miner user allocation
        if($seriestype == 'fseries'){

            $mineral_name = $conn->execute("SELECT mineral_name FROM mineral_worked where mineral_sn = 1 group by mineral_name;")->fetchAll('assoc');

            foreach($mineral_name as $mineral){

                $mineral_name_list[$mineral['mineral_name']] = $mineral['mineral_name'];
            }

            $this->set('mineral_name_list',$mineral_name_list);
            
            
            $dir_state = $conn->execute("select state_code,state_name from dir_state order by state_name")->fetchAll('assoc');

            foreach($dir_state as $each_dir_state){

                $dir_state_result[$each_dir_state['state_code']] = $each_dir_state['state_name'];
            }

            $this->set('dir_state_result',$dir_state_result);

            $supRoleid = 2;
            $priRoleid = 3;

        }


        $supList = $this->MmsUser->find('all',array('fields'=>array('id','first_name','last_name','user_name'),
                                        'conditions'=>array('is_delete IS'=>0,'role_id IS'=>$supRoleid)))
                                    ->order('first_name')
                                    ->toArray();

        foreach($supList as $each){
            $suplistarr[$each['id']] = $each['first_name'].' '.$each['last_name'].'('.$each['user_name'] .')';
        }    

        $primaryList = $this->MmsUser->find('all',array('fields'=>array('id','first_name','last_name','user_name'),
            'conditions'=>array('is_delete IS'=>0,'role_id IS'=>$priRoleid)))
        ->order('first_name')
        ->toArray();                            
            
        foreach($primaryList as $each){
            $prilistarr[$each['id']] = $each['first_name'].' '.$each['last_name'].'('.$each['user_name'] .')';
        }
        
        $this->set('suplist',$suplistarr);
        $this->set('primarylist',$prilistarr);        
    }


    // Get list of unallocated miner user list
    public function getUnallocatedMinerUser(){

        $mineral_name = htmlentities($_POST['mineral_name'], ENT_QUOTES);
        $state_code = htmlentities($_POST['state_code'], ENT_QUOTES);
        $allocationtype = htmlentities($_POST['allocationtype'], ENT_QUOTES);

        $conn = ConnectionManager::get('default');        


        if($allocationtype == 'allocate'){

            $sql = "SELECT mc.mcu_child_user_name userid from mc_user mc
                    inner join mineral_worked mwt on mwt.mine_code = mc.mcu_mine_code and mwt.mineral_sn = 1
                    inner join mine mn on mn.mine_code = mc.mcu_mine_code
                    where mc.mcu_child_user_name NOT IN(select mine_id from tbl_allocation_details) 
                    and  mc.mcu_mine_code IS NOT NULL 
                    and mc.mcu_child_user_name NOT like '%/%/%'";

            if($mineral_name != ''){
                
                $sql .= " and mwt.mineral_name like '$mineral_name'";
            }       
            
            if($state_code != ''){
                    
                $sql .= " and mn.state_code = '$state_code'";
            }           
                    
            $sql .= " ORDER BY `mc`.`mcu_child_user_name` DESC";        
                       

            $result = $conn->execute($sql)->fetchAll('assoc');

            $code = array();
            $i = 0;
            $j = 1;
            foreach($result as $each){

                $code[$i][0] = $each['userid'];
                $code[$i][1] = $each['userid'];
                $i++;
                $j++;
            }


        }




        if($allocationtype == 'reallocate'){

            $this->loadModel('MmsUser');

            $sql = "SELECT tad.id,tad.mine_id,tad.sup_id,tad.pri_id from tbl_allocation_details tad
                    inner join mc_user mc on mc.mcu_child_user_name = tad.mine_id
                    inner join mineral_worked mwt on mwt.mine_code = mc.mcu_mine_code and mwt.mineral_sn = 1
                    inner join mine mn on mn.mine_code = mc.mcu_mine_code";
           
            if($mineral_name != ''){
                
                $sql .= " and mwt.mineral_name like '$mineral_name'";
            }      
            
            if($state_code != ''){
                    
                $sql .= " and mn.state_code = '$state_code'";
            }    

            $result = $conn->execute($sql)->fetchAll('assoc');

            $code = array();
            $i = 0;
            $j = 1;
            foreach($result as $each){

                $code[$i][0] = $each['id'].'-'.$each['mine_id'];
                $code[$i][1] = $each['mine_id'];

                if($each['sup_id'] != ''){

                    $supList = $this->MmsUser->find('all',array('fields'=>array('first_name','last_name','user_name'),
                                        'conditions'=>array('id IS'=>$each['sup_id'])))->first();
					//print_r($each['sup_id']); 			
					if($supList != ''){
						$code[$i][2] = $supList['first_name'].' '.$supList['last_name'].'('.$supList['user_name'] .')';
					}else{
						$code[$i][2] = '---';
					}
					
                }else{

                    $code[$i][2] = '---';
                }
                
                if($each['pri_id'] != ''){

                    $priList = $this->MmsUser->find('all',array('fields'=>array('first_name','last_name','user_name'),
                                        'conditions'=>array('id IS'=>$each['pri_id'])))->first();
					if($priList != ''){
						$code[$i][3] = $priList['first_name'].' '.$priList['last_name'].'('.$priList['user_name'] .')';
					}else{
						 $code[$i][3] = '---';
					}	 
                }else{

                    $code[$i][3] = '---';
                }                
                
                $i++;
                $j++;
            }

        } 
        
        $codeResult['data'] = $code;
        echo json_encode($codeResult);     

        exit;    

    }



    // Get list of unallocated end users list
    public function getUnallocatedBlockUser(){

        $activity_type = htmlentities($_POST['activity_type'], ENT_QUOTES);
        $state_code = htmlentities($_POST['state_code'], ENT_QUOTES);
        $allocationtype = htmlentities($_POST['allocationtype'], ENT_QUOTES);

        $conn = ConnectionManager::get('default');   

        if($allocationtype == 'allocate'){

            $sql = "SELECT distinct mcu_child_user_name userid from mc_user mc
                    Inner Join mc_applicant_det mad ON mad.mcappd_app_id = mc.mcu_parent_app_id
                    where mc.mcu_child_user_name NOT IN(select registration_code from tbl_allocation_n_o_details) 
                    and (mc.mcu_mine_code IS NULL OR mc.mcu_mine_code like '%block%') 
                    and mc.mcu_child_user_name NOT like '%/%/%/%' 
                    and mc.mcu_child_user_name like '%/block%/%'";

                if($activity_type != ''){
                    
                    $sql .= " and mc.mcu_activity = '$activity_type'";
                }  

                if($state_code != ''){
                    
                    $sql .= " and mad.mcappd_state = '$state_code'";
                }       
                        
                $sql .= " ORDER BY `mc`.`mcu_child_user_name` DESC";        
                           

                $result = $conn->execute($sql)->fetchAll('assoc');

                $code = array();
                $i = 0;
                $j = 1;
                foreach($result as $each){

                    $code[$i][0] = $each['userid'];
                    $code[$i][1] = $each['userid'];
                    $i++;
                    $j++;
                }

        }



        if($allocationtype == 'reallocate'){

            $this->loadModel('MmsUser');

            $sql = "SELECT tanod.id,tanod.registration_code,tanod.sup_id,tanod.pri_id from tbl_allocation_n_o_details tanod
                    inner join mc_user mc on mc.mcu_child_user_name = tanod.registration_code
                    Inner Join mc_applicant_det mad ON mad.mcappd_app_id = mc.mcu_parent_app_id";


            if($activity_type != ''){
                    
                $sql .= " and mc.mcu_activity = '$activity_type'";
            }  

            if($state_code != ''){
                
                $sql .= " and mad.mcappd_state = '$state_code'";
            }

            $result = $conn->execute($sql)->fetchAll('assoc');

            $code = array();
            $i = 0;
            $j = 1;
            foreach($result as $each){

                $code[$i][0] = $each['id'].'-'.$each['registration_code'];
                $code[$i][1] = $each['registration_code'];

                if($each['sup_id'] != ''){

                    $supList = $this->MmsUser->find('all',array('fields'=>array('first_name','last_name','user_name'),
                                        'conditions'=>array('id IS'=>$each['sup_id'])))->first();
                    if(!empty($supList)){
                     $code[$i][2] = $supList['first_name'].' '.$supList['last_name'].'('.$supList['user_name'] .')';
                    }else{
                        $code[$i][2] = 'NA'; 
                    }    
                }else{

                    $code[$i][2] = '---';
                }
                
                if($each['pri_id'] != ''){

                    $priList = $this->MmsUser->find('all',array('fields'=>array('first_name','last_name','user_name'),
                                        'conditions'=>array('id IS'=>$each['pri_id'])))->first();
                    if(!empty($priList)){
                    $code[$i][3] = $priList['first_name'].' '.$priList['last_name'].'('.$priList['user_name'] .')';
                    }else{
                        $code[$i][3] = 'NA';
                    }    
                }else{

                    $code[$i][3] = '---';
                }                
                
                $i++;
                $j++;
            }

        }     

        
        
        $codeResult['data'] = $code;
        echo json_encode($codeResult);     

        exit;    

    }

    public function setRoles(){

        $this->viewBuilder()->setLayout('mms_panel');
        $mmsUserId = $this->Session->read('mms_user_id');
        
        $this->alert_theme = '';

        $conn = ConnectionManager::get('default');

        $sql = "select id,CONCAT(IFNULL(first_name,''),' ',IFNULL(last_name,''),'(',user_name,')') name from mms_user
        where id NOT IN (select user_id from mms_secondary_user_roles) and is_delete = '0'
        and user_name IS NOT NULL
        order by first_name asc";

        $result = $conn->execute($sql)->fetchAll('assoc');

        $users = array();
        foreach($result as $each){
            $users[$each['id']] = $each['name'];
        }

        $this->set('users',$users);
       // print_r($this->request->getData()); exit;
        if(null !== $this->request->getData('save')){

            $userRoles = '';
            $user_id = '';

            if($this->request->getData('add_user')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'add_user';
                }else{
                    $userRoles = 'add_user';
                }
                
            }
            if($this->request->getData('user_roles')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'user_roles';
                }else{
                    $userRoles = 'user_roles';
                }
            }
            if($this->request->getData('cms')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'cms';
                }else{
                    $userRoles = 'cms';
                }
            }
			
			
			if($this->request->getData('io')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'inspection_officer';
                }else{
                    $userRoles = 'inspection_officer';
                }
            }
			
			
			if($this->request->getData('ddo')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'ddo';
                }else{
                    $userRoles = 'ddo';
                }
            }
			
			if($this->request->getData('sodo')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'sodo';
                }else{
                    $userRoles = 'sodo';
                }
            }
            
            // added com user role on 22-09-2022 by Aniket
			if($this->request->getData('com')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'com';
                }else{
                    $userRoles = 'com';
                }
            }
            // added view_only user role on 29-03-2023 by Ankush T
            if($this->request->getData('view_only')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'view_only';
                }else{
                    $userRoles = 'view_only';
                }
            }

            if(filter_var($this->request->getData('selected_user'), FILTER_VALIDATE_INT)) {
                $user_id = $this->request->getData('selected_user');
            }
          
            if($userRoles != '' && $user_id != '')
            {  
                $date = date('d-m-y H:i:s');
                $sqlCreate = "insert into mms_secondary_user_roles(user_id,roles,created,modified,created_by)
                        values('$user_id','$userRoles','$date','$date','$mmsUserId') ";
                $conn->execute($sqlCreate); 

				$this->alert_theme = 'success';
                $this->alert_message = "Role successfully set";  
                $this->alert_redirect_url = "set-roles";

            }else{
                $this->alert_theme = 'error';
                $this->alert_message = "User or Role not Selected";
                $this->alert_redirect_url = "set-roles"; 
            }
            
        }

        $this->set('alert_theme',$this->alert_theme);
        $this->set('alert_message',$this->alert_message);
        $this->set('alert_redirect_url',$this->alert_redirect_url);        
    }

    public function editRoles(){

        $this->viewBuilder()->setLayout('mms_panel');
        $conn = ConnectionManager::get('default');
        $mmsUserId = $this->Session->read('mms_user_id');

        $this->alert_theme = '';

        $sql = "select id,CONCAT(IFNULL(first_name,''),' ',IFNULL(last_name,''),'(',user_name,')') name from mms_user
        where id IN (select user_id from mms_secondary_user_roles) and is_delete = '0'
        and user_name IS NOT NULL
        order by first_name asc";

        $result =  $conn->execute($sql)->fetchAll('assoc');

        $users = array();
        foreach($result as $each){
            $users[$each['id']] = $each['name'];
        }

        $this->set('users',$users);

        if(null !== $this->request->getData('save')){

            $userRoles = '';
            $user_id = '';

            if($this->request->getData('add_user')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'add_user';
                }else{
                    $userRoles = 'add_user';
                }
                
            }
            if($this->request->getData('user_roles')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'user_roles';
                }else{
                    $userRoles = 'user_roles';
                }
            }
            if($this->request->getData('cms')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'cms';
                }else{
                    $userRoles = 'cms';
                }
            }
			
			
			/** Start Add new mining plan roles, Pravin Bhakare 07-06-2022 **/
			if($this->request->getData('io')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'inspection_officer';
                }else{
                    $userRoles = 'inspection_officer';
                }
            }
			
			
			if($this->request->getData('ddo')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'ddo';
                }else{
                    $userRoles = 'ddo';
                }
            }
			
			if($this->request->getData('sodo')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'sodo';
                }else{
                    $userRoles = 'sodo';
                }
            }
            
            // added com user role on 22-09-2022 by Aniket
			if($this->request->getData('com')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'com';
                }else{
                    $userRoles = 'com';
                }
            }
            // added view_only user role on 29-03-2023 by Ankush T
            if($this->request->getData('view_only')==1){

                if(!empty($userRoles)){
                    $userRoles = $userRoles.','.'view_only';
                }else{
                    $userRoles = 'view_only';
                }
            }
			
			/** End **/
			

            if(filter_var($this->request->getData('selected_user'), FILTER_VALIDATE_INT)) {
                $user_id = $this->request->getData('selected_user');
            }
          
            if($user_id != '')
            {  
                $date = date('d-m-y H:i:s');
                $sqlCreate = "update mms_secondary_user_roles set roles = '$userRoles', modified = '$date', created_by = '$mmsUserId'
                              where user_id = '$user_id' ";
                $conn->execute($sqlCreate); 

                $this->alert_theme = 'success';
                $this->alert_message = "Role successfully updated";  
                $this->alert_redirect_url = "edit-roles";

            }else{
                $this->alert_theme = 'error';
                $this->alert_message = "User not Selected";
                $this->alert_redirect_url = "edit-roles"; 
            }
            
        }

        $this->set('alert_theme',$this->alert_theme);
        $this->set('alert_message',$this->alert_message);
        $this->set('alert_redirect_url',$this->alert_redirect_url);

    }

    public function getUserRoles(){

        $this->autoRender = false;

        $error = 'no';   
        $user_roles = ''; 
        $user_id = $_POST['user_id'];

        if(!filter_var($user_id, FILTER_VALIDATE_INT)) {

            $error = 'yes';

        }else{
            $conn = ConnectionManager::get('default');
            $sql = "select roles from mms_secondary_user_roles where user_id = '$user_id'";
            $result =  $conn->execute($sql)->fetchAll('assoc');
            $user_roles = $result[0]['roles'];

            // Check status of user work allocation
            $user_role_arr = explode(',',$user_roles);
            $user_role_alloc_status = [];
            $user_role_alloc_list = [];
            foreach($user_role_arr as $role) {
                if(in_array($role, array('inspection_officer','ddo','sodo','com'))){
                    
                    if($role == 'ddo'){
                        $col_nm = 'ddo_id';
                        $tbl = 'ddo_allocation';
                        $tbl_select = 'id, ro_office_id';
                        $tbl_get_col = 'ro_office_id';
                        $connection = ConnectionManager::get('default');
                        $tbl_two = 'dir_region';
                        $tbl_two_select = 'region_name';
                        $tbl_two_where = 'id';
                    } else {
                        $col_nm = ($role == 'inspection_officer') ? 'scru_id' : (($role == 'sodo') ? 'odo_id' : 'com_id');
                        $tbl = 'mp_allocation_details';
                        $tbl_select = 'id, lease_id';
                        $tbl_get_col = 'lease_id';
                        $connection = ConnectionManager::get('mpas');
                        $tbl_two = 'mp_mine_lease_loc_details';
                        $tbl_two_select = 'ml_pb_lease_code';
                        $tbl_two_where = 'lease_id';
                    }

                    $user_allocation =  $connection->execute("SELECT $tbl_select FROM $tbl WHERE $col_nm = '$user_id'")->fetchAll('assoc');
                    $role_n = ($role == 'inspection_officer') ? 'io' : $role;
                    $user_role_alloc_status[$role_n] = (count($user_allocation) > 0) ? 1 : 0;

                    // specify the work allocation details, added on 06-10-2022 by Aniket. 
                    if($user_role_alloc_status[$role_n] == 1){
                        $col_nm = ($col_nm == 'scru_id') ? 'IO' : $col_nm;
                        $role_txt = str_replace('_','',$col_nm);
                        $role_txt = strtoupper(str_replace('id','',$role_txt));
                        $tbl_two_where_val = $user_allocation[0][$tbl_get_col];
                        $lease_data = $connection->execute("SELECT $tbl_two_select FROM $tbl_two WHERE $tbl_two_where = '$tbl_two_where_val'")->fetchAll('assoc');
                        $role_txt_two = ($role == 'ddo') ? 'RO office(s) ' : 'lease(s) ';
                        $lease_data_txt = $role_txt.' role for the '.$role_txt_two;
                        $m = 0;
                        $andMoreRoleTxt = (count($lease_data) > 5) ? ' ... and ('.(count($lease_data)-5).') more' : '';
                        foreach($lease_data as $ldt){
                            $sp = ($m != 0) ? ', ' : '';
                            $lease_data_txt .= $sp.$ldt[$tbl_two_select];
                            if($m == 5){ break; }
                            $m++;
                        }
                        $user_role_alloc_list[$role_n] = $lease_data_txt.$andMoreRoleTxt.'.';
                    }else{
                        $user_role_alloc_list[$role_n] = 0;
                    }

                } else {
                    $user_role_alloc_status[$role] = 0;
                    $user_role_alloc_list[$role] = 0;
                }
                
            }
        }
        $returnArray[0] = $error;
        $returnArray[1] = $user_roles;
        $returnArray[2] = $user_role_alloc_status;
        $returnArray[3] = $user_role_alloc_list;

        echo json_encode($returnArray);

    }
	
	
	/** Start DDO Allocation, Pravin Bhakare 07-06-2022 **/
	public function ddoAllocation(){
		
		$this->viewBuilder()->setLayout('mms_panel');
		$this->loadModel('DirRegion');
		$this->loadModel('MmsUser');
		$this->loadModel('MmsSecondaryUserRoles');
		$this->loadModel('DdoAllocation');
		
		$results = $this->DirRegion->find('all',array('keyField'=>'id','valueField'=>'region_name','conditions'=>array('delete_status IS'=>'no')))->toArray();
		$this->set('results',$results);
		
		$allocatedddo = $this->DdoAllocation->find('list',array('keyField'=>'ro_office_id','valueField'=>'ddo_id'))->toArray();
		$this->set('allocatedddo',$allocatedddo);
		//print_r($allocatedddo); exit;
		
		$ddoUserList = $this->MmsUser->find('all',array('fields'=>array('id'),'conditions'=>array('is_delete IS'=>'0','role_id IS'=>'21')))->toArray();
		$ddoRoleAssignlist = $this->MmsSecondaryUserRoles->find('all',array('fields'=>array('user_id'),'conditions'=>array('roles LIKE'=>'%ddo%')))->toArray();
		
		$allDdoList = array_unique(array_merge(array_column($ddoUserList, 'id'),array_column($ddoRoleAssignlist,'user_id')));
		
		$ddoDetails = $this->MmsUser->find('all',array('fields'=>array('id','first_name','last_name','email'),'conditions'=>array('id IN'=>$allDdoList)))->toArray();
		
		foreach($ddoDetails as $key){
			
			$userlist[$key['id']] = $key['first_name'].' '.$key['last_name'].'('.base64_decode($key['email']).')';
		}
		
		$this->set('userlist',$userlist);
			
		
	}


    
} 



?>    