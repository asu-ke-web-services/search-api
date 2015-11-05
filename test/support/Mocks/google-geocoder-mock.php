<?php

namespace SearchApi\Test\Support\Mocks;

use SearchApi\Models as Models;

/**
 * Class Google_Geocoder_Mock - basic mock of google's geocoder
 */
class Google_Geocoder_Mock {
  public static function reverse_geocoding( $latlin_or_id, $key ) {
    if ( $key === 'geokey' ) {
  	  if ( $latlin_or_id instanceof Models\GeoCoordinate ) {
        return '"formatted_address" : "277 Bedford Avenue, Brooklyn, NY 11211, USA",' +
        '"formatted_address" : "Grand St/Bedford Av, Brooklyn, NY 11211, USA",' +
        '"formatted_address" : "Grand St/Bedford Av, Brooklyn, NY 11249, USA",' +
        '"formatted_address" : "Bedford Av/Grand St, Brooklyn, NY 11211, USA",' +
        '"formatted_address" : "Brooklyn, NY 11211, USA",' +
        '"formatted_address" : "Williamsburg, Brooklyn, NY, USA",' +
        '"formatted_address" : "Brooklyn, NY, USA",' +
        '"formatted_address" : "New York, NY, USA",' +
        '"formatted_address" : "New York, USA",' +
        '"formatted_address" : "United States",';
      } else {
        return '"formatted_address" : "277 Bedford Avenue, Brooklyn, NY 11211, USA"';
      }
    } else {
      return 'Invalid Key';
    }
  }
}
