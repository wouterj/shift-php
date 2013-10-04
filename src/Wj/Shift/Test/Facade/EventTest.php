<?php

namespace Wj\Shift\Test\Facade;

use Wj\Shift\Facade\Event;
use Wj\Shift\EventDispatcher\EventDispatcher;

class EventTest extends \PHPUnit_Framework_TestCase
{
    public function testAttaching()
    {
        $dispatcher = new EventDispatcher();
        Event::setDispatcher($dispatcher);

        $called = false;
        Event::on('event_name')->asAn('operation')->call(function () use (&$called) {
            $called = true;
        });

        $dispatcher->trigger('event_name', 'operation');

        if (!$called) {
            $this->fail('Failed asserting Event::on() attaches an event');
        }
    }
}
