<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use App\Controller\MonthlyController;
	
	class ExplosiveReturnTable extends Table{

		var $name = "ExplosiveReturn";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

	    public function getExplosiveReturnRecords($mineCode, $returnDate, $returnType) {

			$MonthlyController = new MonthlyController;

	        $query = $this->find()
	                ->select(['mag_capacity_exp', 'mag_capacity_det', 'mag_capacity_fuse', 'total_rom_ore', 'ob_blasting'])
	                ->where(['return_date'=>$returnDate,'mine_code'=>$mineCode,'return_type'=>$returnType])
	                ->toArray();

			
		    if (count($query) > 0){
				// $dataArr = $query[0];
				$dataArr[0] = $query[0];
		    } else {
				$dataArr[0] = $MonthlyController->Customfunctions->getTableColumns('explosive_return');
		    }

	        $data = Array();
	        $data['MAG_CAPACITY_EXP'] = $dataArr[0]['mag_capacity_exp'];
	        $data['MAG_CAPACITY_DET'] = $dataArr[0]['mag_capacity_det'];
	        $data['MAG_CAPACITY_FUSE'] = $dataArr[0]['mag_capacity_fuse'];
	        $data['TOTAL_ROM_ORE'] = $dataArr[0]['total_rom_ore'];
	        $data['OB_BLASTING'] = $dataArr[0]['ob_blasting'];

	        return $data;
	    }

		
		public function getRecordsForUpdate($mineCode, $returnDate, $returnType) {

			$data = $this->find()
				->select(['id', 'created_at'])
				->where(['return_date'=>$returnDate, 'mine_code'=>$mineCode, 'return_type'=>$returnType])
				->toArray();

			if (count($data) > 0) {
				$result = $data[0];
			} else {
				$result = array('id'=>'', 'created_at'=>'');
			}

			return $result;
				
	    }

		public function getProductionDuringTheYear($mineCode, $returnDate, $returnType) {

			$query = $this->find()
				->select(['total_rom_ore'])
				->where(['return_date'=>$returnDate])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>$returnType])
				->toArray();
		
			$productionTotal = (isset($query['0']['total_rom_ore'])) ? $query['0']['total_rom_ore'] : '';
			return $productionTotal;

		}

	} 
?>