<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 13.03.16
 * Time: 22:31
 */

namespace EasyCallback\Func;


class ToString extends Base {
    const REQUIRED_PARAM = 0;

    protected function func($wrapped, $args) {
        return (string) $wrapped;
    }
} 