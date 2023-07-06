<?php 
	namespace app\Model\Table;
	use App\Controller\MonthlyController;
	use App\Model\Model;
	use Cake\Core\Configure;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	
	class SubgradeMineralRejectTable extends Table{

		var $name = "SubgradeMineralReject";			
		public $validate = array();
        
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        public function getAllData($mineCode, $returnType, $returnDate, $mineralName){
		
            $query = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
                ->where(['mineral_name'=>$mineralName])	
                ->toArray();
                
            if (count($query) > 0) {
                return $query[0];
            } else {
                $MonthlyCntrl = new MonthlyController();
				return $MonthlyCntrl->Customfunctions->getTableColumns('subgrade_mineral_reject');
            }	
        }

        /**
        * @param string $mineCode
        * @param string $returnType
        * @param date $returnDate
        * @param int $formType
        * @return if data then record id else null
        */
        public function getReturnsId($mineCode, $returnType, $returnDate, $mineralName) {
            
            $query = $this->find()
                ->select(['id'])
                ->where(["mine_code"=>$mineCode])
                ->where(["return_type"=>$returnType])
                ->where(["return_date"=>$returnDate])
                ->where(['mineral_name'=>$mineralName])	
                ->toArray();
                    
            if (count($query) > 0) {
                return $query[0];
            } else {
                return null;
            }

        }


	} 
?>