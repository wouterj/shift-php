<?php

/*
 * This file is part of the ShiftPHP package.
 *
 * (c) 2013 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Wj\Shift\Test\Bundle;

use Wj\Shift\Tests\Fixtures\Bundle\TheBundle;

class BundleTest extends \PHPUnit_Framework_TestCase
{
    public function testDiscoversOperatorClasses()
    {
        $bundle = new TheBundle();
        $operators = $bundle->getOperators();

        $this->assertCount(2, $operators);
        $this->assertEquals(array(
            'Wj\Shift\Tests\Fixtures\Bundle\CatOperator',
            'Wj\Shift\Tests\Fixtures\Bundle\SomeOperator',
        ), $operators);
    }
}
