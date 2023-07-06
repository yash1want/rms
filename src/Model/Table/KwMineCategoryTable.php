<?php

namespace app\Model\Table;

use Cake\ORM\Table;
use Cake\Core\Configure;

class KwMineCategoryTable extends Table
{

	var $name = "kw_mine_category";
	
	// set default connection string
	public static function defaultConnectionName(): string {
		return Configure::read('conn');
	}

	public function postDataValidationMasters($forms_data)
	{
		$returnValue = 1;

		$mineCategory = $forms_data['mine_category'];
		if ($forms_data['mine_category'] == '') {
			$returnValue = null;
		}
		if (strlen($forms_data['mine_category']) > 1) {
			$returnValue = null;
		}
		if (!preg_match("/^[a-zA-Z]+$/", $forms_data['mine_category'])) {
			$returnValue = null;
		}
		return $returnValue;
	}
}
