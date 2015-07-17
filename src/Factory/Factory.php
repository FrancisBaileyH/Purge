<?php


namespace Katten\Purge\Factory;


abstract class Factory {


    public static function buildClass($class) {  
        return new $class();
    }

}
