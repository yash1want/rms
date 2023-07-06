<?php

/**
 * Created Activity Type List by Shweta Apale 
 */
?>
<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body pt-2 pb-3">
        <h5 class="text-center font-weight-bold text-alternate pb-1">
            Null Activity Type List
        </h5>
        <?= $this->Form->create(null, [
            'name' => 'activityType',
            'url' => [
                'controller' => 'activity-type',
                'action' => 'activity',
            ]
        ]); ?>

        <div class="row mt-2">
            <div class="col-md-3">
                <label class="font-weight-bold">Applicant Id</label>
            </div>
            <div class="col-md-3">
                <?php echo $this->Form->control('applicant_id', array('type' => 'text', 'class' => 'form-control f-control search_f_control', 'id' => 'appliacnt_id', 'label' => false)); ?>
            </div>
            <div class="col-md-5 pl-5 pt-2">
                <input type="submit" class="btn btn-dark fbtn" name="f_search" id="f_search" value="View List">
                <input type="reset" class="btn btn-danger fbtn" name="reset" value="Clear">
            </div>
        </div>

        <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php if (!empty($records)) { ?>
    <div class="main-card mb-3 card">
        <div class="card-body">

            <?= $this->Form->create(null, [
                'name' => 'activityList',
                'url' => [
                    'controller' => 'activity-type',
                    'action' => 'edit-activity',
                ]
            ]); ?>

            <table class="mb-0 table table-striped return_list_table tableViolation" id="violationListServe">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="p-1 border-right-1 border-white">#</th>
                        <th class="p-1 border-right-1 border-white">APPLICANT ID WITH NULL ACTIVITY</th>
                        <th class="p-1 border-right-1 border-white">EMAIL</th>
                        <th class="p-1 border-right-1 border-white">ACTION</th>
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
                            <td><?php echo $record['applicant_id']; ?></td>
                            <td><?php echo base64_decode($record['mcu_email']); ?></td>

                            <td>                                                          
                                <input type="hidden" name="applicant_id" value="<?php echo $record['applicant_id']; ?>">
                                <a href="<?= $this->Url->build(['action' => 'edit-activity', '?' => ['id' => $record['applicant_id']]]) ?>" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
<?php } ?>