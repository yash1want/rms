<div class="row p-0">
	<?php echo $this->element('auth/end_user_statistics'); ?>
	<?php echo $this->element('auth/user_latest_comments'); ?>	
</div>
<script>
	$("#endmonthly").removeClass("col-md-3");
	$("#endannual").removeClass("col-md-3");
	$("#endmonthly").addClass("col-md-4");
	$("#endannual").addClass("col-md-4");
</script>