<?php



use Katten\Purge\PurgeHtmlCrawler;



class PurgeHtmlCrawlerTest extends PHPUnit_Framework_TestCase {




    /**
     * @expectedException Symfony\Component\CssSelector\Exception\ParseException
     */ 
    public function testExceptionThrown() {
        
        $html = '<div>Test</div>';
        
        $crawler = new PurgeHtmlCrawler($html);
        $crawler->findFirstInstance('.invalid^css');
    }
}
