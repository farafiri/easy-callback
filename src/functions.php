<?php

namespace EasyCallback\f;
use EasyCallback\Wrapper;

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
function _or($p1, $p2) {return fn2('ecOr', atLeastTwoArgs(func_get_args()));}
function eq() {return fn2('ecEq', atLeastTwoArgs(func_get_args()));}
function is() {return fn2('ecIs', atLeastTwoArgs(func_get_args()));}
function _and() {return fn2('ecAnd', atLeastTwoArgs(func_get_args()));}
function concat($string1, $string2) {return fn2('ecConcat', atLeastTwoArgs(func_get_args()));}
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

function round() {return fn('round', atLeastOneArg(func_get_args()));}
function floor() {return fn('floor', atLeastOneArg(func_get_args()));}
function sqrt() {return fn('sqrt', atLeastOneArg(func_get_args()));}
function sqr() {return fn('sqr', atLeastOneArg(func_get_args()));}
function pow() {return fn('pow', atLeastTwoArgs(func_get_args()));}
function exp() {return fn('exp', atLeastOneArg(func_get_args()));}
function log() {return fn('log', atLeastOneArg(func_get_args()));}
function abs() {return fn('abs', atLeastOneArg(func_get_args()));}

function max() {return fn2('ecMax', atLeastTwoArgs(func_get_args()));}
function min() {return fn2('ecMin', atLeastTwoArgs(func_get_args()));}

function is_string() {return fn('is_string', func_get_args());}
function is_array() {return fn('is_array', func_get_args());}
function is_bool() {return fn('is_bool', func_get_args());}
function is_callable() {return fn('is_callable', func_get_args());}
function is_float() {return fn('is_float', func_get_args());}
function is_int() {return fn('is_int', func_get_args());}
function is_numeric() {return fn('is_numeric', func_get_args());}
function is_object() {return fn('is_object', func_get_args());}
function is_scalar() {return fn('is_scalar', func_get_args());}

function to_bool() {return fn2('ecToBool', atLeastOneArg(func_get_args()));}
function to_float() {return fn2('ecToFloat', atLeastOneArg(func_get_args()));}
function to_int() {return fn2('ecToInt', atLeastOneArg(func_get_args()));}
function to_string() {return fn2('ecToString', atLeastOneArg(func_get_args()));}

function v() {return fn('EasyCallback\internal\valuesIterator', atLeastOneArg(func_get_args()));}
function values() {return fn('EasyCallback\internal\valuesIterator', atLeastOneArg(func_get_args()));}
function a() {return fn('iterator_to_array', atLeastOneArg(func_get_args()));}
function iteratorToArray() {return fn('iterator_to_array', atLeastOneArg(func_get_args()));}

function higherOrderFunction($fn, $args, $closureFrom = 2) {
    if ($args[0] instanceof Wrapper) {
        if (count($args) === 1) {
            $args = [\EasyCallback\f(), $args[0]];
        }
        foreach($args as $i => &$arg) {
            if ($i >= ($closureFrom - 1) && $arg instanceof \EasyCallback\Wrapper) {
                $arg = $arg->ecClosure();
            }
        }

        return fn($fn, $args);
    } else {
        return call_user_func_array($fn, $args);
    }
};

function map() {return higherOrderFunction('EasyCallback\internal\mapIterator', func_get_args());};
function filter() {return higherOrderFunction('EasyCallback\internal\filterIterator',func_get_args());};
function first() {return higherOrderFunction('EasyCallback\internal\first',func_get_args());};
function last() {return higherOrderFunction('EasyCallback\internal\last',func_get_args());};
function firstKey() {return higherOrderFunction('EasyCallback\internal\firstKey',func_get_args());};
function lastKey() {return higherOrderFunction('EasyCallback\internal\lastKey',func_get_args());};
function maximum() {return higherOrderFunction('EasyCallback\internal\maximum',func_get_args());};
function minimum() {return higherOrderFunction('EasyCallback\internal\minimum',func_get_args());};
function maximumKey() {return higherOrderFunction('EasyCallback\internal\maximumKey',func_get_args());};
function minimumKey() {return higherOrderFunction('EasyCallback\internal\minimumKey',func_get_args());};
function groupBy() {return higherOrderFunction('EasyCallback\internal\groupBy',func_get_args());};
function some() {return higherOrderFunction('EasyCallback\internal\some',func_get_args());};
function every() {return higherOrderFunction('EasyCallback\internal\every',func_get_args());};
function none() {return higherOrderFunction('EasyCallback\internal\none',func_get_args());};
function duplicates() {return higherOrderFunction('EasyCallback\internal\duplicates',func_get_args());};
function unique() {return higherOrderFunction('EasyCallback\internal\uniqueIterator',func_get_args());};
function chunk() {return higherOrderFunction('EasyCallback\internal\chunkIterator',func_get_args());};
function flatten() {return higherOrderFunction('EasyCallback\internal\flattenIterator',func_get_args());};
function flatMap() {return higherOrderFunction('EasyCallback\internal\flatMapIterator',func_get_args());};
function join() {return higherOrderFunction('EasyCallback\internal\join',func_get_args(), 3);};
function joinByValue() {return higherOrderFunction('EasyCallback\internal\joinByValue',func_get_args(), 3);};
function reduce() {return higherOrderFunction('EasyCallback\internal\reduce',func_get_args());};
function recursive() {return higherOrderFunction('EasyCallback\internal\recursiveIterator',func_get_args());};


function where() {return fn(function($item, $filter = 1) {
    if ($item === null) {
        return false;
    } if (\is_array($item)) {
        foreach($filter as $key => $value) {
            if (isset($item[$key])) {
                if ($value instanceof \EasyCallback\Wrapper) {
                    /** @var $value callable */
                    if (!$value($item[$key])) {
                        return false;
                    }
                } else {
                    if ($value !== $item[$key]) {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }

        return true;
    } elseif (\is_object($item)) {
        foreach($filter as $key => $value) {
            $getter = 'get' . \ucfirst($key);
            if (\method_exists($item, $getter)) {
                $itemValue = $item->$getter();
            } elseif (\method_exists($item, $key)) {
                $itemValue = $item->$key();
            } elseif (\property_exists($item, $key)) {
                $itemValue = $item->$key;
            } else {
                throw new \EasyCallback\Exception("where-d object don't have $getter method nor $key method nor $key property");
            }

            if ($value instanceof \EasyCallback\Wrapper) {
                /** @var $value callable */
                if (!$value($itemValue)) {
                    return false;
                }
            } else {
                if ($value !== $itemValue) {
                    return false;
                }
            }
        }

        return true;
    } else {
        throw new \EasyCallback\Exception("where-d item should be array or object");
    }
},atLeastTwoArgs(func_get_args()));};