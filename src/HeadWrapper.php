<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 27.02.16
 * Time: 10:41
 */
namespace EasyCallback;

class HeadWrapper extends Wrapper {
    public function __invoke() {
        if (is_integer($this->wrapped)) {
            return func_get_arg($this->wrapped - 1);
        } elseif ($this->wrapped instanceof Wrapper || $this->wrapped instanceof \Closure) {
            return call_user_func_array($this->wrapped, func_get_args());
        } else {
            return $this->wrapped;
        }
    }
} 