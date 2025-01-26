<?php

declare(strict_types=1);

namespace Gala\Traits;

use Gala\Base\Exception\BaseLogicException;
use Gala\GlobalManager\GlobalManager;
use Gala\Session\SessionManager;

trait SystemTrait
{
    public static function sessionInit(bool $useSessionGlobal = false)
    {
        $session = SessionManager::initialize();
        if (!$session) {
            throw new BaseLogicException('Please enable session within your session.yaml configuration file');
        } elseif ($useSessionGlobal === true) {
            GlobalManager::set('global_session', $session);
        } else {
            return $session;
        }
    }
}
