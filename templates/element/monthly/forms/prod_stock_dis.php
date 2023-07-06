
<?php 

// Highlight fields which are differs from cumulative monthly data in annual
// (Only for Form G3 in MMS side)
// Effective from Phase-II
// Added on 25th Nov 2021 by Aniket Ganvir

$stones = array('rough', 'cut', 'ind', 'oth');
$stocks = array('open_tot_no', 'open_tot_qty', 'prod_oc_no', 'prod_oc_qty', 'prod_ug_no', 'prod_ug_qty', 'prod_tot_no', 'prod_tot_qty', 'desp_tot_no', 'desp_tot_qty', 'clos_tot_no', 'clos_tot_qty', 'pmv_oc');

foreach($stones as $stone) {
	
	foreach($stocks as $stock) {
		$diff[$stone][$stock]['class'] = '';
		$diff[$stone][$stock]['title'] = '';
	}

	if (isset($stoneDataMonthAll)) {
		
		$stoneDataOld = $stoneDataMonthAll;
		$newStone = $stone.'Stone';

		foreach($stocks as $stock) {
			if ($stoneDataOld[$stone][0][$stock] != $$newStone[0][$stock]) {
				$openTotNoDiff = $$newStone[0][$stock] - $stoneDataOld[$stone][0][$stock];
				$diff[$stone][$stock]['title'] = ($openTotNoDiff > 0) ? '+'.$openTotNoDiff : $openTotNoDiff;
				$diff[$stone][$stock]['class'] = ' in_new';
			}
		}

	}

}

?>

