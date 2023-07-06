<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use App\Controller\MonthlyController;
	use Cake\Core\Configure;
	
	class StartDatesTable extends Table{

		var $name = "StartDates";
		public $validate = array();
		
		// set default connection string
		// public static function defaultConnectionName(): string {
		// 	return Configure::read('conn');
		// }

		// Get cutoff date for Phase-II
		public function getStartDate() {

			$data = $this->find()
					->select(['startdate'])
					->order(['id'=>'DESC'])
					->first();
			//print_r(date('Y-m-d', strtotime($data['startdate']))); exit;
			//return date('Y-m-d', strtotime($data['startdate']));
			return '2022-04-01';

		}

	} 
?>