<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 26.02.16
 * Time: 21:15
 */

namespace EasyCallback\Resource;


class X {
    public $value;
    protected $x;

    public function __construct($value, $x = null) {
        $this->value = $value;
        $this->x     = $x;
    }

    public function prepend($str) {
        return new self($str . $this->value);
    }

    public function append($str) {
        return new self($this->value . $str);
    }

    public function getValue() {
        return $this->value;
    }

    public function getX() {
        return $this->x;
    }

    public function throwException() {
        throw new \Exception();
    }

    public static function getInstance($str) {
        return new self($str);
    }
} 