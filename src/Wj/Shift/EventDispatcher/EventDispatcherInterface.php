<?php

namespace Wj\Shift\EventDispatcher;

interface EventDispatcher
{
    public function trigger($eventName, $target, $event);
    public function attach($eventName, $target, $callback);
}
