<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 01.03.16
 * Time: 14:36
 */

namespace EasyCallback\Func;


class Replace extends Base {
    const REQUIRED_PARAM = 2;

    protected function func($wrapped, $args) {
        if ($this->params[1] instanceof \Closure) {
            return preg_replace_callback($this->getVal(0, $args), $this->params[1], $wrapped);
        } elseif ($this->params[1] instanceof \EasyCallback\Wrapper) {
            return preg_replace_callback($this->getVal(0, $args), $this->params[1]->ecClosure(), $wrapped);
        } else {
            return preg_replace($this->getVal(0, $args), $this->params[1], $wrapped);
        }
    }
} 