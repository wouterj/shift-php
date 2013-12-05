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

use Wj\Shift\DependencyInjection\ContainerInterface;

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
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function trigger($eventName, $target, $event = null)
    {
        try {
            if (isset($this->listeners[$target]) && $this->listeners[$target]->has($eventName)) {
                $listeners = $this->listeners[$target]->get($eventName);

                $isContainerAvailable = false !== $this->getContainer();
                foreach ($listeners as $listener) {
                    // make new instance if instance is not yet available
                    if ($isContainerAvailable && is_array($listener) && is_string($listener[0]) && class_exists($listener[0])) {
                        $listener[0] = $this->getContainer()->get($listener[0]);
                    }

                    $arguments = $this->resolveArguments($listener, $event);

                    call_user_func_array($listener, $arguments);
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

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Resolves the listener arguments.
     *
     * @param callable    $listener
     * @param null|object $event    The event object
     */
    protected function resolveArguments($listener, $event)
    {
        if (is_array($listener)) {
            // object
            $ref = new \ReflectionClass($listener[0]);
            $parameters = $ref->getMethod($listener[1])->getParameters();
        } else {
            // method/function/closure
            $ref = new \ReflectionFunction($listener);
            $parameters = $ref->getParameters();
        }

        $eventIndex = false;
        foreach ($parameters as $index => $argument) {
            if (in_array($argument->getName(), array('event', 'e'))) {
                $eventIndex = $index;
                unset($parameters[$index]);
                break;
            }
        }

        if ($container = $this->getContainer()) {
            $resolvedArguments = $container->resolveArguments($parameters);
        } else {
            if (count($parameters) > 0) {
                throw new \RuntimeException(sprintf(
                    'Cannot resolve arguments for listener "%s", did you forgot to set the container for the dispatcher?',
                    $listener
                ));
            }
            $resolvedArguments = array();
        }

        if (false !== $eventIndex) {
            $resolvedArguments[$eventIndex] = $event;
            ksort($resolvedArguments);
        }

        return $resolvedArguments;
    }

    protected function getContainer()
    {
        return null === $this->container ? false : $this->container;
    }
}
