<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 29.02.16
 * Time: 17:47
 */

namespace EasyCallback\Func;


class IsInstanceOf extends Base {
    const REQUIRED_PARAM = 1;

    protected function func($wrapped, $args) {
        $className = $this->getVal(0, $args);
        $result = (boolean) ($className ? is_a($wrapped, $className) : is_object($wrapped));
        return $this->getVal($result ? 2 : 1, $args, $result);
    }
} 