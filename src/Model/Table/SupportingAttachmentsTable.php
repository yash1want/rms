<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;

	class SupportingAttachmentsTable extends Table{
		
		var $name = "SupportingAttachments";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		// public function getUserDatabyId($userId){			
		// 	$data = $this->find('all',array('conditions'=>array('user_name'=>$userId)))->first();
		// 	return $data;
		// }

	} 
?>