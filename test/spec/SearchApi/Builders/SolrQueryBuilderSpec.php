<?php

namespace spec\SearchApi\Builders;

use SearchApi;
use SearchApi\Models;
use SearchApi\Builders\SolrQueryBuilder;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * SolrQueryBuilderSpec - Spec test for SolrQueryBuilder
 */
class SolrQueryBuilderSpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\Builders\SolrQueryBuilder' );
  }

  function it_returns_a_string() {
    $keyword = new Models\SearchTerm( 'test' );
    $keywords = array( $keyword );
    $this->build( $keywords )->shouldBeString();
  }
}
