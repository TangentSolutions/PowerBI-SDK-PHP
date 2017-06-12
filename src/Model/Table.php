<?php

namespace Tngnt\PBI\Model;

/**
 * Class Table
 * @package Tngnt\PBI\Model
 */
class Table
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $columns = [];

    /**
     * Table constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param Column $column
     * @return $this
     */
    public function addColumn(Column $column)
    {
        $this->columns[] = $column;

        return $this;
    }
}
