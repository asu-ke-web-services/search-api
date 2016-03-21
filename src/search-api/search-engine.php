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
      $api_path = preg_replace( '~[\r\n]+~', '', Configuration::get_instance()->get( 'SolrApiUrl' ) );
      $this->search = new Providers\SolrSearch( null, null, $api_path );
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
    // the terms that will be sent to the query builder
    $search_terms = array();

    // the keywords from the
    $tagged_words = array();

    // explode user keywords
    if ( $request->text ) {
      $user_words = explode( ' ' , $request->text );
      foreach ( $user_words as &$word ) {
        array_push( $search_terms, new Models\SearchTerm( $word, null, null, 1, true ) );
      }
    }

    // get terms from the document string and turn into searchTerm
    if ( $request->document ) {
      $tagged_words = $this->tagger->tagger_service( $request->document );
      foreach ( $tagged_words as &$keyword ) {
        array_push( $search_terms, new Models\SearchTerm( $keyword->text, $keyword->type, $keyword->relevance, false ) );
      }
    }

    // get coordinates if available when tagged words include a location
    if ( $request->coord ) {
      $place = $this->$geocoder->get_locations( $request->coord );
      array_push( $search_terms, new Models\SearchTerm( $place, 'LOCATION', 1, true ) );
    }

    // do stuff with $request
    $response = new Models\SearchResult();
    $response->original_request = $request;

    $response->results = $this->search->query( $search_terms );
    $response->count = count( $response->results );
    return $response;
  }
}
