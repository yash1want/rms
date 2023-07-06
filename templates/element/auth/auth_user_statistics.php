<?php 
// $fileReturnBtnFlag = ($_SESSION['mc_form_main'] != 0 && ($_SESSION['is_mine_owner'] == true || $_SESSION['endUserFlag'] == false)) ? true : (($_SESSION['is_mine_owner'] == true || $_SESSION['endUserFlag'] == true) ? true : false);
$fileReturnBtnFlag = (in_array($_SESSION['loginusertype'], array('authuser','enduser'))) ? true : false; //changed condition on 23-08-2022
?>
<div class="col-md-3" id="authmonthly">
		<div class="main-card mb-3 card">
			<ul class="list-group list-group-flush u_midnight_bloom">
				<li class="list-group-item p-0 m-0">
					<div class="widget-content u_midnight_bloom_one">
						<div class="widget-content-wrapper text-white">
							<div class="widget-content-left">
								<div class="widget-heading">Total Returns</div>
								<div class="widget-subheading">Monthly Statistics</div>
							</div>
							<div class="widget-content-right">
								<div class="widget-numbers text-white text-center"><span>F<?php echo $this->getRequest()->getSession()->read('mc_form_main'); ?></span></div>
								<div class="widget-numbers text-white text-center"><span class="count-text"><?php echo $_SESSION['mTSubmittedCount']; ?></span></div>
							</div>
						</div>
					</div>
				</li>
				<li class="list-group-item p-0 m-0">
					<div class="card-body p-2">
						<ul class="list-group u_return_stat bg-white">
						<?php //if($_SESSION['is_mine_owner'] == false){ ?> <!-- Display Submitted Returns statistics to the Mine Owner -->
							<li class="list-group-item pt-0 pb-0">
								<div class="widget-content p-0">
									<div class="widget-content-outer">
										<div class="widget-content-wrapper">
											<div class="widget-content-left">
												<div class="widget-heading">Submitted Returns</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-dark"><?php echo $_SESSION['mSubmittedCount']; ?></div>
											</div>
										</div>
									</div>
								</div>
							</li>
						<?php if($_SESSION['is_mine_owner'] == false){ ?>
							<li class="list-group-item pt-0 pb-0">
								<div class="widget-content p-0">
									<div class="widget-content-outer">
										<div class="widget-content-wrapper">
											<div class="widget-content-left">
												<div class="widget-heading">Replied Returns</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-dark"><?php echo $_SESSION['mRepliedCount']; ?></div>
											</div>
										</div>
									</div>
								</div>
							</li>
						<?php } ?>
							<li class="list-group-item pt-0 pb-0">
								<div class="widget-content p-0">
									<div class="widget-content-outer">
										<div class="widget-content-wrapper">
											<div class="widget-content-left">
												<div class="widget-heading">Referred Back</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-primary"><?php echo $_SESSION['mReferredBackCount']; ?></div>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li class="list-group-item pt-0 pb-0">
								<div class="widget-content p-0">
									<div class="widget-content-outer">
										<div class="widget-content-wrapper">
											<div class="widget-content-left">
												<div class="widget-heading">Returns Accepted</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-danger"><?php echo $_SESSION['mApprovedCount']; ?></div>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li class="list-group-item pt-0 pb-0">
								<div class="widget-content p-0">
									<div class="widget-content-outer">
										<div class="widget-content-wrapper">
											<div class="widget-content-left">
												<div class="widget-heading">Pending</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-warning"><?php echo $_SESSION['mTPendingCount']; ?></div>
											</div>
										</div>
										<?php if($fileReturnBtnFlag == true && $_SESSION['mc_form_main'] != 0){ ?>
											<?php echo $this->Html->link('<i class="fa fa-plus"></i> File Return', '/monthly/selectReturn', array('escape'=>false, 'class'=>'mb-2 mr-2 btn btn-light mt-4 spinner_btn_nxt')); ?>
										<?php } ?>	
									</div>
								</div>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</div>
	
	<div class="col-md-3" id="authannual">
		<div class="main-card mb-3 card">
			<ul class="list-group list-group-flush u_stat_four">
				<li class="list-group-item p-0 m-0">
					<div class="widget-content u_midnight_bloom_one">
						<div class="widget-content-wrapper text-white">
							<div class="widget-content-left">
								<div class="widget-heading">Total Returns</div>
								<div class="widget-subheading">Annual Statistics</div>
							</div>
							<div class="widget-content-right">
								<div class="widget-numbers text-white text-center"><span>G<?php echo $this->getRequest()->getSession()->read('mc_form_main'); ?></span></div>
								<div class="widget-numbers text-white text-center"><span class="count-text"><?php echo $_SESSION['aTSubmittedCount']; ?></span></div>
							</div>
						</div>
					</div>
				</li>
				
			<li class="list-group-item p-0 m-0">
				<div class="card-body p-2">
					<ul class="list-group u_return_stat bg-white">
					<?php //if($_SESSION['is_mine_owner'] == false){ ?> <!-- Display Submitted Returns statistics to the Mine Owner -->
						<li class="list-group-item pt-0 pb-0">
							<div class="widget-content p-0">
								<div class="widget-content-outer">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="widget-heading">Submitted Returns</div>
										</div>
										<div class="widget-content-right">
											<div class="widget-numbers text-dark"><?php echo $_SESSION['aSubmittedCount']; ?></div>
										</div>
									</div>
								</div>
							</div>
						</li>
					<?php if($_SESSION['is_mine_owner'] == false){ ?>
						<li class="list-group-item pt-0 pb-0">
							<div class="widget-content p-0">
								<div class="widget-content-outer">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="widget-heading">Replied Returns</div>
										</div>
										<div class="widget-content-right">
											<div class="widget-numbers text-dark"><?php echo $_SESSION['aRepliedCount']; ?></div>
										</div>
									</div>
								</div>
							</div>
						</li>
					<?php } ?>	
						<li class="list-group-item pt-0 pb-0">
							<div class="widget-content p-0">
								<div class="widget-content-outer">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="widget-heading">Referred Back</div>
										</div>
										<div class="widget-content-right">
											<div class="widget-numbers text-primary"><?php echo $_SESSION['aReferredBackCount']; ?></div>
										</div>
									</div>
								</div>
							</div>
						</li>
						<li class="list-group-item pt-0 pb-0">
							<div class="widget-content p-0">
								<div class="widget-content-outer">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="widget-heading">Returns Accepted</div>
										</div>
										<div class="widget-content-right">
											<div class="widget-numbers text-danger"><?php echo $_SESSION['aApprovedCount']; ?></div>
										</div>
									</div>
								</div>
							</div>
						</li>
						<li class="list-group-item pt-0 pb-0">
							<div class="widget-content p-0">
								<div class="widget-content-outer">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="widget-heading">Pending</div>
										</div>
										<div class="widget-content-right">
											<div class="widget-numbers text-warning"><?php echo $_SESSION['aTPendingCount']; ?></div>
										</div>
									</div>
									<?php if($fileReturnBtnFlag == true && $_SESSION['mc_form_main'] != 0){ ?>
										<?php echo $this->Html->link('<i class="fa fa-plus"></i> File Return', '/annual/selectReturn', array('escape'=>false, 'class'=>'mb-2 mr-2 btn btn-light mt-4 spinner_btn_nxt')); ?>
									<?php } ?>	
								</div>
							</div>
						</li>
					</ul>
				</div>
			</li>
			</ul>
		</div>
	</div>