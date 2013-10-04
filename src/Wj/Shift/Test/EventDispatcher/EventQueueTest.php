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

        $this->assertInstanceOf('Closure', $queue->get('event_name'));
        $this->assertInstanceOf('Closure', $queue->get('another_event_name'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFailsIfNotExists()
    {
        $queue = new EventQueue();

        $queue->get('event_name');
    }
}
