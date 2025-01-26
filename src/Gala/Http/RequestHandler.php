<?php

declare(strict_types=1);

namespace Gala\Http;

use Symfony\Component\HttpFoundation\Request;

class RequestHandler
{
    public function handler(): Request
    {
        if (!isset($request)) {
            $request = new Request();
        }

        if ($request) {
            $create = $request->createFromGlobals();
            if ($create) {
                return $create;
            }
        }
        return false;
    }
}
