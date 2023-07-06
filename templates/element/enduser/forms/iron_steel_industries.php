
<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>
<h5 class="text-center text-primary font_15"><?php echo $label[0]; ?></h5>
<h5 class="text-center font_15 font_bold"><?php echo $label[1]; ?></h5>
<div class="position-relative row form-group mine-group">

	<div class="col-sm-12 mine-m-auto">
		<table class="table table-bordered table-sm">
			<thead class="bg-secondary text-white text-center">
				<tr>
					<th rowspan="2" class="v_a_mid"><?php echo $label[2]; ?></th>
					<th rowspan="2" class="v_a_mid"><?php echo $label[3]; ?></th>
					<th colspan="2"><?php echo $label[4]; ?></th>
					<th rowspan="2" class="v_a_mid"><?php echo $label[7]; ?></th>
				</tr>
				<tr>
					<th><?php echo $label[5]; ?></th>
					<th><?php echo $label[6]; ?></th>
				</tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_26p"><?php echo $label['a']; ?></td>
                                <td><?php echo $label[8]; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_22p"></td>
                                <td class="w_22p">i)</td>
                                <td><?php echo $label[9]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_1', array('type'=>'hidden', 'id'=>'prod_name_1', 'label'=>false, 'value'=>'Self fluxing')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_1', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_1', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_1'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_1', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_1', 'label'=>false, 'value'=>$ironData['prev_year_prod_1'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_1', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_1', 'label'=>false, 'value'=>$ironData['pres_year_prod_1'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_1', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_1', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_1'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_22p"></td>
                                <td class="w_22p">ii)</td>
                                <td><?php echo $label[10]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_2', array('type'=>'hidden', 'id'=>'prod_name_2', 'label'=>false, 'value'=>'Ordinary')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_2', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_2', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_2'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_2', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_2', 'label'=>false, 'value'=>$ironData['prev_year_prod_2'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_2', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_2', 'label'=>false, 'value'=>$ironData['pres_year_prod_2'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_2', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_2', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_2'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_26p"><?php echo $label['b']; ?></td>
                                <td><?php echo $label[11]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_3', array('type'=>'hidden', 'id'=>'prod_name_3', 'label'=>false, 'value'=>'Pellets')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_3', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_3', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_3'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_3', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_3', 'label'=>false, 'value'=>$ironData['prev_year_prod_3'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_3', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_3', 'label'=>false, 'value'=>$ironData['pres_year_prod_3'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_3', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_3', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_3'])); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_26p"><?php echo $label['c']; ?></td>
                                <td><?php echo $label[12]; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_22p"></td>
                                <td class="w_22p">i)</td>
                                <td><?php echo $label[13]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_4', array('type'=>'hidden', 'id'=>'prod_name_4', 'label'=>false, 'value'=>'Clean coal')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_4', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_4', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_4'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_4', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_4', 'label'=>false, 'value'=>$ironData['prev_year_prod_4'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_4', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_4', 'label'=>false, 'value'=>$ironData['pres_year_prod_4'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_4', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_4', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_4'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_22p"></td>
                                <td class="w_22p">ii)</td>
                                <td><?php echo $label[14]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_5', array('type'=>'hidden', 'id'=>'prod_name_5', 'label'=>false, 'value'=>'Coke own production')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_5', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_5', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_5'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_5', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_5', 'label'=>false, 'value'=>$ironData['prev_year_prod_5'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_5', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_5', 'label'=>false, 'value'=>$ironData['pres_year_prod_5'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_5', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_5', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_5'])); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_26p"><?php echo $label['d']; ?></td>
                                <td><?php echo $label[15]; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_22p"></td>
                                <td class="w_22p">i)</td>
                                <td><?php echo $label[16]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_6', array('type'=>'hidden', 'id'=>'prod_name_6', 'label'=>false, 'value'=>'Hot metal')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_6', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_6', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_6'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_6', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_6', 'label'=>false, 'value'=>$ironData['prev_year_prod_6'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_6', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_6', 'label'=>false, 'value'=>$ironData['pres_year_prod_6'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_6', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_6', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_6'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_22p"></td>
                                <td class="w_22p">ii)</td>
                                <td><?php echo $label[17]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_7', array('type'=>'hidden', 'id'=>'prod_name_7', 'label'=>false, 'value'=>'Hot metal for own consumption')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_7', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_7', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_7'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_7', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_7', 'label'=>false, 'value'=>$ironData['prev_year_prod_7'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_7', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_7', 'label'=>false, 'value'=>$ironData['pres_year_prod_7'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_7', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_7', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_7'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_22p"></td>
                                <td class="w_22p">iii)</td>
                                <td><?php echo $label[18]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_8', array('type'=>'hidden', 'id'=>'prod_name_8', 'label'=>false, 'value'=>'Pig iron for sale')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_8', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_8', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_8'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_8', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_8', 'label'=>false, 'value'=>$ironData['prev_year_prod_8'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_8', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_8', 'label'=>false, 'value'=>$ironData['pres_year_prod_8'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_8', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_8', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_8'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_26p"><?php echo $label['e']; ?></td>
                                <td><?php echo $label[19]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_9', array('type'=>'hidden', 'id'=>'prod_name_9', 'label'=>false, 'value'=>'Sponge Iron')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_9', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_9', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_9'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_9', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_9', 'label'=>false, 'value'=>$ironData['prev_year_prod_9'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_9', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_9', 'label'=>false, 'value'=>$ironData['pres_year_prod_9'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_9', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_9', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_9'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_26p"><?php echo $label['f']; ?></td>
                                <td><?php echo $label[20]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_10', array('type'=>'hidden', 'id'=>'prod_name_10', 'label'=>false, 'value'=>'Hot Briquetted Iron')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_10', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_10', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_10'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_10', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_10', 'label'=>false, 'value'=>$ironData['prev_year_prod_10'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_10', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_10', 'label'=>false, 'value'=>$ironData['pres_year_prod_10'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_10', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_10', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_10'])); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_26p"><?php echo $label['g']; ?></td>
                                <td><?php echo $label[21]; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_22p"></td>
                                <td class="w_22p">i)</td>
                                <td><?php echo $label[22]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_11', array('type'=>'hidden', 'id'=>'prod_name_11', 'label'=>false, 'value'=>'Liquid Steel/ Crude Steel')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_11', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_11', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_11'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_11', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_11', 'label'=>false, 'value'=>$ironData['prev_year_prod_11'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_11', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_11', 'label'=>false, 'value'=>$ironData['pres_year_prod_11'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_11', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_11', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_11'])); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_22p"></td>
                                <td class="w_22p">ii)</td>
                                <td><?php echo $label[23]; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_22p"></td>
                                <td class="w_22p"></td>
                                <td class="w_22p"><?php echo $label['a']; ?></td>
                                <td><?php echo $label[24]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_12', array('type'=>'hidden', 'id'=>'prod_name_12', 'label'=>false, 'value'=>'Semi-finished Steel')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_12', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_12', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_12'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_12', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_12', 'label'=>false, 'value'=>$ironData['prev_year_prod_12'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_12', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_12', 'label'=>false, 'value'=>$ironData['pres_year_prod_12'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_12', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_12', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_12'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_22p"></td>
                                <td class="w_22p"></td>
                                <td class="w_22p"><?php echo $label['b']; ?></td>
                                <td><?php echo $label[25]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_13', array('type'=>'hidden', 'id'=>'prod_name_13', 'label'=>false, 'value'=>'Finished Steel')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_13', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_13', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_13'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_13', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_13', 'label'=>false, 'value'=>$ironData['prev_year_prod_13'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_13', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_13', 'label'=>false, 'value'=>$ironData['pres_year_prod_13'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_13', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_13', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_13'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_26p"><?php echo $label['h']; ?></td>
                                <td><?php echo $label[26]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_14', array('type'=>'hidden', 'id'=>'prod_name_14', 'label'=>false, 'value'=>'Tin plates')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_14', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_14', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_14'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_14', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_14', 'label'=>false, 'value'=>$ironData['prev_year_prod_14'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_14', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_14', 'label'=>false, 'value'=>$ironData['pres_year_prod_14'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_14', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_14', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_14'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_26p"><?php echo $label['i']; ?></td>
                                <td><?php echo $label[27]; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_name_15', array('type'=>'hidden', 'id'=>'prod_name_15', 'label'=>false, 'value'=>'Sulphuri Acid')); ?>
                        <?php echo $this->Form->control('prod_anual_capacity_15', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_15', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_15'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_15', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_15', 'label'=>false, 'value'=>$ironData['prev_year_prod_15'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_15', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_15', 'label'=>false, 'value'=>$ironData['pres_year_prod_15'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_15', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_15', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_15'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_26p"><?php echo $label['j']; ?></td>
                                <td><?php echo $label[28]; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <?php echo $this->Form->control('prod_name_16', array('type'=>'text', 'class'=>'form-control form-control-sm prodName', 'id'=>'prod_name_16', 'label'=>false, 'maxLength'=>150, 'value'=>$ironData['prod_name_16'])); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_anual_capacity_16', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_16', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_16'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_16', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_16', 'label'=>false, 'value'=>$ironData['prev_year_prod_16'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_16', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_16', 'label'=>false, 'value'=>$ironData['pres_year_prod_16'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_16', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_16', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_16'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_26p"><?php echo $label['k']; ?></td>
                                <td><?php echo $label[29]; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <?php echo $this->Form->control('prod_name_17', array('type'=>'text', 'class'=>'form-control form-control-sm prodName', 'id'=>'prod_name_17', 'label'=>false, 'maxLength'=>150, 'value'=>$ironData['prod_name_17'])); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_anual_capacity_17', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_17', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_17'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_17', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_17', 'label'=>false, 'value'=>$ironData['prev_year_prod_17'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_17', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_17', 'label'=>false, 'value'=>$ironData['pres_year_prod_17'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_17', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_17', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_17'])); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="w_26p"><?php echo $label['l']; ?></td>
                                <td><?php echo $label[30]; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <?php echo $this->Form->control('prod_name_18', array('type'=>'text', 'class'=>'form-control form-control-sm prodName', 'id'=>'prod_name_18', 'label'=>false, 'maxLength'=>150, 'value'=>$ironData['prod_name_18'])); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prod_anual_capacity_18', array('type'=>'text', 'class'=>'form-control form-control-sm right prodCapacity', 'id'=>'prod_anual_capacity_18', 'label'=>false, 'value'=>$ironData['prod_anual_capacity_18'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('prev_year_prod_18', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_18', 'label'=>false, 'value'=>$ironData['prev_year_prod_18'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->control('pres_year_prod_18', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_18', 'label'=>false, 'value'=>$ironData['pres_year_prod_18'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->textarea('prod_remark_18', array('class'=>'form-control form-control-sm prodRemark', 'id'=>'prod_remark_18', 'label'=>false, 'rows'=>2, 'value'=>$ironData['prod_remark_18'])); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

	<div class="col-sm-12 mine-m-auto">
        <table class="table table-bordered table-sm">
            <tbody>
                <tr>
                    <td class="w-25"><?php echo $label[31]; ?></td>
                    <td>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="exampleEmail11" class=""><?php echo $label[32]; ?></label>
                                    <?php echo $this->Form->control('prod_name_19', array('type'=>'hidden', 'id'=>'prod_name_19', 'label'=>false, 'value'=>'Coke purchased')); ?>
                                    <?php echo $this->Form->control('prev_year_prod_19', array('type'=>'text', 'class'=>'form-control form-control-sm right prevYear', 'id'=>'prev_year_prod_19', 'label'=>false, 'maxLength'=>150, 'value'=>$ironData['prev_year_prod_19'])); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="examplePassword11" class=""><?php echo $label[33]; ?></label>
                                    <?php echo $this->Form->control('pres_year_prod_19', array('type'=>'text', 'class'=>'form-control form-control-sm right presYear', 'id'=>'pres_year_prod_19', 'label'=>false, 'maxLength'=>150, 'value'=>$ironData['pres_year_prod_19'])); ?>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $label[34]; ?></td>
                    <td>
                        <?php echo $this->Form->textarea('current_expansion_prog', array('type'=>'text', 'class'=>'form-control form-control-sm prodProg', 'id'=>'current_expansion_prog', 'maxLength'=>500, 'rows'=>2, 'label'=>false, 'value'=>$ironData['current_expansion_prog'])); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $label[35]; ?></td>
                    <td>
                        <?php echo $this->Form->textarea('future_expansion_prog', array('type'=>'text', 'class'=>'form-control form-control-sm prodProg', 'id'=>'future_expansion_prog', 'maxLength'=>500, 'rows'=>2, 'label'=>false, 'value'=>$ironData['future_expansion_prog'])); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $label[36]; ?></td>
                    <td>
                        <?php echo $this->Form->textarea('research_prog', array('type'=>'text', 'class'=>'form-control form-control-sm prodProg', 'id'=>'research_prog', 'maxLength'=>500, 'rows'=>2, 'label'=>false, 'value'=>$ironData['research_prog'])); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php 

    echo $this->Form->control('uType', ['type'=>'hidden', 'id'=>'uType', 'value'=>$userType]);
    echo $this->Form->control('fType', ['type'=>'hidden', 'id'=>'fType', 'value'=>$formType]);
    echo $this->Form->control('return_date', ['type'=>'hidden', 'id'=>'return_date', 'value'=>$returnDate]);
    echo $this->Form->control('return_type', ['type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType]);
    echo $this->Form->control('end_user_id', ['type'=>'hidden', 'value'=>$endUserId]);
    echo $this->Form->control('user_type', ['type'=>'hidden', 'value'=>$userType]);
    echo $this->Form->control('section_no', ['type'=>'hidden','id'=>'section_no','value'=>$section_no]);
    echo $this->Form->control('', ['type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'ironIndustryForm']); 

    echo $this->Html->script('m/iron_steel_industries.js?version='.$version);

?>
