<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\Datasource\ConnectionManager;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use App\Controller\MonthlyController;
	
	class TblEndUserFinalSubmitTable extends Table{

		var $name = "TblEndUserFinalSubmit";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

        /**
         * Returns true if the selected month return is already final submitted
         * @param type $mineCode
         * @param type $returnDate
         * @param type $returnType
         * @return boolean 
         */
        public function checkIsSubmitted($registrationCode, $returnDate, $returnType, $mcu_user_id) {
            
		    $query = $this->find('all')
                    ->select(['id'])
                    ->where(['ibm_unique_reg_no'=>$registrationCode])
                    ->where(['return_date'=>$returnDate])
                    ->where(['return_type'=>$returnType])
                    ->where(['applicant_id'=>$mcu_user_id])
                    ->toArray();

            if (count($query) > 0) {
                return true;
            } else {
                return false;
            }
            
        }

        //id, applicant_id, submitted_by, ibm_unique_reg_no, user_type, mineral_name, return_type, return_date, assigned_to, 
        //approved_sections, reply, rejected_section_remarks, verified_flag, is_replied, replied_section_remarks, status, 
        //notice, status_date, form_type, is_latest, created_at, updated_at
        public function getDetailsForNO($regCode, $returnType, $returnDate, $ibmUniqueRegNo, $formType) {

            $query = $this->find()
                    ->select(['applicant_id', 'ibm_unique_reg_no', 'return_type', 'return_date', 
                        'reply', 'rejected_section_remarks', 'verified_flag', 'approved_sections', 
                        'status', 'form_type', 'is_latest', 'replied_section_remarks', 'status_date'])
                    ->where(['applicant_id'=>$regCode])
                    ->where(['ibm_unique_reg_no'=>$ibmUniqueRegNo])
                    ->where(['return_type'=>$returnType])
                    ->where(['return_date'=>$returnDate])
                    ->where(['form_type'=>$formType])
                    ->where(['status'=>4])
                    ->where(['verified_flag'=>2])
                    ->order(['id'=>'DESC'])
                    ->toArray();

            $resultSet = Array();
            $i = 0;

            foreach ($query as $data) {
                $resultSet[$i]['verified_flag'] = $data['verified_flag'];
                $resultSet[$i]['status'] = $data['status'];
                $resultSet[$i]['status_date'] = $data['status_date'];
                $resultSet[$i]['rejected_section_remarks'] = unserialize($data['rejected_section_remarks']);
                $resultSet[$i]['approved_sections'] = unserialize($data['approved_sections']);
                $resultSet[$i]['reply'] = unserialize($data['reply']);
                $resultSet[$i]['replied_section_remarks'] = unserialize($data['replied_section_remarks']);
                $i++;
            }
            $resultSet['count'] = count($query);

            return $resultSet;
            
        }

        /**
         * UPDATES THE DB TO MAKE THE LAST SUBMITTED OLD ONE AFTER EVERY FINAL SUBMITTED
         * OF REJECTED APPLICATION
         * 
         * @param string $app_id
         * @param string $submitted_by
         * @param date $return_date
         * @param string $returnType 
         */
        public function updateLastSubmittedRecord($app_id, $submitted_by, $return_date, $returnType) {

		    $query = $this->query();
			$query->update()
                ->set(['is_latest'=>'0'])
                ->where(['applicant_id'=>$app_id])
                ->where(['submitted_by'=>$submitted_by])
                ->where(['return_date'=>$return_date])
                ->where(['return_type'=>$returnType])
                ->execute();
                    
        }

        /**
         * GET FORM TYPE OF SUBMITTED RETURNS
         * @version 15th JUL 2021
         * @author Aniket Ganvir
         */
        public function getFormType($app_id, $submitted_by, $return_date, $return_type){

            $result = $this->find()
                ->select(['form_type'])
                ->where(['applicant_id'=>$app_id])
                ->where(['submitted_by'=>$submitted_by])
                ->where(['return_date'=>$return_date])
                ->where(['return_type'=>$return_type])
                ->where(['is_latest'=>1])
                ->limit(1)
                ->toArray();

            return $result[0]['form_type'];

        }

        /**
         * Returns the ID of the submitted returns for the particular mine & mineral
         * @param type $mineCode
         * @param type $mineral
         * @param type $returnDate
         * @param type $returnType
         * @return type 
         */
        public function getReturnId($endUserId, $returnDate, $returnType, $ibmUniqueRegNo) {

            $query = $this->find()
                    ->select(['id'])
                    ->where(['applicant_id'=>$endUserId])
                    ->where(['return_date'=>$returnDate])
                    ->where(['return_type'=>$returnType])
                    ->where(['ibm_unique_reg_no'=>$ibmUniqueRegNo])
                    // ->where(['is_latest'=>1])
                    ->order(['created_at'=>'ASC'])
                    ->toArray();

            if ($query){
                return $query;
            }
            // return $query[0]['id'];
        }

        public function getReason($return_id, $partNo, $section, $user_role = null) {

            // $query = $this->find()
            //         ->select(['rejected_section_remarks', 'status_date', 'replied_section_remarks'])
            //         ->where(['id'=>$return_id])
            //         ->toArray();
                    
            // if (count($query) > 0) {
            //     //if the section is not found in the 'rejected_selections' array dont display the reason
            //     $rejected_section_remarks = unserialize($query[0]['rejected_section_remarks']);
            //     $rejected_section_replies = unserialize($query[0]['replied_section_remarks']);
            //     if (empty($rejected_section_remarks)){
            //         return;
            //     }
    
            //     $reason = "";
            //     if ($partNo == "partI") {
            //         $reason = $rejected_section_remarks['partI'][$section];
            //         $reply = $rejected_section_replies['partI'][$section];
            //     } else if ($partNo == "partII") {
            //         $reason = $rejected_section_remarks['partII'][$section];
            //         $reply = $rejected_section_replies['partII'][$section];
            //     } else if ($partNo == "partIII") {
            //         $reason = $rejected_section_remarks['partIII'][$section];
            //         $reply = $rejected_section_replies['partIII'][$section];
            //     }
    
            //     $data = array();
            //     $data['reason'] = $reason;
            //     $data['reply'] = $reply;
                
	        //     $MonthlyController = new MonthlyController;
            //     $data['status_date'] = $MonthlyController->Clscommon->changeDateFormat($query[0]['status_date']);
            //     return $data;
                
            // }


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

                $reason = (isset($rejected_section_remarks[$partNo][$section])) ? $rejected_section_remarks[$partNo][$section] : "";

	            if($rejected_section_replies == ''){
	            	$rejected_section_replies = array();
	            }

                $reply = (isset($rejected_section_replies[$partNo][$section])) ? $rejected_section_replies[$partNo][$section] : "";

	            if($rejected_replies_date == ''){
	            	$rejected_replies_date = array();
	            }

                $reply_date = (isset($rejected_replies_date[$partNo][$section])) ? $rejected_replies_date[$partNo][$section] : "";

				$rejected_section_date = ($rejected_section_date == '') ? array() : $rejected_section_date;

                $reason_date = (isset($rejected_section_date[$partNo][$section])) ? $rejected_section_date[$partNo][$section] : "";

                $primary_remarks = (isset($primary_comment_remarks[$partNo][$section])) ? $primary_comment_remarks[$partNo][$section] : "";

                $primary_date = (isset($primary_comment_date[$partNo][$section])) ? $primary_comment_date[$partNo][$section] : "";

	            $data = array();
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
	            $current_user_comment = (in_array($user_role, array('2','8'))) ? $reason : ((in_array($user_role, array('3','9'))) ? $primary_remarks : $reply);

	            if($is_latest == '1' && $current_user_comment != '' ){
	            	$commented = '1';
	            }

	            $data['commented'] = $commented;

	            return $data;

            }
            
        }

        //save comments
	    public function saveApproveReject($forms_data, $returnId = ''){

			// $dataValidatation = $this->postDataValidation($forms_data);

			// if($dataValidatation == 1 ){

	            $reason = $forms_data['reason'];
	            $submit = $forms_data['submit'];
	            $returnDate = $forms_data['return_date'];
	            $returnType = $forms_data['return_type'];
	            $user_id = $forms_data['mms_user_id'];
	            $sec_id = $forms_data['section_id'];
	            $part_no = $forms_data['part_no'];
                $return_id = $forms_data['return_id'];

                //check if the approval/rejection is done by Supervisor or Primary
	            $is_supervisor = false;
                
                $userRole = $_SESSION['mms_user_role'];
                if ($userRole == 2 || $userRole == 8){
                    $is_supervisor = true;
                }

	            $MonthlyController = new MonthlyController;

	            $result = false;

	            if ($submit == "approve_return") {

					$main_sec = $forms_data['main_sec_parse'];
	                // $approve = TBL_FINAL_SUBMITTable::approve($return_id, $mineral, $sub_min, $sec_id, $is_supervisor);
                    // $approve = TBL_END_USER_FINAL_SUBMITTable::approve($return_id, $this->partNo, $this->section, $is_supervisor);
	                $result = $this->approve($return_id, $part_no, $sec_id, $is_supervisor, $main_sec);
					
	            } else if ($submit == "save_comment") {
                    
                    // $reject = TBL_END_USER_FINAL_SUBMITTable::reject($return_id, $reason, $this->partNo, $this->section, $is_supervisor);
                    $reject = $this->reject($return_id, $reason, $part_no, $sec_id, $is_supervisor);

	                if($reject == 1){
	                	$result = 1;
	                }

	                if ($is_supervisor == true){
                        // send rejection mail
	                    // $rejection_mail = TBL_END_USER_FINAL_SUBMITTable::sendNAndORejectionMail($return_id, $this->endUserId, $this->returnDate, $this->returnType, "End-Use Mineral Based Activity");
                        // $rejection_mail = $MonthlyController->Clscommon->sendNAndORejectionMail($return_id, $this->endUserId, $this->returnDate);
                    }
	            } else if ($submit == "referred_back") {
	                $reject = $this->rejectFinalSubmit($return_id, $is_supervisor);

	                if($reject == 1){
	                	$result = 2;
	                }

	                if ($is_supervisor == true){
	                    // $rejection_mail = $MonthlyController->Clscommon->sendRejectionMail($return_id, $this->mineCode, $this->returnDate);
							// send sms ME
							$customer_id = $_SESSION['mc_mine_code'];
							$DirSmsEmailTemplates = TableRegistry::getTableLocator()->get('DirSmsEmailTemplates');
							$DirSmsEmailTemplates->sendMessage(10,$customer_id);
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
                } 
                else if ($submit == "disapprove" ) {
                   
                    $main_sec = $forms_data['main_sec_parse'];
                    $result = $this->disapprove($return_id, $part_no, $sec_id, $is_supervisor, $main_sec);

                    
                }

	            return $result;

			// } else {
			// 	return false;
			// }

	    }

        
	    /**
	     * REJECTS THE RETURN
         * @version 16th JUL 2021
         * @author Aniket Ganvir
	     */
	    public function rejectFinalSubmit($id, $is_supervisor = false) {

			date_default_timezone_set('Asia/Kolkata');
			
	        $current_time = date('Y-m-d H:i:s');

	        $tbl_end_user_final_submit = TableRegistry::getTableLocator()->get('TblEndUserFinalSubmit');
			$final_submit = $tbl_end_user_final_submit->get($id);

			if ($is_supervisor == true) {
				//by supervisor user
				// $final_submit->verified_flag = 2;
				// $final_submit->status_date = date('Y-m-d');
				$final_submit->status = 4;
			} else {
	            //by primary user
				 $final_submit->verified_flag = 1;
				// $final_submit->status_date = date('Y-m-d');
				$final_submit->status = 2;
			}

			$result = false;
	        if ($tbl_end_user_final_submit->save($final_submit)){
	            $result = 1;
	        }
	        return $result;
	    }

        
        /**
         * @author Uday Shankar Singh <usingh@ubicsindia.com>
         * 
         * @param Integer $id
         * @param String $reason
         * @param Integer $section
         * @param Boolean $is_supervisor
         * @return boolean
         * 
         * FUNCTION UPDATE THE DATABASE AT THE TIME OF REJECTION OF PARTICULAR RETURN 
         * BY SUPERVISORY OR PRIMARY USER.
         */
	    public function reject($id, $reason, $partNo, $section, $is_supervisor = false) {

			$reason = htmlentities($reason,ENT_QUOTES);
			date_default_timezone_set('Asia/Kolkata');
                
	        $existing = $this->find()
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
            //     $rejected_array[$partNo][$section] = "Rejected";
            //     $remarks_array[$partNo][$section] = $reason;
            //     $date_array[$partNo][$section] = $current_time;
            //     $primary_remark_array[$partNo][$section] = $reason;
            //     $primary_remark_date_array[$partNo][$section] = $current_time;
	            
	        // } else {
	            $rejected_array = unserialize($rejected);
	            $remarks_array = unserialize($remarks);
	            $date_array = unserialize($dates);
	            $primary_remark_array = unserialize($primary_remarks);
	            $primary_remark_date_array = unserialize($primary_date);

                $rejected_array[$partNo][$section] = "Rejected";
                $remarks_array[$partNo][$section] = $reason;
                $date_array[$partNo][$section] = $current_time;
                $primary_remark_array[$partNo][$section] = $reason;
                $primary_remark_date_array[$partNo][$section] = $current_time;
	        // }

	        $rejected_sections = serialize($rejected_array);
	        $rejected_section_remarks = serialize($remarks_array);
	        $rejected_section_date = serialize($date_array);
	        $primary_remarks = serialize($primary_remark_array);
	        $primary_date = serialize($primary_remark_date_array);

	        $tbl_end_user_final_submit = TableRegistry::getTableLocator()->get('TblEndUserFinalSubmit');
			$final_submit = $tbl_end_user_final_submit->get($id);

			// $final_submit->approved_sections = $rejected_sections;

			if ($is_supervisor == true) {
				//by supervisor user
				$final_submit->approved_sections = $rejected_sections;
				$final_submit->rejected_section_remarks = $rejected_section_remarks;
				$final_submit->rejected_section_date = $rejected_section_date;
				//$final_submit->verified_flag = 2;
				$final_submit->status_date = date('Y-m-d');
				// $final_submit->status = 4; // FOR APPROVED
			} else {
	            //by primary user
				$final_submit->primary_comment_remarks = $primary_remarks;
				$final_submit->primary_comment_date = $primary_date;
				//$final_submit->verified_flag = 1;
				$final_submit->status_date = date('Y-m-d');
				// $final_submit->status = 2; // FOR PENDING FROM SUPERVISORY
			}

			$result = false;
	        if ($tbl_end_user_final_submit->save($final_submit)){
	            $result = 1;
	        }
	        return $result;
	    }

        
		/**
		 * REMOVE COMMENT FROM SECTION COMMUNICATION WINDOW
		 * @addedon: 16th JUL 2021 (by Aniket Ganvir)
		 */
	    public function remComment($forms_data){

			// $dataValidatation = $this->postDataValidation($forms_data);

			// if($dataValidatation == 1 ){

	            $submit = $forms_data['submit'];
	            $returnDate = $forms_data['return_date'];
	            $returnType = $forms_data['return_type'];
	            $user_id = $forms_data['mms_user_id'];
	            $return_id = $forms_data['return_id'];
	            $section_id = $forms_data['section_id'];
	            $part_no = $forms_data['part_no'];

                //check if the approval/rejection is done by Supervisor or Primary
	            $is_supervisor = false;
	            $role = $_SESSION['mms_user_role'];
	            if ($role == 2 || $role == 8){
	                $is_supervisor = true;
	            }

	            $MonthlyController = new MonthlyController;

	            $result = false;

	            if ($submit == "remove_comment") {
	                $reject = $this->removeReject($return_id, $part_no, $section_id, $is_supervisor);

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
	    public function removeReject($id, $part_no, $section, $is_supervisor = false) {

			date_default_timezone_set('Asia/Kolkata');
			
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

            $rejected_array[$part_no][$section] = '';
            $remarks_array[$part_no][$section] = '';
            $date_array[$part_no][$section] = '';
            $primary_remark_array[$part_no][$section] = '';
            $primary_date_array[$part_no][$section] = '';

	        $rejected_sections = serialize($rejected_array);
	        $rejected_section_remarks = serialize($remarks_array);
	        $rejected_section_date = serialize($date_array);
	        $rejected_remarks = serialize($primary_remark_array);
	        $rejected_dates = serialize($primary_date_array);

	        $tbl_end_user_final_submit = TableRegistry::getTableLocator()->get('TblEndUserFinalSubmit');
			$final_submit = $tbl_end_user_final_submit->get($id);


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
	        if ($tbl_end_user_final_submit->save($final_submit)){
	            $result = 1;
	        }

	        return $result;
	    }

        /**
         *  SEND REJECTION MAIL FOR N AND O
         * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
         * @version 7th Feb 2014
         */
        public function sendNAndORejectionMail($return_id, $endUserId, $returnDate, $returnType, $activityName) {

            $return = $this->find()
                ->select(['submitted_by'])
                ->where(['id'=>$return_id])
                ->toArray();
        
            $submitted_by = $return[0]['submitted_by'];
            $mail_id = "";
            $mcUser = TableRegistry::getTableLocator()->get('McUser');
            $mine_user = $mcUser->getUserDatabyId($submitted_by);
            if ($mine_user) {
                //GETTING THE USER EMAIL
                $mail_id = $mine_user['mcu_email'];
            
                // CREATING THE USER NAME BY COMBINING THE FIRST, MIDDLE AND LAST NAME
                $userFirstName = $mine_user['mcu_first_name'] ? $mine_user['mcu_first_name'] . " " : "";
                $userMiddleName = $mine_user['mcu_middle_name'] ? $mine_user['mcu_middle_name'] . " " : "";
                $userLastName = $mine_user['mcu_last_name'] ? $mine_user['mcu_last_name'] . " " : "";
                $user = $userFirstName . $userMiddleName . $userLastName;
            
                // CHECKING IF USER NAME IS NOT THERE THEN USER FINAL SUBMITTED SUBITTED BY AS USER NAME
                // AS IT MUST BE THERE
                $user_name = ($user != "") ? $user : $submitted_by;
            }
        
            if ($returnType == 'MONTHLY') {
                $monthName = date("F", strtotime($returnDate));
                $year = date("Y", strtotime($returnDate));
            
                $yearDetails = Array(
                    'dateToDisplay' => "month of '$monthName $year'",
                    'type' => 'MONTHLY'
                );
            } else {
                $year = date("Y", strtotime($returnDate));
                $financialYear = $year . " - " . ($year + 1);
            
                $yearDetails = Array(
                    'dateToDisplay' => "Financial Year '$financialYear'",
                    'type' => 'ANNUAL'
                );
            }
            
            $mailParams['toEmailAddress'] = $mail_id;
            $mailParams['user_name'] = $user_name;
            $mailParams['yearDetails'] = $yearDetails;
            $mailParams['activityName'] = "'$activityName'";
            $mailParams['endUserId'] = "'$endUserId'";
            
            $mail = new siteMails();
            try {
                $sent = $mail->nAndOReturnRejectionEmail($mailParams);
            } catch (Exception $e) {
                
            }
            
            if ($sent){
                return true;
            } else {
                return false;
            }

        }

        
	    /**
	     * GET LATEST REASONS
	     * @version 12th APR 2021
         * @author Aniket Ganvir
	     */
	    public function getLatestReasons($endUserId, $returnDate, $returnType = 'MONTHLY') {

	        $query = $this->find()
	                ->select(['rejected_section_remarks'])
	                ->where(['applicant_id IS'=>$endUserId, 'return_date IS'=>$returnDate, 'return_type IS'=>$returnType, 'is_latest'=>'1'])
	                ->first();

            return $query;
	    }

        /**
         * RETURN LATEST RETURN ID
         * @version 16th JUL 2021
         * @author Aniket Ganvir
         */
        public function getLatestReturnId($endUserId, $returnDate, $returnType = 'MONTHLY') {

	        $query = $this->find()
	                ->select(['id'])
	                ->where(['applicant_id'=>$endUserId, 'submitted_by'=>$endUserId, 'return_date'=>$returnDate, 'return_type'=>$returnType, 'is_latest'=>'1'])
	                ->first();

	        if ($query){
	            return $query['id'];
			} else {
				return null;
			}

	    }

        // get return by return id
	    public function findReturnById($return_id) {

	        $query = $this->find('all')
	                ->where(['id'=>$return_id])
	                ->first();

            return $query;
	    }

		// udpate/save applicant communication reply
	    public function saveApplicantReply($forms_data, $returnId = ''){

			$dataValidatation = $this->postReplyValidation($forms_data);

			if($dataValidatation == 1 ){

	            $reason = $forms_data['reason'];
	            $submit = $forms_data['submit'];
	            $endUserId = $forms_data['mine_code'];
	            $returnDate = $forms_data['return_date'];
	            $returnType = $forms_data['return_type'];
	            $user_id = $forms_data['mms_user_id'];
	            $sec_id = $forms_data['section_id'];
	            $part_no = $forms_data['part_no'];
                
	            $mcUser = TableRegistry::getTableLocator()->get('McUser');
                $regNo = $mcUser->getAppIdWithRegNo($endUserId);
                $ibmUniqueRegNo = str_replace('_','/',$regNo);

	            if($returnId == ''){
	                $returns = $this->getReturnId($endUserId, $returnDate, $returnType, $ibmUniqueRegNo);
		            $tmp = end($returns);
		            $return_id = $tmp['id'];
	            } else {
		            $return_id = $returnId;
	            }

	            $result = false;

	            if ($submit == "save_comment") {
	                $reject = $this->saveReply($return_id, $reason, $part_no, $sec_id);

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
		 * REMOVE APPLICANT REPLY FROM SECTION COMMUNICATION WINDOW
		 * @addedon: 16th JUL 2021 (by Aniket Ganvir)
		 */
	    public function remReply($forms_data){

			// $dataValidatation = $this->postDataValidation($forms_data);

			// if($dataValidatation == 1 ){

	            $submit = $forms_data['submit'];
	            $endUserId = $forms_data['mine_code'];
	            $returnDate = $forms_data['return_date'];
	            $returnType = $forms_data['return_type'];
	            $user_id = $forms_data['mms_user_id'];
	            $return_id = $forms_data['return_id'];
	            $section_id = $forms_data['section_id'];
	            $part_no = $forms_data['part_no'];

	            $result = false;

	            if ($submit == "remove_comment") {
	                $reject = $this->removeRejectReply($return_id, $part_no, $section_id);

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
	    public function removeRejectReply($id, $part_no = '', $section) {

			date_default_timezone_set('Asia/Kolkata');
			
	        $existing = $this->find('all')
	                ->select(['approved_sections', 'rejected_section_remarks', 'rejected_section_date', 'reply', 'reply_date'])
	                ->where(['id'=>$id])
	                ->toArray();

	        $remarks_array = array();
	        $date_array = array();

	        $remarks = $existing[0]['reply'];
	        $dates = $existing[0]['reply_date'];
	        $current_time = date('Y-m-d H:i:s');

            $remarks_array = unserialize($remarks);
            $date_array = unserialize($dates);

            $remarks_array[$part_no][$section] = '';
            $date_array[$part_no][$section] = '';

	        $rejected_section_remarks = serialize($remarks_array);
	        $rejected_section_date = serialize($date_array);

	        $tbl_end_user_final_submit = TableRegistry::getTableLocator()->get('TblEndUserFinalSubmit');
			$final_submit = $tbl_end_user_final_submit->get($id);

			$final_submit->reply = $rejected_section_remarks;
			$final_submit->reply_date = $rejected_section_date;

			$result = false;
	        if ($tbl_end_user_final_submit->save($final_submit)){
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
	     * @param type $part_no
	     * @param type $section
	     * @param type $is_supervisor
	     * @return boolean 
	     */
	    public function saveReply($id, $reason, $part_no = '', $section) {

			$reason = htmlentities($reason, ENT_QUOTES);
			date_default_timezone_set('Asia/Kolkata');
			
	        $existing = $this->find('all')
	                ->select(['approved_sections', 'rejected_section_remarks', 'rejected_section_date', 'reply', 'primary_comment_remarks', 'primary_comment_date'])
	                ->where(['id'=>$id])
	                ->toArray();

	        $reply_array = array();
	        $date_array = array();

	        $reply = $existing[0]['reply'];
	        $dates = $existing[0]['reply_date'];
	        $current_time = date('Y-m-d H:i:s');

	        if ($reply == "") {
	            //if empty of approved array dont need to check the existence.Just push it
                $reply_array[$part_no][$section] = $reason;
                $date_array[$part_no][$section] = $current_time;
	        } else {

	            $reply_array = unserialize($reply);
	            $date_array = unserialize($dates);

                $reply_array[$part_no][$section] = $reason;
                $date_array[$part_no][$section] = $current_time;
	        }

	        $reply_sections = serialize($reply_array);
	        $date_sections = serialize($date_array);

	        $tbl_end_user_final_submit = TableRegistry::getTableLocator()->get('TblEndUserFinalSubmit');
			$final_submit = $tbl_end_user_final_submit->get($id);

			$final_submit->reply = $reply_sections;
			$final_submit->reply_date = $date_sections;

			$result = false;
	        if ($tbl_end_user_final_submit->save($final_submit)){
	            $result = 1;
	        }
	        return $result;

	    }
        
	    // CHECK END/MINE USER SECTION REPLIED STATUS
	    // @addedon: 16th JUL 2021
	    public function checkReplyStatus($endUserId, $returnType, $returnDate){

	        $result = $this->find('all')
	                ->where(['applicant_id'=>$endUserId, 'submitted_by'=>$endUserId, 'return_date'=>$returnDate, 'return_type'=>$returnType, 'is_latest'=>'1'])
	                ->limit(1)
					->toArray();

			if(count($result) == 0){
				$approved_sections = array();
				$reply = array();
			} else {
				$approved_sections = ($result[0]['approved_sections'] != '') ? unserialize($result[0]['approved_sections']) : array();
				$reply = unserialize($result[0]['reply']);
			}

			$reply_status = 1;
			foreach($approved_sections as $key=>$val){
				foreach($val as $section_id=>$section_val){
					if($section_val == 'Rejected'){
						if(isset($reply[$key][$section_id]) && $reply[$key][$section_id] != ''){
							//
						} else {
							$reply_status = 0;
						}
					}
				}
			}

			return $reply_status;

	    }
        
	    // FINAL SUBMIT AFTER REFERRED BACK
	    // @addedon: 16th JUL 2021 (by Aniket Ganvir)
	    public function finalSubmitRef($forms_data){

			$dataValidatation = $this->finalSubmitRefValidation($forms_data);

			if($dataValidatation == 1 ){

	            $submit = $forms_data['submit'];
	            $endUserId = $forms_data['mine_code'];
	            $returnDate = $forms_data['return_date'];
	            $returnType = $forms_data['return_type'];
	            $user_id = $forms_data['mms_user_id'];
	            $mcUser = TableRegistry::getTableLocator()->get('McUser');
                $regNo = $mcUser->getAppIdWithRegNo($endUserId);
                $ibmUniqueRegNo = str_replace('_','/',$regNo);

                $mineCode = $forms_data['mine_code'];

                $returns = $this->getReturnId($endUserId, $returnDate, $returnType, $ibmUniqueRegNo);
	            $tmp = end($returns);
	            $return_id = $tmp['id'];

	            $result = false;

	            if ($submit == "final_submit_ref") {

			        $tbl_end_user_final_submit = TableRegistry::getTableLocator()->get('TblEndUserFinalSubmit');

                    $appSec = $this->getApprovedSec($mineCode, $returnDate, $returnType);


					$final_submit = $tbl_end_user_final_submit->get($return_id);

					$final_submit->is_latest = 0;

					$result = false;
			        if ($tbl_end_user_final_submit->save($final_submit)){
			            $result = 1;
			        }

			        $data = $this->findReturnById($return_id);

			        $return = $tbl_end_user_final_submit->newEmptyEntity();

                    $return->approved_sections = $appSec;
                    
			        $return->applicant_id = $data['applicant_id'];
			        $return->submitted_by = $data['submitted_by'];
			        $return->ibm_unique_reg_no = $data['ibm_unique_reg_no'];
			        $return->user_type = $data['user_type'];
			        $return->return_type = $data['return_type'];
			        $return->return_date = $data['return_date'];
					$return->status = 0; //need to review with existing system
					$return->status_date = date('Y-m-d'); //need to review with existing system
			        $return->created_at = date('Y-m-d H:i:s A');
			        $return->updated_at = date('Y-m-d H:i:s A');
			        $return->notice = $data['notice'];
			        $return->form_type = $data['form_type'];
			        $return->is_latest = 1;

			        if($tbl_end_user_final_submit->save($return)){
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

        
	    // final submit by applicant post data validation
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
	     * @param type $part_no
	     * @param type $section
	     * @param type $is_supervisor
	     * @return boolean 
	     */
	    public function approve($id, $part_no = '', $section, $is_supervisor = false, $main_sec = null, $pdf_path = null) {

	        //get the previous stored array and insert this....
	        $existing = $this->find('all')
	                ->select(['approved_sections'])
	                ->where(['id'=>$id])
	                ->toArray();

	        $approved_array = array();

	        $approved = $existing[0]['approved_sections'];
			$approved_array = unserialize($approved);
			$approved_array['partI'][1] = "Approved";

	        if ($approved == "") {
	            //if empty of approved array dont need to check the existence.Just push it
                $approved_array[$part_no][$section] = "Approved";
	        } else {
                $approved_array[$part_no][$section] = "Approved";
	        }

	        $approved_sections = serialize($approved_array);
			$is_all_approved = $this->checkIsAllApprovedNew($approved_array, $main_sec);
			
	        $result = '0';
	        $tblEndUserFinalSubmit = TableRegistry::getTableLocator()->get('TblEndUserFinalSubmit');
	        $aprove = $tblEndUserFinalSubmit->get($id);
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
	            //$aprove->verified_flag = '1';

				if ($is_all_approved == true) {
	            	$aprove->status = '1';
				} else {
					$aprove->status = '0';
				}

	        }

	        if ($tblEndUserFinalSubmit->save($aprove)){
				
				if ($is_all_approved == true) {
                    // send sms 
                    $customer_id = $_SESSION["mc_mine_code"];
                    $DirSmsEmailTemplates = TableRegistry::getTableLocator()->get('DirSmsEmailTemplates');
                    //$DirSmsEmailTemplates->sendMessage(12,$customer_id);
	            	$result = '4';
				} else {
	            	$result = '3';
				}

	        }

	        return $result;

	    }

		public function checkIsSubmittedForMMS($registrationCode, $returnDate, $returnType) {

			$query = $this->find()
					->select(['id'])
					->where(['applicant_id'=>$registrationCode])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>$returnType])
					->toArray();
	
			if (count($query) > 0) {
				return true;
			} else {
				return false;
			}
			
		}

		public function getCreatedAt($endUserId, $returnDate, $returnType, $mcu_user_id) {

			$query = $this->find()
					->select(['created_at'])
					->where(['applicant_id'=>$endUserId])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>$returnType])
					->toArray();
	
			if(count($query) > 0){
				$MonthlyController = new MonthlyController;
				$finalSubmitDate = $MonthlyController->Clscommon->globalDateFormat($query[0]['created_at']);
			} else {
				$finalSubmitDate = '';
			}

			return $finalSubmitDate;

		}
		
	    // get return id by $enduserid, $returnDate and $returnType
	    public function getReturnIdExceptLatest($endUserId, $returnDate, $returnType) {

	        $result = $this->find('all')
					->select(['id'])
					->where(['applicant_id'=>$endUserId])
					->where(['return_date'=>$returnDate])
					->where(['return_type'=>$returnType])
	                ->where(['is_latest'=>'0'])
					->toArray();

            return $result;

	    }
		
		/**
		 * CHECKING ALL SECTIONS ARE APPROVED OR NOT
		 * @return TRUE IF ALL SECTIONS ARE APPROVED
		 * @return FALSE IF ALL SECTIONS ARE NOT APPROVED
		 */
		public function checkIsAllApprovedNew($appSec, $mainSec) {
	
			$result = true;

			if ($mainSec != null) {

				$mainSecArr = unserialize($mainSec);

				if (is_array($mainSecArr)) {

					foreach ($mainSecArr as $partK=>$partV) {
	
						foreach ($partV as $k => $status) {
							
							if (isset($appSec[$partK][$k])) {
								if ($appSec[$partK][$k] != 'Approved') {
									$result = false;
								}
							} else {
								$result = false;
							}
						}
	
					}

				} else {
					$result = false;
				}

			}
			
			return $result;

		}

		/**
		 * GET SUPERVISOR COMMENTS IN ENDUSER PANEL
		 * FOR DASHBOARD COMMENT INBOX SECTION
		 * @version 22nd Jan 2022
		 * @author Aniket Ganvir
		 */
		public function getSupervisorComments($applicantId) {

			$data = $this->find()
				->select(['rejected_section_remarks', 'rejected_section_date', 'return_type', 'return_date'])
				->where(['applicant_id IS'=>$applicantId])
				->where(['status'=>4])
				->where(['is_latest'=>1])
				->order(['status_date'=>'DESC'])
				->toArray();

			$lRemark = array();

			if (count($data) > 0) {

				$lPart = array();
				$lSec = array();
				$totalRemark = array();
				$totalDate = array();
				$totalReturnType = array();
				$totalReturnDate = array();

				foreach ($data as $d) {

					$remark = $d['rejected_section_remarks'];
					$date = $d['rejected_section_date'];
					$appSec = unserialize($remark);
					$dateSec = unserialize($date);
					$totalRemark[] = $appSec;
					$totalDate[] = $dateSec;
					$totalReturnType[] = ($d['return_type'] == 'MONTHLY') ? "L" : "M";
					$totalReturnDate[] = ($d['return_type'] == 'MONTHLY') ? (date('M-Y', strtotime($d['return_date']))) : (date('Y', strtotime($d['return_date']))."-".(date('Y', strtotime($d['return_date']))+1));

					if (is_array($dateSec)) {

						foreach ($dateSec as $partK=>$partV) {

							$latestDate = '0000-00-00 00:00:00';
		
							if ($partK == 'iron_ore') {
		
								foreach ($partV as $k => $v) {
									foreach ($v as $status) {
										//
									}
								}
		
							} else {
								foreach ($partV as $k => $rDate) {

									if ($rDate > $latestDate) {
										$latestPart = $partK;
										$latestSec = $k;
									}
									
								}
							}
		
						}

						$lPart[] = $latestPart;
						$lSec[] = $latestSec;

					}

				}

				$tParts = count($lPart);
				for ($i=0; $i<$tParts; $i++) {

					$rmk = $totalRemark[$i][$lPart[$i]][$lSec[$i]];
					if (strlen($rmk) > 50) {
						$rmk = substr($rmk, 0, 40);
					}
					$dt = date('d-m-Y h:i A', strtotime($totalDate[$i][$lPart[$i]][$lSec[$i]]));
					$lRemark[$i]['remark'] = $rmk;
					$lRemark[$i]['date'] = $dt;
					$lRemark[$i]['form'] = $totalReturnType[$i];
					$lRemark[$i]['return'] = $totalReturnDate[$i];

				}
				
			}

			return $lRemark;

		}

		/**
		 * GET ENDUSER COMMENTS IN MMS PANEL
		 * FOR DASHBOARD COMMENT INBOX SECTION
		 * @version 22nd Jan 2022
		 * @author Aniket Ganvir
		 */
		public function getEnduserComments($mmsUserId) {
			
	        $con = ConnectionManager::get(Configure::read('conn'));
	        $data = $con->execute("select 
				te.reply as remark,
				te.reply_date as remark_date,
				te.return_date as return_date,
				te.return_type as return_type,
				te.applicant_id as applicant_id
				from tbl_allocation_n_o_details ta,
				tbl_end_user_final_submit te
				where ta.sup_id = '$mmsUserId'
				and te.applicant_id = ta.registration_code
				and te.reply is not null
				and te.status = 4
				and te.is_latest = 0
				group by te.applicant_id,te.return_date order by te.status_date desc")->fetchAll('assoc');

			$lRemark = array();

			if (count($data) > 0) {

				$lPart = array();
				$lSec = array();
				$totalRemark = array();
				$totalDate = array();
				$totalReturnType = array();
				$totalReturnDate = array();
				$totalReturnAppID = array();
				$count = 0;

				foreach ($data as $d) {

					if($count > 10){

						break;
					}

					$chk_return_date = $d['return_date'];
					$chk_return_type = $d['return_type'];
					$chk_applicant_id = $d['applicant_id'];
					
					$check_result = $con->execute("select id 
						from tbl_end_user_final_submit 
						where return_date = '$chk_return_date'
						and return_type = '$chk_return_type'
						and applicant_id = '$chk_applicant_id'
						and status REGEXP '3|4'
						and is_latest = 1
					")->fetchAll('assoc');

					if(empty($check_result)){					

						$remark = $d['remark'];
						$date = $d['remark_date'];
						$appSec = unserialize($remark);
						$dateSec = unserialize($date);
						$totalRemark[] = $appSec;
						$totalDate[] = $dateSec;
						$totalReturnType[] = ($d['return_type'] == 'MONTHLY') ? "L" : "M";
						$totalReturnDate[] = ($d['return_type'] == 'MONTHLY') ? (date('M-Y', strtotime($d['return_date']))) : (date('Y', strtotime($d['return_date']))."-".(date('Y', strtotime($d['return_date']))+1));
						$totalReturnAppID[] = $d['applicant_id'];

						if (is_array($dateSec)) {

							foreach ($dateSec as $partK=>$partV) {

								$latestDate = '0000-00-00 00:00:00';
			
								if ($partK == 'iron_ore') {
			
									foreach ($partV as $k => $v) {
										foreach ($v as $status) {
											//
										}
									}
			
								} else {
									foreach ($partV as $k => $rDate) {

										if ($rDate > $latestDate) {
											$latestPart = $partK;
											$latestSec = $k;
										}
										
									}
								}
			
							}

							$lPart[] = $latestPart;
							$lSec[] = $latestSec;
							$count++;
						}

					}

				}

				$tParts = count($lPart);
				for ($i=0; $i<$tParts; $i++) {

					$rmk = $totalRemark[$i][$lPart[$i]][$lSec[$i]];
					if (strlen($rmk) > 50) {
						$rmk = substr($rmk, 0, 40);
					}
					$dt = date('d-m-Y h:i A', strtotime($totalDate[$i][$lPart[$i]][$lSec[$i]]));
					$lRemark[$i]['remark'] = $rmk;
					$lRemark[$i]['date'] = $dt;
					$lRemark[$i]['form'] = $totalReturnType[$i];
					$lRemark[$i]['return'] = $totalReturnDate[$i];
					$lRemark[$i]['app_id'] = $totalReturnAppID[$i];

				}
				
			}

			return $lRemark;

		}
        public function scrutinize($id) {

            date_default_timezone_set('Asia/Kolkata');
            
            $current_time = date('Y-m-d H:i:s');

            $tbl_end_user_final_submit = TableRegistry::getTableLocator()->get('TblEndUserFinalSubmit');
            $final_submit = $tbl_end_user_final_submit->get($id);
            $final_submit->verified_flag = 1;
                

            $result = false;
            if ($tbl_end_user_final_submit->save($final_submit)){
                $result = 1;
            }
            return $result;
        }

		public function getFileReturnYear($regNo, $applicantId) {

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

		    $submittedData = $this->find('all')
				->select(['return_date'])
				->where(['ibm_unique_reg_no'=>$regNo])
				->where(['applicant_id'=>$applicantId])
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
		
		// GET PENDING RETURN YEARS FOR FILING ANNUAL RETURN (M SERIES)
		// Added on dated 09-02-2022 by Aniket G
		public function getAnnualFileReturnYear($regNo, $applicantId) {

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

		    $submittedData = $this->find('all')
				->select(['return_date'])
				->where(['ibm_unique_reg_no'=>$regNo])
				->where(['applicant_id'=>$applicantId])
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
		 * GET RETURN CURRENT STATUS FOR PDF WATERMARK
		 * @version 15th Jan 2022
		 * @author Aniket Ganvir
		 */
		public function getPdfStatus($applicantId, $returnDate, $returnType) {

			$data = $this->find()
				->select(['status'])
				->where(['applicant_id'=>$applicantId])
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
        /**
         * Dis-approves the return
         * 
         * 
         * @param type $id
         * @param type $part_no
         * @param type $section
         * @param type $is_supervisor
         * @return boolean 
         */
        public function disapprove($id, $part_no = '', $section, $is_supervisor = false, $main_sec = null) {

            //get the previous stored array and insert this....
            $existing = $this->find('all')
                    ->select(['approved_sections', 'rejected_section_remarks'])
                    ->where(['id'=>$id])
                    ->toArray();

            $approved = $existing[0]['approved_sections'];
            $remarks = $existing[0]['rejected_section_remarks'];
            $approved_array = unserialize($approved);
            $remarks_array = unserialize($remarks);

            $approved_array['partI'][1] = "Approved";

            if ($approved != "") {
				if (isset($remarks_array[$part_no][$section]) && $remarks_array[$part_no][$section] != "") {
					$approved_array[$part_no][$section] = "Rejected";
				} else {
					$approved_array[$part_no][$section] = "";
				}
            }

            $approved_sections = serialize($approved_array);
            
            $result = '0';
            $tblEndUserFinalSubmit = TableRegistry::getTableLocator()->get('TblEndUserFinalSubmit');
            $aprove = $tblEndUserFinalSubmit->get($id);
            $aprove->approved_sections = $approved_sections;

            
            if($tblEndUserFinalSubmit->save($aprove)){
                $result = '3';
            }

            return $result;

        }
        // Last unapproved section Date : 17-01-2022 Shalini D
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
            if ($main_sec != null) {
                $mainSecArr = unserialize($main_sec);
                if (is_array($mainSecArr)) {
                    foreach ($mainSecArr as $partK=>$partV) {
                        foreach($partV as $k => $status) {
                           if($partK !='partI') 
                           {
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
            }
            $lastPart = "";
            $lastSec = "";

            if(!empty($notAppSec)){

                if(count($notAppSec)== 1)
                {
                    foreach($notAppSec as $partA => $valA) 
                    {
                        $lastPart = $partA;
                        if(!empty($valA))
                        {
                            if(count($valA)==1)
                            {
                                foreach ($valA as $valK => $secV) {
                                    $lastSec = $secV;
                                }
                            }
                        }
                    }
                }
            }

           $res['lastPart']= $lastPart;
           $res['lastSec']= $lastSec; 

           return $res;
           
        }

		
		// GET LATEST APPROVED SECTIONS FOR REFLECTING SAME IN NEW REFERRED BACK RETURN
		// Added on 25-02-2022 by Aniket Ganvir
		public function getApprovedSec($app_id, $return_date, $return_type) {
			
			$data = $this->find()
				->select(['approved_sections'])
				->where(['applicant_id'=>$app_id])
				->where(['return_date'=>$return_date])
				->where(['return_type'=>$return_type])
				->where(['is_latest'=>1])
				->limit(1)
				->toArray();

			if (count($data) == 1) {

				$appSecArr = unserialize($data[0]['approved_sections']);

				if (is_array($appSecArr)) {
					$appSec = $appSecArr;
					foreach ($appSecArr as $partK=>$partV) {
	
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
					$appSec = serialize($appSec);

				} else {
					$appSec = null;
				}

			} else {
				$appSec = null;
			}

			return $appSec;

		}

		// GET 'notice' & 'user_type' FROM PREVIOUS LATEST RETURN TO REFLECT ON NEW RETURN
		public function getLastReturnDataForNewReturn($appId, $returnDate, $returnType) {

			$data = $this->find()
				->select(['user_type', 'notice'])
				->where(['applicant_id'=>$appId])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>$returnType])
				->where(['is_latest'=>1])
				->first();

			if (!empty($data)) {
				return $data;
			} else {
				return array('user_type'=>0, 'notice'=>0);
			}

		}


	} 
?>