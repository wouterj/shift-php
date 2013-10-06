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

    /**
     * Adds an Operator.
     *
     * @param object $operator The operator instance
     */
    public static function add($operator)
    {
        if (!method_exists($operator, 'registerOperations')) {
            $name = explode('\\', get_class($operator));
            $name = end($name);

            throw new \BadMethodCallException(
                sprintf(
                    'Operator "%s" does not have the required method "registerOperations"',
                    $name
                )
            );
        }

        $operator->registerOperations();
    }
}
