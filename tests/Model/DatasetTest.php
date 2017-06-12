<?php

namespace Tngnt\PBI\Tests\Model;


use Tngnt\PBI\Model\Dataset;
use Tngnt\PBI\Model\Table;

class DatasetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Dataset
     */
    private $dataset;

    public function setUp()
    {
        $this->dataset = new Dataset('testing');
    }

    public function testGetName()
    {
        $this->assertEquals('testing', $this->dataset->getName());
    }

    public function testTables()
    {
        $table = new Table('test-table');

        $this->assertEquals([], $this->dataset->getTables());

        $this->dataset->addTable($table);

        $this->assertEquals([$table], $this->dataset->getTables());
    }
}
