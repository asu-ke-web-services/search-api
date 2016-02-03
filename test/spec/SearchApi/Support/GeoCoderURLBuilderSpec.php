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
class GeoCoderURLBuilderSpec extends ObjectBehavior {
  function good_coord() {
    return new Models\GeoCoordinate( 40.714224, -73.961452 );
  }

  function it_is_initializable() {
    $this->beConstructedWith( $this->good_coord() );
    $this->shouldHaveType( 'SearchApi\Support\GeoCoderURLBuilder' );
  }

  function it_should_return_a_result_without_picked_url() {
    $this->beConstructedWith( $this->good_coord() );
    $this->url_selector( null )
    ->shouldBeString();
  }

  function it_should_return_a_result_with_google_url_picked() {
    $this->beConstructedWith( $this->good_coord() );
    $this->url_selector( 'Google' )
    ->shouldBeString();
  }

  // specific builder tests
  function it_should_return_a_string_from_the_google_builder() {
    $this-> beConstructedWith( $this->good_coord() );
    $this->google_url()->shouldBeString();
  }
  // end of builder tests
}
