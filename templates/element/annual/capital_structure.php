<h5 class="card-title text-center"><?php echo $label['title']; ?></h5>

<div class="position-relative row form-group mine-group">
    <div class="col-sm-6 font-weight-bold">
        <?php echo $label[0]; ?> <?php echo $label['tip'][0]; ?>
    </div>
    <div class="col-sm-6 mine-m-auto">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-rupee-sign"></i></div>
            </div>
            <?php echo $this->Form->control('assests_value', array('class' => 'form-control form-control-sm number-fields-small', 'id' => 'assests_value', 'label' => false, 'value' => $csData['fixed_result']['assests_value'], 'readonly', 'templates' => array('inputContainer' => '{{content}}'))); ?>
        </div>
        <div class="err_cv float-right"></div>
    </div>
</div>

<div class="form-row">
    <div class="col-sm-12 pl-3"><?php echo $label[1]; ?></div>
</div>

<div class="position-relative row form-group mine-group">
    <div class="col-sm-12"><?php echo $label[2]; ?></div>
    <div class="col-sm-6">
        <span class="font-weight-bold"><?php echo $label[3]; ?></span><br>
        <span class="alert alert-secondary p-1 pl-2 pr-2 font_12 d-inline-block mt-3">
            <span class="text-danger font-weight-bold"><?php echo $label['4']; ?></span> <?php echo $label['5']; ?>
        </span>
    </div>
    <div class="col-sm-6 mine-m-auto">
        <?php echo $this->Form->select('selected_mine_code', $mine_data, array('id' => 'selected_mine_code', 'class' => 'form-control form-control-sm capital-mine-code', 'multiple' => 'multiple', 'value' => $csData['fixed_result']['selected_mine_code'])); ?>
    </div>
</div>

<div class="form-row">
    <div class="col-sm-12 pl-3"> <?php echo $label[6]; ?></div>
</div>

