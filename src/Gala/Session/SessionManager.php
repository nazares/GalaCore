<?php

declare(strict_types=1);

namespace Gala\Session;

class SessionManager
{
    public function initialize()
    {
        $factory = new SessionFactory();

        return $factory->create('', \Gala\Session\Storage\NativeSessionStorage::class, []);
    }
}
