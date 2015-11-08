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

  public function __construct( $key = null ) {
  	$this->api_key = $key;
  }

  public function get_locations( Models\GeoCoordinate $geo_coordinate ) {
  	$parser = new Support\GeoParser();
  	$mock = new Mocks\Google_Geocoder_Mock();
  	$geocoding_results = $mock->reverse_geocoding( $geo_coordinate, $this->api_key );
  	if ( $geocoding_results === 'Invalid Key' ) {
  	  return 'Invalid Key';
  	}

    return $parser->reverse_geocoder_parser( $geocoding_results );
  }
}
