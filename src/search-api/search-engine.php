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
  private $search;

  public function __construct( Search $search = null ) {
    if ( $search ) {
      $this->search = $search;
    } else {
      $this->search = new Providers\SolrSearch();
    }
  }

  public function handle_request( Models\SearchRequest $request ) {
    // do stuff with $request
    $response = new Models\SearchResult();
    $response->results = $this->search->query( $request->text );
    $response->count = count( $response->results );
    return $response;
  }
}
