<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\Datasource\ConnectionManager;
	
	class RomStoneTable extends Table{

		var $name = "RomStone";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function getRomData($mineCode, $returnType, $returnDate, $mineral, $pdfStatus = 0) {

			$result = $this->find('all')
					->where(['mine_code'=>$mineCode])
					->where(['return_type'=>$returnType])
					->where(['return_date'=>$returnDate])
					->where(['mineral_name'=>$mineral])
					->limit(1)
					->toArray();

			/**
			 * Prefetch the cumulative monthly records data for annual return
			 * Effective from Phase - II
			 * @version 25th Nov 2021
			 * @author Aniket Ganvir
			 */
			if (count($result) == 0 && $returnType == 'ANNUAL' && $pdfStatus == 0) {

				$conn = ConnectionManager::get(Configure::read('conn'));
				$startDate = (date('Y',strtotime($returnDate))).'-04-01';
				$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
				$str = "SELECT
					rs.rom_type_sn,
					rs.oc_type,
					rs.ug_type,
					SUM(rs.oc_qty) as oc_qty,
					SUM(rs.ug_qty) as ug_qty
					FROM `rom_stone` rs,
					`tbl_final_submit` fs
					WHERE rs.mine_code = '$mineCode'
					AND rs.return_type = 'MONTHLY'
					AND rs.return_date BETWEEN '$startDate' AND '$endDate'
					AND rs.mineral_name = '$mineral'
					AND rs.mine_code = fs.mine_code
					AND fs.return_type = 'MONTHLY'
					AND rs.return_date = fs.return_date";
					
				$result = $conn->execute($str)->fetchAll('assoc');

			}

			$count = count($result);
			if(count($result) == 0){
				$result = array();
				$result[0]['rom_type_sn'] = "";
				$result[0]['oc_type'] = "";
				$result[0]['oc_qty'] = "";
				$result[0]['ug_type'] = "";
				$result[0]['ug_qty'] = "";
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
		public function getRomDataMonthAll($mineCode, $returnType, $returnDate, $mineral) {

			$conn = ConnectionManager::get(Configure::read('conn'));
			$startDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
			$str = "SELECT
				rs.rom_type_sn,
				rs.oc_type,
				rs.ug_type,
				SUM(rs.oc_qty) as oc_qty,
				SUM(rs.ug_qty) as ug_qty
				FROM `rom_stone` rs,
				`tbl_final_submit` fs
				WHERE rs.mine_code = '$mineCode'
				AND rs.return_type = 'MONTHLY'
				AND rs.return_date BETWEEN '$startDate' AND '$endDate'
				AND rs.mineral_name = '$mineral'
				AND rs.mine_code = fs.mine_code
				AND fs.return_type = 'MONTHLY'
				AND rs.return_date = fs.return_date";
				
			$result = $conn->execute($str)->fetchAll('assoc');

			$count = count($result);
			if(count($result) == 0){
				$result = array();
				$result[0]['rom_type_sn'] = "";
				$result[0]['oc_type'] = "";
				$result[0]['oc_qty'] = "";
				$result[0]['ug_type'] = "";
				$result[0]['ug_qty'] = "";
			}

			$result['count'] = $count;
			return $result;

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
					->select(['oc_qty', 'ug_qty'])
					->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate])
					->toArray();

			if (count($query) == 0)
				return 1;

			foreach ($query as $r) {
				if ($r['oc_qty'] == 0 || $r['ug_qty'] == 0)
				return 0;
			}

			return 0;
		}

		/**
		 * Used to check filled status
		 * @version 25th Nov 2021
		 * @author Aniket Ganvir
		 */
		public function isFilledRomData($mineCode, $returnDate, $returnType, $mineral) {

			$result = $this->find()
				->select(['oc_qty', 'ug_qty'])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>$returnType])
				->where(['return_date'=>$returnDate])
				->where(['mineral_name'=>$mineral])
				->limit(1)
				->toArray();

			if (count($result) == 0) {
				return 0;
			} else {
				if ($result[0]['oc_qty'] == '' || $result[0]['ug_qty'] == '') {
					return 0;
				} else {
					return 1;
				}
			}

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

	        	$f_oc_qty = $params['f_oc_qty'];
	        	$f_ug_qty = $params['f_ug_qty'];
	        	$minUnit = $params['minUnit'];

				$data = $this->find('all')->where(['mine_code'=>$mineCode, 'return_type'=>$returnType, 'return_date'=>$returnDate, 'mineral_name'=>$mineralName])->toArray();
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
					'rom_type_sn'=>1,
					'oc_type'=>$minUnit,
					'oc_qty'=>$f_oc_qty,
					'ug_type'=>$minUnit,
					'ug_qty'=>$f_ug_qty,
					'created_at'=>$created_at,
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

			if(empty($params['mine_code'])){ $returnValue = null ; }
			if(empty($params['return_type'])){ $returnValue = null ; }
			if(empty($params['return_date'])){ $returnValue = null ; }
			if(empty($params['mineral_name'])){ $returnValue = null ; }
			
			if($params['f_oc_qty'] == ''){ $returnValue = null ; }
			if($params['f_ug_qty'] == ''){ $returnValue = null ; }

			if(!is_numeric($params['f_oc_qty']) && !is_float($params['f_oc_qty'])){ $returnValue = null ; }
			if(!is_numeric($params['f_ug_qty']) && !is_float($params['f_ug_qty'])){ $returnValue = null ; }

			$round_oc_qty = number_format($params['f_oc_qty'], 3, '.', "");
			$round_ug_qty = number_format($params['f_ug_qty'], 3, '.', "");
			if(strlen($round_oc_qty) > 16){ $returnValue = null ; }
			if(strlen($round_ug_qty) > 16){ $returnValue = null ; }
			
			return $returnValue;
			
		}

		/**
		 * Returns the rom details for F7 form
		 * @param type $mineCode
		 * @param type $returnDate
		 * @param type $returnType
		 * @param type $mineral
		 * @return type 
		 */
		public function getRomStoneDetails($mineCode, $returnDate, $returnType, $mineral) {

			$query = $this->find()
					->where(['mine_code'=>$mineCode])
					->where(['return_type'=>$returnType])
					->where(['return_date'=>$returnDate])
					->where(['mineral_name'=>$mineral])
					->toArray();
			
			if (count($query) > 0){
				return $query[0];
			}
			else {
				return array();
			}

		}

		public function getRomProductionTotal($mineCode, $returnType, $returnDate, $mineral) {

			$query = $this->find()
					->select(['oc_qty','ug_qty'])
					->where(['mine_code'=>$mineCode])
					->where(['return_type'=>$returnType])
					->where(['return_date'=>$returnDate])
					->where(['mineral_name'=>$mineral])            
					->toArray();   
			$total = 0;
			foreach ($query as $data) {
				$total = $total + $data['oc_qty'];
				$total = $total + $data['ug_qty'];             
			}
			return $total;

		}

		/**
		 * ADDED THE BELOW FUNCTION AS PER THE CHANGES IN THE RELEASE CODE
		 * 
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 21st Jan 2014 
		 * 
		 * CALL IS ALSO CHANGED
		 * @param type $mineCode
		 * @param type $returnType
		 * @param type $returnDate
		 * @param type $mineral
		 * @return type 
		 */
		public function getProductionTotal($mineCode, $returnType, $returnDate, $mineral) {

	        $con = ConnectionManager::get(Configure::read('conn'));
			$query = $con->execute("SELECT (SUM(ug_qty) + SUM(oc_qty)) AS totalProd FROM `rom_stone` WHERE mine_code='$mineCode' AND return_type = '$returnType' AND return_date = '$returnDate' AND mineral_name = '$mineral' AND rom_type_sn = '1'")->fetchAll('assoc');
			// $query = $this->find()
			// 		->select('(SUM(ug_qty) + SUM(oc_qty)) AS totalProd')
			// 		->from('ROM_STONE')
			// 		->where('mine_code=?', $mineCode)
			// 		->andWhere('return_type=?', $returnType)
			// 		->andWhere('return_date=?', $returnDate)
			// 		->andWhere('mineral_name=?', $mineral)
			// 		->andWhere('rom_type_sn=?', 1)
			// 		->fetchArray();   
			
			return $query[0]['totalProd'];

		}

	} 

?>