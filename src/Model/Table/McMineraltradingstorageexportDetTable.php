<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class McMineraltradingstorageexportDetTable extends Table{

		var $name = "McMineraltradingstorageexportDet";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        /**
         * @author Uday Shankar singh <usingh@ubicsindia.com>
         * 
         * $userNo IS ADDED AS THIS WILL GET THE DATA BASED ON THE USER ACTIVITY
         * 
         * @param String $appId
         * @return Array
         */
        // TSE -> TRADER STORAGE AND EXPOTER DETAILS
        public function getTSEDetailsBasedOnAppId($appId) {
            
            //ADDED THE BELOW TWO LINES AND COMMENTED TEH FIRST ONE AS THE substr WAS TAKING ONLY ON DIGIT FROM THE END WHILE TRYING TO GET THE SL NO.
            // @author Uday Shankar Singh
            // @version 26th June 2014
            //        $userNo = substr($appId, -1);


            $userNo = explode("/",$appId);
            $app_id = intval($userNo[0]);
            $userNo = intval($userNo[2]);
            $query = $this->find()
                    ->where(['mcmd_app_id'=>$app_id])
                    ->where(['mcmd_slno'=>$userNo])
                    ->toArray();
            return $query;

        }

	} 
?>