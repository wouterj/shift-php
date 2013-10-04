<?php

namespace Wj\Shift\EventDispatcher;

class EventDispatcher implements EventDispatcherInterface
{
    private $listeners = array();

    public function trigger($eventName, $target, $event = null)
    {
        if (isset($this->listeners[$target]) && $this->listeners[$target]->has($eventName)) {
            $listeners = $this->listeners[$target]->get($eventName);

            foreach ($listeners as $listener) {
                call_user_func($listener, $event);
            }
        }
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
            $this->listeners[$target] = new EventQueue();
        }

        $this->listeners[$target]->add($eventName, $listener);
    }

    public function getListeners($target = null)
    {
        if ($target !== null) {
            return $this->listeners[$target];
        }

        return $this->listeners;
    }
}
