<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_stone_type']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Stone Type Management</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Stone Sn</th>
            <th>Stone Def</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($stoneTypeLists as $stoneTypeList) : ?>
        <tr>
            <td><?php echo $stoneTypeList->stone_sn; ?></td>
            <td><?php echo $stoneTypeList->stone_def; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_stone_type', $stoneTypeList->stone_sn]) ?>"  title="Edit Stone Type">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_stone_type', $stoneTypeList->stone_sn]) ?>" class="delete_stone_type" title="Delete Stone Type">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
