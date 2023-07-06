<?php ?>

<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body"><h5 class="card-title">REFERRED BACK RETURNS</h5>
                <table class="mb-0 table" id="rejected-return-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>
                        	<?php if ($returnType == 'MONTHLY') { ?>
		                        Month/Year
		                    <?php } else { ?>
		                        Financial Year
		                    <?php } ?>
                    	</th>
                        <th>Mine Code</th>
                        <th>Date of Submission</th>
                        <th>Status Date</th>
                        <th>Referred Back Sections</th>
                        <th>No. of Times Referred Back</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i = 1;
                    foreach ($returns as $r) { ?>
                    <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td><?php echo $r['month_year']; ?></td>
                        <td><?php echo $r['mine_code']; ?></td>
                        <td><?php echo $r['final_submitted_date']; ?></td>
                        <td><?php echo $r['status_date']; ?></td>
                        <td><?php echo $r['rejected_sections']; ?></td>
                        <td><?php echo $r['total_referred_back']; ?></td>
                        <td>
                            <?php
                            if ($mineOwner == FALSE) {
                                if ($r['status'] == 4) {
                                    // echo link_to('View', 'default/redirectRejectedReturns?id=' . base64_encode($r['return_id']));
                                    echo $this->Html->link('View', '/monthly/redirectRejectedReturns/'.base64_encode($r['return_id']), array('class'=>'btn btn-info'));
                                } else {
                                    // echo link_to('View', 'monthly/printAll?mc=' . $r['mine_code'] . "&date=" . $r['return_date'] . "&return_type=" . $r['return_type'] . "&min=" . strtolower(str_replace(' ', '_', $mineral)));
                                    echo $this->Html->link('View', '/monthly/printAll/'.$r['mine_code'].'/'.$r['return_date'].'/'.$r['return_type'].'/'.strtolower(str_replace(' ', '_', $mineral)), array('class'=>'btn btn-info'));
                                }

                            } else {
                                // echo link_to('View', 'monthly/printAll?mc=' . $r['mine_code'] . "&date=" . $r['return_date'] . "&return_type=" . $r['return_type'] . "&min=" . strtolower(str_replace(' ', '_', $mineral)));
                                    echo $this->Html->link('View', '/monthly/printAll/'.$r['mine_code'].'/'.$r['return_date'].'/'.$r['return_type'].'/'.strtolower(str_replace(' ', '_', $mineral)), array('class'=>'btn btn-info'));
                            }
                            ?>
                        </td>
                    </tr>
                	<?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
