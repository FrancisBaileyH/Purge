<?php



use Purge\BlockHashTable;
use Sabberworm\CSS\Parser;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Rule\Rule;
use Sabberworm\CSS\RuleSet\DeclarationBlock;
use Sabberworm\CSS\Value\RuleValueList;




class BlockHashTableTest extends PHPUnit_Framework_TestCase {


	protected $hashTable;
	
	
	protected $parser;
	
	
	protected $css;
	
	
	protected $document;
	
	
	protected $blockArray;


	protected function setUp() {
		
		$this->css = '.test { position: absolute; } .unused { }';
		
		$this->parser = new Parser($this->css);
		
		$this->hashTable = new BlockHashTable();
		
		$this->document = $this->parser->parse();
		
		$this->hashTable->build($this->document);
		
		$this->blockArray = $this->document->getAllDeclarationBlocks();
	}


	public function testBuildMethod() {
		
		$blockArray = $this->document->getAllDeclarationBlocks();
		$hashTableCopy = $this->hashTable->getBlockCollection();
	
		$this->assertEquals(count($hashTableCopy), 2);		
		
		foreach ($hashTableCopy as $block) {
			
			$this->assertEquals($block[BlockHashTable::IS_USED], false);
		}
	}
	
	
	public function testHashMethod() {
		
		$block = $this->blockArray[1];
		$hashedBlock = $this->hashTable->hashBlock($block);

		$newBlock = new DeclarationBlock();		
		$newBlock->setSelector('.unused');
		
		$hashedNewBlock = $this->hashTable->hashBlock($newBlock);
		
		$this->assertEquals($hashedNewBlock, $hashedBlock);
	}
	
	
	public function testSetUsedFlag() {
		
		$block = $this->blockArray[0];
		$hash  = $this->hashTable->hashBlock($block);
		
		$this->hashTable->setUsedFlag($hash, true);
		
		$this->assertTrue($this->hashTable->getUsedFlag($hash));
	}
	
	
	public function testHasBlock() {
		
		$this->assertFalse($this->hashTable->hasBlock(new DeclarationBlock()));
		
		$block = new DeclarationBlock();
		$block->setSelector('.new-class');
		
		$this->hashTable->setBlock($block);
		
		$this->assertTrue($this->hashTable->hasBlock($block));
	}


	public function testSetBlock() {
		
		$block = new DeclarationBlock();
		$block->setSelector('.fake-class');
		
		$hash = $this->hashTable->hashBlock($block);
		
		$this->hashTable->setBlock($block, true);
		
		$this->assertTrue($this->hashTable->getUsedFlag($hash));
		
		$blockCopy = $this->hashTable->getBlock($hash);
		
		$this->assertEquals($blockCopy, $block);
	}


}

