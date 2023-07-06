<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\Network\Session\DatabaseSession;
use App\Network\Email\Email;
use App\Network\Request\Request;
use App\Network\Response\Response;
use Cake\Datasource\ConnectionManager;

use Cake\Event\EventInterface;
use Cake\ORM\Entity;
use Cake\Core\Configure;


class CmsController extends AppController{

	var $name = 'Cms';

	public function beforeFilter($event) {
		parent::beforeFilter($event);
	 	$this->userSessionExits();

		//$this->loadComponent('Commonlistingfunctions');
		$this->loadComponent('Createcaptcha');
		$this->loadComponent('Authentication');
		$this->loadComponent('Customfunctions');
		$this->loadComponent('Mastertablecontent');
		$this->loadComponent('Language');
        $this->loadComponent('Counts');
        $this->loadComponent('Returnslist');
        $this->loadComponent('Clscommon');
        $this->loadComponent('Formcreation');
		$this->Session = $this->getRequest()->getSession();
		
		$this->viewBuilder()->setHelpers(['Form','Html','Time']);
		$this->viewBuilder()->setLayout('mms_panel');
		$username = $this->getRequest()->getSession()->read('username');

		if ($username == null) {
			echo "Sorry You are not authorized to view this page.."; ?><a href="<?php echo $this->getRequest()->getAttribute('webroot');?>mms/login">Please Login</a><?php
			exit();
		} else {
			$this->loadModel('MmsUser');
			//check if user entry in Dmi_users table for valid user
			$check_user = $this->MmsUser->find('all',array('conditions'=>array('user_name IS'=>$this->Session->read('username'))))->first();

			if (empty($check_user)) {
				echo "Sorry You are not authorized to view this page.."; ?><a href="<?php echo $this->getRequest()->getAttribute('webroot');?>mms/login">Please Login</a><?php
				exit();
			}
		}
	}


	public function authenticateUserForPagesCms() {

		//print_r($this->Session->read('mms_user_email'));die;


		$this->loadModel('MmsUserRoles');
		$user_access = $this->MmsUserRoles->find('all',array('conditions'=>array('OR'=>array('page_draft'=>'yes','page_publish'=>'yes'),'user_email_id IS'=>$this->Session->read('mms_user_email'))))->first();

		if (!empty($user_access)) {
			//proceed
		} else {
			echo "Sorry.. You don't have permission to view this page";
			exit();
		}
	}

	//list all pages
	public function allPages() {

		$this->set('current_menu', 'menu_all_pages');
		//authenticate User
		$this->authenticateUserForPagesCms();

		$this->loadModel('Pages');
		$all_pages = $this->Pages->find('all',array('conditions'=>array('OR'=>array('delete_status IS NULL','delete_status'=>'no')),'order'=>'id ASC'))->toArray();

		$this->set('all_pages',$all_pages);

	}

	//to add new page
	public function addPage() {
		$this->set('current_menu','menu_add_page');

		//authenticate User
		$this->authenticateUserForPagesCms();

		//load Models
		$this->loadModel('MmsUserRoles');
		$this->loadModel('MmsUserFileUploads');

		//check user role for access
		$user_access = $this->MmsUserRoles->find('all',array('conditions'=>array('OR'=>array('page_draft'=>'yes','page_publish'=>'yes'),'user_email_id IS'=>$this->Session->read('mms_user_email'))))->first();

		//check page role to show status drop down
		if ($user_access['page_draft'] == 'yes' &&
			$user_access['page_publish'] == 'no') {

			$list_status = array('draft'=>'draft');

		}elseif ($user_access['page_publish'] == 'yes') {

			$list_status = array('draft'=>'draft','publish'=>'publish');
		}

		$this->set('list_status',$list_status);

		$uploaded_files = $this->MmsUserFileUploads->find('list',array('keyField'=>'file','valueField'=>'file_name', 'conditions'=>array('OR'=>array('delete_status IS NULL','delete_status'=>'no'))))->toArray();
		$this->set('uploaded_files',$uploaded_files);

		// set variables to show popup messages from view file
		$alert_message = '';
		$alert_redirect_url = '';
		$alert_theme = '';

		if ($this->request->is('post')) {

			if ($this->Mastertablecontent->addEditCmsPages($this->request->getData())) {

				$alert_message = 'You have created new page successfully.';
				$alert_redirect_url = 'all_pages';
				$alert_theme = 'success';
			} else {

				$alert_message = 'Sorry.. Please check all fields are proper.';
				$alert_redirect_url = 'add_page';
				$alert_theme = 'error';

			}
		}

		// set variables to show popup messages from view file
		$this->set('alert_message',$alert_message);
		$this->set('alert_redirect_url',$alert_redirect_url);
		$this->set('alert_theme',$alert_theme);

	}



