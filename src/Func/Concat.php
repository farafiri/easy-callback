<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 01.03.16
 * Time: 13:53
 */

namespace EasyCallback\Func;


class Concat extends Base {
    const REQUIRED_PARAM = 1;

    protected function func($wrapped, $args) {
        $value = $wrapped;
        foreach($this->params as $i => $param) {
            $param = $this->getVal($i, $args);
            $value .= $param;
        }

        return $value;
    }
} 