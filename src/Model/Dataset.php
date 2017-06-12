<?php

namespace Tngnt\PBI\Model;

class Dataset
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $tables = [];

    /**
     * Dataset constructor.
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
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @param Table $table
     * @return $this
     */
    public function addTable(Table $table)
    {
        $this->tables[] = $table;

        return $this;
    }
}
