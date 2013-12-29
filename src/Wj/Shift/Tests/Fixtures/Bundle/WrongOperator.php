<?php

namespace Wj\Shift\Tests\Fixtures\Bundle;

class WrongOperator
{
    public function onWrongEvent()
    { }

    public static function getOperations()
    {
        return array(
            'wrong_event' => 'onWrongEvent',
        );
    }
}
