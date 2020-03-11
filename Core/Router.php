<?php
/**
 * MIT License
 * Copyright (c) 2020 Vaibhav Kubre
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

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
        if($request->isPost() && !Security::checkCsrfToken($request->input('_token'))) {
            die("Session expired");
        }
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
