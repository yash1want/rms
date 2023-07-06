<?php 	

	namespace app\Controller\Component;
	use Cake\Controller\Controller;
	use Cake\Controller\Component;
	use Cake\Datasource\ConnectionManager;
	use Cake\Core\Configure;
	
	use Cake\Controller\ComponentRegistry;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	use Cake\Datasource\EntityInterface;
	use Cake\Utility\Security;
	use SimpleXMLElement;
	
	class ReturnslistComponent extends Component {
	
		public $components= array('Session','Customfunctions');
		public $controller = null;
		public $session = null;

		public function initialize(array $config): void {
			parent::initialize($config);
			$this->Controller = $this->_registry->getController();
			$this->Session = $this->getController()->getRequest()->getSession();
		}
		
		
		public function getFilteredReturnsList($mine_code, $mms_user_id, $zone, $region, $state, $district, $fromDate, $toDate, $form, $status, $userrole,$returntype){
		
		
			$listData = null;
			$form_type = $this->Session->read('sess_form_type');
			
			$filter = $this->Customfunctions->validateServerSide($mine_code, $mms_user_id, $zone, $region, $state, $district, $fromDate, $toDate, $form, $status, $userrole,$returntype);
			
			 $mine_code = ($mine_code != "") ? "'$mine_code'" : "''";
			 $zone = ($zone != "") ? "'$zone'" : "''";
			 $region = ($region != "") ? "'$region'" : "''";
			 $state = ($state != "") ? "'$state'" : "''";
			 $district = ($district != "") ? "'$district'" : "''";
			 $fromDate = ($fromDate != "") ? "'$fromDate'" : "''";
			 $toDate = ($toDate != "") ? "'$toDate'" : "''";
			 $form = ($form != "") ? "'$form'" : "''";			
			 $status = ($status != "") ? "'$status'" : "''";
			 $userrole = ($userrole != "") ? "$userrole" : "''";
			 $returntype = ($returntype != "") ? "'$returntype'" : "''";
			 $mms_user_id = ($mms_user_id != "") ? "'$mms_user_id'" : "'0'";
			 	
			
			if($filter == 'tampared'){
				
				return 'filterDataTampared';
				
			}else{
				
				// print_r("CALL SP_GetEndUserFileReturnsUpdate($mine_code,$mms_user_id,$zone,$region,$state,$district,$fromDate,$toDate,$status,$userrole,$returntype,20)");  exit;
				if(null !== $this->Session->read('oldreturns')){
					$conn = ConnectionManager::get(Configure::read('conn'));
				}else{
					$conn = ConnectionManager::get('default');
				}
				if($form_type == 'f' || $form_type == 'g'){	
					$listData = $conn->execute("CALL SP_GetFileReturnsUpdate($mine_code,$mms_user_id,$zone,$region,$state,$district,$fromDate,$toDate,$form,$status,$userrole,$returntype)")->fetchAll('assoc');
				}elseif($form_type == 'm' || $form_type == 'l'){
					//print_r("CALL SP_GetEndUserFileReturnsUpdate($mine_code,$mms_user_id,$zone,$region,$state,$district,$fromDate,$toDate,$status,$userrole,$returntype,20)");  exit;

					$listData = $conn->execute("CALL SP_GetEndUserFileReturnsUpdate($mine_code,$mms_user_id,$zone,$region,$state,$district,$fromDate,$toDate,$status,$userrole,$returntype,20)")->fetchAll('assoc');
				}
				return $listData; 
			}
		
		}


		public function getFilteredUserReturnsList($applicantid,$fromDate,$toDate,$status,$tablename,$returntype,$statusType,$isCount){

			$listData = null;
			$filter = $this->Customfunctions->validateServerSide($applicantid,$fromDate,$toDate,$status,$tablename,$returntype,$statusType,$isCount);
			
			$applicantid = ($applicantid != "") ? "'$applicantid'" : "''";
			$fromDate = ($fromDate != "") ? "'$fromDate'" : "''";
			$toDate = ($toDate != "") ? "'$toDate'" : "''";
			$status = ($status != "") ? "'$status'" : "''";
			$tablename = ($tablename != "") ? "'$tablename'" : "''";
			$returntype = ($returntype != "") ? "'$returntype'" : "''";
			$statusType = ($statusType != "") ? "'$statusType'" : "''";
			$isCount = ($isCount != "") ? "'$isCount'" : "''";

			if($filter == 'tampared'){
				
				return 'filterDataTampared';
				
			}else{
				$conn = ConnectionManager::get(Configure::read('conn'));
				// if (null != $this->Session->read('oldreturns')) {
				// 	//just put oldreturns db connection name added By Amey S. on 29/1/2022
				// 	$conn = ConnectionManager::get('default');
				// }
				//print_r("CALL SP_GetUserReturns($applicantid,$fromDate,$toDate,$status,$tablename,$returntype,$statusType,$isCount)"); exit;
				$listData = $conn->execute("CALL SP_GetUserReturns($applicantid,$fromDate,$toDate,$status,$tablename,$returntype,$statusType,$isCount)")->fetchAll('assoc');
				
				return $listData; 
			}
		}

		public function getFilteredPrimaryUserReturnsList($primaryId,$applicantId,$mineCode,$fromDate,$toDate,$status,$tablename,$returntype){

			$listData = null;
			$filter = $this->Customfunctions->validateServerSide($primaryId,$applicantId,$mineCode,$fromDate,$toDate,$status,$tablename,$returntype);
			
			$primaryId = ($primaryId != "") ? "'$primaryId'" : "''";
			$applicantId = ($applicantId != "") ? "'$applicantId'" : "''";
			$mineCode = ($mineCode != "") ? "'$mineCode'" : "''";
			$fromDate = ($fromDate != "") ? "'$fromDate'" : "''";
			$toDate = ($toDate != "") ? "'$toDate'" : "''";
			$status = ($status != "") ? "'$status'" : "''";
			$tablename = ($tablename != "") ? "'$tablename'" : "''";
			$returntype = ($returntype != "") ? "'$returntype'" : "''";

			if($filter == 'tampared'){
				
				return 'filterDataTampared';
				
			}else{

				$conn = ConnectionManager::get(Configure::read('conn'));
				// if (null != $this->Session->read('oldreturns')) {
				// 	//just put oldreturns db connection name added By Amey S. on 29/1/2022
				// 	$conn = ConnectionManager::get('default');
				// }
				//print_r("CALL SP_GetUserReturns($applicantid,$fromDate,$toDate,$status,$tablename,$returntype,$statusType,$isCount)"); exit;
				$listData = $conn->execute("CALL SP_GetPrimaryUserReturns($primaryId,$applicantId,$mineCode,$fromDate,$toDate,$status,$tablename,$returntype)")->fetchAll('assoc');
				
				return $listData; 
			}

		}
		
		
	
	}
	
	
?>