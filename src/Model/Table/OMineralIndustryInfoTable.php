<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\Datasource\ConnectionManager;
	class OMineralIndustryInfoTable extends Table{

		var $name = "OMineralIndustryInfo";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getAllRecord($formType,$returnType, $returnDate, $end_user_id, $userType) {

            $query = $this->find()
                ->where(['form_type'=>$formType])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['end_user_id'=>$end_user_id])                
                ->toArray();
            
            $resultArray=array();
            $resultArray['industryname1']=(isset($query[0]['industry_name'])) ? $query[0]['industry_name'] : '';
            $resultArray['otherind']=(isset($query[0]['other_industry_name'])) ? $query[0]['other_industry_name'] : '';
            $resultArray['plant1']=(isset($query[0]['plant_name1'])) ? $query[0]['plant_name1'] : '';
            $resultArray['plant2']=(isset($query[0]['plant_name2'])) ? $query[0]['plant_name2'] : '';
            $resultArray['state']=(isset($query[0]['state'])) ? $query[0]['state'] : '';
            $resultArray['district']=(isset($query[0]['district'])) ? $query[0]['district'] : '';
            $resultArray['location']=(isset($query[0]['location'])) ? $query[0]['location'] : '';

            return $resultArray;

        }
                
        public function getRecordIdNew($formType,$returnType, $returnDate, $end_user_id, $userType) {

            $query = $this->find()
                ->select(['id'])
                ->where(['form_type'=>$formType])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['end_user_id'=>$end_user_id])
                ->toArray();

            $rowCount = count($query);
            if ($rowCount > 0) {
                return 1;
            } else {
                return 0;
            }

        }
        
        public function deleteRecordsetNew($formType,$returnType, $returnDate, $end_user_id, $userType) {

            $query = $this->query();
            $query->delete()
                ->where(['form_type'=>$formType])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['end_user_id'=>$end_user_id])
                ->where(['user_type'=>$userType])
                ->execute();

        }

	    public function saveFormDetails($params){

			$dataValidatation = $this->postDataValidation($params);

			if ($dataValidatation == 1){

	        	$formType = $params['fType'];
	        	$returnType = $params['return_type'];
	        	$returnDate = $params['return_date'];
	        	$endUserId = $params['end_user_id'];
	        	$userType = $params['user_type'];
                $mineral = null;
				$result = '1';
                    
                $exsistanceCheck = $this->getRecordIdNew($formType, $returnType, $returnDate, $endUserId, $userType);
                if ($exsistanceCheck == 1) {
                    $this->deleteRecordsetNew($formType, $returnType, $returnDate, $endUserId, $userType);
                }

                $newEntity = $this->newEntity(array(
                    'form_type' => "O",
                    'return_type' => $returnType,
                    'return_date' => $returnDate,
                    'end_user_id' => $endUserId,
                    'mineral_name' => $mineral,
                    'industry_name' => $params['industry_name'],
                    'other_industry_name' => $params['other_industry_name'],
                    'plant_name1' => $params['plant1'],
                    // 'plant_name2' => $params['plant2'],
                    'state' => $params['state'],
                    // 'district' => $params['district_code'],
                    'district' => '',
                    'location' => $params['location'],
                    'user_type' => $userType,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ));
                if($this->save($newEntity)){
                    //
                } else {
                    $result = false;
                }

			} else {
				$result = false;
			}

			return $result;

	    }

	    public function postDataValidation($params){
			
			$returnValue = 1;

			if(empty($params['fType'])){ $returnValue = null; }
			if(empty($params['return_type'])){ $returnValue = null; }
			if(empty($params['return_date'])){ $returnValue = null; }
			if(empty($params['end_user_id'])){ $returnValue = null; }
			if(empty($params['user_type'])){ $returnValue = null; }

            $ind_nm = $params['industry_name'];
            if ($ind_nm != '') {

                if ($ind_nm == 'other') {
                    $oth_ind_nm = $params['other_industry_name'];
                    if ($oth_ind_nm == '') { $returnValue = null; }
                    if (strlen($oth_ind_nm) > 50) { $returnValue = null; }
                }
                
            } else {
                $returnValue = null;
            }
			
			return $returnValue;
			
		}

		/**
		* Used to check for the final submit
		* Returns 0 if the form is not filled
		* Returns 1 if the form is filled
        * @version 02nd Dec 2021
        * @author Aniket Ganvir
		*/    
        public function isFilled($formType,$returnType, $returnDate, $end_user_id, $userType) {

            $records = $this->find()
                ->select(['id'])
                ->where(['form_type'=>$formType])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['end_user_id'=>$end_user_id])
                ->where(['user_type'=>$userType])
                ->count();

            if ($records > 0) {
                return 1;
            } else {
                return 0;
            }


        }
		
		//Made by Shweta Apale
    public function getPlantState($state)
    {
        $state = implode(',', $state);
        $conn = ConnectionManager::get(Configure::read('conn'));
        $q = $conn->execute("SELECT plant_name1,plant_name2 FROM o_mineral_industry_info WHERE FIND_IN_SET(state ,'$state') ORDER BY plant_name1 ASC");
        $records = $q->fetchAll('assoc');

        $data = array();
        $i = 0;
        foreach ($records as $result) {
            $code = $result['plant_name1'] . ' ' . $result['plant_name2'];
            $data[$code] = $result['plant_name1'] . ' ' . $result['plant_name2'];
            $i++;
        }
        return $data;
    }

    //Made by Shweta Apale
    public function getPlantStateIndustry($state, $industry)
    {
        $state = implode(',', $state);
        $industry = implode(',', $industry);
        $conn = ConnectionManager::get(Configure::read('conn'));
        $q = $conn->execute("SELECT plant_name1,plant_name2 FROM o_mineral_industry_info WHERE FIND_IN_SET(state ,'$state') AND FIND_IN_SET(industry_name,'$industry') OR FIND_IN_SET(other_industry_name, '$industry') ORDER BY plant_name1 ASC");
        $records = $q->fetchAll('assoc');

        $data = array();
        $i = 0;
        foreach ($records as $result) {
            $code = $result['plant_name1'] . ' ' . $result['plant_name2'];
            $data[$code] = $result['plant_name1'] . ' ' . $result['plant_name2'];
            $i++;
        }
        return $data;
    }

    //Made by Shweta Apale
    public function getIndustryIbm($ibm)
    {
        $ibm = implode(',', $ibm);
        $conn = ConnectionManager::get(Configure::read('conn'));
        $q = $conn->execute("SELECT industry_name,other_industry_name FROM o_mineral_industry_info WHERE FIND_IN_SET(end_user_id ,'$ibm') ORDER BY industry_name ASC");
        $records = $q->fetchAll('assoc');

        $data = array();
        $i = 0;
        foreach ($records as $result) {
            if ($result['industry_name'] == 'other') {
                $result['industry_name'] = $result['other_industry_name'];
            }
            $code = $result['industry_name'];
            $data[$code] = $result['industry_name'];
            $i++;
        }
        return $data;
    }

    //Made by Shweta Apale
    public function getPlantIndustryIbm($indust, $ibm)
    {
        $industry = implode(',', $indust);
        $ibm = implode(',', $ibm);

        $conn = ConnectionManager::get(Configure::read('conn'));
        $q = $conn->execute("SELECT plant_name1,plant_name2 FROM o_mineral_industry_info WHERE FIND_IN_SET(end_user_id ,'$ibm') AND (FIND_IN_SET(industry_name,'$industry') OR FIND_IN_SET(other_industry_name,'$industry')) ORDER BY plant_name1 ASC");
        $records = $q->fetchAll('assoc');

        $data = array();
        $i = 0;
        foreach ($records as $result) {
            $plant1 = $result['plant_name1'];
            $plant2 = $result['plant_name2'];
            $plant = $plant1 . '' . $plant2;
            $code = $plant;
            $data[$code] = $plant;
            $i++;
        }
        return $data;
    }

    //Made by Shweta Apale
    public function getIbmIndustry($industry)
    {
        $conn = ConnectionManager::get(Configure::read('conn'));
        $q = $conn->execute("SELECT end_user_id FROM o_mineral_industry_info WHERE industry_name = '$industry' OR other_industry_name = '$industry' ORDER BY end_user_id ASC");
        $records = $q->fetchAll('assoc');

        $data = array();
        $i = 0;
        foreach ($records as $result) {
            $code = $result['end_user_id'];
            $data[$code] = $result['end_user_id'];
            $i++;
        }
        return $data;
    }

    //Made by Shweta Apale
    public function getPlantIndustryIbms($industry, $ibm)
    {
        $ibm = implode(',', $ibm);

        $conn = ConnectionManager::get(Configure::read('conn'));
        $q = $conn->execute("SELECT plant_name1,plant_name2 FROM o_mineral_industry_info WHERE FIND_IN_SET(end_user_id ,'$ibm') AND (FIND_IN_SET(industry_name,'$industry') OR FIND_IN_SET(other_industry_name,'$industry')) ORDER BY plant_name1 ASC");
        $records = $q->fetchAll('assoc');

        $data = array();
        $i = 0;
        foreach ($records as $result) {
            $plant1 = $result['plant_name1'];
            $plant2 = $result['plant_name2'];
            $plant = $plant1 . '' . $plant2;
            $code = $plant;
            $data[$code] = $plant;
            $i++;
        }
        return $data;
    }

	} 
?>