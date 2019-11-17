<?php

namespace Tngnt\PBI\Tests\API;

use GuzzleHttp\Psr7\Response;
use Tngnt\PBI\API\Dashboard;
use Tngnt\PBI\Client;

class DashboardTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDashboards()
    {
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', Dashboard::DASHBOARD_URL])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $dashboard = new Dashboard($clientMock);
        $response = $dashboard->getDashboards();

        $this->assertEquals($response, 'final-response');
    }

    public function testGetDashboardsWithGroup()
    {
        $url = sprintf(Dashboard::GROUP_DASHBOARD_URL, '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $dashboard = new Dashboard($clientMock);
        $response = $dashboard->getDashboards('123');

        $this->assertEquals($response, 'final-response');
    }

    public function testGetDashboardEmbedToken()
    {
        $url = sprintf(Dashboard::GROUP_DASHBOARD_EMBED_URL, '456', '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['POST', $url, ['accessLevel' => 'view']])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $dashboard = new Dashboard($clientMock);
        $response = $dashboard->getDashboardEmbedToken(123, 456);

        $this->assertEquals($response, 'final-response');
    }

    public function testGetTiles()
    {
        $url = sprintf(Dashboard::TILES_URL, 'dashboard');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $dashboard = new Dashboard($clientMock);
        $response = $dashboard->getTiles('dashboard');

        $this->assertEquals($response, 'final-response');
    }

    public function testGetTilesWithGroup()
    {
        $url = sprintf(Dashboard::GROUP_TILES_URL, '123', 'dashboard');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $dashboard = new Dashboard($clientMock);
        $response = $dashboard->getTiles('dashboard', '123');

        $this->assertEquals($response, 'final-response');
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
