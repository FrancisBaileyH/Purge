<?php

include "../vendor/autoload.php";

use PHPHtmlParser\Dom;
use Sabberworm\CSS\Parser;
use Purge\Purger;


$dom = new Dom();
$css = new Parser(file_get_contents('http://francisbailey.com/assets/css/style.css'));

$parsedCss = $css->parse();

$dom->load('http://francisbailey.com');



$purge = new Purger($parsedCss, $dom);


$unusedCSS = $purge->parse();



echo "<pre>";


foreach ($unusedCSS as $block) {
    
    echo $block . "\n";
}


echo "</pre>";
