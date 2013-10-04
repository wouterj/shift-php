<?php

namespace Wj\Shift\EventDispatcher;

class EventQueue implements \Countable, \IteratorAggregate
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

    public function count()
    {
        return count($this->listeners);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->listeners);
    }
}
