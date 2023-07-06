<?php 
	// $_SESSION['randSalt'] = Rand();			
	// $salt_server = $_SESSION['randSalt'];			
	echo $this->element('get_captcha_random_code');
	$captchacode = $_SESSION["code"];
?>

<div class='login-page'>
<div class="col-md-6  col-md-offset-3 login-page-window1">
	<div class="col-md-12 col-sm-12 col-sm-offset-0 col-lg-8 col-md-offset-2 login-page-window2">	
	
		<?php echo $this->Form->create(null, array('type'=>'file', 'enctype'=>'multipart/form-data', 'id'=>'frmforgotPassword', 'name'=>'frmforgotPassword')); ?>		
		
		  <div class="container1 login-page-background">
		  
			<div class="login-heading-title"><h1 class='hr'>FORGOT PASSWORD</h1></div>
			<div class="container1 text-center" style="font-size: 14px;color: red;">Please contact concerned Regional office for any query or request to know the status of your applications <br><a href="<?php echo $this->getRequest()->getAttribute('webroot'); ?>regional-office-details" >Click here for Regional Office Contact Details </a>
			</div>
			<div class="form-group ">
			
				<?php if($userType=="mms"){ ?>
					<label class="control-label " for="uname"><b>Email</b></label>
				<?php }else{ ?>
					<label class="control-label " for="uname"><b>Username</b></label>
				<?php } ?>
				
				<div class="input-group">
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-user"></span> 
					</div>
					<?php echo $this->Form->control('username', array('class'=>'form-control login-input-fields', 'autocomplete'=>'off', 'placeholder'=>'', 'id'=>'forgotpass_username','label'=>false,'templates'=>array('inputContainer'=>'{{content}}'))); ?>								
				</div>
				<div id="error_username" class="login_error"></div>
			</div>
			<div class="form-group ">
			
				<?php if($userType=="mms"){ ?>
					<label class="control-label " for="uname"><b>Confirm Email</b></label>
				<?php }else{ ?>
					<label class="control-label " for="uname"><b>Email</b></label>
				<?php } ?>
				
				<div class="input-group">
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-envelope"></span> 
					</div>
					<?php echo $this->Form->control('email', array('type'=>'email', 'class'=>'form-control login-input-fields forgot_email_field', 'autocomplete'=>'off', 'placeholder'=>'', 'id'=>'forgotpass_email', 'label'=>false, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
				</div>
				<div id="error_email" class="login_error"></div>		
			</div>
			<div class="cpt">
				<div class="col-6 col-md-4 col-sm-4 col-lg-4 col-xl-4 cpt-img d-inline-block">
					<span id="captcha_img">
						<?php echo $this->Html->image(array('controller'=>'users','action'=>'create_captcha'),array('class'=>'captcha','alt'=>'captcha','id'=>'login_captcha_img')); ?>
					</span>					
				</div>
				<div class="col-4 col-md-2 col-sm-2 col-lg-2 col-xl-2 cpt-img rfs-img d-inline-block">
					<a class="" href="javascript:void(0);" id="new_captcha" title="Get new Image rfg">
						<img src="<?php echo $this->request->getAttribute('webroot');?>img/home/refresh_button.jpg">
					</a>
				</div>
				<div class="col-md-6 col-sm-6 col-lg-6 col-xl-6 cpt-img">
					<?php echo $this->Form->control('captcha', array('type'=>'text', 'class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Please enter captcha', 'id'=>'forgotpass_captcha', 'label'=>false, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>

				</div>
				<div id="error_captchacode" class="errormsg login_error"><?php if(isset($captcha_error_msg)){ echo $captcha_error_msg; } ?></div>
			</div>
			
		    <?php echo $this->Form->control('loginrequestid', array('label'=>'', 'id'=>'loginrequestid', 'type'=>'hidden', 'value'=>$loginRequestId)); ?>
		    <?php echo $this->Form->control('userType', array('label'=>'', 'id'=>'userType', 'type'=>'hidden', 'value'=>$userType)); ?>
			
			<!-- <button type="submit" name='submit' id='Login' value='Login' class='login-button' onclick='myFunction();return false'>Login</button> -->
			<?php echo $this->Form->button('Submit', array('type'=>'submit', 'name'=>'submit', 'id'=>'submit', 'class'=>'login-button')) ?>
			<span class="psw"><?php //echo link_to('Forgot password ?', 'auth/forgotPassword', array('class' => 'login_watag')); ?></span>
			
		  </div>
		<?php  echo $this->Form->end(); ?>
	</div>
</div>
<div class='clearfix'></div>
</div>

<button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal" data-target="#multipleBrowserModal" id="browser-modal-btn" hidden>modal</button>

<div class="modal fade" id="multipleBrowserModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-0 login-modal-content login-modal-success">
            <div class="modal-header m-0 d-inline-block text-center login-modal-header">
                <span class="browser-modal-txt"><i class="fa fa-info-circle login-info-icon"></i> Multiple Login Alert!</span>
            </div>
            <div class="modal-body login-modal-body">
                <p class="mb-0 modal-body-text">You are currently logged in different window. If you login here then you will be logout from previous window.</p>
            </div>
            <div class="modal-footer m-0 login-modal-footer">
                <button type="button" class="btn btn-light login-modal-btn" data-toggle="modal" data-target="#multipleBrowserModal">Cancel</button>
                <button type="button" class="btn btn-primary login-modal-btn" onclick="submitLoginForm()">Continue</button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->Html->script('users/reset_password.js?version='.$version); ?>