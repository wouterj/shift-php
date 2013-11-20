<?php

namespace Wj\Shift\Tests\Fixtures\DependencyInjection;

class WithParameter
{
    private $a;

    public function __construct($a)
    {
        $this->a = $a;
    }

    public function getPassedValue()
    {
        return $this->a;
    }
}
