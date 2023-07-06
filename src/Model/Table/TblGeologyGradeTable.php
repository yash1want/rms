<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class TblGeologyGradeTable extends Table{

		var $name = "TblGeologyGrade";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

	} 
?>