<?php

declare(strict_types=1);

namespace App\Controller;

use Gala\Base\BaseController;

class HomeController extends BaseController
{
    public function __construct($routeParams)
    {
        parent::__construct($routeParams);
    }

    public static function indexAction()
    {
        echo __CLASS__;
    }

    protected function before()
    {
        echo "this is before action </br>";
    }

    protected function after()
    {
        echo "</br>this is after action </br>";
    }
}
