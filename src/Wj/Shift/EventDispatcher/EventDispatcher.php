<?php

namespace Wj\Shift\EventDispatcher;

class EventDispatcher implements EventDispatcherInterface
{
    private $listeners;

    public function trigger($eventName, $target, $event)
    {
    }

    public function attach($eventName, $target, $event)
    {
        if (!isset($this->listeners[$target])) {
            $this->listeners[$target] = array();
        }

        $this->listeners[$target][$eventName] = $event;
    }

    public function getListeners($target = null)
    {
        if ($target !== null) {
            return $this->listeners[$target];
        }

        return $this->listeners;
    }
}
