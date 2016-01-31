<?php

namespace spec\SearchApi\Providers;

use SearchApi;
use SearchApi\Models as Models;
use SearchApi\Providers as Providers;
use SearchApi\Support as Support;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * ReverseGeocoderClassSpec - Spec integration test for the ReverseGeocoderClass (higher level functions)
 */
class ReverseGeocoderClassSpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->beConstructedWith( null, null );
    $this->shouldHaveType( 'SearchApi\Providers\ReverseGeocoderClass' );
  }

  function it_should_return_google_as_default_urlbuilder() {
    $this->beConstructedWith( null, null );
    $this->get_Url_Pick()->shouldReturn( 'Google' );
  }

  function it_should_return_google_as_default_parser() {
    $this->beConstructedWith( null, null );
    $this->get_Parser_Pick()->shouldReturn( 'Google' );
  }

  function it_should_return_a_result_without_picking_urlbuilder_or_parser() {
    $this->beConstructedWith( null, null );
    $geo_cordinate = new Models\GeoCoordinate( 40.714224, -73.961452 );
    $this->get_locations( $geo_cordinate )
    ->shouldBeArray();
  }

  function it_should_return_a_result_with_google_urlbuilder() {
    $this->beConstructedWith( 'Google', null );
    $geo_cordinate = new Models\GeoCoordinate( 40.714224, -73.961452 );
    $this->get_locations( $geo_cordinate )
    ->shouldBeArray();
  }

  function it_should_return_a_result_with_google_parser() {
    $this->beConstructedWith( null, 'Google' );
    $geo_cordinate = new Models\GeoCoordinate( 40.714224, -73.961452 );
    $this->get_locations( $geo_cordinate )
    ->shouldBeArray();
  }

  function it_should_return_a_result_with_google_urlbuild_and_parser() {
    $this->beConstructedWith( 'Google', 'Google' );
    $geo_cordinate = new Models\GeoCoordinate( 40.714224, -73.961452 );
    $this->get_locations( $geo_cordinate )
    ->shouldBeArray();
  }
}
