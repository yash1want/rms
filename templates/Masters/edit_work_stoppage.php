<a href="<?= $this->Url->build(['action' => 'work-stoppage']) ?>" class="btn btn-success backToList">Back to List</a>
<?php foreach($records as $record) {?>
<h4 class="card-title bg-primary text-white masterHeading"> Edit Work Stoppage</h4>
<?= $this->Form->create(null, ['id' => 'workStoppageForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="sn" class="labelForm">Stoppage Sn</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('stoppage_sn', [
                'class' => 'form-control cvOn cvNum',
                'label' => false,
                'value' => $record['stoppage_sn'],
                'pattern' => '[0-9]{1,6}',
                'title' => 'Only number are allowed not more than 6 digit',
                'id' => 'stoppage_sn'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="def" class="labelForm">Stoppage Def</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('stoppage_def', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $record['stoppage_def'],
                'pattern' => '[a-zA-Z0-9\s]{1,30}',
                'title' => 'Only letters, numbers are allowed and not more than 30 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="def hindi" class="labelForm">Stoppage Def Hindi</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('stoppage_def_h', [
                'class' => 'form-control',
                'label' => false,
                'value' => $record['stoppage_def_h']
            ]); ?>
        </div>
    </div>
</div>
<?php } ?>
<br>
<div class="col-md-8  labelForm">
    <?= $this->Form->submit('Save', ['class' => 'btn btn-primary mb-4', 'name' => 'update']); ?>
</div>
<div class="col-md-2"></div>
<?= $this->Form->end(); ?>