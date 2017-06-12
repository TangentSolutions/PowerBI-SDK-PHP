<?php

namespace Tngnt\PBI;

/**
 * Class Response
 *
 * @package Tngnt\PBI
 */
class Response
{
    /**
     * The response body
     *
     * @var string
     */
    private $body;

    /**
     * The response headers
     *
     * @var array
     */
    private $headers;

    /**
     * Response constructor.
     *
     * @param string $body    The raw response body
     * @param array  $headers An array of response headers
     */
    public function __construct($body, $headers)
    {
        $this->body = $body;
        $this->headers = $headers;
    }

    /**
     * Get the raw response body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get the body converted to an array
     *
     * @return array
     */
    public function toArray()
    {
        return json_decode($this->body, true);
    }

    /**
     * Get the headers array
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Retrieve a specific header item
     *
     * @param string $key The key of the header entry to retrieve.
     *
     * @return mixed|null
     */
    public function getHeader($key)
    {
        if (array_key_exists($key, $this->headers)) {
            return $this->headers[$key];
        }

        return null;
    }
}
