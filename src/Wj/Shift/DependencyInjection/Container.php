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

use Wj\Shift\DependencyInjection\Annotations\Inject as InjectAnnotation;
use Wj\Shift\DependencyInjection\Exception;
use Doctrine\Common\Annotations\AnnotationReader;

class Container implements ContainerInterface
{
    private $parameters = array();
    private $shared = array();
    private $annotationReader;

    public function __construct()
    {
        $this->annotationReader = new AnnotationReader();
    }

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
    public function resolveArguments($parameters)
    {
        $arguments = array();

        foreach ($parameters as $key => $parameter) {
            if ($parameter->isOptional()) {
                $arguments[$key] = $parameter->getDefaultValue();
            } elseif (null !== ($class = $parameter->getClass())) {
                $arguments[$key] = $this->get($class->getName());
            } elseif (array_key_exists($parameter->getName(), $this->parameters)) {
                $arguments[$key] = $this->parameters[$parameter->getName()];
            } else {
                $annotations = $this->annotationReader->getMethodAnnotations($parameter->getDeclaringFunction());
                $found = false;
                foreach ($annotations as $annotation) {
                    if ($annotation instanceof InjectAnnotation) {
                        foreach ($annotation->getParameters() as $name => $param) {
                            if ($name === $parameter->getName()) {
                                $arguments[$key] = $param;
                                $found = true;
                            }
                        }
                    }
                }

                if (!$found) {
                    throw new Exception\UnresolvableServiceException(
                        $parameter->getDeclaringClass()->getName(),
                        $parameter->getName(),
                        'No service or parameter found'
                    );
                }
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
