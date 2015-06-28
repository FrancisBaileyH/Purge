#!/usr/bin/env php
<?php



require '../vendor/autoload.php';

use Purge\Commands\RunCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new RunCommand());
$application->run();


