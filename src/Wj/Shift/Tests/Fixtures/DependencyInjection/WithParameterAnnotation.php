<?php

namespace Wj\Shift\Tests\Fixtures\DependencyInjection;

use Wj\Shift\DependencyInjection\Annotations as DI;

class WithParameterAnnotation
{
    private $a;

    /**
     * @DI\Inject({
     *     "a": "foo"
     * })
     */
    public function __construct($a)
    {
    }
}
