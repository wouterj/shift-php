<?php

namespace Wj\Shift\Tests\Fixtures\Bundle;

use Wj\Shift\Operator\OperatorInterface;

class SomeOperator implements OperatorInterface
{
    public function onSomeEvent()
    { }

    public static function getOperations()
    {
        return array(
            'some_event' => 'onSomeEvent',
        );
    }
}
