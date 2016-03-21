<?php

namespace spec\SearchApi\Support;

use SearchApi;
use SearchApi\Models as Models;
use SearchApi\Providers as Providers;
use SearchApi\Support as Support;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * GeoCoderURLBuilderSpec - Spec integration test for the GeoCoderURLBuilder (higher level functions)
 */
class GoogleURLBuilderSpec extends ObjectBehavior {
  private $good_coords;

  function __construct() {
    $this->good_coords = new Models\GeoCoordinate( 40.714224, - 73.961452 );
  }

  function it_is_initializable() {
    $this->beConstructedWith( $this->good_coords );
    $this->shouldHaveType( 'SearchApi\Support\GoogleURLBuilder' );
  }

  // specific builder tests
  function it_should_return_a_string_from_the_google_builder() {
    $this-> beConstructedWith( $this->good_coords );
    $result = $this->google_url();
    $result->shouldBeString();
    $result->shouldBe( 'https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452' );
  }
  // end of builder tests
}
