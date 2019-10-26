<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 16.05.18
 * Time: 13:23
 */

namespace EasyCallback\Func;


class Is extends Base {
    const REQUIRED_PARAM = 1;

    protected function func($wrapped, $args) {
        $param = $this->getVal(0, $args);

        if ($param === null) {
            return true;
        }

        $strict = $this->getVal(1, $args, true);
        $result = $strict ? ($param === $wrapped) : ($param == $wrapped);
        return $result;
    }
} 