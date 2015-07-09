<?php



namespace Purge\Controllers;



use Purge\Purger;
use Purge\Factory\DomFactory;
use PHPHtmlParser\Dom;
use Sabberworm\CSS\CSSList\Document;
use Symfony\Component\Console\Output\OutputInterface;



class PurgeContoller {



	private $purgedCSS = [];
	
	
	private $output;
	
	
	private $purger;
	
	
	
	public function __construct(Document $css, OutputInterface $output) {
		
		$this->output = $output;
		$this->purger = new Purger($css);
	}
	


	public function startPurge(array $html) {
		
		foreach ($html as $value) {
			
			
			$dom = DomFactory::buildDom($value);
			
			$unusedCSS = $this->purger->purge($dom);
		}	
	}
	

}
