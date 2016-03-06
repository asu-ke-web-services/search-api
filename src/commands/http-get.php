<?php

namespace SearchApi\Commands;
use SearchApi\Commands;

/**
 * Command for making simple GET requests.
 *
 * @var CurlObject $curl object returned by curl_init()
 * @var string $url Url to make a GET request to
 */
class HttpGet implements Command {
  private $curl;
  private $url;

  function __construct() {
    // create curl resource
    $this->curl = curl_init();
  }

  function __destruct() {
    curl_close( $this->curl );
  }

  /**
   * Set the Url to make a GET request to
   *
   * @var string $url Url to make a GET request to
   */
  function setUrl( $url ) {
    $this->url = $url;
  }

  /**
   * Execute command - simple GET request to Url set by setUrl
   */
  function execute() {
    // Use curl to make GET request to SOLR server.
    $ch = $this->curl;
    curl_setopt( $ch, CURLOPT_URL, $this->url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $response = curl_exec( $ch );

    return $response;
  }
}
