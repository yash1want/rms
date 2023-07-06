<?php

namespace app\Model\Table;

use Cake\ORM\Table;
use App\Model\Model;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use App\Controller\MonthlyController;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;

class Rom5Table extends Table
{

	public function initialize(array $config): void
	{
		$this->setTable('rom_5');
	}
	
	// set default connection string
	public static function defaultConnectionName(): string {
		return Configure::read('conn');
	}


	/**
	 * Used to check for the final submit
	 * Returns 1 if the form is not filled
	 * Returns 0 if the form is filled
	 * @param type $mineCode
	 * @param type $returnDate
	 * @param type $returnType
	 * @return int 
	 */
	public function isFilledRom($mineCode, $returnDate, $returnType, $mineral)
	{
		$query = $this->find('all')
			->select(['tot_qty', 'metal_content', 'grade'])
			->where(['mine_code' => $mineCode, 'return_type' => $returnType, 'return_date' => $returnDate, 'return_date' => $returnDate, 'mineral_name' => $mineral, 'rom_5_step_sn <=' => '9'])
			->toArray();

		if (count($query) == 0)
			return 1;

		foreach ($query as $r) {
			if ($r['tot_qty'] == "" || $r['metal_content'] == "" || $r['grade'] == "") {
				return 1;
			}
		}

		return 0;
	}

	/**
	 * Returns the ROM details
	 * @param string $mineCode
	 * @param string $returnDate
	 * @param string $returnType
	 * @param string $mineral
	 * @return array 
	 */
	public function getRomData($mineCode, $returnDate, $returnType, $mineral, $pdfStatus = 0)
	{

		$query = $this->find('all')
			->where(['mine_code' => $mineCode, 'return_date' => $returnDate, 'return_type' => $returnType, 'mineral_name' => $mineral, 'rom_5_step_sn <=' => '9'])
			->order(['id' => 'ASC'])
			->toArray();

		$tables = array(
			'open_dev', 'open_stop', 'open_cast',
			'prod_dev', 'prod_stop', 'prod_cast',
			'close_dev', 'close_stop', 'close_cast'
		);

		// $data = array();
		// $i = 0;
		// foreach ($query as $r) {
		//   $step_sn = $r['rom_5_step_sn'] - 1;
		//   $data[$i]['table'] = $tables[$step_sn];
		//   $data[$i]['tot_qty'] = $r['tot_qty'];
		//   $data[$i]['metal'] = $r['metal_content'];
		//   $data[$i]['grade'] = $r['grade'];
		//   // $data[$i]['reason'] = $r['inc_reason'];

		//   $i++;
		// }

		$data = array();
		$i = 0;
		foreach ($query as $r) {
			$step_sn = $r['rom_5_step_sn'];
			$step = $step_sn - 1;
			$data[$step_sn]['table'][] = $tables[$step];
			$data[$step_sn]['tot_qty'][] = $r['tot_qty'];
			$data[$step_sn]['metal'][] = $r['metal_content'];
			$data[$step_sn]['grade'][] = $r['grade'];
			// $data[$i]['reason'] = $r['inc_reason'];

			$i++;
		}

		if (count($query) == 0) {

			if ($returnType == 'ANNUAL' && $pdfStatus == 0) {

				$conn = ConnectionManager::get(Configure::read('conn'));
				/**
				 * Prefetch the monthly records data for annual returns
				 * Effective from Phase - II
				 * @version 16th Nov 2021
				 * @author Aniket Ganvir
				 */
				$startDate = (date('Y', strtotime($returnDate))) . '-04-01';
				$endDate = (date('Y', strtotime($returnDate)) + 1) . '-03-01';
				$str = "SELECT
						rom_5_step_sn,
						tot_qty,
						metal_content,
						SUM(grade) as grade
						FROM `rom_5`
						WHERE mine_code = '$mineCode'
						AND return_type = 'MONTHLY'
						AND return_date BETWEEN '$startDate' AND '$endDate'
						AND rom_5_step_sn <= 9
						GROUP BY rom_5_step_sn, metal_content";

				$query = $conn->execute($str)->fetchAll('assoc');
				if ($query == null) {

					for ($i = 1; $i <= 9; $i++) {
						$step = $i - 1;
						$data[$i]['table'][] = $tables[$step];
						$data[$i]['tot_qty'][] = '';
						$data[$i]['metal'][] = '';
						$data[$i]['grade'][] = '';
					}
				} else {

					$data = array();
					$i = 0;
					foreach ($query as $r) {
						$step_sn = $r['rom_5_step_sn'];
						$step = $step_sn - 1;
						$data[$step_sn]['table'][] = $tables[$step];
						$data[$step_sn]['tot_qty'][] = $r['tot_qty'];
						$data[$step_sn]['metal'][] = $r['metal_content'];
						$data[$step_sn]['grade'][] = $r['grade'];
						$data[$step_sn]['tot_qty'][0] = (isset($data[$step_sn]['tot_qty'][0])) ? ($data[$step_sn]['tot_qty'][0] + $r['tot_qty']) : $r['tot_qty'];

						$i++;
					}
				}
			} else {

				for ($i = 1; $i <= 9; $i++) {

					$step = $i - 1;
					$data[$i]['table'][] = $tables[$step];
					$data[$i]['tot_qty'][] = '';
					$data[$i]['metal'][] = '';
					$data[$i]['grade'][] = '';
				}
			}
		}

		return $data;
	}


