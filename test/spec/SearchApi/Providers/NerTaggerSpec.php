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

  function its_functions_should_handle_null() {
    $this->call_tagger_service( null )->shouldReturn( null );
    $this->parse_tagger_results( null )->shouldReturn( null );
    $this->result_to_keyword( null )->shouldReturn( null );

    $this->get_tags( null )->shouldReturn( null );
  }

  function it_should_return_xml_string() {
    $this->call_tagger_service( 'test' )->shouldBeString();
    $this->call_tagger_service( 'phoenix arizona' )->shouldReturn( '<wi num="0" entity="O">phoenix</wi> <wi num="1" entity="O">arizona</wi>' );
  }

  function it_should_return_array_strings() {
    $test_result = $this->parse_tagger_results( '<wi num="0" entity="O">phoenix</wi>' );
    $test_result->shouldBeArray();
    $test_result->shouldContain( '<wi num="0" entity="O">phoenix</wi>' );
  }

  function it_should_count_correctly() {
    $test_input = '<wi num="0" entity="O">phoenix</wi>';

    for ( $count = 1; $count <= 10; $count++ ) {
      $this->parse_tagger_results( $test_input )->shouldHaveCount( $count );
      $test_input = $test_input . ' <wi num="0" entity="O">phoenix</wi>';
    }
  }

  function it_should_return_array_keywords() {
    $test_result = $this->result_to_keyword( '<wi num="0" entity="O">phoenix</wi>' );
    $test_result->shouldBeArray();
    $test_result[0]->text->shouldBeString();
    $test_result[0]->type->shouldBeString();
    $test_result[0]->relevance->shouldBeDouble();
  }
}
