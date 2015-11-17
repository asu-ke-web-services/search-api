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

  function it_should_return_a_result() {
  	$this->reverse_geocoder_parser( '{"test":"test"}' )->shouldBeString();
  }
  
  function it_should_throw_invalid_key() {
  	$this->shouldThrow( new \Exception( 'Invalid Key' ) )
  	->during( 'reverse_geocoder_parser', array( '{"status" : "REQUEST_DENIED"}' ) );
  }
  
  function it_should_throw_invalid_json_object() {
  	$this->shouldThrow( new \Exception( 'Invalid Json Object' ) )
  	->during( 'reverse_geocoder_parser', array( '{bad_json : isbad}' ) );
  }
}