	/**
	 * Prefetch the monthly records data for annual return
	 * Effective from Phase-II
	 * @version 20th Nov 2021
	 * @author Aniket Ganvir
	 */
	public function getRomDataMonthAll($mineCode, $returnDate, $returnType, $mineral)
	{

		$tables = array(
			'open_dev', 'open_stop', 'open_cast',
			'prod_dev', 'prod_stop', 'prod_cast',
			'close_dev', 'close_stop', 'close_cast'
		);

		$conn = ConnectionManager::get(Configure::read('conn'));
		$startDate = (date('Y', strtotime($returnDate))) . '-04-01';
		$endDate = (date('Y', strtotime($returnDate)) + 1) . '-03-01';
		$str = "SELECT
				rom_5_step_sn,
				tot_qty,
				metal_content,
				SUM(grade) as grade
				FROM `rom_5`
				WHERE mine_code = '$mineCode'
				AND return_type = 'MONTHLY'
				AND return_date BETWEEN '$startDate' AND '$endDate'
				AND rom_5_step_sn <= 9
				GROUP BY rom_5_step_sn, metal_content";

		$query = $conn->execute($str)->fetchAll('assoc');
		if ($query == null) {

			for ($i = 1; $i <= 9; $i++) {
				$step = $i - 1;
				$data[$i]['table'][] = $tables[$step];
				$data[$i]['tot_qty'][] = '';
				$data[$i]['metal'][] = '';
				$data[$i]['grade'][] = '';
			}
		} else {

			$data = array();
			$i = 0;
			foreach ($query as $r) {
				$step_sn = $r['rom_5_step_sn'];
				$step = $step_sn - 1;
				$data[$step_sn]['table'][] = $tables[$step];
				$data[$step_sn]['tot_qty'][] = $r['tot_qty'];
				$data[$step_sn]['metal'][] = $r['metal_content'];
				$data[$step_sn]['grade'][] = $r['grade'];
				$data[$step_sn]['tot_qty'][0] = (isset($data[$step_sn]['tot_qty'][0])) ? ($data[$step_sn]['tot_qty'][0] + $r['tot_qty']) : $r['tot_qty'];

				$i++;
			}
		}

		return $data;
	}

