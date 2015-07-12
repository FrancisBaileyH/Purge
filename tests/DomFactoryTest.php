<?php




use Katten\Purge\Factory\DomFactory;
use Katten\Purge\Exceptions\UnableToReadInFileException;



class DomFactoryTest extends PHPUnit_Framework_TestCase {
	
	
	
	/**
	 * @expectedException Katten\Purge\Exceptions\UnableToReadInFileException
	 */ 
	public function testDomFactoryExceptionThrown() {
	
		$dom = DomFactory::build('foo');
			
	}
	
	
}
