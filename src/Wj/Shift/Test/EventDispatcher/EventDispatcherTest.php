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

        $this->assertArrayHasKey('foo', $this->dispatcher->getListeners('operation'));
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
}

class DummyListener
{
    public function onFoo() { }
}
