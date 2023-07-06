
<?php
$display_history = false;
// $total_reasons = count($reasons);
// if ($total_reasons > 0)
//   $display_history = true;

if(isset($reasons_old[0]) && ($reasons_old[0] != null || $reasons_old[0] !='')){
    // if($reasons[0] == null || $reasons[0] ==''){
    $display_history = true;
}
?>

<?php if ($display_history == true) { ?>
    <div class="card comment_card">
        <div class="form-group">
            <div class="card-header comment_header bg-secondary text-white">
			    <i class="fa fa-comments header-icon"> </i>
                <?php echo $commentLabel['title']; ?>
                <div class="btn-actions-pane-right">
                </div>
            </div>
            <div class="container cmnt-main">

                <div class="referred-back-history mt-3">
                    <table align="center" class="referred-back-history-table table table-bordered v_a_base_td" id="cmnt-table">
                        <thead class="thead-light">
                            <tr>
                                <th class="w-50">Comment By You</th>
                                <th class="w-50">Comment By Scrutinizer</th>
                            </tr>
                        </thead>
                        <?php
                        // old comment history
                        if(count($reasons_old) > 0){
                            foreach ($reasons_old as $reason) { 
                            ?>
                                <tr>
                                    <td>
                                        <?php if(isset($reason[$commentLabel['comment']]) && $reason[$commentLabel['comment']] != ""){ ?>
                                            <span class="badge badge-reason"><i class="pe-7s-date"></i> <?php echo date('d-m-Y h:i A', strtotime($reason[$commentLabel['comment_date']])); ?></span><br><br>
                                            <?php echo $reason[$commentLabel['comment']]; ?>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if(isset($reason[$commentLabel['other_comment']]) && $reason[$commentLabel['other_comment']] != ""){ ?>
                                            <span class="badge badge-reason"><i class="pe-7s-date"></i> <?php echo date('d-m-Y h:i A', strtotime($reason[$commentLabel['other_comment_date']])); ?></span><br><br>
                                            <?php echo $reason[$commentLabel['other_comment']]; ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
							
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } ?>