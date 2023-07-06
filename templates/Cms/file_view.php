<?php ?>
<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body">
        <div class="rows">
        	<h4 class="text-center font-weight-bold text-alternate">View File</h4>
        </div>

    </div>
</div>
<div class="main-card mb-3 card">
	<div class="card-body text-center">	
		<!-- below condition and anchor tag added on 25-08-2018 to open pdf file in another window in browser -->
	<?php if (substr(strrchr($view_file,'.'),1)=='pdf' || 
			substr(strrchr($view_file,'.'),1)=='PDF') { ?>
		
		<a target="blank" href="<?php echo $view_file; ?>">Please click here to open pdf file</a>
		
	<?php } else {?>

		<img class="wd100" src="<?php echo $view_file; ?>" />
	<?php } ?>	
	<br>
	<br>
	<?php echo $this->Html->link('Back', '/cms/file_uploads',array('escapeTitle'=>false,'class'=>'btn btn-secondary font-weight-bold pl-4 pr-4 ml-2')); ?>
	</div>
</div>




