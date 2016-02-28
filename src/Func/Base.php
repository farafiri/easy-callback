<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 28.02.16
 * Time: 18:25
 */

namespace EasyCallback\Func;
use EasyCallback\Wrapper;

abstract class Base extends Wrapper {
    const REQUIRED_PARAM = null;

    protected $params;

    public function __construct($wrapped, $params) {
        $this->params = $params;
        $this->wrapped = $wrapped;
    }

    protected function getVal($i, $args, $default = null) {
        if (isset($this->params[$i])) {
            $param = $this->params[$i];
            if ($param instanceof Wrapper) {
                return call_user_func_array($param, $args);
            } else {
                return $param;
            }
        } else {
            return $default;
        }
    }


    public function __invoke() {
        $args = $args = func_get_args();
        $wrapped = call_user_func_array($this->wrapped, $args);
        return $this->func($wrapped, $args);
    }

    abstract protected function func($wrapped, $args);
} 