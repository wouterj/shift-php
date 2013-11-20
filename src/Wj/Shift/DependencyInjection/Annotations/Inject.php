<?php

/*
 * This file is part of the ShiftPHP package.
 *
 * (c) 2013 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Wj\Shift\DependencyInjection\Annotations;

/**
 * Configure the name of the service/parameter to inject.
 *
 * @Annotation
 */
class Inject
{
    private $parameters;

    public function __construct(array $data)
    {
        $this->parameters = $data['value'];
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}
