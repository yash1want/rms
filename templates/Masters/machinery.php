<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_machinery']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>
 
<h4 class="card-title bg-primary text-white masterHeading">List of All Machinery</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Machinery Code</th>
            <th>Macinery Name</th>
            <th>Capacity Unit</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($machineryLists as $machineryList) : ?>
        <tr>
            <td><?php echo $machineryList->machinery_code; ?></td>
            <td><?php echo $machineryList->machinery_name; ?></td>
            <td><?php echo $machineryList->capacity_unit; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_machinery', $machineryList->id]) ?>" title="Edit Machinery">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_machinery', $machineryList->id]) ?>" class="delete_machinery" title="Delete Machinery">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
