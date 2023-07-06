<?php	

	namespace app\Controller\Component;
	use Cake\Controller\Controller;
	use Cake\Controller\Component;
	
	use Cake\Utility\Security;
	use SimpleXMLElement;
	
	class ValidateComponent extends Component {
	
		public $components= array('Session');
		public $controller = null;
		public $session = null;

		public function initialize(array $config): void {
			parent::initialize($config);
			$this->Controller = $this->_registry->getController();
			$this->Session = $this->getController()->getRequest()->getSession();
		}
		
		public function chkFloatCharac($val, $decimal, $char) {

            $return = true;
            if(!is_numeric($val)){
                $return = false;
            } else if ($val == '') {
                $return = false;
			} else {
                $valFormatted = number_format($val, $decimal, '.', '');
                if (strlen($valFormatted) > $char) {
                    $return = false;
                }
            }
            
            return $return;

        }

		/**
		 * validate "maxLength" of input characters
		 */
		public function maxLen($input, $maxLen) {

			$result = true;
			if (strlen($input) > $maxLen) {
				$result = false;
			}
			return $result;

		}
		
		public function minLen($input, $minLen) {

			$result = true;
			if (strlen($input) < $minLen) {
				$result = false;
			}
			return $result;

		}

		public function numeric($input) {

			$result = true;
			if (!is_numeric($input) || is_float($input)) {
				$result = false;
			}
			return $result;

		}

		public function notEmpty($input) {

			$result = true;
			if ($input == '') {
				$result = false;
			}
			return $result;

		}

		public function validateDate($date_string) {

			if (strtotime($date_string)) {
				return true;
			} else {
				return false;
			}
			
		}

		public function chkDecimalPlaces($val, $decimal) {

            $return = true;
            if(!is_numeric($val)){
                $return = false;
            } else if ($val == '') {
                $return = false;
			} else {
				if (is_float($val)) {
					$decPlaces = explode('.', $val);
					if (strlen($decPlaces[1]) > $decimal) {
						$return = false;
					}
				}
            }
            
            return $return;

        }

		// Check standard password format
		public function chkStandardPasswordFormat($val) {
			
			$pswdPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
			if (preg_match($pswdPattern, $val)) {
				return true;
			} else {
				return false;
			}

		}
	}
	
?>