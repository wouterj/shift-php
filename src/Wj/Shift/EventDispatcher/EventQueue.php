<?php

/*
 * This file is part of the ShiftPHP package.
 *
 * (c) 2013 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Wj\Shift\EventDispatcher;

/**
 * A Queue, which holds, searches and sorts events.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
class EventQueue implements \Countable, \IteratorAggregate
{
    private $listeners = array();
    private $sortedListeners = array();

    /**
     * @param string   $event
     * @param callable $listener
     * @param integer  $priority Higher number means earlier
     */
    public function add($event, $listener, $priority = 0)
    {
        $this->listeners[$event][$priority][] = $listener;
        unset($this->sortedListeners[$event]);
    }

    /**
     * @param string $event
     *
     * @return boolean
     */
    public function has($event)
    {
        return isset($this->listeners[$event]);
    }

    /**
     * @param string $event
     *
     * @return array
     *
     * @throws \InvalidArgumentException When the event does not have 
     *     listeners
     */
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
            // do nothing
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

    /**
     * @param string $event
     *
     * @throws \RuntimeException When listeners are already sorted for this 
     *     event
     */
    private function sortListeners($event)
    {
        if (isset($this->sortedListeners[$event])) {
            throw new \RuntimeException(sprintf('Listeners for "%s" are already sorted', $event));
        }

        $listeners = $this->listeners[$event];
        krsort($listeners);
        $this->sortedListeners[$event] = call_user_func_array('array_merge', $listeners);
    }
}
