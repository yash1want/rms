<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class MastersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        $this->viewBuilder()->setLayout('mms_panel');
        $this->userSessionExits();

    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('DirCommodity');
        $this->loadModel('DirZone');
        $this->loadModel('DirWorkStoppage');
        $this->loadModel('DirSizeRange');
        $this->loadModel('DirCountry');
        $this->loadModel('DirDistrict');
        $this->loadModel('DirExplosive');
        $this->loadModel('DirUnit');
        $this->loadModel('DirExtraMineral');
        $this->loadModel('DirStoneType');
        $this->loadModel('DirMachinery');
        $this->loadModel('DirMaterial');
        $this->loadModel('DirMetal');
        $this->loadModel('DirMicaType');
        $this->loadModel('DirMineralGrade');
        $this->loadModel('DirMineType');
        $this->loadModel('DirProduct');
        $this->loadModel('DirRegion');
        $this->loadModel('DirRock');
        $this->loadModel('DirRom5Step');
        $this->loadModel('DirSmelterStep');
        $this->loadModel('DirState');
        $this->loadModel('DirGrid');
        $this->loadModel('DirConcentrate');
        $this->loadModel('McpDeposit');
        $this->loadModel('Mine');
        $this->loadModel('OSupplyMode');
        $this->loadModel('KwMineCategory');
        $this->loadModel('DirMcpMineral');
        $this->loadModel('MineralWorked');
        $this->loadModel('DirFinishedProducts');
        $this->loadModel('DirSmsEmailTemplates');
    }

    public function index()
    {
        // echo 'hello';
    }



    ////////////////////////////////////////////////////////////////////////[COMMODITY MASTER]
    /**
     * Commodity Section 
     * View list of Commodity
     * Add Update & Delete Commodity
     * Delete Commodity - Instead of deleteing changing its delete_status to yes
     */

    //to list all commodity
    public function commodity()
    {
        $commodityArrs = $this->DirCommodity->find('all')->where(['delete_status' => 'no']);
        $this->set('commodityArrs', $commodityArrs);
    }


    //to add new commodity
    public function addCommodity()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirCommodity->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $commodityName = $this->request->getData('commodity_name');
                $unitCode = $this->request->getData('unit_code');
                $commodityTable = TableRegistry::get('DirCommodity');
                $commodity = $commodityTable->newEntity($this->request->getData());
                $commodity->commodity_name = $commodityName;
                $commodity->unit_code = strtoupper($unitCode);
                $commodity->delete_status = 'no';

                $this->set('commodity', $commodity);

                if ($commodityTable->save($commodity)) {

                    $this->Session->write('master_success_alert', 'Saved <b>Commodity</b> Successfully !!!');
                    $this->redirect(['action' => 'commodity']);
                } else {

                    $this->Session->write('master_error_alert', 'Insert Not Done');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data');
            }
        }
    }



    //to edit commodity
    public function editCommodity($id = null)
    {
        $commodity = $this->DirCommodity->get($id, [
            'contain' => [],
        ]);

        $unitCode = $this->request->getData('unit_code');

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirCommodity->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $commodity = $this->DirCommodity->patchEntity($commodity, $this->request->getData());
                $commodity->unit_code = strtoupper($unitCode);

                if ($this->DirCommodity->save($commodity)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Commodity</b> Successfully!!!');
                    return $this->redirect(['action' => 'commodity']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Commodity</b>!!!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted!!');
            }
        }

        $this->set(compact('commodity'));
    }


    //to delete the commodity
    public function deleteCommodity($id = null)
    {
        $commodity_table = TableRegistry::get('DirCommodity');
        $commodity = $commodity_table->get($id);
        $commodity->delete_status = 'yes';

        if ($this->DirCommodity->save($commodity)) {

            $this->Session->write('master_success_alert', 'The selected <b>Commodity</b> has been deleted.');
        } else {

            $this->Session->write('master_error_alert', 'The <b>Commodity</b> could not be deleted. Please, try again.');
        }

        return $this->redirect(['action' => 'commodity']);
    }




    ////////////////////////////////////////////////////////////////////[Zone Master]
    /**
     * Zone Section
     * View Zone List
     * Add Update & Delete Zone
     * Delete Zone - Instead of deleteing changing its delete_status to yes
     */


    //to list all zone
    public function zone()
    {
        $zoneLists = $this->DirZone->find('all')->where(['delete_status' => 'no']);
        $this->set('zoneLists', $zoneLists);
    }


    //to add zone
    public function addZone()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirZone->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $zoneName = $this->request->getData('zone_name');
                $zoneTable = TableRegistry::get('DirZone');
                $zone = $zoneTable->newEntity($this->request->getData());
                $zone->zone_name = $zoneName;
                $zone->delete_status = 'no';

                $this->set('zone', $zone);

                if ($zoneTable->save($zone)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Zone</b> Successfully!!!');
                    $this->redirect(['action' => 'zone']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Zone</b> !!!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit zone
    public function editZone($id = null)
    {
        $zone = $this->DirZone->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirZone->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $zone = $this->DirZone->patchEntity($zone, $this->request->getData());

                if ($this->DirZone->save($zone)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Zone</b> Successfully!!!');
                    return $this->redirect(['action' => 'zone']);
                }

                $this->Session->write('master_error_alert', ' Failed to Edit <b>Zone</b> !!!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('zone'));
    }


    //to delete the zone
    public function deleteZone($id = null)
    {
        $zone_table = TableRegistry::get('DirZone');
        $zone = $zone_table->get($id);
        $zone->delete_status = 'yes';

        if ($this->DirZone->save($zone)) {

            $this->Session->write('master_success_alert', 'The <b>Zone</b> has been deleted.');
        } else {

            $this->Session->write('master_error_alert', 'The <b>Zone<?b> could not be deleted. Please, try again.');
        }

        return $this->redirect(['action' => 'zone']);
    }



    //////////////////////////////////////////////////////////////////////////////[Work Stoppage]
    /**
     * Work Stoppage Section
     * List Work Stopppage
     * Add, Update & Delete Work Stoppage
     * Delete Work Stoppage - Instead of deleteing changing its delete_status to yes
     */


    //to list all the work stoppage
    public function workStoppage()
    {
        $workStoppageLists = $this->DirWorkStoppage->find('all')->where(['delete_status' => 'no']);
        $this->set('workStoppageLists', $workStoppageLists);
    }


    //to add the work stoppage
    public function addWorkStoppage()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirWorkStoppage->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $stoppageSn = $this->request->getData('stoppage_sn');
                $stoppageDef = $this->request->getData('stoppage_def');
                $stoppageDefH = $this->request->getData('stoppage_def_h');

                $workTable = TableRegistry::get('DirWorkStoppage');
                $workStoppage = $workTable->newEntity($this->request->getData());

                $workStoppage->stoppage_sn = $stoppageSn;
                $workStoppage->stoppage_def = $stoppageDef;
                $workStoppage->stoppage_def_h = $stoppageDefH;
                $workStoppage->delete_status = 'no';

                $this->set('workStoppage', $workStoppage);

                if ($workTable->save($workStoppage)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Work Stoppage</b> Successfully');
                    $this->redirect(['action' => 'work-stoppage']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to insert <b>Work Stoppage</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }

    //to edit work stoppage
    public function editWorkStoppage($id = null, $stoppage_sn = null)
    {
        $id = $this->request->getQuery('id');
        $stoppage_sn = $this->request->getQuery('stoppage_sn');

        $con = ConnectionManager::get('default');
        $workStoppage = "SELECT stoppage_sn, stoppage_def, stoppage_def_h 
                        FROM dir_work_stoppage
                        WHERE delete_status = 'no' AND id = '$id' AND stoppage_sn = '$stoppage_sn'";
        $query = $con->execute($workStoppage);
        $records = $query->fetchAll('assoc');
        $this->set('records', $records);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $validation = $this->DirWorkStoppage->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {
                if ($this->request->is('post')) {
                    $sn =  $this->request->getData('stoppage_sn');
                    $stoppage_def =  $this->request->getData('stoppage_def');
                    $stoppage_def_h =  $this->request->getData('stoppage_def_h');

                    $sql = "UPDATE dir_work_stoppage SET stoppage_sn = '$sn', stoppage_def = '$stoppage_def', stoppage_def_h = '$stoppage_def_h' WHERE id = '$id' AND stoppage_sn = '$stoppage_sn'";
                    $query = $con->execute($sql);

                    if ($query) {
                        $this->Session->write('master_success_alert', 'Edited  <b>Work Stoppage</b> Successfully!!!');
                        return $this->redirect(['action' => 'work-stoppage']);
                    }
                    $this->Session->write('master_error_alert', 'Failed to Edit <b>Work Stoppage</b>');
                } else {

                    $this->Session->write('master_error_alert', 'Invalid Data Inserted');
                }
            }
        }
    }

    //to delete work stoppage
    public function deleteWorkStoppage($id = null, $stoppage_sn = null)
    {
        $id = $this->request->getQuery('id');
        $stoppage_sn = $this->request->getQuery('stoppage_sn');

        $con = ConnectionManager::get('default');
        $sql = "UPDATE dir_work_stoppage SET delete_status = 'yes' WHERE id = '$id' AND stoppage_sn = '$stoppage_sn'";
        $query = $con->execute($sql);

        if ($query) {

            $this->Session->write('master_success_alert', 'The <b>Work Stoppage</b> has been deleted.');
        } else {

            $this->Session->write('master_error_alert', 'The <b>Work Stoppage</b> could not be deleted. Please, try again.');
        }

        return $this->redirect(['action' => 'work-stoppage']);
    }

    // To check Stoppage Sn already exist or not 
    public function checkStoppageSn()
    {
        $this->autoRender = false;
        $stoppage_sn = $_POST['stoppage_sn'];
        $con = ConnectionManager::get('default');
        $sql = "SELECT stoppage_sn FROM dir_work_stoppage WHERE stoppage_sn = '$stoppage_sn'";

        $query = $con->execute($sql);
        $records = $query->fetchAll('assoc');

        foreach ($records as $record) {
            $sn = $record['stoppage_sn'];
        }
        if ($stoppage_sn == $sn) {
            echo 1;
        } else {
            echo 0;
        }
    }



    /////////////////////////////////////////////////////////////////[Size Range Master] 
    /**
     * Size Range Section
     * List Size Range
     * Add, Update & Delete Size Range
     * Delete Size Range - Instead of deleteing changing its delete_status to yes
     */


    //to list all size range
    public function sizeRange()
    {
        $sizeRangeLists = $this->DirSizeRange->find('all')->where(['delete_status' => 'no']);
        $this->set('sizeRangeLists', $sizeRangeLists);
    }


    //to add size range
    public function addSizeRange()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirSizeRange->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $sizeRangeName = $this->request->getData('size_range');
                $sizeRangeTable = TableRegistry::get('DirSizeRange');
                $sizeRange = $sizeRangeTable->newEntity($this->request->getData());
                $sizeRange->size_range = $sizeRangeName;
                $sizeRange->delete_status = 'no';

                $this->set('sizeRange', $sizeRange);

                if ($sizeRangeTable->save($sizeRange)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Size Range</b> Successfully!!!');
                    $this->redirect(['action' => 'size-range']);
                } else {

                    $this->Session->write('Failed to Insert <b>Size Range</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit size range
    public function editSizeRange($id = null)
    {
        $sizeRange = $this->DirSizeRange->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirSizeRange->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $sizeRange = $this->DirSizeRange->patchEntity($sizeRange, $this->request->getData());

                if ($this->DirSizeRange->save($sizeRange)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Size Range</b> Successfully!!!');
                    return $this->redirect(['action' => 'size-range']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit <b>Size Range</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('sizeRange'));
    }


    //to delete the size range
    public function deleteSizeRange($id = null)
    {
        $sizeRange_table = TableRegistry::get('DirSizeRange');
        $sizeRange = $sizeRange_table->get($id);
        $sizeRange->delete_status = 'yes';

        if ($this->DirSizeRange->save($sizeRange)) {

            $this->Session->write('master_success_alert', 'The <b>Size Range</b> has been deleted.');
        } else {

            $this->session->write('master_error_alert', 'The <b>Size Range</b> could not be deleted. Please, try again.');
        }

        return $this->redirect(['action' => 'size-range']);
    }




    //////////////////////////////////////////////////////////////////[Country Master]
    /**
     * Country Section
     * List Countries
     * Add, Update & Delete Country
     * Delete COuntry - Instead of deleteing changing its delete_status to yes
     */


    //to list all the country
    public function country()
    {
        $countryLists = $this->DirCountry->find('all')->where(['delete_status' => 'no']);
        $this->set('countryLists', $countryLists);
    }


    //to add the country
    public function addCountry()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirCountry->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $countryName = $this->request->getData('country_name');
                $dgcisCounrtyCode = $this->request->getData('dgcis_country_code');
                $subContinentName = $this->request->getData('sub_continent_name');
                $countryTable = TableRegistry::get('DirCountry');
                $country = $countryTable->newEntity($this->request->getData());
                $country->country_name = $countryName;
                $country->dgcis_country_code = $dgcisCounrtyCode;
                $country->sub_continent_name = $subContinentName;
                $country->delete_status = 'no';

                $this->set('country', $country);

                if ($countryTable->save($country)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Country</b> Successfully!!!');
                    $this->redirect(['action' => 'country']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Country</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit country 
    public function editCountry($id = null)
    {
        $country = $this->DirCountry->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirCountry->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $country = $this->DirCountry->patchEntity($country, $this->request->getData());

                if ($this->DirCountry->save($country)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Country</b> Successfully!!!');

                    return $this->redirect(['action' => 'country']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit <b>Country</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('country'));
    }


    //to delete the country
    public function deleteCountry($id = null)
    {
        $country_table = TableRegistry::get('DirCountry');
        $country = $country_table->get($id);
        $country->delete_status = 'yes';

        if ($this->DirCountry->save($country)) {

            $this->Session->write('master_success_alert', 'The <b>Country</b> has been deleted.');
        } else {

            $this->Session->write('master_error_alert', 'The <b>Country</b> could not be deleted. Please, try again.');
        }

        return $this->redirect(['action' => 'country']);
    }



    //////////////////////////////////////////////////////////////////////////[District Master]
    /**
     * District Section
     * List District
     * Add, Update & Delete District
     * Delete District - Instead of deleteing changing its delete_status to yes
     */


    //to list all district
    public function district()
    {
        $districtLists = $this->DirDistrict->find('all')->where(['delete_status' => 'no']);
        $this->set('districtLists', $districtLists);
    }


    //to add district
    public function addDistrict()
    {
        $query = $this->DirState->find('list', ['keyField' => 'state_code', 'valueField' => 'state_code',])
            ->select(['state_code'])->where(['delete_status' => 'no']);
        $states = $query->toArray();
        $this->set('states', $states);

        if ($this->request->is('post')) {

            $validation = $this->DirDistrict->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $stateCode = $this->request->getData('state_code');
                $districtName = $this->request->getData('district_name');
                $regionName = $this->request->getData('region_name');
                $districtCode = $this->request->getData('district_code');
                $districtTable = TableRegistry::get('DirDistrict');
                $district = $districtTable->newEntity($this->request->getData());
                $district->state_code = $stateCode;
                $district->district_name = $districtName;
                $district->region_name = $regionName;
                $district->district_code = $districtCode;
                $district->delete_status = 'no';

                $this->set('district', $district);
                if ($districtTable->save($district)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>District</b> Successfully!!!');
                    $this->redirect(['action' => 'district']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>District</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the district
    public function editDistrict($id = null)
    {
        $query = $this->DirState->find('list', ['keyField' => 'state_code', 'valueField' => 'state_code'])
            ->select(['state_code'])->where(['delete_status' => 'no']);
        $states = $query->toArray();
        $this->set('states', $states);

        $district = $this->DirDistrict->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirDistrict->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $district = $this->DirDistrict->patchEntity($district, $this->request->getData());

                if ($this->DirDistrict->save($district)) {

                    $this->Session->write('master_success_alert', 'Edited <b>District</b> Successfully!!!');

                    return $this->redirect(['action' => 'district']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit <b>District</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('district'));
    }


    //to delete the district
    public function deleteDistrict($id = null)
    {
        $district_table = TableRegistry::get('DirDistrict');
        $district = $district_table->get($id);
        $district->delete_status = 'yes';

        if ($this->DirDistrict->save($district)) {

            $this->Session->write('master_success_alert', 'The <b>District</b> has been deleted.');
        } else {

            $this->Session->write('master_success_alert', 'The <b>District</b> could not be deleted. Please, try again.');
        }

        return $this->redirect(['action' => 'district']);
    }



    //////////////////////////////////////////////////////////////////////////////////////[Explosive Master]
    /**
     * Explosive Section
     * List Explosive
     * Add, Update & Delete Explosive
     * Delete Explosive - Instead of deleteing changing its delete_status to yes
     */


    //to list all the explosive
    public function explosive()
    {
        $explosiveLists = $this->DirExplosive->find('all')->where(['delete_status' => 'no']);
        $this->set('explosiveLists', $explosiveLists);
    }


    //to add the explosive
    public function addExplosive()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirExplosive->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $explosiveName = $this->request->getData('explosive_name');
                $explosiveUnit = $this->request->getData('explosive_unit');
                $explosiveTable = TableRegistry::get('DirExplosive');
                $explosive = $explosiveTable->newEntity($this->request->getData());
                $explosive->explosive_name = $explosiveName;
                $explosive->explosive_unit = $explosiveUnit;
                $explosive->delete_status = 'no';

                $this->set('explosive', $explosive);

                if ($explosiveTable->save($explosive)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Explosive</b> Successfully!!!');
                    $this->redirect(['action' => 'explosive']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Explosive</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the explosive
    public function editExplosive($id = null)
    {
        $explosive = $this->DirExplosive->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirExplosive->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $explosive = $this->DirExplosive->patchEntity($explosive, $this->request->getData());

                if ($this->DirExplosive->save($explosive)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Explosive</b> Successfully!!!');
                    return $this->redirect(['action' => 'explosive']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Explosive</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('explosive'));
    }


    //to delete the explosive
    public function deleteExplosive($id = null)
    {
        $explosive_table = TableRegistry::get('DirExplosive');
        $explosive = $explosive_table->get($id);
        $explosive->delete_status = 'yes';
        if ($this->DirExplosive->save($explosive)) {
            $this->Session->write('master_success_alert', 'The <b>Explosive</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Explosive</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'explosive']);
    }



    //////////////////////////////////////////////////////////////////////////////[Unit Master]
    /**
     * Unit Section
     * List Unit
     * Add, Update & Delete Unit
     * Delete Unit - Instead of deleteing changing its delete_status to yes
     */


    //to the list all units
    public function unit()
    {
        $unitLists = $this->DirUnit->find('all')->where(['delete_status' => 'no']);
        $this->set('unitLists', $unitLists);
    }


    //to add the unit
    public function addUnit()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirUnit->postDataValidationMasters($this->request->getData());

            if ($validation == true) {

                $unit_code = $this->request->getData('unit_code');
                $unit_def = $this->request->getData('unit_def');
                $dgcis_unit_code = $this->request->getData('dgcis_unit_code');
                $dgcis_unit_def = $this->request->getData('dgcis_unit_def');
                $wmi_unit_def = $this->request->getData('wmi_unit_def');
                $mcp_unit_def = $this->request->getData('mcp_unit_def');
                $conversion_factor = $this->request->getData('conversion_factor');

                $unitTable = TableRegistry::get('DirUnit');
                $unit = $unitTable->newEntity($this->request->getData());
                $unit->unit_code = strtoupper($unit_code);
                $unit->unit_def = $unit_def;
                $unit->dgcis_unit_code = strtoupper($dgcis_unit_code);
                $unit->dgcis_unit_def = $dgcis_unit_def;
                $unit->wmi_unit_def = $wmi_unit_def;
                $unit->mcp_unit_def = $mcp_unit_def;
                $unit->conversion_factor = $conversion_factor;
                $unit->delete_status = 'no';

                $this->set('unit', $unit);

                if ($unitTable->save($unit)) {

                    $this->Session->write('master_success_alert', 'Inserted  <b>Unit</b> Successfully!!!');
                    $this->redirect(['action' => 'unit']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Edit the <b>Unit</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the unit
    public function editUnit($id = null)
    {
        $unit = $this->DirUnit->get($id, [
            'contain' => [],
        ]);

        $unit_code = $this->request->getData('unit_code');
        $dgcis_unit_code = $this->request->getData('dgcis_unit_code');

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirUnit->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $unit = $this->DirUnit->patchEntity($unit, $this->request->getData());
                $unit->unit_code = strtoupper($unit_code);
                $unit->dgcis_unit_code = strtoupper($dgcis_unit_code);

                if ($this->DirUnit->save($unit)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Unit</b> Successfully!!!');
                    return $this->redirect(['action' => 'unit']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Unit</b> !!');
            } else {

                $this->Session->write('Invaild Data');
            }
        }

        $this->set(compact('unit'));
    }


    //to delete the unit
    public function deleteUnit($id = null)
    {
        $unit_table = TableRegistry::get('DirUnit');
        $unit = $unit_table->get($id);
        $unit->delete_status = 'yes';

        if ($this->DirUnit->save($unit)) {

            $this->Session->write('master_success_alert', 'The <b>Unit</b> has been deleted.');
        } else {

            $this->Session->write('master_error_alert', 'The <b>Unit</b> could not be deleted. Please, try again.');
        }

        return $this->redirect(['action' => 'unit']);
    }




    ///////////////////////////////////////////////////////////////////////////////////////////////[Extra Mineral Master]
    /**
     * Extra Mineral Section
     * List Extra Mineral
     * Add, Update & Delete Extra MIineral
     * Delete Extra Mineral - Instead of deleteing changing its delete_status to yes
     */


    //to list all extra mineral
    public function extraMineral()
    {
        $extraMineralLists = $this->DirExtraMineral->find('all')->where(['delete_status' => 'no']);
        $this->set('extraMineralLists', $extraMineralLists);
    }


    //to add extra mineral
    public function addExtraMineral()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirExtraMineral->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $mineralName = $this->request->getData('mineral_name');
                $unitCode = $this->request->getData('unit_code');
                $extraMineralTable = TableRegistry::get('DirExtraMineral');
                $extraMineral = $extraMineralTable->newEntity($this->request->getData());
                $extraMineral->mineral_name = $mineralName;
                $extraMineral->unit_code = strtoupper($unitCode);
                $extraMineral->delete_status = 'no';

                $this->set('extraMineral', $extraMineral);

                if ($extraMineralTable->save($extraMineral)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Extra Mineral</b> Successfully!!!');
                    $this->redirect(['action' => 'extra-mineral']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Extra Mineral</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the extra mineral
    public function editExtraMineral($id = null)
    {
        $extraMineral = $this->DirExtraMineral->get($id, [
            'contain' => [],
        ]);

        $unitCode = $this->request->getData('unit_code');

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirExtraMineral->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $extraMineral = $this->DirExtraMineral->patchEntity($extraMineral, $this->request->getData());
                $extraMineral->unit_code = strtoupper($unitCode);

                if ($this->DirExtraMineral->save($extraMineral)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Extra Mineral</b> Successfully!!!');
                    return $this->redirect(['action' => 'extra-mineral']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Extra Mineral</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('extraMineral'));
    }


    //to delete the extra mineral
    public function deleteExtraMineral($id = null)
    {
        $extraMineral_table = TableRegistry::get('DirExtraMineral');
        $extraMineral = $extraMineral_table->get($id);
        $extraMineral->delete_status = 'yes';

        if ($this->DirExtraMineral->save($extraMineral)) {

            $this->Session->write('master_success_alert', 'The <b>Extra Mineral</b> has been deleted.');
        } else {

            $this->Session->write('The <b>Extra Mineral</b> could not be deleted. Please, try again.');
        }

        return $this->redirect(['action' => 'extra-mineral']);
    }

    // To check Extra Mineral type already exist or not 
    public function checkExtraMineral()
    {
        $this->autoRender = false;
        $mineral_name = strtoupper($_POST['mineral_name']);
        $con = ConnectionManager::get('default');
        $sql = "SELECT mineral_name FROM dir_extra_mineral WHERE mineral_name = '$mineral_name'";

        $query = $con->execute($sql);
        $records = $query->fetchAll('assoc');

        foreach ($records as $record) {
            $minname = $record['mineral_name'];
        }
        if ($mineral_name == $minname) {
            echo 1;
        } else {
            echo 0;
        }
    }

    ////////////////////////////////////////////////////////////////////////[Stone Master]
    /**
     * Stone Type Section
     * List Stone Type
     * Add, Update & Delete Stone Type
     * Delete Stone Type - Instead of deleteing changing its delete_status to yes
     */


    //to list all stone type
    public function stoneType()
    {
        $stoneTypeLists = $this->DirStoneType->find('all')->where(['delete_status' => 'no']);
        $this->set('stoneTypeLists', $stoneTypeLists);
    }


    //to add stone type
    public function addStoneType()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirStoneType->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $stoneDef = $this->request->getData('stone_def');
                $stoneTypeTable = TableRegistry::get('DirStoneType');
                $stoneType = $stoneTypeTable->newEntity($this->request->getData());
                $stoneType->mineral_name = $stoneDef;
                $stoneType->delete_status = 'no';

                $this->set('stoneType', $stoneType);

                if ($stoneTypeTable->save($stoneType)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Stone</b> Successfully!!!');
                    $this->redirect(['action' => 'stone-type']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Stone</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the stone type
    public function editStoneType($id = null)
    {
        $stoneType = $this->DirStoneType->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirStoneType->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $stoneType = $this->DirStoneType->patchEntity($stoneType, $this->request->getData());

                if ($this->DirStoneType->save($stoneType)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Stone</b> Successfully!!!');
                    return $this->redirect(['action' => 'stone-type']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Stone</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('stoneType'));
    }


    //to delete the stone type
    public function deleteStoneType($id = null)
    {
        $stoneType_table = TableRegistry::get('DirStoneType');
        $stoneType = $stoneType_table->get($id);
        $stoneType->delete_status = 'yes';

        if ($this->DirStoneType->save($stoneType)) {

            $this->Session->write('master_success_alert', 'The <b>Stone</b> has been deleted.');
        } else {

            $this->Session->write('master_error_alert', 'The <b>Stone</b> could not be deleted. Please, try again.');
        }

        return $this->redirect(['action' => 'stone-type']);
    }




    ///////////////////////////////////////////////////////////////////////////////[Machinery Master]
    /**
     * Machinery Section
     * List Machinery
     * Add, Update & Delete Machinery
     * Delete Machinery - Instead of deleteing changing its delete_status to yes
     */


    //to list all the Machinery
    public function machinery()
    {
        $machineryLists = $this->DirMachinery->find('all')->where(['delete_status' => 'no']);
        $this->set('machineryLists', $machineryLists);
    }


    //to add Machinery
    public function addMachinery()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirMachinery->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $machineryCode = $this->request->getData('machinery_code');
                $machineryName = $this->request->getData('machinery_name');
                $capacityUnit = $this->request->getData('capacity_unit');

                $machineryTable = TableRegistry::get('DirMachinery');
                $machinery = $machineryTable->newEntity($this->request->getData());
                $machinery->machinery_code = $machineryCode;
                $machinery->machinery_name = $machineryName;
                $machinery->capacity_unit = strtoupper($capacityUnit);
                $machinery->delete_status = 'no';

                $this->set('machinery', $machinery);

                if ($machineryTable->save($machinery)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Machinery</b> Successfully!!!');
                    $this->redirect(['action' => 'machinery']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Machinery</b> !!');
                }
            } else {
                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit machinery
    public function editMachinery($id = null)
    {
        $machinery = $this->DirMachinery->get($id, [
            'contain' => [],
        ]);

        $capacityUnit = $this->request->getData('capacity_unit');

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirMachinery->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $machinery = $this->DirMachinery->patchEntity($machinery, $this->request->getData());
                $machinery->capacity_unit = strtoupper($capacityUnit);

                if ($this->DirMachinery->save($machinery)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Machinery</b> Successfully!!!');
                    return $this->redirect(['action' => 'machinery']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Machinery</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('machinery'));
    }


    //to the delete machinery
    public function deleteMachinery($id = null)
    {
        $machinery_table = TableRegistry::get('DirMachinery');
        $machinery = $machinery_table->get($id);
        $machinery->delete_status = 'yes';
        if ($this->DirMachinery->save($machinery)) {
            $this->Session->write('master_success_alert', 'The <b>Machinery</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Machinery</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'machinery']);
    }

    // To check Machinery code already exist or not 
    public function checkMachineryCode()
    {
        $this->autoRender = false;
        $machinery_code = $_POST['machinery_code'];
        $con = ConnectionManager::get('default');
        $sql = "SELECT machinery_code FROM dir_machinery WHERE machinery_code = '$machinery_code'";

        $query = $con->execute($sql);
        $records = $query->fetchAll('assoc');

        foreach ($records as $record) {
            $mcode = $record['machinery_code'];
        }
        if ($machinery_code == $mcode) {
            echo 1;
        } else {
            echo 0;
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////[Material Master]
    /**
     * Material Section
     * List Material
     * Add, Update & Delete Material
     * Delete Material - Instead of deleteing changing its delete_status to yes
     */

    //to list all Material
    public function material()
    {
        $materialLists = $this->DirMaterial->find('all')->where(['delete_status' => 'no']);
        $this->set('materialLists', $materialLists);
    }

    //to add the Material
    public function addMaterial()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirMaterial->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $materialDef = $this->request->getData('material_def');
                $materialUnit = $this->request->getData('material_unit');

                $materialTable = TableRegistry::get('DirMaterial');
                $material = $materialTable->newEntity($this->request->getData());
                $material->material_def = $materialDef;
                $material->material_unit = strtoupper($materialUnit);
                $material->delete_status = 'no';

                $this->set('material', $material);

                if ($materialTable->save($material)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Material</b> Successfully!!!');
                    $this->redirect(['action' => 'material']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Material</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }

    //to edit Material
    public function editMaterial($id = null)
    {
        $material = $this->DirMaterial->get($id, [
            'contain' => [],
        ]);
        $materialUnit = $this->request->getData('material_unit');

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirMaterial->postDataValidationMasters($this->request->getData());
            if ($validation == 1) {

                $material = $this->DirMaterial->patchEntity($material, $this->request->getData());
                $material->material_unit = strtoupper($materialUnit);

                if ($this->DirMaterial->save($material)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Material</b> Successfully!!!');
                    return $this->redirect(['action' => 'material']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Material</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('material'));
    }

    //to delete Material
    public function deleteMaterial($id = null)
    {
        $material_table = TableRegistry::get('DirMaterial');
        $material = $material_table->get($id);
        $material->delete_status = 'yes';

        if ($this->DirMaterial->save($material)) {

            $this->Session->write('master_success_alert', 'The <b>Material</b> has been deleted.');
        } else {

            $this->Session->write('master_error_alert', 'The <b>Material</b> could not be deleted. Please, try again.');
        }

        return $this->redirect(['action' => 'material']);
    }

    //////////////////////////////////////////////////////////////////[METAL MASTER]
    /**
     * Metal Section
     * List Metal
     * Add, Update & Delete Metal
     * Delete Metal - Instead of deleteing changing its delete_status to yes
     */

    //to list all the Metal
    public function metal()
    {
        $metalLists = $this->DirMetal->find('all')->where(['delete_status' => 'no']);
        $this->set('metalLists', $metalLists);
    }

    //to add the Metal
    public function addMetal()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirMetal->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $metalName = $this->request->getData('metal_name');
                $metalDef = $this->request->getData('metal_def');

                $metalTable = TableRegistry::get('DirMetal');
                $metal = $metalTable->newEntity($this->request->getData());
                $metal->material_def = $metalName;
                $metal->material_unit = $metalDef;
                $metal->delete_status = 'no';

                $this->set('metal', $metal);

                if ($metalTable->save($metal)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Metal</b> Successfully!!!');
                    $this->redirect(['action' => 'metal']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Metal</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }

    //to edit the Metal
    public function editMetal($id = null)
    {
        $metal = $this->DirMetal->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirMetal->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $metal = $this->DirMetal->patchEntity($metal, $this->request->getData());

                if ($this->DirMetal->save($metal)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Metal</b> Successfully!!!');
                    return $this->redirect(['action' => 'metal']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Metal</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('metal'));
    }

    //to delete the Metal
    public function deleteMetal($id = null)
    {
        $metal_table = TableRegistry::get('DirMetal');
        $metal = $metal_table->get($id);
        $metal->delete_status = 'yes';
        if ($this->DirMetal->save($metal)) {
            $this->Session->write('master_success_alert', 'The <b>Metal</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Metal</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'metal']);
    }

     // To check Metal type already exist or not 
     public function checkMetal()
     {
         $this->autoRender = false;
         $metal_name = ucwords($_POST['metal_name']);
         $con = ConnectionManager::get('default');
         $sql = "SELECT metal_name FROM dir_metal WHERE metal_name = '$metal_name'";
 
         $query = $con->execute($sql);
         $records = $query->fetchAll('assoc');
 
         foreach ($records as $record) {
             $mname = $record['metal_name'];
         }
         if ($metal_name == $mname) {
             echo 1;
         } else {
             echo 0;
         }
     }

    ////////////////////////////////////////////////////////////////////////////[Mica Master]
    /**
     * Mica Type Section
     * List Mica Type
     * Add, Update & Delete Mica Type
     * Delete Mica Type - Instead of deleteing changing its delete_status to yes
     */

    //to list all the Mica
    public function micaType()
    {
        $micaTypeLists = $this->DirMicaType->find('all')->where(['delete_status' => 'no']);
        $this->set('micaTypeLists', $micaTypeLists);
    }

    //to add the Mica
    public function addMicaType()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirMicaType->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $micaDef = $this->request->getData('mica_def');
                $micaTable = TableRegistry::get('DirMicaType');
                $micaType = $micaTable->newEntity($this->request->getData());
                $micaType->material_def = $micaDef;
                $micaType->delete_status = 'no';
                $this->set('micaType', $micaType);

                if ($micaTable->save($micaType)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Mica</b> Successfully!!!');
                    $this->redirect(['action' => 'mica-type']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Mica</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }

    //to edit the Mica
    public function editMicaType($id = null)
    {
        $micaType = $this->DirMicaType->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirMicaType->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $micaType = $this->DirMicaType->patchEntity($micaType, $this->request->getData());

                if ($this->DirMicaType->save($micaType)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Mica</b> Successfully!!!');
                    return $this->redirect(['action' => 'mica-type']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Mica</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('micaType'));
    }


    //to delete the Mica
    public function deleteMicaType($id = null)
    {
        $micaType_table = TableRegistry::get('DirMicaType');
        $micaType = $micaType_table->get($id);
        $micaType->delete_status = 'yes';
        if ($this->DirMicaType->save($micaType)) {
            $this->Session->write('master_success_alert', 'The <b>Mica</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Mica</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'mica-type']);
    }



    /////////////////////////////////////////////////////////////////////[Mineral Grade Master]
    /**
     * Mineral Grade Section
     * List Mineral Grade
     * Add, Update & Delete Mineral Grade
     * Delete Mineral Grade - Instead of deleteing changing its delete_status to yes
     */


    //to list all the Mineral Grade
    public function mineralGrade()
    {
        $mineralGradeLists = $this->DirMineralGrade->find('all')->where(['delete_status' => 'no','version'=>1]);
        $this->set('mineralGradeLists', $mineralGradeLists);
    }


    //to add the Mineral Grade
    public function addMineralGrade()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirMineralGrade->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $mineralName = $this->request->getData('mineral_name');
                $gradeCode = $this->request->getData('grade_code');
                $gradeName = $this->request->getData('grade_name');

                $mineralGradeTable = TableRegistry::get('DirMineralGrade');
                $mineralGrade = $mineralGradeTable->newEntity($this->request->getData());
                $mineralGrade->mineral_name = $mineralName;
                $mineralGrade->grade_code = $gradeCode;
                $mineralGrade->grade_name = $gradeName;
                $mineralGrade->delete_status = 'no';
				$mineralGrade->version = 1;

                $this->set('mineralGrade', $mineralGrade);

                if ($mineralGradeTable->save($mineralGrade)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Mineral Grade</b> Successfully!!!');
                    $this->redirect(['action' => 'mineral-grade']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Mineral Grade</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the Mineral Grade
    public function editMineralGrade($id = null)
    {
        $mineralGrade = $this->DirMineralGrade->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirMineralGrade->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $mineralGrade = $this->DirMineralGrade->patchEntity($mineralGrade, $this->request->getData());

                if ($this->DirMineralGrade->save($mineralGrade)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Mineral Grade</b> Successfully!!!');
                    return $this->redirect(['action' => 'mineral-grade']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Mineral Grade</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('mineralGrade'));
    }


    //to delete the Mineral Grade
    public function deleteMineralGrade($id = null)
    {
        $mineralGrade_table = TableRegistry::get('DirMineralGrade');
        $mineralGrade = $mineralGrade_table->get($id);
        $mineralGrade->delete_status = 'yes';
        if ($this->DirMineralGrade->save($mineralGrade)) {
            $this->Session->write('master_success_alert', 'The <b>Mineral Grade</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Mineral Grade</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'mineral-grade']);
    }




    ///////////////////////////////////////////////////////////////////////////////[Mine Type Master]
    /**
     * Mine Type Section
     * List Mine Type
     * Add, Update & Delete Mine Type
     * Delete Mine Type - Instead of deleteing changing its delete_status to yes
     */


    //to list all the Mine Type
    public function mineType()
    {
        $mineTypeLists = $this->DirMineType->find('all')->where(['delete_status' => 'no']);
        $this->set('mineTypeLists', $mineTypeLists);
    }


    //to add the Mine Type
    public function addMineType()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirMineType->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $formType = $this->request->getData('form_type');
                $formDef = $this->request->getData('form_def');

                $mineTypeTable = TableRegistry::get('DirMineType');
                $mineTypeGrade = $mineTypeTable->newEntity($this->request->getData());
                $mineTypeGrade->mineral_name = $formType;
                $mineTypeGrade->grade_code = $formDef;
                $mineTypeGrade->delete_status = 'no';

                $this->set('mineTypeGrade', $mineTypeGrade);

                if ($mineTypeTable->save($mineTypeGrade)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Mine Type</b> Successfully!!!');
                    $this->redirect(['action' => 'mine-type']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Mine Type</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the Mine Type
    public function editMineType($id = null)
    {
        $mineType = $this->DirMineType->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirMineType->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $mineType = $this->DirMineType->patchEntity($mineType, $this->request->getData());

                if ($this->DirMineType->save($mineType)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Mine Type</b> Successfully!!!');
                    return $this->redirect(['action' => 'mine-type']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Mine Type</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('mineType'));
    }


    //to delete the Mine Type
    public function deleteMineType($id = null)
    {
        $mineType_table = TableRegistry::get('DirMineType');
        $mineType = $mineType_table->get($id);
        $mineType->delete_status = 'yes';
        if ($this->DirMineType->save($mineType)) {
            $this->Session->write('master_success_alert', 'The <b>Mine Type</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Mine Type</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'mine-type']);
    }




    /////////////////////////////////////////////////////////////////////////////[Product Master]
    /**
     * Product Section
     * List Product
     * Add, Update & Delete Product
     * Delete Product - Instead of deleteing changing its delete_status to yes
     */


    //to list all the Product
    public function product()
    {
        $productLists = $this->DirProduct->find('all')->where(['delete_status' => 'no']);
        $this->set('productLists', $productLists);
    }


    //to add the Product
    public function addProduct()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirProduct->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $productDef = $this->request->getData('product_def');
                $unit = $this->request->getData('unit');

                $productTable = TableRegistry::get('DirProduct');
                $product = $productTable->newEntity($this->request->getData());
                $product->mineral_name = $productDef;
                $product->grade_code = $unit;
                $product->delete_status = 'no';

                $this->set('product', $product);

                if ($productTable->save($product)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Product</b> Successfully!!!');
                    $this->redirect(['action' => 'product']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Product</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the Product
    public function editProduct($id = null)
    {
        $product = $this->DirProduct->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirProduct->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $product = $this->DirProduct->patchEntity($product, $this->request->getData());

                if ($this->DirProduct->save($product)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Product</b> Successfully!!!');
                    return $this->redirect(['action' => 'product']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Product</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('product'));
    }


    //to delete the Product
    public function deleteProduct($id = null)
    {
        $product_table = TableRegistry::get('DirProduct');
        $product = $product_table->get($id);
        $product->delete_status = 'yes';
        if ($this->DirProduct->save($product)) {
            $this->Session->write('master_success_alert', 'The <b>Product</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Product</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'product']);
    }



    ////////////////////////////////////////////////////////////////////////////////////[Region Master]
    /**
     * Region Section
     * List Region
     * Add, Update & Delete Region
     * Delete Region - Instead of deleteing changing its delete_status to yes
     */


    //to list all the Region
    public function region()
    {
        $regionLists = $this->DirRegion->find('all')->where(['delete_status' => 'no']);
        $this->set('regionLists', $regionLists);
    }


    //to add the Region
    public function addRegion()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirRegion->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $regionName = $this->request->getData('region_name');
                $zoneName = $this->request->getData('zone_name');

                $regionTable = TableRegistry::get('DirRegion');
                $region = $regionTable->newEntity($this->request->getData());
                $region->mineral_name = $regionName;
                $region->grade_code = $zoneName;
                $region->delete_status = 'no';

                $this->set('region', $region);

                if ($regionTable->save($region)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Region</b> Successfully!!!');
                    $this->redirect(['action' => 'region']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Region</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the Region
    public function editRegion($id = null)
    {
        $region = $this->DirRegion->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirRegion->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $region = $this->DirRegion->patchEntity($region, $this->request->getData());

                if ($this->DirRegion->save($region)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Region</b> Successfully!!!');
                    return $this->redirect(['action' => 'region']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Region</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('region'));
    }



    //to delete the Region
    public function deleteRegion($id = null)
    {
        $region_table = TableRegistry::get('DirRegion');
        $region = $region_table->get($id);
        $region->delete_status = 'yes';
        if ($this->DirRegion->save($region)) {
            $this->Session->write('master_success_alert', 'The <b>Region</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Region</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'region']);
    }



    //////////////////////////////////////////////////////////////////////////////[Rock Master]
    /**
     * Rock Section
     * List Rock
     * Add, Update & Delete Rock
     * Delete Rock - Instead of deleteing changing its delete_status to yes
     */

    //to list all the Rock
    public function rock()
    {
        $rockLists = $this->DirRock->find('all')
            ->select(['id', 'rock_code', 'rock_name'])
            ->where(['delete_status' => 'no'])->toArray();
        $this->set('rockLists', $rockLists);
    }


    //to add the Rock
    public function addRock()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirRock->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $rockCode = $this->request->getData('rock_code');
                $rockName = $this->request->getData('rock_name');

                $rockTable = TableRegistry::get('DirRock');
                $rock = $rockTable->newEntity($this->request->getData());
                $rock->rock_code = strtoupper($rockCode);
                $rock->rock_name = strtoupper($rockName);
                $rock->delete_status = 'no';

                $this->set('rock', $rock);

                if ($rockTable->save($rock)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Rock</b> Successfully!!!');
                    $this->redirect(['action' => 'rock']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Rock</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the Rock
    public function editRock($id = null)
    {
        $rock = $this->DirRock->get($id, [
            'contain' => [],
        ]);

        $rockCode = $this->request->getData('rock_code');
        $rockName = $this->request->getData('rock_name');

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirRock->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $rock = $this->DirRock->patchEntity($rock, $this->request->getData());
                $rock->rock_code = strtoupper($rockCode);
                $rock->rock_name = strtoupper($rockName);

                if ($this->DirRock->save($rock)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Rock</b> Successfully!!!');
                    return $this->redirect(['action' => 'rock']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Rock</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('rock'));
    }


    //to delete the Rock
    public function deleteRock($id = null)
    {
        $rock_table = TableRegistry::get('DirRock');
        $rock = $rock_table->get($id);
        $rock->delete_status = 'yes';
        if ($this->DirRock->save($rock)) {
            $this->Session->write('master_success_alert', 'The <b>Rock</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Rock</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'rock']);
    }



    ///////////////////////////////////////////////////////////////////[Rom 5 Step Master]
    /**
     * Rom 5 Step Section
     * List Rom 5 Step
     * Add, Update & Delete Rom 5 Step
     * Delete Rom 5 Step - Instead of deleteing changing its delete_status to yes
     */


    //to list all the Rom 5 Step
    public function romStep()
    {
        $rom5StepLists = $this->DirRom5Step->find('all')->where(['delete_status' => 'no']);
        $this->set('rom5StepLists', $rom5StepLists);
    }


    //to add the Rom 5 Step
    public function addRomStep()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirRom5Step->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $romDef = $this->request->getData('rom_5_step_def');
                $romStepTable = TableRegistry::get('DirRom5Step');
                $romStep = $romStepTable->newEntity($this->request->getData());
                $romStep->rom_5_step_def = $romDef;
                $romStep->delete_status = 'no';

                $this->set('romStep', $romStep);

                if ($romStepTable->save($romStep)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Rom 5 Step</b> Successfully!!!');
                    $this->redirect(['action' => 'rom-step']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Rom 5 Step</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the Rom 5 Step
    public function editRomStep($id = null)
    {
        $romStep = $this->DirRom5Step->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirRom5Step->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $romStep = $this->DirRom5Step->patchEntity($romStep, $this->request->getData());

                if ($this->DirRom5Step->save($romStep)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Rom 5 Step</b> Successfully!!!');
                    return $this->redirect(['action' => 'rom-step']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Rom 5 Step</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('romStep'));
    }


    //to delete the Rom 5 Step
    public function deleteRomStep($id = null)
    {
        $romStep_table = TableRegistry::get('DirRom5Step');
        $romStep = $romStep_table->get($id);
        $romStep->delete_status = 'yes';
        if ($this->DirRom5Step->save($romStep)) {
            $this->Session->write('master_success_alert', 'The <b>Rom 5 Step</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Rom 5 Step</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'rom-step']);
    }



    //////////////////////////////////////////////////////////////////////[Smelter Step Master]
    /**
     * Smelter Step Section
     * List Smelter Step
     * Add, Update & Delete Smelter Step
     * Delete Smelter Step - Instead of deleteing changing its delete_status to yes
     */


    //to list all the Smelter Step
    public function smelterStep()
    {
        $smelteStepLists = $this->DirSmelterStep->find('all')->where(['delete_status' => 'no']);
        $this->set('smelteStepLists', $smelteStepLists);
    }


    //to add the Smelter Step
    public function addSmelterStep()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirSmelterStep->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $smelterStepDef = $this->request->getData('smelter_step_def');
                $smelterStepTable = TableRegistry::get('DirSmelterStep');
                $smelterStep = $smelterStepTable->newEntity($this->request->getData());
                $smelterStep->rom_5_step_def = $smelterStepDef;
                $smelterStep->delete_status = 'no';

                $this->set('smelterStep', $smelterStep);

                if ($smelterStepTable->save($smelterStep)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Smelter Step</b> Successfully!!!');
                    $this->redirect(['action' => 'smelter-step']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Smelter Step</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the Smelter Step
    public function editSmelterStep($id = null)
    {
        $smelterStep = $this->DirSmelterStep->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirSmelterStep->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $smelterStep = $this->DirSmelterStep->patchEntity($smelterStep, $this->request->getData());

                if ($this->DirSmelterStep->save($smelterStep)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Smelter Step</b> Successfully!!!');
                    return $this->redirect(['action' => 'smelter-step']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Smelter Step</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('smelterStep'));
    }


    //to delete the Smelter Step
    public function deleteSmelterStep($id = null)
    {
        $smelterStep_table = TableRegistry::get('DirSmelterStep');
        $smelterStep = $smelterStep_table->get($id);
        $smelterStep->delete_status = 'yes';
        if ($this->DirSmelterStep->save($smelterStep)) {
            $this->Session->write('master_success_alert', 'The <b>Smelter Step</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Smelter Step</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'smelter-step']);
    }



    //////////////////////////////////////////////////////////////////////////////[State Master]
    /**
     * State Section
     * List State
     * Add, Update & Delete State
     * Delete State - Instead of deleteing changing its delete_status to yes
     */


    //to list all the State
    public function state()
    {
        $stateLists = $this->DirState->find('all')->where(['delete_status' => 'no']);
        $this->set('stateLists', $stateLists);
    }


    //to list all the State
    public function addState()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirState->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $stateCode = $this->request->getData('state_code');
                $stateName = $this->request->getData('state_name');

                $stateTable = TableRegistry::get('DirState');
                $state = $stateTable->newEntity($this->request->getData());
                $state->state_code = strtoupper($stateCode);
                $state->state_name = ucwords($stateName);
                $state->delete_status = 'no';

                $this->set('state', $state);

                if ($stateTable->save($state)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>State</b> Successfully!!!');
                    $this->redirect(['action' => 'state']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>State</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the State
    public function editState($id = null)
    {
        $state = $this->DirState->get($id, [
            'contain' => [],
        ]);

        $stateCode = $this->request->getData('state_code');
        $stateName = $this->request->getData('state_name');

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirState->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $state = $this->DirState->patchEntity($state, $this->request->getData());
                $state->state_code = strtoupper($stateCode);
                $state->state_name = ucwords($stateName);

                if ($this->DirState->save($state)) {

                    $this->Session->write('master_success_alert', 'Edited <b>State</b> Successfully!!!');
                    return $this->redirect(['action' => 'state']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>State</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('state'));
    }


    //to delete the State
    public function deleteState($id = null)
    {
        $state_table = TableRegistry::get('DirState');
        $state = $state_table->get($id);
        $state->delete_status = 'yes';
        if ($this->DirState->save($state)) {
            $this->Session->write('master_success_alert', 'The <b>State</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>State</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'state']);
    }



    ////////////////////////////////////////////////////////////////////////////////////////////////////[Grid Master]
    /**
     * Grid Section
     * List Grid
     * Add, Update & Grid State
     * Delete Grid - Instead of deleteing changing its delete_status to yes
     */


    //to list all the Grid
    public function grid()
    {
        $con = ConnectionManager::get('default');

        $sql = "SELECT dg.id, dg.grid_name, dg.grid_space, dg.grid_unit, du.unit_code 
		FROM dir_grid dg
       		inner join dir_unit du on dg.grid_unit = du.id
	        WHERE dg.delete_status = 'no' ORDER BY dg.grid_unit ASC ";
        $query = $con->execute($sql);
        $gridLists = $query->fetchAll('assoc');

        $this->set('gridLists', $gridLists);
    }


    //to add the Grid
    public function addGrid()
    {
        $queryGridUnit = $this->DirUnit->find('list', ['keyField' => 'id', 'valueField' => 'unit_code',])
            ->select('unit_code')->where(['delete_status' => 'no']);
        $gridUnits = $queryGridUnit->toArray();
        $this->set('gridUnits', $gridUnits);

        if ($this->request->is('post')) {

            $validation = $this->DirGrid->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $gridName = $this->request->getData('grid_name');
                $gridUnit = $this->request->getData('grid_unit');
                $gridSpace = $this->request->getData('grid_space');

                $gridTable = TableRegistry::get('DirGrid');
                $grid = $gridTable->newEntity($this->request->getData());
                $grid->grid_name = $gridName;
                $grid->grid_unit = $gridUnit;
                $grid->grid_space = $gridSpace;
                $grid->delete_status = 'no';

                $this->set('grid', $grid);

                if ($gridTable->save($grid)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Grid</b> Successfully!!!');
                    $this->redirect(['action' => 'grid']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Grid</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the Grid
    public function editGrid($id = null)
    {
        $queryGridUnit = $this->DirUnit->find('list', ['keyField' => 'id', 'valueField' => 'unit_code',])
            ->select('unit_code')->where(['delete_status' => 'no']);
        $gridUnits = $queryGridUnit->toArray();
        $this->set('gridUnits', $gridUnits);

        $grid = $this->DirGrid->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirGrid->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $grid = $this->DirGrid->patchEntity($grid, $this->request->getData());

                if ($this->DirGrid->save($grid)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Grid</b> Successfully!!!');
                    return $this->redirect(['action' => 'grid']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Grid</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('grid'));
    }


    //to delete the Grid
    public function deleteGrid($id = null)
    {
        $grid_table = TableRegistry::get('DirGrid');
        $grid = $grid_table->get($id);
        $grid->delete_status = 'yes';
        if ($this->DirGrid->save($grid)) {
            $this->Session->write('master_success_alert', 'The <b>Grid</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Grid</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'grid']);
    }



    ///////////////////////////////////////////////////////////////////////////////////////////[Concentrate Master]
    /**
     * Concentrate Section
     * List Concentrate
     * Add, Update & Delete Concentrate 
     * Delete Concentrate - Instead of deleteing changing its delete_status to yes
     */


    //to list all the Concentrate
    public function concentrate()
    {
        $concentrateLists = $this->DirConcentrate->find('all')->where(['delete_status' => 'no']);
        $this->set('concentrateLists', $concentrateLists);
    }


    //to add the Concentrate
    public function addConcentrate()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirConcentrate->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $typeConcentrate = $this->request->getData('type_concentrate');

                $concentrateTable = TableRegistry::get('DirConcentrate');
                $concentrate = $concentrateTable->newEntity($this->request->getData());
                $concentrate->grid_name = $typeConcentrate;
                $concentrate->delete_status = 'no';

                $this->set('concentrate', $concentrate);

                if ($concentrateTable->save($concentrate)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Concentrate</b> Successfully!!!');
                    $this->redirect(['action' => 'concentrate']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Concentrate</b> !!');
                }
            } else {

                $this->Session->write('Invalid Error');
            }
        }
    }


    //to edit the Concentrate
    public function editConcentrate($id = null)
    {
        $concentrate = $this->DirConcentrate->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirConcentrate->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $concentrate = $this->DirConcentrate->patchEntity($concentrate, $this->request->getData());

                if ($this->DirConcentrate->save($concentrate)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Concentrate</b> Successfully!!!');
                    return $this->redirect(['action' => 'concentrate']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Concentrate</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('concentrate'));
    }


    //to delete the Concentrate
    public function deleteConcentrate($id = null)
    {
        $concentrate_table = TableRegistry::get('DirConcentrate');
        $concentrate = $concentrate_table->get($id);
        $concentrate->delete_status = 'yes';
        if ($this->DirConcentrate->save($concentrate)) {
            $this->Session->write('master_success_alert', 'The <b>Concentrate</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Concentrate</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'concentrate']);
    }

    // To check Concentrate type already exist or not 
    public function checkTypeConcentrate()
    {
        $this->autoRender = false;
        $type_concentrate = $_POST['type_concentrate'];
        $con = ConnectionManager::get('default');
        $sql = "SELECT type_concentrate FROM dir_concentrate WHERE type_concentrate = '$type_concentrate'";

        $query = $con->execute($sql);
        $records = $query->fetchAll('assoc');

        foreach ($records as $record) {
            $tc = $record['type_concentrate'];
        }
        if ($type_concentrate == $tc) {
            echo 1;
        } else {
            echo 0;
        }
    }



    /////////////////////////////////////////////////////////////////////////////////[MCP Deposit Master]
    /**
     * Mcp Deposit Section
     * List Mcp Deposit
     * Add, Update & Delete Mcp Deposit 
     * Delete Mcp Deposit - Instead of deleteing changing its delete_status to yes
     */


    //to list all the MCP Deposit
    public function mcpDeposit()
    {
        $mcpDepositLists = $this->McpDeposit->find('all')->where(['delete_status' => 'no']);
        $this->set('mcpDepositLists', $mcpDepositLists);
    }


    //to add the MCP Deposit
    public function addMcpDeposit()
    {
        if ($this->request->is('post')) {

            $validation = $this->McpDeposit->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $mineCode = $this->request->getData('mine_code');
                $depositSn = $this->request->getData('depsoit_sn');
                $tsComtx = $this->request->getData('ts_comtx_dataeposit_name');
                $commodityName = $this->request->getData('commodity_name');
                $depositNo = $this->request->getData('deposit_no');
                $blockNo = $this->request->getData('block_no');
                $strikeLength = $this->request->getData('strike_length');
                $dipAmount = $this->request->getData('dip_amount');
                $dipDirection = $this->request->getData('dip_direction');
                $width = $this->request->getData('width');
                $depth = $this->request->getData('depth');

                $mcpDepositTable = TableRegistry::get('McpDeposit');
                $mcpDeposit = $mcpDepositTable->newEntity($this->request->getData());
                $mcpDeposit->mine_code = $mineCode;
                $mcpDeposit->depsoit_sn = $depositSn;
                $mcpDeposit->ts_comtx_dataeposit_name = $tsComtx;
                $mcpDeposit->commodity_name = $commodityName;
                $mcpDeposit->deposit_no = $depositNo;
                $mcpDeposit->block_no = $blockNo;
                $mcpDeposit->strike_length = $strikeLength;
                $mcpDeposit->dip_amount = $dipAmount;
                $mcpDeposit->dip_direction = $dipDirection;
                $mcpDeposit->width = $width;
                $mcpDeposit->depth = $depth;
                $mcpDeposit->delete_status = 'no';

                $this->set('mcpDeposit', $mcpDeposit);

                if ($mcpDepositTable->save($mcpDeposit)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>MCP Deposit</b> Successfully!!!');
                    $this->redirect(['action' => 'mcp-deposit']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>MCP Deposit</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the MCP Deposit
    public function editMcpDeposit($id = null)
    {
        $mcpDeposit = $this->McpDeposit->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->McpDeposit->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $mcpDeposit = $this->McpDeposit->patchEntity($mcpDeposit, $this->request->getData());

                if ($this->McpDeposit->save($mcpDeposit)) {

                    $this->Session->write('master_success_alert', 'Edited <b>MCP Deposit</b> Successfully!!!');
                    return $this->redirect(['action' => 'mcp-deposit']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>MCP Deposit</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('mcpDeposit'));
    }


    //to delete the MCP Deposit
    public function deleteMcpDeposit($id = null)
    {
        $mcpDeposit_table = TableRegistry::get('McpDeposit');
        $mcpDeposit = $mcpDeposit_table->get($id);
        $mcpDeposit->delete_status = 'yes';
        if ($this->McpDeposit->save($mcpDeposit)) {
            $this->Session->write('master_success_alert', 'The <b>MCP Deposit</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>MCP Deposit</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'mcp-deposit']);
    }



    //////////////////////////////////////////////////////////////////////////////[Mine Master]
    /**
     * Mine Section
     * List Mine
     * Add, Update & Delete Mine 
     * Delete Mine - Instead of deleteing changing its delete_status to yes
     */


    //to list all the Mine
    public function mineCodeGeneration()
    {
        $con = ConnectionManager::get('default');
		//$sql = "SELECT count(mine_code) as c from mine";

        $sql = "SELECT m.mine_code, m.MINE_NAME, m.village_name, m.taluk_name, s.state_name, d.district_name
        FROM mine m 
        INNER JOIN dir_state s ON m.state_code = s.state_code
        INNER JOIN dir_district d ON m.district_code = d.district_code AND d.state_code = s.state_code
        WHERE m.delete_status = 'no' ORDER BY m.updated_at DESC";
        $query = $con->execute($sql);
        $mineLists = $query->fetchAll('assoc');

        $this->set('mineLists', $mineLists); 
		//print_r($mineLists);exit;
    }


    //to add the Mine
    public function addMineCodeGeneration()
    {
        $queryMineCategory = $this->KwMineCategory->find('list', ['keyField' => 'mine_category', 'valueField' => 'mine_category',])
            ->select('mine_category')->where(['delete_status' => 'no']);
        $category = $queryMineCategory->toArray();
        $this->set('category', $category);

        $queryState = $this->DirState->find('list', ['keyField' => 'state_code', 'valueField' => 'state_name',])
            ->select(['state_name'])->where(['delete_status' => 'no']);
        $states = $queryState->toArray();
        $this->set('states', $states);

        $queryMineral = $this->DirMcpMineral->find('list', ['keyField' => 'mineral_code', 'valueField' => 'mineral_name',])
            ->select(['id', 'mineral_name', 'mineral_code'])
			->where(['form_type IS NOT NULL','delete_status'=>'no']);
			
        $minerals = $queryMineral->toArray();
        $this->set('minerals', $minerals);

        if ($this->request->is('post')) {

            $validation = $this->Mine->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $principleMineral = $this->request->getData('principle_mineral');
                $stateCode = $this->request->getData('state_code');
                $districtCode = $this->request->getData('district_code');
                $mineName = $this->request->getData('MINE_NAME');
				$lessee_owner_name = $this->request->getData('lessee_owner_name');
                $mineCategory = $this->request->getData('mine_category');
                $typeWorking = $this->request->getData('type_working');
                $natureUse = $this->request->getData('nature_use');
                $mechanisation = $this->request->getData('mechanisation');
                $mineOwnership = $this->request->getData('mine_ownership');
                $villageName = $this->request->getData('village_name');
                $talukName = $this->request->getData('taluk_name');
                $postOffice = $this->request->getData('post_office');
                $pin = $this->request->getData('pin');
                $faxNo = $this->request->getData('fax_no');
                $phoneNo = $this->request->getData('phone_no');
                $mobileNo = $this->request->getData('mobile_no');
                $email = $this->request->getData('email');
                $formType = '';

                $queryFormData = $this->DirMcpMineral->find()->select(['form_type'])->where(['mineral_code' => $principleMineral]);
                $query = $queryFormData->first();
                $formType = $query->form_type;

                $districtLength = strlen((string)$districtCode); //if district code contains 1 digit than just adding 0 in front

                if ($districtLength == 1) {

                    $districtCode = '0' . $districtCode;
                }

                $mineTable = TableRegistry::get('Mine');
                $mine = $mineTable->newEntity($this->request->getData());
				
				$shortStateCode = $this->DirState->find('all',array('fields'=>'state_short_code','conditions'=>array('id IS'=>$stateCode)))->first();
				
				if(strlen($principleMineral) == 1)
				{
					$principleMineral = '0'. $principleMineral;
				}

                $mineCode = $principleMineral . $shortStateCode['state_short_code'] . $districtCode;
				$substringlength = strlen($mineCode);
				$getSubstringlength = $substringlength+1;
//print_r($principleMineral); print_r('<br>');
//print_r($mineCode); print_r('<br>'); exit();
                $connection = ConnectionManager::get('default');

                $queryMineCodes = $connection->execute("SELECT substring(mine_code,".$getSubstringlength.",3) AS mineString FROM mine WHERE substring(mine_code, 1,".$substringlength.")  = '" . $mineCode . "'")->fetchAll('assoc');

                $count = count($queryMineCodes);

                if ($count > 0) {

                    $lastnumber = max($queryMineCodes); 
                    $lastnumber = $lastnumber['mineString'] + 1;
                    $lastnumber = str_pad($lastnumber, 3, "0", STR_PAD_LEFT);
                    $mineCode = $mineCode . $lastnumber;
                } else {

                    $mineCode = $mineCode . '001';
                }

				//print_r($mineCode); exit;
				
                $mine->mine_code = $mineCode;
                $mine->form_type = $formType;
                $mine->state_code = $stateCode;
                $mine->district_code = $districtCode;
                $mine->MINE_NAME = $mineName;
                $mine->mine_category = $mineCategory;
                $mine->type_working = $typeWorking;
                $mine->nature_use = $natureUse;
                $mine->mechanisation = $mechanisation;
                $mine->mine_ownership = $mineOwnership;
                $mine->village_name = $villageName;
                $mine->taluk_name = $talukName;
                $mine->post_office = $postOffice;
                $mine->pin = $pin;
                $mine->fax_no = $faxNo;
                $mine->phone_no = $phoneNo;
                $mine->mobile_no = $mobileNo;
                $mine->email = $email;
                $mine->delete_status = 'no';

                $this->set('mine', $mine);
				
                if ($mineTable->save($mine)) {
					
					$mcDistrictDir = TableRegistry::get('McDistrictDir');
					
					$regionCodes = $mcDistrictDir->find('all',array('fields'=>array('REGION_CODE','REGION_NAME'),'conditions'=>array('LG_DistrictCode IS'=>$districtCode)))->first();
					
					if($regionCodes != ''){
						$region_name = $regionCodes['REGION_NAME'];
						$region_code = $regionCodes['REGION_CODE'];
						
					}else{
						$region_name = null;
						$region_code = null;
					}
					
					$mcMineDirTable = TableRegistry::get('McMineDir');
					
					//Insert the entery in registration mineral directory table 					
					$mcMineDir = $mcMineDirTable->newEntity(array(
						'mcm_mine_code' => $mineCode,
						'mcm_mine_desc' => $mineName,
						'mcm_mine_LesseeOwnerName' => $lessee_owner_name,
						'mcm_mine_VillageName' => $villageName,
						'mcm_region_name' => $region_name,
						'mcm_region_code' => $region_code,
						'mcm_status' => 'A',
						'username' => $_SESSION['mms_user_id'],
						'activity_type' => 'A',
						'activity_time' => date('Y-m-d H:i:s'),
						'activity_ip' => $this->request->clientIp(),
						'mcm_state_code' => $stateCode,
						'mcm_district_code' => $districtCode,
						'mcm_datapush_status' => 1,
						'mine_category'=>$mineCategory,
						'nature_use'=>$natureUse,
						'type_working'=>$typeWorking,
						'mechanisation'=>$mechanisation,
						'mine_ownership'=>$mineOwnership
					));					
					//print_r($mcMineDir); exit;
					$mcMineDirTable->save($mcMineDir);
					
					$mms_user_id = $_SESSION['mms_user_id'];
					$activity_time = date('Y-m-d H:i:s');
					$activity_ip = $this->request->clientIp();
					
					//$connection->execute("CALL pr_insertMineDirectoryHistory('$mineName','$mineCode','$mms_user_id','A','$activity_time','$activity_ip')");
					
                    $this->Session->write('master_success_alert', 'Inserted <b>Mine</b> Successfully!!!');
                    $this->redirect(['action' => 'mine-code-generation']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Mine</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the Mine
    public function editMineCodeGeneration($id = null)
    {
        $mineCode = $this->Mine->get($id, [
            'contain' => [],
        ]);

        $queryMineCategory = $this->KwMineCategory->find('list', [
            'keyField' => 'mine_category',
            'valueField' => 'mine_category',
        ])
            ->select('mine_category')->where(['delete_status' => 'no']);
        $category = $queryMineCategory->toArray();
        $this->set('category', $category);

        $queryState = $this->DirState->find('list', [
            'keyField' => 'state_code',
            'valueField' => 'state_name',
        ])
            ->select(['state_name'])->where(['delete_status' => 'no']);
        $states = $queryState->toArray();
        $this->set('states', $states);

        $queryDistrict = $this->DirDistrict->find('list', [
            'keyField' => 'district_code',
            'valueField' => 'district_name',
        ])
            ->select(['district_name'])
            ->where(['state_code' => $mineCode->state_code]);
        $districts = $queryDistrict->toArray();
        $this->set('districts', $districts);

        $queryMineral = $this->DirMcpMineral->find('list', [
            'keyField' => 'mineral_code',
            'valueField' => 'mineral_name',			
        ])
            ->select(['id', 'mineral_name', 'mineral_code'])
			->where(['form_type IS NOT NULL','delete_status'=>'no']);
			
        $minerals = $queryMineral->toArray();
        $this->set('minerals', $minerals);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->Mine->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $mineCode = $this->Mine->patchEntity($mineCode, $this->request->getData());

                if ($this->Mine->save($mineCode)) {
					
					$mcDistrictDir = TableRegistry::get('McDistrictDir');
					
					$regionCodes = $mcDistrictDir->find('all',array('fields'=>array('REGION_CODE','REGION_NAME'),'conditions'=>array('LG_DistrictCode IS'=>$this->request->getData('district_code'))))->first();
					
					if($regionCodes != ''){
						$region_name = $regionCodes['REGION_NAME'];
						$region_code = $regionCodes['REGION_CODE'];
						
					}else{
						$region_name = null;
						$region_code = null;
					}
					
					$mcMineDirTable = TableRegistry::get('McMineDir');
					
					$recordId = $mcMineDirTable->find('all',array('fields'=>'SlNo','conditions'=>array('mcm_mine_code IS'=>$mineCode['mine_code'])))->first();
					$recordIdnum = $recordId['SlNo'];
					
					$mineName = $this->request->getData('MINE_NAME');
					$mms_user_id = $_SESSION['mms_user_id'];
					$activity_time = date('Y-m-d H:i:s');
					$activity_ip = $this->request->clientIp();
					$mineCodee = $mineCode['mine_code'];
					
					$connection = ConnectionManager::get('default');
					//print_r("CALL pr_insertMineDirectoryHistory('$mineName','$mineCodee','$mms_user_id','U','$activity_time','$activity_ip')"); exit;
					$connection->execute("CALL pr_insertMineDirectoryHistory('$mineName','$mineCodee','$mms_user_id','U','$activity_time','$activity_ip')");
					
					
					//Update the entery in registration mineral directory table 					
					$mcMineDir = $mcMineDirTable->newEntity(array(
						'SlNo' => $recordIdnum,
						'mcm_mine_desc' => $this->request->getData('MINE_NAME'),
						//'mcm_mine_LesseeOwnerName' => $lesseeOwnerName,
						'mcm_mine_VillageName' => $this->request->getData('village_name'),
						'mcm_region_name' => $region_name,
						'mcm_region_code' => $region_code,
						'username' => $_SESSION['mms_user_id'],
						'activity_type' => 'U',
						'activity_time' => date('Y-m-d H:i:s'),
						'activity_ip' => $this->request->clientIp(),
						'mcm_state_code' => $this->request->getData('state_code'),
						'mcm_district_code' => $this->request->getData('district_code'),
						'mcm_datapush_status' => 1,
						'mine_category'=>$this->request->getData('mine_category'),
						'nature_use'=>$this->request->getData('nature_use'),
						'type_working'=>$this->request->getData('type_working'),
						'mechanisation'=>$this->request->getData('mechanisation'),
						'mine_ownership'=>$this->request->getData('mine_ownership')
					));					
					
					$mcMineDirTable->save($mcMineDir);	
					
						

                    $this->Session->write('master_success_alert', 'Edited <b>Mine</b> Successfully!!!');
                    return $this->redirect(['action' => 'mine-code-generation']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Mine</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('mineCode'));
    }


    //to delete the Mine
    public function deleteMineCodeGeneration($id = null)
    {
        $mineCode_table = TableRegistry::get('Mine');
        $mineCode = $mineCode_table->get($id);
        $mineCode->delete_status = 'yes';
        if ($this->Mine->save($mineCode)) {
            $this->Session->write('master_success_alert', 'The <b>Mine</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Mine</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'mine-code-generation']);
    }




    //////////////////////////////////////////////////////////////////////////////[Mine Category Master]
    /**
     * Mine Category Section
     * List Mine Category
     * Add, Update & Delete Mine Category
     * Delete Mine Category - Instead of deleteing changing its delete_status to yes
     */


    //to list all the Mine Category
    public function mineCategory()
    {
        $mineCategoryLists = $this->KwMineCategory->find('all')->where(['delete_status' => 'no']);
        $this->set('mineCategoryLists', $mineCategoryLists);
    }


    //to add the Mine Category
    public function addMineCategory()
    {
        if ($this->request->is('post')) {

            $validation = $this->KwMineCategory->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $mineCat = $this->request->getData('mine_category');

                $connection = ConnectionManager::get('default');

                $query = $connection->execute("SELECT mine_category AS mineCategory FROM kw_mine_category WHERE mine_category  = '" . $mineCat . "'")->fetchAll('assoc');
                $count = count($query);

                $mineCategoryTable = TableRegistry::get('KwMineCategory');

                $mineCategory = $mineCategoryTable->newEntity($this->request->getData());

                if ($count > 0) {

                    $this->Session->write('Mine Category already exist');
                } else {

                    $mineCategory->mine_category = strtoupper($mineCat);
                    $mineCategory->delete_status = 'no';

                    $this->set('mineCategory', $mineCategory);

                    if ($mineCategoryTable->save($mineCategory)) {

                        $this->Session->write('master_success_alert', 'Inserted <b>Mine Category</b> Successfully!!!');
                        $this->redirect(['action' => 'mine-category']);
                    } else {

                        $this->Session->write('master_error_alert', 'Failed to Insert <b>Mine Category</b> !!');
                    }
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the Mine Category
    public function editMineCategory($id = null)
    {
        $mineCategory = $this->KwMineCategory->get($id, [
            'contain' => [],
        ]);

        $mineCat = $this->request->getData('mine_category');

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->KwMineCategory->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $mineCategory = $this->KwMineCategory->patchEntity($mineCategory, $this->request->getData());

                $mineCategory->mine_category = strtoupper($mineCat);

                if ($this->KwMineCategory->save($mineCategory)) {

                    $this->Session->write('master_success_alert', 'Edited <b>Mine Category</b> Successfully!!!');
                    return $this->redirect(['action' => 'mine-category']);
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Mine Category</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('mineCategory'));
    }


    //to delete the Mine Category
    public function deleteMineCategory($id = null)
    {
        $mineCategory_table = TableRegistry::get('KwMineCategory');
        $mineCategory = $mineCategory_table->get($id);
        $mineCategory->delete_status = 'yes';
        if ($this->KwMineCategory->save($mineCategory)) {
            $this->Session->write('master_success_alert', 'The <b>Mine Category</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Mine Category</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'mine-category']);
    }





    ///////////////////////////////////////////////////////////////////////////////////////////////[Mineral Work]
    /**
     * Mineral Worked Section
     * List Mineral Worked
     * Add, Update & Delete Mineral Worked
     * Delete Mineral Worked - Instead of deleteing changing its delete_status to yes
     */


    //to list all the Mineral Work
    public function mineralWork()
    {
        $mineralWorkedLists = $this->MineralWorked->find()->select([
            'mine_code', 'mineral_name', 'mineral_sn', 'proportion', 'ore_lump', 'ore_fines', 'id'
        ])->where(['delete_status' => 'no'])->order(['updated_at' => 'DESC'])->toArray();

        $this->set('mineralWorkedLists', $mineralWorkedLists);
    }


    //to add the Mineral Work
    public function addMineralWork()
    {
        $queryMineral = $this->DirMcpMineral->find('list', [
            'keyField' => 'mineral_name',
            'valueField' => 'mineral_name',
        ])
            ->select(['id', 'mineral_name', 'mineral_code'])
			->where(['delete_status'=>'no']);
			
        $minerals = $queryMineral->toArray();
        $this->set('minerals', $minerals);

        if ($this->request->is('post')) {

            $validation = $this->MineralWorked->postDataValidationMasters($this->request->getData());

            if ($validation == true) {

                $mineCode = trim($this->request->getData('mine_code'));
                $mineralName = $this->request->getData('mineral_name');
                $mineralSn = $this->request->getData('mineral_sn');
                $proportion = $this->request->getData('proportion');
                $oreLump = $this->request->getData('ore_lump');
                $oreFines = $this->request->getData('ore_fines');
                $oreFriable = $this->request->getData('ore_friable');
                $oreGranular = $this->request->getData('ore_granular');
                $orePlaty = $this->request->getData('ore_platy');
                $oreFibrous = $this->request->getData('ore_fibrous');
                $oreOther = $this->request->getData('ore_other');

                $mineralWorkTable = TableRegistry::get('MineralWorked');
                
                $duplicateMineralCheck = false;
                // check duplicate mineral names validation
                $oldData = $mineralWorkTable->find()->where(['mine_code'=>$mineCode, 'mineral_name'=>$mineralName])->count();
                if($oldData > 0){
                    $duplicateMineralCheck = true;
                    $this->Session->write('master_error_alert', $mineralName.' mineral already present for the mine code '.$mineCode);
                }
                
                // check mineral_sn validation
                if($mineralSn == 1){
                    $oldData = $mineralWorkTable->find()->where(['mine_code'=>$mineCode, 'mineral_sn'=>1])->count();
                    if($oldData > 0){
                        $duplicateMineralCheck = true;
                        $this->Session->write('master_error_alert', '<b>Mineral Sn</b> with "1" already present. Multiple entries with "1" is not allowed.');
                    }
                }
                
                if($duplicateMineralCheck == false){
                    $mineralWork = $mineralWorkTable->newEntity($this->request->getData());
                    $mineralWork->mine_code = $mineCode;
                    $mineralWork->mineral_name = $mineralName;
                    if ($mineralSn == '') {
                        $mineralWork->mineral_sn = 1;
                    } else {
                        $mineralWork->mineral_sn = $mineralSn;
                    }
                    $mineralWork->proportion = $proportion;
                    $mineralWork->ore_lump = $oreLump;
                    $mineralWork->ore_fines = $oreFines;
                    $mineralWork->ore_friable = $oreFriable;
                    $mineralWork->ore_granular = $oreGranular;
                    $mineralWork->ore_platy = $orePlaty;
                    $mineralWork->ore_fibrous = $oreFibrous;
                    $mineralWork->ore_other = $oreOther;
                    $mineralWork->delete_status = 'no';

                    $this->set('mineralWork', $mineralWork);

                    if ($mineralWorkTable->save($mineralWork)) {

                        $this->Session->write('master_success_alert', 'Inserted <b>Mineral Work</b> Successfully!!!');
                        $this->redirect(['action' => 'mineral-work']);
                    } else {

                        $this->Session->write('master_error_alert', 'Failed to Insert <b>Mineral Work</b> !!');
                    }

                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the Mineral Work
    public function editMineralWork($id = null)
    {
        // $mineralWork = $this->MineralWorked->get($id, [
        //     'contain' => [],
        // ]);
        $mineralWork = $this->MineralWorked->find('all')->where(['id'=>$id])->first();

        $queryMineral = $this->DirMcpMineral->find('list', [
            'keyField' => 'mineral_name',
            'valueField' => 'mineral_name',
        ])
            ->select(['id', 'mineral_name', 'mineral_code'])
			->where(['delete_status'=>'no']);
        $minerals = $queryMineral->toArray();
        $this->set('minerals', $minerals);


        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->MineralWorked->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {
                
                $duplicateMineralCheck = false;
                // check duplicate mineral names validation
                $mineCode = $this->request->getData('mine_code');
                $mineralName = $mineralWork['mineral_name'];
                $mineralSn = $this->request->getData('mineral_sn');
                $oldData = $this->MineralWorked->find()->where(['mine_code'=>$mineCode, 'mineral_name'=>$mineralName, 'id !='=>$id])->count();
                if($oldData > 0){
                    $duplicateMineralCheck = true;
                    $this->Session->write('master_error_alert', $mineralName.' mineral already present for the mine code '.$mineCode);
                }
                
                // check mineral_sn validation
                if($mineralSn == 1){
                    $oldData = $this->MineralWorked->find()->where(['mine_code'=>$mineCode, 'mineral_sn'=>1, 'id !='=>$id])->count();
                    if($oldData > 0){
                        $duplicateMineralCheck = true;
                        $this->Session->write('master_error_alert', '<b>Mineral Sn</b> cannot set "1" multiple times');
                    }
                }

                if($duplicateMineralCheck == false){

                    $mineralWork = $this->MineralWorked->patchEntity($mineralWork, $this->request->getData());

                    if ($this->MineralWorked->save($mineralWork)) {

                        $this->Session->write('master_success_alert', 'Edited <b>Mineral Work</b> Successfully!!!');
                        return $this->redirect(['action' => 'mineral-work']);
                    }
                    
                }

                $this->Session->write('master_error_alert', 'Failed to Edit the <b>Mineral Work</b> !!');
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('mineralWork'));
    }


    //to delete the Mineral Work
    public function deleteMineralWork($id = null)
    {
        $mineralWork_table = TableRegistry::get('MineralWorked');
        // $mineralWork = $mineralWork_table->get($id);
        $mineralWork = $this->MineralWorked->find('all')->where(['id'=>$id])->first();
        $mineralWork->delete_status = 'yes';
        if ($this->MineralWorked->save($mineralWork)) {
            $this->Session->write('master_success_alert', 'The <b>Mineral Work</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Mineral Work</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'mineral-work']);
    }



    //FUNCTION / MASTER FOR FINISHED PRODUCT FOR ADD/EDIT/SHOW added on 11-01-2022 By Akash
    //////////////////////////////////////////////////////////////////////////////////////////////[Finished Products]
    /**
     * Finished Products Section
     * List Mineral Worked
     * Add, Update & Delete Mineral Worked
     * Delete Mineral Worked - Instead of deleteing changing its delete_status to yes
     */


    //to list all the Finished Product
    public function finishedProducts()
    {
        $finihsedProductsLists = $this->DirFinishedProducts->find('all')->where(['is_deleted' => 'no']);
        $this->set('finish_products_list', $finihsedProductsLists);
    }


    //to add the Finished Product
    public function addFinishedProduct()
    {
        if ($this->request->is('post')) {

            $validation = $this->DirFinishedProducts->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $fProducts = $this->request->getData('f_products');

                if ($this->DirFinishedProducts->checkIfALreadyExistFinishedProduct($fProducts) != 1) {

                    $FinishedProductsTable = TableRegistry::getTableLocator()->get('DirFinishedProducts');
                    $f_products = $FinishedProductsTable->newEntity($this->request->getData());
                    $f_products->f_products = $fProducts;
                    $f_products->is_deleted = 'no';

                    $this->set('f_products', $f_products);

                    if ($FinishedProductsTable->save($f_products)) {

                        $this->Session->write('master_success_alert', 'Inserted <b>Finished Product</b> Successfully!!!');
                        $this->redirect(['action' => 'finished-products']);
                    } else {

                        $this->Session->write('master_error_alert', 'Failed to Insert <b>Finished Product</b> !!');
                    }
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }


    //to edit the Finished Product
    public function editFinishedProduct($id = null)
    {
        $finishedProducts = $this->DirFinishedProducts->get($id, ['contain' => [],]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $validation = $this->DirFinishedProducts->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $fProducts = $this->request->getData('f_products');

                if ($this->DirFinishedProducts->checkIfALreadyExistFinishedProduct($fProducts) != 1) {

                    $finishedProducts = $this->DirFinishedProducts->patchEntity($finishedProducts, $this->request->getData());
                    if ($this->DirFinishedProducts->save($finishedProducts)) {

                        $this->Session->write('master_success_alert', 'Edited <b>Finished Product</b> Successfully!!!');
                        return $this->redirect(['action' => 'finished-products']);
                    } else {

                        $this->Session->write('master_error_alert', 'Failed to Edit the <b>Finished Product</b> !!');
                    }
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Edit the <b>Finished Product</b> . It is already exists!!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }

        $this->set(compact('finishedProducts'));
    }


    //to delete the Finished Product
    public function deleteFinishedProduct($id = null)
    {
        $FinishedProductsTable = TableRegistry::getTableLocator()->get('DirFinishedProducts');
        $FinishedProducts = $FinishedProductsTable->get($id);
        $FinishedProducts->is_deleted = 'yes';
        if ($this->DirFinishedProducts->save($FinishedProducts)) {
            $this->Session->write('master_success_alert', 'The <b>Finished Product</b> has been deleted.');
        } else {
            $this->Session->write('master_error_alert', 'The <b>Finished Product</b> could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'finished-products']);
    }





    //FUNCTION / MASTER FOR TEMPLATE ADD/EDIT/SHOW added on 11-01-2022 By Akash
    //////////////////////////////////////////////////////////////////////////////////////////[SMS / Email Templates Master]
    /**
     * SMS/EMAIL Template Section
     * List Mineral Worked
     * Add, Update & Delete Mineral Worked
     * Delete Mineral Worked - Instead of deleteing changing its delete_status to yes
     */


    //to list the sms email templates
    public function smsEmailTemplates()
    {

        $smsEmailTemplatesList = $this->DirSmsEmailTemplates->find('all')->where(['OR' => array('delete_status IS NULL', 'delete_status =' => 'no')]);
        $this->set('smsEmailTemplatesList', $smsEmailTemplatesList);
    }


    //to add the sms email templates
    public function addSmsEmailTemplates()
    {


        if ($this->request->is('post')) {

            $postData = $this->request->getData();
            // html encoding
            $sms_message = htmlentities($postData['sms_message'], ENT_QUOTES);
            $email_message = htmlentities($postData['email_message'], ENT_QUOTES);
            $email_subject = htmlentities($postData['email_subject'], ENT_QUOTES);
            $description = htmlentities($postData['description'], ENT_QUOTES);

            $DirSmsEmailTemplates = TableRegistry::getTableLocator()->get('DirSmsEmailTemplates');

            $i = 0;
            //Current selected values from edit page for DMI

            $destination = array();

            if ($postData['applicant'] == 1) {
                $destination[$i] = 1;
                $i = $i + 1;
            }

            if ($postData['ibm_officer'] == 1) {
                $destination[$i] = 2;
                $i = $i + 1;
            }

            $destination_values = implode(',', $destination);
            //save array
            $data_array = array(
                'sms_message' => $sms_message,
                'email_message' => $email_message,
                'email_subject' => $email_subject,
                'destination' => $destination_values,
                'user_email_id' => $this->Session->read('username'),
                'user_once_no' => "n/a",
                'status' => 'active',
                'description' => $description,
                'template_for' => "ibm",
                'created' => date('Y-m-d H:i:s')
            );


            $DirSmsEmailTemplatesEntity = $DirSmsEmailTemplates->newEntity($data_array);

            if ($DirSmsEmailTemplates->save($DirSmsEmailTemplatesEntity)) {

                $this->Session->write('master_success_alert', 'Saved <b>New Template</b>! Successfully.');
                $this->redirect(['action' => 'sms-email-templates']);
            } else {

                $this->Session->write('master_error_alert', 'Failed to saved <b>Template</b>! Please, try again later.');
                $this->redirect(['action' => 'sms-email-templates']);
            }
        }
    }



    //to edit the sms email template
    public function editTemplate($id = null)
    {

        $templates = $this->DirSmsEmailTemplates->get($id, ['contain' => [],]);
        $this->set('template', $templates);

        $DirSmsEmailTemplates = TableRegistry::getTableLocator()->get('DirSmsEmailTemplates');

        //Existed values from table
        $existed_destination_values = $templates['destination'];


        if (!empty($existed_destination_values)) {
            $existed_destination_array = explode(',', $existed_destination_values);
        } else {
            $existed_destination_array = array();
        }

        $this->set(compact('existed_destination_array'));

        if ($this->request->is(['patch', 'post', 'put'])) {

            $postData = $this->request->getData();
            $i = 0;
            //Current selected values from edit page for DMI

            $destination = array();

            if ($postData['applicant'] == 1) {
                $destination[$i] = 1;
                $i = $i + 1;
            }

            if ($postData['ibm_officer'] == 1) {
                $destination[$i] = 2;
                $i = $i + 1;
            }

            $destination_values = implode(',', $destination);


            $data_array = array(
                'id' => $id,
                //'sms_message' => $postData['sms_message'],
                'email_message' => $postData['email_message'],
                'email_subject' => $postData['email_subject'],
                'destination' => $destination_values,
                'user_email_id' => $this->Session->read('username'),
                'user_once_no' => "n/a",
                'status' => 'active',
                'description' => $postData['description'],
                'template_for' => "ibm",
                'created' => date('Y-m-d H:i:s')
            );

            $DirSmsEmailTemplatesEntity = $DirSmsEmailTemplates->newEntity($data_array);


            if ($this->DirSmsEmailTemplates->save($DirSmsEmailTemplatesEntity)) {

                $this->Session->write('master_success_alert', 'Saved <b>Edited Template</b>! Successfully.');
                return $this->redirect(['action' => 'sms-email-templates']);
            }

            $this->Session->write('master_error_alert', 'Saved <b>New Template</b>! Successfully.');
        }
    }


    //to change the status of SMS/Email templates
    public function changeTemplateStatus($id = null)
    {

        $sms_template_values = $this->DirSmsEmailTemplates->find('all', array('conditions' => array('id IS' => $id)))->first();

        if ($sms_template_values['status'] == 'active') {

            $status = 'disactive';
            $message = 'You have <b>Deactivated</b> this SMS/Email Template';
        } else {
            $status = 'active';
            $message = 'You have <b>Activated</b> this SMS/Email Template';
        }

        $DirSmsEmailTemplatesEntity = $this->DirSmsEmailTemplates->newEntity(array(
            'id' => $id,
            'status' => $status,
            'modified' => date('Y-m-d H:i:s')
        ));

        if ($this->DirSmsEmailTemplates->save($DirSmsEmailTemplatesEntity)) {


            $this->Session->write('master_success_alert', $message);
            $this->redirect(['action' => 'sms-email-templates']);
        }
    }
	
	
	
	/* Minerals master Pravin Bhakare 22-02-2023*/
	public function mineralsList(){
		
		$connection = ConnectionManager::get('default');
		
		$minerals_not_exist_in_returns = $connection->execute("select * from mc_minerals_dir where MINERAL_CODE NOT IN (select mineral_code from dir_mcp_mineral where mineral_code IS NOT NULL)");
		$this->set('minerals_not_exist_in_returns',$minerals_not_exist_in_returns);	
		
		
		$mineLists = $this->DirMcpMineral->find('all',array('fields'=>array('id','mineral_name','mineral_code','form_type','delete_status'),'order'=>'mineral_name'))->toArray();
		$this->set('mineLists',$mineLists);	
		
		$queryUnit = $this->DirUnit->find('list', ['keyField' => 'unit_code', 'valueField' => 'unit_code'])
            ->select('unit_code')->where(['delete_status' => 'no'])->order(['unit_code']);
        $units = $queryUnit->toArray();
        $this->set('units', $units);
		
	}
	
	public function addMinerals(){
		
		$queryUnit = $this->DirUnit->find('list', ['keyField' => 'unit_code', 'valueField' => 'unit_code'])
            ->select('unit_code')->where(['delete_status' => 'no'])->order(['unit_code']);
        $units = $queryUnit->toArray();
        $this->set('units', $units);
				
		if ($this->request->is('post')) {
			
			
			$postData = $this->request->getData();
			
			$alreadyPresent = $this->DirMcpMineral->find('all',array('fields'=>array('mineral_name'),'conditions'=>array('mineral_name'=>strtoupper($postData['mineral_name']))))->first();
			
			if(empty($alreadyPresent)){
				
				$maxMineralCode = $this->DirMcpMineral->find('all',array('fields'=>array('mineral_code'=>'MAX(mineral_code)')))->first();
							
				// html encoding
				$mineral_name = htmlentities($postData['mineral_name'], ENT_QUOTES);
				$form_type = htmlentities($postData['form_type'], ENT_QUOTES);
				$input_unit = htmlentities($postData['input_unit'], ENT_QUOTES);
				$output_unit = htmlentities($postData['output_unit'], ENT_QUOTES);
				$mineral_type = htmlentities($postData['mineral_type'], ENT_QUOTES);
				//print_r($maxMineralCode['mineral_code']); exit;
				$mineralCode = $maxMineralCode['mineral_code'] + 1;
				//print_r($mineralCode); exit;
				$newEntity = $this->DirMcpMineral->newEntity(array(
					'mineral_name'=>strtoupper($mineral_name),
					'mineral_full_name'=>strtoupper($mineral_name),
					'form_type'=>$form_type,
					'input_unit'=>$input_unit,
					'output_unit'=>$output_unit,
					'mineral_type'=>$mineral_type,
					'mineral_code'=>$mineralCode,
                    'delete_status'=>'no',
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>date('Y-m-d H:i:s')
				));
				
				if($this->DirMcpMineral->save($newEntity)){
					$this->Session->write('master_success_alert', 'Mineral Added Successfully.');
					
					$connection = ConnectionManager::get('default');
					$connection->execute("insert into mc_minerals_dir (MINERAL_NAME,MINERAL_FULL_NAME,MINERAL_CODE,FORM_TYPE,INPUT_UNIT,OUTPUT_UNIT,Mineral_status,Mineral_Type)
					values('$mineral_name','$mineral_name','$mineralCode','$form_type','$input_unit','$output_unit',1,'$mineral_type')");
					
				}else{
					$this->Session->write('master_error_alert', 'Something went wrong, mineral not added');
				}
				$this->redirect(['action' => 'minerals-list']);	
			
			}else{
				$this->Session->write('master_error_alert', 'The mineral has already present');
				$this->redirect(['action' => 'minerals-list']);	
			}	
		}			
	}
	
	public function deleteMineralDt($mineralCode){
		
		$connection = ConnectionManager::get('default');
		
		if (filter_var($mineralCode, FILTER_VALIDATE_INT)!== false) {
			
			$query = $connection->execute("SELECT mine_code AS the_number FROM mine 
										where REGEXP_SUBSTR(mine_code,'^[0-9]+') = '$mineralCode'
										UNION 
										SELECT mine_code FROM mineral_worked
										where lower(mineral_name) = (SELECT lower(MINERAL_NAME) FROM mc_minerals_dir where MINERAL_CODE = '$mineralCode' limit 1)
										UNION 
										SELECT mineral_name FROM dir_mineral_grade
										where lower(mineral_name) = (SELECT lower(MINERAL_NAME) FROM mc_minerals_dir where MINERAL_CODE = '$mineralCode' limit 1)
										limit 1");
            $count = count($query);
			//print_r($count); exit;
			if($count > 0 ){
				$this->Session->write("master_error_alert", "The mineral is already used, So it can't be deactivated");
				$this->redirect(['action' => 'minerals-list']);					
			}else{	
                $date = date('Y-m-d H:i:s');
				$connection->execute("update mc_minerals_dir set Mineral_status = 0 where MINERAL_CODE = $mineralCode");
				$connection->execute("update dir_mcp_mineral set delete_status = 'yes', updated_at = '$date' where MINERAL_CODE = $mineralCode");
				
				$this->Session->write("master_success_alert", "The mineral successfully deactivated");
				$this->redirect(['action' => 'minerals-list']);				
			}
			
		} else {
			
			$this->Session->write("master_error_alert", "Invaild mineral name");
			$this->redirect(['action' => 'minerals-list']);	
		}
		
	}
	
	
	public function addmineralfromreg(){
		$this->autoRender = false;
		
		$mineralCode = trim($_POST['mineral_code']);
		$input_unit = htmlentities(trim($_POST['input_unit']), ENT_QUOTES);
		$output_unit = htmlentities(trim($_POST['output_unit']), ENT_QUOTES);
		$form_type = htmlentities(trim($_POST['form_type']), ENT_QUOTES);
		$recordstatus = htmlentities(trim($_POST['recordstatus']), ENT_QUOTES);
		//echo $mineralCode; exit;
		if (filter_var($mineralCode, FILTER_VALIDATE_INT)!== false) {
			
			$connection = ConnectionManager::get('default');		
			$mineralsDetails = $connection->execute("select * from mc_minerals_dir where MINERAL_CODE = $mineralCode")->fetch('assoc');		
				//print_r($mineralsDetails); exit;
			$mineral_name = $mineralsDetails['MINERAL_NAME'];
			$mineral_full_name = $mineralsDetails['MINERAL_FULL_NAME'];
			$formtype = $form_type == '' ? $mineralsDetails['FORM_TYPE'] : $form_type;
			$inputunit = $input_unit == '' ? $mineralsDetails['INPUT_UNIT'] : $input_unit;
			$outputunit = $output_unit == '' ? $mineralsDetails['OUTPUT_UNIT'] : $output_unit;
			$mineral_type = $mineralsDetails['Mineral_Type'];
			$delete_status = ($mineralsDetails['Mineral_status'] == 0) ? 'yes' : 'no';
			
			$newEntity = $this->DirMcpMineral->newEntity(array(
					'mineral_name'=>strtoupper($mineral_name),
					'mineral_full_name'=>strtoupper($mineral_full_name),
					'form_type'=>$formtype,
					'input_unit'=>$inputunit,
					'output_unit'=>$outputunit,
					'mineral_type'=>$mineral_type,
					'mineral_code'=>$mineralCode,
                    'delete_status'=>$delete_status,
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>date('Y-m-d H:i:s')
				));
			$this->DirMcpMineral->save($newEntity);
			
			$connection->execute("update mc_minerals_dir set FORM_TYPE = '$formtype', INPUT_UNIT = '$inputunit', OUTPUT_UNIT ='$outputunit'  where MINERAL_CODE = $mineralCode");
			
			echo 1;
				
		}else{
			echo $mineralCode;
		}
	}
	
	public function checkInprocessMineDetails(){
		
		$this->autoRender = false;
		
		$mine_code = trim($_POST['mine_code']);
			
		$connection = ConnectionManager::get('default');		
		$records = $connection->execute("select mcmdt_mineCode,mcmdt_mp_editable_status from mc_minesleasearea_dt where trim(mcmdt_mineCode) = '$mine_code' and mcmdt_mp_editable_status = 0 ")->fetch('assoc');	
		// print_r($records); print_r("select mcmdt_mineCode,mcmdt_mp_editable_status from mc_minesleasearea_dt where mcmdt_mineCode = '$mine_code'"); exit;
		// if(!empty($records)){
		// 	if($records['mcmdt_mp_editable_status'] == 0){
		// 		echo 0;
        //     }else{
		// 		echo 1;
		// 	}
		// }else{
		// 	echo 1;
		// }
        if(!empty($records)){
            echo 0;
		}else{
			echo 1;
		}
        exit;
		
	}

    

    //////////////////////////////////////////////////////////////////////////////[Transport Mode Master]
    /** Added on 17-04-2023 by Shweta Apale
     * Transport Mode Section
     * List Transport Mode
     * Add Transport Mode
     */

    //to list all the Transport Mode
    public function transportMode()
    {
        $transportModeLists = $this->OSupplyMode->find('all');
        $this->set('transportModeLists', $transportModeLists);
    }

    //to add the Transport Mode
    public function addTransportMode()
    {
        if ($this->request->is('post')) {

            $validation = $this->OSupplyMode->postDataValidationMasters($this->request->getData());

            if ($validation == 1) {

                $transportMode = $this->request->getData('transport_mode');

                $transportModeTable = TableRegistry::get('OSupplyMode');
                $transportModeTbl = $transportModeTable->newEntity($this->request->getData());
                $transportModeTbl->mode_name = ucwords($transportMode);

                $this->set('transportModeTbl', $transportModeTbl);

                if ($transportModeTable->save($transportModeTbl)) {

                    $this->Session->write('master_success_alert', 'Inserted <b>Transport Mode</b> Successfully!!!');
                    $this->redirect(['action' => 'transport-mode']);
                } else {

                    $this->Session->write('master_error_alert', 'Failed to Insert <b>Transport Mode</b> !!');
                }
            } else {

                $this->Session->write('master_error_alert', 'Invalid Data Inserted');
            }
        }
    }
    //////////////////////////////////////////////////////////////////////////////[Transport Mode Master]
	
}
