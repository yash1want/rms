<?php 
namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\Core\Configure;

	class Visitor_countsTable extends Table{
		
		var $name = "visitor_counts";
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}
   
	} ?>