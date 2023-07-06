<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_metal']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>
 
<h4 class="card-title bg-primary text-white masterHeading">List of All Metal</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Metal Name</th>
            <th>Metal Def</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($metalLists as $metalList) : ?>
        <tr>
            <td><?php echo $metalList->metal_name; ?></td>
            <td><?php echo $metalList->metal_def; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_metal', $metalList->id]) ?>" title="Edit Metal">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_metal', $metalList->id]) ?>" class="delete_metal" title="Delete Metal">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
