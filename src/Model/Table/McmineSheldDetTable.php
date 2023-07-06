<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class McmineSheldDetTable extends Table{
		
		var $name = "mc_minesheld_det";			
		

		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}
     public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('mc_minesheld_det');
        
    }
		

	} 
?>