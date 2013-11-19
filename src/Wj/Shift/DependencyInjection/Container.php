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
