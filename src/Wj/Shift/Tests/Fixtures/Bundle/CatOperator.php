<?php

namespace Wj\Shift\Tests\Fixtures\Bundle;

use Wj\Shift\Operator\OperatorInterface;

class CatOperator implements OperatorInterface
{
    public function onCatEvent()
    { }

    public static function getOperations()
    {
        return array(
            'cat_event' => 'onCatEvent',
        );
    }
}
