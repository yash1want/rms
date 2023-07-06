<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class ReservesTable extends Table{

		var $name = "Reserves";
		public $validate = array();
    
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function checkDBForAnnual($mineCode, $returnType, $returnDate, $mineralName) {

            $query = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['mineral_name'=>$mineralName])
                ->toArray();
        
            if (count($query) > 0)
              return 1;
            else
              return 0;

        }

        public function getAllData($mineCode, $returnType, $returnDate, $mineralName) {
            
            $query = $this->find()
                    ->where(['mine_code'=>$mineCode])
                    ->where(['return_type'=>$returnType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['mineral_name'=>$mineralName])
                    ->toArray();
            
            $provedCount = 1;
            $probableFirstCount = 1;
            $probableSecondCount = 1;
            $feasibilityCount = 1;
            $preFeasiFirstCount = 1;
            $preFeasiSecondCount = 1;
            $measuredCount = 1;
            $indicatedCount = 1;
            $inferredCount = 1;
            $reconCount = 1;
            $data = Array();
            $count = Array();
            $result = Array();
            foreach ($query as $data) {
              if ($data['PROVED_QTY'] != "" || $data['proved_grade'] != "") {
                $result['proved_min_qty_' . $provedCount] = $data['proved_qty'];
                $result['proved_min_grade_' . $provedCount] = $data['proved_grade'];
                $count['provedCount'] = $provedCount;
                $provedCount++;
              }
              if ($data['probable_first_qty'] != "" || $data['probable_first_grade'] != "") {
                $result['probable_first_min_qty_' . $probableFirstCount] = $data['probable_first_qty'];
                $result['probable_first_min_grade_' . $probableFirstCount] = $data['probable_first_grade'];
                $count['probableFirstCount'] = $probableFirstCount;
                $probableFirstCount++;
              }
              if ($data['probable_second_qty'] != "" || $data['probable_second_grade'] != "") {
                $result['probable_second_min_qty_' . $probableSecondCount] = $data['probable_second_qty'];
                $result['probable_second_min_grade_' . $probableSecondCount] = $data['probable_second_grade'];
                $count['probableSecondCount'] = $probableSecondCount;
                $probableSecondCount++;
              }
              if ($data['feasibility_qty'] != "" || $data['feasibility_grade'] != "") {
                $result['feasibility_min_qty_' . $feasibilityCount] = $data['feasibility_qty'];
                $result['feasibility_min_grade_' . $feasibilityCount] = $data['feasibility_grade'];
                $count['feasibilityCount'] = $feasibilityCount;
                $feasibilityCount++;
              }
              if ($data['prefeasibility_first_qty'] != "" || $data['prefeasibility_first_grade'] != "") {
                $result['pre_feasibility_first_min_qty_' . $preFeasiFirstCount] = $data['prefeasibility_first_qty'];
                $result['pre_feasibility_first_min_grade_' . $preFeasiFirstCount] = $data['prefeasibility_first_grade'];
                $count['preFeasiFirstCount'] = $preFeasiFirstCount;
                $preFeasiFirstCount++;
              }
              if ($data['prefeasibility_second_qty'] != "" || $data['prefeasibility_second_grade'] != "") {
                $result['pre_feasibility_second_min_qty_' . $preFeasiSecondCount] = $data['prefeasibility_second_qty'];
                $result['pre_feasibility_second_min_grade_' . $preFeasiSecondCount] = $data['prefeasibility_second_grade'];
                $count['preFeasiSecondCount'] = $preFeasiSecondCount;
                $preFeasiSecondCount++;
              }
              if ($data['measured_qty'] != "" || $data['measured_grade'] != "") {
                $result['measured_min_qty_' . $measuredCount] = $data['measured_qty'];
                $result['measured_min_grade_' . $measuredCount] = $data['measured_grade'];
                $count['measuredCount'] = $measuredCount;
                $measuredCount++;
              }
              if ($data['indicated_qty'] != "" || $data['indicated_grade'] != "") {
                $result['indicated_min_qty_' . $indicatedCount] = $data['indicated_qty'];
                $result['indicated_min_grade_' . $indicatedCount] = $data['indicated_grade'];
                $count['indicatedCount'] = $indicatedCount;
                $indicatedCount++;
              }
              if ($data['inferred_qty'] != "" || $data['inferred_grade'] != "") {
                $result['inferred_min_qty_' . $inferredCount] = $data['inferred_qty'];
                $result['inferred_min_grade_' . $inferredCount] = $data['inferred_grade'];
                $count['inferredCount'] = $inferredCount;
                $inferredCount++;
              }
              if ($data['recon_qty'] != "" || $data['recon_grade'] != "") {
                $result['recon_min_qty_' . $reconCount] = $data['recon_qty'];
                $result['recon_min_grade_' . $reconCount] = $data['recon_grade'];
                $count['reconCount'] = $reconCount;
                $reconCount++;
              }
            }

            $countLength = count($count);
            $resultSet['data'] = $result;
            $resultSet['count'] = $count;
            $resultSet['arrayCount'] = $countLength;
            return $resultSet;

        }

	}
?>