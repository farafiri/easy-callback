<?php

namespace EasyCallback\f;

function match($pattern) { return \EasyCallback\f()->ecMatch($pattern); };
function isInstanceOf($className) { return \EasyCallback\f()->ecIsInstanceOf($className); };
function condition($cond, $onTrue = true, $onFalse = false) {return \EasyCallback\f($cond)->ecIf($onTrue, $onFalse);}
function _if($cond, $onTrue = true, $onFalse = false) {return \EasyCallback\f($cond, false)->ecIf($onTrue, $onFalse);}
function _or($p1, $p2, $p3 = false, $p4 = false) {return \EasyCallback\f($p1, false)->ecOr($p2, $p3, $p4);}
function eq($p1) {return \EasyCallback\f()->ecEq($p1);}
function _and($p1, $p2, $p3 = true, $p4 = true) {return \EasyCallback\f($p1, false)->ecAnd($p2, $p3, $p4);}
function concat($string1, $string2) {
    $args = func_get_args();
    array_shift($args);
    return new \EasyCallback\Func\Concat(\EasyCallback\f($string1, true), $args);
}
function replace($pattern, $replacement) {return \EasyCallback\f()->ecReplace($pattern, $replacement);}
function nvl() {return new \EasyCallback\Func\Nvl(null, func_get_args());}
