<?php



namespace Purge;


use PHPHtmlParser\Dom;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\RuleSet\DeclarationBlock;



class Purger {


    /**
     * @var $css
     *      A CSS Document object
     */ 
    private $css;
    
    
    /**
     * @var $unusedCssStorage
     * 		A hash table of unused css DeclartionBlock objects
     */ 
    private $unusedCssStorage = [];
    
    

    public function __construct(Document $css) {
        
        $this->css = $css;
    }
    
        
    /**
     * Compares the CSS selectors against those found in the DOM object
     * 
     * @return array
     *      An array of unused CSS selector objects
     */ 
    public function purge(Dom $dom) {
        
        
        foreach ($this->css->getAllDeclarationBlocks() as $block) {
            
            $unusedBlock = $this->filter($block, $dom);
            
            if ($unusedBlock != null) {
				$hash = $this->hashDeclarationBlock($unusedBlock);
                $this->unusedCssStorage[$hash] = $unusedBlock;
            }
        }
        
        return $this->unusedCssStorage;
    }
    
    
    /**
     * Filter out any used CSS on a selector by selector basis
     * 
     * @param DeclarationBlock $block
     *      A DeclarationBlock object
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
				
				$this->removeUsedCss($block);
                return null;
            }
        }

        return $block;
    }
    
    
    /**
     * Check to see if the declaration block exists in storage already
     * if it does, remove it
     * 
     * @param DeclarationBlcok $block
     * 		A css block
     */
    public function removeUsedCss(DeclarationBlock $block) {
		
		$hash = $this->hashDeclarationBlock($block);
		
		if (isset($this->unusedCssStorage[$hash])) {
			unset($this->unusedCssStorage[$hash]);
		}
	}
	
	
	/**
	 * Hash the contents of the declaration block 
	 * 
	 * @param DeclarationBlock $block
	 * 		A css block 
	 * 
	 * @return
	 * 		An md5 representation of the css block
	 */ 
	public function hashDeclarationBlock(DeclarationBlock $block) {
		
		return md5(serialize($block));
	}
    
        
    /**
     * Perform any preprocessing to the selector before it is filtered. 
     * 
     * @TODO
     * - remove multiple instances of psuedo classes ( li:first-child > a:hover > span:first-child )
     * 
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
        echo $processedSelector . '\n';
               
        return $processedSelector;
    }
    
}
