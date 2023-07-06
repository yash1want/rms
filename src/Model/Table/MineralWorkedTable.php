<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\Datasource\ConnectionManager;
	use Cake\ORM\Locator\LocatorAwareTrait;
	
	class MineralWorkedTable extends Table{

		var $name = "MineralWorked";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function getMineralName($mine_code){
			
			$row_count = $this->find('all',array('conditions'=>array('mine_code'=>$mine_code)))->count();
			if ($row_count > 0) {
				$data = $this->find('all',array('conditions'=>array('mine_code'=>$mine_code, 'mineral_sn'=>1)))->first();
				$mineral_name = $data['mineral_name'];
			} else {
				$mineral_name = "--";
			}
			
			return $mineral_name;
			
		}

		public function fetchMineralInfo($mine_code){

        	$data = $this->find('all',array('conditions'=>array('mine_code'=>$mine_code,'mineral_name IS NOT'=>'MICA'),'order'=>array('mineral_sn'=>'ASC')))->toArray();
        	if(count($data) > 0){
        		$result = $data;
        	} else {
        		$result = [];
        	}

        	return $result;

		}

	    /**
	     * returns the name of the other minerals to display in the details of mine page
	     * @param type $mineCode
	     * @return string 
	     */
	    public function getOtherMinerals($mineCode) {

        	$mineral = $this->find('all',array('conditions'=>array('mine_code'=>$mineCode,'mineral_name IS NOT'=>'MICA')))->toArray();

	        if (count($mineral) < 1)
	            return "--";

	        $i = 0;
	        $other_minerals = array();
	        $total_minerals = count($mineral);

	        $other_minerals = "";
	        foreach ($mineral as $m) {
	            if ($m['mineral_sn'] != 1)
	                $other_minerals .= $m['mineral_name'];

	            if ($i != ($total_minerals - 1)) {
	                if ($i != 0)
	                    $other_minerals .= ", ";
	            }

	            $i++;
	        }

	        return $other_minerals;
	    }

	    public function getPrimaryMineralName($mineCode) {

        	$mineral = $this->find('all',array('conditions'=>array('mine_code'=>$mineCode,'mineral_sn'=>'1')))->toArray();

	        return $mineral[0]['mineral_name'];
	    }

		public function getSnCalMineralName($mineCode) {

			$query = $this->find()
				->select(['mineral_name'])
				->where(['mine_code'=>$mineCode])
				->order(['mineral_sn'=>'ASC'])
				->toArray();
	
			$i = 0;
			$result = Array();
			foreach ($query as $data) {
				$result[$i] = $data['mineral_name'];
				$i++;
			}
			if($i > 0) {
				$result = implode(" , ", $result);
			} else {
				$result = "";
			}
			
			return $result;

		}
		
		public function postDataValidationMasters($forms_data)
		{
			$returnValue = 1;
	
			$mineCode = $forms_data['mine_code'];
			$mineName = $forms_data['mineral_name'];
			$mineralSn = $forms_data['mineral_sn'];
			$proportion = $forms_data['proportion'];
			$oreLump = $forms_data['ore_lump'];
			$oreFines = $forms_data['ore_fines'];
			$oreFriable = $forms_data['ore_friable'];
			$oreGranular = $forms_data['ore_granular'];
			$orePlaty = $forms_data['ore_platy'];
			$oreFibrous = $forms_data['ore_fibrous'];
			$oreOther = $forms_data['ore_other'];
	
			if ($forms_data['mine_code'] == '') {
				$returnValue = null;
			}
			if (isset($forms_data['mineral_name']) && $forms_data['mineral_name'] == '') {
				$returnValue = null;
			}
	
			if (strlen($forms_data['mine_code']) > 20) {
				$returnValue = null;
			}
			if (strlen($forms_data['mineral_sn']) > 6) {
				$returnValue = null;
			}
			if (strlen($forms_data['proportion']) > 20) {
				$returnValue = null;
			}
			if (strlen($forms_data['ore_lump']) > 1) {
				$returnValue = null;
			}
			if (strlen($forms_data['ore_fines']) > 1) {
				$returnValue = null;
			}
			if (strlen($forms_data['ore_friable']) > 1) {
				$returnValue = null;
			}
			if (strlen($forms_data['ore_granular']) > 1) {
				$returnValue = null;
			}
			if (strlen($forms_data['ore_platy']) > 1) {
				$returnValue = null;
			}
			if (strlen($forms_data['ore_fibrous']) > 1) {
				$returnValue = null;
			}
			if (strlen($forms_data['ore_other']) > 100) {
				$returnValue = null;
			}
			// if (!is_numeric($forms_data['mineral_sn'])) {
			// 	$returnValue = null;
			// }
			// if(!filter_var($forms_data['proportion'], FILTER_VALIDATE_FLOAT)){
			// 	$returnValue = null;
			// }
			// if (!preg_match('/^[a-zA-Z0-9]+$/', $forms_data['mine_code'])) {
			// 	$returnValue = null;
			// }
			// if (!preg_match("/^[0-9]+$/", $forms_data['mineral_sn'])) {
			// 	$returnValue = null;
			// }
			// if (!preg_match("/^[a-zA-Z]+$/", $forms_data['ore_lump'])) {
			// 	$returnValue = null;
			// }
			// if (!preg_match("/^[a-zA-Z]+$/", $forms_data['ore_fines'])) {
			// 	$returnValue = null;
			// }
			// if (!preg_match("/^[a-zA-Z]+$/", $forms_data['ore_friable'])) {
			// 	$returnValue = null;
			// }
			// if (!preg_match("/^[a-zA-Z]+$/", $forms_data['ore_granular'])) {
			// 	$returnValue = null;
			// }
			// if (!preg_match("/^[a-zA-Z]+$/", $forms_data['ore_platy'])) {
			// 	$returnValue = null;
			// }
			// if (!preg_match("/^[a-zA-Z]+$/", $forms_data['ore_fibrous'])) {
			// 	$returnValue = null;
			// }
			// if (!preg_match("/^[a-zA-Z]+$/", $forms_data['ore_other'])) {
			// 	$returnValue = null;
			// }
			return $returnValue;
		}
		//get mineral code by shalini date : 12/01/2022
		public function getMineCode($forms_data)
		{
			
			$app_id = $forms_data['app_id'];
			$connection = ConnectionManager::get(Configure::read('conn'));

			$result = $connection->execute("SELECT `mine_code` FROM mineral_worked WHERE mine_code LIKE '%".$app_id."%' group by mine_code")->fetchAll('assoc');

            $output = '<ul class="list-unstyled">';

		    if (count($result) > 0){
			
				foreach($result as $row){
					$output .= '<li>'.ucwords($row['mine_code']).'</li>';
				}

		    } else {
		     	$output .= '<li> Mine Code not found!</li>';
		    }

		    $output .= '</ul>';
		    return $output;

		}//end

	} 
?>