	public function getDisplayTableData($mineCode, $returnDate, $returnType, $mineral)
	{

		$data = array();
		//OPEN STOCK DISPALY TABLE
		$und_open = $this->find('all')
			->select(['metal_content', 'grade', 'rom_5_step_sn', 'tot_qty'])
			->where(['mine_code' => $mineCode, 'return_date' => $returnDate, 'return_type' => $returnType, 'mineral_name' => $mineral, 'rom_5_step_sn <' => '2'])
			->order(['rom_5_step_sn' => 'ASC', 'id' => 'ASC'])
			->toArray();

		$und_open_stock = $this->displayTableUndGradeTotal($und_open, 1);
		$open_und_grade_total = $this->undGradeTotal($mineCode, $returnDate, $returnType, $mineral, 1);
		$cast_open_stock = $this->fetchOpenCastRecords($mineCode, $returnDate, $returnType, $mineral, 3);
		$open_total = $this->displayTableGradeTotal($open_und_grade_total, $und_open_stock, $cast_open_stock);

		//    print_r($und_open_stock);
		//    print_r("----");
		//    print_r($open_und_grade_total);
		//    print_r("----");
		//    print_r($cast_open_stock);
		//    print_r("----");
		//    print_r($open_total);
		//    die;
		//PROD STOCK DISPALY TABLE
		$und_prod = $this->find()
			->select(['metal_content', 'grade', 'rom_5_step_sn', 'tot_qty'])
			->where(['mine_code' => $mineCode, 'return_date' => $returnDate, 'return_type' => $returnType, 'mineral_name' => $mineral, 'rom_5_step_sn >' => '4', 'rom_5_step_sn <' => '5'])
			->order(['rom_5_step_sn' => 'ASC', 'id' => 'ASC'])
			->toArray();
		//
		$und_prod_stock = $this->displayTableUndGradeTotal($und_prod, 2);
		$prod_und_grade_total = $this->undGradeTotal($mineCode, $returnDate, $returnType, $mineral, 2);
		$cast_prod_stock = $this->fetchOpenCastRecords($mineCode, $returnDate, $returnType, $mineral, 6);
		$prod_total = $this->displayTableGradeTotal($prod_und_grade_total, $und_prod_stock, $cast_prod_stock);

		//CLOSE STOCK DISPALY TABLE
		$und_close = $this->find()
			->select(['metal_content', 'grade', 'rom_5_step_sn', 'tot_qty'])
			->where(['mine_code' => $mineCode, 'return_date' => $returnDate, 'return_type' => $returnType, 'mineral_name' => $mineral, 'rom_5_step_sn >' => '7', 'rom_5_step_sn <' => '8'])
			->order(['rom_5_step_sn' => 'ASC', 'id' => 'ASC'])
			->toArray();

		$und_close_stock = $this->displayTableUndGradeTotal($und_close, 3);
		$close_und_grade_total = $this->undGradeTotal($mineCode, $returnDate, $returnType, $mineral, 3);
		$cast_close_stock = $this->fetchOpenCastRecords($mineCode, $returnDate, $returnType, $mineral, 9);
		$close_total = $this->displayTableGradeTotal($close_und_grade_total, $und_close_stock, $cast_close_stock);

		$data['und_stock'] = array(
			"open" => $und_open_stock,
			"prod" => $und_prod_stock,
			"close" => $und_close_stock
		);

		$data['total_stock'] = array(
			"open" => $open_total,
			"prod" => $prod_total,
			"close" => $close_total
		);

		return $data;
	}

	public function displayTableUndGradeTotal($rom, $stock_type)
	{

		if ($stock_type == 1) {
			$dev_sn = 1;
			$stop_sn = 2;
		} else if ($stock_type == 2) {
			$dev_sn = 4;
			$stop_sn = 5;
		} else if ($stock_type == 3) {
			$dev_sn = 7;
			$stop_sn = 8;
		}

		$total_per = array();
		$dirMetal = TableRegistry::getTableLocator()->get('DirMetal');
		$metals = $dirMetal->getMetalList();
		foreach ($metals as $m) {
			$dev_grade = 0;
			$dev_grade_qty = 0;
			$stop_grade = 0;
			$stop_grade_qty = 0;

			foreach ($rom as $o) {
				$step_sn = $o['rom_5_step_sn'];

				if ($o['metal_content'] == $m) {
					if ($step_sn == $dev_sn) {
						$dev_grade = $o['grade'];
						$dev_grade_qty = $o['tot_qty'];
					} else if ($step_sn == $stop_sn) {
						$stop_grade = $o['grade'];
						$stop_grade_qty = $o['tot_qty'];
					}
				} else {
					if ($dev_grade_qty == 0)
						$dev_grade_qty = $o['tot_qty'];

					if ($stop_grade_qty == 0)
						$stop_grade_qty = $o['tot_qty'];
				}
			}

			$temp_1 = $dev_grade_qty * ($dev_grade / 100);
			$temp_2 = $stop_grade_qty * ($stop_grade / 100);
			$total_qty = $dev_grade_qty + $stop_grade_qty;

			$stop_grade_qty = ($stop_grade_qty == 0) ? 1 : $stop_grade_qty; //needtoreview

			// added byuday
			if ($temp_1 == 0)
				$tp = ($temp_2 / $stop_grade_qty) * 100;
			else if ($temp_2 == 0)
				$tp = ($temp_1 / $dev_grade_qty) * 100;
			else
				$tp = (($temp_1 + $temp_2) / $total_qty) * 100;

			if ($tp != 0)
				$total_per[$m] = round($tp, 2);
		}

		return $total_per;
	}

