<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 12.03.16
 * Time: 14:32
 */

namespace EasyCallback\Func;


class Min extends Base {
    const REQUIRED_PARAM = 1;

    protected function func($wrapped, $args) {
        return min($wrapped, $this->getVal(0, $args));
    }
}