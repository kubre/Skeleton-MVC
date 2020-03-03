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