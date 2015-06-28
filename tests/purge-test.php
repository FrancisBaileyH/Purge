<?php

include '../vendor/autoload.php';



use FrancisBaileyH\Purge;


class PurgeTest extends PHPUnit_Framework_TestCase {


    public function testFilterUnusedCSS() {
        
        $html = "<div class='test'><div class='all'><p class='text-center'>Text Here</p></div></div>";
        $css = ".test { position: absolute; } .unused { position: relative; }";
        
        $purge = new \Purge($css, [ $html ]);
        
        $purgedCSS = $purge->purge();
             
        $this->assertEquals($purgedCSS, '.unused { position: relative; }');
    }
        
    
    public function testJavascriptSelectorIsFlagged() {
        
        
    }
    
        
    public function testWhiteListSelectorsNotFlagged() {
        
        
    }



}
