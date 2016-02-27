<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 27.02.16
 * Time: 11:24
 */

namespace EasyCallback;


class PropertyWrapper extends Wrapper {
    protected $property;

    public function __construct($wrapped, $key) {
        $this->wrapped = $wrapped;
        $this->property = $key;
    }

    public function __invoke() {
        $wrapped = call_user_func_array($this->wrapped, func_get_args());
        $property = $this->property;
        if ($wrapped === null) {
            throw new NullAccessException("Try to access property: $property on null");
        } elseif (!is_object($wrapped)) {
            throw new Exception ("Try to read property: $property on no object");
        } elseif (isset($wrapped->$property) || property_exists($wrapped, $property)) {
            /* I have to use both methods
             * nor isset -> property_exists (__get magic method)
             * nor property_exists -> isset (property set to null)
             */
            return $wrapped->$property;
        } else {
            throw new NullAccessException("Try to access non existing property: $property on object");
        }
    }
} 