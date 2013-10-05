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

use Symfony\Component\EventDispatcher\EventDispatcher;

class Application
{
    public static function boot()
    {
        $dispatcher = new EventDispatcher();
        Event::setDispatcher($dispatcher);
    }
}
