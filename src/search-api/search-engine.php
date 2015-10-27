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
  protected $searchService;

  public function __construct() {
    $this->searchService = new Providers\SolrSearch();
  }

  public function useSearchService( Search $search ) {
    $this->searchService = $search;
  }

  public function handle_request( Models\SearchRequest $request ) {
    if ( empty( $request ) ) {
      // handle an empty request
      return new Models\SearchResult();
    }

    // do stuff with $request
    $response = new Models\SearchResult();
    $response->results = $this->searchService->query($request->text);
    $response->count = count($response->results);
    return $response;
  }
}
