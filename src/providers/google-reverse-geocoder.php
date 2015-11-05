<?php

namespace SearchApi\Providers;

use SearchApi\Models as Models;
use SearchApi\Test\Support\Mocks as Mocks;
use SearchApi\Support as Support;
use SearchApi\Services\ReverseGeocoder as ReverseGeocoder;

/**
 * Class GoogleReverseGeocoder - Given a latlin or place id to find a point or polygon that can represent that
 * location via GoogleMaps.
 */
class GoogleReverseGeocoder implements ReverseGeocoder {
  public function reverse_geocoding_with_latlng( Models\GeoCoordinate $geo_coordinate, $key ) {
  	$parser = new Support\Geo_Parser();

    $geocoding_results = Mocks\Google_Geocoder_Mock::reverse_geocoding( $geo_coordinate, $key );
    return $parser->reverse_geocoder_parser( $geocoding_results );
  }

  public function reverse_geocoding_with_place_id( $place_id, $key ) {
  	$parser = new Support\Geo_Parser();

  	$geocoding_results = Mocks\Google_Geocoder_Mock::reverse_geocoding( $place_id, $key );
  	return $parser->reverse_geocoder_parser( $geocoding_results );
  }
}
