<?php

namespace Tngnt\PBI;

use Tngnt\PBI\API\Dashboard;
use Tngnt\PBI\API\Dataset;
use Tngnt\PBI\API\Datasource;
use Tngnt\PBI\API\Gateway;
use Tngnt\PBI\API\Group;
use Tngnt\PBI\API\Import;
use Tngnt\PBI\API\Report;
use Tngnt\PBI\API\Row;
use GuzzleHttp\Client as HTTPClient;
use Tngnt\PBI\API\Table;

/**
 * Class Client
 *
 * @package Tngnt\PBI
 *
 * @property \Tngnt\PBI\API\Dataset    $dataset
 * @property \Tngnt\PBI\API\Table      $table
 * @property \Tngnt\PBI\API\Row        $row
 * @property \Tngnt\PBI\API\Group      $group
 * @property \Tngnt\PBI\API\Dashboard  $dashboard
 * @property \Tngnt\PBI\API\Report     $report
 * @property \Tngnt\PBI\API\Datasource $datasource
 * @property \Tngnt\PBI\API\Gateway    $gateway
 * @property \Tngnt\PBI\API\Import     $import
 */
class Client
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PATCH = 'PATCH';

    /**
     * A valid access token
     *
     * @var string
     */
    private $token;

    /**
     * A Guzzle HTTP client
     *
     * @var HTTPClient
     */
    private $httpClient;

    /**
     * The dataset API class
     *
     * @var null|Dataset
     */
    private $dataset = null;

    /**
     * The table API class
     *
     * @var null|Table
     */
    private $table = null;

    /**
     * The row API class
     *
     * @var null|Row
     */
    private $row = null;

    /**
     * The group API class
     *
     * @var null|Group
     */
    private $group = null;

    /**
     * The dashboard API class
     *
     * @var null|Dashboard
     */
    private $dashboard = null;

    /**
     * The report API class
     *
     * @var null|Report
     */
    private $report = null;

    /**
     * The datasource API class
     *
     * @var null|Datasource
     */
    private $datasource = null;

    /**
     * The gateway API class
     *
     * @var null|Gateway
     */
    private $gateway = null;

    /**
     * The import API class
     *
     * @var null|Import
     */
    private $import = null;

    /**
     * Client constructor.
     *
     * @param string     $token      An Azure AD OAuth token.
     * @param HTTPClient $httpClient A Guzzle HTTP client
     */
    public function __construct($token, HTTPClient $httpClient = null)
    {
        $this->token = $token;

        if (!$httpClient) {
            $httpClient = new HTTPClient();
        }
        $this->httpClient = $httpClient;
    }

    /**
     * Get the access token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Helper function that initializes the dataset API class
     *
     * @return Dataset
     */
    private function getDataset()
    {
        if (!$this->dataset) {
            $this->dataset = new Dataset($this);
        }

        return $this->dataset;
    }

    /**
     * Helper function that initializes the table API class
     *
     * @return Table
     */
    private function getTable()
    {
        if (!$this->table) {
            $this->table = new Table($this);
        }

        return $this->table;
    }

    /**
     * Helper function that initializes the row API class
     *
     * @return Row
     */
    private function getRow()
    {
        if (!$this->row) {
            $this->row = new Row($this);
        }

        return $this->row;
    }

    /**
     * Helper function that initializes the group API class
     *
     * @return Group
     */
    private function getGroup()
    {
        if (!$this->group) {
            $this->group = new Group($this);
        }

        return $this->group;
    }

    /**
     * Helper function that initializes the dashboard API class
     *
     * @return Dashboard
     */
    private function getDashboard()
    {
        if (!$this->dashboard) {
            $this->dashboard = new Dashboard($this);
        }

        return $this->dashboard;
    }

    /**
     * Helper function that initializes the report API class
     *
     * @return Report
     */
    private function getReport()
    {
        if (!$this->report) {
            $this->report = new Report($this);
        }

        return $this->report;
    }

    /**
     * Helper function that initializes the datasource API class
     *
     * @return Datasource
     */
    private function getDatasource()
    {
        if (!$this->datasource) {
            $this->datasource = new Datasource($this);
        }

        return $this->datasource;
    }

    /**
     * Helper function that initializes the gateway API class
     *
     * @return Gateway
     */
    private function getGateway()
    {
        if (!$this->gateway) {
            $this->gateway = new Gateway($this);
        }

        return $this->gateway;
    }

    /**
     * Helper function that initializes the import API class
     *
     * @return Import
     */
    private function getImport()
    {
        if (!$this->import) {
            $this->import = new Import($this);
        }

        return $this->import;
    }

    /**
     * Executes a HTTP request using the Guzzle HTTP client
     *
     * @param string     $method The HTTP method to use for the request.
     * @param string     $url    The URL to make the request to.
     * @param mixed|null $body   The body of the request.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function request($method, $url, $body = null)
    {
        // Default Options
        $requestOptions = [
            'headers' => [
                "Accept"        => "application/json",
                "Authorization" => sprintf("Bearer %s", $this->getToken()),
            	"Content-Type"  => "application/json",
            ]
        ];

        // Add body if one was provided.
        if ($body) {
            $requestOptions = array_merge($requestOptions, ['body' => json_encode($body)]);
        }

        return $this->httpClient->request($method, $url, $requestOptions);
    }

    /**
     * Generate a standard response from the PSR7 response interface
     *
     * @param \GuzzleHttp\Psr7\Response $response
     *
     * @return Response
     */
    public function generateResponse(\GuzzleHttp\Psr7\Response $response)
    {
        return new Response($response->getBody()->getContents(), $response->getHeaders());
    }

    /**
     * Magic method which makes it easy to access the API classes
     *
     * @param string $name
     *
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        $methodName = 'get' . ucfirst($name);
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }

        throw new \Exception("Unknown context: $name");
    }
}
