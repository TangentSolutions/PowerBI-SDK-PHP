<?php

namespace Tngnt\PBI\API;

use Tngnt\PBI\Client;

/**
 * Class Report.
 */
class Report {
    const REPORT_URL = "https://api.powerbi.com/v1.0/myorg/reports";
    const GROUP_REPORT_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/reports";
    const GROUP_REPORT_DATA_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/reports/%s";
    const GROUP_REPORT_EMBED_URL = "https://api.powerbi.com/v1.0/myorg/groups/%s/reports/%s/GenerateToken";
    const PAGE_URL = 'https://api.powerbi.com/v1.0/myorg/reports/%s/pages';
    const GROUP_PAGE_URL = 'https://api.powerbi.com/v1.0/myorg/groups/%s/reports/%s/pages';

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
    public function __construct( Client $client ) {
        $this->client = $client;
    }

    /**
     * Retrieves a list of reports on PowerBI.
     *
     * @param string|null $groupId An optional group ID
     *
     * @return \Tngnt\PBI\Response
     */
    public function getReports( $groupId = null ) {
        $url = $this->getUrlReports( $groupId );

        $response = $this->client->request( Client::METHOD_GET, $url );

        return $this->client->generateResponse( $response );
    }


    public function getReportData( $groupId, $reportId ) {

        $url = sprintf( self::GROUP_REPORT_DATA_URL, $groupId, $reportId );

        $response = $this->client->request( Client::METHOD_GET, $url );

        return $this->client->generateResponse( $response );
    }

    /**
     * Retrieves the embed token for embedding a report
     *
     * @param string $reportId The report ID of the report
     * @param string $groupId The group ID of the report
     * @param null|string $accessLevel The access level used for the report
     *
     * @return \Tngnt\PBI\Response
     */
    public function getReportEmbedToken( $reportId, $groupId, $accessLevel = 'view', $identities = [] ) {
        $url = sprintf( self::GROUP_REPORT_EMBED_URL, $groupId, $reportId );

        $body = [
          'accessLevel' => $accessLevel,
          'identities' => $identities
        ];

        $response = $this->client->request( Client::METHOD_POST, $url, $body );

        return $this->client->generateResponse( $response );
    }

    /**
     * Retrieves a list of reports on PowerBI
     *
     * @param string|null $groupId An optional group ID
     *
     * @return \Tngnt\PBI\Response
     */
    public function getPages( $reportId, $groupId = null ) {
        $url = $this->getUrlPages( $reportId, $groupId );

        $response = $this->client->request( Client::METHOD_GET, $url );

        return $this->client->generateResponse( $response );
    }

    /**
     * Helper function to format the request URL
     *
     * @param string|null $groupId An optional group ID
     *
     * @return string
     */
    private function getUrlReports( $groupId ) {
        if ( $groupId ) {
            return sprintf( self::GROUP_REPORT_URL, $groupId );
        }

        return self::REPORT_URL;
    }

    /**
     * Helper function to format the request URL
     *
     * @param string $reportId id from report
     * @param string|null $groupId An optional group ID
     *
     * @return string
     */
    private function getUrlPages( $reportId, $groupId ) {
        if ( $groupId ) {
            return sprintf( self::GROUP_PAGE_URL, $groupId, $reportId );
        }

        return sprintf( self::PAGE_URL, $reportId );
    }
}
