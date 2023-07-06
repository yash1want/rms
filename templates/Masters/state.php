<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_state']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All State</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>State Code</th>
            <th>State Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($stateLists as $stateList) : ?>
        <tr>
            <td><?php echo $stateList->id; ?></td>
            <td><?php echo $stateList->state_code; ?></td>
            <td><?php echo $stateList->state_name; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_state', $stateList->id]) ?>" title="Edit State">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_state', $stateList->id]) ?>" class="delete_state" title="Delete State">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
