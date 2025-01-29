<?php

declare(strict_types=1);

namespace Gala\Application;

use Gala\Router\RouterManager;
use Gala\Traits\SystemTrait;

class Application
{
    use SystemTrait;

    protected string $appRoot;

    public function __construct(string $appRoot)
    {
        $this->appRoot = $appRoot;
    }

    public function run(): self
    {
        $this->constants();
        if (version_compare($phpVersion = PHP_VERSION, $coreVersion = Config::GALA_MIN_VERSION, '<')) {
            die(sprintf(
                'You are running PHP %s, but the core framework requires at least PHP %s',
                $phpVersion,
                $coreVersion
            ));
        }
        $this->environment();
        $this->errorHandler();

        return $this;
    }

    private function constants(): void
    {
        defined('DS') or define('DS', '/');
        defined('APP_ROOT') or define('APP_ROOT', $this->appRoot);
        defined('CONFIG_PATH') or define('CONFIG_PATH', APP_ROOT . DS . "Config");
        defined('TEMPLATE_PATH') or define('TEMPLATE_PATH', APP_ROOT . DS . 'App/templates');
        defined('LOG_DIR') or define('LOG_DIR', APP_ROOT . DS . 'tmp/log');
    }

    private function environment()
    {
        ini_set('default_charset', 'UTF-8');
    }

    private function errorHandler(): void
    {
        error_reporting(E_ALL | E_STRICT);
        set_error_handler('Gala\ErrorHandling\ErrorHandling::errorHandler');
        set_exception_handler('Gala\ErrorHandling\ErrorHandling::exceptionHandler');
    }

    public function setSession()
    {
        self::sessionInit(true);
        return $this;
    }

    public function setRouteHandler(string $url): self
    {
        RouterManager::dispatchRoute($url);
        return $this;
    }
}
