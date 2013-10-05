<?php

namespace Wj\Shift\Test\Facade;

use Wj\Shift\Facade\Event;
use Wj\Shift\Facade\Operation;
use Wj\Shift\EventDispatcher\EventDispatcher;

class OperationTest extends \PHPUnit_Framework_TestCase
{
    protected $dispatcher;

    public function setUp()
    {
        $this->dispatcher = $d = new EventDispatcher();
        Event::setDispatcher($d);
    }

    public function testRegistering()
    {
        $called = false;
        Operation::on('event_name')->call(function () use (&$called) {
            $called = true;
        });

        Event::trigger('event_name')->forAn('operation')->with(null);

        if (!$called) {
            $this->fail('Failed asserting Operation::on registers operations');
        }
    }
}