	//to fetch record id redirect to edit function
	public function fetchPageId($record_id) {

		$this->autoRender = false;
		$this->Session->write('record_id',$record_id);
		$this->Redirect('/cms/edit-page');
	}


	//to Edit page
	public function editPage() {

		//authenticate User
		$this->authenticateUserForPagesCms();

		//load Models
		$this->loadModel('MmsUserRoles');
		$this->loadModel('MmsUserFileUploads');
		$this->loadModel('Pages');

		$record_id = $this->Session->read('record_id');

		//check user role for access
		$user_access = $this->MmsUserRoles->find('all',array('conditions'=>array('OR'=>array('page_draft'=>'yes','page_publish'=>'yes'),'user_email_id IS'=>$this->Session->read('mms_user_email'))))->first();

		//check page role to show status drop down
		if ($user_access['page_draft'] == 'yes' &&
			$user_access['page_publish'] == 'no') {
			$list_status = array('draft'=>'draft');

		} elseif ($user_access['page_publish'] == 'yes') {

			$list_status = array('draft'=>'draft','publish'=>'publish');
		}

		$this->set('list_status',$list_status);

		$uploaded_files = $this->MmsUserFileUploads->find('list',array('keyField'=>'file','valueField'=>'file_name', 'conditions'=>array('OR'=>array('delete_status IS NULL','delete_status'=>'no'))))->toArray();
		$this->set('uploaded_files',$uploaded_files);

		//fetch select page record
		$page_details = $this->Pages->find('all',array('conditions'=>array('id IS'=>$record_id)))->first();
		//print_r($page_details);die;
		$this->set('page_details',$page_details);

		// set variables to show popup messages from view file
		$alert_message = '';
		$alert_redirect_url = '';
		$alert_theme = '';

		if ($this->request->is('post')) {

			$postData = $this->request->getData();

			if ($this->Mastertablecontent->addEditCmsPages($postData,$record_id)) {

				$alert_message = 'You have edited selected page successfully.';
				$alert_theme = 'success';
			} else {
				$alert_message = 'Sorry.. Please check all fields are proper.';
				$alert_theme = 'error';
			}
			$alert_redirect_url = 'edit_page';
		}

		// set variables to show popup messages from view file
		$this->set('alert_message',$alert_message);
		$this->set('alert_redirect_url',$alert_redirect_url);
		$this->set('alert_theme',$alert_theme);

	}


	//function to Delete Record
	public function deletePage($record_id) {

		$this->autoRender = false;
		$this->loadModel('Pages');

		$DmiPagntity = $this->Pages->newEntity(array(
			'id'=>$record_id,
			'delete_status'=>'yes',
			'modified'=>date('Y-m-d H:i:s')
		));

		if ($this->Pages->save($DmiPagntity)) {
			$alert_message = 'Selected page is deleted successfully';
			$alert_theme = 'success';
			$alert_redirect_url = '../all-pages';
		}else
		{
			$alert_message = 'Page could not be deleted.!';
			$alert_theme = 'error';
			$alert_redirect_url = '../all-pages';
		}
		// set variables to show popup messages from view file
		$this->set('alert_message',$alert_message);
		$this->set('alert_redirect_url',$alert_redirect_url);
		$this->set('alert_theme',$alert_theme);

		$this->render('/element/msg_box');


	}

