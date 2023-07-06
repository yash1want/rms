<?php

namespace app\Model\Table;

use Cake\ORM\Table;
use App\Model\Model;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;
use App\Controller\MonthlyController;

class MineTable extends Table
{

	var $name = "Mine";
	public $validate = array();
	
	// set default connection string
	public static function defaultConnectionName(): string {
		return Configure::read('conn');
	}

	public function getMineCloserStatus($mine_code){

		$query = $this->find('all')
			->select(['status'])
			->where(['mine_code is' => $mine_code])
			->first();
		return $query['status'];
	}
	
	public function updateMineDetails($parentid, $mine_code) {
		//print_r($parentid); print_r($mine_code);
		$connection = ConnectionManager::get(Configure::read('conn'));
		
		$mineDetails = $connection->execute("call SP_Proc_GetApplicantMinesDetails('$parentid','$mine_code')")->fetchAll('assoc');
		
		$closerDate = ($mineDetails[0]['mcm_closer_dt'] == '') ? NULL : $mineDetails[0]['mcm_closer_dt'];
		//print_r($mineDetails); exit;
        $updateQuery = $this->query()
                ->update()
				->set(['mine_name' => $mineDetails[0]['mcm_mine_desc']])
                ->set(['village_name' => $mineDetails[0]['mcm_mine_VillageName']])
                ->set(['district_code' => $mineDetails[0]['mcm_district_code']])
				->set(['state_code' => $mineDetails[0]['mcm_state_code']])
                ->set(['status' => $mineDetails[0]['mcm_status']])
				->set(['closer_dt' => $closerDate])
				->set(['updated_at' => date('Y-m-d H:m:s')])	
                ->where(['mine_code' => $mine_code])
                ->execute();
    }


	 /**
     * Updates the mine owner details from the webservice
     * @param type $mineCode
     * @param type $mineOwnerDetails 
     */
    public function updateMineOwnerDetails($parentid, $mine_code) {
		
		$connection = ConnectionManager::get(Configure::read('conn'));
		
		$mineOwnerDetails = $connection->execute("call SP_Proc_GetApplicantDetails('$parentid')")->fetchAll('assoc');
		
        if ($mineOwnerDetails[0]['mcappd_category'] == 'F')
            $lesse_owner_name = $mineOwnerDetails[0]['mcappd_fname'];
        else {
            $lesse_owner_name = ($mineOwnerDetails[0]['mct_title_desc'] != "--") ? $mineOwnerDetails[0]['mct_title_desc'] : " ";
            $lesse_owner_name .= ". ";
            $lesse_owner_name .= ($mineOwnerDetails[0]['mcappd_fname'] != "--") ? $mineOwnerDetails[0]['mcappd_fname'] : " ";
            $lesse_owner_name .= " ";
            $lesse_owner_name .= ($mineOwnerDetails[0]['mcappd_mname'] != "--") ? $mineOwnerDetails[0]['mcappd_mname'] : " ";
            $lesse_owner_name .= " ";
            $lesse_owner_name .= ($mineOwnerDetails[0]['mcappd_lastname'] != "--") ? $mineOwnerDetails[0]['mcappd_lastname'] : " ";
        }
        $address_2 = $mineOwnerDetails[0]['mcappd_address2'];
        if ($mineOwnerDetails[0]['mcappd_address3'] != "--")
            $address_2 .= ", " . $mineOwnerDetails[0]['mcappd_address3'];

        $updateQuery = $this->query()
                ->update()
				->set(['lessee_owner_name' => $lesse_owner_name])                
                ->set(['a_line_1' => $mineOwnerDetails[0]['mcappd_address1']])
                ->set(['a_line_2' =>  $address_2])
                ->set(['a_dist' => $mineOwnerDetails[0]['mcappd_district']])
                ->set(['a_pin' => $mineOwnerDetails[0]['mcappd_pincode']])
                ->set(['a_email' => $mineOwnerDetails[0]['mcappd_email']])
                ->set(['a_mobile_no' => $mineOwnerDetails[0]['mcappd_mobileno']])
                ->set(['a_phone_no' => $mineOwnerDetails[0]['mcappd_office_phoneno']])
                ->set(['a_fax_no' => $mineOwnerDetails[0]['mcappd_faxno']])
                ->set(['registration_no' => $mineOwnerDetails[0]['mcappd_concession_code']])
				->set(['a_state' => $mineOwnerDetails[0]['mcappd_state']])
                ->set(['is_updated' => '1'])
                ->where(['mine_code' => $mine_code])               
                ->execute();
    }

