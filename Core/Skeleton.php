<?php
/**
 * MIT License
 * Copyright (c) [2020] [Vaibhav Kubre]
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

class Skeleton
{

    /** @var Skeleton */
    protected static $instance = null;

    /** @var \Core\Config */
    protected $config;

    /** @var Request */
    protected $request;

    /** @var Router */
    protected $router;

    /** @var Response */
    protected $response;


    private function __construct($config = [])
    {
        $this->config = $config;
    }


    /**
     * Get applications singeleton instance
     *
     * @param \Core\Config $config
     * @return Skeleton
     */
    public static function getInstance($config = \Core\Config::class): Skeleton
    {
        if (is_null(self::$instance) && !empty($config)) {
            self::$instance = new Skeleton($config);
            self::$instance->request = self::$instance->makeRequest();
            self::$instance->router = new Router(self::$instance->config);
            self::$instance->response = self::$instance->routeRequest();
        }

        return self::$instance;
    }


    protected function makeRequest()
    {
        return new Request(
            $this->config::getGlobals()['get'],
            $this->config::getGlobals()['post'],
            $this->config::getGlobals()['files'],
            $this->config::getGlobals()['server'],
            $this->config::getGlobals()['cookie'],
            $this->config::getGlobals()['request']
        );
    }

    protected function routeRequest()
    {
        return $this->router->handle($this->request);
    }


    /**
     * Send Response
     *
     * @return void
     */
    public function sendResponse(): void
    {
        ob_start();
        foreach ($this->response->getHeaders() as $header => $value) {
            header("$header: $value");
        }
        http_response_code($this->response->getStatusCode());
        echo $this->response->getContent();
        $res = ob_get_contents();
        ob_end_clean();
        echo $res;
    }


    public function getConfig()
    {
        return $this->config;
    }
}
