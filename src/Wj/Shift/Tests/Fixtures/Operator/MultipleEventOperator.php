<?php

namespace Wj\Shift\Tests\Fixtures\Operator;

use Wj\Shift\Operator\OperatorInterface;

class MultipleEventOperator implements OperatorInterface
{
    public function onEventName()
    { }
    public function onEventNameTwo()
    { }

    public static function getOperations()
    {
        return array(
            'event_name' => array('onEventName', 'onEventNameTwo'),
        );
    }
}
