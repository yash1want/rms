<?php

	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	
	class McDistrictDirTable extends Table{
		
		var $name = "McDistrictDir";			
		public $validate = array();
		
	}

?>