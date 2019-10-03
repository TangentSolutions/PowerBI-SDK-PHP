<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;

/**
 * Class Report.
 */
class Embled
{
    const GENERATE_TOKEN_URL = 'https://api.powerbi.com/v1.0/myorg/GenerateToken';

    /**
     * The SDK client.
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
     * Retrieves a list of reports on PowerBI.
     *
     * @param array $reports          id of reports
     * @param array $datasets         id of datasets
     * @param array $targetWorkspaces id of workspaces
     * @param $identities id of identities
     *
     * @return \Tngnt\PBI\Response
     */
    public function createEmbledToken(array $reports = [], array $datasets = [], array $targetWorkspaces = [], array $identities = [])
    {
        $url = $this->getEmbledTokenUrl();
        $data = [
            'datasets' => $datasets,
            'reports' => $reports,
            'targetWorkspaces' => $targetWorkspaces,
            'identities' => $identities,
            ];

        $response = $this->client->request(Client::METHOD_POST, $url, $data);

        return $this->client->generateResponse($response);
    }

    /**
     * Helper function to format the request URL.
     *
     * @return string
     */
    private function getEmbledTokenUrl()
    {
        return self::GENERATE_TOKEN_URL;
    }
}
