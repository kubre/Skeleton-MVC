<?php

namespace Core;

class Request {

    /** @var array All Required Superglobals stored here */
    protected $paramBag = [];

    public function __construct($get, $post, $files, $server, $cookie, $request)
    {
        $this->paramBag = [
            'get' => $get,
            'post' => $post, 
            'files' => $files, 
            'server' => $server, 
            'cookie' => $cookie, 
            'request' => $request
        ];
    }

    /**
     * Retrive get array or fields
     *
     * @param string|null $field
     * @return mixed
     */
    public function query($field = null)
    {
        return isset($this->paramBag['get'][$field]) ? $this->paramBag['get'][$field] : null;
    }


    /**
     * Retrive post array or fields
     *
     * @param string|null $field
     * @return mixed
     */
    public function input($field = null)
    {
        return isset($this->paramBag['post'][$field]) ? $this->paramBag['post'][$field] : null;
    }


    /**
     * Retrive server array or fields
     *
     * @param string|null $field
     * @return mixed
     */
    public function server($field = null)
    {
        return isset($this->paramBag['server'][$field]) ? $this->paramBag['server'][$field] : null;
    }

    
    /**
     * Is request Get request
     *
     * @return boolean
     */
    public function isGet()
    {
        return $this->server('REQUEST_METHOD') === 'GET';
    }

    
    /**
     * Is request Post request
     *
     * @return boolean
     */
    public function isPost(): bool
    {
        return $this->server('REQUEST_METHOD') === 'POST';
    }
}