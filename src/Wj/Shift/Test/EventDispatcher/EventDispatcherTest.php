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
}

class DummyListener
{
    public function onFoo() { }
}
