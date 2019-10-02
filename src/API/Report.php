<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;

/**
 * Class Report
 *
 * @package Tngnt\PBI\API
 */
class Report
{
    const REPORT_URL = "https://api.powerbi.com/v1.0/myorg/reports";
    const GROUP_REPORT_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/reports";

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
     * Retrieves a list of reports on PowerBI
     *
     * @param null|string $groupId An optional group ID
     *
     * @return \Tngnt\PBI\Response
     */
    public function getReports($groupId = null)
    {
        $url = $this->getUrl($groupId);

        $response = $this->client->request(Client::METHOD_GET, $url);

        return $this->client->generateResponse($response);
    }

    /**
     * Helper function to format the request URL
     *
     * @param null|string $groupId An optional group ID
     *
     * @return string
     */
    private function getUrl($groupId)
    {
        if ($groupId) {
            return sprintf(self::GROUP_REPORT_URL, $groupId);
        }

        return self::REPORT_URL;
    }
}
