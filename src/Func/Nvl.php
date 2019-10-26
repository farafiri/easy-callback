<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 10.03.16
 * Time: 22:46
 */

namespace EasyCallback\Func;


class Nvl extends Func {
    const REQUIRED_PARAM = 1;

    public function __invoke() {
        $args = func_get_args();
        foreach($this->params as $i => $_) {
            try {
                $val = $this->getVal($i, $args);
            } catch (\EasyCallback\NullAccessException $e) {
                continue;
            }
            if ($val !== null) {
                return $val;
            }
        }

        return null;
    }
} 