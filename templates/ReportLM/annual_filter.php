<a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-success backToList">Back to Report List</a>

<?= $this->Form->create(null, [
    'id' => 'annualFilter',
    'url' => [
        'controller' => 'report-l-m',
        'action' => $title,
    ]
]); ?>
<?php
switch ($title) {
    case "report-A03":
?>
        <h4 class="card-title bg-primary text-white reportHeading">Returns Submission Status Report</h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
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
                        'required' => true
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
                    <label class="labelForm"> State</label>
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
                    <label class="labelForm"> District</label>
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

        <?= $this->Form->end(); ?>
    <?php break;
    case "report-A05":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading">Returns Submission Status Report</h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
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
                        'required' => true
                    ]); ?>
                </div>
            </div>
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
                        'id' => 'stateSelects',
                        'required' => true,
                        'options' => $states
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"> District</label>
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

        <?= $this->Form->end(); ?>

    <?php
        break;
    case "report-A06":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Plantwise Installed Capacity Report</h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Region Name</label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('region', [
                        'class' => 'form-control',
                        'label' => false,
                        'type' => 'select',
                        'empty' => 'Please Select',
                        'id' => 'regionIbmSelect',
                        'option' => $regions,
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <!--<label class="labelForm"><span class="compulsoryField">*</span> Industry Name</label>-->
					<label class="labelForm">Industry Name</label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('industry', [
                        'class' => 'form-control',
                        'label' => false,
                        'type' => 'select',
                        'empty' => 'Please Select',
                        'options' => $industries,
                        'id' => 'industrySelect',
                        //'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
					<!--<label class="labelForm"><span class="compulsoryField">*</span> IBM Registraion No </label>-->
                    <label class="labelForm">IBM Registraion No </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('ibm', [
                        'type' => 'select',
                        'class' => 'form-control ibmSelectIndustry',
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'ibmSelect',
                        'multiple' => true,
                        //'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
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
    case "report-A07":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Plantwise Installed Capacity Report</h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
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
                        'id' => 'stateIbmSelect',
                        'option' => $states,
                        'required' => true,
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
					<!--<label class="labelForm"><span class="compulsoryField">*</span> Industry Name</label>-->
                    <label class="labelForm">Industry Name</label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('industry', [
                        'class' => 'form-control',
                        'label' => false,
                        'type' => 'select',
                        'empty' => 'Please Select',
                        'options' => $industries,
                        'id' => 'industrySelectState',
                        //'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
					<!--<label class="labelForm"><span class="compulsoryField">*</span> IBM Registraion No </label>-->
                    <label class="labelForm">IBM Registraion No </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('ibm', [
                        'type' => 'select',
                        'class' => 'form-control ibmSelectIndustry',
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'ibmSelect',
                        //'required' => true,
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
            <br>
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
    case "report-A08":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Annual Return Submission Status Report for Registration Number </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
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
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> IBM Registraion No </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('ibm', [
                        'type' => 'select',
                        'class' => 'form-control ibmSelectIndustry',
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'ibmSelect',
                        'options' => $ibmRegs,
                        'required' => true,
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
    case "report-A09":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Company-wise Plant/Storage location Details for Business Activity Report (Region-wise) </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
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
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Region </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('region', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'options' => $regions,
                        'required' => true,
                        'multiple' => true,
                        'id' => 'regionIbmSelect',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> IBM Registraion No </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('ibm', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'ibmSelect',
                        // 'options' => $ibmRegs,
                        'required' => true,
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
    case "report-A10":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Company-wise Plant/Storage location Details for Business Activity Report (State-wise) </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
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
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> State </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('state', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'options' => $states,
                        'required' => true,
                        'multiple' => true,
                        'id' => 'stateIbmSelect',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> IBM Registraion No </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('ibm', [
                        'type' => 'select',
                        'class' => 'form-control ibmSelectIndustry',
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'ibmSelect',
                        // 'options' => $ibmRegs,
                        'required' => true,
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
    case "report-A11":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Region wise Percentage Annual Return Receipt Status Report </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
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
                    <label class="labelForm"><span class="compulsoryField">*</span> Region </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('region', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'options' => $regions,
                        'required' => true,
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
    case "report-A12":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> State wise Percentage Annual Return Receipt Status Report </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
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
                    <label class="labelForm"><span class="compulsoryField">*</span> State </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('state', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'options' => $states,
                        'required' => true,
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
    case "report-A14":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> State wise Production of product and Mineral Consumption Report </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> State </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('state', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'options' => $states,
                        'required' => true,
                        'multiple' => true,
                        'id' => 'stateSelectsMultiple',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> District </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('district', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'required' => true,
                        'multiple' => true,
                        'id' => 'districtSingleSelects',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm">Registration Number </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('ibm', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        //'required' => true,
                        'multiple' => true,
                        'id' => 'ibmSelect',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm">Company Name </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('company', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        //'required' => true,
                        'multiple' => true,
                        'id' => 'companySelect'
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm">Plant Name / Storage Location </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('plant', [
                        'type' => 'select',
                        'class' => 'form-control plantSelect',
                        'empty' => 'Please Select',
                        'label' => false,
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
    case "report-A15":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Yearly Mineral wise End Use Mineral Consumption Report </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
					<?= $this->Form->hidden('reportno', ['id' => 'reportno', 'value' => 'A15']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year (From)</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year_15',
                    ]); ?>
                </div>
            </div>
			<br>
			<div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year (To)</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('to_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'to_year_15',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm">Mineral </label>
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
                    <label class="labelForm">Industry </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('industry', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'options' => $industries,
                       // 'required' => true,
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
    case "report-A16":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Yearly Industry wise End Use Mineral Consumption Report </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
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
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Industry </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('industry', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'options' => $industries,
                        'required' => true,
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
    case "report-A17":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> End Use Mineral Consumption Monthly V/s Yearly Report </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control year',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                    ]); ?>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="district-code" class="labelForm"><span class="compulsoryField">*</span> Month</label>
                </div>
                <div class="col-md-3">
                    <?php
                    $data = ['01-01' => 'Jan', '01-02' => 'Feb', '01-03' => 'Mar', '01-04' => 'Apr', '01-05' => 'May', '01-06' => 'Jun', '01-07' => 'Jul', '01-08' => 'Aug', '01-09' => 'Sept', '01-10' => 'Oct', '01-11' => 'Nov', '01-12' => 'Dec'];
                    ?>
                    <?= $this->Form->control('from_month', [
                        'type' => 'select',
                        'class' => 'form-control fromMonth',
                        'required' => true,
                        'label' => false,
                        'options' => $data,
                        'empty' => 'From ',
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('to_month', [
                        'type' => 'select',
                        'class' => 'form-control toMonth',
                        'required' => true,
                        'label' => false,
                        'empty' => ' To ',
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
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> IBM Registration No </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('ibm', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'options' => $ibmRegs,
                        'required' => true,
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
    case "report-A18":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Cost of Mineral Imported v/s Indigenous </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
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
                        'options' => $minerals,
                        'empty' => 'Please Select',
                        'required' => true,
                        'miltiple' => true,
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
    case "report-A19":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Mineral-wise Transportation Cost </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
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
                        'options' => $minerals,
                        'empty' => 'Please Select',
                        'required' => true,
                        'miltiple' => true,
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
    case "report-A20":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Transportation Cost for Registration Number </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Name of Company </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('company', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $company,
                        'empty' => 'Please Select',
                        'required' => true,
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
    case "report-A21":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Sector-wise Mineral Consumption Report (State-wise) </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
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
                        'options' => $minerals,
                        'empty' => 'Please Select',
                        'required' => true,
                        'miltiple' => true,
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
    case "report-A22":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Sector-wise Mineral Consumption Report (Region-wise) </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
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
                        'options' => $minerals,
                        'empty' => 'Please Select',
                        'required' => true,
                        'miltiple' => true,
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
    case "report-A23":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Industry-wise List of Plants </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm">Industry </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('industry', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $industries,
                        'empty' => 'Please Select',
                        //'required' => true,
                        'miltiple' => true,
                    ]); ?>
                </div>
            </div>
			<br>
			<div class="row">
                <div class="col-md-6">
                    <label class="labelForm">State </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('state', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'empty' => 'Please Select',
                        'label' => false,
                        'options' => $states,
                        //'required' => true,
                        'multiple' => true,
                        'id' => 'stateSelectsMultiple',
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
    case "report-A24":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Master Report Trading Activity </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
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
                        'options' => $minerals,
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
    case "report-A25":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Master Report Export Activity </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
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
                        'options' => $minerals,
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
    case "report-A26":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Master Report End Use Activity </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
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
                        'options' => $minerals,
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
    case "report-A27":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Master Report Stockist Activity </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
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
                        'options' => $minerals,
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
    case "report-A28":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Master Report Details of Raw Material Consumed </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Mineral / Metal / Ferror Alloy </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('mineral', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $mineralsAll,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                    ]); ?>
                </div>
            </div>
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
                        'id' => 'stateSelectPlant'
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Industry </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('industry', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $industries,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                        'id' => 'industriesSelect',
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
                        'class' => 'form-control plantIndustrySelect',
                        'label' => false,
                        'empty' => 'Please Select',
                        'multiple' => true,
                        'required' => true,
                        'id' => 'plantSelect'
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
    case "report-A29":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Master Report Source of Supply (Indigenous) </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
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
                        'id' => 'stateSelectPlant'
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Industry </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('industry', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $industries,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                        'id' => 'industriesSelect',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Mineral / Metal / Ferror Alloy </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('mineral', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $mineralsAll,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                        'id' => 'mineralSelect',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Mode of Transportation </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('transport', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'multiple' => true,
                        'required' => true,
                        'options' => $transport,
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
                        'class' => 'form-control plantIndustrySelect',
                        'label' => false,
                        'empty' => 'Please Select',
                        'multiple' => true,
                        'required' => true,
                        'id' => 'plantSelect'
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Name of Suppiler </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('supplier', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'multiple' => true,
                        'required' => true,
                        'id' => 'supplierSelect',
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
    case "report-A30":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Master Report Source of Supply (Imported) </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
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
                        'id' => 'stateSelectPlant'
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Industry </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('industry', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $industries,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                        'id' => 'industriesSelect',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Mineral / Metal / Ferror Alloy </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('mineral', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $mineralsAll,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                        'id' => 'mineralSelect',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Mode of Transportation </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('transport', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'multiple' => true,
                        'required' => true,
                        'options' => $transport,
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
                        'class' => 'form-control plantIndustrySelect',
                        'label' => false,
                        'empty' => 'Please Select',
                        'multiple' => true,
                        'required' => true,
                        'id' => 'plantSelect'
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Name of Suppiler </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('supplier', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'multiple' => true,
                        'required' => true,
                        'id' => 'supplierSelect',
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
    case "report-A31":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> Report Transportation Cost </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> IBM Registration No </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('ibm', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'ibmSelectIndustry',
                        'options' => $ibmRegs,
                        'multiple' => true,
                        'required' => true,
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Industry </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('indust', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                        'id' => 'industriesSelectedIbm',
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
                        'id' => 'plantIndustryIbmSelect'
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Mineral / Metal / Ferror Alloy </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('mineral', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $mineralsAll,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                        'id' => 'mineralSelect',
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
    case "report-A32":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> List of Suppliers (Indigenous) </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Industry </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('indust', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'options' => $industries,
                        'required' => true,
                        'id' => 'industrySelectedIbm',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> IBM Registration No </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('ibm', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'getIndustryIbm',
                        'multiple' => true,
                        'required' => true,
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
                        'id' => 'plantIndustryIbmSelect'
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Mineral / Metal / Ferror Alloy </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('mineral', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $mineralsAll,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                        'id' => 'mineralSelect',
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
    case "report-A33":
    ?>
        <h4 class="card-title bg-primary text-white reportHeading"> List of Suppliers (Imported) </h4>

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Financial Year</label>
                </div>
                <div class="col-md-6">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('from_year', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Industry </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('industry', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'options' => $industries,
                        'required' => true,
                        'id' => 'industrySelectedIbm',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> IBM Registration No </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('ibm', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'getIndustryIbm',
                        'multiple' => true,
                        'required' => true,
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
                        'id' => 'plantIndustryIbmSelect'
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Mineral / Metal / Ferror Alloy </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('mineral', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $mineralsAll,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                        'id' => 'mineralSelect',
                    ]); ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="labelForm"><span class="compulsoryField">*</span> Country </label>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('country', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'label' => false,
                        'options' => $country,
                        'empty' => 'Please Select',
                        'required' => true,
                        'multiple' => true,
                        'id' => 'countrySelect',
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

<?php
} ?>