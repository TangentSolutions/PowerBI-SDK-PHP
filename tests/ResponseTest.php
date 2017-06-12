<?php

namespace Tngnt\PBI\Tests;

use Tngnt\PBI\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    private $response;

    public function setUp()
    {
        $this->response = new Response('{"Foo": "Bar"}', ['X-Foo' => 'Bar']);
    }

    public function testGetBody()
    {
        $this->assertEquals('{"Foo": "Bar"}', $this->response->getBody());
    }

    public function testToArray()
    {
        $this->assertEquals(['Foo' => 'Bar'], $this->response->toArray());
    }

    public function testGetHeaders()
    {
        $this->assertEquals(['X-Foo' => 'Bar'], $this->response->getHeaders());
    }

    public function testGetHeader()
    {
        $this->assertEquals('Bar', $this->response->getHeader('X-Foo'));
        $this->assertEquals(null, $this->response->getHeader('i-dont-exist'));
    }
}
