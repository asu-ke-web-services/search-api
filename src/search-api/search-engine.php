<?php

namespace SearchApi;
use SearchApi\Models as Models;
use SearchApi\Providers as Providers;
use SearchApi\Services\Search as Search;
use Nectary\Configuration as Configuration;

/**
 * Class SearchEngine - This is the main entry point into this application, it takes search requests and
 * returns search results.
 */
class SearchEngine {
  private $search;

  public function __construct( Search $search = null ) {
    Configuration::set_configuration_path( 'config.conf' );
    if ( $search ) {
      $this->search = $search;
    } else {
      $apiPath = trim( Configuration::get_instance()->get( 'SolrApiUrl' ), '\r\n' );
      $this->search = new Providers\SolrSearch( null, null, $apiPath );
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
