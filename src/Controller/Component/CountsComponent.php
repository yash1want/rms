<?php 

	namespace app\Controller\Component;
	use Cake\Controller\Controller;
	use Cake\Controller\Component;
	use Cake\Datasource\ConnectionManager;
	
	use Cake\Controller\ComponentRegistry;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	use Cake\Datasource\EntityInterface;
	use Cake\Utility\Security;
	use SimpleXMLElement;
	
	class CountsComponent extends Component {
	
		public $components= array('Session');
		public $controller = null;
		public $session = null;

		public function initialize(array $config): void {
			parent::initialize($config);
			$this->Controller = $this->_registry->getController();
			$this->Session = $this->getController()->getRequest()->getSession();
		}
		
		
		// Below lines of code commented because we are now make the views for fetching the dashboard counts. Done By Pravin Bhakare.
		/* public function getUserDashboardCountForMiner($status,$return_type){
			
			$conn = ConnectionManager::get('default');			
			$rows = $conn->execute("SELECT COUNT(*) as count FROM TBL_FINAL_SUBMIT fs WHERE fs.is_latest = 1 AND fs.return_type='$return_type' and (fs.status REGEXP '$status')")->fetchAll('assoc');
			return $rows[0]['count'];
		}
		
		public function getSupPriUserDashboardCountForMiner($userId,$status,$userRole,$return_type){
			
			if($userRole==2){
				$userCondition = "sup_id='$userId'";
			}elseif($userRole==3){
				$userCondition = "pri_id='$userId'";	 
			}
			
			$conn = ConnectionManager::get('default');	
			$rows = $conn->execute("SELECT COUNT(*) as count FROM TBL_FINAL_SUBMIT fs WHERE fs.is_latest = 1 AND fs.return_type='$return_type' and (fs.status REGEXP '$status') and fs.applicant_id IN (SELECT mine_id from TBL_ALLOCATION_DETAILS where $userCondition)")->fetchAll('assoc');
			return $rows[0]['count'];
		}
		
		
		public function getZoneUserDashboardCountForMiner($zoneName,$status,$return_type){
			
			$conn = ConnectionManager::get('default');				
			$rows = $conn->execute("select COUNT(*) as count from TBL_FINAL_SUBMIT fs WHERE fs.is_latest = 1 AND fs.return_type='$return_type' and (fs.status REGEXP '$status') and fs.mine_code IN (
										select distinct `mine_code` from mine m where m.district_code IN (select distinct district_code from DIR_DISTRICT where state_code=m.state_code and district_code=m.district_code and region_name in (
											select distinct region_name from DIR_REGION where zone_name LIKE '$zoneName')))")->fetchAll('assoc');
			return $rows[0]['count'];
			
		}
		
		public function getRoUserDashboardCountForMiner($region_name,$status,$return_type){
			
			$conn = ConnectionManager::get('default');				
			$rows = $conn->execute("select COUNT(*) as count from TBL_FINAL_SUBMIT fs WHERE fs.is_latest = 1 AND fs.return_type='$return_type' and (fs.status REGEXP '$status') and fs.mine_code IN (
										select distinct `mine_code` from mine m where m.district_code IN (select distinct district_code from DIR_DISTRICT where state_code=m.state_code and region_name REGEXP '$region_name' ))")->fetchAll('assoc');
			return $rows[0]['count'];
		}
		
		public function getDgmUserDashboardCountForMiner($state_code,$status,$return_type){
			
			$conn = ConnectionManager::get('default');				
			$rows = $conn->execute("select COUNT(*) as count from TBL_FINAL_SUBMIT fs WHERE fs.is_latest = 1 AND fs.return_type='$return_type' and (fs.status REGEXP '$status') and fs.mine_code IN (
										select distinct `mine_code` from mine m where m.state_code LIKE '$state_code' )")->fetchAll('assoc');
			return $rows[0]['count'];
		}
		
		public function getSupPriUserDashboardCountForEndusr($userId,$status,$userRole,$return_type){
			
			if($userRole==2 || $userRole==8){
				$userCondition = "sup_id='$userId'";
			}elseif($userRole==3 || $userRole==9){
				$userCondition = "pri_id='$userId'";	 
			}
			
			$conn = ConnectionManager::get('default');	
			$rows = $conn->execute("SELECT COUNT(*) as count FROM TBL_END_USER_FINAL_SUBMIT fs WHERE fs.is_latest = 1 AND fs.return_type='$return_type' and (fs.status REGEXP '$status') and fs.applicant_id IN (SELECT registration_code from TBL_ALLOCATION_N_O_DETAILS where $userCondition)")->fetchAll('assoc');
			return $rows[0]['count'];
			
		}
				
		public function getEndUserDashboardMonthlyCount($registration_code, $ibm_unique_reg_no,$status) {
			$registration_code = ($registration_code != "") ? "'$registration_code'" : "''";
			$ibm_unique_reg_no = ($ibm_unique_reg_no != "") ? "'$ibm_unique_reg_no'" : "''";
			$status = ($status != "") ? "'$status'" : "''";

			$conn = ConnectionManager::get('default');
			$q = $conn->execute("CALL SP_NSeriesFileReturns($registration_code, $ibm_unique_reg_no, $status,1, '', '')");
			$returns = $q->fetchAll();

			$total_records = $returns[0][0];
			return $total_records;
		}
		
		public function getEndUserDashboardAnnualCount($registration_code, $ibm_unique_reg_no, $status) {
			$registration_code = ($registration_code != "") ? "'$registration_code'" : "''";
			$ibm_unique_reg_no = ($ibm_unique_reg_no != "") ? "'$ibm_unique_reg_no'" : "''";
			$status = ($status != "") ? "'$status'" : "''";

			$conn = ConnectionManager::get('default');
			$q = $conn->execute("CALL SP_OSeriesFileReturns($registration_code, $ibm_unique_reg_no, $status,1, '', '')");
			$returns = $q->fetchAll();
			
			$total_records = $returns[0][0];
			return $total_records;
		} */
		
		
		
				
		
		

	}

?>