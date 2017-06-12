<?php

namespace Tngnt\PBI\Tests\API;

use GuzzleHttp\Psr7\Response;
use Tngnt\PBI\API\Import;
use Tngnt\PBI\Client;
use Tngnt\PBI\Model\Import as ImportModel;

class ImportTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateImport()
    {
        $url = Import::IMPORT_URL . "?nameConflict=Ignore&PreferClientRouting=false";
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs([
            'POST',
            $url,
            \Mockery::type(ImportModel::class)
        ])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $importModel = new ImportModel('path', ImportModel::CONNECT);
        $import = new Import($clientMock);
        $response = $import->createImport($importModel);

        $this->assertEquals($response, 'final-response');
    }

    public function testCreateImportQueryString()
    {
        $url = Import::IMPORT_URL . "?nameConflict=Overwrite&PreferClientRouting=true&datasetDisplayName=testing";
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs([
            'POST',
            $url,
            \Mockery::type(ImportModel::class)
        ])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $importModel = new ImportModel('path', ImportModel::CONNECT);
        $import = new Import($clientMock);
        $response = $import->createImport(
            $importModel,
            'testing',
            Import::CONFLICT_OVERWRITE,
            'true'
        );

        $this->assertEquals($response, 'final-response');
    }

    public function testGetImports()
    {
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', Import::IMPORT_URL])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $import = new Import($clientMock);
        $response = $import->getImports();

        $this->assertEquals($response, 'final-response');
    }

    public function testGetImport()
    {
        $url = Import::IMPORT_URL . "/123";
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $import = new Import($clientMock);
        $response = $import->getImport(123);

        $this->assertEquals($response, 'final-response');
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
