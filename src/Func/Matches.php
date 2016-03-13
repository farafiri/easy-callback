<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 13.03.16
 * Time: 18:16
 */

namespace EasyCallback\Func;


class Matches extends Base {
    const REQUIRED_PARAM = 1;

    protected function func($wrapped, $args) {
        preg_match($this->getVal(0, $args), $wrapped, $result);
        return $result;
    }
} 