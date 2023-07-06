<?php 
	namespace app\Model\Table;
	use Cake\ORM\Table;
	use App\Model\Model;
	use Cake\ORM\TableRegistry;
	use Cake\Core\Configure;
	use Cake\ORM\Locator\LocatorAwareTrait;
	use Cake\Datasource\ConnectionManager;
	
	class TblAllocationNODetailsTable extends Table{
		
		var $name = "TblAllocationNODetails";			
		public $validate = array();
		
		// set default connection string
		public static function defaultConnectionName(): string {
			return Configure::read('conn');
		}

		public function allocation($supid,$prid,$userids,$allocationtype){

			$this->TblAllocationLogs = TableRegistry::getTableLocator()->get('TblAllocationLogs');
			$allocate_by = $_SESSION['mms_user_id'];


			if($allocationtype == 'allocate'){


				foreach($userids as $userid){

					if($userid !='')
					{	
						$newEntity = $this->newEntity(array(				
							'registration_code'=>$userid,
							'sup_flag'=>'y',
							'pri_flag'=>'y',
							'sup_id'=>$supid,
							'pri_id'=>$prid,							
							'created_at'=>date('Y-m-d H:i:s'),
							'updated_at'=>date('Y-m-d H:i:s')
						));


						if($this->save($newEntity)){

							$logEntity = $this->newEntity(array(					
								'user_id'=>$userid,
								'sup_id'=>$supid,
								'pri_id'=>$prid,
								'status'=>'allocated',							
								'allocate_by'=>$allocate_by,				
								'created_at'=>date('Y-m-d H:i:s')
							));

							$this->TblAllocationLogs->save($logEntity);						
						}
					}	

				}
			}	


			if($allocationtype == 'reallocate'){

				foreach($userids as $userid){

					if($userid !='')
					{

						$explodeval = explode('-', $userid);

						$id = $explodeval[0];

						$query = $this->query();
						$query->update()
						    ->set(['sup_id' => $supid,'pri_id'=>$prid,'updated_at'=>date('Y-m-d H:i:s')])
						    ->where(['id' => $id])
						    ->execute();

						$logEntity = $this->newEntity(array(					
							'user_id'=>$explodeval[1],											
							'sup_id'=>$supid,
							'pri_id'=>$prid,
							'status'=>'reallocate',
							'allocate_by'=>$allocate_by,				
							'created_at'=>date('Y-m-d H:i:s')
						));

						$this->TblAllocationLogs->save($logEntity);	    
					}
				}		

			}

		}

		public function reallocation($supid,$prid,$userid){

			
			$newEntity = $this->newEntity(array(
				'mine_code'=>$mineCode,
				'return_type'=>$returnType,
				'return_date'=>$returnDate,
				'mineral_name'=>$mineralName,
				'rom_5_step_sn'=>$step_sn,
				'tot_qty'=>$tot_qty,
				'metal_content'=>$metal_content,
				'grade'=>$grade,
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=>date('Y-m-d H:i:s')
			));


		}

    }
    
?>    