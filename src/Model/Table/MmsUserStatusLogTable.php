<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class MmsUserStatusLogTable extends Table{

		var $name = "MmsUserStatusLog";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}
		
		public function saveUserStatusLog($userId, $mmsUserId, $isDeleted) {

			$newEntity = $this->newEntity(array(
				'user_id'=>$userId,
				'action_by'=>$mmsUserId,
				'action'=>$isDeleted,
				'created_at'=>date('Y-m-d H:i:s')
			));
			$this->save($newEntity);
	
		}

	} 
?>