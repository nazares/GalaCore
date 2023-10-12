<?php

define('ROOT_DIR', realpath(dirname(__FILE__)));
$autoload = ROOT_DIR . '/vendor/autoload.php';
if (is_file($autoload)) {
    require $autoload;
}

use Gala\Application\Application;

$app = new Application(ROOT_DIR);

$app->run();
