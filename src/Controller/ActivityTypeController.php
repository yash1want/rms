<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Datasource\ConnectionManager;

class ActivityTypeController extends AppController
{
    var $name = 'ActivityType';
    var $uses = array();


    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('mms_panel');
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('BusinessActivity');
        $this->loadComponent('Customfunctions');
        $this->viewBuilder()->setHelpers(['Form', 'Html']);

        $queryActivity = $this->BusinessActivity->find('list', [
            'keyField' => 'activity_code',
            'valueField' => 'activity_name',
        ])
            ->select(['activity_name'])->where(['activity_code !=' => 1]);
        $activity = $queryActivity->toArray();
        $this->set('activity', $activity);
    }

    // To fetch & Search Activity type list
    public function activity()
    {        
        if (!empty($this->request->is('post'))) {
            $applicantId = trim($this->request->getData('applicant_id'));

            $con = ConnectionManager::get('default');

            if ($applicantId != '') {
                $select = "SELECT mcu_email, mcu_child_user_name AS applicant_id, CONCAT(mcu_first_name,' ',mcu_middle_name, ' ',mcu_last_name) AS mcname FROM mc_user WHERE mcu_child_user_name = '$applicantId' AND mcu_activity IS NULL;";
                $query = $con->execute($select);
                $records = $query->fetchAll('assoc');
                $this->set('records', $records);
            } else {
                $select = "SELECT mcu_email, mcu_child_user_name AS applicant_id, CONCAT(mcu_first_name,' ',mcu_middle_name, ' ',mcu_last_name) AS mcname FROM mc_user WHERE mcu_child_user_name like '%block%' AND mcu_activity IS NULL;";

                $query = $con->execute($select);
                $records = $query->fetchAll('assoc');
                $this->set('records', $records);
            }
        } else {
            $con = ConnectionManager::get('default');

            $select = "SELECT mcu_email, mcu_child_user_name AS applicant_id, CONCAT(mcu_first_name,' ',mcu_middle_name, ' ',mcu_last_name) AS mcname FROM mc_user WHERE mcu_child_user_name like '%block%' AND mcu_activity IS NULL;";

            $query = $con->execute($select);
            $records = $query->fetchAll('assoc');
            $this->set('records', $records);
        }
    }

    // To update Activity Type
    public function editActivity($id = null)
    {
        $id = $this->request->getQuery('id');

        $con = ConnectionManager::get('default');
        $select = "SELECT mcu_child_user_name, mcu_email FROM mc_user WHERE mcu_child_user_name = '$id'";
        $query = $con->execute($select);
        $records = $query->fetch();
        
        $this->set('records', $records);

        if ($this->request->is('post')) {
            $business =  $this->request->getData('business');
            $applicant_id =  $this->request->getData('applicant_id');

            $con = ConnectionManager::get('default');

            $sql = "UPDATE mc_user SET mcu_activity = '$business' WHERE mcu_child_user_name = '$applicant_id' ";
            $query = $con->execute($sql);
			
			if(!empty($query)){
                $insert = $con->execute("INSERT INTO activity_type_log (applicant_id, activity_type) VALUES ('$applicant_id','$business')");

            }

            $alert_message = "Activity Type updated successfully !!!";
            $alert_redirect_url = "activity";
            $alert_theme = "success";

            $this->set('alert_message', $alert_message);
            $this->set('alert_redirect_url', $alert_redirect_url);
            $this->set('alert_theme', $alert_theme);
        }
    }
}
