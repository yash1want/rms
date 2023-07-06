<div class="col-md-3" id="endmonthly">
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
								<div class="widget-numbers text-white text-center"><span>L</span></div>
								<div class="widget-numbers text-white text-center"><span class="count-text"><?php echo $_SESSION['emTSubmittedCount']; ?></span></div>
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
												<div class="widget-numbers text-dark"><?php echo $_SESSION['emSubmittedCount']; ?></div>
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
												<div class="widget-numbers text-dark"><?php echo $_SESSION['emRepliedCount']; ?></div>
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
												<div class="widget-numbers text-primary"><?php echo $_SESSION['emReferredBackCount']; ?></div>
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
												<div class="widget-numbers text-danger"><?php echo $_SESSION['emApprovedCount']; ?></div>
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
												<div class="widget-numbers text-warning"><?php echo $_SESSION['emTPendingCount']; ?></div>
											</div>
										</div>
										<?php if($_SESSION['is_mine_owner'] == false){ ?>
											<?php echo $this->Html->link('<i class="fa fa-plus"></i> File Return', '/enduser/selectReturn', array('escape'=>false, 'class'=>'mb-2 mr-2 btn btn-light mt-4 spinner_btn_nxt')); ?>
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
	
	<div class="col-md-3" id="endannual">
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
								<div class="widget-numbers text-white text-center"><span>M</span></div>
								<div class="widget-numbers text-white text-center"><span class="count-text"><?php echo $_SESSION['eaTSubmittedCount']; ?></span></div>
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
											<div class="widget-numbers text-dark"><?php echo $_SESSION['eaSubmittedCount']; ?></div>
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
											<div class="widget-numbers text-dark"><?php echo $_SESSION['eaRepliedCount']; ?></div>
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
											<div class="widget-numbers text-primary"><?php echo $_SESSION['eaReferredBackCount']; ?></div>
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
											<div class="widget-numbers text-danger"><?php echo $_SESSION['eaApprovedCount']; ?></div>
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
											<div class="widget-numbers text-warning"><?php echo $_SESSION['eaTPendingCount']; ?></div>
										</div>
									</div>
									<?php if($_SESSION['is_mine_owner'] == false){ ?>
										<?php echo $this->Html->link('<i class="fa fa-plus"></i> File Return', '/enduser/selectAnnualReturn', array('escape'=>false, 'class'=>'mb-2 mr-2 btn btn-light mt-4 spinner_btn_nxt')); ?>
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