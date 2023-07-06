<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class MmsSecondaryUserRolesTable extends Table{
        var $name = "MmsSecondaryUserRoles";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}
		// get user role in array Date: 09/02/2022 Shalini D
		public function getUserRoles($userId)
		{
			$data = $this->find('all',array('conditions'=>array('user_id'=>$userId)))->first();
			if(!empty($data))
			{
				$roles = explode(",", $data['roles']); 
			}else{
				$roles =array();
			}
			return $roles;
		}
		
    }
?>        