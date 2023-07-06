<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class DirMeMineralTable extends Table{
		
		var $name = "DirMeMineral";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        //get minerals list
        public function getMineralList() {

            $query = $this->find('all')
                    ->select(['mineral_name'])
                    ->order(['mineral_name'=>'ASC'])
                    ->toArray();

            $data = array();
            $i = 0;
            foreach ($query as $m) {
                $data[$i] = $m['mineral_name'];
                $i++;
            }

            return $data;

        }

        public function getMineralUnit($mineral) {

            $q = $this->find()
                    ->select(['input_unit'])
                    ->where(['mineral_name'=>$mineral])
                    ->toArray();
    
            $unit = "";
            if (count($q) > 0){
                $unit = ucwords(strtolower($q[0]['input_unit']));
            }
    
            return $unit;

        }

        /**
         * FOR GETTING ALL THE MINERAL WITH THEIR UNIT AS ONCE
         * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 4th Feb 2014
         * @param String $mineral
         * @return Array 
         */
        public function getAllMineralWithUnit($mineral = null) {

            $q = $this->find()
                    ->select(['mineral_name', 'input_unit'])
                    ->toArray();

            $mineralUnitArr = Array();
            if (count($q) > 0){
                foreach ($q as $data) {
                    $temp = $data['mineral_name'];
                    $mineralUnitArr[$temp] = $data['input_unit'];
                }
            }

            return $mineralUnitArr;

        }

        public function getAllMinerals() {

            $query = $this->find()
                    ->select(['mineral_name'])
                    ->order(['mineral_name'=>'ASC'])
                    ->toArray();
    
            $data = array();
            $returnData = array();
            $i = 0;
            foreach ($query as $m) {
                $data[$m['mineral_name']] = $m['mineral_name'];
                $i++;
            }
            $returnData['returnValue'] = $data;
    
            return $returnData;

        }

	} 

?>