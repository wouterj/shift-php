<?php

namespace Wj\Shift\Tests\Fixtures\Operator;

use Wj\Shift\Operator\OperatorInterface;
use Wj\Shift\Tests\Fixtures\DependencyInjection\WithoutInjections;

class OperatorWithArguments implements OperatorInterface
{
    public function onEventName($event, WithoutInjections $object)
    {
        $event->called = true;
    }

    public static function getOperations()
    {
        return array(
            'event_name' => 'onEventName',
        );
    }
}
