<?php
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\Core\Configure;

	class MenusTable extends Table{	
		
		var $name = "Menus";
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

	}

?>