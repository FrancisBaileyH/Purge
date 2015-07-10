<?php



namespace Purge\Factory;


use PHPHtmlParser\Dom;
use Purge\Exceptions\UnableToReadInFileException;


class DomFactory {


	/**
	 * Build a preloaded Dom object
	 * 
	 * @param string $file
	 * 		A local file path or remote url
	 * 
	 * @return
	 * 		A Dom object with the HTML parsed
	 */ 
    public static function buildDom($file) {
        
        $dom = new Dom();
        
        $html = @file_get_contents($file);
        
        if (!$html) {
            throw new UnableToReadInFileException('Unable to load file: ' . urldecode($file));
        }
        
        return $dom->load($html);
    }

}
