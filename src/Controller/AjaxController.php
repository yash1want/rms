<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Network\Email\Email;
use Cake\ORM\Entity;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

class AjaxController extends AppController
{

	var $name = 'ajax';
	var $uses = array();


	public function initialize(): void
	{
		parent::initialize();
		$this->loadComponent('Customfunctions');
		$this->loadComponent('Clscommon');
		$this->Session = $this->getRequest()->getSession();
		$this->DirCountry = $this->getTableLocator()->get('DirCountry');
		$this->DirRegion = $this->getTableLocator()->get('DirRegion');
		$this->DirZone = $this->getTableLocator()->get('DirZone');
		$this->DirState = $this->getTableLocator()->get('DirState');
		$this->DirDistrict = $this->getTableLocator()->get('DirDistrict');
		$this->DirMineralGrade = $this->getTableLocator()->get('DirMineralGrade');
		$this->DirMeMineral = $this->getTableLocator()->get('DirMeMineral');
		$this->McApplicantDet = $this->getTableLocator()->get('McApplicantDet');
		$this->MmsUser = $this->getTableLocator()->get('MmsUser');
		$this->McUser = $this->getTableLocator()->get('McUser');
		$this->Mine = $this->getTableLocator()->get('Mine');
		$this->TblAllocationDetailsTable = $this->getTableLocator()->get('TblAllocationDetails');
		$this->TblAllocationNODetailsTable = $this->getTableLocator()->get('TblAllocationNODetails');
		$this->TblEndUserFinalSubmit = $this->getTableLocator()->get('TblEndUserFinalSubmit');
		$this->TblFinalSubmit = $this->getTableLocator()->get('TblFinalSubmit');
		$this->OMineralIndustryInfo = $this->getTableLocator()->get('OMineralIndustryInfo');
		$this->OSourceSupply = $this->getTableLocator()->get('OSourceSupply');
	}


	public function getDupEmail()
	{

		$this->autoRender = false;

		$uemail = $_POST['uemail'];

		if (filter_var($uemail, FILTER_VALIDATE_EMAIL)) {

			$email = $this->MmsUser->find('all',array('conditions' => array('email IS' => base64_encode($uemail))))->first();

			if(!empty($email)) {
				echo 1;
			}
		
		} else {

			echo 2;
		}


		
		exit;

	}


	public function getDupMmsMobile(){

		$this->autoRender = false;

		$umobile = $_POST['umobile'];

		if(preg_match("/^[0-9]{10}$/", $umobile)) {

		  $mobile = $this->MmsUser->find('all',array('conditions'=>array('mobile IS'=>base64_encode($umobile))))->first();

		  if(!empty($mobile)){
		  	echo 1;
		  }

		}else{

			echo 2;
		}

		
		exit;

	}


	public function getDupStateUsrRegId(){




	}

	//get Months array
	public function getMonthArr()
	{

		$this->autoRender = false;
		$year = htmlentities($_POST['year'], ENT_QUOTES);

		$months = array(
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December'
		);

		$monthArr = [];
		$currMonth = date('m');
		$currYear = date('Y');

		if (!empty($year)) {
			echo "<option value=''>Select</option>";
			foreach ($months as $key => $each) {
				echo "<option value=" . $key . ">" . $each . "</option>";
				if ($currMonth == $key && $currYear == $year) {
					break;
				}
			}
		}

		//echo json_encode($monthArr);
	}

	public function getRegionsArr()
	{

		$this->autoRender = false;

		$zone = htmlentities($_POST['zone'], ENT_QUOTES);
		$regions = $this->DirRegion->find('list', array('keyField' => 'id', 'valueField' => 'region_name', 'conditions' => array('zone_name IS' => $zone)))->toArray();

		if (!empty($regions)) {
			echo "<option value=''>Select</option>";
			foreach ($regions as $key => $each) {
				echo "<option value=" . $each . ">" . $each . "</option>";
			}
		}
	}

	public function getStatesArr()
	{

		$this->autoRender = false;

		$region_name = htmlentities($_POST['region'], ENT_QUOTES);
		$states = $this->DirDistrict->getstateByregion($region_name);

		if (!empty($states)) {
			echo "<option value=''>Select</option>";
			foreach ($states as $key => $each) {
				echo "<option value=" . $key . ">" . $each . "</option>";
			}
		}
	}

	public function getDistrictsArr()
	{

		$this->autoRender = false;

		$state = htmlentities($_POST['state'], ENT_QUOTES);
		$districts = $this->DirDistrict->getDistrictCodesByStateCode($state);

		if (!empty($districts)) {
			echo "<option value=''>Select</option>";
			foreach ($districts as $key => $each) {
				echo "<option value=" . $key . ">" . $each . "</option>";
			}
		}
	}

	public function getParentuserArr()
	{

		$this->autoRender = false;
		$roleid = htmlentities($_POST['roleid'], ENT_QUOTES);

		if ($roleid == 2) {
			$parentid = '1';
		} elseif ($roleid == 3) {
			$parentid = '2';
		} elseif ($roleid == 5) {
			$parentid = '4';
		} elseif ($roleid == 6) {
			$parentid = '5';
		} elseif ($roleid == 8) {
			$parentid = '7';
		} elseif ($roleid == 9) {
			$parentid = '8';
		} elseif ($roleid == 20) {
			$parentid = '6';
		} elseif ($roleid == 21) {
			$parentid = '6';
		} elseif ($roleid == 22) {
			$parentid = '6';
		} elseif ($roleid == 25) {
			$parentid = '4';
		}


		if($roleid == 10)
		{
			$stateList = $this->DirState->find('all',array('fields' => array('id', 'state_name'),
							'conditions'=>array('delete_status IS'=>'no')))
							->order('state_name')
							->toArray();
			//print_r($stateList); exit;
			echo "<option value=''>Select</option>";

			foreach ($stateList as $eachState) {

				echo "<option value=" . $eachState['id'] . ">" . $eachState['state_name'] . "</option>";
			}

		}else{
			
			$supUsersList = $this->MmsUser->find('all', array(
				'fields' => array('id', 'first_name', 'last_name', 'user_name'),
				'conditions' => array('is_delete is' => 0, 'role_id' => $parentid)
			))
				->order('first_name')
				->toArray();

			echo "<option value=''>Select</option>";

			foreach ($supUsersList as $eachUser) {
				$name = $eachUser['first_name'] . ' ' . $eachUser['last_name'] . '(' . $eachUser['user_name'] . ')';
				echo "<option value=" . $eachUser['id'] . ">" . $name . "</option>";
			}
		}	
	}

