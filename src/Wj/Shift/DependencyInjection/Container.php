<?php

/*
 * This file is part of the ShiftPHP package.
 *
 * (c) 2013 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Wj\Shift\DependencyInjection;

class Container implements ContainerInterface
{
    private $parameters = array();
    private $shared = array();

    /**
     * {@inheritDoc}
     */
    public function get($class)
    {
        $reflection = new \ReflectionClass($class);

        $constructor = $reflection->getConstructor();
        if (null === $constructor || 0 === count($constructor->getParameters())) {
            return $reflection->newInstance();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function has($class)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function setParameter($id, $value)
    {
    }
}
