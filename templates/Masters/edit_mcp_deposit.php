<a href="<?= $this->Url->build(['action' => 'commodity']) ?>" class="btn btn-success backToList">Back to List</a>

<h4 class="card-title bg-primary text-white masterHeading"> Edit MCP Deposit</h4>
<?= $this->Form->create(null, ['id' => 'mcpDepositForm', 'class' => 'master_form']); ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-6">
            <label for="mine-code" class="labelForm"><span class="compulsoryField">*</span> Mine Code </label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('mine_code', [
                'type' => 'text',
                'class' => 'form-control cvOn cvAlphaNum',
                'value' => $mcpDeposit->mine_code,
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,20}',
                'title' => 'Only letters, numbers are allowed periods and not more than 20 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="deposit-sn" class="labelForm"><span class="compulsoryField">*</span> Deposit Sn</label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('deposit_sn', [
                'class' => 'form-control cvOn cvNum',
                'type' => 'number',
                'value' => $mcpDeposit->deposit_sn,
                'label' => false,
                'pattern' => '[0-9]{1,2}',
                'title' => 'Only numbers are allowed. Not more than 2 digit are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="ts-comtx" class="labelForm"><span class="compulsoryField">*</span> Ts Comtx Dataeposit Name </label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('ts_comtx_dataeposit_name', [
                'type' => 'text',
                'class' => 'form-control cvOn cvAlphaNum',
                'value' => $mcpDeposit->ts_comtx_dataeposit_name,
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,40}',
                'title' => 'Only letters, numbers are allowed not more than 40 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="commodity-name" class="labelForm"><span class="compulsoryField">*</span> Commodity Name </label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('commodity_name', [
                'type' => 'text',
                'class' => 'form-control cvOn cvAlphaNum',
                'value' => $mcpDeposit->commodity_name,
                'label' => false,
                'pattern' => '[a-zA-Z0-9\s]{1,20}',
                'title' => 'Only letters, numbersare allowed not more than 20 characters'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="deposit" class="labelForm"><span class="compulsoryField">*</span> Deposit Number </label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('deposit_no', [
                'type' => 'number',
                'class' => 'form-control cvOn cvNum',
                'value' => $mcpDeposit->deposit_no,
                'label' => false,
                'pattern' => '[0-9]{1,11}',
                'title' => 'Only numbers are allowed. Not more than 11 digit are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="block" class="labelForm"><span class="compulsoryField">*</span> Block Number </label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('block_no', [
                'type' => 'number',
                'class' => 'form-control cvOn cvNum',
                'value' => $mcpDeposit->block_no,
                'label' => false,
                'pattern' => '[0-9]{1,6}',
                'title' => 'Only numbers are allowed. Not more than 6 digit are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="strke" class="labelForm"><span class="compulsoryField">*</span> Strike Length </label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('strike_length', [
                'type' => 'number',
                'class' => 'form-control cvOn cvNum',
                'value' => $mcpDeposit->strike_length,
                'label' => false,
                'pattern' => '[0-9]{1,20}',
                'title' => 'Only numbers are allowed. Not more than 20 digit are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="amount" class="labelForm"><span class="compulsoryField">*</span> Dip Amount </label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('dip_amount', [
                'type' => 'number',
                'class' => 'form-control cvOn cvNum',
                'value' => $mcpDeposit->dip_amount,
                'label' => false,
                'pattern' => '[0-9]{1,6}',
                'title' => 'Only numbers are allowed. Not more than 6 digit are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="direction" class="labelForm"><span class="compulsoryField">*</span> Dip Direction </label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('dip_direction', [
                'type' => 'number',
                'class' => 'form-control cvOn cvNum',
                'value' => $mcpDeposit->dip_direction,
                'label' => false,
                'pattern' => '[0-9]{1,9}',
                'title' => 'Only numbers are allowed. Not more than 9 digit are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="width" class="labelForm"><span class="compulsoryField">*</span> Width </label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('width', [
                'type' => 'number',
                'class' => 'form-control cvOn cvNum',
                'value' => $mcpDeposit->width,
                'label' => false,
                'pattern' => '[0-9]{1,11}',
                'title' => 'Only numbers are allowed. Not more than 11 digit are allowed'
            ]); ?>
            <div class="err_cv"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <label for="depth" class="labelForm"><span class="compulsoryField">*</span> Depth </label>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('depth', [
                'type' => 'number',
                'class' => 'form-control cvOn cvNum',
                'value' => $mcpDeposit->depth,
                'label' => false,
                'pattern' => '[0-9]{1,11}',
                'title' => 'Only numbers are allowed. Not more than 11 digit are allowed'
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