<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-12 mine-m-auto">
		<table class="table table-bordered table-sm" id="mTable">
			<thead class="bg-secondary text-white text-center">
				<tr>
                    <th rowspan="3"></th>
					<th colspan="4"><?php echo $label[0]; ?></th>
					<th colspan="2" rowspan="2" class="align-middle"><?php echo $label[1]; ?></th>
					<th colspan="2" rowspan="2" class="align-middle"><?php echo $label[2]; ?></th>
				</tr>
				<tr>
					<th colspan="2"><?php echo $label[3]; ?></th>
					<th colspan="2"><?php echo $label[4]; ?></th>
				</tr>
				<tr>
					<th class="align-middle"><?php echo $label[5]; ?></th>
					<th class="align-middle"><?php echo $label[6]; ?></th>
					<th class="align-middle"><?php echo $label[5]; ?></th>
					<th class="align-middle"><?php echo $label[6]; ?></th>
					<th class="align-middle"><?php echo $label[5]; ?></th>
					<th class="align-middle"><?php echo $label[6]; ?></th>
					<th class="align-middle"><?php echo $label[5]; ?></th>
					<th class="align-middle"><?php echo $label[6]; ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo $label[7]; ?></td>
					<td>
						<?php echo $this->Form->control('f_rough_open_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['rough']['open_tot_no']['class'], 'id'=>'F_Rough_OPEN_TOT_NO', 'title'=>$diff['rough']['open_tot_no']['title'], 'value'=>$roughStone[0]['open_tot_no'], 'label'=>false, 'maxLength'=>7)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_rough_open_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum cvFloat'.$diff['rough']['open_tot_qty']['class'], 'id'=>'F_Rough_OPEN_TOT_QTY', 'title'=>$diff['rough']['open_tot_qty']['title'], 'value'=>$roughStone[0]['open_tot_qty'], 'label'=>false, 'maxLength'=>13, 'cvfloat'=>'999999999.999', 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_polished_open_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['cut']['open_tot_no']['class'], 'id'=>'F_Polished_OPEN_TOT_NO', 'title'=>$diff['cut']['open_tot_no']['title'], 'value'=>$cutStone[0]['open_tot_no'], 'label'=>false, 'maxLength'=>7)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_polished_open_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum cvFloat'.$diff['cut']['open_tot_qty']['class'], 'id'=>'F_Polished_OPEN_TOT_QTY', 'title'=>$diff['cut']['open_tot_qty']['title'], 'value'=>$cutStone[0]['open_tot_qty'], 'label'=>false, 'maxLength'=>13, 'cvfloat'=>'999999999.999',  'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_industrial_open_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['ind']['open_tot_no']['class'], 'id'=>'F_Industrial_OPEN_TOT_NO', 'title'=>$diff['ind']['open_tot_no']['title'], 'value'=>$indStone[0]['open_tot_no'], 'label'=>false, 'maxLength'=>7)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_industrial_open_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum cvFloat'.$diff['ind']['open_tot_qty']['class'], 'id'=>'F_Industrial_OPEN_TOT_QTY', 'title'=>$diff['ind']['open_tot_qty']['title'], 'value'=>$indStone[0]['open_tot_qty'], 'label'=>false, 'maxLength'=>13, 'cvfloat'=>'999999999.999',  'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_other_open_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['oth']['open_tot_no']['class'], 'id'=>'F_Other_OPEN_TOT_NO', 'title'=>$diff['oth']['open_tot_no']['title'], 'value'=>$othStone[0]['open_tot_no'], 'label'=>false, 'maxLength'=>7)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_other_open_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum cvFloat'.$diff['oth']['open_tot_qty']['class'], 'id'=>'F_Other_OPEN_TOT_QTY', 'title'=>$diff['oth']['open_tot_qty']['title'], 'value'=>$othStone[0]['open_tot_qty'], 'label'=>false, 'maxLength'=>13, 'cvfloat'=>'999999999.999', 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
				</tr>
				<tr>
					<td colspan="9"><?php echo $label[8]; ?></td>
                </tr>
				<tr>
					<td><?php echo $label[9]; ?></td>
					<td>
						<?php echo $this->Form->control('f_rough_prod_oc_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['rough']['prod_oc_no']['class'], 'id'=>'F_Rough_PROD_OC_NO', 'title'=>$diff['rough']['prod_oc_no']['title'], 'value'=>$roughStone[0]['prod_oc_no'], 'label'=>false, 'maxLength'=>7)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_rough_prod_oc_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum cvFloat'.$diff['rough']['prod_oc_qty']['class'], 'id'=>'F_Rough_PROD_OC_QTY', 'title'=>$diff['rough']['prod_oc_qty']['title'], 'value'=>$roughStone[0]['prod_oc_qty'], 'label'=>false, 'maxLength'=>13, 'cvfloat'=>'999999999.999', 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_polished_prod_oc_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['cut']['prod_oc_no']['class'], 'id'=>'F_Polished_PROD_OC_NO', 'title'=>$diff['cut']['prod_oc_no']['title'], 'value'=>$cutStone[0]['prod_oc_no'], 'label'=>false, 'maxLength'=>7)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_polished_prod_oc_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum cvFloat'.$diff['cut']['prod_oc_qty']['class'], 'id'=>'F_Polished_PROD_OC_QTY', 'title'=>$diff['cut']['prod_oc_qty']['title'], 'value'=>$cutStone[0]['prod_oc_qty'], 'label'=>false, 'maxLength'=>13, 'cvfloat'=>'999999999.999', 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_industrial_prod_oc_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['ind']['prod_oc_no']['class'], 'id'=>'F_Industrial_PROD_OC_NO', 'title'=>$diff['ind']['prod_oc_no']['title'], 'value'=>$indStone[0]['prod_oc_no'], 'label'=>false, 'maxLength'=>7)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_industrial_prod_oc_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum cvFloat'.$diff['ind']['prod_oc_qty']['class'], 'id'=>'F_Industrial_PROD_OC_QTY', 'title'=>$diff['ind']['prod_oc_qty']['title'], 'value'=>$indStone[0]['prod_oc_qty'], 'label'=>false, 'maxLength'=>13, 'cvfloat'=>'999999999.999', 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_other_prod_oc_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['oth']['prod_oc_no']['class'], 'id'=>'F_Other_PROD_OC_NO', 'title'=>$diff['oth']['prod_oc_no']['title'], 'value'=>$othStone[0]['prod_oc_no'], 'label'=>false, 'maxLength'=>7)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_other_prod_oc_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum cvFloat'.$diff['oth']['prod_oc_qty']['class'], 'id'=>'F_Other_PROD_OC_QTY', 'title'=>$diff['oth']['prod_oc_qty']['title'], 'value'=>$othStone[0]['prod_oc_qty'], 'label'=>false, 'maxLength'=>13, 'cvfloat'=>'999999999.999', 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
                </tr>
				<tr>
					<td><?php echo $label[10]; ?></td>
					<td>
						<?php echo $this->Form->control('f_rough_prod_ug_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['rough']['prod_ug_no']['class'], 'id'=>'F_Rough_PROD_UG_NO', 'title'=>$diff['rough']['prod_ug_no']['title'], 'value'=>$roughStone[0]['prod_ug_no'], 'label'=>false, 'maxLength'=>7)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_rough_prod_ug_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum cvFloat'.$diff['rough']['prod_ug_qty']['class'], 'id'=>'F_Rough_PROD_UG_QTY', 'title'=>$diff['rough']['prod_ug_qty']['title'], 'value'=>$roughStone[0]['prod_ug_qty'], 'label'=>false, 'maxLength'=>13, 'cvfloat'=>'999999999.999', 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_polished_prod_ug_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['cut']['prod_ug_no']['class'], 'id'=>'F_Polished_PROD_UG_NO', 'title'=>$diff['cut']['prod_ug_no']['title'], 'value'=>$cutStone[0]['prod_ug_no'], 'label'=>false, 'maxLength'=>7)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_polished_prod_ug_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum cvFloat'.$diff['cut']['prod_ug_qty']['class'], 'id'=>'F_Polished_PROD_UG_QTY', 'title'=>$diff['cut']['prod_ug_qty']['title'], 'value'=>$cutStone[0]['prod_ug_qty'], 'label'=>false, 'maxLength'=>13, 'cvfloat'=>'999999999.999', 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_industrial_prod_ug_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['ind']['prod_ug_no']['class'], 'id'=>'F_Industrial_PROD_UG_NO', 'title'=>$diff['ind']['prod_ug_no']['title'], 'value'=>$indStone[0]['prod_ug_no'], 'label'=>false, 'maxLength'=>7)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_industrial_prod_ug_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum cvFloat'.$diff['ind']['prod_ug_qty']['class'], 'id'=>'F_Industrial_PROD_UG_QTY', 'title'=>$diff['ind']['prod_ug_qty']['title'], 'value'=>$indStone[0]['prod_ug_qty'], 'label'=>false, 'maxLength'=>13, 'cvfloat'=>'999999999.999', 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_other_prod_ug_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['oth']['prod_ug_no']['class'], 'id'=>'F_Other_PROD_UG_NO', 'title'=>$diff['oth']['prod_ug_no']['title'], 'value'=>$othStone[0]['prod_ug_no'], 'label'=>false, 'maxLength'=>7)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_other_prod_ug_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum cvFloat'.$diff['oth']['prod_ug_qty']['class'], 'id'=>'F_Other_PROD_UG_QTY', 'title'=>$diff['oth']['prod_ug_qty']['title'], 'value'=>$othStone[0]['prod_ug_qty'], 'label'=>false, 'maxLength'=>13, 'cvfloat'=>'999999999.999', 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
                </tr>
				<tr class="bg-light">
					<td><?php echo $label[11]; ?></td>
					<td>
						<?php echo $this->Form->control('f_rough_prod_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum tot_no'.$diff['rough']['prod_tot_no']['class'], 'id'=>'F_Rough_PROD_TOT_NO', 'title'=>$diff['rough']['prod_tot_no']['title'], 'value'=>$roughStone[0]['prod_tot_no'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_rough_prod_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum tot_no_qty'.$diff['rough']['prod_tot_qty']['class'], 'id'=>'F_Rough_PROD_TOT_QTY', 'title'=>$diff['rough']['prod_tot_qty']['title'], 'value'=>$roughStone[0]['prod_tot_qty'], 'label'=>false, 'maxLength'=>150, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_polished_prod_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum tot_no'.$diff['cut']['prod_tot_no']['class'], 'id'=>'F_Polished_PROD_TOT_NO', 'title'=>$diff['cut']['prod_tot_no']['title'], 'value'=>$cutStone[0]['prod_tot_no'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_polished_prod_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum tot_no_qty'.$diff['cut']['prod_tot_qty']['class'], 'id'=>'F_Polished_PROD_TOT_QTY', 'title'=>$diff['cut']['prod_tot_qty']['title'], 'value'=>$cutStone[0]['prod_tot_qty'], 'label'=>false, 'maxLength'=>150, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_industrial_prod_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum tot_no'.$diff['ind']['prod_tot_no']['class'], 'id'=>'F_Industrial_PROD_TOT_NO', 'title'=>$diff['ind']['prod_tot_no']['title'], 'value'=>$indStone[0]['prod_tot_no'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_industrial_prod_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum tot_no_qty'.$diff['ind']['prod_tot_qty']['class'], 'id'=>'F_Industrial_PROD_TOT_QTY', 'title'=>$diff['ind']['prod_tot_qty']['title'], 'value'=>$indStone[0]['prod_tot_qty'], 'label'=>false, 'maxLength'=>150, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_other_prod_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum tot_no'.$diff['oth']['prod_tot_no']['class'], 'id'=>'F_Other_PROD_TOT_NO', 'title'=>$diff['oth']['prod_tot_no']['title'], 'value'=>$othStone[0]['prod_tot_no'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_other_prod_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum tot_no_qty'.$diff['oth']['prod_tot_qty']['class'], 'id'=>'F_Other_PROD_TOT_QTY', 'title'=>$diff['oth']['prod_tot_qty']['title'], 'value'=>$othStone[0]['prod_tot_qty'], 'label'=>false, 'maxLength'=>150, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
                </tr>
				<tr>
					<td><?php echo $label[12]; ?></td>
					<td>
						<?php echo $this->Form->control('f_rough_desp_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['rough']['desp_tot_no']['class'], 'id'=>'F_Rough_DESP_TOT_NO', 'title'=>$diff['rough']['desp_tot_no']['title'], 'value'=>$roughStone[0]['desp_tot_no'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_rough_desp_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['rough']['desp_tot_qty']['class'], 'id'=>'F_Rough_DESP_TOT_QTY', 'title'=>$diff['rough']['desp_tot_qty']['title'], 'value'=>$roughStone[0]['desp_tot_qty'], 'label'=>false, 'maxLength'=>150, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_polished_desp_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['cut']['desp_tot_no']['class'], 'id'=>'F_Polished_DESP_TOT_NO', 'title'=>$diff['cut']['desp_tot_no']['title'], 'value'=>$cutStone[0]['desp_tot_no'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_polished_desp_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['cut']['desp_tot_qty']['class'], 'id'=>'F_Polished_DESP_TOT_QTY', 'title'=>$diff['cut']['desp_tot_qty']['title'], 'value'=>$cutStone[0]['desp_tot_qty'], 'label'=>false, 'maxLength'=>150, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_industrial_desp_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['ind']['desp_tot_no']['class'], 'id'=>'F_Industrial_DESP_TOT_NO', 'title'=>$diff['ind']['desp_tot_no']['title'], 'value'=>$indStone[0]['desp_tot_no'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_industrial_desp_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['ind']['desp_tot_qty']['class'], 'id'=>'F_Industrial_DESP_TOT_QTY', 'title'=>$diff['ind']['desp_tot_qty']['title'], 'value'=>$indStone[0]['desp_tot_qty'], 'label'=>false, 'maxLength'=>150, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_other_desp_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['oth']['desp_tot_no']['class'], 'id'=>'F_Other_DESP_TOT_NO', 'title'=>$diff['oth']['desp_tot_no']['title'], 'value'=>$othStone[0]['desp_tot_no'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_other_desp_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['oth']['desp_tot_qty']['class'], 'id'=>'F_Other_DESP_TOT_QTY', 'title'=>$diff['oth']['desp_tot_qty']['title'], 'value'=>$othStone[0]['desp_tot_qty'], 'label'=>false, 'maxLength'=>150, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
                </tr>
				<tr>
					<td><?php echo $label[13]; ?></td>
					<td>
						<?php echo $this->Form->control('f_rough_clos_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum clos_no'.$diff['rough']['clos_tot_no']['class'], 'id'=>'F_Rough_CLOS_TOT_NO', 'title'=>$diff['rough']['clos_tot_no']['title'], 'value'=>$roughStone[0]['clos_tot_no'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_rough_clos_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum clos_no_qty'.$diff['rough']['clos_tot_qty']['class'], 'id'=>'F_Rough_CLOS_TOT_QTY', 'title'=>$diff['rough']['clos_tot_qty']['title'], 'value'=>$roughStone[0]['clos_tot_qty'], 'label'=>false, 'maxLength'=>150, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_polished_clos_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum clos_no'.$diff['cut']['clos_tot_no']['class'], 'id'=>'F_Polished_CLOS_TOT_NO', 'title'=>$diff['cut']['clos_tot_no']['title'], 'value'=>$cutStone[0]['clos_tot_no'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_polished_clos_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum clos_no_qty'.$diff['cut']['clos_tot_qty']['class'], 'id'=>'F_Polished_CLOS_TOT_QTY', 'title'=>$diff['cut']['clos_tot_qty']['title'], 'value'=>$cutStone[0]['clos_tot_qty'], 'label'=>false, 'maxLength'=>150, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_industrial_clos_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum clos_no'.$diff['ind']['clos_tot_no']['class'], 'id'=>'F_Industrial_CLOS_TOT_NO', 'title'=>$diff['ind']['clos_tot_no']['title'], 'value'=>$indStone[0]['clos_tot_no'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_industrial_clos_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum clos_no_qty'.$diff['ind']['clos_tot_qty']['class'], 'id'=>'F_Industrial_CLOS_TOT_QTY', 'title'=>$diff['ind']['clos_tot_qty']['title'], 'value'=>$indStone[0]['clos_tot_qty'], 'label'=>false, 'maxLength'=>150, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_other_clos_tot_no', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum clos_no'.$diff['oth']['clos_tot_no']['class'], 'id'=>'F_Other_CLOS_TOT_NO', 'title'=>$diff['oth']['clos_tot_no']['title'], 'value'=>$othStone[0]['clos_tot_no'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td>
                        <div class="input-group">
						    <?php echo $this->Form->control('f_other_clos_tot_qty', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum clos_no_qty'.$diff['oth']['clos_tot_qty']['class'], 'id'=>'F_Other_CLOS_TOT_QTY', 'title'=>$diff['oth']['clos_tot_qty']['title'], 'value'=>$othStone[0]['clos_tot_qty'], 'label'=>false, 'maxLength'=>150, 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                            <div class="input-group-append">
                                <span class="input-group-text form-control-sm"><?php echo ucfirst(strtolower($minUnit)); ?></span>
                            </div>
                        </div>
						<div class="err_cv"></div>
					</td>
                </tr>
				<tr>
					<td><?php echo $label[14]; ?></td>
					<td colspan="2">
						<?php echo $this->Form->control('f_rough_pmv_oc', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['rough']['pmv_oc']['class'], 'id'=>'F_Rough_PMV_OC', 'title'=>$diff['rough']['pmv_oc']['title'], 'value'=>$roughStone[0]['pmv_oc'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td colspan="2">
						<?php echo $this->Form->control('f_polished_pmv_oc', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['cut']['pmv_oc']['class'], 'id'=>'F_Polished_PMV_OC', 'title'=>$diff['cut']['pmv_oc']['title'], 'value'=>$cutStone[0]['pmv_oc'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td colspan="2">
						<?php echo $this->Form->control('f_industrial_pmv_oc', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['ind']['pmv_oc']['class'], 'id'=>'F_Industrial_PMV_OC', 'title'=>$diff['ind']['pmv_oc']['title'], 'value'=>$indStone[0]['pmv_oc'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
					<td colspan="2">
						<?php echo $this->Form->control('f_other_pmv_oc', array('type'=>'text', 'class'=>'form-control form-control-sm number-fields cvOn cvReq cvNum'.$diff['oth']['pmv_oc']['class'], 'id'=>'F_Other_PMV_OC', 'title'=>$diff['oth']['pmv_oc']['title'], 'value'=>$othStone[0]['pmv_oc'], 'label'=>false, 'maxLength'=>150)); ?>
						<div class="err_cv"></div>
					</td>
                </tr>
			</tbody>
		</table>
        <div class="alert alert-info p-2 pl-3"> <?php echo $label[15]; ?></div>
	</div>
</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'value'=>$mineral)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'value'=>'frmProdStockDis')); ?>

<?php echo $this->Html->script('f/prod_stock_dis.js?version='.$version); ?>