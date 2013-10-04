<?php

namespace Wj\Shift\EventDispatcher;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
interface EventDispatcherInterface
{
    /**
     * Triggers an event.
     *
     * @param string $eventName
     * @param string $target    The target, a class name, etc.
     * @param obj    $event     Optional. The event class
     */
    public function trigger($eventName, $target, $event = null);

    /**
     * Attaches a listener to an event.
     *
     * @param string  $eventName
     * @param string  $target    The target, a class name, etc.
     * @param calable $callback  The listener
     */
    public function attach($eventName, $target, $callback);

    /**
     * @param string $target Optional. The target, if ommitted all listeners 
     *     are returned, otherwise only those for the current target are.
     *
     * @return EventQueue
     */
    public function getListeners($target = null);
}
