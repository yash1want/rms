<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_mine_code_generation']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Mines</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Mine Code</th>
            <th>Mine Name</th>
            <th>State Name</th>
            <th>District Name</th>
            <th>Village Name</th>
            <th>Taluk Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($mineLists as $mineList) : ?>
        <tr>
            <td><?php echo $mineList['mine_code']; ?></td>
            <td><?php echo $mineList['MINE_NAME']; ?></td>
            <td><?php echo $mineList['state_name']; ?></td>
            <td><?php echo $mineList['district_name']; ?></td>
            <td><?php echo $mineList['village_name']; ?></td>
            <td><?php echo $mineList['taluk_name']; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_mine_code-generation', $mineList['mine_code']]) ?>" class="edit_mine_code_details" title="Edit Mine Code">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_mine_code_generation', $mineList['mine_code']]) ?>" class="delete_mine_code_generation" title="Delete Mine Code">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters.js?version='.$version); ?>
