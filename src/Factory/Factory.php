<?php


namespace Purge\Factory;


abstract class Factory {


	public static function build($class) {	
		return new $class();
	}

}