	public function getZoneRegionArr()
	{

		$this->autoRender = false;
		$roleid = htmlentities($_POST['roleid'], ENT_QUOTES);
		$parentid = htmlentities($_POST['parentid'], ENT_QUOTES);

		if ($roleid == 5) {

			$zonelistt = $this->MmsUser->find('list',array('keyField' => 'id','valueField' => 'zone_id','conditions'=>array('zone_id IS NOT NULL','role_id'=>5,'is_delete IS'=>'0'),'group'=>array('zone_id')))->toArray();
			
			if(empty($zonelistt)){

				$resultList =	$this->DirZone->find('list', array('keyField' => 'id', 'valueField' => 'zone_name'))->order('id')->toArray();

			}else{
				
				// Modified array structure cause previously it's getting in the format of ['val' => 'key']
				// so, converted it to ['key' => 'val']
				// Added on 21-04-2022 by Aniket G.
				$zonelistarr = array();
				foreach ($zonelistt as $key=>$val){
					$zonelistarr[] = $key;
				}

				$resultList =	$this->DirZone->find('list', array('keyField' => 'id', 'valueField' => 'zone_name','conditions'=>array('id NOT IN'=>$zonelistarr)))->order('id')->toArray();
			}

			
			$field = 'zone_name';
		} elseif ($roleid == 6) {

			$regionlistt = $this->MmsUser->find('list',array('keyField' => 'id','valueField' => 'region_id','conditions'=>array('region_id IS NOT NULL','role_id'=>6,'is_delete IS'=>'0'),'group'=>array('region_id')))->toArray();

			$usrZoneName = $this->MmsUser->find('all', array(
				'fields' => array('zone.zone_name'),
				'join' => array(array('table' => 'dir_zone', 'alias' => 'zone', 'type' => 'INNER', 'conditions' => array('zone.id = MmsUser.zone_id'))),
				'conditions' => array('MmsUser.id is' => $parentid)
			))->first();

			if(empty($regionlistt)){

				$resultList = $this->DirRegion->find('list', array('keyField' => 'id', 'valueField' => 'region_name', 'conditions' => array('zone_name IS' => $usrZoneName['zone']['zone_name'])))->order('id')->toArray();

			}else{

				// Modified array structure cause previously it's getting in the format of ['val' => 'key']
				// so, converted it to ['key' => 'val']
				// Added on 21-04-2022 by Aniket G.
				$regionlistarr = array();
				foreach ($regionlistt as $key=>$val){
					$regionlistarr[] = $key;
				}
				
				$resultList = $this->DirRegion->find('list', array('keyField' => 'id', 'valueField' => 'region_name', 'conditions' => array('id NOT IN'=>$regionlistarr,'zone_name IS' => $usrZoneName['zone']['zone_name'])))->order('id')->toArray();

			}
			$field = 'region_name';
		}

		echo "<option value=''>Select</option>";
		//
		foreach ($resultList as $key => $each) {

			echo "<option value=" . $key . ">" . $each . "</option>";
		}
	}

	public function userAllocation()
	{

		$this->TblAllocationDetails = $this->getTableLocator()->get('TblAllocationDetails');
		$this->TblAllocationNODetails = $this->getTableLocator()->get('TblAllocationNODetails');

		$this->autoRender = false;
		$userRole = $this->Session->read('mms_user_role');
		$userid = $this->Session->read('mms_user_id');
		$error = 'yes';
		
		$seriestype = htmlentities($_POST['seriestype'], ENT_QUOTES);
		$supid = htmlentities($_POST['supid'], ENT_QUOTES);
		$prid = htmlentities($_POST['prid'], ENT_QUOTES);
		$allocationtype = htmlentities($_POST['allocationtype'], ENT_QUOTES);
		$applicantUserid = $_POST['appuserid'];
		

		if ($userRole == 1 && $supid != '' && $prid != '') {

			if($seriestype == 'fseries')
			{
				
				$result = $this->TblAllocationDetails->allocation($supid, $prid, $applicantUserid, $allocationtype);

			}

			if($seriestype == 'lseries')
			{

				$result = $this->TblAllocationNODetails->allocation($supid, $prid, $applicantUserid, $allocationtype);
			}
			
			$error = 'no';
		}
		

		if ($userRole == 7 && $supid != '' && $prid != '') {

			$result = $this->TblAllocationNODetails->allocation($supid, $prid, $applicantUserid,$allocationtype);
			
			$error = 'no';
		}

		echo $error;

		
	}

