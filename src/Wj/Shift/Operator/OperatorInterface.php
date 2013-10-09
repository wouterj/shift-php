<?php

/*
 * This file is part of the ShiftPHP package.
 *
 * (c) 2013 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Wj\Shift\Operator;

/**
 * An Operator provides operations, models and views to implement a specific 
 * feature.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
interface OperatorInterface
{
    /**
     * Loads all operations, models and views.
     */
    public function loadAll();
}
