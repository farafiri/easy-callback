<?php
namespace EasyCallback;
use EasyCallback\Resource\X;
use EasyCallback\Internal as i;

class FunctionalTest extends \PHPUnit_Framework_TestCase {
    protected function assertTraversable($expected, $actual) {
        $this->assertSame($expected, $actual instanceof \Traversable ? iterator_to_array($actual) : $actual);
    }
    
    public function testMap() {
        $this->assertTraversable(range(6, 10), f\map(range(1, 5), f\add(5)));
    }

    public function testMap2() {
        $c = [
            new X(2),
            new X(5),
            new X(1),
            new X(4),
        ];

        $this->assertTraversable([2, 5, 1, 4], f\map($c, f()->getValue()));
    }

    public function testFilter() {
        $this->assertTraversable([4, 5], f\filter(range(1, 5), f\gt(3)));
        $this->assertTraversable([3 => 4, 4 => 5], f\filter(range(1, 5), f\gt(3), true));
    }

    public function testFilter2() {
        $c = [
            new X(2),
            new X(5),
            new X(1),
            new X(4),
        ];

        $this->assertTraversable([$c[1], $c[3]], f\filter($c, f()->getValue()->ecGt(3)));
    }

    public function testFilterWithWhere() {
        $c = [
            new X(1, 10),
            new X(2, 10),
            new X(3, 10),
            new X(4, 11),
            new X(5, 10)
        ];

        $callback = f\filter(f\where(['value' => f\gt(1), 'x' => 10]));

        $this->assertTraversable([$c[1], $c[2], $c[4]], $callback($c));
    }

    public function testMaximumFunctions() {
        $c = [
            new X(2),
            new X(5),
            new X(1),
            new X(4),
        ];
        $this->assertTraversable($c[1], f\maximum($c, f()->getValue()));
        $this->assertTraversable($c[2], f\minimum($c, f()->getValue()));
        $this->assertTraversable(1, f\maximumKey($c, f()->getValue()));
        $this->assertTraversable(2, f\minimumKey($c, f()->getValue()));
    }

    public function testFirstFunctions() {
        $c = [
            new X(2),
            new X(5),
            new X(1),
            new X(4),
        ];

        $this->assertTraversable($c[1], f\first($c, f()->getValue()->ecGt(3)));
        $this->assertTraversable($c[0], f\first($c, f()->getValue()->ecGt(0)));
        $this->assertTraversable(1, f\firstKey($c, f()->getValue()->ecGt(3)));
        $this->assertTraversable(0, f\firstKey($c, f()->getValue()->ecGt(0)));

        $this->assertTraversable($c[3], f\last($c, f()->getValue()->ecGt(3)));
        $this->assertTraversable($c[3], f\last($c, f()->getValue()->ecGt(0)));
        $this->assertTraversable(3, f\lastKey($c, f()->getValue()->ecGt(3)));
        $this->assertTraversable(3, f\lastKey($c, f()->getValue()->ecGt(0)));
    }

    public function testEvery() {
        $callback = f\every(f\gt(10));

        $this->assertTrue($callback([]));
        $this->assertTrue(f\every([], f\gt(10)));
        $this->assertTrue($callback([12, 15, 18]));
        $this->assertTrue(f\every([12, 15, 18], f\gt(10)));
        $this->assertFalse($callback([12, 3, 18]));
        $this->assertFalse(f\every([5, 15, 5], f\gt(10)));
        $this->assertFalse($callback([2, 5, 8]));
        $this->assertFalse(f\every([2, 5, 8], f\gt(10)));
    }

    public function testSome() {
        $callback = f\some(f\gt(10));

        $this->assertFalse($callback([]));
        $this->assertFalse(f\some([], f\gt(10)));
        $this->assertTrue($callback([12, 15, 18]));
        $this->assertTrue(f\some([12, 15, 18], f\gt(10)));
        $this->assertTrue($callback([12, 3, 18]));
        $this->assertTrue(f\some([5, 15, 5], f\gt(10)));
        $this->assertFalse($callback([2, 5, 8]));
        $this->assertFalse(f\some([2, 5, 8], f\gt(10)));
    }

    public function testNone() {
        $callback = f\none(f\gt(10));

        $this->assertTrue($callback([]));
        $this->assertTrue(f\none([], f\gt(10)));
        $this->assertFalse($callback([12, 15, 18]));
        $this->assertFalse(f\none([12, 15, 18], f\gt(10)));
        $this->assertFalse($callback([12, 3, 18]));
        $this->assertFalse(f\none([5, 15, 5], f\gt(10)));
        $this->assertTrue($callback([2, 5, 8]));
        $this->assertTrue(f\none([2, 5, 8], f\gt(10)));
    }

    public function testGroupBy() {
        $c = [
            new X(true),
            new X(false),
            new X(false),
            new X(true),
        ];

        $this->assertSame([true => [$c[0], $c[3]], false => [$c[1], $c[2]]], f\groupBy($c, f()->getValue()));
    }

    public function testGroupBy2() {
        $callback = f\groupBy(f\floor(f\div(10)));
        $this->assertSame([2 => [23], 5 => [59, 53], 1 => [12, 17, 15], 0 => [9, 9, 4]], $callback([23, 59, 12, 17, 9, 53, 15, 9, 4]));
    }

