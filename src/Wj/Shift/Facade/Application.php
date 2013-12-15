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

use Wj\Shift\Operator\OperatorInterface;
use Wj\Shift\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Application
{
    /**
     * Boots the application.
     */
    public static function boot()
    {
        $container = new Container();
        $dispatcher = new EventDispatcher();

        $dispatcher->setContainer($container);

        Event::setDispatcher($dispatcher);
    }

    /**
     * Adds an Operator.
     *
     * @param object $operator The operator instance
     */
    public static function add($operator)
    {
        if (!$operator instanceof OperatorInterface) {
            $name = explode('\\', get_class($operator));
            $name = end($name);

            throw new \BadMethodCallException(
                sprintf(
                    'Operator "%s" does not have the required method "registerOperations"',
                    $name
                )
            );
        }

        $operator->loadAll();
    }
}
