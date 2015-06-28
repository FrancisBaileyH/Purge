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
    
    
    
    public function __construct(Document $css, Dom $dom, OutputInterface $output) {
        
        $this->css= $css;
        $this->dom = $dom;
        $this->output = $output;
    }
    
    
    
    public function run() {
        
        $purge = new Purger($this->css, $this->dom);
        
        $purgedCSS = $purge->parse();
        
        $this->output->writeln(' [<info>OK</info>]');
        $this->output->writeln('');
        $this->output->writeln('<options=bold>Summary of Unused CSS</options=bold>');
        $this->output->writeln('-----------------------------------------------');
        
        foreach ($purgedCSS as $purgedBlock) {
            $this->output->writeln($purgedBlock->__toString());    
        }
    }
    
}
