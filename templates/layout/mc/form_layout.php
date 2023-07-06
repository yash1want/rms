<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="en">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>IBM Returns Management Portal</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
	<meta name="msapplication-tap-highlight" content="no">

	<?php
	echo $this->Html->css('main.css?version=' . $version);
	echo $this->Html->css('panel.css?version=' . $version);

	//jquery ui (for autocomplete)
	echo $this->Html->css('jquery-ui/jquery-ui.css?version=' . $version);
	
	echo $this->Html->css('jquery.multiselect'); //Added by Shweta Apale 25-01-2022 For multiselect checkbox

	echo $this->Html->script('jquery.min.js?version=' . $version);
	echo $this->Html->script('jquery.validate.min.js?version=' . $version);

	echo $this->Html->script('jquery-ui.min.js?version=' . $version);
	echo $this->Html->script('jquery.ui.autocomplete.js?version=' . $version);

	echo $this->Html->script('custom-validate.js?version=' . $version); // custom form input validations

	$loginUserType = $this->getRequest()->getSession()->read('loginusertype');
	if ($loginUserType == 'authuser') {
		echo $this->Html->script('f/f.series.form.pi.js?version=' . $version); // custom F-series form validations phase I
		echo $this->Html->script('g/g.series.form.pi.js?version=' . $version); // custom G-series form validations phase I
		echo $this->Html->script('f/f.series.form.js?version=' . $version); // custom F-series form validations
	} else {
		echo $this->Html->script('l/l.series.form.pi.js?version=' . $version); // custom N-series form validations phase I
		echo $this->Html->script('m/m.series.form.pi.js?version=' . $version); // custom O-series form validations phase I
		echo $this->Html->script('l/l.series.form.js?version=' . $version); // custom L-series form validations
	}

	echo $this->Html->script('jquery.dataTables.min.js?version=' . $version);
	echo $this->Html->script('panel.js?version=' . $version); // admin panel custom javascript

	echo $this->Html->script('swfobject.js?version=' . $version);
	echo $this->Html->script('slidedown-menu2.js?version=' . $version);
	echo $this->Html->script('AC_RunActiveContent.js?version=' . $version);
	echo $this->Html->script('jquery.blockUI.js?version=' . $version);
	echo $this->Html->script('json_parse.js?version=' . $version);
	echo $this->Html->script('jquery.multiselect'); //Added by Shweta Apale 25-01-2022 For multiselect checkbox
	// echo $this->Html->script('jquery-ui.min.js?version='.$version);
	// echo $this->Html->script('jquery.ui.core.js?version='.$version);
	// echo $this->Html->script('jquery.ui.widget.js?version='.$version);
	// echo $this->Html->script('jquery.ui.position.js?version='.$version);
	// echo $this->Html->script('jquery.ui.datepicker.js?version='.$version);
	// echo $this->Html->script('h-form.js?version='.$version);
	// echo $this->Html->script('jquery-uii.min.js?version='.$version);
	echo $this->Html->script('bootstrap.minn.js?version=' . $version);

	// get current section path for next section redirection purpose
	$controller = $this->request->getParam('controller');
	$action = $this->request->getParam('action');
	$pass = $this->request->getParam('pass');
	$passArr = json_encode($pass);
	$newPass = str_replace('[', '', $passArr);
	$newPass = str_replace(']', '', $newPass);
	$newPass = str_replace(',', '/', $newPass);
	$newPass = str_replace('"', '', $newPass);
	$pass_arr = explode('/', $newPass);
	$param_one = (isset($pass_arr[0])) ? $pass_arr[0] : '';
	$param_two = (isset($pass_arr[1])) ? $pass_arr[1] : '';
	?>

</head>

<body>

<!-- on 05-05-2022, Below noscript tag added to check if browser Scripting is working or not, if not provided steps -->	
<noscript>		
	<?php echo $this->Html->css('noscript'); ?>
	<?php echo $this->element('javascript_disable_msg_box'); ?>
