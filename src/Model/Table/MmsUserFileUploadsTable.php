<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class MmsUserFileUploadsTable extends Table{
	
		var $name = "MmsUserFileUploadsTable";
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}
		
	}

?>