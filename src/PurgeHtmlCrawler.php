<?php



namespace Katten\Purge;



use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelector;
use Symfony\Component\CssSelector\Exception\ParseException;



class PurgeHtmlCrawler extends Crawler {


	/**
	 * Modify the xPath query provided by CssSelector to 
	 * find the first instance of a given element, this reduces
	 * search times compared to filter which returns a whole collection
	 * 
	 * @param string $selector
	 * 		A css selector
	 * 
	 * @return Crawler
	 * 		The first instance of selected element
	 */ 
	public function findFirstInstance($selector) {

		try {
	
			$xPath = CssSelector::toXPath($selector);
			$xPath = '(' . $xPath . ')[1]';
		
			return $this->filterXPath($xPath);
		}
		catch (ParseException $e) {
			
			throw new ParseException("{$e->getMessage()} Invalid Selector: $selector");
		}
	}

}
