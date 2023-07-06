<?php
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\Core\Configure;
	
	class PagesTable extends Table{
		
		var $name = "pages";
		
		public $validate = array(
		
			'title'=>array(
						'rule'=>array('maxLength',100),
						'allowEmpty'=>false,	
					),
			'content'=>array(
						'rule' => 'notBlank',	
					),
			'user_email_id'=>array(
						'rule'=>array('maxLength',200),
					),
			'status'=>array(
						'rule'=>array('maxLength',50),
					),
			'meta_keyword'=>array(
						'rule'=>array('maxLength',200),
					),
			'archive_date'=>array(
						'rule'=>array('date','dmy'),
						'allowEmpty'=>false,
					),
			'publish_date'=>array(
						'rule'=>array('date','dmy'),
						'allowEmpty'=>false,
					),		
		);
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

	}

?>