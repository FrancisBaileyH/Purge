<?php



namespace Katten\Purge\Factory;


use Sabberworm\CSS\Parser;
use Sabberworm\CSS\Settings;
use Katten\Purge\Exceptions\UnableToReadInFileException;


class CssDocumentFactory extends FileFactory {


	/**
	 * Build a CSS Document object from a file 
	 * 
	 * @param string $file
	 * 		The file or url to load the css from
	 * 
	 * @param bool $mbSupport
	 * 		Turn multi byte support on or off 
	 * 
	 * @return Document
	 * 		A parsed CSS document object
	 */ 
	public static function build($file, $mbSupport = false) {
	
		$css = parent::buildFromFile($file);
		
		$settings = Settings::create()->withMultibyteSupport($mbSupport);
		$settings = $settings->beStrict();
				
		$parser = new Parser($css, $settings);
		
		
		return $parser->parse();
	}


}
