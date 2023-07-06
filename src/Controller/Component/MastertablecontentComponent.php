<?php	//component for masters related functions .
// Define functions for all master tables value.
namespace app\Controller\Component;
use Cake\Controller\Controller;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Datasource\EntityInterface;

class MastertablecontentComponent extends Component {

	public $controller = null;
	public $session = null;

	public function initialize(array $config): void {
		parent::initialize($config);
		$this->Controller = $this->_registry->getController();
		$this->Session = $this->getController()->getRequest()->getSession();

	}

	//for Dashboard CMS
	//add/edit pages
	public function addEditCmsPages($postData,$record_id=null){

		//load Model
		$Pages = TableRegistry::getTableLocator()->get('Pages');

		// white listed tags
		$tags_white_list = array('strong','italic','p','a','img','s','ul','li','ol','h1','h2','h3','h4','h5','h6','h7',
							'div','pre','table','tr','td','th','thead','tbody','hr','blockquote','em','big',
							'/strong','/italic','/p','/a','/img','/s','/ul','/li','/ol','/h1','/h2','/h3','/h4','/h5','/h6','/h7',
							'/div','/pre','/table','/tr','/td','/th','/thead','/tbody','/hr','/blockquote','/em','/big');

		// check content tags are proper if not make it htmlencoded
		$page_content = $postData['content'];
		$total_character = strlen($page_content);
		$find_tag = preg_match('/</', $page_content, $matches);

		if (!empty($find_tag)) {

			$i=0;
			while ($i <= $total_character-1) {

				$tag_start_pos = strpos($page_content,'<',$i);

				if ($tag_start_pos === false) {

					$i = $total_character;

				} else {

					$i = $tag_start_pos+1;

					$char = $i;
					$tag_name = '';
					$tag_array = array();
					$tag_array_counter =0;

					while (!($page_content[$char] == '>' || $page_content[$char] == ' ')) {

						$tag_array[$tag_array_counter] = $page_content[$char];

						$tag_array_counter = $tag_array_counter+1;
						$char = $char + 1;
					}

					$tag_name = implode('',$tag_array);
					$x=0;
					$tag_match = '';

					//count of white list tags
					while ($x <= 54) {

						if ($tag_name == $tags_white_list[$x]) {

							$tag_match = 'yes';
							$x = 55;

						} else {

							$tag_match = 'no';
							$x = $x+1;

						}

					}

					if ($tag_match == 'no') {

						$full_tag = array();
						$y = $tag_start_pos;
						$k = 0;

						while ($y <= $char-1) {

							$full_tag[$k] = $page_content[$y];
							$y = $y+1;
							$k = $k+1;
						}

						$htmlencoded_tag = htmlentities((implode('',$full_tag)), ENT_QUOTES);

						$tag_length = strlen($htmlencoded_tag);

						$full_tag_string = implode('',$full_tag);

						$page_content = str_replace($full_tag_string,$htmlencoded_tag,$page_content);

						$i=$char;

						$total_character = strlen($page_content);

					} else {

						$i=$i+1;
					}

				}	// if position empty

			}

		}

		// html encoding
		$title = htmlentities($postData['title'], ENT_QUOTES);
		$publish_date = htmlentities($postData['publish_date'], ENT_QUOTES);
		$publish_date = $this->Controller->Customfunctions->dateFormatCheck($publish_date);
		$archive_date = htmlentities($postData['archive_date'], ENT_QUOTES);
		$archive_date = $this->Controller->Customfunctions->dateFormatCheck($archive_date);

		/*if ($this->dateComparison($publish_date,$archive_date)==false) {
			
			return false;
		}
*/
		$status = htmlentities($postData['status'], ENT_QUOTES);
		$meta_keyword = htmlentities($postData['meta_keyword'], ENT_QUOTES);
		$meta_description = htmlentities($postData['meta_description'], ENT_QUOTES);

		$slug = str_replace(" ","",strtolower($title));

		//set dataArray
		//for add
		if ($record_id == null) {

			$dataArray = array('title'=>$title,
							   'content'=>$page_content,
							   'user_email_id'=>$this->Session->read('mms_user_email'),
							   'status'=>$status,
							   'publish_date'=>$publish_date,
							   'archive_date'=>$archive_date,
							   'meta_keyword'=>$meta_keyword,
							   'meta_description'=>$meta_description,
							   'slug'=>$slug,
							   'created'=>date('Y-m-d H:i:s'));

		//for edit
		} else {

			$dataArray = array('id'=>$record_id,
							   'title'=>$title,
							   'content'=>$page_content,
							   'user_email_id'=>$this->Session->read('mms_user_email'),
							   'status'=>$status,
							   'publish_date'=>$publish_date,
							   'archive_date'=>$archive_date,
							   'meta_keyword'=>$meta_keyword,
							   'meta_description'=>$meta_description,
							   'slug'=>$slug,
							   'modified'=>date('Y-m-d H:i:s'));
			//print_r($dataArray);die;
		}

		$PagesEntity = $Pages->newEntity($dataArray);

		if ($Pages->save($PagesEntity)) {

				return true;
		}

	}


