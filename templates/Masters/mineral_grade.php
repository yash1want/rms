<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_mineral_grade']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Mineral Grade Management</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Mineral Name</th>
            <th>Grade Code</th>
            <th>Grade Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($mineralGradeLists as $mineralGradeList) : ?>
        <tr>
            <td><?php echo $mineralGradeList->id; ?></td>
            <td><?php echo $mineralGradeList->mineral_name; ?></td>
            <td><?php echo $mineralGradeList->grade_code; ?></td>
            <td><?php echo $mineralGradeList->grade_name; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_mineral_grade', $mineralGradeList->id]) ?>" title="Edit Mineral Grade">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_mineral_grade', $mineralGradeList->id]) ?>" class="delete_mineral_grade" title="Delete Mineral Grade">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
