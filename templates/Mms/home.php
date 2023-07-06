<?php ?>

<div class="row p-0">

	<!-- As per IBM suggestion only ME division supervisor and primary user can't scrutinized the Form
		F and G Done by Pravin Bhakare 10-01-2022 -->
	<?php if(!in_array($_SESSION['mms_user_role'],array('8','9'))){ ?>

	<div class="col-md-3" id="authusermonstatics">
		<div class="main-card mb-3 card">
			<ul class="list-group list-group-flush u_midnight_bloom p-2">
				<li class="list-group-item p-0 m-0">
					<div class="widget-content u_midnight_bloom_one total_return_stat">
						<div class="widget-content-wrapper text-white">
							<div class="widget-content-left">
								<div class="widget-heading">Total Returns</div>
								<div class="widget-subheading">Monthly Statistics</div>
							</div>
							<div class="widget-content-right">
								<div class="widget-numbers text-white text-center"><span>F</span></div>
								<div class="widget-numbers text-white text-center"><span class="count-text"><?php echo $_SESSION['submitted']; ?></span></div>
							</div>
						</div>
					</div>
				</li>
				<li class="list-group-item u_midnight_bloom_two">
					<div class="mb-1 u-card">        
						<div>Returns Pending <span class="font-weight-bold ">(<span class="count-text"><?php echo $_SESSION['pending']; ?></span>)</span></div>
						<div class="progress-bar-sm progress-bar-animated-alt progress u-progress">
							<?php if($_SESSION['submitted'] > 0){ $percentPenMon = $_SESSION['pending']/$_SESSION['submitted']; }else{ $percentPenMon = 0; }  $barPenMon = number_format( $percentPenMon * 100, 2 );    ?>
							<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barPenMon; ?>%;"></div>
						</div>									
					</div>
					<div class="mb-1 u-card"> 
						<div>Returns Referred Back <span class="font-weight-bold">(<span class="count-text"><?php echo $_SESSION['referred']; ?></span>)</span></div>
						<div class="progress-bar-sm progress-bar-animated-alt progress u-progress">
							<?php if($_SESSION['submitted'] > 0){ $percentRefMon = $_SESSION['referred']/$_SESSION['submitted']; }else{ $percentRefMon = 0; } $barRefMon = number_format( $percentRefMon * 100, 2 );   ?>
							<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barRefMon; ?>%;"></div>
						</div>									
					</div>
					<div class="mb-1 u-card">  
						<div>Returns Accepted <span class="font-weight-bold">(<span class="count-text"><?php echo $_SESSION['approved']; ?></span>)</span></div>
						<div class="progress-bar-sm progress-bar-animated-alt progress u-progress">
							<?php if($_SESSION['submitted'] > 0){ $percentAppMon = $_SESSION['approved']/$_SESSION['submitted']; }else{ $percentAppMon = 0; } $barAppMon = number_format( $percentAppMon * 100, 2 );   ?>
							<div class="progress-bar bg-success" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barAppMon; ?>%;"></div>
						</div>									
					</div>
				</li>
				<!--<li class="list-group-item u_midnight_bloom_three text-white stat-border-bottom u-stat-small">
					<div class="widget-content p-0">
						<div class="widget-content-outer">
							<div class="widget-content-wrapper">
								<div class="widget-content-left">
									<div class="widget-heading">Total Sales</div>
								</div>
								<div class="widget-content-right">
									<div class="widget-numbers text-white u-return-stat-num">₹1212k</div>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li class="list-group-item u_midnight_bloom_four text-white stat-border-bottom u-stat-small">
					<div class="widget-content p-0">
						<div class="widget-content-outer">
							<div class="widget-content-wrapper">
								<div class="widget-content-left">
									<div class="widget-heading">Production (T)</div>
								</div>
								<div class="widget-content-right">
									<div class="widget-numbers text-white u-return-stat-num">425k</div>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li class="list-group-item u_midnight_bloom_five text-white">
					<div class="widget-content p-0">
						<div class="widget-content-outer">
							<div class="widget-content-wrapper">
								<div class="widget-content-left">
									<div class="widget-heading">Average Sale Price (per T)</div>
									<div class="widget-subheading">Top 3 Ores <i class="fa fa-arrow-up"></i> </div>
									<div class="widget-subheading top-ore-list">
										<span>○</span>
										<span>Iron Ore</span>
										<span class="float-right">486</span>
									</div>
									<div class="widget-subheading top-ore-list">
										<span>○</span>
										<span>Magnese</span>
										<span class="float-right">562</span>
									</div>
									<div class="widget-subheading top-ore-list">
										<span>○</span>
										<span>Limestone</span>
										<span class="float-right">826</span>
									</div>
									<div class="widget-subheading top-ore-list">
										<a href="#" class="top-ore-more">... more <i class="fa fa-chevron-right"></i></a>
									</div>
								</div>
								
								<div class="widget-content-right">
									<div class="widget-numbers text-warning">₹41k</div>
								</div>
								
							</div>
							
							<a href="#" class="mb-2 mr-2 btn btn-info active mt-4">Show More
							</a>
						
						</div>
					</div>
				</li>-->
			</ul>
		</div>
	</div>

	<div class="col-md-3" id="authuserannstatics">
		<div class="main-card mb-3 card">
			<ul class="list-group list-group-flush u_stat_two p-2">
				<li class="list-group-item p-0 m-0 kkk">
					<div class="widget-content u_midnight_bloom_one">
						<div class="widget-content-wrapper text-white">
							<div class="widget-content-left">
								<div class="widget-heading">Total Returns</div>
								<div class="widget-subheading">Annual Statistics</div>
							</div>
							<div class="widget-content-right">
								<div class="widget-numbers text-white text-center"><span>G</span></div>
								<div class="widget-numbers text-white text-center"><span class="count-text"><?php echo $_SESSION['submittedAnnual']; ?></span></div>
							</div>
						</div>
					</div>
				</li>
				<li class="list-group-item u_midnight_bloom_two">
					<div class="mb-1 u-card">        
						<div>Returns Pending <span class="font-weight-bold ">(<span class="count-text"><?php echo $_SESSION['pendingAnnual']; ?></span>)</span></div>
						<div class="progress-bar-sm progress-bar-animated-alt progress u-progress">
							<?php if($_SESSION['submittedAnnual'] > 0){ $percentPenAnnu = $_SESSION['pendingAnnual']/$_SESSION['submittedAnnual']; }else{ $percentPenAnnu = 0; } $barPenAnnu = number_format( $percentPenAnnu * 100, 2 );   ?>
							<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barPenAnnu; ?>%;"></div>
						</div>									
					</div>
					<div class="mb-1 u-card"> 
						<div>Returns Referred Back <span class="font-weight-bold">(<span class="count-text"><?php echo $_SESSION['referredAnnual']; ?></span>)</span></div>
						<div class="progress-bar-sm progress-bar-animated-alt progress u-progress">
							<?php if($_SESSION['submittedAnnual'] > 0){ $percentRefAnnu = $_SESSION['referredAnnual']/$_SESSION['submittedAnnual']; }else{ $percentRefAnnu = 0; } $barRefAnnu = number_format( $percentRefAnnu * 100, 2 );   ?>
							<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barRefAnnu; ?>%;"></div>
						</div>									
					</div>
					<div class="mb-1 u-card">  
						<div>Returns Accepted <span class="font-weight-bold">(<span class="count-text"><?php echo $_SESSION['approvedAnnual']; ?></span>)</span></div>
						<div class="progress-bar-sm progress-bar-animated-alt progress u-progress">
							<?php if($_SESSION['submittedAnnual'] > 0){ $percentAppAnnu = $_SESSION['approvedAnnual']/$_SESSION['submittedAnnual']; }else{ $percentAppAnnu = 0; } $barAppAnnu = number_format( $percentAppAnnu * 100, 2 );   ?>
							<div class="progress-bar bg-success" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barAppAnnu; ?>%;"></div>
						</div>									
					</div>
				</li>
				<!--<li class="list-group-item u_midnight_bloom_three text-white stat-border-bottom-alt u-stat-small">
					<div class="widget-content p-0">
						<div class="widget-content-outer">
							<div class="widget-content-wrapper">
								<div class="widget-content-left">
									<div class="widget-heading">Total Sales</div>
								</div>
								<div class="widget-content-right">
									<div class="widget-numbers text-white u-return-stat-num">₹1212k</div>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li class="list-group-item u_midnight_bloom_four text-white stat-border-bottom-alt u-stat-small">
					<div class="widget-content p-0">
						<div class="widget-content-outer">
							<div class="widget-content-wrapper">
								<div class="widget-content-left">
									<div class="widget-heading">Production (T)</div>
								</div>
								<div class="widget-content-right">
									<div class="widget-numbers text-white u-return-stat-num">425k</div>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li class="list-group-item u_midnight_bloom_five text-white">
					<div class="widget-content p-0">
						<div class="widget-content-outer">
							<div class="widget-content-wrapper">
								<div class="widget-content-left">
									<div class="widget-heading">Average Sale Price (per T)</div>
									<div class="widget-subheading">Top 3 Ores <i class="fa fa-arrow-up"></i> </div>
									<div class="widget-subheading top-ore-list">
										<span>○</span>
										<span>Iron Ore</span>
										<span class="float-right">486</span>
									</div>
									<div class="widget-subheading top-ore-list">
										<span>○</span>
										<span>Magnese</span>
										<span class="float-right">562</span>
									</div>
									<div class="widget-subheading top-ore-list">
										<span>○</span>
										<span>Limestone</span>
										<span class="float-right">826</span>
									</div>
									<div class="widget-subheading top-ore-list">
										<a href="#" class="top-ore-more">... more <i class="fa fa-chevron-right"></i></a>
									</div>
								</div>
								
								<div class="widget-content-right">
									<div class="widget-numbers text-warning">₹41k</div>
								</div>
								
							</div>
							
							<a href="#" class="mb-2 mr-2 btn btn-info active mt-4">Show More
							</a>
							
						</div>
					</div>
				</li>-->
			</ul>
		</div>
	</div>
	<?php } ?>

	<!-- As per IBM suggestion only ME division supervisor and primary user scrutinized the Form
		L and M Done by Pravin Bhakare 10-01-2022 -->

	<div class="col-md-6 row p-0" id="enduserstatics">
		<?php //if(in_array($userRole,array('8','9'))){ ?>
		<?php if(!in_array($userRole,array('2','3'))){ ?>
		<div class="col-md-6" id="endusermonthlystatics">
			<div class="main-card mb-3 card">
				<ul class="list-group list-group-flush u_stat_three p-2">
					<li class="list-group-item p-0 m-0">
						<div class="widget-content u_midnight_bloom_one">
							<div class="widget-content-wrapper text-white">
								<div class="widget-content-left">
									<div class="widget-heading">Total Returns</div>
									<div class="widget-subheading">Monthly Statistics</div>
								</div>
								<div class="widget-content-right">
									<div class="widget-numbers text-white text-center"><span>L</span></div>
									<div class="widget-numbers text-white text-center"><span class="count-text"><?php echo $_SESSION['endUserSubmitted']; ?></span></div>
								</div>
							</div>
						</div>
					</li>
					<li class="list-group-item u_midnight_bloom_two mb-1">
						<div class="mb-1 u-card">        
							<div>Returns Pending <span class="font-weight-bold ">(<span class="count-text"><?php echo $_SESSION['endUserPending']; ?></span>)</span></div>
							<div class="progress-bar-sm progress-bar-animated-alt progress u-progress">
								<?php if($_SESSION['endUserSubmitted'] > 0){ $percentEndPenMon = $_SESSION['endUserPending']/$_SESSION['endUserSubmitted']; }else{ $percentEndPenMon = 0; } $barEndPenMon = number_format( $percentEndPenMon * 100, 2 );   ?>
								<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barEndPenMon; ?>%;"></div>
							</div>									
						</div>
						<div class="mb-1 u-card"> 
							<div>Returns Referred Back <span class="font-weight-bold">(<span class="count-text"><?php echo $_SESSION['endUserReferred']; ?></span>)</span></div>
							<div class="progress-bar-sm progress-bar-animated-alt progress u-progress">
								<?php if($_SESSION['endUserSubmitted'] > 0){ $percentEndRefMon = $_SESSION['endUserReferred']/$_SESSION['endUserSubmitted']; }else{ $percentEndRefMon = 0; } $barEndRefMon = number_format( $percentEndRefMon * 100, 2 );   ?>
								<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barEndRefMon; ?>%;"></div>
							</div>									
						</div>
						<div class="mb-1 u-card">  
							<div>Returns Accepted <span class="font-weight-bold">(<span class="count-text"><?php echo $_SESSION['endUserApproved']; ?></span>)</span></div>
							<div class="progress-bar-sm progress-bar-animated-alt progress u-progress">
								<?php if($_SESSION['endUserSubmitted'] > 0){ $percentEndAppMon = $_SESSION['endUserApproved']/$_SESSION['endUserSubmitted']; }else{ $percentEndAppMon = 0; } $barEndAppMon = number_format( $percentEndAppMon * 100, 2 );   ?>
								<div class="progress-bar bg-success" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barEndAppMon; ?>%;"></div>
							</div>									
						</div>
					</li>
				</ul>
			</div>
		</div>
		<?php } ?>


		<?php if(!in_array($userRole,array('2','3'))){ ?>
		<?php //if(in_array($userRole,array('8','9'))){ ?>
		<div class="col-md-6" id="enduserAnnualtatics">
			<div class="main-card mb-3 card">
				<ul class="list-group list-group-flush u_stat_four p-2">
					<li class="list-group-item p-0 m-0">
						<div class="widget-content u_midnight_bloom_one">
							<div class="widget-content-wrapper text-white">
								<div class="widget-content-left">
									<div class="widget-heading">Total Returns</div>
									<div class="widget-subheading">Annual Statistics</div>
								</div>
								<div class="widget-content-right">
									<div class="widget-numbers text-white text-center"><span>M</span></div>
									<div class="widget-numbers text-white text-center"><span class="count-text"><?php echo $_SESSION['endUserSubmittedAnnual']; ?></span></div>
								</div>
							</div>
						</div>
					</li>
					<li class="list-group-item u_midnight_bloom_two mb-1">
						<div class="mb-1 u-card">        
							<div>Returns Pending <span class="font-weight-bold ">(<span class="count-text"><?php echo $_SESSION['endUserPendingAnnual']; ?></span>)</span></div>
							<div class="progress-bar-sm progress-bar-animated-alt progress u-progress">
								<?php if($_SESSION['endUserSubmittedAnnual'] > 0){ $percentEndPenAnnu = $_SESSION['endUserPendingAnnual']/$_SESSION['endUserSubmittedAnnual']; }else{ $percentEndPenAnnu = 0; } $barEndPenAnnu = number_format( $percentEndPenAnnu * 100, 2 );   ?>
								<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barEndPenAnnu; ?>%;"></div>
							</div>									
						</div>
						<div class="mb-1 u-card"> 
							<div>Returns Referred Back <span class="font-weight-bold">(<span class="count-text"><?php echo $_SESSION['endUserReferredAnnual']; ?></span>)</span></div>
							<div class="progress-bar-sm progress-bar-animated-alt progress u-progress">
								<?php if($_SESSION['endUserSubmittedAnnual'] > 0){ $percentEndRefAnnu = $_SESSION['endUserReferredAnnual']/$_SESSION['endUserSubmittedAnnual']; }else{ $percentEndRefAnnu = 0; } $barEndRefAnnu = number_format( $percentEndRefAnnu * 100, 2 );   ?>
								<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barEndRefAnnu; ?>%;"></div>
							</div>									
						</div>
						<div class="mb-1 u-card">  
							<div>Returns Accepted <span class="font-weight-bold">(<span class="count-text"><?php echo $_SESSION['endUserApprovedAnnual']; ?></span>)</span></div>
							<div class="progress-bar-sm progress-bar-animated-alt progress u-progress">
								<?php if($_SESSION['endUserSubmittedAnnual'] > 0){ $percentEndAppAnnu = $_SESSION['endUserApprovedAnnual']/$_SESSION['endUserSubmittedAnnual']; }else{ $percentEndAppAnnu = 0; } $barEndAppAnnu = number_format( $percentEndAppAnnu * 100, 2 );   ?>
								<div class="progress-bar bg-success" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barEndAppAnnu; ?>%;"></div>
							</div>									
						</div>
					</li>
				</ul>
			</div>
		</div>
		<?php } ?>
		
		<?php if (isset($userRole) && in_array($userRole, array('2', '8'))) { ?>
			<div class="col-md-12 mt_23_m CommentboxDive">
				<div class="mb-3 card h_82_p">
					<div class="card-header-tab card-header-tab-animation card-header u_comment_header">
						<div class="card-header-title">
							<i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
							Comment Inbox
						</div>
						<!--
						<ul class="nav">
							<li class="nav-item"><a data-toggle="tab" href="#tab-eg8-0" class="nav-link show active">Form (F)</a></li>
							<li class="nav-item"><a data-toggle="tab" href="#tab-eg8-1" class="nav-link show">Form (M)</a></li>
						</ul>
						-->
					</div>
					<div class="card-body u_comment_body pb-5">
						<div class="tab-content">
							<div class="tab-pane show active" id="tab-eg8-0" role="tabpanel">
								
								<div class="tab-content">
									<div class="tab-pane fade show active" id="tabs-eg-77">
										<div class="scroll-area-sm">
											<div class="scrollbar-container">
												<ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush comment-inner">
												
													<?php if (isset($mmsRemark) && count($mmsRemark) > 0) { ?>
														<?php foreach ($mmsRemark as $rmk) { ?>
															<li class="list-group-item remark_grp_item">
																<div class="widget-content p-0">
																	<div class="">
																		<div class="widget-content-left">
																			<div class="widget-heading">
																				<span><?php echo $rmk['app_id']; ?></span>
																				<span class="float-right">
																					[<?php echo $rmk['return']; ?>]
																					<span class="badge badge-<?php echo ($rmk['form'] == 'L') ? 'primary' : 'info'; ?>"><?php echo $rmk['form']; ?></span>
																				</span>
																			</div>
																			<div class="widget-subheading">"<?php echo $rmk['remark']; ?>"</div>
																			<span class="badge badge-secondary float-right"><?php echo $rmk['date']; ?></span>
																		</div>
																	</div>
																</div>
															</li>
														<?php } ?>
													<?php } else { ?>
														<li class="list-group-item remark_grp_item">
															<div class="widget-content p-0">
																<div class="widget-content-wrapper">
																	<div class="widget-content-left">
																		<div class="widget-heading text-center pt-3"><h1><i class="fa fa-comments"></i></h1></div>
																		<div class="widget-subheading text-center pb-4 pt-3">Currently no replies from Applicants</div>
																	</div>
																</div>
															</div>
														</li>
													<?php } ?>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>


	</div>
</div>

<!--<div class="main-card mb-3 card">
    <div class="row">
        <div class="col-md-4">
            <div class="widget-content">
                <div class="widget-content-outer">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading">Total Daily Returns Filed</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers text-success">2854</div>
                        </div>
                    </div>
                    <div class="widget-progress-wrapper">
                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="52" aria-valuemin="0" aria-valuemax="100" style="width: 52%;"></div>
                        </div>
                        <div class="progress-sub-label">
                            <div class="sub-label-left">Total Daily Returns required to filed</div>
                            <div class="sub-label-right">4526</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget-content">
                <div class="widget-content-outer">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading">No of Unique Users</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers text-warning">1284</div>
                        </div>
                    </div>
                    <div class="widget-progress-wrapper">
                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                            <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="width: 77%;"></div>
                        </div>
                        <div class="progress-sub-label">
                            <div class="sub-label-left">Total Users</div>
                            <div class="sub-label-right">1458</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget-content">
                <div class="widget-content-outer">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading">User Filed Returns</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers text-danger">46%</div>
                        </div>
                    </div>
                    <div class="widget-progress-wrapper">
                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="46" aria-valuemin="0" aria-valuemax="100" style="width: 46%;"></div>
                        </div>
                        <div class="progress-sub-label">
                            <div class="sub-label-left">Total Users</div>
                            <div class="sub-label-right">1458</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->

<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'user_role_status', 'value'=>$userRole]); ?>
<?php echo $this->Html->script('mms/home.js?version='.$version); ?>
