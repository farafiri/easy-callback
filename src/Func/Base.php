<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 28.02.16
 * Time: 18:25
 */

namespace EasyCallback\Func;

abstract class Base extends Func {


    public function __invoke() {
        $args = $args = func_get_args();
        $wrapped = call_user_func_array($this->wrapped, $args);
        return $this->func($wrapped, $args);
    }

    abstract protected function func($wrapped, $args);
} 