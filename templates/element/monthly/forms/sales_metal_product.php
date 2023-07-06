
<?php 

// Highlight fields which are differs from cumulative monthly data in annual
// (Only for Form G2 in MMS side)
// Effective from Phase-II
// Added on 24th Nov 2021 by Aniket Ganvir

$row_old_main = (isset($salesDataMonthAll)) ? $salesDataMonthAll : array();

foreach ($salesData as $key=>$val) {

	if ($val['table_name'] == 'open_stock') {
		
		$keys['sale_place'] = $key + 1;
		$keys['prod_sold'] = $key + 2;
		$keys['close_stock'] = $key + 3;
		
		$diff[$key]['open_tot_qty']['title'] = '';
		$diff[$key]['open_tot_qty']['class'] = '';
		$diff[$key]['open_metal']['title'] = '';
		$diff[$key]['open_metal']['class'] = '';
		$diff[$key]['open_grade']['title'] = '';
		$diff[$key]['open_grade']['class'] = '';
		$diff[$keys['sale_place']]['sale_place']['title'] = '';
		$diff[$keys['sale_place']]['sale_place']['class'] = '';
		$diff[$keys['prod_sold']]['prod_tot_qty']['title'] = '';
		$diff[$keys['prod_sold']]['prod_tot_qty']['class'] = '';
		$diff[$keys['prod_sold']]['prod_grade']['title'] = '';
		$diff[$keys['prod_sold']]['prod_grade']['class'] = '';
		$diff[$keys['prod_sold']]['prod_product_value']['title'] = '';
		$diff[$keys['prod_sold']]['prod_product_value']['class'] = '';
		$diff[$keys['close_stock']]['close_tot_qty']['title'] = '';
		$diff[$keys['close_stock']]['close_tot_qty']['class'] = '';
		$diff[$keys['close_stock']]['close_product_value']['title'] = '';
		$diff[$keys['close_stock']]['close_product_value']['class'] = '';
		
		if (isset($salesDataMonthAll)) {

			$salesDataOld = $salesDataMonthAll;
			$metal = $val['open_metal'];
			$metalId = array_search($metal, array_column($salesDataOld, 'open_metal'));
			
			if ($metalId != '') {

				// open_stock
				if ($salesDataOld[$metalId]['open_tot_qty'] != $val['open_tot_qty']) {
					$openTotQtyDiff = $val['open_tot_qty'] - $salesDataOld[$metalId]['open_tot_qty'];
					$diff[$key]['open_tot_qty']['title'] = ($openTotQtyDiff > 0) ? '+'.$openTotQtyDiff : $openTotQtyDiff;
					$diff[$key]['open_tot_qty']['class'] = ' in_new';
				}
				
				if ($salesDataOld[$metalId]['open_grade'] != $val['open_grade']) {
					$openGradeDiff = $val['open_grade'] - $salesDataOld[$metalId]['open_grade'];
					$diff[$key]['open_grade']['title'] = ($openGradeDiff > 0) ? '+'.$openGradeDiff : $openGradeDiff;
					$diff[$key]['open_grade']['class'] = ' in_new';
				}

				// sale_place
				$mtlId['sale_place'] = $metalId + 1;
				if ($salesDataOld[$mtlId['sale_place']]['sale_place'] != $salesData[$keys['sale_place']]['sale_place']) {
					$openTotQtyDiff = $salesData[$keys['sale_place']]['sale_place'] - $salesDataOld[$mtlId['sale_place']]['sale_place'];
					$diff[$keys['sale_place']]['sale_place']['title'] = ($openTotQtyDiff > 0) ? '+'.$openTotQtyDiff : $openTotQtyDiff;
					$diff[$keys['sale_place']]['sale_place']['class'] = ' in_new';
				}
				
				// prod_sold
				$mtlId['prod_sold'] = $metalId + 2;
				if ($salesDataOld[$mtlId['prod_sold']]['prod_tot_qty'] != $salesData[$keys['prod_sold']]['prod_tot_qty']) {
					$prodTotQtyDiff = $salesData[$keys['prod_sold']]['prod_tot_qty'] - $salesDataOld[$mtlId['prod_sold']]['prod_tot_qty'];
					$diff[$keys['prod_sold']]['prod_tot_qty']['title'] = ($prodTotQtyDiff > 0) ? '+'.$prodTotQtyDiff : $prodTotQtyDiff;
					$diff[$keys['prod_sold']]['prod_tot_qty']['class'] = ' in_new';
				}
				
				if ($salesDataOld[$mtlId['prod_sold']]['prod_grade'] != $salesData[$keys['prod_sold']]['prod_grade']) {
					$prodGradeDiff = $salesData[$keys['prod_sold']]['prod_grade'] - $salesDataOld[$mtlId['prod_sold']]['prod_grade'];
					$diff[$keys['prod_sold']]['prod_grade']['title'] = ($prodGradeDiff > 0) ? '+'.$prodGradeDiff : $prodGradeDiff;
					$diff[$keys['prod_sold']]['prod_grade']['class'] = ' in_new';
				}
				
				if ($salesDataOld[$mtlId['prod_sold']]['prod_product_value'] != $salesData[$keys['prod_sold']]['prod_product_value']) {
					$prodProdValDiff = $salesData[$keys['prod_sold']]['prod_product_value'] - $salesDataOld[$mtlId['prod_sold']]['prod_product_value'];
					$diff[$keys['prod_sold']]['prod_product_value']['title'] = ($prodProdValDiff > 0) ? '+'.$prodProdValDiff : $prodProdValDiff;
					$diff[$keys['prod_sold']]['prod_product_value']['class'] = ' in_new';
				}
				
				// close_stock
				$mtlId['close_stock'] = $metalId + 3;
				if ($salesDataOld[$mtlId['close_stock']]['close_tot_qty'] != $salesData[$keys['close_stock']]['close_tot_qty']) {
					$closTotQtyDiff = $salesData[$keys['close_stock']]['close_tot_qty'] - $salesDataOld[$mtlId['close_stock']]['close_tot_qty'];
					$diff[$keys['close_stock']]['close_tot_qty']['title'] = ($closTotQtyDiff > 0) ? '+'.$closTotQtyDiff : $closTotQtyDiff;
					$diff[$keys['close_stock']]['close_tot_qty']['class'] = ' in_new';
				}
				
				if ($salesDataOld[$mtlId['close_stock']]['close_product_value'] != $salesData[$keys['close_stock']]['close_product_value']) {
					$closProdValDiff = $salesData[$keys['close_stock']]['close_product_value'] - $salesDataOld[$mtlId['close_stock']]['close_product_value'];
					$diff[$keys['close_stock']]['close_product_value']['title'] = ($closProdValDiff > 0) ? '+'.$closProdValDiff : $closProdValDiff;
					$diff[$keys['close_stock']]['close_product_value']['class'] = ' in_new';
				}
				
				unset($row_old_main[$metalId]);
				unset($row_old_main[$mtlId['sale_place']]);
				unset($row_old_main[$mtlId['prod_sold']]);
				unset($row_old_main[$mtlId['close_stock']]);

			} else {

				$diff[$key]['open_tot_qty']['title'] = 'New record';
				$diff[$key]['open_tot_qty']['class'] = ' in_new';
				$diff[$key]['open_metal']['title'] = 'New record';
				$diff[$key]['open_metal']['class'] = ' in_new';
				$diff[$key]['open_grade']['title'] = 'New record';
				$diff[$key]['open_grade']['class'] = ' in_new';
				$diff[$keys['sale_place']]['sale_place']['title'] = 'New record';
				$diff[$keys['sale_place']]['sale_place']['class'] = ' in_new';
				$diff[$keys['prod_sold']]['prod_tot_qty']['title'] = 'New record';
				$diff[$keys['prod_sold']]['prod_tot_qty']['class'] = ' in_new';
				$diff[$keys['prod_sold']]['prod_grade']['title'] = 'New record';
				$diff[$keys['prod_sold']]['prod_grade']['class'] = ' in_new';
				$diff[$keys['prod_sold']]['prod_product_value']['title'] = 'New record';
				$diff[$keys['prod_sold']]['prod_product_value']['class'] = ' in_new';
				$diff[$keys['close_stock']]['close_tot_qty']['title'] = 'New record';
				$diff[$keys['close_stock']]['close_tot_qty']['class'] = ' in_new';
				$diff[$keys['close_stock']]['close_product_value']['title'] = 'New record';
				$diff[$keys['close_stock']]['close_product_value']['class'] = ' in_new';

			}

		}

	}

}

