<?php



use Purge\Purger;
use PHPHtmlParser\Dom;
use Sabberworm\CSS\Parser;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Ruleset\DeclarationBlock;



class PurgeTest extends PHPUnit_Framework_TestCase {
	


    public function testFilterSelector() {
               
        $html = "<div class='test'><div class='all'><p class='text-center'>Text Here</p></div></div>";
        $css = ".test { position: absolute; } .unused { }";
        
        
        $dom 	  = new Dom();
        $document = new Parser($css);
        $purge    = new Purger($document->parse());
        $block    = new DeclarationBlock();
        $block->setSelector('.unused');
        
        $hashedBlock = $purge->hashDeclarationBlock($block);
   
        
        $purgedCss = $purge->purge($dom->load($html));             
       
		$this->assertEquals(isset($purgedCss[$hashedBlock]), true);
    }
    
    
    public function testFilterChildSelector() {
        
        $html = "<div class='test'><div class='all'><p class='text-center'>Text Here</p></div></div>";
        $css = ".test > .all > p { position: absolute; }";
        
        
        $document = new Parser($css);
        $dom = new Dom();
      
        
        $purge = new Purger($document->parse());
        
        $purgedCss = $purge->purge($dom->load($html));
        

        $this->assertEmpty($purgedCss);
    }
    
    
    public function testFilterPseudoClass() {
        
        $html = "<ul class='nav'><li><a class='text-center'>Text Here</a></li></ul>";
        $css = ".nav > li > a:hover { position: absolute; }";
        
        
        $document = new Parser($css);
        $dom = new Dom();
      
      
        $purge = new Purger($document->parse());

        
        $purgedCss = $purge->purge($dom->load($html));
        
        $this->assertEmpty($purgedCss);
    }
    
    
    public function testPreprocess() {
        
        $document = new Parser('');
        $dom = new Dom();
        
        $purge = new Purger($document->parse());
        
        
        $css = 'ul:last-child > li:first-child > p:hover > a';
        
        $expected = 'ul > li > p > a';
        
        $output = $purge->preprocess($css);
        
        $this->assertEquals($output, $expected);
    }
    
    
    public function testUsedCssRemoved() {
		
		$htmlA = "<div>Text Here</div>";
		$htmlB = "<div class='test'><p class='text-center'>Text Here</p></div>";
        $css = ".test { position: absolute; }";
        
        
        $domA 	  = new Dom();
        $domB 	  = new Dom();
        $document = new Parser($css);
        $purge    = new Purger($document->parse());
        
        
        $purgedCss = $purge->purge($domA->load($htmlA));
        
        $this->assertNotEmpty($purgedCss);
        
        $purgedCss = $purge->purge($domB->load($htmlB));
        
        $this->assertEmpty($purgedCss);
        
        $purgedCss = $purge->purge($domA->load($htmlA));
        
        $this->assertEmpty($purgedCss);
		
	}
    
    
    
    
}
