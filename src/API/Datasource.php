<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;

/**
 * Class Datasource
 *
 * @package Tngnt\PBI\API
 */
class Datasource
{
    const DATASOURCE_URL = "https://api.powerbi.com/v1.0/myorg/datasets/%s/dataSources";
    const GATEWAY_DATASOURCE_URL = "https://api.powerbi.com/v1.0/myorg/datasets/%s/Default.GetBoundGatewayDataSources";
    const CONNECTION_DATASOURCE_URL = "https://api.powerbi.com/v1.0/myorg/myorg/datasets/%s/Default.SetAllConnections";

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
     * Retrieves a list of datasources for a specific dataset
     *
     * @param string $datasetId The ID of the dataset
     *
     * @return \Tngnt\PBI\Response
     */
    public function getDatasources($datasetId)
    {
        $url = sprintf(self::DATASOURCE_URL, $datasetId);

        $response = $this->client->request(Client::METHOD_GET, $url);

        return $this->client->generateResponse($response);
    }

    /**
     * Retrieves a list of gateway datsources for a specific dataset
     *
     * @param string $datasetId The ID of the dataset
     *
     * @return \Tngnt\PBI\Response
     */
    public function getBoundGatewayDatasources($datasetId)
    {
        $url = sprintf(self::GATEWAY_DATASOURCE_URL, $datasetId);

        $response = $this->client->request(Client::METHOD_GET, $url);

        return $this->client->generateResponse($response);
    }

    /**
     * Updates the connection strings for each data source in the specified dataset
     *
     * @param string $datasetId        The ID of the dataset
     * @param string $connectionString The formatted connection strings
     *
     * @return \Tngnt\PBI\Response
     */
    public function setAllConnections($datasetId, $connectionString)
    {
        $url = sprintf(self::CONNECTION_DATASOURCE_URL, $datasetId);

        $response = $this->client->request(
            Client::METHOD_POST,
            $url,
            ['connectionString' => $connectionString]
        );

        return $this->client->generateResponse($response);
    }
}
