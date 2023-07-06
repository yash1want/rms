<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class KwClientTypeTable extends Table{

		var $name = "KwClientType";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		// get all client type list
		// @addedon 24th MAR 2021 (by Aniket Ganvir)
		public function getAllClientType(){

			$result = $this->find('all')->select('client_type')->toArray();
			$associateResultArr = json_decode(json_encode($result), true);
			return $associateResultArr;

		}

	} 
?>