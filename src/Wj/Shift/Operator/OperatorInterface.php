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
 * An Operator bundles multiple Operations inside a class.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
interface OperatorInterface
{
    /**
     * Register the events to attach operations in this operator.
     *
     * @return array The key is the event and the value is/are the method(s)
     */
    public static function getOperations();
}
