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

    /**
     * Factory method which creates the specified cache along with the specified kind of session storage.
     * After creating the session, it will be registered at the session manager.
     *
     * @param string $sessionName
     * @param string $storageString
     * @param array $options
     * @return SessionInterface
     * @throws SessionStorageInvalidArgumentException
     */
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
