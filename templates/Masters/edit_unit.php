<a href="<?= $this->Url->build(['action' => 'unit']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit Unit</h4>
<?= $this->Form->create(null, ['id' => 'unitForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="unit-code" class="labelForm">Unit Code</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('unit_code', [
                'class' => 'form-control cvOn cvAlpha',
                'label' => false,
                'value' => $unit->unit_code,
                'pattern' => '[a-zA-Z%/]{1,10}',
                'title' => 'Only characters,percent sign and forward slash are allowed. Not more than 10 characters are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="unit def" class="labelForm">Unit Def</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('unit_def', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $unit->unit_def,
                'pattern' => '[a-zA-Z0-9\s]{1,100}',
                'title' => 'Only letters, numbers are allowed and not more than 100 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="dgcis code" class="labelForm">DGCIS Unit Code</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('dgcis_unit_code', [
                'class' => 'form-control cvOn cvAlpha',
                'label' => false,
                'value' => $unit->dgcis_unit_def,
                'pattern' => '[a-zA-Z]{1,3}',
                'title' => 'Only characters are allowed. Not more than 3 characters are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="dgcis-unit-def" style="float: right;">DGCIS Unit Def</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('dgcis_unit_def', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $unit->dgcis_unit_def,
                'pattern' => '[a-zA-Z0-9\s]{1,15}',
                'title' => 'Only letters, numbers are allowed and not more than 15 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="wmi-unit-def" class="labelForm">WMI Unit Def</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('wmi_unit_def', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $unit->wmi_unit_def,
                'pattern' => '[a-zA-Z0-9\s]{1,15}',
                'title' => 'Only letters, numbers are allowed and not more than 15 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="mcp-unit-def" class="labelForm">MCP Unit Def</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('mcp_unit_def', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $unit->mcp_unit_def,
                'pattern' => '[a-zA-Z0-9\s]{1,15}',
                'title' => 'Only letters, numbers are allowed and not more than 15 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="conversion" class="labelForm">Conversion Factor</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('conversion_factor', [
                'class' => 'form-control cvOn cvNum',
                'label' => false,
                'value' => $unit->conversion_factor,
                'pattern' => '[0-9]{1,10}',
                'title' => 'Only number are allowed not more than 10 digit'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>

</div>
<br>
<div class="col-md-8 labelForm">
    <?= $this->Form->submit('Edit', ['class' => 'btn btn-primary mb-4']); ?>
</div>
<div class="col-md-2"></div>
<?= $this->Form->end(); ?>