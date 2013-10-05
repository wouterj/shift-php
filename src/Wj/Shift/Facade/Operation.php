<?php

namespace Wj\Shift\Facade;

/**
 * An Operation facade.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
class Operation
{
    /**
     * Registers operation on an event.
     *
     * @param string $event
     */
    public static function on($event)
    {
        return Event::on($event)->asAn('operation');
    }
}
