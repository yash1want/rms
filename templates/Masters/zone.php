<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_zone']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Zone</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Zone Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($zoneLists as $zoneList) : ?>
        <tr>
            <td><?php echo $zoneList->id; ?></td>
            <td><?php echo $zoneList->zone_name; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_zone', $zoneList->id]) ?>" title="Edit Zone">
                    <i class="fa fa-edit"></i>
                </a> |

                <a href="<?= $this->Url->build(['action' => 'delete_zone', $zoneList->id]) ?>" class="delete_zone" title="Delete Zone">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
