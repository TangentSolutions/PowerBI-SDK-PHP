<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;
use Ixudra\Curl\Facades\Curl;

/**
 * Class Report.
 */
class Embed
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
    public function createEmbedToken(array $data,$accessToken)
    {
        $url = $this->getEmbedTokenUrl();
        $headers = [
                'Accept: application/json',
                 sprintf('Authorization: Bearer %s', $accessToken),
            ];
        $response = Curl::to($url)
            ->withData($data)
            ->withHeaders($headers)
            ->asJson()
            ->post();

        return $response;
    }

    /**
     * Helper function to format the request URL.
     *
     * @return string
     */
    private function getEmbedTokenUrl()
    {
        return self::GENERATE_TOKEN_URL;
    }
}
