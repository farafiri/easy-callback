<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 29.02.16
 * Time: 19:42
 */

namespace EasyCallback\Func;


class _Not extends Base {
    const REQUIRED_PARAM = 0;

    protected function func($wrapped, $args) {
        $result = !$wrapped;
        return $this->getVal($result ? 0 : 1, $args, $result);
    }
} 