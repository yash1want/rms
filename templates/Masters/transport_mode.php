<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_transport_mode']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Transport Mode</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Transport Mode</th>           
        </tr>
    </thead>
    <?php foreach ($transportModeLists as $transportModeList) : ?>
        <tr>
            <td><?php echo $transportModeList->id; ?></td>
            <td><?php echo $transportModeList->mode_name; ?></td>            
        </tr>
    <?php endforeach; ?>
</table>

<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>