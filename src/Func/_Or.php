<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 29.02.16
 * Time: 19:43
 */

namespace EasyCallback\Func;


class _Or extends Base {
    const REQUIRED_PARAM = 1;

    protected function func($wrapped, $args) {
        $value = $wrapped;
        $i = 0;

        while(!$value && isset($this->params[$i])) {
            $value = $this->getVal($i++, $args);
        }

        return $value;
    }
} 