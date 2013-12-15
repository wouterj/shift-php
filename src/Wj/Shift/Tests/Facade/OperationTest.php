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

use Wj\Shift\Test\EventFacadeTestCase;
use Wj\Shift\Facade\Event;
use Wj\Shift\Facade\Operation;
use Wj\Shift\EventDispatcher\EventDispatcher;
use Wj\Shift\Tests\Fixtures;

class OperationTest extends EventFacadeTestCase
{
    protected $className = 'Wj\Shift\Facade\Operation';
    protected $target = 'operation';

    public function testRegistersClassMethods()
    {
        $class = 'Wj\Shift\Tests\Fixtures\Operator\SingleEventOperator';
        Operation::add($class);

        $this->assertTrue($this->dispatcher->getListeners('operation')->has('event_name'));
    }

    public function testRegistersMultipleClassMethods()
    {
        $class = 'Wj\Shift\Tests\Fixtures\Operator\MultipleEventOperator';
        Operation::add($class);

        $listeners = $this->dispatcher->getListeners('operation');
        $this->assertTrue($listeners->has('event_name'));
        $this->assertCount(2, $listeners->get('event_name'));
    }

    public function testUsingOperatorArguments()
    {
        $class = 'Wj\Shift\Tests\Fixtures\Operator\OperatorWithArguments';
        Operation::add($class);

        $event = new CalledEvent();
        $this->dispatcher->trigger('event_name', 'operation', $event);

        $this->assertTrue($event->called, 'dependency injection with events works');
    }
}

class CalledEvent
{
    public $called = false;
}
