
<?php 

// Highlight fields which are differs from cumulative monthly data in annual
// (Only for Form G2 in MMS side)
// Effective from Phase-II
// Added on 22nd Nov 2021 by Aniket Ganvir

$diff['pmv']['class'] = '';
$diff['pmv']['title'] = '';
	
if (isset($prod5MonthAll)) {
	$prod5Old = $prod5MonthAll;
	$pmvOld = $prod5Old['pmv'];
	$pmvNew = $prod5['pmv'];
	if ($pmvOld != $pmvNew) {
		$pmvDiff = $pmvNew - $pmvOld; 
		$diff['pmv']['title'] = ($pmvDiff > 0) ? '+'.$pmvDiff : $pmvDiff;
		$diff['pmv']['class'] = ' in_new';
	}
}

?>

<!-- <h5 class="card-title"><?php //echo $label['title']; ?></h5> -->
<div class="position-relative row form-group mine-group">
	<!-- <div class="col-sm-6"><?php //echo $label[0]; ?></div> -->
	<div class="col-sm-6"><h5 class="card-title"><?php echo $label['title']; ?></h5></div>
	<div class="col-sm-6">
		<?php echo $this->Form->control('f_pmv', array('class'=>'form-control number-fields cvOn cvReq cvNum cvMin cvMaxLen cvFloat'.$diff['pmv']['class'], 'id'=>'f_pmv', 'label'=>false, 'autocomplete'=>"off", 'min'=>'0', 'maxlength'=>"11", 'cvfloat'=>'99999999.99', 'title'=>$diff['pmv']['title'], 'value'=>$prod5['pmv'])); ?>
        <div class="err_cv"></div>
	</div>
</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'value'=>$mineral)); ?>
<?php echo $this->Form->control('prod5Id', array('type'=>'hidden', 'value'=>$prod5Id)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'totalRomProd', 'value'=>$romProduction)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'btnExMine')); ?>

<?php echo $this->Html->script('f/ex_mine.js?version='.$version); ?>
