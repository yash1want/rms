<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirNmiGradeTable extends Table{

		var $name = "DirNmiGrade";
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        /**
         *
         * @return array RETURN THE ARRAY OF NMI GRADES WITH ID AS KEY 
         * ID IS MADE AS KEY AS THIS FUNCTION IS CREATED AT THE END OF DEVELOPMENT AND 
         * EALIER ALL THESE GRADES ARE HARD-CODED AND USING ID AS THE KEY
         */
        public function getNmiGrades() {

            $query = $this->query()
                    ->select(['id','grade_name'])
                    ->toArray();

            $result = Array();
            foreach ($query as $data) {
                $result[$data['id']] = $data['grade_name'];
            }
            
            return $result;

        }

	}
?>