<?php

namespace Core;

class Skeleton
{

    /** @var Skeleton */
    protected static $instance = null;

    /** @var array */
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
     * @param array $config
     * @return Skeleton
     */
    public static function getInstance($config = []): Skeleton
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
            $this->config['superglobals']['get'],
            $this->config['superglobals']['post'],
            $this->config['superglobals']['files'],
            $this->config['superglobals']['server'],
            $this->config['superglobals']['cookie'],
            $this->config['superglobals']['request']
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
