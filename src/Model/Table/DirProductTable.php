<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirProductTable extends Table{

		var $name = "DirProduct";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		// get product list
		public function getProductList() {

			$query = $this->find('all')
					->select(['product_def'])
					->where(['delete_status'=>'no'])
					->toArray();

			$data = array();
			$i = 0;
			foreach ($query as $m) {
				$data[$i] = trim($m['product_def']);
				$i++;
			}

			return $data;
			
		}

	    public function getUnit($prod_name) {

	        $query = $this->find('all')
	                ->select(['unit'])
	                ->where(['product_def LIKE '=>$prod_name."%"])
	                ->toArray();

	        $unit = "";
	        if (count($query) > 0)
	            $unit = $query[0]['unit'];

	        return $unit;
	    }

public function postDataValidationMasters($forms_data)
		{
			$returnValue = 1;

			$productDef = $forms_data['product_def'];
			$unit = $forms_data['unit'];

			if (strlen($forms_data['product_def']) > 50) {
				$returnValue = null;
			}
			if (strlen($forms_data['unit']) > 10) {
				$returnValue = null;
			}

			if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['product_def'])) {
				$returnValue = null;
			}

			if (!preg_match("/^[a-zA-Z]+$/", $forms_data['unit'])) {
				$returnValue = null;
			}
			return $returnValue;
		}

	} 
?>