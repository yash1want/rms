<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_mineral_work']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Mineral Worked</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Mine Code</th>
            <th>Mineral Name</th>
            <th>Mineral Sn</th>
            <th>Proportion</th>
            <th>Ore Lump</th>
            <th>Ore Fines</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($mineralWorkedLists as $mineralWorkedList) : ?>
        <tr>
            <td><?php echo $mineralWorkedList->mine_code; ?></td>
            <td><?php echo $mineralWorkedList->mineral_name; ?></td>
            <td><?php echo $mineralWorkedList->mineral_sn; ?></td>
            <td><?php echo $mineralWorkedList->proportion; ?></td>
            <td><?php echo $mineralWorkedList->ore_lump; ?></td>
            <td><?php echo $mineralWorkedList->ore_fines; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_mineral_work', $mineralWorkedList->id]) ?>"  title="Edit Mineral Worked">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_mineral_work', $mineralWorkedList->id]) ?>" class="delete_mineral_work" title="Delete Mineral Worked">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
