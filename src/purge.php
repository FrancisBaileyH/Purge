<?php



namespace FrancisBaileyH\Purge;


use PHPHtmlParser\Dom;
use Sabberworm\CSS\Parser;



class Purge {



    private $css;
    
    private $html;


    public function __construct($css CSSList, $htmlFile DOM) {
        
        $this->css = $css;
        $this->html = $html;
    }
    
    
    public function run() {
        
        
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
        
        return $unusedCSS;
    }
    
    
    public function filter($block) {
        
        $selector = $block->getSelector();
        $usage = $this->html->find($selector->sSelector);
        
        
        if (count($usage) > 0) {
            return $selector;
        }
        else {
            return null;
        }
    }





}
