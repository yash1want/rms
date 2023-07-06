<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirRomGradeTable extends Table{

		var $name = "DirRomGrade";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		// Function retruns grade name in hindi version, Done by pravin bhakre 03-09-2020
		public function getGradsArrByMin($mineral_name) {
			$gradeArr = $this->find('all')
					->select(['id', 'grade_code','grade_name','grade_name_h'])
					->where(['mineral_name'=>$mineral_name])
					->order(['id'=>'ASC'])
					->toArray();
			
			return $gradeArr;
		}


	} 
?>