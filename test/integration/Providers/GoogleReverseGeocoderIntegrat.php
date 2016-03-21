<?php

namespace integration\Providers;

use SearchApi;
use SearchApi\Models as Models;
use SearchApi\Providers as Providers;
use SearchApi\Support as Support;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * ReverseGeocoderClassSpec - Spec integration test for the ReverseGeocoderClass (higher level functions)
 */
class GoogleReverseGeocoderSpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\Providers\GoogleReverseGeocoder' );
  }

  function it_should_return_a_result_for_a_coord() {
    $geo_coordinate = new Models\GeoCoordinate( 40.714224, -73.961452 );
    $this->get_locations( $geo_coordinate )
    ->shouldBeArray();
  }

  function it_should_return_a_url_for_google() {
    $geo_coordinate = new Models\GeoCoordinate( 40.714224, -73.961452 );
    $this->get_url( $geo_coordinate )
    ->shouldBe( 'https://maps.googleapis.com/maps/api/geocode/json?'.
    "latlng={$geo_coordinate->lat},{$geo_coordinate->lng}" );
  }
}
