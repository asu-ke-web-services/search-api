<?php

namespace SearchApi\Clients;

/**
 * Wrapper for whatever http client we want to use.
 */
interface HttpClient {
  /**
   * Simple GET request. Given a URL, return a string for the response.
   */
  function get( $url );
}
