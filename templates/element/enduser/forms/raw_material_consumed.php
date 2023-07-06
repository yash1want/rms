
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<div class="position-relative row form-group mine-group">

	<div class="col-sm-12 mine-m-auto">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-12 tank_table">
					<div class="table-format">
						<div id="table_container_1"></div>
					</div>
                </div>
            </div>
        </div>
        <div class="alert alert-info p-2 pl-3"><?php echo $label[12]; ?></div>
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
    echo $this->Form->control('', ['type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'rawMaterialConsumed']);

    echo $this->Form->control('reason_count', ['type'=>'hidden', 'id'=>'checkNilRow', 'value'=>0]);
    echo $this->Form->control('', ['type'=>'hidden','id'=>'minWithUnit', 'value'=>$minWithUnit]);
    echo $this->Form->control('', ['type'=>'hidden', 'id'=>'get_raw_meterial_metals_unit', 'value'=>$this->Url->build(['controller' => 'Ajax', 'action' => 'getRawMaterialMetalsUnit'])]);

    echo $this->Html->script('m/raw_material_consumed.js?version='.$version);

?>
