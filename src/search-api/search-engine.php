<?php

namespace SearchApi;
use SearchApi\Models as Models;
use SearchApi\Providers as Providers;

/**
 * Class SearchEngine - This is the main entry point into this application, it takes search requests and
 * returns search results.
 */
class SearchEngine {

  private $searchProvider;

  public function handle_request( Models\SearchRequest $request ) {
    if ( empty( $request ) ) {
      // handle an empty request
      return new Models\SearchResult();
    }

    $searchProvider = new Providers\SolrSearch();

    // do stuff with $request
    $response = new Models\SearchResult();
    $response->results = $searchProvider->query($request->text);
    $response->count = count($response->results);
    return $response;
  }
}
