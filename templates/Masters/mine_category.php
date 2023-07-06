<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_mine_category']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>
 
<h4 class="card-title bg-primary text-white masterHeading">List of All Mine Category</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Mine Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($mineCategoryLists as $mineCategoryList) : ?>
        <tr>
            <td><?php echo $mineCategoryList->mine_category; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_mine_category', $mineCategoryList->id]) ?>"  title="Edit Mine Category">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_mine_category', $mineCategoryList->id]) ?>" class="delete_mine_category" title="Delete Mine Category">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
