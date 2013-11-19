<?php

/*
 * This file is part of the ShiftPHP package.
 *
 * (c) 2013 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Wj\Shift\Test\DependencyInjection;

use Wj\Shift\DependencyInjection\Container;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    protected $container;

    public function setUp()
    {
        $this->container = new Container();
    }

    public function tearDown()
    {
        $this->container = null;
    }

    public function testGettingClassWithoutArguments()
    {
        $this->assertInstanceOf("StdClass", $this->container->get('StdClass'));
    }
}
