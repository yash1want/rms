<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_concentrate']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Type Conentrate Management</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Type Concenrate</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($concentrateLists as $concentrateList) : ?>
        <tr>
            <td><?php echo $concentrateList->type_concentrate; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_concentrate', $concentrateList->id]) ?>" title="Edit Concenrate">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_concentrate', $concentrateList->id]) ?>" class="delete_concentrate" title="Delete Concenrate">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>