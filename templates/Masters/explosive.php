<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_explosive']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Explosive</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Explosive Sn</th>
            <th>Explosive Name</th>
            <th>Explosive Unit</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($explosiveLists as $explosiveList) : ?>
        <tr>
            <td><?php echo $explosiveList->explosive_sn; ?></td>
            <td><?php echo $explosiveList->explosive_name; ?></td>
            <td><?php echo $explosiveList->explosive_unit; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_explosive', $explosiveList->explosive_sn]) ?>" title=" Edit Explosive">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_explosive', $explosiveList->explosive_sn]) ?>" class="delete_explosive" title="Delete Explosive">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
