<?php

/**
 * Created Violation Notice Serve by Shweta Apale on 03-03-2022
 */
?>
<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body pt-2 pb-3">
        <h5 class="text-center font-weight-bold text-alternate pb-1">
            <?php echo ucwords($_SESSION['sess_return_type']); ?> Violation Notice Sent
        </h5>
        <?= $this->Form->create(null, [
            'name' => 'violationNoticeServe',
            'url' => [
                'controller' => 'mms',
                'action' => 'violation-notice-serve',
            ]
        ]); ?>

        <div class="row mt-2">
            <?php if ($_SESSION['sess_return_type'] == 'monthly') { ?>
                <div class="col-md-3 pt-2">
                    <label class="font-weight-bold">Month of Returns</label>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('month_return', [
                        'type' => 'text',
                        'class' => 'form-control monthDate',
                        'label' => false,
                        'required' => true,
                        'placeholder' => 'MM/YYYY',
                        'autocomplete' => 'off',
                        'id' => 'f_date',
                    ]); ?>
                </div>
                <div class="col-md-3 pt-2">
                    <label class="font-weight-bold">Mine Code</label>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('mine_code', [
                        'type' => 'text',
                        'class' => 'form-control',
                        'label' => false,
                    ]); ?>
                </div>
            <?php } else { ?>
                <div class="col-md-3 pt-2">
                    <label class="font-weight-bold">Year of Returns</label>
                </div>
                <div class="col-md-3">
                    <?php
                    for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                        $subYear = substr($i, 2);
                        $date = $i . " - " . ($subYear + 1);
                        $yearSelect[$i] = $date;
                    }
                    ?>
                    <?= $this->Form->control('year_returns', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                        'id' => 'from_year',
                    ]); ?>
                </div>
                <div class="col-md-3 pt-2">
                    <label class="font-weight-bold">Mine Code</label>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('mine_code', [
                        'type' => 'text',
                        'class' => 'form-control',
                        'label' => false,
                    ]); ?>
                </div>
            <?php } ?>

            <div class="col-md-5 pl-5 pt-2">
                <input type="submit" class="btn btn-dark fbtn" name="violationView" id="violationView" value="View List">
                <input type="reset" class="btn btn-danger fbtn" name="reset" value="Clear">
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
    <?php if (!empty($records)) { ?>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <?php if ($_SESSION['sess_return_type'] == 'monthly') { ?>
                    <h6 class="font-weight-bold text-alternate pb-1"> Month of Returns : <?php echo $month_return; ?></h6>
                <?php } else { ?>
                    <h6 class="font-weight-bold text-alternate pb-1"> Year of Returns : <?php echo $year_return_display; ?></h6>
                <?php } ?>
                <?= $this->Form->create(null, [
                    'name' => 'violationNoticeList',
                    'url' => [
                        'controller' => 'mms',
                        'action' => 'violation-notice-serve-display',
                    ]
                ]); ?>
                <input type="hidden" name="return_type" value="<?php echo $_SESSION['sess_return_type']; ?>">
                <?php if ($_SESSION['sess_return_type'] == 'monthly') { ?>
                    <input type="hidden" name="month_return" value="<?php echo $month_return; ?>">
                <?php } else { ?>
                    <input type="hidden" name="year_return" value="<?php echo $year_return_display; ?>">
                <?php } ?>
                <table class="mb-0 table table-striped return_list_table tableViolation" id="violationListServe">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="p-1 border-right-1 border-white">#</th>
                            <th class="p-1 border-right-1 border-white">REG. NO</th>
                            <th class="p-1 border-right-1 border-white">MINE CODE</th>
                            <?php if ($_SESSION['sess_return_type'] == 'monthly') { ?>
                                <th class="p-1 border-right-1 border-white">MONTH OF RETURN</th>
                            <?php } else { ?>
                                <th class="p-1 border-right-1 border-white">YEAR OF RETURN</th>
                            <?php } ?>
                            <th class="p-1 border-right-1 border-white">EMAIL ID</th>
                            <th class="p-1 border-right-1 border-white">MAIL SENT DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($records as $record) {
                            $i++;
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $record['registration_no']; ?></td>
                                <td><?php echo $record['mine']; ?></td>
                                <?php if ($_SESSION['sess_return_type'] == 'monthly') { ?>
                                    <td><?php echo date('F', mktime(0, 0, 0, $record['showMonth'], 10)) . ' ' . $record['showYear']; ?></td>
                                <?php } else { ?>
                                    <td><?php echo $year_return_display; ?></td>
                                <?php } ?>
                                <td><?php echo $record['email_id']; ?></td>
                                <td><?php echo $record['mail_date']; ?></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>