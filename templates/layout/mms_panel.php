
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>IBM Returns Management Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
	
	<?php 
		echo $this->Html->css('main.css?version='.$version);
		echo $this->Html->css('panel.css?version='.$version);
		echo $this->Html->css('jquery.dataTables.min.css?version='.$version);
		echo $this->Html->css('datepicker.css?version='.$version);
		echo $this->Html->css('master.css');
		echo $this->Html->css('generateTicket.css');
		echo $this->Html->css('reportico.css');
		
		echo $this->Html->script('jquery.min.js?version='.$version);
		echo $this->Html->script('jquery-uii.min.js?version='.$version);
		echo $this->Html->script('custom-validate.js?version='.$version); // custom form input validations
		echo $this->Html->script('jquery.dataTables.min.js?version='.$version);
		echo $this->Html->script('ajax/ajaxfunction.js?version='.$version);
		echo $this->Html->script('datepicker.js?version='.$version);
		echo $this->Html->script('main.js?version='.$version);
		echo $this->Html->script('common.js?version='.$version);
		echo $this->Html->script('panel.js?version='.$version);
		echo $this->Html->script('custom_master.js');
		echo $this->Html->script('sha512.min.js?version='.$version);
		echo $this->Html->script('sha512.js?version='.$version);
		echo $this->Html->script('reportico_form_filter.js');	
		echo $this->Html->script('security.js?version='.$version);


		//Added Tinymce by Amey for replacement of ckeditor on 24/11/2021
		echo $this->Html->css('Tinymce/contentdefaultcontent.min');
		echo $this->Html->css('Tinymce/uioxidecontent.min');
		echo $this->Html->css('Tinymce/skin.min');
		echo $this->Html->css('Tinymce/uidefaultuioxidecontent.min');

		//Added Tinymce by Amey for replacement of ckeditor on 24/11/2021
		//echo $this->Html->script('jquery_new.min');
		echo $this->Html->script('Tinymce/jquery.tinymce.min');
		echo $this->Html->script('Tinymce/tinymce');
		echo $this->Html->script('Tinymce/icons.min');
		echo $this->Html->script('Tinymce/theme.min');
		echo $this->Html->script('Tinymce/plugin.min');
		echo $this->Html->script('Tinymce/advlistplugin.min');
		echo $this->Html->script('Tinymce/mediaplugin.min');
		echo $this->Html->script('Tinymce/fullscreenplugin.min');
		echo $this->Html->script('Tinymce/tableplugin.min');
		echo $this->Html->script('Tinymce/pasteplugin.min');
		echo $this->Html->script('Tinymce/wordcountplugin.min');
		echo $this->Html->script('Tinymce/imageplugin.min');
		echo $this->Html->script('Tinymce/autoLink');
		echo $this->Html->script('Tinymce/linkplugin');
		echo $this->Html->script('Tinymce/anchorplugin');
		echo $this->Html->script('Tinymce/visualblocksplugin');
		echo $this->Html->script('Tinymce/quickbarsplugin.min');
		
		echo $this->Html->script('admin_forms_validation');


	?>
	
</head>
<body>

<!-- mineral master validation - 01-03-2023 -->
<?php //if(isset($minerals_not_exist_in_returns) && !empty($minerals_not_exist_in_returns)) { echo $this->element('report_modal'); } ?>

<!-- added pdf version history modal on 25-08-2022 by Aniket -->
<?php echo $this->element('mms/pdf_version_modal'); ?>

<!-- on 05-05-2022, Below noscript tag added to check if browser Scripting is working or not, if not provided steps -->	
<noscript>		
	<?php echo $this->Html->css('noscript'); ?>
	<?php echo $this->element('javascript_disable_msg_box'); ?>
</noscript>

	<?php echo $this->element('spinner'); ?>
	
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">

		<?php echo $this->element('mms/header'); ?>

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
				
				<?php echo $this->element('mms_sidebar'); ?>
				
			</div>    
			<div class="app-main__outer">

				<?php echo $this->element('header_banner_panel'); ?>

				<div class="app-main__inner">
					<?php 

						if(!empty($this->getRequest()->getSession()->read('master_success_alert'))){

							$master_success_alert = $this->getRequest()->getSession()->read('master_success_alert');
							if(is_array($master_success_alert)){
								foreach($master_success_alert as $key => $val){
									echo '<div class="alert alert-success fade show" role="alert"><i class="fa fa-check-circle"></i> '.$val.'</div>';
								}
							} else {
								echo '<div class="alert alert-success fade show" role="alert"><i class="fa fa-check-circle"></i> '.$this->getRequest()->getSession()->read('master_success_alert').'</div>';
							}
							
							$this->getRequest()->getSession()->delete('master_success_alert');
						} 
						
						if(!empty($this->getRequest()->getSession()->read('master_error_alert'))){

							$master_error_alert = $this->getRequest()->getSession()->read('master_error_alert');
							if(is_array($master_error_alert)){
								foreach($master_error_alert as $key => $val){
									echo '<div class="alert alert-danger fade show" role="alert"><i class="fa fa-exclamation-triangle"></i> '.$val.'</div>';
								}
							} else {
								echo '<div class="alert alert-danger fade show" role="alert"><i class="fa fa-exclamation-triangle"></i> '.$this->getRequest()->getSession()->read('master_error_alert').'</div>';
							}
							
							$this->getRequest()->getSession()->delete('master_error_alert');
						} 
						
						if(!empty($this->getRequest()->getSession()->read('mon_f_err'))){
							echo '<div class="alert alert-danger fade show mb-5" role="alert"><i class="fa fa-exclamation-triangle"></i> '.$this->getRequest()->getSession()->read('mon_f_err').'</div>';
							$this->getRequest()->getSession()->delete('mon_f_err');
						} 
						
					?>

					<?php echo $this->fetch('content'); ?>
					
				</div>

				<?php echo $this->element('panel_footer');  ?>

			</div>
		</div>
	</div>
	
	<?php echo $this->element('confirm_message_box'); ?>

<?php


	if (isset($alert_message) && $alert_message != null) {  echo $this->element('msg_box'); }

	if (null !== $this->getRequest()->getSession()->read("process_msg")) { echo $this->element('msg_box_only'); }

	echo $this->Form->control('', ['type'=>'hidden', 'id'=>'change_lang_url', 'value'=>$this->Url->build(array('controller'=>'monthly','action'=>'changeLanguage'))]);

?>

<?php echo $this->Html->script('add_more_row.js?version=' . $version); ?> <!-- for support team module purpose only -->
</body>
</html>
