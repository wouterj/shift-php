<?php

namespace Wj\Shift\Facade;

/**
 * A Model facade.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
class Model
{
    /**
     * Registers operation on an event.
     *
     * @param string $event
     */
    public static function on($event)
    {
        return Event::on($event)->asA('model');
    }
}
