<?php

namespace EasyCallback\f;

function fixArgs($args) {
    return $args ? $args : array(\EasyCallback\f());
}
function fn($f, $args) {
    return \EasyCallback\f($f)->__call('ecCall', fixArgs($args));
}
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

function gt($p1) {return \EasyCallback\f()->ecGt($p1);}
function egt($p1) {return \EasyCallback\f()->ecEGt($p1);}
function lt($p1) {return \EasyCallback\f()->ecLt($p1);}
function elt($p1) {return \EasyCallback\f()->ecELt($p1);}