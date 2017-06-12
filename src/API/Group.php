<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;

/**
 * Class Group
 *
 * @package Tngnt\PBI\API
 */
class Group
{
    const GROUP_URL = "https://api.powerbi.com/v1.0/myorg/groups";

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
     * Returns all the groups the user belongs to on PowerBI
     *
     * @return \Tngnt\PBI\Response
     */
    public function getGroups()
    {
        $response = $this->client->request(Client::METHOD_GET, self::GROUP_URL);

        return $this->client->generateResponse($response);
    }
}
