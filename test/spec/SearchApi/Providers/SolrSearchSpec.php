<?php

namespace spec\SearchApi\Providers;

use SearchApi;
use SearchApi\Models;
use SearchApi\Services\Search;
use SearchApi\Builders\QueryBuilder;
use SearchApi\Commands;

use PhpSpec\ObjectBehavior;

/**
 * SolrSearchSpec - Spec test for SolrSearch
 */
class SolrSearchSpec extends ObjectBehavior {

  private $queryResponse = '{"response":{"numFound":1,"start":0,"docs":[{"id":"testid","author":"testauthor","date":"testdate","content":"testcontent"}]}}';

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

  function it_should_return_search_result_when_keywords_not_empty( QueryBuilder $queryBuilder, Commands\HttpGet $httpGetCommand ) {
    $this->beConstructedWith( $queryBuilder, $httpGetCommand, 'url/' );
    $queryBuilder->build( 'test', null )->willReturn( 'test_query' );
    $httpGetCommand->execute()->shouldBeCalled()->willReturn( $this->queryResponse );
    $httpGetCommand->setUrl( 'url/test_query' )->shouldBeCalled();

    $result = $this->query( 'test' );
    $result->shouldHaveType( 'SearchApi\Models\SearchResult' );
    $result->count->shouldBe( 1 );
  }

  function it_should_parse_valid_query_response() {
    $this->parse_query_response( $this->queryResponse )->shouldHaveType( 'SearchApi\Models\SearchResult' );
  }

  function it_should_have_query_response_parser_return_null_if_input_empty() {
    $this->parse_query_response( '' )->shouldBe( null );
  }
}
