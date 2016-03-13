<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 13.03.16
 * Time: 22:30
 */

namespace EasyCallback\Func;


class ToBool extends Base {
    const REQUIRED_PARAM = 0;

    protected function func($wrapped, $args) {
        return (bool) $wrapped;
    }
} 