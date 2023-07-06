<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\Datasource\ConnectionManager;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use App\Controller\MonthlyController;
	
	class TblFinalSubmitTable extends Table{

		var $name = "TblFinalSubmit";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		/**
	     * Returns the ID of the submitted returns for the particular mine & mineral
	     * @param type $mineCode
	     * @param type $mineral
	     * @param type $returnDate
	     * @param type $returnType
	     * @return type 
	     */

		public function getReturnApplicantId($mineCode, $returnDate, $returnType = 'MONTHLY') {

	        $query = $this->find('all')
	                ->select(['applicant_id'])
	                ->where(['mine_code IS'=>$mineCode, 'return_date IS'=>$returnDate, 'return_type IS'=>$returnType])
	                ->order(['created_at'=>'ASC'])
					->limit(1)
	                ->toArray();

	        if ($query)
	            return $query;
	    }


	    public function getReturnId($mineCode, $returnDate, $returnType = 'MONTHLY') {

	        $query = $this->find('all')
	                ->select(['id'])
	                ->where(['mine_code IS'=>$mineCode, 'return_date IS'=>$returnDate, 'return_type IS'=>$returnType])
	                ->order(['created_at'=>'ASC'])
	                ->toArray();

	        if ($query)
	            return $query;
	    }

		
	    public function getLatestReturnId($mineCode, $returnDate, $returnType = 'MONTHLY') {

	        $query = $this->find()
	                ->select(['id'])
	                ->where(['mine_code'=>$mineCode, 'return_date'=>$returnDate, 'return_type'=>$returnType, 'is_latest'=>'1'])
	                ->first();

	        if ($query){
	            return $query['id'];
			} else {
				return null;
			}
	    }


        public function getReason($return_id, $mineral, $sub_min = '', $section, $user_role = null) {

			$mineral = strtolower(str_replace(' ','_',$mineral));
	        if (($sub_min == '1') || ($sub_min == '2')) {
	            if ($sub_min == '1')
	                $sub_mineral = "hematite";
	            else
	                $sub_mineral = "magnetite";
	        }else {
	            $sub_mineral = $sub_min;
	        }

	        $query = $this->find('all')
	                ->select(['rejected_section_remarks', 'rejected_section_date', 'primary_comment_remarks', 'primary_comment_date', 'status_date', 'reply', 'reply_date', 'is_latest'])
	                ->where(['id'=>$return_id])
	                ->toArray();

	        if (count($query) > 0) {
	            //if the section is not found in the 'rejected_selections' array dont display the reason
	            $rejected_section_remarks = unserialize($query[0]['rejected_section_remarks']);
	            $rejected_section_date = unserialize($query[0]['rejected_section_date']);
	            $primary_comment_remarks = ($query[0]['primary_comment_remarks'] == null) ? array() : unserialize($query[0]['primary_comment_remarks']);
	            $primary_comment_date = ($query[0]['primary_comment_date'] == null) ? array() : unserialize($query[0]['primary_comment_date']);
	            $rejected_section_replies = unserialize($query[0]['reply']);
	            $rejected_replies_date = unserialize($query[0]['reply_date']);

	            if (empty($rejected_section_remarks) && empty($primary_comment_remarks)){
	                return;
				}

				$rejected_section_remarks = ($rejected_section_remarks != '') ? $rejected_section_remarks : array(); 
				$primary_comment_remarks = ($primary_comment_remarks != '') ? $primary_comment_remarks : array(); 

	            $data = array();
	            $reason = "";
	            if ($mineral != "") {
	                if (array_key_exists($mineral, $rejected_section_remarks)) {
	                    //if mineral exists
	                    if (array_key_exists($sub_mineral, $rejected_section_remarks[$mineral])) {
	                        //if sub mineral exists
	                        if (array_key_exists($section, $rejected_section_remarks[$mineral][$sub_mineral])) {
	                            //if section exists
	                            $reason = $rejected_section_remarks[$mineral][$sub_mineral][$section];
	                        }
	                    } else {
	                        //for other ores
	                        if (array_key_exists($section, $rejected_section_remarks[$mineral])) {
	                            //if section exists
	                            $reason = $rejected_section_remarks[$mineral][$section];
	                        }
	                    }
	                }
	            } else {
	                $reason = (isset($rejected_section_remarks['partI'][$section])) ? $rejected_section_remarks['partI'][$section] : "";
	            }

	            if($rejected_section_replies == ''){
	            	$rejected_section_replies = array();
	            }

	            if ($mineral != "") {
	                if (array_key_exists($mineral, $rejected_section_replies)) {
	                    //if mineral exists
	                    if (array_key_exists($sub_mineral, $rejected_section_replies[$mineral])) {
	                        //if sub mineral exists
	                        if (array_key_exists($section, $rejected_section_replies[$mineral][$sub_mineral])) {
	                            //if section exists
	                            $reply = $rejected_section_replies[$mineral][$sub_mineral][$section];
	                        }
	                    } else {
	                        //for other ores
	                        if (array_key_exists($section, $rejected_section_replies[$mineral])) {
	                            //if section exists
	                            $reply = $rejected_section_replies[$mineral][$section];
	                        }
	                    }
	                }
	            } else {
	                $reply = (isset($rejected_section_replies['partI'][$section])) ? $rejected_section_replies['partI'][$section] : "";
	            }

	            if($rejected_replies_date == ''){
	            	$rejected_replies_date = array();
	            }
	            if ($mineral != "") {
	                if (array_key_exists($mineral, $rejected_replies_date)) {
	                    //if mineral exists
	                    if (array_key_exists($sub_mineral, $rejected_replies_date[$mineral])) {
	                        //if sub mineral exists
	                        if (array_key_exists($section, $rejected_replies_date[$mineral][$sub_mineral])) {
	                            //if section exists
	                            $reply_date = $rejected_replies_date[$mineral][$sub_mineral][$section];
	                        }
	                    } else {
	                        //for other ores
	                        if (array_key_exists($section, $rejected_replies_date[$mineral])) {
	                            //if section exists
	                            $reply_date = $rejected_replies_date[$mineral][$section];
	                        }
	                    }
	                }
	            } else {
	                $reply_date = (isset($rejected_replies_date['partI'][$section])) ? $rejected_replies_date['partI'][$section] : "";
	            }

				$rejected_section_date = ($rejected_section_date == '') ? array() : $rejected_section_date;
	            $reason_date = "";
	            if ($mineral != "") {
	                if (array_key_exists($mineral, $rejected_section_date)) {
	                    //if mineral exists
	                    if (array_key_exists($sub_mineral, $rejected_section_date[$mineral])) {
	                        //if sub mineral exists
	                        if (array_key_exists($section, $rejected_section_date[$mineral][$sub_mineral])) {
	                            //if section exists
	                            $reason_date = $rejected_section_date[$mineral][$sub_mineral][$section];
	                        }
	                    } else {
	                        //for other ores
	                        if (array_key_exists($section, $rejected_section_date[$mineral])) {
	                            //if section exists
	                            $reason_date = $rejected_section_date[$mineral][$section];
	                        }
	                    }
	                }
	            } else {
	                $reason_date = (isset($rejected_section_date['partI'][$section])) ? $rejected_section_date['partI'][$section] : "";
	            }

	            $primary_remarks = "";
	            if ($mineral != "") {
	                if (array_key_exists($mineral, $primary_comment_remarks)) {
	                    //if mineral exists
	                    if (array_key_exists($sub_mineral, $primary_comment_remarks[$mineral])) {
	                        //if sub mineral exists
	                        if (array_key_exists($section, $primary_comment_remarks[$mineral][$sub_mineral])) {
	                            //if section exists
	                            $primary_remarks = $primary_comment_remarks[$mineral][$sub_mineral][$section];
	                        }
	                    } else {
	                        //for other ores
	                        if (array_key_exists($section, $primary_comment_remarks[$mineral])) {
	                            //if section exists
	                            $primary_remarks = $primary_comment_remarks[$mineral][$section];
	                        }
	                    }
	                }
	            } else {
	                $primary_remarks = (isset($primary_comment_remarks['partI'][$section])) ? $primary_comment_remarks['partI'][$section] : "";
	            }

	            $primary_date = "";
	            if ($mineral != "") {
	                if (array_key_exists($mineral, $primary_comment_date)) {
	                    //if mineral exists
	                    if (array_key_exists($sub_mineral, $primary_comment_date[$mineral])) {
	                        //if sub mineral exists
	                        if (array_key_exists($section, $primary_comment_date[$mineral][$sub_mineral])) {
	                            //if section exists
	                            $primary_date = $primary_comment_date[$mineral][$sub_mineral][$section];
	                        }
	                    } else {
	                        //for other ores
	                        if (array_key_exists($section, $primary_comment_date[$mineral])) {
	                            //if section exists
	                            $primary_date = $primary_comment_date[$mineral][$section];
	                        }
	                    }
	                }
	            } else {
	                $primary_date = (isset($primary_comment_date['partI'][$section])) ? $primary_comment_date['partI'][$section] : "";
	            }

	            $data['reason_id'] = $return_id;
	            $data['reason'] = $reason;
	            $data['reason_date'] = $reason_date;
	            $data['reply'] = (isset($reply)) ? $reply : "";
	            $data['reply_date'] = (isset($reply_date)) ? $reply_date : "";
	            $data['primary_rsn'] = $primary_remarks;
	            $data['primary_date'] = $primary_date;

	            $date = $query[0]['status_date'];
	            $data['status_date'] = date_format($date,"Y-m-d");

	            // $status_date = explode('-', $query[0]['status_date']);
	            // $data['status_date'] = $status_date[2] . "-" . $status_date[1] . "-" . $status_date[0];

	            $commented = '0';
	            $is_latest = $query[0]['is_latest'];

	            foreach($query as $row){
	            	$data['is_latest'] = $row['is_latest'];
	            }

				$reply = (isset($reply)) ? $reply : "";
	            $current_user_comment = ($user_role == '2') ? $reason : (($user_role == '3') ? $primary_remarks : $reply);
	            if($is_latest == '1' && $current_user_comment != '' ){
	            	$commented = '1';
	            }

	            $data['commented'] = $commented;

	            return $data;
	        }
	    }

		public function getReasonAnnual($return_id, $part_no, $section, $mineral = null, $user_role = null) {

			$min_und_low = strtolower(str_replace(' ','_',$mineral)); // mineral underscore lowercase
			$query = $this->find()
				->select(['rejected_section_remarks', 'rejected_section_date', 'primary_comment_remarks', 'primary_comment_date', 'reply', 'reply_date', 'status_date', 'is_latest'])
				->where(['id'=>$return_id])
				->toArray();

	
			if (count($query) > 0) {
				//if the section is not found in the 'rejected_selections' array dont display the reason
	            $rejected_section_remarks = unserialize($query[0]['rejected_section_remarks']);
	            //print_r($rejected_section_remarks);die;
	            $rejected_section_date = unserialize($query[0]['rejected_section_date']);
	            $primary_comment_remarks = ($query[0]['primary_comment_remarks'] == null) ? array() : unserialize($query[0]['primary_comment_remarks']);
	            $primary_comment_date = ($query[0]['primary_comment_date'] == null) ? array() : unserialize($query[0]['primary_comment_date']);
	            $rejected_section_replies = unserialize($query[0]['reply']);
	            $rejected_replies_date = unserialize($query[0]['reply_date']);
	
	            if (empty($rejected_section_remarks) && empty($primary_comment_remarks)){
	                return;
				}

				$rejected_section_remarks = ($rejected_section_remarks != '') ? $rejected_section_remarks : array();
				$primary_comment_remarks = ($primary_comment_remarks != '') ? $primary_comment_remarks : array();

	            $data = array();
	            $reason = "";
	            if ($mineral != "") {
	                if (array_key_exists($part_no, $rejected_section_remarks)) {
						if (array_key_exists($section, $rejected_section_remarks[$part_no])) {
							$reason = (isset($rejected_section_remarks[$part_no][$section][$min_und_low])) ? $rejected_section_remarks[$part_no][$section][$min_und_low] : '';
						}
	                }
	            } else {
	                $reason = (isset($rejected_section_remarks[$part_no][$section])) ? $rejected_section_remarks[$part_no][$section] : "";
	            }

	            if($rejected_section_replies == ''){
	            	$rejected_section_replies = array();
	            }
	            //print_r($mineral);die;
	            if ($mineral != "") {
	                if (array_key_exists($part_no, $rejected_section_replies)) {
						if (array_key_exists($section, $rejected_section_replies[$part_no])) {
							$reply = (isset($rejected_section_replies[$part_no][$section][$min_und_low])) ? $rejected_section_replies[$part_no][$section][$min_und_low] : '';
						}
	                }
	            } else {

	                $reply = (isset($rejected_section_replies[$part_no][$section])) ? $rejected_section_replies[$part_no][$section] : "";
	            }

	            if($rejected_replies_date == ''){
	            	$rejected_replies_date = array();
	            }
	            if ($mineral != "") {
	                if (array_key_exists($part_no, $rejected_replies_date)) {
						if (array_key_exists($section, $rejected_replies_date[$part_no])) {
							$reply_date = (isset($rejected_replies_date[$part_no][$section][$min_und_low])) ? $rejected_replies_date[$part_no][$section][$min_und_low] : "" ;
						}
	                }
	            } else {
	                $reply_date = (isset($rejected_replies_date[$part_no][$section])) ? $rejected_replies_date[$part_no][$section] : "";
	            }

				$rejected_section_date = ($rejected_section_date == '') ? array() : $rejected_section_date;
	            $reason_date = "";
	            if ($mineral != "") {
	                if (array_key_exists($part_no, $rejected_section_date)) {
						if (array_key_exists($section, $rejected_section_date[$part_no])) {
							$reason_date = (isset($rejected_section_date[$part_no][$section][$min_und_low])) ? $rejected_section_date[$part_no][$section][$min_und_low] : '';
						}
	                }
	            } else {
	                $reason_date = (isset($rejected_section_date[$part_no][$section])) ? $rejected_section_date[$part_no][$section] : "";
	            }

	            $primary_remarks = "";
	            if ($mineral != "") {
	                if (array_key_exists($part_no, $primary_comment_remarks)) {
						if (array_key_exists($section, $primary_comment_remarks[$part_no])) {
							$primary_remarks = $primary_comment_remarks[$part_no][$section][$min_und_low];
						}
	                }
	            } else {
	                $primary_remarks = (isset($primary_comment_remarks[$part_no][$section])) ? $primary_comment_remarks[$part_no][$section] : "";
	            }

	            $primary_date = "";
	            if ($mineral != "") {
	                if (array_key_exists($part_no, $primary_comment_date)) {
						if (array_key_exists($section, $primary_comment_date[$part_no])) {
							$primary_date = $primary_comment_date[$part_no][$section][$min_und_low];
						}
	                }
	            } else {
	                $primary_date = (isset($primary_comment_date[$part_no][$section])) ? $primary_comment_date[$part_no][$section] : "";
	            }
				
	            $data['reason_id'] = $return_id;
	            $data['reason'] = $reason;
	            $data['reason_date'] = $reason_date;
	            $data['reply'] = (isset($reply)) ? $reply : "";
	            $data['reply_date'] = (isset($reply_date)) ? $reply_date : "";
	            $data['primary_rsn'] = $primary_remarks;
	            $data['primary_date'] = $primary_date;

	            $date = $query[0]['status_date'];
	            $data['status_date'] = date_format($date,"Y-m-d");
				
	            $commented = '0';
	            $is_latest = $query[0]['is_latest'];

	            foreach($query as $row){
	            	$data['is_latest'] = $row['is_latest'];
	            }

				$reply = (isset($reply)) ? $reply : "";
	            $current_user_comment = ($user_role == '2') ? $reason : (($user_role == '3') ? $primary_remarks : $reply);
	            if($is_latest == '1' && $current_user_comment != '' ){
	            	$commented = '1';
	            }

	            $data['commented'] = $commented;

				return $data;

			}

		}

        public function getreferedBackCount($mineCode, $returnDate, $returnType) {

	        $connection = ConnectionManager::get(Configure::read('conn'));
			$returns = $connection->execute("SELECT count(id) as total_referred_back FROM TBL_FINAL_SUBMIT WHERE mine_code = '" . $mineCode . "' AND return_type = '" . $returnType . "' AND return_date = '" . $returnDate . "' AND status = 3 AND is_latest = 1")->fetchAll('assoc');

	        return $returns[0]['total_referred_back'];
	//     $query  = Doctrine_Query::create()
	//             ->select('')
	    }

     	/**
		 * Returns true if the selected month return is already final submitted
		 * @param type $mineCode
		 * @param type $returnDate
		 * @param type $returnType
		 * @return boolean 
		 */
		public function checkIsSubmitted($mineCode, $returnDate, $returnType) {

		    $query = $this->find('all')
		            ->select(['id'])
		            ->where(['mine_code'=>$mineCode,'return_date'=>$returnDate,'return_type'=>$returnType])
		            ->toArray();

		    if (count($query) > 0) {
		        return true;
		    } else {
		        return false;
		    }
		}

	    public function updateLastSubmittedRecord($app_id, $submitted_by, $mineCode, $return_date, $returnType, $mineral_name = '') {
			
		    $query = $this->query();
			$query->update()
		            ->set(['is_latest'=>0])
		            ->where(['applicant_id'=>$app_id])
		            ->where(['submitted_by'=>$submitted_by])
		            ->where(['return_date'=>$return_date])
		            ->where(['return_type'=>$returnType])
		            ->execute();

		}

		// update form data
	    public function saveApproveReject($forms_data, $returnId = ''){

			// $dataValidatation = $this->postDataValidation($forms_data);

			// if($dataValidatation == 1 ){

	            $reason = $forms_data['reason'];
	            $submit = $forms_data['submit'];
	            $mineCode = $forms_data['mine_code'];
	            $returnDate = $forms_data['return_date'];
	            $returnType = $forms_data['return_type'];
	            $user_id = $forms_data['mms_user_id'];
	            $sec_id = $forms_data['section_id'];
	            $mineral = $forms_data['mineral'];
				$mineral = str_replace(' ','_',$mineral);
	            $sub_min = $forms_data['sub_min'];


	            if($returnId == ''){
	                $returns = $this->getReturnId($mineCode, $returnDate, $returnType);
		            $tmp = end($returns);
		            $return_id = $tmp['id'];
	            } else {
		            $return_id = $returnId;
	            }

                //check if the approval/rejection is done by Supervisor or Primary
	            $is_supervisor = false;
	            // $user_id = $_SESSION['mms_user_id'];
	            $mmsUser = TableRegistry::getTableLocator()->get('MmsUser');
	            $user = $mmsUser->findOneById($user_id);
	            $role = $user['role_id'];
	            if ($role == 2){
	                $is_supervisor = true;
	            }

	            $MonthlyController = new MonthlyController;

	            $result = false;

	            if ($submit == "approve_return") {
					
					$main_sec = $forms_data['main_sec_parse'];
	                // $approve = TBL_FINAL_SUBMITTable::approve($return_id, $mineral, $sub_min, $sec_id, $is_supervisor);
	                $result = $this->approve($return_id, $mineral, $sub_min, $sec_id, $is_supervisor, $main_sec);

	            } else if ($submit == "save_comment") {
	                $reject = $this->reject($return_id, $reason, $mineral, $sub_min, $sec_id, $is_supervisor);

	                if($reject == 1){
	                	$result = 1;
	                }

	                if ($is_supervisor == true){
	                    // $rejection_mail = $MonthlyController->Clscommon->sendRejectionMail($return_id, $this->mineCode, $this->returnDate);
	                }
	            } else if ($submit == "referred_back") {
	                $reject = $this->rejectFinalSubmit($return_id, $is_supervisor);

	                if($reject == 1){
	                	$result = 2;
	                }

	                if ($is_supervisor == true){
	                    // $rejection_mail = $MonthlyController->Clscommon->sendRejectionMail($return_id, $this->mineCode, $this->returnDate);
	                }
	            }else if ($submit == "scrutinize" && $is_supervisor != true) {
                    $reject = $this->scrutinize($return_id);

                    if($reject == 1){
                        $result = 2;
                    }

                    if ($is_supervisor != true){
                        // $rejection_mail = $MonthlyController->Clscommon->sendRejectionMail($return_id, $this->mineCode, $this->returnDate);
                    }
                }else if ($submit == "disapprove" ) {
                   
                    $main_sec = $forms_data['main_sec_parse'];
                    $result = $this->disapprove($return_id, $mineral, $sub_min, $sec_id, $is_supervisor, $main_sec);

                    
                }

	            return $result;

			// } else {
			// 	return false;
			// }

	    }

		
	    public function saveApproveRejectAnnual($forms_data, $returnId = ''){

			// $dataValidatation = $this->postDataValidation($forms_data);

			// if($dataValidatation == 1 ){

	            $reason = $forms_data['reason'];
	            $submit = $forms_data['submit'];
	            $mineCode = $forms_data['mine_code'];
	            $returnDate = $forms_data['return_date'];
	            $returnType = $forms_data['return_type'];
	            $user_id = $forms_data['mms_user_id'];
	            $sec_id = $forms_data['section_id'];
	            $part_no = $forms_data['part_no'];
	            $mineral = $forms_data['mineral'];
	            $mineral = str_replace(' ','_',$mineral);
				$sub_min = '';

	            if($returnId == ''){
	                $returns = $this->getReturnId($mineCode, $returnDate, $returnType);
		            $tmp = end($returns);
		            $return_id = $tmp['id'];
	            } else {
		            $return_id = $returnId;
	            }

                //check if the approval/rejection is done by Supervisor or Primary
	            $is_supervisor = false;
	            // $user_id = $_SESSION['mms_user_id'];
	            $mmsUser = TableRegistry::getTableLocator()->get('MmsUser');
	            $user = $mmsUser->findOneById($user_id);
	            $role = $user['role_id'];
	            if ($role == 2){
	                $is_supervisor = true;
	            }

	            $MonthlyController = new MonthlyController;

	            $result = false;

	            if ($submit == "approve_return") {
                	$main_sec = $forms_data['main_sec_parse'];
	                // $approve = TBL_FINAL_SUBMITTable::approve($return_id, $mineral, $sub_min, $sec_id, $is_supervisor);
	                $result = $this->approveAnnual($return_id, $mineral, $sub_min, $sec_id, $is_supervisor, $main_sec, $part_no);

	                /*if($approve == 1){
	                	$result = 1;
	                }*/
	            } else if ($submit == "save_comment") {
	                $reject = $this->rejectAnnualReturn($return_id, $mineral, $part_no, $sec_id, $reason, $is_supervisor);

	                if($reject == 1){
	                	$result = 1;
	                }

	                if ($is_supervisor == true){
	                    // $rejection_mail = $MonthlyController->Clscommon->sendRejectionMail($return_id, $this->mineCode, $this->returnDate);
	                }
	            } else if ($submit == "referred_back") {
	                $reject = $this->rejectFinalSubmit($return_id, $is_supervisor);

	                if($reject == 1){
	                	$result = 2;
	                }

	                if ($is_supervisor == true){
	                    // $rejection_mail = $MonthlyController->Clscommon->sendRejectionMail($return_id, $this->mineCode, $this->returnDate);
	                }
	            }
	            else if ($submit == "scrutinize" && $is_supervisor != true) {
                    $reject = $this->scrutinize($return_id);

                    if($reject == 1){
                        $result = 2;
                    }

                    if ($is_supervisor != true){
                        // $rejection_mail = $MonthlyController->Clscommon->sendRejectionMail($return_id, $this->mineCode, $this->returnDate);
                    }
                }else if ($submit == "disapprove" ) {
                   
                    $main_sec = $forms_data['main_sec_parse'];
                    $result = $this->disapproveAnnual($return_id, $mineral, $sub_min, $sec_id, $is_supervisor, $main_sec,$part_no);

                    
                }

	            return $result;

			// } else {
			// 	return false;
			// }

	    }
		
		public function rejectAnnualReturn($id, $mineral, $part_no, $section, $reason, $is_supervisor = false) {

	        $existing = $this->find('all')
				->select(['approved_sections', 'rejected_section_remarks', 'rejected_section_date', 'reply', 'primary_comment_remarks', 'primary_comment_date'])
				->where(['id'=>$id])
				->toArray();

			$min_und_low = strtolower(str_replace(' ','_', $mineral)); // mineral underscore lowercase

	        $rejected_array = array();
	        $remarks_array = array();
	        $date_array = array();
	        $primary_remark_array = array();
	        $primary_remark_date_array = array();

	        $rejected = $existing[0]['approved_sections'];
	        $remarks = $existing[0]['rejected_section_remarks'];
	        $dates = $existing[0]['rejected_section_date'];
	        $primary_remarks = $existing[0]['primary_comment_remarks'];
	        $primary_date = $existing[0]['primary_comment_date'];
	        $current_time = date('Y-m-d H:i:s');

			if ($rejected != "") {
				$rejected_array = unserialize($rejected);
				$remarks_array = unserialize($remarks);
				$date_array = unserialize($dates);
				$primary_remark_array = unserialize($primary_remarks);
				$primary_remark_date_array = unserialize($primary_date);
			}
			
			if ($mineral != '') {
				$rejected_array[$part_no][$section][$min_und_low] = "Rejected";
				$remarks_array[$part_no][$section][$min_und_low] = $reason;
				$date_array[$part_no][$section][$min_und_low] = $current_time;
				$primary_remark_array[$part_no][$section][$min_und_low] = $reason;
				$primary_remark_date_array[$part_no][$section][$min_und_low] = $current_time;
			} else {
				$rejected_array[$part_no][$section] = "Rejected";
				$remarks_array[$part_no][$section] = $reason;
				$date_array[$part_no][$section] = $current_time;
				$primary_remark_array[$part_no][$section] = $reason;
				$primary_remark_date_array[$part_no][$section] = $current_time;
			}

			// INTENTIONALLY REFFERRED BACK SECTION '5. Sales during the month'
			// IF SECTION '4. Recovery at the Smelter-Mill-Plant' IS REFFERRED BACK
			// AS SECTION '5. Sales during the month' IS DEPENDENT ON THE SECTION '4. Recovery at the Smelter-Mill-Plant'
			// Added on 21-03-2022 by Aniket G.
			if ($mineral != '') {

				$DirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
				$form_type = $DirMcpMineral->getFormNumber($mineral);

				if ($form_type == '5' && $section == 4) { // RECOVERY AT THE SMELTER/MILL/PLANT
					
					if (isset($rejected_array[$mineral][5]) && $rejected_array[$mineral][5] == 'Rejected') {
						//
					} else {
						$rejected_array[$mineral][5] = "Rejected";
						$remarks_array[$mineral][5] = "This section is intentionally referred back as '5. Sales during the month:' is dependent on '4. Recovery at the Smelter-Mill-Plant:' section";
						$date_array[$mineral][5] = $current_time;
					}

				}

			}

	        $rejected_sections = serialize($rejected_array);
	        $rejected_section_remarks = serialize($remarks_array);
	        $rejected_section_date = serialize($date_array);
	        $primary_remarks = serialize($primary_remark_array);
	        $primary_date = serialize($primary_remark_date_array);

	        $tbl_final_submit_table = TableRegistry::getTableLocator()->get('TblFinalSubmit');
			$final_submit = $tbl_final_submit_table->get($id);

			// $final_submit->approved_sections = $rejected_sections;

			if ($is_supervisor == true) {
				//by supervisor user
				$final_submit->approved_sections = $rejected_sections;
				$final_submit->rejected_section_remarks = $rejected_section_remarks;
				$final_submit->rejected_section_date = $rejected_section_date;
				//$final_submit->verified_flag = 2;
				$final_submit->status_date = date('Y-m-d');
				// $final_submit->status = 4;
			} else {
	            //by primary user
				$final_submit->primary_comment_remarks = $primary_remarks;
				$final_submit->primary_comment_date = $primary_date;
				//$final_submit->verified_flag = 1;
				$final_submit->status_date = date('Y-m-d');
				// $final_submit->status = 2;
			}

			$result = false;
	        if ($tbl_final_submit_table->save($final_submit)){
	            $result = 1;
	        }
	        return $result;
	
		}


	    /**
	     * Rejects the return
	     * 
	     * If rejected by Primary user -> Set: 'status' - 2, 'verified flag' - 1
	     * If rejected by Supervisory user -> Set: 'status' - 4, 'verified flag' - 2
	     * 
	     * @param type $id
	     * @param type $reason
	     * @param type $mineral
	     * @param type $sub_min
	     * @param type $section
	     * @param type $is_supervisor
	     * @return boolean 
	     */
	    public function reject($id, $reason, $mineral = '', $sub_min = '', $section, $is_supervisor = false) {

			$reason = htmlentities($reason,ENT_QUOTES);
			date_default_timezone_set('Asia/Kolkata');
			
	        if ($sub_min == 1){
	            $sub_mineral = 'hematite';
			}
	        else if ($sub_min == 2) {
	            $sub_mineral = 'magnetite';
			}
			else {
	            $sub_mineral = $sub_min;
			}

	        $existing = $this->find('all')
	                ->select(['approved_sections', 'rejected_section_remarks', 'rejected_section_date', 'reply', 'primary_comment_remarks', 'primary_comment_date'])
	                ->where(['id'=>$id])
	                ->toArray();

	        $rejected_array = array();
	        $remarks_array = array();
	        $date_array = array();
	        $primary_remark_array = array();
	        $primary_remark_date_array = array();

	        $rejected = $existing[0]['approved_sections'];
	        $remarks = $existing[0]['rejected_section_remarks'];
	        $dates = $existing[0]['rejected_section_date'];
	        $primary_remarks = $existing[0]['primary_comment_remarks'];
	        $primary_date = $existing[0]['primary_comment_date'];
	        $current_time = date('Y-m-d H:i:s');

	        // if ($rejected == "") {
	        //     //if empty of approved array dont need to check the existence.Just push it
	        //     if ($mineral == "") {
	        //         $rejected_array['partI'][$section] = "Rejected";
	        //         $remarks_array['partI'][$section] = $reason;
	        //         $date_array['partI'][$section] = $current_time;
	        //         $primary_remark_array['partI'][$section] = $reason;
	        //         $primary_remark_date_array['partI'][$section] = $current_time;
	        //     } else if ($mineral == 'iron_ore') {
	        //         $rejected_array[$mineral][$sub_mineral][$section] = "Rejected";
	        //         $remarks_array[$mineral][$sub_mineral][$section] = $reason;
	        //         $date_array[$mineral][$sub_mineral][$section] = $current_time;
	        //         $primary_remark_array[$mineral][$sub_mineral][$section] = $reason;
	        //         $primary_remark_date_array[$mineral][$sub_mineral][$section] = $current_time;
	        //     } else {
	        //         $rejected_array[$mineral][$section] = "Rejected";
	        //         $remarks_array[$mineral][$section] = $reason;
	        //         $date_array[$mineral][$section] = $current_time;
	        //         $primary_remark_array[$mineral][$section] = $reason;
	        //         $primary_remark_date_array[$mineral][$section] = $current_time;
	        //     }
	        // } else {

	            $rejected_array = unserialize($rejected);
	            $remarks_array = unserialize($remarks);
	            $date_array = unserialize($dates);
	            $primary_remark_array = unserialize($primary_remarks);
	            $primary_remark_date_array = unserialize($primary_date);

	            if ($mineral == "") {
	                $rejected_array['partI'][$section] = "Rejected";
	                $remarks_array['partI'][$section] = $reason;
	                $date_array['partI'][$section] = $current_time;
	                $primary_remark_array['partI'][$section] = $reason;
	                $primary_remark_date_array['partI'][$section] = $current_time;
	            } else if ($mineral == 'iron_ore') {
	                $rejected_array[$mineral][$sub_mineral][$section] = "Rejected";
	                $remarks_array[$mineral][$sub_mineral][$section] = $reason;
	                $date_array[$mineral][$sub_mineral][$section] = $current_time;
	                $primary_remark_array[$mineral][$sub_mineral][$section] = $reason;
	                $primary_remark_date_array[$mineral][$sub_mineral][$section] = $current_time;
	            } else {
	                $rejected_array[$mineral][$section] = "Rejected";
	                $remarks_array[$mineral][$section] = $reason;
	                $date_array[$mineral][$section] = $current_time;
	                $primary_remark_array[$mineral][$section] = $reason;
	                $primary_remark_date_array[$mineral][$section] = $current_time;
	            }
	        // }

			// INTENTIONALLY REFFERRED BACK SECTION '5. Sales during the month'
			// IF SECTION '4. Recovery at the Smelter-Mill-Plant' IS REFFERRED BACK
			// AS SECTION '5. Sales during the month' IS DEPENDENT ON THE SECTION '4. Recovery at the Smelter-Mill-Plant'
			// Added on 21-03-2022 by Aniket G.
			if ($mineral != '') {

				$DirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
				$form_type = $DirMcpMineral->getFormNumber($mineral);

				if ($form_type == '5' && $section == 4) { // RECOVERY AT THE SMELTER/MILL/PLANT
					
					if (isset($rejected_array[$mineral][5]) && $rejected_array[$mineral][5] == 'Rejected') {
						//
					} else {
						$rejected_array[$mineral][5] = "Rejected";
						$remarks_array[$mineral][5] = "This section is intentionally referred back as '5. Sales during the month:' is dependent on '4. Recovery at the Smelter-Mill-Plant:' section";
						$date_array[$mineral][5] = $current_time;
					}

				}

			}

	        $rejected_sections = serialize($rejected_array);
	        $rejected_section_remarks = serialize($remarks_array);
	        $rejected_section_date = serialize($date_array);
	        $primary_remarks = serialize($primary_remark_array);
	        $primary_date = serialize($primary_remark_date_array);

	        $tbl_final_submit_table = TableRegistry::getTableLocator()->get('TblFinalSubmit');
			$final_submit = $tbl_final_submit_table->get($id);

			// $final_submit->approved_sections = $rejected_sections;

			if ($is_supervisor == true) {
				//by supervisor user
				$final_submit->approved_sections = $rejected_sections;
				$final_submit->rejected_section_remarks = $rejected_section_remarks;
				$final_submit->rejected_section_date = $rejected_section_date;
				//$final_submit->verified_flag = 2;
				$final_submit->status_date = date('Y-m-d');
				// $final_submit->status = 4;
			} else {
	            //by primary user
				$final_submit->primary_comment_remarks = $primary_remarks;
				$final_submit->primary_comment_date = $primary_date;
				//$final_submit->verified_flag = 1;
				$final_submit->status_date = date('Y-m-d');
				// $final_submit->status = 2;
			}

			$result = false;
	        if ($tbl_final_submit_table->save($final_submit)){
	            $result = 1;
	        }
	        return $result;
	    }

	    // get return by return id
	    public function findReturnById($return_id) {

	        $query = $this->find('all')
	                ->where(['id'=>$return_id])
	                ->first();

            return $query;
	    }

		/**
		 * REMOVE COMMENT FROM SECTION COMMUNICATION WINDOW
		 * @addedon: 08th APR 2021 (by Aniket Ganvir)
		 */
	    public function remComment($forms_data){

			// $dataValidatation = $this->postDataValidation($forms_data);

			// if($dataValidatation == 1 ){

	            $submit = $forms_data['submit'];
	            $mineCode = $forms_data['mine_code'];
	            $returnDate = $forms_data['return_date'];
	            $returnType = $forms_data['return_type'];
	            $user_id = $forms_data['mms_user_id'];
	            $return_id = $forms_data['return_id'];
	            $section_id = $forms_data['section_id'];
	            $mineral = $forms_data['mineral'];
	            $mineral = str_replace(' ', '_', $mineral);
	            $sub_min = $forms_data['sub_min'];

                //check if the approval/rejection is done by Supervisor or Primary
	            $is_supervisor = false;
	            // $user_id = $_SESSION['mms_user_id'];
	            $mmsUser = TableRegistry::getTableLocator()->get('MmsUser');
	            $user = $mmsUser->findOneById($user_id);
	            $role = $user['role_id'];
	            if ($role == 2){
	                $is_supervisor = true;
	            }

	            $MonthlyController = new MonthlyController;

	            $result = false;

	            if ($submit == "remove_comment") {
	                $reject = $this->removeReject($return_id, $mineral, $sub_min, $section_id, $is_supervisor);
					$result = $reject;

	                if ($is_supervisor == true){
	                    // $rejection_mail = $MonthlyController->Clscommon->sendRejectionMail($return_id, $this->mineCode, $this->returnDate);
	                }
	            }

	            return $result;

			// } else {
			// 	return false;
			// }

	    }

		
		/**
		 * Remove comment from section communication window
		 * @version 06th Nov 2021
		 * @author Aniket Ganvir
		 */
	    public function remCommentAnnual($forms_data){

			// $dataValidatation = $this->postDataValidation($forms_data);

			// if($dataValidatation == 1 ){

	            $submit = $forms_data['submit'];
	            $mineCode = $forms_data['mine_code'];
	            $returnDate = $forms_data['return_date'];
	            $returnType = $forms_data['return_type'];
	            $user_id = $forms_data['mms_user_id'];
	            $return_id = $forms_data['return_id'];
	            $section_id = $forms_data['section_id'];
	            $part_no = $forms_data['part_no'];
	            $mineral = $forms_data['mineral'];
	            $sub_min = $forms_data['sub_min'];

                //check if the approval/rejection is done by Supervisor or Primary
	            $is_supervisor = false;
	            // $user_id = $_SESSION['mms_user_id'];
	            $mmsUser = TableRegistry::getTableLocator()->get('MmsUser');
	            $user = $mmsUser->findOneById($user_id);
	            $role = $user['role_id'];
	            if ($role == 2){
	                $is_supervisor = true;
	            }

	            $MonthlyController = new MonthlyController;

	            $result = false;

	            if ($submit == "remove_comment") {
	                $reject = $this->removeRejectAnnual($return_id, $part_no, $section_id, $mineral, $is_supervisor);

	                if($reject == 1){
	                	$result = 1;
	                }

	                if ($is_supervisor == true){
	                    // $rejection_mail = $MonthlyController->Clscommon->sendRejectionMail($return_id, $this->mineCode, $this->returnDate);
	                }
	            }

	            return $result;

			// } else {
			// 	return false;
			// }

	    }

	    /**
	     * REMOVE REJECT REASON FROM SECTION COMMUNICATION WINDOW
	     * @addedon: 08th APR 2021 (by Aniket Ganvir)
	     */
	    public function removeReject($id, $mineral = '', $sub_min = '', $section, $is_supervisor = false) {

			date_default_timezone_set('Asia/Kolkata');
			
	        if ($sub_min == 1) {
	            $sub_mineral = 'hematite';
			}
	        else if ($sub_min == 2) {
	            $sub_mineral = 'magnetite';
			} else {
				$sub_mineral = $sub_min;
			}

	        $existing = $this->find('all')
	                ->select(['approved_sections', 'rejected_section_remarks', 'rejected_section_date', 'reply', 'primary_comment_remarks', 'primary_comment_date'])
	                ->where(['id'=>$id])
	                ->toArray();

	        $rejected_array = array();
	        $remarks_array = array();
	        $date_array = array();
	        $primary_remark_array = array();
	        $primary_date_array = array();

	        $rejected = $existing[0]['approved_sections'];
	        $remarks = $existing[0]['rejected_section_remarks'];
	        $dates = $existing[0]['rejected_section_date'];
	        $primary_remarks = $existing[0]['primary_comment_remarks'];
	        $primary_dates = $existing[0]['primary_comment_date'];
	        $current_time = date('Y-m-d H:i:s');

            $rejected_array = unserialize($rejected);
            $remarks_array = unserialize($remarks);
            $date_array = unserialize($dates);
            $primary_remark_array = unserialize($primary_remarks);
            $primary_date_array = unserialize($primary_dates);
			
            if ($mineral == "") {
                $rejected_array['partI'][$section] = '';
                $remarks_array['partI'][$section] = '';
                $date_array['partI'][$section] = '';
                $primary_remark_array['partI'][$section] = '';
                $primary_date_array['partI'][$section] = '';
            } else if ($mineral == 'iron_ore') {
                $rejected_array[$mineral][$sub_mineral][$section] = '';
                $remarks_array[$mineral][$sub_mineral][$section] = '';
                $date_array[$mineral][$sub_mineral][$section] = '';
                $primary_remark_array[$mineral][$sub_mineral][$section] = '';
                $primary_date_array[$mineral][$sub_mineral][$section] = '';
            } else {
                $rejected_array[$mineral][$section] = '';
                $remarks_array[$mineral][$section] = '';
                $date_array[$mineral][$section] = '';
                $primary_remark_array[$mineral][$section] = '';
                $primary_date_array[$mineral][$section] = '';
            }

			if ($mineral != '' && $is_supervisor == true) {

				$DirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
				$form_type = $DirMcpMineral->getFormNumber($mineral);

				// INTENTIONALLY REMOVE COMMENT FROM SECTION '5. Sales during the month'
				// IF COMMENT IN THE SECTION '4. Recovery at the Smelter-Mill-Plant' IS REMOVED
				// AS SECTION '5. Sales during the month' IS DEPENDENT ON THE SECTION '4. Recovery at the Smelter-Mill-Plant'
				// Added on 21-03-2022 by Aniket G.
				if ($form_type == '5' && $section == 4) { // RECOVERY AT THE SMELTER/MILL/PLANT
					
					if (isset($rejected_array[$mineral][5]) && $rejected_array[$mineral][5] == 'Rejected' && $remarks_array[$mineral][5] == "This section is intentionally referred back as '5. Sales during the month:' is dependent on '4. Recovery at the Smelter-Mill-Plant:' section") {
						$rejected_array[$mineral][5] = '';
						$remarks_array[$mineral][5] = '';
						$date_array[$mineral][5] = '';
					}

				}
				
				// RESTRICT FOR DELETION OF COMMENT FROM SECTION '5. Sales during the month'
				// IF COMMENT IS PRESENT IN SECTION '4. Recovery at the Smelter-Mill-Plant'
				// AS SECTION '5. Sales during the month' IS DEPENDENT ON THE SECTION '4. Recovery at the Smelter-Mill-Plant'
				// Added on 21-03-2022 by Aniket G.
				if ($form_type == '5' && $section == 5) { // SALES DURING THE MONTH
					
					if (isset($rejected_array[$mineral][4]) && $rejected_array[$mineral][4] == 'Rejected') {
						return 2;
						exit;
					}

				}

			}
			
	        $rejected_sections = serialize($rejected_array);
	        $rejected_section_remarks = serialize($remarks_array);
	        $rejected_section_date = serialize($date_array);
	        $rejected_remarks = serialize($primary_remark_array);
	        $rejected_dates = serialize($primary_date_array);
			
	        $tbl_final_submit_table = TableRegistry::getTableLocator()->get('TblFinalSubmit');
			$final_submit = $tbl_final_submit_table->get($id);


			if ($is_supervisor == true) {
				//by supervisor user
				$final_submit->approved_sections = $rejected_sections;
				$final_submit->rejected_section_remarks = $rejected_section_remarks;
				$final_submit->rejected_section_date = $rejected_section_date;
				//$final_submit->verified_flag = 2;
				$final_submit->status_date = date('Y-m-d');
				// $final_submit->status = 4;
			} else {
	            //by primary user
				$final_submit->primary_comment_remarks = $rejected_remarks;
				$final_submit->primary_comment_date = $rejected_dates;
				//$final_submit->verified_flag = 1;
				$final_submit->status_date = date('Y-m-d');
				// $final_submit->status = 2;
			}

			$result = false;
	        if ($tbl_final_submit_table->save($final_submit)){
	            $result = 1;
	        }

	        return $result;
	    }

	    /**
	     * Remove reject reason from section communication window
	     * @version 06th Nov 2021
		 * @author Aniket Ganvir
	     */
	    public function removeRejectAnnual($id, $part_no, $section, $mineral = '', $is_supervisor = false) {
			
			$mineral = strtolower(str_replace(' ','_',$mineral));
	        $existing = $this->find('all')
				->select(['approved_sections', 'rejected_section_remarks', 'rejected_section_date', 'reply', 'primary_comment_remarks', 'primary_comment_date'])
				->where(['id'=>$id])
				->toArray();

	        $rejected_array = array();
	        $remarks_array = array();
	        $date_array = array();
	        $primary_remark_array = array();
	        $primary_date_array = array();

	        $rejected = $existing[0]['approved_sections'];
	        $remarks = $existing[0]['rejected_section_remarks'];
	        $dates = $existing[0]['rejected_section_date'];
	        $primary_remarks = $existing[0]['primary_comment_remarks'];
	        $primary_dates = $existing[0]['primary_comment_date'];
	        $current_time = date('Y-m-d H:i:s');

            $rejected_array = unserialize($rejected);
            $remarks_array = unserialize($remarks);
            $date_array = unserialize($dates);
            $primary_remark_array = unserialize($primary_remarks);
            $primary_date_array = unserialize($primary_dates);

			if ($mineral != '') {
				$rejected_array[$part_no][$section][$mineral] = '';
				$remarks_array[$part_no][$section][$mineral] = '';
				$date_array[$part_no][$section][$mineral] = '';
				$primary_remark_array[$part_no][$section][$mineral] = '';
				$primary_date_array[$part_no][$section][$mineral] = '';
			} else {
				$rejected_array[$part_no][$section] = '';
				$remarks_array[$part_no][$section] = '';
				$date_array[$part_no][$section] = '';
				$primary_remark_array[$part_no][$section] = '';
				$primary_date_array[$part_no][$section] = '';
			}

	        $rejected_sections = serialize($rejected_array);
	        $rejected_section_remarks = serialize($remarks_array);
	        $rejected_section_date = serialize($date_array);
	        $rejected_remarks = serialize($primary_remark_array);
	        $rejected_dates = serialize($primary_date_array);

	        $tbl_final_submit_table = TableRegistry::getTableLocator()->get('TblFinalSubmit');
			$final_submit = $tbl_final_submit_table->get($id);


			if ($is_supervisor == true) {
				//by supervisor user
				$final_submit->approved_sections = $rejected_sections;
				$final_submit->rejected_section_remarks = $rejected_section_remarks;
				$final_submit->rejected_section_date = $rejected_section_date;
				//$final_submit->verified_flag = 2;
				$final_submit->status_date = date('Y-m-d');
				// $final_submit->status = 4;
			} else {
	            //by primary user
				$final_submit->primary_comment_remarks = $rejected_remarks;
				$final_submit->primary_comment_date = $rejected_dates;
				//$final_submit->verified_flag = 1;
				$final_submit->status_date = date('Y-m-d');
				// $final_submit->status = 2;
			}

			$result = false;
	        if ($tbl_final_submit_table->save($final_submit)){
	            $result = 1;
	        }

	        return $result;
	    }


		/**
		 * REMOVE APPLICANT REPLY FROM SECTION COMMUNICATION WINDOW
		 * @addedon: 08th APR 2021 (by Aniket Ganvir)
		 */
	    public function remReply($forms_data){

			// $dataValidatation = $this->postDataValidation($forms_data);

			// if($dataValidatation == 1 ){

	            $submit = $forms_data['submit'];
	            $mineCode = $forms_data['mine_code'];
	            $returnDate = $forms_data['return_date'];
	            $returnType = $forms_data['return_type'];
	            $user_id = $forms_data['mms_user_id'];
	            $return_id = $forms_data['return_id'];
	            $part_no = $forms_data['part_no'];
	            $section_id = $forms_data['section_id'];
	            $mineral = $forms_data['mineral'];
	            $sub_min = $forms_data['sub_min'];

	            $result = false;

	            if ($submit == "remove_comment") {
	            	if($returnType =='ANNUAL' )
	            	{
	                $reject = $this->removeRejectReplyAnnual($return_id, $mineral, $sub_min, $part_no, $section_id);

	            	}else{

	                $reject = $this->removeRejectReply($return_id, $mineral, $sub_min, $part_no, $section_id);
	            	}

	                if($reject == 1){
	                	$result = 1;
	                }

	            }

	            return $result;

			// } else {
			// 	return false;
			// }

	    }

	    /**
	     * REMOVE APPLICANT REPLY FROM SECTION COMMUNICATION WINDOW
	     * @addedon: 08th APR 2021 (by Aniket Ganvir)
	     */
	    public function removeRejectReply($id, $mineral = '', $sub_min = '', $part_no, $section) {

			date_default_timezone_set('Asia/Kolkata');
			$mineral = strtolower(str_replace(' ','_',$mineral));
			$part_no = ($part_no == '') ? 'partI' : $part_no;
			
	        if ($sub_min == 1) {
	            $sub_mineral = 'hematite';
			} else if ($sub_min == 2) {
	            $sub_mineral = 'magnetite';
			} else {
	            $sub_mineral = $sub_min;
			}

	        $existing = $this->find('all')
	                ->select(['reply', 'reply_date'])
	                ->where(['id'=>$id])
	                ->toArray();

	        $remarks_array = array();
	        $date_array = array();

	        $remarks = $existing[0]['reply'];
	        $dates = $existing[0]['reply_date'];

            $remarks_array = unserialize($remarks);
            $date_array = unserialize($dates);

            if ($mineral == "") {
                $remarks_array[$part_no][$section] = '';
                $date_array[$part_no][$section] = '';
            } else if ($mineral == 'iron_ore') {
                $remarks_array[$mineral][$sub_mineral][$section] = '';
                $date_array[$mineral][$sub_mineral][$section] = '';
            } else {
                $remarks_array[$mineral][$section] = '';
                $date_array[$mineral][$section] = '';
            }

	        $rejected_section_remarks = serialize($remarks_array);
	        $rejected_section_date = serialize($date_array);

	        $tbl_final_submit_table = TableRegistry::getTableLocator()->get('TblFinalSubmit');
			$final_submit = $tbl_final_submit_table->get($id);

			$final_submit->reply = $rejected_section_remarks;
			$final_submit->reply_date = $rejected_section_date;

			$result = false;
	        if ($tbl_final_submit_table->save($final_submit)){
	            $result = 1;
	        }

	        return $result;
	    } 
	    /**
	     * REMOVE APPLICANT REPLY FROM SECTION COMMUNICATION WINDOW
	     * @addedon: 08th APR 2021 (by Aniket Ganvir)
	     */
	    public function removeRejectReplyAnnual($id, $mineral = '', $sub_min = '', $part_no, $section) {
	    	//die;

			date_default_timezone_set('Asia/Kolkata');
			$mineral = strtolower(str_replace(' ','_',$mineral));
			$part_no = ($part_no == '') ? 'partI' : $part_no;
			
	        $existing = $this->find('all')
	                ->select(['reply', 'reply_date'])
	                ->where(['id'=>$id])
	                ->toArray();

	        $remarks_array = array();
	        $date_array = array();

	        $remarks = $existing[0]['reply'];
	        $dates = $existing[0]['reply_date'];

            $remarks_array = unserialize($remarks);
            $date_array = unserialize($dates);

            if ($mineral == "") {
                $remarks_array[$part_no][$section] = '';
                $date_array[$part_no][$section] = '';
            } else {
                $remarks_array[$part_no][$section][$mineral] = '';
                $date_array[$part_no][$section][$mineral] = '';
            }

	        $rejected_section_remarks = serialize($remarks_array);
	        $rejected_section_date = serialize($date_array);

	        $tbl_final_submit_table = TableRegistry::getTableLocator()->get('TblFinalSubmit');
			$final_submit = $tbl_final_submit_table->get($id);

			$final_submit->reply = $rejected_section_remarks;
			$final_submit->reply_date = $rejected_section_date;

			$result = false;
	        if ($tbl_final_submit_table->save($final_submit)){
	            $result = 1;
	        }

	        return $result;
	    }


	    /**
	     * Rejects the return
	     */
	    public function rejectFinalSubmit($id, $is_supervisor = false) {

			date_default_timezone_set('Asia/Kolkata');
			
	        $current_time = date('Y-m-d H:i:s');

	        $tbl_final_submit_table = TableRegistry::getTableLocator()->get('TblFinalSubmit');
			$final_submit = $tbl_final_submit_table->get($id);

			if ($is_supervisor == true) {
				//by supervisor user
				// $final_submit->verified_flag = 2;
				$final_submit->status_date = date('Y-m-d');
				$final_submit->status = 4;

				// RESET SECTION '5. Sales during the month'
				// IF SECTION '4. Recovery at the Smelter-Mill-Plant' IS REFFERRED BACK
				// AS SECTION '5. Sales during the month' IS DEPENDENT ON THE SECTION '4. Recovery at the Smelter-Mill-Plant'
				// Added on 26-03-2022 by AG.
				$data = $tbl_final_submit_table->findReturnById($id);
				$mineCode = $data['mine_code'];
				$returnDate = $data['return_date'];
				$returnType = $data['return_type'];
				$MineralWorked = TableRegistry::getTableLocator()->get('MineralWorked');
				$minerals = $MineralWorked->fetchMineralInfo($mineCode);
				foreach ($minerals as $mineral) {
					$mineralArr[] = $mineral['mineral_name'];
				}
				foreach($mineralArr as $min) {
					
					$min = strtolower(str_replace(' ','_',$min));
					$mineral = str_replace('_',' ',$min);
					$DirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
					$form_type = $DirMcpMineral->getFormNumber($min);
					if ($form_type == '5') {
						$rejected_array = array();
						$rejected = $data['approved_sections'];
						$rejected_array = unserialize($rejected);
						if (isset($rejected_array[$min][4]) && $rejected_array[$min][4] == 'Rejected') {
							
							$Sale5 = TableRegistry::getTableLocator()->get('Sale5');
							$query = $Sale5->query();
							$query->delete()
								->where(['mine_code'=>$mineCode])
								->where(['return_date'=>$returnDate])
								->where(['return_type'=>$returnType])
								->where(['mineral_name'=>$mineral])
								->execute();

						}
					}

				}

			} else {
	            //by primary user
				 //$final_submit->verified_flag = 1;
				// $final_submit->status_date = date('Y-m-d');
				$final_submit->status = 2;
			}
			//print_r($final_submit);die;
			$result = false;
	        if ($tbl_final_submit_table->save($final_submit)){
	            $result = 1;
	        }
	        return $result;
	    }

	    /**
	     * GET LATEST REASONS
	     * @addedon: 12th APR 2021 (by Aniket Ganvir)
	     */
	    public function getLatestReasons($mineCode, $returnDate, $returnType = 'MONTHLY') {

	        $query = $this->find('all')
	                ->select(['rejected_section_remarks'])
	                ->where(['mine_code IS'=>$mineCode, 'return_date IS'=>$returnDate, 'return_type IS'=>$returnType, 'is_latest'=>'1'])
	                ->first();

            return $query;
	    }


	    /**
	     * For Approved Returns:
	     *  verified flag - 2
	     *  status - 1
	     * 
	     * For Rejected/Reffered back returns:
	     *  verified flag - 2
	     *  status - 2
	     * 
	     * @param type $userId
	     * @param type $submitted_by
	     * @param type $status
	     * @return type 
	     */
	    public function returnCount($app_id, $submitted_by, $status, $return_type = 'MONTHLY') {

	        if ($submitted_by != "")
	            $where_clause = "AND submitted_by = '" . $submitted_by . "'";

	        $con = ConnectionManager::get(Configure::read('conn'));
	        $returns = $con->execute("SELECT status FROM (SELECT * FROM TBL_FINAL_SUBMIT 
	      	WHERE applicant_id = ? AND return_type = ? " . $where_clause . " ORDER BY created_at DESC) m 
	        GROUP BY return_date, mine_code", array($app_id, $return_type))->fetchAll('assoc');

	        // $q = $con->execute("SELECT status FROM (SELECT * FROM TBL_FINAL_SUBMIT WHERE applicant_id = ? AND return_type = ? " . $where_clause . " ORDER BY created_at DESC) m GROUP BY return_date, mine_code", array($app_id, $return_type));

	        $status_returns = array();
	        foreach ($returns as $a) {
	            if ($a['status'] == $status)
	                $status_returns[] = $a;
	        }

	        $total_returns = count($status_returns);

	        return $total_returns;
	    }


	    /**
	     * Returns the rejected returns for the mine owner
	     * @param type $owner_id
	     * @return string 
	     */
	    public function getRejectedReturnsOwner($owner_id, $return_type = 'MONTHLY') {

	        $con = ConnectionManager::get(Configure::read('conn'));
	        $q = $con->execute("SELECT *, count(id) as total_referred_back FROM (SELECT * FROM TBL_FINAL_SUBMIT 
	      WHERE applicant_id LIKE ? AND verified_flag = 2 AND status = 4 AND is_latest = 1 
	        AND return_type = ? ORDER BY created_at DESC) m 
	        GROUP BY return_date, mine_code", array($owner_id . '/%', $return_type));

	        $returns = $q->fetchAll('assoc');

	        $data = array();
	        $i = 0;
	        foreach ($returns as $r) {
	            $data[$i]['return_id'] = $r['id'];
	            $data[$i]['mine_code'] = $r['mine_code'];

	            $temp = explode(' ', $r['created_at']);
	            $created_at = explode('-', $temp[0]);
	            $data[$i]['final_submitted_date'] = $created_at[2] . "-" . $created_at[1] . "-" . $created_at[0];

	            $data[$i]['return_type'] = $r['return_type'];
	            $data[$i]['return_date'] = $r['return_date'];

	            $date = $r['return_date'];
	            $tmp = explode('-', $date);
	            $year = $tmp[0];
	            $month = date("M", mktime(0, 0, 0, $tmp[1], 1, $year));
	            $data[$i]['month_year'] = $month . " / " . $year;

	            $tmp_status_date = explode('-', $r['status_date']);
	            $status_date = $tmp_status_date[2] . "-" . $tmp_status_date[1] . "-" . $tmp_status_date[0];
	            $data[$i]['status_date'] = ($status_date != "00-00-0000") ? $status_date : "--";

	            $data[$i]['total_referred_back'] = $r['total_referred_back'];


	            $approved_sections = unserialize($r['approved_sections']);

	            //if pending dont need to show the rejected sections
	            if ($r['status'] != 0)
	                $data[$i]['rejected_sections'] = $this->getRejectedSectionNames($approved_sections, $r['mine_code']);
	            else
	                $data[$i]['rejected_sections'] = "--";

	            $i++;
	        }

	        return $data;
	    }


	    /**
	     * Returns the names of the rejected sections with comma seperated.
	     * @param type $approved_sections
	     * @param type $mine_code
	     * @return string 
	     */
	    public function getRejectedSectionNames($approved_sections, $mine_code) {

	        $mineralWorked = TableRegistry::getTableLocator()->get('MineralWorked');
	        $dirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
	        $mins = $mineralWorked->fetchMineralInfo($mine_code);

	        $minerals = array();
	        foreach ($mins as $m) {
	            $mineral_names[] = ucwords(strtolower($m['mineral_name']));
	            $minerals[] = strtolower(str_replace(' ', '_', $m['mineral_name']));
	        }

	        $string = array();
	        $part1 = array('Details of the Mine', 'Name and Address', 'Details of Rent/Royalty', 'Details on Working', 'Average Daily Employment');
	        $part2 = array('Production/Stocks ROM', 'Grade-wise Production', 'Details of Deductions', 'Sales/Dispatches', 'Pulverization');
	        $f5part2 = array('Production/Stocks ROM', 'Ex-mine price', 'Recoveries at Concentrator', 'Recovery at the smelter', 'Sales(Metals/By Product)', 'Details of Deductions', 'Sales/Dispatches');
	        $f6part2 = array('Production, Despatches and Stocks', 'Details of Deductions', 'Sales/Dispatches');
	        $f7part2 = array('Production/Stocks ROM', 'Production, Despatches and Stocks', 'Details of Deductions', 'Sales/Dispatches');


	        for ($j = 0; $j < count($minerals); $j++) {

	            for ($k = 1; $k <= 5; $k++) {
	                if ($approved_sections['partI'][$k] == "Rejected") {
	                    if (!in_array($part1[$k - 1], $string))
	                        $string[] = $part1[$k - 1];
	                }
	            }

	            if ($minerals[$j] == "iron_ore") {
	                for ($k = 1; $k <= 4; $k++) {
	                    if ($approved_sections[$minerals[$j]]['hematite'][$k] == "Rejected") {
	                        $string[] = $part2[$k - 1] . " (Hematite)";
	                    }
	                }

	                for ($k = 1; $k <= 4; $k++) {
	                    if ($approved_sections[$minerals[$j]]['magnetite'][$k] == "Rejected") {
	                        $string[] = $part2[$k - 1] . " (Magnetite)";
	                    }
	                }
	            } else {
	                $formNo = $dirMcpMineral->getFormNumber($minerals[$j]);
	                if ($formNo == 5) {
	                    for ($k = 1; $k <= count($f5part2); $k++) {
	                        if ($approved_sections[$minerals[$j]][$k] == "Rejected") {
	                            $string[] = $f5part2[$k - 1] . " (" . $mineral_names[$j] . ")";
	                        }
	                    }
	                } else if ($formNo == 6) {
	                    for ($k = 1; $k <= count($f6part2); $k++) {
	                        if ($approved_sections[$minerals[$j]][$k] == "Rejected") {
	                            $string[] = $f6part2[$k - 1] . " (" . $mineral_names[$j] . ")";
	                        }
	                    }
	                } else if ($formNo == 7) {
	                    for ($k = 1; $k <= count($f7part2); $k++) {
	                        if ($approved_sections[$minerals[$j]][$k] == "Rejected") {
	                            $string[] = $f7part2[$k - 1] . " (" . $mineral_names[$j] . ")";
	                        }
	                    }
	                } else {
	                    for ($k = 1; $k <= count($part2); $k++) {
	                        if ($approved_sections[$minerals[$j]][$k] == "Rejected") {
	                            $string[] = $part2[$k - 1] . " (" . $mineral_names[$j] . ")";
	                        }
	                    }
	                }
	            }
	        }

	        $rejected_minerals = implode(', ', $string);

	        if ($rejected_minerals == "")
	            $rejected_minerals = "--";

	        return $rejected_minerals;
	    }


	    /**
	     * Returns the rejected returns to the mine user's view.
	     * @param type $app_id
	     * @param type $submitted_by
	     * @return string 
	     */
	    public function getRejectedReturns($app_id, $submitted_by = '', $return_type = 'MONTHLY') {

	        if ($submitted_by != "")
	            $where_clause = "AND submitted_by = '" . $submitted_by . "'";

	        $con = ConnectionManager::get(Configure::read('conn'));
	        $q = $con->execute("SELECT *, count(id) as total_referred_back FROM (SELECT * FROM TBL_FINAL_SUBMIT 
	      WHERE applicant_id = ? AND verified_flag = 2 
	      " . $where_clause . " AND status = 4 AND is_latest = 1 AND return_type = ?
	        ORDER BY created_at DESC) m 
	        GROUP BY return_date, mine_code", array($app_id, $return_type));

	        $returns = $q->fetchAll('assoc');

	        $data = array();
	        $i = 0;
	        foreach ($returns as $r) {
	            $data[$i]['return_id'] = $r['id'];
	            $data[$i]['mine_code'] = $r['mine_code'];
	            $data[$i]['return_date'] = $r['return_date'];
	            $data[$i]['return_type'] = $r['return_type'];

	            $dateQuery = $this->find('all')
	                    ->select(['created_at'])
	                    ->where(['mine_code'=>$data[$i]['mine_code'],'return_date'=>$data[$i]['return_date']])
	                    ->order(['created_at'=>'ASC'])
	                    ->limit(1)
	                    ->toArray();
	            // $datestatusQuery = $this->find('all')
	            //         ->select(['count(mine_code) as mcode','updated_at'])
	            //         ->where(['mine_code'=>$data[$i]['mine_code'],'return_type IS'=>$data[$i]['return_type'],'return_date'=>$data[$i]['return_date']])
	            //         ->order(['created_at'=>'ASC'])
	            //         ->toArray();
	            $datestatusQuery = $con->execute("SELECT count(mine_code) as mcode, updated_at FROM tbl_final_submit WHERE mine_code = '".$data[$i]['mine_code']."' AND return_type = '".$data[$i]['return_type']."' AND return_date = '".$data[$i]['return_date']."' ORDER BY created_at ASC ")->fetchAll('assoc');

	            $data[$i]['re_submit'] = $datestatusQuery[0]['mcode'];
	            $data[$i]['re_update'] = $datestatusQuery[0]['updated_at']; //add

	            // $temp = explode(' ', $dateQuery[0]['created_at']);
	            // $created_at = explode('-', $temp[0]);
	            // $data[$i]['final_submitted_date'] = $created_at[2] . "-" . $created_at[1] . "-" . $created_at[0];
	            $data[$i]['final_submitted_date'] = date('d-m-Y',strtotime($dateQuery[0]['created_at']));

	            $data[$i]['return_type'] = $r['return_type'];

	            $date = $r['return_date'];
	            $tmp = explode('-', $date);
	            $year = $tmp[0];
	            $month = date("M", mktime(0, 0, 0, $tmp[1], 1, $year));
	            $data[$i]['month_year'] = $month . " / " . $year;

	            $status = $r['status'];
	            $data[$i]['status'] = $status;

	            $tmp_status_date = explode('-', $r['status_date']);
	            $status_date = $tmp_status_date[2] . "-" . $tmp_status_date[1] . "-" . $tmp_status_date[0];
	            $data[$i]['status_date'] = ($status_date != "00-00-0000") ? $status_date : "--";

	            $data[$i]['total_referred_back'] = $r['total_referred_back'];

	            $approved_sections = unserialize($r['approved_sections']);

	            //if pending dont need to show the rejected sections
	            if ($r['status'] != 0) {
	                if ($r['return_type'] == 'ANNUAL')
	                    $data[$i]['rejected_sections'] = $this->getRejectedSectionNamesAnnual($approved_sections, $r['mine_code']);
	                else
	                    $data[$i]['rejected_sections'] = $this->getRejectedSectionNames($approved_sections, $r['mine_code']);
	            }else
	                $data[$i]['rejected_sections'] = "--";

	            $i++;
	        }

	        return $data;
	    }


	    public function getRejectedSectionNamesAnnual($approved_sections, $mine_code) {

	        $mineralWorked = TableRegistry::getTableLocator()->get('MineralWorked');
	        $dirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
	        $mins = $mineralWorked->fetchMineralInfo($mine_code);
	        $minerals = array();
	        foreach ($mins as $m) {
	            $mineral_names[] = ucwords(strtolower($m['mineral_name']));
	            $minerals[] = strtolower(str_replace(' ', '_', $m['mineral_name']));
	        }

	        $string = array();
	        $part1 = array('Details of the Mine', 'Name and Address', 'Particulars of area operated', 'Lease Area Utilisation');
	        $part2 = array('Employment & Wages(I)', 'Capital Structure', 'Employment & Wages(II)');
	        $part3 = array('Quantity & Cost of Material', 'Royalty/Compensation/Depriciation', 'Taxes/Other Expenses');
	        $part4 = array('Consumption of Explosives');
	        $part5 = array('Sec 1/2', 'Sec 4', 'Sec 5/6/7/8/9', 'Sec3', 'Sec 4 - Mineral Rejects', 'Sec 7');
	//    $part5 = array('Sec 1/2', 'Sec3', 'Sec 4', 'Sec 5/6/8/9', 'Sec 7', 'Mineral Rejects');
	        $part6 = array('Production/Stocks ROM', 'Grade-wise Production', 'Details of Deductions', 'Sales/Dispatches', 'Pulverization');
	        $f5part6 = array('Production/Stocks ROM', 'Ex-mine price', 'Recoveries at Concentrator', 'Recovery at the smelter', 'Sales(Metals/By Product)', 'Details of Deductions', 'Sales/Dispatches');
	        $f6part6 = array('Production, Despatches and Stocks', 'Details of Deductions', 'Sales/Dispatches');
	        $f7part6 = array('Production/Stocks ROM', 'Production, Despatches and Stocks', 'Details of Deductions', 'Sales/Dispatches');
	        $part7 = array('Cost of Production');


	        for ($j = 0; $j < count($minerals); $j++) {

	            //part1
	            for ($k = 1; $k <= 4; $k++) {
	                if ($approved_sections['partI'][$k] == "Rejected") {
	                    if (!in_array($part1[$k - 1], $string))
	                        $string[] = $part1[$k - 1];
	                }
	            }

	            //part2
	            for ($k = 1; $k <= 3; $k++) {
	                if ($approved_sections['partII'][$k] == "Rejected") {
	                    if (!in_array($part2[$k - 1], $string))
	                        $string[] = $part2[$k - 1];
	                }
	            }

	            //part3
	            for ($k = 1; $k <= 3; $k++) {
	                if ($approved_sections['partIII'][$k] == "Rejected") {
	                    if (!in_array($part3[$k - 1], $string))
	                        $string[] = $part3[$k - 1];
	                }
	            }

	            //part4
	            if ($approved_sections['partIV'][1] == "Rejected") {
	                if (!in_array($part4[0], $string))
	                    $string[] = $part4[0];
	            }

	            //part5
	            for ($k = 1; $k <= 6; $k++) {
	                if ($approved_sections['partV'][$k] == "Rejected") {
	                    if (!in_array($part5[$k - 1], $string))
	                        $string[] = $part5[$k - 1];
	                }
	            }

	            //part6
	            if ($minerals[$j] == "iron_ore") {
	                for ($k = 1; $k <= 4; $k++) {
	                    if ($approved_sections[$minerals[$j]]['hematite'][$k] == "Rejected") {
	                        $string[] = $part6[$k - 1] . " (Hematite)";
	                    }
	                }

	                for ($k = 1; $k <= 4; $k++) {
	                    if ($approved_sections[$minerals[$j]]['magnetite'][$k] == "Rejected") {
	                        $string[] = $part6[$k - 1] . " (Magnetite)";
	                    }
	                }
	            } else {
	                $formNo = $dirMcpMineral->getFormNumber($minerals[$j]);
	                if ($formNo == 5) {
	                    for ($k = 1; $k <= count($f5part6); $k++) {
	                        if ($approved_sections[$minerals[$j]][$k] == "Rejected") {
	                            $string[] = $f5part6[$k - 1] . " (" . $mineral_names[$j] . ")";
	                        }
	                    }
	                } else if ($formNo == 6) {
	                    for ($k = 1; $k <= count($f6part6); $k++) {
	                        if ($approved_sections[$minerals[$j]][$k] == "Rejected") {
	                            $string[] = $f6part6[$k - 1] . " (" . $mineral_names[$j] . ")";
	                        }
	                    }
	                } else if ($formNo == 7) {
	                    for ($k = 1; $k <= count($f7part6); $k++) {
	                        if ($approved_sections[$minerals[$j]][$k] == "Rejected") {
	                            $string[] = $f7part6[$k - 1] . " (" . $mineral_names[$j] . ")";
	                        }
	                    }
	                } else {
	                    for ($k = 1; $k <= count($part6); $k++) {
	                        if ($approved_sections[$minerals[$j]][$k] == "Rejected") {
	                            $string[] = $part6[$k - 1] . " (" . $mineral_names[$j] . ")";
	                        }
	                    }
	                }
	            }

	            //part7
	            if ($approved_sections['partVII'][1] == "Rejected") {
	                if (!in_array($part7[0], $string))
	                    $string[] = $part7[0];
	            }
	        }

	        $rejected_minerals = implode(', ', $string);

	        if ($rejected_minerals == "")
	            $rejected_minerals = "--";

	        return $rejected_minerals;
	    }

		// udpate/save applicant communication reply
	    public function saveApplicantReply($forms_data, $returnId = ''){

			$dataValidatation = $this->postReplyValidation($forms_data);

			if($dataValidatation == 1 ){

	            $reason = $forms_data['reason'];
	            $submit = $forms_data['submit'];
	            $mineCode = $forms_data['mine_code'];
	            $returnDate = $forms_data['return_date'];
	            $returnType = $forms_data['return_type'];
	            $user_id = $forms_data['mms_user_id'];
	            $sec_id = $forms_data['section_id'];
	            $mineral = $forms_data['mineral'];
	            $sub_min = $forms_data['sub_min'];

	            if($returnId == ''){
	                $returns = $this->getReturnId($mineCode, $returnDate, $returnType);
		            $tmp = end($returns);
		            $return_id = $tmp['id'];
	            } else {
		            $return_id = $returnId;
	            }

	            $result = false;

	            if ($submit == "save_comment") {
	                $reject = $this->saveReply($return_id, $reason, $mineral, $sub_min, $sec_id);

	                if($reject == 1){
	                	$result = 1;
	                }
	            }

	            return $result;

			} else {
				return false;
			}

	    }

	    // validate post reply by end/mine user
	    public function postReplyValidation($forms_data){
			
			$returnValue = 1;
			
			if(empty($forms_data['reason'])){ $returnValue = null ; }
			
			return $returnValue;
			
		}

		/**
		 * Save/update applicant reply in annual return
		 * @version 09th Nov 2021
		 * @author Aniket Ganvir
		 */
	    public function saveApplicantReplyAnnual($forms_data, $returnId = ''){

			$dataValidatation = $this->postReplyValidation($forms_data);

			if($dataValidatation == 1 ){

	            $reason = $forms_data['reason'];
	            $submit = $forms_data['submit'];
	            $mineCode = $forms_data['mine_code'];
	            $returnDate = $forms_data['return_date'];
	            $returnType = $forms_data['return_type'];
	            $user_id = $forms_data['mms_user_id'];
	            $sec_id = $forms_data['section_id'];
	            $part_no = $forms_data['part_no'];
	            $mineral = $forms_data['mineral'];
	            $sub_min = $forms_data['sub_min'];

	            if($returnId == ''){
	                $returns = $this->getReturnId($mineCode, $returnDate, $returnType);
		            $tmp = end($returns);
		            $return_id = $tmp['id'];
	            } else {
		            $return_id = $returnId;
	            }

	            $result = false;

	            if ($submit == "save_comment") {
	                $reject = $this->saveReplyAnnual($return_id, $reason, $part_no, $sec_id, $mineral);

	                if($reject == 1){
	                	$result = 1;
	                }
	            }

	            return $result;

			} else {
				return false;
			}

	    }


	    /**
	     * Rejects the return
	     * 
	     * If rejected by Primary user -> Set: 'status' - 2, 'verified flag' - 1
	     * If rejected by Supervisory user -> Set: 'status' - 4, 'verified flag' - 2
	     * 
	     * @param type $id
	     * @param type $reason
	     * @param type $mineral
	     * @param type $sub_min
	     * @param type $section
	     * @param type $is_supervisor
	     * @return boolean 
	     */
	    public function saveReply($id, $reason, $mineral = '', $sub_min = '', $section) {

			$reason = htmlentities($reason, ENT_QUOTES);
			date_default_timezone_set('Asia/Kolkata');
			$mineral = strtolower(str_replace(' ','_',$mineral));
			
	        if ($sub_min == 1) {
	            $sub_mineral = 'hematite';
			}
	        else if ($sub_min == 2) {
				$sub_mineral = 'magnetite';
			}
			else {
	            $sub_mineral = $sub_min;
			}

	        $existing = $this->find('all')
	                ->select(['approved_sections', 'rejected_section_remarks', 'rejected_section_date', 'reply', 'reply_date', 'primary_comment_remarks', 'primary_comment_date'])
	                ->where(['id'=>$id])
	                ->toArray();

	        $reply_array = array();
	        $date_array = array();

	        $reply = $existing[0]['reply'];
	        $dates = $existing[0]['reply_date'];
	        $current_time = date('Y-m-d H:i:s');
			
	        if ($reply == "") {
	            //if empty of approved array dont need to check the existence.Just push it
	            if ($mineral == "") {
	                $reply_array['partI'][$section] = $reason;
	                $date_array['partI'][$section] = $current_time;
	            } else if ($mineral == 'iron_ore') {
	                $reply_array[$mineral][$sub_mineral][$section] = $reason;
	                $date_array[$mineral][$sub_mineral][$section] = $current_time;
	            } else {
	                $reply_array[$mineral][$section] = $reason;
	                $date_array[$mineral][$section] = $current_time;
	            }
	        } else {

	            $reply_array = unserialize($reply);
	            $date_array = unserialize($dates);

	            if ($mineral == "") {
	                $reply_array['partI'][$section] = $reason;
	                $date_array['partI'][$section] = $current_time;
	            } else if ($mineral == 'iron_ore') {
	                $reply_array[$mineral][$sub_mineral][$section] = $reason;
	                $date_array[$mineral][$sub_mineral][$section] = $current_time;
	            } else {
	                $reply_array[$mineral][$section] = $reason;
	                $date_array[$mineral][$section] = $current_time;
	            }
	        }
			
	        $reply_sections = serialize($reply_array);
	        $date_sections = serialize($date_array);

	        $tbl_final_submit_table = TableRegistry::getTableLocator()->get('TblFinalSubmit');
			$final_submit = $tbl_final_submit_table->get($id);

			$final_submit->reply = $reply_sections;
			$final_submit->reply_date = $date_sections;

			$result = false;
	        if ($tbl_final_submit_table->save($final_submit)){
	            $result = 1;
	        }
	        return $result;
	    }

	    // CHECK END/MINE USER SECTION REPLIED STATUS
	    // @addedon: 19th APR 2021
	    public function checkReplyStatus($mineCode, $returnType, $returnDate){

	        $result = $this->find('all')
	                ->where(['mine_code'=>$mineCode, 'return_date'=>$returnDate, 'return_type'=>$returnType, 'is_latest'=>'1'])
	                ->limit(1)
					->toArray();

			if(count($result) == 0){
				$approved_sections = array();
				$reply = array();
			} else {
				$approved_sections = unserialize($result[0]['approved_sections']);
				$reply = unserialize($result[0]['reply']);
			}

			//print_r($reply);die;
			$reply_status = 1;

			// set array if $approved_sections is blank
			$approved_sections = ($approved_sections == '') ? array() : $approved_sections;
			
			foreach($approved_sections as $key=>$val){
				foreach($val as $section_id=>$section_val){
					
					if(gettype($section_val)=='array')
					{
						foreach ($section_val as $min => $minV) {
							if($minV == 'Rejected'){
								if(isset($reply[$key][$section_id][$min]) && $reply[$key][$section_id][$min] != ''){
									//
								} else {
									$reply_status = 0;
								}
							}
						}
					}else{
						if($section_val == 'Rejected'){
							if(isset($reply[$key][$section_id]) && $reply[$key][$section_id] != ''){
								//
							} else {
								$reply_status = 0;
							}
						}
					}
					
				}
			} //die;


			return $reply_status;

	    }

	    // FINAL SUBMIT AFTER REFERRED BACK
	    public function finalSubmitRef($forms_data){

			$dataValidatation = $this->finalSubmitRefValidation($forms_data);

			if($dataValidatation == 1 ){

	            $submit = $forms_data['submit'];
	            $mineCode = $forms_data['mine_code'];
	            $returnDate = $forms_data['return_date'];
	            $returnType = $forms_data['return_type'];
	            $user_id = $forms_data['mms_user_id'];

                $returns = $this->getReturnId($mineCode, $returnDate, $returnType);
	            $tmp = end($returns);
	            $return_id = $tmp['id'];

	            $result = false;

	            if ($submit == "final_submit_ref") {
					
					$appSec = $this->getApprovedSec($mineCode, $returnDate, $returnType);

			        $tbl_final_submit_table = TableRegistry::getTableLocator()->get('TblFinalSubmit');
					$final_submit = $tbl_final_submit_table->get($return_id);

					$final_submit->is_latest = 0;

					$result = false;
			        if ($tbl_final_submit_table->save($final_submit)){
			            $result = 1;
			        }

			        $data = $this->findReturnById($return_id);

			        $return = $tbl_final_submit_table->newEmptyEntity();
			        $return->applicant_id = $data['applicant_id'];
			        $return->submitted_by = $data['submitted_by'];
			        $return->mine_code = $data['mine_code'];
			        $return->return_type = $data['return_type'];
			        $return->return_date = $data['return_date'];

					/**
					 * ADDED BELOW LINE TO REFLECT APPROVED SECTIONS FROM LAST RETURN TO LATEST RETURN
					 * @version 17th Dec 2021
					 * @author Aniket Ganvir
					 */
					$return->approved_sections = $appSec;
					
			        $return->created_at = date('Y-m-d H:i:s A');
			        $return->status_date = date('Y-m-d');
			        $return->updated_at = date('Y-m-d H:i:s A');
			        $return->notice = $data['notice'];
			        $return->form_type = $data['form_type'];
			        $return->is_latest = 1;

			        if($tbl_final_submit_table->save($return)){
			            $result = 1;
			        } else {
			            $result = 0;
			        }

	            }

	            return $result;

			} else {
				return false;
			}

	    }


	    // applicant final submit post data validation
	    public function finalSubmitRefValidation($forms_data){
			
			$returnValue = 1;
			
			if(empty($forms_data['mine_code'])){ $returnValue = null ; }
			if(empty($forms_data['return_date'])){ $returnValue = null ; }
			if(empty($forms_data['return_type'])){ $returnValue = null ; }
			
			return $returnValue;
			
		}

		/**
	     * Approves the return
	     * 
	     * If approved by Primary user -> Set: 'status' - 1, 'verified flag' - 1
	     * If approved by Supervisory user -> Set: 'status' - 3, 'verified flag' - 2
	     * 
	     * @param type $id
	     * @param type $mineral
	     * @param type $sub_min
	     * @param type $section
	     * @param type $is_supervisor
	     * @return boolean 
	     */
	    public function approve($id, $mineral = '', $sub_min = '', $section, $is_supervisor = false, $main_sec = null, $pdf_path = null) {


	        if ($sub_min == 1) {
	            $sub_mineral = 'hematite';
			} else if ($sub_min == 2) {
	            $sub_mineral = 'magnetite';
			} else if (in_array($sub_min, array('hematite', 'magnetite'))) {
				$sub_mineral = $sub_min;
			} else {
				$sub_mineral = null;
			}

	        //get the previous stored array and insert this....
	        $existing = $this->find('all')
	                ->select(['approved_sections'])
	                ->where(['id'=>$id])
	                ->toArray();

	        $approved = $existing[0]['approved_sections'];

			$approved_array = unserialize($approved);

			if ($mineral == "") {
				$approved_array['partI'][$section] = "Approved";
			} else if ($mineral == 'iron_ore') {
				$approved_array[$mineral][$sub_mineral][$section] = "Approved";
			} else {
				$approved_array[$mineral][$section] = "Approved";
			}

			if ($mineral != '') {

				$DirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
				$form_type = $DirMcpMineral->getFormNumber($mineral);

				// IF SECTION '4. Recovery at the Smelter-Mill-Plant' IS REFERRED BACK
				// THEN RESTRICT FOR APPROVAL OF SECTION '5. Sales during the month'
				// AS SECTION '5. Sales during the month' IS DEPENDENT ON THE SECTION '4. Recovery at the Smelter-Mill-Plant'
				// Added on 21-03-2022 by Aniket G.
				if ($form_type == '5' && $section == 5) { // SALES DURING THE MONTH
					
					if (isset($approved_array[$mineral][4]) && $approved_array[$mineral][4] == 'Rejected') {
						return 5;
						exit;
					}

				}

			}

	        $approved_sections = serialize($approved_array);
			
			$is_all_approved = $this->checkIsAllApprovedNew($approved_array, $main_sec, $mineral, $sub_mineral);

	        $result = '0';
	        $tblFinalSubmit = TableRegistry::getTableLocator()->get('TblFinalSubmit');
	        $aprove = $tblFinalSubmit->get($id);
			$aprove->approved_sections = $approved_sections;

	        if ($is_supervisor == true) {
	            //by supervisor user
	            $aprove->verified_flag = '2';
				
				if ($is_all_approved == true) {
					$aprove->status_date = date('Y-m-d');
					$aprove->status = '3';
					$aprove->pdf_path = $pdf_path;
				}

	        } else {
	            //by primary user
	            $aprove->verified_flag = '1';
				
				if ($is_all_approved == true) {
					$aprove->status = '1';
				} else {
					$aprove->status = '0';
				}

	        }
	        


	        if ($tblFinalSubmit->save($aprove)){
				if ($is_all_approved == true) {
	            	// send sms 
		            $customer_id = $_SESSION["applicantid"];
		            $DirSmsEmailTemplates = TableRegistry::getTableLocator()->get('DirSmsEmailTemplates');
		            //$DirSmsEmailTemplates->sendMessage(11,$customer_id);
				
	            	$result = '4';
				} else {
	            	$result = '3';
				}
	        }

	        return $result;

	    }
	    /**
	     * Approves the return G-series
	     * 
	     * If approved by Primary user -> Set: 'status' - 1, 'verified flag' - 1
	     * If approved by Supervisory user -> Set: 'status' - 3, 'verified flag' - 2
	     * 
	     * @param type $id
	     * @param type $mineral
	     * @param type $sub_min
	     * @param type $section
	     * @param type $is_supervisor
	     * @return boolean 
	     */
	    public function approveAnnual($id, $mineral = '', $sub_min = '', $section, $is_supervisor = false, $main_sec = null,$part_no = null, $pdf_path = null) {

	    	$min_und_low = strtolower(str_replace(' ','_', $mineral)); // mineral underscore lowercase
	        if ($sub_min == 1) {
	            $sub_mineral = 'hematite';
			} else if ($sub_min == 2) {
	            $sub_mineral = 'magnetite';
			} else if (in_array($sub_min, array('hematite', 'magnetite'))) {
				$sub_mineral = $sub_min;
			} else {
				$sub_mineral = null;
			}

	        //get the previous stored array and insert this....
	        $existing = $this->find('all')
	                ->select(['approved_sections'])
	                ->where(['id'=>$id])
	                ->toArray();

	        $approved_array = array();

	        $approved = $existing[0]['approved_sections'];



	        if ($approved == "") {
	            //if empty of approved array dont need to check the existence.Just push it
	            if ($min_und_low == "") {
	                $approved_array[$part_no][$section] = "Approved";
	            }  else {
	                $approved_array[$part_no][$section][$min_und_low] = "Approved";
	            }
	        } else {

	            $approved_array = unserialize($approved);


	            if ($min_und_low == "") {
	                $approved_array[$part_no][$section] = "Approved";
				}  else {
	                $approved_array[$part_no][$section][$min_und_low] = "Approved";
	            }
	            //print_r($approved_array);die;
	        }
	        $approved_sections = serialize($approved_array);
			
			$is_all_approved = $this->checkIsAllApprovedNew($approved_array, $main_sec, $min_und_low, $sub_mineral);
	        
	        $result = '0';
	        $tblFinalSubmit = TableRegistry::getTableLocator()->get('TblFinalSubmit');
	        $aprove = $tblFinalSubmit->get($id);
			$aprove->approved_sections = $approved_sections;

	        if ($is_supervisor == true) {
	            //by supervisor user
	            $aprove->verified_flag = '2';
				
				if ($is_all_approved == true) {
					$aprove->status_date = date('Y-m-d');
					$aprove->status = '3';
					$aprove->pdf_path = $pdf_path;
				}

	        } else {
	            //by primary user
	            $aprove->verified_flag = '1';
				
				if ($is_all_approved == true) {
					$aprove->status = '1';
				} else {
					$aprove->status = '0';
				}

	        }
	        


	        if ($tblFinalSubmit->save($aprove)){
				if ($is_all_approved == true) {
	            	// send sms 
		            $customer_id = $_SESSION["applicantid"];
		            $DirSmsEmailTemplates = TableRegistry::getTableLocator()->get('DirSmsEmailTemplates');
		            // $DirSmsEmailTemplates->sendMessage(11,$customer_id);
	            	$result = '4';
				} else {
	            	$result = '3';
				}

	        }

	        return $result;

	    }

		public function getDateForPrintAndPdf($mineCode, $returnDate, $returnType) {
			$query = $this->find()
					->select(['finalSubmitDate'=>'created_at'])
					->where(['mine_code'=>$mineCode])
					->where(['return_type'=>$returnType])
					->where(['return_date'=>$returnDate])
					->limit(1)
					->toArray();

			$date = date('Y-m-d', strtotime($query[0]['finalSubmitDate']));
			// $finalSubmitDate = clsCommon::changeDateFormat($date);
			// return $finalSubmitDate;
			return $date;
		}

	    // get return id by mine code, return type and return date
	    public function getReturnIdExceptLatest($mineCode, $returnDate, $returnType) {

	        $result = $this->find('all')
					->select(['id'])
					->where(['mine_code'=>$mineCode])
					->where(['return_type'=>$returnType])
					->where(['return_date'=>$returnDate])
	                ->where(['is_latest'=>'0'])
					->toArray();

            return $result;

	    }
		
		public function saveReplyAnnual($id, $reply, $part_no, $section, $mineral =null) {

			$existing = $this->find()
				->select(['reply', 'reply_date'])
				->where(['id'=>$id])
				->toArray();
	
			$min_und_low = strtolower(str_replace(' ','_', $mineral)); // mineral underscore lowercase
			$reply_array = array();
	        $date_array = array();
	
			$replies = $existing[0]['reply'];
	        $dates = $existing[0]['reply_date'];
	        $current_time = date('Y-m-d H:i:s');
			
	        if ($min_und_low != "") {
	        	$reply_array = unserialize($replies);
	            $date_array = unserialize($dates);
				$reply_array[$part_no][$section][$min_und_low] = $reply;
				$date_array[$part_no][$section][$min_und_low] = $current_time; 
				
	        } else {
	            $reply_array = unserialize($replies);
	            $date_array = unserialize($dates);
				$reply_array[$part_no][$section] = $reply;
				$date_array[$part_no][$section] = $current_time;
	        }
			
	        $reply_sections = serialize($reply_array);
	        $date_sections = serialize($date_array);
	
			$result = false;
			$save = $this->query();
			$save->update()
				->set(['reply'=>$reply_sections, 'reply_date'=>$date_sections])
				->where(['id'=>$id])
				->execute();
	
			if ($save) {
	            $result = 1;
			}
	        return $result;

		}
		
		public function checkIsAllApproved($approved_sections, $mineral, $sub_min) {

			$part1 = false;
			$part2 = false;
	
			for ($k = 1; $k <= 5; $k++) {
				if (isset($approved_sections['partI'][$k]) && $approved_sections['partI'][$k] == "Approved")
					$part1 = true;
				else
					break;
			}
	
			if ($mineral == "iron_ore") {
				for ($k = 1; $k <= 4; $k++) {
					if ($sub_min == 'hematite') {
						if (isset($approved_sections['iron_ore']['hematite'][$k]) && $approved_sections['iron_ore']['hematite'][$k] == "Approved")
							$part2 = true;
						else {
							$part2 = false;
							break;
						}
					}
	
					if ($sub_min == 'magnetite') {
						if (isset($approved_sections['iron_ore']['magnetite'][$k]) && $approved_sections['iron_ore']['magnetite'][$k] == "Approved")
							$part2 = true;
						else {
							$part2 = false;
							break;
						}
					}
				}
			} else {
	            $dirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
				$formNo = $dirMcpMineral->getFormNumber($mineral);
				if ($formNo == 8)
					$part2Count = 5;
				else if ($formNo == 6)
					$part2Count = 3;
				else if ($formNo == 5)
					$part2Count = 7;
				else
					$part2Count = 4;
	
				for ($k = 1; $k <= $part2Count; $k++) {
					if (isset($approved_sections[$mineral][$k]) && $approved_sections[$mineral][$k] == "Approved")
						$part2 = true;
					else {
						$part2 = false;
						break;
					}
				}
			}
	
			if ($part1 == true && $part2 == true)
				return true;
			else
				return false;

		}

		/**
		 * CHECKING ALL SECTIONS ARE APPROVED OR NOT
		 * @return TRUE IF ALL SECTIONS ARE APPROVED
		 * @return FALSE IF ALL SECTIONS ARE NOT APPROVED
		 */
		public function checkIsAllApprovedNew($appSec, $mainSec, $min, $subMin) {
	
			$result = true;

			if ($mainSec != null) {

				$mainSecArr = unserialize($mainSec);

				if (is_array($mainSecArr)) {

					foreach ($mainSecArr as $partK=>$partV) {

						if ($partK == 'iron_ore') {
	
							foreach ($partV as $k => $v) {
								foreach ($v as $vk => $status) {
									if ($vk != 10) {
										if (isset($appSec['iron_ore'][$k][$vk])) {
											if ($appSec['iron_ore'][$k][$vk] != 'Approved') {
												$result = false;
											}
										} else {
											$result = false;
										}
									}
								}
							}
	
						} else {
							foreach ($partV as $k => $status) {
								
								if (isset($appSec[$partK][$k])) {
									if(gettype($appSec[$partK][$k])=='array')
									{
										foreach ($appSec[$partK][$k] as $min => $minV) {
											if ($minV != 'Approved') {
												$result = false;
											}
										}
									}else{
										if ($appSec[$partK][$k] != 'Approved') {
											$result = false;
										}
									}
								} else {
									$result = false;
								}
							}

						}
	
					}

				} else {
					$result = false;
				}

			} else {
				
				$result = $this->checkIsAllApproved($appSec, $min, $subMin);

			}

			return $result;

		}
		
		/**
		 * GET LATEST APPROVED SECTIONS FOR REFLECTING SAME IN NEW REFERRED BACK RETURN
		 * @version 17th Dec 2021
		 * @author Aniket Ganvir
		 */
	    public function getApprovedSec($mineCode, $returnDate, $returnType) {
			
			$data = $this->find()
				->select(['approved_sections'])
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>$returnType])
				->where(['is_latest'=>1])
				->limit(1)
				->toArray();

			if (count($data) == 1) {

				$appSecArr = unserialize($data[0]['approved_sections']);

				if (is_array($appSecArr)) {
					$appSec = $appSecArr;
					foreach ($appSecArr as $partK=>$partV) {
	
						if ($partK == 'iron_ore') {
	
							foreach ($partV as $k => $v) {
								foreach ($v as $vk => $status) {
									if ($status == 'Rejected') {
										$appSec['iron_ore'][$k][$vk] = '';
									}
								}
							}
	
						} else {
							foreach ($partV as $k => $status) {
								
								if(gettype($status)=='array')
	                            {
	                                foreach ($status as $mine =>$minV) {
	                                    if ($minV == 'Rejected') {
	                                        $appSec[$partK][$k][$mine] = '';
	                                    } 
	                                }
	                            }else{
		                            if ($status == 'Rejected') {
										$appSec[$partK][$k] = '';
									}
	                            }
								
							}
						}
	
					}
					$appSec = serialize($appSec);



				} else {
					$appSec = null;
				}

			} else {
				$appSec = null;
			}


			return $appSec;

		}

		 public function scrutinize($id) {

            date_default_timezone_set('Asia/Kolkata');
            
            $current_time = date('Y-m-d H:i:s');

            $tbl_final_submit = TableRegistry::getTableLocator()->get('TblFinalSubmit');
            $final_submit = $tbl_final_submit->get($id);
            $final_submit->verified_flag = 1;
                

            $result = false;
            if ($tbl_final_submit->save($final_submit)){
                $result = 1;
            }
            return $result;
        }
		
		public function getFileReturnYear($mineCode) {

			$yearArr = array();
			$returnYear = array();
			$currentYear = date('Y');
			// $fromYear = 2011;
			$cutoffDate = Configure::read('cutoff_date');
			$fromYear = date('Y', strtotime($cutoffDate));
			$currentMonth = array();
			for ($yr = $currentYear; $yr >= $fromYear; $yr--) {
				$yearArr[$yr] = $yr;
			}

		    $submittedData = $this->find()
				->select(['return_date'])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>'MONTHLY'])
				->where(['is_latest'=>1])
				->order(['return_date'=>'ASC'])
				->toArray();

			if (count($submittedData) > 0) {

				foreach ($submittedData as $data) {

					$returnDate = $data['return_date'];
					$y = date('Y', strtotime($returnDate));
					$m = date('m', strtotime($returnDate));
					unset($currentMonth[$y][$m]);

					if (isset($returnYear[$y])) {
						$returnYear[$y]++;
					} else {
						$returnYear[$y] = 1;
					}

				}

			}

			foreach ($returnYear as $key=>$val) {
				if ($key == $fromYear) {
					$fromMonth = (int)date('m', strtotime($cutoffDate)) - 1;
					$totalMonth = 12 - $fromMonth;
				} else {
					$totalMonth = 12;
				}
				if ($val >= $totalMonth) {
					unset($yearArr[$key]);
				}
			}

			return $yearArr;

		}
		
		// GET PENDING RETURN YEARS FOR FILING ANNUAL RETURN (G SERIES)
		// Added on dated 09-02-2022 by Aniket G
		public function getAnnualFileReturnYear($mineCode) {

			$cutoffDate = Configure::read('cutoff_date');
			$fromYear = date('Y', strtotime($cutoffDate));

			$date1 = date_create(date('Ymd'));
			$date2 = date_create(date('Y') . "-04-01");
			$diff = date_diff($date2, $date1);
			$dateDiff = $diff->format("%R%a");
			$annualYearArr = [];
			if ($dateDiff < 0) {
				for ($i = (date('Y') - 2); ($i >= (date('Y') - 10) && $i >= $fromYear); $i--) {
					$annualYearArr[$i] = $i . " - " . ($i + 1);
				}
			} else {
				for ($i = (date('Y') - 1); ($i >= (date('Y') - 10) && $i >= $fromYear); $i--) {
					$annualYearArr[$i] = $i . " - " . ($i + 1);
				}
			}

		    $submittedData = $this->find()
				->select(['return_date'])
				->where(['mine_code'=>$mineCode])
				->where(['return_type'=>'ANNUAL'])
				->where(['is_latest'=>1])
				->order(['return_date'=>'ASC'])
				->toArray();

			if (count($submittedData) > 0) {
				foreach ($submittedData as $data) {

					$returnDate = $data['return_date'];
					$y = date('Y', strtotime($returnDate));
					unset($annualYearArr[$y]);

				}
			}

			return $annualYearArr;

		}

		/**
         * Dis-approves the return date : 19/01/2022
         * 
         * 
         * @param type $id
         * @param type $part_no
         * @param type $section
         * @param type $is_supervisor
         * @return boolean 
         */
        public function disapprove($id, $mineral = '', $sub_min = '', $section, $is_supervisor = false, $main_sec = null) {
        	
        	if ($sub_min == 1) {
                $sub_mineral = 'hematite';
            } else if ($sub_min == 2) {
                $sub_mineral = 'magnetite';
            } else if (in_array($sub_min, array('hematite', 'magnetite'))) {
                $sub_mineral = $sub_min;
            } else {
                $sub_mineral = null;
            }
            //get the previous stored array and insert this....
            $existing = $this->find('all')
                    ->select(['approved_sections', 'rejected_section_remarks'])
                    ->where(['id'=>$id])
                    ->toArray();

            $approved = $existing[0]['approved_sections'];
            $remarks = $existing[0]['rejected_section_remarks'];

			$approved_array = unserialize($approved);
			$remarks_array = unserialize($remarks);

			if ($mineral == "") {
				if (isset($remarks_array['partI'][$section]) && $remarks_array['partI'][$section] != '') {
					$approved_array['partI'][$section] = "Rejected";
				} else {
					$approved_array['partI'][$section] = "";
				}
			} else if ($mineral == 'iron_ore') {
				if (isset($remarks_array[$mineral][$sub_mineral][$section]) && $remarks_array[$mineral][$sub_mineral][$section] != '') {
					$approved_array[$mineral][$sub_mineral][$section] = "Rejected";
				} else {
					$approved_array[$mineral][$sub_mineral][$section] = "";
				}
			} else {
				if (isset($remarks_array[$mineral][$section]) && $remarks_array[$mineral][$section] != '') {
					$approved_array[$mineral][$section] = "Rejected";
					
					// ON DISAPPROVAL OF SECTION '4. Recovery at the Smelter-Mill-Plant'
					// ALSO DISAPPROVE SECTION '5. Sales during the month' (IF IT IS APPROVED)
					// AS SECTION '5. Sales during the month' IS DEPENDENT ON '4. Recovery at the Smelter-Mill-Plant' SECTION
					// Added on 21-03-2022 by Aniket G.
					$DirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
					$form_type = $DirMcpMineral->getFormNumber($mineral);

					if ($form_type == '5' && $section == 4) { // RECOVERY AT THE SMELTER/MILL/PLANT
						if (isset($approved_array[$mineral][5]) && $approved_array[$mineral][5] == 'Approved') {
							$approved_array[$mineral][$section] = "";
							$remarks_array[$mineral][$section] = "";
							$approved_array[$mineral][5] = "";
							$remarks_array[$mineral][5] = "";
						}
					}

				} else {
					$approved_array[$mineral][$section] = "";
				}
			}

            $approved_sections = serialize($approved_array);
            $remarks_sections = serialize($remarks_array);
            
            $result = '0';
            $tblFinalSubmit = TableRegistry::getTableLocator()->get('TblFinalSubmit');
            $aprove = $tblFinalSubmit->get($id);
            $aprove->approved_sections = $approved_sections;
            $aprove->rejected_section_remarks = $remarks_sections;

            
            if($tblFinalSubmit->save($aprove)){
                $result = '3';
            }

            return $result;

        }
        /**
         * Dis-approves the return g-series date : 10/02/2022 
         * 
         * 
         * @param type $id
         * @param type $part_no
         * @param type $section
         * @param type $is_supervisor
         * @return boolean 
         */
        public function disapproveAnnual($id, $mineral = '', $sub_min = '', $section, $is_supervisor = false, $main_sec = null, $part_no = null) {
        	
        	$min_und_low = strtolower(str_replace(' ','_',$mineral)); // mineral underscore lowercase

            //get the previous stored array and insert this....
            $existing = $this->find('all')
                    ->select(['approved_sections', 'rejected_section_remarks'])
                    ->where(['id'=>$id])
                    ->toArray();

            $approved = $existing[0]['approved_sections'];
            $remarks = $existing[0]['rejected_section_remarks'];

			$approved_array = unserialize($approved);
			$remarks_array = unserialize($remarks);

			if ($min_und_low == "") {
				if (isset($remarks_array[$part_no][$section]) && $remarks_array[$part_no][$section] != '') {
					$approved_array[$part_no][$section] = "Rejected";
				} else {
					$approved_array[$part_no][$section] = "";
				}
			}
			else {
				if (isset($remarks_array[$part_no][$section][$min_und_low]) && $remarks_array[$part_no][$section][$min_und_low] != '') {
					$approved_array[$part_no][$section][$min_und_low] = "Rejected";
				} else {
					$approved_array[$part_no][$section][$min_und_low] = "";
				}
			}

            //print_r($approved_array);die;
            $approved_sections = serialize($approved_array);
            
            $result = '0';
            $tblFinalSubmit = TableRegistry::getTableLocator()->get('TblFinalSubmit');
            $aprove = $tblFinalSubmit->get($id);
            $aprove->approved_sections = $approved_sections;
            
            if($tblFinalSubmit->save($aprove)){
                $result = '3';
            }

            return $result;

        }
		// Last unapproved section Date : 19-01-2022 Shalini D
        public function checkIsLastApproved($id,$main_sec)
        {
            //get the previous stored array ....
            $existing = $this->find('all')
                    ->select(['approved_sections'])
                    ->where(['id'=>$id])
                    ->toArray();

            $approved_array = array();

            $approved = $existing[0]['approved_sections'];
            $appSec = unserialize($approved);

            //print_r($appSec); echo "<br>";
            //print_r(unserialize($main_sec)); echo "<br>";

            if ($main_sec != null) {
                $mainSecArr = unserialize($main_sec);
                if (is_array($mainSecArr)) {
                    foreach ($mainSecArr as $partK=>$partV) {
                        foreach($partV as $k => $status) {
                            if(isset($appSec[$partK][$k])) {
                                if ($appSec[$partK][$k] != 'Approved') {
                                   $notAppSec[$partK][] = $k;
                                }
                            }else{
                                $notAppSec[$partK][] = $k;
                            }
                           
                        }
                    }
                } 
            }
            
            $lastPart = "";
            $lastSec = "";

            if(!empty($notAppSec)){

                if(count($notAppSec)== 1)
                {
                    foreach($notAppSec as $partA => $valA) 
                    {
                    	//print_r($valA); 
                        $lastPart = $partA;
                        if(!empty($valA))
                        {
                            if(count($valA)==1)
                            {
                                foreach ($valA as $valK => $secV) {
                                	//print_r($secV); 
                                    $lastSec = $secV;
                                }
                            }
                        }
                    } //die;
                }
            }

           /*print_r($lastPart); echo "<br>";
           print_r($lastSec); echo "<br>";*/
           $res['lastPart']= $lastPart;
           $res['lastSec']= $lastSec; 
           return $res;
           
        }
        // Last unapproved section for form G Date : 11-02-2022 Shalini D
        public function checkIsLastApprovedAnnual($id,$main_sec,$mineral)
        {

            //get the previous stored array ....
            $existing = $this->find('all')
                    ->select(['approved_sections'])
                    ->where(['id'=>$id])
                    ->toArray();

            $approved_array = array();

            $approved = $existing[0]['approved_sections'];
            $appSec = unserialize($approved);


            if ($main_sec != null) {
                $mainSecArr = unserialize($main_sec);
                if (is_array($mainSecArr)) {
                    foreach ($mainSecArr as $partK=>$partV) {
                        foreach($partV as $k => $status) {
                            if(isset($appSec[$partK][$k])) {
                            	if(gettype($appSec[$partK][$k])=='array')
									{
										foreach ($appSec[$partK][$k] as $min => $minV) {
											if ($minV != 'Approved') {
												$notAppSec[$partK][] = $k;
											}
										}
									}else{
										if($appSec[$partK][$k] != 'Approved') {
		                                   $notAppSec[$partK][] = $k;
		                                }
									}
                            }else{
                                $notAppSec[$partK][] = $k;
                            }
                           
                        }
                    }
                } 
            }
            
            $lastPart = "";
            $lastSec = "";

            if(!empty($notAppSec)){

                if(count($notAppSec)== 1)
                {
                    foreach($notAppSec as $partA => $valA) 
                    {
                    	//print_r($valA); 
                        $lastPart = $partA;
                        if(!empty($valA))
                        {
                            if(count($valA)==1)
                            {
                                foreach ($valA as $valK => $secV) {
                                	//print_r($secV); 
                                    $lastSec = $secV;
                                }
                            }
                        }
                    } //die;
                }
            }

           /*print_r($lastPart); echo "<br>";
           print_r($lastSec); echo "<br>";*/
           $res['lastPart']= $lastPart;
           $res['lastSec']= $lastSec; 
           return $res;
           
        }

		
		/**
		 * GET RETURN CURRENT STATUS FOR PDF WATERMARK
		 * @version 02nd Feb 2022
		 * @author Aniket Ganvir
		 */
		public function getPdfStatus($mineCode, $returnDate, $returnType) {

			$data = $this->find()
				->select(['status'])
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>$returnType])
				->where(['is_latest'=>1])
				->limit(1)
				->toArray();

			if (count($data) > 0) {
				$result = ($data[0]['status'] == 3) ? 'approve' : 'submit';
			} else {
				$result = 'draft';
			}

			return $result;

		}

		// GET VERSION FOR SAVING ESIGN PDF LOGS
		// Added on 22-02-2021 by Aniket G
	    public function getVersion($mineCode, $returnDate, $returnType) {
			
			$records = $this->find()
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>$returnType])
				->count();

			return $records;

		}

		// GET 'notice' FROM PREVIOUS LATEST RETURN TO REFLECT ON NEW RETURN
		public function getLastReturnDataForNewReturn($mineCode, $returnDate, $returnType) {

			$data = $this->find()
				->select(['notice'])
				->where(['mine_code'=>$mineCode])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>$returnType])
				->where(['is_latest'=>1])
				->first();

			if (!empty($data)) {
				return $data;
			} else {
				return array('notice'=>0);
			}

		}

	} 
?>