?>

<h5 class="card-title"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">
	<div class="col-sm-12 mine-m-auto">
		<table class="table table-bordered recovery-table" id="sales_data_table">
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th rowspan="2"><?php echo $label[4]; ?></th>
					<th colspan="2"><?php echo $label[0]; ?></th>
					<th rowspan="2"><?php echo $label[1]; ?></th>
					<th colspan="3"><?php echo $label[2]; ?></th>
					<th colspan="3"><?php echo $label[3]; ?></th>
				</tr>
				<tr>
					<th><?php echo $label[5]; ?></th>
					<th><?php echo $label[6]; ?></th>
					<th><?php echo $label[5]; ?></th>
					<th><?php echo $label[6]; ?></th>
					<th><?php echo $label[7]; ?></th>
					<th><?php echo $label[5]; ?></th>
					<th colspan="2"><?php echo $label[6]; ?></th>
				</tr>
			</thead>
			<tbody class="t-body">
				<?php 

				$rowC = 1;
				foreach($salesData as $key=>$val){ 
					$keyN = $key+1;

				?>
					<?php if($val['table_name'] == 'open_stock'){ $rowC = ($key != 0) ? $rowC+1 : $rowC;  ?>
					<tr>
						<td>
							<div>
								<?php echo $this->Form->select('open_stock_metal_'.$rowC, $products, array('empty'=>'- Select -','class'=>'form-control open_stock_metal_box cvOn cvReq'.$diff[$key]['open_metal']['class'], 'title'=>$diff[$key]['open_metal']['title'], 'value'=>$val['open_metal'], 'id'=>'open_stock_metal_'.$rowC)); ?>
							</div>	
							<div class="err_cv"></div>
							<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'prev_open_stock_metal_'.$rowC, 'value'=>$val['open_metal']]); ?>
						</td>
						<td>
							<?php echo $this->Form->control('open_stock_qty_'.$rowC, array('type'=>'text', 'class'=>'form-control open_stock_qty sales-quantity-txtbox makeNil cvOn cvReq cvNum cvMaxLen cvFloat'.$diff[$key]['open_tot_qty']['class'], 'id'=>'open_stock_qty_'.$rowC, 'title'=>$diff[$key]['open_tot_qty']['title'], 'value'=>$val['open_tot_qty'], 'label'=>false, 'maxLength'=>16, 'cvfloat'=>999999999999.999)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('open_stock_grade_'.$rowC, array('type'=>'text', 'class'=>'form-control open_stock_grade sales-grade-txtbox makeNil cvOn cvNum cvReq'.$diff[$key]['open_grade']['class'], 'id'=>'open_stock_grade_'.$rowC, 'title'=>$diff[$key]['open_grade']['title'], 'value'=>$val['open_grade'], 'label'=>false)); ?>
							<div class="err_cv"></div>
						</td>

					<?php } if($val['table_name'] == 'sale_place') { ?>

						<td>
							<?php echo $this->Form->control('sale_place_value_'.$rowC, array('type'=>'text', 'class'=>'form-control sale_place_value sales-value-txtbox makeNil cvOn cvReq'.$diff[$key]['sale_place']['class'], 'id'=>'sale_place_value_'.$rowC, 'title'=>$diff[$key]['sale_place']['title'], 'value'=>$val['sale_place'], 'label'=>false)); ?>
							<div class="err_cv"></div>
						</td>

					<?php } if($val['table_name'] == 'prod_sold') { ?>

						<td>
							<?php echo $this->Form->control('prod_sold_qty_'.$rowC, array('type'=>'text', 'class'=>'form-control prod_sold_qty sales-quantity-txtbox makeNil cvOn cvReq cvNum cvFloat'.$diff[$key]['prod_tot_qty']['class'], 'id'=>'prod_sold_qty_'.$rowC, 'title'=>$diff[$key]['prod_tot_qty']['title'], 'value'=>$val['prod_tot_qty'], 'label'=>false, 'cvfloat'=>999999999999.999)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('prod_sold_grade_'.$rowC, array('type'=>'text', 'class'=>'form-control prod_sold_grade sales-grade-txtbox makeNil cvOn cvNum cvReq'.$diff[$key]['prod_grade']['class'], 'id'=>'prod_sold_grade_'.$rowC, 'title'=>$diff[$key]['prod_grade']['title'], 'value'=>$val['prod_grade'], 'label'=>false)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('prod_sold_value_'.$rowC, array('type'=>'text', 'class'=>'form-control prod_sold_value sales-value-txtbox makeNil cvOn cvNum cvReq'.$diff[$key]['prod_product_value']['class'], 'id'=>'prod_sold_value_'.$rowC, 'title'=>$diff[$key]['prod_product_value']['title'], 'value'=>$val['prod_product_value'], 'label'=>false)); ?>
							<div class="err_cv"></div>
						</td>

					<?php } if($val['table_name'] == 'close_stock') { ?>

						<td>
							<?php echo $this->Form->control('close_stock_qty_'.$rowC, array('type'=>'text', 'class'=>'form-control close_stock_qty sales-quantity-txtbox makeNil cvOn cvReq cvNum cvMaxLen cvFloat'.$diff[$key]['close_tot_qty']['class'], 'id'=>'close_stock_qty_'.$rowC, 'title'=>$diff[$key]['close_tot_qty']['title'], 'value'=>$val['close_tot_qty'], 'label'=>false, 'maxLength'=>16, 'cvfloat'=>999999999999.999)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('close_stock_grade_'.$rowC, array('type'=>'text', 'class'=>'form-control close_stock_grade sales-grade-txtbox makeNil cvOn cvNum cvNotReq'.$diff[$key]['close_product_value']['class'], 'id'=>'close_stock_grade_'.$rowC, 'title'=>$diff[$key]['close_product_value']['title'], 'value'=>$val['close_product_value'], 'label'=>false)); ?>
						</td>
						<td></td>
					</tr>

					<?php } ?>
				<?php } ?>
				
				<?php 
				// This extra loop is only for showing deleted records in the annual return
				// as compares to monthly return
				// Effective from Phase-II
				// Added on 24th Nov 2021 by Aniket Ganvir

				foreach($row_old_main as $key=>$val){ 
					$keyN = $key+1;

				?>
					<?php if($val['table_name'] == 'open_stock'){ $rowC = ($key != 0) ? $rowC+1 : $rowC;  ?>
					<tr>
						<td>
							<div>
								<?php echo $this->Form->select('open_stock_metal_'.$rowC, $products, array('empty'=>'- Select -','class'=>'form-control open_stock_metal_box cvOn cvReq in_old', 'title'=>'Removed record', 'value'=>$val['open_metal'], 'id'=>'open_stock_metal_'.$rowC)); ?>
							</div>	
							<div class="err_cv"></div>
							<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'prev_open_stock_metal_'.$rowC, 'value'=>$val['open_metal']]); ?>
						</td>
						<td>
							<?php echo $this->Form->control('open_stock_qty_'.$rowC, array('type'=>'text', 'class'=>'form-control open_stock_qty sales-quantity-txtbox makeNil cvOn cvReq cvNum cvMaxLen cvFloat in_old', 'id'=>'open_stock_qty_'.$rowC, 'title'=>'Removed record', 'value'=>$val['open_tot_qty'], 'label'=>false, 'maxLength'=>16, 'cvfloat'=>999999999999.999)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('open_stock_grade_'.$rowC, array('type'=>'text', 'class'=>'form-control open_stock_grade sales-grade-txtbox makeNil cvOn cvNum cvReq in_old', 'id'=>'open_stock_grade_'.$rowC, 'title'=>'Removed record', 'value'=>$val['open_grade'], 'label'=>false)); ?>
							<div class="err_cv"></div>
						</td>

					<?php } if($val['table_name'] == 'sale_place') { ?>

						<td>
							<?php echo $this->Form->control('sale_place_value_'.$rowC, array('type'=>'text', 'class'=>'form-control sale_place_value sales-value-txtbox makeNil cvOn cvReq in_old', 'id'=>'sale_place_value_'.$rowC, 'title'=>'Removed record', 'value'=>$val['sale_place'], 'label'=>false)); ?>
							<div class="err_cv"></div>
						</td>

					<?php } if($val['table_name'] == 'prod_sold') { ?>

						<td>
							<?php echo $this->Form->control('prod_sold_qty_'.$rowC, array('type'=>'text', 'class'=>'form-control prod_sold_qty sales-quantity-txtbox makeNil cvOn cvReq cvNum cvFloat in_old', 'id'=>'prod_sold_qty_'.$rowC, 'title'=>'Removed record', 'value'=>$val['prod_tot_qty'], 'label'=>false, 'cvfloat'=>999999999999.999)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('prod_sold_grade_'.$rowC, array('type'=>'text', 'class'=>'form-control prod_sold_grade sales-grade-txtbox makeNil cvOn cvNum cvReq in_old', 'id'=>'prod_sold_grade_'.$rowC, 'title'=>'Removed record', 'value'=>$val['prod_grade'], 'label'=>false)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('prod_sold_value_'.$rowC, array('type'=>'text', 'class'=>'form-control prod_sold_value sales-value-txtbox makeNil cvOn cvNum cvReq in_old', 'id'=>'prod_sold_value_'.$rowC, 'title'=>'Removed record', 'value'=>$val['prod_product_value'], 'label'=>false)); ?>
							<div class="err_cv"></div>
						</td>

					<?php } if($val['table_name'] == 'close_stock') { ?>

						<td>
							<?php echo $this->Form->control('close_stock_qty_'.$rowC, array('type'=>'text', 'class'=>'form-control close_stock_qty sales-quantity-txtbox makeNil cvOn cvReq cvNum cvMaxLen cvFloat in_old', 'id'=>'close_stock_qty_'.$rowC, 'title'=>'Removed record', 'value'=>$val['close_tot_qty'], 'label'=>false, 'maxLength'=>16, 'cvfloat'=>999999999999.999)); ?>
							<div class="err_cv"></div>
						</td>
						<td>
							<?php echo $this->Form->control('close_stock_grade_'.$rowC, array('type'=>'text', 'class'=>'form-control close_stock_grade sales-grade-txtbox makeNil cvOn cvNum cvNotReq in_old', 'id'=>'close_stock_grade_'.$rowC, 'title'=>'Removed record', 'value'=>$val['close_product_value'], 'label'=>false)); ?>
						</td>
						<td></td>
					</tr>

					<?php } ?>
				<?php } ?>

			</tbody>
			<thead>
				<tr>
					<td colspan="14">
						<?php echo $this->Form->button('<i class="fa fa-plus"></i> '.$label['btn'], array('type'=>'button', 'id'=>'sales_metal_product_add_btn', 'class'=>'btn btn-sm btn-info f5-add-more-btn form_btn_edit', 'escapeTitle'=>false)); ?>
					</td>
				<tr>
			</thead>
		</table>

		<div class="alert alert-info p-2 pl-3">
			<table>
				<tbody>
					<tr>
						<td><?php echo $label['note_txt']; ?></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><?php echo $label['note_1']; ?></td>
					</tr>
					<tr>
						<td></td>
						<td><?php echo $label['note_2']; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php echo $this->Form->control('form_no', array('type'=>'hidden', 'value'=>$formId)); ?>
<?php echo $this->Form->control('mine_code', array('type'=>'hidden', 'value'=>$mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('return_date', array('type'=>'hidden', 'value'=>$returnDate)); ?>
<?php echo $this->Form->control('mineral_name', array('type'=>'hidden', 'value'=>$mineral)); ?>

<?php echo $this->Form->control('month_sale_count', array('type'=>'hidden', 'id'=>'month_sale_count')); ?>
<?php echo $this->Form->control('metals_recovered', array('type'=>'hidden', 'id'=>'metals_recovered', 'value'=>json_encode($recoveryData))); ?>
<?php echo $this->Form->control('error-flag', array('type'=>'hidden', 'id'=>'error-flag', 'class'=>'error-flag', 'value'=>'0')); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'value'=>'frmSalesF5')); ?>

<?php echo $this->Form->control('', ['type'=>'hidden', 'id'=>'open_stock_metal_row', 'value'=>$this->Form->select("open_stock_metal_rowcc", $products, array("empty"=>"- Select -","class"=>"form-control open_stock_metal_box cvOn cvReq", "id"=>"open_stock_metal_rowcc"))]); ?>

<?php echo $this->Html->script('f/sales_metal_product.js?version='.$version); ?>
