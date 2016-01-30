<?php

namespace spec\SearchApi\Providers;

use SearchApi;
use SearchApi\Models as Models;
use SearchApi\Providers as Providers;
use SearchApi\Support as Support;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * GeoCoderURLBuilderSpec - Spec integration test for the GeoCoderURLBuilder (higher level functions)
 */
class GeoCoderURLBuilderSpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\Providers\GeoCoderURLBuilder' );
  }

  function it_shouldnt_have_an_api_key_by_default() {
    $this->api_key->shouldBe( null );
  }

  function it_should_return_a_result_without_key() {
    $this->beConstructedWith( null, new Support\GeoParser );
    $geo_cordinate = new Models\GeoCoordinate( 40.714224, -73.961452 );
    $this->get_locations( $geo_cordinate )
    ->shouldBeArray();
  }

  function it_should_return_a_result_with_key() {
    $this->beConstructedWith( 'geokey', new Support\GeoParser );
    $geo_cordinate = new Models\GeoCoordinate( 40.714224, -73.961452 );
    $this->get_locations( $geo_cordinate )
    ->shouldBeArray();
  }

  function it_should_throw_invalid_key() {
    $this->beConstructedWith( 'bad_key_test', new Support\GeoParser );
    $geo_cordinate = new Models\GeoCoordinate( 40.714224, -73.961452 );
    $this->shouldThrow( new \Exception( 'Invalid Key' ) )
    ->during( 'get_locations', array( $geo_cordinate ) );
  }
}