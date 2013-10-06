<?php

/*
 * This file is part of the ShiftPHP package.
 *
 * (c) 2013 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Wj\Shift\Test\Facade;

use Wj\Shift\Facade\Event;
use Wj\Shift\Facade\Application;
use Wj\Shift\EventDispatcher\EventDispatcher;

use Wj\Shift\Tests\Fixtures;

require_once __DIR__.'/../Fixtures/operators/operator-valid.php';
require_once __DIR__.'/../Fixtures/operators/operator-invalid.php';

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    protected $dispatcher;

    public function setUp()
    {
        $this->dispatcher = $d = new EventDispatcher();
        Event::setDispatcher($d);
    }

    public function testRegisteringOperators()
    {
        Application::add(new Fixtures\ValidOperator());

        $event = new Fixtures\DummyEvent();
        $this->dispatcher->trigger('event_name', 'operation', $event);

        if (!$event) {
            $this->fail('Failed asserting Application::add registers operators');
        }
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testRegistingInvalidOperators()
    {
        Application::add(new Fixtures\InvalidOperator());
    }
}
