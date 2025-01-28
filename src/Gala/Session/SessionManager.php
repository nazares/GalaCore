<?php

declare(strict_types=1);

namespace Gala\Session;

use Gala\Yaml\YamlConfig;

class SessionManager
{
    public static function initialize()
    {
        $factory = new SessionFactory();

        return $factory->create('galacore', \Gala\Session\Storage\NativeSessionStorage::class, YamlConfig::file('session'));
    }
}
