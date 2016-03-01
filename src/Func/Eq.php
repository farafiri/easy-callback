<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 29.02.16
 * Time: 19:38
 */

namespace EasyCallback\Func;


class Eq extends Base {
    const REQUIRED_PARAM = 1;

    protected function func($wrapped, $args) {
        $param = $this->getVal(0, $args);
        $strict = $this->getVal(1, $args, true);
        $result = $strict ? ($param === $wrapped) : ($param == $wrapped);
        return $result;
    }
} 