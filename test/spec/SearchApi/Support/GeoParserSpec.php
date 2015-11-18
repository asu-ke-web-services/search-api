<?php

namespace spec\SearchApi\Support;

use SearchApi;
use SearchApi\Models as Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * GeoParserSpec - Spec integration test for the Geo Parser Geocoder (higher level functions)
 */
class GeoParserSpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\Support\GeoParser' );
  }

  // reverse_geocoder_json_decoder tests
  function it_should_throw_invalid_key() {
  	$this->shouldThrow( new \Exception( 'Invalid Key' ) )
  	->during( 'reverse_geocoder_json_decoder', array( '{"status" : "REQUEST_DENIED"}' ) );
  }

  function it_should_throw_invalid_json_object() {
  	$this->shouldThrow( new \Exception( 'Invalid Json Object' ) )
  	->during( 'reverse_geocoder_json_decoder', array( '{bad_json : isbad}' ) );
  }
  // end of reverse_geocoder_json_decoder tests

  // reverse_geocoder_parser tests
  function it_should_return_an_empty_array_when_passed_null() {
  	$result = $this->reverse_geocoder_parser( null );
  	$result->shouldBeArray();
  	$result->shouldHaveCount( 0 );
  }

  function it_should_return_an_empty_array_when_passed_empty_array() {
  	$result = $this->reverse_geocoder_parser( array() );
  	$result->shouldBeArray();
  	$result->shouldHaveCount( 0 );
  }

  function it_should_return_an_empty_array_when_passed_bad_formatted_array() {
  	$result = $this->reverse_geocoder_parser( array( 'a', 'b', 'f' ) );
  	$result->shouldBeArray();
  	$result->shouldHaveCount( 0 );
  }
  // end of reverse_geocoder_parser tests

  // combined reverse_geocoder_json_decoder and reverse_geocoder_parser tests
  function it_should_return_an_empty_array_after_json_decoding_and_parsing() {
  	$result = $this->reverse_geocoder_json_decoder( '{"test":"test"}' );
  	$result = $this->reverse_geocoder_parser( $result );
  	$result->shouldBeArray();
  	$result->shouldHaveCount( 0 );
  }
  // end of combined reverse_geocoder_json_decoder and reverse_geocoder_parser tests
}
