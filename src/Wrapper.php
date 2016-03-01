<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 27.02.16
 * Time: 11:03
 */

namespace EasyCallback;


abstract class Wrapper implements \ArrayAccess {
    protected $wrapped;

    public function __construct($wrapped) {
        $this->wrapped = $wrapped;
    }

    public function __get($property) {
        return new PropertyWrapper($this, $property);
    }

    public function __call($method, $args) {
        if ($method == 'ecClosure') {
            $wrapped = $this;
            return function () use ($wrapped) {
                return call_user_func_array($this, func_get_args());
            };
        } if (substr($method, 0, 2) == 'ec') {
            $class = 'EasyCallback\\Func\\' . substr($method, 2);
            if (!class_exists($class)) {
                $class = 'EasyCallback\\Func\\_' . substr($method, 2);
            }
            if (!class_exists($class) || !defined("$class::REQUIRED_PARAM") || $class::REQUIRED_PARAM === null) {
                throw new Exception("Method $method don't exists");
            }
            if ($class::REQUIRED_PARAM > count($args)) {
                throw new Exception("Method $method requires at least " . $class::REQUIRED_PARAM . " parameters");
            }

            return new $class($this, $args);
        } else {
            return new CallWrapper($this, $method, $args);
        }
    }

    public function offsetGet ($offset) {
        return new ArrayAccessWrapper($this, $offset);
    }

    public function offsetExists ($offset) {
        throw new Exception('Can\'t check key on callable');
    }

    public function offsetSet ($offset, $value) {
        throw new Exception('Can\'t assign to callable');
    }

    public function offsetUnset ($offset) {
        throw new Exception('Can\'t unset key on callable');
    }
} 