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
               

                <!--<li class="nav-item">
                    <div class="btn-group dropdown nav-link">
                        <button type="button" aria-haspopup="true" aria-expanded="true" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-dark"><i class="nav-link-icon fa fa-language"> </i> 
                            <?php 
                                $lang = $this->getRequest()->getSession()->read('lang');
                                if($lang == 'english'){
                                    $cur_lang = "ENG";
                                    $other_lang = "HINDI";
                                } else {
                                    $cur_lang = "HIN";
                                    $other_lang = "ENGLISH";
                                }
                                echo $cur_lang;
                            ?>
                        </button>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-left language-dropdown" x-placement="top-end">
                            <?php //echo $this->Html->link($other_lang, array('controller'=>'monthly','action'=>'changeLanguage'), array('class'=>'dropdown-item','id'=>'language-dd')); ?>
                            <span class="dropdown-item" id="language-dd"><?php echo $other_lang; ?></span>
                    </div>
                </li>-->
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
                                                $image_url = $_SESSION['user_image'];
                                            }else{                                                
                                                $image_url = '/writereaddata/IBM/files/defualt_profile.jpg';
                                            }
                                        }else{
                                            $image_url = '/writereaddata/IBM/files/defualt_profile.jpg';
                                        }
                                    ?>
                                    <img width="42" height="42" class="rounded-circle" src="<?php echo $image_url; ?>" alt="">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                    <a href="<?php echo $this->request->getAttribute('webroot')?>auth/profile" class="dropdown-item">
                                        <i class="fa fa-user mr-2"></i>User Account
                                    </a>
                                    <?php if($_SESSION['loginusertype'] != 'primaryuser'){ ?>
                                        <div tabindex="-1" class="dropdown-divider"></div>
                                        <a href="<?php echo $this->request->getAttribute('webroot')?>users/change-password" class="dropdown-item">
                                            <i class="fa fa-lock mr-2"></i>Change Password
                                        </a>
                                    <?php } ?>
                                    <!-- added user trailing logs link on 18-07-2022 by Aniket -->
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <?php echo $this->Html->link('<i class="fa fa-clock mr-2"></i>User Logs','/auth/logs',array('class'=>'dropdown-item','escapeTitle'=>false)); ?>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <?php 
                                    $loginusertype = $this->getRequest()->getSession()->read("loginusertype");
                                    echo $this->Html->link('<i class="fa fa-power-off mr-2"></i>Logout', '/users/logout/'.$loginusertype, array('class'=>'dropdown-item', 'escapeTitle'=>false)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                               <?php echo $_SESSION['user_first_name'].' '. $_SESSION['user_last_name']; ?>
                            </div>
                            <div class="widget-subheading">
                                <?php 
                                switch($loginusertype) {
                                    case 'primaryuser':
                                        $headerUserType = 'Primary';
                                        break;
                                    case 'authuser':
                                        $headerUserType = 'Miner';
                                        break;
                                    case 'enduser':
                                        $headerUserType = 'Enduser';
                                        break;
                                    default:
                                        $headerUserType = 'User';
                                }
                                echo $headerUserType;
                                ?>
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