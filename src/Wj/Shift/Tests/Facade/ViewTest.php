<?php

/*
 * This file is part of the ShiftPHP package.
 *
 * (c) 2013 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Wj\Shift\Test\Facade;

use Wj\Shift\Facade\View;
use Wj\Shift\Facade\Event;
use Wj\Shift\EventDispatcher\EventDispatcher;

class ViewTest extends \PHPUnit_Framework_TestCase
{
    protected $dispatcher;

    public function setUp()
    {
        $this->dispatcher = $d = new EventDispatcher();
        Event::setDispatcher($d);
    }

    public function testRegistering()
    {
        $called = false;
        View::on('show_homepage')->call(function () use ($called) {
            $called = true;
        });

        if (!$called) {
            $this->fail('Failed asserting View::on registers views');
        }
    }
}
