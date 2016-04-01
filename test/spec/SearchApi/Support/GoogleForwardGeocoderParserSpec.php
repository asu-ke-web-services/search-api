<?php

namespace spec\SearchApi\Support;

use SearchApi;
use SearchApi\Models as Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * GoogleForwardGeocoderParserSpec - Spec test for the GoogleReverseGeocoderParser (higher level functions)
 */
class GoogleForwardGeocoderParserSpec extends ObjectBehavior {
  private $geo_coord_response = '{"results": [{"formatted_address": "Arizona, USA",
      "geometry": {"bounds": {"northeast": {"lat": 37.0042599,"lng": -109.0452231
      },"southwest": {"lat": 31.3321771,"lng": -114.8165909}},"location": {
      "lat": 34.0489281,"lng": -111.0937311},"location_type": "APPROXIMATE",
      "viewport": {"northeast": {"lat": 37.0042599,"lng": -109.0452231},"southwest": {
      "lat": 31.3321771,"lng": -114.8165909}}},"place_id": "ChIJaxhMy-sIK4cRcc3Bf7EnOUI"
      }],"status": "OK"}';

  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\Support\GoogleForwardGeocoderParser' );
  }

  // Reverse_Geocoder_Google_Parser tests
  function it_should_return_an_empty_array_when_passed_null() {
    $result = $this->google_forward_geocoder_parser( null );
    $result->shouldBeArray();
    $result->shouldHaveCount( 0 );
  }

  function it_should_return_an_empty_array_when_passed_empty_array() {
    $result = $this->google_forward_geocoder_parser( array() );
    $result->shouldBeArray();
    $result->shouldHaveCount( 0 );
  }

  function it_should_return_an_empty_array_when_passed_bad_formatted_array() {
    $result = $this->google_forward_geocoder_parser( array( 'a', 'b', 'f' ) );
    $result->shouldBeArray();
    $result->shouldHaveCount( 0 );
  }

  function it_should_return_an_array_of_GeoCoordinates() {
    // turning test string into json_decoder array
    $google_test_string = json_decode( $this->geo_coord_response, true );

    // checking it is array and has 2 elements
    $result = $this->google_forward_geocoder_parser( $google_test_string );
    $result->shouldBeArray();
    $result->shouldHaveCount( 1 );

    // checking the coordinates
    $value_checker = $result[0];
    $value_checker->lat->shouldBe( 34.0489281 );
    $value_checker->lng->shouldBe( -111.0937311 );
  }
  // end of reverse_geocoder_parser tests
}
