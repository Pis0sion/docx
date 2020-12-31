#!/usr/bin/env php
<?php

use Inhere\Console\Application;
use Inhere\Console\BuiltIn\PharController;
use Inhere\Console\IO\Input;
use Inhere\Console\IO\Output;
use Pis0sion\Docx\command\GenDocxCommand;

require "vendor/autoload.php";

$meta = [
    'name' => 'My Convert Json To Docx App',
    'version' => '1.0.6',
];

$app = new Application($meta, new Input(), new Output());

$app->command('demo', function (Input $input, Output $output) {
    $cmd = $input->getCommand();
    $output->info("v1.0.6 fixed wps json format : " . $cmd);
});

$app->command(GenDocxCommand::class);
$app->controller(PharController::class);

$app->run();