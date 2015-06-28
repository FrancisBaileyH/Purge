<?php



namespace Purge;


use PHPHtmlParser\Dom;
use Sabberworm\CSS\Parser;
use Sabberworm\CSS\CSSList\Document;



class Purge {



    private $css;
    
    private $dom;


    public function __construct(Document $css, Dom $dom) {
        
        $this->css = $css;
        $this->dom = $dom;
    }
    
    
    public function run() {
        
        $this->parse();
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
