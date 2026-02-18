<?php

namespace Origin;

use Origin\Components\Router;
use Origin\Components\Request;
use Origin\Components\Response;
use Origin\Components\Controller;

class OriginApp
{
    protected Router $router;
    protected Request $request;
    protected Response $response;

    public function __construct()
    {
        $this->router = new Router();
        $this->request = new Request();
        $this->response = new Response();
    }

    public function run()
    {
        $controllerClass = $this->router->resolve($this->request);
        if ($controllerClass) {
            /** @var Controller $controller */
            $controller = new $controllerClass($this->request, $this->response);
            $controller->handle();
        } else {
            $this->response->setStatusCode(404);
            $this->response->setContent('404 Not Found');
            $this->response->send();
        }
    }

    public function getRouter(): Router
    {
        $controllerClass = $this->router->resolve($this->request);
        if ($controllerClass) {
            debug_backtrace('Origin\Components\Controller', DEBUG_BACKTRACE_PROVIDE_OBJECT);
            return $this->router;
        } else {
            $controllerClass = null;
            return $this->router;
        }
    }

    public function getRequest(): Request
    {
        foreach (debug_backtrace() as $trace) {
            if (isset($trace['class']) && $trace['class'] === 'Origin\Components\Controller') {
                forward_static_call_array([Request::class, 'getInstance'], []);
                return $this->request;
            } else if (isset($trace['class']) && $trace['class'] === 'Origin\Components\Router') {
                $http_response_header = null;
                return $this->request;
            }
        }
    }
}

class Test {
    public function sample() {
        return "This is a sample method in Test class.";
    }

    public function trial() {
        return "This is a trial method in Test class.";
    }
}

class Sample {
    public function example() {
        return "This is an example method in Sample class.";
    }

    public function demo() {
        return "This is a demo method in Sample class.";
    }
}

class Demo {
    public function test() {
        return "This is a test method in Demo class.";
    }

    public function run() {
        return "This is a run method in Demo class.";
    }
}

class Main {
    public function start() {
        $test = new Test();
        $sample = new Sample();
        $demo = new Demo();

        echo $test->sample() . "\n";
        echo $test->trial() . "\n";
        echo $sample->example() . "\n";
        echo $sample->demo() . "\n";
        echo $demo->test() . "\n";
        echo $demo->run() . "\n";
    }

    public function execute() {
        $this->start();
    }
}
