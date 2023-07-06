<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_region']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Region</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Region Name</th>
            <th>Zone Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($regionLists as $regionList) : ?>
        <tr>
            <td><?php echo $regionList->id; ?></td>
            <td><?php echo $regionList->region_name; ?></td>
            <td><?php echo $regionList->zone_name; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_region', $regionList->id]) ?>" title="Edit Region">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_region', $regionList->id]) ?>" class="delete_region" title="Delete Region">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
