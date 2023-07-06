<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirSizeRangeTable extends Table{

		var $name = "DirSizeRange";
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getSizeRange() {

            $query = $this->find()
                    ->select(['id'=>'id', 'sizeRange'=>'size_range'])  // pravin bhakare 01-07-2021
                    ->toArray();
        
            $range = Array();
            if (count($query)) {
                foreach ($query as $data) {
                    $value = $data['id'];
                    $range[$value] = $data['sizeRange'];
                }
        
              return $range;
            }
            else{
              return '';
            }

        }
		
		public function postDataValidationMasters($forms_data)
		{
			$returnValue = 1;

			$sizeRange = $forms_data['size_range'];

			if ($forms_data['size_range'] == '') {
				$returnValue = null;
			}
			if (strlen($forms_data['size_range']) >256) {
				$returnValue = null;
			}
			if (!preg_match("/^[a-zA-Z0-9\s<>!,]+$/", $forms_data['size_range'])) {
				$returnValue = null;
			}
			return $returnValue;
		}

	}
?>