	public function undGradeTotal($mineCode, $returnDate, $returnType, $mineral, $stock_type)
	{

		$grade = $this->find('all')
			->select(['tot_qty'])
			->where(['mine_code' => $mineCode, 'return_date' => $returnDate, 'return_type' => $returnType, 'mineral_name' => $mineral]);

		if ($stock_type == 1) {
			$grade = $grade->where(['rom_5_step_sn <' => '2']);
		} else if ($stock_type == 2) {
			$grade = $grade->where(['rom_5_step_sn >' => '4'])
				->where(['rom_5_step_sn <' => '5']);
		} else if ($stock_type == 3) {
			$grade = $grade->where(['rom_5_step_sn >' => '7'])
				->where(['rom_5_step_sn <' => '8']);
		}

		$grade = $grade->order(['rom_5_step_sn' => 'ASC', 'id' => 'ASC'])
			->group('rom_5_step_sn')
			->toArray();

		$und_grade_total = 0;
		foreach ($grade as $g) {
			$und_grade_total += $g['tot_qty'];
		}

		return $und_grade_total;
	}

	public function fetchOpenCastRecords($mineCode, $returnDate, $returnType, $mineral, $step_sn)
	{
		$cast_open = $this->find('all')
			->select(['metal_content', 'grade', 'rom_5_step_sn', 'tot_qty'])
			->where(['mine_code' => $mineCode, 'return_date' => $returnDate, 'return_type' => $returnType, 'mineral_name' => $mineral, 'rom_5_step_sn' => $step_sn])
			->order(['rom_5_step_sn' => 'ASC', 'id' => 'ASC'])
			->toArray();

		return $cast_open;
	}

	public function displayTableGradeTotal($und_total, $und_sum_grades, $open_cast_records)
	{
		$open_cast_total = $open_cast_records[0]['tot_qty'];
		$total_qty = $und_total + $open_cast_total;
		$total_per = $und_sum_grades;

		foreach ($open_cast_records as $o) {
			if (!isset($und_sum_grades[$o['metal_content']])) {
				$tp = $o['grade'];
			} else {
				$temp_1 = $und_total * ($und_sum_grades[$o['metal_content']] / 100);
				$temp_2 = $open_cast_total * ($o['grade'] / 100);
				$tp = (($temp_1 + $temp_2) / $total_qty) * 100;
			}

			if ($tp != 0)
				$total_per[$o['metal_content']] = round($tp, 2);
		}
		//    foreach ($open_cast_records as $o) {
		//      $temp_1 = $und_total * ($und_sum_grades[$o['METAL_CONTENT']] / 100);
		//      $temp_2 = $open_cast_total * ($o['GRADE'] / 100);
		//      $tp = (($temp_1 + $temp_2) / $total_qty) * 100;
		//
		//      if ($tp != 0)
		//        $total_per[$o['METAL_CONTENT']] = round($tp, 2);
		//    }
		//print_r($open_cast_records); // open case details
		//print_r($und_sum_grades); 
		//die;
		//reverse comparision
		if (count($open_cast_records) < count($und_sum_grades)) {
			foreach ($und_sum_grades as $key_min => $u) {

				//          print_r($key_min);
				//          print_r($u);

				$temp_1 = $open_cast_total * ($open_cast_records[$key_min] / 100);
				$temp_2 = $und_total * ($u / 100);

				// added by uday
				if ($temp_1 == 0)
					$tp = ($temp_2 / $stop_grade_qty) * 100;
				else if ($temp_2 == 0)
					$tp = ($temp_1 / $dev_grade_qty) * 100;
				else
					$tp = (($temp_1 + $temp_2) / $total_qty) * 100;
				//        $tp = (($temp_1 + $temp_2) / $total_qty) * 100;

				if ($tp != 0)
					$total_per[$key_min] = round($tp, 2);
			}
		}

		return $total_per;
	}

