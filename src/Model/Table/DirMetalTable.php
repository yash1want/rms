<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirMetalTable extends Table{

		var $name = "DirMetal";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function getDropDownMetalList($min) {

			$mineral = strtoupper(str_replace('_', ' ', $min));

			$data = array();
			$data[""] = "Select";
			if ($mineral == "LEAD AND ZINC ORE") {
			$data[1] = "Lead Concentrate";
			$data[2] = "Zinc Concentrate";
			} else if($mineral == "COPPER ORE"){
			$data[1] = "Copper Ore";
			$data[2] = "Copper Concentrate";
			} else {
			$tmp_min = ucfirst(strtolower(ucwords($mineral)));
			$data[1] = $tmp_min . " Ore";
			$data[2] = $tmp_min . " Concentrate";
			}
			//    $data[0] = "NIL";

			return $data;
		}


		/**
		 * returns the grade name by id
		 * @param type $id
		 * @return type 
		 */
		public function getGradeName($id, $mineral) {
		  $data = $this->getDropDownMetalList($mineral);

		  return $data[$id];
		}

	  public function getMetalList() {
	    $query = $this->find('all')
	            ->select(['metal_def'])
				->where(['delete_status'=>'no'])
	            ->toArray();

	    $data = array();
	    $i = 0;
	    foreach ($query as $m) {
	      $data[$i] = $m['metal_def'];
	      $i++;
	    }

	    return $data;
	  }

public function postDataValidationMasters($forms_data)
		{
			$returnValue = 1;

			$metalName = $forms_data['metal_name'];
			$metalDef = $forms_data['metal_def'];

			if ($forms_data['metal_name'] == '') {
				$returnValue = null;
			}
			if (strlen($forms_data['metal_name']) > 2) {
				$returnValue = null;
			}
			if (strlen($forms_data['metal_def']) > 20) {
				$returnValue = null;
			}

			if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['metal_name'])) {
				$returnValue = null;
			}

			if (!preg_match("/^[a-zA-Z0-9\s]+$/", $forms_data['metal_def'])) {
				$returnValue = null;
			}
			return $returnValue;
		}


	} 
?>