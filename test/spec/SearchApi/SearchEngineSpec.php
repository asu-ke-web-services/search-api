<?php

namespace spec\SearchApi;

use SearchApi;
use SearchApi\Models;
use SearchApi\Services\Search;
use SearchApi\Services\Tagger;
use SearchApi\Services\ReverseGeocoder;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * SearchEngineSpec - Spec integration test for the search engine (higher level functions)
 */
class SearchEngineSpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\SearchEngine' );
  }

  function it_should_return_an_empty_response_when_given_an_empty_request() {
    $empty_search_request = new Models\SearchRequest();
    $this->handle_request( $empty_search_request )->shouldReturnAnInstanceOf( 'SearchApi\Models\SearchResult' );
  }

  function it_should_return_results_when_searching_for_foo( Search $search, Tagger $tagger, ReverseGeocoder $geocder) {
    $this->beConstructedWith( $search, $tagger, $geocoder );

    $foo_request = new Models\SearchRequest();
    $foo_request->document = 'arizona arid phoenix';
    $foo_request->text = 'asu school'

    $response = $this->handle_request( $foo_request );
    $response->results->shouldBeArray();
    $response->results->shouldHaveCount( 1 );
  }

}
