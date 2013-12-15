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
 * Provides basic finding of the operators.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
class Bundle implements BundleInterface
{
    public function getOperators()
    {
        $reflection = new \ReflectionClass($this);
        $files = glob(dirname($reflection->getFileName()).'/*Operator.php');
        $operators = array();

        foreach ($files as $file) {
            if ($class = $this->getClassFromfile($file)) {
                $refClass = new \ReflectionClass($class);

                if ($refClass->implementsInterface('Wj\Shift\Operator\OperatorInterface')) {
                    $operators[] = $class;
                }
            }
        }

        return $operators;
    }

    protected function getClassFromFile($file)
    {
        $code = file_get_contents($file);
        $tokens = token_get_all($code);
        $namespace = '';
        $class = '';
        $ns_token = false;
        $class_token = false;

        foreach ($tokens as $token) {
            if (!is_array($token)) {
                continue;
            }

            if (\T_NAMESPACE === $token[0]) {
                $ns_token = true;
                $class_token = false;
                continue;
            } elseif (\T_CLASS === $token[0]) {
                $class_token = true;
                $ns_token = false;
                continue;
            }

            if ($ns_token) {
                if (\T_WHITESPACE === $token[0] || \T_NS_SEPARATOR === $token[0] || \T_STRING === $token[0]) {
                    $namespace .= $token[1];
                } else {
                    $ns_token = false;
                }
            }

            if ($class_token) {
                if (\T_WHITESPACE === $token[0] || \T_STRING === $token[0]) {
                    $class .= $token[1];
                } else {
                    $class_token = false;
                    break;
                }
            }
        }

        return $class == '' ? false : ltrim(trim($namespace).'\\'.trim($class), '\\');
    }
}
