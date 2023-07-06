<?php

namespace app\Model\Table;

use Cake\ORM\Table;
use App\Model\Model;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use App\Controller\MonthlyController;

class DirMachineryTable extends Table
{

	var $name = "DirMachinery";
	public $validate = array();

	// set default connection string
	public static function defaultConnectionName(): string
	{
		return Configure::read('conn');
	}

	public function getAllData()
	{

		$query = $this->find('all')
			/**
			 * ADDED THE ORDER BY AS THE CHANGES FOUND IN RELEAES CODE 
			 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
			 * @version 21st Jan 2014 
			 */
			->order(['machinery_name' => 'ASC'])
			->toArray();

		$result = array();
		for ($i = 0; $i < count($query); $i++) {

			// Add language condition to get machinery name selected language wise. Done by pravin bhakare, 26-08-2020
			if ($_SESSION['lang'] == 'hindi') {
				$result[$i]['name'] = $query[$i]['machinery_name_h'];
			} else {
				$result[$i]['name'] = $query[$i]['machinery_name'];
			}
			$result[$i]['unit'] = $query[$i]['capacity_unit'];
			$result[$i]['code'] = $query[$i]['machinery_code'];
		}

		return $result;
	}

	public function machineryTypeArr()
	{

		$mTypeArr = $this->find()
			->select(['machinery_name', 'machinery_code', 'capacity_unit'])
			->order(['machinery_name' => 'ASC'])
			->toArray();

		$result = array();
		$result[""] = "Select";
		foreach ($mTypeArr as $tmpArr) {
			$result[$tmpArr['machinery_code'] . '-' . $tmpArr['capacity_unit']] = $tmpArr['machinery_name'];
		}

		return $result;
	}

	public function getMachineByCode($machineCode)
	{

		$query = $this->find()
			->where(['machinery_code' => $machineCode])
			->toArray();

		if (count($query) > 0) {
			return $query[0];
		} else {
			$monthlyCntrl = new MonthlyController;
			return $monthlyCntrl->Customfunctions->getTableColumns('dir_machinery');
		}
	}

	public function postDataValidationMasters($forms_data)
	{
		$returnValue = 1;

		$machineryCode = $forms_data['machinery_code'];
		$machineryName = $forms_data['machinery_name'];
		$capacityUnit = $forms_data['capacity_unit'];

		if ($forms_data['machinery_code'] == '') {
			$returnValue = 2;
		}
		if ($forms_data['machinery_name'] == '') {
			$returnValue = 10;
		}
		if (strlen($forms_data['machinery_code']) > 2) {
			$returnValue = 3;
		}
		if (strlen($forms_data['machinery_name']) > 50) {
			$returnValue = 4;
		}
		if (strlen($forms_data['capacity_unit']) > 10) {
			$returnValue = 5;
		}
		if (!is_numeric($forms_data['machinery_code'])) {
			$returnValue = 6;
		}
		if (!preg_match('/^[0-9]+$/', $forms_data['machinery_code'])) {
			$returnValue = 7;
		}
		if (!preg_match("/^[a-zA-Z0-9\s]+$/", $forms_data['machinery_name'])) {
			$returnValue = 8;
		}
		if ($forms_data['capacity_unit'] != '') {
			if (!preg_match("/^[a-zA-Z]+$/", $forms_data['capacity_unit'])) {
				$returnValue = 9;
			}
		}
		return $returnValue;
	}
}
