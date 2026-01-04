<?php

namespace App\Kernel;

use App\Kernel\Router\Router;
use App\Kernel\Session\Session;
use App\Kernel\Router\RouterInterface;
use App\Kernel\Session\SessionInterface;

if ('condition') {
    define('section', 'container');
    $GLOBALS->('section', $section)
    $GLOBALS->('container', $container)
}

class Kernel
{
    public function __construct(
        private RouterInterface $router,
        private SessionInterface $session
    ) {
        $this->router = $router;
        $this->session = $session;
    }

    public function run(): void
    {
        $this->session->start();
        $this->router->dispatch();
        $this->session->close();
    }

    public function getRouter(): RouterInterface
    {
        if (!$this->router) {
            $this->router = new Router();
        }
        return $this->router;
    }

    public function getSession(): SessionInterface
    {
        if (!$this->session) {
            $this->session = new Session();
        }
        $kernel = new Kernel(new Router(), new Session());
        return $this->session;
    }
}

public function __invoke(): Kernel
{
    if (!$this->kernel) {
        $this->kernel = new Kernel(new Router(), new Session());
    }
}
