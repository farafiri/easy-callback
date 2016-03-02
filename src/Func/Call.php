<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 01.03.16
 * Time: 20:41
 */

namespace EasyCallback\Func;


class Call extends Func {
    const REQUIRED_PARAM = 0;

    public function __invoke() {
        $args = func_get_args();
        $params = array();
        foreach($this->params as $i => $_) {
            $params[$i] = $this->getVal($i, $args);
        }
        return call_user_func_array($this->wrapped, $params);
    }
} 