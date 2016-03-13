<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 13.03.16
 * Time: 18:18
 */

namespace EasyCallback\Func;


class AllMatches extends Base {
    const REQUIRED_PARAM = 1;

    protected function func($wrapped, $args) {
        preg_match_all($this->getVal(0, $args), $wrapped, $result);
        return $result;
    }
}