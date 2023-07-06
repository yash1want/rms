<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class SupportTable extends Table{
		
		var $name = "Support";			
		public $validate = array();

		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function getUserDatabyId($userId){			
			$data = $this->find('all',array('conditions'=>array('user_name'=>$userId)))->first();
			return $data;
		}

		public function getUserByEmail($user_name, $email){			

			// removed 'user_name' from condition as email addresses are now treated as username
			// $row_count = $this->find('all',array('conditions'=>array('user_name'=>$user_name, 'email'=>$email)))->count();
			$row_count = $this->find('all',array('conditions'=>array('email'=>$email)))->count();

			if ($row_count > 0) {
				// $data = $this->find('all',array('conditions'=>array('user_name'=>$user_name, 'email'=>$email)))->first();
				$data = $this->find('all',array('conditions'=>array('email'=>$email)))->first();
				$result = $data['id'];
			} else {
				$result = 0;
			}
			
			return $result;
		}

		// get mms user data by user id
		public function findOneById($userId){			
			$data = $this->find('all',array('conditions'=>array('id'=>$userId)))->first();
			return $data;
		}


		/*Yashwant 01-05-2023 For Update ===================*/
		/*public function updateData($tableName, $data, $condition)
	    {
	    	$query= $this->query()->where($condition);
	    	$query->update($tableName,$data);
	    	$query->execute
	    }	*/

	    


	} 
?>