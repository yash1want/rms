<div class="main-card card fcard mb-1 mt-n3">
	<div class="card-body pt-2 pb-3 pt-4">
		<?php echo $this->Form->create(null, array('type' => 'file', 'enctype' => 'multipart/form-data', 'class' => 'form-group')); ?>
            <div class="row">
                <div class="col-md-3 pt-2">
                    <div class="custom-radio custom-control">
                        <label class="font-weight-bold">Logs Period Range</label>						
                    </div>
                </div>
                <div class="col-md-3 pr-2">
                    <div class="input-group f-control search_f_control"><input placeholder="From Date" name="from_date" id="from_date_log" type="date" class="form-control" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $from_date; ?>" required>
                        <div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
                    </div>
                </div>				
                <div class="col-md-3 pr-2">	
                    <div class="input-group f-control search_f_control"><input placeholder="To Date" name="to_date" id="to_date_log" type="date" class="form-control" min="<?php echo $from_date; ?>" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $to_date; ?>" required>
                        <div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
                    </div>
                </div>	
				
                <div class="col-md-3 pl-5 pt-2">
                    <input type="submit" class="btn btn-dark" name="log_search" value="View Details">
                    <input type="reset" class="btn btn-danger" name="reset" value="Clear">
                </div>
            </div>
			<div class="row pt-2">
				<div class="col-md-3 pt-2">
                    <div class="custom-radio custom-control">
                        <label class="font-weight-bold">Username</label>						
                    </div>
                </div>
				<div class="col-md-2 pr-2">	
                    <div class="input-group f-control search_f_control"><input placeholder="Enter username" name="user_id" id="user_id" type="text" class="form-control">
                        
                    </div>
                </div>
			</div>
            <?php echo $this->Html->script('auth/logs.js?version='.$version); ?>

		<?php echo $this->Form->end(); ?>
	</div>
</div>
<div class="main-card mb-3 card">
	<div class="card-body">
		<h5 class="card-title">USER LOGS (<?php echo $log_filtered_txt; ?>)</h5>
		<div class="table-responsive">
            <table class="mb-0 table table-striped " id="list">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="p-1 border-right-1 border-white">Sr</th>
                        <th class="p-1 border-right-1 border-white">Username</th>
                        <th class="p-1 border-right-1 border-white">Login Date Time</th>
                        <th class="p-1 border-right-1 border-white">Logout Date Time</th>                        
                        <th class="p-1 border-right-1 border-white">Remark</th>
                        <th class="p-1 border-right-1 border-white">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($logdata != 'filterDataTampared') {
                        $j = 1;
                        if(!empty($logdata)){ 
                            foreach($logdata as $each){  

                                    if (filter_var($each['uname'], FILTER_VALIDATE_EMAIL)) {
                                        $each['email'] = base64_encode($each['uname']);
                                    }
							
									if($each['email'] != ''){
										$email = base64_decode($each['email']);
										$mail_first=explode('@',$email);
										
										$arr=str_split($mail_first[0]);
										$mask=array();

										for($i=0;$i<count($arr);$i++) {
											if($i%2!=0) {
												$arr[$i]='*';
											}

											$mask[]=$arr[$i];
										}
										$mask=join($mask).'@'.$mail_first[1];
									}else{
										$mask = '';
									}
                                ?>
                                <tr>
                                    <td><?php echo $j; ?></td>
                                    <td><?php echo $mask; ?></td>
                                    <td><?php echo (!empty($each['login_time'])) ? date('d-m-Y h:i A',strtotime($each['login_time'])) : '--'; ?></td>
                                    <td><?php echo (!empty($each['logout_time'])) ? date('d-m-Y h:i A',strtotime($each['logout_time'])) : '--'; ?></td>
                                    <td><?php echo ($this->getRequest()->getSession()->read('login_session') == $each['session_token']) ? '<span class="badge badge-success">CURRENT SESSION</span>' : (($each['status'] == 'FULL') ? 'SUCCESS' : $each['status']); ?></td>      
                                    <td><?php echo $each['ip_address']; ?></td>
                                </tr>
                                <?php 
                                $j++;
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
		</div>
	</div>
</div>