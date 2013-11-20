<?php

namespace Wj\Shift\Tests\Fixtures\DependencyInjection;

class WithServiceInjection
{
    public function __construct(WithoutInjections $obj)
    {
    }
}
