<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class DdoAllocationTable extends Table{
		
		var $name = "DdoAllocation";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function allocation($roid,$ddoid){

			$this->DdoAllocationLog = TableRegistry::getTableLocator()->get('DdoAllocationLog');
			$allocate_by = $_SESSION['mms_user_id'];
				
			$result = $this->find('all',array('fields'=>'id','conditions'=>array('ro_office_id IS'=>$roid)))->first();
			if(!empty($result)){				
				$rowid = $result['id'];
			}else{
				$rowid = '';
				
			}
			
			$newEntity = $this->newEntity(array(					
				'id'=>$rowid,
				'ro_office_id'=>$roid,
				'ddo_id'=>$ddoid,
				'create_by'=>$allocate_by,
				'created'=>date('Y-m-d H:i:s')
			));

			if($this->save($newEntity)){

				$logEntity = $this->newEntity(array(					
					'ro_office_id'=>$roid,											
					'ddo_id'=>$ddoid,
					'created'=>date('Y-m-d H:i:s'),
					'create_by'=>$allocate_by
				));

				$this->DdoAllocationLog->save($logEntity);		
				
				return true;
				
			}else{
				
				return false;
			}
		}	

			
		

				

}

    
    
?>    