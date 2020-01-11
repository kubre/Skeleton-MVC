<?php

namespace Core;

class Router
{
    /** @var \Core\Config */
    protected $config;


    public function __construct($config)
    {
        $this->config = $config;
    }


    /**
     * Handle the incoming request
     *
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $uri = $request->server('REQUEST_URI');
        $uri = str_replace($this->config::BASE_URL, "", $uri);
        $args = explode('/', trim($uri, '/'));

        // Check if simple routes being used like /, /about, etc.
        if (1 === count($args)) {
            $controller = $this->config::DEFAULT_CONTROLLER;
            $method = array_shift($args) ?: $this->config::ACTION_INDEX;
        } else {
            $controller = array_shift($args);
            $method = array_shift($args);
        }

        $method = explode('?', $method, 2)[0];
        $controller = $this->convertToCamelCase($controller);
        $method = $this->convertToStudlyCaps($method);

        return $this->run($controller, $method, $args, $request);
    }


    /**
     * Convert given string to CamelCase
     *
     * @param string $value
     * @return string
     */
    protected function convertToCamelCase($value): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $value)));
    }


    /**
     * Covert given string to studlyCaps
     *
     * @param string $value
     * @return string
     */
    protected function convertToStudlyCaps($value): string
    {
        return lcfirst($this->convertToCamelCase($value));
    }


    /**
     * Run the given method on controller
     *
     * @param string $controller
     * @param string $method
     * @param array $args
     * @param Request $request
     * @return string
     */
    protected function run($controller, $method, $args, Request $request): Response
    {
        // Add request object as a parameter
        array_unshift($args, $request);
        $class = $this->config::CONTROLLER_NAMESPACE."\\{$controller}Controller";
        if (class_exists($class) && is_callable($toCall = [new $class, $method])) {
            $result = call_user_func_array($toCall, $args);
        } else {
            $class = $this->config::CONTROLLER_NAMESPACE.'\\'.$this->config::DEFAULT_CONTROLLER.'Controller';
            $result = call_user_func([new $class, $this->config::ACTION_404], $request);
        }
        return $result;
    }
}
