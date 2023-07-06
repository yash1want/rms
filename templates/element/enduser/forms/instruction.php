
<h5 class="card-title"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-12 mine-m-auto alert alert-info">
		<ul class="l_h_26">
			<li><b><?php echo $label[0]; ?></b></li>
			<li><b><?php echo $label[1]; ?></b></li>
			<li><b><?php echo $label[2]; ?></b></li>
			<li><b><?php echo $label[3]; ?></b></li>
			<li><b><?php echo $label[4]; ?></b></li>
			<li><b><?php echo $label[5]; ?></b></li>
			<li><b><?php echo $label[6]; ?></b></li>
			<?php if ($returnType == 'ANNUAL') { ?>
				<li><b><?php echo $label[7]; ?></b></li>
			<?php } ?>
		</ul>
	</div>
</div>

<table id="final-submit-error"></table>

<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'frmActivityDetails')); ?>
