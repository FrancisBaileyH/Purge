<?php



namespace Purge;



use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelector;



class PurgeHtmlCrawler extends Crawler {


	public function findFirstInstance($selector) {

		$xPath = CssSelector::toXPath($selector);
		
		$xPath = '(' . $xPath . ')[1]';
		
		return $this->filterXPath($xPath);
	}



}
