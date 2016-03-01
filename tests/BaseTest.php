<?php

namespace EasyCallback;
use EasyCallback\Resource\X;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    public function testFReturnsFirstParam() {
        $callback = f();
        $this->assertEquals('a', $callback('a', 'b'));
    }

    public function testF2ReturnsSecondParam() {
        $callback = f(2);
        $this->assertEquals('b', $callback('a', 'b'));
    }

    public function testArrayAccess() {
        $callback = f()['x'];
        $this->assertEquals('y', $callback(['x' => 'y']));
    }

    public function testPropertyAccess() {
        $callback = f()->x;
        $this->assertEquals('y', $callback((object)['x' => 'y']));
    }

    public function testFunctionCall() {
        $callback = f()->getValue();
        $this->assertEquals('a', $callback(new X('a')));
    }

    public function testNestedArrayAccess() {
        $callback = f()['x']['y'];
        $this->assertEquals('f', $callback(['x' => ['y' => 'f']]));
    }

    public function testNestedPropertyAccess() {
        $callback = f()->x->y;
        $this->assertEquals('f', $callback((object)['x' => (object)['y' => 'f']]));
    }

    public function testNestedFunctionCall() {
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

    public function testMatchMethod() {
        $callback = f()->ecMatch('/TEST/');
        $this->assertTrue($callback('abcTESTdfg'));
        $this->assertFalse($callback('abcTESdfg'));
    }

    public function testMatchFunction() {
        $callback = f\match('/TEST/');
        $this->assertTrue($callback('abcTESTdfg'));
        $this->assertFalse($callback('abcTESdfg'));
    }

    public function testMatchReturnValues() {
        $callback = f()->value->ecMatch('/TEST/', 'b', f()->throwException());
        $this->assertEquals('b', $callback(new X('TESd')));

        $callback = f()->value->ecMatch('/TEST/', f()->throwException(), 'c');
        $this->assertEquals('c', $callback(new X('TEST')));
    }

    public function testConvertToClosure() {
        $callback = f()['a']->ecEq('b')->ecClosure();
        $this->assertTrue($callback instanceof \Closure);
        $this->assertFalse($callback(['a' => 'c']));
        $this->assertTrue($callback(['a' => 'b']));
    }

    public function testIsInstanceOf() {
        $callback = f()->ecIsInstanceOf(X::class);
        $this->assertTrue($callback(new X('a')));
        $this->assertFalse($callback(new static()));
        $this->assertFalse($callback(23));
    }

    public function testIf() {
        $callback = f()->value->ecMatch('/TEST/')->ecIf('b', f()->throwException());
        $this->assertEquals('b', $callback(new X('TEST')));

        $callback = f()->value->ecMatch('/TEST/')->ecIf(f()->throwException(), 'c');
        $this->assertEquals('c', $callback(new X('TESd')));
    }

    public function testEq() {
        $callback = f\eq('a');
        $this->assertTrue($callback('a'));
        $this->assertFalse($callback('b'));
    }

    public function testOr() {
        $callback = f\_or(f\eq('a'), f\eq('b'));
        $this->assertTrue($callback('a'));
        $this->assertTrue($callback('b'));
        $this->assertFalse($callback('c'));
    }

    public function testOrDontReturnTrueButFirstNonFalsyWalue() {
        $callback = f\_or(f(), f('b'));
        $this->assertEquals('a', $callback('a'));
        $this->assertEquals('b', $callback(''));
    }

    public function testOrDontReturnFalseButLastFalsyWalue() {
        $callback = f\_or(f(), f\eq(''));
        $this->assertEquals('a', $callback('a'));
        $this->assertEquals('', $callback(false));
    }

    public function testAnd() {
        $callback = f\_and(f\match('/a/'), f\match('/b/'));
        $this->assertFalse($callback('cad'));
        $this->assertFalse($callback('cbd'));
        $this->assertTrue($callback('cbdae'));
    }

    public function testConcat() {
        $callback = f\concat('{', f(), '}');
        $this->assertEquals('{a}', $callback('a'));
    }

    public function testReplace() {
        $callback = f\replace('/a/', 'A');
        $this->assertEquals('bAcdA', $callback('bacda'));
    }

    public function testReplaceWithCb() {
        //parameters are overrode
        $callback = f\replace('/\{(\d+)\}/', f\concat('(', f()[1] , ')'));
        $this->assertEquals('a(123)(4) (56)f', $callback('a{123}{4} {56}f'));
    }
}