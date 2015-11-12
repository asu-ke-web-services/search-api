<?php

namespace SearchApi\Providers;

use SearchApi\Models as Models;
use SearchApi\Support as Support;
use SearchApi\Test\Support\Mocks as Mocks;
use SearchApi\Services\ReverseGeocoder as ReverseGeocoder;

/**
 * Class GoogleReverseGeocoder - Given a latlin or place id to find a point or polygon that can represent that
 * location via GoogleMaps.
 */
class GoogleReverseGeocoder implements ReverseGeocoder {
  public $api_key; // service key
  private $geo_parser; // injected parser

  public function __construct( $key = null, $parser = null ) {
  	$this->api_key = $key;

  	if ( $parser === null ) {
      // default parser
      $parser = new Support\GeoParser;
  	}
  	$this->geo_parser = $parser;
  }

  // returns array of terms based on latitude and longitude
  public function get_locations( Models\GeoCoordinate $geo_coordinate ) {
  	// removing this soon vvv
  	$mock = new Mocks\Google_Geocoder_Mock();
    // "service" call
  	$geocoding_results = $mock->reverse_geocoding( $geo_coordinate, $this->api_key );

  	// check if need to add a key to the service call
  	// currently after mock call -> will go to before service call once implemented
  	if ( $this->api_key === null ) {
  	  return $this->geo_parser->reverse_geocoder_parser( $geocoding_results );
  	} else {
      // checks if valid key -> will be romoved after service call implemented
      if ( $this->api_key !== 'geokey' ) {
      	// For now: set results to error message to indicate a bad key -> will be removed
        $geocoding_results = $mock->error_message;
      }
      // else: build service call with key
      return $this->geo_parser->reverse_geocoder_parser( $geocoding_results );
  	}
  }
}
