<?php

namespace Tngnt\PBI\Tests\API;

use GuzzleHttp\Psr7\Response;
use Tngnt\PBI\API\Group;
use Tngnt\PBI\Client;

class GroupTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDatasets()
    {
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', Group::GROUP_URL])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $group = new Group($clientMock);
        $response = $group->getGroups();

        $this->assertEquals($response, 'final-response');
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
