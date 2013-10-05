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
 * Handles event attaching and triggering.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var EventQueue[]
     */
    private $listeners = array();

    /**
     * {@inheritDoc}
     */
    public function trigger($eventName, $target, $event = null)
    {
        try {
            if (isset($this->listeners[$target]) && $this->listeners[$target]->has($eventName)) {
                $listeners = $this->listeners[$target]->get($eventName);

                foreach ($listeners as $listener) {
                    call_user_func($listener, $event);
                }
            }
        } catch (\InvalidArgumentException $e) {
            // do nothing
        }
    }

    /**
     * {@inheritDoc}
     */
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

    /**
     * {@inheritDoc}
     */
    public function getListeners($target = null)
    {
        if ($target !== null) {
            return $this->listeners[$target];
        }

        return $this->listeners;
    }
}
