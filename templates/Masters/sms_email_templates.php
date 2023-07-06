<?php ?>
<!-- <a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_sms_email_templates']) ?>" class="btn btn-success backToList">Add New</a> -->
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success mb-2">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All SMS/Email Templates</h4>
<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Sr.No</th>
            <th>Template</th>
            <th>Created By</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php foreach ($smsEmailTemplatesList as $smsEmailTemplates) : ?>
        <tr>
            <td><?php echo $smsEmailTemplates->id; ?></td>
            <td><?php echo $smsEmailTemplates->sms_message; ?></td>
            <td><?php echo $smsEmailTemplates->user_email_id; ?></td>
            <td><?php $remark = $smsEmailTemplates->status;
                    if ($remark == 'active'){
                        $badge = "success";
                    }elseif ($remark == 'disactive'){
                        $badge = "danger";
                    }else{
                        $badge = "info";
                    }
                    
                    echo "<span class='badge badge-".$badge."'>".$remark."</span>";
                ?>
            </td>
            
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_template', $smsEmailTemplates->id]) ?>" title="Edit Template">
                    <i class="fa fa-edit"></i>
                </a> |
               <?php if ($smsEmailTemplates->status == 'active') { ?>
                    <a href="<?= $this->Url->build(['action' => 'changeTemplateStatus', $smsEmailTemplates->id]) ?>" class="deactivate_template" title="Deactivate Template">
                        <i class="fas fa-minus-circle"></i>
                    </a>
                <?php } else { ?>
                    <a href="<?= $this->Url->build(['action' => 'changeTemplateStatus', $smsEmailTemplates->id]) ?>" class="activate_template" title="Activate Template">
                        <i class="fas fa-check"></i>
                    </a>
               <?php } ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>

