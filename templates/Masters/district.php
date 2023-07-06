<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_district']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All District</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>State Code</th>
            <th>District Name</th>
            <th>Region Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($districtLists as $districtList) : ?>
        <tr>
            <td><?php echo $districtList->state_code; ?></td>
            <td><?php echo $districtList->district_name; ?></td>
            <td><?php echo $districtList->region_name; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_district', $districtList->id]) ?>" title="Edit District">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_district', $districtList->id]) ?>" class="delete_district" title="Delete District">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