	public function getTotalProduction($mineCode, $returnDate, $returnType, $mineral)
	{
		$query = $this->find('all')
			->where(['mine_code' => $mineCode, 'return_date' => $returnDate, 'return_type' => $returnType, 'mineral_name' => $mineral, 'rom_5_step_sn >' => '4', 'rom_5_step_sn <' => '6'])
			->toArray();

		$total = 0;
		foreach ($query as $r) {
			$total += $r['tot_qty'];
		}

		return $total;
	}

	// save or update form data
	public function saveFormDetails($forms_data)
	{

		$dataValidatation = $this->postDataValidation($forms_data);

		if ($dataValidatation == 1) {

			$mineCode = $forms_data['mine_code'];
			$returnType = $forms_data['return_type'];
			$returnDate = $forms_data['return_date'];
			$mineralName = $forms_data['mineral_name'];

			$deleteRecord = $this->query();
			$deleteRecord->delete()
				->where(['mine_code' => $mineCode, 'return_type' => $returnType, 'return_date' => $returnDate, 'mineral_name' => $mineralName])
				->where(['rom_5_step_sn IN' => ['1','2','3','4','5','6','7','8','9']])
				->execute();

			//DO NOT CHANGE THE ORDER OF metal_counts ARRAY AND tables ARRAY AT ANY COST
			$metal_counts = array();
			// $metal_counts[] = $forms_data['open_dev_metal_count'];
			// $metal_counts[] = $forms_data['open_stop_metal_count'];
			// $metal_counts[] = $forms_data['open_cast_metal_count'];

			// $metal_counts[] = $forms_data['prod_dev_metal_count'];
			// $metal_counts[] = $forms_data['prod_stop_metal_count'];
			// $metal_counts[] = $forms_data['prod_cast_metal_count'];

			// $metal_counts[] = $forms_data['close_dev_metal_count'];
			// $metal_counts[] = $forms_data['close_stop_metal_count'];
			// $metal_counts[] = $forms_data['close_cast_metal_count'];

			$metal_counts[] = $forms_data['open_dev_metal_count'];
			$metal_counts[] = $forms_data['prod_dev_metal_count'];
			$metal_counts[] = $forms_data['close_dev_metal_count'];

			$metal_counts[] = $forms_data['open_stop_metal_count'];
			$metal_counts[] = $forms_data['prod_stop_metal_count'];
			$metal_counts[] = $forms_data['close_stop_metal_count'];

			$metal_counts[] = $forms_data['open_cast_metal_count'];
			$metal_counts[] = $forms_data['prod_cast_metal_count'];
			$metal_counts[] = $forms_data['close_cast_metal_count'];

			// $tables = array('open_dev', 'open_stop', 'open_cast',
			// 	'prod_dev', 'prod_stop', 'prod_cast',
			// 	'close_dev', 'close_stop', 'close_cast');

			$tables = array(
				'open_dev', 'prod_dev', 'close_dev',
				'open_stop', 'prod_stop', 'close_stop',
				'open_cast', 'prod_cast', 'close_cast'
			);

			$result = '1';

			for ($i = 0; $i < count($metal_counts); $i++) {
				$step_sn = $i + 1;
				for ($j = 1; $j <= $metal_counts[$i]; $j++) {
					$tmp_tbl_qty = 'f_' . $tables[$i] . "_qty";

					$tot_qty = $forms_data[$tmp_tbl_qty];
					$metal_content = $forms_data[$tables[$i] . '_metal_' . $j];
					$grade = $forms_data[$tables[$i] . '_grade_' . $j];

					$newEntity = $this->newEntity(array(
						'mine_code' => $mineCode,
						'return_type' => $returnType,
						'return_date' => $returnDate,
						'mineral_name' => $mineralName,
						'rom_5_step_sn' => $step_sn,
						'tot_qty' => $tot_qty,
						'metal_content' => $metal_content,
						'grade' => $grade,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					));
					if ($this->save($newEntity)) {
						//
					} else {
						$result = false;
					}
				}
			}
		} else {
			$result = false;
		}

		return $result;
	}

