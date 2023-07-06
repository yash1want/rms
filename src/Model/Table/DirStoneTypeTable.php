<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirStoneTypeTable extends Table{

		var $name = "DirStoneType";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function fetchStoneGrades() {
			$stoneArr = $this->find('all')
			        ->select(['stone_sn','stone_def'])
					->where(['delete_status'=>'no'])
			        ->toArray();

			$result = array();
			$result[""] = "Select";
			foreach ($stoneArr as $tmpArr) {
			  $result[$tmpArr['stone_sn']] = $tmpArr['stone_def'];
			}
			return $result;
		}
		
		public function postDataValidationMasters($forms_data)
		{
			$returnValue = 1;

			$stoneDef = $forms_data['stone_def'];

			if (strlen($forms_data['stone_def']) > 100) {
				$returnValue = null;
			}
			if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['stone_def'])) {
				$returnValue = null;
			}
			return $returnValue;
		}

	} 
?>