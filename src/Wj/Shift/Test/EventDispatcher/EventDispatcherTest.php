<?php

namespace Wj\Shift\Test\EventDispatcher;

use Wj\Shift\EventDispatcher\EventDispatcher;

class EventDispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getRegisterValidCallableData
     */
    public function testRegisterValidCallable($callable)
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->attach('foo', 'operation', $callable);

        $this->assertArrayHasKey('foo', $dispatcher->getListeners('operation'));
        $this->assertCount(1, $dispatcher->getListeners('operation'));
    }

    public function getRegisterValidCallableData()
    {
        $obj = new \StdClass();

        $data = array(
            function () { },
            array($obj, 'foo'),
        );

        return array_map(function ($i) { return array($i); }, $data);
    }
}
