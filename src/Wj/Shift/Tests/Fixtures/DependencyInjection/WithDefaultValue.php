<?php

namespace Wj\Shift\Tests\Fixtures\DependencyInjection;

class WithDefaultValue
{
    public function __construct($a = 'foo')
    {
    }
}
