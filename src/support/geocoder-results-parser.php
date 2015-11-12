<?php

namespace SearchApi\Support;


use Exception;

/**
 * Class Geo_Parser - Parses the returned result from a Geocoder
 */
class GeoParser {
  public function reverse_geocoder_parser( $json_results ) {
    // add code to parse json results returned by google

  	// make sure utf8 format
    $json_results = utf8_encode( $json_results );
    // decode json into associate array
    $geocoder_results = json_decode( $json_results, true );

    // check for valid key
    if ( $geocoder_results[ 'status' ] === 'REQUEST_DENIED' ) {
      throw new Exception( 'Invalid Key' );
    }

    // for now: pretends to parse the results and return address
  	return '277 Bedford Avenue, Brooklyn, NY 11211, USA';
  }
}
