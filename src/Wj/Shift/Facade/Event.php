<?php

namespace Wj\Shift\Facade;

use Wj\Shift\EventDispatcher\EventDispatcherInterface;

class Event
{
    private static $dispatcher;

    public static function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        self::$dispatcher = $dispatcher;
    }
}
