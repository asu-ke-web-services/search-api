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
    $this->beConstructedWith( new Models\GeoCoordinate( 40.714224, -73.961452 ) );
    $this->shouldHaveType( 'SearchApi\Providers\GeoCoderURLBuilder' );
  }

  function it_should_return_a_result_without_picked_url() {
    $this->beConstructedWith( new Models\GeoCoordinate( 40.714224, -73.961452 ) );
    $this->Url_Selector( null )
    ->shouldHaveType('String');
  }

  function it_should_return_a_result_with_google_url_picked() {
    $this->beConstructedWith( new Models\GeoCoordinate( 40.714224, -73.961452 ) );
    $this->Url_Selector( 'Google' )
    ->shouldHaveType('String');
  }

  // specific builder tests
  function it_should_return_a_string_from_the_google_builder() {
    $this-> beConstructedWith( new Models\GeoCoordinate( 40.714224, -73.961452 ) );
    $this->Google_URL()->shouldHaveType( 'String' );
  }
  // end of builder tests
}