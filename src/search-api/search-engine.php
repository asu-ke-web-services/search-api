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
  protected $search_service;

  public function __construct() {
    $this->search_service = new Providers\SolrSearch();
  }

  public function use_search_service( Search $search ) {
    $this->search_service = $search;
  }

  public function handle_request( Models\SearchRequest $request ) {
    if ( empty( $request ) ) {
      // handle an empty request
      return new Models\SearchResult();
    }

    // do stuff with $request
    $response = new Models\SearchResult();
    $response->results = $this->search_service->query( $request->text );
    $response->count = count( $response->results );
    return $response;
  }
}