	public function getMineDetails($mine_code)
	{

		$query = $this->find('all')
			->select([
				'mine_name', 'state_code', 'district_code', 'village_name', 'taluk_name',
				'post_office', 'pin', 'fax_no', 'phone_no', 'mobile_no', 'email', 'registration_no'
			])
			->where(['mine_code is' => $mine_code])
			->toArray();

		if (count($query) < 1) {
			return array();
		}

		$data['mine_name'] = $query[0]['mine_name'];
		$state_code = $query[0]['state_code'];
		$data['state_code'] = $state_code;
		$data['state'] = ($state_code != "") ? TableRegistry::getTableLocator()->get('DirState')->getState($state_code) : "--";
		$dist_code = $query[0]['district_code'];
		$data['district_code'] = $dist_code;
		$data['district'] = ($dist_code != "") ? TableRegistry::getTableLocator()->get('DirDistrict')->getDistrict($dist_code, $state_code) : "--";

		$data['village'] = ($query[0]['village_name']) ? $query[0]['village_name'] : "--";
		$data['taluk'] = ($query[0]['taluk_name']) ? $query[0]['taluk_name'] : "--";
		$data['post_office'] = ($query[0]['post_office']) ? $query[0]['post_office'] : "--";
		$data['pin'] = ($query[0]['pin']) ? $query[0]['pin'] : "--";
		$data['fax'] = ($query[0]['fax_no']) ? $query[0]['fax_no'] : "0";
		$data['phone'] = ($query[0]['phone_no']) ? $query[0]['phone_no'] : "0";
		$data['mobile'] = ($query[0]['mobile_no']) ? $query[0]['mobile_no'] : "0";
		$data['email'] = ($query[0]['email']) ? $query[0]['email'] : "--";

		if ($query[0]['registration_no'] != "0") {
			$data['reg_no'] = $query[0]['registration_no'];
		} else {
			$mc_user = TableRegistry::getTableLocator()->get('McUser')->findOneByMcuMineCode($mine_code);
			if ($mc_user) {
				$parent_id = $mc_user['mcu_parent_app_id'];
				$reg_no = TableRegistry::getTableLocator()->get('McApplicantDet')->findOneByMcuMineCode($parent_id);
				if ($reg_no)
					$data['reg_no'] = $reg_no['mcappd_concession_code'];
			}
		}

		$data['other_mineral'] = TableRegistry::getTableLocator()->get('MineralWorked')->getOtherMinerals($mine_code);
		$data['mineral'] = TableRegistry::getTableLocator()->get('MineralWorked')->getPrimaryMineralName($mine_code);

		return $data;
	}

