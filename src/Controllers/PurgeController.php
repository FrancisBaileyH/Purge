<?php



namespace Purge\Controllers;


use Purge\Purger;
use Purge\BlockHashTable;
use Purge\Factory\DomFactory;
use PHPHtmlParser\Dom;
use Sabberworm\CSS\CSSList\Document;
use Symfony\Component\Console\Output\OutputInterface;




class PurgeController {



	private $purgedCSS = [];
	
	
	private $output;
	
	
	private $purger;
	
	
	
	public function __construct(Document $css, OutputInterface $output) {
		
		$this->output = $output;
		
		$this->purger = new Purger(new BlockHashTable($css));
	}
	


	public function startPurge(array $html) {
		
		$i = 1;
		$total = count($html);
			
		
		foreach ($html as $value) {
			$this->output->write("Loading HTML file ($i/$total)");
			$dom = DomFactory::build($value);
			$this->output->writeln(" [<info>OK</info>]");
			
			$this->output->write("Purging CSS from HTML file ($i/$total)");
			$this->purger->purge($dom);
			$this->output->writeln(" [<info>OK</info>]");
			
			$i++;
		}
		
		$this->output->writeln("Purge Successfully Completed!\n");
	}
	
	
	
	public function getPurgeResults() {
		
		return $this->purger->getStoredCss();
	}
		
	

}
