<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_unit']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Unit</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Unit Code</th>
            <th>Unit Def</th>
            <th>DGCIS Unit Code</th>
            <th>DGCIS Unit Def</th>
            <th>WMI Unit Def</th>
            <th>MCP Unit Def</th>
            <th>Conversion Factor</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($unitLists as $unitList) : ?>
        <tr>
            <td><?php echo $unitList->id; ?></td>
            <td><?php echo $unitList->unit_code; ?></td>
            <td><?php echo $unitList->unit_def; ?></td>
            <td><?php echo $unitList->dgcis_unit_code; ?></td>
            <td><?php echo $unitList->dgcis_unit_def; ?></td>
            <td><?php echo $unitList->wmi_unit_def; ?></td>
            <td><?php echo $unitList->mcp_unit_def; ?></td>
            <td><?php echo $unitList->conversion_factor; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_unit', $unitList->id]) ?>" title="Edit Unit">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_unit', $unitList->id]) ?>" class="delete_unit" title="Delete Unit">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
