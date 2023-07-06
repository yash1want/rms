<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class MmsDashboardCountsTable extends Table{

		var $name = "MmsDashboardCounts";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

	} 
?>