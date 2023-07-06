<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_finished_product']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Finished Products Management</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Sr. no</th>
            <th>Finished Products</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($finish_products_list as $finish_products_list) : ?>
        <tr>
            <td><?php echo $finish_products_list->id; ?></td>
            <td><?php echo $finish_products_list->f_products; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_finished_product', $finish_products_list->id]) ?>" title="Edit Template">
                    <i class="fa fa-edit"></i>
                </a> 
                    |
                <a href="<?= $this->Url->build(['action' => 'delete_finished_product', $finish_products_list->id]) ?>" class="delete_finished_product" title="Delete Template">
                    <i class="fas fa-trash"></i>
                </a> 
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
