<?php 

$cname ='support-mod';
$loginusertype = $this->getRequest()->getSession()->read('loginusertype');
$curAction = $this->getRequest()->getParam('action');
$sesssion_ticket_type= $this->getRequest()->getSession()->read('ticket_type');;
//print_r($sesssion_ticket_type);exit;
//$curController = $this->getRequest()->getParam('controller');

?>
<div class="scrollbar-sidebar ovrfl_x_a">
	<div class="app-sidebar__inner">
		<ul class="vertical-nav-menu">

			<li class="app-sidebar__heading">
				<?php echo $this->Html->link('<i class="metismenu-icon pe-7s-home"></i>DASHBOARD', '/support-mod/home', array('class' => 'u-li-menu spinner_btn_nxt', 'escape' => false)); ?>
			</li>

			<?php if($loginusertype == 'supportuser') { ?>
				<!-- <li class="app-sidebar__heading">
						<a href="#" class="u-li-menu" aria-expanded="false">
							<i class="metismenu-icon pe-7s-display1"></i>
							Tickets 
							<i class="metismenu-state-icon font_15 fa fa-chevron-down caret-left"></i>
						</a>
						<ul class="mm-collapse">
								<li>
									<//?php echo $this->Html->link('<i class="metismenu-icon pe-7s-diamond"></i>Pending Tickets', '/support/pending-list', array('escape' => false)); ?>
								</li>
								<li>
									<a href="<//?php echo $this->request->getAttribute('webroot'); ?>support/inprocess-list">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Inprocess Tickets 
									</a>
								</li>
								<li>
									<a href="<//?php echo $this->request->getAttribute('webroot'); ?>support/resolved-list">
										<i class="metismenu-icon pe-7s-diamond"></i>
										Resolved Tickets 
									</a>
								</li>
							
						</ul>
					</li>
				-->
				<li class="app-sidebar__heading">
					<a href="#" class="u-li-menu">
						<i class="metismenu-icon pe-7s-ticket"></i>
						Tickets
						<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
					</a>
					<ul class="mm-collapse">
						<!--Added By Yashwant Pending Ticket START 14-06-2023-->
						<?php if ($curAction=='ticketList' && $sesssion_ticket_type=='pending') {
							$activeStat = 'u-li-menu';
							$activeopen = 'mm-active';
						} else {
							$activeStat = '';
							$activeopen = '';
						} ?>
						<li class="<?php echo $activeopen;?>"><!-- <//?php echo 'mm-active';?> -->

							<a href="<?php echo  $this->request->getAttribute('webroot'); echo $cname;?>/support_app/pending" class="<?php echo $activeStat;?>">
								<i class="fa fa-bell" aria-hidden="true"></i>
								Pending Tickets
							</a>
						</li>
						<!--Added By Yashwant Pending Ticket END 14-06-2023-->

						<!--Added By Yashwant Inprocess Ticket START 14-06-2023-->
						<?php if ($curAction=='ticketList' && $sesssion_ticket_type=='inprocess') {
							$activeStat = 'u-li-menu';
							$activeopen = 'mm-active';
						} else {
							$activeStat = '';
							$activeopen = '';
						} ?>
						<li class="<?php echo $activeopen;?>">

							<a href="<?php echo  $this->request->getAttribute('webroot'); echo $cname;?>/support_app/inprocess" class="<?php echo $activeStat;?>">
								<i class="fa fa-tasks" aria-hidden="true"></i><!-- fa-spinner -->
								Inprocess Tickets
							</a>
						</li>
						<!--Added By Yashwant Inprocess Ticket END 14-06-2023-->

						<!--Added By Yashwant Resolved Ticket START 14-06-2023-->
						<?php if ($curAction=='ticketList' && $sesssion_ticket_type=='resolve') {
							$activeStat = 'u-li-menu';
							$activeopen = 'mm-active';
						} else {
							$activeStat = '';
							$activeopen = '';
						} ?>
						<li class="<?php echo $activeopen;?>">
							<a href="<?php echo  $this->request->getAttribute('webroot'); echo $cname;?>/support_app/resolve" class="<?php echo $activeStat;?>">
								<i class="fa fa-envelope" aria-hidden="true"></i>
								Resolved Tickets
							</a>
						</li>
						<!--Added By Yashwant Resolved Ticket END 14-06-2023-->
					</ul>
				</li>

			<?php } ?>



			


			<!-- Yashwant 24-04-2023 ============================================================================================================-->
			<!-- <//?php if ($_SESSION['loginusertype'] == 'supportuser') { ?>
				<li class="app-sidebar__heading">
					<a href="<//?php echo $this->request->getAttribute('webroot'); ?>auth/level-3-users" class="u-li-menu" aria-expanded="false">
						<i class="metismenu-icon pe-7s-users"></i>
						All Users
					</a>
				</li>
				<//?php } ?> -->
				<!--<li class="app-sidebar__heading">
					<a href="#" class="u-li-menu" aria-expanded="false">
					<i class="metismenu-icon pe-7s-like2"></i>
						FEEDBACK
                    </a>   
                </li>-->

            </ul>
        </div>
    </div>

    <!-- <//?php $this->getRequest()->getSession()->write('sec_link', $sec_link); ?> -->