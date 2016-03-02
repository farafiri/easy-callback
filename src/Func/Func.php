<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 01.03.16
 * Time: 20:45
 */

namespace EasyCallback\Func;
use EasyCallback\Wrapper;

abstract class Func extends Wrapper {
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
}