<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use App\Controller\MonthlyController;
	use Cake\Core\Configure;
	
	class IncrDecrReasonsTable extends Table{

		var $name = "IncrDecrReasons";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function getAllData($mineCode, $returnType, $returnDate, $minaral){

			$MonthlyController = new MonthlyController;
		
			$query = $this->find('all')
	            ->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>$minaral])
	            ->toArray();
				
			if (count($query) > 0) {
				$data = $query[0];
			} else {
				$data = $MonthlyController->Customfunctions->getTableColumns('incr_decr_reasons');
			}

			return $data;
		}


	} 
?>