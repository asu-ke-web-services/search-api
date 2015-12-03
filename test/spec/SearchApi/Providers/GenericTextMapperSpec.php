<?php

namespace spec\SearchApi\Providers;

use SearchApi;
use SearchApi\Models;
use SearchApi\Services\TextMapper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * GenericTextMapperSpec - Spec test for GenericTextMapper
 */
class GenericTextMapperSpec extends ObjectBehavior {
  function it_should_return_null_when_input_is_empty() {
    $result = $this->get_synonyms( null );

    $result->shouldBeNull();
  }

  function it_should_return_a_countable_array_when_input_not_empty() {
    $result = $this->get_synonyms( array( 'smelly', 'cat' ) );

    $result->shouldHaveCount( 2 );
  }

  function it_returns_an_array_of_type_synonym_containing_synonyms() {
    $result = $this->get_synonyms( array( 'smelly', 'cat' ) );

    $result[0]->synonyms->shouldNotBeNull();
  }
}
