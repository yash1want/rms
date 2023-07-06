<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class McMclatlongDetTable extends Table{
		
		var $name = "McMclatlongDet";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        /**
         * @author Uday Shankar singh <usigh@ubicsindia.com>
         * 
         * $SLNo IS ADDED IN THE LAST AS THIS THIS NUMBER IS BASED ON ACTIVITY TYPE 
         * OF THE USERS
         * 
         * @param String $appId
         * @return Array
         */
        public function getLatitudeLongitude($regCodeNumericPart, $slNo) {

            $query = $this->find()
                    ->select(['mcmclld_latitude', 'mcmclld_longitude'])
                    ->where(['mcmclld_app_id'=>$regCodeNumericPart])
                    ->where(['mcmclld_slno IS'=>$slNo])
                    ->toArray();

            $resultSet = Array();
            $resultSet['latitude'] = (isset($query[0]['mcmclld_latitude'])) ? $query[0]['mcmclld_latitude'] : '--';
            $resultSet['longitude'] = (isset($query[0]['mcmclld_longitude'])) ? $query[0]['mcmclld_longitude'] : '--';

            return $resultSet;
            
        }

	} 
?>