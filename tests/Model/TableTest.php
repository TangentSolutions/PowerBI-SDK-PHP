<?php

namespace Tngnt\PBI\Tests\Model;

use Tngnt\PBI\Model\Column;
use Tngnt\PBI\Model\Table;

class TableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Table
     */
    private $table;

    public function setUp()
    {
        $this->table = new Table('testing');
    }

    public function testGetName()
    {
        $this->assertEquals('testing', $this->table->getName());
    }

    public function testColumns()
    {
        $column = new Column('testing-column', 'testing-type');

        $this->assertEquals([], $this->table->getColumns());

        $this->table->addColumn($column);

        $this->assertEquals([$column], $this->table->getColumns());
    }
}
