<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 29.02.16
 * Time: 17:55
 */

namespace EasyCallback\Func;


class _If extends Base {
    const REQUIRED_PARAM = 0;

    protected function func($wrapped, $args) {
        $result = (boolean) $wrapped;
        return $this->getVal($result ? 0 : 1, $args, $result);
    }
} 