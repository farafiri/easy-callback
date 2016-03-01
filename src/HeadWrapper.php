<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 27.02.16
 * Time: 10:41
 */
namespace EasyCallback;

class HeadWrapper extends Wrapper {
    protected $value;

    public function __construct($wrapped, $value = null) {
        $this->wrapped = $wrapped;
        if ($value === null) {
            $value = !(is_integer($wrapped) || is_string($wrapped));
        }
        if ($wrapped instanceof \Closure || $wrapped instanceof Wrapper) {
            $value = false;
        }
        $this->value = $value;
    }

    public function __invoke() {
        if ($this->value) {
            return $this->wrapped;
        } elseif (is_integer($this->wrapped)) {
            return func_get_arg($this->wrapped - 1);
        } else {
            return call_user_func_array($this->wrapped, func_get_args());
        }
    }
} 