	/**
	 * Returns the mine owner details from the MINE table. (dont take it from application_details table)
	 * @param type $mineCode
	 * @param type $returnType
	 * @param type $returnDate
	 * @return type 
	 */
	public function getMineOwnerDetails($mineCode, $returnDate = null)
	{
		$query = $this->find('all')
			->select([
				'lessee_owner_name', 'a_line_1', 'a_line_2', 'a_taluk_name', 'a_post_office', 'a_pin',
				'a_fax_no', 'a_phone_no', 'a_mobile_no', 'a_email', 'a_state', 'a_dist', 'lessee_office_name',
				'director_name', 'agent_name', 'manager_name', 'mining_engineer_name', 'geologist_name',
				'previous_lessee_name', 'date_of_entry'
			])
			->where(['mine_code' => $mineCode])
			->toArray();

		if (count($query) < 1)
			return array();

		$address = $query[0]['a_line_1'];
		if ($query[0]['a_line_2'] != "")
			$address .= $query[0]['a_line_2'];


		$data = array();
		$data['name'] = $query[0]['lessee_owner_name'];
		$data['street'] = $address;
		$data['post_office'] = $query[0]['a_post_office'];
		$data['taluk'] = $query[0]['a_taluk_name'];
		$data['district'] = ($query[0]['a_dist'] != "") ? TableRegistry::getTableLocator()->get('DirDistrict')->getDistrict($query[0]['a_dist'], $query[0]['a_state']) : "--";
		$data['state'] = ($query[0]['a_state'] != "") ? TableRegistry::getTableLocator()->get('DirState')->getState($query[0]['a_state']) : "--";
		$data['pin'] = ($query[0]['a_pin'] != 0) ? $query[0]['a_pin'] : "--";
		$data['fax'] = $query[0]['a_fax_no'];
		$data['phone'] = $query[0]['a_phone_no'];
		$data['mobile'] = $query[0]['a_mobile_no'];
		$data['email'] = $query[0]['a_email'];
		$data['post_office'] = "--";
		$data['taluk'] = "--";

		$data['lessee_office_name'] = $query[0]['lessee_office_name'];
		$data['director_name'] = $query[0]['director_name'];
		$data['agent_name'] = $query[0]['agent_name'];
		$data['manager_name'] = $query[0]['manager_name'];
		$data['mining_engineer_name'] = $query[0]['mining_engineer_name'];
		$data['geologist_name'] = $query[0]['geologist_name'];
		$data['previous_lessee_name'] = $query[0]['previous_lessee_name'];
		//$data['date_of_entry'] = $this->changeDateFormat($query[0]['date_of_entry']);
		$data['date_of_entry'] = $query[0]['date_of_entry'];

		$returnDoc = TableRegistry::getTableLocator()->get('ReturnDoc')->getReturnDoc($mineCode, $returnDate);
		$data['profile_pdf'] = $returnDoc['return_pdf'];
		$data['profile_kml'] = $returnDoc['return_kml'];

		return $data;
	}

