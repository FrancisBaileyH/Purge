<?php




namespace Purge\Commands;

use Purge\Controllers\AppController;
use PHPHtmlParser\Dom;
use Sabberworm\CSS\Parser;
use Sabberworm\CSS\Settings;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;



class RunCommand extends Command {
    
    
    
    protected function configure() {
        
        $this
            ->setName('purge:run')
            ->setDescription('Run CSS purger')
            ->addArgument(
                'css',
                InputArgument::REQUIRED,
                'Specify the css file to clean'
            )
            ->addOption(
                'fast',
                null,
                InputOption::VALUE_NONE,
                'If set, multibyte functions will be disabled in the CSS parser '
                .'allowing for faster parsing. This may lead to errors depending'
                .' on the character encoding of the document'
            )
            ->addArgument(
                'html',
                InputArgument::OPTIONAL,
                'Specify an html file to check against'
            );
    }
    
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        
        $mbSupport = true;
        
        $css = file_get_contents($input->getArgument('css'));
        
       
        $output->write('Reading in CSS');
        
       
        if ($input->getOption('fast')) {
            $mbSupport = false;
        }
        
        $output->writeln(' [<info>OK</info>]');

        $output->write('Reading in HTML');

        $dom = new Dom();
        $dom->load(file_get_contents($input->getArgument('html')));
        
        $output->writeln(' [<info>OK</info>]');
        
        $parser = new Parser($css, Settings::create()->withMultibyteSupport($mbSupport));
        
        $output->write('Parsing CSS Document');
        $document = $parser->parse();
        $output->writeln(' [<info>OK</info>]');
        
        $output->write('Purging CSS Document');
        

        
        $purgeController = new AppController($document, $dom, $output);
        $purgeController->run();
    }
    
    
    
    
}

