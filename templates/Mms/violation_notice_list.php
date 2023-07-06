<?php

/**
 * Created Violation Notice List by Shweta Apale 
 */
?>
<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body pt-2 pb-3">
        <h5 class="text-center font-weight-bold text-alternate pb-1">
            <?php echo ucwords($_SESSION['sess_return_type']); ?> Violation Notice List
        </h5>
        <?= $this->Form->create(null, [
            'name' => 'violationNoticeList',
            'url' => [
                'controller' => 'mms',
                'action' => 'violation-notice-list',
            ]
        ]); ?>

        <div class="row mt-2">
            <?php if ($_SESSION['sess_return_type'] == 'monthly') { ?>
                <div class="col-md-3 pt-2">
                    <label class="font-weight-bold">Month of Returns</label>
                </div>
                <div class="col-md-3">
                    <select name="month_return" class="form-control" required>
                        <option value="" selected disabled hidden>Please Select</option>
                        <?php
                        // To get Previous 3 month dropdown depends on current month
                        $currentDate = date('d-m-Y');
                        // To check current date if current date is less than 10th of any month then will fetch previous month instead of current month
                        //if ($currentDate <= '10-' . date('m-Y')) { commented on 16-08-2022 by Shweta Apale
						if ($currentDate <= '09-' . date('m-Y')) {
                            $mB = date('Y-m', strtotime('-1 month'));
                            //for ($i = -3; $i <= 0; $i++) { commented on 16-08-2022 by Shweta Apale
							for ($i = -3; $i < 0; $i++) {
                                $monthReturns = date('Y-m', strtotime("$i month", strtotime($mB)));
                                $monthReturn = date('F Y', strtotime("$i month", strtotime($mB)));
                                echo "<option value = $monthReturns> $monthReturn </option> ";
                            }
                        } else {
                            //for ($i = -3; $i <= 0; $i++) { commented on 16-08-2022 by Shweta Apale
							for ($i = -3; $i < 0; $i++) {
                                $monthReturns = date('Y-m', strtotime("$i month", strtotime(date("Y-m"))));
                                $monthReturn = date('F Y', strtotime("$i month", strtotime(date("Y-m"))));
                                echo "<option value = $monthReturns> $monthReturn </option> ";
                            }
                        }
                        ?>
                    </select>
                </div>
            <?php } else { ?>
                <div class="col-md-3 pt-2">
                    <label class="font-weight-bold">Year of Returns</label>
                </div>
                <div class="col-md-3">
                    <?php
                    $currentDate = strtotime(date('d-m-Y'));
                    $juneDate = strtotime('10-06-' . date('Y'));
                    
                    // To check current date if current date is less than 10th of June then will fetch previous year instead of current year
                    if ($currentDate <= $juneDate) {
                        $year = date('Y', strtotime('-1 year'));
                        for ($i = $year; ($i >= ($year - 10) && $i >= 2011); $i--) {
                            $subYear = substr($i, 2);
                            $date = $i . " - " . ($subYear + 1);
                            $yearSelect[$i] = $date;
                        }
                    } else {
                        for ($i = date('Y'); ($i >= (date('Y') - 10) && $i >= 2011); $i--) {
                            $subYear = substr($i, 2);
                            $date = $i . " - " . ($subYear + 1);
                            $yearSelect[$i] = $date;
                        }
                    }
                    ?>
                    <?= $this->Form->control('year_returns', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $yearSelect,
                        'required' => true,
                        'label' => false,
                        'empty' => 'Please Select',
                    ]); ?>
                </div>
            <?php } ?>

            <div class="col-md-5 pl-5 pt-2">
                <input type="submit" class="btn btn-dark fbtn" name="violationView" id="violationView" value="View List">
                <input type="reset" class="btn btn-danger fbtn" name="reset" value="Clear">
            </div>
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
                    'action' => 'violation-notice-display',
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
                        <th class="p-1 border-right-1 border-white">NAME OF THE OWNER</th>
                        <th class="p-1 border-right-1 border-white">NOTICE SENT</th>
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
                            <td><?php echo $record['RegistrationNumber']; ?></td>
                            <td><?php echo $record['MineCode']; ?></td>
                            <td><?php echo $record['NameOfTheOwner']; ?></td>
                            <td>
                                <?php // To check Mail already sent to user or not if sent then display text
                                if (in_array($record['MineCode'], $mine)) { ?>
                                    <span class="text-success"><strong>Yes</strong></span>
                                <?php  } else { ?>
                                    <span class="text-danger"><strong>No</strong></span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
<?php } ?>