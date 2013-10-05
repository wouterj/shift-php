<?php

namespace Wj\Shift\Tests\Fixtures;

use Wj\Shift\Facade\Operation;

class FooOperator
{
    public function registerOperations()
    {
        Operation::on('event_name')->call(function (DummyEvent $event) {
            $event->called = true;
        });
    }
}

class DummyEvent
{
    public $called = false;
}
