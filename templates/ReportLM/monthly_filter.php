<a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-success backToList">Back to Report List</a>

<?= $this->Form->create(null, [
    'id' => 'monthlyFilter',
    'url' => [
        'controller' => 'report-l-m',
        'action' => $title,
    ]
]); ?>
<?php
switch ($title) {
    case "report-M02":
?>
        <h4 class="card-title bg-primary text-white reportHeading">Returns Submission Status Report</h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'MONTHLY']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="district-code" class="labelForm"><span class="compulsoryField">*</span> Date</label>
                </div>
                <div class="col-md-3">
                    <?php
                    $data = ['01-01' => 'Jan', '01-02' => 'Feb', '01-03' => 'March', '01-04' => 'April', '01-05' => 'May', '01-06' => 'June', '01-07' => 'July', '01-08' => 'Aug', '01-09' => 'Sept', '01-10' => 'Oct', '01-11' => 'Nov', '01-12' => 'Dec'];
                    ?>
                    <?= $this->Form->control('month', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'required' => true,
                        'label' => false,
                        'options' => $data,
                        'empty' => 'Please Select',
                        'id' => 'm',
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('year', [
                        'type' => 'year',
                        'class' => 'form-control',
                        'min' => 2011,
                        'max' => date('Y'),
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Business Activity </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('business', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $activity,
                        'empty' => 'Please Select',
                        'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Status </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('status', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'options' => $status,
                        'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"> Zone Name</label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('zone', [
                        'class' => 'form-control',
                        'label' => false,
                        'type' => 'select',
                        'empty' => 'Please Select',
                        'options' => $zones,
                        'id' => 'zoneSelect',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"> Region Name</label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('region', [
                        'class' => 'form-control',
                        'label' => false,
                        'type' => 'select',
                        'empty' => 'Please Select',
                        'id' => 'regionSelect',
                    ]); ?>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"> State Name</label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('state', [
                        'class' => 'form-control',
                        'label' => false,
                        'type' => 'select',
                        'empty' => 'Please Select',
                        'id' => 'stateSelects',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"> District Name</label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('district', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'id' => 'districtSelects',
                    ]); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12 text-center">
            <span>
                <button class="btn btn-primary" type="submit" name="view_report" id="filter">View Report</button>
            </span>
            <span>
                <button class="btn btn-primary" type="submit" name="download_report" id="filter">Download Excel</button>
            </span>
        </div><br>
        <div class="col-md-2"></div>

    <?= $this->Form->end();
        break;
    case "report-M04": ?>
        <h4 class="card-title bg-primary text-white reportHeading">Returns Submission Status Report</h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'MONTHLY']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="district-code" class="labelForm"><span class="compulsoryField">*</span> Date</label>
                </div>
                <div class="col-md-3">
                    <?php
                    $data = ['01-01' => 'Jan', '01-02' => 'Feb', '01-03' => 'March', '01-04' => 'April', '01-05' => 'May', '01-06' => 'June', '01-07' => 'July', '01-08' => 'Aug', '01-09' => 'Sept', '01-10' => 'Oct', '01-11' => 'Nov', '01-12' => 'Dec'];
                    ?>
                    <?= $this->Form->control('month', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'required' => true,
                        'label' => false,
                        'options' => $data,
                        'empty' => 'Please Select',
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('year', [
                        'type' => 'year',
                        'class' => 'form-control',
                        'min' => 2011,
                        'max' => date('Y'),
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Business Activity </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('business', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $activity,
                        'empty' => 'Please Select',
                        'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Status </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('status', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'options' => $status,
                        'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> State Name</label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('state', [
                        'class' => 'form-control',
                        'label' => false,
                        'type' => 'select',
                        'empty' => 'Please Select',
                        'id' => 'stateSelects',
                        'options' => $states,
                        'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"> District Name</label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('district', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'id' => 'districtSelects',
                    ]); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12 text-center">
            <span>
                <button class="btn btn-primary" type="submit" name="view_report" id="filter">View Report</button>
            </span>
            <span>
                <button class="btn btn-primary" type="submit" name="download_report" id="filter">Download Excel</button>
            </span>
        </div><br>
        <div class="col-md-2"></div>
    <?= $this->Form->end();
        break;
    case "report-M13": ?>
        <h4 class="card-title bg-primary text-white reportHeading">End Use Mineral Consumption Monthly Report</h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'MONTHLY']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Year </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('year', [
                        'type' => 'year',
                        'class' => 'form-control',
                        'min' => 2011,
                        'max' => date('Y'),
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="district-code" class="labelForm"><span class="compulsoryField">*</span> Month</label>
                </div>
                <div class="col-md-3">
                    <?php
                    $data = ['01-01' => 'Jan', '01-02' => 'Feb', '01-03' => 'March', '01-04' => 'April', '01-05' => 'May', '01-06' => 'June', '01-07' => 'July', '01-08' => 'Aug', '01-09' => 'Sept', '01-10' => 'Oct', '01-11' => 'Nov', '01-12' => 'Dec'];
                    ?>
                    <?= $this->Form->control('from_month', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'required' => true,
                        'label' => false,
                        'options' => $data,
                        'empty' => 'From ',
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?php
                    $data = ['01-01' => 'Jan', '01-02' => 'Feb', '01-03' => 'March', '01-04' => 'April', '01-05' => 'May', '01-06' => 'June', '01-07' => 'July', '01-08' => 'Aug', '01-09' => 'Sept', '01-10' => 'Oct', '01-11' => 'Nov', '01-12' => 'Dec'];
                    ?>
                    <?= $this->Form->control('to_month', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'required' => true,
                        'label' => false,
                        'options' => $data,
                        'empty' => ' To ',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
					<label class="labelForm">Mineral </label>
                    <!--<label class="labelForm"><span class="compulsoryField">*</span> Mineral </label>-->
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('mineral', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $mineralsAll,
                        'empty' => 'Please Select',
                        //'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
					<label class="labelForm">IBM Registration No </label>
                    <!--<label class="labelForm"><span class="compulsoryField">*</span> IBM Registration No </label>-->
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('ibm', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'options' => $ibmRegs,
                        //'required' => true,
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12 text-center">
            <span>
                <button class="btn btn-primary" type="submit" name="view_report" id="filter">View Report</button>
            </span>
            <span>
                <button class="btn btn-primary" type="submit" name="download_report" id="filter">Download Excel</button>
            </span>
        </div><br>
        <div class="col-md-2"></div>

        <?= $this->Form->end(); ?>
    <?php
        break;
    case "report-M36": ?>

        <h4 class="card-title bg-primary text-white reportHeading"> Report of Trading Activity </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'MONTHLY']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Date</label>
                </div>
                <div class="col-md-3">
                    <?php
                    $data = ['01-01' => 'Jan', '01-02' => 'Feb', '01-03' => 'March', '01-04' => 'April', '01-05' => 'May', '01-06' => 'June', '01-07' => 'July', '01-08' => 'Aug', '01-09' => 'Sept', '01-10' => 'Oct', '01-11' => 'Nov', '01-12' => 'Dec'];
                    ?>
                    <?= $this->Form->control('month', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'required' => true,
                        'label' => false,
                        'options' => $data,
                        'empty' => 'Please Select ',
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('year', [
                        'type' => 'year',
                        'class' => 'form-control',
                        'required' => true,
                        'min' => 2011,
                        'max' => date('Y'),
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Mineral </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('mineral', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $mineralsAll,
                        'empty' => 'Please Select',
                        'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Grade </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('grade', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $grade,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> State</label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('state', [
                        'class' => 'form-control',
                        'label' => false,
                        'type' => 'select',
                        'empty' => 'Please Select',
                        'required' => true,
                        'options' => $states,
                        'multiple' => true,
                        'id' => 'stateSelectPlant',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Name of Plant </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('plant', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'multiple' => true,
                        'required' => true,
                        'id' => 'plantSelect',
                    ]); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12 text-center">
            <span>
                <button class="btn btn-primary" type="submit" name="view_report" id="filter">View Report</button>
            </span>
            <span>
                <button class="btn btn-primary" type="submit" name="download_report" id="filter">Download Excel</button>
            </span>
        </div><br>
        <div class="col-md-2"></div>

        <?= $this->Form->end(); ?>

    <?php
        break;
    case "report-M37": ?>

        <h4 class="card-title bg-primary text-white reportHeading"> Report of Export Activity </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'MONTHLY']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Date</label>
                </div>
                <div class="col-md-3">
                    <?php
                    $data = ['01-01' => 'Jan', '01-02' => 'Feb', '01-03' => 'March', '01-04' => 'April', '01-05' => 'May', '01-06' => 'June', '01-07' => 'July', '01-08' => 'Aug', '01-09' => 'Sept', '01-10' => 'Oct', '01-11' => 'Nov', '01-12' => 'Dec'];
                    ?>
                    <?= $this->Form->control('month', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'required' => true,
                        'label' => false,
                        'options' => $data,
                        'empty' => 'Please Select ',
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('year', [
                        'type' => 'year',
                        'class' => 'form-control',
                        'required' => true,
                        'min' => 2011,
                        'max' => date('Y'),
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Mineral </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('mineral', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $mineralsAll,
                        'empty' => 'Please Select',
                        'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Grade </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('grade', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $grade,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> State</label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('state', [
                        'class' => 'form-control',
                        'label' => false,
                        'type' => 'select',
                        'empty' => 'Please Select',
                        'required' => true,
                        'options' => $states,
                        'multiple' => true,
                        'id' => 'stateSelectPlant',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Name of Plant </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('plant', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'multiple' => true,
                        'required' => true,
                        'id' => 'plantSelect',
                    ]); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12 text-center">
            <span>
                <button class="btn btn-primary" type="submit" name="view_report" id="filter">View Report</button>
            </span>
            <span>
                <button class="btn btn-primary" type="submit" name="download_report" id="filter">Download Excel</button>
            </span>
        </div><br>
        <div class="col-md-2"></div>

        <?= $this->Form->end(); ?>

    <?php
        break;
    case "report-M38": ?>

        <h4 class="card-title bg-primary text-white reportHeading"> Report of End Use Activity </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'MONTHLY']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Date</label>
                </div>
                <div class="col-md-3">
                    <?php
                    $data = ['01-01' => 'Jan', '01-02' => 'Feb', '01-03' => 'March', '01-04' => 'April', '01-05' => 'May', '01-06' => 'June', '01-07' => 'July', '01-08' => 'Aug', '01-09' => 'Sept', '01-10' => 'Oct', '01-11' => 'Nov', '01-12' => 'Dec'];
                    ?>
                    <?= $this->Form->control('month', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'required' => true,
                        'label' => false,
                        'options' => $data,
                        'empty' => 'Please Select ',
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('year', [
                        'type' => 'year',
                        'class' => 'form-control',
                        'required' => true,
                        'min' => 2011,
                        'max' => date('Y'),
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Mineral </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('mineral', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $mineralsAll,
                        'empty' => 'Please Select',
                        'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Grade </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('grade', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $grade,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> State</label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('state', [
                        'class' => 'form-control',
                        'label' => false,
                        'type' => 'select',
                        'empty' => 'Please Select',
                        'required' => true,
                        'options' => $states,
                        'multiple' => true,
                        'id' => 'stateSelectPlant',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Name of Plant </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('plant', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'multiple' => true,
                        'required' => true,
                        'id' => 'plantSelect',
                    ]); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12 text-center">
            <span>
                <button class="btn btn-primary" type="submit" name="view_report" id="filter">View Report</button>
            </span>
            <span>
                <button class="btn btn-primary" type="submit" name="download_report" id="filter">Download Excel</button>
            </span>
        </div><br>
        <div class="col-md-2"></div>

        <?= $this->Form->end(); ?>

    <?php
        break;
    case "report-M39": ?>

        <h4 class="card-title bg-primary text-white reportHeading"> Report of Storage Activity </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'MONTHLY']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Date</label>
                </div>
                <div class="col-md-3">
                    <?php
                    $data = ['01-01' => 'Jan', '01-02' => 'Feb', '01-03' => 'March', '01-04' => 'April', '01-05' => 'May', '01-06' => 'June', '01-07' => 'July', '01-08' => 'Aug', '01-09' => 'Sept', '01-10' => 'Oct', '01-11' => 'Nov', '01-12' => 'Dec'];
                    ?>
                    <?= $this->Form->control('month', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'required' => true,
                        'label' => false,
                        'options' => $data,
                        'empty' => 'Please Select ',
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('year', [
                        'type' => 'year',
                        'class' => 'form-control',
                        'required' => true,
                        'min' => 2011,
                        'max' => date('Y'),
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Mineral </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('mineral', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $mineralsAll,
                        'empty' => 'Please Select',
                        'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Grade </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('grade', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $grade,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> State</label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('state', [
                        'class' => 'form-control',
                        'label' => false,
                        'type' => 'select',
                        'empty' => 'Please Select',
                        'required' => true,
                        'options' => $states,
                        'multiple' => true,
                        'id' => 'stateSelectPlant',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Name of Plant </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('plant', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'multiple' => true,
                        'required' => true,
                        'id' => 'plantSelect',
                    ]); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12 text-center">
            <span>
                <button class="btn btn-primary" type="submit" name="view_report" id="filter">View Report</button>
            </span>
            <span>
                <button class="btn btn-primary" type="submit" name="download_report" id="filter">Download Excel</button>
            </span>
        </div><br>
        <div class="col-md-2"></div>

        <?= $this->Form->end(); ?>
        <?php
        break;
    default: {
        ?>
            <h4 class='noReport'>Report Not Found...</h4>
        <?php
        }
        ?>
<?php } ?>