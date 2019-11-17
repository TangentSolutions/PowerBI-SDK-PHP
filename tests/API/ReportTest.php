<?php

namespace Tngnt\PBI\Tests\API;

use GuzzleHttp\Psr7\Response;
use Tngnt\PBI\API\Report;
use Tngnt\PBI\Client;

class ReportTest extends \PHPUnit_Framework_TestCase
{
    function testGetReports()
    {
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', Report::REPORT_URL])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $report = new Report($clientMock);
        $response = $report->getReports();

        $this->assertEquals($response, 'final-response');
    }

    function testGetReportsWithGroup()
    {
        $url = sprintf(Report::GROUP_REPORT_URL, '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $report = new Report($clientMock);
        $response = $report->getReports(123);

        $this->assertEquals($response, 'final-response');
    }

    function testGetReportEmbedToken()
    {
        $url = sprintf(Report::GROUP_REPORT_EMBED_URL, '456', '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['POST', $url, ['accessLevel' => 'view']])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $report = new Report($clientMock);
        $response = $report->getReportEmbedToken(123, 456);

        $this->assertEquals($response, 'final-response');
    }

    function testGetPages()
    {
        $url = sprintf(Report::PAGE_URL, '123');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $report = new Report($clientMock);
        $response = $report->getPages(123);

        $this->assertEquals($response, 'final-response');
    }

    function testGetPagesWithGroups()
    {
        $url = sprintf(Report::GROUP_PAGE_URL, '123', '456');
        $responseMock = \Mockery::mock(Response::class);
        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('request')->once()->withArgs(['GET', $url])->andReturn($responseMock);
        $clientMock->shouldReceive('generateResponse')->once()->with($responseMock)->andReturn('final-response');

        $report = new Report($clientMock);
        $response = $report->getPages(456, 123);

        $this->assertEquals($response, 'final-response');
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
