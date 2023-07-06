<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class GradeRomTable extends Table{

		var $name = "GradeRom";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		//chk record is exists or not
		public function chkGradeWiseRom($mineCode, $returnType, $returnDate, $mineralName, $gradeCode, $ironSubMin) {
			$query = $this->find('all')
					->select(['mine_code','return_type','return_date','mineral_name', 'grade_code'])
					->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,"grade_code"=>$gradeCode,"iron_type IS"=>$ironSubMin])
					->toArray();

			if ($query) {
			  return true;
			} else {
			  return false;
			}
		}

		//fetch array by mine code, return type, return date and mineral name 
		public function fetchGradeWiseRom($mineCode, $returnType, $returnDate, $mineralName, $gradeCode, $ironSubMin) {
			
			if($gradeCode != ''){
				$result = $this->find('all')
						->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,"grade_code"=>$gradeCode,"iron_type"=>$ironSubMin])
						->toArray();
			} else {
				$result = $this->find('all')
						->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mineral_name"=>$mineralName,"iron_type"=>$ironSubMin])
						->toArray();
			}
		
			if (count($result) > 0)
				return $result[0];
			else
				return array();
		}

		public function findOneById($openGradeRomId){

			$result = $this->find('all')
					->where(["id"=>$openGradeRomId])
					->toArray();

			if (count($result) > 0)
				return $result[0];
			else
				return array();

		}


		public function getProductionDetails($mineCode, $returnType, $returnDate, $mineral, $sub_mineral) {

			if ($sub_mineral != "") {
			  $query = $this->find('all')
					  ->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>$mineral,'iron_type'=>$sub_mineral])
					  ->toArray();
			} else {
			  $query = $this->find('all')
					  ->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>$mineral])
					  ->toArray();
			}
			if ($query == null) {
			  if ($sub_mineral != "") {
				$query = $this->find('all')
						->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>strtolower(str_replace(' ', '_', $mineral)),'iron_type'=>strtolower(str_replace(' ', '_', $sub_mineral))])
						->toArray();
			  } else {
				$query = $this->find('all')
						->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>strtolower(str_replace(' ', '_', $mineral))])
						->toArray();
			  }
			}

			$data = array();
			$i = 0;
			foreach ($query as $g) {
			  $data[$g['grade_code']] = $query[$i];

			  if ($query[$i]['reason_1'] != '')
				$data['reason_1'] = $query[$i]['reason_1'];
			  if ($query[$i]['reason_2'] != '')
				$data['reason_2'] = $query[$i]['reason_2'];

			  $i++;
			}


			if (count($query) > 0)
			  return $data;
			else
			  return array();
		}


	} 
?>