<a href="<?= $this->Url->build(['controller' => 'reports','action' => 'report-list']) ?>" class="btn  backToList">Back to Report List</a>
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
                                'controller' => 'reportsnext',
                                'action' => $title,
                            ]
                        ]);
                        switch ($title) {
                            case "reportm07":
                            case "reportm08":
                            case "reportm09":
                            case "reportm34":
                            case "reportm35":
                            case "reportm07new":
                        ?>
                                <?php
                                if ($title == 'reportm07') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M12 - Mine wise Avg Daily Employment with Male/Female bifurcation</h4>
                                <?php }
                                if ($title == 'reportm07new') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M07 - Mine wise Avg Daily Employment with Male/Female bifurcation</h4>
                                <?php }
                                if ($title == 'reportm08') {
                                ?>
                                    <h4 class="card-title ttext-center mb-4 reportHeading">Report M13 - Mine wise Avg Daily Employment with Direct/Contract bifurcation</h4>
                                <?php }
                                if ($title == 'reportm09') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M14 - Mine wise/work place wise Avg Daily Employment and Total Wages paid</h4>
                                <?php }
                                if ($title == 'reportm34') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M15 - Reasons for increase/decrease in production-&lt;Month, Year&gt;</h4>
                                <?php }
                                if ($title == 'reportm35') {
                                ?>
                                    <h4 class="card-title text-center mb-4 reportHeading">Report M16 - Reasons for increase/decrease in Ex-mine Price-&lt;Month, Year&gt;</h4>
                                <?php } ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $this->Form->hidden('returnType', ['id' => 'returnType', 'value' => 'MONTHLY']); ?>
                                    </div>
                                </div>
                                <?php if(in_array($title, array('reportm07','reportm07new','reportm08','reportm09'))){ ?>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>From <span class="compulsoryField">*</span></label>
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
                                            <label>To <span class="compulsoryField">*</span></label>
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
                                <?php } else { ?>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Month & Year <span class="compulsoryField">*</span></label>
                                        </div>
                                        <div class="col-md-5">
                                            <?= $this->Form->control('month_year', [
                                                'type' => 'text',
                                                'class' => 'form-control monthDate',
                                                'label' => false,
                                                'required' => true,
                                                'placeholder' => 'MM/YYYY',
                                                'autocomplete' => 'off',
                                                //'readonly' => true,
                                                'id' => 'month_year',
                                            ]); ?>
                                        </div>
                                    </div>
                                    <br>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> Minerals</label>
                                    </div>
                                    <div class="col-md-9">
                                        <?= $this->Form->control('mineral', [
                                            'type' => 'select',
                                            'multiple' => true,
                                            'class' => 'form-control',
                                            'empty' => 'Please Select',
                                            'label' => false,
                                            'options' => $minerals,
                                        ]); ?>
                                        <span class="alert alert-secondary p-1 pl-2 pr-2 font_12 d-inline-block mt-3">
                                            <span class="text-danger font-weight-bold">Tip:</span>
                                            For multiple selection, Press <kbd class="bg-secondary">Ctrl</kbd> and select
                                        </span>
                                    </div>
                                </div>
                                <br>
                                <?php if(in_array($title, array('reportm07','reportm07new','reportm08','reportm09'))){ ?>
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
                                <?php } ?>
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