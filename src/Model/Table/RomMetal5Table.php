<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use App\Controller\MonthlyController;
	use Cake\ORM\Locator\LocatorAwareTrait;
    use Cake\Datasource\ConnectionManager;
	
	class RomMetal5Table extends Table{
		
		public function initialize(array $config): void
		{
			$this->setTable('rom_metal_5');
		}
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		/**
		* Deletes the CON records for the particular month
		* @param type $mineCode
		* @param type $returnDate
		* @param type $returnType 
		* @param type $mineral
		*/
		public function deleteRecords($mineCode, $returnDate, $returnType, $mineral) {

	    	$deleteRecord = $this->query();
	    	$deleteRecord->delete()
    		->where(['mine_code'=>$mineCode])
    		->where(['return_type'=>$returnType])
    		->where(['return_date'=>$returnDate])
    		->where(['mineral_name'=>$mineral])
    		->execute();
		}

		// save or update form data
	    public function saveRomMetal($params){

            $mineCode = $params['mine_code'];
        	$returnType = $params['return_type'];
        	$returnDate = $params['return_date'];
        	$mineralName = $params['mineral_name'];

        	$this->deleteRecords($mineCode, $returnDate, $returnType, $mineralName);

			$con_metal_counts = array();
			$con_metal_counts[] = $params['con_obt_metal_count'];
			$con_metal_counts[] = $params['close_con_metal_count'];

			$con_tables = array('con_obt', 'close_con');

			$result = '1';

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
					$p_con_tbl_value = (isset($params[$con_tbl_value])) ? $params[$con_tbl_value] : "";

					$newEntity = $this->newEntity(array(
						'mine_code'=>$mineCode,
						'return_type'=>$returnType,
						'return_date'=>$returnDate,
						'mineral_name'=>$mineralName,
						'rom_5_step_sn'=>$step_sn,
						'qty'=>$params[$con_tbl_qty],
						'value'=>$p_con_tbl_value,
						'metal_name'=>$params[$con_tbl_metal],
						'grade'=>$params[$con_tbl_grade],
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

			return $result;

	    }

		// RETURNS THE CON AND ROM DETAILS
		public function getConRomData($mineCode, $returnDate, $returnType, $mineral, $pdfStatus = 0) {
			
	        //ROM DATA FROM ROM_5 table
			$romFive = TableRegistry::getTableLocator()->get('Rom5');
	        $rom = $romFive->find('all')
	                ->where(['mine_code'=>$mineCode])
	                ->where(['return_date'=>$returnDate])
	                ->where(['return_type'=>$returnType])
	                ->where(['mineral_name'=>$mineral])
	                ->where(['rom_5_step_sn >='=>'10'])
	                ->order(['id'=>'ASC'])
	                ->toArray();

	        $rom_tables = array('10'=>'open_ore', '11'=>'rec_ore', '12'=>'treat_ore', '14'=>'tail_ore');

	        $rom_data = array();
	        $i = 0;
	        foreach ($rom as $r) {
	            $step_sn = $r['rom_5_step_sn'];
	            $rom_data[$step_sn]['table'][] = $rom_tables[$step_sn];
	            $rom_data[$step_sn]['tot_qty'][] = $r['tot_qty'];
	            $rom_data[$step_sn]['metal'][] = $r['metal_content'];
	            $rom_data[$step_sn]['grade'][] = $r['grade'];
	            $i++;
	        }

	        if(count($rom) == 0){

				if ($returnType == 'ANNUAL' && $pdfStatus == 0) {
					
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
						SUM(tot_qty) as tot_qty,
						metal_content,
						SUM(grade) as grade,
						rom_5_step_sn
						FROM `rom_5`
						WHERE mine_code = '$mineCode'
						AND return_type = 'MONTHLY'
						AND return_date BETWEEN '$startDate' AND '$endDate'
						AND mineral_name = '$mineral'
						AND rom_5_step_sn >= 10
						GROUP BY rom_5_step_sn, metal_content";
						
					$query = $conn->execute($str)->fetchAll('assoc');
					if ($query == null) {
						
						for($i=10;$i<=14;$i++){
							if($i != '13'){
								$rom_data[$i]['table'][] = $rom_tables[$i];
								$rom_data[$i]['tot_qty'][] = '';
								$rom_data[$i]['metal'][] = '';
								$rom_data[$i]['grade'][] = '';
							}
						}

					} else {

						foreach ($query as $r) {
							$step_sn = $r['rom_5_step_sn'];
							$rom_data[$step_sn]['table'][] = $rom_tables[$step_sn];
							$rom_data[$step_sn]['tot_qty'][] = $r['tot_qty'];
							$rom_data[$step_sn]['metal'][] = $r['metal_content'];
							$rom_data[$step_sn]['grade'][] = $r['grade'];
							$rom_data[$step_sn]['tot_qty'][0] = (isset($rom_data[$step_sn]['tot_qty'][0])) ? ($rom_data[$step_sn]['tot_qty'][0] + $r['tot_qty']) : $r['tot_qty'];
						}

					}

				} else {

					for($i=10;$i<=14;$i++){
						if($i != '13'){
							$rom_data[$i]['table'][] = $rom_tables[$i];
							$rom_data[$i]['tot_qty'][] = '';
							$rom_data[$i]['metal'][] = '';
							$rom_data[$i]['grade'][] = '';
						}
					}

				}

	        }

	        //CON. ORE DATA FROM ROM_METAL_5 table
	        $con = $this->find('all')
	                ->where(['mine_code'=>$mineCode])
	                ->where(['return_date'=>$returnDate])
	                ->where(['return_type'=>$returnType])
	                ->where(['mineral_name'=>$mineral])
	                ->order('id')
	                ->toArray();

	        $con_data = array();
	        $j = 0;
	        foreach ($con as $c) {
	            $step_sn = $c['rom_5_step_sn'];
	            if ($step_sn == 13)
	                $con_data[$step_sn]['table'][] = 'con_obt';
	            else if ($step_sn == 15)
	                $con_data[$step_sn]['table'][] = 'close_con';

	            $con_data[$step_sn]['tot_qty'][] = $c['qty'];
	            $con_data[$step_sn]['metal'][] = $c['metal_name'];
	            $con_data[$step_sn]['grade'][] = $c['grade'];
	            $con_data[$step_sn]['con_value'][] = $c['value'];

	            $j++;
	        }

	        $con_tables = array('13'=>'con_obt', '15'=>'close_con');

	        if(count($con) == 0){
				
				if ($returnType == 'ANNUAL' && $pdfStatus == 0) {

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
						rom_5_step_sn,
						metal_name,
						SUM(grade) as grade,
						sum(qty) as qty,
						sum(`value`) as `value`
						FROM `rom_metal_5`
						WHERE mine_code = '$mineCode'
						AND return_type = 'MONTHLY'
						AND return_date BETWEEN '$startDate' AND '$endDate'
						AND mineral_name = '$mineral'
						GROUP BY rom_5_step_sn, metal_name";
						
					$conQuery = $conn->execute($str)->fetchAll('assoc');
					if ($conQuery == null) {
						
						for($i=13;$i<=15;$i++){
							if($i != '14'){
								$con_data[$i]['table'][] = $con_tables[$i];
								$con_data[$i]['tot_qty'][] = '';
								$con_data[$i]['metal'][] = '';
								$con_data[$i]['grade'][] = '';
								$con_data[$i]['con_value'][] = '';
							}
						}
	
					} else {
	
						foreach ($conQuery as $c) {
							$step_sn = $c['rom_5_step_sn'];
							if ($step_sn == 13) {
								$con_data[$step_sn]['table'][] = 'con_obt';
							} elseif ($step_sn == 15) {
								$con_data[$step_sn]['table'][] = 'close_con';
							}
							$con_data[$step_sn]['tot_qty'][] = $c['qty'];
							$con_data[$step_sn]['metal'][] = $c['metal_name'];
							$con_data[$step_sn]['grade'][] = $c['grade'];
							$con_data[$step_sn]['con_value'][] = $c['value'];
							$con_data[$step_sn]['tot_qty'][0] = (isset($con_data[$step_sn]['tot_qty'][0])) ? ($con_data[$step_sn]['tot_qty'][0] + $c['qty']) : $c['qty'];
						}
	
					}

				} else {

					for($i=13;$i<=15;$i++){
						if($i != '14'){
							$con_data[$i]['table'][] = $con_tables[$i];
							$con_data[$i]['tot_qty'][] = '';
							$con_data[$i]['metal'][] = '';
							$con_data[$i]['grade'][] = '';
							$con_data[$i]['con_value'][] = '';
						}
					}

				}

	        }

	        $data['rom'] = $rom_data;
	        $data['con'] = $con_data;

	        return $data;

		}
		
		/**
		 * Prefetch the monthly records data for annual return
		 * Effective from Phase-II
		 * @version 22nd Nov 2021
		 * @author Aniket Ganvir
		 */
		public function getConRomDataMonthAll($mineCode, $returnDate, $returnType, $mineral) {
			
	        //ROM DATA FROM ROM_5 table
			$conn = ConnectionManager::get(Configure::read('conn'));
	        $rom_tables = array('10'=>'open_ore', '11'=>'rec_ore', '12'=>'treat_ore', '14'=>'tail_ore');
			$startDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
			$str = "SELECT
				SUM(tot_qty) as tot_qty,
				metal_content,
				SUM(grade) as grade,
				rom_5_step_sn
				FROM `rom_5`
				WHERE mine_code = '$mineCode'
				AND return_type = 'MONTHLY'
				AND return_date BETWEEN '$startDate' AND '$endDate'
				AND mineral_name = '$mineral'
				AND rom_5_step_sn >= 10
				GROUP BY rom_5_step_sn, metal_content";
				
			$query = $conn->execute($str)->fetchAll('assoc');
			if ($query == null) {
				
				for($i=10;$i<=14;$i++){
					if($i != '13'){
						$rom_data[$i]['table'][] = $rom_tables[$i];
						$rom_data[$i]['tot_qty'][] = '';
						$rom_data[$i]['metal'][] = '';
						$rom_data[$i]['grade'][] = '';
					}
				}

			} else {

				foreach ($query as $r) {
					$step_sn = $r['rom_5_step_sn'];
					$rom_data[$step_sn]['table'][] = $rom_tables[$step_sn];
					$rom_data[$step_sn]['tot_qty'][] = $r['tot_qty'];
					$rom_data[$step_sn]['metal'][] = $r['metal_content'];
					$rom_data[$step_sn]['grade'][] = $r['grade'];
					$rom_data[$step_sn]['tot_qty'][0] = (isset($rom_data[$step_sn]['tot_qty'][0])) ? ($rom_data[$step_sn]['tot_qty'][0] + $r['tot_qty']) : $r['tot_qty'];
				}

			}

	        //CON. ORE DATA FROM ROM_METAL_5 table
	        $con_tables = array('13'=>'con_obt', '15'=>'close_con');
			$startDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
			$str = "SELECT
				rom_5_step_sn,
				metal_name,
				SUM(grade) as grade,
				sum(qty) as qty,
				sum(`value`) as `value`
				FROM `rom_metal_5`
				WHERE mine_code = '$mineCode'
				AND return_type = 'MONTHLY'
				AND return_date BETWEEN '$startDate' AND '$endDate'
				AND mineral_name = '$mineral'
				GROUP BY rom_5_step_sn, metal_name";
				
			$conQuery = $conn->execute($str)->fetchAll('assoc');
			if ($conQuery == null) {
				
				for($i=13;$i<=15;$i++){
					if($i != '14'){
						$con_data[$i]['table'][] = $con_tables[$i];
						$con_data[$i]['tot_qty'][] = '';
						$con_data[$i]['metal'][] = '';
						$con_data[$i]['grade'][] = '';
						$con_data[$i]['con_value'][] = '';
					}
				}

			} else {

				foreach ($conQuery as $c) {
					$step_sn = $c['rom_5_step_sn'];
					if ($step_sn == 13) {
						$con_data[$step_sn]['table'][] = 'con_obt';
					} elseif ($step_sn == 15) {
						$con_data[$step_sn]['table'][] = 'close_con';
					}
					$con_data[$step_sn]['tot_qty'][] = $c['qty'];
					$con_data[$step_sn]['metal'][] = $c['metal_name'];
					$con_data[$step_sn]['grade'][] = $c['grade'];
					$con_data[$step_sn]['con_value'][] = $c['value'];
					$con_data[$step_sn]['tot_qty'][0] = (isset($con_data[$step_sn]['tot_qty'][0])) ? ($con_data[$step_sn]['tot_qty'][0] + $c['qty']) : $c['qty'];
				}

			}

	        $data['rom'] = $rom_data;
	        $data['con'] = $con_data;

	        return $data;

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
	        //first check ROM_5 records

	        $rom5 = TableRegistry::getTableLocator()->get('Rom5');
	        $rom_query = $rom5->find('all')
	                ->select(['tot_qty', 'metal_content', 'grade'])
	                ->where(['mine_code'=>$mineCode])
	                ->where(['return_type'=>$returnType])
	                ->where(['return_date'=>$returnDate])
	                ->where(['mineral_name'=>$mineral])
	                ->where(['rom_5_step_sn IN'=>['10', '11', '12', '14']])
	                ->toArray();

	        if (count($rom_query) == 0){
	            return 1;
	        }

	        foreach ($rom_query as $r) {
	            if ($r['tot_qty'] == "" || $r['metal_content'] == "") {
	                return 1;
	            }
	        }

	        //check ROM_5_METAL
	        $metal_query = $this->find('all')
	                ->select(['qty', 'metal_name', 'grade'])
	                ->where(['mine_code'=>$mineCode])
	                ->where(['return_type'=>$returnType])
	                ->where(['return_date'=>$returnDate])
	                ->where(['mineral_name'=>$mineral])
	                ->toArray();

	        if (count($metal_query) == 0){
	            return 1;
	        }

			// foreach ($metal_query as $m) {
			//  if ($m['QTY'] == "" || $m['METAL_NAME'] == "" || $m['GRADE'] == 0) {
			//    return 1;
			//  }
			// }

	        return 0;
	    }

		
		public function getConPrintDetails($mineCode, $returnDate, $returnType, $mineral) {

			//ROM DATA FROM ROM_5 table
			$romFive = TableRegistry::getTableLocator()->get('Rom5');
			$rom = $romFive->find()
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>$returnType])
					->where(['mineral_name'=>$mineral])
					->where(['rom_5_step_sn >='=>'10'])
					->order(['id'=>'ASC'])
					->toArray();
	
			$rom_tables = array('open_ore', 'rec_ore', 'treat_ore');
	
			$rom_data = array();
			$prev_table = "";
			$cur_table = "";
			$m_count = 0;
			$i = 0;
			foreach ($rom as $r) {
				$step_sn = $r['rom_5_step_sn'] - 10;
	
				if ($r['rom_5_step_sn'] == 14) {
					$tbl = 'tail_ore';
				} else {
					$tbl = $rom_tables[$step_sn];
				}
	
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
	
				$rom_data[$tbl]['tot_qty'] = $r['tot_qty'];
				$rom_data[$tbl]['table'][$m_count]['metal'] = $r['metal_content'];
				$rom_data[$tbl]['table'][$m_count]['grade'] = $r['grade'];
	
				$i++;
			}
	
	
			$prev_con_table = "";
			$cur_con_table = "";
			$con_count = 0;
			//CON. ORE DATA FROM ROM_METAL_5 table
			$con = $this->find()
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>$returnType])
					->where(['mineral_name'=>$mineral])
					->order(['id'=>'ASC'])
					->toArray();
	
			$con_data = array();
			$j = 0;
			foreach ($con as $c) {
				$step_sn = $c['rom_5_step_sn'];
				if ($step_sn == 13)
					$con_table = 'con_obt';
				else if ($step_sn == 15)
					$con_table = 'close_con';
	
				if ($prev_con_table == "")
					$prev_con_table = $tbl;
	
				$cur_con_table = $tbl;
	
				if ($cur_con_table != $prev_con_table) {
					$prev_con_table = $cur_con_table;
					$con_count = 0;
				} else {
					if ($j != 0)
						$con_count++;
				}
	
				$con_data[$con_table][$con_count]['tot_qty'] = $c['qty'];
				$con_data[$con_table][$con_count]['metal'] = $c['metal_name'];
				$con_data[$con_table][$con_count]['grade'] = $c['grade'];
				$con_data[$con_table][$con_count]['con_value'] = $c['value'];
	
				$j++;
			}
	
			$data['rom'] = $rom_data;
			$data['con'] = $con_data;
	
			return $data;
		}

	}

?>