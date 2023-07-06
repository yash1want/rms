<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class OSupplyModeTable extends Table{

		var $name = "OSupplyMode";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getModes() {

            $countryArr = $this->find()
                ->select(['mode_name'])
                ->toArray();

            $result = array();
            foreach ($countryArr as $tmpArr) {
                $result[] = $tmpArr['mode_name'];
            }
            
            return $result;

        }
		
		public function postDataValidationMasters($forms_data)
		{
			$returnValue = 1;
	
			$transportMode = $forms_data['transport_mode'];
	
			if ($forms_data['transport_mode'] == '') {
				$returnValue = null;
			}
	
			if (strlen($forms_data['transport_mode']) > 200) {
				$returnValue = null;
			}
	
			if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['transport_mode'])) {
				$returnValue = null;
			}
	
			return $returnValue;
		}
        
	} 
?>