<?php	
//Note: All $this are converted to $this->Controller in this component. on 11-07-2017 by Amol
//To access the properties of main controller used initialize function.

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Validation;

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Log\Log;
use Cake\Core\App;
use Cake\I18n\Time; 


class BeforepageloadComponent extends Component {

		public $Controller = null;
		public $Session = null;
		public $current_controller = null; 
		public $current_controllerHere = null;
		public $current_controllerWebroot = null;

		public function initialize(array $config): void {
			parent::initialize($config);
			$this->Controller = $this->_registry->getController();
			$this->Session = $this->getController()->getRequest()->getSession();
			$this->current_controller = $this->getController()->getRequest()->getParam('controller');
			$this->current_controllerHere = $this->getController()->getRequest()->getAttribute("here");
			$this->current_controllerWebroot = $this->getController()->getRequest()->getAttribute("webroot");
			$this->current_controllerlayout = $this->getController()->getRequest()->getAttribute("layout");
			
		}
		//This method is used to set and display site menus from database Date:03/02/2022
		public function set_site_menus() 
		{
			$current_date = date('Y-m-d');		
			

			$Ibm_menu = TableRegistry::getTableLocator()->get('Menus');//initialize model in component
			$Ibm_publish_page = TableRegistry::getTableLocator()->get('Pages');//initialize model in component

			//footer contact details
			$contactDetails = $Ibm_publish_page->find('all')->where(array('AND'=>array('publish_date <='=>$current_date,'archive_date >='=>$current_date,'status'=>'publish','slug'=>'contact')))->toArray();

			if(!empty($contactDetails))
			{
				$this->Controller->set('Fcontact', htmlspecialchars_decode($contactDetails[0]['content']));
			}else
			{
				$this->Controller->set('Fcontact', '');
			}
			


			//site menu
			//get published pages ids.
			$publish_pages_id = $Ibm_publish_page->find('list')->select(['id'])->where(array('AND'=>array('publish_date <='=>$current_date,'archive_date >='=>$current_date,'status'=>'publish')))->toArray();

				$Extraorcond =array();
				if (!empty($publish_pages_id)) {
					$Extraorcond = ['link_id IN'=>$publish_pages_id];
				}
			
			// top menu 
			$top_menus = $Ibm_menu->find()->where(array('OR'=>array($Extraorcond, 'link_type IN'=>array('external','page')),'position'=>'top','parent IS'=> null,'delete_status IS'=>null))->order(array('order_id'=>'Asc'))->all()->toArray();
			
			//print_r($top_menus);die;
			$this->Controller->set('top_menus', $top_menus);

			// Display Single page from database
			if(strtolower($this->current_controller)=='pages' && $this->current_controllerHere != $this->current_controllerWebroot){

				//find the selected menu data using "slug" value (Done By pravin 31-01-2018)
				$slugpage = '';
				$split_value = explode('/',$this->current_controllerHere);	
				if (isset($split_value[2])) {
					$slugpage = $split_value[2];
				}

				$menu_page_data = $Ibm_menu->find()->where(array('slug'=>$slugpage,'delete_status IS'=>null))->first();
				if(!empty($menu_page_data))
				{ 
					$menu_page_data = $menu_page_data->toArray();
					if($menu_page_data['link_type'] == 'page')
					{						
						//$pagetype = $this->Controller->request->query['$type'];
						//$pageid = $this->Controller->request->query['$page'];
											
						$checkpageid = $Ibm_publish_page->find('all')->select(['id'])->where(array('id' => $menu_page_data['link_id']))->first();
						if(!empty($checkpageid) && isset($checkpageid['id']) && !empty($checkpageid['id']))
						{				
												 
							$pagecontents = $Ibm_publish_page->find('all')->where(array('id' => $menu_page_data['link_id']))->first();
						
							$this->Controller->set('pagecontents', $pagecontents);
										
							$meta_keyword = $pagecontents['meta_keyword'];
							$meta_description = $pagecontents['meta_description'];

							$pagetitle = $pagecontents['title'];
							$pagedata = htmlspecialchars_decode($pagecontents['content']);
								  				
												
							$this->Controller->set('meta_keyword', $meta_keyword);
							$this->Controller->set('meta_description', $meta_description);
							$this->Controller->set('pagetitle', $pagetitle);
							$this->Controller->set('pagedata', $pagedata);


						}else{
							$message = 'requested page not available';
							$this->Controller->set('errormsgafterpost',$message);
							$this->Controller->set('meta_keyword', '');
							$this->Controller->set('meta_description', '');
							$this->Controller->set('pagetitle', '');
							$this->Controller->set('pagedata', '');
        					return false;
        					exit;	
						}
					}
				}
			} //end
			else{

				$message = 'requested page not available';
				$this->Controller->set('errormsgafterpost',$message);
				$this->Controller->set('meta_keyword', '');
				$this->Controller->set('meta_description', '');
				$this->Controller->set('pagetitle', '');
				$this->Controller->set('pagedata', '');
				return false;
				exit;
			}




		}
		//get visitor count  Date:04/02/2022
		public function fetch_visitor_count(){
	       $Ibm_visitors = TableRegistry::getTableLocator()->get('Visitor_counts');//initialize model in component
			
			//to fetch address of footer dynamically date:02/02/2018
			$fetch_count=$Ibm_visitors->find('all')->toArray();
		    $this->Controller->set('fetch_count',$fetch_count);
		   
		
           if(!empty($fetch_count)){
			if (!isset($_SESSION['visitor'])) { 
			
			    //if session is not set means if user comes first time or if session expires then. date:07/02/2018
				$_SESSION['visitor'] = 1;
				$pre_visitor=$fetch_count[0]['visitor'];
			    $total_visitor=$_SESSION['visitor']+$pre_visitor;
			    $newEntityVisitor = $Ibm_visitors->newEntity(array( 'id'=>$fetch_count[0]['id'],'visitor'=>$total_visitor));
			    $Ibm_visitors->save($newEntityVisitor);
			}}
			else{
				$newEntityVisitor = $Ibm_visitors->newEntity(array('visitor'=>1));
			    $Ibm_visitors->save($newEntityVisitor);
			
			
			}
			

					   
		}


