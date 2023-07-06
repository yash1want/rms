<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_country']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Country</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Country Name</th>
            <th>DGCIS Country Code</th>
            <th>Sub Continent Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($countryLists as $countryList) : ?>
        <tr>
            <td><?php echo $countryList->id; ?></td>
            <td><?php echo $countryList->country_name; ?></td>
            <td><?php echo $countryList->dgcis_country_code; ?></td>
            <td><?php echo $countryList->sub_continent_name; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_country', $countryList->id]) ?>" title="Edit Country">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_country', $countryList->id]) ?>" class="delete_country" title="Delete Country">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
