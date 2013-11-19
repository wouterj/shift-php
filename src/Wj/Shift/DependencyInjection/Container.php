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

use Wj\Shift\DependencyInjection\Exception;

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
        if (null === $constructor || 0 === count($params = $constructor->getParameters())) {
            return $reflection->newInstance();
        }

        return $reflection->newInstanceArgs($this->resolveArguments($params));
    }

    /**
     * @param \ReflectionParameter[] $parameters
     */
    protected function resolveArguments($parameters)
    {
        $arguments = array();

        foreach ($parameters as $parameter) {
            if ($parameter->isOptional()) {
                $arguments[] = $parameter->getDefaultValue();
            } elseif (null !== ($class = $parameter->getClass())) {
                $arguments[] = $this->get($class->getName());
            } elseif (array_key_exists($parameter->getName(), $this->parameters)) {
                $arguments[] = $this->parameters[$parameter->getName()];
            } else {
                throw new Exception\UnresolvableServiceException(
                    $parameter->getDeclaringClass(),
                    $parameter->getPosition(),
                    'No service or parameter found'
                );
            }
        }

        return $arguments;
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
        if (array_key_exists($id, $this->parameters)) {
            throw new \InvalidArgumentException(sprintf('Parameter with ID "%s" does already exists', $id));
        }

        $this->parameters[$id] = $value;
    }
}
