<?php

namespace Wj\Shift\Facade;

use Wj\Shift\EventDispatcher\EventDispatcherInterface;

/**
 * An Event facade.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
class Event
{
    /**
     * @var EventDispatcherInterface
     */
    private static $dispatcher;

    public static function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        self::$dispatcher = $dispatcher;
    }

    /**
     * @param string $event The name of the event
     *
     * @return AttachingEvent
     */
    public static function on($event)
    {
        return new AttachingEvent(self::$dispatcher, $event);
    }

    /**
     * @param string $event The name of the event
     *
     * @return TriggeringEvent
     */
    public static function trigger($event)
    {
        return new TriggeringEvent(self::$dispatcher, $event);
    }
}

/**
 * @internal
 */
class AttachingEvent
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    private $target;
    private $event;

    public function __construct(EventDispatcherInterface $dispatcher, $event)
    {
        $this->dispatcher = $dispatcher;
        $this->event = $event;
    }

    public function asA($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @see AttachingEvent::asA
     */
    public function asAn($target)
    {
        return $this->asA($target);
    }

    /**
     * @param callable $listener
     *
     * @throws \LogicException When there is no target set
     */
    public function call($listener)
    {
        if (null === $this->target) {
            throw new \LogicException('Missing event target, make sure you use Event::on(...)->asA(...)->do(...)');
        }

        $this->dispatcher->attach($this->event, $this->target, $listener);
    }
}

/**
 * @internal
 */
class TriggeringEvent
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    private $target;
    private $event;

    public function __construct(EventDispatcherInterface $dispatcher, $event)
    {
        $this->dispatcher = $dispatcher;
        $this->event = $event;
    }

    public function forA($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @see TriggeringEvent::forA
     */
    public function forAn($target)
    {
        return $this->forA($target);
    }

    public function with($event)
    {
        $this->dispatcher->trigger($this->event, $this->target, $event);
    }
}
