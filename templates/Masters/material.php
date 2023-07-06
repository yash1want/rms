<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_material']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Material</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Material Sn</th>
            <th>Material Def</th>
            <th>Material Unit</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($materialLists as $materialList) : ?>
        <tr>
            <td><?php echo $materialList->material_sn; ?></td>
            <td><?php echo $materialList->material_def; ?></td>
            <td><?php echo $materialList->material_unit; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_material', $materialList->material_sn]) ?>"  title="Edit Material">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_material', $materialList->material_sn]) ?>" class="delete_material" title="Delete Material">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
