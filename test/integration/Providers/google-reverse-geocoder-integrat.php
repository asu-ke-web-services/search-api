<?php

namespace integration\Providers;

use SearchApi;
use SearchApi\Models as Models;
use SearchApi\Providers as Providers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * GoogleReverseGeocoder_Integration_Test - integration test for the ReverseGeocoderClass (higher level functions)
 */
class GoogleReverseGeocoder_Integration_Test extends ObjectBehavior {
  function it_should_return_a_result_for_a_coord() {
    // setting up and executing the reverse geo coder
    $geo_coordinate = new Models\GeoCoordinate( 40.714224, -73.961452 );
    $google_geocoder = new Providers\GoogleReverseGeocoder();
    $google_results = $google_geocoder->get_locations( $geo_coordinate );

    // checking if the array is returned with the correct format
    $this->assertNotEmpty( $google_results );
    $this->assertCount( 2, $google_results );
    $this->assertContainsOnlyInstancesOf( Models\SearchTerm(), $google_results );

    // testing the results of the array
    // checking element 1
    $results_checker = $google_results[0];
    $this->assertEquals( 'Bedford Avenue', $results_checker->value );
    $this->assertEquals( 1, $results_checker->count );

    // checking element 2
    $results_checker = $google_results[1];
    $this->assertEquals( 'Williamsburg', $results_checker->value );
    $this->assertEquals( 3, $results_checker->count );
  }
}
