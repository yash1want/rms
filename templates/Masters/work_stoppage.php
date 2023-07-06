<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'add_work_stoppage']) ?>" class="btn btn-success backToList">Add New</a>
<a href="<?= $this->Url->build(['contorller' => 'Masters', 'action' => 'index']) ?>" class="btn btn-success backToMaster">Back</a>

<h4 class="card-title bg-primary text-white masterHeading">List of All Work Stopppage Management</h4>

<table id="commoditytable" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Storage sn</th>
            <th>Stoppage def</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php

    foreach ($workStoppageLists as $workStoppageList) :
    ?>
        <tr>
            <td><?php echo $workStoppageList->stoppage_sn; ?></td>
            <td><?php echo $workStoppageList->stoppage_def; ?></td>
            <td>
                <a href="<?= $this->Url->build(['action' => 'edit_work_stoppage', '?' => ['id' => $workStoppageList->id, 'stoppage_sn' => $workStoppageList->stoppage_sn]]) ?>" title="Edit Work Stopppage">
                    <i class="fa fa-edit"></i>
                </a> |

                <a href="<?= $this->Url->build(['action' => 'delete_work_stoppage',  '?' => ['id' => $workStoppageList->id, 'stoppage_sn' => $workStoppageList->stoppage_sn]]) ?>" class="delete_work_stoppage" title="Delete Work Stopppage">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->script('masters/confirm_alert_for_masters'); ?>
