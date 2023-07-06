
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>IBM Support Module Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
	
	<?php 
		echo $this->Html->css('main.css?version='.$version);
		echo $this->Html->css('panel.css?version='.$version);
		echo $this->Html->css('jquery.dataTables.min.css?version='.$version);
		echo $this->Html->css('datepicker.css?version='.$version);
		echo $this->Html->css('master.css');
		echo $this->Html->css('reportico.css');
		echo $this->Html->css('jquery-ui/jquery-ui.css?version='.$version);
		echo $this->Html->css('buttons.dataTables.min.css'); // For Download DataTable data
		echo $this->Html->css('printdatatables.min.css'); // For Download DataTable data
		// echo $this->Html->css('dataTables.bootstrap4.min.css');//For DataTable Style
		echo $this->Html->css('jquery.multiselect');

		echo $this->Html->script('jquery.min.js?version='.$version);
		echo $this->Html->script('jquery-uii.min.js?version='.$version);
		echo $this->Html->script('custom-validate.js?version='.$version); // custom form input validations
		/*echo $this->Html->script('jquery.validate.min.js?version='.$version);*/
		echo $this->Html->script('jquery.dataTables.min.js?version='.$version);
		echo $this->Html->script('ajax/ajaxfunction.js?version='.$version);
		echo $this->Html->script('datepicker.js?version='.$version);

		echo $this->Html->script('main');
		echo $this->Html->script('common.js?version='.$version);
		echo $this->Html->script('panel.js?version='.$version);
		echo $this->Html->script('custom_master.js');
		/*echo $this->Html->script('jquery-ui.min.js?version='.$version);*/
		echo $this->Html->script('jquery.multiselect');
		echo $this->Html->script('sha512.min.js?version='.$version);
		echo $this->Html->script('sha512.js?version='.$version);
		echo $this->Html->script('reportico_form_filter.js');	
		echo $this->Html->script('security.js?version='.$version);

	/*	echo $this->Html->script('select_return.js?version='.$version); // select return validations
		echo $this->Html->script('dataTables.buttons.min.js'); // For Download DataTable data
		echo $this->Html->script('pdfmake.min.js'); // For Download DataTable data
		echo $this->Html->script('vfs_fonts.js'); // For Download DataTable data
		echo $this->Html->script('datatables.min.js'); // For Download DataTable data
		echo $this->Html->script('dataTables.bootstrap4.min.js');//For DataTable Style*/

		
	
	?>
	
</head>
<body>

<!-- added pdf version history modal on 12-08-2022 by Aniket -->
<?php echo $this->element('mms/pdf_version_modal'); ?>

<!-- on 05-05-2022, Below noscript tag added to check if browser Scripting is working or not, if not provided steps -->	
<noscript>		
	<?php echo $this->Html->css('noscript'); ?>
	<?php echo $this->element('javascript_disable_msg_box'); ?>
</noscript>
	
	<?php echo $this->element('spinner'); ?>

    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
		
		<?php echo $this->element('support/header'); ?>

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
				
				<?php echo $this->element('support_sidebar'); ?>
				
			</div>    
			<div class="app-main__outer">

				<?php echo $this->element('support_header_banner_panel'); ?>

				<div class="app-main__inner">
					
					<?php echo $this->element('mc_progress_bar'); ?>

					<?php 

						if (!empty($this->getRequest()->getSession()->read('mon_f_suc'))) 
						{

							$mon_f_suc = $this->getRequest()->getSession()->read('mon_f_suc');
							if (is_array($mon_f_suc)) 
							{
								foreach ($mon_f_suc as $key => $val) {
									echo '<div class="alert alert-success fade show" role="alert"><i class="fa fa-check-circle"></i> ' . $val . '</div>';
								}
							} 
							else 
							{
								echo '<div class="alert alert-success fade show" role="alert"><i class="fa fa-check-circle"></i> ' . $this->getRequest()->getSession()->read('mon_f_suc') . '</div>';
							}

							$this->getRequest()->getSession()->delete('mon_f_suc');
						}


						if(!empty($this->getRequest()->getSession()->read('mon_f_err'))){
							echo '<div class="alert alert-danger fade show" role="alert"><i class="fa fa-exclamation-triangle"></i> '.$this->getRequest()->getSession()->read('mon_f_err').'</div>';
							$this->getRequest()->getSession()->delete('mon_f_err');
						} 
					?>
					
					<?php echo $this->fetch('content'); ?>
					
				</div>

				<?php echo $this->element('panel_footer'); ?>
				
			</div>
		</div>
	</div>

<?php

	if (isset($alert_message) && $alert_message != null) { echo $this->element('msg_box'); }
	
	if (null !== $this->getRequest()->getSession()->read("process_msg")) { echo $this->element('msg_box_only'); }

	echo $this->Form->control('', ['type'=>'hidden', 'id'=>'change_lang_url', 'value'=>$this->Url->build(array('controller'=>'monthly','action'=>'changeLanguage'))]);

?>

</body>
</html>
