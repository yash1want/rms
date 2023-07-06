<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirStateTable extends Table{

		var $name = "DirState";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

	    //returns state name by state code
	    public function getState($state_code) {

			$query = $this->find('all', array('conditions'=>array('state_code'=>$state_code)))->toArray();

	        if (count($query) > 0){
	            return $query[0]['state_name'];
	        }
	        else{
	            return "--";
	        }
	    }

		//returns state name by state code
		public function getStateName($stateCode){

			$result = $this->find('all')
					->where(['state_code LIKE'=>$stateCode.'%'])
					->toArray();
					
			return $result;

		}

		public function getStateNameAsArray($state_code) {

			$queryDist = $this->find()
					->select(['name'=>'state_name'])
					->where(['state_code'=>$state_code])
					->toArray();
		
			if (count($queryDist) > 0) {
				return $queryDist[0]['name'];
			} else {
				return '';
			}

		}

		public function findByDql($stateCode){
			
			$result = $this->find()
					->where(['state_code LIKE'=>$stateCode.'%'])
					->toArray();

			return $result;

		}
		
		public function postDataValidationMasters($forms_data)
		{
			$returnValue = 1;

			$stateCode = $forms_data['state_code'];
			$stateName = $forms_data['state_name'];

			if ($forms_data['state_code'] == '') {
				$returnValue = null;
			}
			if ($forms_data['state_name'] == '') {
				$returnValue = null;
			}

			if (strlen($forms_data['state_code']) > 3) {
				$returnValue = null;
			}
			if (strlen($forms_data['state_name']) > 25) {
				$returnValue = null;
			}

			if (!preg_match('/^[a-zA-Z]+$/', $forms_data['state_code'])) {
				$returnValue = null;
			}

			if (!preg_match("/^[a-zA-Z0-9\s]+$/", $forms_data['state_name'])) {
				$returnValue = null;
			}
			return $returnValue;
		}
		
		
		public function getStateCodesByDistrictCode($district_code)
		{
			$dis = explode('-', $district_code);

			$records = $this->find()
				->select(['id', 'state_code', 'state_name'])->where(['state_code IS'  => $dis[1]])->order(['state_name' => 'ASC'])->toArray();
			$data = array();
			$i = 0;
			foreach ($records as $result) {
				$code = $result['state_code'];
				$data[$code] = $result['state_name'];

				$i++;
			}
			return $data;
		}

	}
	
?>