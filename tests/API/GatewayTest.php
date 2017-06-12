<?php

namespace Tngnt\PBI\Tests\API;

use GuzzleHttp\Psr7\Response;
use Tngnt\PBI\API\Gateway;
use Tngnt\PBI\Client;

class GatewayTest extends \PHPUnit_Framework_TestCase
{
    public function testSetCredentials()
    {
        $url = sprintf(Gateway::GATEWAY_URL, 'gateway', 'datasource');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs([
            'PATCH',
            $url,
            ['foo' => 'bar']
        ])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $gateway = new Gateway($clientMock);
        $response = $gateway->setCredentials('gateway', 'datasource', ['foo' => 'bar']);

        $this->assertEquals($response, 'final-response');
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
