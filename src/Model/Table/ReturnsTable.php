<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	
	class ReturnsTable extends Table{

		var $name = "Returns";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

	  //chk record is exists or not
	  public function chkMineReturns($mineCode, $returnType, $returnDate) {
	    $query = $this->find('all')
	            ->select(['mine_code', 'return_type', 'return_date'])
	            ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate])
	            ->toArray();

	    if ($query) {
	      return true;
	    } else {
	      return false;
	    }
	  }


	  //fetch returns by mine code, return type and return date
	  public function fetchMineReturns($mineCode, $returnType, $returnDate) {
	    $query = $this->find('all')
	            ->where(["mine_code"=>$mineCode,"return_type"=>$returnType,"return_date"=>$returnDate])
	            ->toArray();

	    if (count($query) > 0)
	      return $query[0];
	    else
	      return array();
	  }


		/**
		 * fetch returns by return id
		 * @addedon 10th MAR 2021 (by Aniket Ganvir)
		 */
		public function findOneById($returnId){

			$query = $this->find('all')
	            ->where(["id"=>$returnId])
	            ->toArray();

		    if (count($query) > 0)
		      return $query[0];
		    else
		      return array();

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

	    $query = $this->find('all')
	            ->select(['past_royalty', 'past_dead_rent', 'past_surface_rent'])
	            ->where(["mine_code"=>$mineCode, "return_type"=>$returnType, "return_date"=>$returnDate])
	            ->toArray();

	    if (count($query) == 0)
	      return 1;

	    foreach ($query as $r) {
	      if ($r['past_royalty'] == "" || $r['past_dead_rent'] == "" || $r['past_surface_rent'] == "")
	        return 1;
	    }

	    return 0;
	  }

		/**
		 * Returns the rent details for viewing of IBM user
		 * @param type $mineCode
		 * @param type $returnType
		 * @param type $returnDate
		 * @return boolean 
		 */
		public function getRentDetails($mineCode, $returnType, $returnDate) {

			$query = $this->find()
					->select(['past_royalty', 'past_dead_rent', 'past_surface_rent'])
					->where(['mine_code'=>$mineCode])
					->where(['return_type'=>$returnType])
					->where(['return_date'=>$returnDate])
					->toArray();
					
			if (count($query) > 0)
				return $query[0];
			else
				return false;

		}
		
		public function getMatConsRoyaltyDetails($mineCode, $returnDate, $formType) {

			$mc = $this->find()
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>"ANNUAL"])
					->where(['h_form_type'=>$formType])
					->toArray();
		
			$data = array();
			if (count($mc) > 0) {
				$data['ROYALTY_CURRENT'] = $mc[0]['current_royalty'];
				$data['ROYALTY_PAST'] = $mc[0]['past_royalty'];
				$data['DEAD_RENT_CURRENT'] = $mc[0]['current_dead_rent'];
				$data['DEAD_RENT_PAST'] = $mc[0]['past_dead_rent'];
				$data['SURFACE_RENT_CURRENT'] = $mc[0]['current_surface_rent'];
				$data['SURFACE_RENT_PAST'] = $mc[0]['past_surface_rent'];
				$data['TREE_COMPENSATION'] = $mc[0]['tree_compensation'];
				$data['DEPRECIATION'] = $mc[0]['depreciation'];
			}
		
			return $data;

		}
		
		public function getMatConsTaxDetails($mineCode, $returnDate, $formType) {

			$mc = $this->find()
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>"ANNUAL"])
					->where(['h_form_type'=>$formType])
					->toArray();
		
			$data = array();
			if (count($mc) > 0) {
				$data['SALES_TAX_CENTRAL'] = $mc[0]['central_sales_tax'];
				$data['SALES_TAX_STATE'] = $mc[0]['state_sales_tax'];
				$data['WELFARE_TAX_CENTRAL'] = $mc[0]['central_welfare_cess'];
				$data['WELFARE_TAX_STATE'] = $mc[0]['state_welfare_cess'];
				$data['MIN_CESS_TAX_CENTRAL'] = $mc[0]['central_mineral_cess'];
				$data['MIN_CESS_TAX_STATE'] = $mc[0]['state_mineral_cess'];
				$data['DEAD_CESS_TAX_CENTRAL'] = $mc[0]['central_cdr'];
				$data['DEAD_CESS_TAX_STATE'] = $mc[0]['state_cdr'];
				$data['OTHER_TAX'] = $mc[0]['other_taxes_spec'];
				$data['OTHER_TAX_CENTRAL'] = $mc[0]['central_other_taxes'];
				$data['OTHER_TAX_STATE'] = $mc[0]['state_other_taxes'];
				$data['OVERHEADS'] = $mc[0]['overheads'];
				$data['MAINTENANCE'] = $mc[0]['maintenance'];
				$data['WORKMEN_BENEFITS'] = $mc[0]['benefits_workmen'];
				$data['PAYMENT_AGENCIES'] = $mc[0]['payment_agencies'];
			}
		
			return $data;

		}



	} 
?>