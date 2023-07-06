<a href="<?= $this->Url->build(['action' => 'activity']) ?>" class="btn btn-primary backToList">Back to List</a>

<h4 class="card-title bg-dark text-white masterHeading"> Edit Activity Type</h4>
<?= $this->Form->create(null, ['id' => 'commodityForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="commodity-name" class="labelForm">Applicant Id</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('applicant_id', [
                'type' => 'text',
                'class' => 'form-control ',
                'label' => false,
                'value' => $records[0],
                'readonly' => true,
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="unit code" class="labelForm">Email</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('email', [
                'class' => 'form-control',
                'label' => false,
                'value' => base64_decode($records[1]),
                'readonly' => true,
            ]); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="unit code" class="labelForm">Activity Type</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('business', [
                'type' => 'select',
                'class' => 'form-control',
                'label' => false,
                'options' => $activity,
                'empty' => 'Please Select',
                'required' => true
            ]); ?>
        </div>
    </div>

</div>
<br>
<div class="col-md-8 labelForm">
    <?= $this->Form->submit('Update', ['class' => 'btn btn-primary mb-4']); ?>
</div>
<div class="col-md-2"></div>
<?= $this->Form->end(); ?>