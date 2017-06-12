<?php

namespace Tngnt\PBI\Tests\API;

use GuzzleHttp\Psr7\Response;
use Tngnt\PBI\API\Row;
use Tngnt\PBI\Client;

class RowTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDatasets()
    {
        $url = sprintf(Row::ROW_URL, '123', 'table');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs([
            'POST',
            $url,
            ['Foo' => 'Bar']
        ])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $row = new Row($clientMock);
        $response = $row->addRow(['Foo' => 'Bar'], '123', 'table');

        $this->assertEquals($response, 'final-response');
    }

    public function testGetDatasetsWithGroup()
    {
        $url = sprintf(Row::GROUP_ROW_URL, 'group', '123', 'table');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs([
            'POST',
            $url,
            ['Foo' => 'Bar']
        ])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $row = new Row($clientMock);
        $response = $row->addRow(['Foo' => 'Bar'], '123', 'table', 'group');

        $this->assertEquals($response, 'final-response');
    }

    public function testDeleteRows()
    {
        $url = sprintf(Row::ROW_URL, '123', 'table');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['DELETE', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $row = new Row($clientMock);
        $response = $row->deleteRows('123', 'table');

        $this->assertEquals($response, 'final-response');
    }

    public function testDeleteRowsWithGroup()
    {
        $url = sprintf(Row::GROUP_ROW_URL, 'group', '123', 'table');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['DELETE', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $row = new Row($clientMock);
        $response = $row->deleteRows('123', 'table', 'group');

        $this->assertEquals($response, 'final-response');
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