</noscript>

	<?php echo $this->element('spinner'); ?>

	<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">

		<?php echo $this->element('mc/header'); ?>

		<div class="app-main">
			<div class="app-sidebar sidebar-shadow">
				<div class="app-header__logo">
					<div class="logo-src"></div>
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

				<?php echo $this->element('mc_sidebar'); ?>

			</div>
			<div class="app-main__outer">
				<?php echo $this->element('header_banner_panel'); ?>
				<div class="app-main__inner">

					<?php echo $this->element('mc_progress_bar'); ?>

					<?php

					if (!empty($this->getRequest()->getSession()->read('mon_f_suc'))) {

						$mon_f_suc = $this->getRequest()->getSession()->read('mon_f_suc');
						if (is_array($mon_f_suc)) {
							foreach ($mon_f_suc as $key => $val) {
								echo '<div class="alert alert-success fade show" role="alert"><i class="fa fa-check-circle"></i> ' . $val . '</div>';
							}
						} else {
							echo '<div class="alert alert-success fade show" role="alert"><i class="fa fa-check-circle"></i> ' . $this->getRequest()->getSession()->read('mon_f_suc') . '</div>';
						}

						$this->getRequest()->getSession()->delete('mon_f_suc');
					}

					if (!empty($this->getRequest()->getSession()->read('mon_f_err'))) {

						$mon_f_err = $this->getRequest()->getSession()->read('mon_f_err');
						if (is_array($mon_f_err)) {
							foreach ($mon_f_err as $key => $val) {
								echo '<div class="alert alert-danger fade show" role="alert"><i class="fa fa-exclamation-triangle"></i> ' . $val . '</div>';
							}
						} else {
							echo '<div class="alert alert-danger fade show" role="alert"><i class="fa fa-exclamation-triangle"></i> ' . $this->getRequest()->getSession()->read('mon_f_err') . '</div>';
						}

						$this->getRequest()->getSession()->delete('mon_f_err');
					}

					?>

					<div class="app-page-title return-heading text-center">
						<div class="page-title-wrapper return-heading-wrapper">
							<div class="page-title-heading return-heading-text">
								<div>
									<span class="return-heading-text-main"><?php echo $this->getRequest()->getSession()->read('form_return_date'); ?></span>
									<div class="page-title-subheading">[<?php echo $label['rule']; ?>]</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-header return-form-part">
						<?php echo $label['part']; ?><br/>
						<!-- <small><?php  //echo !empty(isset($label['part-sub']))?$label['part-sub']:''; ?></small> -->

					</div>

					<!-- below input fields used for storing first row container which is used in add more row functionality -->
					<?php echo $this->Form->control('main_row', array('type' => 'hidden', 'label' => false, 'id' => 'main_row')); ?>
					<?php echo $this->Form->control('project_path', array('type' => 'hidden', 'label' => false, 'id' => 'project_path', 'value' => $projectPath)); ?>

					<div class="alrt-div"></div>
					<div class="tab-content">
						<div class="tab-pane tabs-animation fade active show" id="tab-content-0" role="tabpanel">
							<div class="main-card mb-3 card">
								<div class="card-body">

									<?php

									echo $this->Form->create(null, array('type' => 'file', 'enctype' => 'multipart/form-data', 'class' => 'form-group monthly-return-form'));

									echo $this->fetch('content');

									echo $this->element('mc/section_button');

									echo $this->Form->end();

									?>

								</div>
							</div>
						</div>
					</div>
				</div>

				<?php echo $this->element('panel_footer'); ?>

			</div>
		</div>
	</div>


	<?php echo $this->element('mc/modal'); ?>
	<?php echo $this->element('esign_declaration_msg'); ?>

	<?php echo $this->Form->control('', ['type' => 'hidden', 'id' => 'dashboard_url', 'value' => $this->Url->build(array('controller' => 'auth', 'action' => 'home'))]); ?>
	<?php echo $this->Form->control('', ['type' => 'hidden', 'id' => 'section_mode', 'value' => $section_mode]); ?>
	<?php echo $this->Form->control('', ['type' => 'hidden', 'id' => 'change_lang_url', 'value' => $this->Url->build(array('controller' => 'monthly', 'action' => 'changeLanguage'))]); ?>
	<?php echo $this->Form->control('', ['type' => 'hidden', 'id' => 'table_form_data', 'value' => $tableForm]); ?>

	<?php echo $this->Html->script('main.js?version=' . $version); ?>
	<?php echo $this->Html->script('common.js?version=' . $version); ?>
	<?php echo $this->Html->script('add_more_row.js?version=' . $version); ?>
	<?php echo $this->Html->script('security.js?version=' . $version); ?>
	<?php echo $this->Html->script('mc/panel.js?version=' . $version); ?>


</body>

</html>