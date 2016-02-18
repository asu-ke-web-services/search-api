<?php

namespace spec\SearchApi\Providers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * NerTaggerSpec - Spec integration test for the NER Tagger
 */
class NerTaggerSpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\Providers\NerTagger' );
  }

  // All functions should handle the null case
  function its_functions_should_handle_null() {
    $this->tagger_service( null )->shouldReturn( null );
    $this->results_to_keywords( null )->shouldReturn( null );

    $this->get_tags( null )->shouldReturn( null );
  }

  // The tagger service should return a nested array object
  function it_should_return_nested_array() {
    // Test a single function call instead of several
    $test_result = $this->tagger_service( 'sample request phrase' );

    // The results should be an array
    $test_result->shouldBeArray();
    $test_result->shouldHaveCount( 3 );

    // Each item in the resulting array should have a specific structure
    foreach ( $test_result as $result ) {
      $result->shouldBeArray();
      $result->shouldHaveCount( 2 );
      $result[0]->shouldBeString();
      $result[1]->shouldBeString();
    }
  }

  // The results should have the same count as the number of request terms
  function its_length_should_match_term_count() {
    $test_request = '';

    // Keep adding terms and verify that the results match the request's term count
    for ( $count = 1; $count <= 3; $count++ ) {
      $test_request .= 'term ';
      $test_result = $this->tagger_service( $test_request );

      $test_result->shouldBeArray();
      $test_result->shouldHaveCount( $count );
    }
  }

  // The tagger results should be converted to keywords
  function it_should_return_array_keywords() {
    // Test a single function call instead of several
    $test_result = $this->results_to_keywords( $this->tagger_service( 'sample request phrase' ) );

    // The keyword type should have the correct data types
    $test_result->shouldBeArray();
    $test_result[0]->text->shouldBeString();
    $test_result[0]->type->shouldBeString();
    $test_result[0]->relevance->shouldBeDouble();

    // 'text' data should match request string words
    $test_result->shouldHaveCount( 3 );
    $test_result[0]->text->shouldReturn( 'sample' );
    $test_result[1]->text->shouldReturn( 'request' );
    $test_result[2]->text->shouldReturn( 'phrase' );
  }
}
