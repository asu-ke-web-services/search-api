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
  	$this->reverse_geocoder_parser( 'test' )->shouldBeCalled()
  	->shouldReturn( '277 Bedford Avenue, Brooklyn, NY 11211, USA' );
  }
}
