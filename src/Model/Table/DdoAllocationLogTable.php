<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class DdoAllocationLogTable extends Table{
		
		var $name = "DdoAllocationLog";			
		public $validate = array();
			

	}
    
?>    