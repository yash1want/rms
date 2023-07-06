
<div class="position-relative row form-group">
	<div class="col-sm-12 mine-m-auto">
		<table class="table table-bordered" id="d_avg_table">
			<tbody>
                <tr>
                    <td class="w-50"><b><?php echo $label[0]; ?></b></td>
					<td class="w-50"><?php echo $regNo; ?></td>
                </tr>
                <tr>
                    <td class="v_a_base"><b><?php echo $label[1]; ?></b></td>
					<td><?php echo $fullName; ?><br>
						<!--CHANGED WITH THE NOV CODE  UDAY SHANKAR SINGH 16TH JAN 2014-->
						<?php echo $appAdd[0]["mcappd_address1"] ? $appAdd[0]["mcappd_address1"] . ",<br/>" : "" ?>
						<?php echo $appAdd[0]["mcappd_address2"] ? $appAdd[0]["mcappd_address2"] . ",<br/>" : "" ?>
						<?php echo $appAdd[0]["mcappd_address3"] ? $appAdd[0]["mcappd_address3"] . ",<br/>" : "" ?>
						<?php echo $appAdd[0]["mcappd_state"]; ?>
						<?php echo $appAdd[0]["mcappd_district"]; ?>
						<?php echo $appAdd[0]["mcappd_pincode"] ? $appAdd[0]["mcappd_pincode"] : "" ?>
					</td>
                </tr>
                <tr>
                    <td><b><?php echo $label[2]; ?></b></td>
					<td>
						<!--CHANGED WITH THE NOV CODE  UDAYSHANKAR SINGH 16TH JAN 2014-->
						<?php echo $addressDetails[0]['mcmcd_nameofplant'] ? $addressDetails[0]['mcmcd_nameofplant'] . ",<br/>" : ""; ?>
						<?php echo $addressDetails[0]['mcmd_village'] ? $addressDetails[0]['mcmd_village'] . ",<br/>" : ""; ?>
						<?php echo $addressDetails[0]['mcmd_tehsil'] ? $addressDetails[0]['mcmd_tehsil'] . ",<br/>" : ""; ?>
						<?php echo (isset($regionAndDistrictName[0]['district_name'])) ? $regionAndDistrictName[0]['district_name'] . ",<br/>" : (isset($regionAndDistrictName['district_name']) ? $regionAndDistrictName['district_name'] . ",<br/>" : (isset($regionAndDistrictName[0][1]) ? $regionAndDistrictName[0][1] . ",<br/>" : "")); ?>
						<?php echo $addressDetails[0]['mcmd_state'] ? $addressDetails[0]['mcmd_state'] : ''; ?>
					</td>
                </tr>
                <tr>
                    <td><b><?php echo $label[3]; ?></b></td>
					<td><?php
						if ($activityType == 'C' || $activityType == 'S'){
							echo (isset($latiLongiDetails['latitude'])) ? $latiLongiDetails['latitude'] . " " . $latiLongiDetails['longitude'] : "NA";
						} else {
							echo "NA";
						}
					?></td>
                </tr>
                <tr>
                    <td class="v_a_base">
						<b><?php echo $label[4]; ?></b><br>
						<?php echo $label[5]; ?>
					</td>
					<td><?php echo $currActivity; ?></td>
                </tr>
				<tr>
                    <td  class="v_a_base">
						<b><?php echo 'Email'; ?></b><br>
						<?php //echo $label[5]; ?>
					</td>
					<td><?php echo base64_decode($email); ?></td>
                </tr>
				<tr>
                    <td  class="v_a_base">
						<b><?php echo 'Mobile No'; ?></b><br>
						<?php //echo $label[5]; ?>
					</td>
					<td><?php echo base64_decode($phoneno); ?></td>
                </tr>
			</tbody>
		</table>
	</div>
</div>

<table id="final-submit-error"></table>

<?php echo $this->Form->control('return_type', array('type'=>'hidden', 'id'=>'return_type', 'value'=>$returnType)); ?>
<?php echo $this->Form->control('', array('type'=>'hidden','id'=>'form_id_name', 'label'=>false, 'value'=>'frmDailyAverage')); ?>
