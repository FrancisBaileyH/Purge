<?php



namespace Purge\Controllers;


use Sabberworm\CSS\CSSList\Document;
use Symfony\Component\Console\Output\OutputInterface;


class AppController {
    
    
    
    private $css;
    
    
    private $html;
    
    
    private $output;
    
    
    
    public function __construct(Document $css, array $html, OutputInterface $output) {
        
        $this->css= $css;
        $this->html = $html;
        $this->output = $output;
    }
    
    
    /**
     * Start up the PurgeManager and output the summary
     */ 
    public function run() {
		
		try {
			$purgeManager = new PurgeController($this->css, $this->output);
			$purgeManager->startPurge($this->html);
			
			$this->outputSummary($purgeManager->getPurgeResults());
		} 
		catch ( \Exception $e ) {
			$this->output->writeln('');
			$this->output->writeln("[<fg=red>Error</fg=red>] {$e->getMessage()} \n");
		}
    }
    
    
    
    public function handleArgs(InputInterface $input) {
		
		
		
		
		
	}
    
    
      
    /*
     * Write the summary to the console
     * 
     * @param array $purgedCSS
     *      An array of DeclarationBlocks
     */
    public function outputSummary($purgedCSS) {
        
        $this->output->writeln('<options=bold>Summary of Unused CSS</options=bold>');
        $this->output->writeln('-----------------------------------------------');
        
        foreach ($purgedCSS as $purgedBlock) {
            $this->output->writeln($purgedBlock->__toString());    
        }   
        
        $this->output->writeln('');     
    }
    
}
