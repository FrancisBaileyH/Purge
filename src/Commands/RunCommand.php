<?php



namespace Katten\Purge\Commands;


use Sabberworm\CSS\Parser;
use Sabberworm\CSS\Settings;
use Katten\Purge\Controllers\AppController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;



class RunCommand extends Command {
    
    
    
    protected function configure() {
        
        $this
            ->setName('purge:run')
            ->setDescription('Purge unused css from specified css files')
            ->addArgument(
                'css',
                InputArgument::REQUIRED,
                'Specify a css file to purge'
            )
            ->addOption(
                'mb-support',
                null,
                InputOption::VALUE_NONE,
                'If set, multibyte functions will be enabled in the CSS parser '
                .'this typically causes slower parse times and is disabled by default'
            )
            ->addArgument(
                'html',
                InputArgument::REQUIRED,
                'Specify an html file to check against'
            )
            ->addArgument(
				'output-file',
				InputArgument::REQUIRED,
				'Specify a file to write the output to'
			)
            ->addOption(
				'sitemap',
				null,
				InputOption::VALUE_NONE,
				'If set, Purge will read in a sitemap file and run against the links found within it'
			);
    }
    
    
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        
        $app = new AppController($input, $output);
        $app->run();
    }
    
    
    
    
}

