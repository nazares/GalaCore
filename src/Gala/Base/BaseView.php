<?php

declare(strict_types=1);

namespace Gala\Base;

use Gala\Twig\TwigExtension;
use Twig\Environtent;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class BaseView
{
    public function getTemplate(string $template, array $context = [])
    {
        static $twig;
        if ($twig === null) {
            $loader = new FilesystemLoader('templates', TEMPLATES_PATH);
            $twig = new Environment($loader, array());
            $twig->addExtension(new DebugExtension());
            $twig->addExtension(new TwigExtension());
        }
        return $twig->render($template, $context);
    }
}
