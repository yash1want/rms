<?php 
	namespace app\Model\Table;
	use App\Controller\MonthlyController;
	use App\Model\Model;
	use Cake\Core\Configure;
	use Cake\ORM\Table;
	use Cake\ORM\TableRegistry;
	
	class ExplorationDetailsTable extends Table{

		var $name = "ExplorationDetails";			
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
				return $MonthlyCntrl->Customfunctions->getTableColumns('exploration_details');
            }

        }

		/**
		 * Check filled status of section
		 * @version 29th Oct 2021
		 * @author Aniket Ganvir
		 */
		public function isFilled($mineCode, $returnType, $returnDate) {

			$records = $this->find()
                ->where(['mine_code'=>$mineCode])
                ->where(['return_type'=>$returnType])
                ->where(['return_date'=>$returnDate])
				->count();
			if ($records > 0) {
				return true;
			} else {
				return false;
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
                ->select(['id','created_at'])
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

        
	    public function saveFormDetails($params){

			$dataValidatation = $this->postDataValidation($params);

			if($dataValidatation == 1 ){

	            $mineCode = $params['mine_code'];
                $returnDate = $params['return_date'];
                $returnType = $params['return_type'];
                $params = $params['E'];
				
                $result = 1;
				$date = date('Y-m-d H:i:s');

				$formData = $this->getReturnsId($mineCode, 'ANNUAL', $returnDate);
				if (isset($formData['id']) && $formData['id'] != '') {
					$rowId = $formData['id'];
					$created_at = $formData['created_at'];
				} else {
					$rowId = '';
					$created_at = $date;
				}
                
				$newEntity = $this->newEntity(array(
                    'id' => $rowId,
                    'mine_code' => $mineCode,
                    'return_type' => $returnType,
                    'return_date' => $returnDate,
                    'begin_holes_drilling' => $params['BEGIN_HOLES_DRILLING'],
                    'begin_metrage_drilling' => $params['BEGIN_METRAGE_DRILLING'],
                    'during_holes_drilling' => $params['DURING_HOLES_DRILLING'],
                    'during_metrage_drilling' => $params['DURING_METRAGE_DRILLING'],
                    'cumu_holes_drilling' => $params['CUMU_HOLES_DRILLING'],
                    'cumu_metrage_drilling' => $params['CUMU_METRAGE_DRILLING'],
                    'gride_holes_drilling' => $params['GRIDE_HOLES_DRILLING'],
                    'gride_metrage_drilling' => $params['GRIDE_METRAGE_DRILLING'],
                    'begin_pits_pitting' => $params['BEGIN_PITS_PITTING'],
                    'begin_excav_pitting' => $params['BEGIN_EXCAV_PITTING'],
                    'during_pits_pitting' => $params['DURING_PITS_PITTING'],
                    'during_excav_pitting' => $params['DURING_EXCAV_PITTING'],
                    'cumu_pits_pitting' => $params['CUMU_PITS_PITTING'],
                    'cumu_excav_pitting' => $params['CUMU_EXCAV_PITTING'],
                    'gride_pits_pitting' => $params['GRIDE_PITS_PITTING'],
                    'gride_excav_pitting' => $params['GRIDE_EXCAV_PITTING'],
                    'begin_trenches_trench' => $params['BEGIN_TRENCHES_TRENCH'],
                    'begin_excav_trench' => $params['BEGIN_EXCAV_TRENCH'],
                    'begin_length_trench' => $params['BEGIN_LENGTH_TRENCH'],
                    'during_trenches_trench' => $params['DURING_TRENCHES_TRENCH'],
                    'during_excav_trench' => $params['DURING_EXCAV_TRENCH'],
                    'during_length_trench' => $params['DURING_LENGTH_TRENCH'],
                    'cumu_trenches_trench' => $params['CUMU_TRENCHES_TRENCH'],
                    'cumu_excav_trench' => $params['CUMU_EXCAV_TRENCH'],
                    'cumu_length_trench' => $params['CUMU_LENGTH_TRENCH'],
                    'gride_trenches_trench' => $params['GRIDE_TRENCHES_TRENCH'],
                    'gride_excav_trench' => $params['GRIDE_EXCAV_TRENCH'],
                    'gride_length_trench' => $params['GRIDE_LENGTH_TRENCH'],
                    'begin_expenditure' => $params['BEGIN_EXPENDITURE'],
                    'during_expenditure' => $params['DURING_EXPENDITURE'],
                    'cumu_expenditure' => $params['CUMU_EXPENDITURE'],
                    'gride_expenditure' => $params['GRIDE_EXPENDITURE'],
                    'other_explor_activity' => $params['OTHER_EXPLOR_ACTIVITY'],
					'created_at' => $created_at,
					'updated_at' => $date
				));
			
				if ($this->save($newEntity)) {
					//
				} else {
					$result = false;
				}

                return $result;

			} else {
				return false;
			}

	    }

	    public function postDataValidation($params){
			
			$returnValue = 1;
			
			if(empty($params['mine_code'])){ $returnValue = null ; }
			if(empty($params['return_date'])){ $returnValue = null ; }
			if(empty($params['return_type'])){ $returnValue = null ; }
			
			$MonthlyCntrl = new MonthlyController;
			$validate = $MonthlyCntrl->Validate;
            
            $exceptionFieldsForNum = array('GRIDE_HOLES_DRILLING','GRIDE_METRAGE_DRILLING','GRIDE_PITS_PITTING','GRIDE_EXCAV_PITTING','GRIDE_TRENCHES_TRENCH','GRIDE_EXCAV_TRENCH','GRIDE_LENGTH_TRENCH','GRIDE_EXPENDITURE','OTHER_EXPLOR_ACTIVITY');

			foreach ($params['E'] as $key=>$val) {

				if ($val != '') {
					$maxCharac = ($key == 'OTHER_EXPLOR_ACTIVITY') ? 250 : 15;
					$returnValue = ($validate->maxLen($val, $maxCharac) == false) ? null : $returnValue;
                    if (!in_array($key, $exceptionFieldsForNum)) {
                        $returnValue = ($validate->numeric($val) == false) ? null : $returnValue;
                    }
				} else {
					$returnValue = null ;
				}

			}
			
			return $returnValue;
			
		}

	} 
?>