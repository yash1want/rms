
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-12 mine-m-auto">
		<table class="table table-bordered table-sm">
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th><?php echo $label[0]; ?></th>
					<th><?php echo $label[1]; ?></th>
					<th class="w-25"><?php echo $label[2]; ?></th>
				</tr>
			</thead>
			
			<?php 
                        
			// Highlight fields which are differs from cumulative monthly data in annual
			// (Only for Form G1 in MMS side)
			// Effective from Phase-II
			// Added on 09th Nov 2021 by Aniket Ganvir

			$dedArr = array('trans_cost', 'loading_charges', 'railway_freight', 'port_handling', 'sampling_cost', 'plot_rent', 'other_cost', 'total_prod');
			for ($i=0; $i < 8; $i++) {

				$diff[$dedArr[$i]]['class'] = '';
				$diff[$dedArr[$i]]['title'] = '';
					
				if (isset($prodArrMonthAll)) {

					$dedOld = $prodArrMonthAll[$dedArr[$i]];
					$dedNew = $prodArr[$dedArr[$i]];
					if ($dedOld != $dedNew) {
						$dedDiff = $dedNew - $dedOld;
						$diff[$dedArr[$i]]['title'] = ($dedDiff > 0) ? '+'.$dedDiff : $dedDiff;
						$diff[$dedArr[$i]]['class'] = ' in_new';
					}

				}

			}

			?>
			<tbody>
				<tr>
					<td><?php echo $label[3]; ?></td>
					<td>
						<?php $this->Form->setTemplates(['inputContainer' => '{{content}}']); ?>
						<?php echo $this->Form->control('trans_cost', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['trans_cost']['class'], 'id'=>'trans_cost', 'label'=>false, 'title'=>$diff['trans_cost']['title'], 'value'=>$prodArr['trans_cost'], 'maxlength'=>'7')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('trans_remark', array('type'=>'textarea','class'=>'form-control form-control-sm ded_det_textarea cvOn cvMaxLen', 'id'=>'trans_remark', 'label'=>false, 'value'=>$prodArr['trans_remark'], 'maxlength'=>'250', 'rows'=>'2')); ?>
						<div class="err_cv"></div>
					</td>
				</tr>
				<tr>
					<td><?php echo $label[4]; ?></td>
					<td>
						<?php echo $this->Form->control('loading_charges', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['loading_charges']['class'], 'id'=>'loading_charges', 'label'=>false, 'title'=>$diff['loading_charges']['title'], 'value'=>$prodArr['loading_charges'], 'maxlength'=>'7')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('loading_remark', array('type'=>'textarea','class'=>'form-control form-control-sm ded_det_textarea', 'id'=>'loading_remark', 'label'=>false, 'value'=>$prodArr['loading_remark'], 'rows'=>'2')); ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $label[5]; ?></td>
					<td>
						<?php echo $this->Form->control('railway_freight', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['railway_freight']['class'], 'id'=>'railway_freight', 'label'=>false, 'title'=>$diff['railway_freight']['title'], 'value'=>$prodArr['railway_freight'], 'maxlength'=>'8')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('railway_remark', array('type'=>'textarea','class'=>'form-control form-control-sm ded_det_textarea cvOn cvMaxLen', 'id'=>'railway_remark', 'label'=>false, 'value'=>$prodArr['railway_remark'], 'maxlength'=>'250', 'rows'=>'2')); ?>
						<div class="err_cv"></div>
					</td>
				</tr>
				<tr>
					<td><?php echo $label[6]; ?></td>
					<td>
						<?php echo $this->Form->control('port_handling', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['port_handling']['class'], 'id'=>'port_handling', 'label'=>false, 'title'=>$diff['port_handling']['title'], 'value'=>$prodArr['port_handling'], 'maxlength'=>'7')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('port_remark', array('type'=>'textarea','class'=>'form-control form-control-sm ded_det_textarea cvOn cvMaxLen', 'id'=>'port_remark', 'label'=>false, 'value'=>$prodArr['port_remark'], 'maxlength'=>'250', 'rows'=>'2')); ?>
						<div class="err_cv"></div>
					</td>
				</tr>
				<tr>
					<td><?php echo $label[7]; ?></td>
					<td>
						<?php echo $this->Form->control('sampling_cost', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['sampling_cost']['class'], 'id'=>'sampling_cost', 'label'=>false, 'title'=>$diff['sampling_cost']['title'], 'value'=>$prodArr['sampling_cost'], 'maxlength'=>'7')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('sampling_remark', array('type'=>'textarea','class'=>'form-control form-control-sm ded_det_textarea', 'id'=>'sampling_remark', 'label'=>false, 'value'=>$prodArr['sampling_remark'], 'rows'=>'2')); ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $label[8]; ?></td>
					<td>
						<?php echo $this->Form->control('plot_rent', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['plot_rent']['class'], 'id'=>'plot_rent', 'label'=>false, 'title'=>$diff['plot_rent']['title'], 'value'=>$prodArr['plot_rent'], 'maxlength'=>'7')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('plot_remark', array('type'=>'textarea','class'=>'form-control form-control-sm ded_det_textarea', 'id'=>'plot_remark', 'label'=>false, 'value'=>$prodArr['plot_remark'], 'rows'=>'2')); ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $label[9]; ?></td>
					<td>
						<?php echo $this->Form->control('other_cost', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['other_cost']['class'], 'id'=>'other_cost', 'label'=>false, 'title'=>$diff['other_cost']['title'], 'value'=>$prodArr['other_cost'], 'maxlength'=>'7')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('other_remark', array('type'=>'textarea','class'=>'form-control form-control-sm ded_det_textarea cvOn cvMaxLen', 'id'=>'other_remark', 'label'=>false, 'value'=>$prodArr['other_remark'], 'maxlength'=>'250', 'rows'=>'2')); ?>
						<div class="err_cv"></div>
					</td>
				</tr>
				<tr class="bg-light">
					<td><?php echo $label[10]; ?></td>
					<td>
						<div class="input-group">
							<?php echo $this->Form->control('total_prod', array('class'=>'form-control form-control-sm cvOn cvNum cvMaxLen'.$diff['total_prod']['class'], 'id'=>'total_prod', 'label'=>false, 'title'=>$diff['total_prod']['title'], 'value'=>$prodArr['total_prod'], 'maxlength'=>'9')); ?>
							
						</div>
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<div class="alert alert-info p-2 pl-3"><em><?php echo $label['note']; ?></em></div>
	</div>
</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'value'=>$mineral)); ?>
<?php echo $this->Form->control('iron_sub_min', array('type'=>'hidden', 'value'=>$ironSubMin)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'value'=>'frmDeductionsDetails')); ?>
