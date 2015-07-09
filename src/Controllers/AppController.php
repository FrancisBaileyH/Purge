<?php


namespace Purge\Controllers;


use Purge\Purger;
use PHPHtmlParser\Dom;
use Sabberworm\CSS\CSSList\Document;
use Symfony\Component\Console\Output\OutputInterface;


class AppController {
    
    
    
    private $css;
    
    
    private $dom;
    
    
    private $output;
    
    
    
    public function __construct(Document $css, array $html, OutputInterface $output) {
        
        $this->css= $css;
        $this->dom = $dom;
        $this->output = $output;
    }
    
    
    /**
     * Start up the PurgeManager and output the summary
     */ 
    public function run() {
        
        $purge = new Purger($this->css, $this->dom);
        
        $purgedCSS = $purge->parse();
        
        $this->output->writeln(' [<info>OK</info>]');
        $this->output->writeln('');
        
        return $this->outputSummary($purgedCSS);
    }
    
      
    /*
     * Write the summary to the console
     * 
     * @param array $purgedCSS
     *      An array of DeclartionBlocks
     */
    public function outputSummary($purgedCSS) {
        
        $this->output->writeln('<options=bold>Summary of Unused CSS</options=bold>');
        $this->output->writeln('-----------------------------------------------');
        
        foreach ($purgedCSS as $purgedBlock) {
            $this->output->writeln($purgedBlock->__toString());    
        }        
    }
    
}
