<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class MineralWorkedEndUserTable extends Table{
		
		var $name = "MineralWorkedEndUser";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getMineralName($endUserId) {

			$conn = ConnectionManager::get(Configure::read('conn'));
			$query = $conn->execute("SELECT mineral_name  FROM MINERAL_WORKED_END_USER 
							WHERE end_user_id = '".$endUserId."'");
			$mineral = $query->fetchAll();
			
			if (count($mineral) > 0) {
			  $i = 0;
			  $result = Array();
			  foreach ($mineral as $data) {
				$result[$i] = $data['MINERAL_NAME'];
				$i++;
			  }
			  return $result;
			}
			else
			  return "--";
		}

	} 
?>