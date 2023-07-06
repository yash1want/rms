<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_mcp_deposit']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>
 
<h4 class="card-title bg-primary text-white masterHeading">List of All MCP Deposit Management</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Id</th>
            <th>Mine Code</th>
            <th>Deposit Sn</th>
            <th>Ts Comtx Dataeposit Name</th>
            <th>Commodity Name</th>
            <th>Deposit No</th>
            <th>Block No</th>
            <th>Strike Length</th>
            <th>Dip Amount</th>
            <th>Dip Direction</th>
            <th>Width</th>
            <th>Depth</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($mcpDepositLists as $mcpDepositList) : ?>
        <tr>
            <td><?php echo $mcpDepositList->id; ?></td>
            <td><?php echo $mcpDepositList->mine_code; ?></td>
            <td><?php echo $mcpDepositList->deposit_sn; ?></td>
            <td><?php echo $mcpDepositList->ts_comtx_dataeposit_name; ?></td>
            <td><?php echo $mcpDepositList->commodity_name; ?></td>
            <td><?php echo $mcpDepositList->deposit_no; ?></td>
            <td><?php echo $mcpDepositList->block_no; ?></td>
            <td><?php echo $mcpDepositList->strike_length; ?></td>
            <td><?php echo $mcpDepositList->dip_amount; ?></td>
            <td><?php echo $mcpDepositList->dip_direction; ?></td>
            <td><?php echo $mcpDepositList->width; ?></td>
            <td><?php echo $mcpDepositList->depth; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_mcp_deposit', $mcpDepositList->id]) ?>" title="Edit MCP Deposit">
                    <i class="fa fa-edit"></i>
                </a> |
                <a href="<?= $this->Url->build(['action' => 'delete_mcp_deposit', $mcpDepositList->id]) ?>" class="delete_mcp_deposit" title="Delete MCP Deposit">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