	// update form data
	public function saveFormDetails($forms_data)
	{

		$dataValidatation = $this->postDataValidation($forms_data);

		if ($dataValidatation == 1) {

			$formId = $forms_data['form_no'];
			$mineCode = $forms_data['mine_code'];

			$fax_no = $forms_data['f_fax_no'];
			$phone_no = $forms_data['f_phone_no'];
			$mobile_no = $forms_data['f_mobile_no'];
			$email = $forms_data['f_email'];

			$newEntity = $this->newEntity(array(
				'fax_no' => $fax_no,
				'phone_no' => $phone_no,
				'mobile_no' => $mobile_no,
				'email' => $email,
				'mine_code' => $mineCode
			));
			if ($this->save($newEntity)) {
				return 1;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function postDataValidation($forms_data)
	{

		$returnValue = 1;

		if (!is_numeric($forms_data['f_fax_no'])) {
			$returnValue = null;
		}
		if (!is_numeric($forms_data['f_phone_no'])) {
			$returnValue = null;
		}
		if (!is_numeric($forms_data['f_mobile_no'])) {
			$returnValue = null;
		}

		if (empty($forms_data['mine_code'])) {
			$returnValue = null;
		}

		if ($forms_data['f_fax_no'] == '') {
			$returnValue = null;
		}
		if ($forms_data['f_phone_no'] == '') {
			$returnValue = null;
		}
		if ($forms_data['f_mobile_no'] == '') {
			$returnValue = null;
		}
		if ($forms_data['f_email'] == '') {
			$returnValue = null;
		}

		if (strlen($forms_data['f_fax_no']) > '11') {
			$returnValue = null;
		}
		if (strlen($forms_data['f_phone_no']) > '11') {
			$returnValue = null;
		}
		if (strlen($forms_data['f_mobile_no']) > '11') {
			$returnValue = null;
		}

		return $returnValue;
	}

	// update owner form details
	public function saveOwnerFormDetails($forms_data)
	{

		$dataValidatation = $this->ownerPostDataValidation($forms_data);

		if ($dataValidatation == 1) {

			$mineCode = $forms_data['mine_code'];
			$returnDate = $forms_data['return_date'];

			$fax_no = $forms_data['f_a_fax_no'];
			$phone_no = $forms_data['f_a_phone_no'];
			$mobile_no = $forms_data['f_a_mobile_no'];
			$email = $forms_data['f_a_email'];
			$return_type = $forms_data['return_type'];

			$errors = false;
			if ($return_type == 'ANNUAL') {
				
	            $MonthlyCntrl = new MonthlyController;
				$returnDoc = TableRegistry::getTableLocator()->get('ReturnDoc');

				if (!empty($forms_data['profile_pdf']->getClientFilename())) {
					$file_name = $forms_data['profile_pdf']->getClientFilename();
					$file_size = $forms_data['profile_pdf']->getSize();
					$file_type = $forms_data['profile_pdf']->getClientMediaType();
					$file_local_path = $forms_data['profile_pdf']->getStream()->getMetadata('uri');
					
					$upload_result = $MonthlyCntrl->Customfunctions->fileUploadLib($file_name,$file_size,$file_type,$file_local_path); // calling file uploading function
					if($upload_result[0] == 'success'){
						$profile_pdf = $upload_result[1];
					}elseif($upload_result[0] == 'error'){
						session_destroy();
						echo $upload_result[1];
						exit;
					}else{
						$errors = true;
					}
					
				}
				else { $profile_pdf = $forms_data['profile_pdf_old']; }
				
				if (!empty($forms_data['profile_kml']->getClientFilename())) {
					$file_name = $forms_data['profile_kml']->getClientFilename();
					$file_size = $forms_data['profile_kml']->getSize();
					$file_type = $forms_data['profile_kml']->getClientMediaType();
					$file_local_path = $forms_data['profile_kml']->getStream()->getMetadata('uri');
					
					$upload_result = $MonthlyCntrl->Customfunctions->fileUploadLib($file_name,$file_size,$file_type,$file_local_path); // calling file uploading function
					if($upload_result[0] == 'success'){
						$profile_kml = $upload_result[1];
					}elseif($upload_result[0] == 'error'){
						session_destroy();
						echo $upload_result[1];
						exit;
					}else{
						$errors = true;
					}
					
				}
				else { $profile_kml = $forms_data['profile_kml_old']; }

				$returnDocData = $returnDoc->getReturnId($mineCode, $returnDate);
				$rowId = $returnDocData['id'];
				$createdAt = $returnDocData['created_at'];

				$newEntity = $returnDoc->newEntity(array(
					'id'=>$rowId,
					'mine_code'=>$mineCode,
					'return_type'=>'ANNUAL',
					'return_date'=>$returnDate,
					'return_pdf'=>$profile_pdf,
					'return_kml'=>$profile_kml,
					'created_at'=>$createdAt,
					'updated_at'=>date('Y-m-d H:i:s')
				));
				if($returnDoc->save($newEntity)){
					//
				} else {
					$errors = false;
				}

			}

			if ($errors == false) {

				$mineUpdate = $this->get($mineCode);
				$mineUpdate->a_fax_no = $fax_no;
				$mineUpdate->a_phone_no = $phone_no;
				$mineUpdate->a_mobile_no = $mobile_no;
				$mineUpdate->a_email = $email;

				if ($return_type == 'ANNUAL') {
					$mineUpdate->lessee_office_name = $forms_data['lessee_office_name'];
					$mineUpdate->director_name = $forms_data['director_name'];
					$mineUpdate->agent_name = $forms_data['agent_name'];
					$mineUpdate->manager_name = $forms_data['manager_name'];
					$mineUpdate->mining_engineer_name = $forms_data['mining_engineer_name'];
					$mineUpdate->geologist_name = $forms_data['geologist_name'];
					$mineUpdate->previous_lessee_name = $forms_data['previous_lessee_name'];
					$mineUpdate->date_of_entry = ($forms_data['date_of_entry'] == '' && $forms_data['previous_lessee_name'] == '' ) ? null : $forms_data['date_of_entry'];
					$mineUpdate->return_pdf = $profile_pdf;
				}

				if ($this->save($mineUpdate)) {
					return 1;
				} else {
					return false;
				}
			} else {
				return false;
			}

		} else {
			return false;
		}
	}

	public function ownerPostDataValidation($forms_data)
	{

		$returnValue = 1;

		// if (!is_numeric($forms_data['f_a_fax_no'])) {
		// 	$returnValue = null;
		// }
		if (!is_numeric($forms_data['f_a_phone_no'])) {
			$returnValue = null;
		}
		if (!is_numeric($forms_data['f_a_mobile_no'])) {
			$returnValue = null;
		}

		if (empty($forms_data['mine_code'])) {
			$returnValue = null;
		}

		// if ($forms_data['f_a_fax_no'] == '') {
		// 	$returnValue = null;
		// }
		if ($forms_data['f_a_fax_no'] != '' && !is_numeric($forms_data['f_a_fax_no'])) {
			$returnValue = null;
		}
		if ($forms_data['f_a_phone_no'] == '') {
			$returnValue = null;
		}
		if ($forms_data['f_a_mobile_no'] == '') {
			$returnValue = null;
		}
		if ($forms_data['f_a_email'] == '') {
			$returnValue = null;
		}

		if (strlen($forms_data['f_a_fax_no']) > '12') {
			$returnValue = null;
		}
		if (strlen($forms_data['f_a_phone_no']) > '12') {
			$returnValue = null;
		}
		if (strlen($forms_data['f_a_mobile_no']) > '12') {
			$returnValue = null;
		}

		if ($forms_data['return_type'] == 'ANNUAL') {
			if ($forms_data['lessee_office_name'] == '') {
				$returnValue = null;
			}
			if ($forms_data['director_name'] == '') {
				$returnValue = null;
			}
			if ($forms_data['agent_name'] == '') {
				$returnValue = null;
			}
			if ($forms_data['manager_name'] == '') {
				$returnValue = null;
			}
			if ($forms_data['mining_engineer_name'] == '') {
				$returnValue = null;
			}
			if ($forms_data['geologist_name'] == '') {
				$returnValue = null;
			}

			if (strlen($forms_data['lessee_office_name']) > '250') {
				$returnValue = null;
			}
			if (strlen($forms_data['director_name']) > '40') {
				$returnValue = null;
			}
			if (strlen($forms_data['agent_name']) > '40') {
				$returnValue = null;
			}
			if (strlen($forms_data['manager_name']) > '40') {
				$returnValue = null;
			}
			if (strlen($forms_data['mining_engineer_name']) > '40') {
				$returnValue = null;
			}
			if (strlen($forms_data['geologist_name']) > '40') {
				$returnValue = null;
			}
			if (strlen($forms_data['previous_lessee_name']) > '40') {
				$returnValue = null;
			}
		}

		return $returnValue;
	}

	public function checkMine($mineCode)
	{

		$connection = ConnectionManager::get(Configure::read('conn'));

		$mineral = $connection->execute("SELECT count('mine_code') AS totalCnt FROM mine WHERE mine_code = '" . $mineCode . "'")->fetchAll('assoc');

		return $mineral[0]['totalCnt'];
	}

	//Update fax no by ajax call
	public function changeFaxNo($newFaxNo, $mineCode)
	{

		$this->updateAll(
			array('fax_no' => $newFaxNo),
			array('mine_code' => $mineCode)
		);
		return "Fax Number Changed.";
	}

	//Update Phone No by ajax call
	public function changePhoneNo($newPhoneNo, $mineCode)
	{

		$this->updateAll(
			array('phone_no' => $newPhoneNo),
			array('mine_code' => $mineCode)
		);
		return "Phone Number Changed.";
	}

	//Update mobile no by ajax call
	public function changeMobileNo($newMobileNo, $mineCode)
	{

		$this->updateAll(
			array('mobile_no' => $newMobileNo),
			array('mine_code' => $mineCode)
		);
		return "Mobile Number Changed.";
	}

	//Update email no by ajax call
	public function changeEMail($newEMail, $mineCode)
	{

		$this->updateAll(
			array('email' => $newEMail),
			array('mine_code' => $mineCode)
		);
		return "E-mail Changed.";
	}

	public function changeDateFormat($timestamp)
	{
		$date = explode(' ', $timestamp);
		$temp = explode('-', $date[0]);
		// $formatted_date = $temp[2] . "-" . $temp[1] . "-" . $temp[0];
		$formatted_date = "";

		return $formatted_date;
	}

	//Update a fax no by ajax call
	public function changeAFaxNo($newAFaxNo, $mineCode)
	{

		$this->updateAll(
			array('a_fax_no' => $newAFaxNo),
			array('mine_code' => $mineCode)
		);
		return "Fax Number Changed.";
	}

	//Update Phone No by ajax call
	public function changeAPhoneNo($newAPhoneNo, $mineCode)
	{

		$this->updateAll(
			array('a_phone_no' => $newAPhoneNo),
			array('mine_code' => $mineCode)
		);
		return "Phone Number Changed.";
	}

	//Update mobile no by ajax call
	public function changeAMobileNo($newAMobileNo, $mineCode)
	{

		$this->updateAll(
			array('a_mobile_no' => $newAMobileNo),
			array('mine_code' => $mineCode)
		);
		return "Mobile Number Changed.";
	}

	//Update email no by ajax call
	public function changeAEMail($newAEMail, $mineCode)
	{

		$this->updateAll(
			array('a_email' => $newAEMail),
			array('mine_code' => $mineCode)
		);
		return "E-mail Changed.";
	}

	public function nameAndAddressCheck($mineCode)
	{

		$nameAddressData = $this->getMineOwnerDetails($mineCode);

		if (
			$nameAddressData['phone'] == "" || $nameAddressData['mobile'] == "" ||
			$nameAddressData['email'] == "" || $nameAddressData['lessee_office_name'] == "" ||
			$nameAddressData['director_name'] == "" || $nameAddressData['agent_name'] == "" ||
			$nameAddressData['manager_name'] == "" || $nameAddressData['mining_engineer_name'] == "" ||
			$nameAddressData['geologist_name'] == ""
		) {
			return 1;
		} else {
			return 0;
		}
	}

	/**
	 * Made by Shweta Apale 09-12-2021
	 * To get IBM by State & District
	 */
	
	public function getIbmByStateDistrict($state, $district)
	{
		/*$state = implode(',',$state);
		$district = implode(',',$district);*/
		
		$conn = ConnectionManager::get(Configure::read('conn'));

		/*$q = $conn->execute("SELECT registration_no
							FROM mine
							WHERE  FIND_IN_SET(state_code,'$state') AND  FIND_IN_SET(district_code,'$district')  AND registration_no IS NOT null AND registration_no != '0' ORDER By registration_no ASC ");*/
							
		$q = $conn->execute("SELECT registration_no
							FROM mine
							WHERE state_code = '$state' AND  district_code = '$district' AND registration_no IS NOT null AND registration_no != '0' ORDER By registration_no ASC ");					

		
		$records = $q->fetchAll('assoc');

		$data = array();
		$i = 0;
		foreach ($records as $result) {
			
			$code = $result['registration_no'];
			$data[$code] = $result['registration_no'];
			$i++;
		}

		return $data;
	}

	/**
	 * Made by Shweta Apale 09-12-2021
	 * To get Mine Name by IBM
	 */

	public function getMineNameByIbm($ibm)
	{
		$conn = ConnectionManager::get(Configure::read('conn'));

		$q = $conn->execute("SELECT MINE_NAME
							FROM mine
							WHERE registration_no = '$ibm'");
							pr($q);
		$records = $q->fetchAll('assoc');

		$data = array();
		$i = 0;
		foreach ($records as $result) {
			$code = $result['MINE_NAME'];
			$data[$code] = $result['MINE_NAME'];
			$i++;
		}

		return $data;
	}
	/**
	 * Made by Shweta Apale 09-12-2021
	 * To get Lesse Owner Name by IBM
	 */

	public function getLesseeOwnerByIbm($ibm)
	{
		$conn = ConnectionManager::get(Configure::read('conn'));

		$q = $conn->execute("SELECT lessee_owner_name
							FROM mine
							WHERE registration_no = '$ibm'");
		$records = $q->fetchAll('assoc');

		$data = array();
		$i = 0;
		foreach ($records as $result) {
			$code = $result['lessee_owner_name'];
			$data[$code] = $result['lessee_owner_name'];
			$i++;
		}

		return $data;
	}

	/**
	 * Made by Shweta Apale 09-12-2021
	 * To get Lesse Area by IBM
	 */

	public function getLesseeAreaByIbm($ibm)
	{
		$conn = ConnectionManager::get(Configure::read('conn'));

		$q = $conn->execute(" SELECT (under_forest_area + outside_forest_area) AS lesse_area FROM mcp_lease ml
		INNER JOIN mine m ON m.mine_code = ml.mine_code
		WHERE m.registration_no = '$ibm'");
		$records = $q->fetchAll('assoc');

		$data = array();
		$i = 0;
		foreach ($records as $result) {
			$code = $result['lesse_area'];
			$data[$code] = $result['lesse_area'];
			$i++;
		}

		return $data;
	}

	/**
	 * Made by Shweta Apale 09-12-2021
	 * To get Mine Code by Ibm Reg 
	 */
	
	public function getMineCodeByIbm($ibm)
	{
		$conn = ConnectionManager::get(Configure::read('conn'));

		$q = $conn->execute("SELECT mine_code
							FROM mine
							WHERE registration_no = '$ibm'");
		$records = $q->fetchAll('assoc');

		$data = array();
		$i = 0;
		foreach ($records as $result) {
			$code = $result['mine_code'];
			$data[$code] = $result['mine_code'];
			$i++;
		}

		return $data;
	}
	
	public function postDataValidationMasters($forms_data)
	
	{
		
		$returnValue = 1;
		//print_r($forms_data); exit;
		if(array_key_exists('principle_mineral',$forms_data)){
			
			$principleMineral = $forms_data['principle_mineral'];			
			if ($forms_data['principle_mineral'] == '') {
				$returnValue = null;
			}
		}
		
		$stateCode = $forms_data['state_code'];
		$districtCode = $forms_data['district_code'];
		$mineName = $forms_data['MINE_NAME'];
		$lessee_owner_name = $forms_data['lessee_owner_name'];
		$mineCategory = $forms_data['mine_category'];
		$typeWorking = $forms_data['type_working'];
		$natureUse = $forms_data['nature_use'];
		$mechanisation = $forms_data['mechanisation'];
		$mineOwnership = $forms_data['mine_ownership'];
		$villageName = $forms_data['village_name'];
		$talukName = $forms_data['taluk_name'];
		$postOffice = $forms_data['post_office'];
		$pin = $forms_data['pin'];
		$faxNo = $forms_data['fax_no'];
		$phoneNo = $forms_data['phone_no'];
		$mobileNo = $forms_data['mobile_no'];
		$email = $forms_data['email'];

		
		if ($forms_data['state_code'] == '') {
			$returnValue = null;
		}
		if ($forms_data['district_code'] == '') {
			
			$returnValue = null;
		}
		if ($forms_data['MINE_NAME'] == '') {
			$returnValue = null;
		}
		if ($forms_data['village_name'] == '') {
			$returnValue = null;
		}
		if ($forms_data['taluk_name'] == '') {
			$returnValue = null;
		}
		if ($forms_data['post_office'] == '') {
			$returnValue = null;
		}
		if ($forms_data['phone_no'] == '') {
			$returnValue = null;
		}
		if ($forms_data['mobile_no'] == '') {
			$returnValue = null;
		}
		if ($forms_data['email'] == '') {
			$returnValue = null;
		}
		if (strlen($forms_data['MINE_NAME']) > 100) {
			$returnValue = null;
		}
		if (strlen($forms_data['village_name']) > 100) {
			$returnValue = null;
		}
		if (strlen($forms_data['taluk_name']) > 100) {
			$returnValue = null;
		}
		if (strlen($forms_data['post_office']) > 100) {
			$returnValue = null;
		}
		if (strlen($forms_data['phone_no']) > 20) {
			$returnValue = null;
		}
		if (strlen($forms_data['mobile_no']) > 10) {
			$returnValue = null;
		}
		
		if ($forms_data['pin'] != '' && !preg_match("/^[0-9]+$/", $forms_data['pin'])) {
			$returnValue = null;
		}
		
		if ($forms_data['fax_no'] != '' && !preg_match("/^[0-9]+$/", $forms_data['fax_no'])) {
			$returnValue = null;
		}
		if (!preg_match('/^[a-zA-Z0-9 ]+$/', $forms_data['MINE_NAME'])) {
			$returnValue = null;
		}
		if (!preg_match('/^[a-zA-Z0-9 ]+$/', $forms_data['lessee_owner_name'])) {
			$returnValue = null;
		}
		if (!preg_match("/^[a-zA-Z0-9 ]+$/", $forms_data['village_name'])) {
			$returnValue = null;
		}
		if (!preg_match("/^[a-zA-Z0-9 ]+$/", $forms_data['taluk_name'])) {
			$returnValue = null;
		}
		if (!preg_match("/^[a-zA-Z0-9 ]+$/", $forms_data['post_office'])) {
			$returnValue = null;
		}
		
		if (!preg_match("/^[0-9]+$/", $forms_data['phone_no'])) {
			$returnValue = null;
		}
		if (!preg_match("/^[0-9]+$/", $forms_data['mobile_no'])) {
			$returnValue = null;
		}
		
		if (!preg_match("/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/", $forms_data['email'])) {
			$returnValue = null;
		}
		
		//print_r($returnValue);exit;
		return $returnValue;
	}
}
