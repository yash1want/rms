<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class MailSentLogsTable extends Table{

		var $name = "MailSentLogs";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}


		// public function getMineralName($mine_code){
			
		// 	$row_count = $this->find('all',array('conditions'=>array('mine_code'=>$mine_code)))->count();
		// 	if ($row_count > 0) {
		// 		$data = $this->find('all',array('conditions'=>array('mine_code'=>$mine_code)))->first();
		// 		$mineral_name = $data['mineral_name'];
		// 	} else {
		// 		$mineral_name = "--";
		// 	}
			
		// 	return $mineral_name;
			
		// }

		// public function fetchMineralInfo($mine_code){

  //       	$data = $this->find('all',array('conditions'=>array('mine_code'=>$mine_code),'order'=>array('mineral_sn'=>'ASC')))->toArray();
  //       	if(count($data) > 0){
  //       		$result = $data;
  //       	} else {
  //       		$result = [];
  //       	}

  //       	return $result;

		// }

	} 
?>