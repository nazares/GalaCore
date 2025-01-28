<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

defined('ROOT_PATH') or define('ROOT_PATH', realpath(dirname(__FILE__)));
$autoload = ROOT_PATH . '/vendor/autoload.php';
if (is_file($autoload)) {
    require_once $autoload;
}

use Gala\Application\Application;
use Gala\GlobalManager\GlobalManager;

(new Application(ROOT_PATH))
    ->run()->setSession();

$session = GlobalManager::get('global_session');
$session->set('name', 'nazares');
echo $session->get('name');
