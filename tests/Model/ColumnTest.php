<?php

namespace Tngnt\PBI\Tests\Model;

use Tngnt\PBI\Model\Column;

class ColumnTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Column
     */
    private $column;

    public function setUp()
    {
        $this->column = new Column('testing', 'type');
    }

    public function testGetName()
    {
        $this->assertEquals('testing', $this->column->getName());
    }

    public function testGetDataType()
    {
        $this->assertEquals('type', $this->column->getDataType());
    }
}
