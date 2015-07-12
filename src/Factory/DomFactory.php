<?php



namespace Katten\Purge\Factory;


use Katten\Purge\PurgeHtmlCrawler;
use Katten\Purge\Exceptions\UnableToReadInFileException;


class DomFactory extends FileFactory {


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
        
		$html = parent::buildFromFile($file);
        
        $dom = new PurgeHtmlCrawler($html);
        
        return $dom;
    }

}
