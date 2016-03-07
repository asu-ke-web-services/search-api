<?php

namespace SearchApi\Support;


use Exception;

/**
 * Class Json_Decoder - decodes the json from a Geocoder
 *
 * @throws Exception - error if bad json object or json string
 */
class JsonDecoder {

  /**
   * Function: reverse_geocoder_json_decoder
   *
   * @param Json obj $json_results
   * @throws Exception -  error if bad json object or json string
   */
  public function reverse_geocoder_json_decoder( $json_results ) {
    // code that decodes the json object into anrray
    // make sure utf8 format
    $json_results = utf8_encode( $json_results );
    // decode json into associate array
    $returnArrays = true;
    $geocoder_results = json_decode( $json_results, $returnArrays );

    // checking if received Json was valid
    if ( $geocoder_results === null ) {
      throw new Exception( 'Invalid Json Object' );
    }

    // check for valid key
    if ( array_key_exists( 'status', $geocoder_results ) &&
        $geocoder_results['status'] !== 'OK' ) {
      // UPDATE: update with new "Invalid Key" status
      if ( $geocoder_results['status'] === 'REQUEST_DENIED' ) {
        throw new Exception( 'Invalid Key' );
      }
      throw new Exception( "Invalid Json String: Status: {$geocoder_results['status']}" );
    }

    // return decoded json
    return $geocoder_results;
  }
}
