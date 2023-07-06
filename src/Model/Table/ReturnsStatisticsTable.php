<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class ReturnsStatisticsTable extends Table{

		var $name = "ReturnsStatistics";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		// get all returns count
		public function getReturnsCount(){

			$result = $this->find('all')->first();

			return $result;

		}

	} 
?>