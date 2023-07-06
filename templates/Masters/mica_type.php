<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_mica_type']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Mica Type Management</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Mica Sn</th>
            <th>Mica Def</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($micaTypeLists as $micaTypeList) : ?>
        <tr>
            <td><?php echo $micaTypeList->mica_sn; ?></td>
            <td><?php echo $micaTypeList->mica_def; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_mica_type', $micaTypeList->mica_sn]) ?>"  title="Edit Mica Type">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_mica_type', $micaTypeList->mica_sn]) ?>" class="delete_mica_type" title="Delete Mica Type">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
