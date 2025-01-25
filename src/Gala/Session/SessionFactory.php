<?php

declare(strict_types=1);

namespace Gala\Session;

use Gala\Session\Exception\SessionStorageInvalidArgumentException;
use Gala\Session\Storage\SessionStorageInterface;

class SessionFactory
{
    public function __construct()
    {
        # code ...
    }

    public function create(string $sessionName, string $storageString, array $options = []): SessionInterface
    {
        $storageObject = new $storageString($options);
        $errorMessage = sprintf('%s is not a valid session storage object', $storageString);
        if (!$storageObject instanceof SessionStorageInterface) {
            throw new SessionStorageInvalidArgumentException($errorMessage);
        }

        return new Session($sessionName, $storageObject);
    }
}