	//to preview page from list
	public function pagePreview($record_id) {

		//authenticate User
		$this->authenticateUserForPagesCms();
		$this->viewBuilder()->setLayout('default');
		$this->loadModel('Pages');
		$pagecontents = $this->Pages->find('all', array('conditions'=>array('id IS'=>$record_id)))->first();

		$meta_keyword = $pagecontents['meta_keyword'];
		$meta_description = $pagecontents['meta_description'];
		$pagetitle = $pagecontents['title'];
		$pagedata = $pagecontents['content'];

		$this->set(compact('meta_keyword','meta_description','pagetitle','pagedata','pagecontents'));

	}



// methods for site menus
	//authenticate User
	public function authenticateUserForMenusCms() {

		$this->loadModel('MmsUserRoles');
		$user_access = $this->MmsUserRoles->find('all',array('conditions'=>array('menus'=>'yes','user_email_id IS'=>$this->Session->read('mms_user_email'))))->first();

		if (!empty($user_access)) {
			//proceed
		} else {
			echo "Sorry.. You don't have permission to view this page";
			exit();
		}

	}

	//to list all site memus
	public function allMenus() {

		$this->set('current_menu','menu_all_menus');
		//authenticate User
		$this->authenticateUserForMenusCms();

		$this->loadModel('Menus');
		$all_menus = $this->Menus->find('all',array('conditions'=>array('user_email_id IS'=>$this->Session->read('mms_user_email'), 'OR'=>array('delete_status IS NULL','delete_status'=>'no')),'order' => 'id ASC'))->toArray();
		$this->set('all_menus',$all_menus);

	}

	//to add new site menu
	public function addMenu() {

		$this->set('current_menu','menu_add_menu');
		//authenticate User
		$this->authenticateUserForMenusCms();
		//load Models
		$this->loadModel('Pages');
		$this->loadModel('Menus');

		$list_pages = $this->Pages->find('list',array('valueField'=>'title','conditions'=>array('status'=>'publish', 'OR'=>array('delete_status IS NULL','delete_status'=>'no'))))->toArray();
		//to show side menu list for order no.
		$side_menu_list = $this->Menus->find('all',array('conditions'=>array('position'=>'top','OR'=>array('delete_status IS NULL','delete_status'=>'no')),'order'=>'order_id ASC'))->toArray();
		//to show bottom menu list for order no.
		$bottom_menu_list = $this->Menus->find('all',array('conditions'=>array('position'=>'bottom','OR'=>array('delete_status IS NULL','delete_status'=>'no')),'order'=>'order_id ASC'))->toArray();

		$this->set(compact('bottom_menu_list','side_menu_list','list_pages'));

		// set variables to show popup messages from view file
		$alert_message = '';
		$alert_redirect_url = '';
		$alert_theme = '';

		if ($this->request->is('post')) {

			$postData = $this->request->getData();

			if ($this->Mastertablecontent->addEditCmsMenus($postData)) {

				$alert_message = 'You have created new menu succesfully.';
				$alert_theme = 'success';
				$alert_redirect_url = 'all_menus';
	

			} else {

				$alert_message = 'Sorry.. Please check all fields are proper.';
				$alert_theme = 'error';
				$alert_redirect_url = 'add_menu';

			}

		}

		// set variables to show popup messages from view file
		$this->set(compact('alert_message','alert_redirect_url','alert_theme'));

	}


	//to fetch record id redirect to edit function
	public function fetchMenuId($record_id) {

		$this->autoRender = false;
		$this->Session->write('record_id',$record_id);
		$this->Redirect('/cms/edit-menu');
	}


