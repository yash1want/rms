<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_rom_step']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Rom 5 Step</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Rom 5 Step Sn</th>
            <th>Rom 5 Step Def</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($rom5StepLists as $rom5StepList) : ?>
        <tr>
            <td><?php echo $rom5StepList->rom_5_step_sn; ?></td>
            <td><?php echo $rom5StepList->rom_5_step_def; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_rom_step', $rom5StepList->rom_5_step_sn]) ?>" title="Edit Rom 5 Step">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_rom_step', $rom5StepList->rom_5_step_sn]) ?>" class="delete_rom_step" title="Delete Rom 5 Step">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
