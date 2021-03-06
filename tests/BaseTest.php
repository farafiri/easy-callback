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
        $callback = f\_or(f(), f('b', true));
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

    public function testWrappingFunctions() {
        $callback = f('strtolower')->ecEq('a');
        $this->assertTrue($callback('a'));
        $this->assertTrue($callback('A'));
        $this->assertFalse($callback('b'));
    }

    public function testWrappingStaticFunctions() {
        $callback = f([X::class, 'getInstance'], false);
        $this->assertEquals('x', $callback('x')->getValue());
    }

    public function testCall() {
        $callback = f('in_array')->ecCall(f(), ['a', 'b']);
        $this->assertTrue($callback('a'));
        $this->assertTrue($callback('b'));
        $this->assertFalse($callback('c'));
    }

    public function testCmp() {
        $callback = f()->getValue()->ecStrCmp(false, false, true);
        $q = [new X('a8b'), new X('a3b'), new X('a12b'), new X('a5b')];
        $expected = [$q[1], $q[3], $q[0], $q[2]];
        usort($q, $callback);
        $this->assertEquals($expected, $q);
    }

    public function testNatCmp() {
        $callback = f()->getValue()->ecStrCmp(false, false, true);
        $q = [new X('a8b'), new X('a3b'), new X('a12b'), new X('a5b')];
        $expected = [$q[1], $q[3], $q[0], $q[2]];
        usort($q, $callback);
        $this->assertEquals($expected, $q);
    }

    public function testNvlReturnsFirstNotNullValue() {
        $callback = f\nvl(f(), f(2));
        $this->assertEquals(45, $callback(45, 56));
        $this->assertEquals(45, $callback(45, null));
        $this->assertEquals(45, $callback(null, 45));
        $this->assertEquals(false, $callback(false, 45));
    }

    public function testNvlArgEvaluateToNullOnAccessToEmptyPropertyOrCallingMethodOnNull() {
        $callback = f\nvl(f()['a']['b']['c'], 12);
        $this->assertEquals(12, $callback([]));
        $this->assertEquals(12, $callback(['a' => []]));
        $this->assertEquals(12, $callback(['a' => ['b' => []]]));
        $this->assertEquals(30, $callback(['a' => ['b' => ['c' => 30]]]));

        $callback = f\nvl(f()->a->b, 12);
        $this->assertEquals(12, $callback((object)[]));
        $this->assertEquals(12, $callback((object)['a' => (object)[]]));
        $this->assertEquals(37, $callback((object)['a' => (object)['b' => 37]]));

        $callback = f\nvl(f()->prepend('a')->getValue(), 12);
        $this->assertEquals(12, $callback(null));
        $this->assertEquals('ab', $callback(new X('b')));
    }

    public function testTrim() {
        $callable = f\trim(f(), 'a');
        $this->assertEquals('b', $callable('aaaaba'));
    }

    public function testTrimWithoutArgsDefault() {
        $callable = f\trim();
        $this->assertEquals('b', $callable('   b '));
        $this->assertEquals('aaaba', $callable('aaaba', 'a'));
    }

    public function testFunctionsWrapping() {
        $callable = f\ucfirst(f\strtolower(f\trim()));
        $this->assertEquals('Abc', $callable('aBC '));
    }

    public function testGt() {
        $callable = f()->ecGt(5);
        $this->assertFalse($callable(4));
        $this->assertFalse($callable(5));
        $this->assertTrue($callable(6));
    }

    public function testEGt() {
        $callable = f()->ecEGt(5);
        $this->assertFalse($callable(4));
        $this->assertTrue($callable(5));
        $this->assertTrue($callable(6));
    }

    public function testLt() {
        $callable = f()->ecLt(5);
        $this->assertTrue($callable(4));
        $this->assertFalse($callable(5));
        $this->assertFalse($callable(6));
    }

    public function testELt() {
        $callable = f()->ecELt(5);
        $this->assertTrue($callable(4));
        $this->assertTrue($callable(5));
        $this->assertFalse($callable(6));
    }

    public function testGtFunctionWithOneParam() {
        $callable = f\gt(5);
        $this->assertFalse($callable(4));
        $this->assertFalse($callable(5));
        $this->assertTrue($callable(6));
    }

    public function testGtFunctionWithTwoParams() {
        $callable = f\gt(f\gt(10)->ecIf(0, f()) ,5);
        $this->assertFalse($callable(4));
        $this->assertFalse($callable(5));
        $this->assertTrue($callable(6));
        $this->assertTrue($callable(10));
        $this->assertFalse($callable(11));
    }

    public function testAddFunctionWithoutParams() {
        $callable = f\add();
        $this->assertEquals(10, $callable(4, 6));
    }

    public function testWithReduce() {
        $this->assertEquals(8, array_reduce(array(3, 5, 8, 2, 7), f\max()));
        $this->assertEquals(25, array_reduce(array(3, 5, 8, 2, 7), f\add()));
    }

    public function testMatches() {
        $callable = f()->ecMatches('/a(\d*)/');
        $this->assertEquals(array('a12', '12'), $callable('a12a'));
    }

    public function testAllMatches() {
        $callable = f()->ecAllMatches('/a(\d*)/');
        $this->assertEquals(array(array('a12', 'a'), array('12', '')), $callable('a12a'));
    }

    public function testCastingFunction() {
        $callable = f\to_int();
        $this->assertSame(123, $callable('123'));
        $this->assertSame(1, $callable(true));
    }

    public function testIs() {
        $callable = f\is('5');
        $this->assertTrue($callable("5"));
        $this->assertFalse($callable(5));
        $this->assertFalse($callable(null));

        $callable = f\is(null);
        $this->assertTrue($callable("5"));
        $this->assertTrue($callable(5));
        $this->assertTrue($callable(null));
        $this->assertTrue($callable(new X('x')));
    }

    public function testWhere() {
        $callable = f\where([
            'value' => 10,
            'x'     => 33
        ]);

        $this->assertTrue($callable(['value' => 10, 'x' => 33, 'y' => 12]));
        $this->assertTrue($callable(['x' => 33, 'value' => 10]));
        $this->assertFalse($callable(['x' => 10, 'value' => 10]));
        $this->assertFalse($callable(['x' => 33, 'value' => 33]));
        $this->assertFalse($callable(['value' => 10]));
        $this->assertTrue($callable(new X(10, 33)));
        $this->assertFalse($callable(new X(33, 33)));
        $this->assertFalse($callable(new X(10, 10)));
    }

    public function testWhereIsStrictTyped() {
        $callable = f\where([
            'value' => "10",
            'x'     => 33
        ]);

        $this->assertTrue($callable(['value' => "10", 'x' => 33, 'y' => 12]));
        $this->assertFalse($callable(['value' => 10, 'x' => 33, 'y' => 12]));
        $this->assertTrue($callable(new X("10", 33)));
        $this->assertFalse($callable(new X(10, 33)));
    }

    public function testWhereMayUseCallbacks() {
        $callable = f\where([
            'value' => f\gt(5),
            'x'     => f\match('/^$|abcd/')
        ]);

        $this->assertTrue($callable(new X(10, '')));
        $this->assertTrue($callable(new X(10, 'abcd')));
        $this->assertTrue($callable(new X(6, 'abcd')));
        $this->assertFalse($callable(new X(10, 'ab')));
        $this->assertFalse($callable(new X(4, 'abcd')));
        $this->assertFalse($callable(new X(4, '')));
        $this->assertFalse($callable(new X(10, 'gggg')));
        $this->assertFalse($callable(new X(2, 'gggg')));
    }

    public function testWhereOnNullReturnFalse() {
        $callable = f\where([]);

        $this->assertFalse($callable(null));
    }

    public function testWhereCanThrowExceptionIfMethodOrPropertyCantBeFound() {
        $this->setExpectedException(Exception::class);

        $callable = f\where([
            'value' => 1,
            'y'     => 1
        ]);

        $callable(new X(1, 1));
    }

    public function testNestedWhere() {
        $callable = f\where([
            'value' => f\where([
                'x' => 20
            ]),
            'x'     => 10
        ]);

        $this->assertTrue($callable(new X(new X(50, 20), 10)));
        $this->assertFalse($callable(new X(new X(50, 10), 10)));
        $this->assertFalse($callable(new X(new X(50, 20), 20)));
    }
}