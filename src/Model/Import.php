<?php

namespace Tngnt\PBI\Model;

/**
 * Class Import
 *
 * @package Tngnt\PBI\Model
 */
class Import
{
    const IMPORT = 'import';
    const CONNECT = 'connect';

    /**
     * The absolute or relative path to the file on OneDrive
     *
     * @var string
     */
    private $filePath;

    /**
     * The connection type to use. Either "import" or "connect"
     *
     * @var string
     */
    private $connectionType;

    /**
     * Import constructor.
     *
     * @param string $filePath The absolute or relative path to the file on OneDrive
     * @param string $connectionType The connection type to use
     */
    public function __construct($filePath, $connectionType)
    {
        $this->filePath = $filePath;

        if ($connectionType != self::CONNECT && $connectionType != self::IMPORT) {
            throw new \InvalidArgumentException('The connection type must either be "connect" or "import"');
        }
        $this->connectionType = $connectionType;
    }

    /**
     * Returns the file path
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Returns the connection string
     *
     * @return string
     */
    public function getConnectionType()
    {
        return $this->connectionType;
    }
}
