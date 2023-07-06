
<h5 class="card-title text-center"><?php echo $label['title']; ?>
	<small><?php echo $label[10]; ?></small>
</h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-12 mine-m-auto">
		<table class="table table-bordered table-sm">
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th><?php echo $label[0]; ?></th>
					<th><?php echo $label[1]; ?></th>
					<th><?php echo $label[2]; ?></th>
					<th><?php echo $label[3]; ?></th>
				</tr>
			</thead>
			
			<?php       
			// Check if monthly return array present
			// If exits, highlight modified data in annual as compare to monthly

			$romCat = array('open', 'prod', 'clos');
			$romStock = array('_oc_rom', '_ug_rom', '_dw_rom');
			for ($i = 0; $i < 3; $i++) {

				$diff[$romCat[$i].$romStock[0]]['class'] = '';
				$diff[$romCat[$i].$romStock[0]]['title'] = '';
				$diff[$romCat[$i].$romStock[1]]['class'] = '';
				$diff[$romCat[$i].$romStock[1]]['title'] = '';
				$diff[$romCat[$i].$romStock[2]]['class'] = '';
				$diff[$romCat[$i].$romStock[2]]['title'] = '';
					
				if (isset($prodArrMonthly)) {

					// open stock
					$openStockOld = $prodArrMonthly[$romCat[$i].$romStock[0]];
					$openStockNew = $prodArr[$romCat[$i].$romStock[0]];
					if ($openStockOld != $openStockNew) {
						$openStockDiff = $openStockNew - $openStockOld;
						$diff[$romCat[$i].$romStock[0]]['title'] = ($openStockDiff > 0) ? '+'.$openStockDiff : $openStockDiff;
						$diff[$romCat[$i].$romStock[0]]['class'] = ' in_new';
					}
					
					// production
					$prodOld = $prodArrMonthly[$romCat[$i].$romStock[1]];
					$prodNew = $prodArr[$romCat[$i].$romStock[1]];
					if ($prodOld != $prodNew) {
						$prodDiff = $prodNew - $prodOld;
						$diff[$romCat[$i].$romStock[1]]['title'] = ($prodDiff > 0) ? '+'.$prodDiff : $prodDiff;
						$diff[$romCat[$i].$romStock[1]]['class'] = ' in_new';
					}
					
					// close stock
					$closStockOld = $prodArrMonthly[$romCat[$i].$romStock[2]];
					$closStockNew = $prodArr[$romCat[$i].$romStock[2]];
					if ($closStockOld != $closStockNew) {
						$closStockDiff = $closStockNew - $closStockOld;
						$diff[$romCat[$i].$romStock[2]]['title'] = ($closStockDiff > 0) ? '+'.$closStockDiff : $closStockDiff;
						$diff[$romCat[$i].$romStock[2]]['class'] = ' in_new';
					}

				}

			}

			?>
			<tbody>
				<tr>
					<td><?php echo $label[4]; ?></td>
					<td>
						<?php echo $this->Form->control('f_open_oc_rom', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['open_oc_rom']['class'], 'id'=>'f_open_oc_rom', 'label'=>false, 'title'=>$diff['open_oc_rom']['title'], 'value'=>$prodArr['open_oc_rom'], 'maxlength'=>'16')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_prod_oc_rom', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['prod_oc_rom']['class'], 'id'=>'f_prod_oc_rom', 'label'=>false, 'title'=>$diff['prod_oc_rom']['title'], 'value'=>$prodArr['prod_oc_rom'], 'maxlength'=>'16')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_clos_oc_rom', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['clos_oc_rom']['class'], 'id'=>'f_clos_oc_rom', 'label'=>false, 'title'=>$diff['clos_oc_rom']['title'], 'value'=>$prodArr['clos_oc_rom'], 'maxlength'=>'16')); ?>
						<div class="err_cv"></div>
					</td>
				</tr>
				<tr>
					<td><?php echo $label[5]; ?></td>
					<td>
						<?php echo $this->Form->control('f_open_ug_rom', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['open_ug_rom']['class'], 'id'=>'f_open_ug_rom', 'label'=>false, 'title'=>$diff['open_ug_rom']['title'], 'value'=>$prodArr['open_ug_rom'], 'maxlength'=>'16')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_prod_ug_rom', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['prod_ug_rom']['class'], 'id'=>'f_prod_ug_rom', 'label'=>false, 'title'=>$diff['prod_ug_rom']['title'], 'value'=>$prodArr['prod_ug_rom'], 'maxlength'=>'16')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_clos_ug_rom', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['clos_ug_rom']['class'], 'id'=>'f_clos_ug_rom', 'label'=>false, 'title'=>$diff['clos_ug_rom']['title'], 'value'=>$prodArr['clos_ug_rom'], 'maxlength'=>'16')); ?>
						<div class="err_cv"></div>
					</td>
				</tr>
				<tr>
					<td><?php echo $label[6]; ?></td>
					<td>
						<?php echo $this->Form->control('f_open_dw_rom', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['open_dw_rom']['class'], 'id'=>'f_open_dw_rom', 'label'=>false, 'title'=>$diff['open_dw_rom']['title'], 'value'=>$prodArr['open_dw_rom'], 'maxlength'=>'16')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_prod_dw_rom', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['prod_dw_rom']['class'], 'id'=>'f_prod_dw_rom', 'label'=>false, 'title'=>$diff['prod_dw_rom']['title'], 'value'=>$prodArr['prod_dw_rom'], 'maxlength'=>'16')); ?>
						<div class="err_cv"></div>
					</td>
					<td>
						<?php echo $this->Form->control('f_clos_dw_rom', array('class'=>'form-control form-control-sm cvOn cvReq cvNum cvMaxLen'.$diff['clos_dw_rom']['class'], 'id'=>'f_clos_dw_rom', 'label'=>false, 'title'=>$diff['clos_dw_rom']['title'], 'value'=>$prodArr['clos_dw_rom'], 'maxlength'=>'16')); ?>
						<div class="err_cv"></div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="col-sm-8 mine-m-auto">
		<table class="table table-bordered">
			<thead class="bg-light text-center">
				<tr>
					<th><?php echo $label[7]; ?></th>
					<th><?php echo $label[8]; ?></th>
					<th><?php echo $label[9]; ?></th>
				</tr>
			</thead>
			<tbody class="text-center">
				<tr>
					<td><?php echo $estProd; ?></td>
					<td><?php echo $cumProd; ?></td>
					<td><?php echo ($estProd - $cumProd); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'f_open_oc_rom_old', 'value'=>$prodArr['open_oc_rom'])); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'f_open_ug_rom_old', 'value'=>$prodArr['open_ug_rom'])); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'f_open_dw_rom_old', 'value'=>$prodArr['open_dw_rom'])); ?>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'id'=>'mine_code', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'id'=>'mineral_name', 'value'=>$mineralName)); ?>
<?php echo $this->Form->control('iron_sub_min', array('type'=>'hidden', 'id'=>'iron_sub_min', 'value'=>$ironSubMin)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'estimated_prod', 'value'=>$estProd)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'cum_prod', 'value'=>$cumProd)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'value'=>'frmRomStocks')); ?>
<?php echo $this->Form->control('', array('type'=>'hidden', 'id'=>'rom_prev_clos_stock_url', 'value'=>$this->Url->build(['controller'=>'monthly', 'action'=>'getRomPrevClosingStocks']))); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'prev_month', 'value'=>$prev_month)); ?>

<?php echo $this->Html->script('f/rom_stocks'); ?>