<table class="table table-sm table-bordered">
    <thead class="bg-secondary text-white">
        <tr>
            <th><?php echo $label[7]; ?></th>
            <th><?php echo $label[8]; ?></th>
            <th><?php echo $label[9]; ?></th>
            <th><?php echo $label[10]; ?></th>
            <th><?php echo $label[11]; ?></th>
            <th><?php echo $label[12]; ?></th>
            <th><?php echo $label[13]; ?> <?php echo $label['tip'][13]; ?> <?php echo $label['rupee_sign']; ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
        </tr>

        <!--=================LAND PART START=====================-->
        <tr>
            <td>
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="w_28p">(i)</td>
                            <td><?php echo $label[14]; ?> <?php echo $label['tip'][14]; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <!----------------AT THE BEGNING OF THE YEAR------------->
            <td>
                <?php echo $this->Form->control('land_beg', array('class' => 'form-control form-control-sm number-fields-small at_year_beg cap_struc', 'id' => 'land_beg', 'label' => false, 'value' => $csData['common_result']['land_beg'])); ?>
                <div class="err_cv"></div>
            </td>
            <!----------------ADDITION DURING THE YEAR--------------->
            <td>
                <?php echo $this->Form->control('land_addition', array('class' => 'form-control form-control-sm number-fields-small add_during_year cap_struc', 'id' => 'land_addition', 'label' => false, 'value' => $csData['common_result']['land_addition'])); ?>
                <div class="err_cv"></div>
            </td>
            <!-------------------SOLD DURING THE YEAR---------------->
            <td>
                <?php echo $this->Form->control('land_sold', array('class' => 'form-control form-control-sm number-fields-small sold_during_year cap_struc', 'id' => 'land_sold', 'label' => false, 'value' => $csData['common_result']['land_sold'])); ?>
                <div class="err_cv"></div>
            </td>
            <!--------------DEPRECIATION DURING THE YEAR------------->
            <td>
                <?php echo $this->Form->control('land_depreciated', array('class' => 'form-control form-control-sm number-fields-small dep_during_year cap_struc', 'id' => 'land_depreciated', 'label' => false, 'value' => $csData['common_result']['land_depreciated'])); ?>
                <div class="err_cv"></div>
            </td>
            <!------------------NET CLOSING BALANCE------------------>
            <td>
                <?php echo $this->Form->control('land_close_bal', array('class' => 'form-control form-control-sm number-fields-small number-fields-small closing_bal cap_struc', 'id' => 'land_close_bal', 'label' => false, 'value' => $csData['common_result']['land_close_bal'])); ?>
                <div class="err_cv"></div>
            </td>
            <!-----------------ESTIMATED MARKET VALUE---------------->
            <td>
                <?php echo $this->Form->control('land_estimated', array('class' => 'form-control form-control-sm number-fields-small estimated_value cap_struc', 'id' => 'land_estimated', 'label' => false, 'value' => $csData['common_result']['land_estimated'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <!--------------------END OF LAND PART--------------------->

        <!--=================BUILDING STARTS=====================-->
        <!-------------------BUILDING PART-I---------------------->
        <tr>
            <td class="border-right-0">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="w_28p">(ii)</td>
                            <td><?php echo $label[15]; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td colspan="6" class="border-left-0"></td>
        </tr>
        <tr>
            <td>
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="w_28p"></td>
                            <td><?php echo $label[16]; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <!-------------INDUSTRIAL BUILDING STARTS---------------->
            <td>
                <?php echo $this->Form->control('indus_beg', array('class' => 'form-control form-control-sm number-fields-small at_year_beg cap_struc', 'id' => 'indus_beg', 'label' => false, 'value' => $csData['common_result']['indus_beg'])); ?>
                <div class="err_cv"></div>
            </td>
            <!----------------ADDITION DURING THE YEAR--------------->
            <td>
                <?php echo $this->Form->control('indus_addition', array('class' => 'form-control form-control-sm number-fields-small add_during_year cap_struc', 'id' => 'indus_addition', 'label' => false, 'value' => $csData['common_result']['indus_addition'])); ?>
                <div class="err_cv"></div>
            </td>
            <!-------------------SOLD DURING THE YEAR---------------->
            <td>
                <?php echo $this->Form->control('indus_sold', array('class' => 'form-control form-control-sm number-fields-small sold_during_year cap_struc', 'id' => 'indus_sold', 'label' => false, 'value' => $csData['common_result']['indus_sold'])); ?>
                <div class="err_cv"></div>
            </td>
            <!--------------DEPRECIATION DURING THE YEAR------------->
            <td>
                <?php echo $this->Form->control('indus_depreciated', array('class' => 'form-control form-control-sm number-fields-small dep_during_year cap_struc', 'id' => 'indus_depreciated', 'label' => false, 'value' => $csData['common_result']['indus_depreciated'])); ?>
                <div class="err_cv"></div>
            </td>
            <!------------------NET CLOSING BALANCE------------------>
            <td>
                <?php echo $this->Form->control('indus_close_bal', array('class' => 'form-control form-control-sm number-fields-small closing_bal cap_struc', 'id' => 'indus_close_bal', 'label' => false, 'value' => $csData['common_result']['indus_close_bal'])); ?>
                <div class="err_cv"></div>
            </td>
            <!-----------------ESTIMATED MARKET VALUE---------------->
            <td>
                <?php echo $this->Form->control('indus_estimated', array('class' => 'form-control form-control-sm number-fields-small estimated_value cap_struc', 'id' => 'indus_estimated', 'label' => false, 'value' => $csData['common_result']['indus_estimated'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <!----------------INDUSTRIAL BUILDING ENDS----------------->

        <!-------------------BUILDING PART-II---------------------->
        <tr>
            <td>
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="w_28p"></td>
                            <td><?php echo $label[17]; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <!-------------RESIDENTIAL BUILDING STARTS---------------->
            <td>
                <?php echo $this->Form->control('resi_beg', array('class' => 'form-control form-control-sm number-fields-small at_year_beg cap_struc', 'id' => 'resi_beg', 'label' => false, 'value' => $csData['common_result']['resi_beg'])); ?>
                <div class="err_cv"></div>
            </td>
            <!----------------ADDITION DURING THE YEAR--------------->
            <td>
                <?php echo $this->Form->control('resi_addition', array('class' => 'form-control form-control-sm number-fields-small add_during_year cap_struc', 'id' => 'resi_addition', 'label' => false, 'value' => $csData['common_result']['resi_addition'])); ?>
                <div class="err_cv"></div>
            </td>
            <!-------------------SOLD DURING THE YEAR---------------->
            <td>
                <?php echo $this->Form->control('resi_sold', array('class' => 'form-control form-control-sm number-fields-small sold_during_year cap_struc', 'id' => 'resi_sold', 'label' => false, 'value' => $csData['common_result']['resi_sold'])); ?>
                <div class="err_cv"></div>
            </td>
            <!--------------DEPRECIATION DURING THE YEAR------------->
            <td>
                <?php echo $this->Form->control('resi_depreciated', array('class' => 'form-control form-control-sm number-fields-small dep_during_year cap_struc', 'id' => 'resi_depreciated', 'label' => false, 'value' => $csData['common_result']['resi_depreciated'])); ?>
                <div class="err_cv"></div>
            </td>
            <!------------------NET CLOSING BALANCE------------------>
            <td>
                <?php echo $this->Form->control('resi_close_bal', array('class' => 'form-control form-control-sm number-fields-small closing_bal cap_struc', 'id' => 'resi_close_bal', 'label' => false, 'value' => $csData['common_result']['resi_close_bal'])); ?>
                <div class="err_cv"></div>
            </td>
            <!-----------------ESTIMATED MARKET VALUE---------------->
            <td>
                <?php echo $this->Form->control('resi_estimated', array('class' => 'form-control form-control-sm number-fields-small estimated_value cap_struc', 'id' => 'resi_estimated', 'label' => false, 'value' => $csData['common_result']['resi_estimated'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <!----------------RESIDENTIAL BUILDING ENDS---------------->
        <!--==================BUILDING ENDS======================-->

        <!--============PLANT AND MACHINERY STARTS=============-->
        <tr>
            <td>
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="w_28p align-top">(iii)</td>
                            <td><?php echo $label[18]; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <!-------------PLANT AND MACHINERY FIELDS---------------->
            <td>
                <?php echo $this->Form->control('plant_beg', array('class' => 'form-control form-control-sm number-fields-small at_year_beg cap_struc', 'id' => 'plant_beg', 'label' => false, 'value' => $csData['common_result']['plant_beg'])); ?>
                <div class="err_cv"></div>
            </td>
            <!----------------ADDITION DURING THE YEAR--------------->
            <td>
                <?php echo $this->Form->control('plant_addition', array('class' => 'form-control form-control-sm number-fields-small add_during_year cap_struc', 'id' => 'plant_addition', 'label' => false, 'value' => $csData['common_result']['plant_addition'])); ?>
                <div class="err_cv"></div>
            </td>
            <!-------------------SOLD DURING THE YEAR---------------->
            <td>
                <?php echo $this->Form->control('plant_sold', array('class' => 'form-control form-control-sm number-fields-small sold_during_year cap_struc', 'id' => 'plant_sold', 'label' => false, 'value' => $csData['common_result']['plant_sold'])); ?>
                <div class="err_cv"></div>
            </td>
            <!--------------DEPRECIATION DURING THE YEAR------------->
            <td>
                <?php echo $this->Form->control('plant_depreciated', array('class' => 'form-control form-control-sm number-fields-small dep_during_year cap_struc', 'id' => 'plant_depreciated', 'label' => false, 'value' => $csData['common_result']['plant_depreciated'])); ?>
                <div class="err_cv"></div>
            </td>
            <!------------------NET CLOSING BALANCE------------------>
            <td>
                <?php echo $this->Form->control('plant_close_bal', array('class' => 'form-control form-control-sm number-fields-small closing_bal cap_struc', 'id' => 'plant_close_bal', 'label' => false, 'value' => $csData['common_result']['plant_close_bal'])); ?>
                <div class="err_cv"></div>
            </td>
            <!-----------------ESTIMATED MARKET VALUE---------------->
            <td>
                <?php echo $this->Form->control('plant_estimated', array('class' => 'form-control form-control-sm number-fields-small estimated_value cap_struc', 'id' => 'plant_estimated', 'label' => false, 'value' => $csData['common_result']['plant_estimated'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <!--==============PLANT AND MACHINERY ENDS===============-->
        <!--==========CAPITALISED EXPENDITURE STARTS=============-->
        <tr>
            <td>
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="w_28p align-top">(iv)</td>
                            <td><?php echo $label[19]; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <!-----------CAPITALISED EXPENDITURE FIELDS-------------->
            <td>
                <?php echo $this->Form->control('capital_beg', array('class' => 'form-control form-control-sm number-fields-small at_year_beg cap_struc', 'id' => 'capital_beg', 'label' => false, 'value' => $csData['common_result']['capital_beg'])); ?>
                <div class="err_cv"></div>
            </td>
            <!----------------ADDITION DURING THE YEAR--------------->
            <td>
                <?php echo $this->Form->control('capital_addition', array('class' => 'form-control form-control-sm number-fields-small add_during_year cap_struc', 'id' => 'capital_addition', 'label' => false, 'value' => $csData['common_result']['capital_addition'])); ?>
                <div class="err_cv"></div>
            </td>
            <!-------------------SOLD DURING THE YEAR---------------->
            <td>
                <?php echo $this->Form->control('capital_sold', array('class' => 'form-control form-control-sm number-fields-small sold_during_year cap_struc', 'id' => 'capital_sold', 'label' => false, 'value' => $csData['common_result']['capital_sold'])); ?>
                <div class="err_cv"></div>
            </td>
            <!--------------DEPRECIATION DURING THE YEAR------------->
            <td>
                <?php echo $this->Form->control('capital_depreciated', array('class' => 'form-control form-control-sm number-fields-small dep_during_year cap_struc', 'id' => 'capital_depreciated', 'label' => false, 'value' => $csData['common_result']['capital_depreciated'])); ?>
                <div class="err_cv"></div>
            </td>
            <!------------------NET CLOSING BALANCE------------------>
            <td>
                <?php echo $this->Form->control('capital_close_bal', array('class' => 'form-control form-control-sm number-fields-small closing_bal cap_struc', 'id' => 'capital_close_bal', 'label' => false, 'value' => $csData['common_result']['capital_close_bal'])); ?>
                <div class="err_cv"></div>
            </td>
            <!-----------------ESTIMATED MARKET VALUE---------------->
            <td>
                <?php echo $this->Form->control('capital_estimated', array('class' => 'form-control form-control-sm number-fields-small estimated_value cap_struc', 'id' => 'capital_estimated', 'label' => false, 'value' => $csData['common_result']['capital_estimated'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <!--===========CAPITALISED EXPENDITURE ENDS==============-->
        <!--====================TOTAL STARTS=====================-->
        <tr class="bg-light">
            <td><?php echo $label[20]; ?></td>
            <!----------------TOTAL FIELDS FIELDS-------------------->
            <td>
                <?php echo $this->Form->control('total_beg', array('class' => 'form-control form-control-sm beg_total number-fields-small at_year_beg', 'id' => 'total_beg', 'label' => false, 'value' => $csData['common_result']['total_beg'])); ?>
                <div class="err_cv"></div>
            </td>
            <!----------------ADDITION DURING THE YEAR--------------->
            <td>
                <?php echo $this->Form->control('total_addition', array('class' => 'form-control form-control-sm addition_total number-fields-small add_during_year', 'id' => 'total_addition', 'label' => false, 'value' => $csData['common_result']['total_addition'])); ?>
                <div class="err_cv"></div>
            </td>
            <!-------------------SOLD DURING THE YEAR---------------->
            <td>
                <?php echo $this->Form->control('total_sold', array('class' => 'form-control form-control-sm sold_total number-fields-small sold_during_year', 'id' => 'total_sold', 'label' => false, 'value' => $csData['common_result']['total_sold'])); ?>
                <div class="err_cv"></div>
            </td>
            <!--------------DEPRECIATION DURING THE YEAR------------->
            <td>
                <?php echo $this->Form->control('total_depreciated', array('class' => 'form-control form-control-sm depreciated_total number-fields-small dep_during_year', 'id' => 'total_depreciated', 'label' => false, 'value' => $csData['common_result']['total_depreciated'])); ?>
                <div class="err_cv"></div>
            </td>
            <!------------------NET CLOSING BALANCE------------------>
            <td>
                <?php echo $this->Form->control('total_close_bal', array('class' => 'form-control form-control-sm close_total number-fields-small closing_bal', 'id' => 'total_close_bal', 'label' => false, 'value' => $csData['common_result']['total_close_bal'])); ?>
                <div class="err_cv"></div>
            </td>
            <!-----------------ESTIMATED MARKET VALUE---------------->
            <td>
                <?php echo $this->Form->control('total_estimated', array('class' => 'form-control form-control-sm estimated_total number-fields-small estimated_value', 'id' => 'total_estimated', 'label' => false, 'value' => $csData['common_result']['total_estimated'])); ?>
                <div class="err_cv"></div>
            </td>
        </tr>
        <!--=====================TOTAL ENDS======================-->
    </tbody>
</table>
<div class="alert alert-info p-2 pl-3">
    <?php echo $label[35]; ?><br /><br />
    <?php echo $label[32]; ?><br /><br />
    <?php echo $label[33]; ?><br /><br />
</div>

<!--==============SOURCE OF FINANCE STARTS================-->
<div class="form-row mine-group mb-2">
    <div class="col-sm-12 pl-3 font-weight-bold"><?php echo $label[21]; ?></div>
</div>
<div class="form-row">
    <!------------------PAID UP SHARE START-------------------->
    <div class="col-md-3">
        <div class="position-relative form-group">
            <label for="exampleEmail11" class="font-weight-normal"><?php echo $label[22]; ?></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><?php echo $label['rupee']; ?></div>
                </div>
                <?php echo $this->Form->control('paid_share', array('class' => 'form-control form-control-sm number-fields-small cap_struc', 'id' => 'paid_share', 'label' => false, 'value' => $csData['fixed_result']['paid_share'], 'templates' => array('inputContainer' => '{{content}}'))); ?>
            </div>
            <div class="err_cv"></div>
        </div>
    </div>
    <!------------------PAID UP SHARE ENDS--------------------->
    <!------------------OWN CAPITAL STARTS--------------------->
    <div class="col-md-3">
        <div class="position-relative form-group">
            <label for="exampleEmail11" class="font-weight-normal"><?php echo $label[23]; ?></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><?php echo $label['rupee']; ?></div>
                </div>
                <?php echo $this->Form->control('own_Capital', array('class' => 'form-control form-control-sm number-fields-small cap_struc', 'id' => 'own_Capital', 'label' => false, 'value' => $csData['fixed_result']['own_Capital'], 'templates' => array('inputContainer' => '{{content}}'))); ?>
            </div>
            <div class="err_cv"></div>
        </div>
    </div>
    <!--------------------OWN CAPITAL ENDS--------------------->
    <!----------------RESERVE AND SURPLUS STARTS--------------->
    <div class="col-md-3">
        <div class="position-relative form-group">
            <label for="exampleEmail11" class="font-weight-normal"><?php echo $label[24]; ?></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><?php echo $label['rupee']; ?></div>
                </div>
                <?php echo $this->Form->control('reserve', array('class' => 'form-control form-control-sm number-fields-small cap_struc', 'id' => 'reserve', 'label' => false, 'value' => $csData['fixed_result']['reserve'], 'templates' => array('inputContainer' => '{{content}}'))); ?>
            </div>
            <div class="err_cv"></div>
        </div>
    </div>
    <!----------------RESERVE AND SURPLUS ENDS----------------->
    <!------------------LONG TERM LOAN STARTS------------------>
    <div class="col-md-3">
        <div class="position-relative form-group">
            <label for="exampleEmail11" class="font-weight-normal"><?php echo $label[25]; ?> <?php echo $label['tip'][25]; ?></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><?php echo $label['rupee']; ?></div>
                </div>
                <?php echo $this->Form->control('loan_outstanding', array('class' => 'form-control form-control-sm number-fields-small cap_struc', 'id' => 'loan_outstanding', 'label' => false, 'value' => $csData['fixed_result']['loan_outstanding'], 'templates' => array('inputContainer' => '{{content}}'))); ?>
            </div>
            <div class="err_cv"></div>
        </div>
    </div>
    <!------------------LONG TERM LOAN ENDS-------------------->
</div>
<div class="form-row mine-group">
    <div class="alert alert-info p-2 pl-3">
        <?php echo $label[34]; ?>
    </div>
</div>
<!--==============SOURCE OF FINANCE ENDS=================-->

<table class="table table-bordered table-sm w-75 m-auto" id="capStrucTable">
    <thead class="bg-secondary text-white">
        <tr>
            <th><?php echo $label[26]; ?></th>
            <th><?php echo $label[27]; ?></th>
            <th colspan="2"><?php echo $label[28]; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 1; $i <= $csData['dynamic_result']['rowCount']; $i++) { ?>
            <tr id="rw-<?php echo $i; ?>">
                <td>
                    <?php echo $this->Form->control('institute_name_' . $i, array('class' => 'form-control form-control-sm number-fields-small institution', 'id' => 'institute_name_' . $i, 'label' => false, 'value' => $csData['dynamic_result']['institute_name_' . $i])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('loan_amount_' . $i, array('class' => 'form-control form-control-sm number-fields-small loan', 'id' => 'loan_amount_' . $i, 'label' => false, 'value' => $csData['dynamic_result']['loan_amount_' . $i])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->control('interest_rate_' . $i, array('class' => 'form-control form-control-sm number-fields-small interest', 'id' => 'interest_rate_' . $i, 'label' => false, 'value' => $csData['dynamic_result']['interest_rate_' . $i])); ?>
                    <div class="err_cv"></div>
                </td>
                <td>
                    <?php echo $this->Form->button('<i class="fa fa-times"></i>', array('type' => 'button', 'escapeTitle' => false, 'class' => 'btn btn-sm rem_btn', 'disabled' => 'true')); ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <thead>
        <tr>
            <th colspan="4">
                <?php echo $this->Form->button('<i class="fa fa-plus"></i> Add more', array('type' => 'button', 'escapeTitle' => false, 'class' => 'btn btn-info btn-sm', 'id' => 'add_more_btn')); ?>
            </th>
        </tr>
    </thead>
</table>

<div class="form-row mine-group mb-2 mt-3">
    <div class="col-sm-12 pl-3 font-weight-bold"><?php echo $label[29]; ?></div>
</div>
<div class="form-row mine-group">
    <div class="col-sm-8">
        <?php echo $label[30]; ?>
    </div>
    <div class="col-sm-4 mine-m-auto">
        <?php echo $this->Form->control('interest_paid', array('class' => 'form-control form-control-sm number-fields-small paid', 'id' => 'interest_paid', 'label' => false, 'value' => $csData['fixed_result']['interest_paid'])); ?>
        <div class="err_cv"></div>
    </div>
</div>
<div class="form-row mine-group">
    <div class="col-sm-8">
        <?php echo $label[31]; ?>
    </div>
    <div class="col-sm-4 mine-m-auto">
        <?php echo $this->Form->control('rent_paid', array('class' => 'form-control form-control-sm number-fields-small paid', 'id' => 'rent_paid', 'label' => false, 'value' => $csData['fixed_result']['rent_paid'])); ?>
        <div class="err_cv"></div>
    </div>
</div>



<?php echo $this->Form->control('form_no', array('type' => 'hidden', 'value' => $formId)); ?>
<?php echo $this->Form->control('mine_code', array('type' => 'hidden', 'value' => $mineCode)); ?>
<?php echo $this->Form->control('return_type', array('type' => 'hidden', 'id' => 'return_type', 'value' => $returnType)); ?>
<?php echo $this->Form->control('return_date', array('type' => 'hidden', 'value' => $returnDate)); ?>
<?php echo $this->Form->control('return_year', array('type' => 'hidden', 'value' => $returnYear)); ?>
<?php echo $this->Form->control('institutionCount', array('type' => 'hidden', 'id' => 'institutionCount', 'class' => 'institution_count', 'value' => '')); ?>
<?php echo $this->Form->control('mine_owner', array('type' => 'hidden', 'value' => $mineOwner)); ?>
<?php echo $this->Form->control('', array('type' => 'hidden', 'id' => 'form_id_name', 'value' => 'capitalStructure')); ?>

<?php echo $this->Html->script('g/capital_structure.js?version=' . $version); ?>