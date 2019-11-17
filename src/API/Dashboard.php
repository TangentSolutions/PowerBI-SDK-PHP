<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;

/**
 * Class Dashboard
 *
 * @package Tngnt\PBI\API
 */
class Dashboard
{
    const DASHBOARD_URL = "https://api.powerbi.com/v1.0/myorg/dashboards";
    const GROUP_DASHBOARD_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/dashboards";
    const TILES_URL = "https://api.powerbi.com/v1.0/myorg/dashboards/%s/tiles";
    const GROUP_TILES_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/dashboards/%s/tiles";
    const GROUP_DASHBOARD_EMBED_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/dashboards/%s/GenerateToken";

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
     * Retrieves a list of dashboards on PowerBI
     *
     * @param null|string $groupId An optional group ID
     *
     * @return \Tngnt\PBI\Response
     */
    public function getDashboards($groupId = null)
    {
        $url = $this->getUrl($groupId);

        $response = $this->client->request(Client::METHOD_GET, $url);

        return $this->client->generateResponse($response);
    }

    /**
     * Retrieves the embed token for embedding a dashboard
     *
     * @param string      $dashboardId The dashboard ID
     * @param string      $groupId     The group ID of the dashboard
     * @param null|string $accessLevel The access level used for the dashboard
     *
     * @return \Tngnt\PBI\Response
     */
    public function getDashboardEmbedToken($dashboardId, $groupId, $accessLevel = 'view')
    {
        $url = sprintf(self::GROUP_DASHBOARD_EMBED_URL, $groupId, $dashboardId);

        $body = [
            'accessLevel' => $accessLevel,
        ];

        $response = $this->client->request(Client::METHOD_POST, $url, $body);

        return $this->client->generateResponse($response);
    }

    /**
     * Retrieves the tiles on a specified dashboard
     *
     * @param string      $dashboardId The ID of the dashboard
     * @param null|string $groupId     An optional group ID
     *
     * @return \Tngnt\PBI\Response
     */
    public function getTiles($dashboardId, $groupId = null)
    {
        $url = $this->getTilesUrl($dashboardId, $groupId);

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
            return sprintf(self::GROUP_DASHBOARD_URL, $groupId);
        }

        return self::DASHBOARD_URL;
    }

    /**
     * Helper function to format the tiles request URL
     *
     * @param string      $dashboardId The ID of the dashboard to retrieve the tiles for
     * @param null|string $groupId     An optional group ID
     *
     * @return string
     */
    private function getTilesUrl($dashboardId, $groupId)
    {
        if ($groupId) {
            return sprintf(self::GROUP_TILES_URL, $groupId, $dashboardId);
        }

        return sprintf(self::TILES_URL, $dashboardId);
    }
}
