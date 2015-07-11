<?php




use Purge\Factory\DomFactory;
use Purge\Exceptions\UnableToReadInFileException;



class DomFactoryTest extends PHPUnit_Framework_TestCase {
	
	
	
	/**
	 * Test that loading a non-existant file results
	 * in an exception being thrown
	 */ 
	public function testDomFactoryExceptionThrown() {

		try {
		
			$dom = DomFactory::build('foo');
			
			$this->fail();
		}
		catch (UnableToReadInFileException $e) {
			
		}
	}
	
	
}
