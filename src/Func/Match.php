<?php
/**
 * Created by PhpStorm.
 * User: Rafał
 * Date: 28.02.16
 * Time: 18:25
 */

namespace EasyCallback\Func;


class Match extends Base {
   const REQUIRED_PARAM = 1;

   protected function func($wrapped, $args) {
       return (boolean) preg_match($this->getVal(0, $args), $wrapped);
   }
} 