<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class McSflatlongDetTable extends Table{
		
		var $name = "McSflatlongDet";
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        /**
         * @author Uday Shankar singh <usingh@ubicsindia.com>
         * 
         * $slNo IS ADDED IN THE LAST MOMENT AS IT'S DEPENDS ON  ACTIVITY OF THE USES NOW
         * 
         * @param String $appId
         * @return Array
         */
        public function getLatitudeLongitude($regCodeNumericPart, $slNo) {

            $query = $this->find()
                    ->select(['mcsflld_latitude', 'mcsflld_longitude'])
                    ->where(['mcsflld_app_id'=>$regCodeNumericPart])
                    ->where(['mcsflld_slno'=>$slNo])
                    ->toArray();

            $resultSet = Array();
            $resultSet['latitude'] = $query[0]['mcsflld_latitude'];
            $resultSet['longitude'] = $query[0]['mcsflld_longitude'];
            return $resultSet;

        }

	} 
?>