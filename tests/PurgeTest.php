<?php



use Purge\Purger;
use Purge\Factory\BlockHashTableFactory;
use PHPHtmlParser\Dom;
use Sabberworm\CSS\Parser;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Ruleset\DeclarationBlock;



class PurgeTest extends PHPUnit_Framework_TestCase {
	
	
	protected $dom;
		
	
	protected function setUp() {
		
		$this->dom = new Dom();
		
	}
	

	/**
	 * Perform a basic test to see if filtering works
	 */ 
    public function testFilterSelector() {
               
        $html     = "<div class='test'><div class='all'><p class='text-center'>Text Here</p></div></div>";
        $css      = ".test { position: absolute; } .unused { }";
        $document = new Parser($css);
        $purge    = new Purger(BlockHashTableFactory::build($document->parse()));
        $block    = new DeclarationBlock();
        $block->setSelector('.unused');
           
        
        $purge->purge($this->dom->load($html));             
       
		$this->assertNotNull($purge->getPurgedCss());
    }
    
    
    
    /**
     * Test the filtering of child element selectors
     * acts as more of a test againts the underlying HTML parsing lib
     */ 
    public function testFilterChildSelector() {
        
        $html     = "<div class='test'><div class='all'><p class='text-center'>Text Here</p></div></div>";
        $css      = ".test > .all > p { position: absolute; }";
        $document = new Parser($css);
        $purge    = new Purger(BlockHashTableFactory::build($document->parse()));
        
        $purge->purge($this->dom->load($html));

        $this->assertEmpty($purge->getPurgedCss());
    }
    
    
    
    /**
     * Test that a selector with pseudo classes is still found to be used
     */
    public function testFilterPseudoClass() {
        
        $html     = "<ul class='nav'><li><a class='text-center'>Text Here</a></li></ul>";
        $css      = ".nav > li > a:hover { position: absolute; }";
        $document = new Parser($css);
        $purge    = new Purger(BlockHashTableFactory::build($document->parse()));      
        
        $purge->purge($this->dom->load($html));
        
        $this->assertEmpty($purge->getPurgedCss());
    }
    
    
    
    /**
     * Test that the preprocess function strips out pseudo elements
     * 
     */ 
    public function testPreprocess() {
        
        $document = new Parser('');
        $purge    = new Purger(BlockHashTableFactory::build($document->parse()));
        $css      = 'ul:last-child > li:first-child > p:hover > a'; 
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
        $css = ".test { position: absolute; }";
        
       
        $document = new Parser($css);
        $purge    = new Purger(BlockHashTableFactory::build($document->parse()));
        
        
        $purge->purge($this->dom->load($htmlA));
        $purgedCss = $purge->getPurgedCss();
        
        $this->assertNotNull($purgedCss);
        
        $purge->purge($this->dom->load($htmlB));
        $purgedCss = $purge->getPurgedCss();
        
        $this->assertEmpty($purgedCss);
        
        $purge->purge($this->dom->load($htmlA));
        $purgedCss = $purge->getPurgedCss();
        
        $this->assertEmpty($purgedCss);
		
	}
    
}
