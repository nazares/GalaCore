<?php

declare(strict_types=1);

namespace App\Controller;

use Gala\Base\BaseController;

class SecurityController extends BaseController
{
    public function __construct($routeParams)
    {
        parent::__construct($routeParams);
    }

    public function loginAction()
    {
        echo "Login";
    }
}