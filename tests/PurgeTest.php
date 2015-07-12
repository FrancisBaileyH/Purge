<?php



use Purge\Purger;
use Purge\PurgeHtmlCrawler;
use Purge\Factory\BlockHashTableFactory;
use Sabberworm\CSS\Parser;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Ruleset\DeclarationBlock;



class PurgeTest extends PHPUnit_Framework_TestCase {
	
	
	protected $dom;
	protected $html;
	
		
	
	protected function setUp() {
		
		$this->html = "<div class='test'><div class='all'><p class='text-center'>Text Here</p></div></div>";
		$this->dom  = new PurgeHtmlCrawler($this->html);
	}
	

	/**
	 * Perform a basic test to see if filtering works
	 */ 
    public function testFilterSelector() {
               
        $css      = ".test { position: absolute; } .unused { }";
        $document = new Parser($css);
        $purge    = new Purger(BlockHashTableFactory::build($document->parse()));
        $block    = new DeclarationBlock();
        $block->setSelector('.unused');
           
        
        $purge->purge($this->dom);             
       
		$this->assertNotNull($purge->getPurgedCss());
    }
    
    
    
    /**
     * Test the filtering of child element selectors
     * acts as more of a test againts the underlying HTML parsing lib
     */ 
    public function testFilterChildSelector() {
        
        $css      = ".test > .all > p { position: absolute; }";
        $document = new Parser($css);
        $purge    = new Purger(BlockHashTableFactory::build($document->parse()));
        
        $purge->purge($this->dom);

        $this->assertEmpty($purge->getPurgedCss());
    }
    
    
    
    /**
     * Test that a selector with pseudo classes is still found to be used
     */
    public function testFilterPseudoClass() {

        $css      = ".test > .all:hover > p { position: absolute; }";
        $document = new Parser($css);
        $purge    = new Purger(BlockHashTableFactory::build($document->parse()));      
        
        $purge->purge($this->dom);
        
        $this->assertEmpty($purge->getPurgedCss());
    }
    
    
    
    /**
     * Test that the preprocess function strips out pseudo elements
     * 
     */ 
    public function testPreprocess() {
        
        $document = new Parser('');
        $purge    = new Purger(BlockHashTableFactory::build($document->parse()));
        $css      = 'ul:last-child > li:first-child > p::after > a:not(.test)'; 
        $expected = 'ul > li > p > a';
        
        $output = $purge->preprocess($css);
        
        $this->assertEquals($output, $expected);
    }
    
    
    
  	/**
	 * Test that newly parsed html does not overwrite css that is found
	 * to be used in previous html files. 
	 */ 
    public function testUsedCssRemoved() {
		
		$htmlA = "<div>Text Here</div>";
		$htmlB = "<div class='test'><p class='text-center'>Text Here</p></div>";
        $css   = ".test { position: absolute; }";
        
       
        $document = new Parser($css);
        $purge    = new Purger(BlockHashTableFactory::build($document->parse()));
        
        $domA = new PurgeHtmlCrawler($htmlA);
        $domB = new PurgeHtmlCrawler($htmlB);
        
        $purge->purge($domA);
        $purgedCss = $purge->getPurgedCss();
        
        $this->assertNotNull($purgedCss);
        
        $purge->purge($domB);
        $purgedCss = $purge->getPurgedCss();
        
        $this->assertEmpty($purgedCss);
        
        $purge->purge($domA);
        $purgedCss = $purge->getPurgedCss();
        
        $this->assertEmpty($purgedCss);
		
	}
    
}
