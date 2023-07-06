<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirRegionTable extends Table{

		var $name = "DirRegion";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}
		
		public function getRegionByZone($zone)
		{
			$records = $this->find()
				->select(['id', 'region_name'])->where(['zone_name' => $zone])->order(['region_name' => 'ASC'])->toArray();
			$data = array();
			print_r($data);
			$i = 0;
			foreach ($records as $result) {
				$code = $result['id'] . '-' . $result['region_name'];
				$data[$code] = $result['region_name'];

				$i++;
			}
			return $data;
		}
		
		public function postDataValidationMasters($forms_data)
		{
			$returnValue = 1;

			$regionName = $forms_data['region_name'];
			$zoneName = $forms_data['zone_name'];

			if ($forms_data['region_name'] == '') {
				$returnValue = null;
			}
			if ($forms_data['zone_name'] == '') {
				$returnValue = null;
			}

			if (strlen($forms_data['region_name']) > 25) {
				$returnValue = null;
			}
			if (strlen($forms_data['zone_name']) > 10) {
				$returnValue = null;
			}

			if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['region_name'])) {
				$returnValue = null;
			}

			if (!preg_match("/^[a-zA-Z0-9\s]+$/", $forms_data['zone_name'])) {
				$returnValue = null;
			}
			return $returnValue;
		}

	} 
?>