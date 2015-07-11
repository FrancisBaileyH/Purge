<?php



namespace Purge\Factory;


use Purge\PurgeHtmlCrawler;
use Purge\Exceptions\UnableToReadInFileException;


class DomFactory extends Factory {


	/**
	 * Build a preloaded Dom object
	 * 
	 * @param string $file
	 * 		A local file path or remote url
	 * 
	 * @return
	 * 		A Dom object with the HTML parsed
	 */ 
    public static function build($file) {
        
               
        $html = @file_get_contents($file);
        
        if (!$html) {
            throw new UnableToReadInFileException('Unable to load file: ' . urldecode($file));
        }
        
        $dom = new PurgeHtmlCrawler($html);
        
        return $dom;
    }

}
