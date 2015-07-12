<?php



namespace Katten\Purge\Controllers;


use Katten\Purge\Purger;
use Katten\Purge\Factory\DomFactory;
use Katten\Purge\Factory\BlockHashTableFactory;
use Sabberworm\CSS\CSSList\Document;
use Symfony\Component\Console\Output\OutputInterface;




class PurgeController {



    private $purgedCSS = [];
    
    
    private $output;
    
    
    private $purger;
    
    
    
    public function __construct(Document $css, OutputInterface $output) {
        
        $this->output = $output;
        
        $this->purger = new Purger(BlockHashTableFactory::build($css));
    }
    


    /**
     * Loop through available HTML files and run
     * purge against them
     * 
     * @param array $html
     */ 
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
        
        return $this->purger->getPurgedCss();
    }
        
    

}
