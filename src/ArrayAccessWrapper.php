<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 27.02.16
 * Time: 11:44
 */

namespace EasyCallback;


class ArrayAccessWrapper extends Wrapper {
    protected $key;

    public function __construct($wrapped, $key) {
        $this->wrapped = $wrapped;
        $this->key = $key;
    }

    public function __invoke() {
        $wrapped = call_user_func_array($this->wrapped, func_get_args());
        $key = $this->key;
        if ($wrapped === null) {
            throw new NullAccessException("Try to access key: $key on null");
        } elseif (!is_array($wrapped) && !($wrapped instanceof \ArrayAccess)) {
            throw new Exception ("Try to read key: $key on no array");
        } elseif (isset($wrapped[$key])) {
            return $wrapped[$key];
        } else {
            throw new NullAccessException("Try to access non existing key: $key on array or ArrayAccess object");
        }
    }
} 