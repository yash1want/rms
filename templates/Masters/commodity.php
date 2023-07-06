<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_commodity']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Commodity</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Commodity Name</th>
            <th>Unit Code</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($commodityArrs as $commodityArr) : ?>
        <tr>
            <td><?php echo $commodityArr->id; ?></td>
            <td><?php echo $commodityArr->commodity_name; ?></td>
            <td><?php echo $commodityArr->unit_code; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_commodity', $commodityArr->id]) ?>" title="Edit Commodity">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_commodity', $commodityArr->id]) ?>" class="delete_commodity" title="Delete Commodity">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>