<a href="<?= $this->Url->build(['action' => 'report-list']) ?>" class="btn  backToList">Back to Report List</a>
<div class="tab-content">
    <div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 fsStyle ">
                        <?= $this->Form->create(null, [
                            'id' => 'monthlyFilter',
                            'url' => [
                                'controller' => 'reports',
                                'action' => $title,
                            ]
                        ]);
                        switch ($title) {
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
                            case "report-M11":
                        ?>
                                <?php
                                if ($title == 'report-M01' && $subtype == 1) {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M01A - Grade wise ROM Dispatch, ROM Ex-Mine Price, Sale Quantity and Value (For Iron Ore and Chromite)</h4>
                                <?php }
								 if ($title == 'report-M01' && $subtype == 2) {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M01B - Grade wise ROM Dispatch, ROM Ex-Mine Price, Sale Quantity and Value (Minerals other than Iron Ore and Chromite)</h4>
                                <?php }
                                if ($title == 'report-M02') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M02A - Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (For Iron Ore and Chromite)</h4>
                                <?php }
								 if ($title == 'report-M02b') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M02B - Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (Minerals other than Iron Ore and Chromite)</h4>
                                <?php }
								 if ($title == 'report-M02c') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M02C - Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (For F3 Minerals)</h4>
                                <?php }
                                if ($title == 'report-M03') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M03 - ROM Opening Stock, ROM Production & ROM Closing Stock</h4>
                                <?php }
                                if ($title == 'report-M04') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M04 - Mine to Smelter Details (Ore to Metal)</h4>
                                <?php }
                                if ($title == 'report-M05') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M05 - Sales-Dispatch Details of Ore/Concentrates</h4>
                                <?php }
                                if ($title == 'report-M06') {
                                ?>
                                    <h4 class="card-title  text-center mb-4 reportHeading">Report M06 - Opening Stock, Sale of Metal/Product and Closing Stock </h4>
                                <?php }
                                if ($title == 'report-M07') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M07 - Details of Rent/Royalty/Dead Rent/DMF/NMET</h4>
                                <?php }
                                if ($title == 'report-M08') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M08 - Precious & Semi Precious Stone ROM Production Details (Form F3)</h4>
                                <?php }
                                if ($title == 'report-M09') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M09 - Precious & Semi Precious Stone Grade wise Production Details (Form F3)</h4>
                                <?php }
                                if ($title == 'report-M10') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M10 - Precious & Semi Precious Stone Opening & Closing Stock Details (Form F3)</h4>
                                <?php }
                                if ($title == 'report-M11') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M11 - Precious & Semi Precious Stone Ex-Mine Price Details (Form F3)</h4>
                                <?php } ?>

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
                                            'class' => 'form-control monthDate',
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
                                            'class' => 'form-control monthDate',
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
                                        <label> Mineral </label>
                                    </div>
                                    <div class="col-md-9">
                                        <?= $this->Form->control('mineral', [
                                            'type' => 'select',
                                            'class' => 'form-control',
                                            'label' => false,
                                            'options' => $minerals,
                                            'empty' => 'Please Select',
                                        ]); ?>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> State </label>
                                    </div>
                                    <div class="col-md-9">
                                        <?= $this->Form->control('state', [
                                            'type' => 'select',
                                            'class' => 'form-control',
                                            'empty' => 'Please Select',
                                            'label' => false,
                                            'options' => $states,
                                        ]); ?>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> District </label>
                                    </div>
                                    <div class="col-md-9">
                                        <?= $this->Form->control('district', [
                                            'class' => 'form-control',
                                            'label' => false,
                                            'type' => 'select',
                                            'empty' => 'Please Select',
                                            'id' => 'district',
                                        ]); ?>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> IBM Registration Number</label>
                                    </div>
                                    <div class="col-md-9">
                                        <?= $this->Form->control('ibm', [
                                            'type' => 'select',
                                            'class' => 'form-control',
                                            'empty' => 'Please Select',
                                            'label' => false,
                                            'id' => 'ibm',
                                        ]); ?>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Name of Mine</label>
                                    </div>
                                    <div class="col-md-9">
                                        <?= $this->Form->control('minename', [
                                            'class' => 'form-control',
                                            'label' => false,
                                            'type' => 'select',
                                            'empty' => 'Please Select',
                                            'id' => 'minename',
                                        ]); ?>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> Name of Lease/Owner</label>
                                    </div>
                                    <div class="col-md-9">
                                        <?= $this->Form->control('owner', [
                                            'type' => 'select',
                                            'class' => 'form-control',
                                            'empty' => 'Please Select',
                                            'label' => false,
                                            'id' => 'owner',
                                        ]); ?>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> Lease Area(in Hect)</label>
                                    </div>
                                    <div class="col-md-9">
                                        <?php
                                        echo $this->Form->control('lesseearea', [
                                            'type' => 'select',
                                            'class' => 'form-control',
                                            'empty' => 'Please Select',
                                            'label' => false,
                                            'id' => 'area',
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> Mine Code</label>
                                    </div>
                                    <div class="col-md-9">
                                        <?= $this->Form->control('minecode', [
                                            'type' => 'select',
                                            'multiple' => true,
                                            'class' => 'form-control',
                                            'empty' => 'Please Select',
                                            'label' => false,
                                        ]); ?>
                                        <span class="alert alert-secondary p-1 pl-2 pr-2 font_12 d-inline-block mt-3">
                                            <span class="text-danger font-weight-bold">Tip:</span>
                                            For multiple selection, Press <kbd class="bg-secondary">Ctrl</kbd> and select
                                        </span>
                                    </div>
                                </div>
								<input type="hidden" name="subtype" value="<?php echo $subtype; ?>">
                                <!-- </div> -->
                                <br>
                                <div class="col-md-9 labelForm">
                                    <?= $this->Form->submit('Filter', ['class' => 'btn btn-primary mb-4', 'id' => 'formFilter']); ?>
                                </div>
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
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
    </div>
</div>