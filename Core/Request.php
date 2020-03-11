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

class Request
{

    /** @var array All Required Superglobals stored here */
    protected $paramBag = [];
    protected $isUploadedFilesConstructed = false;

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
        return is_null($field) ? $this->paramBag['get'] : $this->paramBag['get'][$field] ?: null;
    }


    /**
     * Retrive post array or fields
     *
     * @param string|null $field
     * @return mixed
     */
    public function input($field = null)
    {
        return is_null($field) ? $this->paramBag['post'] : $this->paramBag['post'][$field] ?? null;
    }


    /**
     * Retrive server array or fields
     *
     * @param string|null $field
     * @return mixed
     */
    public function server($field = null)
    {
        return is_null($field) ? $this->paramBag['server'] : $this->paramBag['server'][$field] ?? null;
    }


    /**
     * Retrive files array or fields
     *
     * @param string|null $field
     * @return array|UploadedFile
     */
    public function files($field = null)
    {
        if (!$this->isUploadedFilesConstructed) {
            foreach ($this->paramBag['files'] as $key => $file) {
                $this->paramBag['files'][$key] = new UploadedFile($file);
            }
            $this->isUploadedFilesConstructed = true;
        }
        return is_null($field) ? $this->paramBag['files'] : $this->paramBag['files'][$field] ?? null;
    }


    /**
     * Check for file
     *
     * @param string|null $field
     * @return boolean
     */
    public function hasFile($field)
    {
        return isset($this->paramBag['files'][$field]);
    }


    public function all()
    {
        return array_merge($this->input(), $this->files());
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
    public function isPost()
    {
        return $this->server('REQUEST_METHOD') === 'POST';
    }
}
