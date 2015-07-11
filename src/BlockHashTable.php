<?php



namespace Purge;


use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\RuleSet\DeclarationBlock;



class BlockHashTable {


	private $hashTable;
	
	
	const IS_USED = 'isUsed';
	
	
	const BLOCK_VALUE = 'block';
	
	
	
	public function __construct() {
	
		$hashTable = [];
	}
	
	
	/**
	 * Build a hash table of declaration blocks from
	 * a given Document object
	 * 
	 * @param Document $css
	 * 		A parsed css document
	 * 
	 * @return mixed
	 * 		A hash table containing css declartion blocks
	 * 		and flags indicating whether they've been used
	 */ 
	public function build(Document $css) {
		
	
		foreach ($css->getAllDeclarationBlocks() as $block) {
			$hash = $this->hashBlock($block);
			
			$this->hashTable[$hash] = [ self::BLOCK_VALUE => $block, self::IS_USED => false ];
		}
		
		return $this->hashTable;
	}
	
	
	
	/**
	 * Serialize the contents of the Declaration block and hash the result
	 * 
	 * @param DeclarationBlock $block
	 * 		A css declaration block 
	 * 
	 * @return string
	 * 		An md5 hash representing the a Declaration Block
	 */
	public function hashBlock(DeclarationBlock $block) {
		return md5(serialize($block));
	}
	
	
	
	/**
	 * Set the used flag for the given block at a given hash index
	 * 
	 * @param string $hash
	 * 		A hashed representation of a DeclarationBlock
	 * 
	 * @param bool $value
	 * 		The boolean value to set the flag as
	 */
	public function setUsedFlag($hash, $value) {
		
		$this->hashTable[$hash][self::IS_USED] = $value;
	}
	
	
	
	/**
	 * Get the flag value for the block at a given hash index
	 * 
	 * @param string $hash
	 * 		A hashed representation of a DeclarationBlock
	 * 
	 * @return bool
	 * 		The value of the flag
	 */ 
	public function getUsedFlag($hash) {
		
		return $this->hashTable[$hash][self::IS_USED];
	}
	
	
	
	/**
	 * Get the block at a given hash index
	 * 
	 * @param string hash
	 * 		A hashed representation of a DeclarationBlock
	 * 
	 * @return DeclarationBlock
	 * 		The declaration block at index $hash
	 */ 
	public function getBlock($hash) {
		
		return $this->hashTable[$hash][self::BLOCK_VALUE];
	}
	
	
	
	/**
	 * Set a hashTable value
	 * 
	 * @param DeclarationBlock $block
	 * 
	 * @param $value
	 * 		A boolean flag to set IS_USED with
	 */
	public function setBlock(DeclarationBlock $block, $value = false) {
		
		$hash = $this->hashBlock($block);
		
		$this->hashTable[$hash] = [ self::BLOCK_VALUE => $block, self::IS_USED => $value ];
	}
	
	
	
	/**
	 * @return
	 * 		Return a copy of the hashTable
	 */ 
	public function getBlockCollection() {
		
		return $this->hashTable;
	}
	
	
	
	/**
	 * Determine if a block is in the hash table
	 * 
	 * @param DeclarationBlock $block
	 * 		A declaration block to search for
	 * 
	 * @return bool
	 * 		True if block is found
	 */ 
	public function hasBlock(DeclarationBlock $block) {
		
		$hash = $this->hashBlock($block);
		
		return isset($this->hashTable[$hash]);
	}

}
