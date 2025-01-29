<?php

declare(strict_types=1);

namespace Gala\Base;

use BadMethodCallException;
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

    public function __call($name, $arguments)
    {
        $method = $name . 'Action';
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func([$this, $method], $arguments);
                $this->after();
            }
        } else {
            throw new BadMethodCallException('method does not exist');
        }
    }

    protected function before()
    {
        //
    }

    protected function after()
    {
        //
    }
}
