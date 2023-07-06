
<?php 
	/* 
	 * Check mineCode for J&K. If mineCode is related to J&K then remove the "amp;" value from mineCode.
	 * Change Done By Pravin Bhakare on Date 19-01-2019 
	 * This was done to address the issue of miners of J&K not able to save the forms 
	**/
	date_default_timezone_set('Asia/Kolkata');
	if(isset($mineCode)){
		if (strpos($mineCode, '&') !== false) {  $mineCode = str_replace('amp;','',$mineCode); } 
	}
	// ***********

?>

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
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
	
	<?php 
		echo $this->Html->css('main.css?version='.$version);
		echo $this->Html->css('panel.css?version='.$version);
		
		//jquery ui (for autocomplete)
		echo $this->Html->css('jquery-ui/jquery-ui.css?version='.$version);
		
		echo $this->Html->script('jquery.min.js?version='.$version);
		echo $this->Html->script('jquery.validate.min.js?version='.$version);

		echo $this->Html->script('jquery-ui/jquery-ui.min.js?version='.$version);
		echo $this->Html->script('jquery.ui.autocomplete.js?version='.$version);
		
		echo $this->Html->script('custom-validate.js?version='.$version); // custom form input validations
		
		$returnType = $this->getRequest()->getSession()->read('view_user_type');
		if($returnType == 'authuser'){
			echo $this->Html->script('f/f.series.form.pi.js?version='.$version); // custom F-series form validations phase I
			echo $this->Html->script('g/g.series.form.pi.js?version='.$version); // custom G-series form validations phase I
			echo $this->Html->script('f/f.series.form.js?version='.$version); // custom F-series form validations
		} else {
			echo $this->Html->script('l/l.series.form.pi.js?version='.$version); // custom N-series form validations phase I
			echo $this->Html->script('l/l.series.form.js?version='.$version); // custom L-series form validations
		}
		
		echo $this->Html->script('jquery.dataTables.min.js?version='.$version);
		echo $this->Html->script('panel.js?version='.$version); // admin panel custom javascript

		echo $this->Html->script('swfobject.js?version='.$version);
		echo $this->Html->script('slidedown-menu2.js?version='.$version);
		echo $this->Html->script('AC_RunActiveContent.js?version='.$version);
		echo $this->Html->script('jquery.blockUI.js?version='.$version);
		echo $this->Html->script('json_parse.js?version='.$version);
		// echo $this->Html->script('jquery.ui.core.js?version='.$version);
		// echo $this->Html->script('jquery.ui.widget.js?version='.$version);
		// echo $this->Html->script('jquery.ui.position.js?version='.$version);
		// echo $this->Html->script('h-form.js?version='.$version);
		// echo $this->Html->script('jquery-uii.min.js?version='.$version);
		echo $this->Html->script('bootstrap.minn.js?version=' . $version);
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
				
				<?php echo $this->element('mc_form_sidebar'); ?>
				
			</div>    
			<div class="app-main__outer">

				<?php echo $this->element('header_banner_panel'); ?>

				<div class="app-main__inner">

					<?php echo $this->element('mc_progress_bar'); ?>

					<?php if(!empty($this->getRequest()->getSession()->read('mon_f_suc'))){ ?>
						<div class="alert alert-success fade show" role="alert"><i class="fa fa-check-circle"></i> 
							<?php echo $this->getRequest()->getSession()->read('mon_f_suc'); ?>
						</div>
					<?php $this->getRequest()->getSession()->delete('mon_f_suc'); } ?>

					<?php if(!empty($this->getRequest()->getSession()->read('mon_f_err'))){ ?>
						<div class="alert alert-danger fade show" role="alert"><i class="fa fa-times-circle"></i> 
							<?php echo $this->getRequest()->getSession()->read('mon_f_err'); ?>
						</div>
					<?php $this->getRequest()->getSession()->delete('mon_f_err'); } ?>
					
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

					<!-- below input field used for storing first row container which is used in add more row functionality -->
					<?php echo $this->Form->control('main_row', array('type'=>'hidden', 'label'=>false, 'id'=>'main_row')); ?>

					<div class="tab-content">
						<div class="tab-pane tabs-animation fade active show" id="tab-content-0" role="tabpanel">
							<div class="main-card mb-3 card">
								<div class="card-body">
									
									<?php 

									echo $this->Form->create(null , array('type'=>'file', 'enctype'=>'multipart/form-data','class'=>'form-group monthly-return-form mms-main-form'));

									echo $this->fetch('content');

									echo $this->Form->end();

									?>

									<?php 

									$user_role = $this->getRequest()->getSession()->read("mms_user_role");
									$curAction = $this->getRequest()->getParam('action');

									// if($user_role == '2' || $user_role == '3'){
									if(in_array($user_role, array('2', '3', '8', '9'))){
										if($curAction != 'oreType' && $curAction != 'generalParticular'){
											echo $this->element('communication');
										} else if($curAction == 'oreType' || $curAction == 'generalParticular') {

											$controller = $this->request->getParam('controller');
											$action = $this->request->getParam('action');
											$pass = $this->request->getParam('pass');
											$passArr = json_encode($pass);
											$newPass = str_replace('[','',$passArr);
											$newPass = str_replace(']','',$newPass);
											$newPass = str_replace(',','/',$newPass);
											$newPass = str_replace('"','',$newPass);

											$pass_arr = explode('/', $newPass);
											$param_one = (isset($pass_arr[0])) ? $pass_arr[0] : '';
											$param_two = (isset($pass_arr[1])) ? $pass_arr[1] : '';
											$viewUserType = $this->getRequest()->getSession()->read("view_user_type");
											if($viewUserType == 'authuser'){
												$view_controller = 'Mms';
												$pdf_action = 'minerPrintPdf';
											} else {
												$view_controller = 'Mmsenduser';
												$pdf_action = 'enduserPrintPdf';
											}

											$curAction = $this->getRequest()->getParam('action');
											$firstSec = array('mine', 'generalParticular');
											if(!in_array($curAction, $firstSec)){
												echo $this->Html->link('<i class="fa fa-arrow-left"></i> Previous', array('controller'=>$view_controller,'action'=>'prevSection',$action,$controller,$param_one,$param_two), array('class'=>'mt-2 btn btn-info btn-lg ml-1', 'escape'=>false));
											}

											echo $this->Html->link('Home', $return_home_page, array('class'=>'print-all mt-2 btn btn-primary btn-lg ml-1','target' => '_blank'));
											echo $this->Html->link('Print All', array('controller'=>'returnspdf', 'action'=>$pdf_action), array('class'=>'print-all mt-2 ml-1 btn btn-success btn-lg','target'=>'_blank'));
											echo $this->Html->link('Next <i class="fa fa-arrow-right"></i>', array('controller'=>$view_controller,'action'=>'nextSection',$action,$controller,$param_one,$param_two), array('class'=>'mt-2 btn btn-info btn-lg ml-1', 'escape'=>false));
										
										}
									} else {
										$controller = $this->request->getParam('controller');
										$action = $this->request->getParam('action');
										$pass = $this->request->getParam('pass');
										$passArr = json_encode($pass);
										$newPass = str_replace('[','',$passArr);
										$newPass = str_replace(']','',$newPass);
										$newPass = str_replace(',','/',$newPass);
										$newPass = str_replace('"','',$newPass);

										$pass_arr = explode('/', $newPass);
										$param_one = (isset($pass_arr[0])) ? $pass_arr[0] : '';
										$param_two = (isset($pass_arr[1])) ? $pass_arr[1] : '';
										$viewUserType = $this->getRequest()->getSession()->read("view_user_type");
										if($viewUserType == 'authuser'){
											$view_controller = 'Mms';
											$pdf_action = 'minerPrintPdf';
										} else {
											$view_controller = 'Mmsenduser';
											$pdf_action = 'enduserPrintPdf';
										}

										$curAction = $this->getRequest()->getParam('action');
										$firstSec = array('mine', 'generalParticular');
										if(!in_array($curAction, $firstSec)){
											echo $this->Html->link('<i class="fa fa-arrow-left"></i> Previous', array('controller'=>$view_controller,'action'=>'prevSection',$action,$controller,$param_one,$param_two), array('class'=>'mt-2 btn btn-info btn-lg ml-1', 'escape'=>false));
										}

									//echo $this->Html->link('Home', $return_home_page, array('class'=>'print-all mt-2 btn btn-primary btn-lg ml-1','target' => '_blank'));

									echo $this->Html->link('Home', array('controller'=>'mms','action'=>'returns_records'), array('class'=>'print-all mt-2 btn btn-primary btn-lg ml-1','target' => '_blank'));
										echo $this->Html->link('Print All', array('controller'=>'returnspdf', 'action'=>$pdf_action), array('class'=>'print-all mt-2 ml-1 btn btn-success btn-lg','target'=>'_blank'));
										
										// "Next" button hide on last section, added on 22-07-2022 by Aniket
										$curController = $this->getRequest()->getParam('controller');
										$mineralParam = $this->getRequest()->getParam('pass');
										if(null==$mineralParam){
											$mineralParam = "";
										} else {
											$mineralPar = $mineralParam[0];
											$mineralPar .= (isset($mineralParam[1])) ? "/".$mineralParam[1] : "";
											$mineralParam = "/".$mineralPar;
										}
										$secLink = "/".$curController."/".$curAction.$mineralParam;
										$secLinkArr = $this->getRequest()->getSession()->read('sec_link');
										$secLinkArrLast = end($secLinkArr);
										$secLinkLast = end($secLinkArrLast);
										$secLinkLast = strtolower(str_replace(' ','',$secLinkLast));
										$secLinkLast = str_replace('_','',$secLinkLast);
										$secLink = strtolower(str_replace(' ','',$secLink));

										if($secLink != $secLinkLast){
											echo $this->Html->link('Next <i class="fa fa-arrow-right"></i>', array('controller'=>$view_controller,'action'=>'nextSection',$action,$controller,$param_one,$param_two), array('class'=>'mt-2 btn btn-info btn-lg ml-1 spinner_btn_nxt form_btn_next', 'escape'=>false));
										}

									}

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
	<?php echo $this->element('confirm_message_box'); ?>
	<?php echo $this->element('esign_declaration_msg_mms'); ?>
	
	<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'dashboard_url', 'value'=>$this->Url->build(['controller'=>'Mms', 'action'=>'home'])]); ?>
	<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'section_mode', 'value'=>$this->getRequest()->getSession()->read("form_status")]); ?>
	<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'table_form_data', 'value'=>$tableForm]); ?>

	<?php echo $this->Html->script('main.js?version='.$version); ?>
	<?php echo $this->Html->script('add_more_row.js?version='.$version); ?>
	<?php echo $this->Html->script('security.js?version='.$version); ?>
	<?php echo $this->Html->script('mms/panel.js?version='.$version); ?>

</body>
</html>
