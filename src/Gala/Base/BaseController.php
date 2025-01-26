<?php

declare(strict_types=1);

namespace Gala\Base;

use Gala\Base\Exception\BaseLogicException;

class BaseController
{
    private object $twig;

    public function __construct(protected array $routeParams)
    {
        # code...
        $this->twig = new BaseView();
    }

    public function render(string $template, array $context = [])
    {
        if (null === $this->twig) {
            throw new BaseLogicException('You cannot use the render method if the twig bundle is not available.');
        }
        return $this->twig->getTemplate($template, $context);
    }
}
