<div class="col-md-4 col-lg-4">				
		<div class="mb-3 card">
			<div class="card-header-tab card-header-tab-animation card-header">
				<div class="card-header-title comment-inbox">
                    <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                    Comment Inbox
                </div>
			</div>
			<div class="card-body">
				<div class="tab-content">
					<div class="tab-pane show active" id="tab-eg8-0" role="tabpanel">
						
						<div class="tab-content">
							<div class="tab-pane fade show active" id="tabs-eg-77">
								<div class="scroll-area-sm">
									<div class="scrollbar-container ps ps--active-y">
										<!--
										<div class="text-center no-comment">
											<div>
												<i class="fa fa-comments fa-2x"></i>
											</div>
											<div>No outstanding queries</div>
										</div>
										-->
										<ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush comment-inner">
											<?php if (isset($mmsRemark) && count($mmsRemark) > 0) { ?>
												<?php foreach ($mmsRemark as $rmk) { ?>
													<li class="list-group-item remark_grp_item">
														<div class="widget-content p-0">
															<div class="">
																<div class="widget-content-left">
																	<div class="widget-heading">
																		<span>[<?php echo $rmk['return']; ?>]</span>
																		<span class="float-right">
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
												<li class="list-group-item">
													<div class="widget-content p-0">
														<div class="widget-content-wrapper">
															<div class="widget-content-left">
																<div class="widget-heading text-center pt-3"><h1><i class="fa fa-comments"></i></h1></div>
																<div class="widget-subheading text-center pb-4 pt-3">Currently no comments from IBM Scrutinizer</div>
															</div>
														</div>
													</div>
												</li>
											<?php } ?>
										</ul>
									<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 200px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 139px;"></div></div></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
    </div>