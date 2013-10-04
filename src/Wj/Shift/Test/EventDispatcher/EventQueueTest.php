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

    public function testCount()
    {
        $queue = new EventQueue();
        $queue->add('event_name', function () { });
        $queue->add('another_event_name', function () { });

        $this->assertCount(2, $queue);
    }

    public function testIteration()
    {
        $queue = new EventQueue();
        $queue->add('event_name', function () { });
        $queue->add('another_event_name', function () { });

        $names = array('', 'event_name', 'another_event_name');
        foreach ($queue as $name => $event) {
            $this->assertEquals(next($names), $name);
            $this->assertInstanceOf('Closure', $event);
        }

        if (current($names) !== end($names)) {
            $this->fail('Failed iterating over the queue');
        }
    }

    public function testSortingOnPriority()
    {
        $queue = new EventQueue();
        $queue->add('event_name', function () { }, 100);
        $queue->add('event_name', function () { }, 200);

        $names = array('', 'another_event_name', 'event_name');
        foreach ($queue as $name => $event) {
            $this->assertEquals(next($names), $name);
            $this->assertInstanceOf('Closure', $event);
        }

        if (current($names) !== end($names)) {
            $this->fail('Failed iterating over the queue');
        }
    }
}
