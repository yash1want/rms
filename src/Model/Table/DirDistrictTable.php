<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\Datasource\ConnectionManager;
	
	class DirDistrictTable extends Table{

		var $name = "DirDistrict";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		  /**
		   * returns the district name by dist code and state code
		   * @param type $dist_code
		   * @param type $state_code
		   * @return type 
		   */
		  public function getDistrict($dist_code, $state_code) {

			$query = $this->find('all', array('conditions'=>array('district_code IS'=>$dist_code,'state_code IS'=>$state_code)))->toArray();

		    if (count($query) > 0)
		      return $query[0]['district_name'];
		    else
		      return "--";
		  }
		  
		  public function getstateByregion($region_name) {
			  
			  $conn = ConnectionManager::get(Configure::read('conn'));
			  			 
			   $q = $conn->execute("SELECT
                        s.state_code,
                        s.state_name
                        FROM DIR_DISTRICT D
                        INNER JOIN DIR_STATE S ON D.state_code = S.state_code 
                        WHERE D.region_name = '$region_name' group by state_code order by S.state_name ");
				$records = $q->fetchAll('assoc');
				
			   $data = Array();
				$i = 0;
				foreach ($records as $result) {
					$code = $result['state_code'];
					$data[$code] = $result['state_name'];
			   
				  $i++;
				}
				
				return $data;
		  }
		  
		  
		  
		  public function getDistrictCodesByStateCode($state_code){
			  
			  $conn = ConnectionManager::get(Configure::read('conn'));
			  
			  $q = $conn->execute("SELECT
                        id, district_code, district_name
                        FROM DIR_DISTRICT D
                        WHERE state_code = '$state_code' order by district_name ");
				$records = $q->fetchAll('assoc');
				
				$data = Array();
				$i = 0;
				foreach ($records as $result) {
					$code = $result['district_code'];
					$data[$code] = $result['district_name'];
			   
				  $i++;
				}
				
				return $data;
		  }

		  
		public function getRegionNameByDistrictName($districtName, $stateCode = null, $districtCode = null) {

			if(!empty($districtCode) && !empty($stateCode)){
				$whereCond = array('district_name'=>$districtName, 'district_code'=>$districtCode, 'state_code'=>$stateCode);
			}else{
				$whereCond = array('district_name'=>$districtName);
			}

			$query = $this->find('all')
				->select(['region_name'])
				->where($whereCond)
				->toArray();

			return((isset($query['0']['region_name'])) ? $query['0']['region_name'] : '');
			
		}

		//returns district name by district id
		public function getDistrictName($dist_code, $state_code) {

			$result = $this->find()
					->select(['name'=>'district_name'])
					->where(['district_code'=>$dist_code])
					->where(['state_code'=>$state_code])
					->first();

			return $result;

		}
		
		// DON'T UNDERSTAND THE OUTPUT OF THE ABOVE ONE SO CREATED THIS.. AS THE ABOVE ONE GIVE THE OBJECT IN THE OUTPUT
		public function getDistrictNameArrayResult($dist_code, $state_code) {

			$queryDist = $this->find()
				->select(['name'=>'district_name'])
				->where(["district_code"=>$dist_code])
				->where(["state_code"=>$state_code])
				->toArray();
			
			return (isset($queryDist[0]['name'])) ? $queryDist[0]['name'] : '';

		}

		public function getRegionNameByDistrictcode($stateCode, $districtCode) {

			$query = $this->find()
					->select(['region_name'])
					->where(['state_code'=>$stateCode])
					->where(['district_code'=>$districtCode])
					->toArray();
		
			return($query['0']['region_name']);

		}

		public function getDistrctNameWithDistrictName() {

			$query = $this->find()
					->select(['district_name'])
					->distinct(['district_name'])
					->order(['district_name'=>'ASC'])
					->toArray();
		
			$dataCount = count($query);
			if ($dataCount > 0) {
				$result = Array();
				$result[''] = '-Please Select District-';
				foreach ($query as $data) {
					$code = $data['district_name'];
					$result[$code] = $data['district_name'];
				}
				return $result;
			} else {
			  	return '';
			}

		} 
		
		//Made by Shweta Apale
	public function getDistrictCodesByStateCodeMultiple($state_code)
	{
		$state_code = implode(',', $state_code);
		$conn = ConnectionManager::get(Configure::read('conn'));
		$q = $conn->execute("SELECT id, district_code, district_name FROM Dir_District WHERE FIND_IN_SET(state_code ,'$state_code') ORDER BY district_name ASC");
		$records = $q->fetchAll('assoc');

		$data = array();
		$i = 0;
		foreach ($records as $result) {
			$code = $result['district_code'];
			$data[$code] = $result['district_name'];
			$i++;
		}

		return $data;
	}

	//Made by Shweta Apale
	public function getIbmStateDistrict($state, $district)
	{
		$state = implode(',', $state);
		$district = implode(',', $district);
		$conn = ConnectionManager::get(Configure::read('conn'));
		$q = $conn->execute("SELECT m.mcappd_concession_code, m.mcappd_state, m.mcappd_district, tfs.applicant_id 
		FROM tbl_end_user_final_submit tfs 
		INNER JOIN  mc_applicant_det m ON tfs.ibm_unique_reg_no = m.mcappd_concession_code
		WHERE FIND_IN_SET(mcappd_state,'$state') AND FIND_IN_SET(mcappd_district,'$district') GROUP BY tfs.applicant_id ORDER BY tfs.applicant_id ASC");
		$records = $q->fetchAll('assoc');

		$data = array();
		$i = 0;
		foreach ($records as $result) {
			$code = $result['applicant_id'];
			$data[$code] = $result['applicant_id'];
			$i++;
		}

		return $data;
	}

	//Made by Shweta Apale
	public function getCompanyStateDistrictIbm($state, $district)
	{
		$state = implode(',', $state);
		$district = implode(',', $district);
		//$ibm = implode(',', $ibm);

		$conn = ConnectionManager::get(Configure::read('conn'));
		$q = $conn->execute("SELECT m.mcappd_fname,	m.mcappd_mname,	m.mcappd_mname
						FROM
							mc_applicant_det m
						WHERE
							FIND_IN_SET(mcappd_state, '$state')
								AND FIND_IN_SET(mcappd_district, '$district')
								ORDER BY m.mcappd_fname");
		$records = $q->fetchAll('assoc');

		$data = array();
		$i = 0;
		foreach ($records as $result) {
			$company = $result['mcappd_fname'] . ' ' . $result['mcappd_mname'] . ' ' . $result['mcappd_lastname'];
			$code = $company;
			$data[$code] = $company;
			$i++;
		}

		return $data;
	}

	//Made by Shweta Apale
	public function getPlantStateDistrictIbmCompany($state, $district)
	{
		$state = implode(',', $state);
		$district = implode(',', $district);
		//$ibm = implode(',', $ibm);
		//$company = array_filter(array_map('trim', $company), 'strlen');
		//$company = implode(',', $company);


		$conn = ConnectionManager::get(Configure::read('conn'));
		$q = $conn->execute("SELECT mdd.mcmcd_nameofplant
					FROM mc_mineralconsumption_det mdd
					INNER JOIN mc_mineralconsumptiondistrict_det mmdd ON mmdd.mcmcdd_app_id = mdd.mcmd_app_id and mmdd.mcmcdd_slno = mdd.mcmd_slno
					WHERE
						FIND_IN_SET(mdd.mcmd_state, '$state')
							AND FIND_IN_SET(mmdd.mcmcdd_district_code, '$district')
							 ORDER BY mdd.mcmcd_nameofplant");
		//print_r($q);
		$records = $q->fetchAll('assoc');

		$data = array();
		$i = 0;
		foreach ($records as $result) {
			$plant = $result['mcmcd_nameofplant'];
			$code = $plant;
			$data[$code] = $plant;
			$i++;
		}

		return $data;
	}

	//Made by Shweta Apale getIBMRegNoByRegion()
	public function getIBMRegNoByRegion($regionName)
	{
		$regionName = implode(',', $regionName);
		$conn = ConnectionManager::get(Configure::read('conn'));
		$q = $conn->execute("SELECT r.region_name, d.region_code, d.region_name, m.mcappd_concession_code, tfs.applicant_id
							FROM DIR_REGION r
							INNER JOIN DIR_DISTRICT d ON r.region_name = d.region_name
							INNER JOIN mc_applicant_det m ON d.region_code = m.mcappd_regioncode 
							INNER JOIN tbl_end_user_final_submit tfs ON m.mcappd_concession_code = tfs.ibm_unique_reg_no
							WHERE FIND_IN_SET(d.region_code,'$regionName') GROUP BY tfs.applicant_id");
		$records = $q->fetchAll('assoc');

		$data = array();
		$i = 0;
		foreach ($records as $result) {
			$code = $result['mcappd_concession_code'];
			$data[$code] = $result['mcappd_concession_code'];
			$i++;
		}
		return $data;
	}

	//Made by Shweta Apale getIBMRegNoByIndustry()
	public function getIBMRegNoByIndustry($regionName, $industry)
	{
		$regionName = implode(',', $regionName);
		$conn = ConnectionManager::get(Configure::read('conn'));

		$q = $conn->execute("SELECT d.region_code, d.region_name, o.state, tfs.applicant_id,tfs.ibm_unique_reg_no,o.industry_name
							FROM o_mineral_industry_info o
							INNER JOIN DIR_DISTRICT d ON o.state = d.state_code 
							INNER JOIN tbl_end_user_final_submit tfs ON tfs.applicant_id = o.end_user_id 
							WHERE FIND_IN_SET(d.region_code,'$regionName') AND o.industry_name = '$industry' GROUP BY tfs.applicant_id");
		$records = $q->fetchAll('assoc');
		$data = array();
		$i = 0;
		foreach ($records as $result) {
			$code = $result['ibm_unique_reg_no'];
			$data[$code] = $result['ibm_unique_reg_no'];
			$i++;
		}
		return $data;
	}

	//Made by Shweta Apale getIBMRegNoByState()
	// Function Updated by Pravin Bhakare 05-04-2022
	public function getIBMRegNoByState($stateName)
	{
		$stateName = implode(',', $stateName);
		$conn = ConnectionManager::get(Configure::read('conn'));

		$q = $conn->execute("select tfs.applicant_id,tfs.ibm_unique_reg_no from mc_user mu
							 INNER JOIN tbl_end_user_final_submit tfs ON  tfs.applicant_id = mu.mcu_child_user_name
							 where exists (select 1 from mc_mineralconsumption_det mmd where mmd.mcmd_app_id = mu.mcu_parent_app_id and mmd.mcmd_slno = substring_index(mu.mcu_child_user_name,'/',-1) and mu.mcu_activity='C' and mmd.mcmd_state = '$stateName')
							 group by tfs.applicant_id");
								
		/*$q = $conn->execute("select tfs.applicant_id from mc_user mu
							 INNER JOIN tbl_end_user_final_submit tfs ON  tfs.applicant_id = mu.mcu_child_user_name
							 where exists (select 1 from mc_mineralconsumption_det mmd where mmd.mcmd_app_id = mu.mcu_parent_app_id and mmd.mcmd_slno = substring_index(mu.mcu_child_user_name,'/',-1) and mu.mcu_activity='C' and mmd.mcmd_state = '$stateName')
							 or   exists (select 1 from mc_mineraltradingstorageexport_det mmd where mmd.mcmd_app_id = mu.mcu_parent_app_id and mmd.mcmd_slno = substring_index(mu.mcu_child_user_name,'/',-1) and mu.mcu_activity IN ('E','T','S','W') and mmd.mcmd_state = '$stateName')
							 group by tfs.applicant_id");	*/
							
		$records = $q->fetchAll('assoc');
		$data = array();
		$i = 0;
		foreach ($records as $result) {
			$code = $result['ibm_unique_reg_no'];
			$data[$code] = $result['ibm_unique_reg_no'];
			$i++;
		}
		return $data;
	}

	//Made by Shweta Apale getIBMRegNoByIndustryByState()
	// Function Updated by Pravin Bhakare 05-04-2022
	public function getIBMRegNoByIndustryByState($stateName, $industry)
	{
		$stateName = implode(',', $stateName);
		$conn = ConnectionManager::get(Configure::read('conn'));

		/*$q = $conn->execute("SELECT  tfs.applicant_id, o.state
			FROM o_mineral_industry_info o
			INNER JOIN tbl_end_user_final_submit tfs ON o.end_user_id = tfs.applicant_id
			WHERE FIND_IN_SET(o.state,'$stateName') AND o.industry_name = '$industry' GROUP BY tfs.applicant_id");*/

		$q = $conn->execute("select tfs.applicant_id,tfs.ibm_unique_reg_no
							  from mc_user mu
							  INNER JOIN tbl_end_user_final_submit tfs ON  tfs.applicant_id = mu.mcu_child_user_name
							  where exists (select 1 from mc_mineralconsumption_det mmd where mmd.mcmd_app_id = mu.mcu_parent_app_id and mmd.mcmd_slno = substring_index(mu.mcu_child_user_name,'/',-1) and mu.mcu_activity='C' and mmd.mcmd_state = '$stateName')
							  and  exists (select 1 from o_mineral_industry_info omii where omii.end_user_id = mu.mcu_child_user_name and omii.industry_name = '$industry')
							  group by mcu_child_user_name");
			
		$records = $q->fetchAll('assoc');
		$data = array();
		$i = 0;
		foreach ($records as $result) {
			$code = $result['ibm_unique_reg_no'];
			$data[$code] = $result['ibm_unique_reg_no'];
			$i++;
		}
		return $data;
	}

	public function postDataValidationMasters($forms_data)
	{
		$returnValue = 1;

		$stateCode = $forms_data['state_code'];
		$districtName = $forms_data['district_name'];
		$regionName = $forms_data['region_name'];
		$districtCode = $forms_data['district_code'];

		if ($forms_data['state_code'] == '') {
			$returnValue = null;
		}
		if ($forms_data['district_name'] == '') {
			$returnValue = null;
		}
		if ($forms_data['region_name'] == '') {
			$returnValue = null;
		}
		if ($forms_data['district_code'] == '') {
			$returnValue = null;
		}
		if (strlen($forms_data['district_name']) > 30) {
			$returnValue = null;
		}
		if (strlen($forms_data['region_name']) > 25) {
			$returnValue = null;
		}
		if (strlen($forms_data['district_code']) > 6) {
			$returnValue = null;
		}
		if (!is_numeric($forms_data['district_code'])) {
			$returnValue = null;
		}
		if (!preg_match('/^[a-zA-Z0-9\s]+$/', $forms_data['district_name'])) {
			$returnValue = null;
		}

		if (!preg_match("/^[a-zA-Z0-9\s]+$/", $forms_data['region_name'])) {
			$returnValue = null;
		}
		if (!preg_match("/^[0-9]+$/", $forms_data['district_code'])) {
			$returnValue = null;
		}
		return $returnValue;
	}

		public function getRegionNameForPrint($regCodeNumericPart, $stateCode, $registrationCode, $activityType) {

			if ($activityType == 'W') {

				$mcApplicantDet = TableRegistry::getTableLocator()->get('McApplicantDet');
				$appAdd = $mcApplicantDet->fetchAllDetailsByAppId($regCodeNumericPart);

				$state = $appAdd[0]["mcappd_state"];
				$district = $appAdd[0]["mcappd_district"];

				if (empty($state) || empty($district)) {
					return '';
				}

				$regionData = $this->find()
						->select(['region_name'])
						->where(['district_code'=>$district])
						->where(['state_code'=>$state])
						->toArray();

				return $regionData[0]['region_name'];

			} else if ($activityType == 'C') {

				$mcMineralconsumptionDet = TableRegistry::getTableLocator()->get('McMineralconsumptionDet');
				$regionData = $mcMineralconsumptionDet->getRegionAndDistrictName($regCodeNumericPart, $stateCode, $registrationCode);
				return $regionData['region_name'];

			} else {

				$mcMineraltradingstorageexportdistrictDet = TableRegistry::getTableLocator()->get('McMineraltradingstorageexportdistrictDet');
				$regionData = $mcMineraltradingstorageexportdistrictDet->getRegionAndDistrictName($regCodeNumericPart, $stateCode, $registrationCode);
				return $regionData[0][0];

			}

		}
		
		
		public function getDistrictByregionArray($region_name,$zone)
		{
			$conn = ConnectionManager::get(Configure::read('conn'));
			
			if($region_name != ""){
				$region_name = explode('-', $region_name);
				$region_name = $region_name[0];

				//$q = $conn->execute("SELECT  id, district_code, district_name, state_code FROM dir_district WHERE region_name = '$region_name' ORDER BY district_name ASC");
				$q = $conn->execute("select state_code, state_name  from dir_state
										where state_code IN (select state_code from dir_district where region_code = '$region_name' group by state_code)");
			}else{
				
				$q = $conn->execute("select state_code, state_name  from dir_state
										where state_code IN (select state_code from dir_district 
										where region_code IN (select id from dir_region where zone_name = '$zone' order by id) group by state_code ) order by state_name");
			}
			
			$records = $q->fetchAll('assoc');
			$data = array();
			$i = 0;
			foreach ($records as $result) {
				$code = $result['state_code'];
				$data[$code] = $result['state_name'];

				$i++;
			}
			return $data;
		}

	} 
?>