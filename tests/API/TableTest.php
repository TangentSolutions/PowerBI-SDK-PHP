<?php

namespace Tngnt\PBI\Tests\API;

use GuzzleHttp\Psr7\Response;
use Tngnt\PBI\API\Table;
use Tngnt\PBI\Client;

class TableTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTables()
    {
        $url = sprintf(Table::TABLE_URL, '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $table = new Table($clientMock);
        $response = $table->getTables(123);

        $this->assertEquals($response, 'final-response');
    }

    public function testGetTablesWithGroup()
    {
        $url = sprintf(Table::GROUP_TABLE_URL, 'group', '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $table = new Table($clientMock);
        $response = $table->getTables(123, 'group');

        $this->assertEquals($response, 'final-response');
    }

    public function testUpdateTableSchema()
    {
        $tableModel = new \Tngnt\PBI\Model\Table('table');
        $url = sprintf(Table::TABLE_UPDATE_URL, '123', 'table');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs([
            'PATCH',
            $url,
            \Mockery::type('Tngnt\PBI\Model\Table')
        ])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $table = new Table($clientMock);
        $response = $table->updateSchema($tableModel, 123);

        $this->assertEquals($response, 'final-response');
    }

    public function testUpdateTableSchemaWithGroup()
    {
        $tableModel = new \Tngnt\PBI\Model\Table('table');
        $url = sprintf(Table::GROUP_TABLE_UPDATE_URL, 'group', '123', 'table');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs([
            'PATCH',
            $url,
            \Mockery::type('Tngnt\PBI\Model\Table')
        ])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $table = new Table($clientMock);
        $response = $table->updateSchema($tableModel, 123, 'group');

        $this->assertEquals($response, 'final-response');
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
