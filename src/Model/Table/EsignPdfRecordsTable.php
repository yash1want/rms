<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class EsignPdfRecordsTable extends Table{

        var $name = "EsignPdfRecords";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		// final submit return after signature appended in pdf
		public function saveFinalSubmitWithEsignStatus($applicant_user) {

			$login_user_type = $_SESSION['loginusertype'];
			$result['status'] = 0;

			if ($applicant_user == 'authuser') {

				// FOR MINER FINAL SUBMIT
				if ($login_user_type == 'authuser') {
					
					/*
						Final submit entry code disable here because now final submit entry done after successfully esign complete.
						New function created in esign module for final submit entry.
						Done by Pravin Bhakare, 31-07-2020
					*/
					//AS NOW THEY WANT ALL THE DETAILS OF NUMBER OF TIME THE FORM IS SUBMITTED
					//SO THE DELETE FUNCTIONALITY HAS BEEN COMMENTED OUT....
					//IF LATER THEY WANT IT BACK JUST UNCOMMENT HERE AND DONE ...!!!
					//if already final submitted - remove it and make a new entry
					//$remove_record = TBL_FINAL_SUBMITTable::removeFinalSubmit($this->app_id, $this->submitted_by, $this->returnDate);

					$mcu_user_id = $_SESSION['username'];
					$mine_code = $_SESSION['mc_mine_code'];
					$return_date = $_SESSION['returnDate'];
					$return_type = $_SESSION['returnType'];

					$mineMinerals = $_SESSION['mineralArr'];
					$pdf_file_name = $_SESSION['pdf_file_name'];

					$pdf_sub_fold = date('d-m-Y', strtotime($return_date));
					$pdf_path = 'writereaddata/returns/'.strtolower($return_type).'/authuser/'.$pdf_sub_fold.'/'.$pdf_file_name;

					//primary form no
					$primaryMineral = $mineMinerals[0];
					$DirMcpMineral = TableRegistry::getTableLocator()->get('DirMcpMineral');
					$primaryFormNo = $DirMcpMineral->getFormNumber($primaryMineral);

					$temp = explode('/', $mcu_user_id);
					$app_id = $temp[0] . "/" . $temp[1];

					if (count($temp) == 3)
						$submitted_by = $temp[2];
					else
						$submitted_by = $app_id;


					$TblFinalSubmit = TableRegistry::getTableLocator()->get('TblFinalSubmit');
					$appSec = $TblFinalSubmit->getApprovedSec($mine_code, $return_date, $return_type);
					$prevData = $TblFinalSubmit->getLastReturnDataForNewReturn($mine_code, $return_date, $return_type);
					$update_record = $TblFinalSubmit->updateLastSubmittedRecord($app_id, $submitted_by, $mine_code, $return_date, $return_type);

			        $return = $TblFinalSubmit->newEmptyEntity();
					$return->applicant_id = $app_id;
					$return->submitted_by = $submitted_by;
					$return->mine_code = $mine_code;
					$return->return_date = $return_date;
					$return->return_type = $return_type;
					$return->form_type = $primaryFormNo;
					$return->approved_sections = $appSec;
					$return->created_at = date('Y-m-d H:i:s');
					$return->status_date = date('Y-m-d');
			        $return->updated_at = date('Y-m-d H:i:s');
			        $return->notice = $prevData['notice'];
					$return->pdf_path = $pdf_path;
					$return->is_latest = '1';
					
					if ($TblFinalSubmit->save($return)) {
						$result['status'] = 1;
						$result['msg'] = $return_type . ' return successfully submitted!';
					}

					// save esign logs
					$list_id = $this->find('all', array('fields'=>'version', 'conditions'=>array('mine_code'=>$mine_code,'return_type'=>$return_type,'return_date'=>$return_date)))
								->order('id desc')
								->limit(1)
								->first();
								
					if (!empty($list_id)) {
						$last_pdf_version =	$list_id['version'];
					} else{					
						$last_pdf_version = 0;
					}
					$current_pdf_version = $last_pdf_version+1; //increment last version by 1

					$newEntityLog = $this->newEntity(array(
						'applicant_id' => $app_id,
						'mine_code' => $mine_code,
						'return_date' => $return_date,
						'return_type' => $return_type,
						'pdf_file' => $pdf_file_name,
						'status' => 'FINAL SUBMIT',
						'date' => date('Y-m-d'),
						'esigned_by' => $app_id,
						'version' => $current_pdf_version,
						'created' => date('Y-m-d H:i:s'),
						'modified' => date('Y-m-d H:i:s')
					));
					$this->save($newEntityLog);

					// removing temp entry from table
					$log_id = $_SESSION['log_last_insert_id'];
					$TempEsignStatuses = TableRegistry::getTableLocator()->get('TempEsignStatuses');
					$TempEsignStatuses->removeTempLog($log_id);

					// unset($_SESSION['pdf_file_name']); //added to clear pdf file name from session, after esign
					// unset($_SESSION['log_last_insert_id']);

					// send sms
					$customer_id = $_SESSION['username'];
					$DirSmsEmailTemplates = TableRegistry::getTableLocator()->get('DirSmsEmailTemplates');
					$DirSmsEmailTemplates->sendMessage(7,$customer_id);

				}

				
				// FOR MMS SUPERVISOR APPROVAL
				if ($login_user_type == 'mmsuser') {
					
					$mineral = $_SESSION['mc_mineral'];
					$mineral = str_replace(' ','_',$mineral);
					$sub_min = $_SESSION['mc_sub_min'];
					$sec_id = $_SESSION['mc_section_id'];
					$part_no = $_SESSION['mc_part_no'];
					$mine_code = $_SESSION['mc_mine_code'];
					$return_date = $_SESSION['returnDate'];
					$return_type = $_SESSION['returnType'];
					$app_id = $_SESSION['applicantid'];
					$esigned_by = $_SESSION['mms_user_id'];
					$cntrl_nm = $_SESSION['mc_cntrl_nm'];
	
					$TblFinalSubmit = TableRegistry::getTableLocator()->get('TblFinalSubmit');
					$returns = $TblFinalSubmit->getReturnId($mine_code, $return_date, $return_type);
					$tmp = end($returns);
					$return_id = $tmp['id'];
	
					//check if the approval/rejection is done by Supervisor or Primary
					$is_supervisor = false;
					$role = $_SESSION['mms_user_role'];
					if ($role == 2){
						$is_supervisor = true;
					}
					
					$main_sec = $_SESSION['main_sec'];
					$main_sec_parse = serialize($main_sec);
					$pdf_file_name = $_SESSION['pdf_file_name'];
					$pdf_sub_fold = date('d-m-Y', strtotime($return_date));
					$pdf_path = 'writereaddata/returns/'.strtolower($return_type).'/mmsuser/'.$pdf_sub_fold.'/'.$pdf_file_name;
					
					// return approval
					if ($cntrl_nm == 'Mms') {
						$approvalResult = $TblFinalSubmit->approve($return_id, $mineral, $sub_min, $sec_id, $is_supervisor, $main_sec_parse, $pdf_path);
					} else {
						$approvalResult = $TblFinalSubmit->approveAnnual($return_id, $mineral, $sub_min, $sec_id, $is_supervisor, $main_sec_parse, $part_no, $pdf_path);
					}

					if ($approvalResult == 4) {

						// save esign logs
						$list_id = $this->find('all', array('fields'=>'version', 'conditions'=>array('mine_code'=>$mine_code,'return_type'=>$return_type,'return_date'=>$return_date)))
									->order('id desc')
									->limit(1)
									->first();
									
						if (!empty($list_id)) {
							$last_pdf_version =	$list_id['version'];
						} else{					
							$last_pdf_version = 0;
						}
						$current_pdf_version = $last_pdf_version+1; //increment last version by 1

						$newEntityLog = $this->newEntity(array(
							'applicant_id' => $app_id,
							'mine_code' => $mine_code,
							'return_date' => $return_date,
							'return_type' => $return_type,
							'pdf_file' => $pdf_file_name,
							'status' => 'APPROVED',
							'date' => date('Y-m-d'),
							'esigned_by' => $esigned_by,
							'version' => $current_pdf_version,
							'created' => date('Y-m-d H:i:s'),
							'modified' => date('Y-m-d H:i:s')
						));
						$this->save($newEntityLog);
	
						// commented below temp entry code, now esign is removed from MMS division
						// added on 25-08-2022 by Aniket
						// removing temp entry from table
						// $log_id = $_SESSION['log_last_insert_id'];
						// $TempEsignStatuses = TableRegistry::getTableLocator()->get('TempEsignStatuses');
						// $TempEsignStatuses->removeTempLog($log_id);
						
						// send sms 
						$customer_id = $_SESSION["applicantid"];
						$DirSmsEmailTemplates = TableRegistry::getTableLocator()->get('DirSmsEmailTemplates');
						$DirSmsEmailTemplates->sendMessage(11,$customer_id);
						
						$result['status'] = 1;
						$result['msg'] = $return_type . ' return successfully approved!';

					}

				}

			} else {

				// FOR MINER FINAL SUBMIT
				if ($login_user_type == 'enduser') {

					$endUserId = $_SESSION['registration_code'];
					$uniqueRegNO = $_SESSION['regNo'];
					$return_type = $_SESSION['returnType'];
					$return_date = $_SESSION['returnDate'];
					$activity_type = $_SESSION['activityType'];
					$form_type = $_SESSION['formType'];
					$app_id = $_SESSION['username'];
					
					$pdf_file_name = $_SESSION['pdf_file_name'];

					$pdf_sub_fold = date('d-m-Y', strtotime($return_date));
					$pdf_path = 'writereaddata/returns/'.strtolower($return_type).'/enduser/'.$pdf_sub_fold.'/'.$pdf_file_name;

					$TblEndUserFinalSubmit = TableRegistry::getTableLocator()->get('TblEndUserFinalSubmit');
					$appSec = $TblEndUserFinalSubmit->getApprovedSec($app_id, $return_date, $return_type);
					$prevData = $TblEndUserFinalSubmit->getLastReturnDataForNewReturn($app_id, $return_date, $return_type);
					$update_record = $TblEndUserFinalSubmit->updateLastSubmittedRecord($endUserId, $endUserId, $return_date, $return_type);
		
			        $return = $TblEndUserFinalSubmit->newEmptyEntity();
					$return->applicant_id = $endUserId;
					$return->submitted_by = $endUserId;
					$return->ibm_unique_reg_no = htmlentities($uniqueRegNO, ENT_QUOTES);
			        $return->user_type = $prevData['user_type'];
					$return->return_date = $return_date;
					$return->return_type = $return_type;
					// 'replied_section_remarks'=>htmlentities(serialize($this->getUser()->getAttribute('replied_section_remarks')), ENT_QUOTES);
					$return->verified_flag = 0;
					$return->status = 0;
					$return->form_type = $form_type;
					$return->status_date = date('Y-m-d');
					$return->pdf_path = $pdf_path;
					$return->approved_sections = $appSec;
					$return->created_at = date('Y-m-d H:i:s');
			        $return->updated_at = date('Y-m-d H:i:s');
			        $return->notice = $prevData['notice'];
					$return->is_latest = 1;
					
					if ($TblEndUserFinalSubmit->save($return)) {
						$result['status'] = 1;
						$result['msg'] = $return_type . ' return successfully submitted!';
					}

					// save esign logs
					$list_id = $this->find('all', array('fields'=>'version', 'conditions'=>array('applicant_id'=>$app_id,'return_type'=>$return_type,'return_date'=>$return_date)))
								->order('id desc')
								->limit(1)
								->first();
								
					if (!empty($list_id)) {
						$last_pdf_version =	$list_id['version'];
					} else{					
						$last_pdf_version = 0;
					}
					$current_pdf_version = $last_pdf_version+1; //increment last version by 1

					$newEntityLog = $this->newEntity(array(
						'applicant_id' => $app_id,
						'return_date' => $return_date,
						'return_type' => $return_type,
						'pdf_file' => $pdf_file_name,
						'status' => 'FINAL SUBMIT',
						'date' => date('Y-m-d'),
						'esigned_by' => $app_id,
						'version' => $current_pdf_version,
						'created' => date('Y-m-d H:i:s'),
						'modified' => date('Y-m-d H:i:s')
					));
					$this->save($newEntityLog);
					
					// removing temp entry from table
					$log_id = $_SESSION['log_last_insert_id'];
					$TempEsignStatuses = TableRegistry::getTableLocator()->get('TempEsignStatuses');
					$TempEsignStatuses->removeTempLog($log_id);

					// clear esign pdf session variable
					unset($_SESSION['pdf_file_name']);
					unset($_SESSION['log_last_insert_id']);
		
					// send sms
					$customer_id = $_SESSION['username'];
					$DirSmsEmailTemplates = TableRegistry::getTableLocator()->get('DirSmsEmailTemplates');
					$DirSmsEmailTemplates->sendMessage(8,$customer_id);

				}

				// FOR MMS SUPERVISOR APPROVAL
				if ($login_user_type == 'mmsuser') {

					$app_id = $_SESSION['mc_mine_code'];
					$return_date = $_SESSION['returnDate'];
					$return_type = $_SESSION['returnType'];
					$ibm_unique_reg_no = $_SESSION['ibm_unique_reg_no'];
					$part_no = $_SESSION['mc_part_no'];
					$sec_id = $_SESSION['mc_section_id'];
					$esigned_by = $_SESSION['mms_user_id'];
					
					$TblEndUserFinalSubmit = TableRegistry::getTableLocator()->get('TblEndUserFinalSubmit');
					$returns = $TblEndUserFinalSubmit->getReturnId($app_id, $return_date, $return_type, $ibm_unique_reg_no);
					$tmp = end($returns);
					$return_id = $tmp['id'];
	
					//check if the approval/rejection is done by Supervisor or Primary
					$is_supervisor = false;
					
					$userRole = $_SESSION['mms_user_role'];
					if ($userRole == 8){
						$is_supervisor = true;
					}
	
					$result = false;
	
					$main_sec = $_SESSION['main_sec'];
					$main_sec_parse = serialize($main_sec);
					$pdf_file_name = $_SESSION['pdf_file_name'];
					$pdf_sub_fold = date('d-m-Y', strtotime($return_date));
					$pdf_path = 'writereaddata/returns/'.strtolower($return_type).'/mmsuser/'.$pdf_sub_fold.'/'.$pdf_file_name;
					$approvalResult = $TblEndUserFinalSubmit->approve($return_id, $part_no, $sec_id, $is_supervisor, $main_sec_parse, $pdf_path);
					
					if ($approvalResult == 4) {

						// save esign logs
						$list_id = $this->find('all', array('fields'=>'version', 'conditions'=>array('applicant_id'=>$app_id,'return_type'=>$return_type,'return_date'=>$return_date)))
									->order('id desc')
									->limit(1)
									->first();
									
						if (!empty($list_id)) {
							$last_pdf_version =	$list_id['version'];
						} else{					
							$last_pdf_version = 0;
						}
						$current_pdf_version = $last_pdf_version+1; //increment last version by 1

						$newEntityLog = $this->newEntity(array(
							'applicant_id' => $app_id,
							'return_date' => $return_date,
							'return_type' => $return_type,
							'pdf_file' => $pdf_file_name,
							'status' => 'APPROVED',
							'date' => date('Y-m-d'),
							'esigned_by' => $esigned_by,
							'version' => $current_pdf_version,
							'created' => date('Y-m-d H:i:s'),
							'modified' => date('Y-m-d H:i:s')
						));
						$this->save($newEntityLog);
	
						// commented below temp entry code, now esign is removed from MMS division
						// added on 25-08-2022 by Aniket
						// removing temp entry from table
						// $log_id = $_SESSION['log_last_insert_id'];
						// $TempEsignStatuses = TableRegistry::getTableLocator()->get('TempEsignStatuses');
						// $TempEsignStatuses->removeTempLog($log_id);
						
						// send sms 
						$customer_id = $_SESSION["mc_mine_code"];
						$DirSmsEmailTemplates = TableRegistry::getTableLocator()->get('DirSmsEmailTemplates');
						$DirSmsEmailTemplates->sendMessage(12,$customer_id);
				
						$result['status'] = 1;
						$result['msg'] = $return_type . ' return successfully approved!';

					}

				}

			}

			return $result;

		}

		// Get all PDF version list of particular return
		// Added on 11-08-2022 by Aniket
		public function getPdfVersionList($applicantId, $returnDate, $returnType, $userType) {

			$applicantIdCol = ($userType == 'authuser') ? 'mine_code' : 'applicant_id';

			$data = $this->find()
				->select(['pdf_file','date','status','version'])
				->where([$applicantIdCol=>$applicantId])
				->where(['return_date'=>$returnDate])
				->where(['return_type'=>$returnType])
				->where(['pdf_file IS NOT NULL'])
				->toArray();

			if (count($data) == 0) {
				return array();
			} else {
				$result = array();
				foreach($data as $key=>$val){
					$result[$key]['version'] = $val['version'];
					$result[$key]['status'] = $val['status'];
					$result[$key]['esigned_date'] = date('d/m/Y', strtotime($val['date']));
					$returnDateFormatted = date('d-m-Y',strtotime($returnDate));
					$usertypedir = ($val['status'] == 'APPROVED') ? 'mmsuser' : $userType;
					$result[$key]['pdf_path'] = '../writereaddata/returns/'.strtolower($returnType).'/'.$usertypedir.'/'.$returnDateFormatted.'/'.$val['pdf_file'];
					$result[$key]['pdf_name'] = $val['pdf_file'];
				}

				return $result;
			}

		}

    }
?>    