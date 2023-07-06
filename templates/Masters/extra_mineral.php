<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_extra_mineral']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Extra Mineral</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Mineral Name</th>
            <th>Unit Code</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($extraMineralLists as $extraMineralList) : ?>
        <tr>
            <td><?php echo $extraMineralList->id; ?></td>
            <td><?php echo $extraMineralList->mineral_name; ?></td>
            <td><?php echo $extraMineralList->unit_code; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_extra_mineral', $extraMineralList->id]) ?>" title="Edit Extra Mineral">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_extra_mineral', $extraMineralList->id]) ?>" class="delete_extra_mineral" title="Delete Extra Mineral">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
