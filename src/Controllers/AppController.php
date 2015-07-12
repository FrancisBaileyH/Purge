<?php



namespace Purge\Controllers;


use Purge\Factory\CssDocumentFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class AppController {
    
    
    
    private $input;
    
    
    private $output;
    
    
    private $css;
    
    
    private $html;
    
    
    
    public function __construct(InputInterface $input, OutputInterface $output) {
        
        $this->input = $input;
        $this->output = $output;
    }
    
    
    /**
     * Start up the PurgeManager and output the summary
     */ 
    public function run() {
		
		try {
			$this->setUp();
			
			$purgeManager = new PurgeController($this->css, $this->output);
			$purgeManager->startPurge($this->html);
			
			$this->outputSummary($purgeManager->getPurgeResults());
		} 
		catch ( \Exception $e ) {
			
			$type = get_class($e);
			$this->output->writeln('');
			$this->output->writeln("<error> {$type} </error>");
			$this->output->writeln("<error> {$e->getMessage()} </error> \n");
		}
    }
    
    
    
    /**
     * Create the CSS Document object and build the html 
     * filenames array
     * 
     * This function is just here in the interim as refactoring
     * occurs
     */ 
    public function setUp() {
		
		$this->output->writeln('');
        $this->output->write('Reading in CSS');
		
		$cssFile   = $this->input->getArgument('css');
		$mbSupport = $this->input->getOption('mb-support');
		
		$this->css = CssDocumentFactory::build($cssFile, $mbSupport);
		
		$this->output->writeln(' [<info>OK</info>]'); 
		
		$this->html = [ $this->input->getArgument('html') ];
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