    public function testReduce() {
        $this->assertTraversable(9, i\reduce([3, 5, 1], f\add()));
        $this->assertTraversable(16, i\reduce([2, 1, 3], f\add(), 10));
        $this->assertTraversable(3, i\reduce([3, 5, 1], f\add(1), 0));
        $this->assertTraversable(5, i\reduce([3, 5, null, 5, 23], f\add(1), 0));
    }

    public function testChunk() {
        $this->assertTraversable([[1, 2, 3], [4, 5, 6], [7]], f\chunk([1,2,3,4,5,6,7], 3));
        $this->assertTraversable([[1, 2, 3, 4], [5, 6, 7, 8]], f\chunk([1,2,3,4,5,6,7,8], 4));
        $this->assertTraversable([[1, 2, 3, 4]], f\chunk([1,2,3,4], 20));
        $this->assertTraversable([[1], [2], [3], [4]], f\chunk([1,2,3,4], 1));
        $this->assertTraversable([], f\chunk([], 5));
        $this->assertTraversable([[1, 2, 3], [4, 5], [6], [7]], f\chunk([1,2,3,4,5,6,7], 9, f()));
        $this->assertTraversable([[8, 5], [10, 7, 0, 3, 0], [1, 0]], f\chunk([8, 5, 10, 7, 0, 3, 0, 1, 0], 20, f()));
    }

    public function testJoinByValue() {
        $this->assertTraversable([[5, 5], [7, 7], [1, 1]], f\joinByValue([5, 7, 1], [1, 5, 7]));
        $this->assertTraversable([[5, 5], [2, null], [7, 7], [null, 1]], f\joinByValue([5, 2 ,7], [1, 5, 7]));
        $this->assertTraversable(['55', '2', '77', '1'], f\joinByValue([5, 2 ,7], [1, 5, 7], f\concat(f(), f(2))));
    }

    public function testRecursive() {
        $dataset = [
            'val' => 1,
            'children' => [
                [
                    'val' => 2,
                    'children' => [
                        ['val' => 3],
                        ['val' => 4]
                    ]
                ],
                ['val' => 5],
                [
                    'val' => 6,
                    'children' => [
                        [
                            'val' => 7,
                            'children' => [
                                [
                                    'val' => 8,
                                    'children' => []
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $this->assertTraversable([3, 4, 5, 8], f\map(f\recursive($dataset, f\nvl(f()['children'], [])), f()['val']));
        $mode = \RecursiveIteratorIterator::SELF_FIRST;
        $this->assertTraversable([1, 2, 3, 4, 5, 6, 7, 8], f\map(f\recursive($dataset, f\nvl(f()['children'], []), $mode), f()['val']));
        $mode = \RecursiveIteratorIterator::CHILD_FIRST;
        $this->assertTraversable([3, 4, 2, 5, 8, 7, 6, 1], f\map(f\recursive($dataset, f\nvl(f()['children'], []), $mode), f()['val']));
    }

    public function testFlatten()
    {
        $this->assertTraversable([1, 2, 3, 4], f\flatten([[1, 2], [3, 4]]));
        $this->assertTraversable([1, 2, 3, 4], f\flatten([[1], [2, 3, 4]]));
        $this->assertTraversable([2, 3, 4], f\flatten([[], [2, 3, 4]]));
        $this->assertTraversable([2, 3, 4], f\flatten([[2, 3, 4], []]));
        $this->assertTraversable([], f\flatten([[], [], []]));
        $this->assertTraversable([], f\flatten([[]]));
        $this->assertTraversable([], f\flatten([]));
        $this->assertTraversable(['1', '2', '3'], f\flatten([['1'], ['2'], ['3']]));
        $this->assertTraversable([[3, 4], [5], 6], f\flatten([[[3, 4], [5]], [6]]));//only one level deep
    }

    public function testFlatMap()
    {
        //on start some test form Flatten
        $this->assertTraversable([1, 2, 3, 4], f\flatMap([[1, 2], [3, 4]], f()));
        $this->assertTraversable([], f\flatMap([[], [], []], f()));
        $this->assertTraversable([], f\flatMap([[]], f()));
        $this->assertTraversable([], f\flatMap([], f()));
        $this->assertTraversable([2, 3, 4], f\flatMap([[2, 3, 4], []], f()));
        //$this->assertTraversable([[3, 4], [5], 6], f\flatMap([[[3, 4], [5]], [6]], f()));

        //specific to flatMap
        $this->assertTraversable([2, 1, 4, 3], f\flatMap([[2], [1, 2, 4], [1, 3, 4]], f())); //values are unique
        $this->assertTraversable([1, 2, 30, 400], f\flatMap([new X([1, 2]), new X([30, 1]), new X([2, 30, 400])], f()->getValue()));
    }

    public function testMapCb() {
        $map = f\map(f\add(5));
        $this->assertTraversable(range(6, 10), $map(range(1, 5)));
    }

    public function testCount() {
        $count = f\reduce(f(), f\add(1), 0);
        $this->assertTraversable([1, 3, 0], f\map([0 => [1], 1 => [1, 2, 3], 2 => []], $count));
    }

    public function testSum() {
        $count = f\reduce(f\add());
        $this->assertTraversable([4, 15, null], f\map([0 => [4], 1 => [10, 2, 3], 2 => []], $count));
    }

    public function testIntersect() {
        $intersect = f\values(f\filter(f\joinByValue(f(), f(2), f\_and()), f()));
        $this->assertTraversable([1, 2], $intersect([1, 3, 2], [2, 1, 4]));
    }
}