<?php

namespace spec\SearchApi\Providers;

use SearchApi;
use SearchApi\Models;
use SearchApi\Services\Search;
use SearchApi\Builders\QueryBuilder;
use SearchApi\Commands;

use PhpSpec\ObjectBehavior;

/**
 * PosTaggerSpec test for PosTagger
 */
class PosTaggerSpec extends ObjectBehavior {

  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\Providers\PosTagger' );
  }

  // All functions should handle the null case
  function its_functions_should_handle_null() {
    $this->tagger_service( null )->shouldReturn( null );
  }

  // The tagger service should return a nested array object
  function it_should_return_array_of_keywords() {
    // Test a single function call instead of several
    $test_result = $this->tagger_service( 'sample request phrase' );

    // The results should be an array
    $test_result->shouldBeArray();
    $test_result->shouldHaveCount( 3 );

    // Each item in the resulting array should have a specific structure
    foreach ( $test_result as $result ) {
      $result->shouldHaveType( Keyword );
    }
  }
}
