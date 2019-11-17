<?php

namespace Tngnt\PBI\Tests\API;

use GuzzleHttp\Psr7\Response;
use Tngnt\PBI\API\Dataset;
use Tngnt\PBI\Client;

class DatasetTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDatasets()
    {
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', Dataset::DATASET_URL])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $dataset = new Dataset($clientMock);
        $response = $dataset->getDatasets();

        $this->assertEquals($response, 'final-response');
    }

    public function testGetDatasetsWithGroup()
    {
        $url = sprintf(Dataset::GROUP_DATASET_URL, '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $dataset = new Dataset($clientMock);
        $response = $dataset->getDatasets(123);

        $this->assertEquals($response, 'final-response');
    }

    public function testRefreshDataset()
    {
        $url = sprintf(Dataset::REFRESH_DATASET_URL, '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['POST', $url, ['notifyOption' => 'MailOnFailure']])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $dataset = new Dataset($clientMock);
        $response = $dataset->refreshDataset(123);

        $this->assertEquals($response, 'final-response');
    }

    public function testRefreshDatasetWithoutNotification()
    {
        $url = sprintf(Dataset::REFRESH_DATASET_URL, '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['POST', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $dataset = new Dataset($clientMock);
        $response = $dataset->refreshDataset(123, null, false);

        $this->assertEquals($response, 'final-response');
    }

    public function testRefreshDatasetWithGroup()
    {
        $url = sprintf(Dataset::GROUP_REFRESH_DATASET_URL, '456', '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['POST', $url, ['notifyOption' => 'MailOnFailure']])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $dataset = new Dataset($clientMock);
        $response = $dataset->refreshDataset(123, 456);

        $this->assertEquals($response, 'final-response');
    }

    public function testCreateDataset()
    {
        $datasetModel = new \Tngnt\PBI\Model\Dataset('testing');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs([
            'POST',
            Dataset::DATASET_URL,
            \Mockery::type('Tngnt\PBI\Model\Dataset')
        ])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $dataset = new Dataset($clientMock);
        $response = $dataset->createDataset($datasetModel);

        $this->assertEquals($response, 'final-response');
    }

    public function testCreateDatasetWithGroup()
    {
        $datasetModel = new \Tngnt\PBI\Model\Dataset('testing');
        $url = sprintf(Dataset::GROUP_DATASET_URL, '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs([
            'POST',
            $url,
            \Mockery::type('Tngnt\PBI\Model\Dataset')
        ])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $dataset = new Dataset($clientMock);
        $response = $dataset->createDataset($datasetModel, 123);

        $this->assertEquals($response, 'final-response');
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
