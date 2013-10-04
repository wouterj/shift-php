<?php

namespace Wj\Shift\EventDispatcher;

class EventQueue implements \Countable, \IteratorAggregate
{
    private $listeners = array();
    private $sortedListeners = array();

    public function add($event, $listener, $priority = 0)
    {
        $this->listeners[$event][$priority][] = $listener;
        unset($this->sortedListeners[$event]);
    }

    public function has($event)
    {
        return isset($this->listeners[$event]);
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

        try {
            $this->sortListeners($event);
        } catch (\RuntimeException $e) {
            // don't do anything
        }

        return $this->sortedListeners[$event];
    }

    public function count()
    {
        return count($this->listeners);
    }

    public function getIterator()
    {
        foreach ($this->listeners as $name => $listeners) {
            $this->sortListeners($name);
        }

        return new \ArrayIterator($this->sortedListeners);
    }

    private function sortListeners($event)
    {
        if (isset($this->sortedListeners[$event])) {
            throw new \RuntimeException('Listeners for "%s" are already sorted', $event);
        }

        $listeners = $this->listeners[$event];
        krsort($listeners);
        $this->sortedListeners[$event] = call_user_func_array('array_merge', $listeners);
    }
}
