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

        $this->assertContainsOnly('Closure', $queue->get('event_name'));
        $this->assertContainsOnly('Closure', $queue->get('another_event_name'));
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
            $this->assertContainsOnly('Closure', $event);
        }

        if (current($names) !== end($names)) {
            $this->fail('Failed iterating over the queue');
        }
    }

    public function testSortingOnPriority()
    {
        $obj = $this->getMock('Listener');
        $obj->expects($this->any())
            ->method('onFoo')
            ->with();

        $queue = new EventQueue();
        $queue->add('event_name', function () { }, 100);
        $queue->add('event_name', array($obj, 'onFoo'), 200);

        $types = array('', 'array', 'object');
        foreach ($queue as $name => $event) {
            $this->assertInternalType(next($types), $event);
        }
    }
}
