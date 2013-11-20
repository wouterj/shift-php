<?php

namespace Wj\Shift\Tests\Fixtures\Operator;

use Wj\Shift\Operator\OperatorInterface;

class SingleEventOperator implements OperatorInterface
{
    public function onEventName()
    { }

    public static function getOperations()
    {
        return array(
            'event_name' => 'onEventName',
        );
    }
}
