<?php




use Purge\Purger;
use Sabberworm\CSS\Parser;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Ruleset\DeclarationBlock;
use PHPHtmlParser\Dom;


class PurgeTest extends PHPUnit_Framework_TestCase {


    public function testFilterSelector() {
               
        $html = "<div class='test'><div class='all'><p class='text-center'>Text Here</p></div></div>";
        $css = ".test { position: absolute; } .unused { position: relative; }";
        
        
        $document = new Parser($css);
        $dom = new Dom();
      
        
        $purge = new Purger($document->parse(), $dom->load($html));
        
        $purgedCSS = $purge->parse();
        
        $block = new DeclarationBlock();
        $block->setSelector('.unused');
        
        
        $purgedBlock = $purgedCSS[0]->getSelector();
        
             
        $this->assertEquals($purgedBlock, $block->getSelector());
    }
    
    
    public function testFilterChildSelector() {
        
        $html = "<div class='test'><div class='all'><p class='text-center'>Text Here</p></div></div>";
        $css = ".test > .all > p";
        
        
        $document = new Parser($css);
        $dom = new Dom();
      
        
        $purge = new Purger($document->parse(), $dom->load($html));
        
        $purgedCSS = $purge->parse();
        

        $this->assertEmpty($purgedCSS);
    }
    
    
    public function testFilterPseudoClass() {
        
        $html = "<div class='test'><p class='text-center'>Text Here</p></div>";
        $css = ".test > p:first-child";
        
        
        $document = new Parser($css);
        $dom = new Dom();
      
        
        $purge = new Purger($document->parse(), $dom->load($html));
        
        $purgedCSS = $purge->parse();
        
        $this->assertEmpty($purgedCSS);
    }
}
