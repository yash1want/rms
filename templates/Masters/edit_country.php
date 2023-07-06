<a href="<?= $this->Url->build(['action' => 'country']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit Country</h4>
<?= $this->Form->create(null, ['id' => 'countryForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="country-name" class="labelForm">Country Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('country_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $country->country_name,
                'pattern' => '[a-zA-Z0-9\s]{1,40}',
                'title' => 'Only letters, numbers are allowed and not more than 40 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="dgcis code" class="labelForm">DGCIS Country Code</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('dgcis_country_code', [
                'class' => 'form-control cvOn cvNum',
                'label' => false,
                'value' => $country->dgcis_country_code,
                'type' => 'number',
                'pattern' => '[0-9]{1,9}',
                'title' => 'Only numbers are allowed not more than 9 numbers'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="continent" class="labelForm">Sub Continent Name</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('sub_continent_name', [
                'class' => 'form-control cvOn cvAlphaNum',
                'label' => false,
                'value' => $country->sub_continent_name,
                'pattern' => '[a-zA-Z0-9\s]{1,40}',
                'title' => 'Only letters, numbers are allowed and not more than 75 characters'
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