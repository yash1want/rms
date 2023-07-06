<?php ?>

<?php if(isset($_GET['debug'])) { echo $maxlifetime = ini_get("session.gc_maxlifetime"); exit; } ?>

<div class="row p-0">

	<?php if(isset($_SESSION['mc_form_type']) && $_SESSION['mc_form_type'] != 6) { ?>
		<?php echo $this->element('auth/auth_user_statistics'); ?>
	<?php } ?>

	<?php echo $this->element('auth/user_latest_comments'); ?>	
</div>

<script>
	$("#authmonthly").removeClass("col-md-3");
	$("#authannual").removeClass("col-md-3");
	$("#authmonthly").addClass("col-md-4");
	$("#authannual").addClass("col-md-4");
</script>