	public function postDataValidation($forms_data)
	{

		$returnValue = 1;

		if (empty($forms_data['mine_code'])) {
			$returnValue = null;
		}
		if (empty($forms_data['return_type'])) {
			$returnValue = null;
		}
		if (empty($forms_data['return_date'])) {
			$returnValue = null;
		}
		if (empty($forms_data['mineral_name'])) {
			$returnValue = null;
		}

		$metal_counts = array();
		$metal_counts[] = $forms_data['open_dev_metal_count'];
		$metal_counts[] = $forms_data['open_stop_metal_count'];
		$metal_counts[] = $forms_data['open_cast_metal_count'];

		$metal_counts[] = $forms_data['prod_dev_metal_count'];
		$metal_counts[] = $forms_data['prod_stop_metal_count'];
		$metal_counts[] = $forms_data['prod_cast_metal_count'];

		$metal_counts[] = $forms_data['close_dev_metal_count'];
		$metal_counts[] = $forms_data['close_stop_metal_count'];
		$metal_counts[] = $forms_data['close_cast_metal_count'];

		$tables = array(
			'open_dev', 'open_stop', 'open_cast',
			'prod_dev', 'prod_stop', 'prod_cast',
			'close_dev', 'close_stop', 'close_cast'
		);

		for ($i = 0; $i < count($metal_counts); $i++) {
			$step_sn = $i + 1;
			for ($j = 1; $j <= $metal_counts[$i]; $j++) {
				$tmp_tbl_qty = 'f_' . $tables[$i] . "_qty";

				$tot_qty = $forms_data[$tmp_tbl_qty];
				$metal_content = $forms_data[$tables[$i] . '_metal_' . $j];
				$grade = $forms_data[$tables[$i] . '_grade_' . $j];

				if ($tot_qty == '') {
					$returnValue = null;
				}
				if ($metal_content == '') {
					$returnValue = null;
				}
				if ($grade == '') {
					$returnValue = null;
				}

				if (!is_numeric($tot_qty) && !is_float($tot_qty)) {
					$returnValue = null;
				}
				if (!is_numeric($grade) && !is_float($grade)) {
					$returnValue = null;
				}
				if (strlen($grade) > 99.99 || strlen($grade) < 0) {
					$returnValue = null;
				}
			}
		}

		if ($forms_data['f_open_tot_qty'] == '') {
			$returnValue = null;
		}
		if ($forms_data['f_prod_tot_qty'] == '') {
			$returnValue = null;
		}
		if ($forms_data['f_close_tot_qty'] == '') {
			$returnValue = null;
		}

		if (!is_numeric($forms_data['f_open_tot_qty']) && !is_float($forms_data['f_open_tot_qty'])) {
			$returnValue = null;
		}
		if (!is_numeric($forms_data['f_prod_tot_qty']) && !is_float($forms_data['f_prod_tot_qty'])) {
			$returnValue = null;
		}
		if (!is_numeric($forms_data['f_close_tot_qty']) && !is_float($forms_data['f_close_tot_qty'])) {
			$returnValue = null;
		}

		return $returnValue;
	}

