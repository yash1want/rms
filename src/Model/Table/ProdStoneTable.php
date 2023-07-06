<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
    use Cake\Datasource\ConnectionManager;
	
	class ProdStoneTable extends Table{

		var $name = "ProdStone";			
		public $validate = array();
		
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
	    public function isFilled($mineCode, $returnDate, $returnType) {

	        $query = $this->find('all')
	                ->select(['open_tot_no'])
	                ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate])
	                ->toArray();

	        if (count($query) == 0)
	            return 1;

	        foreach ($query as $s) {
	            if ($s['open_tot_no'] == "")
	                return 1;
	        }

	        return 0;
	    }
		
		/**
		* RETURN PROD STONE DATA AS PER $stone
		*/
		public function getProdStoneData($mineCode, $returnDate, $mineral, $stone, $returnType, $pdfStatus = 0) {

			$result = $this->find('all')
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>$returnType])
					->where(['mineral_name'=>$mineral])
					->where(['stone_sn'=>$stone])
					->toArray();

			$count = count($result);

			if (count($result) == 0 && $returnType == 'ANNUAL' && $pdfStatus == 0) {

				/**
				 * Prefetch the cumulative monthly records data for annual return
				 * Effective from Phase - II
				 * @version 25th Nov 2021
				 * @author Aniket Ganvir
				 */
				$conn = ConnectionManager::get(Configure::read('conn'));
				$startDate = (date('Y',strtotime($returnDate))).'-04-01';
				$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
				$str = "SELECT
					(
						SELECT open_tot_no
						FROM `prod_stone`
						WHERE mine_code = '$mineCode'
						AND return_type = 'MONTHLY'
						AND return_date BETWEEN '$startDate' AND '$endDate'
						AND mineral_name = 'CORUNDUM'
						AND stone_sn = '$stone'
						ORDER BY return_date ASC
						LIMIT 1
					) open_tot_no,
					(
						SELECT open_tot_qty
						FROM `prod_stone`
						WHERE mine_code = '$mineCode'
						AND return_type = 'MONTHLY'
						AND return_date BETWEEN '$startDate' AND '$endDate'
						AND mineral_name = 'CORUNDUM'
						AND stone_sn = '$stone'
						ORDER BY return_date ASC
						LIMIT 1
					) open_tot_qty,
					SUM(prod_oc_no) as prod_oc_no,
					SUM(prod_oc_qty) as prod_oc_qty,
					SUM(prod_ug_no) as prod_ug_no,
					SUM(prod_ug_qty) as prod_ug_qty,
					SUM(prod_tot_no) as prod_tot_no,
					SUM(prod_tot_qty) as prod_tot_qty,
					SUM(desp_tot_no) as desp_tot_no,
					SUM(desp_tot_qty) as desp_tot_qty,
					(
						SELECT clos_tot_no
						FROM `prod_stone`
						WHERE mine_code = '$mineCode'
						AND return_type = 'MONTHLY'
						AND return_date BETWEEN '$startDate' AND '$endDate'
						AND mineral_name = 'CORUNDUM'
						AND stone_sn = '$stone'
						ORDER BY return_date DESC
						LIMIT 1
					) clos_tot_no,
					(
						SELECT clos_tot_qty
						FROM `prod_stone`
						WHERE mine_code = '$mineCode'
						AND return_type = 'MONTHLY'
						AND return_date BETWEEN '$startDate' AND '$endDate'
						AND mineral_name = 'CORUNDUM'
						AND stone_sn = '$stone'
						ORDER BY return_date DESC
						LIMIT 1
					) clos_tot_qty,
					SUM(pmv_oc) as pmv_oc,
					SUM(pmv_ug) as pmv_ug
					FROM `prod_stone`
					WHERE mine_code = '$mineCode'
					AND return_type = 'MONTHLY'
					AND return_date BETWEEN '$startDate' AND '$endDate'
					AND mineral_name = 'CORUNDUM'
					AND stone_sn = '$stone'";
					
				$result = $conn->execute($str)->fetchAll('assoc');

			}

			if (count($result) == 0){
				$result = array();
				$result[0]['open_tot_no'] = '';
				$result[0]['open_tot_qty'] = '';
				$result[0]['prod_oc_no'] = '';
				$result[0]['prod_oc_qty'] = '';
				$result[0]['prod_ug_no'] = '';
				$result[0]['prod_ug_qty'] = '';
				$result[0]['prod_tot_no'] = '';
				$result[0]['prod_tot_qty'] = '';
				$result[0]['desp_tot_no'] = '';
				$result[0]['desp_tot_qty'] = '';
				$result[0]['clos_tot_no'] = '';
				$result[0]['clos_tot_qty'] = '';
				$result[0]['pmv_oc'] = '';
				$result[0]['pmv_ug'] = '';
			}

			$result['count'] = $count;

			return $result;

		}

		/**
		 * Prefetch the cumulative monthly records data for annual return
		 * Effective from Phase - II
		 * @version 25th Nov 2021
		 * @author Aniket Ganvir
		 */
		public function getProdStoneDataMonthAll($mineCode, $returnDate, $mineral, $stone, $returnType) {

			$conn = ConnectionManager::get(Configure::read('conn'));
			$startDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
			$str = "SELECT
				(
					SELECT open_tot_no
					FROM `prod_stone`
					WHERE mine_code = '$mineCode'
					AND return_type = 'MONTHLY'
					AND return_date BETWEEN '$startDate' AND '$endDate'
					AND mineral_name = 'CORUNDUM'
					AND stone_sn = '$stone'
					ORDER BY return_date ASC
					LIMIT 1
				) open_tot_no,
				(
					SELECT open_tot_qty
					FROM `prod_stone`
					WHERE mine_code = '$mineCode'
					AND return_type = 'MONTHLY'
					AND return_date BETWEEN '$startDate' AND '$endDate'
					AND mineral_name = 'CORUNDUM'
					AND stone_sn = '$stone'
					ORDER BY return_date ASC
					LIMIT 1
				) open_tot_qty,
				SUM(prod_oc_no) as prod_oc_no,
				SUM(prod_oc_qty) as prod_oc_qty,
				SUM(prod_ug_no) as prod_ug_no,
				SUM(prod_ug_qty) as prod_ug_qty,
				SUM(prod_tot_no) as prod_tot_no,
				SUM(prod_tot_qty) as prod_tot_qty,
				SUM(desp_tot_no) as desp_tot_no,
				SUM(desp_tot_qty) as desp_tot_qty,
				(
					SELECT clos_tot_no
					FROM `prod_stone`
					WHERE mine_code = '$mineCode'
					AND return_type = 'MONTHLY'
					AND return_date BETWEEN '$startDate' AND '$endDate'
					AND mineral_name = 'CORUNDUM'
					AND stone_sn = '$stone'
					ORDER BY return_date DESC
					LIMIT 1
				) clos_tot_no,
				(
					SELECT clos_tot_qty
					FROM `prod_stone`
					WHERE mine_code = '$mineCode'
					AND return_type = 'MONTHLY'
					AND return_date BETWEEN '$startDate' AND '$endDate'
					AND mineral_name = 'CORUNDUM'
					AND stone_sn = '$stone'
					ORDER BY return_date DESC
					LIMIT 1
				) clos_tot_qty,
				SUM(pmv_oc) as pmv_oc,
				SUM(pmv_ug) as pmv_ug
				FROM `prod_stone`
				WHERE mine_code = '$mineCode'
				AND return_type = 'MONTHLY'
				AND return_date BETWEEN '$startDate' AND '$endDate'
				AND mineral_name = 'CORUNDUM'
				AND stone_sn = '$stone'";
				
			$result = $conn->execute($str)->fetchAll('assoc');

			if (count($result) == 0){
				$result = array();
				$result[0]['open_tot_no'] = '';
				$result[0]['open_tot_qty'] = '';
				$result[0]['prod_oc_no'] = '';
				$result[0]['prod_oc_qty'] = '';
				$result[0]['prod_ug_no'] = '';
				$result[0]['prod_ug_qty'] = '';
				$result[0]['prod_tot_no'] = '';
				$result[0]['prod_tot_qty'] = '';
				$result[0]['desp_tot_no'] = '';
				$result[0]['desp_tot_qty'] = '';
				$result[0]['clos_tot_no'] = '';
				$result[0]['clos_tot_qty'] = '';
				$result[0]['pmv_oc'] = '';
				$result[0]['pmv_ug'] = '';
			}

			return $result;

		}
		
		// save or update form data
	    public function saveFormDetails($params){

			$dataValidatation = $this->postDataValidation($params);

			if($dataValidatation == 1 ){

	            $mineCode = $params['mine_code'];
	        	$returnType = $params['return_type'];
	        	$returnDate = $params['return_date'];
	        	$mineralName = $params['mineral_name'];

				$result = '1';
				
				for ($i = 0; $i < 4; $i++) {

					if ($i == 0) {
						
						$data = $this->find('all')->where(['mine_code'=>$mineCode, 'return_type'=>$returnType, 'return_date'=>$returnDate, 'mineral_name'=>$mineralName, 'stone_sn'=>1])->toArray();
						if(count($data) > 0){
							$row_id = $data[0]['id'];
							$created_at = $data[0]['created_at'];
						} else {
							$row_id = '';
							$created_at = date('Y-m-d H:i:s');
						}

						$newEntity = $this->newEntity(array(
							'id'=>$row_id,
							'mine_code'=>$mineCode,
							'return_type'=>$returnType,
							'return_date'=>$returnDate,
							'mineral_name'=>$mineralName,
							'stone_sn'=>1,
							'open_tot_no'=>$params['f_rough_open_tot_no'],
							'open_tot_qty'=>$params['f_rough_open_tot_qty'],
							'prod_oc_no'=>$params['f_rough_prod_oc_no'],
							'prod_oc_qty'=>$params['f_rough_prod_oc_qty'],
							'prod_ug_no'=>$params['f_rough_prod_ug_no'],
							'prod_ug_qty'=>$params['f_rough_prod_ug_qty'],
							'prod_tot_no'=>$params['f_rough_prod_tot_no'],
							'prod_tot_qty'=>$params['f_rough_prod_tot_qty'],
							'desp_tot_no'=>$params['f_rough_desp_tot_no'],
							'desp_tot_qty'=>$params['f_rough_desp_tot_qty'],
							'clos_tot_no'=>$params['f_rough_clos_tot_no'],
							'clos_tot_qty'=>$params['f_rough_clos_tot_qty'],
							'pmv_oc'=>$params['f_rough_pmv_oc'],
							'created_at'=>$created_at,
							'updated_at'=>date('Y-m-d H:i:s')
						));
						
						if($this->save($newEntity)){
							//
						} else {
							$result = false;
						}

					}

					if ($i == 1) {
						
						$data = $this->find('all')->where(['mine_code'=>$mineCode, 'return_type'=>$returnType, 'return_date'=>$returnDate, 'mineral_name'=>$mineralName, 'stone_sn'=>2])->toArray();
						if(count($data) > 0){
							$row_id = $data[0]['id'];
							$created_at = $data[0]['created_at'];
						} else {
							$row_id = '';
							$created_at = date('Y-m-d H:i:s');
						}

						$newEntity = $this->newEntity(array(
							'id'=>$row_id,
							'mine_code'=>$mineCode,
							'return_type'=>$returnType,
							'return_date'=>$returnDate,
							'mineral_name'=>$mineralName,
							'stone_sn'=>2,
							'open_tot_no'=>$params['f_polished_open_tot_no'],
							'open_tot_qty'=>$params['f_polished_open_tot_qty'],
							'prod_oc_no'=>$params['f_polished_prod_oc_no'],
							'prod_oc_qty'=>$params['f_polished_prod_oc_qty'],
							'prod_ug_no'=>$params['f_polished_prod_ug_no'],
							'prod_ug_qty'=>$params['f_polished_prod_ug_qty'],
							'prod_tot_no'=>$params['f_polished_prod_tot_no'],
							'prod_tot_qty'=>$params['f_polished_prod_tot_qty'],
							'desp_tot_no'=>$params['f_polished_desp_tot_no'],
							'desp_tot_qty'=>$params['f_polished_desp_tot_qty'],
							'clos_tot_no'=>$params['f_polished_clos_tot_no'],
							'clos_tot_qty'=>$params['f_polished_clos_tot_qty'],
							'pmv_oc'=>$params['f_polished_pmv_oc'],
							'created_at'=>$created_at,
							'updated_at'=>date('Y-m-d H:i:s')
						));

						if($this->save($newEntity)){
							//
						} else {
							$result = false;
						}
						
					}

					if ($i == 2) {
						
						$data = $this->find('all')->where(['mine_code'=>$mineCode, 'return_type'=>$returnType, 'return_date'=>$returnDate, 'mineral_name'=>$mineralName, 'stone_sn'=>3])->toArray();
						if(count($data) > 0){
							$row_id = $data[0]['id'];
							$created_at = $data[0]['created_at'];
						} else {
							$row_id = '';
							$created_at = date('Y-m-d H:i:s');
						}

						$newEntity = $this->newEntity(array(
							'id'=>$row_id,
							'mine_code'=>$mineCode,
							'return_type'=>$returnType,
							'return_date'=>$returnDate,
							'mineral_name'=>$mineralName,
							'stone_sn'=>3,
							'open_tot_no'=> $params['f_industrial_open_tot_no'],
							'open_tot_qty'=> $params['f_industrial_open_tot_qty'],
							'prod_oc_no'=> $params['f_industrial_prod_oc_no'],
							'prod_oc_qty'=> $params['f_industrial_prod_oc_qty'],
							'prod_ug_no'=> $params['f_industrial_prod_ug_no'],
							'prod_ug_qty'=> $params['f_industrial_prod_ug_qty'],
							'prod_tot_no'=> $params['f_industrial_prod_tot_no'],
							'prod_tot_qty'=> $params['f_industrial_prod_tot_qty'],
							'desp_tot_no'=> $params['f_industrial_desp_tot_no'],
							'desp_tot_qty'=> $params['f_industrial_desp_tot_qty'],
							'clos_tot_no'=> $params['f_industrial_clos_tot_no'],
							'clos_tot_qty'=> $params['f_industrial_clos_tot_qty'],
							'pmv_oc'=> $params['f_industrial_pmv_oc'],
							'created_at'=>$created_at,
							'updated_at'=>date('Y-m-d H:i:s')
						));
						
						if($this->save($newEntity)){
							//
						} else {
							$result = false;
						}

					}

					if ($i == 3) {
						
						$data = $this->find('all')->where(['mine_code'=>$mineCode, 'return_type'=>$returnType, 'return_date'=>$returnDate, 'mineral_name'=>$mineralName, 'stone_sn'=>99])->toArray();
						if(count($data) > 0){
							$row_id = $data[0]['id'];
							$created_at = $data[0]['created_at'];
						} else {
							$row_id = '';
							$created_at = date('Y-m-d H:i:s');
						}

						$newEntity = $this->newEntity(array(
							'id'=>$row_id,
							'mine_code'=>$mineCode,
							'return_type'=>$returnType,
							'return_date'=>$returnDate,
							'mineral_name'=>$mineralName,
							'stone_sn'=>99,
							'open_tot_no'=>$params['f_other_open_tot_no'],
							'open_tot_qty'=>$params['f_other_open_tot_qty'],
							'prod_oc_no'=>$params['f_other_prod_oc_no'],
							'prod_oc_qty'=>$params['f_other_prod_oc_qty'],
							'prod_ug_no'=>$params['f_other_prod_ug_no'],
							'prod_ug_qty'=>$params['f_other_prod_ug_qty'],
							'prod_tot_no'=>$params['f_other_prod_tot_no'],
							'prod_tot_qty'=>$params['f_other_prod_tot_qty'],
							'desp_tot_no'=>$params['f_other_desp_tot_no'],
							'desp_tot_qty'=>$params['f_other_desp_tot_qty'],
							'clos_tot_no'=>$params['f_other_clos_tot_no'],
							'clos_tot_qty'=>$params['f_other_clos_tot_qty'],
							'pmv_oc'=>$params['f_other_pmv_oc'],
							'created_at'=>$created_at,
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

			//opening stock
			if($params['f_rough_open_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_rough_open_tot_qty'] == ''){ $returnValue = null ; }
			if($params['f_polished_open_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_polished_open_tot_qty'] == ''){ $returnValue = null ; }
			if($params['f_industrial_open_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_industrial_open_tot_qty'] == ''){ $returnValue = null ; }
			if($params['f_other_open_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_other_open_tot_qty'] == ''){ $returnValue = null ; }

			if(!is_numeric($params['f_rough_open_tot_no']) && !is_float($params['f_rough_open_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_rough_open_tot_qty']) && !is_float($params['f_rough_open_tot_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_polished_open_tot_no']) && !is_float($params['f_polished_open_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_polished_open_tot_qty']) && !is_float($params['f_polished_open_tot_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_industrial_open_tot_no']) && !is_float($params['f_industrial_open_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_industrial_open_tot_qty']) && !is_float($params['f_industrial_open_tot_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_other_open_tot_no']) && !is_float($params['f_other_open_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_other_open_tot_qty']) && !is_float($params['f_other_open_tot_qty'])){ $returnValue = null ; }

			if(strlen($params['f_rough_open_tot_no']) > 7){ $returnValue = null ; }
			if(strlen($params['f_polished_open_tot_no']) > 7){ $returnValue = null ; }
			if(strlen($params['f_industrial_open_tot_no']) > 7){ $returnValue = null ; }
			if(strlen($params['f_other_open_tot_no']) > 7){ $returnValue = null ; }
			if(strlen( number_format($params['f_rough_open_tot_qty'], 3, '.', "") ) > 16){ $returnValue = null ; }
			if(strlen( number_format($params['f_polished_open_tot_qty'], 3, '.', "") ) > 16){ $returnValue = null ; }
			if(strlen( number_format($params['f_industrial_open_tot_qty'], 3, '.', "") ) > 16){ $returnValue = null ; }
			if(strlen( number_format($params['f_other_open_tot_qty'], 3, '.', "") ) > 16){ $returnValue = null ; }
			
			//production (opencast working)
			if($params['f_rough_prod_oc_no'] == ''){ $returnValue = null ; }
			if($params['f_rough_prod_oc_qty'] == ''){ $returnValue = null ; }
			if($params['f_polished_prod_oc_no'] == ''){ $returnValue = null ; }
			if($params['f_polished_prod_oc_qty'] == ''){ $returnValue = null ; }
			if($params['f_industrial_prod_oc_no'] == ''){ $returnValue = null ; }
			if($params['f_industrial_prod_oc_qty'] == ''){ $returnValue = null ; }
			if($params['f_other_prod_oc_no'] == ''){ $returnValue = null ; }
			if($params['f_other_prod_oc_qty'] == ''){ $returnValue = null ; }

			if(!is_numeric($params['f_rough_prod_oc_no']) && !is_float($params['f_rough_prod_oc_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_rough_prod_oc_qty']) && !is_float($params['f_rough_prod_oc_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_polished_prod_oc_no']) && !is_float($params['f_polished_prod_oc_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_polished_prod_oc_qty']) && !is_float($params['f_polished_prod_oc_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_industrial_prod_oc_no']) && !is_float($params['f_industrial_prod_oc_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_industrial_prod_oc_qty']) && !is_float($params['f_industrial_prod_oc_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_other_prod_oc_no']) && !is_float($params['f_other_prod_oc_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_other_prod_oc_qty']) && !is_float($params['f_other_prod_oc_qty'])){ $returnValue = null ; }

			if(strlen($params['f_rough_prod_oc_no']) > 7){ $returnValue = null ; }
			if(strlen($params['f_polished_prod_oc_no']) > 7){ $returnValue = null ; }
			if(strlen($params['f_industrial_prod_oc_no']) > 7){ $returnValue = null ; }
			if(strlen($params['f_other_prod_oc_no']) > 7){ $returnValue = null ; }
			if(strlen( number_format($params['f_rough_prod_oc_qty'], 3, '.', "") ) > 16){ $returnValue = null ; }
			if(strlen( number_format($params['f_polished_prod_oc_qty'], 3, '.', "") ) > 16){ $returnValue = null ; }
			if(strlen( number_format($params['f_industrial_prod_oc_qty'], 3, '.', "") ) > 16){ $returnValue = null ; }
			if(strlen( number_format($params['f_other_prod_oc_qty'], 3, '.', "") ) > 16){ $returnValue = null ; }

			//production (underground working)
			if($params['f_rough_prod_ug_no'] == ''){ $returnValue = null ; }
			if($params['f_rough_prod_ug_qty'] == ''){ $returnValue = null ; }
			if($params['f_polished_prod_ug_no'] == ''){ $returnValue = null ; }
			if($params['f_polished_prod_ug_qty'] == ''){ $returnValue = null ; }
			if($params['f_industrial_prod_ug_no'] == ''){ $returnValue = null ; }
			if($params['f_industrial_prod_ug_qty'] == ''){ $returnValue = null ; }
			if($params['f_other_prod_ug_no'] == ''){ $returnValue = null ; }
			if($params['f_other_prod_ug_qty'] == ''){ $returnValue = null ; }

			if(!is_numeric($params['f_rough_prod_ug_no']) && !is_float($params['f_rough_prod_ug_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_rough_prod_ug_qty']) && !is_float($params['f_rough_prod_ug_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_polished_prod_ug_no']) && !is_float($params['f_polished_prod_ug_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_polished_prod_ug_qty']) && !is_float($params['f_polished_prod_ug_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_industrial_prod_ug_no']) && !is_float($params['f_industrial_prod_ug_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_industrial_prod_ug_qty']) && !is_float($params['f_industrial_prod_ug_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_other_prod_ug_no']) && !is_float($params['f_other_prod_ug_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_other_prod_ug_qty']) && !is_float($params['f_other_prod_ug_qty'])){ $returnValue = null ; }
			
			if(strlen($params['f_rough_prod_ug_no']) > 7){ $returnValue = null ; }
			if(strlen($params['f_polished_prod_ug_no']) > 7){ $returnValue = null ; }
			if(strlen($params['f_industrial_prod_ug_no']) > 7){ $returnValue = null ; }
			if(strlen($params['f_other_prod_ug_no']) > 7){ $returnValue = null ; }
			if(strlen( number_format($params['f_rough_prod_ug_qty'], 3, '.', "") ) > 16){ $returnValue = null ; }
			if(strlen( number_format($params['f_polished_prod_ug_qty'], 3, '.', "") ) > 16){ $returnValue = null ; }
			if(strlen( number_format($params['f_industrial_prod_ug_qty'], 3, '.', "") ) > 16){ $returnValue = null ; }
			if(strlen( number_format($params['f_other_prod_ug_qty'], 3, '.', "") ) > 16){ $returnValue = null ; }
			
			//total production
			if($params['f_rough_prod_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_rough_prod_tot_qty'] == ''){ $returnValue = null ; }
			if($params['f_polished_prod_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_polished_prod_tot_qty'] == ''){ $returnValue = null ; }
			if($params['f_industrial_prod_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_industrial_prod_tot_qty'] == ''){ $returnValue = null ; }
			if($params['f_other_prod_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_other_prod_tot_qty'] == ''){ $returnValue = null ; }

			if(!is_numeric($params['f_rough_prod_tot_no']) && !is_float($params['f_rough_prod_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_rough_prod_tot_qty']) && !is_float($params['f_rough_prod_tot_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_polished_prod_tot_no']) && !is_float($params['f_polished_prod_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_polished_prod_tot_qty']) && !is_float($params['f_polished_prod_tot_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_industrial_prod_tot_no']) && !is_float($params['f_industrial_prod_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_industrial_prod_tot_qty']) && !is_float($params['f_industrial_prod_tot_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_other_prod_tot_no']) && !is_float($params['f_other_prod_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_other_prod_tot_qty']) && !is_float($params['f_other_prod_tot_qty'])){ $returnValue = null ; }
			
			//despatches
			if($params['f_rough_desp_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_rough_desp_tot_qty'] == ''){ $returnValue = null ; }
			if($params['f_polished_desp_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_polished_desp_tot_qty'] == ''){ $returnValue = null ; }
			if($params['f_industrial_desp_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_industrial_desp_tot_qty'] == ''){ $returnValue = null ; }
			if($params['f_other_desp_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_other_desp_tot_qty'] == ''){ $returnValue = null ; }

			if(!is_numeric($params['f_rough_desp_tot_no']) && !is_float($params['f_rough_desp_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_rough_desp_tot_qty']) && !is_float($params['f_rough_desp_tot_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_polished_desp_tot_no']) && !is_float($params['f_polished_desp_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_polished_desp_tot_qty']) && !is_float($params['f_polished_desp_tot_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_industrial_desp_tot_no']) && !is_float($params['f_industrial_desp_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_industrial_desp_tot_qty']) && !is_float($params['f_industrial_desp_tot_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_other_desp_tot_no']) && !is_float($params['f_other_desp_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_other_desp_tot_qty']) && !is_float($params['f_other_desp_tot_qty'])){ $returnValue = null ; }
			
			//closing stock
			if($params['f_rough_clos_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_rough_clos_tot_qty'] == ''){ $returnValue = null ; }
			if($params['f_polished_clos_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_polished_clos_tot_qty'] == ''){ $returnValue = null ; }
			if($params['f_industrial_clos_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_industrial_clos_tot_qty'] == ''){ $returnValue = null ; }
			if($params['f_other_clos_tot_no'] == ''){ $returnValue = null ; }
			if($params['f_other_clos_tot_qty'] == ''){ $returnValue = null ; }

			if(!is_numeric($params['f_rough_clos_tot_no']) && !is_float($params['f_rough_clos_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_rough_clos_tot_qty']) && !is_float($params['f_rough_clos_tot_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_polished_clos_tot_no']) && !is_float($params['f_polished_clos_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_polished_clos_tot_qty']) && !is_float($params['f_polished_clos_tot_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_industrial_clos_tot_no']) && !is_float($params['f_industrial_clos_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_industrial_clos_tot_qty']) && !is_float($params['f_industrial_clos_tot_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_other_clos_tot_no']) && !is_float($params['f_other_clos_tot_no'])){ $returnValue = null ; }
			if(!is_numeric($params['f_other_clos_tot_qty']) && !is_float($params['f_other_clos_tot_qty'])){ $returnValue = null ; }
			
			//ex-mine price
			if($params['f_rough_pmv_oc'] == ''){ $returnValue = null ; }
			if($params['f_polished_pmv_oc'] == ''){ $returnValue = null ; }
			if($params['f_industrial_pmv_oc'] == ''){ $returnValue = null ; }
			if($params['f_other_pmv_oc'] == ''){ $returnValue = null ; }

			if(!is_numeric($params['f_rough_pmv_oc']) && !is_float($params['f_rough_pmv_oc'])){ $returnValue = null ; }
			if(!is_numeric($params['f_polished_pmv_oc']) && !is_float($params['f_polished_pmv_oc'])){ $returnValue = null ; }
			if(!is_numeric($params['f_industrial_pmv_oc']) && !is_float($params['f_industrial_pmv_oc'])){ $returnValue = null ; }
			if(!is_numeric($params['f_other_pmv_oc']) && !is_float($params['f_other_pmv_oc'])){ $returnValue = null ; }
			
			return $returnValue;
			
		}
			
		/*
		* function getProdStoneDetails
		* ---input is record details---
		* ---takes all records irrespective of stone_sn
		* ---record arrays are seperated into $data[] arrays
		* ----returns $data[] array 
		* ----by Pranav Sanvatsarkar----
		*/

		public function getProdStoneDetails($mineCode, $returnType, $returnDate, $mineral) {

			$query = $this->find()
					->where(['mine_code'=>$mineCode])
					->where(['return_type'=>$returnType])
					->where(['return_date'=>$returnDate])
					->where(['mineral_name'=>$mineral])
					->order(['stone_sn'=>'ASC'])
					->toArray();

			$data = array();
			if (count($query) > 0) {
				$data['rough'] = $query[0];
				$data['polished'] = $query[1];
				$data['industrialized'] = $query[2];
				$data['other'] = $query[3];
			}

			return $data;
			
		}

	} 
?>