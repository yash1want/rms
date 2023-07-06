<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class McMineraltradingstorageexportdistrictDetTable extends Table{

		var $name = "McMineraltradingstorageexportdistrictDet";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        /**
         * @author Uday Shankar singh <usingh@ubicsindia.com>
         * 
         * $userNo IS ADDED IN THE LAST SO I AM NOT PASSING IT AS PARAMETER AND 
         * DIRECTLY GETTING IT FROM THE ID SO THAT LESS FILES ARE NEEDED TO BE CHANGED
         * 
         * @param String $appId
         * @return Array
         */
        public function getRegionAndDistrictName($regCodeNumericPart, $stateCode, $registrationCode) {

            //ADDED THE BELOW TWO LINES AND COMMENTED TEH FIRST ONE AS THE substr WAS TAKING ONLY ON DIGIT FROM THE END WHILE TRYING TO GET THE SL NO.
            // @author Uday Shankar Singh
            // @version 26th June 2014
            // $userNo = substr($registrationCode, -1);
            $userNo = explode("/",$registrationCode);
            $userNo = $userNo[2];	
			$con = ConnectionManager::get(Configure::read('conn'));
			$q = $con->execute("SELECT D.region_name, district_name 
                                FROM DIR_DISTRICT D 
                                INNER JOIN mc_mineralTradingStorageExportDistrict_det M 
                                ON D.district_code = M.mcmtdd_district_code 
                                WHERE M.mcmtdd_app_id = $regCodeNumericPart 
                                AND D.state_code = '$stateCode' AND M.mcmtdd_slno = $userNo ;");
    
            $records = $q->fetchAll();
            
            return $records;

        }

	} 
?>