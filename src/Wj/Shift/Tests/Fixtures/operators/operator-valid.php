<?php

namespace Wj\Shift\Tests\Fixtures;

use Wj\Shift\Facade\Operation;
use Wj\Shift\Operator\OperatorInterface;

class ValidOperator implements OperatorInterface
{
    public function loadAll()
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
