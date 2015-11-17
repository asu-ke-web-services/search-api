<?php

namespace SearchApi\Support;


use Exception;

/**
 * Class Geo_Parser - Parses the returned result from a Geocoder
 */
class GeoParser {
  public function reverse_geocoder_parser( $json_results ) {
    // add code to parse json results returned by google

  	// code that decodes the json object into anrray
  	// make sure utf8 format
    $json_results = utf8_encode( $json_results );
    // decode json into associate array
    $geocoder_results = json_decode( $json_results, true );

    if ( $geocoder_results == null ) {
    	throw new Exception( 'Invalid Json Object' );
    }
    //code that parses the array from the json object


    // check for valid key
    if ( array_key_exists( 'status', $geocoder_results ) &&
    		$geocoder_results[ 'status' ] === 'REQUEST_DENIED' ) {
      throw new Exception( 'Invalid Key' );
    }

    // for now: pretends to parse the results and return address
  	return '277 Bedford Avenue, Brooklyn, NY 11211, USA';
  }
}
