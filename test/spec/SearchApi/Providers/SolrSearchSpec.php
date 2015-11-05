<?php

namespace spec\SearchApi\Providers;

use SearchApi;
use SearchApi\Models;
use SearchApi\Services\Search;
use SearchApi\Builders\QueryBuilder;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * SolrSearchSpec - Spec test for SolrSearch
 */
class SolrSearchSpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\Providers\SolrSearch' );
  }

  function it_should_call_query_builder( QueryBuilder $queryBuilder ) {
    $this->beConstructedWith( $queryBuilder );

    $queryBuilder->build( 'test', null )->shouldBeCalled();

    $this->query( 'test' );
  }

  function it_should_return_null_when_keywords_empty() {
    $result = $this->query( null );

    $result->shouldBeNull();
  }

  function it_should_return_search_result_when_keywords_not_empty() {
    $keywords = array( new Models\SearchTerm( 'test' ) );
    $result = $this->query( $keywords );

    $result->shouldHaveType( 'SearchApi\Models\SearchResult' );
  }
}
