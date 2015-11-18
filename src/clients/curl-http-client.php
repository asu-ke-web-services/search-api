<?php

namespace SearchApi\Clients;

/**
 * Uses curl to make http requests.
 */
class CurlHttpClient implements HttpClient {
  private $curl;

  function __construct() {
    // create curl resource
    $this->curl = curl_init();
  }

  function __destruct() {
    curl_close( $this->curl );
  }

  /**
   * Simple GET request. Given a URL, return a string for the response.
   */
  function get( $url ) {
    // Use curl to make GET request to SOLR server.
    $ch = $this->curl;
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $response = curl_exec( $ch );

    return $response;
  }
}
