<?php

namespace spec\SearchApi\Providers;

use SearchApi\Models\Keyword;
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

  // The tagger results should be converted to keywords
  function it_should_return_array_keywords() {
    // Test a single function call instead of several
    $test_result = $this->results_to_keywords( $this->get_tags( 'sample request phrase' ) );

    // The keyword type should have the correct data types
    $test_result->shouldBeArray();
    $test_result[0]->text->shouldBeString();
    $test_result[0]->type->shouldBeString();
    $test_result[0]->relevance->shouldBeDouble();
    $test_result[0]->occurences->shouldBeInt();

    // 'text' data should match request string words
    $test_result->shouldHaveCount( 3 );
    $test_result[0]->text->shouldReturn( 'sample' );
    $test_result[1]->text->shouldReturn( 'request' );
    $test_result[2]->text->shouldReturn( 'phrase' );
  }

  function it_should_return_keywords_match() {
    $keyword1 = new Keyword( 'Arizona', 'place', 1.0, 1 );

    $result = $this->compare_text( $keyword1, $keyword1 );

    $result->shouldBeInt();
    $result->shouldEqual( 0 );
  }

  function it_should_return_keywords_not_match() {
    $keyword1 = new Keyword( 'Arizona', 'place', 1.0, 1 );
    $keyword2 = new Keyword( 'Texas', 'place', 1.0, 1 );

    $result = $this->compare_text( $keyword1, $keyword2 );

    $result->shouldBeInt();
    $result->shouldNotEqual( 0 );
  }

  function it_should_condense_keywords_to_one() {
    $keywords = array();
    array_push( $keywords, new Keyword( 'Arizona', 'place', 1.0, 1 ) );
    array_push( $keywords, new Keyword( 'Texas', 'place', 1.0, 1 ) );
    array_push( $keywords, new Keyword( 'Arizona', 'place', 1.0, 1 ) );
    array_push( $keywords, new Keyword( 'Texas', 'place', 1.0, 1 ) );
    array_push( $keywords, new Keyword( 'Arizona', 'place', 1.0, 1 ) );

    $result = $this->condense_keywords( $keywords );
    $result->shouldBeArray();
    $result->shouldHaveCount( 2 );
    $result[0]->text->shouldBeString( 'Arizona' );
    $result[0]->occurences->shouldEqual( 3 );
    $result[1]->occurences->shouldEqual( 2 );
  }

  function it_should_not_condense_unique_keywords() {
    $keywords = array();
    array_push( $keywords, new Keyword( 'Arizona', 'place', 1.0, 1 ) );
    array_push( $keywords, new Keyword( 'Texas', 'place', 1.0, 1 ) );
    array_push( $keywords, new Keyword( 'California', 'place', 1.0, 1 ) );

    $result = $this->condense_keywords( $keywords );
    $result->shouldBeArray();
    $result->shouldHaveCount( 3 );
  }
}
