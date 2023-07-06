<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class McMineralconsumptionDetTable extends Table{
		
		var $name = "McMineralconsumptionDet";
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        /**
         * @author Uday Shankar singh <usingh@ubicsindia.com>
         * 
         * $userNo IS ADDED IN THE LAST SO I AM NOT PASSING IT AS PARAMETER AND 
         * DIRECTLY GETTING IT FROM THE ID SO THAT LESS FILES ARE NEEDED TO BE CHANED
         * 
         * @param String $appId
         * @return Array
         */
        public function getConsumptionDetailsBasedOnAppId($appId) {
            
            //ADDED THE BELOW TWO LINES AND COMMENTED TEH FIRST ONE AS THE substr WAS TAKING ONLY ON DIGIT FROM THE END WHILE TRYING TO GET THE SL NO.
            // @author Uday Shankar Singh
            // @version 26th June 2014
            //        $userNo = substr($appId, -1);
            $userNo = explode("/",$appId);
            $app_id = $userNo[0];
            $user_no = $userNo[2];
            $query = $this->find()
                    ->where(['mcmd_app_id'=>$app_id])
                    // ->where(['mcmcd_app_id'=>$app_id])
                    ->where(['mcmd_slno'=>$user_no])
                    ->toArray();
    
            return $query;

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
                                    INNER JOIN MC_MINERALCONSUMPTIONDISTRICT_DET M 
                                    ON D.district_code = M.mcmcdd_district_code 
                                    WHERE M.mcmcdd_app_id = $regCodeNumericPart 
                                    AND D.state_code = '$stateCode' AND M.mcmcdd_slno = $userNo;");

            $records = $q->fetchAll();

            // COMMENTED THE BELOW LINES
            $resultSet = Array();
            // $resultSet['district_name'] = $records[0]['district_name'];
            // $resultSet['region_name'] = $records[0]['region_name'];
            $resultSet['district_name'] = (isset($records[0][1])) ? $records[0][1] : '-'; 
            $resultSet['region_name'] = (isset($records[0][0])) ? $records[0][0] : '-';

            return $resultSet;

        }


	} 
?>