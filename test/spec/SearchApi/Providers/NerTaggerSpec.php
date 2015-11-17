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
    $this->call_tagger_service( null )->shouldReturn( null );
    $this->results_to_keywords( null )->shouldReturn( null );

    $this->get_tags( null )->shouldReturn( null );
  }

  // The tagger service should return a nested array object
  function it_should_return_nested_array() {
    // Test a single function call instead of several
    $test_result = $this->call_tagger_service( 'test' );

    $test_result->shouldBeArray();
    for ( $count = 0; $count < count( $test_result ); $count++ ) {
      $test_result[ $count ]->shouldBeArray();
      $test_result[ $count ]->shouldHaveCount( 2 );
      $test_result[ $count ][0]->shouldBeString();
      $test_result[ $count ][1]->shouldBeString();
    }

    // Tests only for dummy return values
    $test_result->shouldHaveCount( 6 );
    $test_result[0][0]->shouldReturn( 'Phoenix' );
    $test_result[0][1]->shouldReturn( 'LOCATION' );
  }

  // The tagger results should be converted to keywords
  function it_should_return_array_keywords() {
    // Test a single function call instead of several
    $test_result = $this->results_to_keywords( $this->call_tagger_service( 'test' ) );

    $test_result->shouldBeArray();
    $test_result[0]->text->shouldBeString();
    $test_result[0]->type->shouldBeString();
    $test_result[0]->relevance->shouldBeDouble();

    // Tests only for dummy return values
    $test_result->shouldHaveCount( 6 );
    $test_result[0]->text->shouldReturn( 'Phoenix' );
    $test_result[0]->type->shouldReturn( 'LOCATION' );
    $test_result[0]->relevance->shouldReturn( 1.0 );
    $test_result[1]->relevance->shouldReturn( 0.5 );
  }
}
