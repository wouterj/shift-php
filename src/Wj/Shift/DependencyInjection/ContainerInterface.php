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

interface ContainerInterface
{
    /**
     * Gets a shared or new instance of the class.
     *
     * @param string $class The FQCN
     *
     * @return object
     *
     * @throws \InvalidArgumentException When the class cannot be handled by 
     *     the container
     */
    public function get($class);

    /**
     * Sets a service parameter.
     * 
     * @param string $id The name of the parameter
     * @param mixed  $value
     *
     * @throws \InvalidArgumentException When the parameter does already exists
     */
    public function setParameter($id, $value);

    /**
     * Checks if the class already exists or if the class can be initialized.
     *
     * @param string $class The FQCN
     *
     * @return boolean
     */
    public function has($class);
}
