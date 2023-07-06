<?php

    namespace app\Controller\Component;
    use Cake\Controller\Controller;
    use Cake\Controller\Component;

    class CreatecaptchaComponent extends Component {	

        public $components= array('Session');
        public $controller = null;
        public $session = null;

        public function initialize(array $config): void {
                parent::initialize($config);
                $this->Controller = $this->_registry->getController();
                $this->session = $this->getController()->getRequest()->getSession();
				
        }

        public function createCaptcha(){

            ob_clean();
            header('Content-type: image/png');
            // Create the image
            $im = imagecreatetruecolor(130, 35);

            // Create some colors
            $white = imagecolorallocate($im, 255, 255, 255);
            $grey = imagecolorallocate($im, 128, 128, 128);
            $black = imagecolorallocate($im, 0, 0, 0);
            imagefilledrectangle($im, 0, 0, 399, 35, $grey);

            // The text to draw
            $text = $this->session->read('code');
            //$text = $this->getCaptchaRandomCode();

            // Replace path by your own font path
            $font = WWW_ROOT.'font/Slabo27px-Regular.ttf';

            // Add some shadow to the text
            //imagettftext($im, 13, 0, 11, 21, $grey, $font, $text);

            // Add the text
            imagettftext($im, 17, 5, 40, 27, $white, $font, $text);

            // Using imagepng() results in clearer text compared with imagejpeg()
            imagepng($im);
            imagedestroy($im);
        }
		
		//this function is created to get captcha image on refresh captcha via ajax.		
		public function refreshCaptchaCode(){
						
			$string = "";			
			$chars = "ABC2D3E4F5G6H78JKL2M3N45P6Q7R8S9TUV2W3X4Y5Z"; //removed O,0,1,I from list on 09-10-2017 by Amol
			//updated logic on 12-08-2017 by Amol to contain atleast one number in string
			$match = null;
			//while(count($string)<=5){
				while($match != 1){
					for($i=0;$i<6;$i++){
                        $string.=substr($chars,rand(0,strlen($chars)-1),2); 
                        $match = preg_match('~[0-9]~', $string);
                    }
					if($match == 1 ){
						$string = substr($string, 0, 6);
						$code=$string;
                        echo "<label class='refresh_captcha'>".$code."</label>";
						//$_SESSION["code"]=$code;
                        $this->session->write('code',$code);
						//$_SESSION["code"]='123';
						
					}
				}		
		}


       

       

    }
?>