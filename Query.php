<?php
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Queries\ServicesQueryCommand;
use Queries\SummaryQueryCommand;


$app = new Application();
$app->add(new ServicesQueryCommand());
$app->add(new SummaryQueryCommand());
$app->run();

?>