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

    public function testGetsClassWithoutConstructor()
    {
        $this->assertInstanceOf("StdClass", $this->container->get('StdClass'));
    }

    public function testGetsClassWithoutInjections()
    {
        $service = $this->container->get('Wj\Shift\Tests\Fixtures\DependencyInjection\WithoutInjections');

        $this->assertInstanceOf('Wj\Shift\Tests\Fixtures\DependencyInjection\WithoutInjections', $service);
        $this->assertTrue($service->isInitialized());
    }

    public function testGetsClassWithServiceInjection()
    {
        $this->assertInstanceOf('Wj\Shift\Tests\Fixtures\DependencyInjection\WithServiceInjection', $this->container->get('Wj\Shift\Tests\Fixtures\DependencyInjection\WithServiceInjection'));
    }

    public function testGetsClassWithDefaultValue()
    {
        $this->assertInstanceOf('Wj\Shift\Tests\Fixtures\DependencyInjection\WithDefaultValue', $this->container->get('Wj\Shift\Tests\Fixtures\DependencyInjection\WithDefaultValue'));
    }

    public function testsGetsClassWithParameter()
    {
        $this->container->setParameter('a', 'foo');

        $service = $this->container->get('Wj\Shift\Tests\Fixtures\DependencyInjection\WithParameter');
        $this->assertInstanceOf('Wj\Shift\Tests\Fixtures\DependencyInjection\WithParameter', $service);
        $this->assertEquals('foo', $service->getPassedValue());
    }
}
