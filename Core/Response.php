<?php

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
