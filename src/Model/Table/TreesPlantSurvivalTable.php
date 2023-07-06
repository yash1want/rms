<?php 
	namespace app\Model\Table;
	use App\Controller\MonthlyController;
	use App\Model\Model;
	use Cake\Core\Configure;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	
	class TreesPlantSurvivalTable extends Table{

		var $name = "TreesPlantSurvival";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getAllData($mineCode, $returnType, $returnDate){
            
            $query = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->toArray();
                
            if (count($query) > 0) {
                return $query[0];
            } else {
                $MonthlyCntrl = new MonthlyController();
				return $MonthlyCntrl->Customfunctions->getTableColumns('trees_plant_survival');
            }

	    }
		
		/**
		* @param string $mineCode
		* @param string $returnType
		* @param date $returnDate
		* @param int $formType
		* @return if data then record id else null
		*/
		public function getReturnsId($mineCode, $returnType, $returnDate) {
			
			$query = $this->find()
				->select(['id', 'created_at'])
				->where(["mine_code"=>$mineCode])
				->where(["return_type"=>$returnType])
				->where(["return_date"=>$returnDate])			
				->toArray();
					
			if (count($query) > 0) {
				return $query[0];
			} else {
				return null;
			}
			
		}

		/**
		 * Check filled status of section
		 * @version 30th Oct 2021
		 * @author Aniket Ganvir
		 */
		public function isFilled($mineCode, $returnType, $returnDate) {
			
            $treesPlant = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->count();
				
			$overburdenWaste = TableRegistry::getTableLocator()->get('OverburdenWaste');
			$overburden = $overburdenWaste->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->count();
                
			if ($treesPlant > 0 && $overburden > 0) {
				return true;
			} else {
				return false;
			}

		}
		
	} 
?>