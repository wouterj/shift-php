<?php

/*
 * This file is part of the ShiftPHP package.
 *
 * (c) 2013 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


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
