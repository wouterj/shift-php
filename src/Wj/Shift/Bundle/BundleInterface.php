<?php

/*
 * This file is part of the ShiftPHP package.
 *
 * (c) 2013 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Wj\Shift\Bundle;

/**
 * A bundle is a way to register multiple operators at once.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
interface BundleInterface
{
    /**
     * Returns all operator classes.
     *
     * @return array The class names
     */
    public function getOperators();
}
