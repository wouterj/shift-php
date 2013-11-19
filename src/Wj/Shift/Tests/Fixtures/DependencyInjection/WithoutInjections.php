<?php

namespace Wj\Shift\Tests\Fixtures\DependencyInjection;

class WithoutInjections
{
    private $init = false;

    public function __construct()
    {
        $this->init = true;
    }

    public function isInitialized()
    {
        return $this->init;
    }
}