	//to edit selected site menu
	public function editMenu() {

		//authenticate User
		$this->authenticateUserForMenusCms();
		//load Models
		$this->loadModel('Pages');
		$this->loadModel('Menus');

		$record_id = $this->Session->read('record_id');

		$menu_details = $this->Menus->find('all',array('conditions'=>array('id IS'=>$record_id)))->first();

		$list_pages = $this->Pages->find('list',array('valueField'=>'title','conditions'=>array('status'=>'publish', 'OR'=>array('delete_status IS NULL','delete_status'=>'no'))))->toArray();
		//to show side menu list for order no.
		$side_menu_list = $this->Menus->find('all',array('conditions'=>array('position'=>'top','OR'=>array('delete_status IS NULL','delete_status'=>'no')),'order'=>'order_id ASC'))->toArray();
		//to show bottom menu list for order no.
		$bottom_menu_list = $this->Menus->find('all',array('conditions'=>array('position'=>'bottom','OR'=>array('delete_status IS NULL','delete_status'=>'no')),'order'=>'order_id ASC'))->toArray();

		$this->set(compact('menu_details','bottom_menu_list','side_menu_list','list_pages'));

		// set variables to show popup messages from view file
		$alert_message = '';
		$alert_redirect_url = '';
		$alert_theme = '';

		if ($this->request->is('post')) {

			$postData = $this->request->getData();

			if ($this->Mastertablecontent->addEditCmsMenus($postData,$record_id)) {

				$alert_message = 'You have updated menu succesfully.';
				$alert_theme = 'success';
			} else {
				$alert_message = 'Sorry.. Please check all fields are proper.';
				$alert_theme = 'error';

			}
			$alert_redirect_url = 'edit_menu';
		

		}

		// set variables to show popup messages from view file
		$this->set(compact('alert_message','alert_redirect_url','alert_theme'));

	}


	//function to Delete Record
	public function deleteMenu($record_id) {

		$this->autoRender = false;
		$this->loadModel('Menus');

		$MenusEntity = $this->Menus->newEntity(array(
			'id'=>$record_id,
			'delete_status'=>'yes',
			'modified'=>date('Y-m-d H:i:s')
		));

		if ($this->Menus->save($MenusEntity)) {
			$alert_message = 'Selected menu is deleted successfully';
			$alert_theme = 'success';
			$alert_redirect_url = '../all-menus';
		}else
		{
			$alert_message = 'Menu could not be deleted.!';
			$alert_theme = 'error';
			$alert_redirect_url = '../all-menus';
		}
		// set variables to show popup messages from view file
		$this->set('alert_message',$alert_message);
		$this->set('alert_redirect_url',$alert_redirect_url);
		$this->set('alert_theme',$alert_theme);

		$this->render('/element/msg_box');

	}


//method to upload file on dashbaord

	//authenticate User
	public function authenticateUserForFileUpload() {

		$this->loadModel('MmsUserRoles');
		$user_access = $this->MmsUserRoles->find('all',array('conditions'=>array('file_upload'=>'yes','user_email_id IS'=>$this->Session->read('mms_user_email'))))->first();

		if (!empty($user_access)) {
			//proceed
		} else {
			echo "Sorry.. You don't have permission to view this page";
			exit();
		}

	}


