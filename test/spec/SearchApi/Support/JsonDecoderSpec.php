<?php

namespace spec\SearchApi\Support;

use SearchApi;
use SearchApi\Models as Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * JsonDecoderSpec - Spec  test for the JsonDecoder (higher level functions)
 */
class JsonDecoderSpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\Support\JsonDecoder' );
  }

  // reverse_geocoder_json_decoder tests
  function it_should_return_a_string() {
    $results = $this->reverse_geocoder_json_decoder( '{"test" : "test"}' );
    $results->shouldBeArray();
  }

  function it_should_throw_invalid_key() {
    $this->shouldThrow( new \Exception( 'Invalid Key' ) )
    ->during( 'reverse_geocoder_json_decoder', array( '{"status" : "REQUEST_DENIED"}' ) );
  }

  function it_should_throw_invalid_json_string() {
    $this->shouldThrow( new \Exception( 'Invalid Json String' ) )
    ->during( 'reverse_geocoder_json_decoder', array( '{"status" : "REQUEST_Apples"}' ) );
  }

  function it_should_throw_invalid_json_object() {
    $this->shouldThrow( new \Exception( 'Invalid Json Object' ) )
    ->during( 'reverse_geocoder_json_decoder', array( '{bad_json : isbad}' ) );
  }
  // end of reverse_geocoder_json_decoder tests
}
