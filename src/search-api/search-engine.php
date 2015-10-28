<?php

namespace SearchApi;
use SearchApi\Models as Models;
use SearchApi\Providers as Providers;
use SearchApi\Services\Search as Search;

/**
 * Class SearchEngine - This is the main entry point into this application, it takes search requests and
 * returns search results.
 */
class SearchEngine {
  public function handle_request( Models\SearchRequest $request, Search $search = null ) {
    // Use a default search service
    if ( $search === null ) {
      $search = new Providers\SolrSearch();
    }

    // do stuff with $request
    $response = new Models\SearchResult();
    $response->results = $search->query( $request->text );
    $response->count = count( $response->results );
    return $response;
  }
}
