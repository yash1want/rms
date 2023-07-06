<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use App\Controller\MonthlyController;
	
	class ExplosiveConsumptionTable extends Table{

		var $name = "ExplosiveConsumption";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

	    public function getExplosiveReturnRecords($mineCode, $returnDate, $returnType) {

			$explosiveReturn = TableRegistry::getTableLocator()->get('ExplosiveReturn');
	        $query = $explosiveReturn->find()
				->select(['mag_capacity_exp', 'mag_capacity_det', 'mag_capacity_fuse', 'total_rom_ore', 'ob_blasting'])
				->where(['return_date'=>$returnDate])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>$returnType])
				->toArray();

			$data = Array();
			if (count($query) > 0) {
				$data['MAG_CAPACITY_EXP'] = $query[0]['mag_capacity_exp'];
				$data['MAG_CAPACITY_DET'] = $query[0]['mag_capacity_det'];
				$data['MAG_CAPACITY_FUSE'] = $query[0]['mag_capacity_fuse'];
				$data['TOTAL_ROM_ORE'] = $query[0]['total_rom_ore'];
				$data['OB_BLASTING'] = $query[0]['ob_blasting'];
			} else {
				$data['MAG_CAPACITY_EXP'] = '';
				$data['MAG_CAPACITY_DET'] = '';
				$data['MAG_CAPACITY_FUSE'] = '';
				$data['TOTAL_ROM_ORE'] = '';
				$data['OB_BLASTING'] = '';
			}

	        return $data;

	    }
		
		/**
		 *
		 * @param string $mine_code
		 * @return array-> containing all the values for the form
		 */
		public function getExplosiveConDetails($mineCode, $returnDate) {

			$query = $this->find()
					->where(['mine_code'=>$mineCode])
					->where(['return_date'=>$returnDate]);
			$result = $query->toArray();

			$MonthlyController = new MonthlyController;
			$expConKeys = $MonthlyController->Clscommon->getExplosiveConsumption();
			$data = Array();

			if (count($result) > 0) {
				for ($i = 0; $i < 13; $i++) {
					if ($i == 0) {
						$data[$expConKeys[$i]['large_con']] = $result[$i]['large_con_qty'];
						$data[$expConKeys[$i]['large_req']] = $result[$i]['large_req_qty'];
					} else if ($i > 0 && $i < 5) {
						$data[$expConKeys[$i]['small_con']] = $result[$i]['small_con_qty'];
						$data[$expConKeys[$i]['large_con']] = $result[$i]['large_con_qty'];
						$data[$expConKeys[$i]['small_req']] = $result[$i]['small_req_qty'];
						$data[$expConKeys[$i]['large_req']] = $result[$i]['large_req_qty'];
					} else if ($i == 5) {
						$data[$expConKeys[$i]['slurry_tn']] = $result[$i]['slurry_tn'];
						$data[$expConKeys[$i]['small_con']] = $result[$i]['small_con_qty'];
						$data[$expConKeys[$i]['large_con']] = $result[$i]['large_con_qty'];
						$data[$expConKeys[$i]['small_req']] = $result[$i]['small_req_qty'];
						$data[$expConKeys[$i]['large_req']] = $result[$i]['large_req_qty'];
					} else if ($i > 5 && $i < 12) {
						$data[$expConKeys[$i]['large_con']] = $result[$i]['large_con_qty'];
						$data[$expConKeys[$i]['large_req']] = $result[$i]['large_req_qty'];
					} else if ($i == 12) {
						$data[$expConKeys[$i]['other_explosives']] = $result[$i]['other_explosives'];
						$data[$expConKeys[$i]['other_unit']] = $result[$i]['other_unit'];
						$data[$expConKeys[$i]['large_con']] = $result[$i]['large_con_qty'];
						$data[$expConKeys[$i]['large_req']] = $result[$i]['large_req_qty'];
					}
				}
			} else {
				for ($i = 0; $i < 13; $i++) {
					if ($i == 0) {
						$data[$expConKeys[$i]['large_con']] = '';
						$data[$expConKeys[$i]['large_req']] = '';
					} else if ($i > 0 && $i < 5) {
						$data[$expConKeys[$i]['small_con']] = '';
						$data[$expConKeys[$i]['large_con']] = '';
						$data[$expConKeys[$i]['small_req']] = '';
						$data[$expConKeys[$i]['large_req']] = '';
					} else if ($i == 5) {
						$data[$expConKeys[$i]['slurry_tn']] = '';
						$data[$expConKeys[$i]['small_con']] = '';
						$data[$expConKeys[$i]['large_con']] = '';
						$data[$expConKeys[$i]['small_req']] = '';
						$data[$expConKeys[$i]['large_req']] = '';
					} else if ($i > 5 && $i < 12) {
						$data[$expConKeys[$i]['large_con']] = '';
						$data[$expConKeys[$i]['large_req']] = '';
					} else if ($i == 12) {
						$data[$expConKeys[$i]['other_explosives']] = '';
						$data[$expConKeys[$i]['other_unit']] = '';
						$data[$expConKeys[$i]['large_con']] = '';
						$data[$expConKeys[$i]['large_req']] = '';
					}
				}
			}

			return $data;

		}
		
	    public function saveFormDetails($params){

			$dataValidatation = $this->postDataValidation($params);

			if($dataValidatation == 1 ){

	            $mineCode = $params['mine_code'];
                $returnDate = $params['return_date'];
                $returnType = $params['return_type'];
                $explCheckVal = $params['explosive_check_val'];
				
                $result = 1;
				$date = date('Y-m-d H:i:s');

				$MonthlyCntrl = new MonthlyController;
				$expConKeys = $MonthlyCntrl->Clscommon->getExplosiveConsumption();

				$params['MAG_CAPACITY_EXP'] = ($params['MAG_CAPACITY_EXP'] != '') ? $params['MAG_CAPACITY_EXP'] : 0;
				$params['MAG_CAPACITY_DET'] = ($params['MAG_CAPACITY_DET'] != '') ? $params['MAG_CAPACITY_DET'] : 0;
				$params['MAG_CAPACITY_FUSE'] = ($params['MAG_CAPACITY_FUSE'] != '') ? $params['MAG_CAPACITY_FUSE'] : 0;

				// if form value in Part III, item 1(iv) is either 0 or empty
				// then save with null/zero values
				if ($explCheckVal == 1) {
					$params['SLURRY_TN'] = '';
					$params['OTHER_EXPLOSIVES'] = '';
					$params['OTHER_UNIT'] = '';

					for ($i = 0; $i < 13; $i++) {
						$params[$expConKeys[$i]['small_con']] = 0;
						$params[$expConKeys[$i]['large_con']] = 0;
						$params[$expConKeys[$i]['small_req']] = 0;
						$params[$expConKeys[$i]['large_req']] = 0;
					}
				} else {
					for ($i = 0; $i < 13; $i++) {
						$params[$expConKeys[$i]['small_con']] = ($params[$expConKeys[$i]['small_con']] != '') ? $params[$expConKeys[$i]['small_con']] : 0;
						$params[$expConKeys[$i]['large_con']] = ($params[$expConKeys[$i]['large_con']] != '') ? $params[$expConKeys[$i]['large_con']] : 0;
						$params[$expConKeys[$i]['small_req']] = ($params[$expConKeys[$i]['small_req']] != '') ? $params[$expConKeys[$i]['small_req']] : 0;
						$params[$expConKeys[$i]['large_req']] = ($params[$expConKeys[$i]['large_req']] != '') ? $params[$expConKeys[$i]['large_req']] : 0;
					}
				}

				/**
				 * Commented below lines as deletion of existing entries on the time of updation
				 * overwrites the 'created_at' value. Now, maintains the 'created_at' value, effective from Phase-II.
				 * @version 06th Oct 2021
				 * @author Aniket Ganvir
				 */
				//
				// $DBRecordCheck = $this->getExplosiveReturnsId($mineCode, $returnDate, $returnType);
				// if ($DBRecordCheck == 1) {
				// 	$this->deleteExplosiveReturnAnnualRecords($mineCode, $returnDate, $returnType);
				// }

				$explosiveReturn = TableRegistry::getTableLocator()->get('ExplosiveReturn');
				$explosiveReturnData = $explosiveReturn->getRecordsForUpdate($mineCode, $returnDate, $returnType);
				if ($explosiveReturnData['id'] != '') {
					$id = $explosiveReturnData['id'];
					$created_at = $explosiveReturnData['created_at'];
				} else {
					$id = '';
					$created_at = $date;
				}
                
				$explosiveReturnEntity = $explosiveReturn->newEntity(array(
					'id' => $id,
					'mine_code' => $mineCode,
					'return_date' => $returnDate,
					'return_type' => $returnType,
					'mag_capacity_exp' => $params['MAG_CAPACITY_EXP'],
					'mag_capacity_det' => $params['MAG_CAPACITY_DET'],
					'mag_capacity_fuse' => $params['MAG_CAPACITY_FUSE'],
					'total_rom_ore' => $params['TOTAL_ROM_ORE'],
					'ob_blasting' => $params['OB_BLASTING'],
					'created_at' => $created_at,
					'updated_at' => $date
				));
			
				if($explosiveReturn->save($explosiveReturnEntity)){
					//
				} else {
					$result = false;
				}

	            $MonthlyCntrl = new MonthlyController;
				$expConKeys = $MonthlyCntrl->Clscommon->getExplosiveConsumption();
				
				$RecordDBCheck = $this->getExplosiveConsumptionId($mineCode, $returnDate);
				
				if ($RecordDBCheck == 1) {
					$this->deleteExplosiveConsumptionAnnualRecords($mineCode, $returnDate);
				}
				
				for ($i = 0; $i < 13; $i++) {
					
					$newEntity = $this->newEntity(array(
						'mine_code' => $mineCode,
						'return_type' => 'ANNUAL',
						'return_date' => $returnDate,
						'explosive_sn' => $MonthlyCntrl->Clscommon->getExplosiveSn($i),
						'slurry_tn' => $params[$expConKeys[$i]['slurry_tn']],
						'other_explosives' => $params[$expConKeys[$i]['other_explosives']],
						'other_unit' => $params[$expConKeys[$i]['other_unit']],
						'small_con_qty' => $params[$expConKeys[$i]['small_con']],
						'large_con_qty' => $params[$expConKeys[$i]['large_con']],
						'small_req_qty' => $params[$expConKeys[$i]['small_req']],
						'large_req_qty' => $params[$expConKeys[$i]['large_req']],
						'created_at' => $date,
						'updated_at' => $date
					));
				
					if($this->save($newEntity)){
						//
					} else {
						$result = false;
					}

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
			$expConKeys = $MonthlyCntrl->Clscommon->getExplosiveConsumption();

			if($params['explosive_check_val'] != ''){

				$expl_check_val = $params['explosive_check_val'];
				
				$qtyCheck = 0;
				if ($params['LARGE_CON_QTY'] > 0) {
					$qtyCheck++;
				}
				for($n=1; $n < 6; $n++) {

					$smallConQty = 'SMALL_CON_QTY_'.$n;
					if ($params[$smallConQty] > 0) {
						$qtyCheck++;
					}

				}
				for($m=1; $m < 15; $m++) {

					if (!in_array($m, array('7', '10'))) {
						$largeConQty = 'LARGE_CON_QTY_'.$m;
						if ($params[$largeConQty] > 0) {
							$qtyCheck++;
						}
					}

				}

				if ($expl_check_val == 0) {

					if ($params['MAG_CAPACITY_EXP'] != '') {
						$returnValue = ($validate->maxLen($params['MAG_CAPACITY_EXP'], 12) == false) ? null : $returnValue;
						$returnValue = ($validate->numeric($params['MAG_CAPACITY_EXP']) == false) ? null : $returnValue;
					}
					
					if ($params['MAG_CAPACITY_DET'] != '') {
						$returnValue = ($validate->maxLen($params['MAG_CAPACITY_DET'], 12) == false) ? null : $returnValue;
						$returnValue = ($validate->numeric($params['MAG_CAPACITY_DET']) == false) ? null : $returnValue;
					}
					
					if ($params['MAG_CAPACITY_FUSE'] != '') {
						$returnValue = ($validate->maxLen($params['MAG_CAPACITY_FUSE'], 12) == false) ? null : $returnValue;
						$returnValue = ($validate->numeric($params['MAG_CAPACITY_FUSE']) == false) ? null : $returnValue;
					}
					
					if ($params['LARGE_CON_QTY'] != '') {
						$returnValue = ($validate->maxLen($params['LARGE_CON_QTY'], 12) == false) ? null : $returnValue;
						$returnValue = ($validate->numeric($params['LARGE_CON_QTY']) == false) ? null : $returnValue;
					}
					
					if ($params['LARGE_REQ_QTY'] != '') {
						$returnValue = ($validate->maxLen($params['LARGE_REQ_QTY'], 12) == false) ? null : $returnValue;
						$returnValue = ($validate->numeric($params['LARGE_REQ_QTY']) == false) ? null : $returnValue;
					}

					$fieldCheck = 0;
					foreach($expConKeys as $key=>$val) {
						foreach($val as $keyTwo=>$valTwo) {
							if (!in_array($valTwo, array('SLURRY_TN', 'OTHER_EXPLOSIVES','OTHER_UNIT'))) {

								if ($params[$valTwo] != '') {
									$returnValue = ($validate->maxLen($params[$valTwo], 12) == false) ? null : $returnValue;
									$returnValue = ($validate->numeric($params[$valTwo]) == false) ? null : $returnValue;
								}

							}
							if ($params[$valTwo] > 0) {
								$fieldCheck++;
							}
						}
					}

					// validate SLURRY_TN
					$smallQty = $params['SMALL_CON_QTY_5'];
					$largeQty = $params['LARGE_CON_QTY_5'];
					if (($smallQty != '' && $smallQty > 0) || ($largeQty != '' && $largeQty > 0)) {
						if ($params['SLURRY_TN'] == '') { $returnValue = null ; }
					}
					
					// validate SMALL_CON_QTY_5
					$slurryVal = $params['SLURRY_TN'];
					if ($slurryVal != '') {
						if ($params['SMALL_CON_QTY_5'] == '') { $returnValue = null ; }
					}
					
					// validate LARGE_CON_QTY_5
					$slurryVal = $params['SLURRY_TN'];
					if ($slurryVal != '') {
						if ($params['LARGE_CON_QTY_5'] == '') { $returnValue = null ; }
					}
					
					// validate OTHER_EXPLOSIVES
					$smallOtherQty = $params['LARGE_CON_QTY_14'];
					if ($smallOtherQty != '' && $smallOtherQty > 0) {
						if ($params['OTHER_EXPLOSIVES'] == '') { $returnValue = null ; }
					}
					
					// validate OTHER_EXPLOSIVES
					$otherExpQty = $params['OTHER_EXPLOSIVES'];
					if ($otherExpQty != '') {
						if ($params['LARGE_CON_QTY_14'] == '') { $returnValue = null ; }
					}

					if ($fieldCheck == 0 || $qtyCheck == 0) {
						// alert("Please enter details of explosive consumed, as the explosive value is entered in Part III, item 1(iv)");
						$returnValue = null ;
					}

				}
				else if ($expl_check_val == 1) {

					if ($params['MAG_CAPACITY_EXP'] != '') {
						$returnValue = ($validate->maxLen($params['MAG_CAPACITY_EXP'], 12) == false) ? null : $returnValue;
						$returnValue = ($validate->numeric($params['MAG_CAPACITY_EXP']) == false) ? null : $returnValue;
					}
						
					if ($params['MAG_CAPACITY_DET'] != '') {
						$returnValue = ($validate->maxLen($params['MAG_CAPACITY_DET'], 12) == false) ? null : $returnValue;
						$returnValue = ($validate->numeric($params['MAG_CAPACITY_DET']) == false) ? null : $returnValue;
					}
						
					if ($params['MAG_CAPACITY_FUSE'] != '') {
						$returnValue = ($validate->maxLen($params['MAG_CAPACITY_FUSE'], 12) == false) ? null : $returnValue;
						$returnValue = ($validate->numeric($params['MAG_CAPACITY_FUSE']) == false) ? null : $returnValue;
					}

					// no need to check other fields as the explosive value in Part III, item 1(iv) is either 0 or empty

					if ($qtyCheck > 0) {
						// alert("Form can't be save as the explosive value is entered in Part III, item 1(iv) is either 0 or empty");
						$returnValue = null ;
					}
				}
				else { $returnValue = null ; }

			}
			else { $returnValue = null ; }
			
			return $returnValue;
			
		}
		
		public function getExplosiveReturnsId($mineCode, $returnDate, $returnType) {

			$explosiveReturn = TableRegistry::getTableLocator()->get('ExplosiveReturn');
			$count = $explosiveReturn->find()
				->select(['id'])
				->where(["mine_code"=>$mineCode])
				->where(["return_date"=>$returnDate])
				->where(["return_type"=>$returnType])
				->count();
	
			if ($count > 0) {
				return 1;
			} else {
				return 0;
			}

		}
		
		public function deleteExplosiveReturnAnnualRecords($mineCode, $returnDate, $returnType) {

			$explosiveReturn = TableRegistry::getTableLocator()->get('ExplosiveReturn');
			$explosiveReturn->query()
				->delete()
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>$returnType])
				->execute();

		}

		/**
		 * One more OPTIONAL parameter added to below function ($calledfrom). 
		 * This was done to handle a special case where 'explosive value' in part III is zero but future consumption in Part IV is not zero.
		 * On Final submit error was being flashed. 
		 * @author Uday Shankar Singh<usingh@ubicsindia.com>
		 * @version 26th June 2015
		 */
		public function getExplosiveConsumptionId($mineCode, $returnDate, $calledfrom = 'form') {

			$query = $this->find()
				->where(["mine_code"=>$mineCode])
				->where(["return_date"=>$returnDate])
				->where(["return_type"=>'ANNUAL'])
				->toArray();

			$checkValueFlag = 0;
			foreach ($query as $data) {
			
				/* Putting the if condition as same function is being called from final submit also
				* @author Uday Shankar Singh<usingh@ubicsindia.com>
				* @version 26th June 2015
				*/
				if ($calledfrom == "finalSubmit") {
					// for final submit we need only first two
					if ($data['small_con_qty'] > 0 || $data['large_con_qty'] > 0) {
						$checkValueFlag = 1;
					}
				}
				
				/**
				 * As per the request by IBM adding the $data['SMALL_REQ_QTY'] > 0 || $data['LARGE_REQ_QTY'] > 0 into the if condition
				 * as data entered while "CON_QTY" is 0 is not getting updated in DB
				 *
				 * @author Uday Shankar Singh<usingh@ubicsindia.com>
				 * @version 23rd June 2015
				 */
				// For form we need all
				else {
					if ($data['small_con_qty'] > 0 || $data['large_con_qty'] > 0 || $data['small_req_qty'] > 0 || $data['large_req_qty'] > 0) {
						$checkValueFlag = 1;
					}
				}
			}

			return $checkValueFlag;

		}
		
		public function deleteExplosiveConsumptionAnnualRecords($mineCode, $returnDate) {

			$query = $this->query()
				->delete()
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->execute();

		}

		
		/**
		 * Check filled status of section
		 * @version 29th Oct 2021
		 * @author Aniket Ganvir
		 */
		public function isFilled($mineCode, $returnDate, $returnType) {
			
			$explosiveReturn = TableRegistry::getTableLocator()->get('ExplosiveReturn');
	        $expReturn = $explosiveReturn->find()
				->select(['mag_capacity_exp', 'mag_capacity_det', 'mag_capacity_fuse', 'total_rom_ore', 'ob_blasting'])
				->where(['return_date'=>$returnDate])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>$returnType])
				->count();
				
			$expConsum = $this->find()
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->count();
				
			if ($expReturn > 0 && $expConsum > 0) {
				return true;
			} else {
				return false;
			}

		}

	} 
?>