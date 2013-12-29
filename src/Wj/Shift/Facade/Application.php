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

use Wj\Shift\Bundle\BundleInterface;
use Wj\Shift\DependencyInjection\Container;
use Wj\Shift\EventDispatcher\EventDispatcher;
use Doctrine\Common\Annotations\AnnotationRegistry;

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

        AnnotationRegistry::registerAutoloadNamespace('Wj\Shift\DependencyInjection\Annotations', __DIR__.'/../../..');
    }

    public static function registerBundle(BundleInterface $bundle)
    {
        foreach ($bundle->getOperators() as $operator) {
            Operation::add($operator);
        }
    }
}
