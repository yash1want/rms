<div class="main-card card fcard mb-1 mt-n3">
    <div class="card-body">
        <div class="rows"><h4 class="text-center font-weight-bold text-alternate">Users List</h4>            
        </div>
    </div>
</div>
<?php echo $this->Form->create(null, array('type' => 'file' ,'id'=>'level2userform')); ?>   
<div class="main-card mb-3 card">
		<div class="card-body">			
			<div class="table-responsive">
				<table class="mb-0 table table-striped" id="level2user">
					<thead class="bg-dark text-white">
                        <tr>
                            <th class="p-1 border-right-1 border-white">#</th>						
                            <th class="p-1 border-right-1 border-white">User Name</th>
                            <th class="p-1 border-right-1 border-white">User Type</th>
                            <th class="p-1 border-right-1 border-white">Email</th> 
                            <th class="p-1 border-right-1 border-white">Action</th>
                        </tr>
					</thead>    
                                   
                        <tbody>
                            <?php $i=1; if(isset($level2users)){
                                    foreach($level2users as $each){ ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>							
                                    <td>
                                        <?php echo ucfirst($each['mcbd_mine_name']); 
                                        if($each['mcbd_desc']== "Mining"){
                                            echo " (".$each['mcmd_mine_code'].")";
                                        } else if($each['userid'] && $each['actionlabel'] == 'Regenerate') {
                                            echo " (".$each['userid'].")";
                                        }?>
                                    </td>
                                    <td><?php echo $level2usertype[$each['mcbd_desc']]; ?></td>
                                    <td><?php echo $this->Form->control('email', array('type' => 'email','value'=>$each['useremail'], 
                                                                                        'class'=>'cvOn cvReq cvEmail form-control',
                                                                                        'id'=>'email'.$i,'required','placeholder'=>'Enter Email','label'=>false)); ?>
                                        <div class="err_cv"></div>                                                
                                    </td> 
                                    <td>
                                        <input type="hidden" name= "userid" value="<?php echo $each['userid']?>">
                                        <input type="hidden" name= "level2usrid" value="<?php echo $each['level2usrid']?>">
                                        <input type="hidden" name= "level2type" value="<?php echo $each['mcbd_desc']?>">
                                        <button type="button" class="btn btn-info genbtn" style='font-size:0.8rem; font-weight:bold' ><?php echo $each['actionlabel']?></button>
                                    </td>							
                                </tr>
                            <?php $i++; } } ?>
                        </tbody>
				</table>			
			</div>
		</div>
	</div>
    <?php $this->Form->end() ?>  
    <?php echo $this->Html->script('auth/level2_users'); ?>