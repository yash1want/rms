
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">

	<div class="col-sm-12 mine-m-auto">
		<table class="table table-bordered table-sm v_a_mid_th" id="source_of_supply_table">
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th rowspan="3"><?php echo $label[1]; ?></th>
					<th rowspan="3"><?php echo $label[2]; ?></th>
					<th colspan="8"><?php echo $label[3]; ?></th>
					<th colspan="4"><?php echo $label[4]; ?></th>
                    <th rowspan="3"></th>
				</tr>
				<tr>
					<th rowspan="2"><?php echo $label[5]; ?></th>
					<th colspan="2"><?php echo $label[6]; ?></th>
					<th rowspan="2"><?php echo $label[7]; ?></th>
					<th colspan="2"><?php echo $label[8]; ?></th>
					<th rowspan="2"><?php echo $label[9]; ?></th>
					<th rowspan="2"><?php echo $label[10]; ?></th>
					<th colspan="2"><?php echo $label[11]; ?></th>
					<th rowspan="2"><?php echo $label[12]; ?></th>
					<th rowspan="2"><?php echo $label[13]; ?></th>
				</tr>
				<tr>
					<th><?php echo $label[14]; ?></th>
					<th><?php echo $label[15]; ?></th>
					<th><?php echo $label[16]; ?></th>
					<th><?php echo $label[17]; ?></th>
					<th><?php echo $label[18]; ?></th>
					<th><?php echo $label[19]; ?></th>
				</tr>
            </thead>
            <tbody>
                <?php
                $totalCount = $sourceData['totalCount'];
                for ($i = 1; $i <= $totalCount; $i++) { ?>
                    <tr id="trow-<?php echo $i; ?>">
                        <td>
                            <?php echo $this->Form->select('sour_indus_'.$i, array('indigenous'=>'Indigenous', 'imported'=>'Imported'), array('class'=>'form-control form-control-sm m_w_70 MakeRequired fillNil sourceType', 'id'=>'sour_indus_'.$i, 'empty'=>'--Select---', 'label'=>false, 'value'=>$sourceData['sour_indus_'.$i])); ?>
                        </td>
                        <td>
                            <div class="input-group">
                                <?php echo $this->Form->select('sour_mineral_'.$i, $minBasedOnRaw, array('class'=>'form-control form-control-sm MakeRequired makeNilDD putUnit col-sm-11 d-inline-block', 'id'=>'sour_mineral_'.$i, 'empty'=>'--Select---', 'label'=>false, 'value'=>$sourceData['sour_mineral_'.$i], 'templates'=>array('inputContainer'=>'{{content}}'))); ?>
                                <div class="input-group-append">
                                    <div class="input-group-text form-control-sm m_w_70" id="unitSpan_trow-<?php echo $i; ?>"><?php echo $sourceData['mineral_unit_'.$i]; ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php echo $this->Form->control('sour_name_add_'.$i, array('type'=>'text', 'class'=>'form-control form-control-sm m_w_70 MakeRequired makeNilChar indigenous indigenous_'.$i.' text-fields address', 'id'=>'sour_name_add_'.$i, 'label'=>false, 'value'=>$sourceData['sour_name_add_'.$i])); ?>
                        </td>
                        <td>
                            <?php echo $this->Form->control('sour_mine_area_'.$i, array('type'=>'text', 'class'=>'form-control form-control-sm m_w_70 MakeRequired nameOne makeNilChar indigenous mineCode indigenous_'.$i.' text-fields address ui-autocomplete-input', 'id'=>'sour_mine_area_'.$i, 'label'=>false, 'value'=>$sourceData['sour_mine_area_'.$i])); ?>
                                <div id="suggestion_box_<?= $i;?>" class="sugg-box autocomp"></div>
                
                        </td>
                        <td>
                            <?php echo $this->Form->select('sour_mine_area_dist_'.$i, $districts, array('class'=>'form-control form-control-sm m_w_70 MakeRequired makeNilDD indigenous indigenous_'.$i, 'id'=>'sour_mine_area_dist_'.$i, 'label'=>false, 'value'=>$sourceData['sour_mine_area_dist_'.$i])); ?>
                        </td>
                        <td>
                            <?php echo $this->Form->control('sour_ind_dis_'.$i, array('type'=>'text', 'class'=>'form-control form-control-sm m_w_70 MakeRequired makeNilInt right indigenous indigenous_'.$i.' text-fields distance', 'id'=>'sour_ind_dis_'.$i, 'label'=>false, 'value'=>$sourceData['sour_ind_dis_'.$i])); ?>
                        </td>
                        <td>
                            <?php echo $this->Form->select('sour_tran_mode_'.$i, $modeOption, array('class'=>'form-control form-control-sm m_w_70 MakeRequired makeNilDD indigenous indigenous_'.$i, 'empty'=>'--Select---', 'id'=>'sour_tran_mode_'.$i, 'label'=>false, 'value'=>$sourceData['sour_tran_mode_'.$i])); ?>
                        </td>
                        <td>
                            <?php echo $this->Form->control('sour_tran_cost_'.$i, array('type'=>'text', 'class'=>'form-control form-control-sm m_w_70 MakeRequired makeNilInt right indigenous indigenous_'.$i.' cost', 'id'=>'sour_tran_cost_'.$i, 'label'=>false, 'value'=>$sourceData['sour_tran_cost_'.$i])); ?>
                        </td>
                        <td>
                            <?php echo $this->Form->control('sour_qty_'.$i, array('type'=>'text', 'class'=>'form-control form-control-sm m_w_70 MakeRequired makeNilInt right indigenous indigenous_'.$i.' qty', 'id'=>'sour_qty_'.$i, 'label'=>false, 'value'=>$sourceData['sour_qty_'.$i])); ?>
                        </td>
                        <td>
                            <?php echo $this->Form->control('sour_price_'.$i, array('type'=>'text', 'class'=>'form-control form-control-sm m_w_70 MakeRequired makeNilInt right indigenous indigenous_'.$i.' price', 'id'=>'sour_price_'.$i, 'label'=>false, 'value'=>$sourceData['sour_price_'.$i])); ?>
                        </td>
                        <td>
                            <?php echo $this->Form->control('sour_supplier_add_'.$i, array('type'=>'text', 'class'=>'form-control form-control-sm m_w_70 MakeRequired makeNilChar imported imported_'.$i.' text-fields address', 'id'=>'sour_supplier_add_'.$i, 'label'=>false, 'value'=>$sourceData['sour_supplier_add_'.$i])); ?>
                        </td>
                        <td>
                            <?php echo $this->Form->select('sour_supplier_country_'.$i, $countryOption, array('class'=>'form-control form-control-sm m_w_70 MakeRequired makeNilDD imported imported_'.$i, 'empty'=>'--Select---', 'id'=>'sour_supplier_country_'.$i, 'label'=>false, 'value'=>$sourceData['sour_supplier_country_'.$i])); ?>
                        </td>
                        <td>
                            <?php echo $this->Form->control('sour_qty_purch_'.$i, array('type'=>'text', 'class'=>'form-control form-control-sm m_w_70 MakeRequired makeNilInt right imported imported_'.$i.' qty', 'id'=>'sour_qty_purch_'.$i, 'label'=>false, 'value'=>$sourceData['sour_qty_purch_'.$i])); ?>
                        </td>
                        <td>
                            <?php echo $this->Form->control('sour_cost_metric_'.$i, array('type'=>'text', 'class'=>'form-control form-control-sm m_w_70 MakeRequired makeNilInt right imported imported_'.$i.' price', 'id'=>'sour_cost_metric_'.$i, 'label'=>false, 'value'=>$sourceData['sour_cost_metric_'.$i])); ?>
                        </td>
                        <td class="remove_btn">
                            <button type="button" class="btn btn-sm ss_remove_btn_btn" disabled="true"><i class="fa fa-times"></i></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="15">
                        <button type="button" class="btn btn-sm btn-info" id="ss_add_more_btn"><i class="fa fa-plus"></i> Add more</button>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class="alert alert-info p-2 pl-3"><?php echo $label[21]; ?></div>
    </div>

</div>

<?php 

    echo $this->Form->control('uType', ['type'=>'hidden', 'id'=>'uType', 'value'=>$userType]);
    echo $this->Form->control('fType', ['type'=>'hidden', 'id'=>'fType', 'value'=>$formType]);
    echo $this->Form->control('return_date', ['type'=>'hidden', 'id'=>'return_date', 'value'=>$returnDate]);
    echo $this->Form->control('return_type', ['type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType]);
    echo $this->Form->control('end_user_id', ['type'=>'hidden', 'value'=>$endUserId]);
    echo $this->Form->control('user_type', ['type'=>'hidden', 'value'=>$userType]);
    echo $this->Form->control('section_no', ['type'=>'hidden','id'=>'section_no','value'=>$section_no]);
    echo $this->Form->control('', ['type'=>'hidden', 'id'=>'form_id_name', 'value'=>'sourceOfSupply']);

    echo $this->Form->control('', ['type'=>'hidden', 'id'=>'get_raw_meterial_metals_unit', 'value'=>$this->Url->build(['controller'=>'Ajax', 'action'=>'getRawMaterialMetalsUnit'])]);
    echo $this->Form->control('source_of_supply_count', ['type'=>'hidden', 'id'=>'source_of_supply_count', 'value'=>'1']);

     echo $this->Form->control('mine_code_url', array('type'=>'hidden', 'id'=>'mine_code_url', 'value'=>$this->Url->build(['controller'=>'enduser', 'action'=>'get_mine_code'])));

    echo $this->Html->script('m/source_of_supply.js?version='.$version);

?>
