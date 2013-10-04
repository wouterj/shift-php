<?php

namespace Wj\Shift\Test\EventDispatcher;

use Wj\Shift\EventDispatcher\EventQueue;

class EventQueueTest extends \PHPUnit_Framework_TestCase
{
    public function testAddAndGetEvents()
    {
        $queue = new EventQueue();

        $queue->add('event_name', function () { });
        $queue->add('another_event_name', function () { });

        $this->assertInternalType('function', $queue->get('event_name'));
        $this->assertInternalType('function', $queue->get('another_event_name'));
    }
}
