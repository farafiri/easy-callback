<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 13.03.16
 * Time: 22:30
 */

namespace EasyCallback\Func;


class ToFloat extends Base {
    const REQUIRED_PARAM = 0;

    protected function func($wrapped, $args) {
        return (float) $wrapped;
    }
} 