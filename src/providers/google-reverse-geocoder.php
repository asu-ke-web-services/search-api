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
  public $api_key;
	private $geo_parser;

  public function __construct( $key = NULL, $parser = NULL ) {
  	$this->api_key = $key;
  	$this->geo_parser = $parser;
  }

  public function get_locations( Models\GeoCoordinate $geo_coordinate ) {
  	$mock = new Mocks\Google_Geocoder_Mock();
  	$geocoding_results = $mock->reverse_geocoding( $geo_coordinate, $this->api_key );
  	if ( $geocoding_results === 'Invalid Key' ) {
  	  return 'Invalid Key';
  	}

    return $this->geo_parser->reverse_geocoder_parser( $geocoding_results );
  }
}
