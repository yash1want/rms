<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_size_range']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Size Range</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Size Range</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($sizeRangeLists as $sizeRangeList) : ?>
        <tr>
            <td><?php echo $sizeRangeList->id; ?></td>
            <td><?php echo $sizeRangeList->size_range; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_size_range', $sizeRangeList->id]) ?>" title="Edit Size Range">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_size_range', $sizeRangeList->id]) ?>" class="delete_size_range" title="Delete Size Range">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