	public function fileUploads() {

		$this->set('current_menu', 'menu_file_uploads');
		$this->authenticateUserForFileUpload();
		$this->loadModel('MmsUserFileUploads');

		// set variables to show popup messages from view file
		//$message_theme = ""; // set variable for holding message theme value like 'success', 'failed' @by Aniket Ganvir dated 15th DEC 2020


			$alert_message = "";
			$alert_theme = "";
			$alert_redirect_url = "";


		$all_files = $this->MmsUserFileUploads->find('all',array('conditions'=>array('delete_status IS NULL'),'order'=>'id desc'))->toArray();
		$this->set('all_files',$all_files);

		if (null !== ($this->request->getData('upload'))) {

			$check_duplicate_filename = $this->MmsUserFileUploads->find('all',array('fields'=>'file_name', 'conditions'=>array('file_name'=>$this->request->getData('file')->getClientFilename())))->first();

			if (!empty($check_duplicate_filename)) {

	
				$alert_message = '<b>File with same name is already exist... Please change file name and try again</b>';
				$alert_theme = "error";
				$alert_redirect_url = 'file_uploads';


			} else {
				//file uploading
				if (!empty($this->request->getData('file')->getClientFilename())) {

					$file_name = $this->request->getData('file')->getClientFilename();
					$file_size = $this->request->getData('file')->getSize();
					$file_type = $this->request->getData('file')->getClientMediaType();
					$file_local_path = $this->request->getData('file')->getStream()->getMetadata('uri');
					$file = $this->Customfunctions->fileUploadLib($file_name,$file_size,$file_type,$file_local_path);
					//print_r($file);die;

				}

				if (!empty($file)) {
					$fileName = '';
					if($file[0]=='success')
					{
						$fileName =$file[1]; 
					}

					$MmsUserFileUploadsEntity = $this->MmsUserFileUploads->newEntity(array(

						'file'=>$fileName,
						'file_name'=>$this->request->getData('file')->getClientFilename(),
						'user_email_id'=>$this->Session->read('mms_user_email'),
						'user_once_no'=>$this->Session->read('once_card_no')

					));

					if ($this->MmsUserFileUploads->save($MmsUserFileUploadsEntity)) {
						$alert_message = '<b>Your File is Uploaded Successfully.</b>';
						$alert_theme = "success";
						$alert_redirect_url = 'file_uploads';

					}

				}
				else{
					$alert_message = '<b>Please select proper file</b>';
					$alert_theme = "error";
					$alert_redirect_url = 'file_uploads';

				}

			}

		}

		// set variables to show popup messages from view file
		$this->set('alert_message',$alert_message);
		$this->set('alert_theme',$alert_theme);
		$this->set('alert_redirect_url',$alert_redirect_url);


	}

	//to fetch file id
	public function fetchFileId($id) {

		$this->Session->write('file_id',$id);
		$this->redirect(array('controller'=>'cms','action'=>'file_view'));

	}

	//to preview uploaded file
	public function fileView() {

		$this->authenticateUserForFileUpload();
		$this->loadModel('MmsUserFileUploads');

		$file_id = $this->Session->read('file_id');
		$get_file_path = $this->MmsUserFileUploads->find('all',array('fields'=>'file','conditions'=>array('id IS'=>$file_id)))->first();

		$view_file = $get_file_path['file'];

		$this->set('view_file',$view_file);

	}

	//function to Delete uploaded file
	public function deleteUploadedFile($record_id) {

		$this->autoRender = false;
		$this->loadModel('MmsUserFileUploads');

		$alert_message = "";
		$alert_theme = "";
		$alert_redirect_url = "";

		$MmsUserFileUploadsEntity = $this->MmsUserFileUploads->newEntity(array(
			'id'=>$record_id,
			'delete_status'=>'yes',
			'modified'=>date('Y-m-d H:i:s')
		));

		if ($this->MmsUserFileUploads->save($MmsUserFileUploadsEntity)) {

				$alert_message = 'Selected file is deleted successfully';
				$alert_theme = 'success';
				$alert_redirect_url = '../file_uploads';
		}else
		{
			$alert_message = 'File could not be deleted.!';
			$alert_theme = 'error';
			$alert_redirect_url = '../file_uploads';
		}

		$this->set('alert_message',$alert_message);
		$this->set('alert_theme',$alert_theme);
		$this->set('alert_redirect_url',$alert_redirect_url);
		
        $this->render('/element/msg_box');
        
		

	}


}



?>
