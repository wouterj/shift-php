<?php

namespace Wj\Shift;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Application
{
    public static function boot()
    {
        $dispatcher = new EventDispatcher();
        Event::setDispatcher($dispatcher);
    }
}
