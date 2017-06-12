<?php

namespace Tngnt\PBI\Tests\Model;

use Tngnt\PBI\Model\Import;

class ImportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Import
     */
    private $import;

    public function setUp()
    {
        $this->import = new Import("file-path", Import::CONNECT);
    }

    public function testGetFilePath()
    {
        $this->assertEquals('file-path', $this->import->getFilePath());
    }

    public function testGetConnectionType()
    {
        $this->assertEquals('connect', $this->import->getConnectionType());
    }

    public function testInvalidConnectionType()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        new Import('file-path', 'invalid-type');
    }
}
