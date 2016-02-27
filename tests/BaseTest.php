<?php

namespace EasyCallback;
use EasyCallback\Resource\X;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    public function testArrayAccess() {
        $callback = f()['x']['y'];
        $this->assertEquals('f', $callback(['x' => ['y' => 'f']]));
    }

    public function testPropertyAccess() {
        $callback = f()->x->y;
        $this->assertEquals('f', $callback((object)['x' => (object)['y' => 'f']]));
    }

    public function testFunctionCall() {
        $callback = f()->append('b')->prepend('c')->getValue();
        $this->assertEquals('cab', $callback(new X('a')));
    }

    public function testMixed() {
        $callback = f()['x']->append('W')->value;
        $this->assertEquals('QW', $callback(['x' => new X('Q')]));
    }

    public function testWrappingObject() {
        $o = new X('O');
        $callback = f($o)->prepend(f(1))->append(f(1))->value;
        $this->assertEquals('xOx', $callback('x'));
    }

    public function testCallbackMayTakeSeveralArguments() {
        $callback = f(1)->prepend(f(2))->append(f(3))->value;
        $this->assertEquals('YXZ', $callback(new X('X'), 'Y', 'Z'));
    }

    public function testCallsOnArgs() {
        $o = new X('O');
        $callback = f(1)->prepend(f($o)->value)->append(f(2)->getValue())->value;
        $this->assertEquals('OXY', $callback(new X('X'), new X('Y')));
    }
}