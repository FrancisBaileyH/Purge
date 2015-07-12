<?php


use Katten\Purge\Factory\BlockHashTableFactory;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Parser;



class BlockHashTableFactoryTest extends PHPUnit_Framework_TestCase {


    public function testBuild() {
        
        $css =  '.test { margin: 0 auto }';
        
        $parser = new Parser($css);
        $document = $parser->parse();
        
        $hashTable = BlockHashTableFactory::build($document);
        
        $class = 'Katten\Purge\BlockHashTable';
        
        $this->assertTrue($hashTable instanceof $class);
    }



}
