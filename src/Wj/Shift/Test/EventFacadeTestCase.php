<?php

/*
 * This file is part of the ShiftPHP package.
 *
 * (c) 2013 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Wj\Shift\Test;

use Wj\Shift\Facade\Event;
use Wj\Shift\DependencyInjection\Container;
use Wj\Shift\EventDispatcher\EventDispatcher;

class EventFacadeTestCase extends \PHPUnit_Framework_TestCase
{
    protected $container;
    protected $dispatcher;

    public function setUp()
    {
        $this->dispatcher = $d = new EventDispatcher();
        $d->setContainer($this->container = new Container());
        Event::setDispatcher($d);
    }

    public function testAttaching()
    {
        $called = false;
        $facade = $this->className;
        $facade::on('event_name')->call(function () use (&$called) {
            $called = true;
        });

        Event::trigger('event_name')->forA($this->target)->with(null);

        if (!$called) {
            $this->fail('Failed asserting '.$facade.'::on registers '.strtolower($facade).'s');
        }
    }
}
