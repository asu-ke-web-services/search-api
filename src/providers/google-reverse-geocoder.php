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
  	// check if need to ad key to url
    if ( $this->api_key === null ) {
      // add code to append key to url
    }

    // add "service" call
    // temp mock results of service call
    $geocoding_results = '"results from geocoding" : "results"';

    // checks if valid key -> will be romoved after service call implemented
    // and if key is used
    if ( $this->api_key !== 'geokey' && $this->api_key !== null ) {
      // For now: set results to error message to indicate a bad key -> will be removed
      $geocoding_results =
      '{'.
		  '  "error_message": "The provided API key is invalid.",'.
		  '  "results": [],'.
		  '  "status": "REQUEST_DENIED"'.
	    '}';
    }
    // else: build service call with key
    return $this->geo_parser->reverse_geocoder_parser( $geocoding_results );
  }
}
