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

class Response
{

    /** @var array Headers to be sent with response */
    protected $headers = [];

    /** @var string Content sent as response */
    protected $content = '';

    /** @var int Status code for http reponse */
    protected $statusCode = 200;


    public function __construct($content = '', $headers = [], $statusCode = 200)
    {
        $this->content = $content;
        $this->headers = $headers;
        $this->statusCode = $statusCode;
    }

    /**
     * Get headers of HttpResponse
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }


    /**
     * Get content of HttpResponse
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }


    /**
     * Get Status code of HttpResponse
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Set Headers for response with given value
     *
     * @param string $header
     * @param string $value
     * @return Response returns the same object for chaining
     */
    public function withHeader($header, $value): Response
    {
        $this->headers[$header] = $value;
        return $this;
    }


    /**
     * Set http status code to given
     *
     * @param int $code
     * @return Response returns the same object for chaining
     */
    public function withStatus($code = 200): Response
    {
        $this->statusCode = $code;
        return $this;
    }
}
