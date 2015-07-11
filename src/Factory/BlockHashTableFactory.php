<?php



namespace Purge\Factory;


use Purge\BlockHashTable;
use Sabberworm\CSS\CSSList\Document;



class BlockHashTableFactory extends Factory {


	public static function build(Document $css) {
	
		$hashTable = new BlockHashTable();
		
		$hashTable->build($css);
		
		return $hashTable;
	}
	
}
