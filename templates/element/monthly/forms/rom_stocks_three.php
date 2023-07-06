
<?php 

// Highlight fields which are differs from cumulative monthly data in annual
// (Only for Form G3 in MMS side)
// Effective from Phase-II
// Added on 25th Nov 2021 by Aniket Ganvir

$diff['oc_qty']['class'] = '';
$diff['oc_qty']['title'] = '';
$diff['ug_qty']['class'] = '';
$diff['ug_qty']['title'] = '';

if (isset($romDataMonthAll)) {
	
	$romDataOld = $romDataMonthAll;

	if ($romDataOld[0]['oc_qty'] != $romData[0]['oc_qty']) {
		$ocQtyDiff = $romData[0]['oc_qty'] - $romDataOld[0]['oc_qty'];
		$diff['oc_qty']['title'] = ($ocQtyDiff > 0) ? '+'.$ocQtyDiff : $ocQtyDiff;
		$diff['oc_qty']['class'] = ' in_new';
	}
	
	if ($romDataOld[0]['ug_qty'] != $romData[0]['ug_qty']) {
		$ugQtyDiff = $romData[0]['ug_qty'] - $romDataOld[0]['ug_qty'];
		$diff['ug_qty']['title'] = ($ugQtyDiff > 0) ? '+'.$ugQtyDiff : $ugQtyDiff;
		$diff['ug_qty']['class'] = ' in_new';
	}

}

?>

<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-9 mine-m-auto">
		<table class="table table-bordered table-sm" id="mTable">
            <!--
			<thead class="thead-light text-center">
				<tr>
					<th colspan="2"><?php //echo $label[0]; ?></th>
					<th><?php //echo $label[1]; ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php //echo $label[2]; ?></td>
					<td><?php //echo ucfirst(strtolower($minUnit)); ?></td>
					<td>
						<?php //echo $this->Form->control('f_oc_qty', array('type'=>'text', 'class'=>'form-control number-fields fSevenRom cvOn cvNum cvReq', 'id'=>'f_oc_qty', 'value'=>$romData[0]['oc_qty'], 'label'=>false, 'maxLength'=>150)); ?>
					</td>
				</tr>
				<tr>
					<td><?php //echo $label[3]; ?></td>
					<td><?php //echo ucfirst(strtolower($minUnit)); ?></td>
					<td>
						<?php //echo $this->Form->control('f_ug_qty', array('type'=>'text', 'class'=>'form-control number-fields fSevenRom cvOn cvNum cvReq', 'id'=>'f_ug_qty', 'value'=>$romData[0]['ug_qty'], 'label'=>false, 'maxLength'=>150)); ?>
					</td>
				</tr>
			</tbody>
            -->
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th><?php echo $label[0]; ?></th>
					<th><?php echo $label[10]; ?></th>
					<th><?php echo $label[1]; ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo $label[2]; ?></td>
					<td><?php echo ucfirst(strtolower($minUnit)); ?></td>
					<td>
                        <div class="input-group">
                            <?php echo $this->Form->control('f_oc_qty', array('type'=>'text', 'class'=>'form-control number-fields fSevenRom cvOn cvReq cvNum cvFloat'.$diff['oc_qty']['class'], 'id'=>'f_oc_qty', 'title'=>$diff['oc_qty']['title'], 'value'=>$romData[0]['oc_qty'], 'label'=>false, 'maxLength'=>16, 'cvfloat'=>'999999999999.999', 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <!-- <div class="input-group-append">
                                <span class="input-group-text"><?php //echo ucfirst(strtolower($minUnit)); ?></span>
                            </div> -->
                        </div>
                        <div class="err_cv"></div>
					</td>
				</tr>
				<tr>
					<td><?php echo $label[3]; ?></td>
					<td><?php echo ucfirst(strtolower($minUnit)); ?></td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_ug_qty', array('type'=>'text', 'class'=>'form-control number-fields fSevenRom cvOn cvReq cvNum cvFloat'.$diff['ug_qty']['class'], 'id'=>'f_ug_qty', 'title'=>$diff['ug_qty']['title'], 'value'=>$romData[0]['ug_qty'], 'label'=>false, 'maxLength'=>16, 'cvfloat'=>'999999999999.999', 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                           <!--  <div class="input-group-append">
                                <span class="input-group-text"><?php //echo ucfirst(strtolower($minUnit)); ?></span>
                            </div> -->
                        </div>
                        <div class="err_cv"></div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
    
	<div class="col-sm-8 mine-m-auto">
		<table class="table table-bordered">
            <?php if($returnType == 'ANNUAL'){ ?>
			    <thead class="thead-light text-center">
                    <tr>
                        <th><?php echo $label[4]; ?></th>
                        <th><?php echo $label[5]; ?><br/><?php echo $period; ?></th>
                        <th><?php echo $label[6]; ?><br/><?php echo $period; ?></th>
                        <th><?php echo $label[9]; ?></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td><?php echo $mineralName; ?></td>
                        <td><?php echo $estProd; ?></td>
                        <td><?php echo $cumProd; ?></td>
                        <td><?php echo ($estProd - $cumProd); ?></td>
                    </tr>
                </tbody>
                <?php } else { ?>
			    <thead class="thead-light text-center">
                    <tr>
                        <th><?php echo $label[7]; ?></th>
                        <th><?php echo $label[8]; ?></th>
                        <th><?php echo $label[9]; ?></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td><?php echo ($estProd != "") ? $estProd : "--"; ?></td>
                        <td><?php echo $cumProd; ?></td>
                        <td><?php echo ($estProd - $cumProd); ?></td>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
    </div>
</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'label'=>false, 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'label'=>false, 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'label'=>false, 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'label'=>false, 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'label'=>false, 'value'=>$mineral)); ?>

<?php echo $this->Form->control('estimated_prod', array('type'=>'hidden', 'label'=>false, 'value'=>$estProd)); ?>
<?php echo $this->Form->control('cum_prod', array('type'=>'hidden', 'label'=>false, 'value'=>$cumProd)); ?>
<?php echo $this->Form->control('minUnit', array('type'=>'hidden', 'label'=>false, 'value'=>$minUnit)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'frmRomStocksF7')); ?>

<?php echo $this->Html->script('f/rom_stocks_three.js?version='.$version); ?>