<?php

namespace SearchApi;
use SearchApi\Models as Models;
use SearchApi\Providers as Providers;
use SearchApi\Services\Search as Search;
use SearchApi\Services\Tagger as Tagger;
use SearchApi\Services\ReverseGeocoder as GeoCoder;
use Nectary\Configuration as Configuration;

/**
 * Class SearchEngine - This is the main entry point into this application, it takes search requests and
 * returns search results.
 */
class SearchEngine {
  private $search; // Search Implemenation to use
  private $tagger; // Tagger Implemenation to use
  private $geocoder; // GeoCdoder Implementation to use

  public function __construct( Search $search = null, Tagger $tagger = null, GeoCoder $geocoder = null) {
    Configuration::set_configuration_path( 'config.conf' );
    if ( $search ) {
      $this->search = $search;
    } else {
      $apiPath = trim( Configuration::get_instance()->get( 'SolrApiUrl' ), '\r\n' );
      $this->search = new Providers\SolrSearch( null, null, $apiPath );
    }

    if( $tagger ) {
      $this->tagger = $tagger;
    } else {
      $this->tagger = new Providers\NerTagger();
    }

    if ( $geocoder ) {
      $this->geocoder = $geocoder;
    } else {
      $this->geocoder = new Providers\GoogleReverseGeocoder();
    }
  }

  public function handle_request( Models\SearchRequest $request ) {
    // get keywords from the $request
    if ( $request->document ) {
      $request->text = $this->tagger->tagger_service( $request->document );
    }
    // get coordinates if available if $text has a location
/*    foreach ( $request->text as $item ) {
        if( $item->type === 'LOCATION' ) {
        // @todo: check for lat&long create GeoCoordinate, call geocdoer
        } 
        // @todo: call synonyms for $item
    }*/

    // do stuff with $request
    $response = new Models\SearchResult();
    $response->orginialRequest = $request;

    $keywords = explode(" ", $request->text);
    $searchTerms = array();
    foreach ($keywords as &$word) {
      array_push($searchTerms, new Models\SearchTerm($word));
    }

    $response->results = $this->search->query( $searchTerms );
    $response->count = count( $response->results );
    return $response;
  }
}
