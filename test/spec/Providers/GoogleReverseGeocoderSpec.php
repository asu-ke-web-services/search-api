<?php

namespace spec\Providers;

use SearchApi;
use SearchApi\Models as Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * GoogleReverseGeocoderSpec - Spec integration test for the Google Reverse Geocoder (higher level functions)
 */
class GoogleReverseGeocoderSpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\Providers\GoogleReverseGeocoder' );
  }
  
  function it_should_return_a_result() {
  	$geo_cordinate = new Models\GeoCoordinate( 123, 456 );
  	$key = 'geokey';
  	$this->reverse_geocoding_with_latlin( $geo_cordinate, $key );
  }
  
  function it_should_return_invalid_key() {
  	$this->reverse_geocoding_with_latlin( 'place_id_var', 'bad_key_test_var')
  	  ->shouldBeCalled()->willReturn( 'Invalid Key' );
  }
}
