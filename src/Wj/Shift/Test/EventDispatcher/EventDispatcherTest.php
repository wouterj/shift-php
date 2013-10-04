<?php

namespace Wj\Shift\Test\EventDispatcher;

use Wj\Shift\EventDispatcher\EventDispatcher;

class EventDispatcherTest extends \PHPUnit_Framework_TestCase
{
    protected $dispatcher;

    public function setUp()
    {
        $this->dispatcher = new EventDispatcher();
    }

    /**
     * @dataProvider getRegisterValidCallableData
     */
    public function testRegisterValidCallable($callable)
    {
        $this->dispatcher->attach('foo', 'operation', $callable);

        $this->assertTrue($this->dispatcher->getListeners('operation')->has('foo'));
        $this->assertCount(1, $this->dispatcher->getListeners('operation'));
    }

    public function getRegisterValidCallableData()
    {
        $obj = new DummyListener();

        $data = array(
            function () { },
            array($obj, 'onFoo'),
        );

        return array_map(function ($i) { return array($i); }, $data);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFailsWithNonCallableListener()
    {
        $this->dispatcher->attach('foo', 'operation', 'invalid');
    }

    public function testTriggersEvents()
    {
        $triggered = false;

        $this->dispatcher->attach('foo', 'operation', function () use (&$triggered) {
            $triggered = true;
        });

        $this->dispatcher->trigger('foo', 'operation');

        if (!$triggered) {
            $this->fail('Failed asserting listeners are called when event is triggered');
        }
    }

    public function testTwoListenersOnSameEvent()
    {
        $triggered = array(false, false);

        $this->dispatcher->attach('foo', 'operation', function () use (&$triggered) {
            $triggered[0] = true;
        });

        $this->dispatcher->attach('foo', 'operation', function () use (&$triggered) {
            $triggered[1] = true;
        });

        $this->dispatcher->trigger('foo', 'operation');

        if (!$triggered[0]) {
            if (!$triggered[1]) {
                $this->fail('Failed asserting listeners are called when event is triggered');
            }
            $this->fail('Failed asserting both listeners are called when event is triggered');
        }
    }

    public function testDoesNotCallListenersOfOtherTargets()
    {
        $fail = false;

        $this->dispatcher->attach('foo', 'operation', function () { });
        $this->dispatcher->attach('foo', 'model', function () use (&$fail) {
            $fail = true;
        });

        $this->dispatcher->trigger('foo', 'operation');

        if ($fail) {
            $this->fail('Failed asserting only operation listeners are dispatched');
        }
    }

    public function testEventClasses()
    {
        $event = new DummyEvent();

        $this->dispatcher->attach('foo', 'operation', function (DummyEvent $e) {
            $e->fail = false;
        });

        $this->dispatcher->trigger('foo', 'operation', $event);

        if ($event->fail) {
            $this->fail('Failed asserting event gets passed to listener');
        }
    }
}

class DummyListener
{
    public function onFoo() { }
}

class DummyEvent
{
    public $fail = true;
}
