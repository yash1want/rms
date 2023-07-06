<?php  
		
	$userType = $_SESSION['loginusertype'];			


	if ($userType == 'authuser' || $userType == 'enduser') {
		echo $this->element('changePassword/change_password_for_mc_user');
	} elseif ($userType == 'mmsuser')  {
		echo $this->element('changePassword/change_password_for_mms_user');
	}
	


?>