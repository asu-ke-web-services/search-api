<?php

namespace spec\SearchApi\Providers;

use SearchApi;
use SearchApi\Models;
use SearchApi\Services\Search;
use SearchApi\Builders\QueryBuilder;
use SearchApi\Clients\HttpClient;

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

  function it_should_return_search_result_when_keywords_not_empty( QueryBuilder $queryBuilder, HttpClient $httpClient ) {
    $queryBuilder->build( 'test', null )->willReturn( 'test2' );
    $httpClient->get( Argument::any() )->willReturn( '{"responseHeader":{"response":{"numFound":1,"start":0,"docs":[{"id":"testid","author":"testauthor","date":"testdate","content":"testcontent"}]}}' );

    $result = $this->query( 'test' );
    $result->shouldHaveType( 'SearchApi\Models\SearchResult' );
    $result->count->shouldBe( 1 );
  }
}
