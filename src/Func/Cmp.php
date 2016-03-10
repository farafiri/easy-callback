<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 01.03.16
 * Time: 23:30
 */

namespace EasyCallback\Func;


class Cmp extends Func {
    const REQUIRED_PARAM = 0;

    public function __invoke($value1, $value2) {
        $wrapped = $this->wrapped;
        $v1 = $wrapped($value1);
        $v2 = $wrapped($value2);
        $order = empty($this->params[0]) ? 1 : -1;
        return (($v1 >= $v2) - ($v2 >= $v1)) * $order;
    }
} 