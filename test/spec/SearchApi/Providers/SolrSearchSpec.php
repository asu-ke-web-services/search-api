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

    $keywords = array( new Models\SearchTerm() );

    $queryBuilder->build_query( $keywords )->shouldBeCalled();

    $this->query( $keywords );
  }

  function it_should_execute_query( QueryBuilder $queryBuilder ) {
    $this->beConstructedWith( $queryBuilder );

    $keywords = array( new Models\SearchTerm() );

    $queryString = 'query';
    $queryBuilder->build_query( Argument::any() )->shouldBeCalled()->willReturn( $queryString );

    $this->execute_query( $queryString )->shouldBeCalled();

    $this->query( $keywords );
  }

  function it_should_return_search_result_if_keywords_are_nonempty( QueryBuilder $queryBuilder ) {
    $this->beConstructedWith( $queryBuilder );

    $keywords = array( new Models\SearchTerm() );

    $queryBuilder->build_query( Argument::any() )->shouldBeCalled();
    $this->execute_query( Argument::any() )->shouldBeCalled()->willReturn( );

    $searchResult = new Models\SearchResult();
    $this->parse_result( Argument::any() )->shouldBeCalled()->willReturn( $searchResult );

    $result = $this->query( $keywords );
    $result->shouldHaveType( 'SearchApi\Models\SearchResult' );
  }
}
