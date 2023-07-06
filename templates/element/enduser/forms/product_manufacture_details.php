
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<h5 class="card-title text-center text-primary f_s_13"><?php echo $label[0]; ?></h5>
<div class="position-relative row form-group mine-group">

	<div class="col-sm-12 mine-m-auto">
		<table class="table table-bordered table-sm">
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th rowspan="2" class="v_a_mid w_24_p"><?php echo $label[1]; ?></th>
					<th rowspan="2" class="v_a_mid w_23_5_p"><?php echo $label[2]; ?></th>
					<th colspan="2" class=""><?php echo $label[3]; ?></th>
				</tr>
				<tr>
					<th class="w_23_6_p"><?php echo $label[4]; ?></th>
					<th><?php echo $label[5]; ?></th>
				</tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">(1)</td>
                    <td class="text-center">(2)</td>
                    <td class="text-center">(3)</td>
                    <td class="text-center">(4)</td>
                </tr>
                <tr>
                    <td colspan="4"><?php echo $label[6]; ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="table-format">
                            <div id="table_container_1"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><?php echo $label[7]; ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="table-format">
                            <div id="table_container_2"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><?php echo $label[8]; ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="table-format">
                            <div id="table_container_3"></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
	<div class="col-sm-12 mine-m-auto">
        <table class="table table-bordered table-sm">
            <tbody>
                <tr>
                    <td colspan="2" class="v_a_base"><?php echo $label[9]; ?></td>
                    <td class="w-75">
                        <?php echo $this->Form->textarea('expansion_under', array('class'=>'form-control form-control-sm text-area expansion1', 'id'=>'expansion_under', 'label'=>false, 'rows'=>3, 'maxLength'=>'500', 'value'=>$mineralData['expansion_under'])); ?>
                    </td>
                </tr>
                <tr>
                    <td class="v_a_base b_r_0">(iv)</td>
                    <td class="v_a_base"><?php echo $label[10]; ?></td>
                    <td>
                        <?php echo $this->Form->textarea('expansion_program', array('class'=>'form-control form-control-sm text-area expansion1', 'id'=>'expansion_program', 'label'=>false, 'rows'=>3, 'maxLength'=>'500', 'value'=>$mineralData['expansion_program'])); ?>
                    </td>
                </tr>
                <tr>
                    <td class="v_a_base b_r_0">(v)</td>
                    <td class="v_a_base"><?php echo $label[11]; ?></td>
                    <td>
                        <?php echo $this->Form->textarea('research_develop', array('class'=>'form-control form-control-sm text-area expansion1', 'id'=>'research_develop', 'label'=>false, 'rows'=>3, 'maxLength'=>'500', 'value'=>$mineralData['research_develop'])); ?>
                    </td>
                </tr>
            </tbody>
        </table>
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
    echo $this->Form->control('', ['type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'productManufactureDetails']); 

    echo $this->Form->control('reason_count', ['type'=>'hidden','id'=>'reason_count']);

    echo $this->Html->script('m/product_manufacture_details.js?version='.$version);

?>