	//FORM L > PART II: Trading Activity
	public function getTradAcGradeDetail()
	{

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$mineral = $_POST['mineral'];
			$return_date = htmlentities($_POST['returnDate'], ENT_QUOTES);
			$data = $this->DirMineralGrade->getAllMineralGradeinfo($mineral, $return_date);

			echo '<option value="">-Select grade-</option>';
			foreach ($data['gradeData'] as $key => $each) {
				echo '<option value="' . $key . '">' . $each . '</option>';
			}
		}
	}

	public function getRawMaterialsMetalsUnit()
	{

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$mineral = htmlentities($_POST['mineral'], ENT_QUOTES);
			$data = $this->DirMeMineral->getMineralUnit($mineral);

			echo $data;
		}
	}

	public function getCountryNameLSeries()
	{

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$result = $this->DirCountry->getCountryListByInput($this->request->getData());
			echo $result;
		}
	}

	public function getRegistrationNo()
	{

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$result = $this->McApplicantDet->getRegNo($this->request->getData());
			echo $result;
		}
	}


	public function genLevel3UserPass()
	{

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$minecode  =  NUll;
			$message = NULL;
			$username = $this->Session->read('username');
			$level2usrid = htmlentities($_POST['level2usrid'], ENT_QUOTES);
			//$userid = htmlentities($_POST['userid'], ENT_QUOTES);
			$userid = $_POST['userid'];
			$useremail = htmlentities($_POST['useremail'], ENT_QUOTES);

			$level2type = htmlentities($_POST['level2type'], ENT_QUOTES);
			if ($level2type == 'Mining') {
				$level2type = 1;
				$explode = explode('/', $userid);
				$minecode = $explode[1];
				//echo $minecode;
				$this->loadModel('MineralWorked');
				$mineral_name = $this->MineralWorked->getMineralName($minecode);
				
				if(trim($mineral_name) == '--'){
					$message = "Form Type not allocated, please contact with adminstration";
				}
				
			}else{
				
				$this->loadModel('McApplicantDet');
				$regNO = $this->McApplicantDet->find('all',array('conditions'=>array('mcappd_concession_code IS NOT NULL','mcappd_app_id IS'=>$username)))->first();
				if(empty($regNO)){
					$message = "Registration code not approved, please contact with adminstration";
				}
			}
			
			if($message == NULL){
				
				$newEntity = $this->McUser->newEntity(array(

					'mcu_user_id' => $level2usrid,
					'mcu_email' => base64_encode($useremail),
					'mcu_mine_code' => $minecode,
					'mcu_activity' => $level2type,
					'mcu_ip_address' => $_SERVER['REMOTE_ADDR'],
					'mcu_level_flag' => 2,
					'mcu_parent_app_id' => $username,
					'is_deleted'=>'no',
					'mcu_child_user_name' => $userid
				));

				$result = $this->McUser->save($newEntity);
				$record_id = $result->mcu_user_id;
				$this->Clscommon->forgotPassword($record_id, $userid, $useremail, 'McUser');

				echo 1;
			
			}else{
				
				echo $message;
			}
		}
	}

	public function getRawMaterialMetalsUnit()
	{

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$mineralName = htmlentities($_POST['value'], ENT_QUOTES);
			$data = $this->DirMeMineral->getMineralUnit($mineralName);

			echo $data;
		}
	}

	/***
	 * Created by Shweta Apale 09-12-2021
	 * To get IBM by State & District Selection
	 */

	public function getIbmByStateDistrictArray()
	{
		$this->autoRender = false;

		$state = $_POST['state'];
		$district = $_POST['district'];
		
		$ibm = $this->Mine->getIbmByStateDistrict($state, $district);
		
		if (!empty($ibm)) {
			
			echo "<option value=''>Select</option>";
			foreach ($ibm as $key => $each) {
				echo "<option value='" . $key . "'>" . $each . "</option>";
			}
		} else {
			echo "<option> No IBM Registration Number Avaiable</option>";
		}
	}

	/***
	 * Created by Shweta Apale 09-12-2021
	 * To get Mine Name by IBM Selection
	 */
	public function getMineNameByIbmArray()
	{

		$this->autoRender = false;

		$ibm = $_POST['ibm'];
		$minenames = $this->Mine->getMineNameByIbm($ibm);
		if (!empty($minenames)) {
			echo "<option value=''>Select</option>";
			foreach ($minenames as $key => $each) {
				echo "<option value='" . $key . "'>" . $each . "</option>";
			}
		} else {
			echo "<option> No Mine Name Avaiable</option>";
		}
	}

	/***
	 * Created by Shweta Apale 09-12-2021
	 * To get Lessee Owner Name by IBM Selection
	 */

	public function getLesseeOwnerByIbmArray()
	{
		$this->autoRender = false;

		$ibm = $_POST['ibm'];
		$owner = $this->Mine->getLesseeOwnerByIbm($ibm);
		if (!empty($owner)) {
			echo "<option value=''>Select</option>";
			foreach ($owner as $key => $each) {
				echo "<option value='" . $key . "'>" . $each . "</option>";
			}
		} else {
			echo "<option> No Lessee Owner Avaiable</option>";
		}
	}

	/***
	 * Created by Shweta Apale 09-12-2021
	 * To get Lessee Area by Mine Code Selection
	 * Commented because Lesse area is not present in any table
	 */

	public function getLesseeAreaByIbmArray()
	{
		$this->autoRender = false;

		$ibm = $_POST['ibm'];
		$area = $this->Mine->getLesseeAreaByIbm($ibm);
		if (!empty($area)) {
			echo "<option value=''>Select</option>";
			foreach ($area as $key => $each) {
				echo "<option value='" . $key . "'>" . $each . "</option>";
			}
		} else {
			echo "<option> No Lesse Area Avaiable</option>";
		}
	}

	/***
	 * Created by Shweta Apale 09-12-2021
	 * To get Mine Code by IBM Selection
	 */

	public function getMineCodeByIbmArray()
	{
		$this->autoRender = false;

		$ibm = $_POST['ibm'];
		$minecodes = $this->Mine->getMineCodeByIbm($ibm);
		if (!empty($minecodes)) {
			foreach ($minecodes as $key => $each) {
				echo "<option value='" . $key . "'>" . $each . "</option>";
			}
		} else {
			echo "<option> No Mine Code Avaiable</option>";
		}
	}
	
	//Made by Shweta Apale 
	public function getDistrictsRegionArray()
	{

		$this->autoRender = false;
		$region_name = $_POST['region_name'];
		$zone = $_POST['zone'];
		$districts = $this->DirDistrict->getDistrictByregionArray($region_name,$zone);

		if (!empty($districts)) {
			echo "<option value=''>Select</option>";
			foreach ($districts as $key => $each) {
				echo "<option value=" . $key . ">" . $each . "</option>";
			}
		}
	}


	//Made by Shweta Apale 
	public function getStatesByDistrictArray()
	{

		$this->autoRender = false;
		$district_code = $_POST['district_code'];
		$states = $this->DirState->getStateCodesByDistrictCode($district_code);

		if (!empty($states)) {
			echo "<option value=''>Select</option>";
			foreach ($states as $key => $each) {
				echo "<option value=" . $key . ">" . $each . "</option>";
			}
		}
	}

	//Made by Shweta Apale 
	public function getDistrictsArray()
	{

		$this->autoRender = false;

		$state = $_POST['state'];
		$districts = $this->DirDistrict->getDistrictCodesByStateCode($state);

		if (!empty($districts)) {
			echo "<option value=''>Select</option>";
			foreach ($districts as $key => $each) {
				echo "<option value=" . $key . ">" . $each . "</option>";
			}
		}
	}

	//Made by Shweta Apale 
	public function getZoneRegionsArray()
	{

		$this->autoRender = false;

		$zone = $_POST['zone'];
		$regions = $this->DirRegion->getRegionByZone($zone);

		if (!empty($regions)) {
			echo "<option value=''>Select</option>";
			foreach ($regions as $key => $each) {
				echo "<option value=" . $key . ">" . $each . "</option>";
			}
		}
	}

	//Made by Shweta Apale
	public function getSingleDistrictsArray()
	{

		$this->autoRender = false;

		$state = $_POST['state'];
		$districts = $this->DirDistrict->getDistrictCodesByStateCodeMultiple($state);
		if (!empty($districts)) {
			echo "<option value=''>Select</option>";
			foreach ($districts as $key => $each) {
				echo "<option value='" . $key . "'>" . $each . "</option>";
			}
		}
	}

	//Made by Shweta Commented because this function appear twice
	/*public function getIbmByStateDistrictArray()
	{
		$this->autoRender = false;

		$state = $_POST['state'];
		$district = $_POST['district'];
		$ibm = $this->DirDistrict->getIbmStateDistrict($state, $district);
		if (!empty($ibm)) {
			echo "<option value=''>Select</option>";
			foreach ($ibm as $key => $each) {
				echo "<option value='" . $key . "'>" . $each . "</option>";
			}
		}
	}*/

	//Made by Shweta
	public function getCompanyByStateDistrictIbmArray()
	{
		$this->autoRender = false;

		$state = $_POST['state'];
		$district = $_POST['district'];
		$ibm = $_POST['ibm'];
		$company = $this->DirDistrict->getCompanyStateDistrictIbm($state, $district, $ibm);
		if (!empty($company)) {
			echo "<option value=''>Select</option>";
			foreach ($company as $key => $each) {
				echo "<option value='" . $key . "'>" . $each . "</option>";
			}
		}
	}

	//Made by Shweta
	public function getPlantByStateDistrictIbmCompanyArray()
	{
		$this->autoRender = false;

		$state = $_POST['state'];
		$district = $_POST['district'];
		$ibm = $_POST['ibm'];
		$company = $_POST['company'];
		$plant = $this->DirDistrict->getPlantStateDistrictIbmCompany($state, $district, $ibm, $company);
		if (!empty($plant)) {
			echo "<option value=''>Select</option>";
			foreach ($plant as $key => $each) {
				echo "<option value='" . $key . "'>" . $each . "</option>";
			}
		}
	}

	//Made by Shweta Apale
	public function getIbmRegRegionArray()
	{
		$this->autoRender = false;

		$region_name = $_POST['region_name'];
		$regions = $this->DirDistrict->getIBMRegNoByRegion($region_name);
		if (!empty($regions)) {
			echo "<option value = ''>Select </option>";
			foreach ($regions as $key => $each) {
				echo "<option value = '" . $key . "'>" . $each . "</option>";
			}
		}
	}

	//Made by Shweta Apale
	public function getIbmRegIndustryArray()
	{
		$this->autoRender = false;

		$region_name = $_POST['region_name'];
		$industry = $_POST['industry'];
		$industries = $this->DirDistrict->getIBMRegNoByIndustry($region_name, $industry);
		if (!empty($industries)) {
			echo "<option value = ''>Select </option>";
			foreach ($industries as $key => $each) {
				echo "<option value = '" . $key . "'>" . $each . "</option>";
			}
		}
	}

	//Made by Shweta Apale
	public function getIbmRegStateArray()
	{
		$this->autoRender = false;

		$state_name = $_POST['state_name'];
		$states = $this->DirDistrict->getIBMRegNoByState($state_name);
		if (!empty($states)) {
			echo "<option value = ''>Select </option>";
			foreach ($states as $key => $each) {
				echo "<option value = '" . $key . "'>" . $each . "</option>";
			}
		}
	}

	//Made by Shweta Apale
	public function getIbmRegIndustryStateArray()
	{
		$this->autoRender = false;

		$state_name = $_POST['state_name'];
		$industry = $_POST['industry'];
		$industries = $this->DirDistrict->getIBMRegNoByIndustryByState($state_name, $industry);
		if (!empty($industries)) {
			echo "<option value = ''>Select </option>";
			foreach ($industries as $key => $each) {
				echo "<option value = '" . $key . "'>" . $each . "</option>";
			}
		}
	}

	//Made by Shweta Apale
	public function getPlantByStateArray()
	{
		$this->autoRender = false;

		$state = $_POST['state'];
		$plants = $this->OMineralIndustryInfo->getPlantState($state);
		if (!empty($plants)) {
			echo "<option value = ''>Select </option>";
			foreach ($plants as $key => $each) {
				echo "<option value = '" . $key . "'>" . $each . "</option>";
			}
		} else {
			echo "<option value = ''>No Plant found...</option>";
		}
	}

	//Made by Shweta Apale
	public function getPlantByStateIndustryArray()
	{
		$this->autoRender = false;

		$state = $_POST['state'];
		$industry = $_POST['industryy'];
		$plants = $this->OMineralIndustryInfo->getPlantStateIndustry($state, $industry);
		if (!empty($plants)) {
			echo "<option value = ''>Select </option>";
			foreach ($plants as $key => $each) {
				echo "<option value = '" . $key . "'>" . $each . "</option>";
			}
		} else {
			echo "<option value = ''>NO Plant found...</option>";
		}
	}

	// //Made by Shweta Apale
	public function getSupplierByPlantArray()
	{
		$this->autoRender = false;

		$plant = $_POST['plant'];
		$supplier = $this->OSourceSupply->getSupplierPlant($plant);
		if (!empty($supplier)) {
			echo "<option value = ''>Select </option>";
			foreach ($supplier as $key => $each) {
				echo "<option value = '" . $key . "'>" . $each . "</option>";
			}
		}
	}

	//Made by Shweta Apale
	public function getIndustryByIbmArray()
	{
		$this->autoRender = false;

		$ibm = $_POST['ibm'];
		$industry = $this->OMineralIndustryInfo->getIndustryIbm($ibm);
		if (!empty($industry)) {
			echo "<option value = ''>Select </option>";
			foreach ($industry as $key => $each) {
				echo "<option value = '" . $key . "'>" . $each . "</option>";
			}
		} else {
			echo "<option value = ''>No Industry Found...</option>";
		}
	}

	//Made by Shweta Apale
	public function getPlantByIndustryIbmArray()
	{
		$this->autoRender = false;

		$industry = $_POST['indust'];
		$ibm = $_POST['ibm'];
		$plant = $this->OMineralIndustryInfo->getPlantIndustryIbm($industry, $ibm);
		if (!empty($plant)) {
			echo "<option value = ''>Select </option>";
			foreach ($plant as $key => $each) {
				echo "<option value = '" . $key . "'>" . $each . "</option>";
			}
		} else {
			echo "<option value = ''>No Plant Found...</option>";
		}
	}

	//Made by Shweta Apale
	public function getIbmByIndustryArray()
	{
		$this->autoRender = false;

		$industry = $_POST['indust'];
		$ibm = $this->OMineralIndustryInfo->getIbmIndustry($industry);
		if (!empty($ibm)) {
			echo "<option value = ''>Select </option>";
			foreach ($ibm as $key => $each) {
				echo "<option value = '" . $key . "'>" . $each . "</option>";
			}
		}
	}

	//Made by Shweta Apale
	public function getPlantByIndustryIbmsArray()
	{
		$this->autoRender = false;

		$industry = $_POST['industry'];
		$ibm = $_POST['ibm'];
		$plant = $this->OMineralIndustryInfo->getPlantIndustryIbms($industry,$ibm);
		if (!empty($plant)) {
			echo "<option value = ''>Select </option>";
			foreach ($plant as $key => $each) {
				echo "<option value = '" . $key . "'>" . $each . "</option>";
			}
		} else {
			echo "<option value = ''>No Plant found...</option>";
		}
	}


	//Made by Shweta Apale
	public function getToMonthByFromMonthArray()
	{
		$this->autoRender = false;
		$from_year = $_POST['from_year'];
		$from_month = $_POST['from_month'];

		$ex = explode('-', $from_month);
		$date1 = $from_year . '-' . $ex[1] . '-' . $ex[0];

		$dateFeb = explode('-', $date1);
		$from_year_next = $from_year + 1;
		$date2 = $from_year_next . '-03-01';

		if ($dateFeb[1] == '02') {
			$diff = abs(strtotime($date2) - strtotime($date1));

			$years = floor($diff / (365 * 60 * 60 * 24));

			$month_count = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24)) + 1;
		} else {
			$diff = abs(strtotime($date2) - strtotime($date1));

			$years = floor($diff / (365 * 60 * 60 * 24));

			$month_count = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		}

		if (!empty($from_month)) {
			echo "<option value = ''> Select </option>";
			$from_month = $ex[1];

			for ($x = $from_month; $x <= $from_month + $month_count; $x++) {
				$months = date('M', mktime(0, 0, 0, $x, 1));
				$months_key = date('m', mktime(0, 0, 0, $x, 1));
				echo  "<option value = '" . '01-' . $months_key . "'>" . $months . "</option>";
			}
		}
	}



	public function getPendingWorkStatus(){

		$this->autoRender = false;

		$roleid = htmlentities($_POST['roleid'], ENT_QUOTES);
		$usrid = htmlentities($_POST['usrid'], ENT_QUOTES);

		$returnValue = '';
		
		$validUser = $this->MmsUser->find('all',array('conditions'=>array('id IS'=>$usrid)))->toArray();

		if(!empty($validUser)){

			$returnValue = 'work_allocate';

			if($roleid == 2){
				$workAllocate = $this->TblAllocationDetailsTable->find('all',array('conditions'=>array('sup_id IS'=>$usrid)))->toArray();
			}

			if($roleid == 3){
				$workAllocate = $this->TblAllocationDetailsTable->find('all',array('conditions'=>array('pri_id IS'=>$usrid)))->toArray();
			}

			if($roleid == 8){
				$workAllocate = $this->TblAllocationNODetailsTable->find('all',array('conditions'=>array('sup_id IS'=>$usrid)))->toArray();
			}

			if($roleid == 9){
				$workAllocate = $this->TblAllocationNODetailsTable->find('all',array('conditions'=>array('pri_id IS'=>$usrid)))->toArray();
			}
			
			if($roleid == 10){ // to check State DGM work allocation, added on 06-10-2022 by Aniket
				$workAllocate = $this->mpasconn->newQuery()->select('state_id')->from('mp_allocation_details')->where(['state_id'=>$usrid])->execute()->fetchAll('assoc');
			}

			if($roleid == 20){
				$workAllocate = $this->McApplicantDet->find('all',array('conditions'=>array('mcappd_dealinghand IS'=>$usrid)))->toArray();
			}

			if ($roleid == 25) {
				$workAllocate = array();
			}

			
			// for mining plan work allocation, added on 06-10-2022 by Aniket
 			$this->loadModel('DdoAllocation');
			$workAllocateDDO = $this->DdoAllocation->find('all')->select('ddo_id')->where(['ddo_id'=>$usrid])->toArray();

			$workAllocateIO = $this->mpasconn->newQuery()->select('scru_id')->from('mp_allocation_details')->where(['scru_id'=>$usrid])->execute()->fetchAll('assoc');

			$workAllocateODO = $this->mpasconn->newQuery()->select('odo_id')->from('mp_allocation_details')->where(['odo_id'=>$usrid])->execute()->fetchAll('assoc');
		
			// added work allocate check condition for COM on 22-09-2022 by Aniket
			$workAllocateCOM = $this->mpasconn->newQuery()->select('com_id')->from('mp_allocation_details')->where(['com_id'=>$usrid])->execute()->fetchAll('assoc');
			
			if(empty($workAllocate) && empty($workAllocateDDO) && empty($workAllocateIO) && empty($workAllocateODO) && empty($workAllocateCOM)){

				$returnValue = 'no_work_allocate';

			}

		}

		echo $returnValue;
	}

	// Get allocated work list, added on 06-10-2022 by Aniket
	public function getPendingWorkList(){

		$this->autoRender = false;

		$roleid = htmlentities($_POST['roleid'], ENT_QUOTES);
		$usrid = htmlentities($_POST['usrid'], ENT_QUOTES);

		$workAllocateArr = array();
		$validUser = $this->MmsUser->find('all',array('conditions'=>array('id IS'=>$usrid)))->toArray();

		if(!empty($validUser)){

			if($roleid == 2){

				$workAllocate = $this->TblAllocationDetailsTable->find('all',array('conditions'=>array('sup_id IS'=>$usrid)))->toArray();
				if(!empty($workAllocate)){
					$workAllocateTxt = 'MMS Supervisor role for mine id(s) ';
					$n = 0;
					$andMoreRoleTxt = (count($workAllocate) > 5) ? ' ... and ('.(count($workAllocate)-5).') more' : '';
					foreach($workAllocate as $work){
						$sp = ($n != 0) ? ', ' : '';
						$workAllocateTxt .= $sp.$work['mine_id'];
						if($n == 5){ break; }
						$n++;
					}
					$workAllocateArr[] = $workAllocateTxt.$andMoreRoleTxt.'.';
				}

			}

			if($roleid == 3){

				$workAllocate = $this->TblAllocationDetailsTable->find('all',array('conditions'=>array('pri_id IS'=>$usrid)))->toArray();
				if(!empty($workAllocate)){
					$workAllocateTxt = 'MMS Primary role for mine id(s) ';
					$n = 0;
					$andMoreRoleTxt = (count($workAllocate) > 5) ? ' ... and ('.(count($workAllocate)-5).') more' : '';
					foreach($workAllocate as $work){
						$sp = ($n != 0) ? ', ' : '';
						$workAllocateTxt .= $sp.$work['mine_id'];
						if($n == 5){ break; }
						$n++;
					}
					$workAllocateArr[] = $workAllocateTxt.$andMoreRoleTxt.'.';
				}

			}

			if($roleid == 8){

				$workAllocate = $this->TblAllocationNODetailsTable->find('all',array('conditions'=>array('sup_id IS'=>$usrid)))->toArray();
				if(!empty($workAllocate)){
					$workAllocateTxt = 'ME Supervisor role for registration code(s) ';
					$n = 0;
					$andMoreRoleTxt = (count($workAllocate) > 5) ? ' ... and ('.(count($workAllocate)-5).') more' : '';
					foreach($workAllocate as $work){
						$sp = ($n != 0) ? ', ' : '';
						$workAllocateTxt .= $sp.$work['registration_code'];
						if($n == 5){ break; }
						$n++;
					}
					$workAllocateArr[] = $workAllocateTxt.$andMoreRoleTxt.'.';
				}

			}

			if($roleid == 9){

				$workAllocate = $this->TblAllocationNODetailsTable->find('all',array('conditions'=>array('pri_id IS'=>$usrid)))->toArray();
				if(!empty($workAllocate)){
					$workAllocateTxt = 'ME Primary role for registration code(s) ';
					$n = 0;
					$andMoreRoleTxt = (count($workAllocate) > 5) ? ' ... and ('.(count($workAllocate)-5).') more' : '';
					foreach($workAllocate as $work){
						$sp = ($n != 0) ? ', ' : '';
						$workAllocateTxt .= $sp.$work['registration_code'];
						if($n == 5){ break; }
						$n++;
					}
					$workAllocateArr[] = $workAllocateTxt.$andMoreRoleTxt.'.';
				}
			}
			
			if($roleid == 10){ // to check State DGM work allocation, added on 06-10-2022 by Aniket

				$workAllocate = $this->mpasconn->newQuery()->select('lease_id')->from('mp_allocation_details')->where(['state_id'=>$usrid])->execute()->fetchAll('assoc');
				if(!empty($workAllocate)){
					$workAllocateTxt = 'State DGM role for lease(s) ';
					$n = 0;
					$andMoreRoleTxt = (count($workAllocate) > 5) ? ' ... and ('.(count($workAllocate)-5).') more' : '';
					foreach($workAllocate as $work){
						$sp = ($n != 0) ? ', ' : '';
						$leaseData = $this->mpasconn->newQuery()->select('ml_pb_lease_code')->from('mp_mine_lease_loc_details')->where(['lease_id'=>$work['lease_id']])->execute()->fetchAll('assoc');
						$workAllocateTxt .= $sp.$leaseData[0]['ml_pb_lease_code'];
						if($n == 5){ break; }
						$n++;
					}
					$workAllocateArr[] = $workAllocateTxt.$andMoreRoleTxt.'.';
				}

			}

			if($roleid == 20){
				
				$workAllocate = $this->McApplicantDet->find('all',array('conditions'=>array('mcappd_dealinghand IS'=>$usrid)))->toArray();
				// on hold
				if(!empty($workAllocate)){
					$workAllocateTxt = 'Dealing Hand role for applicant id(s) ';
					$n = 0;
					$andMoreRoleTxt = (count($workAllocate) > 5) ? ' ... and ('.(count($workAllocate)-5).') more' : '';
					foreach($workAllocate as $work){
						$sp = ($n != 0) ? ', ' : '';
						$workAllocateTxt .= $sp.$work['mcappd_app_id'];
						if($n == 5){ break; }
						$n++;
					}
					$workAllocateArr[] = $workAllocateTxt.$andMoreRoleTxt.'.';
				}
			}

			// for mining plan work allocation, added on 06-10-2022 by Aniket
			$this->loadModel('DdoAllocation');
			$this->loadModel('DirRegion');
			$workAllocateDDO = $this->DdoAllocation->find('all')->select('ro_office_id')->where(['ddo_id'=>$usrid])->toArray();
			if(!empty($workAllocateDDO)){
				$workAllocateDDOTxt = 'DDO role for RO office(s) ';
				$n = 0;
				$andMoreRoleTxt = (count($workAllocateDDO) > 5) ? ' ... and ('.(count($workAllocate)-5).') more' : '';
				foreach($workAllocateDDO as $work){
					$sp = ($n != 0) ? ', ' : '';
					$regionData = $this->DirRegion->find('all')->select(['region_name','zone_name'])->where(['id'=>$work['ro_office_id']])->toArray();
					$workAllocateDDOTxt .= $sp.$regionData[0]['region_name']."(".$regionData[0]['zone_name'].")";
					if($n == 5){ break; }
					$n++;
				}
				$workAllocateArr[] = $workAllocateDDOTxt.$andMoreRoleTxt.'.';
			}

			$workAllocateIO = $this->mpasconn->newQuery()->select('lease_id')->from('mp_allocation_details')->where(['scru_id'=>$usrid])->execute()->fetchAll('assoc');
			if(!empty($workAllocateIO)){
				$workAllocateIOTxt = 'IO role for lease(s) ';
				$n = 0;
				$andMoreRoleTxt = (count($workAllocateIO) > 5) ? ' ... and ('.(count($workAllocateIO)-5).') more' : '';
				foreach($workAllocateIO as $work){
					$sp = ($n != 0) ? ', ' : '';
					$leaseData = $this->mpasconn->newQuery()->select('ml_pb_lease_code')->from('mp_mine_lease_loc_details')->where(['lease_id'=>$work['lease_id']])->execute()->fetchAll('assoc');
					$workAllocateIOTxt .= $sp.$leaseData[0]['ml_pb_lease_code'];
					if($n == 5){ break; }
					$n++;
				}
				$workAllocateArr[] = $workAllocateIOTxt.$andMoreRoleTxt.'.';
			}

			$workAllocateODO = $this->mpasconn->newQuery()->select('lease_id')->from('mp_allocation_details')->where(['odo_id'=>$usrid])->execute()->fetchAll('assoc');
			if(!empty($workAllocateODO)){
				$workAllocateODOTxt = 'Supr.ODO role for lease(s) ';
				$n = 0;
				$andMoreRoleTxt = (count($workAllocateODO) > 5) ? ' ... and ('.(count($workAllocateODO)-5).') more' : '';
				foreach($workAllocateODO as $work){
					$sp = ($n != 0) ? ', ' : '';
					$leaseData = $this->mpasconn->newQuery()->select('ml_pb_lease_code')->from('mp_mine_lease_loc_details')->where(['lease_id'=>$work['lease_id']])->execute()->fetchAll('assoc');
					$workAllocateODOTxt .= $sp.$leaseData[0]['ml_pb_lease_code'];
					if($n == 5){ break; }
					$n++;
				}
				$workAllocateArr[] = $workAllocateODOTxt.$andMoreRoleTxt.'.';
			}
		
			// added work allocate check condition for COM on 22-09-2022 by Aniket
			$workAllocateCOM = $this->mpasconn->newQuery()->select('lease_id')->from('mp_allocation_details')->where(['com_id'=>$usrid])->execute()->fetchAll('assoc');
			if(!empty($workAllocateCOM)){
				$workAllocateCOMTxt = 'COM role for lease(s) ';
				$n = 0;
				$andMoreRoleTxt = (count($workAllocateCOM) > 5) ? ' ... and ('.(count($workAllocateCOM)-5).') more' : '';
				foreach($workAllocateCOM as $work){
					$sp = ($n != 0) ? ', ' : '';
					$leaseData = $this->mpasconn->newQuery()->select('ml_pb_lease_code')->from('mp_mine_lease_loc_details')->where(['lease_id'=>$work['lease_id']])->execute()->fetchAll('assoc');
					$workAllocateCOMTxt .= $sp.$leaseData[0]['ml_pb_lease_code'];
					if($n == 5){ break; }
					$n++;
				}
				$workAllocateArr[] = $workAllocateCOMTxt.$andMoreRoleTxt.'.';
			}

		}

		$finalWorkList = '';
		$l = 1;
		foreach($workAllocateArr as $wrk){
			$finalWorkList .= ' ('.$l.') '.$wrk; 
			$l++;
		}

		echo $finalWorkList; exit;

	}

	public function getEnduserFileReturnMonth() {

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$cutoffDate = Configure::read('cutoff_date');
			$cutoffYear = date('Y', strtotime($cutoffDate));
			$applicantId = htmlentities($_POST['applicant_id'], ENT_QUOTES);
			$returnYear = htmlentities($_POST['return_year'], ENT_QUOTES);
			
			$monthStart = 1;
			$monthEnd = 12;
			if ($returnYear == $cutoffYear) {
				$monthStart = (int)date('m', strtotime($cutoffDate));
			}
			if ($returnYear == date('Y')) {
				$monthEnd = date('m');
			}

			$currentMonth = array();
			for ($mn = $monthStart; $mn <= $monthEnd; $mn++) {
				$month = sprintf('%02d', $mn);
				$currentMonth[$month] = $month;
			}

			$startDate = $returnYear."-01-01";
			$endDate = $returnYear."-12-01";

			$submittedData = $this->TblEndUserFinalSubmit->find()
				->select(['return_date'])
				->where(['applicant_id'=>$applicantId])
				->where(['return_type'=>'MONTHLY'])
				->where(['return_date BETWEEN :start AND :end'])
				->bind(':start', $startDate, 'date')
				->bind(':end', $endDate, 'date')
				->where(['is_latest'=>1])
				->order(['return_date'=>'ASC'])
				->toArray();

			if (count($submittedData) > 0) {

				foreach ($submittedData as $data) {

					$returnDate = $data['return_date'];
					$m = date('m', strtotime($returnDate));
					unset($currentMonth[$m]);

				}

			}

			$emptyMonthOpt = '<option value="">- Select Month -</option>';
			foreach ($currentMonth as $key=>$val) {
				$monthText = date('F', strtotime('2021-'.$key.'-01'));
				$emptyMonthOpt .= '<option value="'.$key.'">'.$monthText.'</option>';
			}

			echo $emptyMonthOpt;
			
		}

	}

	
	public function getMinerFileReturnMonth() {

		$this->autoRender = false;

		if ($this->request->is('post')) {

			$cutoffDate = Configure::read('cutoff_date');
			$cutoffYear = date('Y', strtotime($cutoffDate));
			$mineCode = htmlentities($_POST['mine_code'], ENT_QUOTES);
			$returnYear = htmlentities($_POST['return_year'], ENT_QUOTES);

			$monthStart = 1;
			$monthEnd = 12;
			if ($returnYear == $cutoffYear) {
				$monthStart = (int)date('m', strtotime($cutoffDate));
			}
			if ($returnYear == date('Y')) {
				$monthEnd = date('m');
			}

			$currentMonth = array();
			for ($mn = $monthStart; $mn <= $monthEnd; $mn++) {
				$month = sprintf('%02d', $mn);
				$currentMonth[$month] = $month;
			}

			$startDate = $returnYear."-01-01";
			$endDate = $returnYear."-12-01";

			$submittedData = $this->TblFinalSubmit->find()
				->select(['return_date'])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>'MONTHLY'])
				->where(['return_date BETWEEN :start AND :end'])
				->bind(':start', $startDate, 'date')
				->bind(':end', $endDate, 'date')
				->where(['is_latest'=>1])
				->order(['return_date'=>'ASC'])
				->toArray();

			if (count($submittedData) > 0) {
				foreach ($submittedData as $data) {

					$returnDate = $data['return_date'];
					$m = date('m', strtotime($returnDate));
					unset($currentMonth[$m]);

				}
			}

			$emptyMonthOpt = '<option value="">- Select Month -</option>';
			foreach ($currentMonth as $key=>$val) {
				$monthText = date('F', strtotime('2021-'.$key.'-01'));
				$emptyMonthOpt .= '<option value="'.$key.'">'.$monthText.'</option>';
			}

			echo $emptyMonthOpt;
			
		}

	}



	//AJAX FOR CHECKING THE Password is matched or not EXIST IN DATABASE FOR users ON 31-12-2021 BY AKASH
  	public function checkOldPassword(){

  		//load models
 		$this->loadModel('McUser');
        $this->loadModel('MmsUser');
        $this->autoRender = false;

        $username = $this->Session->read('username');
		$loginusertype = $this->Session->read('loginusertype');
		$get_password = $_POST['Oldpassword'];
        $oldPassword = hash('sha512',$get_password);

		if($loginusertype == 'primaryuser')
		{
			$userData = $this->McUser->find('all', array('conditions'=> array('mcu_user IS' => base64_decode($username))))->first();

			if(!empty($userData)){
				$dbPassword = $userData['mcu_sha_password'];
				$user_name = $userData['mcu_user'];
				$user_id = $userData['mcu_user_id'];
			}

		}elseif($loginusertype == 'authuser' || $loginusertype == 'enduser'){	

			$userData = $this->McUser->find('all', array('conditions'=> array('mcu_child_user_name IS' => $username)))->first();


			if(!empty($userData)){
				$dbPassword = $userData['mcu_sha_password'];
				$user_name = $userData['mcu_child_user_name'];
				$user_id = $userData['mcu_user_id'];
			}	

		}elseif($loginusertype == 'mmsuser'){

			$userData = $this->MmsUser->find('all', array('conditions'=> array('email IS' => $this->Session->read('mms_user_email'),'is_delete'=>0)))->first();

			if(!empty($userData)){

				$dbPassword = $userData['sha_password'];
				$user_name = $userData['user_name'];
				$user_id = $userData['id'];
			}

		}

        if (!empty($dbPassword)) {

            if ($dbPassword != $oldPassword) {
                echo 'yes';
            } else {
                echo 'no';
            }
        }

		exit;

    }
	
	// CHECK 'IS LAST UNAPPROVED SECTION' FOR MINER
	// Added on 23-03-2022 by A.G.
	public function isLastUnapprovedSec() {
		
		if ($this->request->is('post')) {

			$mineCode = htmlentities($_POST['mine_code'], ENT_QUOTES);
			$returnDate = htmlentities($_POST['return_date'], ENT_QUOTES);
			$returnType = htmlentities($_POST['return_type'], ENT_QUOTES);
			$mineral = htmlentities($_POST['mineral'], ENT_QUOTES);
			$partNo = htmlentities($_POST['part_no'], ENT_QUOTES);
			$section = htmlentities($_POST['section'], ENT_QUOTES);
			$subMin = htmlentities($_POST['sub_mineral'], ENT_QUOTES);
			$mmsCntrlNm = htmlentities($_POST['mms_cntrl_nm'], ENT_QUOTES);
			$mainSec = $_POST['main_sec'];

			$mineral = strtolower(str_replace(' ','_',$mineral));
			$returnId = $this->TblFinalSubmit->getLatestReturnId($mineCode, $returnDate, $returnType);
			
			if ($subMin == 1) {
				$subMineral = 'hematite';
			} else if ($subMin == 2) {
				$subMineral = 'magnetite';
			} else if (in_array($subMin, array('hematite', 'magnetite'))) {
				$subMineral = $subMin;
			} else {
				$subMineral = null;
			}

			$existing = $this->TblFinalSubmit->find('all')
					->select(['approved_sections'])
					->where(['id'=>$returnId])
					->toArray();

			$approved = $existing[0]['approved_sections'];
			$approvedArray = unserialize($approved);

			if ($mmsCntrlNm == 'Mms') {
				if ($mineral == "") {
					$approvedArray['partI'][$section] = "Approved";
				} else if ($mineral == 'iron_ore') {
					$approvedArray[$mineral][$subMineral][$section] = "Approved";
				} else {
					$approvedArray[$mineral][$section] = "Approved";
				}
			} else {
	            if ($mineral == "") {
	                $approvedArray[$partNo][$section] = "Approved";
				}  else {
	                $approvedArray[$partNo][$section][$mineral] = "Approved";
	            }
			}

			$is_all_approved = $this->TblFinalSubmit->checkIsAllApprovedNew($approvedArray, $mainSec, $mineral, $subMineral);
			
			if ($is_all_approved == true) {
				echo '1';
			} else {
				echo '0';
			}
			exit;
		}

	}

	// CHECK 'IS LAST UNAPPROVED SECTION' FOR ENDUSER
	// Added on 23-03-2022 by A.G.
	public function isLastUnapprovedSecEnduser() {
		
		if ($this->request->is('post')) {

			$mineCode = htmlentities($_POST['mine_code'], ENT_QUOTES);
			$returnDate = htmlentities($_POST['return_date'], ENT_QUOTES);
			$returnType = htmlentities($_POST['return_type'], ENT_QUOTES);
			$partNo = htmlentities($_POST['part_no'], ENT_QUOTES);
			$section = htmlentities($_POST['section'], ENT_QUOTES);
			$mainSec = $_POST['main_sec'];

			$returnId = $this->TblEndUserFinalSubmit->getLatestReturnId($mineCode, $returnDate, $returnType);
			
			$existing = $this->TblEndUserFinalSubmit->find('all')
					->select(['approved_sections'])
					->where(['id'=>$returnId])
					->toArray();

			$approved = $existing[0]['approved_sections'];
			$approvedArray = unserialize($approved);

			$approvedArray['partI'][1] = "Approved";
			$approvedArray[$partNo][$section] = "Approved";

			$is_all_approved = $this->TblEndUserFinalSubmit->checkIsAllApprovedNew($approvedArray, $mainSec);
			
			if ($is_all_approved == true) {
				echo '1';
			} else {
				echo '0';
			}
			exit;
		}

	}
	
	
	/** Start DDO Allocation, Pravin Bhakare 07-06-2022 **/	
	public function ddoAllocation(){	
	
		$this->autoRender = false;
		$this->loadModel('DdoAllocation');
		
		if ($this->request->is('post')) {
			
			$roid = htmlentities($_POST['roid'], ENT_QUOTES);
			$ddoid = htmlentities($_POST['ddoid'], ENT_QUOTES);
			
			if($roid != '' && $ddoid != ''){	
			
				$result = $this->DdoAllocation->allocation($roid,$ddoid);		
				
				if($result == true){
					echo "true";
				}else{
					echo "false";
				}	
			}else{
				echo "false";
			}			
		}
		
		exit;
	}

	// get pdf version list
	// added on 11-08-2022 by Aniket
	public function getPdfVersion(){	
	
		$this->autoRender = false;
		
		if ($this->request->is('post')) {
			
			$this->loadModel('EsignPdfRecords');
			$appid = $_POST['appid'];
			$rtype = htmlentities($_POST['rtype'], ENT_QUOTES);
			$rdate = htmlentities($_POST['rdate'], ENT_QUOTES);
			$rform = htmlentities($_POST['rform'], ENT_QUOTES);
			
			$data = array();
			if($appid != '' && $rtype != '' && $rdate != ''){
				$data = $this->EsignPdfRecords->getPdfVersionList($appid,$rdate,$rtype,$rform);
			}

			echo json_encode($data, true);
		}
		
		exit;
	}

}
