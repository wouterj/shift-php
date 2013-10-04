<?php

namespace Wj\Shift\Facade;

use Wj\Shift\EventDispatcher\EventDispatcherInterface;

class Event
{
    private static $dispatcher;

    public static function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        self::$dispatcher = $dispatcher;
    }

    public static function on($event)
    {
        return new AttachingEvent(self::$dispatcher, $event);
    }

    public static function trigger($event)
    {
        return new TriggeringEvent(self::$dispatcher, $event);
    }
}

class AttachingEvent
{
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

    public function asAn($target)
    {
        return $this->asA($target);
    }

    public function call($listener)
    {
        if (null === $this->target) {
            throw new \LogicException('Missing event target, make sure you use Event::on(...)->asA(...)->do(...)');
        }

        $this->dispatcher->attach($this->event, $this->target, $listener);
    }
}

class TriggeringEvent
{
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

    public function forAn($target)
    {
        return $this->forA($target);
    }

    public function with($event)
    {
        $this->dispatcher->trigger($this->event, $this->target, $event);
    }
}
