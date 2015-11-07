<?php

namespace SearchApi\Providers;

use SearchApi\Models as Models;
use SearchApi\Support as Support;
use SearchApi\Services\ReverseGeocoder as ReverseGeocoder;

/**
 * Class GoogleReverseGeocoder - Given a latlin or place id to find a point or polygon that can represent that
 * location via GoogleMaps.
 */
class GoogleReverseGeocoder implements ReverseGeocoder {
  public function get_locations( Models\GeoCoordinate $geo_coordinate ) {
  	$parser = new Support\Geo_Parser();

    //$geocoding_results = Mocks\Google_Geocoder_Mock reverse_geocoding( $geo_coordinate, $key );
    return $parser->reverse_geocoder_parser( $geocoding_results );
  }
}
