<?php

namespace Tngnt\PBI\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tngnt\PBI\Client;
use GuzzleHttp\Client as HTTPClient;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Client */
    private $client;

    private $container = [];

    public function setUp()
    {
        $history = Middleware::history($this->container);

        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], '{"Foo": "Bar"}'),
        ]);
        $handler = HandlerStack::create($mock);
        $handler->push($history);
        $client = new HTTPClient(['handler' => $handler]);
        $this->client = new Client('test-token', $client);
    }

    public function testGetToken()
    {
        $this->assertEquals('test-token', $this->client->getToken());
    }

    public function testDatasetProperty()
    {
        $this->assertInstanceOf('Tngnt\PBI\API\Dataset', $this->client->dataset);
    }

    public function testTableProperty()
    {
        $this->assertInstanceOf('Tngnt\PBI\API\Table', $this->client->table);
    }

    public function testRowProperty()
    {
        $this->assertInstanceOf('Tngnt\PBI\API\Row', $this->client->row);
    }

    public function testGroupProperty()
    {
        $this->assertInstanceOf('Tngnt\PBI\API\Group', $this->client->group);
    }

    public function testDashboardProperty()
    {
        $this->assertInstanceOf('Tngnt\PBI\API\Dashboard', $this->client->dashboard);
    }

    public function testReportProperty()
    {
        $this->assertInstanceOf('Tngnt\PBI\API\Report', $this->client->report);
    }

    public function testDatasourceProperty()
    {
        $this->assertInstanceOf('Tngnt\PBI\API\Datasource', $this->client->datasource);
    }

    public function testGatewayProperty()
    {
        $this->assertInstanceOf('Tngnt\PBI\API\Gateway', $this->client->gateway);
    }

    public function testImportProperty()
    {
        $this->assertInstanceOf('Tngnt\PBI\API\Import', $this->client->import);
    }

    public function testRequest()
    {
        $response = $this->client->request(Client::METHOD_POST, '/testing', ['Foo' => 'Bar']);

        // Check the PSR7 Response
        $this->assertInstanceOf('GuzzleHttp\Psr7\Response', $response);
        $this->assertEquals(['Bar'], $response->getHeader('X-Foo'));
        $this->assertEquals(200, $response->getStatusCode());

        // Check the request
        $this->assertEquals(1, count($this->container));

        /** @var Request $request */
        $request = $this->container[0]['request'];
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/testing', $request->getUri());
        $this->assertEquals('{"Foo":"Bar"}', $request->getBody()->getContents());
    }

    public function testGenerateResponse()
    {
        $HTTPresponse = $this->client->request(Client::METHOD_POST, '/testing', ['Foo' => 'Bar']);
        $response = $this->client->generateResponse($HTTPresponse);

        $this->assertInstanceOf('Tngnt\PBI\Response', $response);
    }
}