	// save or update form data
	public function saveConReco($params)
	{

		$dataValidatation = $this->conRecoPostValidation($params);

		if ($dataValidatation == 1) {

			$mineCode = $params['mine_code'];
			$returnType = $params['return_type'];
			$returnDate = $params['return_date'];
			$mineralName = $params['mineral_name'];

			$this->deleteConRecords($mineCode, $returnDate, $returnType, $mineralName);

			//DO NOT CHANGE THE ORDER OF metal_counts ARRAY AND tables ARRAY AT ANY COST
			$rom_metal_counts = array();
			$rom_metal_counts[] = $params['open_ore_metal_count'];
			$rom_metal_counts[] = $params['rec_ore_metal_count'];
			$rom_metal_counts[] = $params['treat_ore_metal_count'];
			$rom_metal_counts[] = $params['tail_ore_metal_count'];

			$rom_tables = array('open_ore', 'rec_ore', 'treat_ore', 'tail_ore');

			$result = '1';

			for ($i = 0; $i < 4; $i++) {
				//since rom_5_step_sn for Concentrated Recoveries starts from 10
				$step_sn = $i + 10;
				if ($i == 3)
					$step_sn = 14;

				for ($j = 1; $j <= $rom_metal_counts[$i]; $j++) {

					$tmp_tbl_qty = $rom_tables[$i] . "_qty";
					$tmp_tbl_grade = $rom_tables[$i] . "_grade_" . $j;
					$tmp_tbl_metal = $rom_tables[$i] . '_metal_' . $j;

					$newEntity = $this->newEntity(array(
						'mine_code' => $mineCode,
						'return_type' => $returnType,
						'return_date' => $returnDate,
						'mineral_name' => $mineralName,
						'rom_5_step_sn' => $step_sn,
						'tot_qty' => $params[$tmp_tbl_qty],
						'metal_content' => $params[$tmp_tbl_metal],
						'grade' => $params[$tmp_tbl_grade],
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					));
					if ($this->save($newEntity)) {
						//
					} else {
						$result = false;
					}
				}
			}

			// FOR CONCENTRATED ORE STORE IN ROM_METAL_5
			$romMetalFive = TableRegistry::getTableLocator()->get('RomMetal5');
			$saveRomMetal = $romMetalFive->saveRomMetal($params);
			if ($saveRomMetal == false) {
				$result = false;
			}
		} else {
			$result = false;
		}

		return $result;
	}

	// check post data validation
	public function conRecoPostValidation($params)
	{

		$returnValue = 1;

		if (empty($params['mine_code'])) {
			$returnValue = null;
		}
		if (empty($params['return_type'])) {
			$returnValue = null;
		}
		if (empty($params['return_date'])) {
			$returnValue = null;
		}
		if (empty($params['mineral_name'])) {
			$returnValue = null;
		}

		$rom_metal_counts = array();
		$rom_metal_counts[] = $params['open_ore_metal_count'];
		$rom_metal_counts[] = $params['rec_ore_metal_count'];
		$rom_metal_counts[] = $params['treat_ore_metal_count'];
		$rom_metal_counts[] = $params['tail_ore_metal_count'];

		$rom_tables = array('open_ore', 'rec_ore', 'treat_ore', 'tail_ore');

		for ($i = 0; $i < 4; $i++) {
			//since rom_5_step_sn for Concentrated Recoveries starts from 10
			$step_sn = $i + 10;
			if ($i == 3)
				$step_sn = 14;

			for ($j = 1; $j <= $rom_metal_counts[$i]; $j++) {

				$tmp_tbl_qty = $rom_tables[$i] . "_qty";
				$tmp_tbl_grade = $rom_tables[$i] . "_grade_" . $j;
				$tmp_tbl_metal = $rom_tables[$i] . '_metal_' . $j;

				$tot_qty = $params[$tmp_tbl_qty];
				$metal_content = $params[$tmp_tbl_metal];
				$grade = $params[$tmp_tbl_grade];

				if ($tot_qty == '') {
					$returnValue = null;
				}
				if ($metal_content == '') {
					$returnValue = null;
				}
				if ($grade == '') {
					$returnValue = null;
				}

				if (!is_numeric($tot_qty) && !is_float($tot_qty)) {
					$returnValue = null;
				}
				if (!is_numeric($grade) && !is_float($grade)) {
					$returnValue = null;
				}
			}
		}

		// FOR CONCENTRATED ORE STORE IN ROM_METAL_5
		$con_metal_counts = array();
		$con_metal_counts[] = $params['con_obt_metal_count'];
		$con_metal_counts[] = $params['close_con_metal_count'];

		$con_tables = array('con_obt', 'close_con');

		for ($i = 0; $i < 2; $i++) {
			//13 - for Con Obtained
			//15 - for Closing Stock
			if ($i == 0)
				$step_sn = 13;
			else
				$step_sn = 15;

			for ($j = 1; $j <= $con_metal_counts[$i]; $j++) {

				$con_tbl_metal = $con_tables[$i] . '_metal_' . $j;
				$con_tbl_qty = $con_tables[$i] . "_quantity_" . $j;
				$con_tbl_value = $con_tables[$i] . '_metal_value_' . $j;
				$con_tbl_grade = $con_tables[$i] . "_grade_" . $j;

				$qty = $params[$con_tbl_qty];
				$metal_name = $params[$con_tbl_metal];
				$grade = $params[$con_tbl_grade];

				if ($qty == '') {
					$returnValue = null;
				}
				if (isset($params[$con_tbl_value])) {
					if ($params[$con_tbl_value] == '') {
						$returnValue = null;
					}
				}
				if ($metal_name == '') {
					$returnValue = null;
				}
				if ($grade == '') {
					$returnValue = null;
				}

				if (!is_numeric($qty) && !is_float($qty)) {
					$returnValue = null;
				}
				if (!is_numeric($grade) && !is_float($grade)) {
					$returnValue = null;
				}
			}
		}

		return $returnValue;
	}

