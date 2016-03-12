<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 11.03.16
 * Time: 23:37
 */

namespace EasyCallback\Func;


class Sub extends Base {
    const REQUIRED_PARAM = 1;

    protected function func($wrapped, $args) {
        return $wrapped - $this->getVal(0, $args);
    }
} 