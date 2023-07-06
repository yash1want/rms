<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_smelter_step']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Smelter Step Management</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Smelter Step Sn</th>
            <th>Smelter Step Def</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($smelteStepLists as $smelteStepList) : ?>
        <tr>
            <td><?php echo $smelteStepList->smelter_step_sn; ?></td>
            <td><?php echo $smelteStepList->smelter_step_def; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_smelter_step', $smelteStepList->smelter_step_sn]) ?>"  title="Edit Smelter Step">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_smelter_step', $smelteStepList->smelter_step_sn]) ?>" class="delete_smelter_step" title="Delete Smelter Step">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
