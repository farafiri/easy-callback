<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 27.02.16
 * Time: 11:49
 */

namespace EasyCallback;


class CallWrapper extends Wrapper {
    protected $method;
    protected $params;

    public function __construct($wrapped, $method, $params) {
        $this->wrapped = $wrapped;
        $this->method = $method;
        $this->params = $params;
    }

    public function __invoke() {
        $args = func_get_args();
        $wrapped = call_user_func_array($this->wrapped, $args);
        $method = $this->method;
        if ($wrapped === null) {
            throw new NullAccessException("Try to call method: $method on null");
        } elseif (!is_object($wrapped)) {
            throw new Exception ("Try to call method: $method on no object");
        } elseif (method_exists($wrapped, $method) || method_exists($wrapped, '__call')) {
            $params = $this->params;
            foreach($params as &$param) {
                if ($param instanceof Wrapper) {
                    $param = call_user_func_array($param, $args);
                }
            }
            return call_user_func_array([$wrapped, $method], $params);
        } else {
            throw new Exception("Try to call non existing method: $method on object " . get_class($wrapped));
        }
    }
} 