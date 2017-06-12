<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;

/**
 * Class Gateway
 *
 * @package Tngnt\PBI\API
 */
class Gateway
{
    const GATEWAY_URL = "https://api.powerbi.com/v1.0/myorg/gateways/%s/datasources/%s";

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
     * Sets the credentials for a specified datasource
     *
     * @param string $gatewayId    The ID of the gateway
     * @param string $datasourceId The ID of the datasource
     * @param array  $credentials  The credentials in the following format: ['credentialsType => 'basic',
     *                             'basicCredentials' => ['username' => '', 'password' => '']]
     *
     * @return \Tngnt\PBI\Response
     */
    public function setCredentials($gatewayId, $datasourceId, array $credentials)
    {
        $url = sprintf(self::GATEWAY_URL, $gatewayId, $datasourceId);

        $response = $this->client->request(Client::METHOD_PATCH, $url, $credentials);

        return $this->client->generateResponse($response);
    }
}
