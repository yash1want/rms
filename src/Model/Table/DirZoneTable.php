<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirZoneTable extends Table{

		var $name = "DirZone";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}
		
		public function getZones() {
			
		$query = $this->query()
				->select(array('id', 'zone_name'))
				->toArray();
		
		$zones[''] = "Select";
		foreach ($query as $z) {			
		  $zones[$z['id']] = $z['zone_name'];
		}

		return $zones;
	  }
	  
	   public function postDataValidationMasters($forms_data)
		{
			$returnValue = 1;

			$zoneName = $forms_data['zone_name'];

			if ($forms_data['zone_name'] == '') {
				$returnValue = null;
			}
			if (strlen($forms_data['zone_name']) > 10) {
				$returnValue = null;
			}
			if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['zone_name'])) {
				$returnValue = null;
			}
			return $returnValue;
		}

	} 
?>