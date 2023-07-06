<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirCountryTable extends Table{

		var $name = "DirCountry";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		// get all country list
		// @addedon 24th MAR 2021 (by Aniket Ganvir)
		public function getCountryList(){

			$result = $this->find('all')->select(['id','country_name'])->where(['country_name IS NOT'=>'INDIA'])->order(['country_name'=>'ASC'])->toArray();
			$associateResultArr = json_decode(json_encode($result), true);
			return $associateResultArr;

		}

		public function getCountry($id){

			if(!is_int($id)){
				return '--';
			}

			$query = $this->find('all')
					->select(['country_name'])
					->where(['id'=>$id])
					->toArray();
			
			if(is_iterable($query)){
				if(count($query) > 0){
					$country = $query[0]['country_name'];
				} else {
					$country = "--";
				}
			}else{
				$country = "--";
			}
			
			return $country;

		}

		public function getCountryListByInput($forms_data){

			$input = $forms_data['input'];
			$result = $this->find()
					->select(['country_name'])
					->where(['country_name IS NOT'=>'INDIA'])
					->where(['country_name LIKE'=>'%'.$input.'%'])
					->order(['country_name'=>'ASC'])
					->toArray();

			$output = '';
		    if (count($result) > 0){
				
				$output .= '<ul class="list-unstyled">';
			
				foreach($result as $row){
					$output .= '<li>'.ucwords($row['country_name']).'</li>';
				}

				$output .= '</ul>';

		    }

		    return $output;

		}
		
		public function getcountryNameNseries() {

			$countryArr = $this->find()
				->select(['country_name'])
				->toArray();

			$result = array();
			foreach ($countryArr as $tmpArr) {
				$result[] = $tmpArr['country_name'];
			}
			$indiaArr = array('INDIA');
			
			$resultSet = array_diff($result, $indiaArr);
			return $resultSet;

		}
		
		public function getCountryNameLMSeries() {

			$countryArr = $this->find()
				->select(['country_name'])
				->where(['country_name IS NOT'=>'INDIA'])
				->order(['country_name'=>'ASC'])
				->toArray();

			$result = array();
			$result[''] = '--select--';
			foreach ($countryArr as $tmpArr) {
				$result[$tmpArr['country_name']] = $tmpArr['country_name'];
			}
			
			return $result;
		}
		
		public function postDataValidationMasters($forms_data)
	{
		$returnValue = 1;

		$countryName = $forms_data['country_name'];
		$countryCode = $forms_data['dgcis_country_code'];

		if ($forms_data['country_name'] == '') {
			$returnValue = null;
		}
		if ($forms_data['dgcis_country_code'] == '') {
			$returnValue = null;
		}

		if (strlen($forms_data['country_name']) > 40) {
			$returnValue = null;
		}
		if (strlen($forms_data['dgcis_country_code']) > 9) {
			$returnValue = null;
		}
		if (!is_numeric($forms_data['dgcis_country_code'])) {
			$returnValue = null;
		}
		if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['country_name'])) {
			$returnValue = null;
		}

		if (!preg_match("/^[0-9]+$/", $forms_data['dgcis_country_code'])) {
			$returnValue = null;
		}
		return $returnValue;
	}

	} 
?>