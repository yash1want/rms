<div id="filter" class="filterDisplayBlock">
    <a href="<?= $this->Url->build(['action' => 'home']) ?>" class="btn  backToList">Back To Ticket Report List</a>
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 fsStyle ">
                            <?= $this->Form->create(null, [
                                'id' => 'allStatusFilter',
                                'url' => [
                                    'controller' => 'support-mod',
                                    'action' => $title,
                                ]
                            ]);
                            /*switch ($title) {
                                case "report-M01":
                                case "report-M02":
                                case "report-M02b":
                                case "report-M02c":
                                case "report-M03":
                                case "report-M04":
                                case "report-M05":
                                case "report-M06":
                                case "report-M07":
                                case "report-M08":
                                case "report-M09":
                                case "report-M10":
                                case "report-M11":*/

                                switch ($title) {
                                case "report-statusS1":
                            ?>
                                    <?php

                                    if ($title == 'report-statusS1' && $subtype == 1) {
                                    ?>
                                        <h4 class="card-title text-center mb-4 reportHeading">Ticket Report - Click Here, To Check Ticket Records - Pending ,Inprocess & Closed With Filters</h4>
                                    <?php } ?>
                                    <!-- if ($title == 'report-M01' && $subtype == 2) {
                                    ?>
                                        <h4 class="card-title text-center mb-4 reportHeading">Report M01B - Grade wise ROM Dispatch, ROM Ex-Mine Price, Sale Quantity and Value (Minerals other than Iron Ore and Chromite)</h4>
                                    </?php }
                                    if ($title == 'report-M02') {
                                    ?>
                                        <h4 class="card-title text-center mb-4 reportHeading">Report M02A - Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (For Iron Ore and Chromite)</h4>
                                    </?php }
                                    if ($title == 'report-M02b') {
                                    ?>
                                        <h4 class="card-title text-center mb-4 reportHeading">Report M02B - Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (Minerals other than Iron Ore and Chromite)</h4>
                                    </?php }
                                    if ($title == 'report-M02c') {
                                    ?>
                                        <h4 class="card-title text-center mb-4 reportHeading">Report M02C - Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (For F3 Minerals)</h4>
                                    </?php }
                                    if ($title == 'report-M03') {
                                    ?>
                                        <h4 class="card-title text-center mb-4 reportHeading">Report M03 - ROM Opening Stock, ROM Production & ROM Closing Stock</h4>
                                    </?php }
                                    if ($title == 'report-M04') {
                                    ?>
                                        <h4 class="card-title text-center mb-4 reportHeading">Report M04 - Mine to Smelter Details (Ore to Metal)</h4>
                                    </?php }
                                    if ($title == 'report-M05') {
                                    ?>
                                        <h4 class="card-title text-center mb-4 reportHeading">Report M05 - Sales-Dispatch Details of Ore/Concentrates</h4>
                                    </?php }
                                    if ($title == 'report-M06') {
                                    ?>
                                        <h4 class="card-title  text-center mb-4 reportHeading">Report M06 - Opening Stock, Sale of Metal/Product and Closing Stock </h4>
                                    </?php }
                                    if ($title == 'report-M07') {
                                    ?>
                                        <h4 class="card-title text-center mb-4 reportHeading">Report M07 - Details of Rent/Royalty/Dead Rent/DMF/NMET</h4>
                                    </?php }
                                    if ($title == 'report-M08') {
                                    ?>
                                        <h4 class="card-title text-center mb-4 reportHeading">Report M08 - Precious & Semi Precious Stone ROM Production Details (Form F3)</h4>
                                    </?php }
                                    if ($title == 'report-M09') {
                                    ?>
                                        <h4 class="card-title text-center mb-4 reportHeading">Report M09 - Precious & Semi Precious Stone Grade wise Production Details (Form F3)</h4>
                                    </?php }
                                    if ($title == 'report-M10') {
                                    ?>
                                        <h4 class="card-title text-center mb-4 reportHeading">Report M10 - Precious & Semi Precious Stone Opening & Closing Stock Details (Form F3)</h4>
                                    </?php }
                                    if ($title == 'report-M11') {
                                    ?>
                                        <h4 class="card-title text-center mb-4 reportHeading">Report M11 - Precious & Semi Precious Stone Ex-Mine Price Details (Form F3)</h4>
                                    </?php } ?> -->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'MONTHLY']); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label><span class="compulsoryField">*</span> From</label>
                                        </div>
                                        <div class="col-md-4">
                                            <?= $this->Form->control('from_date', [
                                                'type' => 'text',
                                                'class' => 'form-control supportReportDates',
                                                'label' => false,
                                                'required' => true,
                                                'placeholder' => 'MM/YYYY',
                                                'autocomplete' => 'off',
                                                //'readonly' => true,
                                                   'id' => 'f_date',
                                            ]); ?>
                                        </div>
                                        <div class="col-md-1">
                                            <label><span class="compulsoryField">*</span> To</label>
                                        </div>
                                        <div class="col-md-4">
                                            <?= $this->Form->control('to_date', [
                                                'type' => 'text',
                                                'class' => 'form-control supportReportDates',
                                                'label' => false,
                                                'required' => true,
                                                'placeholder' => 'MM/YYYY',
                                                'autocomplete' => 'off',
                                                //'readonly' => true,
                                                'id' => 't_date',
                                            ]); ?>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label> Ticket Issue Category </label>
                                        </div>
                                        <div class="col-md-9">
                                            <?= $this->Form->control('issue_category', [
                                                'type' => 'select',
                                                'class' => 'form-control',
                                                'label' => false,
                                                'options' => $tIssueCategory,
                                                'empty' => 'Please Select',
                                            ]); ?>
                                        </div>
                                    </div>
                                    
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label> Ticket Form Type </label>
                                        </div>
                                        <div class="col-md-9">
                                            <?= $this->Form->control('ticket_type', [
                                                'type' => 'select',
                                                'class' => 'form-control',
                                                'label' => false,
                                                'options' => $tFormType,
                                                'empty' => 'Please Select',
                                            ]); ?>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label> Ticket Status </label>
                                        </div>
                                        <div class="col-md-9">
                                            <?= $this->Form->control('status', [
                                                'type' => 'select',
                                                'class' => 'form-control',
                                                'empty' => 'Please Select',
                                                'label' => false,
                                                'options' => $tStatus,
                                            ]); ?>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label> Token Number </label>
                                        </div>
                                        <div class="col-md-9">
                                            <?= $this->Form->control('token', [
                                                'class' => 'form-control',
                                                'label' => false,
                                                'type' => 'select',
                                                'empty' => 'Please Select',
                                                'options' => $tToken,
                                            ]); ?>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label> Reference Number</label>
                                        </div>
                                        <div class="col-md-9">
                                            <?= $this->Form->control('reference_no', [
                                                'class' => 'form-control',
                                                'label' => false,
                                                'type' => 'select',
                                                'empty' => 'Please Select',
                                                'options' => $tReference,
                                            ]); ?>
                                        </div>
                                    </div>
                                    <br>
                                    
                                    <input type="hidden" name="subtype" id="subtype" value="<?php echo $subtype; ?>">
                                    <!-- </div> -->
                                    <br>
                                    <div class="col-md-9 labelForm">
                                    <?php
                                    $excludedReportArr = array('report-statusS1', 'report-M04');
                                    if (in_array($title, $excludedReportArr)) {
                                        echo $this->Form->submit('Filter', ['class' => 'btn btn-primary mb-4', 'id' => 'formFilter-' . $title . '']);
                                    } else {
                                        echo '<input type="button" class="btn btn-primary mb-4" id="formFilter-' . $title . '" value="Filter">';
                                    }
                                    ?>
                                        <!-- End -->
                                    </div>
                                    <?= $this->Form->end(); ?>
                                    <?php
                                        break;
                                        default: {
                                    ?>
                                        <h4 class='noReport'>Report Not Found...</h4>
                                    <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Report StatusS1 Start 08-06-2023 start-->
<?php if ($title == 'report-statusS1') { ?>
    <div class="noDisplay" id="reportmone">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><?php echo $this->Html->link('Back', array('controller' => 'support-mod', 'action' => 'home'), array('class' => 'add_btn btn btn-secondary backToReport')); ?>
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <?php if ($subtype == '1') { ?>
                            <h4 class="tHeadFont" id='heading1'>Ticket Report - To Check Ticket Records - Pending ,Inprocess & Closed With Filters.</h4>
                        <?php }  ?>
                           
                        <div class="form-horizontal">
                            <div class="card-body" id="avb">
                                <h6 class="tHeadDate" id='heading2'></h6> <!-- Getting value from JS -->
                                <div class="table-responsive">
                                    <table id="list" class="table table-striped table-bordered" style="width:100%">
                                        <thead class="tableHead">
                                            <tr>
                                                <th>SR.NO.</th>
                                                <th>Token Number</th>
                                                <th>Applicant ID</th>
                                                <th>Form Module</th>
                                                <th>Ticket Issue Category</th>
                                                <th>Issue Raise By</th>
                                                <th>Issue Type</th>
                                                <th>Ticket Status</th>
                                                <th>No.Of Days</th>
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tableBody">
                                        </tbody>
                                    </table>
                                    <span class="tHeadDate">Report Generated on : <?php echo date("Y-m-d h:i:sa"); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Report StatusS1 Start 08-06-2023 End-->
<?php }  ?>

    <!-- End -->