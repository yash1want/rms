<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_rock']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Rock Management</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Rock Code</th>
            <th>Rock Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($rockLists as $rockList) : ?>
        <tr>
            <td><?php echo $rockList->id; ?></td>
            <td><?php echo $rockList->rock_code; ?></td>
            <td><?php echo $rockList->rock_name; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_rock', $rockList->id]) ?>" title="Edit Rock">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_rock', $rockList->id]) ?>" class="delete_rock" title="Delete Rock">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
