<a href="<?= $this->Url->build(['action' => 'report-list']) ?>" class="btn  backToList">Back to Report List</a>
<div class="tab-content">
    <div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 fsStyle ">
                        <?= $this->Form->create(null, [
                            'id' => 'annualFilter',
                            'url' => [
                                'controller' => 'reports',
                                'action' => $title,
                            ]
                        ]);
                        switch ($title) {
                            case "report-A01":
                            case "report-A02":
							case "report-A02b":
							case "report-A02c":
                            case "report-A03":
                            case "report-A04":
                            case "report-A05":
                            case "report-A06":
                            case "report-A07":
                            case "report-A08":
                            case "report-A09":
                            case "report-A10":
                            case "report-A11":
                            case "report-A12":
                            case "report-A13":
                            case "report-A14":
                            case "report-A15":
                            case "report-A16":
                            case "report-A17":
                            case "report-A18":
                        ?>
                                <?php
                                if ($title == 'report-A01' && $subtype == 1) {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A01A - Grade wise ROM Dispatch, ROM Ex-Mine Price, Sale Quantity and Value (For Iron Ore and Chromite)</h4>
                                <?php }
								if ($title == 'report-A01' && $subtype == 2) {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A01B - Grade wise ROM Dispatch, ROM Ex-Mine Price, Sale Quantity and Value (Minerals other than Iron Ore and Chromite)</h4>
                                <?php }
                                if ($title == 'report-A02') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A02A - Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (For Iron Ore and Chromite)</h4>
                                <?php }
								if ($title == 'report-A02b') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A02B - Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (Minerals other than Iron Ore and Chromite)</h4>
                                <?php }
								if ($title == 'report-A02c') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A02C - Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (For F3 Minerals)</h4>
                                <?php }
                                if ($title == 'report-A03') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A03 - ROM Opening Stock, ROM Production & ROM Closing Stock</h4>
                                <?php }
                                if ($title == 'report-A04') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A04 - Mine to Smelter Details (Ore to Metal)</h4>
                                <?php }
                                if ($title == 'report-A05') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A05 - Dispatch Details Ore/Concentrates</h4>
                                <?php }
                                if ($title == 'report-A06') {
                                ?>
                                    <h4 class="card-title  text-center mb-4 reportHeading">Report A06 - Sale of Metal/Prouct during the Month</h4>
                                <?php }
                                if ($title == 'report-A07') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A07 - Details of Rent/Royalty/Dead Rent/DMF/NMET</h4>
                                <?php }
                                if ($title == 'report-A08') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A08 - Precious & Semi Precious Stone ROM Production Details( Form F3)</h4>
                                <?php }
                                if ($title == 'report-A09') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A09 - Precious & Semi Precious Stone Production Details (Form F3)</h4>
                                <?php }
                                if ($title == 'report-A10') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A10 - Precious & Semi Precious Stone Opening & Closing Stock Details (Form F3)</h4>
                                <?php }
                                if ($title == 'report-A11') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A11 - Precious & Semi Precious Stone Ex-Mine Price Details (Form F3)</h4>
                                <?php }
                                if ($title == 'report-A12') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A12 - Reserve & Resources</h4>
                                <?php }
                                if ($title == 'report-A13') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A13 - Subgrade-Mineral Reject Details</h4>
                                <?php }
                                if ($title == 'report-A14') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A14 - Tree planted /Survival Rate</h4>
                                <?php }
                                if ($title == 'report-A15') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A15 - Cost of Production</h4>
                                <?php }
                                if ($title == 'report-A16') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A16 - Lease area (surface area) Utilization (in hect) at the end of year</h4>
                                <?php }
                                if ($title == 'report-A17') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A17 - Miscleaneous</h4>
                                <?php }
                                if ($title == 'report-A18') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report A18 - Machinary used in the Mine</h4>
                                <?php }?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'ANNUAL']); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><span class="compulsoryField">*</span> Period </label>
                                    </div>
                                    <div class="col-md-9">
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
                                    <?= $this->Form->submit('Filter', ['class' => 'btn btn-primary mb-4', 'id' => 'annualFormFilter']); ?>
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