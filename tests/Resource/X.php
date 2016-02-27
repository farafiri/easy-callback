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

    public function __construct($value) {
        $this->value = $value;
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
} 