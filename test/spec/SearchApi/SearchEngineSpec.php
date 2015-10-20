<?php

namespace spec\SearchApi;

use SearchApi;
use SearchApi\Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * SearchEngineSpec - Spec integration test for the search engine (higher level functions)
 */
class SearchEngineSpec extends ObjectBehavior {

  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\SearchEngine' );
  }

  function it_should_handle_requests() {
    $empty_search_request = new Models\SearchRequest();
    $this->handle_request( $empty_search_request )->shouldReturnAnInstanceOf( 'SearchApi\Models\SearchResult' );
  }

  /** Initial specifications */
  function it_should_return_non_empty_results() {
    $request = new Models\SearchRequest();
    $request->text = 'foo';
    $search_results = $this->handle_request( $request );
    $search_results->results->shouldNotBeEmpty();
  }

  function it_should_return_multiple_results() {
    $request = new Models\SearchRequest();
    $request->text = 'foo';
    $search_results = $this->handle_request( $request );
    $search_results->count->shouldBeGreaterThan( 0 );
  }

  function it_should_return_the_search_text_in_results() {
    $request = new Models\SearchRequest();
    $request->text = 'foo';
    $search_results = $this->handle_request( $request );
    $search_results->results->shouldContain( 'foo' );
  }

}
