<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Utility\Inflector;
use App\Controller\CronjobController;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */

    public function initialize(): void
    {
        parent::initialize();
        
        $this->loadComponent('Customfunctions');
        $this->viewBuilder()->setHelpers(['Form','Html']);
        $this->Session = $this->getRequest()->getSession();
    }
    // show front page date: 03/02/2022
    public function display(string ...$path)
    {
        $this->viewBuilder()->setTemplatePath('Pages');
        $this->viewBuilder()->setLayout('default');
        $this->viewBuilder()->setTemplate('default');
        $path = func_get_args();
        $count = count($path);
        //debug($count);die;
        if (!$count) {
            return $this->redirect('/');
        }
        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $title_for_layout = Inflector::humanize($path[$count - 1]);
        }
        //debug($title_for_layout);die;
        $this->set(compact('page', 'subpage', 'title_for_layout'));
    }
	
	public function home() {

		$this->viewBuilder()->setLayout('home_page');
		
		//$frontStatistics = new CronjobController;
		//$frontStatistics->frontStatistics();

        // get returns count for statistics purpose
        $this->loadModel('ReturnsStatistics');
        $returnStats = $this->ReturnsStatistics->getReturnsCount();

        $f1_count = $returnStats['f1_returns_received'];
        $f2_count = $returnStats['f2_returns_received'];
        $f3_count = $returnStats['f3_returns_received'];
        $f4_count = $returnStats['f4_returns_received'];
        $f5_count = $returnStats['f5_returns_received'];
        $f7_count = $returnStats['f7_returns_received'];
        $f8_count = $returnStats['f8_returns_received'];

        // $f_returns_received_total = $returnStats['f_returns_received_t'];
        $f1_total_count = $f1_count + $f2_count + $f3_count + $f4_count + $f8_count;
        $f_returns_received_total = $f1_count + $f2_count + $f3_count + $f4_count + $f5_count + $f7_count + $f8_count;

		if($f1_total_count == 0){
			$f1_count_per = 0;
		}else{
			$f1_count_per = ($f1_total_count*100)/$f_returns_received_total;
		}
		
		if($f5_count == 0){
			$f2_count_per = 0;
		}else{
			$f2_count_per = ($f5_count*100)/$f_returns_received_total;
		}
		
		if($f7_count == 0){
			$f3_count_per = 0;
		}else{
			$f3_count_per = ($f7_count*100)/$f_returns_received_total;
		}
		
        
        
        

        $h1_count = $returnStats['h1_returns_received'];
        $h2_count = $returnStats['h2_returns_received'];
        $h3_count = $returnStats['h3_returns_received'];
        $h4_count = $returnStats['h4_returns_received'];
        $h5_count = $returnStats['h5_returns_received'];
        $h7_count = $returnStats['h7_returns_received'];
        $h8_count = $returnStats['h8_returns_received'];

        // $h_returns_received_total = $returnStats['h_returns_received_t'];
        $h1_total_count = $h1_count + $h2_count + $h3_count + $h4_count + $h8_count;
        $h_returns_received_total = $h1_count + $h2_count + $h3_count + $h4_count + $h5_count + $h7_count + $h8_count;
        
		if($h1_total_count == 0){
			$h1_count_per = 0;
		}else{
			$h1_count_per = ($h1_total_count*100)/$h_returns_received_total;
		}
        
		if($h5_count == 0){
			$h2_count_per = 0;
		}else{
			$h2_count_per = ($h5_count*100)/$h_returns_received_total;
		}
		
		if($h7_count == 0){
			$h3_count_per = 0;
		}else{
			$h3_count_per = ($h7_count*100)/$h_returns_received_total;
		}
		
        
        

        // // get shorten statistics count (like 1452 = 1k)
        // $f1_total_count = $this->Customfunctions->getShortStatsCount($f1_total_count);
        // $f5_count = $this->Customfunctions->getShortStatsCount($f5_count);
        // $f7_count = $this->Customfunctions->getShortStatsCount($f7_count);

        // // get shorten statistics count (like 1452541 = 1m)
        // $f_returns_received_total = $this->Customfunctions->getShortStatsCountM($f_returns_received_total);

        $this->set('f1_count',$f1_total_count);
        $this->set('f2_count',$f5_count);
        $this->set('f3_count',$f7_count);
        $this->set('f1_count_per',$f1_count_per);
        $this->set('f2_count_per',$f2_count_per);
        $this->set('f3_count_per',$f3_count_per);
        $this->set('f_returns_received_total',$f_returns_received_total);

        // // get shorten statistics count (like 1452 = 1k)
        // $h1_total_count = $this->Customfunctions->getShortStatsCount($h1_total_count);
        // $h5_count = $this->Customfunctions->getShortStatsCount($h5_count);
        // $h7_count = $this->Customfunctions->getShortStatsCount($h7_count);

        // // get shorten statistics count (like 1452541 = 1m)
        // $h_returns_received_total = $this->Customfunctions->getShortStatsCountM($h_returns_received_total);

        $this->set('h1_count',$h1_total_count);
        $this->set('h2_count',$h5_count);
        $this->set('h3_count',$h7_count);
        $this->set('h1_count_per',$h1_count_per);
        $this->set('h2_count_per',$h2_count_per);
        $this->set('h3_count_per',$h3_count_per);
        $this->set('h_returns_received_total',$h_returns_received_total);

        $L_count = $returnStats['l_returns_received_t'];
        // // get shorten statistics count (like 1452541 = 1m)
        // $L_count = $this->Customfunctions->getShortStatsCountM($L_count);
        $this->set('l_count_per',$L_count);

        $M_count = $returnStats['m_returns_received_t'];
        // // get shorten statistics count (like 1452541 = 1m)
        // $M_count = $this->Customfunctions->getShortStatsCountM($M_count);
        $this->set('m_count_per',$M_count);


		$issued = $returnStats['issued'];
		$suspended = $returnStats['suspended'];
		$junked = $returnStats['junked'];
		$totalreg = $returnStats['totalreg'];
		
		// $issued_count = $this->Customfunctions->getShortStatsCount($issued);
        // $suspended_count = $this->Customfunctions->getShortStatsCount($suspended);
        // $junked_count = $this->Customfunctions->getShortStatsCount($junked);
		// $totalreg_count = $this->Customfunctions->getShortStatsCount($totalreg);
		$issued_count = $issued;
        $suspended_count = $suspended;
        $junked_count = $junked;
		$totalreg_count = $totalreg;
		
		$this->set('issued',$issued_count);
		$this->set('suspended',$suspended_count);
		$this->set('junked',$junked_count);
		$this->set('totalreg',$totalreg_count);
		
	}


}
