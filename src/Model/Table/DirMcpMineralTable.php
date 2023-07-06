<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirMcpMineralTable extends Table{
		
		var $name = "DirMcpMineral";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function getFormNumber($mineral){
			
			$mineral_name = strtoupper(str_replace('_', ' ', html_entity_decode($mineral)));
			
			//    @author: UDAY SHANKAR SINGH
			//    
			//    BELOW WAS THE ORIGINAL VERSION BUT I ADD html_entity_decode TO RESOLVE THE PROBLEM OF '&'
			//    $mineral_name = strtoupper(str_replace('_', ' ', $mineral));
			//    $amphershandPos =  strstr($mineral_name, '&');
			//    if($amphershandPos){
			////      $mineral_name = html_entity_decode($mineral_name);
			////      $mineralArr = explode('&', html_entity_decode($mineral_name));
			//      $mineralArr = explode('&', $mineral_name);
			//    }
			//    print_r($mineralArr);
			//    $min_name[0] = 'LEAD';
			//    $min_name[1] = 'ZINC ORE';
			//    $mineral_name = 'LEAD & ZINC ORE';
			
			$data = $this->find('all', array('conditions'=>array('mineral_name'=>$mineral_name)))->first();
			$form_number = (isset($data['form_type'])) ? $data['form_type'] : "";
			
			return $form_number;
			
		}

	    /**
	     * Returns true if the ore is selected already
	     * @param type $mineCode
	     * @param type $returnType
	     * @param type $returnDate
	     * @param type $mineral
	     * @return boolean 
	     */
	    public function isOreExists($mineCode, $returnType, $returnDate) {

	        $query = Doctrine_Query::create()
	                ->select('hematite, magnetite')
	                ->from('PROD_1')
	                ->where("mine_code = ?", $mineCode)
	                ->andWhere("return_type = ?", $returnType)
	                ->andWhere("return_date = ?", $returnDate)
	                ->andWhere("mineral_name = ?", "iron_ore")
	                ->fetchArray();

	        if (count($query) > 0) {
	            foreach ($query as $m) {
	                if ($m['HEMATITE'] || $m['MAGNETITE'] != "")
	                    return true;
	                else
	                    return false;
	            }
	        } else {
	            return false;
	        }
	    }

		public function getMineralUnit($mineral) {
			$q = $this->find('all')
			        ->select(['input_unit'])
			        ->where(['mineral_name'=>$mineral])
			        ->toArray();

			$unit = "";
			if (count($q) > 0)
			  $unit = ucwords(strtolower($q[0]['input_unit']));

			return $unit;
		}

		public function getAllUnit($mineral = null) {

			$q = $this->find()
					->select(['input_unit', 'mineral_name'])
					->toArray();
		
			$resultSet = Array();
			foreach($q as $data){
				$mineralName = $data['mineral_name'];
				$resultSet[$mineralName] = ucwords(strtolower($data['input_unit']));
			}
			return $resultSet;

		}

	} 
?>