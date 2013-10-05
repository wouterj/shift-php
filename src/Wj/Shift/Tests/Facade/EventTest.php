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

    public function testTriggeringEvent()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->attach('event_name', 'operation', function ($e) {
            $e->fail = false;
        });
        Event::setDispatcher($dispatcher);

        $event = new DummyEvent();
        Event::trigger('event_name')->forAn('operation')->with($event);

        if ($event->fail) {
            $this->fail('Failed asserting Event::trigger() triggers an event');
        }
    }
}

class DummyEvent
{
    public $fail = true;
}
