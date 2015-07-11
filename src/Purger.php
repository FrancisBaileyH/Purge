<?php



namespace Purge;


use PHPHtmlParser\Dom;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\RuleSet\DeclarationBlock;



class Purger {


    /**
     * @var $cssBlocks
     *      A hash table of css DeclarationBlock objects
     */ 
    private $cssBlocks;
      
    

    public function __construct(BlockHashTable $hashTable) {
        
        $this->cssBlocks = $hashTable;
    }
    
    
        
    /**
     * Compares the CSS selectors against those found in the DOM object
     * 
     * @param Dom $dom
     * 		A pre-parsed html dom object
     */ 
    public function purge(Dom $dom) {
        
        
        foreach ($this->cssBlocks->getBlockCollection() as $block) {
			
			$decBlock = $block[BlockHashTable::BLOCK_VALUE];
            
            $unusedBlock = $this->filter($decBlock, $dom);
            
            if ($unusedBlock == null) {
				$hash = $this->cssBlocks->hashBlock($decBlock);
				$this->cssBlocks->setUsedFlag($hash, true);
            }
        }
    }
    
    
    
    /**
     * Get all unused css from the cssBlocks hashtable
     * 
     * @return
     * 		An array of DeclarationBlock objects
     */ 
    public function getPurgedCss() {
		
		$unusedCss = [];
		
		foreach ($this->cssBlocks->getBlockCollection() as $block) {
			
			if (!$block[BlockHashTable::IS_USED]) {
				$unusedCss[] = $block[BlockHashTable::BLOCK_VALUE];
			}
		}
		
		return $unusedCss;
	}
    
       
    
    /**
     * Filter out any used CSS on a selector by selector basis
     * 
     * @param DeclarationBlock $block
     *      The css block to check against existence in the dom
     * 
     * @return mixed
     *      Return the DeclarationBlock if no usage is found
     *      otherwise, return null
     */ 
    public function filter(DeclarationBlock $block, Dom $dom) {
        
        $usage = 0;
        
        foreach ($block->getSelector() as $selector) {
            
            $processedSelector = $this->preprocess($selector->sSelector);
            
            $usage = $dom->find($processedSelector);

            if (count($usage) > 0) {
                return null;
            }
        }

        return $block;
    }
    
    
          
    /**
     * Perform any preprocessing to the selector before it is filtered. 
     * 
     * @param string $selector
     *      A string representation of a css selectorf
     * 
     * @return string
     *      A processed selector string
     */ 
    public function preprocess($selector) {

        if (strstr($selector, ':')) {
            $processedSelector = preg_replace('/::?[^ ,:.]+/i', '', $selector);
        }
        else {
            $processedSelector = $selector;
        }
               
        return $processedSelector;
    }
    
}
