<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 27.02.16
 * Time: 10:45
 */

namespace EasyCallback;

function f($obj = 1, $type = null) {
    if ($obj instanceof Wrapper) {
        return $obj;
    }
    return new HeadWrapper($obj, $type);
}