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
  function it_should_return_null_when_word_is_empty() {
    $result = $this->get_synonyms( null );

    $result->shouldBeNull();
  }

  function it_should_return_a_synonymn_object_when_word_not_empty() {
    $result = $this->get_synonyms( 'word' );

    $result->shouldHaveType( 'SearchApi\Models\Synonym' );
  }
  
  function it_return_a_synonym_containing_synonyms() {
    $result = $this->get_synonyms( 'word' );

    $result->synonyms->shouldHaveCount( 3 );
  }
}