	/**
	 * deletes the rom records for concentrate form for the particular month
	 * @param type $mineCode
	 * @param type $returnDate
	 * @param type $returnType 
	 * @param type $mineral
	 */
	public function deleteConRecords($mineCode, $returnDate, $returnType, $mineralName)
	{

		$deleteRecord = $this->query();
		$deleteRecord->delete()
			->where(['mine_code' => $mineCode])
			->where(['return_type' => $returnType])
			->where(['return_date' => $returnDate])
			->where(['mineral_name' => $mineralName])
			->where(['rom_5_step_sn IN' => ['10', '11', '12', '14']])
			->execute();
	}


	public function getRomPrintData($mineCode, $returnDate, $returnType, $mineral)
	{

		$query = $this->find()
			->where(['mine_code' => $mineCode])
			->where(['return_date' => $returnDate])
			->where(['return_type' => $returnType])
			->where(['mineral_name' => $mineral])
			->where(['rom_5_step_sn <=' => '9'])
			->order(['id' => 'ASC'])
			->toArray();

		$tables = array(
			'open_dev', 'open_stop', 'open_cast',
			'prod_dev', 'prod_stop', 'prod_cast',
			'close_dev', 'close_stop', 'close_cast'
		);

		$data = array();
		$table_data = array();
		$prev_table = "";
		$cur_table = "";
		$m_count = 0;
		$i = 0;
		foreach ($query as $r) {
			$step_sn = $r['rom_5_step_sn'] - 1;
			$tbl = $tables[$step_sn];

			if ($prev_table == "")
				$prev_table = $tbl;

			$cur_table = $tbl;

			if ($cur_table != $prev_table) {
				$prev_table = $cur_table;
				$m_count = 0;
			} else {
				if ($i != 0)
					$m_count++;
			}

			$table_data[$tbl]['tot_qty'] = $r['tot_qty'];
			$table_data[$tbl]['table'][$m_count]['metal'] = $r['metal_content'];
			$table_data[$tbl]['table'][$m_count]['grade'] = $r['grade'];

			if ($i == 0)
				$data['reason'] = $r['INC_REASON'];

			$i++;
		}

		$data['table_data'] = $table_data;

		//underground table total qty
		$und_tot_qty['open_und_total'] = $table_data['open_dev']['tot_qty'] + $table_data['open_stop']['tot_qty'];
		$und_tot_qty['prod_und_total'] = $table_data['prod_dev']['tot_qty'] + $table_data['prod_stop']['tot_qty'];
		$und_tot_qty['close_und_total'] = $table_data['close_dev']['tot_qty'] + $table_data['close_stop']['tot_qty'];
		$data['und_tot_qty'] = $und_tot_qty;

		//cast table total qty
		$cast_tot_qty['open'] = $table_data['open_cast']['tot_qty'] + $und_tot_qty['open_und_total'];
		$cast_tot_qty['prod'] = $table_data['prod_cast']['tot_qty'] + $und_tot_qty['prod_und_total'];
		$cast_tot_qty['close'] = $table_data['close_cast']['tot_qty'] + $und_tot_qty['close_und_total'];
		$data['cast_tot_qty'] = $cast_tot_qty;

		//und table total

		$data['display_table'] = $this->getDisplayTableData($mineCode, $returnDate, $returnType, $mineral);

		return $data;
	}
}
