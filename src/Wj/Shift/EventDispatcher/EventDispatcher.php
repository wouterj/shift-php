<?php

namespace Wj\Shift\EventDispatcher;

class EventDispatcher implements EventDispatcherInterface
{
    private $listeners;

    public function trigger($eventName, $target, $event = null)
    {
    }

    public function attach($eventName, $target, $listener)
    {
        if (!is_callable($listener)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Listeners can only be callables, tried to attach type of "%s" to "%s" with target "%s"',
                    gettype($listener),
                    $eventName,
                    $target
                )
            );
        }

        if (!isset($this->listeners[$target])) {
            $this->listeners[$target] = array();
        }

        $this->listeners[$target][$eventName] = $listener;
    }

    public function getListeners($target = null)
    {
        if ($target !== null) {
            return $this->listeners[$target];
        }

        return $this->listeners;
    }
}
