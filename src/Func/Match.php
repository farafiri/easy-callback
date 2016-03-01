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
       $result = (boolean) preg_match($this->getVal(0, $args), $wrapped);
       return $this->getVal($result ? 2 : 1, $args, $result);
   }
} 