		// Check multiple browser login
		public function checkMultiBrowserSession() {

			if (isset($_SESSION['loginusertype']) && isset($_SESSION['username']) && isset($_SESSION['login_session'])) {

				$login_user_type = $_SESSION['loginusertype'];
				
				if (!in_array($login_user_type, array('authuser', 'enduser', 'primaryuser', 'mmsuser'))) {
					$this->Session->destroy();
				}

				switch ($login_user_type) {
					case 'authuser':
					case 'enduser':
					case 'primaryuser':
						$uname = $_SESSION['username'];
						$log_tbl = 'McUserLog';
						break;
					case 'mmsuser':
						$uname = $_SESSION['mms_user_name'];
						$log_tbl = 'MmsUserLog';
						break;
				}

				$logged_session_token = $_SESSION['login_session'];
				$log = TableRegistry::getTableLocator()->get($log_tbl);
				$logData = $log->find()
					->select(['session_token'])
					->where(['uname'=>$uname])
					->order(['login_time'=>'DESC'])
					->first();

				$db_session_token = $logData['session_token'];

				if ($db_session_token != $logged_session_token) {
					// destroy session if db session token and current browser session token mismatch
					$this->Session->destroy();
				}

			}
		}
		
		public function ValidDomainRequest()
		{
			$validHostName = array('ibmreturns.gov.in','10.158.81.41','es-staging.cdac.in','esignservice.cdac.in','email.gov.in');
			$hostName = $_SERVER['HTTP_HOST'];
			$msg = 'Invalid Domain Request';
			
			if(!in_array($hostName,$validHostName)){
				$this->Controller->invalidActivities($msg);				
			}else{
									
				// validated referere,
				if(isset($_SERVER['HTTP_REFERER'])){
					$http_referer = str_replace('https://','',$_SERVER['HTTP_REFERER']);
					$http_referer = explode('/', $http_referer)[0];

				 	if(!in_array($http_referer,$validHostName)){
						$this->Controller->invalidActivities($msg);
					}
				}			
			}
		}

}