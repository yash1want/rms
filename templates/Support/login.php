<?php 
	//$_SESSION['support_tkn'] = Rand();			
	$_SESSION['support_tkn'] = "9876543210";			
	$support_tkn = $_SESSION['support_tkn'];
	echo $this->element('get_captcha_random_code');	
	$captchacode = $_SESSION["code"];
?>

<div class='login-page'>
<div class="col-md-6  col-md-offset-3 login-page-window1">
	<div class="col-md-12 col-sm-12 col-sm-offset-0 col-lg-8 col-md-offset-2 login-page-window2">	
	
		<?php echo $this->Form->create(null, array('type'=>'file', 'enctype'=>'multipart/form-data', 'id'=>'login_form')); ?>		
		
		  <div class="container1 login-page-background">
		  
			<div class="login-heading-title"><h1 class='hr'><?php echo $logititle; ?></h1></div>
			<div class="form-group ">
				<label class="control-label " for="uname"><b>Username</b></label>
				<div class="input-group">
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-user"></span> 
					</div>
					<?php echo $this->Form->control('username', array('class'=>'form-control login-input-fields', 'autocomplete'=>'off', 'placeholder'=>'Enter User Name Like 000/00XYZ0000', 'id'=>'username','label'=>false,'templates'=>array('inputContainer'=>'{{content}}'))); ?>								
				</div>
				<div id="error_username" class="login_error"></div>
			</div>
			<div class="form-group ">
				<label class="control-label " for="psw"><b>Password</b></label>
				<div class="input-group">
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-lock"></span> 
					</div>
					<?php echo $this->Form->control('password', array('class'=>'form-control login-input-fields', 'autocomplete'=>'off', 'placeholder'=>'**************', 'id'=>'password', 'label'=>false, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
				</div>
				<div id="error_password" class="login_error"></div>		
			</div>
			<div class="cpt">
				<div class="col-6 col-md-4 col-sm-4 col-lg-4 col-xl-4 cpt-img d-inline-block">
					<span id="captcha_img">
						<?php echo $this->Html->image(array('controller'=>'users','action'=>'create_captcha'),array('class'=>'captcha','alt'=>'captcha','id'=>'login_captcha_img')); ?>
					</span>					
				</div>
				<div class="col-4 col-md-2 col-sm-2 col-lg-2 col-xl-2 cpt-img rfs-img d-inline-block">
					<a class="" href="javascript:void(0);" id="new_captcha" title="Get new Image">
						<img src="<?php echo $this->request->getAttribute('webroot');?>img/home/refresh_button.jpg">
					</a>
				</div>
				<div class="col-md-6 col-sm-6 col-lg-6 col-xl-6 cpt-img">
					<?php echo $this->Form->control('captcha', array('type'=>'text', 'class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Please enter captcha', 'id'=>'captcha', 'label'=>false, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>

				</div>
				<div id="error_captchacode" class="errormsg login_error"><?php if(isset($captcha_error_msg)){ echo $captcha_error_msg; } ?></div>
			</div>
			
		    <?php echo $this->Form->control('support_tkn', array('label'=>'', 'id'=>'salt_value', 'type'=>'hidden', 'value'=>$support_tkn)); ?>
		    
		    <?php echo $this->Form->control('current_ctrl', array('label'=>'', 'id'=>'current_ctrl', 'type'=>'hidden', 'value'=>$current_ctrl)); ?>
		    <?php echo $this->Form->control('multilogin', array('label'=>'', 'id'=>'multilogin', 'type'=>'hidden')); ?>
			
			
			<?php echo $this->Form->button('Login', array('type'=>'button', 'name'=>'login_submit', 'id'=>'Login', 'value'=>'Login', 'class'=>'login-button')) ?>
			
			<div class='clearfix'></div>
			<div class="container1 login_page_note"><?php if(isset($userlogintxt['note'])) { echo $userlogintxt['note']; } ?></div>
			
		  </div>
		<?php  echo $this->Form->end(); ?>
	</div>
</div>
<div class='clearfix'></div>
</div>
