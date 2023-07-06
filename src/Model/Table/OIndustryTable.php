<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class OIndustryTable extends Table{

		var $name = "OIndustry";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}
		
        public function getIndustries() {

            $countryArr = $this->find()
                ->select(['industry_name'])
                ->toArray();

            $result = array();
            foreach ($countryArr as $tmpArr) {
                $result[] = $tmpArr['industry_name'];
            }
            
            return $result;

        }

	} 
?>