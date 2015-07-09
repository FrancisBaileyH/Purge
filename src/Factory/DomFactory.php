<?php



namespace Purge\Factory;


use PHPHtmlParser\Dom;
use Purge\Exceptions\UnableToReadInFileException;


class DomFactory {


    public static function buildDom($file) {
        
        $dom = new Dom();
        
        if (filter_var($file, FILTER_VALIDATE_URL)) {
            $file = urlencode($file);
        }
        
        $html = @file_get_contents($file);
        
        if (!$html) {
            throw new UnableToReadInFileException('Unable to load file' . $file);
        }
        
        return $dom->load($html);
    }

}
