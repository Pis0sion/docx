#!/usr/bin/env php
<?php

use Inhere\Console\BuiltIn\PharController;

require "vendor/autoload.php";

$meta = [
    'name' => 'My Console App',
    'version' => '1.0.2',
];

$app = new \Inhere\Console\Application($meta, new \Inhere\Console\IO\Input(), new \Inhere\Console\IO\Output());

$app->command('demo', function (\Inhere\Console\IO\Input $input, \Inhere\Console\IO\Output $output) {
    $cmd = $input->getCommand();
    $output->info("hello,this is a test console : " . $cmd);
});

$app->command(\Pis0sion\Docx\command\GenDocxCommand::class);
$app->controller(PharController::class);

$app->run();