<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;
use Tngnt\PBI\Model\Dataset as DatasetModel;
use Tngnt\PBI\Response;

/**
 * Class Dataset
 *
 * @package Tngnt\PBI\Dataset
 */
class Dataset
{
    const DATASET_URL = 'https://api.powerbi.com/v1.0/myorg/datasets';
    const GROUP_DATASET_URL = 'https://api.powerbi.com/v1.0/myorg/groups/%s/datasets';

    /**
     * The SDK client
     *
     * @var Client
     */
    private $client;

    /**
     * Dataset constructor.
     *
     * @param Client $client The SDK client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves the datasets from the PowerBI API
     *
     * @param null|string $groupId An optional group ID
     *
     * @return Response
     */
    public function getDatasets($groupId = null)
    {
        $url = $this->getUrl($groupId);

        $response = $this->client->request(Client::METHOD_GET, $url);

        return $this->client->generateResponse($response);
    }

    /**
     * Create a new dataset on PowerBI
     *
     * @param DatasetModel $dataset The dataset model
     * @param null|string  $groupId An optional group ID
     *
     * @return Response
     */
    public function createDataset(DatasetModel $dataset, $groupId = null)
    {
        $url = $this->getUrl($groupId);

        $response = $this->client->request(client::METHOD_POST, $url, $dataset);

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
            return sprintf(self::GROUP_DATASET_URL, $groupId);
        }

        return self::DATASET_URL;
    }
}