	// Function to check comparison between from date and To date
	public function dateComparison($from_date,$to_date) {

		$from_date = strtotime(str_replace('/','-',$from_date));
		$to_date  = strtotime(str_replace('/','-',$to_date));

		if ($from_date <= $to_date) {
			return true;
		} else {
			return false;
		}

	}


	//add/edit Menus
	public function addEditCmsMenus($postData,$record_id=null){

		//load Model
		$Menus = TableRegistry::getTableLocator()->get('Menus');
		$Pages = TableRegistry::getTableLocator()->get('Pages');

		// html encoding
		$title = htmlentities($postData['title'], ENT_QUOTES);
		$external_link = htmlentities($postData['external_link'], ENT_QUOTES);

		//checking radio buttons input
		$link_type = $this->Controller->Customfunctions->radioButtonInputCheck($postData['link_type']);
		$position = $this->Controller->Customfunctions->radioButtonInputCheck($postData['position']);

		//checking dropdown input
		//for page id
		if ($postData['link_type']=='page') {
			$link_id = $this->Controller->Customfunctions->dropdownSelectInputCheck('Pages',$postData['link_id']);
			$pageData= $Pages->find('all')->select(['slug'])->where(array('AND'=>array('id'=>$link_id)))->toArray();
			$slug = $pageData[0]['slug'];
			//$slug = $Pages->find('list',array('valueField'=>'slug'),where(array('AND'=>array('id'=>$link_id))))->toArray();
		} else {
			$link_id = null;
			$slug  = null;
		}



		//checking number input
		$order = $this->Controller->Customfunctions->integerInputCheck($postData['order_id']);
		if ($order == 0) {
			return false;
		}

		//for add
		if ($record_id == null) {

			$dataArray = array('title'=>$title,
							    'external_link'=>$external_link,
							    'user_email_id'=>$this->Session->read('mms_user_email'),
							    'link_type'=>$link_type,
							    'position'=>$position,
							    'link_id'=>$link_id,
							    'order_id'=>$order,
							    'slug'=>$slug,
							    'created'=>date('Y-m-d H:i:s'));

		//for edit
		} else {

			$dataArray = array('id'=>$record_id,
							   'title'=>$title,
							   'external_link'=>$external_link,
							   'user_email_id'=>$this->Session->read('mms_user_email'),
							   'link_type'=>$link_type,
							   'position'=>$position,
							   'link_id'=>$link_id,
							   'order_id'=>$order,
							   'slug'=>$slug,
							   'modified'=>date('Y-m-d H:i:s'));
		}


		$MenusEntity = $Menus->newEntity($dataArray);

		if ($Menus->save($MenusEntity)) {
			return true;
		}

	}


	


}


?>
