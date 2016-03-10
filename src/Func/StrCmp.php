<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 01.03.16
 * Time: 23:37
 */

namespace EasyCallback\Func;


class StrCmp extends Func {
    const REQUIRED_PARAM = 0;

    protected $fn;
    protected $order;

    public function __construct($wrapped, $params) {
        $this->order = empty($params[0]) ? 1 : -1;
        $case = !empty($params[1]);
        $nat = !empty($params[2]);
        $this->fn = $case ? ($nat ? 'strnatcasecmp' : 'strcasecmp') : ($nat ? 'strnatcmp' : 'strcmp');
        parent::__construct($wrapped, $params);
    }

    public function __invoke($value1, $value2) {
        $wrapped = $this->wrapped;
        $fn = $this->fn;
        return $fn($wrapped($value1), $wrapped($value2)) * $this->order;
    }
} 