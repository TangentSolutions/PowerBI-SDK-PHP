<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;

/**
 * Class Row
 *
 * @package Tngnt\PBI\API
 */
class Row
{
    const ROW_URL = "https://api.powerbi.com/v1.0/myorg/datasets/%s/tables/%s/rows";
    const GROUP_ROW_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/datasets/%s/tables/%s/rows";

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
     * Adds a new row to the table on PowerBI
     *
     * @param array       $row       An assoc array of the row data
     * @param string      $datasetId The ID of the dataset the table belongs to
     * @param string      $tableName The name of the table to add the row to
     * @param null|string $groupId   An optional group ID
     *
     * @return \Tngnt\PBI\Response
     */
    public function addRow(array $row, $datasetId, $tableName, $groupId = null)
    {
        $url = $this->getUrl($datasetId, $tableName, $groupId);

        $response = $this->client->request(Client::METHOD_POST, $url, $row);

        return $this->client->generateResponse($response);
    }

    /**
     * Deletes the rows of a table on PowerBI
     *
     * @param string      $datasetId The ID of the dataset the table belongs to
     * @param string      $tableName The name of the table
     * @param null|string $groupId   An optional group ID
     *
     * @return \Tngnt\PBI\Response
     */
    public function deleteRows($datasetId, $tableName, $groupId = null)
    {
        $url = $this->getUrl($datasetId, $tableName, $groupId);

        $response = $this->client->request(Client::METHOD_DELETE, $url);

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
    private function getUrl($datasetId, $tableName, $groupId)
    {
        if ($groupId) {
            return sprintf(self::GROUP_ROW_URL, $groupId, $datasetId, $tableName);
        }

        return sprintf(self::ROW_URL, $datasetId, $tableName);
    }
}
