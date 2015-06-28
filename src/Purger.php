<?php



namespace Purge;


use PHPHtmlParser\Dom;
use Sabberworm\CSS\CSSList\Document;



class Purger {


    /**
     * @var $css
     *      A CSS Document object
     */ 
    private $css;
    
    
    /**
     * @var $dom
     *      An HTML Dom object
     */ 
    private $dom;



    public function __construct(Document $css, Dom $dom) {
        
        $this->css = $css;
        $this->dom = $dom;
    }
    
    
        
    /**
     * Compares the CSS selectors against those found in the DOM object
     * 
     * @return 
     *      An array of unused CSS selector objects
     */ 
    public function parse() {
        
        $css = [];
        
        foreach ($this->css->getAllDeclarationBlocks() as $block) {
            
            $unusedCSS = $this->filter($block);
            
            if ($unusedCSS != null) {
                $css[] = $unusedCSS;
            }
        }
        
        return $css;
    }
    
    
    /**
     * Filter out any used CSS on a selector by selector basis
     * 
     * @param $block
     *      A Sabberworm\CSS\RuleSet\DeclarationBlock object
     * 
     * @return mixed
     *      Return the DeclarationBlock if no usage is found
     *      otherwise, return null
     */ 
    public function filter($block) {
        
        $usage = 0;
        
        foreach ($block->getSelector() as $selector) {
            
            $processedSelector = $this->preprocess($selector->sSelector);
            
            $usage = $this->dom->find($processedSelector);

            if (count($usage) > 0) {
                return null;
            }
        }

        return $block;
    }
    
    
    /**
     * Perform any preprocessing to the selector before it is filtered. 
     * 
     * @param $selector
     *      A string representation of a css selector
     * 
     * @return string
     *      A processed selector string
     */ 
    public function preprocess($selector) {

        if (strstr($selector, ':')) {
            $processedSelector = substr($selector, 0, strpos($selector, ":"));
        }
        else {
            $processedSelector = $selector;
        }
               
        return $processedSelector;
    }

}
