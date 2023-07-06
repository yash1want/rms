<?php $maxlifetime = ini_get("session.gc_maxlifetime") * 1000; ?>
<input type="hidden" value="<?php echo $maxlifetime; ?>" id="session_timeout_value">

<header class="header_one">
    <div class="container-fluid">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row header_new">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 header_new_lt"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 header_new_md">
                <div class="w_f_c m-auto font_sans">
                    <div class="header_md_title_sub">MINING TENEMENT SYSTEM</div>
                    <div class="header_md_title_main">Returns Management System</div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 header_new_rt"></div>
        </div>
    </div>
</header>

<div class="app-header header-shadow bg-dark header-text-light">
    <div class="app-header__logo">
        <div class="logo-src"><span class="u-logo-text">IBM</span></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>    
    <div class="app-header__content">
        <div class="app-header-left">
            <ul class="header-menu nav">

                <?php 
                $loginusertype = $this->getRequest()->getSession()->read("loginusertype");
                if (!in_array($loginusertype, array('authuser', 'enduser'))) {
                    ?>
                    <li class="nav-item">
                        <div class="btn-group dropdown nav-link">
                            <button type="button"  class="mb-2 mr-2 btn btn-dark"><i class="nav-link-icon fa fa-database"> </i> <a href="<?php echo $this->request->getAttribute('webroot'); ?>reports/report-list"> Reports </a></button>
                            <!-- <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start">
                                <ul class="nav flex-column">
                                    <li class="nav-item u_nav_item">
                                        <a href="javascript:void(0);" class="nav-link">
                                        Region wise Status of Online Receipt of Returns
                                        </a>
                                    </li>
                                    <li class="nav-item u_nav_item">
                                        <a href="javascript:void(0);" class="nav-link">
                                        Mine Returns for Current Financial Year
                                        </a>
                                    </li>
                                    <li class="nav-item u_nav_item">
                                        <a href="javascript:void(0);" class="nav-link">
                                        Regionwise Registered in Form M but not filed returns
                                        </a>
                                    </li>
                                    <li class="nav-item u_nav_item">
                                        <a href="javascript:void(0);" class="nav-link">
                                        Monthly Report
                                        </a>
                                    </li>
                                    <li class="nav-item u_nav_item">
                                        <a href="javascript:void(0);" class="nav-link">
                                        Annual Report
                                        </a>
                                    </li>
                                    <li class="nav-item u_nav_item">
                                        <a href="javascript:void(0);" class="nav-link">
                                        N and O Report
                                        </a>
                                    </li>
                                    <li class="nav-item u_nav_item">
                                        <a href="javascript:void(0);" class="nav-link">
                                        MMTC Report
                                        </a>
                                    </li>
                                </ul>
                            </div> -->
                        </div>
                    </li>
				<?php } 

                if (!in_array($loginusertype, array('authuser', 'enduser'))) {
                    ?>
                    <li class="nav-item">
                        <div class="btn-group dropdown nav-link">
                            <button type="button"  class="mb-2 mr-2 btn btn-dark"><i class="nav-link-icon fa fa-database"> </i> <a href="<?php echo $this->request->getAttribute('webroot'); ?>report-l-m"> Reports For L & M </a></button>
                        </div>
                    </li>
                <?php } ?>
				
				<?php if (base64_decode($_SESSION['mms_user_email']) == 'sa.mts-ibm@nic.in') {
                    ?>
                    <li class="nav-item">
                        <div class="btn-group dropdown nav-link">
                            <button type="button"  class="mb-2 mr-2 btn btn-dark"><i class="nav-link-icon fa fa-database"> </i> <a href="<?php echo $this->request->getAttribute('webroot'); ?>reports/user_login_status"> User Login Status </a></button>
                        </div>
                    </li>
                <?php } 

                // if (!in_array($loginusertype, array('authuser', 'enduser'))) {
                if (isset($_SESSION['mms_user_role']) && $_SESSION['mms_user_role'] == 1){
                    ?>
                    <li class="nav-item">
                        <div class="btn-group dropdown nav-link">
                            <button type="button"  class="mb-2 mr-2 btn btn-dark"><i class="nav-link-icon fa fa-database"> </i> <a href="<?php echo $this->request->getAttribute('webroot'); ?>activity-type/activity"> Activity Type </a></button>
                        </div>
                    </li>
                <?php } ?>
				
                <!-- <li class="nav-item">
                    <div class="btn-group dropdown nav-link">
                        <button type="button" aria-haspopup="true" aria-expanded="true" class="mb-2 mr-2 btn u_login_info">Last Login: Fri, Nov 19, 2021, 17:08:54 IST</button>
                    </div>
                </li> -->
                <!--  <li class="btn-group nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-link-icon fa fa-edit"></i>
                        Projects
                    </a>
                </li> -->
            </ul>        
        </div>
        <div class="app-header-right">
            <!-- added session timer on 30-08-2022 -->
            <?php echo $this->Form->create(null, array('type' => 'file', 'enctype' => 'multipart/form-data', 'class' => '')); ?>
            <div id="session_timer">
                <div id="session_timer_text">Session time:</div>
                <div id="session_timer_counter"><?php echo $maxlifetime/60000; ?> : 00</div>
                <!-- Below hidden fields for session expired logout purpose, added on 11-10-2022 by Aniket --> 
                <?php echo $this->Form->control('session_timer_id', array('type'=>'hidden', 'id'=>'session_timer_id', 'value'=>$_SESSION['login_session'])); ?>
                <?php echo $this->Form->control('session_timer_logout_url', array('type'=>'hidden', 'id'=>'session_timer_logout_url', 'value'=>$this->Url->build(['controller'=>'app', 'action'=>'sessionExpiredLogout']))); ?>
                <?php echo $this->Form->control('session_usertype', array('type'=>'hidden', 'id'=>'session_usertype', 'value'=>$_SESSION['loginusertype'])); ?>
                <?php echo $this->Form->control('session_username', array('type'=>'hidden', 'id'=>'session_username', 'value'=>$_SESSION['username'])); ?>
                <?php echo $this->Form->control('session_timer_status', array('type'=>'hidden', 'id'=>'session_timer_status', 'value'=>0)); ?>
                <?php echo $this->Form->control('session_support_team_login', array('type'=>'hidden', 'id'=>'session_support_team_login', 'value'=>$_SESSION['support_team_login'])); ?>
            </div>
            <?php echo $this->Form->end(); ?>
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <?php 
                                        if(array_key_exists('user_image',$_SESSION)){
                                            if (strpos($_SESSION['user_image'], 'writereaddata') !== false) {
                                                $image_url = str_replace('/UAT5/','',$_SESSION['user_image']);
                                            }else{                                                
                                                $image_url = '/writereaddata/IBM/files/defualt_profile.jpg';
                                            }
                                        }else{
                                            $image_url = '/writereaddata/IBM/files/defualt_profile.jpg';
                                        }
										
                                    ?>
									
                                    <img width="42" height="42" class="rounded-circle" src="<?php echo $image_url; ?>" alt="profile_img">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                    <a href="<?php echo $this->request->getAttribute('webroot'); ?>admin/user-profile" class="dropdown-item">
                                    <i class="fa fa-user mr-2"></i>User Account
                                    </a>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <a href="<?php echo $this->request->getAttribute('webroot'); ?>users/change-password" class="dropdown-item">
                                    <i class="fa fa-lock mr-2"></i>Change Password
                                    </a>
                                    <!--<div tabindex="-1" class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item">
                                    <i class="fa fa-cog mr-2"></i>Settings
                                    </a>-->
                                    <!-- added user trailing logs link on 13-07-2022 by Aniket -->
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <?php echo $this->Html->link('<i class="fa fa-clock mr-2"></i>My Logs','/mms/logs',array('class'=>'dropdown-item','escapeTitle'=>false)); ?>
                                    <div tabindex="-1" class="dropdown-divider"></div>
									<?php $user_role = $this->getRequest()->getSession()->read("mms_user_role"); ?>
                                    <?php if($user_role == 1){ ?>
                                        <?php echo $this->Html->link('<i class="fa fa-clock mr-2"></i>Mms Logs','/mms/mms-logs',array('class'=>'dropdown-item','escapeTitle'=>false)); ?>
                                        <div tabindex="-1" class="dropdown-divider"></div>
                                        <?php echo $this->Html->link('<i class="fa fa-clock mr-2"></i>User Logs','/mms/user-logs',array('class'=>'dropdown-item','escapeTitle'=>false)); ?>
                                    <?php } ?>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <?php 
                                    $mmsUserRole = $this->getRequest()->getSession()->read("mms_user_role");
                                    echo $this->Html->link('<i class="fa fa-power-off mr-2"></i>Logout', '/users/logout/'.$loginusertype, array('class'=>'dropdown-item', 'escapeTitle'=>false)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                <?php echo $_SESSION['mms_user_first_name'].' '.$_SESSION['mms_user_last_name']; ?>
                            </div>
                            <div class="widget-subheading">
                                <?php echo $mms_user_role_array[$mmsUserRole]; ?>
                            </div>
                        </div>
                        <div class="widget-content-right header-user-info ml-3">
                            <?php echo $this->Html->link('<i class="fa text-white fa-power-off pr-1 pl-1"></i>', '/users/logout/'.$loginusertype, array('class'=>'btn-shadow p-1 btn btn-dark btn-sm', 'escapeTitle'=>false)); ?>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</div>        
<div class="ui-theme-settings">
</div>

<?php echo $this->Html->css('session_timeout_counter.css?version='.$version); ?>
<?php echo $this->Html->script('session_timeout_counter.js?version='.$version); ?>