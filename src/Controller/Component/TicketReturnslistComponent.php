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
	
	class TicketReturnslistComponent extends Component 
	{
	
		public $components= array('Session','Customfunctions');
		public $controller = null;
		public $session = null;

		public function initialize(array $config): void 
		{
			parent::initialize($config);
			$this->Controller = $this->_registry->getController();
			$this->Session = $this->getController()->getRequest()->getSession();
		}
		
		
		public function getFilteredTicketList($ticket_type, $fromDate, $toDate,$status)
		{
		
			$listData = null;
			//$form_type = $this->Session->read('sess_form_type');
			//$status = $this->Session->read('ticket_type');
			
			$filter = $this->Customfunctions->validateServerSide($ticket_type,$fromDate,$toDate,$status);
			
			$ticket_type = ($ticket_type != "") ? "'$ticket_type'" : "''";
			$fromDate = ($fromDate != "") ? "'$fromDate'" : "''";
			$toDate = ($toDate != "") ? "'$toDate'" : "''";
			$status = ($status != "") ? "'$status'" : "''";
			 
			/*print_r($fromDate);
			print_r($toDate);exit;*/

			 	
			if($filter == 'tampared')
			{
				return 'filterDataTampared';
			}
			else
			{
				
				// print_r("CALL SP_GetEndUserFileReturnsUpdate($f_ticket_type,$mms_user_id,$zone,$region,$state,$district,$fromDate,$toDate,$status,$userrole,$returntype,20)");  exit;

				/*if(null !== $this->Session->read('ticket_type'))
				{
					$conn = ConnectionManager::get(Configure::read('conn'));
				}
				else
				{
					$conn = ConnectionManager::get('default');
				}
				if($status == 'all' || $status == 'pending' || $status == 'inprocess' || $status == 'resolve')
				{	
					$listData = $conn->execute("CALL SP_GetFileReturnsUpdate($f_ticket_type,fromDate,$toDate)")->fetchAll('assoc');
				}*/

				$conn = ConnectionManager::get(Configure::read('conn'));
				$listData = $conn->execute("CALL SP_GetTicketReturnFilter($ticket_type,$fromDate,$toDate,$status)")->fetchAll('assoc');
				//echo"<pre>";print_r($listData);exit;
				return $listData; 
			}
			
		
		}


		

		/*public function getFilteredPrimaryUserReturnsList($primaryId,$applicantId,$mineCode,$fromDate,$toDate,$status,$tablename,$returntype){

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

			}*/	
		
		
	
	}
	
	
?>