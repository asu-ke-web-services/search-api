<?php

namespace spec\SearchApi\Providers;

use SearchApi;
use SearchApi\Models as Models;
use SearchApi\Providers as Providers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * GoogleReverseGeocoderSpec - Spec integration test for the Google Reverse Geocoder (higher level functions)
 */
class GoogleReverseGeocoderSpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\Providers\GoogleReverseGeocoder' );
  }
  
  function it_should_have_key_null() {
  	$this->api_key->shouldBe( NULL );
  }

  function it_should_return_a_result() {
  	$this->api_key = 'geokey';
  	$geo_cordinate = new Models\GeoCoordinate( 123, 456 );
  	$this->get_locations( $geo_cordinate )
  	->shouldReturn( '277 Bedford Avenue, Brooklyn, NY 11211, USA' );
  }  

  function it_should_throw_invalid_key() {
  	$this->beConstructedWith( 'bad_key_test' );
  	$geo_cordinate = new Models\GeoCoordinate( 123, 456 );
    $this->shouldThrow( new \InvalidArgumentException( 'Invalid Key' ) )
    ->during( 'get_locations', array( $geo_cordinate ) );
  }
}
