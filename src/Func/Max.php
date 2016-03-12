<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 12.03.16
 * Time: 14:27
 */

namespace EasyCallback\Func;


class Max extends Base {
    const REQUIRED_PARAM = 1;

    protected function func($wrapped, $args) {
        return max($wrapped, $this->getVal(0, $args));
    }
}