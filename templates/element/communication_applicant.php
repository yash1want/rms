
<?php 

$section_link = $this->getRequest()->getSession()->read("sec_link");
$part_link = end($section_link);
$last_sec = end($part_link);
$last_sec = str_replace('_','',$last_sec);

// get current section path for next section redirection purpose
$controller = $this->request->getParam('controller');
$action = $this->request->getParam('action');
$pass = $this->request->getParam('pass');
$passArr = json_encode($pass);
$newPass = str_replace('[','',$passArr);
$newPass = str_replace(']','',$newPass);
$newPass = str_replace(',','/',$newPass);
$newPass = str_replace('"','',$newPass);

$pass_arr = explode('/', $newPass);
$param_one = (isset($pass_arr[0])) ? $pass_arr[0] : '';
$param_two = (isset($pass_arr[1])) ? $pass_arr[1] : '';

$sec_url = '/mms/'.$action;
$sec_url.= ($newPass != null) ? '/'.$newPass : '';

$userRole = $this->getRequest()->getSession()->read("mms_user_role");
$viewUserType = $this->getRequest()->getSession()->read("view_user_type");

// function getFormattedDate($date){
// 	return date('d-m-Y h:i A', strtotime($date));
// }

?>
<div class="card comment_card">
	<?php echo $this->Form->create(null , array('type'=>'file', 'enctype'=>'multipart/form-data','class'=>'form-group')); ?>
		<div class="card-header comment_header bg-secondary text-white">
			<i class="fa fa-comments header-icon"> </i>
			<?php echo $commentLabel['title']; ?>
			<div class="btn-actions-pane-right"></div>
		</div>
		<div class="container cmnt-main">
			<!-- For master admin show all the history. 
			For other users show the history only if it has records other than the current one. 
			For current rejection, the reason will be displayed inside the textarea. -->

			<?php
			$display_history = false;
			// $total_reasons = count($reasons);
			// if ($total_reasons > 0)
			//   $display_history = true;

			if($reasons[0] != null || $reasons[0] !=''){
				// if($reasons[0] == null || $reasons[0] ==''){
				$display_history = true;
			}
			?>

  			<?php if ($display_history == true) { ?>

				<div class="referred-back-history mt-3">
					<table align="center" class="referred-back-history-table table table-bordered v_a_base_td" id="cmnt-table">
						<thead class="thead-light">
							<tr>
								<th class="w_p_44">Comment By You</th>
								<th class="w_p_44">Comment By Scrutinizer</th>
								<th class="w_p_12">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// old comment history
							if(count($reasons_old) > 0){
								foreach ($reasons_old as $reason) { 
								?>
									<tr>
										<td>
											<?php if(isset($reason[$commentLabel['comment']]) && $reason[$commentLabel['comment']] != ""){ ?>
												<span class="badge badge-reason"><i class="pe-7s-date"></i> <?php echo date('d-m-Y h:i A', strtotime($reason[$commentLabel['comment_date']])); ?></span><br><br>
												<?php echo $reason[$commentLabel['comment']]; ?>
											<?php } ?>
										</td>
										<td>
											<?php if(isset($reason[$commentLabel['other_comment']]) && $reason[$commentLabel['other_comment']] != ""){ ?>
												<span class="badge badge-reason"><i class="pe-7s-date"></i> <?php echo date('d-m-Y h:i A', strtotime($reason[$commentLabel['other_comment_date']])); ?></span><br><br>
												<?php echo $reason[$commentLabel['other_comment']]; ?>
											<?php } ?>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							<?php } ?>
								
							<?php
							$total_reasons = count($reasons); $loopC = 1;
							for ($i = 0; $i < $total_reasons; $i++) {
								// if ($reasons[$i][$commentLabel['comment']] != "" || $reasons[$i][$commentLabel['other_comment']] != ""){ ?>
									<tr id="cmnt_container-<?php echo $loopC; ?>">
										<td id="cmnt_rsn-<?php echo $loopC; ?>">

											<?php if($reasons[$i][$commentLabel['comment']] != ""){ ?>
												<span class="badge badge-reason"><i class="pe-7s-date"></i> <?php echo date('d-m-Y h:i A', strtotime($reasons[$i][$commentLabel['comment_date']])); ?></span><br><br>
												<?php echo $reasons[$i][$commentLabel['comment']]; ?>
											<?php } ?>
										</td>
										<td>
											<?php if($reasons[$i][$commentLabel['other_comment']] != ""){ ?>
												<span class="badge badge-reason"><i class="pe-7s-date"></i> <?php echo date('d-m-Y h:i A', strtotime($reasons[$i][$commentLabel['other_comment_date']])); ?></span><br><br>
												<?php echo $reasons[$i][$commentLabel['other_comment']]; ?>
											<?php } ?>
										</td>
										<td>
											<?php if($reasons[$i][$commentLabel['comment']] != ""){ ?>

												<div class="alert alert-success fade show cmnt-msg d_none" role="alert" id="cmnt_msg-<?php echo $loopC; ?>"></div>
												<?php 
													echo $this->Form->button('<i class="pe-7s-note"></i>', array('type'=>'button','class'=>'btn btn-info cmnt-edit', 'id'=>'cmnt_btn-'.$loopC, 'title'=>'Edit comment', 'escapeTitle'=>false));

													echo $this->Form->button('<i class="pe-7s-trash"></i>', array('type'=>'button','class'=>'btn btn-danger cmnt-del ml-1', 'id'=>'cmnt_del-'.$loopC, 'title'=>'Delete comment', 'escapeTitle'=>false));

													echo $this->Form->button('<i class="pe-7s-trash"></i> Confirm Delete', array('type'=>'button','class'=>'btn btn-danger cmnt-del-conf ml-1 d_none', 'id'=>'cmnt_del_conf-'.$loopC, 'escapeTitle'=>false));

													echo $this->Form->button('<i class="pe-7s-diskette"></i> Update', array('type'=>'button','class'=>'btn btn-success ml-1 cmnt-save d_none', 'id'=>'cmnt_save-'.$loopC, 'escapeTitle'=>false));

													echo $this->Form->button('<i class="pe-7s-close"></i> Cancel', array('type'=>'button','class'=>'btn btn-dark ml-1 cmnt-cancel d_none', 'id'=>'cmnt_cancel-'.$loopC, 'escapeTitle'=>false));

													echo $this->Html->image('ajax-loader.gif', array('alt'=>'loading', 'class'=>'d_none', 'id'=>'ajax_loader'));
												?>

											<?php } ?>
										</td>
									</tr>
									<?php 
										echo $this->Form->control('old_cmnt_rsn-'.$loopC, array('type'=>'hidden', 'id'=>'old_cmnt_rsn-'.$loopC, 'value'=>$reasons[$i][$commentLabel['comment']]));
										echo $this->Form->control('old_cmnt_rsn_dt-'.$loopC, array('type'=>'hidden', 'id'=>'old_cmnt_rsn_dt-'.$loopC, 'value'=>date('d-m-Y h:i A', strtotime($reasons[$i][$commentLabel['comment_date']]))));
										echo $this->Form->control('reason_id-'.$loopC, array('type'=>'hidden', 'id'=>'reason_id-'.$loopC, 'value'=>$reasons[$i]['reason_id']));
									?>
									<?php $loopC++;
								// }
							}

							$last_reason = $reasons[$total_reasons - 1][$commentLabel['comment']];
							?>
						</tbody>
					</table>
				</div>
			<?php } ?>

			<?php echo $this->Html->script('mc/communication_applicant.js?version='.$version); ?>

			<?php 
			/**
			 * COMMENTED THE BELOW LINE FOR NOT SHOWING THE REJECTION BOX FOR MASTER ADMIN
			 * ONLY PRIMARY AND SUPERVISORY USER ARE ALLOWED TO SEE AND FILL THE 
			 * REJECTION BOX
			 * @author Uday Shankar Singh<usingh@ubicsindia.com, udayshankar1306@gmail.com>
			 * @version 10th March 2014
			 * 
			 */
			// if (($viewOnly == false && $is_pri_pending != true) || ($view=='') && ($userRole != 10)) { ?>
	 		<?php //if ($viewOnly == false && $is_pri_pending != true) { ?>
			<?php if ($viewOnly == false && $is_pri_pending != true && $commented_status == false) { ?>
				<!-- <textarea name="reason" class="reason-box form-control"><?php //if(isset($last_reason)){ echo $last_reason; } ?></textarea> -->
				<div class="position-relative form-group">
					<label for="exampleText" class="font-weight-bold">Current Comment</label>
					<?php 
						if(!isset($last_reason)){ $last_reason = ''; }
						echo $this->Form->control('reason', array('type'=>'textarea','class'=>'reason-box form-control col-6', 'id'=>'average_grade-1', 'label'=>false, 'value'=>$last_reason, 'required')); 
					?>
				</div>
			<?php } ?>

	  		<table class="col-12 cmnt-action-btn">
	    		<tr><td align="center" valign="top"></td></tr>
	    		<tr>
					<td align="center">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
							<tr>
								<td colspan="2" align="center" valign="middle" class="d_block">
								<?php

									switch($viewUserType){
										case 'authuser':
											$view_contrl = 'Monthly';
											$pdf_action = 'minerPrintPdf';
											break;
										case 'enduser':
											$view_contrl = 'Enduser';
											$pdf_action = 'enduserPrintPdf';
											break;
										default:
											$view_contrl = 'Monthly';
											$pdf_action = 'minerPrintPdf';
									}
						
									$curAction = $this->getRequest()->getParam('action');
									$firstSec = array('mine', 'instructions');
									if(!in_array($curAction, $firstSec)){
										echo $this->Html->link('<i class="fa fa-arrow-left"></i> Previous', array('controller'=>$view_contrl,'action'=>'prevSection',$action,$controller,$param_one,$param_two), array('class'=>'mt-2 btn btn-info btn-lg ml-1 spinner_btn_nxt float-left', 'escape'=>false));
									}

									if ($viewOnly == true || $is_pri_pending == true || $view == 1 || $userRole == '3') {

										if($commented_status != true){
											// echo tag('input', array('name' => 'submit', 'type' => 'submit', 'id' => 'approve', "value" => "Approve", "class" => "btn", "style" => "width:auto; text-align:center; margin-right:20px;"));
											echo $this->Form->button('Save Comment', array('name'=>'submit','type'=>'submit','id'=>'save_comment','class'=>'mt-2 btn btn-success btn-lg float-left','value'=>'save_comment'));
										}

										if($returnType == 'MONTHLY' && strtolower($last_sec) != strtolower($sec_url)) {
											// echo button_to('Next', 'mms/address', array('class' => 'print-all btn', 'style' => ' margin:2px 10px;'));
											// echo $this->Form->button('Next', array('type'=>'button','id'=>'submit','class'=>'mt-2 btn btn-success btn-lg ml-1','onclick'=>'nextSection('.$controller.','.$action.','.$passArr.')'));
											//echo $this->Html->link('Next', array('controller'=>'Mms','action'=>'nextSection',$action,$newPass), array('class'=>'mt-2 btn btn-success btn-lg ml-1'));
										}
										else {
											// echo button_to('Next', 'mmsHSeries/address', array('class' => 'print-all btn', 'style' => ' margin:2px 10px;'));
										}

									} else {

										// if($this->getRequest()->getSession()->read("comment_status") == '1'){
										// 	// echo $this->Form->button('Final Submit', array('name'=>'submit','type'=>'submit','id'=>'final_submit','class'=>'mt-2 btn btn-success btn-lg ml-1','value'=>'final_submit'));
										// 	echo $this->Form->button('Final Submit', array('name'=>'submit','type'=>'button','id'=>'referred_back','class'=>'mt-2 btn btn-success btn-lg ml-1','onclick'=>'referredBack()'));
										// }

										if($commented_status != true){
											// echo tag('input', array('name' => 'submit', 'type' => 'submit', 'id' => 'approve', "value" => "Approve", "class" => "btn", "style" => "width:auto; text-align:center; margin-right:20px;"));
											echo $this->Form->button('Save Comment', array('name'=>'submit','type'=>'submit','id'=>'save_comment','class'=>'mt-2 btn btn-success btn-lg ml-1 float-left','value'=>'save_comment'));
										} else {

											if($replyStatus == true){
												echo $this->Form->button('Final Submit', array('name'=>'submit','type'=>'button','id'=>'final_submit_ref','class'=>'mt-2 btn btn-success btn-lg ml-1 float-right','value'=>'final_submit_ref'));
											}

											echo $this->Form->button('Update', array('name'=>'submit','type'=>'submit','id'=>'submit','class'=>'mt-2 btn btn-success btn-lg ml-1 update-form float-left','value'=>'Save & Next'));

										}
									}

									// echo button_to('Back to Returns', $return_home_page, array('class' => 'print-all btn', 'target' => '_blank', 'style' => ' margin:2px 10px;')); 
									echo $this->Html->link('Home', $return_home_page, array('class'=>'print-all mt-2 btn btn-primary btn-lg ml-1 spinner_btn_nxt float-left','target' => '_blank'));
									?>
									<!--      below comment button by ganesh satav as per the discuss with ibm person 
									added by ganesh satav dated 1 Sep 2014
									<td><input type='button' id='print_mine_details' value='Print' class='btn' style='float:right; margin:0px 5px;'/></td>-->
									<?php 
									// echo button_to('Print All', 'monthly/printAll?mc=' . $mineCode . "&date=" . $returnDate, array('class' => 'print-all btn', 'target' => '_blank', 'style' => ' margin:0px 5px;')); 
									echo $this->Html->link('Print All', array('controller'=>'returnspdf', 'action'=>$pdf_action), array('class'=>'print-all mt-2 ml-1 btn btn-success btn-lg float-left','target'=>'_blank'));
									
									// "Next" button hide on last section
									$curController = $this->getRequest()->getParam('controller');
									$mineralParam = $this->getRequest()->getParam('pass');
									if(null==$mineralParam){
										$mineralParam = "";
									} else {
										$mineralPar = $mineralParam[0];
										$mineralPar .= (isset($mineralParam[1])) ? "/".$mineralParam[1] : "";
										$mineralParam = "/".$mineralPar;
									}
									$secLink = "/".$curController."/".$curAction.$mineralParam;
									$secLinkArr = $this->getRequest()->getSession()->read('sec_link');
									$secLinkArrLast = end($secLinkArr);
									$secLinkLast = end($secLinkArrLast);
									$secLinkLast = strtolower(str_replace(' ','',$secLinkLast));
									$secLinkLast = str_replace('_','',$secLinkLast);
									$secLink = strtolower(str_replace(' ','',$secLink));

									if($secLink != $secLinkLast){
										echo $this->Html->link('Next <i class="fa fa-arrow-right"></i>', array('controller'=>$view_contrl,'action'=>'nextSection',$action,$controller,$param_one,$param_two), array('class'=>'mt-2 btn btn-info btn-lg ml-1 spinner_btn_nxt float-left', 'escape'=>false));
									}

									?>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							</tbody>
						</table>
      					<?php 
							echo $this->Form->control('mine_code', array('type'=>'hidden', 'id'=>'mine_code', 'value'=>$mineCode));
							echo $this->Form->control('return_date', array('type'=>'hidden', 'id'=>'return_date', 'value'=>$returnDate));
							echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType));
							echo $this->Form->control('mms_user_id', array('type'=>'hidden', 'id'=>'mms_user_id', 'value'=>$mmsUserId));
							echo $this->Form->control('mms_user_role', array('type'=>'hidden', 'id'=>'mms_user_role', 'value'=>$mmsUserRole));
							echo $this->Form->control('section_id', array('type'=>'hidden', 'id'=>'section_id', 'value'=>$sectionId));
							echo $this->Form->control('part_no', array('type'=>'hidden', 'id'=>'part_no', 'value'=>$part_no));
							echo $this->Form->control('mineral', array('type'=>'hidden', 'id'=>'mineral', 'value'=>$mineral));
							echo $this->Form->control('sub_min', array('type'=>'hidden', 'id'=>'sub_min', 'value'=>$sub_min));
							echo $this->Form->control('view_user_type', array('type'=>'hidden', 'id'=>'view_user_type', 'value'=>$viewUserType));
							echo $this->Form->control('home_link', array('type'=>'hidden', 'id'=>'home_link', 'value'=>$this->Url->build(array('controller'=>'auth', 'action'=>'home'))));
							
							if($viewUserType == 'enduser'){
								echo $this->Form->control('return_id', array('type'=>'hidden', 'id'=>'return_id', 'value'=>$return_id));
								echo $this->Form->control('update_comment_url', array('type'=>'hidden', 'id'=>'update_comment_url', 'value'=>$this->Url->build(['controller' => 'Enduser', 'action' => 'updateComment'])));
								echo $this->Form->control('remove_comment_url', array('type'=>'hidden', 'id'=>'remove_comment_url', 'value'=>$this->Url->build(['controller' => 'Enduser', 'action' => 'removeComment'])));
								echo $this->Form->control('refer_back_comment_url', array('type'=>'hidden', 'id'=>'refer_back_comment_url', 'value'=>$this->Url->build(['controller' => 'Enduser', 'action' => 'referredBack'])));
								echo $this->Form->control('final_submit_ref_url', array('type'=>'hidden', 'id'=>'final_submit_ref_url', 'value'=>$this->Url->build(['controller' => 'Enduser', 'action' => 'final_submit_ref'])));
							} else {
								echo $this->Form->control('update_comment_url', array('type'=>'hidden', 'id'=>'update_comment_url', 'value'=>$this->Url->build(['controller' => 'Monthly', 'action' => 'updateComment'])));
								echo $this->Form->control('remove_comment_url', array('type'=>'hidden', 'id'=>'remove_comment_url', 'value'=>$this->Url->build(['controller' => 'Monthly', 'action' => 'removeComment'])));
								echo $this->Form->control('refer_back_comment_url', array('type'=>'hidden', 'id'=>'refer_back_comment_url', 'value'=>$this->Url->build(['controller' => 'Monthly', 'action' => 'referredBack'])));
								echo $this->Form->control('final_submit_ref_url', array('type'=>'hidden', 'id'=>'final_submit_ref_url', 'value'=>$this->Url->build(['controller' => 'Monthly', 'action' => 'final_submit_ref'])));
							}
						?>
						<!-- For redirecting purpose get these parameters on POST -->
					</td>
				</tr>
			</table>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
