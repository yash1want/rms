<a href="<?= $this->Url->build(['action' => 'zone']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit Zone</h4>
<?= $this->Form->create(null, ['id' => 'zoneyForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="zone-name" class="labelForm">Zone Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('zone_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $zone->zone_name,
                'pattern' => '[a-zA-Z0-9\s]{1,10}',
                'title' => 'Only letters, numbers are allowed and not more than 10 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
</div>
<br>
<div class="col-md-8 labelForm">
    <?= $this->Form->submit('Save', ['class' => 'btn btn-primary mb-4']); ?>
</div>
<div class="col-md-2"></div>
<?= $this->Form->end(); ?>