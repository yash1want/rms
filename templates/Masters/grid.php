<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_grid']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Grid</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Grid Name</th>
            <th>Grid Unit</th>
            <th>Grid Space</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($gridLists as $gridList) : ?>
        <tr>
            <td><?php echo $gridList['grid_name']; ?></td>
            <td><?php echo $gridList['unit_code']; ?></td>
            <td><?php echo $gridList['grid_space']; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_grid', $gridList['id']]) ?>" title="Edit Grid">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_grid', $gridList['id']]) ?>" class="delete_grid" title="Delete Grid">
                    <i class="fas fa-trash"></i>
                </a>
            </td>

        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>