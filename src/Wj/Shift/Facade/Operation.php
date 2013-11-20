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

/**
 * An Operation facade.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
class Operation
{
    /**
     * Registers operation on an event.
     *
     * @param string $event
     */
    public static function on($event)
    {
        return Event::on($event)->asAn('operation');
    }

    /**
     * Registers an Operator.
     *
     * @param string $operator The FQCN of the operator
     */
    public static function add($operator)
    {
        $ref = new \ReflectionClass($operator);
        if (!$ref->implementsInterface('Wj\Shift\Operator\OperatorInterface')) {
            throw new \InvalidArgumentException(sprintf('Operation::add can only register operators implementing "Wj\Shift\Operator\OperatorInterface" for "%s"', $ref->getName()));
        }

        foreach ($operator::getOperations() as $event => $operation) {
            if (is_array($operation) && !is_callable($operation)) {
                foreach ($operation as $singleOperation) {
                    Event::on($event)->asAn('operation')->call(array($operator, $singleOperation));
                }
                continue;
            }

            Event::on($event)->asAn('operation')->call(array($operator, $operation));
        }
    }
}
