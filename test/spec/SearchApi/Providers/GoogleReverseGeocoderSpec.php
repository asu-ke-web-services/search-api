<?php

namespace spec\SearchApi\Providers;

use SearchApi;
use SearchApi\Models as Models;
use SearchApi\Providers as Providers;
use SearchApi\Support as Support;
use SearchApi\Commands as Commands;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * ReverseGeocoderClassSpec - Spec integration test for the ReverseGeocoderClass (higher level functions)
 */
class GoogleReverseGeocoderSpec extends ObjectBehavior {
  private $geo_response = '{"results": [{"address_components": 
			[{"long_name": "Bedford Avenue","short_name": "Bedford Ave","types": 
			["route"]},{"long_name": "Williamsburg","short_name": "Williamsburg","types": 
			["neighborhood","political"]}],"place_id": "ChIJd8BlQ2BZwokRAFUEcm_qrcA"},
			{"address_components": [{"long_name": "Williamsburg","short_name": 
			"Williamsburg","types": ["neighborhood","political"]}],"place_id": 
			"ChIJi27VXGBZwokRM8ErPyB91yk"}],"status": "OK"}';

  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\Providers\GoogleReverseGeocoder' );
  }

  function it_should_return_a_result_for_a_coord( Support\GoogleURLBuilder $url_builder,
    Commands\HttpGet $http_get_command ) {
    // setting up the class variables
    $geo_coordinate = new Models\GeoCoordinate( 40.714224, -73.961452 );
    $this->beConstructedWith( $url_builder, $http_get_command );

    // setting up predictions
    // url_builder predictions
    $url_builder->set_coords( Argument::type( 'SearchApi\Models\GeoCoordinate' ) )->shouldBeCalled();
    $url_builder->google_url()->shouldBeCalled()->willReturn( 'https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452' );
    // curl call predictions
    $http_get_command->setUrl( Argument::type( 'string' ) )->shouldBeCalled();
    $http_get_command->execute()->shouldBeCalled()->willReturn( $this->geo_response );

    // calling the function
    $result = $this->get_locations( $geo_coordinate );
    $result->shouldBeArray();
    $result->shouldHaveCount( 2 );

    // checking the first element value and count
    $value_checker = $result[0];
    $value_checker->value->shouldBe( 'Bedford Avenue' );
    $value_checker->count->shouldBe( 1 );

    // checking the second element value and count
    $value_checker = $result[1];
    $value_checker->value->shouldBe( 'Williamsburg' );
    $value_checker->count->shouldBe( 2 );
  }

  function it_should_return_a_url_for_google() {
    $geo_coordinate = new Models\GeoCoordinate( 40.714224, -73.961452 );
    $this->get_url( $geo_coordinate )
    ->shouldBe( 'https://maps.googleapis.com/maps/api/geocode/json?'.
    "latlng={$geo_coordinate->lat},{$geo_coordinate->lng}" );
  }
}
