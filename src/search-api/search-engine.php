<?php

namespace SearchApi;
use SearchApi\Models as Models;

/**
 * Class SearchEngine - This is the main entry point into this application, it takes search requests and
 * returns search results.
 */
class SearchEngine {

  public function handle_request( Models\SearchRequest $request ) {
    if ( empty( $request ) ) {
      // handle an empty request
      return new Models\SearchResult();
    }
    // do stuff with $request
    return new Models\SearchResult();
  }
}
