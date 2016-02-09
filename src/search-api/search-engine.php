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

  public function __construct( Search $search = null, Tagger $tagger = null, GeoCoder $geocoder = null ) {
    Configuration::set_configuration_path( 'config.conf' );
    if ( $search ) {
      $this->search = $search;
    } else {
      $apiPath = trim( Configuration::get_instance()->get( 'SolrApiUrl' ), '\r\n' );
      $this->search = new Providers\SolrSearch( null, null, $apiPath );
    }

    if ( $tagger ) {
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

    if ( $request->document === null ) {
      return new Models\SearchResult();
    }

    // the terms that will be sent to the query builder
    $searchTerms = array();

    // the keywords from the
    $taggedWords = array();

    // explode user keywords
    if ( $request->text ) {
      $userWords = explode( ' ' , $request->text );
      foreach ( $userWords as &$word ) {
        array_push( $searchTerms, new Models\SearchTerm( $word, null, null, 1, true ) );
      }
    }

    // get terms from the document string and turn into searchTerm
    if ( $request->document ) {
      $taggedWords = $this->tagger->tagger_service( $request->document );
      foreach ( $taggedWords as &$keyword ) {
        array_push( $searchTerms, new Models\SearchTerm( $keyword->text, $keyword->type, $keyword->relevance, false ) );
      }
    }

    // get coordinates if available when tagged words include a location
    if ( $request->coord ) {
      $place = $this->$geocoder->get_locations( $request->coord );
      array_push( $searchTerms, new Models\SearchTerm( $place, 'LOCATION', 1, true ) );
    }

    // do stuff with $request
    $response = new Models\SearchResult();
    $response->orginalRequest = $request;

    $response->results = $this->search->query( $searchTerms );
    $response->count = count( $response->results );
    return $response;
  }
}
