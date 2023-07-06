<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class ProdMicaTable extends Table{

		var $name = "ProdMica";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		/**
		 * Used to check for the final submit
		 * Returns 1 if the form is not filled
		 * Returns 0 if the form is filled
		 * @param type $mineCode
		 * @param type $returnDate
		 * @param type $returnType
		 * @return int 
		 */
		public function isFilled($mineCode, $returnDate, $returnType) {

		  $mica_sn = array(1, 6, 7);

		  foreach ($mica_sn as $sn) {
		    $query = $this->find('all')
		            ->select(['open_mine'])
		            ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate,"mica_sn"=>$sn])
		            ->toArray();

		    if (count($query) == 0)
		      return 1;

		    foreach ($query as $m) {
		      if ($m['open_mine'] == "")
		        return 1;
		    }
		  }

		  return 0;
		}

		
		public function getAllProdMicaDetails($mineCode, $returnType, $returnDate) {

			$query = $this->find()
					->where(['mine_code'=>$mineCode])
					->where(['return_type'=>$returnType])
					->where(['return_date'=>$returnDate])
					->order(['mica_sn'=>'ASC'])
					->toArray();
		
			$data = array();
			if (count($query) > 0) {
				$data['crude'] = $query[0];
				$data['incidental'] = $query[1];
				$data['waste'] = $query[2];
			} else {
				$data['crude'] = array('open_mine'=>'','open_dress'=>'','open_other_spec'=>'','open_other'=>'','total_open'=>'','prod_ug'=>'','prod_oc'=>'','prod_dw'=>'','total_prod'=>'','desp_dress'=>'','desp_sale'=>'','total_desp'=>'','clos_mine'=>'','clos_dress'=>'','clos_other_spec'=>'','clos_other'=>'','total_clos'=>'','pmv'=>'','REASON_ONE'=>'','REASON_TWO'=>'');
				$data['incidental'] =array('open_mine'=>'','open_dress'=>'','open_other_spec'=>'','open_other'=>'','total_open'=>'','prod_ug'=>'','prod_oc'=>'','prod_dw'=>'','total_prod'=>'','desp_dress'=>'','desp_sale'=>'','total_desp'=>'','clos_mine'=>'','clos_dress'=>'','clos_other_spec'=>'','clos_other'=>'','total_clos'=>'','pmv'=>'');
				$data['waste'] = array('open_mine'=>'','open_dress'=>'','open_other_spec'=>'','open_other'=>'','total_open'=>'','prod_ug'=>'','prod_oc'=>'','prod_dw'=>'','total_prod'=>'','desp_dress'=>'','desp_sale'=>'','total_desp'=>'','clos_mine'=>'','clos_dress'=>'','clos_other_spec'=>'','clos_other'=>'','total_clos'=>'','pmv'=>'');
			}
			
			return $data;

		}

		public function getProductionTotalfn($mineCode, $returnType, $returnDate, $mineral, $mica_sn){

			$query = $this->find()
				->select(['total_clos'])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>$returnType])
				->where(['return_date'=>$returnDate])
				->where(['mineral_name'=>$mineral])
				->where(["mica_sn"=>$mica_sn])
				->toArray();
			$total = 0;
			foreach($query as $data){
			  $total = $total + $data['total_clos'];
			}
			return $total;

		}

		/**
		 * CHANGED THIS FUNCTION AS PER THE RELEASE CODE
		 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
		 * @version 21st Jan 2104
		 * 
		 * LIVE VERSION IS COMMENTED BELOW
		 */  
		public function getRomProductionTotalfn($mineCode, $returnType, $returnDate, $mineral, $mica_sn) {

			$query = $this->find()
						->select(['total_prod'])
						// ->select('open_mine,open_dress,open_other,prod_ug,prod_oc,prod_dw')
						->where(['mine_code'=>$mineCode])
						->where(['return_type'=>$returnType])
						->where(['return_date'=>$returnDate])
						->where(['mineral_name'=>$mineral])
						->where(["mica_sn IN"=>array(1,6)])
						->toArray();

			$total = 0;
			foreach ($query as $data) {
				// $total = $total + $data['OPEN_MINE'];
				// $total = $total + $data['OPEN_DRESS'];
				// $total = $total + $data['OPEN_OTHER'];
				$total = $total + $data['total_prod'];
				// $total = $total + $data['PROD_OC'];
				// $total = $total + $data['PROD_DW'];      
			}
			return $total;

		}

	} 
?>