<?php

namespace EasyCallback\f;

function atLeastOneArg($args) {
    return $args ? $args : array(\EasyCallback\f());
}

function atLeastTwoArgs($args) {
    if (count($args) == 0) {
        return array(\EasyCallback\f(), \EasyCallback\f(2));
    }
    return count($args) == 1 ? array_merge(array(\EasyCallback\f()), $args) : $args;
}

function fn($f, $args) {
    return \EasyCallback\f($f)->__call('ecCall', atLeastOneArg($args));
}

function fn2($f, $args) {
    $arg = array_shift($args);
    return \EasyCallback\f($arg, true)->__call($f, $args);
}

function match($pattern) { return fn2('ecMatch', atLeastTwoArgs(func_get_args())); };
function isInstanceOf($className) { return fn2('ecIsInstanceOf', atLeastTwoArgs(func_get_args())); };
function condition($cond, $onTrue = true, $onFalse = false) {return \EasyCallback\f($cond)->ecIf($onTrue, $onFalse);}
function _if($cond, $onTrue = true, $onFalse = false) {return \EasyCallback\f($cond, false)->ecIf($onTrue, $onFalse);}
function _or($p1, $p2) {return fn2('ecOr', func_get_args());}
function eq() {return fn2('ecEq', atLeastTwoArgs(func_get_args()));}
function _and($p1, $p2) {return fn2('ecAnd', func_get_args());}
function concat($string1, $string2) {return fn2('ecConcat', func_get_args());}
function replace($pattern, $replacement) {return \EasyCallback\f()->ecReplace($pattern, $replacement);}
function nvl() {return new \EasyCallback\Func\Nvl(null, func_get_args());}

function trim() {return fn('trim', func_get_args());}
function ltrim() {return fn('ltrim', func_get_args());}
function rtrim() {return fn('rtrim', func_get_args());}

function html_entity_decode() {return fn('html_entity_decode', func_get_args());}
function htmlentities() {return fn('htmlentities', func_get_args());}
function htmlspecialchars () {return fn('htmlspecialchars', func_get_args());}
function htmlspecialchars_decode () {return fn('htmlspecialchars_decode', func_get_args());}
function addslashes() {return fn('addslashes', func_get_args());}
function addcslashes() {return fn('addcslashes', func_get_args());}
function stripslashes() {return fn('stripslashes', func_get_args());}
function stripcslashes() {return fn('stripcslashes', func_get_args());}
function bin2hex() {return fn('bin2hex', func_get_args());}
function hex2bin() {return fn('hex2bin', func_get_args());}
function quoted_printable_decode() {return fn('quoted_printable_decode', func_get_args());}
function quoted_printable_encode() {return fn('quoted_printable_encode', func_get_args());}
function quotemeta() {return fn('quotemeta', func_get_args());}

function lcfirst() {return fn('lcfirst', func_get_args());}
function ucfirst() {return fn('ucfirst', func_get_args());}
function strtolower() {return fn('strtolower', func_get_args());}
function strtoupper() {return fn('strtoupper', func_get_args());}
function ucwords() {return fn('ucwords', func_get_args());}

function wordwrap() {return fn('wordwrap', func_get_args());}
function nl2br() {return fn('nl2br', func_get_args());}
function strip_tags() {return fn('strip_tags', func_get_args());}
function md5() {return fn('md5', func_get_args());}
function sha1() {return fn('sha1', func_get_args());}
function number_format() {return fn('number_format', func_get_args());}
function str_ireplace() {return fn('str_ireplace', func_get_args());}
function str_pad() {return fn('str_pad', func_get_args());}
function str_repeat() {return fn('str_repeat', func_get_args());}
function str_replace() {return fn('str_replace', func_get_args());}
function str_rot13() {return fn('str_rot13', func_get_args());}

function str_shuffle() {return fn('str_shuffle', func_get_args());}
function str_split() {return fn('str_split', func_get_args());}
function strlen() {return fn('strlen', func_get_args());}
function str_word_count() {return fn('str_word_count', func_get_args());}
function substr_compare() {return fn('substr_compare', func_get_args());}
function substr_count() {return fn('substr_count', func_get_args());}
function substr_replace() {return fn('substr_replace', func_get_args());}
function substr() {return fn('substr', func_get_args());}
function strtr() {return fn('strtr', func_get_args());}
function strstr() {return fn('strstr', func_get_args());}
function stristr() {return fn('stristr', func_get_args());}

function chr() {return fn('chr', func_get_args());}
function ord() {return fn('ord', func_get_args());}

function gt() {return fn2('ecGt', atLeastTwoArgs(func_get_args()));}
function egt() {return fn2('ecEGt', atLeastTwoArgs(func_get_args()));}
function lt() {return fn2('ecLt', atLeastTwoArgs(func_get_args()));}
function elt() {return fn2('ecELt', atLeastTwoArgs(func_get_args()));}

function add() {return fn2('ecAdd', atLeastTwoArgs(func_get_args()));}
function sub() {return fn2('ecSub', atLeastTwoArgs(func_get_args()));}
function mul() {return fn2('ecMul', atLeastTwoArgs(func_get_args()));}
function div() {return fn2('ecDiv', atLeastTwoArgs(func_get_args()));}
function mod() {return fn2('ecMod', atLeastTwoArgs(func_get_args()));}

function max() {return fn2('ecMax', atLeastTwoArgs(func_get_args()));}
function min() {return fn2('ecMin', atLeastTwoArgs(func_get_args()));}