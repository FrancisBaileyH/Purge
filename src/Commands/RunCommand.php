<?php



namespace Purge\Commands;


use PHPHtmlParser\Dom;
use Sabberworm\CSS\Parser;
use Sabberworm\CSS\Settings;
use Purge\Controllers\AppController;
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
        
        $output->writeln('');
        $output->write('Reading in CSS');
        
        $css = file_get_contents($input->getArgument('css'));
               
       
        if ($input->getOption('fast')) {
            $mbSupport = false;
        }
        
        $parser = new Parser($css, Settings::create()->withMultibyteSupport($mbSupport));
        
        
        $dom = [ "http://www.francisbailey.com",
        "http://www.francisbailey.com",
        "http://www.francisbailey.com",
        "http://www.francisbailey.com",
        "http://www.francisbailey.com",
        "http://www.francisbailey.com",
        "http://www.francisbailey.com",
        "http://www.francisbailey.com",
        "http://www.francisbailey.com",
        "http://www.francisbailey.com",
				 "http://reddit.com" ];
        
        $document = $parser->parse();
        
        $output->writeln(' [<info>OK</info>]');   

        
        $app = new AppController($document, $dom, $output);
        $app->run();
    }
    
    
    
    
}

