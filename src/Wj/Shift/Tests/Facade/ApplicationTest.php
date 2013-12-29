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

use Wj\Shift\Tests\Fixtures;
use Wj\Shift\Facade\Event;
use Wj\Shift\Facade\Application;
use Wj\Shift\EventDispatcher\EventDispatcher;
use Wj\Shift\DependencyInjection\Container;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    protected $container;
    protected $dispatcher;

    public function testBooting()
    {
        Application::boot();

        $dispatcher = $this->readAttribute('Wj\Shift\Facade\Event', 'dispatcher');
        $this->assertInstanceOf('Wj\Shift\EventDispatcher\EventDispatcher', $dispatcher);

        $this->assertInstanceOf('Wj\Shift\DependencyInjection\Container', $this->readAttribute($dispatcher, 'container'));
    }

    public function testRegisteringBundle()
    {
        $this->dispatcher = $d = new EventDispatcher();
        $d->setContainer($this->container = new Container());
        Event::setDispatcher($d);

        Application::registerBundle(new Fixtures\Bundle\TheBundle());

        $this->assertTrue($this->dispatcher->getListeners('operation')->has('cat_event'));
        $this->assertTrue($this->dispatcher->getListeners('operation')->has('some_event'));
    }
}
