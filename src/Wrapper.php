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
        return new CallWrapper($this, $method, $args);
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