<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_product']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Product</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Product Sn</th>
            <th>Product Def</th>
            <th>Unit </th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($productLists as $productList) : ?>
        <tr>
            <td><?php echo $productList->product_sn; ?></td>
            <td><?php echo $productList->product_def; ?></td>
            <td><?php echo $productList->unit; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_product', $productList->product_sn]) ?>" title="Edit Product">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_product', $productList->product_sn]) ?>" class="delete_product" title="Delete Product">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
