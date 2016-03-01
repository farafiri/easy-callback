<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 01.03.16
 * Time: 12:03
 */

namespace EasyCallback\Func;


class _And extends Base {
    const REQUIRED_PARAM = 1;

    protected function func($wrapped, $args) {
        $value = $wrapped;
        $i = 0;

        while($value && isset($this->params[$i])) {
            $value = $this->getVal($i++, $args);
        }

        return $value;
    }
} 