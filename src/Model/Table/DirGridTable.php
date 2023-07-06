<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirGridTable extends Table{

		var $name = "DirGrid";
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        /**
         * HERE I AM USING IF OF THE FIELD AS THE KEY AS THIS MASTER IS CREATED AT 
         * VERY LAST AND EARLIER THIS IS HARD CODED EVERY WHERE AND ALL THOSE FORMS
         * AND FUNCTIONS NEEDS ID AS THE KEY
         * 
         * DON'T CHANGE IT UNLESS YOU ARE VERY SURE OF WHAT YOU ARE DOING
         * 
         * @author Uday Shankar Singh <usingh@ubicsindia.com, udayshankar1306@gmail.com>
         * @return Array
         */
        public function getGridByIdKey(){

            $query = $this->query()
                    ->select(['id','grid_space'])
                    ->toArray();
            
            $result = Array();
            foreach($query as $data){
                $result[$data['id']] = $data['grid_space'];
            }
            
            return $result;

        }
		
		public function postDataValidationMasters($forms_data)
		{
			$returnValue = 1;

			$gridName = $forms_data['grid_name'];
			$gridUnit = $forms_data['grid_unit'];
			$gridSpace = $forms_data['grid_space'];

			if ($forms_data['grid_name'] == '') {
				$returnValue = null;
			}
			if ($forms_data['grid_space'] == '') {
				$returnValue = null;
			}
			if (strlen($forms_data['grid_name']) > 56) {
				$returnValue = null;
			}
			if (strlen($forms_data['grid_space']) > 56) {
				$returnValue = null;
			}
			if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['grid_name'])) {
				$returnValue = null;
			}
			if (!preg_match("/^[a-zA-Z0-9\s]+$/", $forms_data['grid_space'])) {
				$returnValue = null;
			}
			return $returnValue;
		}


	}
?>