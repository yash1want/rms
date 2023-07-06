<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace TestApp\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\EventInterface;

/**
 * AppleComponent class
 *
 * @property OrangeComponent $Orange
 */
class AppleComponent extends Component
{
    /**
     * components property
     *
     * @var array
     */
    protected $components = ['Orange'];

    /**
     * startup method
     *
     * @param \Cake\Event\EventInterface $event
     * @return void
     */
    public function startup(EventInterface $event)
    {
    }
}
