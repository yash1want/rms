<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use App\Controller\MonthlyController;
	use Cake\ORM\Locator\LocatorAwareTrait;
    use Cake\Datasource\ConnectionManager;
	
	class Sale5Table extends Table{
		
		public function initialize(array $config): void
		{
			$this->setTable('sale_5');
		}
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		/**
		* Returns the SALES details
		* @param type $mineCode
		* @param type $returnDate
		* @param type $returnType
		* @param type $mineral
		* @return type 
		*/
		public function getSalesData($mineCode, $returnDate, $returnType, $mineral, $pdfStatus = 0) {

			//ROM DATA FROM ROM_5 table
			$rom = $this->find('all')
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>$returnType])
				->where(['mineral_name'=>$mineral])
				->where(['sale_5_step_sn <='=>4])
				->order(['id'=>'ASC'])
				->toArray();

			if (count($rom) == 0 && $returnType == 'ANNUAL' && $pdfStatus == 0) {

				/**
				 * Prefetch the monthly records data for annual returns
				 * Effective from Phase - II
				 * @version 17th Nov 2021
				 * @author Aniket Ganvir
				 */
				$conn = ConnectionManager::get(Configure::read('conn'));
				$startDate = (date('Y',strtotime($returnDate))).'-04-01';
				$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
				$str = "SELECT
					sale_5_step_sn,
					metal_content,
					sum(qty) as qty,
					sum(grade) as grade,
					place_of_sale,
					sum(product_value) as product_value
					FROM `sale_5`
					WHERE mine_code = '$mineCode'
					AND return_type = 'MONTHLY'
					AND return_date BETWEEN '$startDate' AND '$endDate'
					AND mineral_name = '$mineral'
					AND sale_5_step_sn <= 4
					GROUP BY metal_content, sale_5_step_sn
					ORDER BY id ASC";
					
				$rom = $conn->execute($str)->fetchAll('assoc');

			}

			$dirProduct = TableRegistry::getTableLocator()->get('DirProduct');
			$rom_data = array();
			$i = 0;
			foreach ($rom as $r) {
				$check[$i]['sale_dir'] = $r['sale_5_step_sn'];
				$rom_data[$i]['unit'] = $dirProduct->getUnit($r['metal_content']);

				if ($check[$i]['sale_dir'] == 1) {
					$rom_data[$i]['table_name'] = 'open_stock';
					$rom_data[$i]['open_tot_qty'] = $r['qty'];
					$rom_data[$i]['open_metal'] = $r['metal_content'];
					$rom_data[$i]['open_grade'] = $r['grade'];
				} else if ($check[$i]['sale_dir'] == 2) {
					$rom_data[$i]['table_name'] = 'sale_place';
					$rom_data[$i]['sale_place'] = $r['place_of_sale'];
				} else if ($check[$i]['sale_dir'] == 3) {
					$rom_data[$i]['table_name'] = 'prod_sold';
					$rom_data[$i]['prod_tot_qty'] = $r['qty'];
					$rom_data[$i]['prod_grade'] = $r['grade'];
					$rom_data[$i]['prod_product_value'] = $r['product_value'];
				} else if ($check[$i]['sale_dir'] == 4) {
					$rom_data[$i]['table_name'] = 'close_stock';
					$rom_data[$i]['close_tot_qty'] = $r['qty'];
					//$rom_data[$i]['close_product_value'] = $r['PRODUCT_VALUE']; CHAANGES MADE AS PER THE DISCUSSION ON 14TH Aug 2013 with Amod Sir -- Uday Shankar Singh
					$rom_data[$i]['close_product_value'] = $r['grade'];
				}
				$i++;
			}

			if(count($rom) == 0){

				$rom_data[0]['table_name'] = 'open_stock';
				$rom_data[0]['open_tot_qty'] = '';
				$rom_data[0]['open_metal'] = '';
				$rom_data[0]['open_grade'] = '';

				$rom_data[1]['table_name'] = 'sale_place';
				$rom_data[1]['sale_place'] = '';

				$rom_data[2]['table_name'] = 'prod_sold';
				$rom_data[2]['prod_tot_qty'] = '';
				$rom_data[2]['prod_grade'] = '';
				$rom_data[2]['prod_product_value'] = '';

				$rom_data[3]['table_name'] = 'close_stock';
				$rom_data[3]['close_tot_qty'] = '';
				//$rom_data[$i]['close_product_value'] = $r['PRODUCT_VALUE']; CHAANGES MADE AS PER THE DISCUSSION ON 14TH Aug 2013 with Amod Sir -- Uday Shankar Singh
				$rom_data[3]['close_product_value'] = '';

			}

			return $rom_data;

		}

		
		/**
		 * Prefetch the monthly records data for annual returns
		 * Effective from Phase - II
		 * @version 24th Nov 2021
		 * @author Aniket Ganvir
		 */
		public function getSalesDataMonthAll($mineCode, $returnDate, $returnType, $mineral) {

			//ROM DATA FROM ROM_5 table
			$conn = ConnectionManager::get(Configure::read('conn'));
			$startDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
			$str = "SELECT
				sale_5_step_sn,
				metal_content,
				sum(qty) as qty,
				sum(grade) as grade,
				place_of_sale,
				sum(product_value) as product_value
				FROM `sale_5`
				WHERE mine_code = '$mineCode'
				AND return_type = 'MONTHLY'
				AND return_date BETWEEN '$startDate' AND '$endDate'
				AND mineral_name = '$mineral'
				AND sale_5_step_sn <= 4
				GROUP BY metal_content, sale_5_step_sn
				ORDER BY id ASC";
				
			$rom = $conn->execute($str)->fetchAll('assoc');

			$dirProduct = TableRegistry::getTableLocator()->get('DirProduct');
			$rom_data = array();
			$i = 0;
			foreach ($rom as $r) {
				$check[$i]['sale_dir'] = $r['sale_5_step_sn'];
				$rom_data[$i]['unit'] = $dirProduct->getUnit($r['metal_content']);

				if ($check[$i]['sale_dir'] == 1) {
					$rom_data[$i]['table_name'] = 'open_stock';
					$rom_data[$i]['open_tot_qty'] = $r['qty'];
					$rom_data[$i]['open_metal'] = $r['metal_content'];
					$rom_data[$i]['open_grade'] = $r['grade'];
				} else if ($check[$i]['sale_dir'] == 2) {
					$rom_data[$i]['table_name'] = 'sale_place';
					$rom_data[$i]['sale_place'] = $r['place_of_sale'];
				} else if ($check[$i]['sale_dir'] == 3) {
					$rom_data[$i]['table_name'] = 'prod_sold';
					$rom_data[$i]['prod_tot_qty'] = $r['qty'];
					$rom_data[$i]['prod_grade'] = $r['grade'];
					$rom_data[$i]['prod_product_value'] = $r['product_value'];
				} else if ($check[$i]['sale_dir'] == 4) {
					$rom_data[$i]['table_name'] = 'close_stock';
					$rom_data[$i]['close_tot_qty'] = $r['qty'];
					//$rom_data[$i]['close_product_value'] = $r['PRODUCT_VALUE']; CHAANGES MADE AS PER THE DISCUSSION ON 14TH Aug 2013 with Amod Sir -- Uday Shankar Singh
					$rom_data[$i]['close_product_value'] = $r['grade'];
				}
				$i++;
			}

			if(count($rom) == 0){

				$rom_data[0]['table_name'] = 'open_stock';
				$rom_data[0]['open_tot_qty'] = '';
				$rom_data[0]['open_metal'] = '';
				$rom_data[0]['open_grade'] = '';

				$rom_data[1]['table_name'] = 'sale_place';
				$rom_data[1]['sale_place'] = '';

				$rom_data[2]['table_name'] = 'prod_sold';
				$rom_data[2]['prod_tot_qty'] = '';
				$rom_data[2]['prod_grade'] = '';
				$rom_data[2]['prod_product_value'] = '';

				$rom_data[3]['table_name'] = 'close_stock';
				$rom_data[3]['close_tot_qty'] = '';
				//$rom_data[$i]['close_product_value'] = $r['PRODUCT_VALUE']; CHAANGES MADE AS PER THE DISCUSSION ON 14TH Aug 2013 with Amod Sir -- Uday Shankar Singh
				$rom_data[3]['close_product_value'] = '';

			}

			return $rom_data;

		}

		// save or update form data
	    public function saveFormDetails($params){

			$dataValidatation = $this->postDataValidation($params);

			if($dataValidatation == 1 ){

	            $mineCode = $params['mine_code'];
	        	$returnType = $params['return_type'];
	        	$returnDate = $params['return_date'];
	        	$mineralName = $params['mineral_name'];

				// if editing or record already exsists then first delete it and then enter the data again
	        	$deleteRecord = $this->query()
	        		->delete()
	        		->where(['mine_code'=>$mineCode, 'return_date'=>$returnDate, 'return_type'=>$returnType, 'mineral_name'=>$mineralName])
	        		->execute();

				$result = '1';

				$rom_metal_counts = $params['month_sale_count'];

				for ($i = 0; $i < $rom_metal_counts; $i++) {

					for ($j = 0; $j < 4; $j++) {
						$step_sn = $j + 1;

						$count = $i + 1;

						$tmp_tbl_metal = 'open_stock_metal_' . $count;
						$metal_content = $params[$tmp_tbl_metal];

						if ($j == 0) {

							$tmp_tbl_qty = "open_stock_qty_" . $count;
							$tmp_tbl_grade = "open_stock_grade_" . $count;

							$qty = $params[$tmp_tbl_qty];
							$grade = $params[$tmp_tbl_grade];
							$place_of_sale = null;
							$product_value = null;

						} else if ($j == 1) {

							$tmp_tbl_value = 'sale_place_value_' . $count;
							$qty = null;
							$grade = null;
							$place_of_sale = $params[$tmp_tbl_value];
							$product_value = null;

						} else if ($j == 2) {

							$tmp_tbl_qty = "prod_sold_qty_" . $count;
							$tmp_tbl_grade = "prod_sold_grade_" . $count;
							$tmp_tbl_value = "prod_sold_value_" . $count;

							$qty = $params[$tmp_tbl_qty];
							$grade = $params[$tmp_tbl_grade];
							$place_of_sale = null;
							$product_value = $params[$tmp_tbl_value];

						} else if ($j == 3) {

							$tmp_tbl_qty = "close_stock_qty_" . $count;
							$tmp_tbl_value = 'close_stock_grade_' . $count;

							$qty = $params[$tmp_tbl_qty];
							//$rom->PRODUCT_VALUE = $params[$tmp_tbl_value]; CHAANGES MADE AS PER THE DISCUSSION ON 14TH Aug 2013 with Amod Sir -- Uday Shankar Singh
							$grade = ($params[$tmp_tbl_value] != '') ? $params[$tmp_tbl_value] : 0;
							$place_of_sale = null;
							$product_value = null;

						}

						$newEntity = $this->newEntity(array(
							'mine_code'=>$mineCode,
							'return_type'=>$returnType,
							'return_date'=>$returnDate,
							'mineral_name'=>$mineralName,
							'sale_5_step_sn'=>$step_sn,
							'product_sn'=>0,
							'metal_content'=>$metal_content,
							'qty'=>$qty,
							'grade'=>$grade,
							'place_of_sale'=>$place_of_sale,
							'product_value'=>$product_value,
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
			
			$rom_metal_counts = $params['month_sale_count'];

			for ($i = 0; $i < $rom_metal_counts; $i++) {

				for ($j = 0; $j < 4; $j++) {
					$step_sn = $j + 1;

					$count = $i + 1;

					$tmp_tbl_metal = 'open_stock_metal_' . $count;
					$metal_content = $params[$tmp_tbl_metal];
					if(empty($metal_content)){ $returnValue = null ; }

					if ($j == 0) {

						$tmp_tbl_qty = "open_stock_qty_" . $count;
						$tmp_tbl_grade = "open_stock_grade_" . $count;

						$qty = $params[$tmp_tbl_qty];
						$grade = $params[$tmp_tbl_grade];

						if($qty == ''){ $returnValue = null ; }
						if($grade == ''){ $returnValue = null ; }

						if(!is_numeric($qty) && !is_float($qty)){ $returnValue = null ; }
						if(!is_numeric($grade) && !is_float($grade)){ $returnValue = null ; }

					} else if ($j == 1) {

						$tmp_tbl_value = 'sale_place_value_' . $count;
						$place_of_sale = $params[$tmp_tbl_value];

						if($place_of_sale == ''){ $returnValue = null ; }

					} else if ($j == 2) {

						$tmp_tbl_qty = "prod_sold_qty_" . $count;
						$tmp_tbl_grade = "prod_sold_grade_" . $count;
						$tmp_tbl_value = "prod_sold_value_" . $count;

						$qty = $params[$tmp_tbl_qty];
						$grade = $params[$tmp_tbl_grade];
						$product_value = $params[$tmp_tbl_value];

						if($qty == ''){ $returnValue = null ; }
						if($grade == ''){ $returnValue = null ; }
						if($product_value == ''){ $returnValue = null ; }

						if(!is_numeric($qty) && !is_float($qty)){ $returnValue = null ; }
						if(!is_numeric($grade) && !is_float($grade)){ $returnValue = null ; }
						if(!is_numeric($product_value) && !is_float($product_value)){ $returnValue = null ; }

					} else if ($j == 3) {

						$tmp_tbl_qty = "close_stock_qty_" . $count;
						// $tmp_tbl_value = 'close_stock_grade_' . $count;

						$qty = $params[$tmp_tbl_qty];
						// $grade = $params[$tmp_tbl_value];

						if($qty == ''){ $returnValue = null ; }
						// if($grade == ''){ $returnValue = null ; }

						if(!is_numeric($qty) && !is_float($qty)){ $returnValue = null ; }
						// if(!is_numeric($grade) && !is_float($grade)){ $returnValue = null ; }

					}

				}
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
				->select(['sale_5_step_sn'])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>$returnType])
				->where(['return_date'=>$returnDate])
				->where(['mineral_name'=>$mineral])
				->toArray();

			if (count($query) == 0){
				return 1;
			}

			foreach ($query as $r) {
				if ($r['sale_5_step_sn'] == "") {
					return 1;
				}
			}

			return 0;

		}

		
		public function getSalesPrintData($mineCode, $returnDate, $returnType, $mineral) {

			//ROM DATA FROM ROM_5 table
			$sales = $this->find()
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>$returnType])
					->where(['mineral_name'=>$mineral])
					->where(['sale_5_step_sn <='=>'4'])
					->order(['id'=>'ASC'])
					->toArray();
		
			//echo "<pre>"; print_r($sales); exit;
			$sales_data = array();
			$prev_metal = "";
			$current_metal = "";
			$m_count = 0;
			foreach ($sales as $s) {
				if ($prev_metal == "")
				$prev_metal = $s['metal_content'];
		
				$current_metal = $s['metal_content'];
		
				if ($current_metal != $prev_metal) {
					$prev_metal = $current_metal;
					$m_count++;
				}
		
				$step_sn = $s['sale_5_step_sn'];
				switch ($step_sn) {
					case 1:
						$sales_data[$m_count]['open_metal'] = $s['metal_content'];
						$sales_data[$m_count]['open_tot_qty'] = $s['qty'];
						$sales_data[$m_count]['open_grade'] = $s['grade'];
					case 2:
						$sales_data[$m_count]['sale_place'] = $s['place_of_sale'];
					case 3:
						$sales_data[$m_count]['prod_tot_qty'] = $s['qty'];
						$sales_data[$m_count]['prod_grade'] = $s['grade'];
						$sales_data[$m_count]['prod_value'] = $s['product_value'];
					case 4:
						$sales_data[$m_count]['close_tot_qty'] = $s['qty'];
						//solved the issues grade value not show in the sales douring the month section. added by ganesh satav dated on 26th Feb 2014
						$sales_data[$m_count]['close_product_value'] = $s['grade'];
				}
			}
		
			return $sales_data;

		}

	}

?>