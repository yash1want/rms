<a href="<?= $this->Url->build(['action' => 'commodity']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit Commodity</h4>
<?= $this->Form->create(null, ['id' => 'commodityForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="commodity-name" class="labelForm">Commodity Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('commodity_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $commodity->commodity_name,
                'pattern' => '[a-zA-Z0-9\s]{1,20}',
                'title' => 'Only letters, numbers are allowed not more than 20 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="unit code" class="labelForm">Unit Code</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('unit_code', [
                'class' => 'form-control cvOn cvAlpha',
                'label' => false,
                'value' => $commodity->unit_code,
                'pattern' => '[a-zA-Z]{1,10}',
                'title' => 'Only characters are allowed. Not more than 10 characters are allowed'
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