if(!preg_match("/^[A-Za-z0-9]{6}$/", $captcha)){

				$this->alert_message = 'Invalid Captcha Input';
				$this->alert_redirect_url = 'login';

			}else{

				if($captcha == $this->Session->read('code')){

					$validUserName = $this->validUserName(base64_decode($userName));

					if($validUserName == true && strlen($password) == '128'){

						$login_result =	$this->Authentication->loginuser($userName,$password,$userType);


						if($loginStatus == 'SUCCESS'){
							


						}elseif($loginStatus == 'RESETPASS'){



						}else{

							$this->saveUserLog(base64_decode($userName),$loginStatus,'', $loginusertype); 

							if($loginStatus=='LOCKED'){
								$this->alert_message = 'Sorry... Your account is disabled for today, on account of 3 login failure';							
							}

							if($loginStatus=='FAILED'){
								$attemptleft = 2 - $login_result[3];
								$this->alert_message = 'Username or password do not match.<br> Please note: You have '. $attemptleft .' more attempt to login';							
							}

							if($loginStatus=='DENIED'){

								$this->alert_message = 'Username or password do not match';	
							}
							
							$this->alert_redirect_url = 'login';
						}


					}else{	          		
		          		$this->alert_message = "You are trying to login from incorrect login window";
						$this->alert_redirect_url = 'login';

		          	}

				}else{	          		
		          		$this->alert_message = "Invalid Captcha Input";
						$this->alert_redirect_url = 'login';

		        }

			}