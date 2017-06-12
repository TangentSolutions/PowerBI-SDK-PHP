<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;
use Tngnt\PBI\Model\Table as TableModel;

/**
 * Class Table
 *
 * @package Tngnt\PBI\API
 */
class Table
{
    const TABLE_URL = "https://api.powerbi.com/v1.0/myorg/datasets/%s/tables";
    const GROUP_TABLE_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/datasets/%s/tables";
    const TABLE_UPDATE_URL = "https://api.powerbi.com/v1.0/myorg/datasets/%s/tables/%s";
    const GROUP_TABLE_UPDATE_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/datasets/%s/tables/%s";

    /**
     * The SDK client
     *
     * @var Client
     */
    private $client;

    /**
     * Table constructor.
     *
     * @param Client $client The SDK client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves all the tables for a specified dataset
     *
     * @param string      $datasetId The ID of the dataset the table belongs to
     * @param null|string $groupId   An optional group ID
     *
     * @return \Tngnt\PBI\Response
     */
    public function getTables($datasetId, $groupId = null)
    {
        $url = $this->getUrl($datasetId, $groupId);

        $response = $this->client->request(Client::METHOD_GET, $url);

        return $this->client->generateResponse($response);
    }

    /**
     * Updates the schema of an existing table
     *
     * @param TableModel  $table     A table model with the updated schema
     * @param string      $datasetId The ID of the dataset the table bleongs to
     * @param null|string $groupId   An optional group ID
     *
     * @return \Tngnt\PBI\Response
     */
    public function updateSchema(TableModel $table, $datasetId, $groupId = null)
    {
        $url = $this->getUpdateUrl($datasetId, $table->getName(), $groupId);

        $response = $this->client->request(Client::METHOD_PATCH, $url, $table);

        return $this->client->generateResponse($response);
    }

    /**
     * Helper function to format the request URL
     *
     * @param string      $datasetId The ID of the dataset the table belongs to
     * @param null|string $groupId   An optional group ID
     *
     * @return string
     */
    private function getUrl($datasetId, $groupId)
    {
        if ($groupId) {
            return sprintf(self::GROUP_TABLE_URL, $groupId, $datasetId);
        }

        return sprintf(self::TABLE_URL, $datasetId);
    }

    /**
     * Helper function to format the update request URL
     *
     * @param string      $datasetId The ID of the datset the table belongs to
     * @param string      $tableName The name of the table
     * @param null|string $groupId   An optional group ID
     *
     * @return string
     */
    private function getUpdateUrl($datasetId, $tableName, $groupId)
    {
        if ($groupId) {
            return sprintf(self::GROUP_TABLE_UPDATE_URL, $groupId, $datasetId, $tableName);
        }

        return sprintf(self::TABLE_UPDATE_URL, $datasetId, $tableName);
    }
}
