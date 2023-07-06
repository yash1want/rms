<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_mine_type']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Mine Type Management</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Form Type</th>
            <th>Form Def</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($mineTypeLists as $mineTypeList) : ?>
        <tr>
            <td><?php echo $mineTypeList->id; ?></td>
            <td><?php echo $mineTypeList->form_type; ?></td>
            <td><?php echo $mineTypeList->form_def; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_mine_type', $mineTypeList->id]) ?>"  title="Edit Mine Type">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_mine_type', $mineTypeList->id]) ?>" class="delete_mine_type" title="Delete Mine Type">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
