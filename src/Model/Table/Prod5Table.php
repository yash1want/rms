<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use App\Controller\MonthlyController;
	use Cake\ORM\Locator\LocatorAwareTrait;
    use Cake\Datasource\ConnectionManager;
	
	class Prod5Table extends Table{
		
		public function initialize(array $config): void
		{
			$this->setTable('prod_5');
		}
		
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
		public function isFilled($mineCode, $returnDate, $returnType, $mineral) {
		  $query = $this->find('all')
		          ->select(['pmv'])
		          ->where(['mine_code'=>$mineCode,'return_type'=>$returnType,'return_date'=>$returnDate,'mineral_name'=>$mineral])
		          ->toArray();

		  if (count($query) == 0)
		    return 1;

		  foreach ($query as $r) {
		    if ($r['pmv'] == "") {
		      return 1;
		    }
		  }

		  return 0;
		}

	  /**
	   * @author PRANAV SANVATSARKAR
	   * @method takes following parameters and returns the specific ID from table PROD_5
	   * @param type $mineCode
	   * @param type $returnType
	   * @param type $returnDate
	   * @param type $mineral 
	   */
	  public function getExMineProd5Id($mineCode, $returnType, $returnDate, $mineral) {
	    $query = $this->find('all')
	            ->select(['id'])
	            ->where(['mine_code'=>$mineCode, 'return_type'=>$returnType, 'return_date'=>$returnDate, 'mineral_name'=>$mineral])
	            ->toArray();

	    if ($query)
	      return $query[0]['id'];
	    else
	      return '';
	  }

		public function findOneById($prod5Id) {

			$query = $this->find('all')
			    ->where(['id'=>$prod5Id])
			    ->toArray();
			return $query;

		}

		/**
		 * GET EX-MINE PRICE
		 * @addedon 26th MAY 2021 (by Aniket Ganvir)
		 */
		public function getExMineProd5($mineCode, $returnType, $returnDate, $mineral, $pdfStatus = 0){

		    $result = $this->find('all')
				->select(['pmv'])
				->where(['mine_code'=>$mineCode, 'return_type'=>$returnType, 'return_date'=>$returnDate, 'mineral_name'=>$mineral])
				->toArray();

			if(count($result) == 0){

				if ($returnType == 'ANNUAL' && $pdfStatus == 0) {

					/**
					 * Prefetch the monthly records data for annual returns
					 * Effective from Phase - II
					 * @version 29th Oct 2021
					 * @author Aniket Ganvir
					 */
					$conn = ConnectionManager::get(Configure::read('conn'));
					$startDate = (date('Y',strtotime($returnDate))).'-04-01';
					$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
					$str = "SELECT
						avg(pmv) as pmv
						FROM `prod_5`
						WHERE mine_code = '$mineCode'
						AND return_type = 'MONTHLY'
						AND return_date BETWEEN '$startDate' AND '$endDate'
						AND mineral_name = '$mineral'";
						
					$query = $conn->execute($str)->fetchAll('assoc');
					if ($query == null) {
						$data['pmv'] = '';
					} else {
						$data = $query[0];
					}

				} else {
					$data['pmv'] = '';
				}

			} else {
				$data = $result[0];
			}

			return $data;

		}
		
		/**
		 * Prefetch the monthly records data for annual return
		 * Effective from Phase-II
		 * @version 22nd Nov 2021
		 * @author Aniket Ganvir
		 */
		public function getExMineProd5MonthAll($mineCode, $returnType, $returnDate, $mineral){

			$conn = ConnectionManager::get(Configure::read('conn'));
			$startDate = (date('Y',strtotime($returnDate))).'-04-01';
			$endDate = (date('Y',strtotime($returnDate))+1).'-03-01';
			$str = "SELECT
				avg(pmv) as pmv
				FROM `prod_5`
				WHERE mine_code = '$mineCode'
				AND return_type = 'MONTHLY'
				AND return_date BETWEEN '$startDate' AND '$endDate'
				AND mineral_name = '$mineral'";
				
			$query = $conn->execute($str)->fetchAll('assoc');
			if ($query == null) {
				$data['pmv'] = '';
			} else {
				$data = $query[0];
			}

			return $data;

		}

		// update / save form data
	    public function saveFormDetails($forms_data){

			$dataValidatation = $this->postDataValidation($forms_data);

			if($dataValidatation == 1 ){

	            $formId = $forms_data['form_no'];
	            $mineCode = $forms_data['mine_code'];
	            $returnType = $forms_data['return_type'];
	            $returnDate = $forms_data['return_date'];
	            $mineralName = $forms_data['mineral_name'];

	        	$f_pmv = $forms_data['f_pmv'];
	            $prod5Id = $forms_data['prod5Id'];

				$newEntity = $this->newEntity(array(
					'id'=>$prod5Id,
					'mine_code'=>$mineCode,
					'return_date'=>$returnDate,
					'return_type'=>$returnType,
					'mineral_name'=>$mineralName,
					'pmv'=>$f_pmv,
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>date('Y-m-d H:i:s')
				));
				if($this->save($newEntity)){
					return 1;
				} else {
					return false;
				}
			} else {
				return false;
			}

	    }

	    public function postDataValidation($forms_data){
			
			$returnValue = 1;
			
			if(empty($forms_data['mine_code'])){ $returnValue = null ; }
			if(empty($forms_data['return_type'])){ $returnValue = null ; }
			if(empty($forms_data['return_date'])){ $returnValue = null ; }
			if(empty($forms_data['mineral_name'])){ $returnValue = null ; }

			if(!is_numeric($forms_data['f_pmv'])){ $returnValue = null ; }

			if($forms_data['f_pmv'] == ''){ $returnValue = null ; }

			if(strlen($forms_data['f_pmv']) > '11'){ $returnValue = null ; }
			
			return $returnValue;
			
		}

		public function getExMinePrintDetails($mineCode, $returnDate, $returnType, $mineral) {
  
			$query = $this->find()
					->select(['pmv', 'inc_reasons'])
					->where(['mine_code'=>$mineCode])
					->where(['return_type'=>$returnType])
					->where(['return_date'=>$returnDate])
					->where(['mineral_name'=>$mineral])
					->toArray();
		
			$data = array();
			if (count($query) > 0) {
				$data['pmv'] = $query[0]['pmv'];
				$data['reason'] = $query[0]['inc_reasons'];
			}
		
			return $data;

		}

	} 
?>