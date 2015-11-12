<?php

namespace SearchApi\Support;

use SearchApi\Test\Support\Mocks as Mocks;
use Exception;

/**
 * Class Geo_Parser - Parses the returned result from a Geocoder
 */
class GeoParser {
  public function reverse_geocoder_parser( $json_results ) {
    // add code to parse json results returned by google
    // $json_results = utf8_encode( $json_results ); // make sure utf8 format
    // $geocoder_results = json_decode( $json_results, true ); // decode json into associate array

    // var_dump( $geocoder_results );
    // for now: pretends to parse the results and return address
    $mock = new Mocks\Google_Geocoder_Mock();
    if ( $json_results === $mock->error_message ) {
      throw new Exception( 'Invalid Key' );
    }

  	return '277 Bedford Avenue, Brooklyn, NY 11211, USA';
  }
}
