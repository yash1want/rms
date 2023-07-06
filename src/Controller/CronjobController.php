<?php

	namespace App\Controller;

	use Cake\Event\EventInterface;
	use App\Network\Email\Email;
	use Cake\ORM\Entity;
	use Cake\Datasource\ConnectionManager;

	class CronjobController extends AppController{
			
		var $name = 'Cronjob';
		var $uses = array();
		
		public function initialize(): void
		{
			parent::initialize();
			$this->loadComponent('Counts');
			$this->DirRegion = $this->getTableLocator()->get('DirRegion');
			$this->DirZone = $this->getTableLocator()->get('DirZone');
			$this->DirState = $this->getTableLocator()->get('DirState');
			$this->MmsUser = $this->getTableLocator()->get('MmsUser');
		}
		
		public function mmsDashboardCount(){
			
			$this->autoRender = false;
			
			ini_set('max_execution_time', '1200');
			date_default_timezone_set('Asia/Kolkata');
			
			$userRole = $this->Session->read('mms_user_role'); // Added by Shweta Apale on 19-06-2023
			
			$conn = ConnectionManager::get('default');
			
			$conn->execute("truncate table mms_dashboard_counts");
			
			///////////////// master admin user dashboard count for miners ///////////////////////
			if($userRole == 1) { // Added by Shweta Apale on 19-06-2023
				$adminCounts = $conn->execute("SELECT * from view_admin_user_count")->fetchAll('assoc');		
				foreach($adminCounts as $each){
					
					$mms_user_id = 1;
					$return_type = $each['return_type'];
					$status = $each['status'];
					$counts = $each['count'];
					
					if($return_type == 'MONTHLY'){ $form_type = 'F'; }
					elseif($return_type == 'ANNUAL'){ $form_type = 'G'; }
					
					$adminResult = $conn->execute("select id from mms_dashboard_counts where mms_user_id = '$mms_user_id' and return_type= '$return_type'
									and form_type = '$form_type' and user_role = 'adminuser' and status = '$status'")->fetchAll('assoc');
					
					if(empty($adminResult)){					
						$conn->execute("INSERT INTO mms_dashboard_counts (mms_user_id,return_type,form_type,user_role,status,counts)
										VALUES('$mms_user_id','$return_type','$form_type','adminuser','$status',$counts)");
					}else{
					
						$date = date('Y-m-d H:m:s');					
						$conn->execute("UPDATE mms_dashboard_counts 
													set counts = $counts,modified='$date'
													where mms_user_id = '$mms_user_id' and return_type= '$return_type'
													and form_type = '$form_type' and user_role = 'adminuser' and status = '$status'");
					}	
									
				}
				
				
				///////////////// master admin user dashboard count for end users ///////////////////////
				
				$endAdminCounts = $conn->execute("SELECT * from view_end_admin_user_count")->fetchAll('assoc');
				
				foreach($endAdminCounts as $eachEndCount){
					
					$end_mms_user_id = 1;
					$end_return_type = $eachEndCount['return_type'];
					$end_status = $eachEndCount['status'];
					$end_counts = $eachEndCount['count'];
					
					if($end_return_type == 'MONTHLY'){ $end_form_type = 'L'; }
					elseif($end_return_type == 'ANNUAL'){ $end_form_type = 'M'; }
					
					
					$endAdminResult = $conn->execute("select id from mms_dashboard_counts where mms_user_id = '$end_mms_user_id' and return_type= '$end_return_type'
									and form_type = '$end_form_type' and user_role = 'endadminuser' and status = '$end_status'")->fetchAll('assoc');
					
					if(empty($endAdminResult)){					
						$conn->execute("INSERT INTO mms_dashboard_counts (mms_user_id,return_type,form_type,user_role,status,counts)
									VALUES('$end_mms_user_id','$end_return_type','$end_form_type','endadminuser','$end_status',$end_counts)");
					}else{
					
						$date = date('Y-m-d H:m:s');					
						$conn->execute("UPDATE mms_dashboard_counts 
													set counts = $end_counts,modified='$date'
													where mms_user_id = '$end_mms_user_id' and return_type= '$end_return_type'
													and form_type = '$end_form_type' and user_role = 'endadminuser' and status = '$end_status'");
					}	
					
					
				}
			}
			///////////////// Primary user dashboard count for Miners ///////////////////////
			else if ($userRole == 3) { // Added by Shweta Apale on 19-06-2023
				$primaryUserCounts = $conn->execute("SELECT * from view_primary_count")->fetchAll('assoc');
				
				foreach($primaryUserCounts as $eachPri){
					
					$pri_user_id = $eachPri['pri_id'];
					$pri_return_type = $eachPri['return_type'];
					$pri_status = $eachPri['status'];
					$pri_counts = $eachPri['count'];
					
					if($pri_return_type == 'MONTHLY'){ $pri_form_type = 'F'; }
					elseif($pri_return_type == 'ANNUAL'){ $pri_form_type = 'G'; }
					
					$priUserResult = $conn->execute("select id from mms_dashboard_counts where mms_user_id = '$pri_user_id' and return_type= '$pri_return_type'
									and form_type = '$pri_form_type' and user_role = 'primaryuser' and status = '$pri_status'")->fetchAll('assoc');
					
					if(empty($priUserResult)){					
						$conn->execute("INSERT INTO mms_dashboard_counts (mms_user_id,return_type,form_type,user_role,status,counts)
									VALUES('$pri_user_id','$pri_return_type','$pri_form_type','primaryuser','$pri_status',$pri_counts)");
					}else{
					
						$date = date('Y-m-d H:m:s');					
						$conn->execute("UPDATE mms_dashboard_counts 
													set counts = $pri_counts,modified='$date'
													where mms_user_id = '$pri_user_id' and return_type= '$pri_return_type'
													and form_type = '$pri_form_type' and user_role = 'primaryuser' and status = '$pri_status'");
					}
					
					
				}
			}
			///////////////// Supervisor user dashboard count for Miners ///////////////////////
			else if ($userRole == 2) { // Added by Shweta Apale on 19-06-2023
				$supUserCounts = $conn->execute("SELECT * from view_supervisor_count")->fetchAll('assoc');
				
				foreach($supUserCounts as $eachSup){
					
					$sup_user_id = $eachSup['sup_id'];
					$sup_return_type = $eachSup['return_type'];
					$sup_status = $eachSup['status'];
					$sup_counts = $eachSup['count'];
					
					if($sup_return_type == 'MONTHLY'){ $sup_form_type = 'F'; }
					elseif($sup_return_type == 'ANNUAL'){ $sup_form_type = 'G'; }
					
					$supUserResult = $conn->execute("select id from mms_dashboard_counts where mms_user_id = '$sup_user_id' and return_type= '$sup_return_type'
									and form_type = '$sup_form_type' and user_role = 'supervisoruser' and status = '$sup_status'")->fetchAll('assoc');
					
					if(empty($supUserResult)){					
						$conn->execute("INSERT INTO mms_dashboard_counts (mms_user_id,return_type,form_type,user_role,status,counts)
									VALUES('$sup_user_id','$sup_return_type','$sup_form_type','supervisoruser','$sup_status',$sup_counts)");
					}else{
					
						$date = date('Y-m-d H:m:s');					
						$conn->execute("UPDATE mms_dashboard_counts 
													set counts = $sup_counts,modified='$date'
													where mms_user_id = '$sup_user_id' and return_type= '$sup_return_type'
													and form_type = '$sup_form_type' and user_role = 'supervisoruser' and status = '$sup_status'");
					}
					
				}
			}
			
			///////////////// End Primary user dashboard count for end user ///////////////////////
			else if ($userRole == 9) { // Added by Shweta Apale on 19-06-2023
				$endPrimaryUserCounts = $conn->execute("SELECT * from view_end_primary_count")->fetchAll('assoc');
				
				foreach($endPrimaryUserCounts as $eachEndPri){
					
					$end_pri_user_id = $eachEndPri['pri_id'];
					$end_pri_return_type = $eachEndPri['return_type'];
					$end_pri_status = $eachEndPri['status'];
					$end_pri_counts = $eachEndPri['count'];
					
					if($end_pri_return_type == 'MONTHLY'){ $end_pri_form_type = 'L'; }
					elseif($end_pri_return_type == 'ANNUAL'){ $end_pri_form_type = 'M'; }
					
					$endPriUserResult = $conn->execute("select id from mms_dashboard_counts where mms_user_id = '$end_pri_user_id' and return_type= '$end_pri_return_type'
									and form_type = '$end_pri_form_type' and user_role = 'primaryuser' and status = '$end_pri_status'")->fetchAll('assoc');
					
					if(empty($endPriUserResult)){					
						$conn->execute("INSERT INTO mms_dashboard_counts (mms_user_id,return_type,form_type,user_role,status,counts)
									VALUES('$end_pri_user_id','$end_pri_return_type','$end_pri_form_type','primaryuser','$end_pri_status',$end_pri_counts)");
					}else{
					
						$date = date('Y-m-d H:m:s');					
						$conn->execute("UPDATE mms_dashboard_counts 
													set counts = $end_pri_counts,modified='$date'
													where mms_user_id = '$end_pri_user_id' and return_type= '$end_pri_return_type'
													and form_type = '$end_pri_form_type' and user_role = 'primaryuser' and status = '$end_pri_status'");
					}
									
				}
			}
			
			///////////////// End Supervisor user dashboard count for end user ///////////////////////
			else if ($userRole == 8) { // Added by Shweta Apale on 19-06-2023
				$endSupUserCounts = $conn->execute("SELECT * from view_end_supervisor_count")->fetchAll('assoc');
				
				foreach($endSupUserCounts as $eachEndSup){
					
					$end_sup_user_id = $eachEndSup['sup_id'];
					$end_sup_return_type = $eachEndSup['return_type'];
					$end_sup_status = $eachEndSup['status'];
					$end_sup_counts = $eachEndSup['count'];
					
					if($end_sup_return_type == 'MONTHLY'){ $end_sup_form_type = 'L'; }
					elseif($end_sup_return_type == 'ANNUAL'){ $end_sup_form_type = 'M'; }
					
					$endSupUserResult = $conn->execute("select id from mms_dashboard_counts where mms_user_id = '$end_sup_user_id' and return_type= '$end_sup_return_type'
									and form_type = '$end_sup_form_type' and user_role = 'supervisoruser' and status = '$end_sup_status'")->fetchAll('assoc');
					
					if(empty($endSupUserResult)){					
						$conn->execute("INSERT INTO mms_dashboard_counts (mms_user_id,return_type,form_type,user_role,status,counts)
									VALUES('$end_sup_user_id','$end_sup_return_type','$end_sup_form_type','supervisoruser','$end_sup_status',$end_sup_counts)");
					}else{
					
						$date = date('Y-m-d H:m:s');					
						$conn->execute("UPDATE mms_dashboard_counts 
													set counts = $end_sup_counts,modified='$date'
													where mms_user_id = '$end_sup_user_id' and return_type= '$end_sup_return_type'
													and form_type = '$end_sup_form_type' and user_role = 'supervisoruser' and status = '$end_sup_status'");
					}				
				}
			}
			
			///////////////// Zone user dashboard count for Miners ///////////////////////
			else if ($userRole == 5) { // Added by Shweta Apale on 19-06-2023
				$zoneUserCounts = $conn->execute("SELECT * from view_zone_user_count")->fetchAll('assoc');
				
				foreach($zoneUserCounts as $eachZone){
					
					$zone_user_id = $eachZone['mms_user_id'];
					$zone_return_type = $eachZone['return_type'];
					$zone_status = $eachZone['status'];
					$zone_counts = $eachZone['count'];
					
					if($zone_return_type == 'MONTHLY'){ $zone_form_type = 'F'; }
					elseif($zone_return_type == 'ANNUAL'){ $zone_form_type = 'G'; }
					
					$zoneUserResult = $conn->execute("select id from mms_dashboard_counts where mms_user_id = '$zone_user_id' and return_type= '$zone_return_type'
									and form_type = '$zone_form_type' and user_role = 'zoneuser' and status = '$zone_status'")->fetchAll('assoc');
					
					if(empty($zoneUserResult)){					
						$conn->execute("INSERT INTO mms_dashboard_counts (mms_user_id,return_type,form_type,user_role,status,counts)
									VALUES('$zone_user_id','$zone_return_type','$zone_form_type','zoneuser','$zone_status',$zone_counts)");
					}else{
					
						$date = date('Y-m-d H:m:s');					
						$conn->execute("UPDATE mms_dashboard_counts 
													set counts = $zone_counts,modified='$date'
													where mms_user_id = '$zone_user_id' and return_type= '$zone_return_type'
													and form_type = '$zone_form_type' and user_role = 'zoneuser' and status = '$zone_status'");
					}					
				}
			
				///////////////// Zone user dashboard count for Endusers ///////////////////////
				
				$zoneUserEndCounts = $conn->execute("SELECT * from view_end_zone_user_count")->fetchAll('assoc');
				
				foreach($zoneUserEndCounts as $eachZone){
					
					$zone_user_id = $eachZone['mms_user_id'];
					$zone_return_type = $eachZone['return_type'];
					$zone_status = $eachZone['status'];
					$zone_counts = $eachZone['count'];
					
					if($zone_return_type == 'MONTHLY'){ $zone_form_type = 'L'; }
					elseif($zone_return_type == 'ANNUAL'){ $zone_form_type = 'M'; }
					
					$zoneUserResult = $conn->execute("select id from mms_dashboard_counts where mms_user_id = '$zone_user_id' and return_type= '$zone_return_type'
									and form_type = '$zone_form_type' and user_role = 'zoneuser' and status = '$zone_status'")->fetchAll('assoc');
					
					if(empty($zoneUserResult)){					
						$conn->execute("INSERT INTO mms_dashboard_counts (mms_user_id,return_type,form_type,user_role,status,counts)
									VALUES('$zone_user_id','$zone_return_type','$zone_form_type','zoneuser','$zone_status',$zone_counts)");
					}else{
					
						$date = date('Y-m-d H:m:s');					
						$conn->execute("UPDATE mms_dashboard_counts 
													set counts = $zone_counts,modified='$date'
													where mms_user_id = '$zone_user_id' and return_type= '$zone_return_type'
													and form_type = '$zone_form_type' and user_role = 'zoneuser' and status = '$zone_status'");
					}
									
				}
			}
			
			///////////////// Region user dashboard count for Miners ///////////////////////
			else if ($userRole == 6) { // Added by Shweta Apale on 19-06-2023
				$regionUserCounts = $conn->execute("SELECT * from view_region_user_count")->fetchAll('assoc');
				
				foreach($regionUserCounts as $eachRegion){
					
					$region_user_id = $eachRegion['mms_user_id'];
					$region_return_type = $eachRegion['return_type'];
					$region_status = $eachRegion['status'];
					$region_counts = $eachRegion['count'];
					
					if($region_return_type == 'MONTHLY'){ $region_form_type = 'F'; }
					elseif($region_return_type == 'ANNUAL'){ $region_form_type = 'G'; }
					
					$regionUserResult = $conn->execute("select id from mms_dashboard_counts where mms_user_id = '$region_user_id' and return_type= '$region_return_type'
									and form_type = '$region_form_type' and user_role = 'regionuser' and status = '$region_status'")->fetchAll('assoc');
					
					if(empty($regionUserResult)){					
						$conn->execute("INSERT INTO mms_dashboard_counts (mms_user_id,return_type,form_type,user_role,status,counts)
									VALUES('$region_user_id','$region_return_type','$region_form_type','regionuser','$region_status',$region_counts)");
					}else{
					
						$date = date('Y-m-d H:m:s');					
						$conn->execute("UPDATE mms_dashboard_counts 
													set counts = $region_counts,modified='$date'
													where mms_user_id = '$region_user_id' and return_type= '$region_return_type'
													and form_type = '$region_form_type' and user_role = 'regionuser' and status = '$region_status'");
					}				
				}
				
				///////////////// Region user dashboard count for Endusers ///////////////////////
				
				$regionEndUserCounts = $conn->execute("SELECT * from view_end_region_user_count")->fetchAll('assoc');
				
				foreach($regionEndUserCounts as $eachRegion){
					
					$region_user_id = $eachRegion['mms_user_id'];
					$region_return_type = $eachRegion['return_type'];
					$region_status = $eachRegion['status'];
					$region_counts = $eachRegion['count'];
					
					if($region_return_type == 'MONTHLY'){ $region_form_type = 'L'; }
					elseif($region_return_type == 'ANNUAL'){ $region_form_type = 'M'; }
					
					$regionUserResult = $conn->execute("select id from mms_dashboard_counts where mms_user_id = '$region_user_id' and return_type= '$region_return_type'
									and form_type = '$region_form_type' and user_role = 'regionuser' and status = '$region_status'")->fetchAll('assoc');
					
					if(empty($regionUserResult)){					
						$conn->execute("INSERT INTO mms_dashboard_counts (mms_user_id,return_type,form_type,user_role,status,counts)
									VALUES('$region_user_id','$region_return_type','$region_form_type','regionuser','$region_status',$region_counts)");
					}else{
					
						$date = date('Y-m-d H:m:s');					
						$conn->execute("UPDATE mms_dashboard_counts 
													set counts = $region_counts,modified='$date'
													where mms_user_id = '$region_user_id' and return_type= '$region_return_type'
													and form_type = '$region_form_type' and user_role = 'regionuser' and status = '$region_status'");
					}				
				}
			}
			
			///////////////// DGM user dashboard count for Miners ///////////////////////
			else { // Added by Shweta Apale on 19-06-2023
				$dgmUserCounts = $conn->execute("SELECT * from view_dgm_user_count")->fetchAll('assoc');
				
				foreach($dgmUserCounts as $eachDGM){
					
					$dgm_user_id = $eachDGM['mms_user_id'];
					$dgm_return_type = $eachDGM['return_type'];
					$dgm_status = $eachDGM['status'];
					$dgm_counts = $eachDGM['count'];
					
					if($dgm_return_type == 'MONTHLY'){ $dgm_form_type = 'F'; }
					elseif($dgm_return_type == 'ANNUAL'){ $dgm_form_type = 'G'; }
					
					$dgmUserResult = $conn->execute("select id from mms_dashboard_counts where mms_user_id = '$dgm_user_id' and return_type= '$dgm_return_type'
									and form_type = '$dgm_form_type' and user_role = 'dgmuser' and status = '$dgm_status'")->fetchAll('assoc');
					
					if(empty($dgmUserResult)){					
						$conn->execute("INSERT INTO mms_dashboard_counts (mms_user_id,return_type,form_type,user_role,status,counts)
									VALUES('$dgm_user_id','$dgm_return_type','$dgm_form_type','dgmuser','$dgm_status',$dgm_counts)");
					}else{
					
						$date = date('Y-m-d H:m:s');					
						$conn->execute("UPDATE mms_dashboard_counts 
													set counts = $dgm_counts,modified='$date'
													where mms_user_id = '$dgm_user_id' and return_type= '$dgm_return_type'
													and form_type = '$dgm_form_type' and user_role = 'dgmuser' and status = '$dgm_status'");
					}					
				}

				///////////////// DGM user dashboard count for Endusers ///////////////////////
				
				$dgmUserEndCounts = $conn->execute("SELECT * from view_end_dgm_user_count")->fetchAll('assoc');
				
				foreach($dgmUserEndCounts as $eachDGM){
					
					$dgm_user_id = $eachDGM['mms_user_id'];
					$dgm_return_type = $eachDGM['return_type'];
					$dgm_status = $eachDGM['status'];
					$dgm_counts = $eachDGM['count'];
					
					if($dgm_return_type == 'MONTHLY'){ $dgm_form_type = 'L'; }
					elseif($dgm_return_type == 'ANNUAL'){ $dgm_form_type = 'M'; }
					
					$dgmUserResult = $conn->execute("select id from mms_dashboard_counts where mms_user_id = '$dgm_user_id' and return_type= '$dgm_return_type'
									and form_type = '$dgm_form_type' and user_role = 'dgmuser' and status = '$dgm_status'")->fetchAll('assoc');
					
					if(empty($dgmUserResult)){					
						$conn->execute("INSERT INTO mms_dashboard_counts (mms_user_id,return_type,form_type,user_role,status,counts)
									VALUES('$dgm_user_id','$dgm_return_type','$dgm_form_type','dgmuser','$dgm_status',$dgm_counts)");
					}else{
					
						$date = date('Y-m-d H:m:s');					
						$conn->execute("UPDATE mms_dashboard_counts 
													set counts = $dgm_counts,modified='$date'
													where mms_user_id = '$dgm_user_id' and return_type= '$dgm_return_type'
													and form_type = '$dgm_form_type' and user_role = 'dgmuser' and status = '$dgm_status'");
					}				
				}
			}
			//exit;
		}
		
		
		public function frontStatistics(){
			
			$conn = ConnectionManager::get('default');
			
			$f1_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'MONTHLY' and form_type IN('1') and is_latest='1'")->fetchAll('assoc');
			$f2_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'MONTHLY' and form_type IN('2') and is_latest='1'")->fetchAll('assoc');
			$f3_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'MONTHLY' and form_type IN('3') and is_latest='1'")->fetchAll('assoc');
			$f4_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'MONTHLY' and form_type IN('4') and is_latest='1'")->fetchAll('assoc');
			$f5_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'MONTHLY' and form_type IN('5') and is_latest='1'")->fetchAll('assoc');
			$f7_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'MONTHLY' and form_type IN('7') and is_latest='1'")->fetchAll('assoc');
			$f8_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'MONTHLY' and form_type IN('8') and is_latest='1'")->fetchAll('assoc');
			//print_r($f1_returns_received); exit; 
			$f1_counts = $f1_returns_received[0]['count'];
			$f2_counts = $f2_returns_received[0]['count'];
			$f3_counts = $f3_returns_received[0]['count'];
			$f4_counts = $f4_returns_received[0]['count'];
			$f5_counts = $f5_returns_received[0]['count'];
			$f7_counts = $f7_returns_received[0]['count'];
			$f8_counts = $f8_returns_received[0]['count'];
			
			$f_returns_received_t = $f1_counts + $f2_counts + $f3_counts + $f4_counts + $f5_counts + $f7_counts + $f8_counts;
			
			
			$h1_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'ANNUAL' and form_type IN('1') and is_latest='1'")->fetchAll('assoc');
			$h2_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'ANNUAL' and form_type IN('2') and is_latest='1'")->fetchAll('assoc');
			$h3_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'ANNUAL' and form_type IN('3') and is_latest='1'")->fetchAll('assoc');
			$h4_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'ANNUAL' and form_type IN('4') and is_latest='1'")->fetchAll('assoc');
			$h5_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'ANNUAL' and form_type IN('5') and is_latest='1'")->fetchAll('assoc');
			$h7_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'ANNUAL' and form_type IN('7') and is_latest='1'")->fetchAll('assoc');
			$h8_returns_received = $conn->execute("select count(applicant_id) as count from tbl_final_submit where return_type = 'ANNUAL' and form_type IN('8') and is_latest='1'")->fetchAll('assoc');
			
			$h1_counts = $h1_returns_received[0]['count'];
			$h2_counts = $h2_returns_received[0]['count'];
			$h3_counts = $h3_returns_received[0]['count'];
			$h4_counts = $h4_returns_received[0]['count'];
			$h5_counts = $h5_returns_received[0]['count'];
			$h7_counts = $h7_returns_received[0]['count'];
			$h8_counts = $h8_returns_received[0]['count'];
			
			$h_returns_received_t = $h1_counts + $h2_counts + $h3_counts + $h4_counts + $h5_counts + $h7_counts + $h8_counts;
			
			
			$l_returns_received_t = $conn->execute("select count(applicant_id) as count from tbl_end_user_final_submit where return_type = 'MONTHLY' and form_type IN('N') and is_latest='1'")->fetchAll('assoc');
			$m_returns_received_t = $conn->execute("select count(applicant_id) as count from tbl_end_user_final_submit where return_type = 'ANNUAL' and form_type IN('O') and is_latest='1'")->fetchAll('assoc');
			
			$l_counts = $l_returns_received_t[0]['count'];
			$m_counts = $m_returns_received_t[0]['count'];
			
			$conn->execute("update returns_statistics set f1_returns_received = '$f1_counts', f2_returns_received = '$f2_counts', f3_returns_received = '$f3_counts',
							f4_returns_received = '$f4_counts',f5_returns_received = '$f5_counts',f7_returns_received = '$f7_counts',f8_returns_received = '$f8_counts',
							f_returns_received_t = '$f_returns_received_t' where id='1' ");
			
			$conn->execute("update returns_statistics set h1_returns_received = '$h1_counts', h2_returns_received = '$h2_counts', h3_returns_received = '$h3_counts',
							h4_returns_received = '$h4_counts',h5_returns_received = '$h5_counts',h7_returns_received = '$h7_counts',h8_returns_received = '$h8_counts',
							h_returns_received_t = '$h_returns_received_t' where id='1' ");
							
			$conn->execute("update returns_statistics set l_returns_received_t = '$l_counts', m_returns_received_t = '$m_counts' where id='1' ");				
			
			
			$issued_received = $conn->execute("SELECT COUNT(*) as issued FROM mc_applicant_det WHERE mcappd_concession_no_issue=1")->fetchAll('assoc');
			$junked_received = $conn->execute("SELECT COUNT(*) as junked FROM mc_applicant_det WHERE mcappd_junk=1")->fetchAll('assoc');
			$suspended_received = $conn->execute("SELECT COUNT(*) as suspended FROM mc_applicant_det WHERE mcappd_suspend=1")->fetchAll('assoc');
			$totalreg_received = $conn->execute("SELECT COUNT(*) as totalreg FROM mc_applicant_det ")->fetchAll('assoc');
			
			$issued = $issued_received[0]['issued'];
			$junked = $junked_received[0]['junked'];
			$suspended = $suspended_received[0]['suspended'];
			$totalreg = $totalreg_received[0]['totalreg'];
			
			$conn->execute("update returns_statistics set issued = '$issued', suspended = '$suspended', junked = '$junked', totalreg = '$totalreg' where id='1' ");
			
			exit;
		}
		
	}
?>	