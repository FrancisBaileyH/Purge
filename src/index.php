<?php

include "vendor/autoload.php";

use PHPHtmlParser\Dom;
use Sabberworm\CSS\Parser;
use FrancisBaileyH\Purge;


$dom = new Dom();
$css = new Parser(file_get_contents('http://francisbailey.com/assets/css/style.css'));

$parsedCss = $css->parse();

$dom->load('http://francisbailey.com');



$purge = new Purge($css, $dom);


$unusedCSS = $purge->parse();

var_dump($unusedCSS);


echo "<pre>";


foreach ($parsedCss->getAllDeclarationBlocks() as $block) {
    
    foreach ($block->getSelector() as $selector) {
        
        $strSelector = $selector->sSelector;
        
        if (count($dom->find($strSelector)) > 0) {
            echo "HTML Usage found for: {$strSelector}\n";
        } 
        else {
            echo "HTML Usage not found for: {$strSelector}\n";
        }
        
    }
}

echo "</pre>";
