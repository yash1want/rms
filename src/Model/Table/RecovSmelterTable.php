<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
    use Cake\Datasource\ConnectionManager;
	
	class RecovSmelterTable extends Table{

		var $name = "RecovSmelter";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function getRecoveryData($mineCode, $returnDate, $returnType, $mineral, $pdfStatus = 0) {

			//ROM DATA FROM ROM_5 table
			$prev_month_data = Array();
			$prev_month_data = $this->getPreviousMonthData($mineCode, $returnDate, $returnType, $mineral);

			$recovery = $this->find('all')
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>$returnType])
					->where(['mineral_name'=>$mineral])
					->order(['id'=>'ASC'])
					->toArray();

			if (count($recovery) == 0 && $returnType == 'ANNUAL' && $pdfStatus == 0) {

				/**
				 * Prefetch the monthly records data for annual returns
				 * Effective from Phase - II
				 * @version 16th Nov 2021
				 * @author Aniket Ganvir
				 */
				$conn = ConnectionManager::get(Configure::read('conn'));
				$startDate = (date('Y',strtotime($returnDate))).'-04-01';
				$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
				$str = "SELECT
					smelter_step_sn,
					type_concentrate,
					sum(grade) as grade,
					sum(source) as source,
					sum(qty) as qty,
					sum(`value`) as `value`
					FROM `recov_smelter`
					WHERE mine_code = '$mineCode'
					AND return_type = 'MONTHLY'
					AND return_date BETWEEN '$startDate' AND '$endDate'
					AND mineral_name = '$mineral'
					GROUP BY smelter_step_sn, type_concentrate
					ORDER BY type_concentrate, smelter_step_sn";
					
				$recovery = $conn->execute($str)->fetchAll('assoc');

			}

			$smelter_data = array();
			$data = array();
			$recovery_data = array();
			$con_metal_data = array();
			$byproduct_data = array();
			$i = 0;
			foreach ($recovery as $r) {

				$data['metal'] = $r['type_concentrate'];
				$data['grade'] = $r['grade'];
				$data['source'] = $r['source'];
				$data['qty'] = $r['qty'];
				$data['value'] = $r['value'];

				$step_sn = $r['smelter_step_sn'];
				$data['step_sn'] = $r['smelter_step_sn'];

				if ($step_sn == 6) {
					$con_metal_data[$i] = $data;
				} else if ($step_sn == 7) {
					$byproduct_data[$i] = $data;
				} else {
					$recovery_data[$i] = $data;
				}

				$smelter_data['recovery'] = $recovery_data;
				$smelter_data['con_metal'] = $con_metal_data;
				$smelter_data['byproduct'] = $byproduct_data;

				$i++;
			}

			if(count($recovery) == 0){

				$smelter_data['recovery'] = $recovery_data;
				$smelter_data['con_metal'] = $con_metal_data;
				$smelter_data['byproduct'] = $byproduct_data;
			}

			$rec = array();
			$prev_metal = "";
			$current_metal = "";
			$m_count = 0;
			foreach ($smelter_data['recovery'] as $s) {
				if ($prev_metal == "")
				$prev_metal = $s['metal'];

				$current_metal = $s['metal'];

				if ($current_metal != $prev_metal) {
					$prev_metal = $current_metal;
					$m_count++;
				}

				$step_sn = $s['step_sn'];
				switch ($step_sn) {
					case 1:
					$rec[$m_count]['open_metal'] = $s['metal'];
					$rec[$m_count]['open_qty'] = $s['qty'];
					$rec[$m_count]['open_grade'] = $s['grade'];
					case 2:
					$rec[$m_count]['con_rc_qty'] = $s['qty'];
					$rec[$m_count]['con_rc_grade'] = $s['grade'];
					case 3:
					$rec[$m_count]['con_rs_qty'] = $s['qty'];
					$rec[$m_count]['con_rs_grade'] = $s['grade'];
					$rec[$m_count]['con_rs_source'] = $s['source'];
					case 4:
					$rec[$m_count]['con_so_qty'] = $s['qty'];
					$rec[$m_count]['con_so_grade'] = $s['grade'];
					case 5:
					$rec[$m_count]['con_tr_qty'] = $s['qty'];
					$rec[$m_count]['con_tr_grade'] = $s['grade'];
					case 8:
					$rec[$m_count]['close_qty'] = $s['qty'];
					$rec[$m_count]['close_value'] = $s['value'];
				}
			}

			$dirProduct = TableRegistry::getTableLocator()->get('DirProduct');

			$con = array();
			$prev_metal = "";
			$current_metal = "";
			$p_count = 0;
			foreach ($smelter_data['con_metal'] as $m) {
				if ($prev_metal == ""){
					$prev_metal = $m['metal'];
				}

				$current_metal = $m['metal'];

				if ($current_metal != $prev_metal) {
					$prev_metal = $current_metal;
					$p_count++;
				}

				$con[$p_count]['rc_metal'] = $m['metal'];
				$con[$p_count]['rc_qty'] = $m['qty'];
				$con[$p_count]['rc_value'] = $m['value'];
				$con[$p_count]['rc_grade'] = $m['grade'];
				$con[$p_count]['unit'] = $dirProduct->getUnit($m['metal']);
			}

			$bp = array();
			$prev_metal = "";
			$current_metal = "";
			$bp_count = 0;
			foreach ($smelter_data['byproduct'] as $b) {
				if ($prev_metal == ""){
					$prev_metal = $b['metal'];
				}

				$current_metal = $b['metal'];

				if ($current_metal != $prev_metal) {
					$prev_metal = $current_metal;
					$bp_count++;
				}

				$bp[$bp_count]['bp_metal'] = $b['metal'];
				$bp[$bp_count]['bp_qty'] = $b['qty'];
				$bp[$bp_count]['bp_value'] = $b['value'];
				$bp[$bp_count]['bp_grade'] = $b['grade'];
				$bp[$bp_count]['unit'] = $dirProduct->getUnit($m['metal']);
			}

			if(count($rec) == 0){
				$rec = array(0 => array(
					'open_metal' => '',
					'open_qty' => '',
					'open_grade' => '',
					'con_rc_qty' => '',
					'con_rc_grade' => '',
					'con_rs_qty' => '',
					'con_rs_grade' => '',
					'con_rs_source' => '',
					'con_so_qty' => '',
					'con_so_grade' => '',
					'con_tr_qty' => '',
					'con_tr_grade' => '',
					'close_qty' => '',
					'close_value' => ''));
			}
			if(count($con) == 0){
				$con = array(0 => array(
					'rc_metal' => '',
					'rc_qty' => '',
					'rc_value' => '',
					'rc_grade' => '',
					'unit' => ''));
			}
			if(count($bp) == 0){
				$bp = array(0 => array(
					'bp_metal' => '',
					'bp_qty' => '',
					'bp_value' => '',
					'bp_grade' => '',
					'unit' => ''));
			}

			$structured_data['recovery'] = $rec;
			$structured_data['con_metal'] = $con;
			$structured_data['by_product'] = $bp;
			$structured_data['prev_month_data'] = $prev_month_data;

			return $structured_data;
			
		}
		
		/**
		 * Prefetch the monthly records data for annual return
		 * Effective from Phase-II
		 * @version 22nd Nov 2021
		 * @author Aniket Ganvir
		 */
		public function getRecoveryDataMonthAll($mineCode, $returnDate, $returnType, $mineral) {

			//ROM DATA FROM ROM_5 table
			$prev_month_data = Array();
			$prev_month_data = $this->getPreviousMonthData($mineCode, $returnDate, $returnType, $mineral);

			$conn = ConnectionManager::get(Configure::read('conn'));
			$startDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
			$str = "SELECT
				smelter_step_sn,
				type_concentrate,
				sum(grade) as grade,
				sum(source) as source,
				sum(qty) as qty,
				sum(`value`) as `value`
				FROM `recov_smelter`
				WHERE mine_code = '$mineCode'
				AND return_type = 'MONTHLY'
				AND return_date BETWEEN '$startDate' AND '$endDate'
				AND mineral_name = '$mineral'
				GROUP BY smelter_step_sn, type_concentrate
				ORDER BY type_concentrate, smelter_step_sn";
				
			$recovery = $conn->execute($str)->fetchAll('assoc');

			$smelter_data = array();
			$data = array();
			$recovery_data = array();
			$con_metal_data = array();
			$byproduct_data = array();
			$i = 0;
			foreach ($recovery as $r) {

				$data['metal'] = $r['type_concentrate'];
				$data['grade'] = $r['grade'];
				$data['source'] = $r['source'];
				$data['qty'] = $r['qty'];
				$data['value'] = $r['value'];

				$step_sn = $r['smelter_step_sn'];
				$data['step_sn'] = $r['smelter_step_sn'];

				if ($step_sn == 6) {
					$con_metal_data[$i] = $data;
				} else if ($step_sn == 7) {
					$byproduct_data[$i] = $data;
				} else {
					$recovery_data[$i] = $data;
				}

				$smelter_data['recovery'] = $recovery_data;
				$smelter_data['con_metal'] = $con_metal_data;
				$smelter_data['byproduct'] = $byproduct_data;

				$i++;
			}

			if(count($recovery) == 0){

				$smelter_data['recovery'] = $recovery_data;
				$smelter_data['con_metal'] = $con_metal_data;
				$smelter_data['byproduct'] = $byproduct_data;
			}

			$rec = array();
			$prev_metal = "";
			$current_metal = "";
			$m_count = 0;
			foreach ($smelter_data['recovery'] as $s) {
				if ($prev_metal == "")
				$prev_metal = $s['metal'];

				$current_metal = $s['metal'];

				if ($current_metal != $prev_metal) {
					$prev_metal = $current_metal;
					$m_count++;
				}

				$step_sn = $s['step_sn'];
				switch ($step_sn) {
					case 1:
					$rec[$m_count]['open_metal'] = $s['metal'];
					$rec[$m_count]['open_qty'] = $s['qty'];
					$rec[$m_count]['open_grade'] = $s['grade'];
					case 2:
					$rec[$m_count]['con_rc_qty'] = $s['qty'];
					$rec[$m_count]['con_rc_grade'] = $s['grade'];
					case 3:
					$rec[$m_count]['con_rs_qty'] = $s['qty'];
					$rec[$m_count]['con_rs_grade'] = $s['grade'];
					$rec[$m_count]['con_rs_source'] = $s['source'];
					case 4:
					$rec[$m_count]['con_so_qty'] = $s['qty'];
					$rec[$m_count]['con_so_grade'] = $s['grade'];
					case 5:
					$rec[$m_count]['con_tr_qty'] = $s['qty'];
					$rec[$m_count]['con_tr_grade'] = $s['grade'];
					case 8:
					$rec[$m_count]['close_qty'] = $s['qty'];
					$rec[$m_count]['close_value'] = $s['value'];
				}
			}

			$dirProduct = TableRegistry::getTableLocator()->get('DirProduct');

			$con = array();
			$prev_metal = "";
			$current_metal = "";
			$p_count = 0;
			foreach ($smelter_data['con_metal'] as $m) {
				if ($prev_metal == ""){
					$prev_metal = $m['metal'];
				}

				$current_metal = $m['metal'];

				if ($current_metal != $prev_metal) {
					$prev_metal = $current_metal;
					$p_count++;
				}

				$con[$p_count]['rc_metal'] = $m['metal'];
				$con[$p_count]['rc_qty'] = $m['qty'];
				$con[$p_count]['rc_value'] = $m['value'];
				$con[$p_count]['rc_grade'] = $m['grade'];
				$con[$p_count]['unit'] = $dirProduct->getUnit($m['metal']);
			}

			$bp = array();
			$prev_metal = "";
			$current_metal = "";
			$bp_count = 0;
			foreach ($smelter_data['byproduct'] as $b) {
				if ($prev_metal == ""){
					$prev_metal = $b['metal'];
				}

				$current_metal = $b['metal'];

				if ($current_metal != $prev_metal) {
					$prev_metal = $current_metal;
					$bp_count++;
				}

				$bp[$bp_count]['bp_metal'] = $b['metal'];
				$bp[$bp_count]['bp_qty'] = $b['qty'];
				$bp[$bp_count]['bp_value'] = $b['value'];
				$bp[$bp_count]['bp_grade'] = $b['grade'];
				$bp[$bp_count]['unit'] = $dirProduct->getUnit($m['metal']);
			}

			if(count($rec) == 0){
				$rec = array(0 => array(
					'open_metal' => '',
					'open_qty' => '',
					'open_grade' => '',
					'con_rc_qty' => '',
					'con_rc_grade' => '',
					'con_rs_qty' => '',
					'con_rs_grade' => '',
					'con_rs_source' => '',
					'con_so_qty' => '',
					'con_so_grade' => '',
					'con_tr_qty' => '',
					'con_tr_grade' => '',
					'close_qty' => '',
					'close_value' => ''));
			}
			if(count($con) == 0){
				$con = array(0 => array(
					'rc_metal' => '',
					'rc_qty' => '',
					'rc_value' => '',
					'rc_grade' => '',
					'unit' => ''));
			}
			if(count($bp) == 0){
				$bp = array(0 => array(
					'bp_metal' => '',
					'bp_qty' => '',
					'bp_value' => '',
					'bp_grade' => '',
					'unit' => ''));
			}

			$structured_data['recovery'] = $rec;
			$structured_data['con_metal'] = $con;
			$structured_data['by_product'] = $bp;
			$structured_data['prev_month_data'] = $prev_month_data;

			return $structured_data;
			
		}

		public function getPreviousMonthData($mineCode, $returnDate, $returnType, $mineral) {

			$prev_month = date('Y-m-d', strtotime(date("Y-m-d", strtotime($returnDate)) . " -1 month"));

			$query = $this->find('all')
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$prev_month])
					->where(['return_type'=>$returnType])
					->where(['mineral_name'=>$mineral])
					->where(['smelter_step_sn'=>8])
					->toArray();

			$i = 0;
			$prev_data = Array();
			foreach ($query as $data) {
				$prev_data[$i]['open_metal'] = $data['type_concentrate'];
				$prev_data[$i]['open_qty'] = $data['qty'];
				$i++;
			}
			return $prev_data;
		}

		// save or update form data
	    public function saveFormDetails($params){

			$dataValidatation = $this->postDataValidation($params);

			if($dataValidatation == 1 ){

	            $mineCode = $params['mine_code'];
	        	$returnType = $params['return_type'];
	        	$returnDate = $params['return_date'];
	        	$mineralName = $params['mineral_name'];

	        	$deleteRecord = $this->query();
	        	$deleteRecord->delete()
	        		->where(['mine_code'=>$mineCode, 'return_date'=>$returnDate, 'return_type'=>$returnType, 'mineral_name'=>$mineralName])
	        		->execute();

				$result = '1';
				$recovery_tables = array('open', 'con_rc', 'con_rs', 'con_so', 'con_tr', 'close');

				//save the recovery data
				$recovery_count = $params['recovery_count'];
				for ($i = 0; $i < $recovery_count; $i++) {
					$count = $i + 1;
					for ($j = 0; $j < count($recovery_tables); $j++) {

						$step_sn = $j + 1;
						if ($j == 5){
							$step_sn = 8;
						}

						$tmp_tbl_qty = $recovery_tables[$j] . "_qty_" . $count;
						$tmp_tbl_grade = $recovery_tables[$j] . "_grade_" . $count;
						$tmp_tbl_metal = 'open_metal_' . $count;
						$tmp_tbl_value = 'close_value_' . $count;

						// $source = ($step_sn == 3) ? $params[$tmp_tbl_source] : null;
						$grade = ($step_sn == 8) ? null : $params[$tmp_tbl_grade];

						$newEntity = $this->newEntity(array(
							'mine_code'=>$mineCode,
							'return_type'=>$returnType,
							'return_date'=>$returnDate,
							'mineral_name'=>$mineralName,
							'smelter_step_sn'=>$step_sn,
							'type_concentrate'=>$params[$tmp_tbl_metal],
							'grade'=>$grade,
							'qty'=>$params[$tmp_tbl_qty],
							// 'source'=>$source,
							'value'=>$params[$tmp_tbl_value],
							'created_at'=>date('Y-m-d H:i:s'),
							'updated_at'=>date('Y-m-d H:i:s')
						));
						if($this->save($newEntity)){
							//
						} else {
							$result = false;
						}

					}
				}

				//save metals recovered
				$metal_recovered_count = $params['con_metal_count'];
				for ($i = 0; $i < $metal_recovered_count; $i++) {
					$mcount = $i + 1;
					$tmp_rc_qty = "rc_qty_" . $mcount;
					$tmp_rc_grade = "rc_grade_" . $mcount;
					$tmp_rc_metal = 'rc_metal_' . $mcount;
					$tmp_rc_value = 'rc_value_' . $mcount;

					$newEntity = $this->newEntity(array(
						'mine_code'=>$mineCode,
						'return_type'=>$returnType,
						'return_date'=>$returnDate,
						'mineral_name'=>$mineralName,
						'smelter_step_sn'=>6,
						'type_concentrate'=>$params[$tmp_rc_metal],
						'grade'=>$params[$tmp_rc_grade],
						'qty'=>$params[$tmp_rc_qty],
						'value'=>$params[$tmp_rc_value],
						'created_at'=>date('Y-m-d H:i:s'),
						'updated_at'=>date('Y-m-d H:i:s')
					));
					if($this->save($newEntity)){
						//
					} else {
						$result = false;
					}

				}

				//save byproducts
				$byproduct_count = $params['byproduct_metal_count'];
				for ($i = 0; $i < $byproduct_count; $i++) {
					$bcount = $i + 1;
					$tmp_bp_qty = "rc_byproduct_qty_" . $bcount;
					$tmp_bp_grade = "rc_byproduct_grade_" . $bcount;
					$tmp_bp_metal = 'rc_byproduct_prod_' . $bcount;
					$tmp_bp_value = 'rc_byproduct_value_' . $bcount;

					$newEntity = $this->newEntity(array(
						'mine_code'=>$mineCode,
						'return_type'=>$returnType,
						'return_date'=>$returnDate,
						'mineral_name'=>$mineralName,
						'smelter_step_sn'=>7,
						'type_concentrate'=>$params[$tmp_bp_metal],
						'grade'=>$params[$tmp_bp_grade],
						'qty'=>$params[$tmp_bp_qty],
						'value'=>$params[$tmp_bp_value],
						'created_at'=>date('Y-m-d H:i:s'),
						'updated_at'=>date('Y-m-d H:i:s')
					));
					if($this->save($newEntity)){
						//
					} else {
						$result = false;
					}

				}

				// RESET THE "5. Sales during the year/month" SECTION
				// ON SAVING OF THIS "4. Recovery at the Smelter-Mill-Plant" SECTION
				// Effective from Phase-II
				// Added on 22-03-2022 by A.G.
				$Sale5 = TableRegistry::getTableLocator()->get('Sale5');
				$query = $Sale5->query();
				$query->delete()
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>$returnType])
					->where(['mineral_name'=>$mineralName])
					->execute();

				// ALSO RESET THE COMMENT IN THE "5. Sales during the year/month" SECTION
				// Effective from Phase-II
				// Added on 22-03-2022 by A.G.
				$TblFinalSubmit = TableRegistry::getTableLocator()->get('TblFinalSubmit');
				$latestReturnId = $TblFinalSubmit->getLatestReturnId($mineCode, $returnDate, $returnType);
				if (!empty($latestReturnId)) {
					$TblFinalSubmit->removeRejectReply($latestReturnId, $mineralName, '', '', 5);
				}
					
			} else {
				$result = false;
			}

			return $result;

	    }

	    public function postDataValidation($params){
			
			$returnValue = 1;

			if(empty($params['mine_code'])){ $returnValue = null ; }
			if(empty($params['return_type'])){ $returnValue = null ; }
			if(empty($params['return_date'])){ $returnValue = null ; }
			if(empty($params['mineral_name'])){ $returnValue = null ; }
			
			// check recovery data
			$recovery_tables = array('open', 'con_rc', 'con_rs', 'con_so', 'con_tr', 'close');

			$recovery_count = $params['recovery_count'];
			for ($i = 0; $i < $recovery_count; $i++) {
				$count = $i + 1;
				for ($j = 0; $j < count($recovery_tables); $j++) {

					$step_sn = $j + 1;
					if ($j == 5){
						$step_sn = 8;
					}

					$tmp_tbl_qty = $recovery_tables[$j] . "_qty_" . $count;
					$tmp_tbl_grade = $recovery_tables[$j] . "_grade_" . $count;
					$tmp_tbl_metal = 'open_metal_' . $count;
					$tmp_tbl_value = 'close_value_' . $count;

					if($step_sn == 8){
						$grade = null;
					} else {
						$grade = $params[$tmp_tbl_grade];
						if($grade == ''){ $returnValue = null ; }
						if(!is_numeric($grade) && !is_float($grade)){ $returnValue = null ; }
					}

					$type_concentrate = $params[$tmp_tbl_metal];
					$qty = $params[$tmp_tbl_qty];
					$value = $params[$tmp_tbl_value];

					if($type_concentrate == ''){ $returnValue = null ; }
					if($qty == ''){ $returnValue = null ; }
					if($value == ''){ $returnValue = null ; }

					if(!is_numeric($qty) && !is_float($qty)){ $returnValue = null ; }
					if(!is_numeric($value) && !is_float($value)){ $returnValue = null ; }

				}
			}

			// check metals recovered
			$metal_recovered_count = $params['con_metal_count'];
			for ($i = 0; $i < $metal_recovered_count; $i++) {
				$mcount = $i + 1;
				$tmp_rc_qty = "rc_qty_" . $mcount;
				$tmp_rc_grade = "rc_grade_" . $mcount;
				$tmp_rc_metal = 'rc_metal_' . $mcount;
				$tmp_rc_value = 'rc_value_' . $mcount;

				$type_concentrate = $params[$tmp_rc_metal];
				$grade = $params[$tmp_rc_grade];
				$qty = $params[$tmp_rc_qty];
				$value = $params[$tmp_rc_value];

				if($type_concentrate == ''){ $returnValue = null ; }
				if($grade == ''){ $returnValue = null ; }
				if($qty == ''){ $returnValue = null ; }
				if($value == ''){ $returnValue = null ; }

				if(!is_numeric($grade) && !is_float($grade)){ $returnValue = null ; }
				if(!is_numeric($qty) && !is_float($qty)){ $returnValue = null ; }
				if(!is_numeric($value) && !is_float($value)){ $returnValue = null ; }

			}

			// check byproducts
			$byproduct_count = $params['byproduct_metal_count'];
			for ($i = 0; $i < $byproduct_count; $i++) {
				$bcount = $i + 1;
				$tmp_bp_qty = "rc_byproduct_qty_" . $bcount;
				$tmp_bp_grade = "rc_byproduct_grade_" . $bcount;
				$tmp_bp_metal = 'rc_byproduct_prod_' . $bcount;
				$tmp_bp_value = 'rc_byproduct_value_' . $bcount;

				$type_concentrate = $params[$tmp_bp_metal];
				$grade = $params[$tmp_bp_grade];
				$qty = $params[$tmp_bp_qty];
				$value = $params[$tmp_bp_value];

				if($type_concentrate == ''){ $returnValue = null ; }
				if($grade == ''){ $returnValue = null ; }
				if($qty == ''){ $returnValue = null ; }
				if($value == ''){ $returnValue = null ; }

				if(!is_numeric($grade) && !is_float($grade)){ $returnValue = null ; }
				if(!is_numeric($qty) && !is_float($qty)){ $returnValue = null ; }
				if(!is_numeric($value) && !is_float($value)){ $returnValue = null ; }

			}
			
			return $returnValue;
			
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
		public function isFilled($mineCode, $returnDate, $returnType, $mineral) {

			$query = $this->find('all')
				->select(['type_concentrate'])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>$returnType])
				->where(['return_date'=>$returnDate])
				->where(['mineral_name'=>$mineral])
				->toArray();

			if (count($query) == 0){
				return 1;
			}

			foreach ($query as $r) {
				if ($r['type_concentrate'] == "") {
					return 1;
				}
			}

			return 0;

		}


	}

?>