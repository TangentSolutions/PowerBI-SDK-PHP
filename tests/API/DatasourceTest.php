<?php

namespace Tngnt\PBI\Tests\API;

use GuzzleHttp\Psr7\Response;
use Tngnt\PBI\API\Datasource;
use Tngnt\PBI\Client;

class DatasourceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDatasources()
    {
        $url = sprintf(Datasource::DATASOURCE_URL, '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $datasource = new Datasource($clientMock);
        $response = $datasource->getDatasources('123');

        $this->assertEquals($response, 'final-response');
    }

    public function testGetBoundGatewayDatasources()
    {
        $url = sprintf(Datasource::GATEWAY_DATASOURCE_URL, '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $datasource = new Datasource($clientMock);
        $response = $datasource->getBoundGatewayDatasources('123');

        $this->assertEquals($response, 'final-response');
    }

    public function testSetAllConnections()
    {
        $url = sprintf(Datasource::CONNECTION_DATASOURCE_URL, '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs([
            'POST',
            $url,
            ['connectionString' => 'testing']
        ])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $datasource = new Datasource($clientMock);
        $response = $datasource->setAllConnections('123', 'testing');

        $this->assertEquals($response, 'final-response');
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
