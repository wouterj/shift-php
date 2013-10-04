<?php

namespace Wj\Shift\EventDispatcher;

class EventQueue
{
    private $listeners = array();

    public function add($event, $listener)
    {
        $this->listeners[$event] = $listener;
    }

    public function get($event)
    {
        if (!isset($this->listeners[$event])) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Event "%s" does not have any listeners',
                    $event
                )
            );
        }

        return $this->listeners[$event];
    }
}
